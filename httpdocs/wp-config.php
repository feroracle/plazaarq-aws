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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_plazaarq' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password_seguro' );

/** MySQL hostname */
define( 'DB_HOST', 'db-plazaarq' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Nb*%zcS4O[*8KXq[28@4j!7/349HlQpFR;XHgThW3:EO@Z3E;h@!#zQt8Aw/3!ta');
define('SECURE_AUTH_KEY', '@8m~_x+~q#/~#7-J+8-6%8J]_%!7M73f4%ZHNfm68hns%Sb#2Lx5hqkeHY-zQ2:h');
define('LOGGED_IN_KEY', 'qLONT20Y+0@nGR4XJ#!A2lPb45U9[dyN71*V]6(Q%|Bhe8g!32DH@%]8yCHVU7:!');
define('NONCE_KEY', '_C++dAi@+6abr+kD9tYTF;OM3ua44/ufMt|7]O#B76g49~&h2Nwv&EK)[vrxe[ea');
define('AUTH_SALT', '(231:h*OvroLC!wUW/Pet&0(71|Zg[48-+O|Ta@2Et2)UmWE05!%gR_/h3J5r(GP');
define('SECURE_AUTH_SALT', 'Xl*|bBpABLC8]8(o|3[Y137]f~;MV/terz86CYT6wR~fN9aSdZo1*:0[%bPqoHFF');
define('LOGGED_IN_SALT', 'wziEZ:5+k)8dT]1yr5x8Tm;70|k*O%W~2p96vS!*6%2R#lH;0UP1W@93d_L0|;1#');
define('NONCE_SALT', 'Lu7768e2y_:W|12+2/9Z6RjrSa4hu~/B&0Q&C!95T#:*55146kaH+90p@4xRg0[-');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'o7VMD_';


define('WP_ALLOW_MULTISITE', true);
define( 'DISALLOW_FILE_EDIT', true );
define( 'CONCATENATE_SCRIPTS', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
