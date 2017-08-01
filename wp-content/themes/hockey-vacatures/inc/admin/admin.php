<?php
/**
 * Admin Functionality
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

///**
// * Enqueue the admin scripts and styles
// */
//function hv_enqueue_admin_scripts(){
//    wp_enqueue_script( 'hv-admin-js', get_stylesheet_directory_uri() . '/inc/js/admin.js', array(), null, false );
//    wp_enqueue_media();
//}
//add_action( 'admin_enqueue_scripts', 'hv_enqueue_admin_scripts' );
//
//// Add Page Banner Meta Box To Pages
//function add_page_banner_meta_box(){
//    $args = array();
//    add_meta_box( 'page_banner_meta_box', __( 'Page Banner', TEXTDOMAIN ), 'page_banner_meta_box', 'page', 'normal', 'high', $args );
//}
//add_action( 'add_meta_boxes', 'add_page_banner_meta_box' );
//
//function page_banner_meta_box(){
//    echo '<p class="hide-if-no-js">';
//        echo '<a class="btn" id="upload-banner-image">Upload</a>';
//    echo '</p>';
//}