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
                $this->build_form($club_register);
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
                $this->build_form($player_register);
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
                $this->build_form($place_register);
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
                $this->build_form($user_register)
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