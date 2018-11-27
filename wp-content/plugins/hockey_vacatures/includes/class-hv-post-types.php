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
        add_action('init', array(__CLASS__, 'register_post_status'), 1);
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

        // Vacature Post Type
        // =============================================================================================================

        // Post type settings
        $delete_with_user = false;

        // TODO: Create backend option for this.
        if ('yes' === get_option('hv_delete_posts_with_user', 'yes')) {
            $delete_with_user = true;
        }

        register_post_type('vacature',
            array(
                'labels'              => array(
                    'name'               => _x('Vacature', 'Post Type General Name', 'hockey_vacatures'),
                    'singular_name'      => _x('Vacature', 'Post Type Singular Name', 'hockey_vacatures'),
                    'menu_name'          => __('Vacatures', 'hockey_vacatures'),
                    'parent_item_colon'  => __('Parent Vacature', 'hockey_vacatures'),
                    'all_items'          => __('Alle vacatures', 'hockey_vacatures'),
                    'view_item'          => __('View Vacature ', 'hockey_vacatures'),
                    'add_new_item'       => __('Nieuwe vacature toevoegen', 'hockey_vacatures'),
                    'add_new'            => __('Nieuwe vacature', 'hockey_vacatures'),
                    'edit_item'          => __('Vacature bewerken', 'hockey_vacatures'),
                    'update_item'        => __('Update vacature', 'hockey_vacatures'),
                    'search_items'       => __('Zoek Vacature', 'hockey_vacatures'),
                    'not_found'          => __('Not Found', 'hockey_vacatures'),
                    'not_found_in_trash' => __('Not found in Trash', 'hockey_vacatures'),
                ),
                'description'         => __('Post type for Vacatures.', 'hockey_vacatures'),
                'public'              => true,
                'publicly_queryable'  => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'query_var'           => true,
                'rewrite'             => array('slug' => 'vacatures'),
                'capability_type'     => 'post',
                'has_archive'         => true,
                'hierarchical'        => false,
                'menu_position'       => 50,
                'supports'            => array('title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies'          => array('vacature'),
                'can_export'          => true,
                'exclude_from_search' => false,
                'map_meta_cap'        => true,
                'delete_with_user'    => $delete_with_user,
                'menu_icon'           => 'dashicons-id-alt',
            )
        );

        // Order Post Type
        // =============================================================================================================
        register_post_type('hv_order',
            array(
                'labels'              => array(
                    'name'               => _x('Orders', 'Post Type General Name', 'hockey_vacatures'),
                    'singular_name'      => _x('Order', 'Post Type Singular Name', 'hockey_vacatures'),
                    'menu_name'          => __('Orders', 'hockey_vacatures'),
                    'parent_item_colon'  => __('Parent Order', 'hockey_vacatures'),
                    'all_items'          => __('Alle Orders', 'hockey_vacatures'),
                    'view_item'          => __('View Order ', 'hockey_vacatures'),
                    'add_new_item'       => __('Add New Order', 'hockey_vacatures'),
                    'add_new'            => __('Add New', 'hockey_vacatures'),
                    'edit_item'          => __('Edit Order', 'hockey_vacatures'),
                    'update_item'        => __('Update Order', 'hockey_vacatures'),
                    'search_items'       => __('Search Order', 'hockey_vacatures'),
                    'not_found'          => __('Not Found', 'hockey_vacatures'),
                    'not_found_in_trash' => __('Not found in Trash', 'hockey_vacatures'),
                ),
                'description'         => __('Post type for Orders.', 'hockey_vacatures'),
                'public'              => true,
                'publicly_queryable'  => true,
                'show_ui'             => true,
                'show_in_menu'        => 'hockey_vacatures',
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'query_var'           => true,
                'capability_type'     => 'post',
                'has_archive'         => true,
                'hierarchical'        => false,
                'menu_position'       => 50,
                'supports'            => array('title', 'editor', 'excerpt', 'thumbnail'),
                'taxonomies'          => array('category'),
                'can_export'          => true,
                'exclude_from_search' => false,
                'map_meta_cap'        => true,
                'delete_with_user'    => false,
                'menu_icon'           => 'dashicons-location-alt',
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
                'label'             => __('Vacature Categorieën', 'hockey_vacatures'),
                'show_tagcloud'     => false,
                'show_admin_column' => true,
                'hierarchical'      => true,
                'rewrite'           => array('vacature_category')
            )
        );
    }

    /**
     * Insert the categories for the taxonomies.
     */
    public static function insert_categories()
    {
        // User role categories
        if (taxonomy_exists('vacature_category')) {
            wp_insert_category(
                array(
                    'cat_name'             => __('Speler', 'hockey_vacatures'),
                    'category_description' => __('Speler categorie', 'hockey_vacatures'),
                    'category_nicename'    => 'speler',
                    'taxonomy'             => 'vacature_category'
                )
            );
            wp_insert_category(
                array(
                    'cat_name'             => __('Club', 'hockey_vacatures'),
                    'category_description' => __('Club categorie', 'hockey_vacatures'),
                    'category_nicename'    => 'club',
                    'taxonomy'             => 'vacature_category'
                )
            );
            wp_insert_category(
                array(
                    'cat_name'             => __('Coach', 'hockey_vacatures'),
                    'category_description' => __('Coach categorie', 'hockey_vacatures'),
                    'category_nicename'    => 'coach',
                    'taxonomy'             => 'vacature_category'
                )
            );
            wp_insert_category(
                array(
                    'cat_name'             => __('Trainer', 'hockey_vacatures'),
                    'category_description' => __('Trainer categorie', 'hockey_vacatures'),
                    'category_nicename'    => 'trainer',
                    'taxonomy'             => 'vacature_category'
                )
            );
        }
    }

    /**
     * Register the post states
     *
     * TODO: Make the status available to be changed in the backend.
     *
     *
     * - Post status: Flagged
     */
    public static function register_post_status()
    {
        $args = array(
            'label'                     => __('Flagged', 'hockey_vacatures'),
            'public'                    => false,
            'internal'                  => false,
            'private'                   => true,
            'exclude_from_search'       => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Flagged <span class="count">(%s)</span>', 'Flagged <span class="count">(%s)</span>'),
        );

        register_post_status('flagged', $args);


        // TODO: FIX WITH PENDING POST STATUS
        $args = array(
            'label'       => __('In Review', 'hockey_vacatures'),
            'exclude_from_search' => null,
            'public' => null,
            'internal' => null,
            'protected' => null,
            'private' => true,
            'publicly_queryable' => null,
            'show_in_admin_status_list' => null,
            'show_in_admin_all_list' => null,
            'label_count' => _n_noop('Review <span class="count">(%s)</span>', 'Reviews <span class="count">(%s)</span>'),
        );

        register_post_status('review', $args);

    }
}

HV_Post_Types::init();