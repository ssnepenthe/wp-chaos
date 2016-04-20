<?php
/**
 * Helper functionality to ensure sites built on wp-chaos run smoothly
 *
 * @todo disable remote assets on local dev: gravatar, google fonts, etc.
 *
 * @package wp-chaos
 */

/**
 * Plugin Name: WP-Chaos Helpers
 * Plugin URI: https://github.com/ssnepenthe/wp-chaos
 * Description: This helper plugin provides further configuration for sites built using the wp-chaos starter repo.
 * Version: 0.1.0
 * Author: SSNepenthe
 * Author URI: https://github.com/ssnepenthe
 * License: GPL-2.0
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:
 * Domain Path:
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Helper functions.
if ( ! function_exists( 'is_dev' ) ) :
	/**
	 * Determine whether we are on a dev environment.
	 *
	 * @return boolean
	 */
	function is_dev() {
		return ( defined( 'WP_ENV' ) && 'development' === WP_ENV );
	}
endif;

// Register themes directory from wp/wp-content/ if default theme isn't set.
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
	register_theme_directory( ABSPATH . 'wp-content/themes/' );
}

// Force the 'blog_public' option to false on all non-production environments.
if ( defined( 'WP_ENV' ) && 'production' !== WP_ENV ) {
	add_filter( 'pre_option_blog_public', '__return_zero' );
}

/**
 * Bump up the minimum role required to bypass frontend cache to Editor.
 *
 * @param bool    $frontend_cookies Whether user gets WP cookies on frontend.
 * @param WP_User $user The current logged in user.
 *
 * @return bool
 */
function wpc_cache_buddy_logged_in_frontend( $frontend_cookies, $user ) {
	return $user->has_cap( 'publish_pages' );
}
add_filter(
	'cache_buddy_logged_in_frontend',
	'wpc_cache_buddy_logged_in_frontend',
	10,
	2
);

/**
 * Autoload Composer wordpress-muplugin packages via ssnepenthe/horme package.
 */
function wpc_horme_autoloader() {
	if ( ! is_blog_installed() || ! defined( WPC_PROJECT_ROOT ) ) {
		return;
	}

	$loader = new SSNepenthe\Horme\Horme( WPC_PROJECT_ROOT, __FILE__ );
	$loader->init();
}
add_action( 'muplugins_loaded', 'wpc_horme_autoloader', 0 );

/**
 * Don't require ssnepenthe/cache-manager to verify ssl certificates on dev.
 *
 * @return bool
 */
function wpc_cache_manager_sslverify() {
	return 'development' !== WP_ENV;
}
add_filter(
	'SSNepenthe\\CacheManager\\Nginx\\sslverify',
	'wpc_cache_manager_sslverify'
);
