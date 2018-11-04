<?php

add_shortcode('hv_vc_counter', 'hv_vc_counter_output');
function hv_vc_counter_output($atts)
{
    $output = $type = $title = $counter = '';

    extract(shortcode_atts(array(
        'type'  => 'vacature_count',
        'title' => ''
    ), $atts));

    if($type == 'vacature_count' && wp_count_posts('vacature')->publish){
        $counter = wp_count_posts( 'vacature' )->publish;
    } elseif ($type == 'user_count' || $type == 'club_count'){
        $role = ($type == 'user_count') ? 'person' : 'business';
        $user_query = new WP_User_Query( array( 'role' => $role ) );
        $users_count = (int) $user_query->get_total();
        $counter = $users_count;
    }


    $output .= '<div class="facts-block">';
    $output .= '<div class="fact">';
    $output .= '<span class="counter">'.$counter.'</span>';
    $output .= '<h4>'.$title.'</h4>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_action('vc_before_init', 'hv_vc_counter_params');
function hv_vc_counter_params()
{
    vc_map(array(
        "name"     => __("HV Counter", TEXTDOMAIN),
        "base"     => "hv_vc_counter",
        "class"    => "",
        "category" => __("Hockey vacatures", TEXTDOMAIN),
        "params"   => array(
            array(
                'type'       => 'dropdown',
                'heading'    => __('Type', TEXTDOMAIN),
                'param_name' => 'type',
                'value'      => array(
                    __('Aantal vacatures')             => 'vacature_count',
                    __('Aantal ingeschreven Personen') => 'user_count',
                    __('Aantal ingeschreven Clubs')    => 'club_count'
                ),
            ),
            array(
                "type"       => "textfield",
                "holder"     => "div",
                "heading"    => __("Title", TEXTDOMAIN),
                "param_name" => "title",
                "value"      => '',
            ),
        )
    ));
}