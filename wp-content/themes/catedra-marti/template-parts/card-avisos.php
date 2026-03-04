<?php
/**
 * Template Part: Card de Avisos
 *
 * Muestra los últimos 3 avisos con icono de campana.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$avisos = new WP_Query([
    'post_type'      => 'aviso',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
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
?>

<div class="cm-card cm-avisos">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#128276;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Avisos', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if ($avisos->have_posts()) : ?>
            <ul class="cm-list">
                <?php while ($avisos->have_posts()) : $avisos->the_post(); ?>
                    <li class="cm-list__item">
                        <span class="cm-list__bullet"></span>
                        <span><?php the_title(); ?></span>
                    </li>
                <?php endwhile; ?>
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
