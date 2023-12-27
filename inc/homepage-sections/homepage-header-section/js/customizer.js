/**
 * Homepage Header Section Customizer live preview
 */

( function( $ ) {

	// Header 
	
		// Display Logo		
		wp.customize( 'display_homepage_logo', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.home .navbar .site-logo' ).removeClass( 'd-none' );
				} else {
					$( '.home .navbar .site-logo' ).addClass( 'd-none' );
				}
			});
		});
	
		// Logo Size
		wp.customize( 'homepage_site_logo_size', function( value ) {
			value.bind( function( newval ) {
				$('.home .navbar .site-logo-img').css( 'width', '' + newval + 'rem' );
			} );
		} );

		// Display Icon		
		wp.customize( 'display_homepage_site_logo_icon', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.home .navbar .site-logo-icon' ).removeClass( 'd-none' );
				} else {
					$( '.home .navbar .site-logo-icon' ).addClass( 'd-none' );
				}
			});
		});	
	
		// Icon Size
		wp.customize( 'homepage_site_logo_icon_size', function( value ) {
			value.bind( function( newval ) {
				$('.home .navbar .site-logo-icon i').css( 'font-size', '' + newval + 'rem' );
			} );
		} );
	
		// Display Site Title			
		wp.customize( 'display_homepage_site_title', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.home .navbar .site-title' ).removeClass( 'd-none' );
				} else {
					$( '.home .navbar .site-title' ).addClass( 'd-none' );
				}
			});
		});
	
		// Site Title Size
		wp.customize( 'homepage_site_title_size', function( value ) {
			value.bind( function( newval ) {
				$('.home .navbar .site-title a').css( 'font-size', '' + newval + 'rem' );
			} );
		} );

		// Header Position
		wp.customize( 'homepage_header_position', function( value ) {
			value.bind( function( newval ) {
				$('.home').css( 'padding-top', '' + newval + 'px' );
			} );
		} );
		
		// Header Height
		wp.customize( 'homepage_header_height', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image, #homepage-header-image .container, #homepage-header-carousel .slide, #homepage-header-carousel .container').css( 'min-height', '' + newval + 'px' );
			} );
		} );
	
		// Header
		
		// Title
		wp.customize( 'homepage_header_image_title', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-title').html( newval );
			} );
		} );
		
		// Text
		wp.customize( 'homepage_header_image_text', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-text').html( newval );
			} );
		} );
	
		// Button 1
		wp.customize( 'homepage_header_image_button_1_text', function( value ) {
			value.bind( function( newval ) {
				$('.homepage-header-image-button-1').html( newval );
			} );
		} );
	
		// URL
		wp.customize( 'homepage_header_image_button_1_url', function( value ) {
			value.bind( function( newval ) {
				$('.homepage-header-image-button-1').attr( 'href', newval );
			} );
		} );
	
		// Button 2
		wp.customize( 'homepage_header_image_button_2_text', function( value ) {
			value.bind( function( newval ) {
				$('.homepage-header-image-button-2').html( newval );
			} );
		} );
	
		// URL
		wp.customize( 'homepage_header_image_button_2_url', function( value ) {
			value.bind( function( newval ) {
				$('.homepage-header-image-button-2').attr( 'href', newval );
			} );
		} );
		
		// Header Color
		wp.customize( 'homepage_header_image_background_color', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image').css( 'background-color', newval );
			} );
		} );
	
		// Header Image
		wp.customize( 'homepage_header_image_background_image', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-background-image').css('background-image', 'url("' + newval + '")' );
			} );
		} );
	
		// Header Image Opacity
		wp.customize( 'homepage_header_image_background_image_opacity', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-background-image').css( 'opacity', newval );
			} );
		} );
	
		// Header Image Overlay Color
		wp.customize( 'homepage_header_image_overlay_color', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-overlay-color').css( 'background-color', newval );
			} );
		} );
	
		// Header Image Overlay Color Opacity
		wp.customize( 'homepage_header_image_overlay_color_opacity', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-overlay-color').css( 'opacity', newval );
			} );
		} );
	
		// Header Image Blend Mode
		wp.customize( 'homepage_header_image_blend_mode', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-overlay-color').css( 'mix-blend-mode', newval );
			} );
		} );
		
		// Heading Color
		wp.customize( 'homepage_header_image_heading_color', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image h1, #homepage-header-image h2, #homepage-header-image h3, #homepage-header-image h4, #homepage-header-image h5, #homepage-header-image h6').css( 'color', newval );
			} );
		} );
		
		// Font Color
		wp.customize( 'homepage_header_image_font_color', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image').css( 'color', newval );
			} );
		} );
		
		// Top Padding
		wp.customize( 'homepage_header_top_padding', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-caption').css( 'padding-top', '' + newval + 'rem' );
			} );
		} );
	
		// Bottom Padding
		wp.customize( 'homepage_header_bottom_padding', function( value ) {
			value.bind( function( newval ) {
				$('#homepage-header-image .homepage-header-image-caption').css( 'padding-bottom', '' + newval + 'rem' );
			} );
		} );

} )( jQuery );