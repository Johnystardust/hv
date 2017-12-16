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

    public function top_bar_shortcode(){
        $this->top_bar();
    }

    public function top_bar(){
        global $post;
        ?>
        <div id="vacatures-top-bar" class="top-bar container-fluid">
            <div class="container">
                <div class="row">
                    <?php if(is_post_type_archive('vacatures')): ?>
                        <div class="<?php echo $this->item_class; ?>">
                            <a id="archive-add-filter" href="#" class="icon-left"><i class="fa fa-filter"></i><?php echo __( 'Filter', TEXTDOMAIN ); ?></a>
                        </div>
                        <?php if(is_user_logged_in()): ?>
                            <div class="<?php echo $this->item_class; ?>">
                                <a id="open-side-panel" href="#" class="icon-left"><i class="fa fa-user"></i><?php echo __( 'Mijn Profiel', TEXTDOMAIN ); ?></a>
                            </div>
                            <div class="<?php echo $this->item_class; ?>">
                                <a id="new-vacature" href="<?php echo get_permalink( get_page_by_path( 'nieuwe-vacature' ) ); ?>" class="icon-left"><i class="fa fa-pencil-square-o"></i><?php echo __( 'Vacature plaatsen', TEXTDOMAIN ); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php elseif(is_singular('vacatures')): ?>

                        <?php // Previous Post Link ?>
                        <?php if(get_previous_post_link()): ?>
                            <div class="<?php echo $this->item_class; ?>">
                                <?php previous_post_link( '%link', __( 'Vorige', TEXTDOMAIN ), false ); ?>
                            </div>
                        <?php endif; ?>

                        <?php // Bewerken/Verwijderen Link ?>
                        <?php if(get_current_user_id() == $post->post_author): ?>
                            <?php if( current_user_can( 'edit_vacatures' ) ) : ?>
                                <div class="<?php echo $this->item_class; ?>">
                                    <a href="<?php echo get_edit_post_link(); ?>" class="icon-left"><i class="fa fa-pencil"></i><?php echo __( 'Bewerken', TEXTDOMAIN ); ?></a>
                                </div>
                            <?php endif; ?>
                            <?php if( current_user_can( 'delete_vacatures' ) ) : ?>
                                <div class="<?php echo $this->item_class; ?>">
                                    <?php var_dump(get_delete_post_link()); ?>
                                    <a id="delete-post" href="<?php echo get_delete_post_link(); ?>" data-id="<?php the_ID() ?>" data-nonce="<?php echo wp_create_nonce('vacature_delete_nonce'); ?>" class="icon-left"><i class="fa fa-trash"></i><?php echo __( 'Verwijderen', TEXTDOMAIN ); ?></a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="<?php echo $this->item_class; ?>">
                                <a id="view-on-map" href="#" class="icon-right"><?php echo __( 'Bekijk op kaart', TEXTDOMAIN ); ?><i class="fa fa-map-signs"></i></a>
                            </div>

                            <div class="<?php echo $this->item_class; ?>">
                                <a id="new-vacature" href="<?php echo get_post_type_archive_link( 'vacatures' );; ?>" class="icon-left"><i class="fa fa-pencil-square-o"></i><?php echo __( 'Alle Vacatures', TEXTDOMAIN ); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php // Next Post Link ?>
                        <?php if(get_next_post_link()): ?>
                            <div class="<?php echo $this->item_class; ?>">
                                <?php next_post_link( '%link', __( 'Volgende', TEXTDOMAIN ), false ); ?>
                            </div>
                        <?php endif; ?>
                    <?php elseif(is_page('registreren')): // TODO: FIX MET GLENN !!! ?>
                        <div class="<?php echo $this->item_class; ?>">
                            <a href="#" class="icon-left"><i class="fa fa-question"></i><?php echo __( 'Hulp nodig?', TEXTDOMAIN ); ?></a>
                        </div>
                    <?php else: ?>
                        <?php if(is_user_logged_in()): ?>
                            <div class="<?php echo $this->item_class; ?>">
                                <a id="open-side-panel" href="#" class="icon-left"><i class="fa fa-user"></i><?php echo __( 'Mijn Profiel', TEXTDOMAIN ); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }



}