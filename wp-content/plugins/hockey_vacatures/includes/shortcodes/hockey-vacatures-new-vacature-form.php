<?php
/**
 * Class Hockey_Vacatures_Register_Form
 *
 * @since   1.0.0
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . '/hockey-vacatures-forms.php';

class Hockey_Vacatures_New_Vacature_Form extends Hockey_Vacatures_Forms {

    private $user;
    private $category;
    private $title;
    private $function;
    private $gender;
    private $content;


    public function __construct(){
        require_once( ABSPATH . 'wp-admin/includes/post.php' );
    }

    /**
     * Register the shortcode for the new vacature form.
     *
     * @return string
     */
    public function new_vacature_form_shortcode(){
        // TODO: FIX EDIT PAGE
//        if(isset($_GET['edit'])){
//            $post_id = $_GET['edit'];
//            var_dump(get_post($post_id));
//        }

        if(isset($_POST['submit'])){
            if(!isset($_POST['new_vacature_nonce']) || !wp_verify_nonce($_POST['new_vacature_nonce'], 'new_vacature')){
                echo '<div class="message-popup error">';
                echo '<div class="message-popup-inner">';
                echo '<h5>' . __( 'Foutje bedankt', TEXTDOMAIN ) . '</h5>';
                echo '<p>' . __( 'De vacature kan niet worden aangemaakt probeer het later nog een keer.', TEXTDOMAIN ) . '</p>';
                echo '<a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', TEXTDOMAIN ) . ' </a>';
                echo '</div>';
                echo '</div>';
            }
            else {
                $this->user     = get_userdata(get_current_user_id());
                $this->category = array('vacature');
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->function = $_POST['function'];
                $this->gender   = $_POST['gender'];

                $this->new_vacature_validation();
                $this->new_vacature_add_page();
            }
        }

        $this->new_vacature_form();
    }

    /**
     * Validation for the registration form.
     *
     * @since   1.0.0
     *
     * @return WP_Error
     *
     */
    public function new_vacature_validation(){
        if(empty($this->title) || empty($this->content) || empty($this->function) || empty($this->gender)) {
            return new WP_Error('field', 'Een verplicht veld is niet ingevuld. Controleer alle ingevulde velden.');
        }
        if(post_exists($this->title) != 0) {
            return new WP_Error('post_exists', 'Deze vacature bestaat al. Kies een andere titel.');
        }
    }

    /**
     * Add the new vacature page.
     *
     * @since   1.0.0
     *
     */
    public function new_vacature_add_page(){
        if (is_wp_error($this->new_vacature_validation())) {
            echo '<div class="message-popup error">';
            echo '<div class="message-popup-inner">';
            echo '<h5>' . __( 'Foutje bedankt', TEXTDOMAIN ) . '</h5>';
            echo '<p>' . __( 'De vacature kan niet geplaatst worden door de volgende reden(en)', TEXTDOMAIN ) . '</p>';
            echo '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $this->new_vacature_validation()->get_error_message() . '</strong>';
            echo '<br><br><a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', TEXTDOMAIN ) . ' </a>';
            echo '</div>';
            echo '</div>';
        }
        else {
            $new_vacature = array(
                'post_title' => wp_strip_all_tags( $this->title ),
                'post_content' => $this->content,
                'post_type' => 'vacatures',
                'post_status' => 'publish',
            );

            $post_id = wp_insert_post($new_vacature);
            if(!is_wp_error($post_id)){
                $this->category[] = $this->function.'-vacature';
                wp_set_object_terms($post_id, $this->category, 'category');

                if($this->add_post_meta($post_id)){
                    // Render the success message
                    // ==========================
                    echo '<div class="message-popup success">';
                    echo '<div class="message-popup-inner">';
                    echo '<h5>' . __( 'Vacature geplaatst!', TEXTDOMAIN ) . '</h5>';
                    echo '<p>' . __( 'De vacature is geplaatst veel succes met de werving!', TEXTDOMAIN ) . '</p>';
                    echo '<a class="btn btn-primary" href="' . get_page_link($post_id).'">' . __( 'Vacature bekijken', TEXTDOMAIN ) . '</a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            else {
                echo '<div class="message-popup error">';
                echo '<div class="message-popup-inner">';
                echo '<h5>' . __( 'Foutje bedankt', TEXTDOMAIN ) . '</h5>';
                echo '<p>' . __( 'De vacature kan niet geplaatst worden door de volgende reden(en)', TEXTDOMAIN ) . '</p>';
                echo '<strong><i class="fa fa-exclamation-triangle text-danger mr-2"></i>' . $post_id->get_error_message() . '</strong>';
                echo '<br><br><a href="#message-popup-close" class="btn btn-primary"> ' . __( 'Terug', TEXTDOMAIN ) . ' </a>';
                echo '</div>';
                echo '</div>';
            }
        }
    }

    /**
     * Add the new vacature post meta.
     *
     * @since   1.0.0
     *
     */
    private function add_post_meta($post_id){
        $additional_data = get_user_meta(get_current_user_id(), 'user_data', true);
        $data = array();

        if($additional_data){
            $data['function']   = $this->function;
            $data['gender']     = $this->gender;
            $data['city']       = $additional_data['city'];
            $data['province']   = $additional_data['province'];
            $data['mail']       = $this->user->user_email;
            $data['tel']        = $additional_data['tel'];
            $data['latlng']     = $additional_data['coordinates'];

            if(in_array('club', $this->user->roles)){
                $data['web_url'] = $additional_data['web_url'];
            }
        }

        if(add_post_meta($post_id, 'additional_data', $data)){
            return true;
        }

        return false;
    }

    /**
     * The markup for the register form.
     *
     * @since   1.0.0
     */
    public function new_vacature_form(){
        ?>
        <form class="px-0" id="new_vacature_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <?php
                        $new_vacature = array(
                            'title' => array(
                                'type'          => 'text',
                                'label'         => __( 'Titel', TEXTDOMAIN ),
                                'name'          => 'title',
                                'placeholder'   => __( 'Titel', TEXTDOMAIN ),
                                'col_size'      => 'col-12',
                                'required'      => true
                            ),
                            'function' => array(
                                'type'          => 'select',
                                'label'         => __( 'Functie', TEXTDOMAIN ),
                                'name'          => 'function',
                                'options'       => array(
                                    'default'   => __( 'Maak een keuze...', TEXTDOMAIN ),
                                    'coach'     => __( 'Coach', TEXTDOMAIN ),
                                    'speler'    => __( 'Speler', TEXTDOMAIN ),
                                    'trainer'   => __( 'Trainer', TEXTDOMAIN )
                                ),
                                'col_size'      => 'col-12 col-md-6',
                                'required'      => true
                            ),
                            'gender' => array(
                                'type'          => 'select',
                                'label'         => __( 'Geslacht', TEXTDOMAIN ),
                                'name'          => 'gender',
                                'options'       => array(
                                    'default'   => __( 'Maak een keuze...', TEXTDOMAIN ),
                                    'male'      => __( 'Man', TEXTDOMAIN ),
                                    'female'    => __( 'Vrouw', TEXTDOMAIN ),
                                    'either'    => __( 'Geen voorkeur', TEXTDOMAIN )
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

                        <!--                        --><?php //wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>

                        <div class="form-group col-12">
                            <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-paper-plane"></i> &nbsp; <?php echo __( 'Vacature Plaatsen', TEXTDOMAIN ); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            // Nonce Field
            wp_nonce_field('new_vacature', 'new_vacature_nonce');
            ?>
        </form>
        <?php
    }
}

