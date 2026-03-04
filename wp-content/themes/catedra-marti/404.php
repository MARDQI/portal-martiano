<?php
/**
 * Template: Error 404
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section cm-404">
    <div class="cm-404__content">
        <h1 class="cm-404__title">404</h1>
        <h2 class="cm-404__subtitle"><?php esc_html_e('Página no encontrada', 'catedra-marti'); ?></h2>
        <p class="cm-404__text">
            <?php esc_html_e('Lo sentimos, la página que buscas no existe o ha sido movida.', 'catedra-marti'); ?>
        </p>

        <div class="cm-404__search">
            <?php get_search_form(); ?>
        </div>

        <a href="<?php echo esc_url(home_url('/')); ?>" class="cm-btn cm-btn--primary">
            <?php esc_html_e('Volver al Inicio', 'catedra-marti'); ?>
        </a>
    </div>
</div>

<?php
get_footer();
