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

get_header(); ?>

<div id="vacature-archive" class="page-normal">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-8 main-column vacature-list">
                    <?php
                    $args = array(
                        'post_type'         => 'vacatures',
                    );

                    $the_query = new WP_Query( $args );
                    $post_count = $the_query->post_count;

                    if($the_query->have_posts()):
                    ?>
                        <h1 class="title d-inline-block">Alle Vacatures</h1>
                        <span class="d-inline pull-right" style="font-size: 1rem;"><?php echo __('Aantal vacatures', TEXTDOMAIN); ?>: <?php echo $post_count ?></span>
                    <?php
                        while($the_query->have_posts()): $the_query->the_post();
                            // TODO: FIX GET TEMPLATE PART
                            ?>
                            <div class="vacature-item col-12 px-0">
                                <h3 class="title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                                <h5 class="sub-line"><strong><?php echo get_the_author(); ?></strong><span> - <?php echo get_post_meta($post->ID, 'city', true); ?></span></h5>
                                <?php if(function_exists('the_views')): ?>
                                    <h5 class="sub-line"><span><?php echo __('Aantal keer bekeken', TEXTDOMAIN); ?> - <?php the_views(); ?></span></h5>
                                <?php endif; ?>
                                <p><?php echo wp_trim_words(get_the_content(), 40); ?></p>
                                <ul class="vacature-info row mt-2">
                                    <li class="col-3">
                                        <i class="fa fa-user"></i>
                                        <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                                        <?php echo ucfirst(get_post_meta($post->ID, 'function', true)); ?>
                                    </li>
                                    <?php if($gender = get_post_meta($post->ID, 'gender', true)): ?>
                                        <li class="col-3">
                                            <?php if($gender == 'male'): ?>
                                                <i class="fa fa-mars"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Man', TEXTDOMAIN); ?>
                                            <?php elseif($gender == 'female'): ?>
                                                <i class="fa fa-venus"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Vrouw', TEXTDOMAIN); ?>
                                            <?php elseif($gender == 'either'): ?>
                                                <i class="fa fa-venus-mars"></i>
                                                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                                <?php echo __('Geen voorkeur', TEXTDOMAIN); ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="btn-set">
                                    <a class="btn btn-primary" href="<?php echo get_the_permalink(); ?>"><?php echo __( 'Meer informatie', TEXTDOMAIN ); ?></a>
                                    <a class="btn btn-border" href="mailto:info@timvanderslik.nl"><?php echo __( 'Solliciteer direct', TEXTDOMAIN ); ?></a>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        $big = 999999999; // need an unlikely integer

                        echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format' => '?paged=%#%',
                            'current' => max( 1, get_query_var('paged') ),
                            'total' => $wp_query->max_num_pages,
                        ) );

                    else:
                        echo 'test';
                    endif;
                    ?>
                </div>

                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="maps" class="container-fluid px-0">
        <div id="map-canvas" class="h-100"></div>
        <script>
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 8
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Bekijk nu alle vacatures</h3>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer() ?>
</div>