<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/4/2017
 * Time: 10:06 PM
 */

add_shortcode( 'hv_vc_vacature_list', 'hv_vc_vacature_list_output' );
function hv_vc_vacature_list_output( $atts )
{
    $output = $num = $view_counter = $order = $order_by = $meta_value = '';

    extract( shortcode_atts( array(
        'num'          => '5',
        'view_counter' => '',
        'order'        => 'DESC',
        'order_by'     => 'id',
        'meta_value'   => ''
    ), $atts ) );


    $args = array(
        'post_type'      => 'vacatures',
        'posts_per_page' => $num,
        'order'          => $order
    );

    if ( $order_by == 'meta_value' && !empty( $meta_value ) ) {
        $args['meta_key'] = $meta_value;
        $args['orderby'] = 'meta_value_num';
    }

    $query = new WP_Query( $args );

    if ( $query->have_posts() ):
        $output .= '<ul class="hv-vc-vacature-list">';
        while ( $query->have_posts() ): $query->the_post();
            $output .= '<li>';
            if ( $view_counter ) {
                $output .= '<span class="post-views"> views: ' . the_views( false ) . '</span>';
            }
            $output .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
            $output .= '</li>';
        endwhile;
        $output .= '</ul>';
    endif;

    return $output;
}

add_action( 'vc_before_init', 'hv_vc_vacature_list_params' );
function hv_vc_vacature_list_params()
{
    vc_map( array(
        "name"     => __( "HV Vacature list", TEXTDOMAIN ),
        "base"     => "hv_vc_vacature_list",
        "class"    => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN ),
        "params"   => array(
            array(
                "type"        => "textfield",
                "holder"      => "div",
                "class"       => "",
                "heading"     => __( "Aantal vacatures", TEXTDOMAIN ),
                "param_name"  => "num",
                "value"       => '5',
                'description' => __( 'Voer getallen in, -1 voor alles.', TEXTDOMAIN )
            ),
            array(
                "type"       => "checkbox",
                "holder"     => "div",
                "class"      => "",
                "heading"    => __( "View counter", TEXTDOMAIN ),
                "param_name" => "view_counter",
                "value"      => '',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Order', TEXTDOMAIN ),
                'param_name' => 'order',
                'value'      => array(
                    'Descending' => 'DESC',
                    'Ascending'  => 'ASC'
                ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Order by', TEXTDOMAIN ),
                "holder"     => "div",
                'param_name' => 'order_by',
                'value'      => array(
                    'ID'         => 'id',
                    'Date'       => 'date',
                    'Meta Value' => 'meta_value'
                ),
            ),
            array(
                "type"        => "textfield",
                "holder"      => "div",
                "class"       => "",
                "heading"     => __( "Post meta key", TEXTDOMAIN ),
                "param_name"  => "meta_value",
                "value"       => '',
                'dependency'  => array(
                    'element' => 'orderby',
                    'value'   => 'meta_value',
                ),
                'description' => __( 'Voer de post_meta key in.', TEXTDOMAIN )
            ),
        )
    ) );
}
