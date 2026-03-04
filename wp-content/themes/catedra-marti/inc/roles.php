<?php
/**
 * Ajuste de roles y capacidades (RF1-RF5, RF39-RF41).
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Configurar roles y capacidades al activar el tema.
 *
 * Roles:
 * - Administrador: Acceso total (nativo WP)
 * - Editor: Solo puede gestionar Enlaces de Interés (RF39-RF41)
 * - Suscriptor: Puede comentar y ver contenido (RF25)
 */
function cm_setup_roles() {
    // Obtener el rol Editor
    $editor = get_role('editor');
    if ($editor) {
        // El Editor mantiene sus capacidades base de WP
        // pero se restringe su acceso en el dashboard

        // Asegurarse de que puede gestionar los menús de navegación
        $editor->add_cap('edit_theme_options');
    }

    // Obtener el rol Suscriptor
    $subscriber = get_role('subscriber');
    if ($subscriber) {
        // Los suscriptores solo pueden leer y comentar
        // Estas capacidades ya vienen por defecto
        $subscriber->add_cap('read');
    }
}
add_action('after_switch_theme', 'cm_setup_roles');

/**
 * Redirigir suscriptores fuera del dashboard.
 * Los suscriptores son redirigidos al frontend (RF1).
 */
function cm_redirect_subscribers_from_admin() {
    if (is_admin() && !defined('DOING_AJAX') && current_user_can('subscriber')) {
        if (!current_user_can('edit_posts')) {
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('admin_init', 'cm_redirect_subscribers_from_admin');

/**
 * Ocultar la barra de administración para suscriptores.
 */
function cm_hide_admin_bar_for_subscribers() {
    if (current_user_can('subscriber') && !current_user_can('edit_posts')) {
        return false;
    }
    return true;
}
add_filter('show_admin_bar', 'cm_hide_admin_bar_for_subscribers');

/**
 * Restringir menús del dashboard para Editores.
 * Los editores solo ven lo necesario para gestionar enlaces de interés.
 */
function cm_restrict_editor_menus() {
    if (current_user_can('editor') && !current_user_can('administrator')) {
        // Remover menús innecesarios para el Editor
        remove_menu_page('edit.php');              // Posts
        remove_menu_page('upload.php');            // Medios
        remove_menu_page('edit-comments.php');     // Comentarios
        remove_menu_page('tools.php');             // Herramientas

        // Remover CPTs del menú (el Editor no los gestiona)
        remove_menu_page('edit.php?post_type=noticia');
        remove_menu_page('edit.php?post_type=aviso');
        remove_menu_page('edit.php?post_type=actividad');
        remove_menu_page('edit.php?post_type=evento');
        remove_menu_page('edit.php?post_type=curiosidad');
        remove_menu_page('edit.php?post_type=documento');
    }
}
add_action('admin_menu', 'cm_restrict_editor_menus', 999);

/**
 * Personalizar la página de login con el estilo del portal.
 */
function cm_login_styles() {
    ?>
    <style>
        body.login {
            background-color: #f0f4f8;
        }
        .login h1 a {
            background-image: none;
            text-indent: 0;
            font-size: 24px;
            font-weight: 700;
            color: #1a3a5c;
            width: auto;
            height: auto;
        }
        .login h1 a:hover {
            color: #2563eb;
        }
        .login form {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login .button-primary {
            background-color: #1a3a5c;
            border-color: #1a3a5c;
            border-radius: 6px;
        }
        .login .button-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'cm_login_styles');

/**
 * Cambiar la URL del logo de login para apuntar al sitio.
 */
function cm_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'cm_login_logo_url');

/**
 * Cambiar el texto del logo de login.
 */
function cm_login_logo_text() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'cm_login_logo_text');
