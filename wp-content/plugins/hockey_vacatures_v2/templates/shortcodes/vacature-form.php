<form class="px-0" id="new_vacature_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="row">
                <?php
                $new_vacature = array(
                    'title' => array(
                        'type'          => 'text',
                        'label'         => __( 'Titel', 'hockey_vacatures' ),
                        'name'          => 'title',
                        'placeholder'   => __( 'Titel', 'hockey_vacatures' ),
                        'col_size'      => 'col-12',
                        'required'      => true
                    ),
                    'function' => array(
                        'type'          => 'select',
                        'label'         => __( 'Functie', 'hockey_vacatures' ),
                        'name'          => 'function',
                        'options'       => array(
                            'default'   => __( 'Maak een keuze...', 'hockey_vacatures' ),
                            'coach'     => __( 'Coach', 'hockey_vacatures' ),
                            'speler'    => __( 'Speler', 'hockey_vacatures' ),
                            'trainer'   => __( 'Trainer', 'hockey_vacatures' )
                        ),
                        'col_size'      => 'col-12 col-md-6',
                        'required'      => true
                    ),
                    'gender' => array(
                        'type'          => 'select',
                        'label'         => __( 'Geslacht', 'hockey_vacatures' ),
                        'name'          => 'gender',
                        'options'       => array(
                            'default'   => __( 'Maak een keuze...', 'hockey_vacatures' ),
                            'male'      => __( 'Man', 'hockey_vacatures' ),
                            'female'    => __( 'Vrouw', 'hockey_vacatures' ),
                            'either'    => __( 'Geen voorkeur', 'hockey_vacatures' )
                        ),
                        'col_size'      => 'col-12 col-md-6',
                        'required'      => true
                    ),
                );

                $this->build_form($new_vacature);
                ?>
            </div>

            <div class="row">

                <div class="form-group col-12">
                    <?php
                    $content = isset($_POST['content']) ? $_POST['content'] : '';
                    $args = array(
                        'media_buttons' => false,
                        'fullscreen' => false,
                        'quicktags' => false
                    )
                    ?>
                    <textarea name="content">
                            </textarea>
                    <!--                            --><?php //wp_editor( $content, 'content', $args ); ?>
                    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
                    <script>tinymce.init({ selector:'textarea' });</script>

                </div>

                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo __( 'Vacature Plaatsen', TEXTDOMAIN ); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Nonce Field
    wp_nonce_field('vacature_form_shortcode', 'vacature_form_nonce');
    ?>
</form>