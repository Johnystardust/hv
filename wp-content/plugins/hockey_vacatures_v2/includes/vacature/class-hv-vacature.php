<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

include_once( HV_ABSPATH . 'includes/abstracts/wp-model.php' );


class HV_Vacature extends WP_Model {

    public $postType = 'vacature';
    public $attributes  = array(
        'function',
        'gender',
    );
    public $taxonomies = array(
        'category'
    );

    public function __construct(){
        parent::__construct();
    }

    public function get_single_info(){
        $additional_data = get_user_meta($this->post()->post_author, 'hv_user_data', true);

//        unset( $additional_data['postal'] );
//        unset( $additional_data['addition'] );
//        unset( $additional_data['street_number'] );
//        unset( $additional_data['coordinates'] );
//        unset( $additional_data['gender'] );
//        unset( $additional_data['street'] );
//        unset( $additional_data['age'] );


        return $additional_data;
    }

}