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
                <div class="col-12 col-md-6 filter">
                    <div class="filter-inner">
                        <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" id="vacature-filter" method="post">
                            <div class="form-group">
                                <label for="search"><?php echo __('Zoeken', TEXTDOMAIN); ?></label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Zoeken..." value="<?php echo (isset($_POST['search'])) ? $_POST['search'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <?php $categories = get_categories(array('parent' => 17)); ?>
                                <label for="cat"><?php echo __('Functie', TEXTDOMAIN); ?></label>
                                <select name="cat" id="cat" class="custom-select form-control">
                                    <option value=""><?php echo __('Alle vacatures', TEXTDOMAIN); ?></option>
                                    <?php foreach($categories as $category): ?>
                                        <option <?php echo (isset($_POST['cat']) && $_POST['cat'] == $category->term_id) ? 'selected="selected"' : ''; ?> value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit">Zoeken</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-8 main-column vacature-list">
                    <?php
                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                    $args = array(
                        'post_type'         => 'vacatures',
                        'posts_per_page'    => 3,
                        'paged'             => $paged,
                    );



                    // Filters
                    // =======
                    if(!empty($_POST['search'])){
                        $args['s'] = $_POST['search'];
                    }
                    if(!empty($_POST['cat'])){
                        $args['cat'] = array($_POST['cat']);
                    }

                    $the_query = new WP_Query( $args );
                    $post_count = $the_query->found_posts;
                    $post_page_count = $the_query->post_count;

                    if($the_query->have_posts()): ?>
                        <h2 class="font-weight-bold d-inline-block"><?php echo __('Alle Vacatures'); ?></h2>
                        <span class="vacature-counter" style="font-size: 1rem;"><?php echo __('Aantal vacatures', TEXTDOMAIN); ?>: <?php echo $post_count ?></span>
                        <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                            <div class="vacature-item col-12 px-0">
                                <h4 class="title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
                                <h5 class="sub-line"><strong><?php echo get_the_author(); ?></strong><span> - <?php echo get_post_meta($post->ID, 'additional_data', false)[0]['city']; ?></span></h5>
                                <div class="spacer small"></div>
                                <?php if(function_exists('the_views')): ?>
                                    <h5 class="sub-line"><span><?php echo __('Aantal keer bekeken', TEXTDOMAIN); ?> - <?php the_views(); ?></span></h5>
                                <?php endif; ?>
                                <p><?php echo wp_trim_words(get_the_content(), 25); ?></p>
                                <ul class="vacature-info row mt-2">
                                    <li class="col-6 col-md-3">
                                        <i class="fa fa-user"></i>
                                        <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                                        <?php echo ucfirst(get_post_meta($post->ID, 'function', true)); ?>
                                    </li>
                                    <?php if($gender = get_post_meta($post->ID, 'gender', true)): ?>
                                        <li class="col-6 col-md-3">
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
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>

                        <?php if($post_count > $post_page_count): ?>
                            <div class="archive-pagination">
                                <?php
                                $big = 999999999; // need an unlikely integer
                                echo paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format'             => '?paged=%#%',
                                    'total'              => $the_query->max_num_pages,
                                    'current'            => max( 1, get_query_var('paged') ),
                                    'prev_next'          => true,
                                    'prev_text'          => __('Previous'),
                                    'next_text'          => __('Next'),
                                    'type'               => 'list',
//                                    'add_args'           => array('page' => 'test')
                                ));
                                ?>
                            </div>
                        <?php endif ?>
                    <?php else: ?>
                        <!-- TODO: FIX NO POSTS FOUND MESSAGE !!!!!! -->
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