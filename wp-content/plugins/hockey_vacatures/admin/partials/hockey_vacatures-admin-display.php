<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" name="hockey_vacatures_options" action="options.php">

        <?php
        //Grab all options

        $options = get_option($this->plugin_name);

        var_dump($options);


        // Example Fields
        $checkbox_example       = $options['checkbox_example'];
        $textfield_example      = $options['textfield_example'];

        $image_example_id       = $options['image_example_id'];
        $image_example          = wp_get_attachment_image_src($image_example_id, 'thumbnail');
        $image_example_url      = $image_example[0];

        $colorpicker_example    = $options['colorpicker_example'];


        // New Login customization vars
        $login_logo_id = $options['login_logo_id'];
        $login_logo = wp_get_attachment_image_src( $login_logo_id, 'thumbnail' );
        $login_logo_url = $login_logo[0];
        $login_background_color = $options['login_background_color'];
        $login_button_primary_color = $options['login_button_primary_color'];

        ?>

        <?php
        // This line will add a nonce, option_page, action and http_referer
        settings_fields( $this->plugin_name );

        //
        do_settings_sections( $this->plugin_name );
        ?>

        <section class="example-fields">
            <h2><?php _e('Example Fields', $this->plugin_name);?></h2>

            <!-- Checkbox -->
            <fieldset>
                <legend class="screen-reader-text"><span>Checkbox Example</span></legend>
                <label for="<?php echo $this->plugin_name;?>-checkbox-example">
                    <input type="checkbox" name="<?php echo $this->plugin_name;?>[checkbox_example]" id="<?php echo $this->plugin_name;?>-checkbox-example" value="1" <?php checked( $checkbox_example, 1 ); ?> />
                    <span><?php esc_attr_e( 'Checkbox Example', $this->plugin_name ); ?></span>
                </label>
            </fieldset>

            <br>

            <!-- Text field inputs -->
            <fieldset>
                <label for="<?php echo $this->plugin_name;?>-textfield-example">
                    <strong><?php esc_attr_e( 'Textfield Example', $this->plugin_name ); ?></strong><br>
                    <input type="text" name="<?php echo $this->plugin_name;?>[textfield_example]" id="<?php echo $this->plugin_name;?>-textfield-example" value="<?php if(!empty($textfield_example)) echo $textfield_example;?>" class="regular-text" />
                    <span class="description"><?php esc_attr_e( 'No html tags allowed', $this->plugin_name ); ?></span><br>
                </label>
            </fieldset>

            <br>

            <!-- Image upload -->
            <fieldset>
                <label>
                    <strong><?php esc_attr_e( 'Image Upload Example', $this->plugin_name); ?></strong><br>
                    <input type="hidden" id="image_example_id" name="<?php echo $this->plugin_name;?>[image_example_id]" value="<?php echo $image_example_id; ?>" />
                    <input id="upload_example_button" type="button" class="button" value="<?php _e( 'Upload Example', $this->plugin_name); ?>" />
                    <button id="upload_example_delete_button" class="button"><?php _e('Remove Example', $this->plugin_name); ?></button>
                    <br><br>
                </label>
                <div id="upload_image_example_preview" class="upload-preview <?php if(empty($image_example_id)) echo 'hidden'?>">
                    <small><?php esc_attr_e( 'Image preview', $this->plugin_name);?></small><br>
                    <img src="<?php echo $image_example_url; ?>" />
                </div>
            </fieldset>

            <br>

            <!-- Color picker -->
            <fieldset class="wp_cbf-admin-colors">
                <label for="<?php echo $this->plugin_name;?>-login_background_color">
                    <strong><?php esc_attr_e( 'Colorpicker Example', $this->plugin_name ); ?></strong><br>
                    <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo $this->plugin_name;?>-colorpicker-example" name="<?php echo $this->plugin_name;?>[colorpicker_example]" value="<?php echo $colorpicker_example;?>" />
                </label>
            </fieldset>

            <br>

        </section>

        <hr>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

    </form>

</div>