<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Admin_Meta_Boxes {

    public function __construct(){
        add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ), 10 );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'), 20 );
        add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );
    }

    public function add_meta_boxes(){
        add_meta_box( 'vacature_info', __( 'Vacature Info', 'hockey_vacatures' ), 'HV_Meta_Box_Vacature_Info::output', 'vacature', 'normal', 'high' );
    }

    public function save_meta_boxes( $post_id, $post ){

    }

}
new HV_Admin_Meta_Boxes();