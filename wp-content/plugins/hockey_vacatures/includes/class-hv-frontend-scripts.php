<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class HV_Frontend_Scripts
{

    public static function init()
    {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'load_scripts'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'load_styles'));
    }

    /**
     * Load the Scripts
     *
     * TODO: FIX Local jquery validate function
     */
    public static function load_scripts()
    {
        wp_enqueue_script('hv-public', self::get_assets_url('assets/js/hv-public.js'), array('jquery'), null, false);
        wp_localize_script('hv-public', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'we_value' => 1234));

        if (is_page('registreren') || is_page('profiel-bewerken') || is_page('wachtwoord-wijzigen') || is_page('email-wijzigen')) {
            wp_enqueue_script('jquery-validate', self::get_assets_url('assets/js/jquery.validate.min.js'), array('jquery'), null, true);
            wp_enqueue_script('hv-forms', self::get_assets_url('assets/js/hv-forms.js'), array('jquery'), null, true);
        }
    }

    /**
     * Load the styles.
     */
    public static function load_styles()
    {
        wp_enqueue_style('hv-styles', self::get_assets_url('assets/css/hockey_vacatures-public.css'), array(), null, 'all');
    }

    /**
     * Get the assets url.
     *
     * @param $path
     *
     * @return string
     */
    private static function get_assets_url($path)
    {
        return plugins_url($path, HV_PLUGIN_FILE);
    }
}

HV_Frontend_Scripts::init();