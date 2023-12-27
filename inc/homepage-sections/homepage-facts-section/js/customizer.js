/**
 * Homepage Facts Section Customizer live preview
 */

( function( $ ) {
	
	// Title
	wp.customize( 'facts_title', function( value ) {
		value.bind( function( newval ) {
			$('.facts .facts-title').html( newval );
		} );
	} );
	
	// Slug
	wp.customize( 'facts_slug', function( value ) {
		value.bind( function( newval ) {
			$('.facts .facts-title').attr( 'id', '#' + newval );
		} );
	} );

	// Text
	wp.customize( 'facts_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts .facts-text').html( newval );
		} );
	} );

	// Icon Position
	wp.customize( 'facts_block_icon_position', function( value ) {
		value.bind( function( to ) {
			if ( 'top' === to ) {
				$('.facts-block-icon').removeClass('col-md-3').addClass('col-md-12'),
				$('.facts-block-title-text').removeClass('col-md-9').addClass('col-md-12');
			} else {
				$('.facts-block-icon').removeClass('col-md-12').addClass('col-md-3'),
				$('.facts-block-title-text').removeClass('col-md-12').addClass('col-md-9');
			}
		});
	} );
	
	// Icon Size
	wp.customize( 'facts_block_icon_size', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-icon i').css( 'font-size', '' + newval + 'em' );
		} );
	} );
	
	// Alignment
	wp.customize( 'facts_block_alignment', function( value ) {
		value.bind( function( to ) {
			if ( 'center' === to ) {
				$( '.facts-block-icon' ).addClass( 'text-center' ),
				$( '.facts-block-title-text' ).addClass( 'text-center' );
			} else {
				$( '.facts-block-icon' ).removeClass( 'text-center' ),
				$( '.facts-block-title-text' ).removeClass( 'text-center' );
			}
		});
	} );
	
	// Icon
	wp.customize( 'facts_block_1_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.facts-block-1 .facts-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Prefix
	wp.customize( 'facts_block_1_title_prefix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-1 .facts-block-title-prefix').html( newval );
		} );
	} );
	
	// Title
	wp.customize( 'facts_block_1_title', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-1 .facts-block-title').html( newval );
		} );
	} );
	
	// Suffix
	wp.customize( 'facts_block_1_title_suffix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-1 .facts-block-title-suffix').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'facts_block_1_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-1 .facts-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'facts_block_2_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.facts-block-2 .facts-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Prefix
	wp.customize( 'facts_block_2_title_prefix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-2 .facts-block-title-prefix').html( newval );
		} );
	} );
	
	// Title
	wp.customize( 'facts_block_2_title', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-2 .facts-block-title').html( newval );
		} );
	} );
	
	// Suffix
	wp.customize( 'facts_block_2_title_suffix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-2 .facts-block-title-suffix').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'facts_block_2_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-2 .facts-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'facts_block_3_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.facts-block-3 .facts-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Prefix
	wp.customize( 'facts_block_3_title_prefix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-3 .facts-block-title-prefix').html( newval );
		} );
	} );
	
	// Title
	wp.customize( 'facts_block_3_title', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-3 .facts-block-title').html( newval );
		} );
	} );
	
	// Suffix
	wp.customize( 'facts_block_3_title_suffix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-3 .facts-block-title-suffix').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'facts_block_3_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-3 .facts-block-text').html( newval );
		} );
	} );
	
	// Icon
	wp.customize( 'facts_block_4_icon', function( value ) {
		value.bind( function( newval ) {
			$( '.facts-block-4 .facts-block-icon i' ).toggleClass( newval );
		} );
	} );
	
	// Prefix
	wp.customize( 'facts_block_4_title_prefix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-4 .facts-block-title-prefix').html( newval );
		} );
	} );
	
	// Title
	wp.customize( 'facts_block_4_title', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-4 .facts-block-title').html( newval );
		} );
	} );
	
	// Suffix
	wp.customize( 'facts_block_4_title_suffix', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-4 .facts-block-title-suffix').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'facts_block_4_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-4 .facts-block-text').html( newval );
		} );
	} );
	
	// Text
	wp.customize( 'facts_block_6_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-block-6 .facts-block-text').html( newval );
		} );
	} );
	
	// Button
	wp.customize( 'facts_button_text', function( value ) {
		value.bind( function( newval ) {
			$('.facts-button').html( newval );
		} );
	} );

	// Button URL
	wp.customize( 'facts_button_url', function( value ) {
		value.bind( function( newval ) {
			$('.facts-button').attr( 'href', newval );
		} );
	} );

} )( jQuery );
