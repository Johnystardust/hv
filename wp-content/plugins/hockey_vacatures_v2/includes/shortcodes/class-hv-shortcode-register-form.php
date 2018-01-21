<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Register_Form {

    private $username;

    /**
     * The main shortcode function.
     */
    public static function output(){
        if( isset( $_POST['hv_reg_submit'] ) ) {
            
            if( !isset( $_POST['register_form_nonce'] ) || !wp_verify_nonce( $_POST['register_form_nonce'], 'register_form_shortcode' ) ) {
                // Display failure message
                die('failure message non nonce.');
            }
            else {

                $data = array(
                    'general' => self::get_general_form_data(),
                    'role' => self::get_role_data( $_POST[ 'role' ] )
                );

                try {
                    $data = self::register_form_validation( $data );
                }
                catch ( Exception $e ){
                    return new WP_Error('field', 'message');
                    die;
                }

            }
            
        }

        self::register_form();
    }
    
    
    public static function register_form_validation( $data ) {

//        var_dump($data);
        unset($data['general']['username']);

//        echo '<br>';
//        var_dump($data);

        if(empty($data['general']['username'])){
            throw new Exception('Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
        }

        // General
        // =======
        if(empty($data['general']['username']) || empty($data['general']['password']) || empty($data['general']['email']) || empty($data['general']['role'])) {
            return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
        }
        if(strlen($data['general']['username']) < 4) {
            return new WP_Error('username_length', 'Gebruikersnaam is te kort. Tenminste 4 karaters zijn verplicht.');
        }
        if(strlen($data['general']['password']) < 5) {
            return new WP_Error('password', 'Het password moet tenminste 5 karaters bevatten.');
        }
        if($data['general']['password'] !== $data['general']['password_check']) {
            return new WP_Error('password', 'Wachtwoorden zijn niet gelijk.');
        }
        if(!is_email($data['general']['email'])) {
            return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres.');
        }
        if(username_exists($data['general']['username'])){
            return new WP_Error('username', 'Gebruikersnaam is al in gebruik.');
        }
        if(email_exists($data['general']['email'])) {
            return new WP_Error('email', 'Dit email adres is al in gebruik.');
        }

        // Role specific validation
        // ========================
        if($data['general']['role'] === 'club'){
            var_dump($data['general']['role']);

            die;

            if(empty($data['role']['club_name']) || empty($data['role']['contactperson'])){
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
            }

            if(!empty($data['role']['web_url'])){
                if(!filter_var($data['role']['web_url'], FILTER_VALIDATE_URL)){
                    return new WP_Error('website', 'Website is not a valid URL');
                }
            }
        }
        elseif($data['general']['role'] === 'player'){

            if(empty($data['role']['first_name']) || empty($data['role']['last_name']) || empty($data['role']['age']) || empty($data['role']['gender'])){
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
            }
        }
    }

    /**
     * Get the general form data not including the user role data.
     *
     * @return array
     */
    private static function get_general_form_data(){
        $data = array();
        $general_form_data = array(
            'username',
            'role',
            'description',
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

        foreach( $general_form_data as $item ){
            if ( array_key_exists( $item, $_POST ) && !empty( $_POST[ $item ] ) ){
                $data[ $item ] = $_POST[ $item ];
            }
        }

        return $data;
    }

    /**
     * Get the users data based on the role.
     *
     * @param $role
     * @return array
     */
    private static function get_role_data( $role ){
        $data = array();

        if( $role === 'club' ){
            $general_club_data = array(
                'c_name',
                'c_cname',
                'c_web_url',
                'c_email',
                'c_tel'
            );

            foreach ( $general_club_data as $item ) {
                if ( array_key_exists( $item, $_POST ) && !empty( $_POST[ $item ] ) ){
                    $data[ $item ] = $_POST[ $item ];
                }
            }
        }
        elseif( $role === 'player' ) {
            $general_player_data = array(
                'p_fname',
                'p_lname',
                'p_email',
                'p_age',
                'p_gender',
                'p_tel'
            );

            foreach ( $general_player_data as $item ) {
                if ( array_key_exists( $item, $_POST ) && !empty( $_POST[ $item ] ) ){
                    $data[ $item ] = $_POST[ $item ];
                }
            }
        }

        return $data;
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
                                'name'          => 'description',
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
                                'name'          => 'description',
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