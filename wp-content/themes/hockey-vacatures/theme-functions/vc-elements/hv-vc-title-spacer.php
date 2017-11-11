<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/2/2017
 * Time: 10:09 PM
 */

add_shortcode( 'hv_vc_title_spacer', 'hv_vc_title_spacer_output' );
function hv_vc_title_spacer_output( $atts ) {
    $output = $title = $subtitle = $subtitle_placement = '';

    extract( shortcode_atts( array(
        'title' => '',
        'subtitle' => '',
        'subtitle_placement' => (!empty($subtitle_placement)) ? $subtitle_placement : 'hidden'
    ), $atts ) );

    if($subtitle_placement == 'above_title' && !empty($subtitle)){
        $output .= '<h5 class="text-uppercase">'.$subtitle.'</h5>';
    }

    $output .= '<h2 class="font-weight-bold">'.$title.'</h2>';
    $output .= '<div class="spacer"></div>';

    if($subtitle_placement == 'below_title' && !empty($subtitle)){
        $output .= '<h5 class="text-uppercase">'.$subtitle.'</h5>';
    }

    return $output;
}

add_action( 'vc_before_init', 'hv_vc_title_spacer_params' );
function hv_vc_title_spacer_params() {
    vc_map( array(
        "name" => __( "HV Title & Spacer", TEXTDOMAIN ),
        "base" => "hv_vc_title_spacer",
        "class" => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __( "Title", TEXTDOMAIN ),
                "param_name" => "title",
                "value" => ''
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __( "Subtitle", TEXTDOMAIN ),
                "param_name" => "subtitle",
                "value" => ''
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => __( 'Subtitle Placement', TEXTDOMAIN ),
                'param_name'    => 'subtitle_placement',
                'value' => array(
                    'Hidden'      => 'hidden',
                    'Above title' => 'above_title',
                    'Below title' => 'below_title',
                ),
            ),
        )
    ) );
}