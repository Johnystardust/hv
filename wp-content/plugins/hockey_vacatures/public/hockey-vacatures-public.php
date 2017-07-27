<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public
 * @author     Tim van der Slik <info@timvanderslik.nl>
 */
class Hockey_vacatures_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// @TODO: FIX: loading wrong version when using $this->version
		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hockey_vacatures-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hockey_vacatures-public.css', array(), '', 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_scripts() {
		// TODO: FIX: loading wrong version when using $this->version
		// TODO: FIX: Dependency with theme file
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hockey_vacatures-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hockey_vacatures-public.js', array( 'jquery-cdn' ), null, true );

		wp_enqueue_script( 'jquery-validate', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js', array( 'jquery-cdn' ), null, true );
//		wp_enqueue_script( 'jquery-validate-am', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js', array( 'jquery-cdn', 'jquery-validate' ), null, true );
	}

	/**
	 * Register the single template for the custom post types
	 *
	 * @since	1.0.0
	 *
	 * @param $single
	 * @return string
	 */
	public function custom_post_type_single_template($single){
		global $wp_query, $post;
		$theme_files = array('single-vacatures.php');
		$exists_in_theme = locate_template($theme_files, false);

		if($post->post_type == 'vacatures'){
			if($exists_in_theme == ''){
				return plugin_dir_path( __FILE__ ) . 'partials/hockey_vacatures-single-template.php';
			}
		}
		return $single;
	}

	/**
	 * Register the archive template for the custom post types.
	 * The template can be overwritten by placing 'archive-{custom-post-type}.php' in the theme folder.
	 *
	 * @since	1.0.0
	 *
	 * @param $template
	 * @return string
	 */
	public function custom_post_type_archive_template($template){
		$theme_files = array('archive-vacatures.php');
		$exists_in_theme = locate_template($theme_files, false);

		if(is_post_type_archive('vacatures')){
			if($exists_in_theme == ''){
				return plugin_dir_path( __FILE__ ) . 'partials/hockey_vacatures-archive-template.php';
			}
		}
		return $template;
	}

	/**
	 * Register the registration page.
	 * The template can be overwritten by placing 'page-register.php' in the theme folder.
	 *
	 * @since	1.0.0
	 */
	public function custom_page_templates($template){
		$theme_files = array('page-register.php');
		$exists_in_theme = locate_template($theme_files, false);

		if(is_page('registreren')){
			if($exists_in_theme == ''){
				$template = plugin_dir_path( __FILE__ ) . 'partials/hockey_vacatures-register-template.php';
			}
		}
		elseif(is_page('tegoed')){
			$template = plugin_dir_path( __FILE__ ) . 'partials/hockey_vacatures-sale-template.php';
		}
		return $template;
	}

	/**
	 * Register the my account side panel
	 *
	 * TODO: FIX ME !!!!
	 *
	 * @since	1.0.0
	 */
	public function wp_head_templates(){
		echo '<div id="hv-messages"></div>';
		include_once(plugin_dir_path( __FILE__ ) . 'partials/hockey_vacatures-side-panel.php');
	}
}
