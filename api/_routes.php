<?php
/**
 * API for the plugin
 *
 * @package wcehapi/plugin
 */

namespace WCEHAPI\plugin\API;

add_action( 'rest_api_init', __NAMESPACE__ . '\\register_routes' );

/**
 * Register the routes for the plugin.
 *
 * @return void
 */
function register_routes() {
	$version   = '1';
	$namespace = 'wceh/v' . $version;

	// Register Routes

	// wp-json/wceh/v1/basic
	register_rest_route(
		$namespace,
		'/basic',
		[
			'methods'             => 'GET',
			'callback'            => __NAMESPACE__ . '\\get_basic',
			'permission_callback' => '__return_true', // public endpoint
		]
	);

}
