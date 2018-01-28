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

}