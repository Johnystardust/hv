<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include core functions.
// =====================================================================================================================
include_once(HV_ABSPATH . 'includes/hv-widgets.php');

// Core functions.
// =====================================================================================================================

/**
 * Redirect the user on login.
 *
 * @param $redirect_to
 * @param $request
 * @param $user
 *
 * @return string
 */
function redirect_on_login($redirect_to, $request, $user)
{
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return $redirect_to;
        } else {
            return home_url() . '?login=true';
        }
    } else {
        return $redirect_to;
    }
}

add_action('login_redirect', 'redirect_on_login', 10, 3);

/**
 * Hide the admin bar for all users except admins.
 */
function hv_remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {

        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'hv_remove_admin_bar');

/**
 * Block the /wp-admin for all users except admins.
 */
function hv_block_users_form_admin()
{
    if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}

//add_action( 'init', 'hv_block_users_form_admin' );

/**
 * Add to the body class
 */
function hv_add_body_class()
{
    if (isset($_GET['login']) == true) {
        add_filter('body_class', function ($classes) {
            return array_merge($classes, array('hv-side-panel-open'));
        });
    }
}

add_action('init', 'hv_add_body_class');

// Helper functions.
// =====================================================================================================================

/**
 * Defines constant if not defined
 *
 * @param $name
 * @param $value
 */
function hv_maybe_define_constant($name, $value)
{
    if (!defined($name)) {
        define($name, $value);
    }
}

/**
 * Checks if the user is an administrator
 *
 * @param WP_User $user
 *
 * @return bool
 */
function hv_is_user_admin(WP_User $user)
{
    if (count($user->roles) && $user->roles[0] === 'administrator') {
        return true;
    }

    return false;
}

/**
 * Return the function options for the vacature and profile types
 *
 * @param $field ;
 *
 * @return array
 *
 * @deprecated
 */
function hv_get_function_options($field = 'term_id')
{
    $options = array(
        '' => __('Maak een keuze', 'hockey_vactures')
    );

    $vacature_terms = get_terms(array(
        'taxonomy'   => 'vacature_category',
        'hide_empty' => false,
    ));

    foreach ($vacature_terms as $vacature_term) {
        if ($field == 'term_id') {
            $options[$vacature_term->term_id] = $vacature_term->name;
        } elseif ($field == 'slug') {
            $options[$vacature_term->slug] = $vacature_term->name;
        }
    }

    return $options;
}

/**
 * Return the categories options for the vacature types in the vacature add form.
 *
 * @param $field
 *
 * @return array
 */
function hv_get_vacature_categories($field = 'term_id')
{
    $options = array(
        '' => __('Maak een keuze', 'hockey_vactures')
    );

    $vacature_terms = get_terms(array(
        'taxonomy'   => 'vacature_category',
        'hide_empty' => false,
    ));

    foreach ($vacature_terms as $vacature_term) {
        if ($field == 'term_id') {
            $options[$vacature_term->term_id] = $vacature_term->name;
        } elseif ($field == 'slug') {
            $options[$vacature_term->slug] = $vacature_term->name;
        }
    }

    return $options;
}

/**
 * Return the category descriptions for the vacature types in the vacature add form
 *
 * @param string $field
 *
 * @return array
 */
function hv_get_vacature_category_descriptions($field = 'term_id')
{
    $options = array();

    $vacature_terms = get_terms(array(
        'taxonomy' => 'vacature_category',
        'hide_empty' => false,
    ));

    foreach ($vacature_terms as $vacature_term){
        if($field == 'term_id'){
            $options[$vacature_term->term_id] = $vacature_term->description;
        } elseif ($field == 'slug'){
            $options[$vacature_term->term_id] = $vacature_term->description;
        }
    }

    return $options;
}


// Ajax functions.
// =====================================================================================================================

/**
 * Side panel get template
 */
function hv_side_panel_get_template()
{
    if ($_GET['name'] == '#user_vacatures') {
        include_once(HV_ABSPATH . 'templates/shortcodes/user-panel/user-vacatures.php');
    } elseif ($_GET['name'] == '#edit_vacature') {
        include_once(HV_ABSPATH . 'templates/shortcodes/user-panel/user-edit-vacature.php');
    }

    die;
}

add_action('wp_ajax_nopriv_hv_side_panel_get_template', 'hv_side_panel_get_template');
add_action('wp_ajax_hv_side_panel_get_template', 'hv_side_panel_get_template');

/**
 * Vacature delete
 *
 * Used in the vacature archive top bar.
 */
function hv_delete_vacature()
{
    $data = array();
    $nonce = check_ajax_referer('vacature_delete_nonce', 'nonce', false);

    if ($nonce == false) {
        $data['status'] = 'error';
        $data['title'] = __('Niet verwijderd', 'hockey_vacatures');
        $data['message'] = __('Er is iets mis gegaan met het verwerken van de gegevens probeer het later nog een keer.', 'hockey_vactures');
        $data['button_text'] = __('Terug');
        $data['url'] = '#message-popup-close';
    } else {
        if (wp_delete_post($_POST['id'], true)) {
            $data['status'] = 'OK';
            $data['title'] = __('Vacature is verwijderd', 'hockey_vacatures');
            $data['message'] = __('De vacature is verwijderd en zal niet meer te zien zijn.', 'hockey_vacatures');
            $data['button_text'] = __('Naar vacatures overzicht');
            $data['url'] = get_post_type_archive_link('vacature');
        }
    }

    wp_send_json($data);
}

add_action('wp_ajax_nopriv_hv_delete_vacature', 'hv_delete_vacature');
add_action('wp_ajax_hv_delete_vacature', 'hv_delete_vacature');

/**
 * Flag the vacature if the user thinks isn't valid
 *
 * TODO: Send email on vacature set to private
 *
 * TODO: If the vacature is set to private the vacature gets shown in the archive with the private prefix.
 * TODO: add an description so the user knows his post is flagged and will be checked by an site author.
 */
function hv_flag_vacature()
{
    $data = array();
    $nonce = check_ajax_referer('vacature_flag_nonce', 'nonce', false);

    if($nonce == false){
        $data['status'] = 'error';
        $data['title'] = __('Foutje bedankt', 'hockey_vactures');
        $data['message'] = __('Er is iets mis gegaan met het verwerken van de gegevens probeer het later nog een keer.', 'hockey_vactures');
        $data['button_text'] = __('Terug');
        $data['url'] = '#message-popup-close';
    } else {
        $flags = get_post_meta($_POST['id'], 'flags', true);

        if($flags < 5){
            if(update_post_meta($_POST['id'], 'flags', $flags + 1)){
                $data['status'] = 'success';
                $data['title'] = __('Bericht ontvangen', 'hockey_vacatures');
                $data['message'] = __('Bedankt voor je bericht we gaan er meteen naar kijken.'. ($flags + 1), 'hockey_vacatures');
                $data['button_text'] = __('Terug');
                $data['url'] = '#message-popup-close';
            }
        } else {
            if(wp_update_post(array('ID' => $_POST['id'], 'post_status' => 'flagged'))){
                $data['status'] = 'success';
                $data['title'] = __('Bericht ontvangen', 'hockey_vacatures');
                $data['message'] = __('Bedankt voor je bericht we gaan er meteen naar kijken.', 'hockey_vacatures');
                $data['button_text'] = __('Naar vacatures overzicht');
                $data['url'] = get_post_type_archive_link('vacature');
            }
        }
    }

    wp_send_json($data);
}

add_action('wp_ajax_nopriv_hv_flag_vacature', 'hv_flag_vacature');
add_action('wp_ajax_hv_flag_vacature', 'hv_flag_vacature');