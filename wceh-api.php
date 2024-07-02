<?php
/**
 * Plugin Name: WordCamp Canada API Demo
 * Plugin URI: https://github.com/cgarofalo/wceh-api
 * Description: A plugin demoing custom API endpoints.
 * Version: 0.1
 * Author: Christina Garofalo
 * Author URI: https://profiles.wordpress.org/cold-iron-chef/
 *
 * @package wceh-api/plugin
 **/

// Add the custom Post type
add_action( 'init', 'wcehapi_custom_post_type' );

// Add Taxonomies
add_action( 'init', 'wcehapi_taxonomy_colour' );
add_action( 'init', 'wcehapi_taxonomy_breed' );
add_action( 'init', 'wcehapi_taxonomy_pattern' );

// Load the API (All files in the api directory)
foreach ( glob( __DIR__ . '/api/*.php' ) as $file ) {
	require $file;
}

/**
 * Register Custom Post Type
 *
 * @return void
 */
function wcehapi_custom_post_type() {
	register_post_type(
		'wcehapi_cat',
		[
			'labels'              => [
				'name'          => __( 'Cats', 'wcehapi' ),
				'singular_name' => __( 'Cat', 'wcehapi' ),
				'add_new'       => __( 'Add New Cat', 'wcehapi' ),
				'add_new_item'  => __( 'Add New Cat', 'wcehapi' ),
				'edit_item'     => __( 'Edit Cat', 'wcehapi' ),
				'all_items'     => __( 'All Cats', 'wcehapi' ),
			],
			'public'              => true, // This needs to be true so Polylang can see the post type.
			'show_ui'             => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'menu_icon'           => wcehapi_get_svg( 'cat' ),
			'capability_type'     => 'post',
			'rewrite'             => [
				'slug' => 'cats',
			],
			'supports'            => [
				'title',
				'editor',
				'thumbnail',
			],
		]
	);
}

/**
 * Register Custom Taxonomy
 *
 * @return void
 */
function wcehapi_taxonomy_breed() {
	register_taxonomy(
		'cat_breed',
		'wcehapi_cat',
		[
			'labels'              => [
				'name'          => __( 'Breeds', 'wcehapi' ),
				'singular_name' => __( 'Breed', 'wcehapi' ),
				'add_new'       => __( 'Add New Breed', 'wcehapi' ),
				'add_new_item'  => __( 'Add New Breed', 'wcehapi' ),
			],
			'public'              => true, // This needs to be true so Polylang can see the taxonomy.
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'hierarchical'        => false,
			'rewrite'             => [
				'slug' => 'breed',
			],
		]
	);
}

/**
 * Register Custom Taxonomy
 *
 * @return void
 */
function wcehapi_taxonomy_colour() {
	register_taxonomy(
		'cat_colour',
		'wcehapi_cat',
		[
			'labels'              => [
				'name'          => __( 'Colours', 'wcehapi' ),
				'singular_name' => __( 'Colour', 'wcehapi' ),
				'add_new'       => __( 'Add New Colour', 'wcehapi' ),
				'add_new_item'  => __( 'Add New Colour', 'wcehapi' ),
			],
			'public'              => true, // This needs to be true so Polylang can see the taxonomy.
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'hierarchical'        => false,
			'rewrite'             => [
				'slug' => 'Colour',
			],
		]
	);
}

/**
 * Register Custom Taxonomy
 *
 * @return void
 */
function wcehapi_taxonomy_pattern() {
	register_taxonomy(
		'cat_pattern',
		'wcehapi_cat',
		[
			'labels'              => [
				'name'          => __( 'Patterns', 'wcehapi' ),
				'singular_name' => __( 'Pattern', 'wcehapi' ),
				'add_new'       => __( 'Add New Pattern', 'wcehapi' ),
				'add_new_item'  => __( 'Add New Pattern', 'wcehapi' ),
			],
			'public'              => true, // This needs to be true so Polylang can see the taxonomy.
			'show_ui'             => true,
			'show_in_rest'        => false,
			'exclude_from_search' => true,
			'hierarchical'        => false,
			'rewrite'             => [
				'slug' => 'pattern',
			],
		]
	);
}

/**
 * Get svg icon for custom post type
 *
 * @param string $icon The icon name
 *
 * @return string
 */
function wcehapi_get_svg( $icon ) {
	// Fallback to dashicons if the icon can't be found.
	$svg = 'dashicons-admin-post';

	if ( file_exists( __DIR__ . '/assets/' . $icon . '.svg' ) ) {
		// The fill attribute needs to be set to "black" for WordPress to be able to change the colour.
		$svg = 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( __DIR__ . '/assets/' . $icon . '.svg' ) ); //phpcs:ignore
	}

	return $svg;
}

// Bonus: Restrict User endpoints
add_filter( 'rest_endpoints', 'wcehapi_restrict_user_endpoints' );

/**
 * Remove user endpoints for unauthorized users.
 *
 * @param  array $endpoints Array of endpoints
 *
 * @return array $endpoints Filtered list of endpoints
 */
function wcehapi_restrict_user_endpoints( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
	}

	return $endpoints;
}