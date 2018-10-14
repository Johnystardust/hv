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


    <div id="vacature-single" class="page-normal">
        <?php get_template_part('template-parts/page/page', 'banner'); ?>

        <?php // Top Bar ?>
        <?php echo do_shortcode('[hockey_vacatures_top_bar user="' . get_current_user_id() . '"]'); ?>

        <div class="container-fluid main-content">
            <div class="container main-content-inner">
                <?php global $post; ?>
                <?php $vacature = HV_Vacature::find($post->ID); ?>

                <div class="row">
                    <div class="col-12 col-md-8 main-column">
                        <h2 class="font-weight-bold"><?php echo $vacature->title; ?></h2>
                        <div class="spacer"></div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <ul class="vacature-info">
                                    <?php if ($function_term = get_term_by('id', $vacature->function, 'vacature_category')): ?>
                                        <li>
                                            <i class="fa fa-user"></i>
                                            <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                                            <?php echo $function_term->name; ?>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <i class="fa fa-user"></i>
                                        <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                                        <?php echo $vacature->get_vacature_gender() ?>
                                    </li>
                                    <?php if (!empty($vacature->get_vacature_author_meta_by_key('city'))): ?>
                                        <li>
                                            <i class="fa fa-map-marker"></i>
                                            <strong><?php echo __('Plaats:', TEXTDOMAIN); ?></strong>
                                            <?php echo $vacature->get_vacature_author_meta_by_key('city'); ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (!empty($vacature->get_vacature_author_meta_by_key('province'))): ?>
                                        <li>
                                            <i class="fa fa-globe"></i>
                                            <strong><?php echo __('Provincie:', TEXTDOMAIN); ?></strong>
                                            <?php echo $vacature->get_vacature_author_meta_by_key('province'); ?>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-12 col-md-6">
                                <ul class="vacature-data">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <strong><?php echo __('Datum:', TEXTDOMAIN); ?></strong>
                                        <?php echo get_the_date('d-m-Y'); ?>
                                    </li>
                                    <?php if (!empty($vacature->get_vacature_author_email())): ?>
                                        <li>
                                            <i class="fa fa-envelope-o"></i>
                                            <strong><?php echo __('Mail:', TEXTDOMAIN); ?></strong>
                                            <?php echo $vacature->get_vacature_author_email(); ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (!empty($vacature->get_vacature_author_meta_by_key('tel'))): ?>
                                        <li>
                                            <i class="fa fa-phone"></i>
                                            <strong><?php echo __('Tel:', TEXTDOMAIN); ?></strong>
                                            <?php echo $vacature->get_vacature_author_meta_by_key('tel'); ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (!empty($vacature->get_vacature_author_url())): ?>
                                        <li>
                                            <i class="fa fa-external-link"></i>
                                            <strong><?php echo __('Website:', TEXTDOMAIN); ?></strong>
                                            <?php echo $vacature->get_vacature_author_url(); ?>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="the-content">
                            <?php echo $vacature->the_content; ?>
                        </div>

                        <?php if (!empty($vacature->get_vacature_author_email())): ?>
                            <div class="btn-set mt-3">
                                <a href="mailto:<?php echo $vacature->get_vacature_author_email(); ?>"
                                   class="btn btn-primary"><?php echo __('Solliciteren', TEXTDOMAIN); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php //TODO: Onclick flag this vacature and after * flags set it to inacctive and mail the user. ?>
                        <?php //TODO: If the user clicks the link send mail to admins ?>
                        <?php //TODO: Add the * ass option in the backend ?>
                        <div class="send-notification">
                            <a id="hv-flag-vacature" href="#" data-id="<?php echo $post->ID; ?>" data-nonce="<?php echo wp_create_nonce('vacature_flag_nonce'); ?>"><?php echo __('Vacature niet oke? Laat het ons weten!', TEXTDOMAIN); ?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php //echo do_shortcode('[hockey_vacatures_vacature_map lat="'.$latlng[1].'" lng="'.$latlng[0].'"]'); ?>
<?php echo do_shortcode('[hockey_vacatures_vacature_map]'); ?>


<?php get_footer(); ?>