<?php

/**
 * Register page
 *
 * This file is used to markup the template for the register page.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>

<div id="register-page" class="wrapper">
    <div class="container-fluid px-0" style="background-image: url('<?php echo get_stylesheet_directory_uri().'/inc/img/hockeyvacatures-banner.jpg'; ?>'); height: 300px; position: relative;">
        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle">
                <div class="container">

                    <h1 class="text-uppercase">Registreren</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="top-bar container-fluid">
        <div class="container">
            <div class="row">
                <div class="top-bar-item col-md-3">
                    <a href="#" class="icon-left"><i class="fa fa-filter"></i>Filter</a>
                </div>
                <div class="top-bar-item col-md-3">
                    <a href="#open-side-panel" class="icon-left"><i class="fa fa-user"></i>Mijn Profiel</a>
                </div>
                <div class="top-bar-item col-md-3">
                    <a href="#" class="icon-left"><i class="fa fa-id-card-o"></i>Alle Vacatures</a>
                </div>
                <div class="top-bar-item col-md-3">
                    <a href="#" class="icon-right">Bekijk op kaart<i class="fa fa-map-signs"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-8 main-column">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/page/content', 'page' );
                    endwhile; ?>

                    <br>
                    <br>

                    <?php echo do_shortcode('[hockey_vacatures_register_form]'); ?>
                </div>

                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>

                </div>
            </div>
        </div>
    </div>

    <div id="maps" class="container-fluid px-0">
        <div id="map-canvas" class="h-100"></div>
        <script>
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 8
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Bekijk nu alle vacatures</h3>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer() ?>
</div>