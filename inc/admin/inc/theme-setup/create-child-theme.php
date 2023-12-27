<?php
/**
 * Create Child Theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Add Admin page
function cct_admin_add_page() {
	
	add_theme_page(
		esc_html__( 'Create Child Theme','minisite-lite' ),
		esc_html__( 'Create Child Theme','minisite-lite' ),
		'switch_themes',
		'create-child-theme',
		'cct_page'
	);
}
add_action( 'admin_menu', 'cct_admin_add_page' );

// Create Child Theme page
function cct_page() {
	$cct_title 		= esc_html__( 'Create Child Theme', 'minisite-lite' );
	$cct_exists		= esc_html__( 'A child theme is already created but you can reset it below if you wish.', 'minisite-lite' );
	$cct_text 		= esc_html__( 'Child themes inherit the functionality and styling of a parent theme. This allows you to make changes, without editing the parent theme, so that the parent theme can be updated without overwriting your changes.', 'minisite-lite' );
	$cct_image 		= get_template_directory_uri() . '/inc/admin/img/create-child-theme.svg';
	$cct_link 		= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://developer.wordpress.org/themes/advanced-topics/child-themes/', esc_html__( 'Learn more about child themes', 'minisite-lite' ) );
	$cct_button_2 	= sprintf( '<a class="button button-hero" href="%1$s">%2$s</a>', admin_url( 'themes.php?page=install-plugins' ), esc_html__( 'Next', 'minisite-lite' ) );
	$theme_directory = get_template_directory() . '-child';
	$results = cct_generator();
	if ( $results === true ) return;
	?>
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="welcome-panel admin-welcome-panel create-child-theme">
			<div class="has-2-columns is-fullwidth">
				<div class="column col">
					<h3><?php echo $cct_title; ?></h3>
					<p>	
						<?php if( file_exists( $theme_directory ) ) : ?>
							<?php echo $cct_exists; ?>
						<?php endif; ?>
						<?php echo $cct_text; ?>
					</p>
					<p><?php echo $cct_link; ?></p>
					<form method="post" action="">
					<?php wp_nonce_field('cct_nonce'); ?>
					<table class="form-table">
					</table>
					<?php
						if( file_exists( $theme_directory ) ) : 
							submit_button( esc_html__('Reset Child Theme', 'minisite-lite'), 'button-primary button-hero', false, false );
						else :
							submit_button( esc_html__('Create Child Theme', 'minisite-lite'), 'button-primary button-hero', false, false );
						endif; 
					?>
					<?php echo $cct_button_2; ?>
					</form>
				</div>
				<div class="theme-setup-image column col">
					<img src="<?php echo $cct_image; ?>">
				</div>
			</div>
		</div>
		<?php include get_template_directory() . '/inc/admin/inc/about.php'; ?>
	</div>
<?php
}

// Child Theme Generator
function cct_generator() {

	// Theme Data
	$theme = wp_get_theme();
	$parent_theme = wp_get_theme(get_template());
	$parent_theme_name = $parent_theme->get( 'Name' );
	$parent_theme_directory = get_template_directory();
	$parent_theme_slug = get_template();
	$theme_name = $parent_theme_name . ' Child';
	$theme_directory = get_template_directory() . '-child';
	$theme_slug = $parent_theme_slug . '-child';
	$theme_uri = $theme->display( 'ThemeURI' );
	$theme_description = $theme->Description;
	$theme_author = $theme->display( 'Author', FALSE );
	$theme_author_uri = $theme->display( 'AuthorURI' );
	$theme_version = $theme->Version;
	$theme_text_domain = $theme->TextDomain;
	$theme_tags = implode(', ', $theme->Tags);

	if ( 'POST' != $_SERVER['REQUEST_METHOD'] )
		return false;
	
	check_admin_referer( 'cct_nonce' );
	
	if( !current_user_can( 'manage_options' ) )
		return false;
	
	$form_fields = array ( $theme_name, $theme_uri, $theme_description, $theme_version, $theme_author, $theme_author_uri );
	$method = ''; // TODO TESTING
	$url = wp_nonce_url( 'themes.php?page=create-child-theme', 'cct_nonce' );
	
	if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $form_fields ) ) ) {
		return true;
	}
	if ( ! WP_Filesystem( $creds ) ) {
		request_filesystem_credentials( $url, $method, true, false, $form_fields );
		return true;
	}
	
	global $wp_filesystem;

	// Create Child Theme directory
	$themedir = $wp_filesystem->wp_themes_dir() . $theme_slug;	
	$wp_filesystem->mkdir( $themedir ) ;

	// Stylesheet
	$themeheader = '/*!
Theme Name: ' . $theme_name .'
Theme URI: ' . $theme_uri . '
Author: ' . $theme_author . '
Author URI: ' . $theme_author_uri . '
Template: ' . $parent_theme_slug . '
Description: ' . $theme_description . '	
Version: ' . $theme_version . '
License: GNU General Public License v2 or later
License URI: LICENSE
Text Domain: ' . $theme_text_domain . '
Tags: ' . $theme_tags . '
*/';
	$themefile = trailingslashit( $themedir ) . 'style.css';
	$wp_filesystem->put_contents( $themefile, $themeheader, FS_CHMOD_FILE );
	$themeslug = $theme_slug. '/' . $theme_slug . '.css';
	
	// Functions
	$functionsheader = '<?php
/** 
* Functions and Definitions 
*/';
	$functionsfile = trailingslashit( $themedir ) . 'functions.php';
	$wp_filesystem->put_contents( $functionsfile, $functionsheader, FS_CHMOD_FILE ) ;
	switch_theme( $parent_theme_slug, $theme_slug  ) ;

	// Screenshot
	copy( $parent_theme_directory . '/screenshot.png', $theme_directory . '/screenshot.png' );

	// Redirect
	$redirect = admin_url( 'themes.php?page=install-plugins' );
	?>
	<script type="text/javascript">
	<!--
	window.location = "<?php echo $redirect; ?>"
	//-->
	</script>
	<?php

	return true;
}
