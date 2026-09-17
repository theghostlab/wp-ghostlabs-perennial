<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use GHOSTLABS\DYNAMIC_COPYRIGHT\Kernel;

if ( file_exists( GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	require_once GHOSTLABS_DYNAMIC_COPYRIGHT_PLUGIN_PATH . 'vendor/autoload.php';
} else {
	add_action( 'admin_notices', static function () {
		echo '<div class="error"><p>GhostLabs: Dynamic Copyright error: Composer autoloader not found. Please run <code>composer install</code>.</p></div>';
	} );

	return;
}

add_action( 'plugins_loaded', static function () {
	try {
		Kernel::getInstance()->init()->run();
	} catch ( \Throwable $e ) {

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( '[Dynamic Copyright] ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Guarded by WP_DEBUG; this is the only report a failed boot can make.
		}
	}
}, 10 );
