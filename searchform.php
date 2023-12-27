<?php
/**
 * Search Form Template
 */

// Search Form
?>
<div class="search-box">
	<form role="search" method="get" class="search-form" action="<?php home_url(); ?>">
		<label>
			<span class="screen-reader-text"><?php echo __( 'Search for:', 'minisite-lite' ) ?></span>
			<input type="search" class="search-field" placeholder="Search" value="" name="s">
		</label>
		<input type="submit" class="search-submit " value="Search">
	</form>
</div>