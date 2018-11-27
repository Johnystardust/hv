<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

include_once(HV_ABSPATH . 'includes/abstracts/wp-model.php');

class HV_Vacature extends WP_Model
{

    public $postType   = 'vacature';
    public $attributes = array(
        'vacature_cat',
        'gender',
        'flags',
        'street',
        'street_number',
        'addition',
        'postal',
        'city',
        'province',
        'coordinates',
        'alternate_address',
        'age',
        'field'
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
     * Function to get the related vacature.
     *
     * // TODO: Expand on this related function.
     *
     * @return array
     */
    public function get_related_vacatures()
    {
        $args = array(
            'posts_per_page' => 3,
            'post_type' => 'vacature',
            'order' => 'ASC'
        );

        return get_posts($args);
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
     * Get the vacature field type.
     *
     * @return bool|string
     */
    public function get_vacature_field()
    {
        if ($this->field == 'outdoor') {
            return __('Veld', 'hockey_vactures');
        } elseif ($this->field == 'indoor') {
            return __('Zaal', 'hockey_vacatures');
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
        if (is_user_logged_in() && $this->post()->post_author == get_current_user_id() || hv_is_user_admin(wp_get_current_user())) {
            if ($this->post()->post_status === 'flagged') {
                return true;
            }
        }

        return false;
    }

    /**
     * // TODO: FIX PENDING VACATURES ONLY SHOWN BY THEIR Authors
     *
     * Show the in review notice
     *
     * @return bool
     */
    public function show_in_review_notice()
    {
        if (is_user_logged_in() && $this->post()->post_author == get_current_user_id() || hv_is_user_admin(wp_get_current_user())) {
            if($this->post()->post_status === 'review') {
                return true;
            }
        }

        return false;
    }
}