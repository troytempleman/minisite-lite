<?php
/**
 * Minisite Scripts
 */

function minisite_scripts() {
	
	// Bootstrap core CSS 
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.3.1' );
	
	// Fonts
	wp_enqueue_style( 'theme-fonts', get_template_directory_uri() . '/fonts/metropolis/stylesheet.css' );
		
	// Parent stylesheet
	if ( is_child_theme() ) {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	}

	// Theme stylesheet
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
	
	// RTL language
	if ( get_theme_mod( 'right_to_left_language' , '' ) ) {
		wp_enqueue_style( 'right-to-left-style', get_template_directory_uri() . '/css/rtl.css' );
	}
	
	// Bootstrap core JavaScript
	wp_enqueue_script( 'bootstrap-popper-js', get_template_directory_uri() . '/js/popper.min.js', array(), '1.14.7', true );  
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '4.3.1', true );  

	// Mobile Menu Toggle
	wp_enqueue_script( 'minisite-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	
	// Skip Link Focus Fix
	wp_enqueue_script( 'minisite-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Comment Form
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'minisite_scripts' );

// Editor Styles
function minisite_editor_styles() {
	
	// Theme stylesheet
    add_editor_style( get_stylesheet_uri() );
}
add_action( 'admin_init', 'minisite_editor_styles' );
