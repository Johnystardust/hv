<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Post_Types {

    public static function init(){
        add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
    }

    public static function register_post_types() {
        if( post_type_exists('vacature' ) || post_type_exists( 'hv_order' ) ) {
            return;
        }

        // Action before registering post types
        do_action( 'hv_register_post_type' );


        // Vacature Post Type
        // =============================================================================================================

        // Post type settings
        $delete_with_user = false;
        if( 'yes' === get_option( 'hv_delete_posts_with_user', 'yes' ) ) {
            $delete_with_user = true;
        }

        register_post_type( 'vacature',
            array(
                'labels' => array(
                    'name'                  => _x( 'Vacature', 'Post Type General Name', 'hockey_vacatures' ),
                    'singular_name'         => _x( 'Vacature', 'Post Type Singular Name', 'hockey_vacatures' ),
                    'menu_name'             => __( 'Vacatures' , 'hockey_vacatures' ),
                    'parent_item_colon'     => __( 'Parent Vacature', 'hockey_vacatures' ),
                    'all_items'             => __( 'Alle Vacatures',  'hockey_vacatures' ),
                    'view_item'             => __( 'View Vacature ',  'hockey_vacatures' ),
                    'add_new_item'          => __( 'Add New Vacature',  'hockey_vacatures' ),
                    'add_new'               => __( 'Add New',  'hockey_vacatures' ),
                    'edit_item'             => __( 'Edit Vacature', 'hockey_vacatures' ),
                    'update_item'           => __( 'Update Vacature', 'hockey_vacatures' ),
                    'search_items'          => __( 'Search Vacature', 'hockey_vacatures' ),
                    'not_found'             => __( 'Not Found', 'hockey_vacatures' ),
                    'not_found_in_trash'    => __( 'Not found in Trash',  'hockey_vacatures' ),
                ),
                'description'        => __( 'Post type for Vacatures.', 'hockey_vacatures' ),
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_in_nav_menus'  => true,
                'show_in_admin_bar'  => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'vacatures' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => 50,
                'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
                'taxonomies'         => array( 'category' ),
                'can_export'          => true,
                'exclude_from_search' => false,
                'map_meta_cap'        => true,
                'delete_with_user'   => $delete_with_user,
            )
        );

        // Order Post Type
        // =============================================================================================================
        register_post_type( 'hv_order',
            array(
                'labels' => array(
                    'name'                  => _x( 'Orders', 'Post Type General Name', 'hockey_vacatures' ),
                    'singular_name'         => _x( 'Order', 'Post Type Singular Name', 'hockey_vacatures' ),
                    'menu_name'             => __( 'Orders' , 'hockey_vacatures' ),
                    'parent_item_colon'     => __( 'Parent Order', 'hockey_vacatures' ),
                    'all_items'             => __( 'Alle Orders',  'hockey_vacatures' ),
                    'view_item'             => __( 'View Order ',  'hockey_vacatures' ),
                    'add_new_item'          => __( 'Add New Order',  'hockey_vacatures' ),
                    'add_new'               => __( 'Add New',  'hockey_vacatures' ),
                    'edit_item'             => __( 'Edit Order', 'hockey_vacatures' ),
                    'update_item'           => __( 'Update Order', 'hockey_vacatures' ),
                    'search_items'          => __( 'Search Order', 'hockey_vacatures' ),
                    'not_found'             => __( 'Not Found', 'hockey_vacatures' ),
                    'not_found_in_trash'    => __( 'Not found in Trash',  'hockey_vacatures' ),
                ),
                'description'        => __( 'Post type for Orders.', 'hockey_vacatures' ),
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => 'hockey_vacatures',
                'show_in_nav_menus'  => true,
                'show_in_admin_bar'  => true,
                'query_var'          => true,
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => 50,
                'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
                'taxonomies'         => array( 'category' ),
                'can_export'          => true,
                'exclude_from_search' => false,
                'map_meta_cap'        => true,
                'delete_with_user'   => false,
            )
        );
    }

}

HV_Post_Types::init();