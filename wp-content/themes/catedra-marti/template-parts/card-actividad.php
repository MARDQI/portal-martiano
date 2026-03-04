<?php
/**
 * Template Part: Card individual de Actividad (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$fecha_inicio = get_post_meta(get_the_ID(), '_cm_actividad_fecha_inicio', true);
$fecha_fin    = get_post_meta(get_the_ID(), '_cm_actividad_fecha_fin', true);
$lugar        = get_post_meta(get_the_ID(), '_cm_actividad_lugar', true);
?>

<article class="cm-actividad-item cm-search-results__item">
    <span class="cm-search-results__item-type"><?php esc_html_e('Actividad', 'catedra-marti'); ?></span>
    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    <?php if ($fecha_inicio) : ?>
        <p>
            <strong><?php esc_html_e('Fecha:', 'catedra-marti'); ?></strong>
            <?php echo esc_html(date_i18n('d/m/Y', strtotime($fecha_inicio))); ?>
            <?php if ($fecha_fin && $fecha_fin !== $fecha_inicio) : ?>
                - <?php echo esc_html(date_i18n('d/m/Y', strtotime($fecha_fin))); ?>
            <?php endif; ?>
        </p>
    <?php endif; ?>
    <?php if ($lugar) : ?>
        <p><strong><?php esc_html_e('Lugar:', 'catedra-marti'); ?></strong> <?php echo esc_html($lugar); ?></p>
    <?php endif; ?>
    <?php if (has_excerpt()) : ?>
        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
    <?php endif; ?>
</article>
