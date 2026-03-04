<?php
/**
 * Header del tema — Cátedra Marti
 *
 * Contiene: Logo, Menú Principal, Enlace Acceder, Barra de Búsqueda.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="cm-header" role="banner">
    <div class="cm-header__inner">

        <!-- Logo -->
        <div class="cm-header__logo">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="cm-header__logo-text">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Botón Hamburguesa (móvil) -->
        <button class="cm-menu-toggle" aria-label="<?php esc_attr_e('Abrir menú', 'catedra-marti'); ?>" aria-expanded="false">
            <span class="cm-menu-toggle__bar"></span>
            <span class="cm-menu-toggle__bar"></span>
            <span class="cm-menu-toggle__bar"></span>
        </button>

        <!-- Navegación -->
        <nav class="cm-nav" role="navigation" aria-label="<?php esc_attr_e('Menú principal', 'catedra-marti'); ?>">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'cm-nav__list',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'link_before'    => '<span class="cm-nav__link">',
                    'link_after'     => '</span>',
                    'depth'          => 2,
                ]);
            }
            ?>

            <!-- Enlace Acceder / Mi Cuenta -->
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(admin_url()); ?>" class="cm-nav__login">
                    <span class="dashicons dashicons-admin-users"></span>
                    <?php echo esc_html(wp_get_current_user()->display_name); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="cm-nav__login">
                    <?php esc_html_e('Acceder', 'catedra-marti'); ?>
                </a>
            <?php endif; ?>

            <!-- Barra de Búsqueda (RF44) -->
            <form class="cm-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input
                    type="search"
                    class="cm-search-form__input"
                    name="s"
                    placeholder="<?php esc_attr_e('Buscar', 'catedra-marti'); ?>"
                    value="<?php echo esc_attr(get_search_query()); ?>"
                    aria-label="<?php esc_attr_e('Buscar en el portal', 'catedra-marti'); ?>"
                />
                <button type="submit" class="cm-search-form__btn" aria-label="<?php esc_attr_e('Buscar', 'catedra-marti'); ?>">
                    <span class="dashicons dashicons-search"></span>
                </button>
            </form>
        </nav>

    </div>
</header>

<main id="main-content" class="cm-main" role="main">
