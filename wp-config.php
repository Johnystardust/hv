<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'hockeyvacatures');
//define('DB_NAME', 'timvasz104_hv');

/** MySQL database username */
define('DB_USER', 'root');
//define('DB_USER', 'timvasz104_hv');

/** MySQL database password */
define('DB_PASSWORD', 'mysql');
//define('DB_PASSWORD', 'CYjggQ6u');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
//define('DB_COLLATE', '');
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '[_|[sAbOg)rG^e}8>L6s#]P5?Zjdja<roQYlhUB}ei`?H3/~O7V9&(9vlw0{o0$~');
define('SECURE_AUTH_KEY',  '^x sO+~*]z#POe^+,G~0 c|1{k{zyP{Rh<$a];%.&`NWxs9|,J&W]~Ny54Iy#^E(');
define('LOGGED_IN_KEY',    'wETgr-#_f6Eej#V()JLKO<jz=7&#}ALWmnNI<rK$5Zh%[!#<a4uGXJbbX^hX;&,:');
define('NONCE_KEY',        '~+^c#$ h5P=A8&[E$GM]wE0q8.!R4<f_2!(wPfh#H{V>m46a|PZXWa}JQma8S%s9');
define('AUTH_SALT',        'j`fBU&;OnxjS#K-t?v?BdWlCnrcLyLdOL9GSs7Vn#f]o-@{NtFeF,)hyZPHJK{m>');
define('SECURE_AUTH_SALT', 'E2 37VUT52+1(cA)+:2+Z?~Ah u/w<N7cXV^A7_PHV`@}GMaz[){.hI/}M|fk%ze');
define('LOGGED_IN_SALT',   'sb!RS>Drbuz4>[~,/B5z?>q0+>9s:~[H{8I(*=wk{F-js[KG;*)PoH/#|Xkl_b|W');
define('NONCE_SALT',       ' k6 tcK [(RIiETk9aapHz}2RTx-+n*8l *xtsx((<I64yeWdF[7fbFLCWLtG[S:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define( 'SAVEQUERIES', true );
define( 'WP_DEBUG_LOG', true );

ini_set('display_errors', E_ALL);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
