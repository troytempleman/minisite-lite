<?php
/**
 * Helper Functions
 */

// Allow Mime Types 
function allow_mime_types( $mimes ) {
	
	// SVG
	$mimes['svg'] = 'image/svg+xml';
	
	return $mimes;
}
add_filter( 'upload_mimes' , 'allow_mime_types' );

// Disable Emoji's
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

