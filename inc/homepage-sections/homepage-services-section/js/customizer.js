/**
 * Homepage Services Section Customizer live preview
 */

( function( $ ) {
	
	// Title
	wp.customize( 'services_title', function( value ) {
		value.bind( function( newval ) {
			$('.services .services-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'services_slug', function( value ) {
		value.bind( function( newval ) {
			$('.services .services-title').attr( 'id', '#' + newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_text', function( value ) {
		value.bind( function( newval ) {
			$('.services .services-text').html( newval );
		} );
	} );
	
	// Icon Position
	wp.customize( 'services_block_icon_position', function( value ) {
		value.bind( function( to ) {
			if ( 'top' === to ) {
				$('.services-block-icon').removeClass('col-md-3').addClass('col-md-12'),
				$('.services-block-title-text').removeClass('col-md-9').addClass('col-md-12');
			} else {
				$('.services-block-icon').removeClass('col-md-12').addClass('col-md-3'),
				$('.services-block-title-text').removeClass('col-md-12').addClass('col-md-9');
			}
		});
	} );
	
	// Icon Size
	wp.customize( 'services_block_icon_size', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-icon i').css( 'font-size', '' + newval + 'em' );
		} );
	} );
	
	// Alignment
	wp.customize( 'services_block_alignment', function( value ) {
		value.bind( function( to ) {
			if ( 'center' === to ) {
				$( '.services-block-icon' ).addClass( 'text-center' ),
				$( '.services-block-title-text' ).addClass( 'text-center' );
			} else {
				$( '.services-block-icon' ).removeClass( 'text-center' ),
				$( '.services-block-title-text' ).removeClass( 'text-center' );
			}
		});
	} );
	
	// Icon
	wp.customize( 'services_block_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-1 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_1_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-1 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_1_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-1 .services-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'services_block_2_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-2 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_2_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-2 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_2_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-2 .services-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'services_block_3_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-3 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_3_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-3 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_3_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-3 .services-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'services_block_4_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-4 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_4_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-4 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_4_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-4 .services-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'services_block_5_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-5 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_5_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-5 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_5_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-5 .services-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'services_block_6_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.services-block-6 .services-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Title
	wp.customize( 'services_block_6_title', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-6 .services-block-title').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'services_block_6_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-block-6 .services-block-text').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'services_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.services-button').html( newval );
		} );
	} );

	// Button URL
	wp.customize( 'services_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.services-button').attr( 'href', newval );
		} );
	} );
	
} )( jQuery );
