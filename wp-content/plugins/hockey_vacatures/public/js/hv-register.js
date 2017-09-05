(function( $ ) {

    $(function(){

        // 1.0 Register Form Validation
        // 2.0 Register Form Postcode API
        // 3.0 Register Page

        // 1.0 Register Form Validation
        // =============================================================================================================
        var $regForm = $('#hv_reg_form');

        // jQuery validate addMethods
        // ==========================
        $.validator.addMethod("valueNotEquals", function(value, element, arg){
            return arg !== value;
        }, "Value must not equal arg.");

        // Register Form Validation
        // ========================
        $regForm.validate({
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

        // 2.0 Register Form Postcode API
        // =============================================================================================================

        // Register Form postcode API
        // ==========================
        //function setLocationData(postal){
        //	$.ajax({
        //		url: "https://api.postcodeapi.nu/v2/addresses/?postcode="+postal+"&number="+street_number,
        //		"method": "GET",
        //		"headers": {
        //			"x-api-key": "1vRaaykvlV3pcEmP6sGjG3wVMxYcgvMD6buKoVHg",
        //			"accept": "application/hal+json"
        //		},
        //		"async": true,
        //		"crossDomain": true,
        //	}).done(function(response){
        //		return response;
        //	});
        //}
        //
        //$regForm.find('#postal').on('keyup', function(){
        //	var postal = $(this).val();
        //	var data = setLocationData(postal);
        //});

        $regForm.find('#street_number').on('keyup', function(){
            var street_number 	= $(this).val();
            var postal 			= $regForm.find('#postal').val();

            console.log(street_number);

            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "https://api.postcodeapi.nu/v2/addresses/?postcode="+postal+"&number="+street_number,
                "method": "GET",
                "headers": {
                    "x-api-key": "1vRaaykvlV3pcEmP6sGjG3wVMxYcgvMD6buKoVHg",
                    "accept": "application/hal+json"
                }
            };

            $.ajax({
                url: "https://api.postcodeapi.nu/v2/addresses/?postcode="+postal+"&number="+street_number,
                "method": "GET",
                "headers": {
                    "x-api-key": "1vRaaykvlV3pcEmP6sGjG3wVMxYcgvMD6buKoVHg",
                    "accept": "application/hal+json"
                },
                "async": true,
                "crossDomain": true,
            }).done(function(response){
                var addresses = response._embedded.addresses[0].city.label;

                $regForm.find('#city').val(response._embedded.addresses[0].city.label);
                $regForm.find('#province').val(response._embedded.addresses[0].province.label);
                $regForm.find('#street').val(response._embedded.addresses[0].street);

                console.log(response._embedded.addresses);
            });
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
        // ===============
        var role = $regForm.find('#role').find(":selected").val();
        role_select(role);

        // On select
        $regForm.find('select[name="role"]').on('change', function(event){
            role_select($(this).val());
        });

        // Message popup close
        // ===================
        $('.message-popup a[href="#message-popup-close"]').on('click', function(event){
            event.preventDefault();

            $(this).parentsUntil('.message-popup').parent().fadeOut();
        });

        // Manual Location
        // ===============
        $regForm.find('#manual_location').on('change', function(){
            if($(this).is(':checked')){
                $regForm.find('#city').removeAttr('disabled');
                $regForm.find('#province').removeAttr('disabled');
                $regForm.find('#street').removeAttr('disabled');
            } else {
                $regForm.find('#city').attr('disabled', 'disabled');
                $regForm.find('#province').attr('disabled', 'disabled');
                $regForm.find('#street').attr('disabled', 'disabled');
            }
        });

    });

})( jQuery );
