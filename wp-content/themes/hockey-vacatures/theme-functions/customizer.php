<?php
/**
 * Customizer
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

function hv_register_theme_customizer($wp_customize){

    // Header section
    // =================================================================================================================
    $wp_customize->add_section('header', array(
        'title'         => __( 'Header', TEXTDOMAIN ),
        'priority'      => 30,
    ));

    // Header Social Media
    // ===================

    // Facebook
    $wp_customize->add_setting('header_social_facebook', array(
        'default'       => '',
    ));
    $wp_customize->add_control('header_social_facebook', array(
        'label'         => __( 'Social Facebook', TEXTDOMAIN ),
        'section'       => 'header',
        'type'          => 'text',
    ));

    // Twitter
    $wp_customize->add_setting('header_social_twitter', array(
        'default'       => '',
    ));
    $wp_customize->add_control('header_social_twitter', array(
        'label'         => __( 'Social Twitter', TEXTDOMAIN ),
        'section'       => 'header',
        'type'          => 'text',
    ));

    // Linkedin
    $wp_customize->add_setting('header_social_linkedin', array(
        'default'       => '',
    ));
    $wp_customize->add_control('header_social_linkedin', array(
        'label'         => __( 'Social LinkedIn', TEXTDOMAIN ),
        'section'       => 'header',
        'type'          => 'text',
    ));

    // Whatsapp
    $wp_customize->add_setting('header_social_whatsapp', array(
        'default'       => '',
    ));
    $wp_customize->add_control('header_social_whatsapp', array(
        'label'         => __( 'Social Whatsapp', TEXTDOMAIN ),
        'section'       => 'header',
        'type'          => 'text',
    ));

    // Phone
    $wp_customize->add_setting('header_social_phone', array(
        'default'       => '',
    ));
    $wp_customize->add_control('header_social_phone', array(
        'label'         => __( 'Social Telefoonnummer', TEXTDOMAIN ),
        'section'       => 'header',
        'type'          => 'text',
    ));



    // Footer section
    // =================================================================================================================
    $wp_customize->add_section('footer', array(
        'title'         => 'Footer',
        'priority'      => 35,
    ));

    // Footer Copyright text
    // =====================
    $wp_customize->add_setting('footer_copyright_text', array(
        'default'       => 'Default copyright text, you can change this in the customizer.',
        'transport'     => 'refresh',
    ));
    $wp_customize->add_control('footer_copyright_text', array(
        'label'         => __('Footer copyright text', TEXTDOMAIN),
        'section'       => 'footer',
        'type'          => 'text',
    ));


}
add_action('customize_register', 'hv_register_theme_customizer');

