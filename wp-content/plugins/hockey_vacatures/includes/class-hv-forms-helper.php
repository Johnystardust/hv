<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class HV_Forms_Helper
{

    /**
     * Render a popup
     *
     * @param        $title
     * @param        $message
     * @param string $type
     * @param null $errors
     * @param null $button
     *
     * @return string
     */
    public function render_popup_message($title, $message, $type = 'error', $errors = null, $button = null)
    {
        $html = '';

        $html .= '<div class="message-popup ' . $type . '">';
        $html .= '<div class="message-popup-inner">';
        $html .= '<h5>' . $title . '</h5>';
        $html .= '<p>' . $message . '</p>';
        if (!is_null($errors)) {
            $html .= '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $errors . '</strong>';
        }
        if (!is_null($button)) {
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
     *
     * @return array
     */
    public function get_form_data($form_fields)
    {
        $form_data = array();

        foreach ($form_fields as $field_name => $field_data) {
            if (array_key_exists($field_name, $_POST)) {
                $form_data[$field_name] = $this->sanitize_form_data($_POST[$field_name], $field_data);
            }
        }

        return $form_data;
    }

    /**
     * Sanitize the form data
     *
     * @param $value
     * @param $field_data
     *
     * @return mixed|string
     */
    public function sanitize_form_data($value, $field_data)
    {

        $value = stripslashes($value);
        $value = trim($value);
        $value = htmlspecialchars($value);
        //        $value = strip_tags( $value );

        if ($field_data['type'] === 'text' || $field_data['type'] === 'select') {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        } elseif ($field_data['type'] == 'url') {
            $value = filter_var($value, FILTER_SANITIZE_URL);
        } elseif ($field_data['type'] == 'email') {
            $value = filter_var($value, FILTER_SANITIZE_EMAIL);
        } elseif ($field_data['type'] == 'number') {
            $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        }

        return $value;
    }

    /**
     * Validate the form data
     *
     * TODO: ??? MAYBE LIST ALL ERRORS AND REPORT THEM AT ONCE ???
     *
     * @param       $form_data
     * @param array $fields
     * @param       $edit
     *
     * @return WP_Error
     */
    public function validate_form_data($form_data, $fields = array(), $edit = false)
    {

        foreach ($form_data as $key => $value) {
            if (isset($fields[$key]['not_editable']) && $fields[$key]['not_editable'] == true && $edit == true) {
                continue;
            } elseif ($fields[$key]['validation']['required'] == true && empty ($value)) {
                return new WP_Error('field', 'Een verplicht veld "' . $fields[$key]['label'] . '" is niet ingevuld. Controleer alle ingevulde velden.');
            } elseif ($fields[$key]['validation']['type'] == 'role') {
                if (!in_array($value, $this->_get_allowed_registration_roles())) {
                    return new WP_Error('error', 'Ongeldig gebruikersprofiel');
                }
            } elseif ($fields[$key]['validation']['type'] == 'gender') {
                if (!in_array($value, array('male', 'female', 'either'))) {
                    return new WP_Error('error', 'Ongeldig geslacht');
                }
            } elseif ($fields[$key]['validation']['type'] == 'vacature_category') {
                if (!in_array($value, $this->_get_allowed_vacature_categories())) {
                    return new WP_Error('error', 'Ongeldig vacature type');
                }
            } elseif ($fields[$key]['validation']['type'] == 'field') {
                if (!in_array($value, $this->_get_allowed_vacature_field_values())) {
                    return new WP_Error('error', 'Ongeldig veld type');
                }
            } elseif ($fields[$key]['validation']['type'] == 'age') {
                if (!in_array($value, $this->_get_allowed_vacature_age_values())) {
                    return new WP_Error('error', 'Ongeldige leeftijds categorie');
                }
            } elseif ($fields[$key]['validation']['type'] == 'url' && !filter_var($value, FILTER_VALIDATE_URL)) {
                return new WP_Error('website', 'Er is een niet geldige URL ingevuld. Controleer de velden.');
            } elseif ($fields[$key]['validation']['type'] == 'email' && !is_email($value)) {
                return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres.');
            } elseif (isset($fields[$key]['validation']['min_length']) && strlen($value) < $fields[$key]['validation']['min_length']) {
                return new WP_Error($key . '_length', ucfirst($key) . ' is te kort. Tenminste ' . $fields[$key]['validation']['min_length'] . ' karaters zijn verplicht.');
            } elseif (isset($fields[$key]['validation']['vacature_exists']) && $fields[$key]['validation']['vacature_exists'] == true && $this->vacature_exists($value) !== 0) {
                return new WP_Error('post_exists', 'Deze vacature bestaat al. Kies een andere titel.');
            }
        }

        return $form_data;
    }

    /**
     * Check if the post exists
     * Copied straight from the wp-admin/wp-includes/post.php
     *
     * @param        $title
     * @param string $content
     * @param string $date
     *
     * @return int
     */
    private function vacature_exists($title, $content = '', $date = '')
    {
        global $wpdb;

        $post_title = wp_unslash(sanitize_post_field('post_title', $title, 0, 'db'));
        $post_content = wp_unslash(sanitize_post_field('post_content', $content, 0, 'db'));
        $post_date = wp_unslash(sanitize_post_field('post_date', $date, 0, 'db'));

        $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
        $args = array();

        if (!empty ($date)) {
            $query .= ' AND post_date = %s';
            $args[] = $post_date;
        }

        if (!empty ($title)) {
            $query .= ' AND post_title = %s';
            $args[] = $post_title;
        }

        if (!empty ($content)) {
            $query .= ' AND post_content = %s';
            $args[] = $post_content;
        }

        if (!empty ($args))
            return (int)$wpdb->get_var($wpdb->prepare($query, $args));

        return 0;
    }

    /**
     * Form Builder
     *
     * @since   1.0
     *
     * @param array $form_fields
     *
     * @return string|void
     */
    public function build_form($form_fields = array())
    {
        if (!is_array($form_fields)) {
            return;
        }

        $fields_html = '';

        foreach ($form_fields as $field) {

            switch ($field['type']) {
                case('text'):
                case('number'):
                case('password'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>">
                            <?php esc_attr_e($field['label']); ?>
                            <?php if (array_key_exists('required', $field) && $field['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </label>
                        <input id="<?php echo $field['name']; ?>"
                               class="form-control"
                               type="<?php echo $field['type']; ?>"
                               name="<?php echo $field['name']; ?>"
                               placeholder="<?php echo $field['placeholder']; ?>"
                               value="<?php if ($field['name'] !== 'password_check') {
                                   if (isset($_POST[$field['name']])) {
                                       echo $_POST[$field['name']];
                                   } elseif (isset($field['value'])) {
                                       echo $field['value'];
                                   }
                               } ?>"
                            <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?>
                            <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?> >
                        <?php if (array_key_exists('description', $field)): ?>
                            <span class="description"><?php echo $field['description'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php break;
                case('select'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>">
                            <?php echo $field['label'] ?>
                            <?php if (array_key_exists('required', $field) && $field['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </label>
                        <select class="form-control custom-select <?php echo (isset($field['description']) && $field['description'] == 'option_based') ? 'option-based-description' : ''; ?>" name="<?php echo $field['name']; ?>"
                                id="<?php echo $field['name']; ?>" <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?> <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>>
                            <?php foreach ($field['options'] as $option => $value): ?>
                                <option <?php if (isset($_POST[$field['name']]) && $_POST[$field['name']] == $option) {
                                    echo 'selected';
                                } elseif (isset($field['value']) && $field['value'] == $option) {
                                    echo 'selected';
                                }; ?> value="<?php echo $option; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (array_key_exists('description', $field)): ?>
                            <?php if($field['description'] == 'option_based'): ?>
                                <?php foreach ($field['description_options'] as $term => $description_option): ?>
                                    <span id="description-option-<?php echo $term; ?>" class="description-option description"><?php echo $description_option; ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="description"><?php echo $field['description'] ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php break;
                case('textarea'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>">
                            <?php echo $field['label'] ?>
                            <?php if (array_key_exists('required', $field) && $field['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </label>
                        <textarea class="form-control" name="<?php echo $field['name']; ?>"
                                  id="<?php echo $field['name']; ?>" cols="<?php echo $field['cols']; ?>"
                                  rows="<?php echo $field['rows']; ?>" <?php echo (isset($field['disabled']) && $field['disabled']) ? 'disabled' : ''; ?>
                                  placeholder="<?php echo $field['placeholder']; ?>" <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>><?php if (isset($_POST[$field['name']])) {
                                echo $_POST[$field['name']];
                            } elseif (isset($field['value'])) {
                                echo $field['value'];
                            } ?></textarea>
                        <?php if (array_key_exists('description', $field)): ?>
                            <span class="description"><?php echo $field['description'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php break;
                case('checkbox'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="<?php echo $field['name']; ?>"
                                   id="<?php echo $field['name']; ?>" <?php echo (isset($field['readonly']) && $field['readonly']) ? 'readonly' : ''; ?>>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"><?php echo $field['label'] ?></span>
                        </label>
                    </div>
                    <?php break;
                case('blank'): ?>
                    <div class="<?php echo $field['col_size']; ?>"></div>
                    <?php break;
                case('hidden'): ?>
                    <input id="<?php echo $field['name']; ?>" type="hidden" name="<?php echo $field['name']; ?>"
                           value="<?php if (isset($_POST[$field['name']])) {
                               echo $_POST[$field['name']];
                           } elseif (isset($field['value'])) {
                               echo $field['value'];
                           } ?>"/>
                    <?php break;
            }
        }

        return $fields_html;
    }

    /**
     * Get all the allowed vacature categories for the validation
     *
     * @param string $field
     * @return array
     */
    private function _get_allowed_vacature_categories($field = 'term_id')
    {
        $options = array();

        $vacature_terms = get_terms(array(
            'taxonomy'   => 'vacature_category',
            'hide_empty' => false,
        ));

        foreach ($vacature_terms as $vacature_term) {
            if ($field == 'term_id') {
                $options[] = $vacature_term->term_id;
            } elseif ($field == 'slug') {
                $options[] = $vacature_term->slug;
            }
        }

        return $options;
    }

    /**
     * Returns the allowed roles for the user registration form
     *
     * @return array
     */
    private function _get_allowed_registration_roles()
    {
        return array(
            'business',
            'person'
        );
    }

    /**
     * Returns the allowed values for the field on the vacature create
     *
     * @return array
     */
    private function _get_allowed_vacature_field_values()
    {
        return array(
            'outdoor',
            'indoor'
        );
    }

    private function _get_allowed_vacature_age_values(){
        return array(
            'senior',
            'junior'
        );
    }
}