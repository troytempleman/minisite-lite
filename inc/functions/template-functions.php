<?php
/**
 * Template Functions
 */

// Adds custom classes to the array of body classes.
function minisite_body_classes( $classes ) {
	
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'minisite_body_classes' );

// Add a pingback url auto-discovery header for single posts, pages, or attachments.
function minisite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'minisite_pingback_header' );
