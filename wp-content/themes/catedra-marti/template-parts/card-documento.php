<?php
/**
 * Template Part: Card individual de Documento (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$archivo_id = get_post_meta(get_the_ID(), '_cm_documento_archivo_id', true);
$categoria  = get_post_meta(get_the_ID(), '_cm_documento_categoria', true);
$archivo_url = $archivo_id ? wp_get_attachment_url($archivo_id) : '';
?>

<article class="cm-documento-item cm-search-results__item">
    <span class="cm-search-results__item-type"><?php echo esc_html(ucfirst($categoria ?: 'general')); ?></span>
    <h4>
        <?php if ($archivo_url) : ?>
            <a href="<?php echo esc_url($archivo_url); ?>" download><?php the_title(); ?></a>
        <?php else : ?>
            <?php the_title(); ?>
        <?php endif; ?>
    </h4>
    <?php if (get_the_content()) : ?>
        <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
    <?php endif; ?>
    <?php if ($archivo_url) : ?>
        <a href="<?php echo esc_url($archivo_url); ?>" class="cm-btn cm-btn--sm cm-btn--outline" download>
            <?php esc_html_e('Descargar', 'catedra-marti'); ?>
        </a>
    <?php endif; ?>
</article>
