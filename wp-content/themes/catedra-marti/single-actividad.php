<?php
/**
 * Template: Single Actividad
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <?php while (have_posts()) : the_post();
        $fecha_inicio = get_post_meta(get_the_ID(), '_cm_actividad_fecha_inicio', true);
        $fecha_fin    = get_post_meta(get_the_ID(), '_cm_actividad_fecha_fin', true);
        $lugar        = get_post_meta(get_the_ID(), '_cm_actividad_lugar', true);
    ?>
        <article class="cm-single cm-single--actividad">
            <header class="cm-single__header">
                <span class="cm-search-results__item-type"><?php esc_html_e('Actividad', 'catedra-marti'); ?></span>
                <h1 class="cm-single__title"><?php the_title(); ?></h1>
                <div class="cm-single__meta">
                    <?php if ($fecha_inicio) : ?>
                        <span>
                            <?php echo esc_html(date_i18n('d/m/Y', strtotime($fecha_inicio))); ?>
                            <?php if ($fecha_fin && $fecha_fin !== $fecha_inicio) : ?>
                                - <?php echo esc_html(date_i18n('d/m/Y', strtotime($fecha_fin))); ?>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($lugar) : ?>
                        <span>&middot;</span>
                        <span><?php echo esc_html($lugar); ?></span>
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
