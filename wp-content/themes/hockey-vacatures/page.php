<?php
/**
 * Page
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<?php get_header(); ?>

<div id="page-<?php the_ID(); ?>" <?php post_class('page-normal'); ?>>
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/page/content', 'page' );
    endwhile; ?>
</div>

<?php get_footer(); ?>
