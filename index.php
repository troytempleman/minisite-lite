<?php
/**
 * The main template file
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
						<?php if ( is_home() && ! is_front_page() ) : ?> 
							<header>
								<h1 class="page-title screen-reader-text">
									<?php single_post_title(); ?>
								</h1>
							</header>
						<?php endif; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
							// Include the Post-Type-specific template for the content.
							// If you want to override this in a child theme, then include a file
							// called content-___.php (where ___ is the Post Type name) and that will be used instead.
							get_template_part( 'template-parts/content', get_post_type() ); ?>
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