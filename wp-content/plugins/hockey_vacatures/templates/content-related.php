<div class="col-12 col-lg-4 mb-5 related-vacature">
    <h5 class="title mb-3">
        <a href="<?php echo get_the_permalink($related_post->ID); ?>">
            <?php echo $related_post->post_title; ?>
        </a>
    </h5>

    <div class="sub-line mb-3">
        <?php $userdata = get_userdata($related_post->post_author); ?>
        <strong><?php echo $userdata->first_name . ' ' . $userdata->last_name; ?></strong>
        <span>- <?php echo $related_post->city; ?></span>
    </div>

    <p><?php echo wp_trim_words($related_post->post_content, 15); ?></p>

    <a class="btn btn-border" href="<?php echo get_the_permalink($related_post->ID); ?>"><?php echo __('Lees meer', TEXTDOMAIN); ?></a>
</div>