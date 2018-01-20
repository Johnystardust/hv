<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Post_Types {

    public static function init(){
        add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
    }

    public static function register_post_types() {

    }

}

WC_Post_types::init();