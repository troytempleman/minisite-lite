<?php
/**
 * Feaures page
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Add Help page
function features_admin_menu() {
	add_theme_page(
		esc_html__( 'Features','minisite-lite' ),
		esc_html__( 'Features','minisite-lite' ),
		'switch_themes',
		'features',
		'features_page'
	);
}
add_action( 'admin_menu', 'features_admin_menu' );

// Help page
function features_page() {
	$table_head_1		= esc_html__( 'Features', 'minisite-lite' );
	$table_head_2		= esc_html__( 'Minisite Lite', 'minisite-lite' );
	$table_head_3		= esc_html__( 'Minisite Pro', 'minisite-lite' );
	$table_row_1_1		= '<strong>' . esc_html__( 'Standard Features', 'minisite-lite' ) . '</strong>';
	$table_row_1_2		= esc_html__( '', 'minisite-lite' );
	$table_row_1_3		= esc_html__( '', 'minisite-lite' );
	$table_row_2_1		= esc_html__( 'Mobile Friendly', 'minisite-lite' );
	$table_row_2_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_2_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_3_1		= esc_html__( 'User Friendly Navigation', 'minisite-lite' );
	$table_row_3_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_3_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_4_1		= esc_html__( 'Live Customizer', 'minisite-lite' );
	$table_row_4_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_4_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_5_1		= esc_html__( 'SEO Friendly', 'minisite-lite' );
	$table_row_5_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_5_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_6_1		= esc_html__( 'WooCommerce Support', 'minisite-lite' );
	$table_row_6_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_6_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_7_1		= esc_html__( 'Translation & RTL Ready', 'minisite-lite' );
	$table_row_7_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_7_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_8_1		= esc_html__( 'Icon Fonts', 'minisite-lite' );
	$table_row_8_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_8_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_9_1		= esc_html__( 'Demo Import', 'minisite-lite' );
	$table_row_9_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_9_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_10_1		= '<strong>' . esc_html__( 'Sections', 'minisite-lite' ) . '</strong>';
	$table_row_10_2		= esc_html__( '', 'minisite-lite' );
	$table_row_10_3		= esc_html__( '', 'minisite-lite' );
	$table_row_11_1		= esc_html__( 'Header Section', 'minisite-lite' );
	$table_row_11_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_11_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_12_1		= esc_html__( 'About Section', 'minisite-lite' );
	$table_row_12_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_12_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_13_1		= esc_html__( 'Facts Section', 'minisite-lite' );
	$table_row_13_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_13_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_14_1		= esc_html__( 'Services Section', 'minisite-lite' );
	$table_row_14_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_14_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_15_1		= esc_html__( 'Team Section', 'minisite-lite' );
	$table_row_15_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_15_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_16_1		= esc_html__( 'News Section', 'minisite-lite' );
	$table_row_16_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_16_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_17_1		= esc_html__( 'Call to Action Section', 'minisite-lite' );
	$table_row_17_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_17_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_18_1		= esc_html__( 'Contact Form', 'minisite-lite' );
	$table_row_18_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_18_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_19_1		= esc_html__( 'Google Map', 'minisite-lite' );
	$table_row_19_2		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_19_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_20_1		= esc_html__( 'Notification Bar', 'minisite-lite' );
	$table_row_20_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_20_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_21_1		= esc_html__( 'Gallery Section', 'minisite-lite' );
	$table_row_21_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_21_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_22_1		= esc_html__( 'Testimonials Section', 'minisite-lite' );
	$table_row_22_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_22_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_23_1		= esc_html__( 'Pricing Section', 'minisite-lite' );
	$table_row_23_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_23_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_24_1		= esc_html__( 'FAQ Section', 'minisite-lite' );
	$table_row_24_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_24_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_25_1		= esc_html__( 'Newsletter Section', 'minisite-lite' );
	$table_row_25_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_25_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_26_1		= esc_html__( 'Pricing Section', 'minisite-lite' );
	$table_row_26_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_26_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_27_1		= esc_html__( 'FAQ Section', 'minisite-lite' );
	$table_row_27_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_27_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_28_1		= esc_html__( 'Newsletter Sign Up', 'minisite-lite' );
	$table_row_28_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_28_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_29_1		= esc_html__( 'Logos Section', 'minisite-lite' );
	$table_row_29_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_29_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_30_1		= esc_html__( 'Footer Section', 'minisite-lite' );
	$table_row_30_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_30_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_31_1		= '<strong>' . esc_html__( 'Other Features', 'minisite-lite' ) . '</strong>';
	$table_row_31_2		= esc_html__( '', 'minisite-lite' );
	$table_row_31_3		= esc_html__( '', 'minisite-lite' );
	$table_row_32_1		= esc_html__( 'Section Ordering & Visibility', 'minisite-lite' );
	$table_row_32_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_32_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_33_1		= esc_html__( 'Section Styling', 'minisite-lite' );
	$table_row_33_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_33_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_34_1		= esc_html__( 'Section Widgets', 'minisite-lite' );
	$table_row_34_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_34_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_35_1		= esc_html__( 'Header Carousel', 'minisite-lite' );
	$table_row_35_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_35_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_36_1		= esc_html__( 'Social Sharing', 'minisite-lite' );
	$table_row_36_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_36_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_37_1		= esc_html__( 'Typography', 'minisite-lite' );
	$table_row_37_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_37_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_38_1		= esc_html__( 'Animations & Parallax Effects', 'minisite-lite' );
	$table_row_38_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_38_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_39_1		= esc_html__( 'Minify & Concatenate', 'minisite-lite' );
	$table_row_39_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_39_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_40_1		= esc_html__( 'Support', 'minisite-lite' );
	$table_row_40_2		= '<span class="dashicons-before dashicons-dismiss" style="color:#CA4A20"></span> <span class="screen-reader-text">' . esc_html__( 'No', 'minisite-lite' );
	$table_row_40_3		= '<span class="dashicons-before dashicons-yes-alt" style="color:#31843f"></span> <span class="screen-reader-text">' . esc_html__( 'Yes', 'minisite-lite' );
	$table_row_41_1		= '<strong>' . esc_html__( 'Price', 'minisite-lite' ) . '</strong>';
	$table_row_41_2		= '<strong>' . esc_html__( 'FREE', 'minisite-lite' ) . '</strong>';
	$table_row_41_3		= '<strong>' . esc_html__( 'US $45', 'minisite-lite' ) . '</strong>';
	$table_row_42_1		= esc_html__( '', 'minisite-lite' );
	$table_row_42_2		= '';
	$table_row_42_3		= '<a href="https://www.getminisites.com/theme/#pricing" target="_blank" class="button button-primary button-hero">' . esc_html__( 'Buy Now', 'minisite-lite' ) . '</span>';
	?>
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="nav-tab-2-content is-fullwidth">
			<p class="about-description"></p>
			<table class="wp-list-table widefat striped">
	            <thead>
					<tr>
						<th>
							<?php echo $table_head_1 ?>
						</th>
						<th style="text-align:right">
							<?php echo $table_head_2?>
						</th>
						<th style="text-align:right">
							<?php echo $table_head_3 ?>
						</th>
					</tr>
				</thead>
	            <tbody>
					<tr>
						<td class="column-title">
							<strong><?php echo $table_row_1_1 ?></strong>
						</td>
						<td class="column-description" style="text-align:right">
						</td>
						<td class="column-description" style="text-align:right">
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_2_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_2_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_2_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_3_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_3_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_3_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_4_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_4_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_4_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_5_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_5_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_5_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_6_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_6_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_6_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_7_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_7_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_7_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_8_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_8_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_8_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_9_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_9_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_9_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_10_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_10_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_10_3 ?>
						</td>
					</tr>
				
					<tr>
						<td class="column-title">
							<?php echo $table_row_11_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_11_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_11_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_12_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_12_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_12_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_13_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_13_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_13_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_14_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_14_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_14_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_15_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_15_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_15_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_16_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_16_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_16_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_17_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_17_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_17_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_18_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_18_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_18_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_19_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_19_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_19_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_20_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_20_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_20_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_21_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_22_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_23_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_25_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_25_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_25_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_26_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_26_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_26_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_27_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_27_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_27_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_28_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_28_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_28_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_29_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_29_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_29_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_30_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_30_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_30_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_31_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_31_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_31_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_32_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_32_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_32_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_33_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_33_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_33_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_34_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_34_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_34_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_35_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_35_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_35_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_36_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_36_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_36_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_37_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_37_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_37_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_38_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_38_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_38_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_39_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_39_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_39_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_40_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_40_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_40_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_41_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_41_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_41_3 ?>
						</td>
					</tr>
					<tr>
						<td class="column-title">
							<?php echo $table_row_42_1 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_42_2 ?>
						</td>
						<td class="column-description" style="text-align:right">
							<?php echo $table_row_42_3 ?>
						</td>
					</tr>
	            </tbody>
	        </table>
		</div>
	</div>
<?php
}
