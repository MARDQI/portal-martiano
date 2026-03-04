<?php
/**
 * Registro y enqueue de estilos y scripts del tema.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Encolar estilos CSS.
 */
function cm_enqueue_styles() {
    // Google Fonts — Inter (moderna, legible)
    wp_enqueue_style(
        'cm-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
        [],
        null
    );

    // Estilos principales del tema
    wp_enqueue_style(
        'cm-main-style',
        CM_ASSETS_URI . '/css/main.css',
        ['cm-google-fonts'],
        CM_THEME_VERSION
    );

    // Estilos de la página de inicio
    if (is_front_page()) {
        wp_enqueue_style(
            'cm-front-page-style',
            CM_ASSETS_URI . '/css/front-page.css',
            ['cm-main-style'],
            CM_THEME_VERSION
        );
    }

    // style.css del tema (requerido por WP para identificar el tema)
    wp_enqueue_style(
        'cm-theme-style',
        get_stylesheet_uri(),
        ['cm-main-style'],
        CM_THEME_VERSION
    );
}
add_action('wp_enqueue_scripts', 'cm_enqueue_styles');

/**
 * Encolar scripts JS.
 */
function cm_enqueue_scripts() {
    // Script principal
    wp_enqueue_script(
        'cm-main-script',
        CM_ASSETS_URI . '/js/main.js',
        [],
        CM_THEME_VERSION,
        true
    );

    // Infinite scroll (solo en páginas que lo necesiten)
    if (is_front_page() || is_archive()) {
        wp_enqueue_script(
            'cm-infinite-scroll',
            CM_ASSETS_URI . '/js/infinite-scroll.js',
            ['cm-main-script'],
            CM_THEME_VERSION,
            true
        );

        // Pasar variables PHP a JS para AJAX
        wp_localize_script('cm-infinite-scroll', 'cmAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('cm_ajax_nonce'),
        ]);
    }

    // Calendario de actividades (solo en front-page)
    if (is_front_page()) {
        wp_enqueue_script(
            'cm-calendar',
            CM_ASSETS_URI . '/js/calendar.js',
            ['cm-main-script'],
            CM_THEME_VERSION,
            true
        );

        wp_localize_script('cm-calendar', 'cmCalendar', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('cm_calendar_nonce'),
        ]);
    }

    // Lightbox para la galería (solo en páginas con template Galería)
    if (is_page_template('page-galeria.php')) {
        wp_enqueue_script(
            'cm-lightbox',
            CM_ASSETS_URI . '/js/lightbox.js',
            [],
            CM_THEME_VERSION,
            true
        );
    }

    // Comentarios encadenados de WordPress
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cm_enqueue_scripts');
