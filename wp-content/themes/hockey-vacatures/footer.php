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
            <div class="col-md-6 push-md-3 text-center">
                <p><?php echo get_theme_mod('footer_copyright_text', true); ?></p>
            </div>
            <div class="col-md-3 push-md-3 copyright-social">
                <ul class="list-unstyled">
                    <li class="social-item">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <div class="social-popup animated bounceInRight"><strong><?php echo __( 'Find us on Facebook', TEXTDOMAIN ); ?></strong></div>
                    </li>
                    <li class="social-item">
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <div class="social-popup animated bounceInRight"><strong><?php echo __( 'Find us on Twitter', TEXTDOMAIN ); ?></strong></div>
                    </li>
                    <li class="social-item">
                        <a href="#"><i class="fa fa-youtube"></i></a>
                        <div class="social-popup animated bounceInRight"><strong><?php echo __( 'Find us on YouTube', TEXTDOMAIN ); ?></strong></div>
                    </li>
                </ul>
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