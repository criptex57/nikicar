<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'niki-car.space' );

/** Database username */
define( 'DB_USER', 'murahypivdnya@gmail.com' );

/** Database password */
define( 'DB_PASSWORD', 'o7[j62DW&{D$~%@' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('WPLANG', 'uk');

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
define( 'AUTH_KEY',         '(;Mlk/&w<#,f1o^:6hM%{y!S/wLs[|(NvCQ)y0Ux<y{VVRH736128kUFp]Ll?DEs' );
define( 'SECURE_AUTH_KEY',  '!^)GF*~0mK}/Wv>t[&OU$-()/CP~x4bXx^b:Z5-TUgDs?{=*`Nd4qSc6cp({[c?I' );
define( 'LOGGED_IN_KEY',    '@*u9iQHRZ$O#8xXfJJ+>FXtWP{m@^@`EaWpOfO^W<WOou{A:=,Gxa)YZ-q!VXg63' );
define( 'NONCE_KEY',        '=;J~HwGq2,rVVwR<{24{YGN^p1v,JL,_}dH4}BwJ!z4<&x.4Lnh>o%p88O.*.9-^' );
define( 'AUTH_SALT',        'Il@_9`n)dYqTQWo=jepF`*g6qXoSStv*f<{nT|N4{&Z]]YL/-+h?o.q%@Rhj=r@L' );
define( 'SECURE_AUTH_SALT', 'dt=b@sq(m aBDQu>.$eDxV[_.k5 !&+Z*U9x_I))u;]U)4^=+t}%RPyrE&o IV#_' );
define( 'LOGGED_IN_SALT',   'pfS%Fp/OER3PegH3vg`z3Gx4BV]xACQj]8`nhE7P0:ebJs.2~7+3=Ru`d1KL=lX%' );
define( 'NONCE_SALT',       'l<&iF7c_-?Eh~.}H/uipIZ!IQaqbPwA` V9ps|b~OZ4A4qyL_d{4YOHzK.=1w75o' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
