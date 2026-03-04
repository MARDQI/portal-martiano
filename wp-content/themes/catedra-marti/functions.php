<?php
/**
 * Cátedra Marti — functions.php
 *
 * Archivo maestro del tema. Carga todos los módulos funcionales desde inc/.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

// ─── Constantes del tema ───
define('CM_THEME_VERSION', '1.0.0');
define('CM_THEME_DIR', get_template_directory());
define('CM_THEME_URI', get_template_directory_uri());
define('CM_ASSETS_URI', CM_THEME_URI . '/assets');

// ─── Módulos funcionales ───
$cm_modules = [
    'inc/setup.php',              // Configuración base del tema
    'inc/enqueue.php',            // Registro de CSS y JS
    'inc/custom-post-types.php',  // CPTs: noticias, avisos, actividades, eventos, curiosidades, documentos
    'inc/custom-fields.php',      // Metaboxes personalizados para cada CPT
    'inc/ajax-handlers.php',      // Endpoints AJAX (infinite scroll, calendario)
    'inc/comments.php',           // Personalización del sistema de comentarios
    'inc/social-share.php',       // Botones de compartir en redes sociales
    'inc/widgets.php',            // Widgets personalizados
    'inc/roles.php',              // Ajuste de roles y capacidades
    'inc/customizer.php',         // Opciones del Customizer (redes sociales, contacto)
];

foreach ($cm_modules as $module) {
    $module_path = CM_THEME_DIR . '/' . $module;
    if (file_exists($module_path)) {
        require_once $module_path;
    }
}
