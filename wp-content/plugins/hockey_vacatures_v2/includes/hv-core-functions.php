<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Include core functions.
// =====================================================================================================================
include_once( HV_ABSPATH . 'includes/hv-widgets.php' );

// Core functions.
// =====================================================================================================================

/**
 * Defines constant if not defined
 *
 * @param $name
 * @param $value
 */
function hv_maybe_define_constant( $name, $value ) {
    if( ! defined( $name) ) {
        define( $name, $value );
    }
}