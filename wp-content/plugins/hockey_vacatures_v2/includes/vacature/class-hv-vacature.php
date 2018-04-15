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

    public function get_vacature_author_meta_by_key($key){
        if(!empty(get_user_meta($this->post()->post_author, $key, true))){
            return get_user_meta($this->post()->post_author, $key, true);
        }

        return false;
    }

    public function get_vacature_author_email(){
        $user = get_userdata($this->post()->post_author);
        return $user->user_email;
    }

    public function get_vacature_author_url(){
        $user = get_userdata($this->post()->post_author);
        return $user->user_url;
    }

    public function get_vacature_gender(){

        if($this->gender == 'male'){
            return __('Man', 'hockey_vacatures');
        }elseif($this->gender == 'female'){
            return __('Vrouw', 'hockey_vacatures');
        }elseif($this->gender == 'either'){
            return __('Geen voorkeur', 'hockey_vacatures');
        }

        return false;
    }








    public function get_vacature_meta_by_key($key){
        return $this->{$key};
    }


    public function get_single_info_by_key($key){
        $additional_data = get_user_meta($this->post()->post_author, $key, true);

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