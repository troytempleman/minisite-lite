<?php
/**
 * Archive Template
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
							<?php the_archive_title( '<h1 class="page-title">', '</h1>' );  ?>
							<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
						</header>
						<?php while ( have_posts() ) : the_post();  ?>
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