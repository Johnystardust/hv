<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/2/2017
 * Time: 10:09 PM
 */

add_shortcode( 'hv_vc_iconbox', 'hv_vc_iconbox_output' );
function hv_vc_iconbox_output( $atts ) {
    $output = $fa_class = $title = $subline = '';

    extract( shortcode_atts( array(
        'fa_class' => '',
        'title' => '',
        'subline' => ''
    ), $atts ) );

    $output .= '<div class="hv-icon-box">';
    $output .= '<div class="icon-container">';
    $output .= '<i class="fa '.$fa_class.'"></i>';
    $output .= '</div>';

    $output .= '<div class="text-container">';
    $output .= '<h5>'.$title.'</h5>';
    $output .= '<p>'.$subline.'</p>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_action( 'vc_before_init', 'hv_vc_iconbox_params' );
function hv_vc_iconbox_params() {
    vc_map( array(
        "name" => __( "HV Iconbox", TEXTDOMAIN ),
        "base" => "hv_vc_iconbox",
        "class" => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __( "FontAwesome class", TEXTDOMAIN ),
                "param_name" => "fa_class",
                "value" => ''
            ),
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
                "heading" => __( "Sub line", TEXTDOMAIN ),
                "param_name" => "subline",
                "value" => ''
            )
        )
    ) );
}