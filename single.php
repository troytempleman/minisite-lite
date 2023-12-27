<?php
/**
 * Single Post Template
 */

// Header
get_header();

// Content
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area col-md-9">
				<main id="main" class="site-main">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
						<?php the_post_navigation(); ?>
						<?php if ( comments_open() || get_comments_number() ) : ?>
							<?php comments_template(); ?>
						<?php endif; ?>
					<?php endwhile; ?>
				</main>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php 

// Footer
get_footer();