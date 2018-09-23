<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

global $post;
$background_image = ''; //!empty(get_field('banner_image')) ? get_field('banner_image') : get_stylesheet_directory_uri().'/inc/img/hockey-vacatures-random-1.jpg';

// TODO: FIX PAGE BANNER

if(is_home() || is_front_page()): ?>
    <div id="page-slider">
        <div class="slick-container">
            <div class="slide" style="background-image: url('<?php echo $background_image ?>');">
                <div class="d-table w-100 h-100">
                    <div class="d-table-cell align-middle">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
<!--                                    --><?php //if(get_field('banner_title')): ?>
<!--                                        <h1>--><?php //echo get_field('banner_title'); ?><!--</h1>-->
<!--                                        --><?php //if(!empty(get_field('banner_subtitle'))): ?>
<!--                                            <h2>--><?php //echo get_field('banner_subtitle'); ?><!--</h2>-->
<!--                                        --><?php //endif; ?>
<!--                                    --><?php //elseif(is_archive()): ?>
<!--                                        <h1>--><?php //echo post_type_archive_title(); ?><!--</h1>-->
<!--                                    --><?php //else: ?>
<!--                                        <h1>--><?php //echo get_the_title(); ?><!--</h1>-->
<!--                                        --><?php //if(!empty(get_field('banner_subtitle'))): ?>
<!--                                            <h2>--><?php //echo get_field('banner_subtitle'); ?><!--</h2>-->
<!--                                        --><?php //endif; ?>
<!--                                    --><?php //endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?php echo $background_image ?>');">
                <div class="d-table w-100 h-100">
                    <div class="d-table-cell align-middle">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                   <h1>test</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-slider-spacer"></div>
<?php else: ?>
    <div id="page-banner" style="background-image: url('<?php echo $background_image ?>');">
        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
<!--                            --><?php //if(get_field('banner_title')): ?>
<!--                                <h1>--><?php //echo get_field('banner_title'); ?><!--</h1>-->
<!--                                --><?php //if(!empty(get_field('banner_subtitle'))): ?>
<!--                                    <h2>--><?php //echo get_field('banner_subtitle'); ?><!--</h2>-->
<!--                                --><?php //endif; ?>
<!--                            --><?php //elseif(is_archive()): ?>
<!--                                <h1>--><?php //echo post_type_archive_title(); ?><!--</h1>-->
<!--                            --><?php //else: ?>
<!--                                <h1>--><?php //echo get_the_title(); ?><!--</h1>-->
<!--                                --><?php //if(!empty(get_field('banner_subtitle'))): ?>
<!--                                    <h2>--><?php //echo get_field('banner_subtitle'); ?><!--</h2>-->
<!--                                --><?php //endif; ?>
<!--                            --><?php //endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-banner-spacer"></div>
<?php endif; ?>