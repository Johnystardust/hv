<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://timvanderslik.nl
 * @since             1.0.0
 * @package           Hockey_vacatures
 *
 * @wordpress-plugin
 * Plugin Name:       Hockey Vacatures
 * Plugin URI:        http://timvanderslik.nl/hockey-vacatures
 * Description:       Vacatures functionaliteit voor hockey-vacatures.nl
 * Version:           1.0.0
 * Author:            Tim van der Slik
 * Author URI:        http://timvanderslik.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hockey_vacatures
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hockey_vacatures-activator.php
 */
function activate_hockey_vacatures() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/hockey-vacatures-activator.php';
	Hockey_Vacatures_Activator::register_pages();
	Hockey_Vacatures_Activator::register_user_roles();
	Hockey_Vacatures_Activator::register_categories();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hockey_vacatures-deactivator.php
 */
function deactivate_hockey_vacatures() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/hockey-vacatures-deactivator.php';
	Hockey_Vacatures_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hockey_vacatures' );
register_deactivation_hook( __FILE__, 'deactivate_hockey_vacatures' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/hockey-vacatures.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hockey_vacatures() {

	$plugin = new Hockey_Vacatures();
	$plugin->run();

}
run_hockey_vacatures();