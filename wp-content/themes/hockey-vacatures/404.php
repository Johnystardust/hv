<?php
/**
 * 404 Page
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<?php get_header(); ?>

<div id="page-<?php the_ID(); ?>" <?php post_class('page-normal'); ?>>
    <?php get_template_part( 'template-parts/page/page', 'banner-404' ); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <?php get_template_part( 'template-parts/page/content', '404' ); ?>
                </div>

                <div class="col-12 col-md-4 col-xl-3 push-xl-1 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo do_shortcode('[hockey_vacatures_vacature_map]'); ?>

<?php get_footer(); ?>