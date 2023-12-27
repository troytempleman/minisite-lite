<?php
/**
 * Admin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Exit if not Admin
if ( ! is_admin() ) { return; }

// Scripts
function admin_scripts() {
	wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/inc/admin/css/style.css' );
	wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/inc/admin/js/admin.js', array(), '', true ); 
}
add_action( 'admin_enqueue_scripts', 'admin_scripts', 100 );

// Theme Setup
require dirname( __FILE__ ) . '/inc/theme-setup/theme-setup.php';

// Create Child Theme
require dirname( __FILE__ ) . '/inc/theme-setup/create-child-theme.php';

// Install Plugins
require dirname( __FILE__ ) . '/inc/theme-setup/install-plugins/install-plugins.php';

// Import Demo
require dirname( __FILE__ ) . '/inc/theme-setup/import-demo/import-demo.php';

// Set Homepage
require dirname( __FILE__ ) . '/inc/theme-setup/set-homepage.php';

// Theme Setup
require dirname( __FILE__ ) . '/inc/theme-setup/theme-setup-complete.php';

// Upgrade
require dirname( __FILE__ ) . '/inc/features.php';

// Help
require dirname( __FILE__ ) . '/inc/help.php';

// Hide Admin Menu Pages
function hide_admin_menu_pages() {
	remove_submenu_page( 'themes.php', 'create-child-theme' );
	remove_submenu_page( 'themes.php', 'install-plugins' );
	remove_submenu_page( 'themes.php', 'import-demo' );
	remove_submenu_page( 'themes.php', 'set-homepage' );
	remove_submenu_page( 'themes.php', 'theme-setup-complete' );
	remove_submenu_page( 'themes.php', 'features' );
	remove_submenu_page( 'themes.php', 'help' );
}
add_action( 'admin_init', 'hide_admin_menu_pages' );
