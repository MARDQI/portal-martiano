<?php
/**
 * Template Part: Sección Video Portada
 *
 * Muestra un video embed configurable desde el Customizer.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$video_url   = get_theme_mod('cm_video_url', '');
$video_title = get_theme_mod('cm_video_title', __('Video Portada', 'catedra-marti'));
?>

<div class="cm-card cm-video-section">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#127909;</span>
        <h3 class="cm-card__header-title"><?php echo esc_html($video_title); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if ($video_url) : ?>
            <div class="cm-video__wrapper">
                <?php
                // Intentar embeber el video usando WordPress oEmbed
                $embed = wp_oembed_get($video_url);
                if ($embed) {
                    echo $embed;
                } else {
                    // Fallback: enlace directo al video
                ?>
                    <video controls preload="metadata">
                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        <?php esc_html_e('Tu navegador no soporta el elemento de video.', 'catedra-marti'); ?>
                    </video>
                <?php } ?>
            </div>
        <?php else : ?>
            <div class="cm-video__wrapper" style="background-color: var(--cm-bg-secondary); display: flex; align-items: center; justify-content: center; padding-top: 0; min-height: 200px;">
                <p style="color: var(--cm-text-light); text-align: center;">
                    <?php esc_html_e('Configura el video de portada desde el Personalizador.', 'catedra-marti'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($video_url) : ?>
    <div class="cm-card__footer">
        <a href="<?php echo esc_url($video_url); ?>" class="cm-card__link" target="_blank" rel="noopener">
            <?php esc_html_e('Ver video', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
    <?php endif; ?>
</div>
