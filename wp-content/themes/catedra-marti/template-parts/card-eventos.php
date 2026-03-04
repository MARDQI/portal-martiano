<?php
/**
 * Template Part: Card de Eventos
 *
 * Muestra los próximos eventos con fecha destacada grande.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$eventos = new WP_Query([
    'post_type'      => 'evento',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'meta_key'       => '_cm_evento_fecha',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'     => [
        [
            'key'     => '_cm_evento_fecha',
            'value'   => date('Y-m-d'),
            'compare' => '>=',
            'type'    => 'DATE',
        ],
    ],
]);

$months_short = [
    1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic',
];
?>

<div class="cm-card cm-eventos">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#127942;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Eventos', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <?php if ($eventos->have_posts()) : ?>
            <?php while ($eventos->have_posts()) : $eventos->the_post();
                $fecha = get_post_meta(get_the_ID(), '_cm_evento_fecha', true);
                $day   = '';
                $month = '';
                $date_display = '';
                if ($fecha) {
                    $timestamp = strtotime($fecha);
                    $day   = date('d', $timestamp);
                    $month_num = intval(date('m', $timestamp));
                    $month = isset($months_short[$month_num]) ? $months_short[$month_num] : '';
                    $date_display = date('F d, Y', $timestamp);
                }
            ?>
                <div class="cm-event-item">
                    <div class="cm-event-item__date">
                        <span class="cm-event-item__day"><?php echo esc_html($day); ?></span>
                        <span class="cm-event-item__month"><?php echo esc_html($month); ?></span>
                    </div>
                    <div class="cm-event-item__info">
                        <span class="cm-event-item__title">
                            <?php echo esc_html($date_display); ?>
                        </span>
                    </div>
                    <div class="cm-event-item__action">
                        <a href="<?php the_permalink(); ?>" class="cm-btn cm-btn--tag">
                            <?php the_title(); ?> &rsaquo;
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="cm-card__empty"><?php esc_html_e('No hay eventos próximos.', 'catedra-marti'); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <div class="cm-card__footer">
        <a href="<?php echo esc_url(get_post_type_archive_link('evento')); ?>" class="cm-card__link">
            <?php esc_html_e('Ver todos los eventos', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</div>
