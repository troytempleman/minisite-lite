<?php
/**
 * Admin Header
 */
	// Theme Data
	$theme = wp_get_theme();
	$parent_theme = wp_get_theme(get_template());
	$parent_theme_name = $parent_theme->get( 'Name' );
	$theme_description = $theme->Description;
	$theme_author = $theme->display( 'Author', FALSE );
	$theme_author_uri = $theme->display( 'AuthorURI' );
	$theme_version = $theme->Version;
	$tab_1_text = esc_html__( 'About', 'minisite-lite' );
	$tab_1_link = 'minisite';
	$tab_2_text = esc_html__( 'Features', 'minisite-lite' );
	$tab_2_link = 'features';
	$tab_3_text = esc_html__( 'Help', 'minisite-lite' );
	$tab_3_link = 'help';
?>
<h1><?php echo $parent_theme_name; ?> <span class="admin-theme-author">by <a href="<?php echo $theme_author_uri; ?>" target="_blank"><?php echo $theme_author; ?></a></span>			
</h1>
<div class="about-text">
	<?php echo $theme_description; ?>	
</div>
<div class="wp-badge ms-badge">Version <?php echo $theme_version; ?></div>
<h2 class="admin-nav nav-tab-wrapper">
	<a href="?page=<?php echo $tab_1_link; ?>" class="nav-tab-1 nav-tab"><?php echo $tab_1_text; ?></a>
	<a href="?page=<?php echo $tab_2_link; ?>" class="nav-tab-2 nav-tab"><?php echo $tab_2_text; ?></a>
	<a href="?page=<?php echo $tab_3_link; ?>" class="nav-tab-3 nav-tab"><?php echo $tab_3_text; ?></a>
</h2>