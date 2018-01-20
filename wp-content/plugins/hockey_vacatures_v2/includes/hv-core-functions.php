<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function hv_maybe_define_constant( $name, $value ) {
    if( ! defined( $name) ) {
        define( $name, $value );
    }
}