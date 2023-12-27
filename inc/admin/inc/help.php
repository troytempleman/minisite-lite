<?php
/**
 * Admin Help 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Add Help page
function help_admin_menu() {
	add_theme_page(
		esc_html__( 'Help','minisite-lite' ),
		esc_html__( 'Help','minisite-lite' ),
		'switch_themes',
		'help',
		'help_page'
	);
}
add_action( 'admin_menu', 'help_admin_menu' );

// Help page
function help_page() {
	$column_1_icon 		= 'dashicons-book-alt';
	$column_1_title 	= esc_html__( 'Documentation', 'minisite-lite' );
	$column_1_text 		= sprintf( 'Have a question on how to use Minisite? Please visit the <a href="%1$s" target="_blank">%2$s</a> for a guided tour of Minisite and a user friendly, step-by-step guide with screenshots on how to use it.', 'https://www.getminisites.com/theme/documentation', esc_html__( 'documentation', 'minisite-lite' ) );
	$column_1_button 	= sprintf( '<a class="button button-primary button-hero" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/documentation', esc_html__( 'View Documentation', 'minisite-lite' ) );
	$column_2_icon 		= 'dashicons-sos';
	$column_2_title 	= esc_html__( 'Support', 'minisite-lite' );
	$column_2_text 		= sprintf( 'Have a question that\'s not covered in the <a href="%1$s" target="_blank">%2$s</a>? If you purchased Minisite, please visit the <a href="%3$s" target="_blank">%4$s</a> or <a href="%5$s" target="_blank">%6$s</a> with details of your issue and we\'ll get back to you as soon as possible.', 'https://www.getminisites.com/theme/documentation', esc_html__( 'documentation', 'minisite-lite' ), 'https://www.getminisites.com/theme/support', esc_html__( 'support forum', 'minisite-lite' ), 'https://www.getminisites.com/theme/support/#support-forums', esc_html__( 'submit a ticket', 'minisite-lite' ) );
	$column_2_button 	= sprintf( '<a class="button button-primary button-hero" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/support', esc_html__( 'Support Forum', 'minisite-lite' ) );
	?>
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="nav-tab-3-content has-2-columns is-fullwidth feature-section two-col">
			<div class="column col">
				<span class="dashicons <?php echo $column_1_icon; ?>" style="font-size:48px;width:48px;height:48px;"></span>
				<h3><?php echo $column_1_title; ?></h3>
				<p><?php echo $column_1_text; ?></p>
				<p><?php echo $column_1_button; ?></p>
			</div>
			<div class="column col">
				<span class="dashicons <?php echo $column_2_icon; ?>" style="font-size:48px;width:48px;height:48px;"></span>
				<h3><?php echo $column_2_title; ?></h3>
				<p><?php echo $column_2_text; ?></p>
				<p><?php echo $column_2_button; ?></p>
			</div>
		</div>
	</div>
<?php
}
