/**
 * Homepage About Section Customizer live preview
 */

( function( $ ) {

	// Title
	wp.customize( 'about_title', function( value ) {
		value.bind( function( newval ) {
			$('.about .about-title').html( newval );
			//$('#_customize-input-about_slug').value( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'about_slug', function( value ) {
		value.bind( function( newval ) {
			$('.about .about-title').attr( 'id', '#' + newval );
		} );
	} );

	// Text
	wp.customize( 'about_text', function( value ) {
		value.bind( function( newval ) {
			$('.about .about-text').html( newval );
		} );
	} );

	// Block 1 
	wp.customize( 'about_block_1_text', function( value ) {
		value.bind( function( newval ) {
			$('.about-block-1 .about-block-text').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'about_block_1_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.about-block-1 .about-block-button').html( newval );
		} );
	} );
	
	// Button URL
	wp.customize( 'about_block_1_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.about-block-1 .about-block-button').attr( 'href', newval );
		} );
	} );

	// Image
	wp.customize( 'about_block_2_image', function( value ) {
		value.bind( function( newval ) {
			$('.about-block-2 .about-block-image img').attr( 'src', newval );
		} );
	} ); 
	
	// Video
	wp.customize( 'about_block_2_video', function( value ) {
		value.bind( function( newval ) {
			$('.about-block-2 .about-block-video').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'about_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.about-button').html( newval );
		} );
	} );
	
	// Button URL
	wp.customize( 'about_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.about-button').attr( 'href', newval );
		} );
	} );

} )( jQuery );
