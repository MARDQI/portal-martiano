<?php
/**
 * Template: Archivo genérico
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <header class="cm-archive__header">
        <?php the_archive_title('<h1 class="cm-section__title">', '</h1>'); ?>
        <?php the_archive_description('<p class="cm-archive__description">', '</p>'); ?>
    </header>

    <?php if (have_posts()) : ?>
        <div class="cm-archive__list">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/card', get_post_type()); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination([
            'prev_text' => '&laquo; ' . __('Anterior', 'catedra-marti'),
            'next_text' => __('Siguiente', 'catedra-marti') . ' &raquo;',
        ]); ?>
    <?php else : ?>
        <p><?php esc_html_e('No se encontró contenido.', 'catedra-marti'); ?></p>
    <?php endif; ?>
</div>

<?php
get_footer();
