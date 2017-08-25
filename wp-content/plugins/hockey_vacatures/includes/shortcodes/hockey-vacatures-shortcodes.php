<?php
/**
 * The shortcode-specific functionality of the plugin.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Shortcodes {

    private $plugin_name;
    private $version;

    private $register_form;
    private $sale_form;
    private $top_bar;
    private $new_vacature_form;

    // @TODO: FIX NEW SHORTCODE WAY IF POSSIBLE

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

        $this->register_form        = new Hockey_Vacatures_Register_Form();
        $this->sale_form            = new Hockey_Vacatures_Sale_Form();
        $this->top_bar              = new Hockey_Vacatures_Top_Bar();
        $this->new_vacature_form    = new Hockey_Vacatures_New_Vacature_Form();
    }

    /**
     * Load the required dependencies for the shortcodes.
     *
     * @since   1.0.0
     */
    private function load_dependencies(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/hockey-vacatures-register-form.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/hockey-vacatures-sale-form.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/hockey-vacatures-top-bar.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/hockey-vacatures-new-vacature-form.php';
    }

    /**
     * Register the shortcodes
     *
     * @since   1.0.0
     */
    public function register_shortcodes(){
        add_shortcode( 'hockey_vacatures_register_form', array($this->register_form, 'register_form_shortcode') );
        add_shortcode( 'hockey_vacatures_sale_form', array($this->sale_form, 'sale_form_shortcode') );
        add_shortcode( 'hockey_vacatures_top_bar', array($this->top_bar, 'top_bar_shortcode') );
        add_shortcode( 'hockey_vacatures_vacature_form', array($this->new_vacature_form, 'new_vacature_form_shortcode'));
    }
}