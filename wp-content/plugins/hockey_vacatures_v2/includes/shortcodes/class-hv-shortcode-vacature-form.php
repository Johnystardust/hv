<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Vacature_Form extends HV_Forms_Helper {

    private $form_fields;
    private $form_data;

    public function __construct(){
        $this->form_fields = array(
            'title'     => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'function'  => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'gender'    => array(
                'required'  => true,
                'type'      => 'text'
            ),
            'content'   => array(
                'required'  => true,
                'type'      => 'text'
            )
        );
    }

    /**
     * Output for the vacature form
     *
     * @return string
     */
    public function output(){
        $output = '';

        // If the form is submitted run the submit route
        if( isset( $_POST['submit'] ) ) {

            // If the nonce is not validated display failure message
            if( !isset( $_POST['vacature_form_nonce'] ) || !wp_verify_nonce( $_POST['vacature_form_nonce'], 'vacature_form_shortcode' ) ) {
                $output .= $this->render_popup_message(
                    __( 'Foutje bedankt', 'hockey_vacatures' ),
                    __( 'De vacature kan niet worden geplaatst probeer het later nog een keer.', 'hockey_vacatures' )
                );
            }
            else {
                // Get all the data from the form and validate them
                $this->form_data = $this->get_form_data($this->form_fields);
                $this->form_data = $this->validate_form_data($this->form_data, $this->form_fields);

                if( is_wp_error( $this->form_data ) ) {
                    $output .= $this->render_popup_message(
                        __( 'Foutje bedankt', 'hockey_vacatures' ),
                        __( 'De vacature kan niet worden geplaatst door de volgende reden(en):', 'hockey_vacatures' ),
                        'error',
                        $this->form_data->get_error_message()
                    );
                }
                else {
                    // Form is validated lets continue.
                    $post_array = $this->get_post_array( $this->form_data );
                    $new_vacature = wp_insert_post( $post_array );

                    // If the post insert went wrong render the message
                    if( is_wp_error( $new_vacature ) ) {
                        $output .= $this->render_popup_message(
                            __( 'Foutje bedankt', 'hockey_vacatures' ),
                            __( 'De vacature kan niet worden geplaatst door de volgende reden(en):', 'hockey_vacatures' ),
                            'error',
                            $new_vacature->get_error_message()
                        );
                    }
                    else {
                        // Set the object terms if it fails render the message
                        $category_id = wp_set_object_terms( $new_vacature, $this->form_data['function'].'-vacature', 'category' );

                        if( is_wp_error( $category_id ) ) {
                            $output .= $this->render_popup_message(
                                __( 'Foutje bedankt', 'hockey_vacatures' ),
                                __( 'De vacature kan niet worden geplaatst door de volgende reden(en):', 'hockey_vacatures' ),
                                'error',
                                $category_id->get_error_message()
                            );
                        }
                        else {
                            // Object terms are set, good to go. Adding post meta.
                            if( $this->add_post_meta( $new_vacature ) ) {
                                // Post meta is set render success message and redirect to the new post
                                $output .= $this->render_popup_message(
                                    __( 'Vacature geplaatst!', 'hockey_vacatures' ),
                                    __( 'De vacature is geplaatst veel succes met de werving! U word over 5 seconden doorverwezen naar de vacature.', 'hockey_vacatures' ),
                                    'success',
                                    null,
                                    array( get_the_permalink( $new_vacature ), __( 'Naar vacature', 'hockey_vacatures' ) )
                                );
                            }
                            else {
                                // If the post meta is not set ask to contact us.
                                $output .= $this->render_popup_message(
                                    __( 'Foutje bedankt', 'hockey_vacatures' ),
                                    __( 'Uw account is aangemaakt maar er is iets mis gegaan neemt a.u.b. contact op met ons.', 'hockey_vacatures' ),
                                    'error',
                                    null,
                                    array( get_permalink( get_page_by_path( 'contact' ) ), __( 'Naar contact', 'hockey_vacatures' ) )
                                );
                            }
                        }
                    }
                }
            }
        }

        // Add the template for the form
        $output .= include_once( HV_ABSPATH . 'templates/shortcodes/vacature_form.php' );

        return $output;
    }

    /**
     * Get the post_array for the wp_insert_post function.
     *
     * @param $form_data
     * @return array
     */
    public function get_post_array( $form_data ) {
        $post_array = array(
            'post_title'    => wp_strip_all_tags( $form_data['title'] ),
            'post_content'  => $form_data['content'],
            'post_type'     => 'vacature',
            'post_status'   => 'publish',
        );

        return $post_array;
    }

    /**
     * Add the post meta to the post
     *
     * @param $post_id
     * @return bool
     */
    public function add_post_meta( $post_id ){
        $hv_user_data = get_post_meta( get_current_user_id(), 'hv_user_data', true );
        $user = get_userdata( get_current_user_id() );

        // Create the post meta array
        $post_meta = array(
            'function' => $this->form_data['function'],
            'gender'   => $this->form_data['gender'],
            'city'     => $hv_user_data['city'],
            'province' => $hv_user_data['province'],
            'mail'     => $user->user_email,
            'tel'      => $hv_user_data['tel'],
            'latlng'   => $hv_user_data['coordinates'],
        );

        // Add the web url if the user is a club user
        if( in_array( 'club', $user->roles ) ) {
            $post_meta['web_url'] = $hv_user_data['web_url'];
        }

        // Add the post meta
        if( add_post_meta( $post_id, 'hv_vacature_data', $post_meta ) ) {
            return true;
        }

        return false;
    }
}