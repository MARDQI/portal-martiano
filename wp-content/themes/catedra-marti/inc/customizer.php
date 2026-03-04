<?php
/**
 * Opciones del Customizer (RF30-RF33, RF45).
 *
 * Secciones:
 * - Redes Sociales
 * - Información de Contacto
 * - Video de Portada
 * - Mensaje de Bienvenida
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Registrar secciones y controles del Customizer.
 */
function cm_customizer_register($wp_customize) {

    // ═══════════════════════════════════════
    // PANEL: Portal Martiano
    // ═══════════════════════════════════════
    $wp_customize->add_panel('cm_portal_panel', [
        'title'       => __('Portal Martiano', 'catedra-marti'),
        'description' => __('Opciones de configuración del portal.', 'catedra-marti'),
        'priority'    => 30,
    ]);

    // ─── Sección: Redes Sociales (RF30-RF33) ───
    $wp_customize->add_section('cm_social_links', [
        'title'    => __('Redes Sociales', 'catedra-marti'),
        'panel'    => 'cm_portal_panel',
        'priority' => 10,
    ]);

    $social_networks = [
        'facebook'  => __('Facebook', 'catedra-marti'),
        'twitter'   => __('Twitter / X', 'catedra-marti'),
        'instagram' => __('Instagram', 'catedra-marti'),
        'youtube'   => __('YouTube', 'catedra-marti'),
        'telegram'  => __('Telegram', 'catedra-marti'),
        'email'     => __('Email de Contacto', 'catedra-marti'),
    ];

    foreach ($social_networks as $key => $label) {
        $wp_customize->add_setting("cm_social_{$key}", [
            'default'           => '',
            'sanitize_callback' => ($key === 'email') ? 'sanitize_email' : 'esc_url_raw',
        ]);

        $wp_customize->add_control("cm_social_{$key}", [
            'label'   => $label,
            'section' => 'cm_social_links',
            'type'    => ($key === 'email') ? 'email' : 'url',
        ]);
    }

    // ─── Sección: Información de Contacto (RF45) ───
    $wp_customize->add_section('cm_contact_info', [
        'title'    => __('Información de Contacto', 'catedra-marti'),
        'panel'    => 'cm_portal_panel',
        'priority' => 20,
    ]);

    $contact_fields = [
        'address' => [
            'label'   => __('Dirección', 'catedra-marti'),
            'type'    => 'textarea',
            'default' => '',
        ],
        'phone' => [
            'label'   => __('Teléfono', 'catedra-marti'),
            'type'    => 'text',
            'default' => '',
        ],
        'email' => [
            'label'   => __('Email', 'catedra-marti'),
            'type'    => 'email',
            'default' => '',
        ],
        'schedule' => [
            'label'   => __('Horario de Atención', 'catedra-marti'),
            'type'    => 'text',
            'default' => '',
        ],
    ];

    foreach ($contact_fields as $key => $field) {
        $wp_customize->add_setting("cm_contact_{$key}", [
            'default'           => $field['default'],
            'sanitize_callback' => ($field['type'] === 'email') ? 'sanitize_email' : 'sanitize_text_field',
        ]);

        $wp_customize->add_control("cm_contact_{$key}", [
            'label'   => $field['label'],
            'section' => 'cm_contact_info',
            'type'    => $field['type'],
        ]);
    }

    // ─── Sección: Página de Inicio ───
    $wp_customize->add_section('cm_front_page', [
        'title'    => __('Página de Inicio', 'catedra-marti'),
        'panel'    => 'cm_portal_panel',
        'priority' => 5,
    ]);

    // Hero — Título
    $wp_customize->add_setting('cm_hero_title', [
        'default'           => __('Cátedra Honorífica de Estudios Martianos', 'catedra-marti'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('cm_hero_title', [
        'label'   => __('Título del Hero', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'text',
    ]);

    // Hero — Descripción
    $wp_customize->add_setting('cm_hero_description', [
        'default'           => __('Breve descripción de la página de inicio.', 'catedra-marti'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('cm_hero_description', [
        'label'   => __('Descripción del Hero', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'textarea',
    ]);

    // Hero — Imagen de fondo
    $wp_customize->add_setting('cm_hero_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cm_hero_image', [
        'label'   => __('Imagen de Fondo del Hero', 'catedra-marti'),
        'section' => 'cm_front_page',
    ]));

    // Hero — URL del botón "Leer más"
    $wp_customize->add_setting('cm_hero_button_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('cm_hero_button_url', [
        'label'   => __('URL del botón "Leer más"', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'url',
    ]);

    // Mensaje de Bienvenida
    $wp_customize->add_setting('cm_welcome_title', [
        'default'           => __('Bienvenida', 'catedra-marti'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('cm_welcome_title', [
        'label'   => __('Título de Bienvenida', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('cm_welcome_message', [
        'default'           => __('Mensaje de bienvenida al portal web.', 'catedra-marti'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('cm_welcome_message', [
        'label'   => __('Mensaje de Bienvenida', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'textarea',
    ]);

    // Video de Portada
    $wp_customize->add_setting('cm_video_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('cm_video_url', [
        'label'       => __('URL del Video de Portada', 'catedra-marti'),
        'description' => __('URL de YouTube, Vimeo, o enlace directo al video.', 'catedra-marti'),
        'section'     => 'cm_front_page',
        'type'        => 'url',
    ]);

    $wp_customize->add_setting('cm_video_title', [
        'default'           => __('Video Portada', 'catedra-marti'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('cm_video_title', [
        'label'   => __('Título del Video', 'catedra-marti'),
        'section' => 'cm_front_page',
        'type'    => 'text',
    ]);
}
add_action('customize_register', 'cm_customizer_register');

// ═══════════════════════════════════════════
// FUNCIONES HELPER PARA ACCEDER A OPCIONES
// ═══════════════════════════════════════════

/**
 * Obtener URL de una red social.
 */
function cm_get_social_url($network) {
    return get_theme_mod("cm_social_{$network}", '');
}

/**
 * Obtener información de contacto.
 */
function cm_get_contact_info($field) {
    return get_theme_mod("cm_contact_{$field}", '');
}

/**
 * Verificar si hay al menos una red social configurada.
 */
function cm_has_social_links() {
    $networks = ['facebook', 'twitter', 'instagram', 'youtube', 'telegram', 'email'];
    foreach ($networks as $network) {
        if (cm_get_social_url($network)) {
            return true;
        }
    }
    return false;
}
