<?php
/**
 * The widget-specific functionality of the plugin.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Widgets {
    private $plugin_name;
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name   The name of this plugin.
     * @param      string    $version       The version of this plugin.
     */
    public function __construct( $plugin_name, $version ){
        $this->plugin_name  = $plugin_name;
        $this->version      = $version;

        $this->load_dependencies();
    }

    /**
     * Load the required dependencies for the widgets.
     *
     * @since   1.0.0
     */
    private function load_dependencies(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/hockey-vacatures-register-widget.php';
    }

    /**
     * Registers all the widgets.
     *
     * @since   1.0.0
     */
    public function load_widgets(){
        new Hockey_Vacatures_Register_Widget();
        register_widget( 'Hockey_Vacatures_Register_Widget' );
    }

}