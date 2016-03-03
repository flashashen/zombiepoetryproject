/**
 *  Custom JS Scripts
 *
 * @package so-simple-75
 */

 var sosimpleApp = (function( $ ) {

	return {

		/**
		 * Popups
		 * Open new windows for links with a class of '.js-popup'. Used exclusively for the Twitter replies.
		 *
		 */
		jsPopups: function() {

			$( '.js-popup' ).on( 'click', function( e ) {
				var $this = $( this ),
					popupId = $this.data('popup-id') || 'popup',
					popupUrl = $this.data('popup-url') || $this.attr( 'href' ),
					popupWidth = $this.data('popup-width') || 550,
					popupHeight = $this.data('popup-height') || 430;

				e.preventDefault();

				window.open( popupUrl, popupId, 'width=' + popupWidth + ',height=' + popupHeight + ',directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no' );
			} );
	    },

	    /**
		 * Fluidvids
		 * JS fluid vids
		 *
		 */
		fluidVids: function() {

			fluidvids.init({
				selector: ['iframe'],
				players: ['www.youtube.com', 'player.vimeo.com']
			}); 
		},

		
		/**
		 * Menu and Menu Icon Toggle
		 *
		 */
		menuToggle: function() {

			var mainNav = document.querySelector('.main-navigation');
			var menuIcon = document.querySelector('.menu-icon');
			menuTop = document.querySelector('.menu-top'),
			menuMiddle = document.querySelector('.menu-middle'),
			menuBottom = document.querySelector('.menu-bottom');

			menuIcon.addEventListener('click', function() {
				mainNav.classList.toggle('menu-mobile-active');
				menuTop.classList.toggle('menu-top-click');
				menuMiddle.classList.toggle('menu-middle-click');
				menuBottom.classList.toggle('menu-bottom-click');
			});
		},
	}

})( jQuery );


/**
 * sosimpleApp init
 */
( function() {

	sosimpleApp.jsPopups();
	sosimpleApp.fluidVids();
	sosimpleApp.menuToggle();

})();
