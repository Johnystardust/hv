<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

global $post;

$background_image = !empty(get_field('banner_image')) ? get_field('banner_image') : get_stylesheet_directory_uri().'/inc/img/hockeyvacatures-banner.jpg';

?>
<div id="page-banner" style="background-image: url('<?php echo $background_image ?>');">
    <div class="d-table w-100 h-100">
        <div class="d-table-cell align-middle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if(get_field('banner_title')): ?>
                            <h1><?php echo get_field('banner_title'); ?></h1>
                            <h2><?php echo get_field('banner_subtitle'); ?></h2>
                        <?php elseif(is_archive()): ?>
                            <h1><?php echo post_type_archive_title(); ?></h1>
                        <?php else: ?>
                            <h1><?php echo get_the_title(); ?></h1>
                            <h2><?php echo get_field('banner_subtitle'); ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>