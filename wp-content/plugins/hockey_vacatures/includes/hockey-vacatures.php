<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 */
class Hockey_Vacatures {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Hockey_vacatures_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'hockey_vacatures';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_post_type_hooks();
		$this->define_widget_hooks();
		$this->define_shortcode_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Hockey_vacatures_Loader. Orchestrates the hooks of the plugin.
	 * - Hockey_vacatures_i18n. Defines internationalization functionality.
	 * - Hockey_vacatures_Admin. Defines all hooks for the admin area.
	 * - Hockey_vacatures_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/hockey-vacatures-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/hockey-vacatures-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/hockey-vacatures-post-type.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/hockey-vacatures-widgets.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/hockey-vacatures-shortcodes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/hockey-vacatures-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/hockey-vacatures-public.php';

		$this->loader = new Hockey_vacatures_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Hockey_vacatures_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Hockey_vacatures_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Hockey_vacatures_Admin( $this->get_plugin_name(), $this->get_version() );

		// Menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'edit_admin_menus', 999 );

		// Toolbar item
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'add_toolbar_links', 999 );

		// Limit user posts
		$this->loader->add_action( 'load-post-new.php', $plugin_admin, 'limit_user_posts');

		// Filter CPT Listing
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'filter_cpt_listing' );

		// Edit WP Die Handler
		$this->loader->add_action( 'wp_die_handler', $plugin_admin, 'edit_wp_die_handler' );

		// Save options page
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );

		// Enqueue
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'block_users_form_admin' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'remove_admin_bar' );


		// Add Settings Link
		$plugin_basename = plugin_basename(plugin_dir_path(__DIR__). $this->plugin_name .'.php' );
		$this->loader->add_filter( 'plugin_action_links_'. $plugin_basename, $plugin_admin, 'add_action_links' );

		// Redirect on login
		$this->loader->add_filter( 'login_redirect', $plugin_admin, 'redirect_on_login', 10, 3 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality.
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Hockey_vacatures_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Templates
		$this->loader->add_filter( 'single_template', $plugin_public, 'custom_post_type_single_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'custom_post_type_archive_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'custom_page_templates' );

		// Wp head
		$this->loader->add_action( 'wp_head', $plugin_public, 'wp_head_templates' );

		// Redirect
		$this->loader->add_filter( 'registration_redirect', $plugin_public, 'registration_redirect' );

		// Tiny mce buttons
		$this->loader->add_filter( 'mce_buttons', $plugin_public, 'edit_mce_buttons' );
	}

	/**
	 * Register all of the hooks related to the custom post type functionality.
	 * of the plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 */
	private function define_post_type_hooks(){

		$plugin_post_type = new Hockey_vacatures_Post_Type( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_post_type, 'create_custom_post_type' );
		$this->loader->add_action( 'admin_init', $plugin_post_type, 'add_meta_boxes' );
		$this->loader->add_action( 'save_post', $plugin_post_type, 'save_meta_boxes', 10, 2 );
	}

	/**
	 * Register all the hooks related to the widgets functionality.
	 *
	 * @since 	1.0.0
	 * @access 	private
	 */
	private function define_widget_hooks(){

		$plugin_widgets = new Hockey_Vacatures_Widgets( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'widgets_init', $plugin_widgets, 'load_widgets');
	}

	/**
	 * Register all the hooks related to the shortcodes functionality.
	 *
	 * @since	1.0.0
	 * @access 	private
	 */
	private function define_shortcode_hooks(){

		$plugin_shortcode = new Hockey_Vacatures_Shortcodes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_shortcode, 'register_shortcodes' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Hockey_vacatures_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
