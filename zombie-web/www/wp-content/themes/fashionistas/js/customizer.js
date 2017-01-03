/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Main color
	wp.customize('main_color',function( value ) {
		value.bind( function( newval ) {
			$('button, input[type="button"], input[type="reset"], input[type="submit"], #top-navigation, #top-navigation li:hover ul, #top-navigation li.sfHover ul, #main-navigation li:hover ul, #main-navigation li.sfHover ul, #main-navigation > .sf-menu > ul, .site-content [class*="navigation"] a, .widget-tab-nav li.active a, .widget-social-icons li a [class^="ico-"]:before, .site-footer ').css('background', newval );
			$('#main-navigation, .entry-footer, .page-header, .author-info, .site-content [class*="navigation"] a:hover, .site-content .post-navigation, .comments-title, .widget, .widget-title, ul.widget-tab-nav, .site-extra').css('border-color', newval );													
		} );
	});
	// Site title
	wp.customize('site_title',function( value ) {
		value.bind( function( newval ) {
			$('.site-title a').css('color', newval );
		} );
	});
	// Site description
	wp.customize('site_desc',function( value ) {
		value.bind( function( newval ) {
			$('.site-description').css('color', newval );
		} );
	});
	// Entry title
	wp.customize('entry_title',function( value ) {
		value.bind( function( newval ) {
			$('.entry-title, .entry-title a').css('color', newval );
		} );
	});
	// Body text color
	wp.customize('body_text',function( value ) {
		value.bind( function( newval ) {
			$('body').css('color', newval );
		} );
	});


} )( jQuery );
