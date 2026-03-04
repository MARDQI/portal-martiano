<?php
/**
 * Template Part: Card individual de Noticia (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */
?>

<article class="cm-noticia-item cm-search-results__item">
    <?php if (has_post_thumbnail()) : ?>
        <div class="cm-noticia-item__thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('cm-card', ['loading' => 'lazy']); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="cm-noticia-item__content">
        <span class="cm-search-results__item-type"><?php esc_html_e('Noticia', 'catedra-marti'); ?></span>
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <?php if (has_excerpt()) : ?>
            <p><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
        <?php endif; ?>
        <small><?php echo get_the_date(); ?></small>
    </div>
</article>
