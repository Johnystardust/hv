<?php
/* Template Name: Sidebar right page */
?>

<?php get_header(); ?>

    <div id="page-<?php the_ID(); ?>" <?php post_class('page-normal'); ?>>
        <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

        <div class="container-fluid main-content">
            <div class="container main-content-inner">
                <div class="row">
                    <div class="col-12 col-md-8 main-column">
                        <?php while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/page/content', 'page' );
                        endwhile; ?>
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