<?php
/**
 * Register Widget Template
 *
 * This file is used to markup register widget.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes/partials
 */

echo $args['before_widget'];

?>
<ul>
    <?php if(is_user_logged_in()): ?>
        <li class="hv-profile-link"><a href="#"><i class="fa fa-user"></i> <span><?php echo __( 'Mijn Profiel', TEXTDOMAIN ); ?></span></a></li>
        <li><a href="<?php echo wp_logout_url(  home_url() ); ?>"><i class="fa fa-sign-out"></i> <span><?php echo __( 'Uitloggen', TEXTDOMAIN ); ?></span></a></li>
    <?php else: ?>
        <li class="hv-login-link">
            <a href="#"><i class="fa fa-sign-in"></i> <span><?php echo __( 'Inloggen', TEXTDOMAIN ); ?></span></a>
            <div class="hv-register-widget-form animated bounceIn">
                <?php
                $form_args = array(
                    'echo'           => true,
                    'redirect'       => home_url( '/wp-admin/' ),
                    'form_id'        => 'loginform',
                    'label_username' => __( 'Username' ),
                    'label_password' => __( 'Password' ),
                    'label_remember' => __( 'Remember Me' ),
                    'label_log_in'   => __( 'Log In' ),
                    'id_username'    => 'user_login',
                    'id_password'    => 'user_pass',
                    'id_remember'    => 'rememberme',
                    'id_submit'      => 'wp-submit',
                    'remember'       => true,
                    'value_username' => NULL,
                    'value_remember' => true
                );

                // Calling the login form.
                wp_login_form( $form_args );
                ?>
            </div>
        </li>
        <?php $register_page = get_page_by_path( 'registreren' ); ?>
        <li><a href="<?php echo get_page_link($register_page->ID); ?>"><i class="fa fa-user-plus"></i> <span><?php echo __( 'Registreren', TEXTDOMAIN ); ?></span></a></li>
    <?php endif; ?>
    <div class="clearfix"></div>
</ul>

<?php
echo $args['after_widget'];
