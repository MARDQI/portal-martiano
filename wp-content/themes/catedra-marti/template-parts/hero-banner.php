<?php
/**
 * Template Part: Hero Banner
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$hero_title       = get_theme_mod('cm_hero_title', __('Cátedra Honorífica de Estudios Martianos', 'catedra-marti'));
$hero_description = get_theme_mod('cm_hero_description', __('Breve descripción de la página de inicio.', 'catedra-marti'));
$hero_image       = get_theme_mod('cm_hero_image', '');
$hero_button_url  = get_theme_mod('cm_hero_button_url', '#');

$bg_style = $hero_image ? 'style="background-image: url(' . esc_url($hero_image) . ');"' : '';
?>

<section class="cm-hero" <?php echo $bg_style; ?>>
    <div class="cm-hero__content">
        <h1 class="cm-hero__title"><?php echo esc_html($hero_title); ?></h1>
        <p class="cm-hero__description"><?php echo esc_html($hero_description); ?></p>
        <a href="<?php echo esc_url($hero_button_url); ?>" class="cm-hero__btn">
            <?php esc_html_e('Leer más', 'catedra-marti'); ?>
        </a>
    </div>
</section>
