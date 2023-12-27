/**
 * Social Sharing Customizer live preview.
 */

( function( $ ) {

// About

	// Social Sharing

		// Horizontal Position 
		wp.customize( 'social_sharing_horizontal_position', function( value ) {
			value.bind( function( to ) {
				if ( 'ssk-left' === to ) {   
					$( '.ssk-sticky' ).addClass( 'ssk-left' ).removeClass( 'ssk-bottom' ).removeClass( 'ssk-right' );                                        
				} else if ( 'ssk-bottom' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-left' ).addClass( 'ssk-bottom' ).removeClass( 'ssk-right' );  
				} else if ( 'ssk-right' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-left' ).removeClass( 'ssk-bottom' ).addClass( 'ssk-right' );  
				}
			});
		});

		// Vertical Position 
		wp.customize( 'social_sharing_vertical_position', function( value ) {
			value.bind( function( to ) {
				if ( '' === to ) {   
					$( '.ssk-sticky' ).addClass( 'ssk-top' ).removeClass( 'ssk-center' ).removeClass( 'ssk-bottom' );                                      
				} else if ( 'ssk-center' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-top' ).addClass( 'ssk-center' ).removeClass( 'ssk-bottom' );      
				} else if ( 'ssk-bottom' === to ) {  
					$( '.ssk-sticky' ).removeClass( 'ssk-top' ).removeClass( 'ssk-center' ).addClass( 'ssk-bottom' );  
				}
			});
		});
	
		// Size
		wp.customize( 'social_sharing_size', function( value ) {
			value.bind( function( to ) {
				if ( 'ssk-xs' === to ) {   
					$( '.ssk-sticky' ).addClass( 'ssk-xs' ).removeClass( 'ssk-sm' ).removeClass( 'ssk-lg' );                                        
				} else if ( 'ssk-sm' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-xs' ).addClass( 'ssk-sm' ).removeClass( 'ssk-lg' );  
				} else if ( '' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-xs' ).removeClass( 'ssk-sm' ).removeClass( 'ssk-lg' );  
				} else if ( 'ssk-lg' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-xs' ).removeClass( 'ssk-sm' ).addClass( 'ssk-lg' );   
				}
			});
		});
	
		// Shape
		wp.customize( 'social_sharing_shape', function( value ) {
			value.bind( function( to ) {
				if ( '' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-round' ).removeClass( 'ssk-rounded' );                                        
				} else if ( 'ssk-round' === to ) {   
					$( '.ssk-sticky' ).addClass( 'ssk-round' ).removeClass( 'ssk-rounded' );   
				} else if ( 'ssk-rounded' === to ) {   
					$( '.ssk-sticky' ).removeClass( 'ssk-round' ).addClass( 'ssk-rounded' );  
				}
			});
		});

		// Display Facebook
		wp.customize( 'display_facebook', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-facebook' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-facebook' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display Twitter
		wp.customize( 'display_twitter', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-twitter' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-twitter' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display Google+
		wp.customize( 'display_google_plus', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-google-plus' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-google-plus' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display LinkedIn
		wp.customize( 'display_linkedin', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-linkedin' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-linkedin' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display Pinterest
		wp.customize( 'display_pinterest', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-pinterest' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-pinterest' ).addClass( 'd-none' );
				}
			});
		});
		
		// Display Email
		wp.customize( 'display_email', function( value ) {
			value.bind( function( to ) {
				if ( true === to ) {
					$( '.ssk-email' ).removeClass( 'd-none' );
				} else {
					$( '.ssk-email' ).addClass( 'd-none' );
				}
			});
		});	

} )( jQuery );
