<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Template_Loader {

    public static function init(){
        add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
    }

    /**
     * Loads the template.
     *
     * @param $template
     * @return string
     */
    public static function template_loader( $template ){
        if( is_embed() ){
            return $template;
        }

        if ( $default_template = self::get_default_template_file() ){
            $template = HV()->plugin_path() . '/templates/' . $default_template;
        }

        return $template;
    }

    /**
     * Get the default template file.
     *
     * // TODO: REDIRECT TO 404 OR FORBIDDEN IF THE USER IS NOT LOGGED IN ON PAGES WHERE THIS IS REQUIRED
     *
     * @return string
     */
    private static function get_default_template_file(){
        if( is_singular( 'vacature' ) ) {
            $default_file = 'single-vacature.php';
        }
        elseif( is_page( 'nieuwe-vacature' ) ) {
            if(is_user_logged_in()){
                $default_file = 'vacature-form-page.php';
            } else {
                wp_die(__('You need to be logged in to create a new vacature.', 'hockey_vacatures'));
            }
        }
        elseif( is_page( 'bewerk-vacature' ) ) {
            if(!isset($_GET['id'])){
                wp_die(__('Vacature not found.', 'hockey_vacatures'));
            }

            $post = get_post((int)$_GET['id']);

            if(is_user_logged_in() && $post->post_author == get_current_user_id()){
                $default_file = 'vacature-form-page.php';
            } else {
                wp_die(__('You are trying to edit someone else post. You naughty!', 'hockey_vacatures'));
            }
        }
        elseif( is_page( 'registreren' ) ) {
            $default_file = 'register-page.php';
        }
        elseif( is_page( 'profiel-bewerken' ) ) {
            if(is_user_logged_in() && (int)$_GET['id'] == get_current_user_id()){
                $default_file = 'register-page.php';
            } else {
                wp_die(__('You need to be logged in to edit your profile.', 'hockey_vacatures'));
            }
        }
        elseif( is_post_type_archive( 'vacature' ) ) {
            $default_file = 'archive-vacature.php';
        }

        else {
            $default_file = '';
        }
        return $default_file;
    }
}
HV_Template_Loader::init();