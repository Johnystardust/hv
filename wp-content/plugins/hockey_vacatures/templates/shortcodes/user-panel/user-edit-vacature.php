<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<h5><?php echo __( 'Vacature bewerken', 'hockey_vacatures' ); ?></h5>

<form class="px-0" id="new_vacature_form" method="post" action="<?php echo home_url() .'/update'; ?>">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php
                $vacature = HV_Vacature::find( $_GET['data']['id'] );

                if(!is_object($vacature) ) {
                    return;
                }

                $vacature_form = array(
                    'title' => array(
                        'type'          => 'text',
                        'label'         => __( 'Titel', 'hockey_vacatures' ),
                        'name'          => 'title',
                        'placeholder'   => __( 'Titel', 'hockey_vacatures' ),
                        'col_size'      => 'col-12',
                        'required'      => true,
                        'readonly'      => true,
                        'value'         => $vacature->title
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
                        'required'      => true,
                        'readonly'      => true,
                        'value'         => $vacature->function
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
                        'required'      => true,
                        'value'         => $vacature->gender
                    ),
                    'content' => array(
                        'type'          => 'textarea',
                        'label'         => __( 'Content', 'hockey_vacatures' ),
                        'name'          => 'Content',
                        'col_size'      => 'col-12',
                        'required'      => true,
                        'value'         => $vacature->content
                    )
                );
                $form_helper = new HV_Forms_Helper();
                $form_helper->build_form($vacature_form);
                ?>

                <div class="form-group col-12">
                    <button class="btn btn-primary" type="submit" name="submit">
                        <i class="fa fa-paper-plane"></i> &nbsp; <?php echo __( 'Vacature Plaatsen', 'hockey_vacatures' ); ?>
                    </button>
                </div>
            </div>

        </div>
    </div>
    <?php
    // Nonce Field
    wp_nonce_field('vacature_form_shortcode', 'vacature_form_nonce');
    ?>
</form>