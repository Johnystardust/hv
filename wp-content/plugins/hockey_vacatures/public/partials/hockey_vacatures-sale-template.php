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

<div id="register-page" class="wrapper">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-8 main-column">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/page/content', 'page' );
                    endwhile; ?>

                    <br>
                    <br>

                    <?php echo do_shortcode('[hockey_vacatures_sale_form]'); ?>
                </div>

                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer() ?>
</div>