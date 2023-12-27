<?php
/**
 * Search Results Template
 */

// Header
get_header();

// Content
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-md-9">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) : ?>
						<header class="page-header">
							<h1 class="page-title">
								<?php printf( esc_html__( 'Search Results for %s', 'minisite-lite' ), '<span>' . get_search_query() . '</span>' ); ?>
							</h1>
						</header>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
							// Run the loop for the search to output the results.
							// If you want to overload this in a child theme then include a file
							// called content-search.php and that will be used instead.
							get_template_part( 'template-parts/content', 'search' ); ?>
						<?php endwhile; ?>
						<?php the_posts_navigation(); ?>
					<?php else : ?>
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					<?php endif; ?>
				</main>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php 

// Footer
get_footer();