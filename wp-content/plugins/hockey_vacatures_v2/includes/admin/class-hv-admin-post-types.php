<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin_Post_Types {

    public function __construct(){

        include_once( dirname( __FILE__ ) . '/class-hv-admin-meta-boxes.php' );
    }
}
new HV_Admin_Post_Types();