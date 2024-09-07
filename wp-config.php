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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'm/B12cA5g#|/SEkFuK$e1YBIQK7crjxv<#>U82Z[$XTrnlO`D ~]yX4^U]PCgT3v' );
define( 'SECURE_AUTH_KEY',  'jY8k0ie>jt9Eyu9=rb^x~|NN4n!JyELqAG579a{8 _ef3-o%J{+MdR5BVaD{AL=@' );
define( 'LOGGED_IN_KEY',    '{A>l1pjKLEfn~~A5Hy3pDXiOpDQo20u/0nN`Kfhnp+q G};(:=2cP<D,7{qvYS(Q' );
define( 'NONCE_KEY',        'OuO?[p^NB;GkK>l`R%M=8 Kv;ID!OdW}at)nk#*c(iN,(IcW08iXy-qpa-E{f0/+' );
define( 'AUTH_SALT',        'q^.Cwb!|!Qq];(69]Q#YH{CkIEL*|kxYLk_qjhx`S;mx@Pc=YoR.zuI:a$k8$P$4' );
define( 'SECURE_AUTH_SALT', 'enNu&TTW-@6u[p?Jc(;l`U(%debr+<Q/^]lVt!y(vxYBI5[l7qiNaRv+H3/GU0yR' );
define( 'LOGGED_IN_SALT',   'W#9IV>UHf(sxM*E0p`7GOB|*6d/qj?t$=*h<KQ`{5&}ONMc4?STAg@YgmaN@:n)1' );
define( 'NONCE_SALT',       '~4,o-y6F,uFy)SM{1Q>4{`{g`1 QBlR]3@PL~/^|eeSL74atqRie~u3H3`Cc /-z' );

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

@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );