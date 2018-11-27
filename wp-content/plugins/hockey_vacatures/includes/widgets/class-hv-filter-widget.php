<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class HV_Filter_Widget extends WP_Widget {

    function __construct(){
        parent::__construct(
            'hv_filter_widget',
            __( 'HV: Vacture Filter', 'hockey_vacatures' ),
            array(
                'description' => __( 'This widget provides a filter for the vacature archive.', 'hockey_vacatures' ),
            )
        );
    }

    /**
     * Echoes the widget content.
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ){
        echo $args['before_widget'];

        // Display the title if it has been set.
        if(isset($instance['title']) && !empty($instance['title'])){
            echo $args['before_title'] . $instance['title'] . $args['after_title'];
        }

        $field_types = array(
            'outdoor' => __('Veld', TEXTDOMAIN),
            'indoor' => __('Zaal', TEXTDOMAIN),
        );

        $age_types = array(
            'senior' => __('Senior', TEXTDOMAIN),
            'junior' => __('Junior', TEXTDOMAIN),
        );

        $vacature_terms = get_terms( array(
            'taxonomy' => 'vacature_category',
            'hide_empty' => true,
        ) );
        ?>

        <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" id="vacature-filter" method="post">
            <div class="form-group">
                <label for="search"><?php echo __('Zoeken', TEXTDOMAIN); ?></label>
                <input type="text" name="s" id="search" class="form-control" placeholder="Zoeken..." value="<?php echo (isset($_POST['s'])) ? $_POST['s'] : ''; ?>">
            </div>

            <?php if(count($vacature_terms) >= 1): ?>
                <div class="form-group">
                    <label for="term_id"><?php echo __('Functie', TEXTDOMAIN); ?></label>

                    <?php foreach($vacature_terms as $key => $vacature_term): ?>
                        <label for="<?php echo 'field-'.$vacature_term->slug; ?>">
                            <input type="checkbox" id="<?php echo 'field-'.$vacature_term->slug; ?>"
                                   name="term_ids[<?php echo $vacature_term->slug; ?>]"
                                   value="<?php echo $vacature_term->term_id; ?>"
                                   <?php isset($_POST['term_ids'][$vacature_term->slug]) ? checked($_POST['term_ids'][$vacature_term->slug], $vacature_term->term_id) : null ?>>
                            <?php echo $vacature_term->name; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="age"><?php echo __('Leeftijd', TEXTDOMAIN); ?></label>

                <?php foreach($age_types as $key => $value): ?>
                    <label for="<?php echo 'field-'.$key; ?>">
                        <input type="checkbox" id="<?php echo 'field-'.$key; ?>"
                               name="age[<?php echo $key; ?>]"
                               value="true"
                               <?php isset($_POST['age'][$key]) ? checked($_POST['age'][$key], 'true') : null ?>>
                        <?php echo $value ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="form-group">
                <label for="field"><?php echo __('Veld/Zaal', TEXTDOMAIN); ?></label>

                <?php foreach($field_types as $key => $value): ?>
                    <label for="<?php echo 'field-'.$key; ?>">
                        <input type="checkbox" id="<?php echo 'field-'.$key; ?>"
                               name="field[<?php echo $key; ?>]"
                               value="true">
                        <?php echo $value ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><?php echo __('Zoeken', TEXTDOMAIN); ?></button>
            </div>
        </form>

        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the settings update form.
     *
     * @param array $instance Current settings.
     * @return string Default return is 'noform'.
     */
    public function form( $instance ){
        $title          = (isset($instance['title'] ) )             ? $instance['title']            : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title', 'hockey_vacatures' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * Update the widget fields replacing them with new data
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ){
        $instance = array();

        $instance['title']          = (!empty( $new_instance['title'] ) )           ? $new_instance['title']            : '';

        return $instance;
    }
}