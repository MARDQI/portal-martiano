<?php
/**
 * Template Part: Card de Noticias Recientes
 *
 * Muestra las últimas 3 noticias.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$noticias = new WP_Query([
    'post_type'      => 'noticia',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<div class="cm-card cm-noticias">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#128196;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Noticias Recientes', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if ($noticias->have_posts()) : ?>
            <ul class="cm-list">
                <?php while ($noticias->have_posts()) : $noticias->the_post(); ?>
                    <li class="cm-list__item">
                        <span class="cm-list__bullet"></span>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p class="cm-card__empty"><?php esc_html_e('No hay noticias publicadas todavía.', 'catedra-marti'); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <div class="cm-card__footer">
        <a href="<?php echo esc_url(get_post_type_archive_link('noticia')); ?>" class="cm-card__link">
            <?php esc_html_e('Leer todas las noticias', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</div>
