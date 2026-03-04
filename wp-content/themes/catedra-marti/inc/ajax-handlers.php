<?php
/**
 * Endpoints AJAX para Infinite Scroll y Calendario.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * AJAX: Cargar más posts (Infinite Scroll).
 */
function cm_ajax_load_more() {
    check_ajax_referer('cm_ajax_nonce', 'nonce');

    $page      = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'noticia';
    $per_page  = isset($_POST['per_page']) ? absint($_POST['per_page']) : 3;

    // Validar post_type permitidos
    $allowed_types = ['noticia', 'aviso', 'actividad', 'evento', 'curiosidad', 'documento'];
    if (!in_array($post_type, $allowed_types)) {
        wp_send_json_error(['message' => 'Tipo de contenido no válido.']);
    }

    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/card', $post_type);
        }
        $html = ob_get_clean();
        wp_reset_postdata();

        wp_send_json_success([
            'html'      => $html,
            'has_more'  => $page < $query->max_num_pages,
            'max_pages' => $query->max_num_pages,
        ]);
    } else {
        wp_send_json_success([
            'html'     => '',
            'has_more' => false,
        ]);
    }
}
add_action('wp_ajax_cm_load_more', 'cm_ajax_load_more');
add_action('wp_ajax_nopriv_cm_load_more', 'cm_ajax_load_more');

/**
 * AJAX: Obtener actividades para el calendario.
 */
function cm_ajax_get_calendar_activities() {
    check_ajax_referer('cm_calendar_nonce', 'nonce');

    $month = isset($_POST['month']) ? absint($_POST['month']) : intval(date('m'));
    $year  = isset($_POST['year']) ? absint($_POST['year']) : intval(date('Y'));

    // Buscar actividades que caigan en el mes solicitado
    $args = [
        'post_type'      => 'actividad',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => '_cm_actividad_fecha_inicio',
                'value'   => sprintf('%04d-%02d-01', $year, $month),
                'compare' => '<=',
                'type'    => 'DATE',
            ],
            [
                'key'     => '_cm_actividad_fecha_fin',
                'value'   => sprintf('%04d-%02d-%02d', $year, $month, cal_days_in_month(CAL_GREGORIAN, $month, $year)),
                'compare' => '>=',
                'type'    => 'DATE',
            ],
        ],
    ];

    // También incluir actividades cuya fecha de inicio cae en el mes
    $args2 = [
        'post_type'      => 'actividad',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => '_cm_actividad_fecha_inicio',
                'value'   => [
                    sprintf('%04d-%02d-01', $year, $month),
                    sprintf('%04d-%02d-%02d', $year, $month, cal_days_in_month(CAL_GREGORIAN, $month, $year)),
                ],
                'compare' => 'BETWEEN',
                'type'    => 'DATE',
            ],
        ],
    ];

    $query1 = new WP_Query($args);
    $query2 = new WP_Query($args2);

    $activities = [];
    $seen_ids = [];

    foreach ([$query1, $query2] as $query) {
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $id = get_the_ID();
                if (in_array($id, $seen_ids)) continue;
                $seen_ids[] = $id;

                $activities[] = [
                    'id'           => $id,
                    'title'        => get_the_title(),
                    'url'          => get_permalink(),
                    'fecha_inicio' => get_post_meta($id, '_cm_actividad_fecha_inicio', true),
                    'fecha_fin'    => get_post_meta($id, '_cm_actividad_fecha_fin', true),
                    'lugar'        => get_post_meta($id, '_cm_actividad_lugar', true),
                ];
            }
        }
    }

    wp_reset_postdata();

    wp_send_json_success([
        'activities' => $activities,
        'month'      => $month,
        'year'       => $year,
    ]);
}
add_action('wp_ajax_cm_get_calendar', 'cm_ajax_get_calendar_activities');
add_action('wp_ajax_nopriv_cm_get_calendar', 'cm_ajax_get_calendar_activities');
