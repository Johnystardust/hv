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

<?php while ( have_posts() ) : the_post();

    get_template_part( 'template-parts/page/content', '404' );

    if(comments_open() || get_comments_number()) :
        comments_template();
    endif;

endwhile; ?>

<?php get_footer(); ?>