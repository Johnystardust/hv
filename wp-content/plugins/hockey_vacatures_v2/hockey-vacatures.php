<?php
/**
 * Plugin Name:       Hockey Vacatures v2
 * Plugin URI:        http://timvanderslik.nl/hockey-vacatures
 * Description:       Vacatures functionaliteit voor hockey-vacatures.nl
 * Version:           1.0.0
 * Author:            Tim van der Slik
 * Author URI:        http://timvanderslik.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Text Domain:       hockey_vacatures
 * Domain Path:       /i18n/languages
 *
 * @package           Hockey_vacatures
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'HV_PLUGIN_FILE' ) ) {
    define( 'HV_PLUGIN_FILE', __FILE__ );
}

// Include the main class.
if ( ! class_exists( 'Hockey_Vacatures' ) ) {
    include_once dirname( __FILE__ ) . '/includes/class-hockey-vacatures.php';
}

/**
 * Main instance of Hockey Vacatures.
 *
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return WooCommerce
 */
function wc() {
    return Hockey_Vacatures::instance();
}