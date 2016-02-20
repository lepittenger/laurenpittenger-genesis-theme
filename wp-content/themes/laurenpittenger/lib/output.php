<?php

//* Add custom site initial CSS
add_action( 'wp_enqueue_scripts', 'modern_portfolio_set_icon' );
function modern_portfolio_set_icon() {

    $handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

    $icon = get_option( 'lp_custom_initial', 'M' );

    if( empty( $icon ) || get_header_image() )
        return;

    $css = sprintf( '.site-title a::before{ content: \'%s\'; }', $icon[0] );

    wp_add_inline_style( $handle, $css );

}