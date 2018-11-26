<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Vacature_List_Widget extends WP_Widget
{
    function __construct(){
        parent::__construct(
            'hv_vacature_list_widget',
            __( 'HV: Vacature List', 'hockey_vacatures' ),
            array(
                'description' => __( 'This widget a list of the latest vacatures.', 'hockey_vacatures' ),
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

        $query_args = array(
            'post_type'      => 'vacature',
            'post_status'    => 'publish',
            'posts_per_page' => 5
        );

        $query = new WP_Query($query_args);

        if ($query->have_posts()): ?>
            <ul>
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <li>
                    <a href="<?php echo get_the_permalink() ?>"><?php echo get_the_title() ?></a>
                </li>
            <?php endwhile; ?>
            </ul>
        <?php endif;

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