<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpdivi5' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'lfS%NW(C|g9Ho+tWd QI`L8ZsHinbXDypTYM~:]E# =N1,YNVn8UuY+=}sg#t]h|' );
define( 'SECURE_AUTH_KEY',  'VX}|hWtO6aMgYG<0{(fgAt CDb%nuZHg>IH6K44 :zC3x@86zTd!3Q3a5lEywLHy' );
define( 'LOGGED_IN_KEY',    'AMT!AlZF~|M>Dsy{A#|1QPv>$~QMyVC1h6=]&4[L(L,P0.1HV4u2t9 mp^U|wm,r' );
define( 'NONCE_KEY',        'ImwiWL4o|/|Hr$sD@KiMnlR&H!K|4E3nHt;6uN0d%X?OXa~KmylxrqHe~znb$<x>' );
define( 'AUTH_SALT',        'a Mco)gy`|YMg^5z/-;*IiO3r~eK^<6uYA&Y)AnjABrAb9)olj{L/qKDJZ*CvX(:' );
define( 'SECURE_AUTH_SALT', '$75fIo HErWN;Vkn#>wRNObc2 {K*rFO/M-*D :zs^:Z&XnoCt&B5ezz85Li_JjT' );
define( 'LOGGED_IN_SALT',   'fm7A{]8j.embM[43@^I6&ZHw5%@Yr#g{f8wsB;qa@i j[:2%eO!$*2>%c{L5rRsL' );
define( 'NONCE_SALT',       ' `A{+Y9jf/:cf7` bWq]?m QkSAC<XQi%kHZ`tbR(]sl07#/g[h4S//$sb@8.8i!' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
