<?php

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'xub7ohSee9Ul');

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
define('AUTH_KEY',         'Aesaing0weepei6OteeDie2ahjei3Aenish0ahn0geey8oogaegeeTiasa7ahWeir');
define('SECURE_AUTH_KEY',  'qui0loow3eixah0ro2quaef6gefuto2KuidaineijaayiKee9lauFiekuw9ahGh1U');
define('LOGGED_IN_KEY',    'eaNaegh8der0booGai6deiM1aetho6iekee7ieGhooSee1Aphah0gawahNiup3iel');
define('NONCE_KEY',        'eej4Amev6mouKa1xoh8Aic8aefohxoopheighooth5zuGeu3uebod7oomaifeeph3');
define('AUTH_SALT',        'wa2yoh9aixobaaX8rai4Joo6iephae4phee3ohtaechai1Gagai9aepe0iedaeyaZ');
define('SECURE_AUTH_SALT', 'quahm2shu9ootohp6phai6ahfiequan6aiJ6awai9Toz8chai0ebuizaeSh6ohxah');
define('LOGGED_IN_SALT',   'shi2eiyiewiuYe3eaPhaikihae6bu5peiso9voow0aapaef8phieng3gahch5deed');
define('NONCE_SALT',       'aShia1oow6eezah5ce6vapheeth8IetheeS2seib3rahg1wae7sohwaishui8uat8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all my dear, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
$plugins = get_option( 'active_plugins' );
if ( count( $plugins ) === 0 ) {
  require_once(ABSPATH .'/wp-admin/includes/plugin.php');
  $pluginsToActivate = array( 'nginx-helper/nginx-helper.php' );
  foreach ( $pluginsToActivate as $plugin ) {
    if ( !in_array( $plugin, $plugins ) ) {
      activate_plugin( '/usr/share/nginx/www/wp-content/plugins/' . $plugin );
    }
  }
}
