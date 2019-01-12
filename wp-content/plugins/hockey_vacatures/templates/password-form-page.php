<?php

/**
 * Password page
 *
 * This file is used to markup the template for the password change page.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>

<div id="register-page" class="wrapper page-normal">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <div id="vacatures-top-bar" class="top-bar container-fluid"></div>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <?php

                    // Get the content and title and display them
                    while( have_posts() ) : the_post();
                        get_template_part( 'template-parts/page/content', 'page' );
                    endwhile;

                    // If user is admin don't show the form
                    if( is_user_logged_in() && hv_is_user_admin( wp_get_current_user() ) ) {
                        echo 'Form not available for administrators';
                    } else {
                        $edit_id = isset( $_GET['id'] ) ? $_GET['id'] : null;
                        echo do_shortcode( '[hockey_vacatures_password_change edit_id="' . $edit_id . '"]' );
                    }
                    ?>
                </div>
                <div class="col-12 col-md-4 col-xl-3 push-xl-1 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo do_shortcode( '[hockey_vacatures_vacature_map]' ); ?>

    <?php get_footer() ?>
</div>