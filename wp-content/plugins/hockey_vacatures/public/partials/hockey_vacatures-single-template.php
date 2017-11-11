<?php

/**
 * Single Template for the Vacatures Custom Post Type
 *
 * This file is used to markup the single post view for the vacatures custom post type.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>


<div id="vacature-single" class="wrapper">
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <?php while(have_posts()) : the_post(); ?>
                        <h2 class="font-weight-bold"><?php echo get_the_title(); ?></h2>
                        <div class="spacer"></div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <ul class="vacature-info">
                                    <?php
                                    global $post;
                                    $additional_data = get_post_meta($post->ID, 'additional_data', true);

                                    // TODO: FIX SINGLE VACATURE MAPS
                                    // $additional_data['latlng'];
                                    ?>

                                    <li>
                                        <i class="fa fa-user"></i>
                                        <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                                        <?php echo ucfirst($additional_data['function']); ?>
                                    </li>
                                    <?php if($gender = $additional_data['gender']): ?>
                                        <li>
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
                                    <li>
                                        <i class="fa fa-map-marker"></i>
                                        <strong><?php echo __('Plaats:', TEXTDOMAIN); ?></strong>
                                        <?php echo $additional_data['city']; ?>

                                    </li>
                                    <li>
                                        <i class="fa fa-globe"></i>
                                        <strong><?php echo __('Provincie:', TEXTDOMAIN); ?></strong>
                                        <?php echo $additional_data['province']; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-md-6">
                                <ul class="vacature-data">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <strong><?php echo __('Datum:', TEXTDOMAIN); ?></strong>
                                        <?php echo get_the_date('d-m-Y'); ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o"></i>
                                        <strong><?php echo __('Mail:', TEXTDOMAIN); ?></strong>
                                        <a href="mailto:<?php echo $additional_data['mail']; ?>"><?php echo $additional_data['mail']; ?></a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        <strong><?php echo __('Tel:', TEXTDOMAIN); ?></strong>
                                        <a href="tel:<?php echo $additional_data['tel']; ?>"><?php echo $additional_data['tel']; ?></a>
                                    </li>
                                    <li>
                                        <i class="fa fa-external-link"></i>
                                        <strong><?php echo __('Website:', TEXTDOMAIN); ?></strong>
                                        <a target="_blank" href="<?php echo $additional_data['web_url']; ?>"><?php echo $additional_data['web_url']; ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="the-content">
                            <?php the_content() ?>
                        </div>

                        <div class="btn-set mt-3">
                            <a href="mailto:<?php echo get_post_meta($post->ID, 'mail', true); ?>" class="btn btn-primary"><?php echo __('Solliciteren', TEXTDOMAIN); ?></a>
                        </div>

                        <div class="send-notification">
                            <form action="">
                                <input type="hidden" value="<?php echo $post->ID; ?>">
                            </form>


                            <a href="#"><?php echo __('Vacature niet oke? Laat het ons weten!', TEXTDOMAIN); ?></a>
                        </div>

                        <div class="social-share">
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i><span>share</span></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>

                    <?php endwhile; ?>
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
