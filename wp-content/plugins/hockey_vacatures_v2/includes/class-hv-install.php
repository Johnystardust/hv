<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Install {

    public static function init(){
        add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
    }

    public static function check_version(){
        if( get_option( 'hockey_vacatures_version' ) !== HV()->version ){
            self::install();
            add_option( 'hockey_vacatures_version', HV()->version );
            do_action( 'hockey_vacatures_updated' );
        }
    }

    public static function install(){

        // Check if we are not running this route
        if( 'yes' == get_transient( 'hv_installing' ) ) {
            return;
        }

        // If the transient is not set lets set it now.
        set_transient( 'hv_installing', 'yes', MINUTE_IN_SECONDS * 10 );
        hv_maybe_define_constant( 'HV_INSTALLING', true );

        // Run the installers
        self::create_roles();
        self::create_taxonomies();
        self::register_pages();

        delete_transient( 'hv_installing' );
    }

    private static function create_roles(){
        global $wp_roles;

        if( ! class_exists( 'WP_Roles' ) ) {
            return;
        }

        if( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        // Add the new roles
        // =============================================================================================================

        // Club Role
        add_role(
            'club',
            __( 'Club', 'hockey_vacatures'),
            array(
                // Post/Page
                'read'							=> false,
                'edit_posts'					=> false,
                'edit_pages'					=> false,
                'edit_others_posts'				=> false,
                'create_posts'					=> false,
                'publish_posts'					=> false,
                'delete_posts'					=> false,

                // Vacatures
                'create_vacatures'				=> true,
                'read_vacatures'				=> true,
                'read_private_vacatures'		=> true,
                'edit_others_vacatures'			=> false,
                'edit_private_vacatures'		=> true,
                'edit_published_vacatures'		=> true,
                'edit_vacatures'				=> true,
                'delete_others_vacatures'		=> false,
                'delete_private_vacatures'		=> true,
                'delete_published_vacatures'	=> true,
                'delete_vacatures'				=> true,
                'publish_vacatures'				=> true,

                // Theme functionality
                'edit_themes'					=> false,
                'install_plugins'				=> false,
                'update_plugin'					=> false,
                'update_core'					=> false,
                'list_users'                    => false,
                'manage_categories'             => false,
                'manage_links'                  => false,
                'moderate_comments'             => false,
                'upload_files'                  => false,
                'export'                        => false,
                'import'                        => false,
            )
        );

        // Player Role
        add_role(
            'player',
            __( 'Speler', 'hockey_vacatures' ),
            array(
                // Post/Page
                'read'							=> false,
                'edit_posts'					=> false,
                'edit_pages'					=> false,
                'edit_others_posts'				=> false,
                'create_posts'					=> false,
                'publish_posts'					=> false,
                'delete_posts'					=> false,

                // Vacatures
                'create_vacatures'				=> true,
                'read_vacatures'				=> true,
                'read_private_vacatures'		=> true,
                'edit_others_vacatures'			=> false,
                'edit_private_vacatures'		=> true,
                'edit_published_vacatures'		=> true,
                'edit_vacatures'				=> true,
                'delete_others_vacatures'		=> false,
                'delete_private_vacatures'		=> true,
                'delete_published_vacatures'	=> true,
                'delete_vacatures'				=> true,
                'publish_vacatures'				=> true,

                // Theme functionality
                'edit_themes'					=> false,
                'install_plugins'				=> false,
                'update_plugin'					=> false,
                'update_core'					=> false,
                'list_users'                    => false,
                'manage_categories'             => false,
                'manage_links'                  => false,
                'moderate_comments'             => false,
                'upload_files'                  => false,
                'export'                        => false,
                'import'                        => false,
            )
        );

        // TODO: ADD MORE USER ROLES
        // Trainer
        // Coach

        // Vacature Manager Role
        add_role(
            'vacature_manager',
            __( 'Vacature Manager', 'hockey_vacatures' ),
            array(
                // Post/Page
                'read'							=> false,
                'edit_posts'					=> false,
                'edit_pages'					=> false,
                'edit_others_posts'				=> false,
                'create_posts'					=> false,
                'publish_posts'					=> false,
                'delete_posts'					=> false,

                // Vacatures
                'create_vacatures'				=> true,
                'read_vacatures'				=> true,
                'read_private_vacatures'		=> true,
                'edit_others_vacatures'			=> true,
                'edit_private_vacatures'		=> true,
                'edit_published_vacatures'		=> true,
                'edit_vacatures'				=> true,
                'delete_others_vacatures'		=> true,
                'delete_private_vacatures'		=> true,
                'delete_published_vacatures'	=> true,
                'delete_vacatures'				=> true,
                'publish_vacatures'				=> true,

                // Theme functionality
                'edit_themes'					=> false,
                'install_plugins'				=> false,
                'update_plugin'					=> false,
                'update_core'					=> false,
                'list_users'                    => true,
                'manage_categories'             => true,
                'manage_links'                  => true,
                'moderate_comments'             => true,
                'upload_files'                  => true,
                'export'                        => true,
                'import'                        => false,
            )
        );

        // Add all vacature capabilities to the Administrators and Vacature Managers
        $new_caps = array(
            'create_vacatures',
            'read_vacatures',
            'read_private_vacatures',
            'edit_others_vacatures',
            'edit_private_vacatures',
            'edit_published_vacatures',
            'edit_vacatures',
            'delete_others_vacatures',
            'delete_private_vacatures',
            'delete_published_vacatures',
            'delete_vacatures',
            'publish_vacatures',
            'manage_hockey_vacatures',
        );

        foreach( $new_caps as $cap ){
            $wp_roles->add_cap( 'vacature_manager', $cap );
            $wp_roles->add_cap( 'administrator', $cap );
        }
    }

    private static function create_taxonomies(){
        // TODO: FIX TAXONOMIES
//        // User role categories
//        wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Speler', 'hockey_vacatures'),
//                'category_description'	=> __( 'Speler categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'speler',
//                'taxonomy' 				=> 'category'
//            )
//        );
//        wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Club', 'hockey_vacatures'),
//                'category_description'	=> __( 'Club categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'club',
//                'taxonomy' 				=> 'category'
//            )
//        );
//
//        // Vacature categories
//        $vacature_cat_id = wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Vacature', 'hockey_vacatures'),
//                'category_description'	=> __( 'Vacatures categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'vacature',
//                'taxonomy' 				=> 'category'
//            )
//        );
//        wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Trainer vacature', 'hockey_vacatures'),
//                'category_description'	=> __( 'Trainer vacature categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'trainer-vacature',
//                'taxonomy' 				=> 'category',
//                'category_parent' 		=> $vacature_cat_id,
//            )
//        );
//        wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Speler vacature', 'hockey_vacatures'),
//                'category_description'	=> __( 'Speler vacature categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'speler-vacature',
//                'taxonomy' 				=> 'category',
//                'category_parent' 		=> $vacature_cat_id,
//            )
//        );
//        wp_insert_category(
//            array(
//                'cat_name' 				=> __( 'Coach vacature', 'hockey_vacatures'),
//                'category_description'	=> __( 'Coach vacature categorie', 'hockey_vacatures'),
//                'category_nicename' 	=> 'coach-vacature',
//                'taxonomy' 				=> 'category',
//                'category_parent' 		=> $vacature_cat_id,
//            )
//        );
    }

    private static function register_pages(){

        // Register Page
        $register_page_title 	= 'Registreren';
        $register_page_check	= get_page_by_title($register_page_title);
        $register_page 			= array(
            'post_type' 	=> 'page',
            'post_title' 	=> $register_page_title,
            'post_status'	=> 'publish',
            'post_author'	=> 1,
        );

        $register_page_slug = get_page_by_path('registreren', OBJECT);
        if(!isset($register_page_slug) && !isset($register_page_check->ID)){
            $register_page_id = wp_insert_post($register_page);
        } else {
            deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );
            wp_die( __('Registratie pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures') );
        }

        // Vacature Create Page
        $vacature_create_page_title = 'Nieuwe Vacature';
        $vacature_create_page_check = get_page_by_title($vacature_create_page_title);
        $vacature_create_page 		= array(
            'post_type'		=> 'page',
            'post_title' 	=> $vacature_create_page_title,
            'post_status'	=> 'publish',
            'post_author'	=> 1,
        );

        $vacature_create_page_slug = get_page_by_path( 'nieuwe_vacature', OBJECT );
        if(!isset($vacature_create_page_slug) && !isset($vacature_create_page_check->ID)){
            $vacature_create_page_id = wp_insert_post($vacature_create_page);
        } else {
            wp_delete_post($register_page_id);
            deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );
            wp_die( __('Nieuwe Vacature pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures') );
        }
    }

}

HV_Install::init();