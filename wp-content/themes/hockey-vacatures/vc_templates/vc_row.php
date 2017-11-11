<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$output = $after_output = '';
$padding_block = $container = $el_id = $el_class = $color = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract($atts);

//---------------- Adding the Wrapper Attributes ----------------//
$wrapper_attributes = array();

if(!empty($el_id)){
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if(!empty($color)){
    $wrapper_attributes[] = 'style="background-color:'.$color.';"';
}

//---------------- Adding the Classes ----------------//
$container_class = ($container == 'container-fluid') ? 'container-fluid' : 'container';

$css_classes = array(
    $container_class,
    $padding_block,
    $el_class,
);

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="row '.vc_shortcode_custom_css_class( $css ).'">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';

echo $output;