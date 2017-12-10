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

<div id="page-404" <?php post_class('page-normal'); ?>>
    <?php get_template_part( 'template-parts/page/page', 'banner-404' ); ?>


    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/page/content', '404' );
    endwhile; ?>

    <div class="container-fluid page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-8 main-column page-content">
                    <h1><?php echo __( 'Sorry, we kunnen deze pagina niet meer vinden', TEXTDOMAIN ); ?></h1>
                    <br>
                    <p><?php echo __( 'We hebben ons best gedaan, maar het lijkt erop dat deze pagina niet (meer) bestaat of misschien verhuisd is. Je kunt natuurlijk altijd naar de homepage of de zoekfunctie gebruiken.', TEXTDOMAIN ); ?></p>

                    <?php get_search_form(); ?>
                </div>
                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>




