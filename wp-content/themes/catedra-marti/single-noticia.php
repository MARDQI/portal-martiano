<?php
/**
 * Template: Single Noticia
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <?php while (have_posts()) : the_post(); ?>
        <article class="cm-single cm-single--noticia">
            <header class="cm-single__header">
                <span class="cm-search-results__item-type"><?php esc_html_e('Noticia', 'catedra-marti'); ?></span>
                <h1 class="cm-single__title"><?php the_title(); ?></h1>
                <div class="cm-single__meta">
                    <span><?php echo get_the_date(); ?></span>
                    <span>&middot;</span>
                    <span><?php the_author(); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="cm-single__thumbnail">
                    <?php the_post_thumbnail('cm-hero'); ?>
                </div>
            <?php endif; ?>

            <div class="cm-single__content">
                <?php the_content(); ?>
            </div>

            <?php get_template_part('template-parts/social-share', 'buttons'); ?>

            <?php
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
        </article>
    <?php endwhile; ?>
</div>

<?php
get_footer();
