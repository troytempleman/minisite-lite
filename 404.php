<?php
/**
 * 404 Error Template
 */

// Header
get_header();

// Content
$page_not_found		= __( 'Page Not Found', 'minisite-lite' );
$sorry				= __( 'Sorry, the requested page does not exist. It might have been removed, had its name changed or is temporarily unavailable.', 'minisite-lite' );
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-sm-12">
				<main id="main" class="site-main">
					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php echo $page_not_found ?></h1>
						</header>
						<div class="page-content">
							<p><?php echo $sorry ?></p>
							<?php get_search_form(); ?>
						</div>
					</section>
				</main>
			</div>
		</div>
	</div>
<?php 

// Footer
get_footer();