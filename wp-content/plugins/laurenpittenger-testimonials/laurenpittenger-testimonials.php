<?php
/**
* Plugin Name: Lauren Pittenger Testimonials
* Description: A simple testimonials custom post type with meta fields
* Author: Lauren Pittenger
* Version: 1.0
*/

/* Set up the post type */
add_action( 'init', 'lp_testimonials_register_post_type' );

/**
 * Register the 'lp_testimonials' post type
 *
 * @since 1.0
 *
 * @uses register_post_type()
 */
function lp_testimonials_register_post_type() {

	/* Set up arguements for the staff post type */
	$testimonials_args = array(
		'public' => true,
		'query_var' => 'testimonials',
		'supports' => array(
			'title',
			'thumbnail',
			'excerpt',
			'editor'
		),
		'rewrite' => array( 'slug' => 'testimonials' ),
		'labels' => array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial',
			'add_new' => 'Add New Testimonial Item',
			'add_new_item' => 'Add New Testimonial Item',
			'edit_item' => 'Edit Testimonial Item',
			'new_item' => 'New Testimonial Item',
			'view_item' => 'View Testimonial Item',
			'search_items' => 'Search Testimonials',
			'not_found' => 'No Testimonial Items Found',
			'not_found_in_trash' => 'No Testimonial Items Found In Trash'
		),
		'has_archive' => true,
		'menu_position' => 5,
	);

	/* Register the staff post type */
	register_post_type( 'lp_testimonials', $testimonials_args );

}
