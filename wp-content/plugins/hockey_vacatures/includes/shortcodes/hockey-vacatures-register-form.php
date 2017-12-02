<?php
/**
 * Class Hockey_Vacatures_Register_Form
 *
 * @since   1.0.0
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/hockey-vacatures-forms.php';

class Hockey_Vacatures_Register_Form extends Hockey_Vacatures_Forms {

    // General Vars
    private $username;
    private $email;
    private $role;
    private $description;
    private $tel;
    private $password;
    private $password_check;

    // Location Vars
    private $postal;
    private $street_number;
    private $addition;
    private $city;
    private $province;
    private $street;
    private $coordinates;

    // Player Vars
    private $first_name;
    private $last_name;
    private $age;
    private $gender;

    // Club Vars
    private $club_name;
    private $contactperson;
    private $web_url;

    /**
     * The markup for the register form.
     *
     * @since   1.0.0
     */
    public function register_form(){
        ?>
        <form class="px-0" id="hv_reg_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="row">
                <div class="col-12 col-md-11">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="username"><?php echo __( 'Gebruikersnaam', TEXTDOMAIN ); ?><span class="required">*</span></label><br>
                            <input class="form-control" type="text" id="username" name="username" placeholder="<?php echo __( 'Gebruikersnaam', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['username']) ? $_POST['username'] : null); ?>">
                            <span class="description"><?php echo __( 'De gebruikersnaam word gebruikt voor het inloggen',  TEXTDOMAIN ); ?></span>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="role"><?php echo __( 'Soort profiel', TEXTDOMAIN ); ?><span class="required">*</span></label>
                            <select class="form-control custom-select" name="role" id="role">
                                <option value="default"><?php echo __( 'Maak een keuze...', TEXTDOMAIN ); ?></option>
                                <option value="club" <?php if(isset($_POST['role']) && $_POST['role'] == 'club'){ echo 'selected'; }; ?>><?php echo __( 'Club', TEXTDOMAIN ); ?></option>
                                <option value="player" <?php if(isset($_POST['role']) && $_POST['role'] == 'player'){ echo 'selected'; }; ?>><?php echo __( 'Speler', TEXTDOMAIN ); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="club-fields disabled row animated fadeIn">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Club', TEXTDOMAIN); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $club_register = array(
                            'c_name' => array(
                                'type'          => 'text',
                                'label'         => __( 'Club naam', TEXTDOMAIN ),
                                'name'          => 'c_name',
                                'placeholder'   => __( 'Naam', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_cname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Contactpersoon', TEXTDOMAIN ),
                                'name'          => 'c_cname',
                                'placeholder'   => __( 'Contactpersoon', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_email' => array(
                                'type'          => 'text',
                                'label'         => __( 'E-mail', TEXTDOMAIN ),
                                'name'          => 'c_email',
                                'placeholder'   => __( 'E-mail', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'c_web_url' => array(
                                'type'          => 'text',
                                'label'         => __( 'Club website', TEXTDOMAIN ),
                                'name'          => 'c_web_url',
                                'placeholder'   => __( 'https://example.nl', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            // TODO: FIX VALIDATION FOR C_TEL
                            'c_tel' => array(
                                'type'          => 'text',
                                'label'         => __( 'Telefoonnummer', TEXTDOMAIN ),
                                'name'          => 'c_tel',
                                'placeholder'   => __( 'Telefoonnummer', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            'blank' => array(
                                'type'          => 'blank',
                                'col_size'      => 'col-md-6 hidden-md-down'
                            ),
                            'c_description' => array(
                                'type'          => 'textarea',
                                'label'         => __( 'Omschrijving', TEXTDOMAIN ),
                                'name'          => 'description',
                                'placeholder'   => __( 'Uw bericht', TEXTDOMAIN ),
                                'rows'          => '7',
                                'cols'          => '30',
                                'col_size'      => 'col-12',
                                'required'      => false,
                                'description'   => __( 'Vul hier een korte omschrijving over u zelf/club', TEXTDOMAIN )
                            )
                        );
                        $this->build_form($club_register);
                        ?>
                    </div>

                    <div class="player-fields disabled row animated fadeIn">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Speler', TEXTDOMAIN); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $player_register = array(
                            'p_fname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Naam', TEXTDOMAIN ),
                                'name'          => 'p_fname',
                                'placeholder'   => __( 'Naam', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_lname' => array(
                                'type'          => 'text',
                                'label'         => __( 'Achternaam', TEXTDOMAIN ),
                                'name'          => 'p_lname',
                                'placeholder'   => __( 'Achternaam', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            // TODO: FIX VALIDATION FOR P_TEL
                            'p_tel' => array(
                                'type'          => 'text',
                                'label'         => __( 'Telefoonnummer', TEXTDOMAIN ),
                                'name'          => 'p_tel',
                                'placeholder'   => __( 'Telefoonnummer', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6'
                            ),
                            'p_email' => array(
                                'type'          => 'text',
                                'label'         => __( 'E-mail', TEXTDOMAIN ),
                                'name'          => 'p_email',
                                'placeholder'   => __( 'E-mail', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_age' => array(
                                'type'          => 'number',
                                'label'         => __( 'Leeftijd', TEXTDOMAIN ),
                                'name'          => 'p_age',
                                'placeholder'   => __( 'Leeftijd', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_gender' => array(
                                'type'          => 'select',
                                'label'         => __( 'Geslacht', TEXTDOMAIN ),
                                'name'          => 'p_gender',
                                'options'       => array(
                                    'default'   => __( 'Maak een keuze...', TEXTDOMAIN ),
                                    'male'      => __( 'Man', TEXTDOMAIN ),
                                    'female'    => __( 'Vrouw', TEXTDOMAIN )
                                ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'p_description' => array(
                                'type'          => 'textarea',
                                'label'         => __( 'Een stukje over uzelf.', TEXTDOMAIN ),
                                'name'          => 'description',
                                'placeholder'   => __( 'Uw bericht', TEXTDOMAIN ),
                                'rows'          => '7',
                                'cols'          => '30',
                                'col_size'      => 'col-12',
                                'required'      => false,
                                'description'   => __( 'Vul hier een korte omschrijving over u zelf/club', TEXTDOMAIN )
                            )
                        );
                        $this->build_form($player_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('adresgegevens', TEXTDOMAIN); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $place_register = array(
                            'postal' => array(
                                'type'          => 'text',
                                'label'         => __( 'Postcode', TEXTDOMAIN ),
                                'name'          => 'postal',
                                'placeholder'   => __( 'Postcode', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                            ),
                            'street_number' => array(
                                'type'          => 'number',
                                'label'         => __( 'Huisnummer', TEXTDOMAIN ),
                                'name'          => 'street_number',
                                'placeholder'   => __( 'Huisnummer', TEXTDOMAIN ),
                                'col_size'      => 'col-6 col-md-3',
                                'required'      => true,
                            ),
                            'addition' => array(
                                'type'          => 'number',
                                'label'         => __( 'Toevoeging', TEXTDOMAIN ),
                                'name'          => 'addition',
                                'placeholder'   => __( 'Toevoeging', TEXTDOMAIN ),
                                'col_size'      => 'col-6 col-md-3',
                                'required'      => false,
                            ),
                            'city' => array(
                                'type'          => 'text',
                                'label'         => __( 'Stad', TEXTDOMAIN ),
                                'name'          => 'city',
                                'placeholder'   => __( 'Stad', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'disabled'      => false
                            ),
                            'province' => array(
                                'type'          => 'text',
                                'label'         => __( 'Provincie', TEXTDOMAIN ),
                                'name'          => 'province',
                                'placeholder'   => __( 'Provincie', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'disabled'      => false
                            ),
                            'street' => array(
                                'type'          => 'text',
                                'label'         => __( 'Straat', TEXTDOMAIN ),
                                'name'          => 'street',
                                'placeholder'   => __( 'Straat', TEXTDOMAIN ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true,
                                'disabled'      => false
                            ),
                            'blank' => array(
                                'type'          => 'blank',
                                'col_size'      => 'col-md-6 hidden-md-down'
                            ),
                            'manual_location' => array(
                                'type'          => 'checkbox',
                                'label'         => __( 'Handmatig adres invullen', TEXTDOMAIN ),
                                'name'          => 'manual_location',
                                'col_size'      => 'col-12',
                                'required'      => false,
                            ),
                            'coordinates' => array(
                                'type'          => 'hidden',
                                'name'          => 'coordinates'
                            )
                        );

                        $this->build_form($place_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <strong class="text-uppercase"><?php echo __('Wachtwoord / omschrijving', TEXTDOMAIN); ?></strong>
                            <hr>
                        </div>
                        <?php
                        $user_register = array(
                            'password' => array(
                                'type'          => 'password',
                                'label'         => __( 'Wachtwoord', TEXTDOMAIN ),
                                'name'          => 'password',
                                'placeholder'   => '',
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'password_check' => array(
                                'type'          => 'password',
                                'label'         => __( 'Wachtwoord Check', TEXTDOMAIN ),
                                'name'          => 'password_check',
                                'placeholder'   => '',
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),

                        );
                        $this->build_form($user_register);
                        ?>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <span class="description"><?php echo __( 'Velden met een',  TEXTDOMAIN ); ?><span class="required">&nbsp;*&nbsp;</span><?php echo __( 'zijn verplicht',  TEXTDOMAIN ); ?></span>
                        </div>
                        <div class="form-group col-12">
                            <button class="btn btn-primary" type="submit" name="hv_reg_submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo __( 'Registreren', TEXTDOMAIN ); ?></button>
                        </div>
                    </div>

                </div>
            </div>

        </form>
        <?php
    }

    /**
     * Validation for the registration form.
     *
     * @since   1.0.0
     *
     * @return WP_Error
     *
     * @TODO: FIX: MESSAGES TEXT
     * @TODO: TEST FUNCTIONALITY
     *
     */
    public function register_form_validation(){

        // General
        // =======
        if(empty($this->username) || empty($this->password) || empty($this->email) || empty($this->role)) {
            return new WP_Error('field', 'Required form field is missing');
        }
        if(strlen($this->username) < 4) {
            return new WP_Error('username_length', 'Gebruikersnaam is te kort. Tenminste 4 karaters zijn verplicht');
        }
        if(strlen($this->password) < 5) {
            return new WP_Error('password', 'Het password moet tenminste 5 karaters bevatten');
        }
        if($this->password !== $this->password_check) {
            return new WP_Error('password', 'Wachtwoorden zijn niet gelijk');
        }
        if(!is_email($this->email)) {
            return new WP_Error('email_invalid', 'Het email addres is geen geldig email adres');
        }
        if(username_exists($this->username)){
            return new WP_Error('username', 'Gebruikersnaam is al in gebruik');
        }
        if(email_exists($this->email)) {
            return new WP_Error('email', 'Dit email adres ia al in gebruik!');
        }

        // TODO: ROLE CAN ONLY BE CLUB OR PLAYER

        // Club
        // ====
        if($this->role == 'club'){
            if(empty($this->club_name) || empty($this->contactperson)){
                return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
            }

            $details = array(
                'Club Name' => $this->club_name,
                'Contact Person' => $this->contactperson,
            );

            foreach($details as $field => $detail){
                if(!validate_username($detail)){
                    return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
                }
            }

            if(!empty($this->web_url)){
                if(!filter_var($this->web_url, FILTER_VALIDATE_URL)){
                    return new WP_Error('website', 'Website is not a valid URL');
                }
            }
        }
        elseif($this->role == 'player'){
//            if(empty($this->first_name))
        }
    }

    /**
     * The Registration Functionality
     *
     * @since   1.0.0
     *
     */
    public function register_form_registration(){
        $userdata = array(
            'user_login'    => esc_attr($this->username),
            'user_email'    => esc_attr($this->email),
            'user_pass'     => esc_attr($this->password),
            'description'   => esc_attr($this->description),
        );

        // Add The Role Specific User Data
        // ===============================
        if($this->role == 'club'){
            // TODO: FIX CLUB FIRST LAST NAME
            $userdata['first_name'] = esc_attr($this->club_name);
            $userdata['last_name'] = esc_attr($this->city);
            $userdata['user_url'] = esc_attr($this->web_url);
        }
        elseif($this->role == 'player'){
            $userdata['first_name'] = esc_attr($this->first_name);
            $userdata['last_name'] = esc_attr($this->last_name);
        }

        // Register the user and add the metadata or display an error message
        // ==================================================================
        if (is_wp_error($this->register_form_validation())) {
            echo '<div class="message-popup error">';
                echo '<div class="message-popup-inner">';
                    echo '<h3>' . __( 'Foutje bedankt', TEXTDOMAIN ) . '</h3>';
                    echo '<p>' . __( 'Het account kan niet worden aangemaakt door de volgende reden(en)', TEXTDOMAIN ) . '</p>';
                    echo '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $this->register_form_validation()->get_error_message() . '</strong>';
                    echo '<br><br><a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', TEXTDOMAIN ) . ' </a>';
                echo '</div>';
            echo '</div>';
        }
        else {
            $register_user = wp_insert_user($userdata);
            if( !is_wp_error($register_user) ){

                // Send mail notification to admin and user
                // ========================================
                // TODO: FIX & TEST FUNCTIONALITY
//                wp_new_user_notification($register_user, null, 'both');

                // Set the User Role
                // =================
                $user_obj = new WP_User($register_user);
                $user_obj->set_role($this->role);

                // Set 1st month free membership
                // =============================
                $date = new DateTime("+30 days");
                add_user_meta( $register_user, 'membership_end_date', $date->format("d-m-Y"), false );

                // Add Post Counter and Sale Counter to user
                // =========================================
                add_user_meta( $register_user, 'vacature_post_counter', 0, false );
                add_user_meta( $register_user, 'vacature_s_count', 1, false );

                // Add the rest of the user info in the user meta data
                // ===================================================
                $userinfo = array(
                    'postal' => $this->postal,
                    'street_number' => $this->street_number,
                    'addition' => $this->addition,
                    'city' => $this->city,
                    'province' => $this->province,
                    'street' => $this->street,
                    'coordinates' => $this->coordinates,
                    'tel' => $this->tel,
                );

                if( $this->role == 'club' ){
                    $userinfo['name'] = $this->club_name;
                    $userinfo['contactperson'] = $this->contactperson;
                    $userinfo['web_url'] = $this->web_url;
                }
                elseif( $this->role == 'player' ){
                    $userinfo['age'] = $this->age;
                    $userinfo['gender'] = $this->gender;
                }

                if(!empty($userinfo)){
                    add_user_meta( $register_user, 'user_data', $userinfo, false );
                }

                // Render the success message
                // ==========================
                echo '<div class="message-popup success">';
                    echo '<div class="message-popup-inner">';
                        echo '<h3>' . __( 'Beste', TEXTDOMAIN ) . ' ' . $this->username . ' ' . __( 'Uw account is succesvol aangemaakt', TEXTDOMAIN ) . '</h3>';
                        echo '<p>' . __( 'Binnen enkele momenten ontvangt u een bevestigings mail waarmee u het account kunt activeren. Na 15 minuten nog geen mail ontvangen klik dan', TEXTDOMAIN ) . '<a href="' . get_page_link() . '">&nbsp;'. __( 'hier', TEXTDOMAIN ) .'</a> </p>';
                        echo '<a class="btn btn-primary" href="' . home_url() . '">' . __( 'Naar Homepagina', TEXTDOMAIN ) . '</a>';
                    echo '</div>';
                echo '</div>';
            }
            else {
                echo '<div class="message-popup error">';
                    echo '<div class="message-popup-inner">';
                        echo '<h3>' . __( 'Foutje bedankt', TEXTDOMAIN ) . '</h3>';
                        echo '<p>' . __( 'Het account kan niet worden aangemaakt door de volgende reden(en)', TEXTDOMAIN ) . '</p>';
                        echo '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $this->register_form_validation()->get_error_message() . '</strong>';
                        echo '<br><br><a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', TEXTDOMAIN ) . ' </a>';
                    echo '</div>';
                echo '</div>';
            }
        }
    }

    /**
     * Register the shortcode for the registration form.
     *
     * @return string
     */
    public function register_form_shortcode(){
        ob_start();

        if(isset($_POST['hv_reg_submit'])){

            $this->username         = $_POST['username'];
            $this->role             = $_POST['role'];
            $this->description      = $_POST['description'];
            $this->password         = $_POST['password'];
            $this->password_check   = $_POST['password_check'];
            $this->postal           = $_POST['postal'];
            $this->street_number    = $_POST['street_number'];
            $this->addition         = $_POST['addition'];
            $this->city             = $_POST['city'];
            $this->province         = $_POST['province'];
            $this->street           = $_POST['street'];
            $this->coordinates      = $_POST['coordinates'];

            if($this->role == 'club'){
                $this->club_name        = $_POST['c_name'];
                $this->contactperson    = $_POST['c_cname'];
                $this->web_url          = $_POST['c_web_url'];
                $this->email            = $_POST['c_email'];
                $this->tel              = $_POST['c_tel'];
            }
            elseif($this->role == 'player'){
                $this->first_name       = $_POST['p_fname'];
                $this->last_name        = $_POST['p_lname'];
                $this->email            = $_POST['p_email'];
                $this->age              = $_POST['p_age'];
                $this->gender           = $_POST['p_gender'];
                $this->tel              = $_POST['p_tel'];
            }

            $this->register_form_validation();
            $this->register_form_registration();
        }

        $this->register_form();
        return ob_get_clean();
    }
}