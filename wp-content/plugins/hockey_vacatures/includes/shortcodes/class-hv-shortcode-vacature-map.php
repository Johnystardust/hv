<?php

if( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Shortcode_Vacature_Map
{

    public function output()
    {
        // TODO: //  FIX ME !!!!!!!!!!!!!!!!!!!

        ?>
        <div id="map-canvas" style="height: 300px;"></div>
        <script>
            function initMap() {
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: 51.9646808, lng: 5.9114894},
                    zoom: 14,
                    styles: [
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#444444"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#f2f2f2"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 45
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.icon",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "color": "#177FBF"
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ]
                });

                var myLatLng = {lat: 51.9646808, lng: 5.9114894};
                var image = {
                    url: '/wp-content/themes/hockey-vacatures/inc/img/hv-maps-marker.png',
                };
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Hello World!',
                    icon: image
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTjw-Z0dph6JxefZkVg7o_NpPk9L24JGo&callback=initMap" async defer></script>
        <?php
    }


    public function vacature_map_shortcode($attributes){

    }

}