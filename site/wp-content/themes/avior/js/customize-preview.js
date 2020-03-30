/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
    var style = $( '#avior-color-scheme-css' ),
        api = wp.customize;
    if ( ! style.length ) {
        style = $( 'head' ).append( '<style type="text/css" id="avior-color-scheme-css" />' )
            .find( '#avior-color-scheme-css' );
    }
	// Site title and description.
    api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
    api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
    api( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.menu-toggle,.main-navigation,.site-header .site-title, .site-header .site-description, .top-navigation-right .theme-social-menu > li > a, .top-navigation-right .nav-menu > li > a, .main-navigation .theme-social-menu > li > a, .main-navigation .nav-menu > li > a' ).css( {
					'color': to
				} );

			}
		} );
	} );
    // Color Scheme CSS.
    api.bind( 'preview-ready', function() {
        api.preview.bind( 'update-color-scheme-css', function( css ) {
            style.html( css );
        } );
    } );
} )( jQuery );
