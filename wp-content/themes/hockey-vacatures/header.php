<?php
/**
 * Header
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo get_the_title(); ?> | Hockey Vacatures</title>

    <meta name="viewport" content="width=device-width">

    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>

<header id="header" class="<?php if(!is_home() || !is_front_page()){echo 'normal';} ?>">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-8 col-md-6">
                    <ul>
                        <?php if(get_theme_mod('header_social_facebook')): ?>
                            <li><a href="<?php echo get_theme_mod('header_social_facebook'); ?>"><i class="fa fa-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if(get_theme_mod('header_social_twitter')): ?>
                            <li><a href="<?php echo get_theme_mod('header_social_twitter'); ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if(get_theme_mod('header_social_linkedin')): ?>
                            <li><a href="<?php echo get_theme_mod('header_social_linkedin'); ?>"><i class="fa fa-linkedin"></i></a></li>
                        <?php endif; ?>
                        <?php if(get_theme_mod('header_social_whatsapp')): ?>
                            <?php // TODO: FIX: whatsapp-open-chat-link ?>
                            <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
                        <?php endif; ?>
                        <?php if(get_theme_mod('header_social_phone')): ?>
                            <?php // TODO: FIX: tel:phone-number ?>
                            <li><a href="#"><i class="fa fa-phone"></i> <span><?php echo get_theme_mod('header_social_phone'); ?></span></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-4 col-md-6 pr-3 pr-lg-0">
                    <?php if(is_active_sidebar('header_top_bar')): ?>
                        <?php dynamic_sidebar('header_top_bar'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="logo">
                        <a href="<?php echo get_home_url() ?>">
                            <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri().'/inc/img/hockey-vacatures-logo.png'; ?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <?php $args = array(
                        'menu'          => 'primary',
                        'menu_class'    => 'main-menu'
                    );
                    wp_nav_menu( $args ); ?>
                    <div class="menu-toggle">
                        <a href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="main" class="page">


