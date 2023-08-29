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
define( 'DB_NAME', 'ascent2' );

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
define( 'AUTH_KEY',         '3ci>EPWH8Q7>mF4m,^;UM9`; + f-DY]W/J)@MT?5( 0h0spu^GjpZ,x_ll$Y}Jl' );
define( 'SECURE_AUTH_KEY',  ';Z|&zIgjLgrDFd*PD2#o4-NRv&`Vp8Ypw7(^oJCB*Ez=b5tpA&y@z H%CS@ZjXFV' );
define( 'LOGGED_IN_KEY',    '{gai;M7np4%t}pJ+@B,%I)eW},T3>H9c.f`,eGK]h3tU&a[~Ex)DBF]tW&txN@!-' );
define( 'NONCE_KEY',        'lWUzSJA:7PvY2Mwq-*SI=C>4fBGJ!?ol7,bxQfN_uR(*%MV[Dq95X2[j]{Bo[4qy' );
define( 'AUTH_SALT',        'UtuBW:?^?jMAE2/ZwJXn,#cuysolVmu[wF|lIb#UiSxi(X:HGNCL$~cIIdgy8A0$' );
define( 'SECURE_AUTH_SALT', '[Z`6}qu3MWz+y2jMbKAea8|SPbQvOyB=n6$L(:7ed~B@8s,mMAwE6tzvu&kO/^:W' );
define( 'LOGGED_IN_SALT',   'u{eDx;9;^(M~Q$wTJ;E/g_:ui3igQY!f[@Zv+A^Q:}dUy0HGOfIhsyp?Wpgs[p6|' );
define( 'NONCE_SALT',       'xFccpI5D F.=EpB%#?VVw-1dkm2GgO-^;PJd+k%*86%o7/|DeL8@dG=Q-Een ;D7' );

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
