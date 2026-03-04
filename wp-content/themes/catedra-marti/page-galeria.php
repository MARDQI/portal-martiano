<?php
/**
 * Template Name: Galería de Imágenes
 * 
 * Muestra todas las imágenes del sitio en una cuadrícula con lightbox.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$gallery_images = new WP_Query([
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => 24,
    'paged'          => $paged,
    'post_status'    => 'inherit',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<div class="cm-container cm-section">
    <h1 class="cm-section__title"><?php esc_html_e('Galería de Imágenes', 'catedra-marti'); ?></h1>

    <?php if ($gallery_images->have_posts()) : ?>
        <div class="cm-gallery-page__grid">
            <?php while ($gallery_images->have_posts()) : $gallery_images->the_post();
                $full_url  = wp_get_attachment_url(get_the_ID());
                $caption   = wp_get_attachment_caption(get_the_ID());
                $alt       = get_post_meta(get_the_ID(), '_wp_attachment_image_alt', true);
                $title     = get_the_title();
            ?>
                <figure class="cm-gallery-page__item">
                    <a href="<?php echo esc_url($full_url); ?>"
                       class="cm-gallery-page__link"
                       data-caption="<?php echo esc_attr($caption ?: $title); ?>">
                        <?php echo wp_get_attachment_image(get_the_ID(), 'cm-gallery', false, [
                            'loading' => 'lazy',
                            'alt'     => esc_attr($alt ?: $title),
                            'class'   => 'cm-gallery-page__img',
                        ]); ?>
                    </a>
                    <?php if ($caption) : ?>
                        <figcaption class="cm-gallery-page__caption"><?php echo esc_html($caption); ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endwhile; ?>
        </div>

        <?php
        // Paginación
        $big = 999999999;
        echo '<nav class="cm-pagination">';
        echo paginate_links([
            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'    => '/page/%#%',
            'current'   => max(1, $paged),
            'total'     => $gallery_images->max_num_pages,
            'prev_text' => '&laquo; ' . __('Anterior', 'catedra-marti'),
            'next_text' => __('Siguiente', 'catedra-marti') . ' &raquo;',
        ]);
        echo '</nav>';
        ?>
    <?php else : ?>
        <p><?php esc_html_e('No hay imágenes en la galería todavía.', 'catedra-marti'); ?></p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<!-- Lightbox overlay -->
<div class="cm-lightbox" id="cmLightbox" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Visor de imágenes', 'catedra-marti'); ?>">
    <button class="cm-lightbox__close" aria-label="<?php esc_attr_e('Cerrar', 'catedra-marti'); ?>">&times;</button>
    <button class="cm-lightbox__prev" aria-label="<?php esc_attr_e('Anterior', 'catedra-marti'); ?>">&lsaquo;</button>
    <button class="cm-lightbox__next" aria-label="<?php esc_attr_e('Siguiente', 'catedra-marti'); ?>">&rsaquo;</button>
    <div class="cm-lightbox__content">
        <img class="cm-lightbox__img" src="" alt="" />
        <p class="cm-lightbox__caption"></p>
    </div>
</div>

<?php
get_footer();
