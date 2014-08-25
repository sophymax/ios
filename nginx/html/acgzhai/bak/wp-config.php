<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define ('WP_MEMORY_LIMIT', '256M' );
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/usr/local/openresty/nginx/html/acgzhai/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'acgzhai_wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'ErvDAgIep1m3awEXW0b1Ek0H2FfZ7JQukhjvaUKi3ScB46kBnFvJtdnjHSXREcGb');define('SECURE_AUTH_KEY',  'fvkIlZhKcOINmZPwXliqpXUjuGdVtql2EJFCYcxmzniDZnEvTNMSmSkwTLJJ7s7t');define('LOGGED_IN_KEY',    'BiUfSM7Tx9GiYmp6Y1Rfv2LlGvo7OvYY2aaXH4jDvjT5u2mPdYqaZAjSpOWM3zZI');define('NONCE_KEY',        'R6HObxbcIDhJhsaKbMWMrA3xq448AJGMA01gZ64T02by0vsZlf3R9qjCpNUi4Vxr');define('AUTH_SALT',        'rHjXVPXiy94tZhOSvtYb5gbZ4SlQVVvpl8ClKy8feWm7jdqxkjNYyUrxE4jcRIyG');define('SECURE_AUTH_SALT', 'qDoLcfyIKiYZdA8868w2KwD1517R6pO5jXaMSHptykohMLJiQG36uckgTZOVXQuN');define('LOGGED_IN_SALT',   'IKJ7KwGEroOYIyy7JlJ79EJvYcYn2VOZmdlaUc9uDFcBqCS1WEsuzEVYNXJsRwjt');define('NONCE_SALT',       'mICN3jxWyUxctR2xVi8OlWHua46xH5nLXDPgR8t3btJavgjznAVat2CUO4QJFjXa');/** * Other customizations. */define('FS_METHOD','direct');define('FS_CHMOD_DIR',0777);define('FS_CHMOD_FILE',0666);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');/** * Turn off automatic updates since these are managed upstream. */define('AUTOMATIC_UPDATER_DISABLED', true);

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'zh_CN');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

//define('WP_DEBUG', true);//
ini_set('display_errors',false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
