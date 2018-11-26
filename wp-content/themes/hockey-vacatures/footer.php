<?php
/**
 * Footer
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

</div>

<footer>
    <div class="container big-block">
        <?php get_template_part('template-parts/footer/footer', 'widgets'); ?>
    </div>
</footer>

<div id="copyright" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p><?php echo get_theme_mod('footer_copyright_text', true); ?></p>
            </div>

        </div>
    </div>
</div>

<?php if( is_user_logged_in() ) : ?>
    <?php echo do_shortcode('[hockey_vacatures_user_panel]'); ?>
<?php endif; ?>

</body>
<?php wp_footer(); ?>
</html>