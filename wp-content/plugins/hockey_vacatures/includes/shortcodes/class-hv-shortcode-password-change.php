<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Password_Change extends HV_Forms_Helper
{
    protected $id;
    protected $user;
    protected $form_fields;
    protected $form_data;

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

            $this->user = new WP_User($this->id);
            $this->form_fields = $this->get_form_fields();
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

        if (isset($_POST['hv_pass_submit'])) {
            $output .= $this->submit_form();
        }

        // Add the template for the form
        include_once(HV_ABSPATH . 'templates/shortcodes/password-change-form.php');

        return $output;
    }

    public function submit_form()
    {
        $output = '';

        $this->form_data = $this->get_form_data($this->form_fields);
        $this->form_data = $this->validate_form_data($this->form_data, $this->form_fields);

        // Form data and nonce validated
        if ($this->verify_nonce() && !is_wp_error($this->form_data)) {

            if(wp_check_password($this->form_data['current_password'], $this->user->user_pass)){
                wp_set_password( $this->form_data['new_password'], $this->id );

                $output .= $this->render_popup_message(
                    __('Wachtwoord gewijzigd!', 'hockey_vacatures'),
                    __('Uw wachtwoord is gewijzigd. U dient opnieuw in te loggen.', 'hockey_vacatures'),
                    'success',
                    null,
                    array(home_url() . '?register=true', __('Login', 'hockey_vacatures'))
                );
            } else {
                $output .= $this->render_popup_message(
                    __('Foutje bedankt', 'hockey_vacatures'),
                    __('Het wachtwoord is niet correct.', 'hockey_vacatures'),
                    'error',
                    null,
                    array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                );
            }
        } else {
            $error_message = null;
            if (is_wp_error($this->form_data)) {
                $error_message = $this->form_data->get_error_message();
            }
            $output .= $this->render_popup_message(
                __('Foutje bedankt', 'hockey_vacatures'),
                __('Het password kan niet worden gewijzigd probeer het later nog een keer.', 'hockey_vacatures'),
                'error',
                $error_message,
                array('#message-popup-close', __('Terug', 'hockey_vacatures'))
            );
        }

        return $output;
    }

    /**
     * Get the fields for the form.
     *
     * @return array
     */
    private function get_form_fields()
    {
        $form_fields = array(
            'new_password' => array(
                'type'        => 'password',
                'label'       => __('Nieuw wachtwoord', 'hockey_vacatures'),
                'name'        => 'new_password',
                'placeholder' => '',
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required'   => true,
                    'type'       => 'text',
                    'min_length' => 5
                ),
            ),
            'new_password_check' => array(
                'type'        => 'password',
                'label'       => __('Nieuw wachtwoord check', 'hockey_vacatures'),
                'name'        => 'new_password_check',
                'placeholder' => '',
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required'   => true,
                    'type'       => 'text',
                    'min_length' => 5
                ),
            ),
            'current_password' => array(
                'type'        => 'password',
                'label'       => __('Huidig wachtwoord', 'hockey_vacatures'),
                'name'        => 'current_password',
                'placeholder' => '',
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required'   => true,
                    'type'       => 'text',
                    'min_length' => 5
                ),
            )
        );

        return $form_fields;
    }

    /**
     * Verify the nonce
     *
     * @return bool
     */
    private function verify_nonce()
    {
        if (!isset($_POST['change_password_form_nonce']) || !wp_verify_nonce($_POST['change_password_form_nonce'], 'change_password_form_shortcode')) {
            return false;
        }

        return true;
    }

}