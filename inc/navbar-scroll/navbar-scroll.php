<?php
/**
 * Navbar Scroll
 */

// Scripts
function navbar_scroll_scripts() {
		
	wp_enqueue_script( 'navbar-scroll', get_template_directory_uri() . '/inc/navbar-scroll/js/navbar-scroll.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'navbar_scroll_scripts' );
