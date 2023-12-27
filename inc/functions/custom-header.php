<?php
/**
 * Custom Header
 */

function minisite_custom_header_setup() {
	
	add_theme_support( 'custom-header', apply_filters( 'minisite_custom_header_args', array(
		//'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1440,
		'height'                 => 255,
		'flex-height'            => true,
		//'wp-head-callback'       => 'minisite_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'minisite_custom_header_setup' );
