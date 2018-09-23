<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Vacature_Form extends HV_Forms_Helper
{

    private   $form_fields;
    private   $form_data;
    private   $vacature;
    protected $edit = false;

    public function __construct($atts = array())
    {
        // Get the vacature or create an new object
        if (isset($atts['edit_id']) && !empty($atts['edit_id'])) {
            $this->vacature = HV_Vacature::find($atts['edit_id']);
            $this->edit = true;
        } else {
            $this->vacature = new HV_Vacature();
        }

        // The form data
        $this->form_fields = array(
            'title'             => array(
                'type'        => 'text',
                'label'       => __('Titel', 'hockey_vacatures'),
                'name'        => 'title',
                'placeholder' => __('Titel', 'hockey_vacatures'),
                'col_size'    => 'col-12',
                'required'    => true,
                'value'       => $this->vacature->title,
                'validation'  => array(
                    'required'        => true,
                    'vacature_exists' => !$this->edit,
                    'type'            => 'text',
                ),
                'readonly'    => $this->edit
            ),
            'vacature_category' => array(
                'type'       => 'select',
                'label'      => __('Vacature Type', 'hockey_vacatures'),
                'name'       => 'vacature_category',
                'options'    => hv_get_vacature_categories(),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'value'      => $this->vacature->function, // TODO: FIX VALUE INSERT FOR EDIT. Get the category id and set it here
                'validation' => array(
                    'required' => true,
                    'type'     => 'function',
                )
            ),
            'gender'            => array(
                'type'       => 'select',
                'label'      => __('Geslacht', 'hockey_vacatures'),
                'name'       => 'gender',
                'options'    => array(
                    'default' => __('Maak een keuze...', 'hockey_vacatures'),
                    'male'    => __('Man', 'hockey_vacatures'),
                    'female'  => __('Vrouw', 'hockey_vacatures'),
                    'either'  => __('Geen voorkeur', 'hockey_vacatures')
                ),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'value'      => $this->vacature->gender,
                'validation' => array(
                    'required' => true,
                    'type'     => 'gender',
                )
            ),
            'content'           => array(
                'type'        => 'textarea',
                'cols'        => 5,
                'rows'        => 10,
                'label'       => __('Bericht', 'hockey_vacatures'),
                'name'        => 'content',
                'col_size'    => 'col-12',
                'required'    => true,
                'value'       => $this->vacature->content,
                'placeholder' => 'Bericht',
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text',
                )
            ),
        );
    }

    /**
     * Output for the vacature form
     *
     * // TODO: TEST NONCE FAIL
     *
     * @return string
     */
    public function output()
    {
        $output = '';

        if (isset ($_POST['submit'])) {
            $this->form_data = $this->get_form_data($this->form_fields);
            $this->form_data = $this->validate_form_data($this->form_data, $this->form_fields);

            if ($this->user_can_edit() && $this->verify_nonce() && !is_wp_error($this->form_data) && $this->save_vacature()) {

                // If the user is editing a vacature
                if ($this->edit) {
                    $output .= $this->render_popup_message(
                        __('Vacature Bewerkt!', 'hockey_vacatures'),
                        __('De vacature is opgeslagen. U word over 5 seconden doorverwezen naar de vacature.', 'hockey_vacatures'),
                        'success',
                        null,
                        array($this->vacature->permalink(), __('Naar vacature', 'hockey_vacatures'))
                    );
                } // If the user is creating a new vacature
                else {
                    $output .= $this->render_popup_message(
                        __('Vacature geplaatst!', 'hockey_vacatures'),
                        __('De vacature is geplaatst veel succes met de werving! U word over 5 seconden doorverwezen naar de vacature.', 'hockey_vacatures'),
                        'success',
                        null,
                        array($this->vacature->permalink(), __('Naar vacature', 'hockey_vacatures'))
                    );
                }
            } else {
                $output .= $this->render_popup_message(
                    __('Foutje bedankt', 'hockey_vacatures'),
                    __('De vacature kan niet worden geplaatst door de volgende reden(en):', 'hockey_vacatures'),
                    'error',
                    is_wp_error($this->form_data) ? $this->form_data->get_error_message() : '',
                    array('#message-popup-close', __('Terug', 'hockey_vacatures'))
                );
            }
        }

        // TODO: ADD REDIRECT TO SAVED VACATURE
        include_once(HV_ABSPATH . 'templates/shortcodes/vacature-form.php');

        return $output;
    }

    /**
     * Save the vacature in the form
     *
     * @return bool
     */
    public function save_vacature()
    {
        $this->vacature->title = $this->form_data['title'];
        $this->vacature->content = $this->form_data['content'];
        $this->vacature->vacature_cat = $this->form_data['vacature_category'];
        $this->vacature->gender = $this->form_data['gender'];

        $this->vacature->addTaxonomy('vacature_category', (int)$this->form_data['vacature_category']);

        if ($this->vacature = $this->vacature->save()) {
            return true;
        }

        return false;
    }

    /**
     * Check if the user is post_author
     *
     * @return bool
     */
    private function user_can_edit()
    {
        if ($this->edit !== false && get_current_user_id() !== intval($this->vacature->post()->post_author)) {
            // TODO: LOG THIS EVENT: a user has tried to edit an page that was not his
            return false;
        }

        return true;
    }

    /**
     * Verify the nonce
     *
     * @return bool
     */
    private function verify_nonce()
    {
        if (!isset ($_POST['vacature_form_nonce']) || !wp_verify_nonce($_POST['vacature_form_nonce'], 'vacature_form_shortcode')) {
            return false;
        }

        return true;
    }
}