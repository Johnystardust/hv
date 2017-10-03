/**
 * Main JS for theme
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
$(document).ready(function(){


    // Vacature Maps open
    // ==================
    $('#maps .overlay').on('click', function(){
        $('#maps').addClass('open');
        $('.map-side').addClass('active');
        $('html, body').animate({ scrollTop: $(this).offset().top }, "fast").css('overflow', 'hidden');
        google.maps.event.trigger(map, "resize");
    });

    // Maps Side open
    // ==============
    $('.open-map-side').on('click', function(event){
        $('.map-side').toggleClass('open');
        return false;
    });

    // Vacature Maps exit
    // ==================
    $('.map-exit').on('click', function(event){
        $('#maps').removeClass('open');
        $('.maps-side').removeClass('active');
        $('html, body').css('overflow', 'auto');
        return false;
    });

    // Slick Slider
    // ============
    $('.banner-full-width').slick({
        dots: true,
        arrows: false
    });



    $(window).scroll(function(){
        if ($(document).scrollTop() > 80) {
            $('#header').addClass('fixed');
        } else {
            $('#header').removeClass('fixed');
        }
    });


});