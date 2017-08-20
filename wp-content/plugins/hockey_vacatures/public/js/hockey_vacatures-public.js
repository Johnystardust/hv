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

		// 1.0	Side Panel
		// 2.0 	Form Validation
		// 3.0 	Register Page


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


		// 2.0 Form Validation
		// =============================================================================================================

		// jQuery validate addMethods
		// ==========================
		$.validator.addMethod("valueNotEquals", function(value, element, arg){
			return arg !== value;
		}, "Value must not equal arg.");

		// Register Form Validation
		// ========================
		$('#hv_reg_form').validate({
			rules: {
				// General
				username: {
					required: true,
					minlength: 4
				},
				role: {
					valueNotEquals: 'default'
				},
				password: {
					required: true,
					minlength: 5
				},
				password_check: {
					equalTo: '#password'
				},

				// Club
				c_name: {
					required: true,
					minlength: 2
				},
				c_place: {required: true},
				c_cname: {required: true},
				c_email: {
					required: true,
					email: true
				},
				c_web_url: {url: true},

				// Player
				p_fname: {
					required: true,
					minlength: 2
				},
				p_lname: {
					required: true,
					minlength: 2
				},
				p_place: {required: true},
				p_email: {
					required: true,
					email: true
				},
				p_age: {
					required: true,
					number: true,
					min: 13,
					max: 130
				},
				p_gender: {valueNotEquals: 'default'}
			},
			messages: {
				// General
				username: {
					required: 'Gebruikersnaam is verplicht.',
					minlength: 'Tenmninste 4 letters.'
				},
				role: 'Kies een rol.',
				hv_reg_email: 'Geef een geldig email adres op.',
				password: {
					required: 'Geef een wachtwoord op.',
					minlength: 'Password moet tenminste 5 letters zijn.'
				},
				password_check: {
					equalTo: 'Geef nogmaals hetzelfde wachtwoord op.'
				},

				// Club
				// Player
				hv_reg_fname: 'Geef een naam op.',
				hv_reg_lname: 'Geef een achternaam op.',
				hv_reg_age: 'Geef een leeftijd op.',
				hv_reg_gender: 'Kies een geslacht.',
			}
		});


		// Sale form validation
		// ====================
		$('#hv_sale_num').on('change', function(event){
			var num 	= $(this).val();
			var other 	= $('#hv_sale_num_other');
			var vacatures;
			var total;
			var staffel;
			var discount;

			// If the value is other show the number field
			if(num == 'other'){
				other.removeClass('hidden').focus();
				$(this).addClass('hidden');
			} else {
				staffel = Math.floor(num / 5);
				discount = staffel * 5;
				vacatures = (num * 10);
				total = vacatures - discount;

				console.log(discount);
				if(discount > 0){
					$('.total-sale').text(discount+',-');
					$('.totals-sale').show();
				}
				$('.total-vacatures').text(vacatures+',-');
				$('.total').text(total+',-')
			}
		});

		$('#hv_sale_form').validate({
			rules: {
				hv_sale_num: {
					required: true
				}

			},
			messages: {
				hv_sale_num: 'Vul een aantal vacatures in.'

			}
		});

		// 3.0 Register Page
		// =============================================================================================================

		// Show correct form fields based on role
		// ======================================
		function role_select($value){
			if($value == 'player'){
				$('.club-fields').addClass('disabled');
				$('.player-fields.disabled').removeClass('disabled');
				$('.player-fields input, .player-fields select').removeAttr('disabled');
			}
			else if($value == 'club'){
				$('.player-fields').addClass('disabled');
				$('.club-fields.disabled').removeClass('disabled');
				$('.club-fields input, .club-fields select').removeAttr('disabled');
			}
			else {
				$('.player-fields').addClass('disabled');
				$('.player-fields input, .player-fields select').attr('disabled', 'disabled');
				$('.club-fields').addClass('disabled');
				$('.club-fields input, .club-fields select').attr('disabled', 'disabled');
			}
		}

		// On page refresh
		var role = $('#hv_reg_form #role').find(":selected").val();
		role_select(role);

		// On select
		$('#hv_reg_form select[name="role"]').on('change', function(event){
			role_select($(this).val());
		});

		// Message popup close
		// ===================
		$('.message-popup a[href="#message-popup-close"]').on('click', function(event){
			event.preventDefault();

			$(this).parentsUntil('.message-popup').parent().fadeOut();
		});

	});

})( jQuery );
