<form class="px-0" id="new_vacature_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="row">
                <?php $this->build_form($this->form_fields); ?>

                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo (isset($_GET['id'])) ? __( 'Vacature Bewerken', TEXTDOMAIN ) : __( 'Vacature Plaatsen', TEXTDOMAIN ); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php wp_nonce_field('vacature_form_shortcode', 'vacature_form_nonce'); // Nonce Field ?>
</form>