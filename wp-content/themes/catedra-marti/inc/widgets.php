<?php
/**
 * Widgets personalizados.
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Widget: Información de Contacto (RF45).
 */
class CM_Contact_Info_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'cm_contact_info',
            __('CM: Información de Contacto', 'catedra-marti'),
            ['description' => __('Muestra la información de contacto de la cátedra.', 'catedra-marti')]
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }

        echo '<div class="cm-contact-info">';

        if (!empty($instance['address'])) {
            echo '<p class="cm-contact-info__address"><span class="dashicons dashicons-location"></span> ' . esc_html($instance['address']) . '</p>';
        }
        if (!empty($instance['phone'])) {
            echo '<p class="cm-contact-info__phone"><span class="dashicons dashicons-phone"></span> ' . esc_html($instance['phone']) . '</p>';
        }
        if (!empty($instance['email'])) {
            echo '<p class="cm-contact-info__email"><span class="dashicons dashicons-email"></span> <a href="mailto:' . esc_attr($instance['email']) . '">' . esc_html($instance['email']) . '</a></p>';
        }

        echo '</div>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title   = !empty($instance['title']) ? $instance['title'] : __('Contacto', 'catedra-marti');
        $address = !empty($instance['address']) ? $instance['address'] : '';
        $phone   = !empty($instance['phone']) ? $instance['phone'] : '';
        $email   = !empty($instance['email']) ? $instance['email'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Título:', 'catedra-marti'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php _e('Dirección:', 'catedra-marti'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php _e('Teléfono:', 'catedra-marti'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php _e('Email:', 'catedra-marti'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="email" value="<?php echo esc_attr($email); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title']   = sanitize_text_field($new_instance['title']);
        $instance['address'] = sanitize_text_field($new_instance['address']);
        $instance['phone']   = sanitize_text_field($new_instance['phone']);
        $instance['email']   = sanitize_email($new_instance['email']);
        return $instance;
    }
}

/**
 * Registrar widgets personalizados.
 */
function cm_register_custom_widgets() {
    register_widget('CM_Contact_Info_Widget');
}
add_action('widgets_init', 'cm_register_custom_widgets');
