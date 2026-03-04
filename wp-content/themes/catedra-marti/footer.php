<?php
/**
 * Footer del tema — Cátedra Marti
 *
 * Contiene: Logo, Enlaces Sociales, Enlaces Rápidos, Enlaces de Interés, Contacto.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;
?>
</main><!-- /.cm-main -->

<footer class="cm-footer" role="contentinfo">
    <div class="cm-footer__grid">

        <!-- Columna 1: Logo -->
        <div class="cm-footer__col">
            <div class="cm-footer__logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span class="cm-header__logo-text" style="color: #fff;">
                        <?php bloginfo('name'); ?>
                    </span>
                <?php endif; ?>
            </div>
            <p class="cm-footer__description" style="margin-top: 1rem; color: rgba(255,255,255,0.7); font-size: 0.875rem;">
                <?php bloginfo('description'); ?>
            </p>
        </div>

        <!-- Columna 2: Enlaces Sociales (RF30-RF33) -->
        <div class="cm-footer__col">
            <h4 class="cm-footer__col-title"><?php esc_html_e('Enlaces Sociales', 'catedra-marti'); ?></h4>
            <?php if (cm_has_social_links()) : ?>
                <div class="cm-footer__social">
                    <?php
                    $social_icons = [
                        'facebook'  => 'dashicons-facebook-alt',
                        'twitter'   => 'dashicons-twitter',
                        'instagram' => 'dashicons-instagram',
                        'youtube'   => 'dashicons-video-alt3',
                        'telegram'  => 'dashicons-share',
                        'email'     => 'dashicons-email-alt',
                    ];

                    foreach ($social_icons as $network => $icon) :
                        $url = cm_get_social_url($network);
                        if (!$url) continue;

                        $href = ($network === 'email') ? 'mailto:' . esc_attr($url) : esc_url($url);
                    ?>
                        <a href="<?php echo $href; ?>" class="cm-footer__social-icon" target="_blank" rel="noopener noreferrer"
                           title="<?php echo esc_attr(ucfirst($network)); ?>">
                            <span class="dashicons <?php echo esc_attr($icon); ?>"></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Columna 3: Enlaces Rápidos -->
        <div class="cm-footer__col">
            <h4 class="cm-footer__col-title"><?php esc_html_e('Enlaces Rápidos', 'catedra-marti'); ?></h4>
            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'cm-footer__links',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'link_before'    => '<span class="cm-footer__link">',
                    'link_after'     => '</span>',
                    'depth'          => 1,
                ]);
            } else {
                // Fallback: enlaces básicos
            ?>
                <ul class="cm-footer__links">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="cm-footer__link"><?php esc_html_e('Inicio', 'catedra-marti'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('noticia')); ?>" class="cm-footer__link"><?php esc_html_e('Noticias', 'catedra-marti'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('evento')); ?>" class="cm-footer__link"><?php esc_html_e('Eventos', 'catedra-marti'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('actividad')); ?>" class="cm-footer__link"><?php esc_html_e('Actividades', 'catedra-marti'); ?></a></li>
                </ul>
            <?php } ?>
        </div>

        <!-- Columna 4: Enlaces de Interés + Contacto (RF39-RF41, RF45) -->
        <div class="cm-footer__col">
            <h4 class="cm-footer__col-title"><?php esc_html_e('Enlaces de Interés', 'catedra-marti'); ?></h4>
            <?php
            // Menú de enlaces de interés (gestionado por Admin/Editor)
            if (has_nav_menu('social')) {
                wp_nav_menu([
                    'theme_location' => 'social',
                    'container'      => false,
                    'menu_class'     => 'cm-footer__links',
                    'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                    'link_before'    => '<span class="cm-footer__link">',
                    'link_after'     => '</span>',
                    'depth'          => 1,
                ]);
            }

            // Información de contacto (RF45)
            $contact_email = cm_get_contact_info('email');
            $contact_phone = cm_get_contact_info('phone');
            if ($contact_email || $contact_phone) :
            ?>
                <div style="margin-top: 1.25rem;">
                    <h4 class="cm-footer__col-title"><?php esc_html_e('Contacto', 'catedra-marti'); ?></h4>
                    <?php if ($contact_email) : ?>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="cm-footer__link">
                            <?php echo esc_html($contact_email); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($contact_phone) : ?>
                        <span class="cm-footer__link"><?php echo esc_html($contact_phone); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Bottom bar -->
    <div class="cm-footer__bottom">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Todos los derechos reservados.', 'catedra-marti'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
