<?php
/**
 * Bootstrap Multi Dropdown Navbar 
 */

// Scripts
function bootstrap_multi_dropdown_navbar_scripts() {

	wp_enqueue_script( 'toggle-dropdown', get_template_directory_uri() . '/inc/bootstrap-multi-dropdown-navbar/js/bootstrap-multi-dropdown-navbar.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'bootstrap_multi_dropdown_navbar_scripts', 1 );