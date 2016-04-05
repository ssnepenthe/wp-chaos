<?php
/**
 * Base configuration for WordPress.
 *
 * @package wp-chaos
 */

define( 'WPC_DOCUMENT_ROOT', __DIR__ );
define( 'WPC_PROJECT_ROOT', dirname( WPC_DOCUMENT_ROOT ) );

// Composer.
if ( file_exists( WPC_PROJECT_ROOT . '/vendor/autoload.php' ) ) {
	require_once WPC_PROJECT_ROOT . '/vendor/autoload.php';
}

// Config via PHP dotenv.
require_once WPC_DOCUMENT_ROOT . '/environment.php';

// DB settings, don't touch.
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// Max post revisions.
define( 'WP_POST_REVISIONS', 3 );

// Disable automatic updates.
define( 'AUTOMATIC_UPDATER_DISABLED', true );

// Disable wp-admin file editors.
define( 'DISALLOW_FILE_EDIT', true );

// Disable default WP cron.
define( 'DISABLE_WP_CRON', true );

// Absolute path to WordPress dir.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
}

// WordPress setup and includes.
require_once ABSPATH . 'wp-settings.php';
