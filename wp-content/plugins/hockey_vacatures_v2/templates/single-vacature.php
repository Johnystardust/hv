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
    <?php get_template_part( 'template-parts/page/page', 'banner' ); ?>

    <?php // Top Bar ?>
    <?php echo do_shortcode('[hockey_vacatures_top_bar]'); ?>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <?php global $post; ?>
            <?php $vacature = HV_Vacature::find( $post->ID ); ?>

            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <h2 class="font-weight-bold"><?php echo $vacature->title; ?></h2>
                    <div class="spacer"></div>

                    <?php $vacature_info = $vacature->get_single_info(); ?>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <ul class="vacature-info">
<!--                                TODO: FIX ME !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
<!--                                --><?php //foreach( $vacature_info as $key => $value ): ?>
<!--                                    <li>-->
<!--                                        <i class="fa fa-map-marker"></i>-->
<!--                                        <strong>--><?php //echo $value['label']; ?><!--</strong>-->
<!--                                        --><?php //echo $value['value']; ?>
<!--                                    </li>-->
<!--                                --><?php //endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="the-content">
                        <?php echo $vacature->the_content; ?>
                    </div>

                    <div class="btn-set mt-3">
                        <a href="mailto:<?php echo get_post_meta($post->ID, 'mail', true); ?>" class="btn btn-primary"><?php echo __('Solliciteren', TEXTDOMAIN); ?></a>
                    </div>

                    <?php //TODO: Onclick flag this vacature and after 5 flags set it to inacctive and mail the user. ?>
                    <?php //TODO: If the user clicks the link send mail to admins ?>
                    <div class="send-notification">
                        <form action="">
                            <input type="hidden" value="<?php echo $post->ID; ?>">
                        </form>
                        <a href="#"><?php echo __('Vacature niet oke? Laat het ons weten!', TEXTDOMAIN); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo do_shortcode('[hockey_vacatures_vacature_map lat="'.$latlng[1].'" lng="'.$latlng[0].'"]'); ?>


<?php get_footer(); ?>