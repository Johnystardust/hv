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
        <form id="hv_sale_form" class="px-0" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for=""><?php echo __( 'Aantal vacatures', TEXTDOMAIN ); ?></label><br>
                            <select name="hv_sale_num" class="form-control custom-select" id="hv_sale_num">
                                <?php for($x = 0; $x <= 15; $x++): ?>
                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                <?php endfor; ?>
                                <option value="other"><?php echo __( 'Anders namelijk', TEXTDOMAIN ); ?></option>
                            </select>
                            <input class="form-control hidden" id="hv_sale_num_other" type="number" name="hv_sale_num" placeholder="<?php echo __( 'Vul aantal vacatures in', TEXTDOMAIN ); ?>" value="<?php echo(isset($_POST['hv_sale_num']) ? $_POST['hv_sale_num'] : null); ?>">
                        </div>
                        <div class="form-group col-12 col-md-6 totals">
                            <table>
                                <tr>
                                    <td><?php echo __( 'Totaal vacatures', TEXTDOMAIN ); ?></td>
                                    <td><i class="fa fa-euro"></i> <span class="total-vacatures">-</span></td>
                                </tr>
                                <tr class="totals-sale">
                                    <td><?php echo __( 'Korting', TEXTDOMAIN ); ?></td>
                                    <td><i class="fa fa-euro"></i> <span class="total-sale">-</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __( 'Totaal', TEXTDOMAIN); ?></td>
                                    <td><i class="fa fa-euro"></i> <span class="total">-</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group col-12">
                            <button class="btn btn-primary" type="submit" name="hv_reg_submit"><?php echo __( 'Afrekenen', TEXTDOMAIN ); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }

    public function sale_form_shortcode(){
        ob_start();

        if(isset($_POST['hv_scl_submit'])){
            // Add the new value to the user counter
            // =====================================
            $user_id = get_current_user_id();
            $user_counter = get_user_meta($user_id, 'vacature_credit', true);
            $new_user_counter = $user_counter + $_POST['hv_scl'];

            update_user_meta($user_id, 'vacature_s_count', $new_user_counter);
        }

        $this->sale_form();
        return ob_get_clean();
    }
}