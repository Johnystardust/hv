<?php
/**
 * VC-Map
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

//function plugin_loaded(){
//    if(is_plugin_active('js_composer/js_composer.php')){
//        return false;
//    }
//}
//add_action('admin_init', 'plugin_loaded');

get_template_part('theme-functions/vc-elements/hv-vc-maps');
get_template_part('theme-functions/vc-elements/hv-vc-iconbox');
get_template_part('theme-functions/vc-elements/hv-vc-title-spacer');
get_template_part('theme-functions/vc-elements/hv-vc-button');
get_template_part('theme-functions/vc-elements/hv-vc-vacature-list');

function hv_vc_remove_params(){
    vc_remove_param( "vc_row", "gap" );
    vc_remove_param( "vc_row", "full_width" );
    vc_remove_param( "vc_row", "full_height" );
    vc_remove_param( "vc_row", "equal_height" );
    vc_remove_param( "vc_row", "columns_placement" );
    vc_remove_param( "vc_row", "content_placement" );
    vc_remove_param( "vc_row", "video_bg" );
    vc_remove_param( "vc_row", "video_bg_url" );
    vc_remove_param( "vc_row", "parallax" );
    vc_remove_param( "vc_row", "video_bg_parallax" );
    vc_remove_param( "vc_row", "parallax_speed_video" );
    vc_remove_param( "vc_row", "parallax_image" );
    vc_remove_param( "vc_row", "parallax_speed_bg" );
}
add_action('vc_before_init', 'hv_vc_remove_params');

function hv_vc_remove_elements(){
    vc_remove_element('vc_gmaps');
}
add_action('vc_before_init', 'hv_vc_remove_elements');

function hv_vc_update_params(){
//    $attributes = array(
//        'type' => 'textfield',
//        'heading' => __( 'Extra class name', 'js_composer' ),
//        'param_name' => 'el_class',
//        'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
//    );
//    vc_update_shortcode_param( 'vc_row', $attributes );
}
add_action('vc_before_init', 'hv_vc_update_params');

function hv_vc_add_params(){
    $attributes = array(
        array(
            'type' => 'dropdown',
            'heading' => 'Padding Block',
            'param_name' => 'padding_block',
            'value' => array(
                'None' => 'none',
                'Big Block' => 'big-block',
                'Half Block' => 'half-block'
            ),
            'weight' => 100,
        ),
        array(
            'type'          => 'dropdown',
            'heading'       => 'Container',
            'param_name'    => 'container',
            'value' => array(
                'Container' => 'container',
                'Container Fluid' => 'container-fluid'
            ),
            'weight' => 99,
        ),
        array(
            'type' => 'colorpicker',
            'heading' => 'Background color',
            'param_name' => 'color',
            'weight' => 98,
        )
    );
    vc_add_params( 'vc_row', $attributes ); // Note: 'vc_message' was used as a base for "Message box" element
}
add_action('vc_before_init', 'hv_vc_add_params');







//  Link your VC elements's folder //
//function vc_before_init_actions() {
//    if( function_exists('vc_set_shortcodes_templates_dir') ){
//        vc_set_shortcodes_templates_dir( get_template_directory() . '/vc-elements' );
//    }
//}
//add_action( 'vc_before_init', 'vc_before_init_actions' );
