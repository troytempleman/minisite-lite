<?php
/**
 * Theme Setup
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Redirect to Minisite page
if ( isset($_GET['activated']) && $pagenow == "themes.php") {
	wp_redirect('themes.php?page=minisite');
}

// Minisite page
function minisite_admin_menu() {
	add_theme_page(
		esc_html__( 'Minisite','minisite-lite' ),
		esc_html__( 'Minisite','minisite-lite' ),
		'switch_themes',
		'minisite',
		'minisite_page'
	);
}
add_action( 'admin_menu', 'minisite_admin_menu' );

// Theme Setup page
function minisite_page() {
	$theme_setup_title 		= esc_html__( 'Theme Setup', 'minisite-lite' );
	$theme_setup_text 		= sprintf( 'This setup wizard will create a child theme, install plugins, import demo content and set your homepage to match the <a href="%1$s" target="_blank">%2$s</a>. It is not required but may help in getting a head start in customizing your site.', 'https://getminisites.com/theme/minisite-lite/', esc_html__( 'demo site', 'minisite-lite' ) );
	$theme_setup_link 		= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/article/using-themes/', esc_html__( 'Learn more about themes', 'minisite-lite' ) );
	$theme_setup_button_1 	= sprintf( '<a class="start-button button button-primary button-hero" href="%1$s">%2$s</a>', admin_url( 'themes.php?page=create-child-theme' ), esc_html__( 'Start Setup', 'minisite-lite' ) );
	$theme_setup_button_2 	= sprintf( '<button class="exit-button button button-hero" href="">%2$s</a>', '', esc_html__( 'Exit Setup', 'minisite-lite' ) );
	$theme_setup_image 		= get_template_directory_uri() . '/inc/admin/img/theme-setup.svg';
	?>
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="welcome-panel admin-welcome-panel theme-setup">
			<div class="has-2-columns is-fullwidth">
				<div class="column col">
					<h3><?php echo $theme_setup_title; ?></h3>
					<p><?php echo $theme_setup_text; ?></p>
					<p><?php echo $theme_setup_link; ?></p>
					<div class="buttons">
						<?php echo $theme_setup_button_1; ?>
						<?php echo $theme_setup_button_2; ?>
					</div>
				</div>
				<div class="theme-setup-image column col">
					<img src="<?php echo $theme_setup_image; ?>">
				</div>
			</div>
		</div>
		<?php include get_template_directory() . '/inc/admin/inc/about.php'; ?>
	</div>
<?php
}
