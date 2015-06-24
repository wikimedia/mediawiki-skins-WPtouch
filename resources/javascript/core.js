/*
 * WPtouch 1.9.x -The WPtouch Core JS File
 * This file holds all the default jQuery & AJAX functions for the skin
 * Copyright (c) 2008-2009 Duane Storey & Dale Mugford (BraveNewCode Inc.)
 * Licensed under GPL.
 *
 * Last Updated: 14 June 2015
 */

/////// -- Get out of frames! -- ///////
if ( top.location != self.location ) {
	top.location = self.location.href;
}

/////// -- Menus -- ///////
// Creating a new function, fadeToggle()
$.fn.fadeToggle = function( speed, easing, callback ) {
	return this.animate( { opacity: 'toggle' }, speed, easing, callback );
};

function bnc_jquery_menu_drop() {
	$( '#wptouch-menu' ).fadeToggle( 400 );
	$( '#headerbar-menu a' ).toggleClass( 'open' );
}

function bnc_jquery_login_toggle() {
	$( '#wptouch-login' ).fadeToggle( 400 );
}

function bnc_jquery_search_toggle() {
	$( '#wptouch-search' ).fadeToggle( 400 );
}

/////// --jQuery Tabs-- ///////

$( function () {
	var tabContainers = $( '#menu-head > ul' );

	$( '#tabnav a' ).click( function () {
		tabContainers.hide().filter( this.hash ).show();

		$( '#tabnav a' ).removeClass( 'selected' );
		$( this ).addClass( 'selected' );

		return false;
	} ).filter( ':first' ).click();
} );

/////// -- Tweak jQuery Timer -- ///////
$.timerId = setInterval( function() {
	var timers = jQuery.timers;
	for ( var i = 0; i < timers.length; i++ ) {
		if ( !timers[i]() ) {
			timers.splice( i--, 1 );
		}
	}
	if ( !timers.length ) {
		clearInterval( jQuery.timerId );
		jQuery.timerId = null;
	}
}, 83 );

$( function() {
	$( '#wptouch-login-inner a' ).on( 'click', function( e ) {
		e.preventDefault();
		bnc_jquery_login_toggle();
	} );
	$( '#headerbar-menu a' ).on( 'click', function( e ) {
		e.preventDefault();
		bnc_jquery_menu_drop();
	} );
	$( '#searchform a, #searchopen' ).on( 'click', function( e ) {
		e.preventDefault();
		bnc_jquery_search_toggle();
	} );
} );

// End WPtouch JS