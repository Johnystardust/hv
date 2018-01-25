<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HV_Forms_Helper {

    /**
     * Render a popup
     *
     * @param $title
     * @param $message
     * @param string $type
     * @param null $errors
     * @param null $button
     * @return string
     */
    public function render_popup_message( $title, $message, $type = 'error', $errors = null, $button = null ){
        $html = '';

        $html .= '<div class="message-popup ' . $type . '">';
        $html .= '<div class="message-popup-inner">';
        $html .= '<h5>' . $title . '</h5>';
        $html .= '<p>' . $message . '</p>';
        if( !is_null( $errors ) ){
            $html .= '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $errors . '</strong>';
        }
        if( !is_null( $button ) ) {
            $html .= '<br><br><a href="' . $button[0] . '" class="btn btn-primary"> ' . $button[1] . ' </a>';
        }
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Get the data from the form
     *
     * @param $form_fields
     * @return array
     */
    public function get_form_data($form_fields){
        $form_data = array();

        // TODO: ??? MAYBE ADD SANITATION ???
        foreach( $form_fields as $field_name => $field_data ){
            if ( array_key_exists( $field_name, $_POST ) && !empty( $_POST[ $field_name ] ) ){
                $form_data[ $field_name ] = $this->sanitize_form_data( $_POST[ $field_name ], $field_data );
            }
        }

        return $form_data;
    }

    /**
     * Sanitize the form data
     *
     * @param $value
     * @param $field_data
     * @return mixed|string
     */
    private function sanitize_form_data( $value, $field_data ) {

        $value = stripslashes( $value );
        $value = strip_tags( $value );
        $value = trim( $value );
        $value = htmlspecialchars( $value );

        if( $field_data['type'] === 'text' ) {
            $value = filter_var( $value, FILTER_SANITIZE_STRING );
        }
        elseif ( $field_data['type'] == 'url' ) {
            $value = filter_var( $value, FILTER_SANITIZE_URL );
        }
        elseif ( $field_data['type'] == 'email' ) {
            $value = filter_var( $value, FILTER_SANITIZE_EMAIL );
        }
        elseif ( $field_data['type'] == '' ) {
            $value = filter_var( $value, FILTER_SANITIZE_NUMBER_INT );
        }

        return $value;
    }

    /**
     * Validate the form data
     *
     * TODO: ??? MAYBE LIST ALL ERRORS AND REPORT THEM AT ONCE ???
     *
     * @param $form_data
     * @param array $fields
     * @return WP_Error
     */
    public function validate_form_data( $form_data, $fields = array() ) {

        foreach( $form_data as $key => $value ){

            if( $fields[$key]['required'] == true && empty ( $value ) ) {
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.' );
            }
            elseif( $fields[$key]['type'] == 'role' ) {
                if( !in_array( $value, array( 'club', 'player' ) ) ) {
                    return new WP_Error( 'error', 'Ongeldig gebruikersprofiel' );
                }
            }
            elseif ( isset( $fields[$key]['min_length'] ) && strlen( $value ) < $fields[$key]['min_length'] ) {
                return new WP_Error( $key . '_length', ucfirst( $key ) . ' is te kort. Tenminste ' . $fields[$key]['min_length'] . ' karaters zijn verplicht.');
            }
            elseif ( $fields[$key]['type'] == 'url' && !filter_var( $value, FILTER_VALIDATE_URL ) ) {
                return new WP_Error('website', 'Er is een niet geldige URL ingevuld. Controleer de velden.' );
            }
            elseif( $fields[$key]['type'] == 'email' && !is_email( $value ) ) {
                return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres.');
            }

            // TODO: FIX ME !!!!!!!!
//            elseif( isset( $fields[$key]['vacature_exists'] ) == true && post_exists( $value ) ) {
//                return new WP_Error('post_exists', 'Deze vacature bestaat al. Kies een andere titel.');
//            }
        }

        return $form_data;
    }

    /**
     * Form Builder
     *
     * @since   1.0
     *
     * @param array $form_fields
     * @return string|void
     */
    public function build_form($form_fields = array()){
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
}