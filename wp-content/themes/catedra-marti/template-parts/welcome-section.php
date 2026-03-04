<?php
/**
 * Template Part: Sección de Bienvenida
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$welcome_title   = get_theme_mod('cm_welcome_title', __('Bienvenida', 'catedra-marti'));
$welcome_message = get_theme_mod('cm_welcome_message', __('Mensaje de bienvenida al portal web.', 'catedra-marti'));
?>

<section class="cm-welcome cm-container">
    <h2 class="cm-welcome__title"><?php echo esc_html($welcome_title); ?></h2>
    <p class="cm-welcome__message"><?php echo esc_html($welcome_message); ?></p>
</section>
