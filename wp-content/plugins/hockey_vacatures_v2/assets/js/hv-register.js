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

        //$regForm.validate({
        //    rules: {
        //        // General
        //        username: {
        //            required: true,
        //            minlength: 4
        //        },
        //        role: {
        //            valueNotEquals: 'default'
        //        },
        //        postal: {
        //            required: true
        //        },
        //        street_number: {
        //            required: true
        //        },
        //        password: {
        //            required: true,
        //            minlength: 5
        //        },
        //        password_check: {
        //            required: true,
        //            equalTo: '#password'
        //        },
        //
        //        // Club
        //        // ====
        //        c_name: {
        //            required: true,
        //            minlength: 2
        //        },
        //        c_place: {required: true},
        //        c_cname: {required: true},
        //        c_email: {
        //            required: true,
        //            email: true
        //        },
        //        c_web_url: {url: true},
        //
        //        // Player
        //        // ======
        //        p_fname: {
        //            required: true,
        //            minlength: 2
        //        },
        //        p_lname: {
        //            required: true,
        //            minlength: 2
        //        },
        //        p_place: {required: true},
        //        p_email: {
        //            required: true,
        //            email: true
        //        },
        //        p_age: {
        //            required: true,
        //            number: true,
        //            min: 13,
        //            max: 130
        //        },
        //        p_gender: {
        //            valueNotEquals: 'default'
        //        }
        //    },
        //    messages: {
        //        // General
        //        username: {
        //            required: 'Gebruikersnaam is verplicht.',
        //            minlength: 'Tenmninste 4 letters.'
        //        },
        //        role: 'Kies een rol.',
        //        postal: {
        //            required: 'Geef een geldige postcode op.',
        //        },
        //        street_number: {
        //            required: 'Geef een geldig huisnummer op.',
        //        },
        //        password: {
        //            required: 'Geef een wachtwoord op.',
        //            minlength: 'Password moet tenminste 5 letters zijn.'
        //        },
        //        password_check: {
        //            required: 'Geef een wachtwoord op.',
        //            equalTo: 'Geef nogmaals hetzelfde wachtwoord op.'
        //        },
        //
        //        // Club
        //        c_name: 'Geef een naam op.',
        //        c_cname: 'Geef een naam op.',
        //        c_email: 'Geef een geldig email adres op.',
        //
        //        // Player
        //        p_fname: 'Geef een naam op.',
        //        p_lname: 'Geef een achternaam op.',
        //        p_email: 'Geef een geldig email adres op.',
        //        p_age: 'Geef een leeftijd op.',
        //        p_gender: 'Kies een geslacht.',
        //    }
        //});

        // 2.0 Register Form Postcode API
        // =============================================================================================================

        // Register Form postcode API
        // ==========================
        $regForm.find('#street_number').on('keyup', function(){
            var street_number 	= $(this).val();
            var postal 			= $regForm.find('#postal').val();

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
                $regForm.find('#city').val(response._embedded.addresses[0].city.label);
                $regForm.find('#province').val(response._embedded.addresses[0].province.label);
                $regForm.find('#street').val(response._embedded.addresses[0].street);

                var coordinates = [
                    response._embedded.addresses[0].geo.center.wgs84.coordinates[0],
                    response._embedded.addresses[0].geo.center.wgs84.coordinates[1],
                ];

                $regForm.find('#coordinates').val(coordinates);
            });
        });

        // 3.0 Register Page
        // =============================================================================================================

        // Show correct form fields based on role
        // ======================================
        function role_select($value){
            console.log($value);
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

        // Manual Location
        // ===============
        $regForm.find('#manual_location').on('change', function(){
            if($(this).is(':checked')){
                $regForm.find('#city').removeAttr('readonly');
                $regForm.find('#province').removeAttr('readonly');
                $regForm.find('#street').removeAttr('readonly');
            } else {
                $regForm.find('#city').attr('readonly', 'readonly');
                $regForm.find('#province').attr('readonly', 'readonly');
                $regForm.find('#street').attr('readonly', 'readonly');
            }
        });

    });

})( jQuery );
