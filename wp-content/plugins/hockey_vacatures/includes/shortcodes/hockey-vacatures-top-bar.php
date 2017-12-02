<?php
/**
 * The Top Bar shortcode functionality of the plugin.
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/includes
 * @author     Tim van der Slik <info@timvanderslik.nl>
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 */
class Hockey_Vacatures_Top_Bar {

    protected $item_class = 'top-bar-item col-3';

    public function top_bar(){
        ?>
        <div class="top-bar container-fluid">
            <div class="container">
                <div class="row">
                    <?php echo $this->get_items() ?>

                    <div class="<?php echo $this->item_class; ?>">
                        <?php previous_post_link( '%link', __( 'Vorige', TEXTDOMAIN ), false ); ?>
                    </div>
                    <div class="<?php echo $this->item_class; ?>">
                        <a href="#" class="icon-left"><i class="fa fa-pencil"></i><?php echo __( 'Bewerken', TEXTDOMAIN ); ?></a>
                    </div>
                    <div class="<?php echo $this->item_class; ?>">
                        <a href="<?php echo get_delete_post_link(); ?>" class="icon-left"><i class="fa fa-trash"></i><?php echo __( 'Verwijderen', TEXTDOMAIN ); ?></a>
                    </div>
                    <div class="<?php echo $this->item_class; ?>">
                        <?php next_post_link( '%link', __( 'Vorige', TEXTDOMAIN ), false ); ?>
                    </div>




<!--                    --><?php //if(is_post_type_archive('vacatures')): ?>
<!--                        <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                            <a href="#" class="icon-left"><i class="fa fa-filter"></i>Filter</a>-->
<!--                        </div>-->
<!--                        --><?php //if(is_user_logged_in()): ?>
<!--                            <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                                <a href="#open-side-panel" class="icon-left"><i class="fa fa-user"></i>Mijn Profiel</a>-->
<!--                            </div>-->
<!--                        --><?php //endif; ?>
<!--                    --><?php //elseif(is_singular('vacatures')): ?>
<!--                        <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                            --><?php //previous_post_link( '%link', __( 'Vorige', TEXTDOMAIN ), false ); ?>
<!--                        </div>-->
<!--                        --><?php //global $post; ?>
<!--                        --><?php //if(get_current_user_id() == $post->post_author): ?>
<!--                            <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                                <a href="#" class="icon-left"><i class="fa fa-pencil"></i>--><?php //echo __( 'Bewerken', TEXTDOMAIN ); ?><!--</a>-->
<!--                            </div>-->
<!--                            <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                                <a href="--><?php //echo get_delete_post_link(); ?><!--" class="icon-left"><i class="fa fa-trash"></i>--><?php //echo __( 'Verwijderen', TEXTDOMAIN ); ?><!--</a>-->
<!--                            </div>-->
<!--                        --><?php //else: ?>
<!--                            <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                                <a href="--><?php //echo get_post_type_archive_link('vacatures'); ?><!--" class="icon-left"><i class="fa fa-id-card-o"></i>Alle Vacatures</a>-->
<!--                            </div>-->
<!--                            <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                                <a href="#" class="icon-right">Bekijk op kaart<i class="fa fa-map-signs"></i></a>-->
<!--                            </div>-->
<!--                        --><?php //endif; ?>
<!--                        <div class="--><?php //echo $this->item_class; ?><!--">-->
<!--                            --><?php //next_post_link( '%link', __( 'Vorige', TEXTDOMAIN ), false ); ?>
<!--                        </div>-->
<!--                    --><?php //endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function get_items(){


    }

    public function top_bar_shortcode(){
        $this->top_bar();
    }

}