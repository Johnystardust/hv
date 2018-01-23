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
     * @return string
     */
    private static function get_default_template_file(){
        if( is_singular( 'vacature' ) ) {
            $default_file = 'single-vacature.php';
        }
        elseif( is_page( 'nieuwe-vacature' ) ) {
            $default_file = 'vacature-form-page.php';
        }
        elseif( is_page( 'registreren' ) ) {
            $default_file = 'register-page.php';
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