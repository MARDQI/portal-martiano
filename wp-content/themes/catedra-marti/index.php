<?php
/**
 * Template: index.php (Fallback principal)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <h1 class="cm-section__title"><?php esc_html_e('Publicaciones', 'catedra-marti'); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="cm-noticias-list">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/card', 'noticia'); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination([
            'prev_text' => '&laquo; ' . __('Anterior', 'catedra-marti'),
            'next_text' => __('Siguiente', 'catedra-marti') . ' &raquo;',
        ]); ?>
    <?php else : ?>
        <p><?php esc_html_e('No se encontraron publicaciones.', 'catedra-marti'); ?></p>
    <?php endif; ?>
</div>

<?php
get_footer();
