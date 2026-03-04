<?php
/**
 * Template Part: Card de Calendario de Actividades
 *
 * Mini-calendario interactivo renderizado por JS (calendar.js).
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

$months_es = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
];
$current_month = intval(date('m'));
$current_year  = intval(date('Y'));
?>

<div class="cm-card cm-calendar-widget" id="cm-calendar">
    <div class="cm-card__header">
        <span class="cm-card__header-icon">&#128197;</span>
        <h3 class="cm-card__header-title"><?php esc_html_e('Calendario de Actividades', 'catedra-marti'); ?></h3>
    </div>

    <div class="cm-card__body">
        <!-- Navegación del calendario -->
        <div class="cm-calendar__nav">
            <button class="cm-calendar__nav-btn cm-calendar__nav-btn--prev" aria-label="<?php esc_attr_e('Mes anterior', 'catedra-marti'); ?>">
                &laquo;
            </button>
            <span class="cm-calendar__month-label">
                <?php echo esc_html($months_es[$current_month] . ' ' . $current_year); ?>
            </span>
            <button class="cm-calendar__nav-btn cm-calendar__nav-btn--next" aria-label="<?php esc_attr_e('Mes siguiente', 'catedra-marti'); ?>">
                &raquo;
            </button>
        </div>

        <!-- Tabla del calendario -->
        <table class="cm-calendar__table">
            <thead>
                <tr>
                    <th>L</th>
                    <th>M</th>
                    <th>M</th>
                    <th>J</th>
                    <th>V</th>
                    <th>S</th>
                    <th>D</th>
                </tr>
            </thead>
            <tbody>
                <!-- Renderizado por calendar.js -->
            </tbody>
        </table>
    </div>

    <div class="cm-card__footer">
        <a href="<?php echo esc_url(get_post_type_archive_link('actividad')); ?>" class="cm-card__link">
            <?php esc_html_e('Ver todo el calendario', 'catedra-marti'); ?> &rsaquo;
        </a>
    </div>
</div>
