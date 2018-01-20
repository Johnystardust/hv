<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin {

    public function __construct(){
        add_action( 'init', array( $this, 'includes' ) );
    }

    public function includes(){

    }
}