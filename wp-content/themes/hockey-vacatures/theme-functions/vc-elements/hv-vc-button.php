<?php

add_shortcode( 'hv_vc_button', 'hv_vc_button_output' );
function hv_vc_button_output( $atts ) {
    $output = $button_style = $link  = '';

    extract( shortcode_atts( array(
        'link' => '',
        'button_style' => 'primary',
        'button_align' => 'left',
    ), $atts ) );

    // TODO: IMPLEMENT TARGET & REL
    $href = vc_build_link( $link );

    $classes = array(
        'btn',
        'btn-'.$button_style,
    );

    $output .= '<a href="'.$href['url'].'" class="'.implode(' ', $classes).'">'.$href['title'].'</a>';

    return $output;
}

add_action( 'vc_before_init', 'hv_vc_button_params' );
function hv_vc_button_params() {
    vc_map( array(
        "name" => __( "HV Button", TEXTDOMAIN ),
        "base" => "hv_vc_button",
        "class" => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN),
        "params" => array(
            array(
                "type" => "vc_link",
                "holder" => "div",
                "class" => "",
                "heading" => __( "Link", TEXTDOMAIN ),
                "param_name" => "link",
                "value" => ''
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => __( 'Button style', TEXTDOMAIN ),
                'param_name'    => 'button_style',
                'value' => array(
                    'Primary' => 'primary',
                    'Border' => 'border',
                    'Alternate' => 'alternate'
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => __( 'Button align', TEXTDOMAIN ),
                'param_name'    => 'button_align',
                'value' => array(
                    'Left' => 'left',
                    'Right' => 'right',
                    'Center' => 'center'
                ),
            ),
        )
    ) );
}