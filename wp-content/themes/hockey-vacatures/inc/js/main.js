/**
 * Main JS for theme
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
$(document).ready(function(){

    // Nav toggle
    // ==========
    $('.menu-toggle a').on('click', function(){
        $('.menu-hoofdmenu-container').toggleClass('active');
        $('html').toggleClass('noscroll');
    });

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

    $('#page-slider').find('.slick-container').slick({
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        infinite: true,
        speed: 500,
        //fade: true,
        //cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 6000,
    });

    $(window).scroll(function(){
        if ($(document).scrollTop() > 80) {
            $('#header').addClass('fixed');
        } else {
            $('#header').removeClass('fixed');
        }
    });


});