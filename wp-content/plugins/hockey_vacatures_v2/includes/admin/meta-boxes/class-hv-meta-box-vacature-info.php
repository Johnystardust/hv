<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Meta_Box_Vacature_Info {

    public static function output($post){
        $function   = esc_html(get_post_meta($post->ID, 'function', true));
        $gender     = esc_html(get_post_meta($post->ID, 'gender', true));
        $city       = esc_html(get_post_meta($post->ID, 'city', true));
        $province   = esc_html(get_post_meta($post->ID, 'province', true));

        ?>
        <div class="field">
            <p class="label">
                <label for="function"><?php esc_attr_e( 'Functie', 'hockey_vacatures' ); ?></label>
            </p>
            <select name="function" id="function">
                <option value=""><?php echo __('Maak keuze', 'hockey_vacatures'); ?></option>
                <option <?php selected($function, 'trainer', true); ?> value="trainer"><?php echo __('Trainer', 'hockey_vacatures'); ?></option>
                <option <?php selected($function, 'coach', true); ?> value="coach"><?php echo __('Coach', 'hockey_vacatures'); ?></option>
                <option <?php selected($function, 'speler', true); ?> value="speler"><?php echo __('Speler', 'hockey_vacatures'); ?></option>
            </select>
        </div>
        <div class="field">
            <p class="label">
                <label for="gender"><?php esc_attr_e( 'Geslacht', 'hockey_vacatures' ); ?></label>
            </p>
            <select name="gender" id="gender">
                <option value=""><?php echo __('Maak keuze', 'hockey_vacatures'); ?></option>
                <option <?php selected($gender, 'men', true); ?> value="men"><?php echo __('Man', 'hockey_vacatures'); ?></option>
                <option <?php selected($gender, 'women', true); ?> value="women"><?php echo __('Vrouw', 'hockey_vacatures'); ?></option>
            </select>
        </div>
        <div class="field">
            <p class="label">
                <label for="city"><?php esc_attr_e( 'Plaats', 'hockey_vacatures' ); ?></label>
            </p>
            <input type="text" name="city" placeholder="Bijv. Amsterdam" value="<?php echo $city; ?>" />
        </div>
        <div class="field">
            <p class="label">
                <label for="province"><?php esc_attr_e( 'Provincie', 'hockey_vacatures' ); ?></label>
            </p>
            <input type="text" name="province" placeholder="Bijv. Noord-Holland" value="<?php echo $province; ?>" />
        </div>
        <?php
    }
}