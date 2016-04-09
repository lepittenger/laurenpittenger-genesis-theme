<?php
/**
 * Controls the homepage output.
 */

add_action( 'wp_enqueue_scripts', 'lp_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function lp_enqueue_scripts() {

	if ( is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-blog' ) ) {
		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
	}
}

add_action( 'genesis_meta', 'lp_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function lp_home_genesis_meta() {

	if ( is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-blog' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add lp-home body class
		add_filter( 'body_class', 'lp_body_class' );

		// Remove the navigation menus
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );

		// Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'lp_homepage_widgets' );

	}

}

function lp_body_class( $classes ) {

	$classes[] = 'lp-home';
	return $classes;

}

function lp_homepage_widgets() {

	genesis_widget_area( 'home-about', array(
		'before' => '<div id="about"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-portfolio', array(
		'before' => '<div id="portfolio"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-services', array(
		'before' => '<div id="services"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-blog', array(
		'before' => '<div id="blog"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
