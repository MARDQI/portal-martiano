<?php
/**
 * Template Part: Sección Galería de Imágenes
 *
 * Muestra thumbnails horizontales de la galería nativa de WordPress.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

// Obtener las últimas imágenes subidas
$gallery_images = new WP_Query([
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => 6,
    'post_status'    => 'inherit',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<div class="cm-card cm-gallery-section">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#128247;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Galería de Imágenes', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if ($gallery_images->have_posts()) : ?>
            <div class="cm-gallery__grid">
                <?php while ($gallery_images->have_posts()) : $gallery_images->the_post(); ?>
                    <div class="cm-gallery__item">
                        <?php echo wp_get_attachment_image(get_the_ID(), 'cm-gallery', false, [
                            'loading' => 'lazy',
                            'alt'     => get_the_title(),
                        ]); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="cm-card__empty"><?php esc_html_e('No hay imágenes en la galería todavía.', 'catedra-marti'); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <div class="cm-card__footer">
        <?php
        $galeria_page = get_pages([
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-galeria.php',
            'number'     => 1,
        ]);
        $galeria_url = !empty($galeria_page) ? get_permalink($galeria_page[0]->ID) : '#';
        ?>
        <a href="<?php echo esc_url($galeria_url); ?>" class="cm-card__link">
            <?php esc_html_e('Ver galería', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</div>
