/**
 * Portal Martiano — Mini Calendario de Actividades
 *
 * Calendario interactivo que muestra actividades de cada mes.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

(function () {
    'use strict';

    if (typeof cmCalendar === 'undefined') return;

    const MONTHS_ES = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    const DAYS_ES = ['L', 'M', 'M', 'J', 'V', 'S', 'D'];

    let currentMonth, currentYear, activities;

    /**
     * Inicializar el calendario.
     */
    function init() {
        const container = document.getElementById('cm-calendar');
        if (!container) return;

        const now = new Date();
        currentMonth = now.getMonth() + 1; // 1-12
        currentYear = now.getFullYear();
        activities = [];

        // Bindear botones de navegación
        const prevBtn = container.querySelector('.cm-calendar__nav-btn--prev');
        const nextBtn = container.querySelector('.cm-calendar__nav-btn--next');

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                changeMonth(-1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                changeMonth(1);
            });
        }

        // Cargar el mes actual
        fetchAndRender();
    }

    /**
     * Cambiar de mes.
     */
    function changeMonth(delta) {
        currentMonth += delta;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        } else if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        fetchAndRender();
    }

    /**
     * Obtener actividades y renderizar.
     */
    function fetchAndRender() {
        const formData = new FormData();
        formData.append('action', 'cm_get_calendar');
        formData.append('nonce', cmCalendar.nonce);
        formData.append('month', currentMonth);
        formData.append('year', currentYear);

        fetch(cmCalendar.ajaxurl, {
            method: 'POST',
            body: formData,
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (data.success) {
                    activities = data.data.activities || [];
                }
                render();
            })
            .catch(function () {
                activities = [];
                render();
            });
    }

    /**
     * Renderizar el calendario en el DOM.
     */
    function render() {
        // Actualizar label del mes
        const monthLabel = document.querySelector('.cm-calendar__month-label');
        if (monthLabel) {
            monthLabel.textContent = MONTHS_ES[currentMonth - 1] + ' ' + currentYear;
        }

        const tbody = document.querySelector('.cm-calendar__table tbody');
        if (!tbody) return;

        // Calcular días del mes
        const firstDay = new Date(currentYear, currentMonth - 1, 1);
        const lastDay = new Date(currentYear, currentMonth, 0);
        const daysInMonth = lastDay.getDate();

        // Día de la semana del primer día (0=Dom → ajustar a Lunes=0)
        let startDay = firstDay.getDay() - 1;
        if (startDay < 0) startDay = 6;

        // Días del mes anterior
        const prevMonthDays = new Date(currentYear, currentMonth - 1, 0).getDate();

        // Obtener días con actividades
        const activityDays = getActivityDays();

        // Hoy
        const today = new Date();
        const isCurrentMonth = today.getMonth() + 1 === currentMonth && today.getFullYear() === currentYear;

        let html = '';
        let day = 1;
        let nextMonthDay = 1;

        for (let week = 0; week < 6; week++) {
            if (day > daysInMonth) break;
            html += '<tr>';

            for (let dow = 0; dow < 7; dow++) {
                const cellIndex = week * 7 + dow;

                if (cellIndex < startDay) {
                    // Días del mes anterior
                    const prevDay = prevMonthDays - startDay + cellIndex + 1;
                    html += '<td><span class="cm-calendar__day cm-calendar__day--other-month">' + prevDay + '</span></td>';
                } else if (day > daysInMonth) {
                    // Días del mes siguiente
                    html += '<td><span class="cm-calendar__day cm-calendar__day--other-month">' + nextMonthDay + '</span></td>';
                    nextMonthDay++;
                } else {
                    let classes = 'cm-calendar__day';

                    if (isCurrentMonth && day === today.getDate()) {
                        classes += ' cm-calendar__day--today';
                    }

                    if (activityDays.includes(day)) {
                        classes += ' cm-calendar__day--has-activity';
                    }

                    html += '<td><span class="' + classes + '" data-day="' + day + '">' + day + '</span></td>';
                    day++;
                }
            }

            html += '</tr>';
        }

        tbody.innerHTML = html;

        // Bind click en días con actividades
        tbody.querySelectorAll('.cm-calendar__day--has-activity').forEach(function (el) {
            el.addEventListener('click', function () {
                var dayNum = parseInt(this.dataset.day);
                showDayActivities(dayNum);
            });
        });
    }

    /**
     * Obtener los días del mes que tienen actividades.
     */
    function getActivityDays() {
        var days = [];
        activities.forEach(function (activity) {
            var start = new Date(activity.fecha_inicio);
            var end = activity.fecha_fin ? new Date(activity.fecha_fin) : start;

            for (var d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                if (d.getMonth() + 1 === currentMonth && d.getFullYear() === currentYear) {
                    var day = d.getDate();
                    if (days.indexOf(day) === -1) {
                        days.push(day);
                    }
                }
            }
        });
        return days;
    }

    /**
     * Mostrar actividades de un día específico (tooltip/popup simple).
     */
    function showDayActivities(dayNum) {
        var dateStr = currentYear + '-' + String(currentMonth).padStart(2, '0') + '-' + String(dayNum).padStart(2, '0');
        var dayActivities = activities.filter(function (a) {
            return a.fecha_inicio <= dateStr && (a.fecha_fin || a.fecha_inicio) >= dateStr;
        });

        if (dayActivities.length === 0) return;

        // Crear o actualizar tooltip
        var existingTooltip = document.querySelector('.cm-calendar-tooltip');
        if (existingTooltip) existingTooltip.remove();

        var tooltip = document.createElement('div');
        tooltip.className = 'cm-calendar-tooltip';
        tooltip.innerHTML = '<div class="cm-calendar-tooltip__header">' +
            '<strong>' + dayNum + ' de ' + MONTHS_ES[currentMonth - 1] + '</strong>' +
            '<button class="cm-calendar-tooltip__close">&times;</button>' +
            '</div>' +
            '<ul class="cm-calendar-tooltip__list">' +
            dayActivities.map(function (a) {
                return '<li><a href="' + a.url + '">' + a.title + '</a>' +
                    (a.lugar ? '<br><small>' + a.lugar + '</small>' : '') +
                    '</li>';
            }).join('') +
            '</ul>';

        document.querySelector('.cm-calendar-widget .cm-card__body').appendChild(tooltip);

        tooltip.querySelector('.cm-calendar-tooltip__close').addEventListener('click', function () {
            tooltip.remove();
        });
    }

    // ─── Inicializar ───
    document.addEventListener('DOMContentLoaded', init);

})();
