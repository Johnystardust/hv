<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class HV_Autoloader {

	private $include_path;

	public function __construct() {
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'hv_autoloader' ) );
		$this->include_path = untrailingslashit( plugin_dir_path( HV_PLUGIN_FILE ) ) . '/includes/';
	}

	/**
	 * The Hockey Vacatures Plugin Autoloader
	 *
	 * @param $class
	 */
	public function hv_autoloader( $class ){
		// Return if the HV isnt in the Class
		if( 0 !== strpos( $class, 'HV_' ) ) {
			return;
		}

		$file = $this->get_file_name_from_class( $class );
		$path = '';

		// Map the different plugin sections.
		if( 0 === strpos( $class, 'HV_Shortcode' ) ) {
			$path = $this->include_path . 'shortcodes/';
		}
		elseif( 0 === strpos( $class, 'HV_Meta_Box' ) ) {
			$path = $this->include_path . 'admin/meta-boxes/';
		}
		elseif( 0 === strpos( $class, 'HV_User_Roles' ) ) {
			$path = $this->include_path . 'user_roles/';
		}
		elseif( 0 === strpos( $class, 'HV_Vacature' ) ) {
			$path = $this->include_path . 'vacature/';
		}

		// Load the file.
		if ( empty( $path ) || $this->load_file( $path . $file ) ) {
			$this->load_file( $this->include_path . $file );
		}
	}

	/**
	 * Makes the filename from the class.
	 *
	 * @param $class
	 * @return string
	 */
	private function get_file_name_from_class( $class ){
		return 'class-' . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Include the Class
	 *
	 * @param $path
	 * @return bool
	 */
	private function load_file( $path ){
		if( $path && is_readable( $path ) ){
			include_once( $path );
			return true;
		}
		return false;
	}
}
new HV_Autoloader();