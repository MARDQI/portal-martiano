<?php
/**
 * Registro de Custom Post Types.
 *
 * CPTs: Noticias, Avisos, Actividades, Eventos, Curiosidades, Documentos
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Registrar todos los Custom Post Types.
 */
function cm_register_post_types() {

    // ─── Noticias (RF6-RF9) ───
    register_post_type('noticia', [
        'labels' => [
            'name'               => __('Noticias', 'catedra-marti'),
            'singular_name'      => __('Noticia', 'catedra-marti'),
            'add_new'            => __('Añadir Noticia', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nueva Noticia', 'catedra-marti'),
            'edit_item'          => __('Editar Noticia', 'catedra-marti'),
            'new_item'           => __('Nueva Noticia', 'catedra-marti'),
            'view_item'          => __('Ver Noticia', 'catedra-marti'),
            'search_items'       => __('Buscar Noticias', 'catedra-marti'),
            'not_found'          => __('No se encontraron noticias.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay noticias en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todas las Noticias', 'catedra-marti'),
            'menu_name'          => __('Noticias', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'noticias'],
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 5,
    ]);

    // ─── Avisos (RF10-RF12) ───
    register_post_type('aviso', [
        'labels' => [
            'name'               => __('Avisos', 'catedra-marti'),
            'singular_name'      => __('Aviso', 'catedra-marti'),
            'add_new'            => __('Añadir Aviso', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nuevo Aviso', 'catedra-marti'),
            'edit_item'          => __('Editar Aviso', 'catedra-marti'),
            'new_item'           => __('Nuevo Aviso', 'catedra-marti'),
            'view_item'          => __('Ver Aviso', 'catedra-marti'),
            'search_items'       => __('Buscar Avisos', 'catedra-marti'),
            'not_found'          => __('No se encontraron avisos.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay avisos en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todos los Avisos', 'catedra-marti'),
            'menu_name'          => __('Avisos', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'avisos'],
        'menu_icon'          => 'dashicons-bell',
        'supports'           => ['title', 'editor', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 6,
    ]);

    // ─── Actividades (RF13-RF16) ───
    register_post_type('actividad', [
        'labels' => [
            'name'               => __('Actividades', 'catedra-marti'),
            'singular_name'      => __('Actividad', 'catedra-marti'),
            'add_new'            => __('Añadir Actividad', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nueva Actividad', 'catedra-marti'),
            'edit_item'          => __('Editar Actividad', 'catedra-marti'),
            'new_item'           => __('Nueva Actividad', 'catedra-marti'),
            'view_item'          => __('Ver Actividad', 'catedra-marti'),
            'search_items'       => __('Buscar Actividades', 'catedra-marti'),
            'not_found'          => __('No se encontraron actividades.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay actividades en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todas las Actividades', 'catedra-marti'),
            'menu_name'          => __('Actividades', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'actividades'],
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 7,
    ]);

    // ─── Eventos (RF17-RF20) ───
    register_post_type('evento', [
        'labels' => [
            'name'               => __('Eventos', 'catedra-marti'),
            'singular_name'      => __('Evento', 'catedra-marti'),
            'add_new'            => __('Añadir Evento', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nuevo Evento', 'catedra-marti'),
            'edit_item'          => __('Editar Evento', 'catedra-marti'),
            'new_item'           => __('Nuevo Evento', 'catedra-marti'),
            'view_item'          => __('Ver Evento', 'catedra-marti'),
            'search_items'       => __('Buscar Eventos', 'catedra-marti'),
            'not_found'          => __('No se encontraron eventos.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay eventos en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todos los Eventos', 'catedra-marti'),
            'menu_name'          => __('Eventos', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'eventos'],
        'menu_icon'          => 'dashicons-tickets-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 8,
    ]);

    // ─── Curiosidades (RF34-RF38) ───
    register_post_type('curiosidad', [
        'labels' => [
            'name'               => __('Curiosidades', 'catedra-marti'),
            'singular_name'      => __('Curiosidad', 'catedra-marti'),
            'add_new'            => __('Añadir Curiosidad', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nueva Curiosidad', 'catedra-marti'),
            'edit_item'          => __('Editar Curiosidad', 'catedra-marti'),
            'new_item'           => __('Nueva Curiosidad', 'catedra-marti'),
            'view_item'          => __('Ver Curiosidad', 'catedra-marti'),
            'search_items'       => __('Buscar Curiosidades', 'catedra-marti'),
            'not_found'          => __('No se encontraron curiosidades.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay curiosidades en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todas las Curiosidades', 'catedra-marti'),
            'menu_name'          => __('Curiosidades', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'curiosidades'],
        'menu_icon'          => 'dashicons-lightbulb',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 9,
    ]);

    // ─── Documentos Descargables (RF27-RF29) ───
    register_post_type('documento', [
        'labels' => [
            'name'               => __('Documentos', 'catedra-marti'),
            'singular_name'      => __('Documento', 'catedra-marti'),
            'add_new'            => __('Añadir Documento', 'catedra-marti'),
            'add_new_item'       => __('Añadir Nuevo Documento', 'catedra-marti'),
            'edit_item'          => __('Editar Documento', 'catedra-marti'),
            'new_item'           => __('Nuevo Documento', 'catedra-marti'),
            'view_item'          => __('Ver Documento', 'catedra-marti'),
            'search_items'       => __('Buscar Documentos', 'catedra-marti'),
            'not_found'          => __('No se encontraron documentos.', 'catedra-marti'),
            'not_found_in_trash' => __('No hay documentos en la papelera.', 'catedra-marti'),
            'all_items'          => __('Todos los Documentos', 'catedra-marti'),
            'menu_name'          => __('Documentos', 'catedra-marti'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'documentos'],
        'menu_icon'          => 'dashicons-media-text',
        'supports'           => ['title', 'editor', 'revisions'],
        'show_in_rest'       => true,
        'capability_type'    => 'post',
        'menu_position'      => 10,
    ]);
}
add_action('init', 'cm_register_post_types');

/**
 * Incluir CPTs en los resultados de búsqueda (RF44).
 */
function cm_add_cpts_to_search($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', [
            'post',
            'page',
            'noticia',
            'aviso',
            'actividad',
            'evento',
            'curiosidad',
            'documento',
        ]);
    }
}
add_action('pre_get_posts', 'cm_add_cpts_to_search');

/**
 * Flush rewrite rules al activar el tema.
 */
function cm_rewrite_flush() {
    cm_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'cm_rewrite_flush');
