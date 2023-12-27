<?php
/**
 * Admin Content
 */
	$section_1_title	= esc_html__( 'Features', 'minisite-lite' );
	$feature_1_image	= get_template_directory_uri() . '/inc/admin/img/mobile-friendly.png';
	$feature_1_title	= esc_html__( 'Mobile Friendly', 'minisite-lite' );
	$feature_1_text		= esc_html__( 'More than half of all web traffic in the world is displayed on mobile devices. To accommodate this, Minisite is optimized for mobile devices. It uses Responsive Web Design (RWD) to automatically reconfigure its layout to fit the screen size and shape of the device it\'s being viewed on, creating the optimum user experience whether it\'s phone, tablet, laptop or desktop.', 'minisite-lite' );	
	$feature_1_link		= sprintf( '<a class="button" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/', esc_html__( 'Learn More', 'minisite-lite' ) );
	$feature_2_title	= esc_html__( 'User Friendly Navigation', 'minisite-lite' );
	$feature_2_text		= esc_html__( 'Minisite has a sticky navigation bar that sticks to the top of the browser window as the user scrolls down the page, allowing them to quickly access the navigation at anytime and easily jump to different sections. Also, when any on page link is clicked, Minisite smoothly scrolls to the link location, giving the user a sense of where they are on the page and where they are going.', 'minisite-lite' );
	$feature_2_link		= sprintf( '<a class="button" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/', esc_html__( 'Learn More', 'minisite-lite' ) );
	$feature_2_image	= get_template_directory_uri() . '/inc/admin/img/user-friendly-navigation.jpg';
	$feature_3_image	= get_template_directory_uri() . '/inc/admin/img/live-customizer.jpg';
	$feature_3_title	= esc_html__( 'Live Customizer', 'minisite-lite' );
	$feature_3_text		= esc_html__( 'Minisite leverages and extends the native WordPress Theme Customizer, allowing you to easily customize the appearance of your site in a user friendly interface and preview changes live in real time before publishing. Minisite Pro has 15 custom sections to customize with over 1,500 options for content, images, menus, layout, typography, colour and more!', 'minisite-lite' );
	$feature_3_link		= sprintf( '<a class="button" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/', esc_html__( 'Learn More', 'minisite-lite' ) );
	$section_2_title	= esc_html__( 'More Features', 'minisite-lite' );
	$feature_4_title	= esc_html__( 'SEO Friendly', 'minisite-lite' );
	$feature_4_text		= esc_html__( 'Minisite is built using Search Engine Optimization (SEO) best practices, helping increase the quantity and quality of organic search engine traffic to your site.', 'minisite-lite' );
	$feature_5_title	= esc_html__( 'WooCommerce Support', 'minisite-lite' );
	$feature_5_text		= sprintf( 'The <a href="%1$s" target="_blank">%2$s</a> WordPress plugin is one of the most popular eCommerce platforms in the world and Minisite is fully compatible with it, letting you turn your site into a online store with ease.', 'https://woocommerce.com', esc_html__( 'WooCommerce', 'minisite-lite' ) );
	$feature_6_title	= esc_html__( 'Translation and RTL Ready', 'minisite-lite' );
	$feature_6_text		= sprintf( 'Minisite is coded in such a way that it can be easily translated into other languages without modifying the source code. It also supports languages written from right to left (RTL).', 'minisite-lite' );
	$feature_7_title	= esc_html__( 'Icon Fonts', 'minisite-lite' );
	$feature_7_text		= sprintf( 'Minisite comes with over 1,500 icon fonts from <a href="%1$s" target="_blank">%2$s</a> and are packaged with <a href="%3$s" target="_blank">%4$s</a>, making it easy to  add icons to or replace with your own icon font package.', 'https://fontawesome.com/', esc_html__( 'Font Awesome', 'minisite-lite' ), 'https://icomoon.io/', esc_html__( 'IcoMoon', 'minisite-lite' ) );
	$section_2_link		= sprintf( '<a class="button button-hero" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/', esc_html__( 'Learn More', 'minisite-lite' ) );
	$section_3_title	= esc_html__( 'Pro Features', 'minisite-lite' );
	$feature_8_image	= get_template_directory_uri() . '/inc/admin/img/testimonials-section.jpg';
	$feature_8_title	= esc_html__( 'More Sections', 'minisite-lite' );
	$feature_8_text	= __( '<ul style="list-style:disc;padding-left:20px;"><li>Notification Bar</li><li>Gallery Section</li><li>Testimonials Section</li><li>Pricing Section</li><li>FAQ Section</li><li>Newsletter Section</li><li>Logos Section</li><li>Map Section</li><li>Footer Section</li></ul>', 'minisite-lite' );
	$feature_9_image	= get_template_directory_uri() . '/inc/admin/img/call-to-action-section.jpg';
	$feature_9_title	= esc_html__( 'More Section Controls', 'minisite-lite' );
	$feature_9_text		= __( '<ul style="list-style:disc;padding-left:20px;"><li>Font Colours</li><li>Heading Colors</li><li>Background Colors</li><li>Background Images</li><li>Background Overlays</li><li>Padding</li><li>Parallax Effects</li><li>Animations<Le/li><li> Widgets</li></ul>', 'minisite-lite' );
	$feature_10_image	= get_template_directory_uri() . '/inc/admin/img/footer-section.jpg';
	$feature_10_title	= esc_html__( 'More Features', 'minisite-lite' );
	$feature_10_text	= __( '<ul style="list-style:disc;padding-left:20px;"><li>Section Ordering & Visibility</li><li>Section Styling</li><li>Section Widgets</li><li>Header Carousel</li><li>Social Sharing</li><li>Typography</li><li>Animations & Parallax Effects</li><li>Minify & Concatenate</li><li>Support</li></ul>', 'minisite-lite' );
	$section_3_link		= sprintf( '<a class="button button-primary button-hero" href="%1$s" target="_blank">%2$s</a>', 'https://www.getminisites.com/theme/#pricing', esc_html__( 'Upgrade', 'minisite-lite' ) );	
	$footer_link		= sprintf( '<a href="%1$s">%2$s</a>', admin_url() , esc_html__( 'Go to Dashboard &rarr; Home', 'minisite-lite' ) );
