<?php
/**
 * Functions and Definitions
 */

// Setup
require get_template_directory() . '/inc/functions/setup.php';

// Content Width
require get_template_directory() . '/inc/functions/content-width.php';

// Widgets
require get_template_directory() . '/inc/functions/widgets.php';

// Scripts
require get_template_directory() . '/inc/functions/scripts.php';

// Custom Header
require get_template_directory() . '/inc/functions/custom-header.php';

// Template Tags
require get_template_directory() . '/inc/functions/template-tags.php';

// Template Functions
require get_template_directory() . '/inc/functions/template-functions.php';

// Helper Functions
require get_template_directory() . '/inc/functions/helper-functions.php';

// Customizer 
require get_template_directory() . '/inc/customizer/customizer.php';

// Admin
require get_template_directory() . '/inc/admin/admin.php';

// Bootstrap Nav Walker
require get_template_directory() . '/inc/bootstrap-navwalker/bootstrap-navwalker.php';

// Bootstrap Multi Dropdown Navbar 
require get_template_directory() . '/inc/bootstrap-multi-dropdown-navbar/bootstrap-multi-dropdown-navbar.php';

// Homepage Sections
if ( get_theme_mod( 'homepage_sections' , '' ) ) {
	
	// Homepage About Section
	if ( get_theme_mod( 'homepage_about_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-about-section/homepage-about-section.php';
	}
	
	// Homepage Call to Action Section
	if ( get_theme_mod( 'homepage_call_to_action_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-call-to-action-section/homepage-call-to-action-section.php';
	}

	// Homepage Contact Section
	if ( get_theme_mod( 'homepage_contact_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-contact-section/homepage-contact-section.php';
	}

	// Homepage Facts Section
	if ( get_theme_mod( 'homepage_facts_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-facts-section/homepage-facts-section.php';
	}

	// Homepage Header Section
	if ( get_theme_mod( 'homepage_header_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-header-section/homepage-header-section.php';
	}
	
	// Homepage Map Section
	if ( get_theme_mod( 'homepage_map_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-map-section/homepage-map-section.php';
	}

	// Homepage News Section
	if ( get_theme_mod( 'homepage_news_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-news-section/homepage-news-section.php';
	}
	
	// Homepage Services Section
	if ( get_theme_mod( 'homepage_services_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-services-section/homepage-services-section.php';
	}

	// Homepage Team Section
	if ( get_theme_mod( 'homepage_team_section' , '' ) ) {
		require get_template_directory() . '/inc/homepage-sections/homepage-team-section/homepage-team-section.php';
	}
}

// Icon Fonts
if ( get_theme_mod( 'icon_fonts' , '' ) ) {
	require get_template_directory() . '/inc/icon-fonts/icon-fonts.php';
}

// Jetpack compatibility file
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/functions/jetpack.php';
}

// Navbar Scroll
if ( get_theme_mod( 'navbar_scroll' , '' ) ) {
	require get_template_directory() . '/inc/navbar-scroll/navbar-scroll.php';
}

// Search Collapse
if ( get_theme_mod( 'search_collapse' , true ) ) {
	require get_template_directory() . '/inc/search-collapse/search-collapse.php';
}

// Smooth Scroll
if ( get_theme_mod( 'smooth_scroll' , '' ) ) {
	require get_template_directory() . '/inc/smooth-scroll/smooth-scroll.php';
}

// WooCommerce compatibility file
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/woocommerce/woocommerce.php';
}
