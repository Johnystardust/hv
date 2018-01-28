<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Hockey_Vacatures {

    public $version = '1.0.0';

    protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();

        do_action( 'hockey_vacatures_loaded' );
    }

    private function init_hooks(){
        register_activation_hook( HV_PLUGIN_FILE, array( 'HV_Install', 'install' ) );
    }

    /**
     * Define HV Constants.
     */
    private function define_constants() {
        $upload_dir = wp_upload_dir( null, false );

        $this->define( 'HV_ABSPATH', dirname( HV_PLUGIN_FILE ) . '/' );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {

        // Include the classes
        // =============================================================================================================

        // Autoload
        include_once( HV_ABSPATH . 'includes/class-hv-autoloader.php' );

        // Abstracts
        include_once( HV_ABSPATH . 'includes/abstracts/abstract-hv-data.php' );

        // Core Classes
        include_once( HV_ABSPATH . 'includes/hv-core-functions.php' );
        include_once( HV_ABSPATH . 'includes/class-hv-post-types.php' );
        include_once( HV_ABSPATH . 'includes/class-hv-install.php' );

        // Include Classes by request
        // =============================================================================================================

        // Include the admin class
        if ( $this->is_request( 'admin' ) ) {
            include_once( HV_ABSPATH . 'includes/admin/class-hv-admin.php' );
        }

        // Include the frontend classes
        if ( $this->is_request( 'frontend' ) ) {
            $this->frontend_includes();
        }

        // TODO: ??? IMPLEMENT SESSIONS ???
//        if ( $this->is_request( 'frontend' ) || $this->is_request( 'cron' ) ) {
//            include_once( HV_ABSPATH . 'includes/class-wc-session-handler.php' );
//        }

//        $this->query = new WC_Query();
//        $this->api   = new WC_API();
    }

    /**
     * Include required frontend files.
     */
    public function frontend_includes() {
        include_once( HV_ABSPATH . 'includes/class-hv-template-loader.php' );
        include_once( HV_ABSPATH . 'includes/class-hv-frontend-scripts.php' );
        include_once( HV_ABSPATH . 'includes/class-hv-forms-helper.php' );
        include_once( HV_ABSPATH . 'includes/class-hv-shortcodes.php' );
    }

    /**
     * What type of request is this?
     *
     * @param $type
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( HV_PLUGIN_FILE ) );
    }

}