<?php
/**
 * Index
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>
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

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column vacature-list">
                    <?php if ( have_posts() ) : ?>
                        <h2 class="font-weight-bold d-inline-block"><?php echo __('Zoeken'); ?></h2>
<!--                        <span class="vacature-counter" style="font-size: 1rem;">--><?php //echo __('Aantal vacatures', TEXTDOMAIN); ?><!--: --><?php //echo $post_count ?><!--</span>-->

                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part('template-parts/archive/search', 'item'); ?>
                        <?php endwhile; ?>
                    <?php else : ?>
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