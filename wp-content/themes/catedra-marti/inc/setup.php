<?php
/**
 * Configuración base del tema.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Configurar funcionalidades del tema.
 */
function cm_theme_setup() {
    // Título del sitio gestionado por WordPress
    add_theme_support('title-tag');

    // Imágenes destacadas en posts y CPTs
    add_theme_support('post-thumbnails');

    // Tamaños de imagen personalizados
    add_image_size('cm-hero', 1920, 600, true);
    add_image_size('cm-card', 600, 400, true);
    add_image_size('cm-thumbnail', 300, 200, true);
    add_image_size('cm-gallery', 400, 300, true);

    // Logo personalizado
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Soporte HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Menús de navegación
    register_nav_menus([
        'primary'   => __('Menú Principal', 'catedra-marti'),
        'footer'    => __('Menú del Pie de Página', 'catedra-marti'),
        'social'    => __('Enlaces Sociales', 'catedra-marti'),
    ]);

    // Soporte de alineación ancha para bloques
    add_theme_support('align-wide');

    // Idioma
    load_theme_textdomain('catedra-marti', CM_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'cm_theme_setup');

/**
 * Registrar áreas de widgets (sidebars).
 */
function cm_widgets_init() {
    register_sidebar([
        'name'          => __('Barra Lateral', 'catedra-marti'),
        'id'            => 'sidebar-1',
        'description'   => __('Área de widgets de la barra lateral.', 'catedra-marti'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Columna 1', 'catedra-marti'),
        'id'            => 'footer-1',
        'description'   => __('Primera columna del pie de página.', 'catedra-marti'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Columna 2', 'catedra-marti'),
        'id'            => 'footer-2',
        'description'   => __('Segunda columna del pie de página.', 'catedra-marti'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Columna 3', 'catedra-marti'),
        'id'            => 'footer-3',
        'description'   => __('Tercera columna del pie de página.', 'catedra-marti'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'cm_widgets_init');
