<?php
/**
 * Vacature Map
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes/shortcodes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Vacature_Map {

    public function vacature_map(){
        ?>
        <div id="map-canvas" style="height: 300px;"></div>
        <script type="text/javascript">
            var map;

            function initMap(){
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: 51.9876536, lng: 5.9115403},
                    zoom: Number(14),
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

                var myLatLng = {lat: 51.9876536, lng: 5.9115403};
                var image = {
                    url: '../wp-content/themes/hockey-vacatures/inc/img/hv-maps-marker.png',
                };
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Hello World!',
                    icon: image
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>
        <?php
    }

    public function vacature_map_shortcode(){
        $this->vacature_map();
    }
}