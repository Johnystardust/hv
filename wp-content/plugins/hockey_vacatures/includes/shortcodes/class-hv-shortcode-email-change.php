<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Email_Change extends HV_Forms_Helper
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

        if (isset($_POST['hv_email_submit'])) {
            $output .= $this->submit_form();
        }

        // Add the template for the form
        include_once(HV_ABSPATH . 'templates/shortcodes/email-change-form.php');

        return $output;
    }

    public function submit_form()
    {
        $output = '';

        $this->form_data = $this->get_form_data($this->form_fields);
        $this->form_data = $this->validate_form_data($this->form_data, $this->form_fields);

        // Form data and nonce validated
        if ($this->verify_nonce() && !is_wp_error($this->form_data)) {

            if(wp_check_password($this->form_data['password'], $this->user->user_pass)){
                $this->user->user_email = $this->form_data['new_email'];
                $user_update = wp_update_user($this->user);

                if(!is_wp_error($user_update)){
                    $output .= $this->render_popup_message(
                        __('E-mail gewijzigd!', 'hockey_vacatures'),
                        __('Uw email is gewijzigd.', 'hockey_vacatures'),
                        'success',
                        null,
                        array(home_url(), __('Terug', 'hockey_vacatures'))
                    );
                } else {
                    $output .= $this->render_popup_message(
                        __('Foutje bedankt', 'hockey_vacatures'),
                        __('Het email adres kan niet worden gewijzigd probeer het later nog een keer.', 'hockey_vacatures'),
                        'error',
                        $user_update->get_error_message(),
                        array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                    );
                }
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
                __('Het email adres kan niet worden gewijzigd probeer het later nog een keer.', 'hockey_vacatures'),
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
            'new_email' => array(
                'type'        => 'text',
                'label'       => __('Nieuwe E-mail', 'hockey_vacatures'),
                'name'        => 'new_email',
                'placeholder' => __('E-mail', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'email',
                ),
            ),
            'blank' => array(
                'type'     => 'blank',
                'col_size' => 'col-12 col-md-6',
            ),
            'password' => array(
                'type'        => 'password',
                'label'       => __('Wachtwoord', 'hockey_vacatures'),
                'name'        => 'password',
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
        if (!isset($_POST['change_email_form_nonce']) || !wp_verify_nonce($_POST['change_email_form_nonce'], 'change_email_form_shortcode')) {
            return false;
        }

        return true;
    }

}