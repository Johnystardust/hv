<?php
/**
 * Class Hockey_Vacatures_Register_Form
 *
 * @since   1.0.0
 */
class Hockey_Vacatures_New_Vacature_Form {

    private $user_info;

    private $title;
    private $function;
    private $gender;
    private $city;
    private $province;
    private $tel;
    private $url;
    private $content;

    public function __construct(){

    }

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
        </form>
        <?php
    }

    /**
     * Form builder Function
     *
     * @since   1.0.0
     *
     * @param array $form_fields
     *
     */
    private function build_form($form_fields = array()){
        if(!is_array($form_fields)){
            return;
        }

        $fields_html = '';

        foreach($form_fields as $field){

            switch($field['type']){
                case('text'):
                case('number'):
                case('password'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>">
                            <?php esc_attr_e($field['label']); ?>
                            <?php if(array_key_exists('required', $field) && $field['required']): ?>
                                <span class="required">*</span>
                            <?php endif; ?>
                        </label>
                        <input id="<?php echo $field['name']; ?>" class="form-control" type="<?php echo $field['type']; ?>" name="<?php echo $field['name']; ?>"
                               placeholder="<?php echo $field['placeholder']; ?>" value="<?php if($field['name'] !== 'password_check'){ echo(isset($_POST[$field['name']]) ? $_POST[$field['name']] : null); } ?>">
                        <?php if(array_key_exists('description', $field)): ?>
                            <span class="description"><?php echo $field['description'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php break;
                case('select'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>"><?php echo $field['label'] ?></label>
                        <select class="form-control custom-select" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>">
                            <?php foreach( $field['options'] as $option => $value ): ?>
                                <option <?php if(isset($_POST[$field['name']]) && $_POST[$field['name']] == $option){ echo 'selected'; }; ?> value="<?php echo $option; ?>"><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(array_key_exists('description', $field)): ?>
                            <span class="description"><?php echo $field['description'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php break;
                case('textarea'): ?>
                    <div class="form-group <?php echo $field['col_size']; ?>">
                        <label for="<?php echo $field['name']; ?>"><?php echo $field['label'] ?></label>
                        <textarea class="form-control" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" cols="<?php echo $field['cols']; ?>" rows="<?php echo $field['rows']; ?>"
                                  placeholder="<?php echo $field['placeholder']; ?>"><?php echo(isset($_POST[$field['name']]) ? $_POST[$field['name']] : null); ?></textarea>
                        <?php if(array_key_exists('description', $field)): ?>
                            <span class="description"><?php echo $field['description'] ?></span>
                        <?php endif; ?>
                    </div>
                    <?php break;
            }
        }

        echo $fields_html;
    }

    private function add_new_vacature_meta($post_id){
        $user_info = get_userdata(get_current_user_id());
        $additional_data = get_user_meta(get_current_user_id(), 'user_data', true);

        // Users Variables
        // TODO: FIX MULTIPLE ROLES ADD PLAYER ROLE !!
        add_post_meta($post_id, 'city', $additional_data['city']);
        add_post_meta($post_id, 'province', $additional_data['province']);
        add_post_meta($post_id, 'tel', $additional_data['tel']);
        add_post_meta($post_id, 'web_url', $additional_data['web_url']);

        // Post Variables
        add_post_meta($post_id, 'gender', $this->gender);
        add_post_meta($post_id, 'function', $this->function);

        add_post_meta($post_id, 'mail', $user_info->user_email);
    }

    public function new_vacature_form_shortcode(){

        if(isset($_POST['submit'])){

            $this->title    = $_POST['title'];
            $this->function = $_POST['function'];
            $this->gender   = $_POST['gender'];
            $this->content  = $_POST['content'];

            $new_vacature = array(
                'post_title' => wp_strip_all_tags( $this->title ),
                'post_content' => $this->content,
                'post_type' => 'vacatures',
                'post_status' => 'publish'
            );

            $post_id = wp_insert_post($new_vacature);

            if($post_id){
                $this->add_new_vacature_meta($post_id);

                var_dump($post_id);
            }
        }
        $this->new_vacature_form();
    }
}

