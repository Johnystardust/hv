<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Shortcode_User_Panel {

    public function __construct(){

    }

    /**
     * The output for the user panel
     *
     * @return string
     */
    public function output(){
        $output = '';

        include_once( HV_ABSPATH . 'templates/shortcodes/user-panel.php' );

        return $output;
    }

    /**
     * Get the users posts
     *
     * @return bool|WP_Query
     */
    public function get_user_posts(){
        $post_args = array(
            'post_type'         => 'vacature',
            'posts_per_page'    => 5,
            'author'            => get_current_user_id(),
        );

        $the_query = new WP_Query( $post_args );

        if( $the_query->have_posts() ) {
            return $the_query;
        }

        return false;
    }



}