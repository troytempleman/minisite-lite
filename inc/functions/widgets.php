<?php
/**
 * Minisite Widgets
 */

function minisite_widgets_init() {
	
	// Sidebar	
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'minisite-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'minisite-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );	
	
	// Footer
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'minisite-lite' ),
		'id'            => 'footer',
		'before_widget' => '<div id="%1$s" class="footer-block widget %2$s col-md">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'minisite_widgets_init' );