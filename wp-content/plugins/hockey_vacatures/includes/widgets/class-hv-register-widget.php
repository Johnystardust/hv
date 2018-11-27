<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Register_Widget extends WP_Widget {

    function __construct(){
        parent::__construct(
            'hv_register_widget',
            __( 'HV: Login/Register', 'hockey_vacatures' ),
            array(
                'description' => __( 'This widget provides a user login form, link to register page, logout link and my profile opening button. The menu links are best placed in a header of other logical place for ul ordered list.', 'hockey_vacatures' ),
            )
        );
    }

    /**
     * Echoes the widget content.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ){
        echo $args['before_widget'];

        ?>
        <ul>
            <?php if(is_user_logged_in()): ?>
                <li class="hv-profile-link <?php echo ( isset( $_GET['login'] ) == true ) ? 'active' : '';  ?>"><a href="#"><i class="fa fa-user"></i> <span><?php echo __( 'Mijn Profiel', 'hockey_vacatures' ); ?></span></a></li>
                <li><a href="<?php echo wp_logout_url(  home_url() ); ?>"><i class="fa fa-sign-out-alt"></i> <span><?php echo __( 'Uitloggen', 'hockey_vacatures' ); ?></span></a></li>
            <?php else: ?>
                <li class="hv-login-link <?php echo ( isset( $_GET['register'] ) == true ) ? 'active' : '';  ?>">
                    <a href="#"><i class="fa fa-sign-in-alt"></i> <span><?php echo __( 'Inloggen', 'hockey_vacatures' ); ?></span></a>
                    <div class="hv-register-widget-form animated bounceIn">
                        <?php
                        $form_args = array(
                            'echo'           => true,
                            'redirect'       => home_url( '/wp-admin/' ),
                            'form_id'        => 'loginform',
                            'label_username' => __( 'Username' ),
                            'label_password' => __( 'Password' ),
                            'label_remember' => __( 'Remember Me' ),
                            'label_log_in'   => __( 'Log In' ),
                            'id_username'    => 'user_login',
                            'id_password'    => 'user_pass',
                            'id_remember'    => 'rememberme',
                            'id_submit'      => 'wp-submit',
                            'remember'       => true,
                            'value_username' => NULL,
                            'value_remember' => true
                        );

                        // Calling the login form.
                        wp_login_form( $form_args );
                        ?>
                    </div>
                </li>
                <?php $register_page = get_page_by_path( 'registreren' ); ?>
                <li><a href="<?php echo get_page_link($register_page->ID); ?>"><i class="fa fa-user-plus"></i> <span><?php echo __( 'Registreren', 'hockey_vacatures' ); ?></span></a></li>
            <?php endif; ?>
            <div class="clearfix"></div>
        </ul>

        <?php
        echo $args['after_widget'];
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title', 'hockey_vacatures' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('allow_login'); ?>" name="<?php echo $this->get_field_name('allow_login'); ?>" <?php checked($allow_login, 'on'); ?>>
            <label for="<?php echo $this->get_field_id('allow_login'); ?>"><?php echo __( 'Login Toestaan', 'hockey_vacatures' ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('allow_register'); ?>" name="<?php echo $this->get_field_name('allow_register'); ?>" <?php checked($allow_register, 'on'); ?>>
            <label for="<?php echo $this->get_field_id('allow_register'); ?>"><?php echo __( 'Registreren Toestaan', 'hockey_vacatures' ); ?></label>
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