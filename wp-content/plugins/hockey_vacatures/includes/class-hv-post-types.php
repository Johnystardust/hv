<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class HV_Post_Types
{

    public static function init()
    {
        add_action('init', array(__CLASS__, 'register_post_types'), 5);
        add_action('init', array(__CLASS__, 'register_taxonomies'));
        add_action('admin_init', array(__CLASS__, 'insert_categories'));
    }

    /**
     * Registers the post types needed for the plugin.
     */
    public static function register_post_types()
    {
        if (post_type_exists('vacature') || post_type_exists('hv_order')) {
            return;
        }

        // Action before registering post types
        do_action('hv_register_post_type');


        // Vacature Post Type
        // =============================================================================================================

        // Post type settings
        $delete_with_user = false;
        if ('yes' === get_option('hv_delete_posts_with_user', 'yes')) {
            $delete_with_user = true;
        }

        register_post_type('vacature',
            array(
                'labels' => array(
                    'name' => _x('Vacature', 'Post Type General Name', 'hockey_vacatures'),
                    'singular_name' => _x('Vacature', 'Post Type Singular Name', 'hockey_vacatures'),
                    'menu_name' => __('Vacatures', 'hockey_vacatures'),
                    'parent_item_colon' => __('Parent Vacature', 'hockey_vacatures'),
                    'all_items' => __('Alle vacatures', 'hockey_vacatures'),
                    'view_item' => __('View Vacature ', 'hockey_vacatures'),
                    'add_new_item' => __('Nieuwe vacature toevoegen', 'hockey_vacatures'),
                    'add_new' => __('Nieuwe vacature', 'hockey_vacatures'),
                    'edit_item' => __('Vacature bewerken', 'hockey_vacatures'),
                    'update_item' => __('Update vacature', 'hockey_vacatures'),
                    'search_items' => __('Zoek Vacature', 'hockey_vacatures'),
                    'not_found' => __('Not Found', 'hockey_vacatures'),
                    'not_found_in_trash' => __('Not found in Trash', 'hockey_vacatures'),
                ),
                'description' => __('Post type for Vacatures.', 'hockey_vacatures'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'vacatures'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 50,
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies' => array('vacature'),
                'can_export' => true,
                'exclude_from_search' => false,
                'map_meta_cap' => true,
                'delete_with_user' => $delete_with_user,
                'menu_icon' => 'dashicons-id-alt',
            )
        );

        // Practice Match Post Type
        // =============================================================================================================
        register_post_type('practice_match',
            array(
                'labels' => array(
                    'name' => _x('Oefenwedstrijd', 'Post Type General Name', 'hockey_vacatures'),
                    'singular_name' => _x('Oefenwedstrijd', 'Post Type Singular Name', 'hockey_vacatures'),
                    'menu_name' => __('Oefenwedstrijden', 'hockey_vacatures'),
                    'parent_item_colon' => __('Parent Oefenwedstrijd', 'hockey_vacatures'),
                    'all_items' => __('Alle Oefenwedstrijden', 'hockey_vacatures'),
                    'view_item' => __('Bekijk Oefenwedstrijd ', 'hockey_vacatures'),
                    'add_new_item' => __('Nieuwe oefenwedstrijd toevoegen', 'hockey_vacatures'),
                    'add_new' => __('Nieuwe oefenwedstrijd', 'hockey_vacatures'),
                    'edit_item' => __('Oefenwedstrijd bewerken', 'hockey_vacatures'),
                    'update_item' => __('Update oefenwedstrijd', 'hockey_vacatures'),
                    'search_items' => __('Zoek oefenwedstrijd', 'hockey_vacatures'),
                    'not_found' => __('Not Found', 'hockey_vacatures'),
                    'not_found_in_trash' => __('Not found in Trash', 'hockey_vacatures'),
                ),
                'description' => __('Post type for oefenwedstrijden.', 'hockey_vacatures'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'oefenwedstrijden'),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 50,
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies' => array('category'),
                'can_export' => true,
                'exclude_from_search' => false,
                'map_meta_cap' => true,
                'delete_with_user' => $delete_with_user,
                'menu_icon' => 'dashicons-awards',
            )
        );

        // Order Post Type
        // =============================================================================================================
        register_post_type('hv_order',
            array(
                'labels' => array(
                    'name' => _x('Orders', 'Post Type General Name', 'hockey_vacatures'),
                    'singular_name' => _x('Order', 'Post Type Singular Name', 'hockey_vacatures'),
                    'menu_name' => __('Orders', 'hockey_vacatures'),
                    'parent_item_colon' => __('Parent Order', 'hockey_vacatures'),
                    'all_items' => __('Alle Orders', 'hockey_vacatures'),
                    'view_item' => __('View Order ', 'hockey_vacatures'),
                    'add_new_item' => __('Add New Order', 'hockey_vacatures'),
                    'add_new' => __('Add New', 'hockey_vacatures'),
                    'edit_item' => __('Edit Order', 'hockey_vacatures'),
                    'update_item' => __('Update Order', 'hockey_vacatures'),
                    'search_items' => __('Search Order', 'hockey_vacatures'),
                    'not_found' => __('Not Found', 'hockey_vacatures'),
                    'not_found_in_trash' => __('Not found in Trash', 'hockey_vacatures'),
                ),
                'description' => __('Post type for Orders.', 'hockey_vacatures'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => 'hockey_vacatures',
                'show_in_nav_menus' => true,
                'show_in_admin_bar' => true,
                'query_var' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => 50,
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies' => array('category'),
                'can_export' => true,
                'exclude_from_search' => false,
                'map_meta_cap' => true,
                'delete_with_user' => false,
                'menu_icon' => 'dashicons-location-alt',
            )
        );
    }

    /**
     * Register the taxonomies needed for the plugin.
     */
    public static function register_taxonomies()
    {

        // Vacature Taxonomy
        // =============================================================================================================
        register_taxonomy(
            'vacature_category',
            'vacature',
            array(
                'label' => __('Vacature Categorieën', 'hockey_vacatures'),
                'show_tagcloud' => false,
                'show_admin_column' => true,
                'hierarchical' => true,
                'rewrite' => array('vacature_category')
            )
        );

        // Functions Taxonomy
        // =============================================================================================================
        $labels = array(
            'name' => _x( 'Functions', 'hockey_vacatures' ),
            'singular_name' => _x( 'Function', 'hockey_vacatures' ),
            'search_items' =>  __( 'Search Functions' ),
            'all_items' => __( 'All Functions' ),
            'parent_item' => __( 'Parent Function' ),
            'parent_item_colon' => __( 'Parent Function:' ),
            'edit_item' => __( 'Edit Function' ),
            'update_item' => __( 'Update Function' ),
            'add_new_item' => __( 'Add New Function' ),
            'new_item_name' => __( 'New Vacature Function' ),
            'menu_name' => __( 'Functions' ),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'functions' ),
        );

        register_taxonomy('functions', array('vacature'), $args);
    }

    /**
     * Insert the categories for the taxonomies.
     */
    public static function insert_categories()
    {
        // User role categories
        if(taxonomy_exists('vacature_category')){
            wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Speler', 'hockey_vacatures'),
                    'category_description'	=> __( 'Speler categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'speler',
                    'taxonomy' 				=> 'category'
                )
            );
            wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Club', 'hockey_vacatures'),
                    'category_description'	=> __( 'Club categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'club',
                    'taxonomy' 				=> 'category'
                )
            );
        }

        // Function Categories
        if(taxonomy_exists('function')){
            $vacature_cat_id = wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Vacature', 'hockey_vacatures'),
                    'category_description'	=> __( 'Vacatures categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'vacature',
                    'taxonomy' 				=> 'category'
                )
            );
            wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Trainer vacature', 'hockey_vacatures'),
                    'category_description'	=> __( 'Trainer vacature categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'trainer-vacature',
                    'taxonomy' 				=> 'category',
                    'category_parent' 		=> $vacature_cat_id,
                )
            );
            wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Speler vacature', 'hockey_vacatures'),
                    'category_description'	=> __( 'Speler vacature categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'speler-vacature',
                    'taxonomy' 				=> 'category',
                    'category_parent' 		=> $vacature_cat_id,
                )
            );
            wp_insert_category(
                array(
                    'cat_name' 				=> __( 'Coach vacature', 'hockey_vacatures'),
                    'category_description'	=> __( 'Coach vacature categorie', 'hockey_vacatures'),
                    'category_nicename' 	=> 'coach-vacature',
                    'taxonomy' 				=> 'category',
                    'category_parent' 		=> $vacature_cat_id,
                )
            );

        }
    }

}

HV_Post_Types::init();