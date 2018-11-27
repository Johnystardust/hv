<?php global $post; ?>
<?php $related_vacature = HV_Vacature::find($post->ID); ?>

<div class="col-12 col-lg-4 mb-5 related-vacature">
    <h5 class="title mb-3">
        <a href="<?php echo get_the_permalink(); ?>">
            <?php echo get_the_title(); ?>
        </a>
    </h5>

    <div class="sub-line mb-3">
        <?php $userdata = get_userdata($related_vacature->post()->post_author); ?>
        <strong><?php echo $userdata->first_name . ' ' . $userdata->last_name; ?></strong>
        <span>- <?php echo $related_vacature->city; ?></span>
    </div>

    <p><?php echo wp_trim_words($related_vacature->content, 15); ?></p>

    <a class="btn btn-border"
       href="<?php echo get_the_permalink(); ?>"><?php echo __('Lees meer', TEXTDOMAIN); ?></a>



</div>