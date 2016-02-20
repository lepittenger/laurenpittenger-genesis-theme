<?php
/**
 * Controls the "Portfolio" Category archive page output.
 */
//* Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
/**
 * Display as Columns
 *
 */
function be_portfolio_post_class( $classes ) {
	$columns = 3; // Set the number of columns here
	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
	$classes[] = $column_classes[$columns];
	global $wp_query;
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
		$classes[] = 'first';
	return $classes;
}
add_filter( 'post_class', 'be_portfolio_post_class' );
//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
//* Remove the standard post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
//* Show featured image linking to single Post
add_action( 'genesis_entry_content', 'sk_do_post_content' );
function sk_do_post_content() {
	if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
		printf( '<div class="portfolio-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}
}
//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
genesis();
