jQuery(document).ready(function() {
	jQuery( '.navbar-toggler' ).click(function() { 
		if ( !jQuery( '#nav' ).hasClass( 'navbar-scroll' ) ) {
			jQuery( '#nav' ).addClass( 'navbar-scroll' );
	    }
	});
});
jQuery(window).scroll(function() {
	if ( jQuery(document).scrollTop() > 1) {
		jQuery( 'nav' ).addClass(' navbar-scroll' );
	} else {
		jQuery( 'nav' ).removeClass( 'navbar-scroll' );
	}
});