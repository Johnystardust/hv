<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin {

    public function __construct(){
        add_action( 'init', array( $this, 'includes' ) );
    }

    /**
     * Include the admin classes.
     */
    public function includes(){
        include_once( dirname( __FILE__ ) . '/class-hv-admin-menus.php' );
        include_once( dirname( __FILE__ ) . '/class-hv-admin-meta-boxes.php' );
    }


}

return new HV_Admin();