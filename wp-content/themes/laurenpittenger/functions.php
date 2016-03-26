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
add_image_size( 'portfolio', 340, 230, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 90,
	'width'           => 300,
) );

//* Remove sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Force full-width-content layout setting
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

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

add_filter( 'genesis_post_meta', 'lp_post_meta_filter' );
//* remove the post meta on portfolio category posts
function lp_post_meta_filter($post_meta) {
	if ( !in_category('portfolio') && is_single() ) {
		$post_meta = '[post_categories before="Filed Under: "] [post_tags before="Tagged: "]';
		return $post_meta;
	}
}

add_filter( 'genesis_post_info', 'lp_post_info_filter' );
//* remove the post info on portfolio category posts
function lp_post_info_filter($post_info) {
	if ( !in_category('portfolio') ) {
		$post_info = '[post_date] [post_comments] [post_edit]';
		return $post_info;
	}
}

//* Display the contents of 'Home - About' widget area
add_action( 'genesis_before_loop', 'sk_home_about' );
function sk_home_about() {

	if (! is_front_page() )
		return;

	genesis_widget_area( 'home-about', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="widget-area"><div class="wrap">',
		'after'  => '</div></div></div>',
	) );

}

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

		if( is_category() ) {
			$headline = 'Posts in category: '. $headline;
		} else if ( is_tag() ) {
			$headline = 'Posts tagged: '. $headline;
		} else if ( is_tax() ) {
			'Posts in: '. $headline;
		}

	return $headline;
}
add_filter( 'genesis_term_meta_headline', 'be_default_category_title', 10, 2 );

// favicon for admin dashboard
function admin_favicon() {
  echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_bloginfo( 'stylesheet_directory' ) . '/images/favicon-admin.ico" />';
}
add_action( 'admin_head', 'admin_favicon' );

// Custom login logo
function custom_login_logo() {
    echo '<style type="text/css">
    h1 a {
	    background-image:url('.get_bloginfo('stylesheet_directory').'/images/custom-login-logo.png) !important;
    }
    </style>';
}
add_action('login_head', 'custom_login_logo');

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
