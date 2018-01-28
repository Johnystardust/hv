<?php
/**
 * The user vacatures side panel tab
 */
?>
<?php $user_panel = new HV_Shortcode_User_Panel(); ?>

<h5><?php echo __( 'Vacatures', 'hockey_vacatures' ); ?></h5>
<?php if( $user_posts = $user_panel->get_user_posts() ) : ?>
    <table class="table table-hover mt-3">
        <thead>
        <tr>
            <th><?php echo __( 'Titel', 'hockey_vacatures' ); ?></th>
            <th><?php echo __( 'Datum', 'hockey_vacatures' ); ?></th>
            <th><?php echo __( 'Bekeken', 'hockey_vacatures' ); ?></th>
            <th><?php echo __( 'Acties', 'hockey_vacatures' ); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php while($user_posts->have_posts()): $user_posts->the_post(); ?>
            <?php global $post; ?>

            <?php var_dump($post->ID); ?>
            <tr>
                <td><?php echo get_the_title(); ?></td>
                <td><?php echo get_the_date(); ?></td>
                <td><?php the_views(); ?></td>
                <td>
                    <a class="hv-side-delete-post" href="<?php echo get_delete_post_link($post->ID); ?>"><?php echo __( 'Verwijderen', 'hockey_vacatures' ); ?></a> -
                    <a href="<?php echo home_url() ?>/bewerk-vacature?id=<?php echo $post->ID; ?>" data-id="<?php echo $post->ID; ?>"><?php echo __( 'Bewerken', 'hockey_vacatures' ); ?></a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <hr>
    <p><?php echo __( 'U heeft nog geen vacatures geplaatst.', 'hockey_vacatures' ); ?>&nbsp;<a href="<?php echo get_page_link( get_page_by_path( 'nieuwe-vacature' ) ); ?>"><?php echo __( 'Klik hier', 'hockey_vacatures' ); ?></a>&nbsp;<?php echo __( 'om een vacature te plaatsen', 'hockey_vacatures' ); ?></p>
<?php endif; wp_reset_postdata(); ?>