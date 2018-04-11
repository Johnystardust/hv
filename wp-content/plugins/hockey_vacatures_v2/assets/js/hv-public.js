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
        //var ajax_object = ajax_object;

        // 1.0	Side Panel
        // 2.0  Messages
        // 3.0  Top Bar

        // 1.0 Side Panel
        // =============================================================================================================
        var side_panel = $('#hv-side-panel');

        // -- Open login form
        $('.widget_hv_register_widget li.hv-login-link').on('click', function(e){
            e.preventDefault();
            $(this).toggleClass('active');
        });

        $('.hv-register-widget-form').on('click', function(e){
            e.stopPropagation();
        });

        // -- Open side panel
        $('.widget_hv_register_widget li.hv-profile-link, #open-side-panel').on('click', function(e){
            e.preventDefault();

            $('#hv-side-panel').toggleClass('active');
            $(this).toggleClass('active');

            $('body').toggleClass('hv-side-panel-open');
            $('header').toggleClass('fixed');
        });

        // -- Close side panel
        $('a[href="#close-side-panel"]').on('click', function(){
            $('#hv-side-panel').removeClass('active');
            $(this).removeClass('active');

            $('body').removeClass('hv-side-panel-open');
            $('header').removeClass('fixed');
        });

        // -- Side panel get template with ajax
        $(document).on('click', 'a.hv-side-panel-tab.user-vacatures', function( e ){
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
                success: function ( result ) {
                    console.log(result);
                    side_panel.find('.ajax-contents').empty().append( result );
                },
                error: function ( error ) {
                    console.log( error );
                }
            } );
        } );

        // -- Side panel save/update vacature
        //$(document).on('click', 'a.vacature-update-side-panel', function ( e ) {
        //    e.preventDefault();
        //
        //    $.ajax({
        //        type: 'GET',
        //        url: ajax_object.ajax_url,
        //        data: {
        //            action: 'save_vacature'
        //        },
        //        success: function ( result ) {
        //            console.log( result );
        //        }
        //    })
        //} );






        // 2.0 Messages
        // =============================================================================================================

        // -- Message popup close
        $('.message-popup a[href="#message-popup-close"]').on('click', function(event){
            event.preventDefault();

            $(this).parentsUntil('.message-popup').parent().fadeOut();
        });

        // 3.0 Top Bar
        // =============================================================================================================
        var top_bar = $('#vacatures-top-bar');

        console.log(ajax_object);

        top_bar.find('#delete-post').on('click', function(){
            var id = $(this).data('id');
            var nonce = $(this).data('nonce');
            //var post = $(this).parents('.post:first');

            $.ajax({
                type: 'post',
                url: ajax_object.ajax_url,
                data: {
                    action: 'vacature_delete',
                    nonce: nonce,
                    id: id
                },
                success: function (result) {
                    console.log(result);
                }
            });

            return false;

            window.confirm('Deze post zal verwijderd worden. Weet u zeker dat u wilt doorgaan.');
            if(confirm){
                return true;
            }
            else {
                return false;
            }

        });

        // General
        // =============================================================================================================

        // -- Archive open filter
        $('#archive-add-filter').on('click', function(e){
            e.preventDefault();
            $('.main-content .filter').toggleClass('active');
        });

        // -- Open on maps
        $('#view-on-map').on('click', function(e){
            e.preventDefault();
            var offset = $('#map-canvas').offset().top;
            $('html, body').animate({scrollTop: (offset - 120)}, 500);
        });









        // DEPRECATED
        // =============================================================================================================

        // Sale form validation
        // ====================
        //$('#hv_sale_num').on('change', function(event){
        //    var num 	= $(this).val();
        //    var other 	= $('#hv_sale_num_other');
        //    var vacatures;
        //    var total;
        //    var staffel;
        //    var discount;
        //
        //    // If the value is other show the number field
        //    if(num == 'other'){
        //        other.removeClass('hidden').focus();
        //        $(this).addClass('hidden');
        //    } else {
        //        staffel = Math.floor(num / 5);
        //        discount = staffel * 5;
        //        vacatures = (num * 10);
        //        total = vacatures - discount;
        //
        //        console.log(discount);
        //        if(discount > 0){
        //            $('.total-sale').text(discount+',-');
        //            $('.totals-sale').show();
        //        }
        //        $('.total-vacatures').text(vacatures+',-');
        //        $('.total').text(total+',-')
        //    }
        //});



    });

})( jQuery );
