<?php

/**
 * Sale page
 *
 * This file is used to markup the template for the sale page.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>

<div id="register-page" class="page-<?php the_ID(); ?> page-normal">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/page/content', 'page' );
                    endwhile; ?>

                    <?php $edit_id = isset($_GET['id']) ? $_GET['id'] : null; ?>
                    <?php echo do_shortcode('[hockey_vacatures_vacature_form edit_id="'.$edit_id.'"]'); ?>
                </div>

                <div class="col-12 col-md-4 col-xl-3 push-xl-1 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo do_shortcode('[hockey_vacatures_vacature_map]'); ?>

    <?php get_footer() ?>
</div>