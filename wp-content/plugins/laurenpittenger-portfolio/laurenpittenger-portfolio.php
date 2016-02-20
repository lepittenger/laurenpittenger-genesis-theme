<?php
/**
* Plugin Name: Lauren Pittenger Portfolio
* Description: A simple portfolio custom post type with meta fields
* Author: Lauren Pittenger
* Version: 1.0
*/

/* Set up the post type */
add_action( 'init', 'laurenpittenger_portfolio_register_post_type' );

/**
 * Register the 'lbd_staff' post type
 *
 * @since 1.0
 *
 * @uses register_post_type()
 */
function laurenpittenger_portfolio_register_post_type() {

	/* Set up arguements for the staff post type */
	$portfolio_args = array(
		'public' => true,
		'query_var' => 'portfolio',
		'supports' => array(
			'title',
			'thumbnail',
			'excerpt',
			'editor'
		),
		'rewrite' => array( 'slug' => 'portfolio' ),
		'labels' => array(
			'name' => 'Portfolio',
			'singular_name' => 'Portfolio',
			'add_new' => 'Add New Portfolio Item',
			'add_new_item' => 'Add New Portfolio Item',
			'edit_item' => 'Edit Portfolio Item',
			'new_item' => 'New Portfolio Item',
			'view_item' => 'View Portfolio Item',
			'search_items' => 'Search Portfolio',
			'not_found' => 'No Portfolio Items Found',
			'not_found_in_trash' => 'No Portfolio Items Found In Trash'
		),
		'has_archive' => true,
		'menu_position' => 5,
	);

	/* Register the staff post type */
	register_post_type( 'lp_portfolio', $portfolio_args );

}

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Portfolio Categories', 'text_domain' ),
		'all_items'                  => __( 'All Portfolio Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Portfolio Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Portfolio Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Category Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Portfolio Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Portfolio Category', 'text_domain' ),
		'update_item'                => __( 'Update Portfolio Category', 'text_domain' ),
		'view_item'                  => __( 'View Portfolio Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'portfolio_categories', array( 'lp_portfolio' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy', 0 );

// Register Custom Taxonomy
function skills_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Skills', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Skills', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Skills', 'text_domain' ),
		'all_items'                  => __( 'All Skills', 'text_domain' ),
		'parent_item'                => __( 'Parent Skill', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Skill:', 'text_domain' ),
		'new_item_name'              => __( 'New Skill Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Skill', 'text_domain' ),
		'edit_item'                  => __( 'Edit Skill', 'text_domain' ),
		'update_item'                => __( 'Update Skill', 'text_domain' ),
		'view_item'                  => __( 'View Skill', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'           => array( 'slug' => 'skills' ),
	);
	register_taxonomy( 'portfolio_skills', array( 'lp_portfolio' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'skills_custom_taxonomy', 0 );
