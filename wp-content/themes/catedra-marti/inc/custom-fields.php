<?php
/**
 * Metaboxes personalizados para los CPTs.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Sanitizar color hexadecimal para el calendario.
 *
 * @param string $color   Color recibido.
 * @param string $default Color por defecto.
 * @return string
 */
function cm_sanitize_calendar_color($color, $default) {
    $sanitized = sanitize_hex_color($color);
    return $sanitized ? $sanitized : $default;
}

/**
 * Registrar metaboxes para cada CPT.
 */
function cm_register_metaboxes() {
    // Avisos — Prioridad y fecha de vigencia
    add_meta_box(
        'cm_aviso_details',
        __('Detalles del Aviso', 'catedra-marti'),
        'cm_aviso_metabox_callback',
        'aviso',
        'normal',
        'high'
    );

    // Actividades — Fecha inicio, fecha fin, lugar
    add_meta_box(
        'cm_actividad_details',
        __('Detalles de la Actividad', 'catedra-marti'),
        'cm_actividad_metabox_callback',
        'actividad',
        'normal',
        'high'
    );

    // Eventos — Fecha, hora, lugar, enlace de inscripción
    add_meta_box(
        'cm_evento_details',
        __('Detalles del Evento', 'catedra-marti'),
        'cm_evento_metabox_callback',
        'evento',
        'normal',
        'high'
    );

    // Curiosidades — Fuente
    add_meta_box(
        'cm_curiosidad_details',
        __('Detalles de la Curiosidad', 'catedra-marti'),
        'cm_curiosidad_metabox_callback',
        'curiosidad',
        'normal',
        'high'
    );

    // Documentos — Archivo adjunto, categoría del documento
    add_meta_box(
        'cm_documento_details',
        __('Detalles del Documento', 'catedra-marti'),
        'cm_documento_metabox_callback',
        'documento',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cm_register_metaboxes');

// ═══════════════════════════════════════════
// CALLBACKS DE METABOXES
// ═══════════════════════════════════════════

/**
 * Metabox de Aviso.
 */
function cm_aviso_metabox_callback($post) {
    wp_nonce_field('cm_aviso_nonce_action', 'cm_aviso_nonce');
    $prioridad = get_post_meta($post->ID, '_cm_aviso_prioridad', true);
    if (!$prioridad || $prioridad === 'normal') {
        $prioridad = 'baja';
    }
    $vigencia  = get_post_meta($post->ID, '_cm_aviso_vigencia', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="cm_aviso_prioridad"><?php _e('Prioridad', 'catedra-marti'); ?></label></th>
            <td>
                <select id="cm_aviso_prioridad" name="cm_aviso_prioridad">
                    <option value="baja" <?php selected($prioridad, 'baja'); ?>><?php _e('Baja', 'catedra-marti'); ?></option>
                    <option value="alta" <?php selected($prioridad, 'alta'); ?>><?php _e('Alta', 'catedra-marti'); ?></option>
                    <option value="urgente" <?php selected($prioridad, 'urgente'); ?>><?php _e('Urgente', 'catedra-marti'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="cm_aviso_vigencia"><?php _e('Fecha de Vigencia', 'catedra-marti'); ?></label></th>
            <td>
                <input type="date" id="cm_aviso_vigencia" name="cm_aviso_vigencia" value="<?php echo esc_attr($vigencia); ?>" />
                <p class="description"><?php _e('Fecha hasta la cual el aviso estará visible.', 'catedra-marti'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Metabox de Actividad.
 */
function cm_actividad_metabox_callback($post) {
    wp_nonce_field('cm_actividad_nonce_action', 'cm_actividad_nonce');
    $fecha_inicio = get_post_meta($post->ID, '_cm_actividad_fecha_inicio', true);
    $fecha_fin    = get_post_meta($post->ID, '_cm_actividad_fecha_fin', true);
    $lugar        = get_post_meta($post->ID, '_cm_actividad_lugar', true);
    $color        = get_post_meta($post->ID, '_cm_actividad_color', true);
    if (!$color) {
        $color = '#2F6FED';
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="cm_actividad_fecha_inicio"><?php _e('Fecha de Inicio', 'catedra-marti'); ?></label></th>
            <td><input type="date" id="cm_actividad_fecha_inicio" name="cm_actividad_fecha_inicio" value="<?php echo esc_attr($fecha_inicio); ?>" /></td>
        </tr>
        <tr>
            <th><label for="cm_actividad_fecha_fin"><?php _e('Fecha de Fin', 'catedra-marti'); ?></label></th>
            <td><input type="date" id="cm_actividad_fecha_fin" name="cm_actividad_fecha_fin" value="<?php echo esc_attr($fecha_fin); ?>" /></td>
        </tr>
        <tr>
            <th><label for="cm_actividad_lugar"><?php _e('Lugar', 'catedra-marti'); ?></label></th>
            <td><input type="text" id="cm_actividad_lugar" name="cm_actividad_lugar" value="<?php echo esc_attr($lugar); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="cm_actividad_color"><?php _e('Color en calendario', 'catedra-marti'); ?></label></th>
            <td>
                <input type="color" id="cm_actividad_color" name="cm_actividad_color" value="<?php echo esc_attr($color); ?>" />
                <p class="description"><?php _e('Color con el que se mostrará la actividad en el calendario.', 'catedra-marti'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Metabox de Evento.
 */
function cm_evento_metabox_callback($post) {
    wp_nonce_field('cm_evento_nonce_action', 'cm_evento_nonce');
    $fecha       = get_post_meta($post->ID, '_cm_evento_fecha', true);
    $hora        = get_post_meta($post->ID, '_cm_evento_hora', true);
    $lugar       = get_post_meta($post->ID, '_cm_evento_lugar', true);
    $inscripcion = get_post_meta($post->ID, '_cm_evento_inscripcion', true);
    $color       = get_post_meta($post->ID, '_cm_evento_color', true);
    if (!$color) {
        $color = '#D97706';
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="cm_evento_fecha"><?php _e('Fecha del Evento', 'catedra-marti'); ?></label></th>
            <td><input type="date" id="cm_evento_fecha" name="cm_evento_fecha" value="<?php echo esc_attr($fecha); ?>" /></td>
        </tr>
        <tr>
            <th><label for="cm_evento_hora"><?php _e('Hora', 'catedra-marti'); ?></label></th>
            <td><input type="time" id="cm_evento_hora" name="cm_evento_hora" value="<?php echo esc_attr($hora); ?>" /></td>
        </tr>
        <tr>
            <th><label for="cm_evento_lugar"><?php _e('Lugar', 'catedra-marti'); ?></label></th>
            <td><input type="text" id="cm_evento_lugar" name="cm_evento_lugar" value="<?php echo esc_attr($lugar); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="cm_evento_inscripcion"><?php _e('Enlace de Inscripción', 'catedra-marti'); ?></label></th>
            <td>
                <input type="url" id="cm_evento_inscripcion" name="cm_evento_inscripcion" value="<?php echo esc_attr($inscripcion); ?>" class="regular-text" />
                <p class="description"><?php _e('URL del formulario de inscripción (opcional).', 'catedra-marti'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="cm_evento_color"><?php _e('Color en calendario', 'catedra-marti'); ?></label></th>
            <td>
                <input type="color" id="cm_evento_color" name="cm_evento_color" value="<?php echo esc_attr($color); ?>" />
                <p class="description"><?php _e('Color con el que se mostrará el evento en el calendario.', 'catedra-marti'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Metabox de Curiosidad.
 */
function cm_curiosidad_metabox_callback($post) {
    wp_nonce_field('cm_curiosidad_nonce_action', 'cm_curiosidad_nonce');
    $fuente = get_post_meta($post->ID, '_cm_curiosidad_fuente', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="cm_curiosidad_fuente"><?php _e('Fuente', 'catedra-marti'); ?></label></th>
            <td>
                <input type="text" id="cm_curiosidad_fuente" name="cm_curiosidad_fuente" value="<?php echo esc_attr($fuente); ?>" class="regular-text" />
                <p class="description"><?php _e('Referencia o fuente de la curiosidad.', 'catedra-marti'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Metabox de Documento.
 */
function cm_documento_metabox_callback($post) {
    wp_nonce_field('cm_documento_nonce_action', 'cm_documento_nonce');
    $archivo_id = get_post_meta($post->ID, '_cm_documento_archivo_id', true);
    $categoria  = get_post_meta($post->ID, '_cm_documento_categoria', true);
    $archivo_url = $archivo_id ? wp_get_attachment_url($archivo_id) : '';
    ?>
    <table class="form-table">
        <tr>
            <th><label for="cm_documento_archivo"><?php _e('Archivo Adjunto', 'catedra-marti'); ?></label></th>
            <td>
                <input type="hidden" id="cm_documento_archivo_id" name="cm_documento_archivo_id" value="<?php echo esc_attr($archivo_id); ?>" />
                <input type="text" id="cm_documento_archivo_url" value="<?php echo esc_url($archivo_url); ?>" class="regular-text" readonly />
                <button type="button" class="button cm-upload-btn" data-target="cm_documento_archivo"><?php _e('Seleccionar Archivo', 'catedra-marti'); ?></button>
                <?php if ($archivo_url) : ?>
                    <p class="description"><a href="<?php echo esc_url($archivo_url); ?>" target="_blank"><?php _e('Ver archivo actual', 'catedra-marti'); ?></a></p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="cm_documento_categoria"><?php _e('Categoría del Documento', 'catedra-marti'); ?></label></th>
            <td>
                <select id="cm_documento_categoria" name="cm_documento_categoria">
                    <option value="general" <?php selected($categoria, 'general'); ?>><?php _e('General', 'catedra-marti'); ?></option>
                    <option value="academico" <?php selected($categoria, 'academico'); ?>><?php _e('Académico', 'catedra-marti'); ?></option>
                    <option value="normativo" <?php selected($categoria, 'normativo'); ?>><?php _e('Normativo', 'catedra-marti'); ?></option>
                    <option value="informativo" <?php selected($categoria, 'informativo'); ?>><?php _e('Informativo', 'catedra-marti'); ?></option>
                </select>
            </td>
        </tr>
    </table>

    <script>
    jQuery(document).ready(function($) {
        $('.cm-upload-btn').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var frame = wp.media({
                title: '<?php _e("Seleccionar Documento", "catedra-marti"); ?>',
                button: { text: '<?php _e("Usar este archivo", "catedra-marti"); ?>' },
                multiple: false,
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#' + target + '_id').val(attachment.id);
                $('#' + target + '_url').val(attachment.url);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

// ═══════════════════════════════════════════
// GUARDAR METADATOS
// ═══════════════════════════════════════════

/**
 * Guardar metadatos al guardar un post.
 */
function cm_save_metaboxes($post_id) {
    // Verificar autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Verificar permisos
    if (!current_user_can('edit_post', $post_id)) return;

    // ─── Aviso ───
    if (isset($_POST['cm_aviso_nonce']) && wp_verify_nonce($_POST['cm_aviso_nonce'], 'cm_aviso_nonce_action')) {
        $prioridad = isset($_POST['cm_aviso_prioridad']) ? sanitize_text_field($_POST['cm_aviso_prioridad']) : 'baja';
        $prioridades_validas = ['urgente', 'alta', 'baja', 'normal'];
        if (!in_array($prioridad, $prioridades_validas, true)) {
            $prioridad = 'baja';
        }

        if ($prioridad === 'normal') {
            $prioridad = 'baja';
        }

        $mapa_orden = [
            'urgente' => 3,
            'alta'    => 2,
            'baja'    => 1,
        ];

        update_post_meta($post_id, '_cm_aviso_prioridad', $prioridad);
        update_post_meta($post_id, '_cm_aviso_prioridad_orden', $mapa_orden[$prioridad]);

        if (isset($_POST['cm_aviso_vigencia'])) {
            update_post_meta($post_id, '_cm_aviso_vigencia', sanitize_text_field($_POST['cm_aviso_vigencia']));
        }
    }

    // ─── Actividad ───
    if (isset($_POST['cm_actividad_nonce']) && wp_verify_nonce($_POST['cm_actividad_nonce'], 'cm_actividad_nonce_action')) {
        $actividad_fields = ['fecha_inicio', 'fecha_fin', 'lugar'];
        foreach ($actividad_fields as $field) {
            if (isset($_POST['cm_actividad_' . $field])) {
                update_post_meta($post_id, '_cm_actividad_' . $field, sanitize_text_field($_POST['cm_actividad_' . $field]));
            }
        }
        $actividad_color = isset($_POST['cm_actividad_color']) ? $_POST['cm_actividad_color'] : '#2F6FED';
        update_post_meta($post_id, '_cm_actividad_color', cm_sanitize_calendar_color($actividad_color, '#2F6FED'));
    }

    // ─── Evento ───
    if (isset($_POST['cm_evento_nonce']) && wp_verify_nonce($_POST['cm_evento_nonce'], 'cm_evento_nonce_action')) {
        $evento_fields = ['fecha', 'hora', 'lugar'];
        foreach ($evento_fields as $field) {
            if (isset($_POST['cm_evento_' . $field])) {
                update_post_meta($post_id, '_cm_evento_' . $field, sanitize_text_field($_POST['cm_evento_' . $field]));
            }
        }
        if (isset($_POST['cm_evento_inscripcion'])) {
            update_post_meta($post_id, '_cm_evento_inscripcion', esc_url_raw($_POST['cm_evento_inscripcion']));
        }
        $evento_color = isset($_POST['cm_evento_color']) ? $_POST['cm_evento_color'] : '#D97706';
        update_post_meta($post_id, '_cm_evento_color', cm_sanitize_calendar_color($evento_color, '#D97706'));
    }

    // ─── Curiosidad ───
    if (isset($_POST['cm_curiosidad_nonce']) && wp_verify_nonce($_POST['cm_curiosidad_nonce'], 'cm_curiosidad_nonce_action')) {
        if (isset($_POST['cm_curiosidad_fuente'])) {
            update_post_meta($post_id, '_cm_curiosidad_fuente', sanitize_text_field($_POST['cm_curiosidad_fuente']));
        }
    }

    // ─── Documento ───
    if (isset($_POST['cm_documento_nonce']) && wp_verify_nonce($_POST['cm_documento_nonce'], 'cm_documento_nonce_action')) {
        if (isset($_POST['cm_documento_archivo_id'])) {
            update_post_meta($post_id, '_cm_documento_archivo_id', absint($_POST['cm_documento_archivo_id']));
        }
        if (isset($_POST['cm_documento_categoria'])) {
            update_post_meta($post_id, '_cm_documento_categoria', sanitize_text_field($_POST['cm_documento_categoria']));
        }
    }
}
add_action('save_post', 'cm_save_metaboxes');

/**
 * Encolar WordPress media uploader en pantallas de documentos.
 */
function cm_admin_enqueue_media($hook) {
    global $post_type;
    if ($post_type === 'documento' && in_array($hook, ['post.php', 'post-new.php'])) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'cm_admin_enqueue_media');
