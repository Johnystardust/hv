<?php
/**
 * The post-type-specific functionality of the plugin.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/admin
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_vacatures_Post_Type {
    private $plugin_name;
    private $version;
    private $post_types;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name   The name of this plugin.
     * @param      string    $version       The version of this plugin.
     * @param      array     $post_types    The required post types
     */
    public function __construct( $plugin_name, $version ){
        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
        $this->post_types   = array('vacatures', 'sollicitaties');

    }

    /**
     * Set the Labels for the custom post type
     *
     * @since   1.0.0
     *
     * @param $name
     * @return array
     */
    private function set_labels($name){
        $name = ucfirst($name);
        $singular = (substr($name, -1, 1) == 's') ? substr($name, 0, -1) : $name;

        $labels = array(
            'name'                  => _x( $name, 'Post Type General Name', $this->plugin_name ),
            'singular_name'         => _x( $singular, 'Post Type Singular Name', $this->plugin_name ),
            'menu_name'             => __( $name , $this->plugin_name ),
            'parent_item_colon'     => __( 'Parent '.$singular, $this->plugin_name ),
            'all_items'             => __( 'All '.$name,  $this->plugin_name ),
            'view_item'             => __( 'View '.$singular,  $this->plugin_name ),
            'add_new_item'          => __( 'Add New '.$singular,  $this->plugin_name ),
            'add_new'               => __( 'Add New',  $this->plugin_name ),
            'edit_item'             => __( 'Edit '.$singular, $this->plugin_name ),
            'update_item'           => __( 'Update '.$singular, $this->plugin_name ),
            'search_items'          => __( 'Search '.$singular, $this->plugin_name ),
            'not_found'             => __( 'Not Found', $this->plugin_name ),
            'not_found_in_trash'    => __( 'Not found in Trash',  $this->plugin_name ),
        );

        return $labels;
    }

    /**
     * Set the Arguments for the custom post type
     *
     * @since   1.0.0
     *
     * @param $name
     * @param $labels
     * @return array
     */
    private function set_args($name, $labels){
        $args = array(
            'label'               => __( $name, $this->plugin_name ),
            'description'         => __( 'Movie news and reviews', $this->plugin_name ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies'          => array( 'genres' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => array('page', $name),
            'map_meta_cap'        => true,
        );

        return $args;
    }

    /**
     * Creates the post types for the plugin
     *
     * @since   1.0.0
     */
    public function create_custom_post_type(){

        foreach($this->post_types as $post_type){
            $labels = $this->set_labels( $post_type );
            $args   = $this->set_args( $post_type, $labels );

            register_post_type( $post_type, $args );
        }
    }

    /**
     * Add meta boxes to the custom post types
     *
     * @since   1.0.0
     */
    public function add_meta_boxes(){
        add_meta_box('vacature_info', __('Vacature', $this->plugin_name), array($this, 'vacatures_info_meta_box'), 'vacatures', 'normal', 'high');
    }

    /**
     * Vacature info meta box fields
     *
     * @param $post
     */
    public function vacatures_info_meta_box($post){
        $function   = esc_html(get_post_meta($post->ID, 'function', true));
        $gender     = esc_html(get_post_meta($post->ID, 'gender', true));
        $city       = esc_html(get_post_meta($post->ID, 'city', true));
        $province   = esc_html(get_post_meta($post->ID, 'province', true));

        ?>
        <div class="field">
            <p class="label">
                <label for="function"><?php esc_attr_e( 'Functie', $this->plugin_name ); ?></label>
            </p>
            <select name="function" id="function">
                <option value=""><?php echo __('Maak keuze', $this->plugin_name); ?></option>
                <option <?php selected($function, 'trainer', true); ?> value="trainer"><?php echo __('Trainer', $this->plugin_name); ?></option>
                <option <?php selected($function, 'coach', true); ?> value="coach"><?php echo __('Coach', $this->plugin_name); ?></option>
                <option <?php selected($function, 'speler', true); ?> value="speler"><?php echo __('Speler', $this->plugin_name); ?></option>
            </select>
        </div>
        <div class="field">
            <p class="label">
                <label for="gender"><?php esc_attr_e( 'Geslacht', $this->plugin_name ); ?></label>
            </p>
            <select name="gender" id="gender">
                <option value=""><?php echo __('Maak keuze', $this->plugin_name); ?></option>
                <option <?php selected($gender, 'men', true); ?> value="men"><?php echo __('Man', $this->plugin_name); ?></option>
                <option <?php selected($gender, 'women', true); ?> value="women"><?php echo __('Vrouw', $this->plugin_name); ?></option>
            </select>
        </div>
        <div class="field">
            <p class="label">
                <label for="city"><?php esc_attr_e( 'Plaats', $this->plugin_name ); ?></label>
            </p>
            <input type="text" name="city" placeholder="Bijv. Amsterdam" value="<?php echo $city; ?>" />
        </div>
        <div class="field">
            <p class="label">
                <label for="province"><?php esc_attr_e( 'Provincie', $this->plugin_name ); ?></label>
            </p>
            <input type="text" name="province" placeholder="Bijv. Noord-Holland" value="<?php echo $province; ?>" />
        </div>
        <?php
    }

    /**
     * Save the meta boxes for the custom post types
     *
     * @param $post_id
     * @param $post
     */
    public function save_meta_boxes($post_id, $post){

        if($post->post_type == 'vacatures'){
            if(isset($_POST['function']) && $_POST['function'] != ''){
                update_post_meta( $post_id, 'function', $_POST['function']);
            }
            if(isset($_POST['gender']) && $_POST['gender'] != ''){
                update_post_meta( $post_id, 'gender', $_POST['gender']);
            }
            if(isset($_POST['city']) && $_POST['city'] != ''){
                update_post_meta( $post_id, 'city', $_POST['city']);
            }
            if(isset($_POST['province']) && $_POST['province'] != ''){
                update_post_meta( $post_id, 'province', $_POST['province']);
            }

        }
    }
}