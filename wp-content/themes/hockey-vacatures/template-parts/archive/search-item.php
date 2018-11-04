
<?php global $post; ?>

<div class="search-item vacature-item col-12 px-0">
    <h4 class="title">
        <a href="<?php echo get_the_permalink(); ?>">
            <?php echo get_the_title(); ?>
        </a>
    </h4>
    <h5 class="sub-line">
        <strong><?php echo get_the_author(); ?></strong>
    </h5>
    <p><?php echo wp_trim_words(get_the_content(), 25); ?></p>
    <div class="btn-set">
        <a class="btn btn-primary"
           href="<?php echo get_the_permalink(); ?>"><?php echo __('Lees meer', TEXTDOMAIN); ?></a>
    </div>
</div>