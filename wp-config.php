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
define('DB_NAME', 'fromagegenesis');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
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
define('AUTH_KEY',         'aXCs^<dn_+*:^P[CGdY0DOon3Og@b~0bY*c~N4x/M{gq54N[ik>uYJ3w#,O3P..W');
define('SECURE_AUTH_KEY',  'h5A(I0iR|*wAD:^FizCHq:[Qzu-XQ(]}xN(F@lpIR)-;bQa]/i;]?@q,z/3ljYvz');
define('LOGGED_IN_KEY',    '5#Vj+yE{tT_-b1Wd_%C~Ekk&;yk=VS7nY+vqS=Iwx[xIRv;+y--UOPK%5y|TX,1s');
define('NONCE_KEY',        '_5- v43*4$J!@*zhD<uz0W^zT&A?GQ/@QXd!]]]o O.%/J2/UVV)#IXKC)Y4D7TN');
define('AUTH_SALT',        'aG+OrE`+]KZZ2}7@LEPI5;]^?E8DdTaU(ej jn=.7JS@O,~nUk+v_aOgL1,U]_6+');
define('SECURE_AUTH_SALT', 'O&t|`Yxd3:U+6p`Tr1m+E}utd`hoV&R+0JUBWJi7K(~5SFmD|5[Y:6v.n,VTF=t?');
define('LOGGED_IN_SALT',   'Lx=AO.P(1nCYASkLPGioh*Q|FPzNx(Iq`!Q^F?2=(>Z0-Wt~ya=)rv36n?$o^1cg');
define('NONCE_SALT',       'R~[FB0x)q-kn n/5j-;TvKkt(&0auBy /_1jfBi,Bq)Kt/r+|[ZOUd}zpou~T7-Y');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
