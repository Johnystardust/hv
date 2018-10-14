<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Admin
{

    public function __construct()
    {
        add_action('init', array($this, 'includes'));
        add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));
    }

    /**
     * Include the admin classes.
     */
    public function includes()
    {
        include_once(dirname(__FILE__) . '/class-hv-admin-menus.php');
        include_once(dirname(__FILE__) . '/class-hv-admin-meta-boxes.php');
    }

    /**
     * Load the admin scripts.
     */
    public function load_admin_scripts()
    {
        wp_enqueue_script('hv-admin', plugins_url('assets/js/hv-admin.js', HV_PLUGIN_FILE), array('jquery'), null, false);
    }
}

return new HV_Admin();