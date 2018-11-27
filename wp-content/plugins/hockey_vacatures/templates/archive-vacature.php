<?php

/**
 * Archive Template for the Vacatures Custom Post Type
 *
 * This file is used to markup the archive view for the vacatures custom post type.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

global $wp_query;

get_header(); ?>

<div id="vacature-archive" class="page-normal">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar user="'.get_current_user_id().'"]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <?php
                $vacature_terms = get_terms( array(
                    'taxonomy' => 'vacature_category',
                    'hide_empty' => true,
                ) );
                ?>
                <div class="col-12 col-md-8 main-column vacature-list">
                    <?php $post_count = $wp_query->found_posts; ?>
                    <?php if ( have_posts() ) : ?>
                        <h2 class="font-weight-bold d-inline-block"><?php echo __('Alle Vacatures'); ?></h2>
                        <span class="vacature-counter" style="font-size: 1rem;"><?php echo __('Aantal vacatures', TEXTDOMAIN); ?>: <?php echo $post_count ?></span>

                        <?php while ( have_posts() ) : the_post();
                            include( HV_ABSPATH . 'templates/content-archive.php' );
                        endwhile;

                        the_posts_pagination( array(
                            'screen_reader_text' => '',
                            'mid_size' => 1,
                            'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>',
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                        ) );
                    else : ?>
                        <h2 class="font-weight-bold d-inline-block"><?php echo __('Geen Vacatures'); ?></h2>
                        <p><?php echo __('Helaas er zijn geen zoekresultaten gevonden.'); ?></p>
                    <?php endif; ?>
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