<?php

// TODO: finnish this top bar

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HV_Shortcode_Top_Bar
{
    protected $user;
    protected $vacature;

    /**
     * Constructor function get the user object
     *
     * HV_Shortcode_Top_Bar constructor.
     * @param $atts
     */
    public function __construct($atts)
    {
        // Extract the shortcode atts
        $user = '';
        extract(shortcode_atts(array('user' => false,), $atts));
        $this->user = $user;
        $this->vacature = (is_singular('vacature')) ? HV_Vacature::find(get_the_ID()) : false;
    }

    /**
     * Output function
     */
    public function output()
    {
        $this->top_bar();
    }

    /**
     * Top bar  function
     *
     */
    public function top_bar()
    {
        global $post;
        ?>
        <div id="vacatures-top-bar" class="top-bar container-fluid">
            <div class="container">
                <div class="row">
                    <?php if ($menu_items = $this->get_user_menu_items()): ?>
                        <?php foreach ($menu_items as $menu_item): ?>
                            <?php $method_name = 'get_' . $menu_item . '_menu_item'; ?>
                            <?php $this->{$method_name}(); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Get the user menu items
     *
     * @return array|bool
     */
    private function get_user_menu_items()
    {
        // If the user is logged in
        if ($this->user) {
            // Vacature archive
            if (is_post_type_archive('vacature')) {
                return array('maps', 'side_panel');
            }
            // Vacature single
            elseif (is_singular('vacature')) {
                if ($this->is_user_author()) {
                    return array('vacature_delete', 'vacature_edit', 'archive_link');
                } else {
                    return array('previous_post', 'archive_link', 'next_post');
                }
            }
        } else {
            // Vacature archive
            if (is_post_type_archive('vacature')) {
                return array('maps');
            }
            // Vacature Single
            elseif (is_singular('vacature')) {
                return array('previous_post', 'archive_link', 'next_post');
            }
        }

        return false;
    }

    /**
     * Check if the current user is author of the vacature.
     *
     * @return bool
     */
    private function is_user_author()
    {
        if($this->user === $this->vacature->_post->post_author){
            return true;
        }
        return false;
    }

    /**
     * Get Archive Menu Item
     */
    private function get_archive_link_menu_item()
    {
        ?>
        <div class="top-bar-item col-3">
            <a id="new-vacature" href="<?php echo get_post_type_archive_link('vacature'); ?>" class="icon-right">
                <?php echo __('Alle Vacatures', TEXTDOMAIN); ?>
                <i class="fas fa-list-ul"></i>
            </a>
        </div>
        <?php
    }

    /**
     * Get Maps Menu Item
     */
    private function get_maps_menu_item()
    {
        ?>
        <div class="top-bar-item col-3">
            <a id="view-on-map" href="#" class="icon-right">
                <?php echo __('Bekijk op kaart', TEXTDOMAIN); ?>
                <i class="fa fa-map-signs"></i>
            </a>
        </div>
        <?php
    }

    /**
     * Get Side Panel Menu Item
     */
    private function get_side_panel_menu_item()
    {
        ?>
        <div class="top-bar-item col-3">
            <a id="open-side-panel" href="#" class="icon-right">
                <?php echo __('Mijn Profiel', TEXTDOMAIN); ?>
                <i class="fa fa-user"></i>
            </a>
        </div>
        <?php
    }

    /**
     * The Next Post Menu Item
     */
    private function get_next_post_menu_item()
    {
        if (get_next_post_link()): ?>
            <div class="top-bar-item col-3">
                <?php next_post_link('%link', __('Volgende', TEXTDOMAIN), false); ?>
            </div>
        <?php endif;
    }

    /**
     * The Previous Post Menu Item
     */
    private function get_previous_post_menu_item()
    {
        if (get_previous_post_link()): ?>
            <div class="top-bar-item col-3">
                <?php previous_post_link('%link', __('Vorige', TEXTDOMAIN), false); ?>
            </div>
        <?php endif;
    }

    /**
     * Get New Vacature Menu Item
     *
     * @DEPRECATED
     *
     */
    private function get_new_vacature_menu_item()
    {
        ?>
<!--        <div class="top-bar-item col-3">-->
<!--            <a id="new-vacature" href="--><?php //echo get_permalink(get_page_by_path('nieuwe-vacature')); ?><!--"-->
<!--               class="icon-left">-->
<!--                <i class="fa fa-pencil-square-o"></i>-->
<!--                --><?php //echo __('Vacature plaatsen', TEXTDOMAIN); ?>
<!--            </a>-->
<!--        </div>-->
        <?php
    }

    /**
     * The Edit Vacature Menu Item
     */
    private function get_vacature_edit_menu_item()
    {
        global $post;

        if (current_user_can('edit_vacatures')) : ?>
            <div class="top-bar-item col-3">
                <a href="<?php echo home_url() ?>/bewerk-vacature?id=<?php echo $post->ID; ?>" class="icon-left">
                    <i class="fa fa-pencil"></i><?php echo __('Bewerken', TEXTDOMAIN); ?>
                </a>
            </div>
        <?php endif;
    }

    /**
     * The Delete Vacature Menu Item
     */
    private function get_vacature_delete_menu_item()
    {
        if (current_user_can('delete_vacatures')) :?>
            <div class="top-bar-item col-3">
                <a id="delete-post" href="#" data-id="<?php the_ID() ?>" data-nonce="<?php echo wp_create_nonce('vacature_delete_nonce'); ?>" class="icon-left">
                    <i class="fa fa-trash"></i><?php echo __('Verwijderen', TEXTDOMAIN); ?>
                </a>
            </div>
        <?php endif;
    }
}