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

    <div id="vacature-single" class="page-normal">
        <?php get_template_part('template-parts/page/page', 'banner'); ?>

        <?php // Top Bar ?>
        <?php echo do_shortcode('[hockey_vacatures_top_bar user="' . get_current_user_id() . '"]'); ?>

        <div class="container-fluid main-content">
            <div class="container main-content-inner">

                <div class="row">
                    <div class="col-12 col-md-8 main-column">
                        <?php include(HV_ABSPATH . 'templates/content-single.php'); ?>
                    </div>
                    <div class="col-12 col-md-4 col-xl-3 push-xl-1 sidebar-column">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php //echo do_shortcode('[hockey_vacatures_vacature_map lat="'.$latlng[1].'" lng="'.$latlng[0].'"]'); // todo: fix maps on vacature single ?>
<?php echo do_shortcode('[hockey_vacatures_vacature_map]'); ?>


<?php get_footer(); ?>