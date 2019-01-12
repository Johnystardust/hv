<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcodes
{

    public static function init()
    {
        $shortcodes = array(
            'hockey_vacatures_top_bar'          => __CLASS__ . '::top_bar',
            'hockey_vacatures_register_form'    => __CLASS__ . '::register_form',
            'hockey_vacatures_vacature_form'    => __CLASS__ . '::vacature_form',
            'hockey_vacatures_user_panel'       => __CLASS__ . '::user_panel',
            'hockey_vacatures_vacature_map'     => __CLASS__ . '::vacature_map',
            'hockey_vacatures_password_change'  => __CLASS__ . '::password_change_form',
            'hockey_vacatures_email_change'     => __CLASS__ . '::email_change_form'
        );

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode(apply_filters("{$shortcode}_shortcode_tag", $shortcode), $function);
        }
    }

    /**
     * Shortcode wrapper.
     *
     * @param       $function
     * @param array $atts
     * @param array $wrapper
     *
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
    )
    {
        ob_start();

        call_user_func($function, $atts);

        return ob_get_clean();
    }

    /**
     * Top bar shortcode.
     *
     * @return string
     */
    public static function top_bar($atts = array())
    {
        $shortcode = new HV_Shortcode_Top_Bar($atts);

        return $shortcode->output();

//        return self::shortcode_wrapper(array('HV_Shortcode_Top_Bar', 'output'));
    }

    /**
     * Register form shortcode.
     *
     * @return string
     */
    public static function register_form($atts = array())
    {
        $shortcode = new HV_Shortcode_Register_Form($atts);

        return $shortcode->output();
    }

    /**
     * Vacature form shortcode
     *
     * @return string
     */
    public static function vacature_form($atts = array())
    {
        $shortcode = new HV_Shortcode_Vacature_Form($atts);

        return $shortcode->output();
    }

    /**
     * User panel shortcode.
     *
     * @return string
     */
    public static function user_panel()
    {
        $shortcode = new HV_Shortcode_User_Panel();

        return $shortcode->output();
    }

    /**
     * Maps shortcode.
     *
     * @param array $atts
     */
    public static function vacature_map($atts = array())
    {
        $shortcode = new HV_Shortcode_Vacature_Map($atts);

        return $shortcode->output();
    }

    /**
     * Password change form shortcode.
     *
     * @param array $atts
     * @return mixed
     */
    public static function password_change_form($atts = array())
    {
        $shortcode = new HV_Shortcode_Password_Change($atts);

        return $shortcode->output();
    }

    /**
     * Email change form shortcode.
     *
     * @param array $atts
     * @return string
     */
    public static function email_change_form($atts = array())
    {
        $shortcode = new HV_Shortcode_Email_Change($atts);

        return $shortcode->output();
    }

}

HV_Shortcodes::init();