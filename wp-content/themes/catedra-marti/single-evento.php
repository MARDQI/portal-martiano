<?php
/**
 * Template: Single Evento
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <?php while (have_posts()) : the_post();
        $fecha       = get_post_meta(get_the_ID(), '_cm_evento_fecha', true);
        $hora        = get_post_meta(get_the_ID(), '_cm_evento_hora', true);
        $lugar       = get_post_meta(get_the_ID(), '_cm_evento_lugar', true);
        $inscripcion = get_post_meta(get_the_ID(), '_cm_evento_inscripcion', true);
    ?>
        <article class="cm-single cm-single--evento">
            <header class="cm-single__header">
                <span class="cm-search-results__item-type"><?php esc_html_e('Evento', 'catedra-marti'); ?></span>
                <h1 class="cm-single__title"><?php the_title(); ?></h1>
                <div class="cm-single__meta">
                    <?php if ($fecha) : ?>
                        <span><?php echo esc_html(date_i18n('d \d\e F \d\e Y', strtotime($fecha))); ?></span>
                    <?php endif; ?>
                    <?php if ($hora) : ?>
                        <span>&middot;</span>
                        <span><?php echo esc_html($hora); ?></span>
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

            <?php if ($inscripcion) : ?>
                <div style="margin: 2rem 0;">
                    <a href="<?php echo esc_url($inscripcion); ?>" class="cm-btn cm-btn--primary" target="_blank" rel="noopener">
                        <?php esc_html_e('Inscribirse al Evento', 'catedra-marti'); ?>
                    </a>
                </div>
            <?php endif; ?>

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
