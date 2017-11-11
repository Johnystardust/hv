<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/4/2017
 * Time: 10:06 PM
 */

add_shortcode( 'hv_vc_carousel', 'hv_vc_carousel_output' );
function hv_vc_carousel_output( $atts )
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

add_action( 'vc_before_init', 'hv_vc_carousel_params' );
function hv_vc_carousel_params()
{
    vc_map( array(
        "name"     => __( "HV Vacature list", TEXTDOMAIN ),
        "base"     => "hv_vc_carousel",
        "class"    => "",
        "category" => __( "Hockey vacatures", TEXTDOMAIN ),
        "params"   => array(
            array(
                "type"        => "attach_images",
                "holder"      => "div",
                "class"       => "",
                "heading"     => __( "Afbeeldingen", TEXTDOMAIN ),
                "param_name"  => "images",
                "value"       => '',
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
