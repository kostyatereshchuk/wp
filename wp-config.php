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
define( 'DB_NAME', 'wp' );

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
define( 'AUTH_KEY',         'gZx#rT.{Nm3BDxMtFi0+6w`&tJ|/P*J*vu:,7->Y!-#V5I^g}9KdPr|)Uf~v.T4H' );
define( 'SECURE_AUTH_KEY',  '.i9M 2ql9tH;MQUP65_us70(Hl(F.<e?QAC73&g`?Oy]gctE_c([5jo(qePeqgzC' );
define( 'LOGGED_IN_KEY',    'PqZ&$^[_;fJLy^^J@((#SCY yuy83v}^/1iL:`Vf[P;9:k[0-*HuL3&&=h*:)nK{' );
define( 'NONCE_KEY',        'ioRH{=]/a2rwCaof PyKF=kSCeU-4C0S3w1G1XJ58]]x*J /_y_L78u&C#w&vT.a' );
define( 'AUTH_SALT',        '~f|4+s+R*eQ2H=|VEDE>z,wWzi&B&H;A+|<i9vi-$()5@v9%9XeNQ0{9dp@Qph7|' );
define( 'SECURE_AUTH_SALT', 'pe@th}? RVX4r-Xv|!$RE(fp^07+UZ!Kj0~u=4OY8BU}6=#CbG$FZ,Kcx:aG|fDi' );
define( 'LOGGED_IN_SALT',   'g0BVGY!lr<4R*n}Xk(O%rSPWRSP;J,YUuDkV6egR3hTpvAuU$hnJ4j(_wY.#h$ v' );
define( 'NONCE_SALT',       'IXr,kbpt}? i;Zb|BPL+40Y :cLJp-#F njXwY-pBp4u|$![^AxGP<<7R^mN~+UJ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );

ini_set( 'display_errors', 1 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
