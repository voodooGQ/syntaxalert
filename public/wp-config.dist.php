
<?php
/**
 * Theme Settings
 */
define('THEME_HANDLE', 'oowp'); // The base handle for generated objects
define('THEME_VERSION', '1.0'); // Current theme version
define('THEME_ENV', 'dev'); // The environment variable (dev or prod)
define('TWIG_CACHE', '.cache/twig'); // The cache directory for twig generation
define('TWIG_TEMPLATE_DIR', 'twig'); // The twig template dir, relative to theme root

/**
 * Home & site URL.
 *
 * This will override the home/site URL settings
 * in the General Settings of wp-admin.
 */
define('WP_HOME', 'http://YOUR_DOMAIN_HERE');
define('WP_SITEURL', WP_HOME . '/core');

/**
 * Content directory and URL.
 *
 * For WordPress installations using GIT externals and keeping the
 * content directory separate from WordPress core code.
 */
define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
define('WP_CONTENT_URL', WP_HOME . '/content');

/**
 * MySQL settings.
 *
 * Update these to match the values necessary for
 * accessing the database.
 */
// Database name
define('DB_NAME', 'dbname');

// Database username
define('DB_USER', 'dbuser');

// Database password
define('DB_PASSWORD', '123');

// Database host (usually 'localhost')
define('DB_HOST', 'localhost');

// Database character set
define('DB_CHARSET', 'utf8');

// The database collation. Leave this blank unless otherwise required.
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
define('AUTH_KEY',         'GET_FROM_LINK_ABOVE');
define('SECURE_AUTH_KEY',  'GET_FROM_LINK_ABOVE');
define('LOGGED_IN_KEY',    'GET_FROM_LINK_ABOVE');
define('NONCE_KEY',        'GET_FROM_LINK_ABOVE');
define('AUTH_SALT',        'GET_FROM_LINK_ABOVE');
define('SECURE_AUTH_SALT', 'GET_FROM_LINK_ABOVE');
define('LOGGED_IN_SALT',   'GET_FROM_LINK_ABOVE');
define('NONCE_SALT',       'GET_FROM_LINK_ABOVE');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'oowp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);
if (WP_DEBUG) {
    define('WP_DEBUG_LOG',     true);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG',     true);
    @ini_set('display_errors', 0);
}

/**
 * Disable WP_Cron and have it run off a manual linux cron instead.
 * See: https://www.lucasrolff.com/wordpress/why-wp-cron-sucks/
 */
define('DISABLE_WP_CRON', true);

/**
 * Admin cookie path.
 *
 * A path must be defined for the WordPress login cookie because
 * WordPress core is located in a subdirectory of the site.
 */
define('ADMIN_COOKIE_PATH', '/');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
