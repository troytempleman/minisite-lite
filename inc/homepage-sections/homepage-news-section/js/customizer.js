/**
 * Homepage News Section Customizer live preview
 */

( function( $ ) {

	// Title
	wp.customize( 'news_title', function( value ) {
		value.bind( function( newval ) {
			$('.news .news-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'news_slug', function( value ) {
		value.bind( function( newval ) {
			$('.news .news-title').attr( 'id', '#' + newval );
		} );
	} );

	// Text
	wp.customize( 'news_text', function( value ) {
		value.bind( function( newval ) {
			$('.news .news-text').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'news_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.news-button').html( newval );
		} );
	} );

	// Button URL
	wp.customize( 'news_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.news-button').attr( 'href', newval );
		} );
	} );
				
} )( jQuery );