?>
<div class="nav-tab-1-content feature-1 has-2-columns is-fullwidth feature-section two-col">
	<div class="column col">
		<img src="<?php echo $feature_1_image; ?>">
	</div>
	<div class="column col">
		<h3><?php echo $feature_1_title; ?></h3>
		<p><?php echo $feature_1_text; ?></p>
		<p><?php echo $feature_1_link; ?></p>
	</div>
</div>
<hr>
<div class="feature-2 has-2-columns is-fullwidth feature-section two-col">
	<div class="column col">
		<h3><?php echo $feature_2_title; ?></h3>
		<p><?php echo $feature_2_text; ?></p>
		<p><?php echo $feature_2_link; ?></p>
	</div>
	<div class="column col">
		<img src="<?php echo $feature_2_image; ?>">
	</div>
</div>
<hr>
<div class="feature-3 has-2-columns is-fullwidth feature-section two-col">
	<div class="column col">
		<img src="<?php echo $feature_3_image; ?>">
	</div>
	<div class="column col">
		<h3><?php echo $feature_3_title; ?></h3>
		<p><?php echo $feature_3_text; ?></p>
		<p><?php echo $feature_3_link; ?></p>
	</div>
</div>
<hr>
<h2><?php echo $section_2_title; ?></h2>
<div class="has-2-columns is-fullwidth feature-section two-col">
	<div class="column col">
		<h3><?php echo $feature_4_title; ?></h3>
		<p><?php echo $feature_4_text; ?></p>
	</div>
	<div class="column col">
		<h3><?php echo $feature_5_title; ?></h3>
		<p><?php echo $feature_5_text; ?></p>
	</div>
	<div class="column col">
		<h3><?php echo $feature_6_title; ?></h3>
		<p><?php echo $feature_6_text; ?></p>
	</div>
	<div class="column col">
		<h3><?php echo $feature_7_title; ?></h3>
		<p><?php echo $feature_7_text; ?></p>
	</div>
</div>
<p style="text-align:center"><?php echo $section_2_link; ?></p>
<hr>
<h2><?php echo $section_3_title; ?></h2>
<div class="has-3-columns is-fullwidth feature-section two-col">
	<div class="column col">
		<img src="<?php echo $feature_8_image; ?>">
		<h3><?php echo $feature_8_title; ?></h3>
		<p><?php echo $feature_8_text; ?></p>
	</div>
	<div class="column col">
		<img src="<?php echo $feature_9_image; ?>">
		<h3><?php echo $feature_9_title; ?></h3>
		<p><?php echo $feature_9_text; ?></p>
	</div>
	<div class="column col">
		<img src="<?php echo $feature_10_image; ?>">
		<h3><?php echo $feature_10_title; ?></h3>
		<p><?php echo $feature_10_text; ?></p>
	</div>
</div>
<p style="text-align:center"><?php echo $section_3_link; ?></p>
<hr>
<div class="return-to-dashboard">
	<?php echo $footer_link; ?>
</div>
