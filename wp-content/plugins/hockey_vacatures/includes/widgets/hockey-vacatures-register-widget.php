<?php
/**
 * The Register widget.
 *
 * This widget provides a user login form, link to register page, logout link and my profile opening button.
 * The menu links are best placed in a header of other logical place for ul ordered list.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes/widgets
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Register_Widget extends WP_Widget {

    function __construct(){
        parent::__construct(
            'hv_register_widget',
            __( 'HV: Login/Register Widget', TEXTDOMAIN ),
            array(
                'description' => __( 'This widget provides a user login form, link to register page, logout link and my profile opening button. The menu links are best placed in a header of other logical place for ul ordered list.', TEXTDOMAIN ),
            )
        );
    }

    /**
     * Echoes the widget content.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ){
        include_once('partials/register-widget.php');
    }

    /**
     * Outputs the settings update form.
     *
     * @param array $instance Current settings.
     * @return string Default return is 'noform'.
     */
    public function form( $instance ){
        $title          = (isset($instance['title'] ) )             ? $instance['title']            : '';
        $allow_login    = (isset($instance['allow_login'] ) )       ? $instance['allow_login']      : '';
        $allow_register = (isset($instance['allow_register'] ) )    ? $instance['allow_register']   : '';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title', TEXTDOMAIN ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('allow_login'); ?>" name="<?php echo $this->get_field_name('allow_login'); ?>" <?php checked($allow_login, 'on'); ?>>
            <label for="<?php echo $this->get_field_id('allow_login'); ?>"><?php echo __( 'Login Toestaan', TEXTDOMAIN ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('allow_register'); ?>" name="<?php echo $this->get_field_name('allow_register'); ?>" <?php checked($allow_register, 'on'); ?>>
            <label for="<?php echo $this->get_field_id('allow_register'); ?>"><?php echo __( 'Registreren Toestaan', TEXTDOMAIN ); ?></label>
        </p>
        <?php
    }

    /**
     * Update the widget fields replacing them with new data
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ){
        $instance = array();

        $instance['title']          = (!empty( $new_instance['title'] ) )           ? $new_instance['title']            : '';
        $instance['allow_login']    = (!empty( $new_instance['allow_login'] ) )     ? $new_instance['allow_login']      : '';
        $instance['allow_register'] = (!empty( $new_instance['allow_register'] ) )  ? $new_instance['allow_register']   : '';

        return $instance;
    }
}