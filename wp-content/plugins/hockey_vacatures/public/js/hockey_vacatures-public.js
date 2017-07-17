(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	$(function(){

		// 1.0 Side Panel
		// =============================================================================================================
		var side_panel = $('#hv-side-panel');


		// Open login form
		// ===============
		$('.widget_hv_register_widget li.hv-login-link').on('click', function(e){
			e.preventDefault();
			$(this).toggleClass('active');
		});

		$('.hv-register-widget-form').on('click', function(e){
			e.stopPropagation();
		});

		// Open side panel
		// ===============
		$('.widget_hv_register_widget li.hv-profile-link, a[href="#open-side-panel"]').on('click', function(e){
			e.preventDefault();

			$('#hv-side-panel').toggleClass('active');
			$(this).toggleClass('active');

			$('body').toggleClass('hv-side-panel-open');
			$('header').toggleClass('fixed');
		});

		$('a[href="#close-side-panel"]').on('click', function(){
			$('#hv-side-panel').removeClass('active');
			$(this).removeClass('active');

			$('body').removeClass('hv-side-panel-open');
			$('header').removeClass('fixed');
		});

	});


	function hv_messages($type, $text){
		var $message = $('<div></div>');
		$message.addClass('message '+ $type);
		$message.text($text);

		$('body #hv-messages').append($message);
	}



})( jQuery );
