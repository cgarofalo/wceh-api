<?php
/**
 * The Basic Cats Data for the API
 *
 * @package wceh-api/plugin
 */

namespace WCEHAPI\plugin\API;

/**
 * Callback for the basic endpoint
 *
 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
 */
function get_basic() {

	// All you need is an array of data.
	$data = [
		'cats' => [
			[
				'name'    => 'Pekoe',
				'colour'  => 'orange',
				'breed'   => 'domestic shorthair',
				'pattern' => 'tabby',
			],
			[
				'name'    => 'Milo',
				'colour'  => 'grey',
				'breed'   => 'domestic shorthair',
				'pattern' => 'solid',
			],
			[
				'name'    => 'Poppy',
				'colour'  => 'cream',
				'breed'   => 'siamese',
				'pattern' => 'pointed',
			],
		],
	];

	// And then return it with WordPress' rest_ensure_response function.
	return rest_ensure_response( $data );
}
