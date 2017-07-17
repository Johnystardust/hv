<?php
/**
 * The Sale Form
 *
 * TODO: FIX ME !!!!!!!!!!!!!!!!!!!!!
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes/shortcodes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Sale_Form {

    public function sale_form(){
        ?>
        <form class="px-0" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <div class="radio">
                <label><input type="radio" name="hv_scl" value="1"> 1 Vacature</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="hv_scl" value="5"> 5 Vacatures</label>
            </div>
            <button type="submit" class="btn btn-primary" name="hv_scl_submit">Opwaarderen</button>
        </form>
        <?php
    }



    public function sale_form_shortcode(){
        ob_start();

        if(isset($_POST['hv_scl_submit'])){
            // Add the new value to the user counter
            //
            $user_id = get_current_user_id();
            $user_counter = get_user_meta($user_id, 'vacature_credit', true);
            $new_user_counter = $user_counter + $_POST['hv_scl'];

            update_user_meta($user_id, 'vacature_s_count', $new_user_counter);
        }

        $this->sale_form();
        return ob_get_clean();
    }
}