<?php
/**
 * Template Part: Card individual de Evento (para AJAX/infinite scroll)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$fecha = get_post_meta(get_the_ID(), '_cm_evento_fecha', true);
$hora  = get_post_meta(get_the_ID(), '_cm_evento_hora', true);
$lugar = get_post_meta(get_the_ID(), '_cm_evento_lugar', true);

$months_short = [
    1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic',
];

$day = '';
$month = '';
if ($fecha) {
    $timestamp = strtotime($fecha);
    $day = date('d', $timestamp);
    $month_num = intval(date('m', $timestamp));
    $month = isset($months_short[$month_num]) ? $months_short[$month_num] : '';
}
?>

<article class="cm-event-item">
    <div class="cm-event-item__date">
        <span class="cm-event-item__day"><?php echo esc_html($day); ?></span>
        <span class="cm-event-item__month"><?php echo esc_html($month); ?></span>
    </div>
    <div class="cm-event-item__info">
        <h4 class="cm-event-item__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
        <?php if ($lugar) : ?>
            <small><?php echo esc_html($lugar); ?></small>
        <?php endif; ?>
        <?php if ($hora) : ?>
            <small> &middot; <?php echo esc_html($hora); ?></small>
        <?php endif; ?>
    </div>
    <div class="cm-event-item__action">
        <a href="<?php the_permalink(); ?>" class="cm-btn cm-btn--tag">
            <?php esc_html_e('Ver', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</article>
