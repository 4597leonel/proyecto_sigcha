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
define( 'DB_NAME', 'impsigcha' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/z I0cHFkw< %S<2W^0$+s6r}+iGZYBRR]wR|.de4!V.?5|=:RO=XbQ=4iBcWS{x' );
define( 'SECURE_AUTH_KEY',  '|Q{/lSz^Xv>)Xc?3 ^Pv~c#kF4KZg{Du(8bcD;~_xC@-SB@Ji4qd{ix@h[t;}U}(' );
define( 'LOGGED_IN_KEY',    't{?{WN_h]m+A~At_HM8])S~Mq@6!dTp`sN-U&.8VjiXu4-j*3R3f##?Ajzo_e}Nm' );
define( 'NONCE_KEY',        '0S5]HLK[G&SE%@j_f^sHB1fBxN/#wRy~4J (YA&!t|7 ]zH(<:k>!xQJ(4vSOr1W' );
define( 'AUTH_SALT',        'ulXbRd>c Fv<U6Ta#++r`M2k4_~2$i[!uSe%uu8y}Lsql,}5?|:]|!NVdgpDlwc#' );
define( 'SECURE_AUTH_SALT', 'N]/Gcv#W1(OClV;0:&zbc{mD@&!uD%XL,uDW{+-19FKth#`Q@z_{G/eQ0r(6VgRo' );
define( 'LOGGED_IN_SALT',   'oGEbqItkLRH[y(Io^&Mq,&fC];icL_FI-qNDL+==Dz<Wb=w%9@+6/0Z/@QsP8[iW' );
define( 'NONCE_SALT',       '>uT2lX2y$hEh3rJr]:{z~<e%{0J?)eY ?w;^Lg;]@f!c5kTEjsFsQ0AP7kaapdXx' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'imps_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
