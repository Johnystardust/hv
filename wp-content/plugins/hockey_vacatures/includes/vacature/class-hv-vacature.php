<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

include_once(HV_ABSPATH . 'includes/abstracts/wp-model.php');


class HV_Vacature extends WP_Model
{

    public $postType   = 'vacature';
    public $attributes = array(
        'function',
        'gender',
        'flags',
        'street',
        'street_number',
        'addition',
        'postal',
        'city',
        'province',
        'coordinates'
    );
    public $taxonomies = array(
        'vacature_category'
    );

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the vacature author by the post meta.
     *
     * @param $key
     * @return bool|mixed
     */
    public function get_vacature_author_meta_by_key($key)
    {
        if (!empty(get_user_meta($this->post()->post_author, $key, true))) {
            return get_user_meta($this->post()->post_author, $key, true);
        }

        return false;
    }

    /**
     * Get the Vacature Author user object.
     *
     * @return false|WP_User
     */
    private function _get_user()
    {
        return get_userdata($this->post()->post_author);
    }

    /**
     * Get vacature user email
     *
     * @return string
     */
    public function get_vacature_author_email()
    {
        return $this->_get_user()->user_email;
    }

    /**
     * Get vacature author website url
     *
     * @return string
     */
    public function get_vacature_author_url()
    {
        return $this->_get_user()->user_url;
    }

    /**
     * Get the vacature gender role.
     *
     * @return bool|string
     */
    public function get_vacature_gender()
    {
        if ($this->gender == 'male') {
            return __('Man', 'hockey_vacatures');
        } elseif ($this->gender == 'female') {
            return __('Vrouw', 'hockey_vacatures');
        } elseif ($this->gender == 'either') {
            return __('Geen voorkeur', 'hockey_vacatures');
        }

        return false;
    }

    /**
     * Get the vacature gender icon.
     *
     * @return bool|string
     */
    public function get_vacature_gender_icon()
    {
        if ($this->gender == 'male') {
            return '<i class="fa fa-mars"></i>';
        } elseif ($this->gender == 'female') {
            return '<i class="fa fa-venus"></i>';
        } elseif ($this->gender == 'either') {
            return '<i class="fa fa-user"></i>';
        }

        return false;
    }

    /**
     * Show the flagged notice text.
     *
     * @return bool
     */
    public function show_flagged_notice()
    {
        if (is_user_logged_in() && $this->post()->post_author == get_current_user_id() || hv_is_user_admin(wp_get_current_user())){
            if($this->post()->post_status === 'flagged'){
                return true;
            }
        }

        return false;
    }
}