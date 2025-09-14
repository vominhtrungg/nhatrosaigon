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
define( 'DB_NAME', 'wp_demo' );

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
define( 'AUTH_KEY',         'TevFl0nwSEoZ),7#>3HM=RI*,=Uksu+LYhfj||E;WXn{pZAk4dF3&Pg:ESfy?xAf' );
define( 'SECURE_AUTH_KEY',  'yp90LK)4.@F)C02Y/VhTl1l|2/gh~7c=(ofDi~5&={y+;$^FU.kEcgTAy?1B~CNd' );
define( 'LOGGED_IN_KEY',    '>[d51{4$C`TwnxDb*E70z-SQ lB(}2%%d[{(ZMJ)J%1`.scN~DeS77n<kCcN;YJ2' );
define( 'NONCE_KEY',        '`H2t*HlY~z2P#[(D*NOS0kT-mb4/r42*CD4D7P}Jze@@k5>1NFb!J]V1s&VPT2<?' );
define( 'AUTH_SALT',        '^TnMZEiyzNj;$h6dh`0>NkW<Ka7-2mCX M&SwbO](,:HW6R8L4#Y(~IK>Z__g{(&' );
define( 'SECURE_AUTH_SALT', 'HLcn-E!,2!9xx6tvxOJ+D&,W1qbE]4l]@D%bzU),1aWXG(2P)6<,5B82 zX@1nRg' );
define( 'LOGGED_IN_SALT',   '_GMwoO06q--&TBOmIQcc76A#~Fv?$P;N@XfXvd_!|Z`kT-yG5;`[|,p;THrWxld.' );
define( 'NONCE_SALT',       'y:uW.ZYw`jC`F`,R;1v33Fku!jvXdDl=0$&jqvY/jW%ea5PE-Uq0J=>ah|$>fJ;.' );

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
