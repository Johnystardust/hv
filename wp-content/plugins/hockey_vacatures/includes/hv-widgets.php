<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

include_once( dirname( __FILE__ ) . '/widgets/class-hv-register-widget.php' );
include_once( dirname( __FILE__ ) . '/widgets/class-hv-search-widget.php'  );
include_once( dirname( __FILE__ ) . '/widgets/class-hv-filter-widget.php'  );

/**
 * Register the widgets.
 *
 * @since 1.0.0
 */
function hv_register_widgets(){
    register_widget( 'HV_Register_Widget' );
    register_widget( 'HV_Search_Widget' );
    register_widget( 'HV_Filter_Widget' );
}
add_action( 'widgets_init', 'hv_register_widgets' );


/**
 * @param WP_Query $query
 */
function archive_filter_widget_query(WP_Query $query){

    // Add the filter for the vacature query
    // =================================================================================================================
    if($query->is_archive && $query->query_vars['post_type'] == 'vacature'){
        // If the Term id is set
        if(isset($_POST['term_ids']) && !empty($_POST['term_ids'])){
            $tax_query = array(
                'relation' => 'OR',
            );

            foreach($_POST['term_ids'] as $key => $value){
                if($term = get_term_by('id', $value, 'vacature_category')){
                    $tax_query[] = array(
                        'taxonomy'  => $term->taxonomy,
                        'field'     => 'slug',
                        'terms'     => array($term->slug)
                    );
                }
            }

            $query->tax_query->queries[] = $tax_query;
            $query->query_vars['tax_query'] = $query->tax_query->queries;
        }
    }
}
add_action( 'pre_get_posts', 'archive_filter_widget_query', 1 );