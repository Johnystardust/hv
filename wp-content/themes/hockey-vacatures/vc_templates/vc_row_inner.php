<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

$output .= '<div class="container">';
$output .= '<div class="row">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';

echo $output;
