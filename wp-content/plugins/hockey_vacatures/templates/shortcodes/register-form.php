<form class="px-0" id="hv_reg_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
    <div class="row">
        <div class="col-12 col-md-11">

            <div class="row">
                <?php $this->build_form( $this->get_form_section( array('username', 'role') ) ); ?>
            </div>

            <div class="business-fields disabled row animated fadeIn hideable-fields">
                <div class="col-12">
                    <strong class="text-uppercase"><?php echo __('Club/Onderneming', 'hockey_vactures'); ?></strong>
                    <hr>
                </div>

                <?php $this->build_form($this->get_business_fields()); ?>
            </div>

            <div class="person-fields disabled row animated fadeIn hideable-fields">
                <div class="col-12">
                    <strong class="text-uppercase"><?php echo __('Gebruiker', 'hockey_vactures'); ?></strong>
                    <hr>
                </div>

                <?php $this->build_form($this->get_person_fields()); ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <strong class="text-uppercase"><?php echo __('adresgegevens', 'hockey_vacatures'); ?></strong>
                    <hr>
                </div>
                <?php $this->build_form( $this->get_form_section( array('postal', 'street_number', 'addition', 'city', 'province', 'street', 'blank', 'manual_location', 'coordinates') ) ); ?>
            </div>

            <div class="row">
                <div class="col-12">
                    <strong class="text-uppercase"><?php echo __('Wachtwoord', 'hockey_vacatures'); ?></strong>
                    <hr>
                </div>
                <?php // TODO: IMPLEMENT PASSWORD CHECK !!!! ?>
                <?php $this->build_form( $this->get_form_section( array('password', 'password_check') ) ); ?>
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <span class="description"><?php echo __( 'Velden met een',  'hockey_vacatures' ); ?><span class="required">&nbsp;*&nbsp;</span><?php echo __( 'zijn verplicht',  'hockey_vacatures' ); ?></span>
                </div>
                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="hv_reg_submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo (isset($_GET['id'])) ? __( 'Profiel Bewerken', TEXTDOMAIN ) : __( 'Registreren', TEXTDOMAIN ); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Nonce Field
    wp_nonce_field('register_form_shortcode', 'register_form_nonce');
    ?>
</form>