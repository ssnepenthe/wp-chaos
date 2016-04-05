<?php
/**
 * Environment specific configuration vie PHP dotenv
 *
 * @package  wp-chaos
 */

// Initialize phpdotenv.
try {
	$dotenv = new Dotenv\Dotenv( WPC_PROJECT_ROOT );
	$dotenv->load();
	$dotenv->required( [
		'DB_NAME',
		'DB_USER',
		'DB_PASSWORD',
		'WP_HOME',
		'AUTH_KEY',
		'SECURE_AUTH_KEY',
		'LOGGED_IN_KEY',
		'NONCE_KEY',
		'AUTH_SALT',
		'SECURE_AUTH_SALT',
		'LOGGED_IN_SALT',
		'NONCE_SALT',
	] );
} catch ( \Exception $e ) {
	die( $e->getMessage() );
}

// Define the current environment.
define( 'WP_ENV', getenv( 'WP_ENV' ) ?: 'development' );

// Custom directories and URLs.
define( 'WP_HOME', getenv( 'WP_HOME' ) );
define( 'WP_SITEURL', WP_HOME . '/wp' );
define( 'WP_CONTENT_DIR', WPC_DOCUMENT_ROOT . '/content' );
define( 'WP_CONTENT_URL', WP_HOME . '/content' );

// Default theme.
if (
	! empty( $theme = getenv( 'WP_DEFAULT_THEME' ) ) &&
	file_exists( sprintf( '%s/themes/%s/style.css', WP_CONTENT_DIR, $theme ) )
) {
	define( 'WP_DEFAULT_THEME', $theme );
}

// DB config.
define( 'DB_NAME', getenv( 'DB_NAME' ) );
define( 'DB_USER', getenv( 'DB_USER' ) );
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );
define( 'DB_HOST', getenv( 'DB_HOST' ) ?: 'localhost' );

$table_prefix = getenv( 'TABLE_PREFIX' ) ?: 'wp_';

// Salts.
define( 'AUTH_KEY', getenv( 'AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', getenv( 'SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', getenv( 'LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', getenv( 'NONCE_KEY' ) );
define( 'AUTH_SALT', getenv( 'AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', getenv( 'SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', getenv( 'LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', getenv( 'NONCE_SALT' ) );

/**
 * Debugging.
 *
 * @todo Seems likely that we will want to be able to override on production.
 */
define( 'WP_DEBUG', 'production' !== WP_ENV ? true : false );
define( 'WP_DEBUG_LOG', 'production' !== WP_ENV ? true : false );
define( 'WP_DEBUG_DISPLAY', 'production' !== WP_ENV ? true : false );
define( 'SCRIPT_DEBUG', 'production' !== WP_ENV ? true : false );
define( 'SAVEQUERIES', 'production' !== WP_ENV ? true : false );
