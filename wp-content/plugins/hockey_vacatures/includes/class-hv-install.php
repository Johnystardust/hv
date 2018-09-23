<?php

if( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class HV_Install
 */
class HV_Install
{

    /**
     * Initialize
     */
    public static function init()
    {
        add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
    }

    /**
     * Check the version of the plugin
     */
    public static function check_version()
    {
        if( get_option( 'hockey_vacatures_version' ) !== HV()->version ) {
            self::install();
            add_option( 'hockey_vacatures_version', HV()->version );
            do_action( 'hockey_vacatures_updated' );
        }
    }

    /**
     * The method that runs on plugin activation.
     */
    public static function install()
    {
        self::create_roles();
        self::register_pages();
    }

    /**
     * Create the user roles
     */
    private static function create_roles()
    {
        global $wp_roles;

        if( !class_exists( 'WP_Roles' ) ) {
            return;
        }

        if( !isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        // Add the new roles
        //
        // These roles correspond with the types of roles that can be registered in the registration form
        // =============================================================================================================

        /*
         * The business role is for the clubs and enterprises that want to create an account with their
         * company information.
         */
        add_role(
            'business',
            __( 'Club/Onderneming', 'hockey_vacatures' ),
            array(
                // Post/Page
                'read'                       => false,
                'edit_posts'                 => false,
                'edit_pages'                 => false,
                'edit_others_posts'          => false,
                'create_posts'               => false,
                'publish_posts'              => false,
                'delete_posts'               => false,

                // Vacatures
                'create_vacatures'           => true,
                'read_vacatures'             => true,
                'read_private_vacatures'     => true,
                'edit_others_vacatures'      => false,
                'edit_private_vacatures'     => true,
                'edit_published_vacatures'   => true,
                'edit_vacatures'             => true,
                'delete_others_vacatures'    => false,
                'delete_private_vacatures'   => true,
                'delete_published_vacatures' => true,
                'delete_vacatures'           => true,
                'publish_vacatures'          => true,

                // Theme functionality
                'edit_themes'                => false,
                'install_plugins'            => false,
                'update_plugin'              => false,
                'update_core'                => false,
                'list_users'                 => false,
                'manage_categories'          => false,
                'manage_links'               => false,
                'moderate_comments'          => false,
                'upload_files'               => false,
                'export'                     => false,
                'import'                     => false,
            )
        );

        /*
         * Person role, the person role is for normal people who want to register but are not affiliated to a
         * club or enterprise
         */
        add_role(
            'person',
            __( 'Persoon', 'hockey_vacatures' ),
            array(
                // Post/Page
                'read'                       => false,
                'edit_posts'                 => false,
                'edit_pages'                 => false,
                'edit_others_posts'          => false,
                'create_posts'               => false,
                'publish_posts'              => false,
                'delete_posts'               => false,

                // Vacatures
                'create_vacatures'           => true,
                'read_vacatures'             => true,
                'read_private_vacatures'     => true,
                'edit_others_vacatures'      => false,
                'edit_private_vacatures'     => true,
                'edit_published_vacatures'   => true,
                'edit_vacatures'             => true,
                'delete_others_vacatures'    => false,
                'delete_private_vacatures'   => true,
                'delete_published_vacatures' => true,
                'delete_vacatures'           => true,
                'publish_vacatures'          => true,

                // Theme functionality
                'edit_themes'                => false,
                'install_plugins'            => false,
                'update_plugin'              => false,
                'update_core'                => false,
                'list_users'                 => false,
                'manage_categories'          => false,
                'manage_links'               => false,
                'moderate_comments'          => false,
                'upload_files'               => false,
                'export'                     => false,
                'import'                     => false,
            )
        );

        /*
         * Vacature manager role, this is a additional role for a user who can edit/monitor other posts in the backend.
         */
        add_role(
            'vacature_manager',
            __( 'Vacature Manager', 'hockey_vacatures' ),
            array(
                // Post/Page
                'read'                       => false,
                'edit_posts'                 => false,
                'edit_pages'                 => false,
                'edit_others_posts'          => false,
                'create_posts'               => false,
                'publish_posts'              => false,
                'delete_posts'               => false,

                // Vacatures
                'create_vacatures'           => true,
                'read_vacatures'             => true,
                'read_private_vacatures'     => true,
                'edit_others_vacatures'      => true,
                'edit_private_vacatures'     => true,
                'edit_published_vacatures'   => true,
                'edit_vacatures'             => true,
                'delete_others_vacatures'    => true,
                'delete_private_vacatures'   => true,
                'delete_published_vacatures' => true,
                'delete_vacatures'           => true,
                'publish_vacatures'          => true,

                // Theme functionality
                'edit_themes'                => false,
                'install_plugins'            => false,
                'update_plugin'              => false,
                'update_core'                => false,
                'list_users'                 => true,
                'manage_categories'          => true,
                'manage_links'               => true,
                'moderate_comments'          => true,
                'upload_files'               => true,
                'export'                     => true,
                'import'                     => false,
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

        foreach( $new_caps as $cap ) {
            $wp_roles->add_cap( 'vacature_manager', $cap );
            $wp_roles->add_cap( 'administrator', $cap );
        }
    }

    /**
     * Register the needed pages on activation
     */
    private static function register_pages()
    {
        $post_ids = array();
        $pages = array(
            'Registreren',
            'Profiel Bewerken',
            'Nieuwe Vacature',
            'Bewerk Vacature',
        );

        foreach( $pages as $page ) {
            $title_check = get_page_by_title( $page );
            $slug_check = get_page_by_path( strtolower( $page ) );

            $post_data = array(
                'post_type'   => 'page',
                'post_title'  => $page,
                'post_status' => 'publish',
                'post_author' => 1
            );

            if( !isset( $title_check->ID ) && !isset( $slug_check ) ) {
                $post_ids[] = wp_insert_post( $post_data );

            } else {
                deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );

                foreach( $post_ids as $id ) {
                    wp_delete_post( $id, true );
                }

                wp_die( __( $page . ' pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures' ) );
            }
        }
    }

}

HV_Install::init();