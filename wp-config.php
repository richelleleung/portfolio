<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
define( 'DB_NAME', 'portfolio' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          '-!WEB%jR<!Q!VDDFlXU%%E$>KAM]*0pc_/Z#~An/Wzkc/9jP;8q?*PbndL<q-RIp' );
define( 'SECURE_AUTH_KEY',   'B+FprvXnB{)2A|scqqi#%|Bt:9aI?CH`bK>mMg99Se7}1%#~o/<!4=_5@eeDoe1U' );
define( 'LOGGED_IN_KEY',     'SR~%vyYor;X:&61_yOr[Y}6OcoiV #Z,*zhA`5BLEI2sYa!(>gy#} *o p)hCPWi' );
define( 'NONCE_KEY',         '#*i [x^~?X5Vam_~C:(4cA8P*i*XE;Iim`n_CF,. -MhwKqmSIMrBLg;6m*t][&?' );
define( 'AUTH_SALT',         ' LX:cU9d&aMPcN1Bk*zH?HzN/ca3$vs!uK9(JODPLEgZYkpb?l8bYTRcsTy+D~aR' );
define( 'SECURE_AUTH_SALT',  'Jb#D*;iE4xYRRGgMMM2(LXs`tgC!SM-M.$0OJ=xYwhK 1m~P#E6oaD)Y]X9W%En9' );
define( 'LOGGED_IN_SALT',    'T?eZRhxBEt:cLIPXB3|*72utO{Q.4HN=izRVDI[oH i]BEwUd6NG&*c*6U?6e2b}' );
define( 'NONCE_SALT',        'Y8 ~y.X5srvs|qmGHv=M4l=;:DY&a<GhZ.Ep*PNdp)WgU%LH&pd.<{3cT/gUL.Vp' );
define( 'WP_CACHE_KEY_SALT', '_tG!.!oa|y+*PSZ*yq-7L>=/$Sc;[40,d~*T*wZUlz|r02uedKaCdn:9.lXX;rv`' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'j1co_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD', 'direct');
