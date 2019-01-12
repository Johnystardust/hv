<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Vacature_Form extends HV_Forms_Helper
{

    protected $form_fields;
    protected $form_data;
    protected $vacature;
    protected $flags;
    protected $user;
    protected $edit = false;

    public function __construct($atts = array())
    {
        $this->user = new WP_User(get_current_user_id());

        // Get the vacature or create an new object
        if (isset($atts['edit_id']) && !empty($atts['edit_id'])) {
            $this->vacature = HV_Vacature::find($atts['edit_id']);
            $this->edit = true;
        } else {
            $this->vacature = new HV_Vacature();
//            $this->vacature->post()->post_status = 'review';
        }

        // The form data
        $this->form_fields = array_merge($this->get_form_fields(), $this->get_address_fields(), $this->get_user_address_fields());
    }

    /**
     * Get the vacature form fields
     *
     * @return array
     */
    private function get_form_fields()
    {
        return array(
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
//            'date' => array(
//                'type'       => 'select',
//                'label'      => __('Datum', 'hockey_vacatures'),
//                'name'       => 'date',
//                'options'    => array(
//                    'default' => __('Maak een keuze...', 'hockey_vacatures'),
//                    'male'    => __('Per direct', 'hockey_vacatures'),
//                    'female'  => __('Vanaf Datum', 'hockey_vacatures'),
//                ),
//                'col_size'   => 'col-12 col-md-6',
//                'required'   => true,
//                'value'      => $this->vacature->date,
//                'validation' => array(
//                    'required' => true,
//                    'type'     => 'date',
//                ),
//            ),
            'vacature_category' => array(
                'type'       => 'select',
                'label'      => __('Vacature Type', 'hockey_vacatures'),
                'name'       => 'vacature_category',
                'options'    => hv_get_vacature_categories(),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'value'      => $this->vacature->vacature_cat,
                'validation' => array(
                    'required' => true,
                    'type'     => 'function',
                ),
                'description' => 'option_based',
                'description_options' => hv_get_vacature_category_descriptions(),
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
                ),
            ),
            'age'               => array(
                'type'       => 'select',
                'label'      => __('Leeftijd', 'hockey_vactures'),
                'name'       => 'age',
                'options'    => array(
                    'default' => __('Maak een keuze...', 'hockey_vacatures'),
                    'junior'  => __('Junioren', 'hockey_vactures'),
                    'senior'  => __('Senioren', 'hockey_vactures'),
                ),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'value' => $this->vacature->age,
                'validation' => array(
                    'required' => true,
                    'type' => 'age'
                )
            ),
            'field' => array(
                'type' => 'select',
                'label'      => __('Veld/zaal', 'hockey_vactures'),
                'name'       => 'field',
                'options'    => array(
                    'default' => __('Maak een keuze...', 'hockey_vacatures'),
                    'outdoor'  => __('Veld', 'hockey_vactures'),
                    'indoor'  => __('Zaal', 'hockey_vactures'),
                ),
                'col_size'   => 'col-12 col-md-6',
                'required'   => true,
                'value' => $this->vacature->field,
                'validation' => array(
                    'required' => true,
                    'type' => 'field',
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
     * Get vacature address fields
     *
     * @return array
     */
    private function get_address_fields()
    {
        return array(
            'postal'          => array(
                'type'        => 'text',
                'label'       => __('Postcode', 'hockey_vacatures'),
                'name'        => 'postal',
                'value'       => $this->edit ? $this->vacature->postal : '',
                'placeholder' => __('Postcode', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
            'street_number'   => array(
                'type'        => 'number',
                'label'       => __('Huisnummer', 'hockey_vacatures'),
                'name'        => 'street_number',
                'value'       => $this->edit ? $this->vacature->street_number : '',
                'placeholder' => __('Huisnummer', 'hockey_vacatures'),
                'col_size'    => 'col-6 col-md-3',
                'required'    => true,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'number'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
            'addition'        => array(
                'type'        => 'text',
                'label'       => __('Toevoeging', 'hockey_vacatures'),
                'name'        => 'addition',
                'value'       => $this->edit ? $this->vacature->addition : '',
                'placeholder' => __('Toevoeging', 'hockey_vacatures'),
                'col_size'    => 'col-6 col-md-3',
                'required'    => false,
                'validation'  => array(
                    'required' => false,
                    'type'     => 'text'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
            'city'            => array(
                'type'        => 'text',
                'label'       => __('Stad', 'hockey_vacatures'),
                'name'        => 'city',
                'value'       => $this->edit ? $this->vacature->city : '',
                'placeholder' => __('Stad', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => false,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
            'province'        => array(
                'type'        => 'text',
                'label'       => __('Provincie', 'hockey_vacatures'),
                'name'        => 'province',
                'value'       => $this->edit ? $this->vacature->province : '',
                'placeholder' => __('Provincie', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => false,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
            'street'          => array(
                'type'        => 'text',
                'label'       => __('Straat', 'hockey_vacatures'),
                'name'        => 'street',
                'value'       => $this->edit ? $this->vacature->street : '',
                'placeholder' => __('Straat', 'hockey_vacatures'),
                'col_size'    => 'col-12 col-md-6',
                'required'    => true,
                'readonly'    => false,
                'validation'  => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'disabled'    => !($this->edit && !$this->vacature->alternate_address),
            ),
//            'manual_location' => array(
//                'type'       => 'checkbox',
//                'label'      => __('Handmatig adres invullen', 'hockey_vacatures'),
//                'name'       => 'manual_location',
//                'col_size'   => 'col-12',
//                'required'   => false,
//                'validation' => array(
//                    'required' => false,
//                    'type'     => 'checkbox'
//                ),
//            ),
//            'coordinates'     => array(
//                'type'       => 'hidden',
//                'name'       => 'coordinates',
//                'value'      => $this->edit ? $this->vacature->coordinates : '',
//                'validation' => array(
//                    'required' => true,
//                    'type'     => 'text'
//                ),
//                'disabled'   => !($this->edit && !$this->vacature->alternate_address),
//            ),
        );
    }

    /**
     * Get the user address fields.
     *
     * @return array
     */
    private function get_user_address_fields()
    {
        return array(
            'user_postal'        => array(
                'type'       => 'hidden',
                'name'       => 'user_postal',
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->postal
            ),
            'user_street_number' => array(
                'type'       => 'hidden',
                'name'       => 'user_street_number',
                'validation' => array(
                    'required' => true,
                    'type'     => 'number'
                ),
                'value'      => $this->user->street_number
            ),
            'user_addition'      => array(
                'type'       => 'hidden',
                'name'       => 'user_addition',
                'validation' => array(
                    'required' => false,
                    'type'     => 'text'
                ),
                'value'      => $this->user->user_addition
            ),
            'user_city'          => array(
                'type'       => 'hidden',
                'name'       => 'user_city',
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->city
            ),
            'user_province'      => array(
                'type'       => 'hidden',
                'name'       => 'user_province',
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->province
            ),
            'user_street'        => array(
                'type'       => 'hidden',
                'name'       => 'user_street',
                'validation' => array(
                    'required' => true,
                    'type'     => 'text'
                ),
                'value'      => $this->user->street
            ),
//            'user_coordinates'   => array(
//                'type'       => 'hidden',
//                'name'       => 'user_coordinates',
//                'validation' => array(
//                    'required' => true,
//                    'type'     => 'text'
//                ),
//                'value'      => $this->user->coordinates
//            ),
        );
    }


    /**
     * Output for the vacature form
     *
     * TODO: TEST NONCE FAIL
     *
     * TODO: Redirect to the vacature on complete.
     *
     * @return string
     */
    public function output()
    {
        $output = '';

        if (isset ($_POST['submit'])) {

            // TODO: FIX COORDINATES
            $_POST['coordinates'] = 'fafbnkabkfkadfak2390203';

            $this->remove_unneeded_fields();
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
                        __('De vacature is geplaatst veel succes met de werving! De vacature is zichtbaar na controle.', 'hockey_vacatures'),
                        'success',
                        null,
                        array(get_post_type_archive_link('vacature'), __('Naar vacatures', 'hockey_vacatures'))
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
        $this->vacature->field = $this->form_data['field'];
        $this->vacature->age = $this->form_data['age'];
        $this->vacature->gender = $this->form_data['gender'];
        $this->vacature->flags = '0';

        if (isset($_POST['toggle-address'])) {
            $this->vacature->street = $this->form_data['user_street'];
            $this->vacature->street_number = $this->form_data['user_street_number'];
            $this->vacature->addition = $this->form_data['user_addition'];
            $this->vacature->postal = $this->form_data['user_postal'];
            $this->vacature->city = $this->form_data['user_city'];
            $this->vacature->province = $this->form_data['user_province'];
            $this->vacature->coordinates = $this->form_data['user_coordinates'];
        } else {
            $this->vacature->street = $this->form_data['street'];
            $this->vacature->street_number = $this->form_data['street_number'];
            $this->vacature->addition = $this->form_data['addition'];
            $this->vacature->postal = $this->form_data['postal'];
            $this->vacature->city = $this->form_data['city'];
            $this->vacature->province = $this->form_data['province'];
            $this->vacature->coordinates = $this->form_data['coordinates'];
        }

        $this->vacature->clearTaxonomy('vacature_category');
        $this->vacature->addTaxonomy('vacature_category', (int)$this->form_data['vacature_category']);

        if ($this->vacature = $this->vacature->save(['post_status'  => 'pending'])) {
            return true;
        }

        return false;
    }

    /**
     * Check if the user is post_author
     *
     * TODO: LOG THIS EVENT: a user has tried to edit an page that was not his
     *
     * @return bool
     */
    private function user_can_edit()
    {
        if ($this->edit !== false && get_current_user_id() !== intval($this->vacature->post()->post_author)) {

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

    /**
     * Removes the not needed fields form the form fields, and set the address toggle value.
     */
    private function remove_unneeded_fields()
    {
        if (isset($_POST['toggle-address'])) {
            $this->vacature->alternate_address = true;

            foreach (array_keys($this->get_address_fields()) as $field) {
                if (array_key_exists($field, $this->form_fields)) {
                    unset($this->form_fields[$field]);
                }
            }
        } else {
            $this->vacature->alternate_address = false;

            foreach (array_keys($this->get_user_address_fields()) as $field) {
                if (array_key_exists($field, $this->form_fields)) {
                    unset($this->form_fields[$field]);
                }
            }
        }
    }

    /**
     * Get the users address ad html.
     *
     * @return string
     */
    public function get_user_address_format()
    {
        $html = '<div class="user-address-format">';
        $html .= '<span>' . $this->user->street . ' ' . $this->user->street_number . '</span><br>';
        $html .= '<span>' . $this->user->city . ' ' . $this->user->postal . '</span><br>';
        $html .= '<span>' . $this->user->province . '</span><br>';
        $html .= '</div>';

        return $html;
    }

    public function is_alternate_address()
    {
        if ($this->edit && !$this->vacature->alternate_address) {
            return true;
        }

        return false;
    }
}