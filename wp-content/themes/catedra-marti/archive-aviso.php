<?php
/**
 * Template: Archivo de Avisos
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();

$avisos_posts = get_posts([
    'post_type'      => 'aviso',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

if (!empty($avisos_posts)) {
    usort($avisos_posts, function ($a, $b) {
        $mapa = [
            'urgente' => 3,
            'alta'    => 2,
            'baja'    => 1,
            'normal'  => 1,
        ];

        $prioridad_a = get_post_meta($a->ID, '_cm_aviso_prioridad', true);
        $prioridad_b = get_post_meta($b->ID, '_cm_aviso_prioridad', true);

        $orden_a = $mapa[$prioridad_a] ?? 1;
        $orden_b = $mapa[$prioridad_b] ?? 1;

        if ($orden_a !== $orden_b) {
            return $orden_b <=> $orden_a;
        }

        return strtotime($b->post_date_gmt ?: $b->post_date) <=> strtotime($a->post_date_gmt ?: $a->post_date);
    });
}
?>

<div class="cm-container cm-section">
    <h1 class="cm-section__title"><?php esc_html_e('Avisos', 'catedra-marti'); ?></h1>

    <?php if (!empty($avisos_posts)) : ?>
        <div class="cm-avisos-list">
            <?php foreach ($avisos_posts as $post) : setup_postdata($post); ?>
                <?php get_template_part('template-parts/card', 'aviso'); ?>
            <?php endforeach; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p><?php esc_html_e('No hay avisos en este momento.', 'catedra-marti'); ?></p>
    <?php endif; ?>
</div>

<?php
get_footer();
