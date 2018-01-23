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
 * Redirect the user on login.
 *
 * @param $redirect_to
 * @param $request
 * @param $user
 * @return string
 */
function redirect_on_login($redirect_to, $request, $user){
    if(isset($user->roles) && is_array($user->roles)){
        if(in_array('administrator', $user->roles)){
            return $redirect_to;
        } else {
            return home_url() . '?login=true';
        }
    } else {
        return $redirect_to;
    }
}
add_action( 'login_redirect', 'redirect_on_login', 10, 3 );

/**
 * Hide the admin bar for all users except admins.
 */
function hv_remove_admin_bar(){
    if( !current_user_can( 'administrator' ) && !is_admin() ){

        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'hv_remove_admin_bar' );

/**
 * Block the /wp-admin for all users except admins.
 *
 * @since	1.0.0
 */
function hv_block_users_form_admin(){
    if( is_admin() && !current_user_can( 'administrator' ) && !(defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'hv_block_users_form_admin' );

// Helper functions.
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