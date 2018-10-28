<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/4/2017
 * Time: 10:06 PM
 */

add_shortcode('hv_vc_vacature_list', 'hv_vc_vacature_list_output');
function hv_vc_vacature_list_output($atts)
{
    $output = $type = $num = $category = $view_counter = $order = '';

    extract(shortcode_atts(array(
        'type'         => 'new',
        'num'          => '5',
        'view_counter' => '',
        'order'        => 'DESC',
        'category'     => ''
    ), $atts));

    $args = array(
        'post_type'      => 'vacature',
        'post_status'    => 'publish',
        'posts_per_page' => $num,
        'order'          => $order
    );

    if ($type == 'views') {
        $args['meta_key'] = 'views';
        $args['orderby'] = 'meta_value_num';
    } elseif ($type == 'cat') {
        $terms = explode(',', $category);

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'vacature_category',
                'field'    => 'slug',
                'terms'    => $terms,
            )
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()):
        $output .= '<ul class="hv-vc-vacature-list">';
        while ($query->have_posts()): $query->the_post();
            $output .= '<li>';
            if ($view_counter) {
                $output .= '<span class="post-views"> views: ' . the_views(false) . '</span>';
            }
            $output .= '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
            $output .= '</li>';
        endwhile;
        $output .= '</ul>';
    endif;

    return $output;
}

add_action('vc_before_init', 'hv_vc_vacature_list_params');
function hv_vc_vacature_list_params()
{
    vc_map(array(
        "name"     => __("HV Vacature list", TEXTDOMAIN),
        "base"     => "hv_vc_vacature_list",
        "class"    => "",
        "category" => __("Hockey vacatures", TEXTDOMAIN),
        "params"   => array(
            array(
                "type"        => "textfield",
                "holder"      => "div",
                "class"       => "",
                "heading"     => __("Aantal vacatures", TEXTDOMAIN),
                "param_name"  => "num",
                "value"       => '5',
                'description' => __('Voer getallen in, -1 voor alles.', TEXTDOMAIN)
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Type lijst', TEXTDOMAIN),
                'param_name' => 'type',
                'value'      => array(
                    __('Nieuwste vacatures', TEXTDOMAIN)  => 'new',
                    __('Aantal keer bekeken', TEXTDOMAIN) => 'views',
                    __('Categorie', TEXTDOMAIN)           => 'cat'
                ),
            ),
            array(
                "type"        => "textfield",
                "holder"      => "div",
                "class"       => "",
                "heading"     => __("Categorie", TEXTDOMAIN),
                "param_name"  => "category",
                "value"       => '',
                'dependency'  => array(
                    'element' => 'type',
                    'value'   => 'cat'
                ),
                'description' => __('Voer de slugs van de categorie in, je kunt meerdere categorieen invoeren door er een comma tussen te zetten. Bijv: speler,club', TEXTDOMAIN)
            ),
            array(
                "type"       => "checkbox",
                "holder"     => "div",
                "class"      => "",
                "heading"    => __("View counter", TEXTDOMAIN),
                "param_name" => "view_counter",
                "value"      => '',
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __('Order', TEXTDOMAIN),
                'param_name' => 'order',
                'value'      => array(
                    'Descending' => 'DESC',
                    'Ascending'  => 'ASC'
                ),
            ),
        )
    ));
}