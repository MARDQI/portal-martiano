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
    let hoverLegendEl;

    function parseLocalDate(dateStr) {
        if (!dateStr || typeof dateStr !== 'string') {
            return null;
        }

        const parts = dateStr.split('-');
        if (parts.length !== 3) {
            return null;
        }

        const year = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10);
        const day = parseInt(parts[2], 10);

        if (!year || !month || !day) {
            return null;
        }

        return new Date(year, month - 1, day);
    }

    function hexToRgba(hex, alpha) {
        const normalized = (hex || '').replace('#', '');
        if (normalized.length !== 6) {
            return 'rgba(47, 111, 237, ' + alpha + ')';
        }

        const red = parseInt(normalized.substring(0, 2), 16);
        const green = parseInt(normalized.substring(2, 4), 16);
        const blue = parseInt(normalized.substring(4, 6), 16);

        return 'rgba(' + red + ', ' + green + ', ' + blue + ', ' + alpha + ')';
    }

    function formatRangeLabel(item) {
        if (item.type === 'evento') {
            return item.hora ? item.hora : 'Evento';
        }

        if (!item.fecha_fin || item.fecha_fin === item.fecha_inicio) {
            return '1 día';
        }

        const start = parseLocalDate(item.fecha_inicio);
        const end = parseLocalDate(item.fecha_fin);
        if (!start || !end) {
            return 'Duración';
        }
        const diff = Math.round((end - start) / 86400000) + 1;
        return diff + ' días';
    }

    function formatShortDate(dateStr) {
        if (!dateStr) return '';
        const date = parseLocalDate(dateStr);
        if (!date) return '';
        return date.getDate() + ' ' + MONTHS_ES[date.getMonth()].slice(0, 3);
    }

    function getDayItems(dayNum) {
        var dateStr = currentYear + '-' + String(currentMonth).padStart(2, '0') + '-' + String(dayNum).padStart(2, '0');
        return activities.filter(function (a) {
            return a.fecha_inicio <= dateStr && (a.fecha_fin || a.fecha_inicio) >= dateStr;
        });
    }

    function buildDayItemsHtml(dayItems, compact) {
        return dayItems.map(function (a) {
            const durationText = formatRangeLabel(a);
            const rangeText = (a.fecha_fin && a.fecha_fin !== a.fecha_inicio)
                ? formatShortDate(a.fecha_inicio) + ' → ' + formatShortDate(a.fecha_fin)
                : formatShortDate(a.fecha_inicio);

            return '<li class="cm-calendar-tooltip__item">' +
                '<span class="cm-calendar-tooltip__dot" style="background:' + (a.color || '#2F6FED') + ';"></span>' +
                '<div class="cm-calendar-tooltip__item-body">' +
                '<div class="cm-calendar-tooltip__meta">' +
                '<small class="cm-calendar-tooltip__type">' + (a.type === 'evento' ? 'Evento' : 'Actividad') + '</small>' +
                '<span class="cm-calendar-tooltip__duration">' + durationText + '</span>' +
                '</div>' +
                (compact
                    ? '<strong class="cm-calendar-tooltip__title">' + a.title + '</strong>'
                    : '<a href="' + a.url + '">' + a.title + '</a>') +
                '<small class="cm-calendar-tooltip__range">' + rangeText + '</small>' +
                (a.lugar ? '<small>' + a.lugar + '</small>' : '') +
                (a.hora ? '<small>' + a.hora + '</small>' : '') +
                '</div>' +
                '</li>';
        }).join('');
    }

    function removeHoverLegend() {
        if (hoverLegendEl) {
            hoverLegendEl.remove();
            hoverLegendEl = null;
        }
    }

    function showDayHoverLegend(dayNum, anchorEl) {
        var dayItems = getDayItems(dayNum);
        if (dayItems.length === 0) return;

        removeHoverLegend();

        const container = document.querySelector('.cm-calendar-widget .cm-card__body');
        if (!container) return;

        const anchorRect = anchorEl.getBoundingClientRect();
        const containerRect = container.getBoundingClientRect();

        const legend = document.createElement('div');
        legend.className = 'cm-calendar-hover-legend';
        const summaryText = dayItems.length > 1
            ? 'Coinciden ' + dayItems.length + ' actividades/eventos'
            : '1 actividad/evento';
        legend.innerHTML = '<div class="cm-calendar-hover-legend__header">' +
            '<strong>' + dayNum + ' de ' + MONTHS_ES[currentMonth - 1] + '</strong>' +
            '<small class="cm-calendar-hover-legend__summary">' + summaryText + '</small>' +
            '</div>' +
            '<ul class="cm-calendar-tooltip__list">' + buildDayItemsHtml(dayItems, true) + '</ul>';

        container.appendChild(legend);
        const legendWidth = legend.offsetWidth;

        let left = anchorRect.left - containerRect.left + (anchorRect.width / 2) - (legendWidth / 2);
        left = Math.max(8, Math.min(left, container.clientWidth - legendWidth - 8));

        legend.style.left = left + 'px';
        legend.style.top = (anchorRect.bottom - containerRect.top + 8) + 'px';

        hoverLegendEl = legend;
    }

    function buildRingValue(colors) {
        if (!colors || colors.length === 0) {
            return '#2F6FED';
        }

        if (colors.length === 1) {
            return colors[0];
        }

        const segment = 360 / colors.length;
        const stops = colors.map(function (color, index) {
            const start = (index * segment).toFixed(2);
            const end = ((index + 1) * segment).toFixed(2);
            return color + ' ' + start + 'deg ' + end + 'deg';
        });

        return 'conic-gradient(' + stops.join(', ') + ')';
    }

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

        const dayDecorations = getDayDecorations();

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
                    let cellClasses = 'cm-calendar__cell';
                    let cellStyle = '';
                    let dayData = dayDecorations[day] || null;

                    if (isCurrentMonth && day === today.getDate()) {
                        classes += ' cm-calendar__day--today';
                    }

                    if (dayData) {
                        classes += ' cm-calendar__day--has-activity';
                        cellClasses += ' ' + dayData.segmentClass;
                        cellStyle = ' style="--cm-calendar-accent:' + dayData.color + ';--cm-calendar-accent-soft:' + hexToRgba(dayData.color, 0.18) + ';--cm-calendar-accent-strong:' + hexToRgba(dayData.color, 0.28) + ';--cm-calendar-ring:' + buildRingValue(dayData.colors) + ';"';
                    }

                    const titleText = dayData && dayData.titles && dayData.titles.length
                        ? dayData.titles.join(' • ')
                        : '';

                    const countBadge = dayData && dayData.count > 1
                        ? '<span class="cm-calendar__multi-count" title="' + titleText + '">' + dayData.count + '</span>'
                        : '';

                    html += '<td class="' + cellClasses + '"' + cellStyle + ' data-day="' + day + '" title="' + titleText.replace(/"/g, '&quot;') + '">' + countBadge + '<span class="' + classes + '" data-day="' + day + '">' + day + '</span></td>';
                    day++;
                }
            }

            html += '</tr>';
        }

        tbody.innerHTML = html;
        removeHoverLegend();

        // Bind click/hover en celdas con actividades
        tbody.querySelectorAll('.cm-calendar__cell--single, .cm-calendar__cell--range-start, .cm-calendar__cell--range-middle, .cm-calendar__cell--range-end').forEach(function (cell) {
            const dayNum = parseInt(cell.dataset.day);
            if (!dayNum) return;

            cell.addEventListener('click', function () {
                showDayActivities(dayNum);
            });

            cell.addEventListener('mouseenter', function () {
                showDayHoverLegend(dayNum, cell.querySelector('.cm-calendar__day') || cell);
            });

            cell.addEventListener('mouseleave', function () {
                removeHoverLegend();
            });
        });
    }

    /**
     * Obtener los días del mes que tienen actividades.
     */
    function getDayDecorations() {
        var decorations = {};

        activities.forEach(function (item) {
            var start = parseLocalDate(item.fecha_inicio);
            var end = item.fecha_fin ? parseLocalDate(item.fecha_fin) : start;
            if (!start || !end) {
                return;
            }
            var visibleDays = [];

            for (var d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
                if (d.getMonth() + 1 === currentMonth && d.getFullYear() === currentYear) {
                    visibleDays.push(d.getDate());
                }
            }

            visibleDays.forEach(function (day, index) {
                if (!decorations[day]) {
                    decorations[day] = { entries: [] };
                }

                decorations[day].entries.push({
                    id: item.id,
                    type: item.type,
                    title: item.title,
                    lugar: item.lugar,
                    hora: item.hora,
                    color: item.color || '#2F6FED',
                    visibleDays: visibleDays,
                    index: index,
                    duration: visibleDays.length,
                });
            });
        });

        Object.keys(decorations).forEach(function (dayKey) {
            var dayEntries = decorations[dayKey].entries;

            dayEntries.sort(function (a, b) {
                if (a.duration !== b.duration) {
                    return b.duration - a.duration;
                }

                if (a.type !== b.type) {
                    return a.type === 'actividad' ? -1 : 1;
                }

                return a.id - b.id;
            });

            var primary = dayEntries[0];
            var segmentClass = 'cm-calendar__cell--single';
            if (primary.duration > 1) {
                if (primary.index === 0) {
                    segmentClass = 'cm-calendar__cell--range-start';
                } else if (primary.index === primary.duration - 1) {
                    segmentClass = 'cm-calendar__cell--range-end';
                } else {
                    segmentClass = 'cm-calendar__cell--range-middle';
                }
            }

            var colors = [];
            var titles = [];
            dayEntries.forEach(function (entry) {
                if (colors.indexOf(entry.color) === -1) {
                    colors.push(entry.color);
                }
                if (titles.indexOf(entry.title) === -1) {
                    titles.push(entry.title);
                }
            });

            decorations[dayKey] = {
                color: primary.color,
                colors: colors,
                titles: titles,
                count: dayEntries.length,
                segmentClass: segmentClass,
            };
        });

        return decorations;
    }

    /**
     * Mostrar actividades de un día específico (tooltip/popup simple).
     */
    function showDayActivities(dayNum) {
        var dayActivities = getDayItems(dayNum);

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
            '<ul class="cm-calendar-tooltip__list">' + buildDayItemsHtml(dayActivities, false) + '</ul>';

        document.querySelector('.cm-calendar-widget .cm-card__body').appendChild(tooltip);

        tooltip.querySelector('.cm-calendar-tooltip__close').addEventListener('click', function () {
            tooltip.remove();
        });
    }

    // ─── Inicializar ───
    document.addEventListener('DOMContentLoaded', init);

})();
