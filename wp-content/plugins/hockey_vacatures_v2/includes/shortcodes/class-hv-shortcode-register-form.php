<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Register_Form {

    /**
     * The main shortcode function.
     */
    public static function output(){
        // If the form is submitted run the submit route
        if( isset( $_POST['hv_reg_submit'] ) ) {

            // If the nonce is not validated display failure message
            if( !isset( $_POST['register_form_nonce'] ) || !wp_verify_nonce( $_POST['register_form_nonce'], 'register_form_shortcode' ) ) {
                echo hv_render_popup_message(
                    __( 'Foutje bedankt', 'hockey_vacatures' ),
                    __( 'Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures' )
                );
            }
            else {
                // Get all the data from the form and validate them
                $form_data = self::get_form_data();
                $validated = self::register_form_validation( $form_data );

                if( is_wp_error( $validated ) ) {
                    echo hv_render_popup_message(
                        __( 'Foutje bedankt', 'hockey_vacatures' ),
                        __( 'Het account kan niet worden aangemaakt door de volgende reden(en):', 'hockey_vacatures' ),
                        'error',
                        $validated->get_error_message()
                    );
                }
                else {
                    // Form is validated lets continue.
                    $user_data  = self::get_user_data( $form_data );
                    $user_info  = self::get_user_info( $form_data );
                    $new_user   = wp_insert_user( $user_data );

                    if( is_wp_error( $new_user ) ) {
                        echo hv_render_popup_message(
                            __( 'Foutje bedankt', 'hockey_vacatures' ),
                            __( 'Het account kan niet worden aangemaakt probeer het later nog een keer.', 'hockey_vacatures' ),
                            'error',
                            $new_user->get_error_message()
                        );
                    }
                    else {
                        // User is registered now complete the process

                        // Register the role
                        $user_obj = new WP_User( $new_user );
                        $user_obj->set_role( $form_data['role'] );

                        // Add the user info in the meta
                        if( !empty( $user_info ) ) {
                            // Set the account to active
                            add_user_meta( $new_user, 'hv_account_active', true, false );

                            // Add the user meta if this fails block the account and ask them to contact us
                            if(add_user_meta( $new_user, 'hv_user_data', $user_info, false ) != false ){
                                echo hv_render_popup_message(
                                    __( 'Beste' . $user_info['first_name'], 'hockey_vacatures' ),
                                    __( 'Uw account is geactiveerd, u kunt nu inloggen.', 'hockey_vacatures' ),
                                    'success'
                                );
                            }
                            else {
                                echo hv_render_popup_message(
                                    __( 'Foutje bedankt', 'hockey_vacatures' ),
                                    __( 'Uw account is aangemaakt maar er is iets mis gegaan neemt a.u.b. contact op met ons.', 'hockey_vacatures' )
                                );
                                update_user_meta( $new_user, 'hv_account_active', false );
                            }
                        }
                    }
                }
            }
        }

        self::register_form();
    }

    /**
     * Get all the form field names that are active based on role.
     *
     * @return array
     */
    private static function get_form_data(){
        $form_data = array();
        $form_field_names = array(
            'username',
            'role',
            'password',
            'password_check',
            'postal',
            'street_number',
            'addition',
            'city',
            'province',
            'street',
            'coordinates'
        );
        
        if( $_POST['role'] === 'club' ) {
            $form_field_names[] = 'c_name';
            $form_field_names[] = 'c_cname';
            $form_field_names[] = 'c_description';
            $form_field_names[] = 'c_web_url';
            $form_field_names[] = 'c_email';
            $form_field_names[] = 'c_tel';
        }
        elseif( $_POST['role'] === 'player' ){
            $form_field_names[] = 'p_fname';
            $form_field_names[] = 'p_lname';
            $form_field_names[] = 'p_description';
            $form_field_names[] = 'p_email';
            $form_field_names[] = 'p_age';
            $form_field_names[] = 'p_gender';
            $form_field_names[] = 'p_tel';
        }

        // TODO: ??? MAYBE ADD SANITATION ???
        foreach( $form_field_names as $field_name ){
            if ( array_key_exists( $field_name, $_POST ) && !empty( $_POST[ $field_name ] ) ){
                $form_data[ $field_name ] = $_POST[ $field_name ];
            }
        }

        // If the user forgot password check make an exception
        if( empty( $_POST['password_check'] ) ) {
            $form_data['password_check'] = '';
        }
        
        return $form_data;
    }

    /**
     * Returns the user_data array used for wp_insert_user() function
     *
     * @param $form_data
     * @return array
     */
    private static function get_user_data( $form_data ) {
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
    private static function get_user_info( $form_data ) {
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
     * The validation for the register form
     *
     * TODO: ??? MAYBE LIST ALL ERRORS AND REPORT THEM AT ONCE ???
     *
     * @param $data
     * @return WP_Error
     */
    public static function register_form_validation( $data ) {

        // General
        if(empty($data['username']) || empty($data['password']) || empty($data['role'])) {
            return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden 2.');
        }
        if(strlen($data['username']) < 4) {
            return new WP_Error('username_length', 'Gebruikersnaam is te kort. Tenminste 4 karaters zijn verplicht.');
        }
        if(strlen($data['password']) < 5) {
            return new WP_Error('password', 'Het password moet tenminste 5 karaters bevatten.');
        }
        if($data['password'] !== $data['password_check']) {
            return new WP_Error('password', 'Wachtwoorden zijn niet gelijk.');
        }
        if(username_exists($data['username'])){
            return new WP_Error('username', 'Gebruikersnaam is al in gebruik.');
        }

        // Role specific validation
        if($data['role'] === 'club'){
            if(empty($data['c_name']) || empty($data['c_cname']) || empty($data['c_email'])){
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
            }
            if(!empty($data['web_url'])){
                if(!filter_var($data['web_url'], FILTER_VALIDATE_URL)){
                    return new WP_Error('website', 'Website is not a valid URL');
                }
            }
            if(email_exists($data['c_email'])) {
                return new WP_Error('email', 'Dit email adres is al in gebruik.');
            }
            if(!is_email($data['c_email'])) {
                return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres.');
            }
        }
        elseif($data['role'] === 'player'){
            if(empty($data['p_fname']) || empty($data['p_lname']) || empty($data['p_email']) || empty($data['p_age']) || empty($data['p_gender'])){
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
            }
            if(email_exists($data['p_email'])) {
                return new WP_Error('email', 'Dit email adres is al in gebruik.');
            }
            if(!is_email($data['p_email'])) {
                return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres.');
            }
        }
        else {
            return new WP_Error( 'error', 'Ongeldig gebruikersprofiel');
        }
    }

    /**
     * The register form html output.
     */
    public static function register_form(){
        ?>
        <form class="px-0" id="hv_reg_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="row">
                <div class="col-12 col-md-11">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username"><?php echo __( 'Gebruikersnaam', 'hockey_vacatures' ); ?><span class="required">*</span></label><br>
                            <input class="form-control" type="text" id="username" name="username" placeholder="<?php echo __( 'Gebruikersnaam', 'hockey_vacatures' ); ?>" value="<?php echo(isset($_POST['username']) ? $_POST['username'] : null); ?>">
                            <span class="description"><?php echo __( 'De gebruikersnaam word gebruikt voor het inloggen',  'hockey_vacatures' ); ?></span>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="role"><?php echo __( 'Soort profiel', 'hockey_vacatures' ); ?><span class="required">*</span></label>
                            <select class="form-control custom-select" name="role" id="role">
                                <option value="default"><?php echo __( 'Maak een keuze...', 'hockey_vacatures' ); ?></option>
                                <option value="club" <?php if(isset($_POST['role']) && $_POST['role'] == 'club'){ echo 'selected'; }; ?>><?php echo __( 'Club', 'hockey_vacatures' ); ?></option>
                                <option value="player" <?php if(isset($_POST['role']) && $_POST['role'] == 'player'){ echo 'selected'; }; ?>><?php echo __( 'Speler', 'hockey_vacatures' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="club-fields disabled row animated fadeIn">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Club', 'hockey_vacatures'); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $club_register = array(
                            'c_name' => array(
                                'type'          => 'text',
                                'label'         => __( 'Club naam', 'hockey_vacatures' ),
                                'name'          => 'c_name',
                                'placeholder'   => __( 'Naam', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_cname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Contactpersoon', 'hockey_vacatures' ),
                                'name'          => 'c_cname',
                                'placeholder'   => __( 'Contactpersoon', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_email' => array(
                                'type'          => 'text',
                                'label'         => __( 'E-mail', 'hockey_vacatures' ),
                                'name'          => 'c_email',
                                'placeholder'   => __( 'E-mail', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_web_url' => array(
                                'type'          => 'text',
                                'label'         => __( 'Club website', 'hockey_vacatures' ),
                                'name'          => 'c_web_url',
                                'placeholder'   => __( 'https://www.google.nl', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            // TODO: FIX VALIDATION FOR C_TEL
                            'c_tel' => array(
                                'type'          => 'text',
                                'label'         => __( 'Telefoonnummer', 'hockey_vacatures' ),
                                'name'          => 'c_tel',
                                'placeholder'   => __( 'Telefoonnummer', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            'blank' => array(
                                'type'          => 'blank',
                                'col_size'      => 'col-md-6 hidden-md-down'
                            ),
                            'c_description' => array(
                                'type'          => 'textarea',
                                'label'         => __( 'Omschrijving', 'hockey_vacatures' ),
                                'name'          => 'c_description',
                                'placeholder'   => __( 'Uw bericht', 'hockey_vacatures' ),
                                'rows'          => '7',
                                'cols'          => '30',
                                'col_size'      => 'col-12',
                                'required'      => false,
                                'description'   => __( 'Vul hier een korte omschrijving over u zelf/club', 'hockey_vacatures' )
                            )
                        );
                        hv_build_form($club_register);
                        ?>
                    </div>

                    <div class="player-fields disabled row animated fadeIn">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Speler', 'hockey_vacatures'); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $player_register = array(
                            'p_fname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Naam', 'hockey_vacatures' ),
                                'name'          => 'p_fname',
                                'placeholder'   => __( 'Naam', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_lname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Achternaam', 'hockey_vacatures' ),
                                'name'          => 'p_lname',
                                'placeholder'   => __( 'Achternaam', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            // TODO: FIX VALIDATION FOR P_TEL
                            'p_tel' => array(
                                'type'          => 'text',
                                'label'         => __( 'Telefoonnummer', 'hockey_vacatures' ),
                                'name'          => 'p_tel',
                                'placeholder'   => __( 'Telefoonnummer', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            'p_email' => array(
                                'type'          => 'text',
                                'label'         => __( 'E-mail', 'hockey_vacatures' ),
                                'name'          => 'p_email',
                                'placeholder'   => __( 'E-mail', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_age' => array(
                                'type'          => 'number',
                                'label'         => __( 'Leeftijd', 'hockey_vacatures' ),
                                'name'          => 'p_age',
                                'placeholder'   => __( 'Leeftijd', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_gender' => array(
                                'type'          => 'select',
                                'label'         => __( 'Geslacht', 'hockey_vacatures' ),
                                'name'          => 'p_gender',
                                'options'       => array(
                                    'default'   => __( 'Maak een keuze...', 'hockey_vacatures' ),
                                    'male'      => __( 'Man', 'hockey_vacatures' ),
                                    'female'    => __( 'Vrouw', 'hockey_vacatures' )
                                ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_description' => array(
                                'type'          => 'textarea',
                                'label'         => __( 'Een stukje over uzelf.', 'hockey_vacatures' ),
                                'name'          => 'p_description',
                                'placeholder'   => __( 'Uw bericht', 'hockey_vacatures' ),
                                'rows'          => '7',
                                'cols'          => '30',
                                'col_size'      => 'col-12',
                                'required'      => false,
                                'description'   => __( 'Vul hier een korte omschrijving over u zelf/club', 'hockey_vacatures' )
                            )
                        );
                        hv_build_form($player_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('adresgegevens', 'hockey_vacatures'); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $place_register = array(
                            'postal' => array(
                                'type'          => 'text',
                                'label'         => __( 'Postcode', 'hockey_vacatures' ),
                                'name'          => 'postal',
                                'placeholder'   => __( 'Postcode', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                            ),
                            'street_number' => array(
                                'type'          => 'number',
                                'label'         => __( 'Huisnummer', 'hockey_vacatures' ),
                                'name'          => 'street_number',
                                'placeholder'   => __( 'Huisnummer', 'hockey_vacatures' ),
                                'col_size'      => 'col-6 col-md-3',
                                'required'      => true,
                            ),
                            'addition' => array(
                                'type'          => 'number',
                                'label'         => __( 'Toevoeging', 'hockey_vacatures' ),
                                'name'          => 'addition',
                                'placeholder'   => __( 'Toevoeging', 'hockey_vacatures' ),
                                'col_size'      => 'col-6 col-md-3',
                                'required'      => false,
                            ),
                            'city' => array(
                                'type'          => 'text',
                                'label'         => __( 'Stad', 'hockey_vacatures' ),
                                'name'          => 'city',
                                'placeholder'   => __( 'Stad', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'readonly'      => true
                            ),
                            'province' => array(
                                'type'          => 'text',
                                'label'         => __( 'Provincie', 'hockey_vacatures' ),
                                'name'          => 'province',
                                'placeholder'   => __( 'Provincie', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'readonly'      => true
                            ),
                            'street' => array(
                                'type'          => 'text',
                                'label'         => __( 'Straat', 'hockey_vacatures' ),
                                'name'          => 'street',
                                'placeholder'   => __( 'Straat', 'hockey_vacatures' ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'readonly'      => true
                            ),
                            'blank' => array(
                                'type'          => 'blank',
                                'col_size'      => 'col-md-6 hidden-md-down'
                            ),
                            'manual_location' => array(
                                'type'          => 'checkbox',
                                'label'         => __( 'Handmatig adres invullen', 'hockey_vacatures' ),
                                'name'          => 'manual_location',
                                'col_size'      => 'col-12',
                                'required'      => false,
                            ),
                            'coordinates' => array(
                                'type'          => 'hidden',
                                'name'          => 'coordinates'
                            )
                        );

                        hv_build_form($place_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Wachtwoord / omschrijving', 'hockey_vacatures'); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $user_register = array(
                            'password' => array(
                                'type'          => 'password',
                                'label'         => __( 'Wachtwoord', 'hockey_vacatures' ),
                                'name'          => 'password',
                                'placeholder'   => '',
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'password_check' => array(
                                'type'          => 'password',
                                'label'         => __( 'Wachtwoord Check', 'hockey_vacatures' ),
                                'name'          => 'password_check',
                                'placeholder'   => '',
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),

                        );
                        hv_build_form($user_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <span class="description"><?php echo __( 'Velden met een',  'hockey_vacatures' ); ?><span class="required">&nbsp;*&nbsp;</span><?php echo __( 'zijn verplicht',  'hockey_vacatures' ); ?></span>
                        </div>
                        <div class="form-group col-12">
                            <button class="btn btn-primary" type="submit" name="hv_reg_submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo __( 'Registreren', 'hockey_vacatures' ); ?></button>
                        </div>
                    </div>

                </div>
            </div>

            <?php
            // Nonce Field
            wp_nonce_field('register_form_shortcode', 'register_form_nonce');
            ?>

        </form>
        <?php
    }
}