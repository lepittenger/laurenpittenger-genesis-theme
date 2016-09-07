<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'lp', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'lp' ) );

//* Add custom site initial field to Theme Customizer
add_action( 'customize_register', 'lp_customizer' );
function lp_customizer(){

	require_once( get_stylesheet_directory() . '/lib/customize.php' );

}

//* Include custom site initial CSS output
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Lauren Pittenger', 'lp' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/modern-portfolio/' );
define( 'CHILD_THEME_VERSION', '2.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'lp_load_scripts' );
function lp_load_scripts() {

	wp_enqueue_script( 'lp-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'google-fonts-roboto', '//fonts.googleapis.com/css?family=Roboto:300,500,900', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'google-fonts-playfair', '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,900,700italic,900italic', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );

}

//* Add new image sizes
add_image_size( 'blog', 340, 140, TRUE );
add_image_size( 'blog-lg', 740, 240, TRUE );
add_image_size( 'portfolio', 340, 230, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 100,
	'width'           => 252,
) );

//* force full width layout on single portfolios
add_filter( 'genesis_site_layout', 'lp_portfolio_layout' );
function lp_portfolio_layout() {
    if( 'lp_portfolio' == get_post_type() ) {
        return 'full-width-content';
    }
}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'lp_secondary_menu_args' );
function lp_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'lp_author_box_gravatar_size' );
function lp_author_box_gravatar_size( $size ) {

	return 80;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'lp_remove_comment_form_allowed_tags' );
function lp_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-about',
	'name'        => __( 'Home - About','lp' ),
	'description' => __( 'This is the about section of the homepage.','lp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-portfolio',
	'name'        => __( 'Home - Portfolio','lp' ),
	'description' => __( 'This is the portfolio section of the homepage.','lp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-services',
	'name'        => __( 'Home - Services','lp' ),
	'description' => __( 'This is the Services section of the homepage.','lp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-blog',
	'name'        => __( 'Home - Blog','lp' ),
	'description' => __( 'This is the Blog section of the homepage.','lp' ),
) );

// Add Read More Link to Excerpts
add_filter('excerpt_more', 'get_read_more_link');
add_filter( 'the_content_more_link', 'get_read_more_link' );
function get_read_more_link() {
   return '... <a href="' . get_permalink() . '" class="read-more">Read&nbsp;More</a>';
}

// add headings to categories, tags & custom taxonomies if any
function be_default_category_title( $headline, $term ) {
	if( ( is_category() || is_tag() || is_tax() ) && empty( $headline ) )
		$headline = $term->name;

	return $headline;
}
add_filter( 'genesis_term_meta_headline', 'be_default_category_title', 10, 2 );

// Custom login logo
add_action('login_head', 'custom_login_logo');
function custom_login_logo() {
    echo '<style type="text/css">
    h1 a {
	    background-image:url('.get_bloginfo('stylesheet_directory').'/images/custom-login-logo.png) !important;
			background-size: 320px 127px !important;
			width: 320px !important;
			height: 127px !important;
    }
    </style>';
}

//* Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'highspire_custom_footer' );
function highspire_custom_footer() {
	?>
	<p>&copy; Copyright 2012 - <?php echo date('Y'); ?> <a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name'); ?></a>, all rights reserved. Site by me, of course.</p>
	<?php
}

add_filter( 'pre_get_posts', 'be_archive_query' );
// @link http://www.billerickson.net/customize-the-wordpress-query/
function be_archive_query( $query ) {
	if( $query->is_main_query() && $query->is_post_type_archive('lp_portfolio') ) {
		$query->set( 'posts_per_page', 24 );
	}
}

// Move image above post title in Genesis Framework 2.0
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

// add ability to hide GF labels
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// don't show post meta on pages and portfolio singles
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	if ( !is_page() && !('lp_portfolio' == get_post_type() ) ) {
		$post_info = '[post_date] [post_comments] [post_edit]';
		return $post_info;
	}
}

// Add website verification meta tag for Pinterest
add_action( 'genesis_meta', 'lp_pinterest_meta_tag' );
function sp_viewport_meta_tag() {
	echo '<meta name="p:domain_verify" content="807bb20b2b2b5e0c96a901fac7e5e38f"/>';
}
