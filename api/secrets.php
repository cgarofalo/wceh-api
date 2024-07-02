<?php
/**
 * The Top Secret Data for the API
 * Can be accessed with an application password.
 *
 * @package wceh-api/plugin
 */

namespace WCEHAPI\plugin\API;

/**
 * Callback for the basic endpoint
 *
 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
 */
function get_secrets() {

	// All you need is an array of data.
	$data = [
		'secrets' => [
			[
				'name'        => 'Area 51',
				'description' => 'Aliens are real!',
			],
			[
				'name'        => 'JFK\'s Assassination',
				'description' => 'It was the CIA!',
			],
			[
				'name'        => 'The Moon Landing',
				'description' => 'It was faked!',
			],
			[
				'name'        => 'The Illuminati',
				'description' => 'They control everything!',
			],
		],
	];

	// And then return it with WordPress' rest_ensure_response function.
	return rest_ensure_response( $data );
}
