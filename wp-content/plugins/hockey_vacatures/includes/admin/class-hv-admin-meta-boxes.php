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

    /**
     * Add the meta boxes for the post types.
     */
    public function add_meta_boxes(){
        add_meta_box( 'vacature_info', __( 'Vacature Info', 'hockey_vacatures' ), 'HV_Meta_Box_Vacature_Info::output', 'vacature', 'normal', 'high' );
    }

    /**
     * Save the meta boxes.
     *
     * @param $post_id
     * @param $post
     */
    public function save_meta_boxes( $post_id, $post ){

        // Save the meta boxes for the vacature post type.
        if($post->post_type == 'vacature'){
            if(isset($_POST['function']) && $_POST['function'] != ''){
                update_post_meta( $post_id, 'function', $_POST['function']);
            }
            if(isset($_POST['gender']) && $_POST['gender'] != ''){
                update_post_meta( $post_id, 'gender', $_POST['gender']);
            }
            if(isset($_POST['city']) && $_POST['city'] != ''){
                update_post_meta( $post_id, 'city', $_POST['city']);
            }
            if(isset($_POST['province']) && $_POST['province'] != ''){
                update_post_meta( $post_id, 'province', $_POST['province']);
            }
        }
    }

    public function remove_meta_boxes(){

    }

}
new HV_Admin_Meta_Boxes();