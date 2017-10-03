<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/2/2017
 * Time: 8:43 PM
 */

add_shortcode( 'hv_vc_gmaps', 'hv_vc_gmaps_output' );
function hv_vc_gmaps_output( $atts ) {
    $output = $height = $center = $zoom = $marker = $full_width = '';

    extract( shortcode_atts( array(
        'height' => '300',
        'center' => '-68.6118544,78.9550111',
        'zoom' => '9',
        'marker' => '',
        'full_width' => ''
    ), $atts ) );

    $map_attributes = array(
        'data-center="'.$center.'"',
        'data-zoom="'.$zoom.'"',
        'data-marker="'.$marker.'"',
    );

    $map_style = array(
        'height: '.$height.'px;',
    );

    if($full_width){
        $map_style[] = 'margin-left: -15px!important;';
        $map_style[] = 'margin-right: -15px!important;';
    }

    $output .= '<div id="map-attributes" '.implode(' ', $map_attributes).'></div>';
    $output .= '<div id="map-canvas" style="'.implode(' ', $map_style).'"></div>';
    $output .= '<script src="'.get_stylesheet_directory_uri().'/theme-functions/vc-js/hv-vc-maps.js"></script>';
    $output .= '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>';

    return $output;
}

add_action( 'vc_before_init', 'hv_vc_gmaps_params' );
function hv_vc_gmaps_params() {
    vc_map( array(
        "name" => __( "HV Google Maps", TEXTDOMAIN ),
        "base" => "hv_vc_gmaps",
        "class" => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __( "Height", TEXTDOMAIN ),
                "param_name" => "height",
                "value" => '',
                "description" => __( "Don't include the px", TEXTDOMAIN )
            ),
            array(
                'type' => 'textfield',
                'holder' => "div",
                "heading" => __( "Center LatLng", TEXTDOMAIN ),
                "param_name" => "center",
                "value" => '',
                "description" => __( "Example: 51.9646808,5.9114894", TEXTDOMAIN )
            ),
            array(
                'type' => 'textfield',
                'holder' => "div",
                "heading" => __( "Zoom", TEXTDOMAIN ),
                "param_name" => "zoom",
                "value" => '',
            ),
            array(
                'type' => 'checkbox',
                'holder' => 'div',
                'heading' => __('Marker toevoegen'),
                'param_name' => 'marker',
                'value' => ''
            ),
            array(
                'type' => 'checkbox',
                'holder' => 'div',
                'heading' => __('Full width'),
                'param_name' => 'full_width',
                'value' => ''
            )
        )
    ) );
}