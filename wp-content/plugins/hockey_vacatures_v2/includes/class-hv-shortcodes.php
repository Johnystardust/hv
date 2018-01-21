<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Shortcodes {

    public static function init(){
        $shortcodes = array(
            'hockey_vacatures_top_bar'          => __CLASS__ . '::top_bar',
            'hockey_vacatures_register_form'    => __CLASS__ . '::register_form'
        );

        foreach ( $shortcodes as $shortcode => $function ) {
            add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
        }
    }

    /**
     * Shortcode wrapper.
     *
     * @param $function
     * @param array $atts
     * @param array $wrapper
     * @return string
     */
    public static function shortcode_wrapper(
        $function,
        $atts = array(),
        $wrapper = array(
            'class' => 'hockey-vacatures',
            'before' => null,
            'after' => null,
        )
    ){
        ob_start();

        call_user_func( $function, $atts );

        return ob_get_clean();
    }

    /**
     * Top bar shortcode.
     *
     * @return string
     */
    public static function top_bar(){
        return self::shortcode_wrapper( array( 'HV_Shortcode_Top_Bar', 'output' ) );
    }

    /**
     * Register form shortcode
     *
     * @return string
     */
    public static function register_form(){
        return self::shortcode_wrapper( array( 'HV_Shortcode_Register_Form', 'output' ) );
    }
}
HV_Shortcodes::init();