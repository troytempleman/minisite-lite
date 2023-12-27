/**
 * Homepage Contact Section Customizer live preview
 */

( function( $ ) {

	// Title
	wp.customize( 'contact_title', function( value ) {
		value.bind( function( newval ) {
			$('.contact .contact-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'contact_slug', function( value ) {
		value.bind( function( newval ) {
			$('.contact .contact-title').attr( 'id', '#' + newval );
		} );
	} );

	// Text
	wp.customize( 'contact_text', function( value ) {
		value.bind( function( newval ) {
			$('.contact .contact-text').html( newval );
		} );
	} );

	// Contact Form
	wp.customize( 'contact_form', function( value ) {
		value.bind( function( newval ) {
			$('.contact .contact-form').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'contact_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.contact-button').html( newval );
		} );
	} );

	// Button URL
	wp.customize( 'contact_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.contact-button').attr( 'href', newval );
		} );
	} );

} )( jQuery );
