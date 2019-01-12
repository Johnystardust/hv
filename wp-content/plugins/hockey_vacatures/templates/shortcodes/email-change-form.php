<form class="px-0" id="hv_email_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
    <div class="row">
        <div class="col-12 col-md-11">

            <div class="row">
                <?php $this->build_form($this->get_form_section(array('new_email', 'blank', 'password'))); ?>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <span class="description"><?php echo __( 'Velden met een',  'hockey_vacatures' ); ?><span class="required">&nbsp;*&nbsp;</span><?php echo __( 'zijn verplicht',  'hockey_vacatures' ); ?></span>
                </div>
                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="hv_email_submit"><i class="fa fa-paper-plane"></i> <?php echo __( 'Email Wijzigen', TEXTDOMAIN ); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Nonce Field
    wp_nonce_field('change_email_form_shortcode', 'change_email_form_nonce');
    ?>
</form>