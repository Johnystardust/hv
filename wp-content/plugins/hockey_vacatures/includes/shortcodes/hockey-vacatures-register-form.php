<?php
/**
 * Class Hockey_Vacatures_Register_Form
 *
 * @since   1.0.0
 */
class Hockey_Vacatures_Register_Form {

    private $username;
    private $email;
    private $password;
    private $first_name;
    private $last_name;

    /**
     * The markup for the register form.
     *
     * @since   1.0.0
     */
    public function register_form(){
        ?>
        <form class="px-0" id="hv_reg_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for=""><?php echo __( 'Gebruikersnaam', TEXTDOMAIN ); ?></label><br>
                            <input class="form-control" type="text" name="hv_reg_name" placeholder="<?php echo __( 'Gebruikersnaam', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_reg_name']) ? $_POST['hv_reg_name'] : null); ?>">
                            <span class="description"><?php echo __( 'De gebruikersnaam word gebruikt voor het inloggen',  TEXTDOMAIN ); ?></span>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Naam', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="text" name="hv_reg_fname" placeholder="<?php echo __( 'Naam', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_reg_name']) ? $_POST['hv_reg_name'] : null); ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Achternaam', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="text" name="hv_reg_lname" placeholder="<?php echo __( 'Achternaam', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_reg_name']) ? $_POST['hv_reg_name'] : null); ?>">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Soort profiel', TEXTDOMAIN ); ?></label>
                            <select class="form-control custom-select" name="hv_reg_role" id="role">
                                <option value="default"><?php echo __( 'Maak een keuze...', TEXTDOMAIN ); ?></option>
                                <option value="club"><?php echo __( 'Club', TEXTDOMAIN ); ?></option>
                                <option value="player"><?php echo __( 'Speler', TEXTDOMAIN ); ?></option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'E-mail', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="text" name="hv_reg_email" placeholder="<?php echo __( 'E-mail', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_reg_email']) ? $_POST['hv_reg_email'] : null); ?>">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Leeftijd', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="number" name="hv_reg_age" placeholder="<?php echo __( 'Leeftijd', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_reg_age']) ? $_POST['hv_reg_age'] : null); ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Geslacht', TEXTDOMAIN ); ?></label>
                            <select class="form-control custom-select" name="hv_reg_gender" id="hv_reg_gender">
                                <option value="default"><?php echo __( 'Maak een keuze...', TEXTDOMAIN ); ?></option>
                                <option value="male"><?php echo __( 'Man', TEXTDOMAIN ); ?></option>
                                <option value="female"><?php echo __( 'Vrouw', TEXTDOMAIN ); ?></option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Wachtwoord', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="password" name="hv_reg_password" id="hv_reg_password" placeholder="<?php echo __( 'Wachtwoord', TEXTDOMAIN ); ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for=""><?php echo __( 'Wachtwoord Check', TEXTDOMAIN ); ?></label>
                            <input class="form-control" type="password" name="hv_reg_password_check" id="hv_reg_password_check" placeholder="<?php echo __( 'Wachtwoord Check', TEXTDOMAIN ); ?>">
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
        if (empty($this->username) || empty($this->password) || empty($this->email) || empty($this->role)) {
            return new WP_Error('field', 'Required form field is missing');
        }

        if (strlen($this->username) < 4) {
            return new WP_Error('username_length', 'Username too short. At least 4 characters is required');
        }

        if (strlen($this->password) < 5) {
            return new WP_Error('password', 'Password length must be greater than 5');
        }

        if ($this->password !== $this->password_check) {
            return new WP_Error('password', 'Wachtwoorden zijn niet gelijk');
        }

        if (!is_email($this->email)) {
            return new WP_Error('email_invalid', 'Email is not valid');
        }

        if (email_exists($this->email)) {
            return new WP_Error('email', 'Email Already in use');
        }

//        if (!empty($website)) {
//            if (!filter_var($this->website, FILTER_VALIDATE_URL)) {
//                return new WP_Error('website', 'Website is not a valid URL');
//            }
//        }

        $details = array('Username' => $this->username,
            'First Name' => $this->first_name,
            'Last Name' => $this->last_name,
//            'Nickname' => $this->nickname,
//            'bio' => $this->bio
        );

        foreach ($details as $field => $detail) {
            if (!validate_username($detail)) {
                return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
            }
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
            'first_name'    => esc_attr($this->first_name),
            'last_name'     => esc_attr($this->last_name),
        );

        // TODO: FIX: STYLE MESSAGES
        if (is_wp_error($this->register_form_validation())) {
            echo '<div style="margin-bottom: 6px" class="text-center bg-danger text-white">';
            echo '<strong>' . $this->register_form_validation()->get_error_message() . '</strong>';
            echo '</div>';
        } else {

            $register_user = wp_insert_user($userdata);
            if (!is_wp_error($register_user)) {

                // Set 1st month free membership
                // =============================
                $date = new DateTime("+30 days");
                add_user_meta( $register_user, 'membership_end_date', $date->format("d-m-Y"), false );

                // Set role specific meta data
                // ===========================
                if($this->role == 'club'){
                    wp_update_user( array( 'ID', $register_user, 'role' => 'club' ) );

                    // Add Post Counter and Sale Counter to user
                    add_user_meta( $register_user, 'vacature_post_counter', 0, false );
                    add_user_meta( $register_user, 'vacature_s_count', 1, false );

                } else if($this->role == 'player') {
                    // TODO: FIX: FOR MULTIPLE USER ROLES
                }

                echo '<div style="margin-bottom: 6px" class="text-center bg-success text-white">';
                echo '<strong>Registration complete. Goto <a href="' . wp_login_url() . '">login page</a></strong>';
                echo '</div>';
            } else {
                echo '<div style="margin-bottom: 6px" class="text-center bg-danger text-white">';
                echo '<strong>' . $register_user->get_error_message() . '</strong>';
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
            $this->username         = $_POST['hv_reg_name'];
            $this->first_name       = $_POST['hv_reg_fname'];
            $this->last_name        = $_POST['hv_reg_lname'];
            $this->role             = $_POST['hv_reg_role'];
            $this->email            = $_POST['hv_reg_email'];
            $this->password         = $_POST['hv_reg_password'];
            $this->password_check   = $_POST['hv_reg_password_check'];

            $this->register_form_validation();
            $this->register_form_registration();
        }

        $this->register_form();
        return ob_get_clean();
    }
}
