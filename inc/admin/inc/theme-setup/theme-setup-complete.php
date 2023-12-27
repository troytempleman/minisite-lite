<?php
/**
 * Theme Setup Complete
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Add Theme Setup Complete page
function add_theme_setup_complete_page() {
	
	add_theme_page(
		esc_html__( 'Theme Setup Complete','minisite-lite' ),
		esc_html__( 'Theme Setup Complete','minisite-lite' ),
		'switch_themes',
		'theme-setup-complete',
		'theme_setup_complete_page'
	);
}
add_action( 'admin_menu', 'add_theme_setup_complete_page' );

// Theme Setup Complete page
function theme_setup_complete_page() {
	$theme_setup_complete_title 		= esc_html__( 'Setup Complete', 'minisite-lite' );
	$theme_setup_complete_text_1 		= esc_html__( 'Congratulations, your theme has been setup and is ready to use!', 'minisite-lite'  );
	$theme_setup_complete_links 		= sprintf( '<li><a href="%1$s" target="_blank">%2$s</a></li><li><a href="%3$s" target="_blank">%4$s</a></li><li><a href="%5$s" target="_blank">%6$s</a></li>', 'https://wordpress.org/support/article/first-steps-with-wordpress-classic/', esc_html__( 'First Steps with WordPress', 'minisite-lite' ), admin_url(), esc_html__( 'WordPress Dashboard', 'minisite-lite' ), 'https://wordpress.org/support/', esc_html__( 'WordPress Support', 'minisite-lite' ) );
	$theme_setup_complete_button_1 		= sprintf( '<a class="button button-primary button-hero" href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Customize Your Site', 'minisite-lite' ) );
	$theme_setup_complete_button_2 		= sprintf( '<a class="button button-hero" href="%1$s" target="_blank">%2$s</a>', home_url(), esc_html__( 'View Your Site', 'minisite-lite' ) );
	$theme_setup_image 					= get_template_directory_uri() . '/inc/admin/img/theme-setup-complete.svg';
	?>
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="welcome-panel admin-welcome-panel theme-setup-complete">
			<div class="has-2-columns is-fullwidth">
				<div class="column col">
					<h3><?php echo $theme_setup_complete_title; ?></h3>
					<p><?php echo $theme_setup_complete_text_1; ?></p>
					<ul><?php echo $theme_setup_complete_links; ?></ul>
					<div class="buttons ">
						<?php echo $theme_setup_complete_button_1; ?>
						<?php echo $theme_setup_complete_button_2 ?>
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
