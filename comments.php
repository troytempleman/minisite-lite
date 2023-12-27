<?php
/**
 * Comments Template
 */

// Exit if password is required
if ( post_password_required() ) {
	return;
}

// Comments
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php printf( esc_html__( 'Comments', 'minisite-lite' ), '<span>' . get_the_title() . '</span>' ); ?>
		</h2>
		<?php the_comments_navigation(); ?>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'minisite-lite' ); ?></p>
		<?php endif;?>
	<?php endif; ?>
	<?php comment_form( array( 'title_reply' => 'Reply' ) ); ?>
</div>