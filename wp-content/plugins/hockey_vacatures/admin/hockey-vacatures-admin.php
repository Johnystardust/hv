<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/admin
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_vacatures_Admin {


	private $plugin_name;
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// Add the stylesheet for the color picker on the plugin options page
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hockey_vacatures-admin.css', array('wp-color-picker'), false, 'all' );

		// @todo: fix loading wrong version when using $this->version
		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hockey_vacatures-admin.css', array('wp-color-picker'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// Add the js for the media upload
		wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hockey_vacatures-admin.js', array( 'jquery', 'wp-color-picker', 'media-upload'), '', false );
		// @todo: fix loading wrong version when using $this->version
		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hockey_vacatures-admin.js', array( 'jquery', 'wp-color-picker', 'media-upload'), $this->version, false );
	}

	/**
	 * Add links to the toolbar
	 *
	 * @since	1.0.0
	 *
	 * @param $wp_admin_bar
	 */
	public function add_toolbar_links($wp_admin_bar){
		$user = wp_get_current_user();

		// For employer user role
		if(in_array( 'employer_basic', $user->roles ) || in_array( 'employer_normal', $user->roles ) || in_array( 'employer_premium', $user->roles )){
			if(!is_admin()){
				$args = array(
					'id' 	=> 'vacaturebeheer',
					'title'	=> __('Vacature beheer', $this->plugin_name),
					'href'	=> get_admin_url() . 'edit.php?post_type=vacatures',
					'meta'	=> array(
						'class' => 'vacaturebeheer',
						'title'	=> __('Vacature beheer', $this->plugin_name),
					),
				);
				$wp_admin_bar->add_node($args);
			}

			$wp_admin_bar->remove_node('site-name');
			$wp_admin_bar->remove_node('wp-logo');
			$wp_admin_bar->remove_node('my-account');
		}
	}

	/**
	 * Edit/Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function edit_admin_menus(){
		$user = wp_get_current_user();

		// For employer user role
		if(in_array( 'employer_basic', $user->roles ) || in_array( 'employer_normal', $user->roles ) || in_array( 'employer_premium', $user->roles )){
			remove_menu_page('vc-welcome');
		}

		// Add Plugin Options Page to the menu
		add_options_page( 'Hockey Vacatures Opties Setup', 'Hockey Vacatures', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
	}

	/**
	 * Limit the number of posts a user can use
	 *
	 * @since	1.0.0
	 */
//	public function limit_user_posts(){
//		if(is_admin()){
//			return;
//		}
//
//		$user 				= wp_get_current_user();
//		$user_id 			= get_current_user_id();
//
//		$user_post_count 	= get_user_meta( $user_id, 'vacature_post_counter', true );
//		$user_s_count		= get_user_meta( $user_id, 'vacature_s_counter', true ) ? '' : 1;
//
//		if($user_post_count >= $user_s_count){
//			header( 'Location: ' .get_admin_url() . 'edit.php' );
//		} else {
//			update_user_meta( $user_id, 'vacature_post_counter', $user_post_count + 1 );
//		}
//	}

	/**
	 * Edit the Wordpress Die Handler
	 *
	 * @since	1.0.0
	 *
	 * @return Closure
	 */
//	public function edit_wp_die_handler(){
//		$user = wp_get_current_user();
//
//		if(in_array( 'club', $user->roles )){
//			// If the employer has tried to save more than the allowed number of posts
//			if(false !== strpos($_SERVER['SCRIPT_NAME'], 'edit.php')){
//				return function() {
//					_default_wp_die_handler(
//						$message 	= __( 'Met het gratis account kun je maximaal 1 vacature plaatsen. Wil je meer dan 1 vacature plaatsen, upgrade dan nu je account.', $this->plugin_name ),
//						$title		= __( 'Geen Toegang', $this->plugin_name ),
//						$args		= array(
//							'back_link'	=> get_admin_url() . 'edit.php?post_type=vacatures',
//							'back_text'	=> 'Terug',
//						)
//					);
//				};
//			}
//		}
//		return '_default_wp_die_handler';
//	}

	/**
	 * Filter the posts in the admin menu to show only the users own posts
	 *
	 * @since	1.0.0
	 *
	 * @param $wp_query_obj
	 */
//	public function filter_cpt_listing($wp_query_obj){
//		$user = wp_get_current_user();
//
//		if(is_admin()){
//			if(in_array( 'employer_basic', $user->roles ) || in_array( 'employer_normal', $user->roles ) || in_array( 'employer_premium', $user->roles )){
//				$wp_query_obj->set( 'author', $user->ID );
//			}
//		}
//	}

	/**
	 * Redirects users on login to the home page instead of the admin screen.
	 *
	 * TODO: GIVE THE USER AN RESPONSE
	 *
	 * @since 	1.0.0
	 *
	 * @param $redirect_to
	 * @param $request
	 * @param $user
	 * @return string|void
	 */
	public function redirect_on_login($redirect_to, $request, $user){

		if(isset($user->roles) && is_array($user->roles)){
			if(in_array('administrator', $user->roles)){
				return $redirect_to;
			} else {
				return home_url() . '?login=true';
			}
		} else {
			return $redirect_to;
		}
	}

	/**
	 * Block the /wp-admin for all users except admins.
	 *
	 * @since	1.0.0
	 */
	public function block_users_form_admin(){
		if(is_admin() && !current_user_can( 'administrator' ) && !(defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
			wp_redirect( home_url() );
			exit;
		}
	}

	/**
	 * Hide the admin bar for all users except admins.
	 */
	public function remove_admin_bar(){
		if( !current_user_can( 'administrator' ) && !is_admin() ){
			show_admin_bar( false );
		}
	}
















	// @TODO: FIX ME!!! DO SOMETHING WITH THE OPTIONS PAGE
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ){
		$settings_link = array(
			'<a href="'. admin_url('options-general.php?page='. $this->plugin_name ) .'">'. __('Settings', $this->plugin_name) .'</a>',
		);
		return array_merge(  $settings_link, $links );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page(){
		include_once('partials/hockey_vacatures-admin-display.php');
	}

	/**
	 * Save/Update the settings page for this plugin.
	 *
	 * @since	1.0.0
     */
	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	/**
	 * Validate the settings page for this plugin
	 *
	 * @param $input
	 * @return array
	 *
	 * @since 	1.0.0l
     */
	public function validate($input) {
		// All checkboxes inputs
		$valid = array();

		// Checkboxes
		$valid['checkbox_example'] = (isset($input['checkbox_example']) && !empty($input['checkbox_example'])) ? 1 : 0;

		// Textfields
		$valid['textfield_example'] = strip_tags($input['textfield_example']);

		// Img Upload Id
		// We use the Id because it is the easiest to sanitize, it needs to be a number
		$valid['image_example_id'] = (isset($input['image_example_id']) && !empty($input['image_example_id'])) ? absint($input['image_example_id']) : 0;

		// Colorpicker
		$valid['colorpicker_example'] = (isset($input['colorpicker_example']) && !empty($input['colorpicker_example'])) ? sanitize_text_field($input['colorpicker_example']) : '';
		if(!empty($valid['colorpicker_example']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['colorpicker_example']  ) ) { // if user insert a HEX color with #
			add_settings_error(
				'colorpicker_example',
				'colorpicker_example_texterror',
				'Please enter a valid hex value color',
				'error'
			);
		}

		return $valid;
	}


}
