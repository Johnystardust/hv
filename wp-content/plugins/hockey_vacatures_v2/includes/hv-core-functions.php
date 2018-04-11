<?php

if( !defined( 'ABSPATH' ) ) {
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
 *
 * @return string
 */
function redirect_on_login( $redirect_to, $request, $user )
{
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        if( in_array( 'administrator', $user->roles ) ) {
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
function hv_remove_admin_bar()
{
    if( !current_user_can( 'administrator' ) && !is_admin() ) {

        show_admin_bar( false );
    }
}

add_action( 'after_setup_theme', 'hv_remove_admin_bar' );

/**
 * Block the /wp-admin for all users except admins.
 */
function hv_block_users_form_admin()
{
    if( is_admin() && !current_user_can( 'administrator' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

add_action( 'init', 'hv_block_users_form_admin' );

/**
 * Add to the body class
 */
function hv_add_body_class()
{
    if( isset( $_GET['login'] ) == true ) {
        add_filter( 'body_class', function ( $classes ) {
            return array_merge( $classes, array( 'hv-side-panel-open' ) );
        } );
    }
}

add_action( 'init', 'hv_add_body_class' );

// Helper functions.
// =====================================================================================================================

/**
 * Defines constant if not defined
 *
 * @param $name
 * @param $value
 */
function hv_maybe_define_constant( $name, $value )
{
    if( !defined( $name ) ) {
        define( $name, $value );
    }
}

/**
 * Checks if the user is an administrator
 *
 * @param WP_User $user
 *
 * @return bool
 */
function hv_is_user_admin( WP_User $user )
{
    if( $user->roles[0] === 'administrator' ) {
        return true;
    }

    return false;
}


// Ajax functions.
// =====================================================================================================================

/**
 * Side panel get template
 */
function hv_side_panel_get_template()
{

    if( $_GET['name'] == '#user_vacatures' ) {
        include_once( HV_ABSPATH . 'templates/shortcodes/user-panel/user-vacatures.php' );
    } elseif( $_GET['name'] == '#edit_vacature' ) {
        include_once( HV_ABSPATH . 'templates/shortcodes/user-panel/user-edit-vacature.php' );
    }

    die;
}

add_action( 'wp_ajax_nopriv_hv_side_panel_get_template', 'hv_side_panel_get_template' );
add_action( 'wp_ajax_hv_side_panel_get_template', 'hv_side_panel_get_template' );