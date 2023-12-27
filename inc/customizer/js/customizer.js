/**
 * Customizer live preview
 */

( function( $ ) {
	
	// Header
	
		// Display Logo		
		wp.customize( 'display_logo', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.site-logo' ).removeClass( 'd-none' );
				} else {
					$( '.site-logo' ).addClass( 'd-none' );
				}
			});
		});
		
		// Logo Size
		wp.customize( 'site_logo_size', function( value ) {
			value.bind( function( newval ) {
				$('.site-logo-img').css( 'width', '' + newval + 'rem' );
			} );
		} );
	
		// Display Icon		
		wp.customize( 'display_site_logo_icon', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.site-logo-icon' ).removeClass( 'd-none' );
				} else {
					$( '.site-logo-icon' ).addClass( 'd-none' );
				}
			});
		});	
		
		// Icon
		wp.customize( 'site_logo_icon', function( value ) {
			value.bind( function( newval ) {
				$( '.site-logo-icon i' ).toggleClass( newval );
			} );
		} );
		
		// Icon Size
		wp.customize( 'site_logo_icon_size', function( value ) {
			value.bind( function( newval ) {
				$('.site-logo-icon i').css( 'font-size', '' + newval + 'rem' );
			} );
		} );
		
		// Display Site Title			
		wp.customize( 'display_site_title', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.site-title' ).removeClass( 'd-none' );
				} else {
					$( '.site-title' ).addClass( 'd-none' );
				}
			});
		});
		
		// Site Title
		wp.customize( 'blogname', function( value ) {
			value.bind( function( newval ) {
				$( '.site-title a' ).text( newval );
			} );
		} );
		
		// Site Title Size
		wp.customize( 'site_title_size', function( value ) {
			value.bind( function( newval ) {
				$('.site-title a').css( 'font-size', '' + newval + 'rem' );
			} );
		} );
	
		// Display Tagline			
		wp.customize( 'display_tagline', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.site-description' ).removeClass( 'd-none' );
				} else {
					$( '.site-description' ).addClass( 'd-none' );
				}
			});
		});	
		
		// Tagline	
		wp.customize( 'blogdescription', function( value ) {
			value.bind( function( newval ) {
				$( '.site-description' ).text( newval );
			} );
		} );
		
		// Display Search	
		wp.customize( 'display_search', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.navbar .search-form' ).removeClass( 'd-none' );
				} else {
					$( '.navbar .search-form' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display Hamburger Menu
		wp.customize( 'display_hamburger_menu', function( value ) {
			value.bind( function( to ) {
				if ( 'navbar-expand' === to ) {   
					$( '.navbar' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-lg' ).removeClass( 'navbar-expand-xl' ).addClass( 'navbar-expand' );                                                                                                                   					$( '.navbar' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-lg' ).removeClass( 'navbar-expand-xl' ).addClass( 'navbar-expand' );
				} else if ( 'navbar-expand-sm' === to ) {
					$( '.navbar' ).removeClass( 'navbar-expand' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-lg' ).removeClass( 'navbar-expand-xl' ).addClass( 'navbar-expand-sm' );
				} else if ( 'navbar-expand-md' === to ) {
					$( '.navbar' ).removeClass( 'navbar-expand' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-lg' ).removeClass( 'navbar-expand-xl' ).addClass( 'navbar-expand-md' );
				} else if ( 'navbar-expand-lg' === to ) {
					$( '.navbar' ).removeClass( 'navbar-expand' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-xl' ).addClass( 'navbar-expand-lg' );
				} else if ( 'navbar-expand-xl' === to ) {
					$( '.navbar' ).removeClass( 'navbar-expand' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-lg' ).addClass( 'navbar-expand-xl' );
				} else {
					$( '.navbar' ).removeClass( 'navbar-expand' ).removeClass( 'navbar-expand-sm' ).removeClass( 'navbar-expand-md' ).removeClass( 'navbar-expand-lg' ).removeClass( 'navbar-expand-xl' );
				}
			});
		} );
	
		// Title
		wp.customize( 'header_image_title', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-title').html( newval );
			} );
		} );
		
		// Text
		wp.customize( 'header_image_text', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-text').html( newval );
			} );
		} );
		
		// Header Position
		wp.customize( 'header_position', function( value ) {
			value.bind( function( newval ) {
				$('body').css( 'padding-top', '' + newval + 'px' );
			} );
		} );
		
		// Header Height
		wp.customize( 'header_height', function( value ) {
			value.bind( function( newval ) {
				$('#header-image, #header-image .container').css( 'min-height', '' + newval + 'px' );
			} );
		} );
		
		// Heading Color
		wp.customize( 'header_image_heading_color', function( value ) {
			value.bind( function( newval ) {
				$('#header-image h1, .#header-image h2, #header-image h3, #header-image h4, #header-image h5, #header-image h6').css( 'color', newval );
			} );
		} );
		
		// Font Color
		wp.customize( 'header_image_font_color', function( value ) {
			value.bind( function( newval ) {
				$('#header-image').css( 'color', newval );
			} );
		} );
	
		// Header Color
		wp.customize( 'header_image_background_color', function( value ) {
			value.bind( function( newval ) {
				$('#header-image').css( 'background-color', newval );
			} );
		} );
	
		// Header Image
		wp.customize( 'header_image_background_image', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css('background-image', 'url("' + newval + '")' );
			} );
		} );
	
		// Background Image Attachment
		wp.customize( 'header_image_background_attachment', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css( 'background-attachment', newval );
			} );
		} );

		// Background Image Position
		wp.customize( 'header_image_background_position', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css( 'background-position', newval );
			} );
		} );

		// Background Image Size
		wp.customize( 'header_image_background_size', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css( 'background-size', newval );
			} );
		} );

		// Background Image Repeat
		wp.customize( 'header_image_background_repeat', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css( 'background-repeat', newval );
			} );
		} );
	
		// Header Image Opacity
		wp.customize( 'header_image_background_image_opacity', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-background-image').css( 'opacity', newval );
			} );
		} );
	
		// Header Image Overlay Color
		wp.customize( 'header_image_overlay_color', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-overlay-color').css( 'background-color', newval );
			} );
		} );
	
		// Header Image Overlay Color Opacity
		wp.customize( 'header_image_overlay_color_opacity', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-overlay-color').css( 'opacity', newval );
			} );
		} );
	
		// Header Image Blend Mode
		wp.customize( 'header_image_blend_mode', function( value ) {
			value.bind( function( newval ) {
				$('#header-image .header-image-overlay-color').css( 'mix-blend-mode', newval );
			} );
		} );
		
		// Top Padding
		wp.customize( 'header_top_padding', function( value ) {
			value.bind( function( newval ) {
				$('#header-image').css( 'padding-top', '' + newval + 'rem' );
			} );
		} );

		// Bottom Padding
		wp.customize( 'header_bottom_padding', function( value ) {
			value.bind( function( newval ) {
				$('#header-image').css( 'padding-bottom', '' + newval + 'rem' );
			} );
		} );
	
	// Footer

		// Colophon

			// Copyright Owner
			wp.customize( 'footer_block_colophon_copyright_owner', function( value ) {
				value.bind( function( newval ) {
					$('.footer-block-colophon-copyright-link').html( newval );
				} );
			} );
		
			
			// Copyright Link
			wp.customize( 'footer_block_colophon_copyright_link', function( value ) {
				value.bind( function( newval ) {
					$('.footer-block-colophon-copyright-link').attr( 'href', newval );
				} );
			} );
		
			// Terms of Use
			wp.customize( 'footer_block_colophon_terms_of_use', function( value ) {
				value.bind( function( newval ) {
					$('.footer-block-colophon-terms-of-use .modal-body').html( newval );
				} );
			} );
		
			// Privacy Policy
			wp.customize( 'footer_block_colophon_privacy_policy', function( value ) {
				value.bind( function( newval ) {
					$('.footer-block-colophon-privacy-policy .modal-body').html( newval );
				} );
			} );
		
			// Credits
			wp.customize( 'footer_block_colophon_credits', function( value ) {
				value.bind( function( newval ) {
					$('.footer-block-colophon-credits .modal-body').html( newval );
				} );
			} );

	// Options
			
		// Background
			
			// Background Color
			wp.customize( 'background_color', function( value ) {
				value.bind( function( newval ) {
					$('body').css('background-color', newval );
				} );
			} );

		// Colors
			
			// Link Color
			wp.customize( 'link_color', function( value ) {
				value.bind( function( newval ) {
					$('a, a:active, a:focus, a:hover, a:visited').css('color', newval );
				} );
			} );
	
			// Background Color
			wp.customize( 'background_color', function( value ) {
				value.bind( function( newval ) {
					$('body').css('background-color', newval );
				} );
			} );

			// Update site link color in real time...
			wp.customize( 'link_textcolor', function( value ) {
				value.bind( function( newval ) {
					$('a').css('color', newval );
				} );
			} );
	
} )( jQuery );
