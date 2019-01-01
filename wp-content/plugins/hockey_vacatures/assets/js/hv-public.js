(function ($) {
    'use strict';

    $(function () {
        //var ajax_object = ajax_object;

        // 1.0	Side Panel
        // 2.0  Messages
        // 3.0  Top Bar
        // 4.0  Vacature Single
        // 5.0  Vacature Form

        // 1.0 Side Panel
        // =============================================================================================================
        var side_panel = $('#hv-side-panel');

        // -- Open login form
        $('.widget_hv_register_widget li.hv-login-link').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('active');
        });

        $('.hv-register-widget-form').on('click', function (e) {
            e.stopPropagation();
        });

        // -- Open side panel
        $('.widget_hv_register_widget li.hv-profile-link, #open-side-panel').on('click', function (e) {
            e.preventDefault();

            $('#hv-side-panel').toggleClass('active');
            $(this).toggleClass('active');

            $('body').toggleClass('hv-side-panel-open');
            $('header').toggleClass('fixed');
        });

        // -- Close side panel
        $('a[href="#close-side-panel"], #hv-side-panel').on('click', function () {
            $('#hv-side-panel').removeClass('active');
            $('.widget_hv_register_widget li.hv-profile-link, #open-side-panel').removeClass('active');

            $('body').removeClass('hv-side-panel-open');
            $('header').removeClass('fixed');
        });

        $('.hv-side-panel-inner').on('click', function (e) {
            e.stopPropagation();
        });

        // -- Side panel get template with ajax
        $(document).on('click', 'a.hv-side-panel-tab.user-vacatures', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var data = $(this).data();

            $.ajax({
                type: 'GET',
                url: ajax_object.ajax_url,
                data: {
                    action: 'hv_side_panel_get_template',
                    name: href,
                    data: data
                },
                success: function (result) {
                    console.log(result);
                    side_panel.find('.ajax-contents').empty().append(result);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // 2.0 Messages
        // =============================================================================================================

        // -- Message popup close
        $(document).on('click', '.message-popup a[href="#message-popup-close"]', function (e) {
            e.preventDefault();
            $(this).parentsUntil('.message-popup').parent().fadeOut();
        });

        // 3.0 Top Bar
        // =============================================================================================================

        // -- Delete vacature
        $(document).on('click', '#vacatures-top-bar #delete-post', function (e) {
            e.preventDefault();

            var nonce = $(this).data('nonce');
            var id = $(this).data('id');

            var validation = confirm('Weet u zeker dat u de vacature wilt verwijderen. Deze actie kan niet ongedaan gemaakt worden.');

            if (validation === true) {
                $.ajax({
                    type: 'post',
                    url: ajax_object.ajax_url,
                    data: {
                        action: 'hv_delete_vacature',
                        nonce: nonce,
                        id: id
                    },
                    success: function (result) {
                        var popup = render_popup_message(result.title, result.message, result.button_text, result.url, result.status);
                        $('body').append(popup);

                        console.log(result);
                    }
                });
            }
        });

        // 4.0 Vacature Single
        // =============================================================================================================

        // TODO: FIX VACATURE FLAGGED

        // -- Flag vacature
        // $(document).on('click', '#hv-flag-vacature', function (e) {
        //     e.preventDefault();
        //
        //     var nonce = $(this).data('nonce');
        //     var id = $(this).data('id');
        //
        //     $.ajax({
        //         type: 'post',
        //         url: ajax_object.ajax_url,
        //         data: {
        //             action: 'hv_flag_vacature',
        //             nonce: nonce,
        //             id: id
        //         },
        //         success: function (result) {
        //             var popup = render_popup_message(result.title, result.message, result.button_text, result.url, result.status);
        //             $('body').append(popup);
        //         }
        //     })
        // });

        // 5.0  Vacature Form
        // =============================================================================================================

        // -- Toggle custom address
        $('#new_vacature_form #toggle-address').on('change', function(){
            var checked = $(this).is(':checked');

            if(checked){
                $('.address-toggle.current-address').removeClass('hidden');
                $('.address-toggle.alternate-address').addClass('hidden');
                $('.address-toggle.alternate-address input, .address-toggle.alternate-address select, .address-toggle.alternate-address textarea').attr('disabled', 'disabled');
                $('.address-toggle.current-address input').removeAttr('disabled');
            } else {
                $('.address-toggle.alternate-address').removeClass('hidden');
                $('.address-toggle.current-address').addClass('hidden');
                $('.address-toggle.current-address input').attr('disabled', 'disabled');
                $('.address-toggle.alternate-address input, .address-toggle.alternate-address select, .address-toggle.alternate-address textarea').removeAttr('disabled');
            }
        });

        // -- Manual Location
        $('#new_vacature_form #manual_location').on('change', function(){
            console.log('test');

            if($(this).is(':checked')){
                $('#new_vacature_form .address-toggle').find('#city').removeAttr('readonly');
                $('#new_vacature_form .address-toggle').find('#province').removeAttr('readonly');
                $('#new_vacature_form .address-toggle').find('#street').removeAttr('readonly');
            } else {
                $('#new_vacature_form .address-toggle').find('#city').attr('readonly', 'readonly');
                $('#new_vacature_form .address-toggle').find('#province').attr('readonly', 'readonly');
                $('#new_vacature_form .address-toggle').find('#street').attr('readonly', 'readonly');
            }
        });

        // General
        // =============================================================================================================

        // -- Toggle Form Descriptions
        $('.option-based-description').on('change', function(e){
            var value = $(this).val();

            $(this).parent().find('.description-option').removeClass('active');
            $(this).parent().find('#description-option-'+value).addClass('active');
        });

        // -- Archive open filter
        $('#archive-add-filter').on('click', function (e) {
            e.preventDefault();
            $('.main-content .filter').toggleClass('active');
        });

        // -- Open on maps
        $('#view-on-map').on('click', function (e) {
            e.preventDefault();
            var offset = $('#map-canvas').offset().top;
            $('html, body').animate({scrollTop: (offset - 120)}, 500);
        });


        // Functions
        // =============================================================================================================

        // -- Renders the html for the popup message
        function render_popup_message(title, text, button_text, url, status) {
            var popup = $('<div>').addClass('message-popup ' + status);
            popup.append('<div class="message-popup-inner"><h5>' + title + '</h5><p>' + text + '</p><br><br><a href="' + url + '" class="btn btn-primary">' + button_text + '</a></div>');
            return popup;
        }
    });
})(jQuery);
