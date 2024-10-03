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
define( 'DB_NAME', 'codeeureka' );

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
define( 'AUTH_KEY',         '+2fG_U<ER:hjM~6ZT-h(6+vjOgMHVcE##i^#cL/%:O:8%,tHqV/ILK*{VdYU#khK' );
define( 'SECURE_AUTH_KEY',  'S:O`Z4o:E(;~7Z7KAWQ)XQ29p[a,|f>oI)WMhO$-PA,:89_{%C.3o,Zu{J[4 ejk' );
define( 'LOGGED_IN_KEY',    'Bj/@FJ:;1-&J+_pqYQv_k`d3#V@7 K]#odYswWuts+I|j~72}5BLD<<A@o5qOTms' );
define( 'NONCE_KEY',        'z)7`6M<e}}n=Vu?w-jX4ermMN|`E4ty,1(kaHMySO2bI~R6r,8Qnja0Ed6N/j%j%' );
define( 'AUTH_SALT',        '2Q]%HHA$;^&@^M%=BFT?F`O#(q<MYv3<o4NbW+[^>t[X+[c0mW.YOr/F~T-DCT?c' );
define( 'SECURE_AUTH_SALT', ';KR$b4>;*xu&a*vh=oP|s~,m$b~Mzot2I-dAgBrkd3L,0F}@xPw~ubGMd/fRwES(' );
define( 'LOGGED_IN_SALT',   '/Whu;]{ul9i1B+adeGM6dJAMyd}bD9Ux S{VII|8kfaX3:;Mhf6W>Qz6<d},?n4F' );
define( 'NONCE_SALT',       'U_,~p$I$hXMaPU;PMvYgr;-XOa.Wv}Ez<-3;WBR:5 vlCaTRL>BF a_$=G/`=Xz[' );

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
