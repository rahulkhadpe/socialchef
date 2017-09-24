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
define('DB_NAME', 'social_chef');

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
define('AUTH_KEY',         'lrn$Z%Ssf!|qb7Q1!k{#DG/.CW[It;E{U{0N0jo^OyIq_KkZx1:@WQP5pboF+cxq');
define('SECURE_AUTH_KEY',  'Dr7XmLJp02{5svIXd5zw|]gzcgp>]fT&)BUh59a&<p!xlAS8|,-&s,i+!Z1LM,I:');
define('LOGGED_IN_KEY',    '8NVZwYq/;1)+w`@~v1|-<Ea@{s]55_sO|v1Lc0`x0-x0! Jq:$Rr4WL{a 9S#CUW');
define('NONCE_KEY',        ':,ZG8eBiB1yTuH-Q: zx7GGRcX%e1II7Z*^e^=1@eN*N3!E9?Rds)ZCV4hAg3e$j');
define('AUTH_SALT',        'F/;!S3P_&a8q4brGMA~N)jdgB0_Q8B7{KK#~uB~]ce[uP5F|eUw$#28mflaiR!p,');
define('SECURE_AUTH_SALT', '_)W=9OWq^(;.4fN_va%rhTE2ls>Y;ecR8=-u2aeo/& RW5TLDS*QgX{#G*n_:A;}');
define('LOGGED_IN_SALT',   '_,wT|Z*b_O~Vgf~pzdUIZvjsXfdfHXhhB`s~|K+Tk>I[KvVubd`l]@W9gX` }%V6');
define('NONCE_SALT',       'rXj7$@R&^Fy.@UllI*VPttUn31c[&5^qs(z6zlM=DW.4btPhPS)`#^ 7i(>Y{kgl');

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
