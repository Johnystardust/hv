<?php
/**
 * Page
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<?php get_header(); ?>

<div id="page-<?php the_ID(); ?>" class="page-normal <?php post_class(); ?>">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>


    <?php while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/page/content', 'page' );
    endwhile; ?>

<!--    <div class="container-fluid page-wrapper">-->
<!--        <div class="container page-content">-->
<!---->
<!--        </div>-->
<!--    </div>-->

</div>

<!-- TODO: FIX: MAPS !!! -->
<!--<div id="maps" class="container-fluid px-0">-->
<!--    <div class="map-side">-->
<!--        <div class="map-side-inner">-->
<!--            <h3>Filters: </h3>-->
<!--            <ul>-->
<!--                <li><a href="#">Test Filter</a></li>-->
<!--                <li><a href="#">Functie</a></li>-->
<!--                <li><a href="#">Geslacht</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <a href="#" class="open-map-side"><i class="fa fa-angle-right"></i></a>-->
<!--        <a href="#" class="map-exit"><i class="fa fa-times"></i></a>-->
<!--    </div>-->
<!--    <div id="map-canvas" class="h-100"></div>-->
<!--    <script>-->
<!--        var map;-->
<!--        function initMap() {-->
<!--            map = new google.maps.Map(document.getElementById('map-canvas'), {-->
<!--                center: {lat: 52.497215, lng: 4.996103},-->
<!--                zoom: 9,-->
<!--                styles: [-->
<!--                    {-->
<!--                        "featureType": "administrative",-->
<!--                        "elementType": "labels.text.fill",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "color": "#444444"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "landscape",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "color": "#f2f2f2"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "poi",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "visibility": "off"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "road",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "saturation": -100-->
<!--                            },-->
<!--                            {-->
<!--                                "lightness": 45-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "road.highway",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "visibility": "simplified"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "road.arterial",-->
<!--                        "elementType": "labels.icon",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "visibility": "off"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "transit",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "visibility": "off"-->
<!--                            }-->
<!--                        ]-->
<!--                    },-->
<!--                    {-->
<!--                        "featureType": "water",-->
<!--                        "elementType": "all",-->
<!--                        "stylers": [-->
<!--                            {-->
<!--                                "color": "#177FBF"-->
<!--                            },-->
<!--                            {-->
<!--                                "visibility": "on"-->
<!--                            }-->
<!--                        ]-->
<!--                    }-->
<!--                ]-->
<!--            });-->
<!---->
<!--            var myLatLng = {lat: 52.127692, lng: 5.5596333};-->
<!--            var marker = new google.maps.Marker({-->
<!--                position: myLatLng,-->
<!--                map: map,-->
<!--                title: 'Hello World!'-->
<!--            });-->
<!--        }-->
<!--    </script>-->
<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>-->
<!---->
<!--    <div class="overlay">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-12">-->
<!--                    <h3>--><?php //echo __('Bekijk alle vacatures', TEXTDOMAIN); ?><!--</h3>-->
<!--                    <i class="fa fa-angle-down"></i>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php get_footer(); ?>
