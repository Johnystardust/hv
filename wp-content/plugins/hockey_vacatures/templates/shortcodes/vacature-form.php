<form class="px-0" id="new_vacature_form" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
    <div class="row">
        <div class="col-12 col-md-11">
            <div class="row">
                <?php $this->build_form($this->get_form_section(array('title', 'vacature_category', 'gender', 'age', 'field'))); ?>
            </div>
            <div class="new-vacature-address-toggle row">
                <div class="form-group col-12">
                    <?php $alternate_address = $this->is_alternate_address(); ?>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="toggle-address"
                               id="toggle-address" <?php echo ($alternate_address) ? '' : 'checked="checked"'; ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo __('Gebruik mijn huidige adres', 'hockey_vacatures'); ?></span>
                    </label>

                    <div class="address-toggle current-address <?php echo ($alternate_address) ? 'hidden' : ''; ?>">
                        <?php echo $this->get_user_address_format(); ?>
                        <?php $this->build_form($this->get_form_section(array('user_postal', 'user_street_number', 'user_addition', 'user_city', 'user_province', 'user_street', 'user_coordinates'))); ?>
                    </div>
                </div>
            </div>
            <div class="address-toggle alternate-address row <?php echo ($alternate_address) ? '' : 'hidden'; ?>">
                <?php $this->build_form($this->get_form_section(array('postal', 'street_number', 'addition', 'city', 'province', 'street', 'blank', 'manual_location', 'coordinates'))); ?>
            </div>
            <div class="row">
                <?php $this->build_form($this->get_form_section(array('content'))); ?>
                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-paper-plane"></i>
                        &nbsp; <?php echo (isset($_GET['id'])) ? __('Vacature Bewerken', TEXTDOMAIN) : __('Vacature Plaatsen', TEXTDOMAIN); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php wp_nonce_field('vacature_form_shortcode', 'vacature_form_nonce'); // Nonce Field ?>
</form>