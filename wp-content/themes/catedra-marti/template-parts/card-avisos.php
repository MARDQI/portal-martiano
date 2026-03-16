<?php
/**
 * Template Part: Card de Avisos
 *
 * Muestra los últimos 3 avisos con icono de campana.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$avisos_query = new WP_Query([
    'post_type'      => 'aviso',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => '_cm_aviso_vigencia',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE',
        ],
        [
            'key'     => '_cm_aviso_vigencia',
            'compare' => 'NOT EXISTS',
        ],
    ],
]);

$avisos_posts = $avisos_query->posts;

if (!empty($avisos_posts)) {
    usort($avisos_posts, function ($a, $b) {
        $mapa = [
            'urgente' => 3,
            'alta'    => 2,
            'baja'    => 1,
            'normal'  => 1,
        ];

        $prioridad_a = get_post_meta($a->ID, '_cm_aviso_prioridad', true);
        $prioridad_b = get_post_meta($b->ID, '_cm_aviso_prioridad', true);

        $orden_a = $mapa[$prioridad_a] ?? 1;
        $orden_b = $mapa[$prioridad_b] ?? 1;

        if ($orden_a !== $orden_b) {
            return $orden_b <=> $orden_a;
        }

        return strtotime($b->post_date_gmt ?: $b->post_date) <=> strtotime($a->post_date_gmt ?: $a->post_date);
    });

    $avisos_posts = array_slice($avisos_posts, 0, 3);
}
?>

<div class="cm-card cm-avisos">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#128276;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Avisos', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if (!empty($avisos_posts)) : ?>
            <ul class="cm-list">
                <?php foreach ($avisos_posts as $post) : setup_postdata($post); ?>
                    <li class="cm-list__item">
                        <span class="cm-list__bullet"></span>
                        <span><?php the_title(); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="cm-card__empty"><?php esc_html_e('No hay avisos importantes en este momento.', 'catedra-marti'); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <div class="cm-card__footer">
        <a href="<?php echo esc_url(get_post_type_archive_link('aviso')); ?>" class="cm-card__link">
            <?php esc_html_e('Ver todos los avisos', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</div>
