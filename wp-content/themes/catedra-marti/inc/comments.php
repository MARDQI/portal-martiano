<?php
/**
 * Personalización del sistema de comentarios (RF21-RF26).
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Forzar moderación de comentarios.
 * Todos los comentarios deben ser aprobados antes de publicarse (RF21).
 */
function cm_force_comment_moderation() {
    // Activar moderación manual
    update_option('comment_moderation', 1);
    // Requiere que el usuario tenga un comentario aprobado previamente: NO
    // Queremos que TODOS pasen por moderación
    update_option('comment_previously_approved', 0);
}
add_action('after_switch_theme', 'cm_force_comment_moderation');

/**
 * Habilitar comentarios en los CPTs que lo requieran.
 * Noticias y Eventos permiten comentarios (RF25).
 */
function cm_enable_comments_on_cpts($open, $post_id) {
    $post_type = get_post_type($post_id);

    // CPTs que permiten comentarios
    $commentable_cpts = ['noticia', 'evento'];

    if (in_array($post_type, $commentable_cpts)) {
        return true;
    }

    return $open;
}
add_filter('comments_open', 'cm_enable_comments_on_cpts', 10, 2);

/**
 * Solo usuarios autenticados pueden comentar (RF25).
 */
function cm_require_login_to_comment() {
    update_option('comment_registration', 1);
}
add_action('after_switch_theme', 'cm_require_login_to_comment');

/**
 * Personalizar campos del formulario de comentarios.
 */
function cm_comment_form_defaults($defaults) {
    $defaults['title_reply']          = __('Deja tu comentario', 'catedra-marti');
    $defaults['title_reply_to']       = __('Responder a %s', 'catedra-marti');
    $defaults['cancel_reply_link']    = __('Cancelar respuesta', 'catedra-marti');
    $defaults['label_submit']         = __('Enviar Comentario', 'catedra-marti');
    $defaults['comment_notes_before'] = '<p class="comment-notes">' .
        __('Tu comentario será revisado antes de ser publicado.', 'catedra-marti') .
        '</p>';

    return $defaults;
}
add_filter('comment_form_defaults', 'cm_comment_form_defaults');

/**
 * Notificar al admin cuando hay un nuevo comentario pendiente.
 */
function cm_notify_admin_new_comment($comment_id) {
    $comment = get_comment($comment_id);
    if ($comment && $comment->comment_approved === '0') {
        // WordPress ya envía notificación por defecto, pero podemos personalizar
        $admin_email = get_option('admin_email');
        $subject     = sprintf(
            __('[%s] Nuevo comentario pendiente de aprobación', 'catedra-marti'),
            get_bloginfo('name')
        );
        $message = sprintf(
            __("Nuevo comentario de %s en \"%s\":\n\n%s\n\nAprobar/Rechazar: %s", 'catedra-marti'),
            $comment->comment_author,
            get_the_title($comment->comment_post_ID),
            $comment->comment_content,
            admin_url('edit-comments.php?comment_status=moderated')
        );
        wp_mail($admin_email, $subject, $message);
    }
}
add_action('comment_post', 'cm_notify_admin_new_comment');
