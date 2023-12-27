/**
 * Homepage Call to Action Section Customizer live preview
 */

( function( $ ) {
		
	// Title
	wp.customize( 'call_to_action_title', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action .call-to-action-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'call_to_action_slug', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action .call-to-action-title').attr( 'id', '#' + newval );
		} );
	} );
	
	// Text
	wp.customize( 'call_to_action_text', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action .call-to-action-text').html( newval );
		} );
	} );
	
	// Button 1
	wp.customize( 'call_to_action_button_1_text', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action-button-1').html( newval );
		} );
	} );

	// Button 1 URL
	wp.customize( 'call_to_action_button_1_url', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action-button-1').attr( 'href', newval );
		} );
	} );
	
	// Button 2
	wp.customize( 'call_to_action_button_2_text', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action-button-2').html( newval );
		} );
	} );

	// Button 2 URL
	wp.customize( 'call_to_action_button_2_url', function( value ) {
		value.bind( function( newval ) {
			$('.call-to-action-button-2').attr( 'href', newval );
		} );
	} );

} )( jQuery );
