<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin_Menus {

    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_menu', array( $this, 'settings_menu' ) );
    }

    public function admin_menu(){
        global $menu;
        if(current_user_can('manage_hockey_vacatures')){
            $menu[49] = array( '', 'read', 'separator-hockey-vacatures', '', 'wp-menu-separator hockey-vacatures' );
        }

        add_menu_page( __( 'Hockey Vacatures', 'hockey_vacatures' ), __( 'Hockey Vacatures', 'hockey_vacatures' ), 'manage_hockey_vacatures', 'hockey_vacatures', null, null, '49.5');
    }

    public function settings_menu(){
        $settings_page = add_submenu_page( 'hockey_vacatures', __( 'Hockey Vacatures Settings', 'hockey_vacatures' ), __( 'Settings', 'hockey_vacatures' ), 'manage_hockey_vacatures', 'hv_settings', array( $this, 'settings_page' ) );
//        add_action( 'load-' .$settings_page, array( $this, 'settings_page_init' ) );
    }

    /**
     * Init the settings page.
     */
    public function settings_page() {
        echo '<h1>test</h1>';
//        HV_Admin_Settings::output();
    }
}

return new HV_Admin_Menus();