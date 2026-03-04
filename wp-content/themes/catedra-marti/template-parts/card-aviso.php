<?php
/**
 * Template Part: Card individual de Aviso (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$prioridad = get_post_meta(get_the_ID(), '_cm_aviso_prioridad', true);
$prioridad_class = $prioridad === 'urgente' ? 'cm-aviso--urgente' : ($prioridad === 'alta' ? 'cm-aviso--alta' : '');
?>

<article class="cm-aviso-item <?php echo esc_attr($prioridad_class); ?>">
    <div class="cm-list__item">
        <span class="cm-list__bullet"></span>
        <div>
            <h4><?php the_title(); ?></h4>
            <?php if (get_the_content()) : ?>
                <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
            <?php endif; ?>
            <small><?php echo get_the_date(); ?></small>
        </div>
    </div>
</article>
