<?php

/**
 * Single Template for the Vacatures Custom Post Type
 *
 * This file is used to markup the single post view for the vacatures custom post type.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>


<div id="vacature-single" class="wrapper">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-8 main-column">
                    <?php while(have_posts()) : the_post(); ?>
                        <h1 class="title"><?php echo get_the_title(); ?></h1>

                        <div class="row mb-3">
                            <div class="col-6">
                                <ul class="vacature-info">
                                    <li>
                                        <i class="fa fa-user"></i>
                                        <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                                        <?php echo ucfirst(get_post_meta($post->ID, 'function', true)); ?>
                                    </li>
                                    <?php if($gender = get_post_meta($post->ID, 'gender', true)): ?>
                                        <li>
                                            <?php if($gender == 'male'): ?>
                                                <i class="fa fa-mars"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Man', TEXTDOMAIN); ?>
                                            <?php elseif($gender == 'female'): ?>
                                                <i class="fa fa-venus"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Vrouw', TEXTDOMAIN); ?>
                                            <?php elseif($gender == 'either'): ?>
                                                <i class="fa fa-venus-mars"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Geen voorkeur', TEXTDOMAIN); ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="fa fa-map-marker"></i>
                                        <strong><?php echo __('Plaats:', TEXTDOMAIN); ?></strong>
                                        <?php echo get_post_meta($post->ID, 'city', true); ?>

                                    </li>
                                    <li>
                                        <i class="fa fa-globe"></i>
                                        <strong><?php echo __('Provincie:', TEXTDOMAIN); ?></strong>
                                        <?php echo get_post_meta($post->ID, 'province', true); ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="vacature-data">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <strong><?php echo __('Datum:', TEXTDOMAIN); ?></strong>
                                        <?php echo get_the_date('d-m-Y'); ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>
                                        <strong><?php echo __('Mail:', TEXTDOMAIN); ?></strong>
                                        <a href="mailto:<?php echo get_post_meta($post->ID, 'mail', true); ?>"><?php echo get_post_meta($post->ID, 'mail', true); ?></a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <strong><?php echo __('Tel:', TEXTDOMAIN); ?></strong>
                                        <a href="tel:<?php echo get_post_meta($post->ID, 'tel', true); ?>"><?php echo get_post_meta($post->ID, 'tel', true); ?></a>
                                    </li>
                                    <li>
                                        <i class="fa fa-external-link"></i>
                                        <strong><?php echo __('Website:', TEXTDOMAIN); ?></strong>
                                        <a href="<?php echo get_post_meta($post->ID, 'web_url', true); ?>"><?php echo get_post_meta($post->ID, 'web_url', true); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="the-content">
                            <?php the_content() ?>
                        </div>

                        <div class="btn-set mt-3">
                            <a href="mailto:<?php echo get_post_meta($post->ID, 'mail', true); ?>" class="btn btn-primary"><?php echo __('Solliciteren', TEXTDOMAIN); ?></a>
                        </div>

                        <div class="social-share">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i><span>share</span></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>

                    <?php endwhile; ?>
                </div>
                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="maps" class="container-fluid px-0">
    <div class="map-side">
        <div class="map-side-inner">
            <h3>Filters: </h3>
            <ul>
                <li><a href="#">Test Filter</a></li>
                <li><a href="#">Functie</a></li>
                <li><a href="#">Geslacht</a></li>
            </ul>
        </div>
        <a href="#" class="open-map-side"><i class="fa fa-angle-right"></i></a>
        <a href="#" class="map-exit"><i class="fa fa-times"></i></a>
    </div>
    <div id="map-canvas" class="h-100"></div>
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {lat: 52.497215, lng: 4.996103},
                zoom: 9
            });

            var myLatLng = {lat: 52.127692, lng: 5.5596333};
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>

    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3><?php echo __('Bekijk alle vacatures', TEXTDOMAIN); ?></h3>
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
