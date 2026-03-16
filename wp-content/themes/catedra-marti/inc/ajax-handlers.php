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
 * Construir entrada normalizada para el calendario.
 *
 * @param int    $id   ID del post.
 * @param string $type Tipo de contenido.
 * @param array  $meta Metadatos normalizados.
 * @return array
 */
function cm_build_calendar_entry($id, $type, $meta) {
    return [
        'id'           => $id,
        'type'         => $type,
        'title'        => get_the_title($id),
        'url'          => get_permalink($id),
        'fecha_inicio' => $meta['fecha_inicio'],
        'fecha_fin'    => $meta['fecha_fin'],
        'lugar'        => $meta['lugar'],
        'hora'         => $meta['hora'],
        'color'        => $meta['color'],
    ];
}

/**
 * AJAX: Obtener actividades y eventos para el calendario.
 */
function cm_ajax_get_calendar_activities() {
    check_ajax_referer('cm_calendar_nonce', 'nonce');

    $month = isset($_POST['month']) ? absint($_POST['month']) : intval(date('m'));
    $year  = isset($_POST['year']) ? absint($_POST['year']) : intval(date('Y'));
    $month_start = sprintf('%04d-%02d-01', $year, $month);
    $month_end   = date('Y-m-t', strtotime($month_start));

    $activity_args = [
        'post_type'      => 'actividad',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            'relation' => 'AND',
            [
                'key'     => '_cm_actividad_fecha_inicio',
                'value'   => $month_end,
                'compare' => '<=',
                'type'    => 'DATE',
            ],
            [
                'key'     => '_cm_actividad_fecha_fin',
                'value'   => $month_start,
                'compare' => '>=',
                'type'    => 'DATE',
            ],
        ],
    ];

    $event_args = [
        'post_type'      => 'evento',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => [
            [
                'key'     => '_cm_evento_fecha',
                'value'   => [$month_start, $month_end],
                'compare' => 'BETWEEN',
                'type'    => 'DATE',
            ],
        ],
    ];

    $activities_query = new WP_Query($activity_args);
    $events_query     = new WP_Query($event_args);

    $entries = [];

    if ($activities_query->have_posts()) {
        while ($activities_query->have_posts()) {
            $activities_query->the_post();
            $id = get_the_ID();

            $fecha_inicio = get_post_meta($id, '_cm_actividad_fecha_inicio', true);
            $fecha_fin    = get_post_meta($id, '_cm_actividad_fecha_fin', true);
            if (!$fecha_fin) {
                $fecha_fin = $fecha_inicio;
            }

            $entries[] = cm_build_calendar_entry($id, 'actividad', [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin'    => $fecha_fin,
                'lugar'        => get_post_meta($id, '_cm_actividad_lugar', true),
                'hora'         => '',
                'color'        => get_post_meta($id, '_cm_actividad_color', true) ?: '#2F6FED',
            ]);
        }
    }

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $id = get_the_ID();
            $fecha = get_post_meta($id, '_cm_evento_fecha', true);

            $entries[] = cm_build_calendar_entry($id, 'evento', [
                'fecha_inicio' => $fecha,
                'fecha_fin'    => $fecha,
                'lugar'        => get_post_meta($id, '_cm_evento_lugar', true),
                'hora'         => get_post_meta($id, '_cm_evento_hora', true),
                'color'        => get_post_meta($id, '_cm_evento_color', true) ?: '#D97706',
            ]);
        }
    }

    usort($entries, function ($a, $b) {
        $date_compare = strcmp($a['fecha_inicio'], $b['fecha_inicio']);
        if ($date_compare !== 0) {
            return $date_compare;
        }

        if ($a['type'] === $b['type']) {
            return strcmp($a['title'], $b['title']);
        }

        return $a['type'] === 'actividad' ? -1 : 1;
    });

    wp_reset_postdata();

    wp_send_json_success([
        'activities' => $entries,
        'month'      => $month,
        'year'       => $year,
    ]);
}
add_action('wp_ajax_cm_get_calendar', 'cm_ajax_get_calendar_activities');
add_action('wp_ajax_nopriv_cm_get_calendar', 'cm_ajax_get_calendar_activities');
