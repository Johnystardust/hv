<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin_Menus {

    public function __construct(){
        add_action( 'admin_menu', array( $this, 'admin_menu' ));
    }

    public function admin_menu(){
        global $menu;
        if(current_user_can('manage_hockey_vacatures')){
            $menu[49] = array( '', 'read', 'separator-hockey-vacatures', '', 'wp-menu-separator hockey-vacatures' );
        }
        add_menu_page( __( 'Hockey Vacatures', 'hockey_vacatures' ), __( 'Hockey Vacatures', 'hockey_vacatures' ), 'manage_hockey_vacatures', 'hockey_vacatures', null, null, '49.5');
    }
}

return new HV_Admin_Menus();