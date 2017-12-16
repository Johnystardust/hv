<?php

/**
 * My Account Side Panel
 *
 * This file is used to markup the template for the side panel.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */
?>

<div id="hv-side-panel">
    <div class="hv-side-panel-inner slideInRight animated p-3">
        <div class="row">
            <div class="col-3">
                <?php $new_vacature = get_page_by_path( 'nieuwe-vacature' ); ?>
                <a href="<?php echo get_page_link($new_vacature->ID); ?>" class="btn btn-primary btn-full"><?php echo __( 'Vacature Plaatsen', TEXTDOMAIN ); ?>&nbsp;<i class="fa fa-address-book-o"></i></a>
            </div>
            <div class="col-3">
                <?php $sale_page = get_page_by_path( 'tegoed' ); ?>
                <a href="<?php echo get_page_link($sale_page->ID); ?>" class="btn btn-border btn-full"><?php echo __( 'Tegoed kopen', TEXTDOMAIN ); ?>&nbsp;<i class="fa fa-eur"></i></a>
            </div>
            <div class="col-2">
                <a href="#close-side-panel" class="btn btn-border btn-full"><?php echo __( 'Sluiten', TEXTDOMAIN ); ?>&nbsp;<i class="fa fa-times"></i></a>
            </div>
        </div>

        <div class="row mt-5">
            <?php
                $additional_data = get_user_meta(get_current_user_id(), 'user_data', true);
                var_dump($additional_data);
            ?>
            <div class="col-12">
                <?php $user_id = get_current_user_id(); ?>
                <?php $user_data = get_userdata($user_id); ?>

                <h3><?php echo __( 'Hallo ', TEXTDOMAIN ) . $user_data->first_name; ?></h3>
                <span><?php echo __( 'Uw lidmaatschap is nog geldig tot: ' ); ?><?php echo date('d-m-Y', strtotime(get_user_meta($user_id, 'membership_end_date', true))); ?></span><br>
                <span><?php echo __( 'U kunt nog '. get_user_meta($user_id, 'vacature_s_count', true) .' vacatures plaatsen'); ?></span>
            </div>

            <?php
            $vacatures_args = array(
                'post_type'         => 'vacatures',
                'posts_per_page'    => 5,
                'author'            => get_current_user_id(),
            );
            $the_query = new WP_Query( $vacatures_args );
            ?>

            <div class="col-12 mt-3">
                <h5><?php echo __( 'Vacatures', TEXTDOMAIN ); ?></h5>

                <?php if($the_query->have_posts()): ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><?php echo __( 'Titel', TEXTDOMAIN ); ?></th>
                            <th><?php echo __( 'Datum', TEXTDOMAIN ); ?></th>
                            <th><?php echo __( 'Bekeken', TEXTDOMAIN ); ?></th>
                            <th><?php echo __( 'Acties', TEXTDOMAIN ); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                            <?php global $post; ?>
                            <tr>
                                <td><?php echo get_the_title(); ?></td>
                                <td><?php echo get_the_date(); ?></td>
                                <td><?php the_views(); ?></td>
                                <td>
                                    <a class="hv-side-delete-post" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo __( 'Verwijderen', TEXTDOMAIN ); ?></a> -
                                    <a href="<?php echo get_the_permalink(); ?>"><?php echo __( 'Bekijken', TEXTDOMAIN ); ?></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <hr>
                    <p><?php echo __( 'U heeft nog geen vacatures geplaatst.', TEXTDOMAIN ); ?>&nbsp;<a href="<?php echo get_page_link($new_vacature->ID); ?>"><?php echo __( 'Klik hier', TEXTDOMAIN ); ?></a>&nbsp;<?php echo __( 'om een vacature te plaatsen', TEXTDOMAIN ); ?></p>
                <?php endif; wp_reset_postdata(); ?>
            </div>

        </div>
    </div>
</div>
