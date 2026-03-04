<?php
/**
 * Funciones para compartir en redes sociales (RF42).
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Generar botones de compartir en redes sociales.
 *
 * @param int|null $post_id ID del post (usa el actual si es null).
 * @return string HTML de los botones de compartir.
 */
function cm_social_share_buttons($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $url     = urlencode(get_permalink($post_id));
    $title   = urlencode(get_the_title($post_id));
    $excerpt = urlencode(wp_trim_words(get_the_excerpt($post_id), 20));

    $networks = [
        'facebook' => [
            'url'   => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'icon'  => 'dashicons-facebook-alt',
            'label' => 'Facebook',
            'color' => '#1877F2',
        ],
        'twitter' => [
            'url'   => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
            'icon'  => 'dashicons-twitter',
            'label' => 'Twitter',
            'color' => '#1DA1F2',
        ],
        'telegram' => [
            'url'   => "https://t.me/share/url?url={$url}&text={$title}",
            'icon'  => 'dashicons-share',
            'label' => 'Telegram',
            'color' => '#0088CC',
        ],
        'email' => [
            'url'   => "mailto:?subject={$title}&body={$excerpt}%0A%0A{$url}",
            'icon'  => 'dashicons-email-alt',
            'label' => 'Email',
            'color' => '#555555',
        ],
    ];

    $html = '<div class="cm-social-share">';
    $html .= '<span class="cm-social-share__label">' . __('Compartir:', 'catedra-marti') . '</span>';

    foreach ($networks as $key => $network) {
        $html .= sprintf(
            '<a href="%s" class="cm-social-share__btn cm-social-share__btn--%s" target="_blank" rel="noopener noreferrer" title="%s" style="--share-color: %s;">' .
            '<span class="dashicons %s"></span>' .
            '<span class="screen-reader-text">%s</span>' .
            '</a>',
            esc_url($network['url']),
            esc_attr($key),
            esc_attr(sprintf(__('Compartir en %s', 'catedra-marti'), $network['label'])),
            esc_attr($network['color']),
            esc_attr($network['icon']),
            esc_html($network['label'])
        );
    }

    $html .= '</div>';

    return $html;
}

/**
 * Añadir botones de compartir automáticamente al final del contenido.
 */
function cm_auto_social_share($content) {
    if (is_singular(['noticia', 'evento']) && is_main_query()) {
        $content .= cm_social_share_buttons();
    }
    return $content;
}
add_filter('the_content', 'cm_auto_social_share');
