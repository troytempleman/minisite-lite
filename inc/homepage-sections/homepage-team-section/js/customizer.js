/**
 * Homepage Team Section Customizer live preview
 */

( function( $ ) {

	// Title
	wp.customize( 'team_title', function( value ) {
		value.bind( function( newval ) {
			$('.team .team-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'team_slug', function( value ) {
		value.bind( function( newval ) {
			$('.team .team-title').attr( 'id', '#' + newval );
		} );
	} );

	// Text
	wp.customize( 'team_text', function( value ) {
		value.bind( function( newval ) {
			$('.team .team-text').html( newval );
		} );
	} );
	
	// Image
	wp.customize( 'team_bio_1_image', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-1 .team-block-image').attr( 'src', newval );
		} );
	} );
	
	// Name
	wp.customize( 'team_bio_1_name', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-1 .team-block-name').html( newval );
		} );
	} );
	
	// Title
	wp.customize( 'team_bio_1_title', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-1 .team-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'team_bio_1_text', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-1 .team-block-text').html( newval );
		} );
	} );
	
	// Link
	wp.customize( 'team_bio_1_link_1_url', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-1 .team-block-social-media-1 a' ).attr( 'href', newval );
		} );
	} );
	
	// Icon
	wp.customize( 'team_bio_1_link_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-1 .team-block-social-media-1 i' ).toggleClass( newval );
		} );
	} );
	
	// Image
	wp.customize( 'team_bio_2_image', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-2 .team-block-image').attr( 'src', newval );
		} );
	} );

	// Name
	wp.customize( 'team_bio_2_name', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-2 .team-block-name').html( newval );
		} );
	} );

	// Title
	wp.customize( 'team_bio_2_title', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-2 .team-block-title').html( newval );
		} );
	} );

	// Text
	wp.customize( 'team_bio_2_text', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-2 .team-block-text').html( newval );
		} );
	} );

	// Link
	wp.customize( 'team_bio_2_link_1_url', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-2 .team-block-social-media-1 a' ).attr( 'href', newval );
		} );
	} );

	// Icon
	wp.customize( 'team_bio_2_link_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-2 .team-block-social-media-1 i' ).toggleClass( newval );
		} );
	} );
	
	// Image
	wp.customize( 'team_bio_3_image', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-3 .team-block-image').attr( 'src', newval );
		} );
	} );

	// Name
	wp.customize( 'team_bio_3_name', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-3 .team-block-name').html( newval );
		} );
	} );

	// Title
	wp.customize( 'team_bio_3_title', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-3 .team-block-title').html( newval );
		} );
	} );

	// Text
	wp.customize( 'team_bio_3_text', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-3 .team-block-text').html( newval );
		} );
	} );

	// Link
	wp.customize( 'team_bio_3_link_1_url', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-3 .team-block-social-media-1 a' ).attr( 'href', newval );
		} );
	} );

	// Icon
	wp.customize( 'team_bio_3_link_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-3 .team-block-social-media-1 i' ).toggleClass( newval );
		} );
	} );
	
	// Image
	wp.customize( 'team_bio_4_image', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-4 .team-block-image').attr( 'src', newval );
		} );
	} );

	// Name
	wp.customize( 'team_bio_4_name', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-4 .team-block-name').html( newval );
		} );
	} );

	// Title
	wp.customize( 'team_bio_4_title', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-4 .team-block-title').html( newval );
		} );
	} );

	// Text
	wp.customize( 'team_bio_4_text', function( value ) {
		value.bind( function( newval ) {
			$('.team-block-4 .team-block-text').html( newval );
		} );
	} );

	// Link
	wp.customize( 'team_bio_4_link_1_url', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-4 .team-block-social-media-1 a' ).attr( 'href', newval );
		} );
	} );

	// Icon
	wp.customize( 'team_bio_4_link_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.team-block-4 .team-block-social-media-1 i' ).toggleClass( newval );
		} );
	} );
	
	// Button
	wp.customize( 'team_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.team-button').html( newval );
		} );
	} );

	// Button URL
	wp.customize( 'team_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.team-button').attr( 'href', newval );
		} );
	} );

} )( jQuery );
