<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include_once( dirname( __FILE__ ) . '/widgets/class-hv-register-widget.php' );

/**
 * Register the widgets.
 *
 * @since 1.0.0
 */
function hv_register_widgets(){
    register_widget( 'HV_Register_Widget' );
}
add_action( 'widgets_init', 'hv_register_widgets' );