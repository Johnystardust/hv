<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Include core functions.
// =====================================================================================================================
include_once( HV_ABSPATH . 'includes/hv-widgets.php' );

// Core functions.
// =====================================================================================================================

/**
 * Redirect the user on login.
 *
 * @param $redirect_to
 * @param $request
 * @param $user
 * @return string
 */
function redirect_on_login($redirect_to, $request, $user){
    if(isset($user->roles) && is_array($user->roles)){
        if(in_array('administrator', $user->roles)){
            return $redirect_to;
        } else {
            return home_url() . '?login=true';
        }
    } else {
        return $redirect_to;
    }
}
add_action( 'login_redirect', 'redirect_on_login', 10, 3 );

/**
 * Hide the admin bar for all users except admins.
 */
function hv_remove_admin_bar(){
    if( !current_user_can( 'administrator' ) && !is_admin() ){

        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'hv_remove_admin_bar' );

/**
 * Block the /wp-admin for all users except admins.
 *
 * @since	1.0.0
 */
function hv_block_users_form_admin(){
    if( is_admin() && !current_user_can( 'administrator' ) && !(defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
        wp_redirect( home_url() );
        exit;
    }
}
add_action( 'init', 'hv_block_users_form_admin' );

// Helper functions.
// =====================================================================================================================

function hv_render_popup_message( $message ){
    $html = '';

    $html .= '<div class="message-popup error">';
        $html .= '<div class="message-popup-inner">';
            $html .= '<h5>' . __( 'Foutje bedankt', 'hockey_vacatures' ) . '</h5>';
            $html .= '<p>' . __( 'Het account kan niet worden aangemaakt door de volgende reden(en):', 'hockey_vacatures' ) . '</p>';
            $html .= '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $message . '</strong>';
            $html .= '<br><br><a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', 'hockey_vacatures' ) . ' </a>';
        $html .= '</div>';
    $html .= '</div>';

    return $html;
}


/**
 * Form Builder
 *
 * @since   1.0
 *
 * @param array $form_fields
 * @return string|void
 */
function hv_build_form($form_fields = array()){
    if(!is_array($form_fields)){
        return;
    }

    $fields_html = '';

    foreach($form_fields as $field){

        switch($field['type']){
            case('text'):
            case('number'):
            case('password'): ?>
                <div class="form-group <?php echo $field['col_size']; ?>">
                    <label for="<?php echo $field['name']; ?>">
                        <?php esc_attr_e($field['label']); ?>
                        <?php if(array_key_exists('required', $field) && $field['required']): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                    <input id="<?php echo $field['name']; ?>" class="form-control" type="<?php echo $field['type']; ?>" name="<?php echo $field['name']; ?>" placeholder="<?php echo $field['placeholder']; ?>"
                           value="<?php if($field['name'] !== 'password_check'){ echo(isset($_POST[$field['name']]) ? $_POST[$field['name']] : null); } ?>" <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?> <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?> >
                    <?php if(array_key_exists('description', $field)): ?>
                        <span class="description"><?php echo $field['description'] ?></span>
                    <?php endif; ?>
                </div>
                <?php break;
            case('select'): ?>
                <div class="form-group <?php echo $field['col_size']; ?>">
                    <label for="<?php echo $field['name']; ?>">
                        <?php echo $field['label'] ?>
                        <?php if(array_key_exists('required', $field) && $field['required']): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                    <select class="form-control custom-select" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?> <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>>
                        <?php foreach( $field['options'] as $option => $value ): ?>
                            <option <?php if(isset($_POST[$field['name']]) && $_POST[$field['name']] == $option){ echo 'selected'; }; ?> value="<?php echo $option; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(array_key_exists('description', $field)): ?>
                        <span class="description"><?php echo $field['description'] ?></span>
                    <?php endif; ?>
                </div>
                <?php break;
            case('textarea'): ?>
                <div class="form-group <?php echo $field['col_size']; ?>">
                    <label for="<?php echo $field['name']; ?>">
                        <?php echo $field['label'] ?>
                        <?php if(array_key_exists('required', $field) && $field['required']): ?>
                            <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                        <textarea class="form-control" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" cols="<?php echo $field['cols']; ?>" rows="<?php echo $field['rows']; ?>" <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?>
                                  placeholder="<?php echo $field['placeholder']; ?>" <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>><?php echo(isset($_POST[$field['name']]) ? $_POST[$field['name']] : null); ?></textarea>
                    <?php if(array_key_exists('description', $field)): ?>
                        <span class="description"><?php echo $field['description'] ?></span>
                    <?php endif; ?>
                </div>
                <?php break;
            case('checkbox'): ?>
                <div class="form-group <?php echo $field['col_size']; ?>">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo $field['label'] ?></span>
                    </label>
                </div>
                <?php break;
            case('blank'): ?>
                <div class="<?php echo $field['col_size']; ?>"></div>
                <?php break;
            case('hidden'): ?>
                <input id="<?php echo $field['name']; ?>" type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo(isset($_POST[$field['name']]) ? $_POST[$field['name']] : null); ?>">
                <?php break;
        }
    }

    return $fields_html;
}

/**
 * Defines constant if not defined
 *
 * @param $name
 * @param $value
 */
function hv_maybe_define_constant( $name, $value ) {
    if( ! defined( $name) ) {
        define( $name, $value );
    }
}