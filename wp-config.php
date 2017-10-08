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
define('DB_NAME', 'luxury_new');

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
define('AUTH_KEY',         'gkZ0FkWPIgr$p{}b]rs2b,D0!B[SS0O}^N^uK<g^3K8($*|dqr]Sh/7Aqaub]y-9');
define('SECURE_AUTH_KEY',  '+?hiMdZm)ra2^Gw)/01l.qo<}a~}p2?!j%2SLQRu,+zf7N-~.[0.0B%w61O`(X5!');
define('LOGGED_IN_KEY',    '&SF{V~A_sQsM-wV;Hw[5qT:WD/TJ *OQbQWF)@,P%(cm!OyZOw]q%m3MV+8BnFfy');
define('NONCE_KEY',        'Bh`~LPs|dQ5woN)H.o9FJ;NW%[hZ5!Zc+mXfD^y,`$Y)$R1,5W54!M_h{y44#Zsd');
define('AUTH_SALT',        'vkD]l/H8t{}$~D;T/p(}BT|B&KW`5n+j=g).>c2#|}sQ#M=QQyyBZ,< n7]B)UB!');
define('SECURE_AUTH_SALT', 'UV0+UA}g#P>^ZwE6Ow<~m1oCT~O1||44Z(`;pJ+J^(eMbAAri|`)7CHk}gQY4d[]');
define('LOGGED_IN_SALT',   'W0FA</Or6pWNOEFrw/b*TM[!>d~{9Wc*AtnSnrzQW;#g8T*aGKv]7TDn|v;dp9ow');
define('NONCE_SALT',       '^?UQK#}1/Sl^9khT=F{f,BS5CB|0,.LT:.A;WMWi-Cf5Q<LY8H1yW{iTT3R(ZLO6');

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
