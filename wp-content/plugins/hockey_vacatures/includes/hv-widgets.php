<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

include_once(dirname(__FILE__) . '/widgets/class-hv-register-widget.php');
include_once(dirname(__FILE__) . '/widgets/class-hv-search-widget.php');
include_once(dirname(__FILE__) . '/widgets/class-hv-filter-widget.php');
include_once(dirname(__FILE__) . '/widgets/class-hv-vacature-list-widget.php');

/**
 * Register the widgets.
 *
 * @since 1.0.0
 */
function hv_register_widgets()
{
    register_widget('HV_Register_Widget');
    register_widget('HV_Search_Widget');
    register_widget('HV_Filter_Widget');
    register_widget('HV_Vacature_List_Widget');
}

add_action('widgets_init', 'hv_register_widgets');


/**
 * @param WP_Query $query
 */
function archive_filter_widget_query(WP_Query $query)
{
    // Add the filter for the vacature query
    // =================================================================================================================
    if (!is_admin() && $query->is_archive && $query->query_vars['post_type'] == 'vacature') {
        $tax_query = $query->tax_query->queries;
        $meta_query = $query->meta_query;

        $meta_query['relation'] = 'OR';

        // If the Term id is set
        if (isset($_POST['term_ids']) && !empty($_POST['term_ids'])) {
            foreach ($_POST['term_ids'] as $key => $value) {
                if ($term = get_term_by('id', $value, 'vacature_category')) {
                    $tax_query[] = array(
                        'taxonomy' => $term->taxonomy,
                        'field'    => 'slug',
                        'terms'    => array($term->slug)
                    );
                }
            }
        }

        // If the age is set
        if (isset($_POST['age']) && !empty($_POST['age'])) {
            foreach ($_POST['age'] as $key => $value){
                $meta_query[] = array(
                    'key'     => 'age',
                    'value'   => $key,
                    'compare' => '='
                );
            }
        }

        // If field is set
        if (isset($_POST['field']) && !empty($_POST['field'])) {
            foreach ($_POST['field'] as $key => $value){
                $meta_query[] = array(
                    'key'     => 'field',
                    'value'   => $key,
                    'compare' => '='
                );
            }
        }

        $query->set('tax_query', $tax_query);
        $query->set('meta_query', $meta_query);

//        var_dump($query->tax_query);
//        die;
    }
}

add_action('pre_get_posts', 'archive_filter_widget_query', 1);