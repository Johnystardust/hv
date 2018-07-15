<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Search_Widget extends WP_Widget
{
    function __construct(){
        parent::__construct(
            'hv_search_widget',
            __( 'HV: Vacature Search', 'hockey_vacatures' ),
            array(
                'description' => __( 'This widget provides search bar that can be used on vacature archive pages', 'hockey_vacatures' ),
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
        ?>
        <form action="">
            <div class="form-group">
                <?php if(isset($instance['label']) && $instance['label']): ?>
                    <?php $label = (isset($instance['label']) && !empty($instance['label'])) ? $instance['label'] : __('Zoeken', 'hockey_vacatures'); ?>
                    <label for=""><?php echo $label; ?></label>
                <?php endif; ?>
                <?php $placeholder = (isset($instance['placeholder']) && !empty($instance['placeholder'])) ? $instance['placeholder'] : __('Zoekwoorden...', 'hockey_vacatures'); ?>
                <input type="text" class="form-control" name="search" placeholder="<?php echo $placeholder; ?>"/>
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
        $label          = (isset($instance['label'] ) )             ? $instance['label']            : '';
        $placeholder    = (isset($instance['placeholder']))         ? $instance['placeholder']      : '';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title', 'hockey_vacatures' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php echo __( 'Label', 'hockey_vacatures' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo esc_attr($label); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php echo __( 'Placeholder', 'hockey_vacatures' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" value="<?php echo esc_attr($placeholder); ?>">
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
        $instance['label']          = (!empty( $new_instance['label'] ) )           ? $new_instance['label']            : '';
        $instance['placeholder']    = (!empty( $new_instance['placeholder'] ) )     ? $new_instance['placeholder']      : '';

        return $instance;
    }
}