<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Register_Form extends HV_Forms_Helper
{
    private $id;
    private $user;
    private $form_fields;
    private $form_data;

    protected $edit = false;

    /**
     * Constructor for the register form Shortcode Class
     *
     * @param array $atts
     */
    public function __construct($atts = array())
    {
        // Get the user and or create a new one
        if (isset($atts['edit_id']) && !empty($atts['edit_id'])) {
            $this->id = $atts['edit_id'];
            $this->edit = true;

            $this->user = new WP_User($this->id);
            $this->form_fields = array_merge($this->get_form_fields(), $this->_get_role_fields($this->get_hv_user_role()));
        } else {
            $this->user = new WP_User();
            $this->form_fields = array_merge($this->get_form_fields(), $this->get_business_fields(), $this->get_person_fields());
        }
    }

    /**
     * The output for the Shortcode
     *
     * @return string
     */
    public function output()
    {
        $output = '';

        if (isset($_POST['hv_reg_submit'])) {
            $output .= $this->submit_form();
        }

        // Add the template for the form
        include_once(HV_ABSPATH . 'templates/shortcodes/register-form.php');

        return $output;
    }

    /**
     * The submit functionality
     *
     * @return string
     */
    public function submit_form()
    {
        $output = '';

        $this->remove_unneeded_fields(isset($_POST['role']) ? $_POST['role'] : '');
        $this->form_data = $this->get_form_data($this->form_fields);
        $this->form_data = $this->validate_form_data($this->form_data, $this->form_fields, $this->edit);

        // Form data and nonce validated
        if ($this->verify_nonce() && !is_wp_error($this->form_data)) {

            // If the user is editing
            if ($this->edit) {
                if (!is_wp_error($this->id = $this->update_user())) {
                    $output .= $this->render_popup_message(
                        __('Account aangepast!', 'hockey_vacatures'),
                        __('Uw account is bewerkt.', 'hockey_vacatures'),
                        'success',
                        null,
                        array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                    );
                } else {
                    $output .= $this->render_popup_message(
                        __('Foutje bedankt', 'hockey_vacatures'),
                        __('Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures'),
                        'error',
                        $this->id->get_error_message(),
                        array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                    );
                }
            } // If the user is registering
            else {
                if (!is_wp_error($this->id = $this->save_user())) {
                    $output .= $this->render_popup_message(
                        __('Account aangemaakt!', 'hockey_vacatures'),
                        __('Uw account is geactiveerd, u kunt nu inloggen.', 'hockey_vacatures'),
                        'success',
                        null,
                        array(home_url() . '?register=true', __('Naar home', 'hockey_vacatures'))
                    );
                } else {
                    $output .= $this->render_popup_message(
                        __('Foutje bedankt', 'hockey_vacatures'),
                        __('Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures'),
                        'error',
                        $this->id->get_error_message(),
                        array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                    );
                }
            }
        } else {
            $error_message = '';
            if (is_wp_error($this->form_data)) {
                $error_message = $this->form_data->get_error_message();
            }
            $output .= $this->render_popup_message(
                __('Foutje bedankt', 'hockey_vacatures'),
                __('Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures'),
                'error',
                $error_message,
                array('#message-popup-close', __('Terug', 'hockey_vacatures'))
            );
        }

        return $output;
    }

    /**
     * Saves the user.
     *
     * First the user array gets made form the form fields.
     * The user is inserted and the id is returned to a new WP_User object where the role is set.
     * Last the users metadata is set and saved.
     *
     * @return WP_Error
     */
    public function save_user()
    {
        $user_array = $this->_get_user_insert_array($this->form_data);
        $this->id = wp_insert_user($user_array);

        if (is_wp_error($this->id)) {
            return new WP_Error('error', $this->id->get_error_message());
        }

        $user_obj = new WP_User($this->id);
        $user_obj->set_role($this->form_data['role']);

        return $this->save_user_meta($this->form_data);
    }

    /**
     * Updates the user.
     *
     * @return WP_Error
     */
    public function update_user()
    {
        return $this->save_user_meta($this->form_data);

        // TODO: ADD EXTRA FUNCTIONALITY SO WE CAN EDIT NAME AND EMAIL
    }

    /**
     * Save the user Meta
     *
     * @param $form_data
     * @return WP_Error
     */
    public function save_user_meta($form_data)
    {
        $user_info = $this->_get_user_meta_array($form_data);

        foreach ($user_info as $key => $value){
            if(!update_user_meta($this->id, $key, $value)){
                if(!$this->edit){
                    return new WP_Error('error', 'Er is iets mis gegaan met het verwerken van uw gegevens.'); // TODO: FIX THIS TEXT
                }
            }
        }

        return $this->id;
    }

    /**
     * Return the users HV role
     *
     * @return string
     */
    private function get_hv_user_role()
    {
        if (in_array('business', $this->user->roles)) {
            return 'business';
        } elseif (in_array('person', $this->user->roles)) {
            return 'person';
        }
    }

    /**
     * Get the default form fields
     *
     * @return array
     */
    private function get_form_fields()
    {
        return array(
            'username'        => array(
                'type'        => 'text',
                'label'       => __('Gebruikersnaam', 'hockey_vacatures'),
                'name'        => 'username',
                'placeholder' => __('Gebruikersnaam', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => ($this->edit) ? null : array(
                    'required'   => true,
                    'type'       => 'text',
                    'min_length' => 4
                ),
                'value'       => ($this->edit) ? $this->user->nickname : null,
                'readonly'    => $this->edit,
                'disabled'    => $this->edit,
            ),
            'role'            => array(
                'type'       => 'select',
                'label'      => __('Type account', 'hockey_vacatures'),
                'name'       => 'role',
                'options'    => array(
                    'default'  => __('Maak een keuze...', 'hockey_vacatures'),
                    'person'   => __('Persoon', 'hockey_vacatures'),
                    'business' => __('Club/Onderneming', 'hockey_vacatures')
                ),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'validation' => array(
                    'required' => true,
                    'type'     => 'role',
                ),
                'value'      => $this->get_hv_user_role(),
                'readonly'   => $this->edit,
                'disabled'   => $this->edit,
            ),

            // Password fields
            'password'        => array(
                'type'        => 'password',
                'label'       => __('Wachtwoord', 'hockey_vacatures'),
                'name'        => 'password',
                'placeholder' => '',
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => ($this->edit) ? null : array(
                    'required'   => !$this->edit,
                    'type'       => 'text',
                    'min_length' => 5
                ),
                'readonly'    => $this->edit,
                'disabled'    => $this->edit,
            ),
            'password_check'  => array(
                'type'        => 'password',
                'label'       => __('Wachtwoord Check', 'hockey_vacatures'),
                'name'        => 'password_check',
                'placeholder' => '',
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => !$this->edit,
                    'type'     => 'text'
                ),
                'readonly'    => $this->edit,
                'disabled'    => $this->edit,
            ),

            // Address fields
            'postal'          => array(
                'type'        => 'text',
                'label'       => __('Postcode', 'hockey_vacatures'),
                'name'        => 'postal',
                'placeholder' => __('Postcode', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->postal
            ),
            'street_number'   => array(
                'type'        => 'number',
                'label'       => __('Huisnummer', 'hockey_vacatures'),
                'name'        => 'street_number',
                'placeholder' => __('Huisnummer', 'hockey_vacatures'),
                'col_size'    => 'col-6 col-md-3',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'number'
                ),
                'value'       => $this->user->street_number
            ),
            'addition'        => array(
                'type'        => 'number',
                'label'       => __('Toevoeging', 'hockey_vacatures'),
                'name'        => 'addition',
                'placeholder' => __('Toevoeging', 'hockey_vacatures'),
                'col_size'    => 'col-6 col-md-3',
                'required'    => false,
                'validation'  => array(
                    'required' => false,
                    'type'     => 'text'
                ),
                'value'       => $this->user->addition
            ),
            'city'            => array(
                'type'        => 'text',
                'label'       => __('Stad', 'hockey_vacatures'),
                'name'        => 'city',
                'placeholder' => __('Stad', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->city
            ),
            'province'        => array(
                'type'        => 'text',
                'label'       => __('Provincie', 'hockey_vacatures'),
                'name'        => 'province',
                'placeholder' => __('Provincie', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->province
            ),
            'street'          => array(
                'type'        => 'text',
                'label'       => __('Straat', 'hockey_vacatures'),
                'name'        => 'street',
                'placeholder' => __('Straat', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->street
            ),
            'manual_location' => array(
                'type'     => 'checkbox',
                'label'    => __('Handmatig adres invullen', 'hockey_vacatures'),
                'name'     => 'manual_location',
                'col_size' => 'col-12',
                'required' => false,
            ),
            'coordinates'     => array(
                'type'       => 'hidden',
                'name'       => 'coordinates',
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->coordinates
            ),
        );
    }


    /**
     * Returns the business fields for the registration form.
     *
     * The business role is for the clubs and enterprises that want to create an account with their
     * company information.
     *
     * @return array
     */
    private function get_business_fields()
    {
        return array(
            'business_name'    => array(
                'type'        => 'text',
                'label'       => __('Club naam', 'hockey_vacatures'),
                'name'        => 'business_name',
                'placeholder' => __('Naam', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->name
            ),
            'business_cname'   => array(
                'type'        => 'text',
                'label'       => __('Contactpersoon', 'hockey_vacatures'),
                'name'        => 'business_cname',
                'placeholder' => __('Contactpersoon', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->contactperson
            ),
            'business_email'   => array(
                'type'        => 'text',
                'label'       => __('E-mail', 'hockey_vacatures'),
                'name'        => 'business_email',
                'placeholder' => __('E-mail', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => ($this->edit) ? null : array(
                    'required' => true,
                    'type'     => 'email',
                ),
                'value'       => $this->user->user_email,
                'readonly'   => $this->edit,
                'disabled'   => $this->edit,
            ),
            'business_web_url' => array(
                'type'        => 'url',
                'label'       => __('Club website', 'hockey_vacatures'),
                'name'        => 'business_web_url',
                'placeholder' => __('https://www.google.nl', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'validation'  => array(
                    'required' => true,
                    'type'     => 'url'
                ),
                'value'       => $this->user->web_url
            ),
            // TODO: FIX VALIDATION FOR business_TEL
            'business_tel'     => array(
                'type'        => 'text',
                'label'       => __('Telefoonnummer', 'hockey_vacatures'),
                'name'        => 'business_tel',
                'placeholder' => __('Telefoonnummer', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->tel
            ),
        );
    }

    /**
     * Returns the person fields for the registration form.
     *
     * Person role, the person role is for normal people who want to register but are not affiliated to a
     * club or enterprise
     *
     * @return array
     */
    private function get_person_fields()
    {
        return array(
            'person_fname'  => array(
                'type'        => 'text',
                'label'       => __('Naam', 'hockey_vacatures'),
                'name'        => 'person_fname',
                'placeholder' => __('Naam', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->first_name
            ),
            'person_lname'  => array(
                'type'        => 'text',
                'label'       => __('Achternaam', 'hockey_vacatures'),
                'name'        => 'person_lname',
                'placeholder' => __('Achternaam', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->last_name
            ),
            // TODO: FIX VALIDATION FOR person_TEL
            'person_tel'    => array(
                'type'        => 'text',
                'label'       => __('Telefoonnummer', 'hockey_vacatures'),
                'name'        => 'person_tel',
                'placeholder' => __('Telefoonnummer', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->tel
            ),
            'person_email'  => array(
                'type'        => 'text',
                'label'       => __('E-mail', 'hockey_vacatures'),
                'name'        => 'person_email',
                'placeholder' => __('E-mail', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => ($this->edit) ? null : array(
                    'required' => true,
                    'type'     => 'email',
                ),
                'value'       => $this->user->user_email,
                'readonly'   => $this->edit,
                'disabled'   => $this->edit,
            ),
            'person_age'    => array(
                'type'        => 'number',
                'label'       => __('Leeftijd', 'hockey_vacatures'),
                'name'        => 'person_age',
                'placeholder' => __('Leeftijd', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'       => $this->user->age
            ),
            'person_gender' => array(
                'type'       => 'select',
                'label'      => __('Geslacht', 'hockey_vacatures'),
                'name'       => 'person_gender',
                'options'    => array(
                    'default' => __('Maak een keuze...', 'hockey_vacatures'),
                    'male'    => __('Man', 'hockey_vacatures'),
                    'female'  => __('Vrouw', 'hockey_vacatures')
                ),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->gender
            ),
        );
    }

    /**
     * Removes the unneeded fields for the not chosen roles
     *
     * @param $role
     */
    private function remove_unneeded_fields($role)
    {
        $role = (!empty($role)) ? $role : $this->get_hv_user_role();

        if ($role === 'person') {
            foreach (array_keys($this->get_business_fields()) as $field) {
                if (array_key_exists($field, $this->form_fields)) {
                    unset($this->form_fields[$field]);
                }
            }
        } elseif ($role === 'business') {
            foreach (array_keys($this->get_person_fields()) as $field) {
                if (array_key_exists($field, $this->form_fields)) {
                    unset($this->form_fields[$field]);
                }
            }
        }
    }

    /**
     * Get the array param for the wp_insert_user function.
     *
     * @param $form_data
     * @return array
     */
    private function _get_user_insert_array($form_data)
    {
        // Start the general userdata
        $user_data = array(
            'user_login' => $form_data['username'],
            'user_pass'  => $form_data['password'],
        );

        // Complete general userdata
        if ($form_data['role'] === 'business') {
            $user_data['first_name'] = $form_data['business_name'];
            $user_data['last_name'] = $form_data['city'];
            $user_data['user_email'] = $form_data['business_email'];
            $user_data['description'] = $form_data['business_description'];
            $user_data['user_url'] = $form_data['business_web_url'];
        } elseif ($form_data['role'] === 'player') {
            $user_data['first_name'] = $form_data['person_fname'];
            $user_data['last_name'] = $form_data['person_lname'];
            $user_data['user_email'] = $form_data['person_email'];
            $user_data['description'] = $form_data['person_description'];
        }

        return $user_data;
    }

    /**
     * Get the array for the user meta saving.
     *
     * @param $form_data
     * @return array
     */
    private function _get_user_meta_array($form_data)
    {
        // Start the general userinfo
        $user_info = array(
            'postal'        => $form_data['postal'],
            'street_number' => $form_data['street_number'],
            'addition'      => $form_data['addition'],
            'city'          => $form_data['city'],
            'province'      => $form_data['province'],
            'street'        => $form_data['street'],
            'coordinates'   => $form_data['coordinates'],
        );

        // If the user is editing this profile set the required role param
        if($this->edit && !isset($form_data['role'])){
            $form_data['role'] = $this->get_hv_user_role();
        }

        // Complete general userinfo
        if ($form_data['role'] === 'business') {
            $user_info['tel'] = $form_data['business_tel'];
            $user_info['name'] = $form_data['business_name'];
            $user_info['contactperson'] = $form_data['business_cname'];
            $user_info['web_url'] = $form_data['business_web_url'];
        } elseif ($form_data['role'] === 'person') {
            $user_info['tel'] = $form_data['person_tel'];
            $user_info['age'] = $form_data['person_age'];
            $user_info['gender'] = $form_data['person_gender'];
            $user_info['first_name'] = $form_data['person_fname'];
            $user_info['last_name'] = $form_data['person_lname'];
        }

        return $user_info;
    }

    /**
     * Returns the role fields if person tries to edit their account
     *
     * @param $user_role
     * @return array
     */
    private function _get_role_fields($user_role)
    {
        if($user_role === 'person'){
            return $this->get_person_fields();
        } elseif ($user_role === 'business'){
            return $this->get_business_fields();
        }

        return array();
    }

    /**
     * Get an section of the form_fields by array key
     *
     * @param array $sections
     *
     * @return array
     */
    private function get_form_section($sections = array())
    {
        $data = array();

        foreach ($sections as $section) {
            if (array_key_exists((string)$section, $this->form_fields)) {
                $data[$section] = $this->form_fields[$section];
            }
        }

        return $data;
    }

    /**
     * Verify the nonce
     *
     * @return bool
     */
    private function verify_nonce()
    {
        if (!isset($_POST['register_form_nonce']) || !wp_verify_nonce($_POST['register_form_nonce'], 'register_form_shortcode')) {
            return false;
        }

        return true;
    }
}