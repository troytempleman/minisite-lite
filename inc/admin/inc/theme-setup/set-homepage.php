<?php
/**
 * Set Homepage
 */

// Add Admin page
function set_homepage_admin_menu() {
	
	add_theme_page(
		esc_html__( 'Set Homepage','minisite-lite' ),
		esc_html__( 'Set Homepage','minisite-lite' ),
		'switch_themes',
		'set-homepage',
		'set_homepage_page'
	);
}
add_action( 'admin_menu', 'set_homepage_admin_menu' );

function set_homepage_page() {
	
	// Content
	$set_homepage_title = esc_html__( 'Set Homepage', 'minisite-lite' );
	$set_homepage_text = sprintf( 'By default, WordPress displays your latest posts on the homepage. This sets your homepage to a static page that has the homepage template assigned to it. These settings can be changed anytime on the <a href="%1$s" target="_blank">%2$s</a> page.', admin_url( 'options-reading.php' ), esc_html__( 'Reading Settings', 'minisite-lite' ) );
	$set_homepage_link = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/article/settings-reading-screen/', esc_html__( 'Learn more about homepages', 'minisite-lite' ) );
	$set_homepage_button_1 	= sprintf( '<input type="submit" name="Submit" class="button button-primary button-hero" value="%1$s"/>', esc_html__('Set Homepage', 'minisite-lite') );
	$set_homepage_button_2 	= sprintf( '<a class="next-button button button-hero" href="%1$s">%2$s</a>', admin_url( 'themes.php?page=theme-setup-complete' ), esc_html__( 'Next', 'minisite-lite' ) );
	$set_homepage_image 	= get_template_directory_uri() . '/inc/admin/img/set-homepage.svg';

    // Variables for the field and option names 
    $option_name_1 = 'show_on_front';
	$option_name_2 = 'page_on_front';
	//$option_name_3 = 'page_for_posts';
    $hidden_field_name = 'set_homepage_hidden_field';
    $data_field_name_1 = 'show_on_front';
	$data_field_name_2 = 'page_on_front';
	//$data_field_name_3 = 'page_for_posts';
	
	// Set new values
	$homepage_displays = 'page';
	$homepage = get_page_by_title( 'Home', '', 'page' )->ID;
	//$posts_page = get_page_by_title( '', '', 'page' )->ID;

    // Read existing option value
    $option_value_1 = get_option( $option_name_1 );
	$option_value_2 = get_option( $option_name_2 );
	//$option_value_3 = get_option( $option_name_3 );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
       
	    // Read posted values
        $option_value_1 = $_POST[ $data_field_name_1 ];
		$option_value_2 = $_POST[ $data_field_name_2 ];
		//$option_value_3 = $_POST[ $data_field_name_3 ];

        // Save posted values
        update_option( $option_name_1, $option_value_1 );
		update_option( $option_name_2, $option_value_2 );
		//update_option( $option_name_3, $option_value_3 );

	    // Settings saved message
		?>
		<div class="set-homepage-notice"><p><strong><?php _e('Homepage set!', 'minisite-lite' ); ?></strong></p></div>
		<?php
	}
    ?>	
	<div class="about-wrap wrap">
		<?php include get_template_directory() . '/inc/admin/inc/header.php'; ?>
		<div class="welcome-panel admin-welcome-panel theme-setup">
			<div class="has-2-columns is-fullwidth">
				<div class="column col">
					<h3><?php echo $set_homepage_title; ?></h3>
					<p><?php echo $set_homepage_text; ?></p>
					<p><?php echo $set_homepage_link; ?></p>
					<form name="form1" method="post" action="">
					<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
					<input type="hidden" name="<?php echo $data_field_name_1; ?>" value="<?php echo $homepage_displays; ?>" size="20">
					<input type="hidden" name="<?php echo $data_field_name_2; ?>" value="<?php echo $homepage; ?>" size="20">
					<div class="buttons">
						<?php echo $set_homepage_button_1; ?>
						<?php echo $set_homepage_button_2; ?>
					</div>
					</form>
				</div>
				<div class="theme-setup-image column col">
					<img src="<?php echo $set_homepage_image; ?>">
				</div>
			</div>
		</div>
		<?php include get_template_directory() . '/inc/admin/inc/about.php'; ?>
	</div>
	<?php
}