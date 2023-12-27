<?php
/**
 * Template part for displaying posts
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php else : ?>
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<?php endif; ?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php minisite_posted_on(); ?>
				<?php minisite_posted_by(); ?>
			</div>
		<?php endif; ?>
	</header>
	<div class="entry-content">
		<?php the_content( sprintf( wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'minisite-lite' ), array( 'span' => array( 'class' => array(), ), ) ), get_the_title() ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minisite-lite' ), 'after'  => '</div>', ) ); ?>
	</div>
	<footer class="entry-footer">
		<?php minisite_entry_footer(); ?>
	</footer>
</article>