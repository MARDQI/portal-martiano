<?php
/**
 * Template Part: Card individual de Curiosidad (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$fuente = get_post_meta(get_the_ID(), '_cm_curiosidad_fuente', true);
?>

<article class="cm-curiosidad-item cm-search-results__item">
    <?php if (has_post_thumbnail()) : ?>
        <div class="cm-curiosidad-item__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('cm-thumbnail', ['loading' => 'lazy']); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="cm-curiosidad-item__content">
        <span class="cm-search-results__item-type"><?php esc_html_e('Curiosidad', 'catedra-marti'); ?></span>
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php if (has_excerpt()) : ?>
            <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
        <?php endif; ?>
        <?php if ($fuente) : ?>
            <small><em><?php esc_html_e('Fuente:', 'catedra-marti'); ?> <?php echo esc_html($fuente); ?></em></small>
        <?php endif; ?>
    </div>
</article>
