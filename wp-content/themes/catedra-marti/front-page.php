<?php
/**
 * Template: Página de Inicio (front-page.php)
 *
 * Implementa el diseño visual del portal:
 * - Hero Banner
 * - Bienvenida
 * - Grid: Avisos + Noticias
 * - Grid: Calendario de Actividades + Eventos
 * - Grid: Galería de Imágenes + Video Portada
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<!-- ═══ Hero Banner ═══ -->
<?php get_template_part('template-parts/hero', 'banner'); ?>

<!-- ═══ Bienvenida ═══ -->
<?php get_template_part('template-parts/welcome', 'section'); ?>

<div class="cm-container">

    <!-- ═══ Fila 1: Avisos + Noticias Recientes ═══ -->
    <div class="cm-grid">
        <?php get_template_part('template-parts/card', 'avisos'); ?>
        <?php get_template_part('template-parts/card', 'noticias'); ?>
    </div>

    <!-- ═══ Fila 2: Calendario de Actividades + Eventos ═══ -->
    <div class="cm-grid">
        <?php get_template_part('template-parts/card', 'calendario'); ?>
        <?php get_template_part('template-parts/card', 'eventos'); ?>
    </div>

    <!-- ═══ Fila 3: Galería de Imágenes + Video Portada ═══ -->
    <div class="cm-grid">
        <?php get_template_part('template-parts/gallery', 'section'); ?>
        <?php get_template_part('template-parts/video', 'section'); ?>
    </div>

</div><!-- /.cm-container -->

<?php
get_footer();
