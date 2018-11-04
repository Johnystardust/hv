/**
 * Created by Tim on 10/2/2017.
 */
var map;

function initMap() {

    console.log('test');

    var attributes = document.getElementById('map-attributes');
    var center = attributes.getAttribute('data-center').split(',');
    var zoom = attributes.getAttribute('data-zoom');
    var add_marker = attributes.getAttribute('data-marker');

    map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: {lat: Number(center[0]), lng: Number(center[1])},
        zoom: Number(zoom),
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

    var myLatLng = {lat: Number(center[0]), lng: Number(center[1])};
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