<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

global $post;
$background_image = !empty(get_field('banner_image')) ? get_field('banner_image') : get_stylesheet_directory_uri().'/inc/img/hockey-vacatures-banner-1.jpg';

if(is_home() || is_front_page()): ?>
    <div id="home-banner" style="background-image: url('<?php echo $background_image ?>');">
        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?php if(get_field('banner_title')): ?>
                                <h1><?php echo get_field('banner_title'); ?></h1>
                                <?php if(!empty(get_field('banner_subtitle'))): ?>
                                    <h2><?php echo get_field('banner_subtitle'); ?></h2>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="home-banner-spacer"></div>
<?php else: ?>
    <div id="page-banner" style="background-image: url('<?php echo $background_image ?>');">
        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?php if(is_archive()): ?>
                                <h1><?php echo post_type_archive_title(); ?></h1>
                            <?php elseif(get_field('banner_title')): ?>
                                <h1><?php echo get_field('banner_title'); ?></h1>
                                <?php if(!empty(get_field('banner_subtitle'))): ?>
                                    <h2><?php echo get_field('banner_subtitle'); ?></h2>
                                <?php endif; ?>
                            <?php else: ?>
                                <h1><?php echo get_the_title(); ?></h1>
                                <?php if(!empty(get_field('banner_subtitle'))): ?>
                                    <h2><?php echo get_field('banner_subtitle'); ?></h2>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-banner-spacer"></div>
<?php endif; ?>