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
define( 'DB_NAME', 'aushamon' );

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
define( 'AUTH_KEY',         'l{b|}A`^.n9fUsi9m_6-s~Av>)nvLKX+)}%B2uTC{#ZiZ7HbV7o)=y.fmC>>OEdE' );
define( 'SECURE_AUTH_KEY',  'xANzMji,M3q>Mkw;f1wrHS.y#yP_c7!JrG_}ji7_l3P|v|]GM;YH t%CZ8(CSGo9' );
define( 'LOGGED_IN_KEY',    '&zhSX^*r~uJ;f<)sBj{41?}/a,Yol,*E%e[@t$Qx~*W$e?cAdQ+<N5qbJM3fJzl9' );
define( 'NONCE_KEY',        ',pMAF,DGk/gnGrCW.ak;nW`;k|{ O#H~g.p20.~E(89#@lq5y5Opz<7reX8FZ-.+' );
define( 'AUTH_SALT',        '.fBuJsr.yZG7O.^7^C!1_$1TrEHM?kErH+3|&Rxip)-p5%-&[)C_sr&Khn641Ef@' );
define( 'SECURE_AUTH_SALT', ')eG2j>vvf]7|_efSrW:H3F,H?Y<F*D%{zb1+Il4z4XXxW$-N-:e(B~mT|JJumLXs' );
define( 'LOGGED_IN_SALT',   'MI~W$-w8eLn `8f9,CXWr.A6z*=B]e)JS6uF6M>|o[SZZ>Cq1_herR~K-Ht%#]Yh' );
define( 'NONCE_SALT',       'eMSb#N#Y]]AdhGW=D.WA&l*gcce6_Sj!>0u1MP~lyg{#*7pUR857Nl3)UE(:/!!R' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_user';

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
