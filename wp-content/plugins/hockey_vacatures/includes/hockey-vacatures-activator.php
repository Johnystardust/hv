<?php

/**
 * Fired during plugin activation
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 */
class Hockey_Vacatures_Activator {

	/**
	 * Create pages on plugin activate
	 *
	 * @since	1.0.0
	 */
	public static function register_pages(){

		// Register Page
		// =============
		$register_page_title 	= 'Registreren';
		$register_page_check	= get_page_by_title($register_page_title);
		$register_page 			= array(
			'post_type' 	=> 'page',
			'post_title' 	=> $register_page_title,
			'post_status'	=> 'publish',
			'post_author'	=> 1,
		);

		$register_page_slug = get_page_by_path('registreren', OBJECT);
		if(!isset($register_page_slug) && !isset($register_page_check->ID)){
			$register_page_id = wp_insert_post($register_page);
		} else {
			deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );
			wp_die( __('Registratie pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures') );
		}

		// Sale Page
		// =========
		$sale_page_title		= 'Tegoed';
		$sale_page_check		= get_page_by_title($sale_page_title);
		$sale_page				= array(
			'post_type'		=> 'page',
			'post_title'	=> $sale_page_title,
			'post_status'	=> 'publish',
			'post_author'	=> 1,
		);

		$sale_page_slug = get_page_by_path( 'tegoed', OBJECT );
		if(!isset($sale_page_slug) && !isset($sale_page_check->ID)){
			$sale_page_id = wp_insert_post($sale_page);
		} else {
			wp_delete_post($register_page_id);
			deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );
			wp_die( __('Tegoed pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures') );
		}

		// Vacature Create Page
		// ====================
		$vacature_create_page_title = 'Nieuwe Vacature';
		$vacature_create_page_check = get_page_by_title($vacature_create_page_title);
		$vacature_create_page 		= array(
			'post_type'		=> 'page',
			'post_title' 	=> $vacature_create_page_title,
			'post_status'	=> 'publish',
			'post_author'	=> 1,
		);

		$vacature_create_page_slug = get_page_by_path( 'nieuwe_vacature', OBJECT );
		if(!isset($vacature_create_page_slug) && !isset($vacature_create_page_check->ID)){
			$vacature_create_page_id = wp_insert_post($vacature_create_page);
		} else {
			wp_delete_post($register_page_id);
			wp_delete_post($sale_page_id);
			deactivate_plugins( plugin_basename( 'hockey_vacatures' ) );
			wp_die( __('Nieuwe Vacature pagina bestaat al. Los het probleem op en activeer de plugin opnieuw', 'hockey_vacatures') );
		}
	}

	/**
	 * Register/Edit the user roles
	 *
	 * @since	1.0.0
	 */
	public static function register_user_roles(){

		// Edit the admin user role
		// ========================
		$role = get_role('administrator');
		$new_caps = array(
			'create_vacatures',
			'read_vacatures',
			'read_private_vacatures',
			'edit_others_vacatures',
			'edit_private_vacatures',
			'edit_published_vacatures',
			'edit_vacatures',
			'delete_others_vacatures',
			'delete_private_vacatures',
			'delete_published_vacatures',
			'delete_vacatures',
			'publish_vacatures',
		);
		foreach($new_caps as $cap){
			$role->add_cap($cap);
		}

		// Club Role
		// =========
		add_role(
			'club',
			__( 'Club', 'hockey_vacatures'),
			array(
				// Post/Page
				'read'							=> false,
				'edit_posts'					=> false,
				'edit_pages'					=> false,
				'edit_others_posts'				=> false,
				'create_posts'					=> false,
				'publish_posts'					=> false,
				'delete_posts'					=> false,

				// Vacatures
				'create_vacatures'				=> true,
				'read_vacatures'				=> true,
				'read_private_vacatures'		=> true,
				'edit_others_vacatures'			=> false,
				'edit_private_vacatures'		=> true,
				'edit_published_vacatures'		=> true,
				'edit_vacatures'				=> true,
				'delete_others_vacatures'		=> false,
				'delete_private_vacatures'		=> true,
				'delete_published_vacatures'	=> true,
				'delete_vacatures'				=> true,
				'publish_vacatures'				=> true,

				// Theme functionality
				'edit_themes'					=> false,
				'install_plugins'				=> false,
				'update_plugin'					=> false,
				'update_core'					=> false,
			)
		);

		// Player Role
		// ===========
		add_role(
			'player',
			__( 'Speler', 'hockey_vacatures' ),
			array(
				// Post/Page
				'read'							=> false,
				'edit_posts'					=> false,
				'edit_pages'					=> false,
				'edit_others_posts'				=> false,
				'create_posts'					=> false,
				'publish_posts'					=> false,
				'delete_posts'					=> false,

				// Vacatures
				'create_vacatures'				=> true,
				'read_vacatures'				=> true,
				'read_private_vacatures'		=> true,
				'edit_others_vacatures'			=> false,
				'edit_private_vacatures'		=> true,
				'edit_published_vacatures'		=> true,
				'edit_vacatures'				=> true,
				'delete_others_vacatures'		=> false,
				'delete_private_vacatures'		=> true,
				'delete_published_vacatures'	=> true,
				'delete_vacatures'				=> true,
				'publish_vacatures'				=> true,

				// Theme functionality
				'edit_themes'					=> false,
				'install_plugins'				=> false,
				'update_plugin'					=> false,
				'update_core'					=> false,
			)
		);
	}

	public static function register_categories(){
		// User role categories
		wp_insert_category(
			array(
				'cat_name' 				=> __( 'Speler', 'hockey_vacatures'),
				'category_description'	=> __( 'Speler categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'speler',
				'taxonomy' 				=> 'category'
			)
		);
		wp_insert_category(
			array(
				'cat_name' 				=> __( 'Club', 'hockey_vacatures'),
				'category_description'	=> __( 'Club categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'club',
				'taxonomy' 				=> 'category'
			)
		);

		// Vacature categories
		$vacature_cat_id = wp_insert_category(
			array(
				'cat_name' 				=> __( 'Vacature', 'hockey_vacatures'),
				'category_description'	=> __( 'Vacatures categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'vacature',
				'taxonomy' 				=> 'category'
			)
		);
		wp_insert_category(
			array(
				'cat_name' 				=> __( 'Trainer vacature', 'hockey_vacatures'),
				'category_description'	=> __( 'Trainer vacature categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'trainer-vacature',
				'taxonomy' 				=> 'category',
				'category_parent' 		=> $vacature_cat_id,
			)
		);
		wp_insert_category(
			array(
				'cat_name' 				=> __( 'Speler vacature', 'hockey_vacatures'),
				'category_description'	=> __( 'Speler vacature categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'speler-vacature',
				'taxonomy' 				=> 'category',
				'category_parent' 		=> $vacature_cat_id,
			)
		);
		wp_insert_category(
			array(
				'cat_name' 				=> __( 'Coach vacature', 'hockey_vacatures'),
				'category_description'	=> __( 'Coach vacature categorie', 'hockey_vacatures'),
				'category_nicename' 	=> 'coach-vacature',
				'taxonomy' 				=> 'category',
				'category_parent' 		=> $vacature_cat_id,
			)
		);
	}
}
