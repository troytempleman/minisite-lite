<?php
/**
 * Header Template
 */

// Content
$skip_to_content						= __( 'Skip to content', 'minisite-lite' );
$display_navbar							= get_theme_mod( 'display_navbar' , true );
$display_header							= get_theme_mod( 'display_header' , '' );
$display_hamburger_menu					= get_theme_mod( 'display_hamburger_menu' , 'navbar-expand-lg' );
$sticky_navbar							= get_theme_mod( 'sticky_navbar' , '' );
$sticky_homepage_navbar					= get_theme_mod( 'sticky_homepage_navbar' , '' );
$full_width_navbar						= get_theme_mod( 'full_width_navbar' , '' );
$display_logo							= get_theme_mod( 'display_logo' , '' );
$home_url								= home_url();
$site_title								= get_bloginfo( 'name', 'display' );
$site_tagline							= get_bloginfo( 'description', 'display' );
$site_logo								= wp_get_attachment_url( get_theme_mod( 'site_logo' , '' ) );
$display_site_logo_icon					= get_theme_mod( 'display_site_logo_icon' , '' );
$site_logo_icon							= get_theme_mod( 'site_logo_icon' , '' );
$display_site_title						= get_theme_mod( 'display_site_title' , true );
$display_tagline						= get_theme_mod( 'display_tagline' , true );
$display_menu							= get_theme_mod( 'display_menu' , true );
$display_search							= get_theme_mod( 'display_search' , '' );
$url									= home_url();
$search_for								= __( 'Search for:', 'minisite-lite' );
$search									= __( 'Search:', 'minisite-lite' );		
$display_homepage_header				= get_theme_mod( 'display_homepage_header' , '' );
$display_header_image_background_image	= get_theme_mod( 'display_header_image_background_image' , '' );
if ( has_post_thumbnail() ) {
	$featured_image						= get_the_post_thumbnail_url( $post->ID );
}
$header_displays						= get_theme_mod( 'header_displays' , '' );
$display_header_image_title				= get_theme_mod( 'display_header_image_title' , '' );
$header_image_title						= get_theme_mod( 'header_image_title' , '' );
$display_header_image_text				= get_theme_mod( 'display_header_image_text' , '' );
$header_image_text						= wpautop( get_theme_mod( 'header_imag	e_text' , __( '', 'minisite-lite' ) ) );
$display_header_scroll_down_arrow		= get_theme_mod( 'display_header_scroll_down_arrow' , '' );
$header_scroll_down_arrow_link			= get_theme_mod( 'header_scroll_down_arrow_link' , '' );
$scroll_down							= __( 'Scroll Down', 'minisite-lite' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php echo $skip_to_content ?></a>
	<?php if ( $display_navbar || $display_header ) : ?>
		<header id="masthead" class="site-header wrapper">
			<?php if ( $display_navbar ) : ?>
				<nav id="nav" class="navbar <?php echo $display_hamburger_menu ?><?php if ( $sticky_navbar || is_front_page() && $sticky_homepage_navbar ) {  echo ' fixed-top'; } ?>" role="navigation">
					<?php if ( class_exists( 'Notification_Bar' ) ) : ?>
						<?php Notification_Bar::notification_bar(); ?>
					<?php endif; ?>	
					<div class="container<?php if ( $full_width_navbar ) {  echo '-fluid'; } ?>">			
						<div class="navbar-brand">			
							<?php if ( $display_logo ) : ?>
								<div class="site-logo">
									<a class="site-logo-link" href="<?php echo $home_url ?>" rel="home" title="<?php echo $site_title ?><?php if( $site_tagline <> '' ) { echo ' - ' , $site_tagline; } ?>">
										<img class="site-logo-img" src="<?php echo $site_logo ?>" alt="<?php echo $site_title ?><?php if( $site_tagline <> '' ) { echo ' - ' , $site_tagline; } ?>">	
									</a>
								</div>
							<?php endif; ?>	
							<?php if ( $display_site_logo_icon ) : ?>
								<div class="site-logo-icon">
									<i class="<?php echo $site_logo_icon ?>" aria-hidden="true"></i>
								</div>
							<?php endif; ?>
							<?php if ( $display_site_title && $display_tagline ) { echo '<div class="site-title-description">'; } ?>				
							<?php if ( $display_tagline ) : ?>
								<?php if ( is_front_page() ) { echo '<h1 class="site-title">'; } else { echo '<p class="site-title">'; } ?>
									<a href="<?php echo $home_url ?>" rel="home"><?php echo $site_title ?></a>
								<?php if ( is_front_page() ) { echo '</h1>'; } else { echo '</p>'; } ?>
							<?php endif; ?>				
							<?php if ( $display_tagline ) : ?>
							    <?php if ( ! empty ( $site_tagline ) ) : ?>
									<?php if ( is_front_page() ) { echo '<h2 class="site-description">'; } else { echo '<p class="site-description">'; } ?><?php echo $site_tagline; ?><?php if ( is_front_page() ) { echo '</h2>'; } else { echo '</p>'; } ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php if ( $display_site_title && $display_tagline ) { echo '</div>'; } ?>
						</div>
						<?php if ( $display_menu ) : ?>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div id="primary-menu" class="collapse navbar-collapse">
								<?php wp_nav_menu( array(
						            	'menu'              => 'primary',
						                'theme_location'    => 'primary',
						                'depth'             => 3,
										'container'			=> false,
						                'menu_class'        => 'navbar-nav ml-auto',
						                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						                'walker'            => new WP_Bootstrap_Navwalker(),
						        	));
								?>
								<?php if ( $display_search ) : ?>
									<form role="search" method="get" class="search-form" action="<?php echo $url ?>"> 
										<label>
											<span class="screen-reader-text"><?php echo $search_for ?></span>
											<input type="search" class="search-field search-collapse" placeholder="<?php echo $search ?>" value="" name="s" />
										</label>
									    <input type="button" class="search-submit search-collapse" value="<?php echo $search ?>" />
									</form>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</nav>
			<?php endif; ?>
			<?php if ( is_front_page() && class_exists( 'Homepage_Header_Section' ) && $display_homepage_header ) : ?>
				<?php Homepage_Header_Section::homepage_header_section(); ?>
			<?php elseif ( $display_header ) : ?>
				<div id="header-image">
					<?php if ( $display_header_image_background_image ) : ?>
						<div class="header-image-background-image"<?php if( has_post_thumbnail() && $featured_image ) : ?> style="background-image: url(<?php echo $featured_image ?>);"<?php endif; ?>></div>
						<div class="header-image-overlay-color"></div>
					<?php endif; ?>
					<?php if ( $header_displays == 'display_page_title' || $header_displays == 'display_header_title_text' || $display_header_scroll_down_arrow ) : ?>
						<div class="container">
							<div class="header-image-caption row no-gutters">
								<?php if ( $header_displays == 'display_page_title' || $header_displays == 'display_header_title_text' ) : ?>
									<div class="col-sm-12 text-left">							
										<?php if ( $header_displays == 'display_page_title' ) : ?>	
											<h2 class="h1 header-image-title">
												<?php echo get_the_title() ?>
											</h2>
										<?php endif; ?>	
										<?php if ( $header_displays == 'display_header_title_text' ) : ?>						
											<?php if ( $display_header_image_title ) : ?>			
												<h2 class="h1 header-image-title">
													<?php echo $header_image_title ?>
												</h2>
											<?php endif; ?>
											<?php if ( $display_header_image_text ) : ?>
												<div class="header-image-text lead">
													<?php echo $header_image_text ?>
												</div>
											<?php endif; ?>
										<?php endif; ?>							
									</div>
								<?php endif; ?>
								<?php if ( $display_header_scroll_down_arrow ) : ?>
									<div class="scroll-down-arrow col-sm-12">
										<p><a href="<?php echo $header_scroll_down_arrow_link ?>" class="scroll-down-arrow-link"><?php echo $scroll_down ?></a></p>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</header>
	<?php endif; 
	
	// Content
	?>		
	<div id="content" class="site-content wrapper">