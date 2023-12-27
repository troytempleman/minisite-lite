<?php
/**
 * Minisite Content Width
 */

function minisite_content_width() {
	
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'minisite_content_width', 690 );
}
add_action( 'after_setup_theme', 'minisite_content_width', 0 );