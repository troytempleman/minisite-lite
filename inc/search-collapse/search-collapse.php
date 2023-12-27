<?php
/**
 * Search Collapse
 */

// Scripts
function search_collapse_scripts() {
		
	wp_enqueue_script( 'search-collapse', get_template_directory_uri() . '/inc/search-collapse/js/search-collapse.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'search_collapse_scripts' );