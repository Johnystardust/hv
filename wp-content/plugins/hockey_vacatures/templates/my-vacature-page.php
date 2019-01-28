<?php

/**
 * My vacatures page
 *
 * This file is used to markup the template for the my vactures overview page.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */

get_header(); ?>

<div id="register-page" class="wrapper page-normal">
    <?php get_template_part('template-parts/page/page', 'banner'); ?>

    <div id="vacatures-top-bar" class="top-bar container-fluid"></div>

    <div class="container-fluid main-content">
        <div class="container main-content-inner">
            <div class="row">
                <div class="col-12 col-md-8 main-column">
                    <?php

                    // Get the content and title and display them
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/page/content', 'page');
                    endwhile;

                    $post_args = array(
                        'post_type'      => 'vacature',
                        'posts_per_page' => -1,
                        'author'         => get_current_user_id(),
                        'post_status'    => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
                    );

                    $the_query = new WP_Query($post_args);
                    ?>

                    <?php if ($the_query->have_posts()): ?>

                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th><?php echo __('Titel', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Type', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Geslacht', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Leeftijd', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Veld/zaal', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Status', 'hockey_vacatures'); ?></th>
                                <th><?php echo __('Acties', 'hockey_vacatures'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                                <?php global $post; ?>
                                <?php $vacature = HV_Vacature::find($post->ID); ?>

                                <tr>
                                    <td><?php echo $vacature->title; ?></td>
                                    <td><?php echo $vacature->vacature_cat; ?></td>
                                    <td><?php echo $vacature->gender; ?></td>
                                    <td><?php echo $vacature->age; ?></td>
                                    <td><?php echo $vacature->field; ?></td>
                                    <td><?php echo get_post_status($vacature->ID); ?></td>
                                    <td>
                                        <a class="hv-side-delete-post"
                                           href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo __('Verwijderen', 'hockey_vacatures'); ?></a>
                                        -
                                        <a href="<?php echo home_url() ?>/bewerk-vacature?id=<?php echo $post->ID; ?>"
                                           data-id="<?php echo $post->ID; ?>"><?php echo __('Bewerken', 'hockey_vacatures'); ?></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p><?php echo __('U heeft nog geen vacatures geplaatst.', 'hockey_vacatures'); ?></p>
                    <?php endif; ?>

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