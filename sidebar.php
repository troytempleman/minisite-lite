<?php
/**
 * Sidebar Template
 */

// Exit if there are no widgets
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

// Sidebar
?>
<aside id="secondary" class="widget-area col-md-3">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>