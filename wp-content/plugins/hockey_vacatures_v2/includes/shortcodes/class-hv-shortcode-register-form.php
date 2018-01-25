<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Register_Form extends HV_Forms_Helper {

    private $form_fields;
    private $form_data;

    public function __construct(){
        $this->form_fields = array(
            'username'          => array(
                'required'  => true,
                'type'      => 'text',
                'min_length' => 4
            ),
            'role'              => array(
                'required'  => true,
                'type'      => 'role'
            ),
            'password'          => array(
                'required'  => true,
                'type'      => 'text',
                'min_length' => 5
            ),
            'password_check'    => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'postal'            => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'street_number'     => array(
                'required'  => true,
                'type'      => 'number'
            ),
            'addition'          => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'city'              => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'province'          => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'street'            => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'coordinates'       => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'c_name' => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'c_cname'           => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'c_description'     => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'c_web_url'         => array(
                'required'  => true,
                'type'      => 'url'
            ),
            'c_email'           => array(
                'required'  => true,
                'type'      => 'email',
            ),
            'c_tel'             => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_fname'           => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_lname'           => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_description'     => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_email'           => array(
                'required'  => true,
                'type'      => 'email',
            ),
            'p_age'             => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_gender'          => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'p_tel'             => array(
                'required'  => true,
                'type'      => 'text'
            ),
        );
    }

    public function output(){
        $output = '';

        // If the form is submitted run the submit route
        if( isset( $_POST['hv_reg_submit'] ) ) {

            // If the nonce is not validated display failure message
            if ( !isset( $_POST['register_form_nonce'] ) || !wp_verify_nonce( $_POST['register_form_nonce'], 'register_form_shortcode' ) ) {
                $output .= $this->render_popup_message(
                    __( 'Foutje bedankt', 'hockey_vacatures' ),
                    __( 'Het account kan niet worden aangemaakt door de volgende reden(en):', 'hockey_vacatures' ),
                    'error',
                    null,
                    array('#message-popup-close', __( 'Terug', 'hockey_vacatures' ) )
                );
            }
            else {
                // Get all the data from the form and validate them
                $this->form_data = $this->get_form_data( $this->form_fields );
                $this->form_data = $this->validate_form_data( $this->form_data, $this->form_fields );

                if( is_wp_error( $this->form_data ) ) {
                    $output .= $this->render_popup_message(
                        __( 'Foutje bedankt', 'hockey_vacatures' ),
                        __( 'Het account kan niet worden aangemaakt door de volgende reden(en):', 'hockey_vacatures' ),
                        'error',
                        $this->form_data->get_error_message(),
                        array('#message-popup-close', __( 'Terug', 'hockey_vacatures' ) )
                    );
                }
                else {

                    // Form is validated lets continue.
                    $user_array = $this->get_user_array( $this->form_data );
                    $new_user   = wp_insert_user( $user_array );

                    if( is_wp_error( $new_user ) ) {
                        $output .= $this->render_popup_message(
                            __( 'Foutje bedankt', 'hockey_vacatures' ),
                            __( 'Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures' ),
                            'error',
                            $new_user->get_error_message(),
                            array('#message-popup-close', __( 'Terug', 'hockey_vacatures' ) )
                        );
                    }
                    else {
                        // User is registered now complete the process
                        $user_info  = $this->get_user_info( $this->form_data );

                        if( $this->complete_register_process( $new_user, $user_info) ){
                            // User registered
                            $output .= $this->render_popup_message(
                                __( 'Account aangemaakt!', 'hockey_vacatures' ),
                                __( 'Uw account is geactiveerd, u kunt nu inloggen.', 'hockey_vacatures' ),
                                'success',
                                null,
                                array( home_url(), __( 'Naar home', 'hockey_vacatures' ) )
                            );
                        }
                        else {
                            $output .= $this->render_popup_message(
                                __( 'Foutje bedankt', 'hockey_vacatures' ),
                                __( 'Uw account is aangemaakt maar er is iets mis gegaan neemt a.u.b. contact op met ons.', 'hockey_vacatures' )
                            );

                            update_user_meta( $new_user, 'hv_account_active', false );
                        }
                    }
                }
            }
        }

        // Add the template for the form
        include_once( HV_ABSPATH . 'templates/shortcodes/register-form.php' );

        return $output;
    }

    /**
     * Returns the user_array used for wp_insert_user() function
     *
     * @param $form_data
     * @return array
     */
    private function get_user_array( $form_data ) {
        // Start the general userdata
        $user_data = array(
            'user_login' => $form_data['username'],
            'user_pass'  => $form_data['password'],
        );

        // Complete general userdata
        if( $form_data['role'] === 'club' ) {
            $user_data['first_name']    = $form_data['c_name'];
            $user_data['last_name']     = $form_data['city'];
            $user_data['user_email']    = $form_data['c_email'];
            $user_data['description']   = $form_data['c_description'];
            $user_data['user_url']      = $form_data['c_web_url'];
        }
        elseif ( $form_data['role'] === 'player' ) {
            $user_data['first_name']    = $form_data['p_fname'];
            $user_data['last_name']     = $form_data['p_lname'];
            $user_data['user_email']    = $form_data['p_email'];
            $user_data['description']   = $form_data['p_description'];
        }

        return $user_data;
    }

    /**
     * Returns the user_info for the user meta
     *
     * @param $form_data
     * @return array
     */
    private function get_user_info( $form_data ) {
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

        // Complete general userinfo
        if( $form_data['role'] === 'club' ) {
            $user_info['tel']            = $form_data['c_tel'];
            $user_info['name']           = $form_data['c_name'];
            $user_info['contactperson']  = $form_data['c_cname'];
            $user_info['web_url']        = $form_data['c_web_url'];
        }
        elseif ( $form_data['role'] === 'player' ) {
            $user_info['tel']           = $form_data['p_tel'];
            $user_info['age']           = $form_data['p_tel'];
            $user_info['gender']        = $form_data['p_gender'];
        }

        return $user_info;
    }

    /**
     * Some final work on the registration of the user
     *
     * @param $user_id
     * @param $user_info
     * @return bool
     */
    private function complete_register_process( $user_id, $user_info ){
        // Set the user role
        $user_obj = new WP_User( $user_id );
        $user_obj->set_role( $this->form_data['role'] );

        // Add the user info in the meta if it fails render the message and block the account
        if( add_user_meta( $user_id, 'hv_account_active', true, false ) && add_user_meta( $user_id, 'hv_user_data', $user_info, false ) ) {
            return true;
        }

        return false;
    }

}