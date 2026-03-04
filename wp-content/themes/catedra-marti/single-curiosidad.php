<?php
/**
 * Template: Single Curiosidad
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <?php while (have_posts()) : the_post();
        $fuente = get_post_meta(get_the_ID(), '_cm_curiosidad_fuente', true);
    ?>
        <article class="cm-single cm-single--curiosidad">
            <header class="cm-single__header">
                <span class="cm-search-results__item-type"><?php esc_html_e('Curiosidad', 'catedra-marti'); ?></span>
                <h1 class="cm-single__title"><?php the_title(); ?></h1>
                <div class="cm-single__meta">
                    <span><?php echo get_the_date(); ?></span>
                    <?php if ($fuente) : ?>
                        <span>&middot;</span>
                        <span><em><?php esc_html_e('Fuente:', 'catedra-marti'); ?> <?php echo esc_html($fuente); ?></em></span>
                    <?php endif; ?>
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
        </article>
    <?php endwhile; ?>
</div>

<?php
get_footer();
