<?php
/**
 * Functions
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

// Define Constants
define('TEXTDOMAIN', 'hockeyvacatures');

get_template_part('theme-functions/customizer');
get_template_part('theme-functions/vc_map');
get_template_part('inc/admin/admin');

// Remove Wordpress branding from admin footer
if( !current_user_can('administrator') ){
    add_filter( 'admin_footer_text', '__return_empty_string', 11 );
    add_filter( 'update_footer',     '__return_empty_string', 11 );
}

function hv_enqueue(){

    // Enqueue the stylesheets
    // =======================
    wp_enqueue_style('theme-stylesheet', get_stylesheet_uri());
    wp_enqueue_style('styles', get_stylesheet_directory_uri().'/inc/css/style.css', array(), null);

    // Enqueue the scripts
    // ===================
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery-cdn', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(/* Dependencies */), null, true);
    wp_enqueue_script('theme-js', get_stylesheet_directory_uri().'/inc/js/main.js', array('jquery-cdn'), null, true);

    wp_enqueue_script('tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', array('jquery-cdn'), null, true);
    wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', array('jquery-cdn', 'tether'), null, true);
    wp_enqueue_script('slick-slider', get_stylesheet_directory_uri().'/inc/js/slick.min.js', array('jquery-cdn'), null, true);
}
add_action('wp_enqueue_scripts', 'hv_enqueue');

function hv_register_widget_areas(){

    // Footer
    register_sidebar(array(
        'name' 			=> __('Footer', TEXTDOMAIN),
        'id' 			=> 'footer',
        'description' 	=> __('Footer', TEXTDOMAIN),
        'before_widget' => '<div id="%1$s" class="%2$s widget footer-widget col-12 col-md-6 col-lg-3">',
        'after_widget' 	=> '</div>',
        'before_title' 	=> '<h5 class="widget-title">',
        'after_title' 	=> '</h5><div class="spacer"></div>',
    ));

    // Sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', TEXTDOMAIN),
        'id'            => 'sidebar',
        'description'   => __('Main sidebar displayed on single templates.', TEXTDOMAIN),
        'before_widget' => '<div id="%1$s" class="%2$s widget sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5><div class="spacer"></div>',
    ));

    // Archive Sidebar
    register_sidebar(array(
        'name'          => __('Archive Sidebar', TEXTDOMAIN),
        'id'            => 'archive_sidebar',
        'description'   => __('Archive sidebar displayed on archive templates.', TEXTDOMAIN),
        'before_widget' => '<div id="%1$s" class="%2$s widget sidebar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5><div class="spacer"></div>',
    ));

    // Top Header
    register_sidebar(array(
        'name'          => __('Header Top Bar', TEXTDOMAIN),
        'id'            => 'header_top_bar',
        'description'   => __('Header Top Bar widget area', TEXTDOMAIN),
        'before_widget' => '<div id="%1$s" class="%2$s widget top-bar-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
}
add_action( 'widgets_init', 'hv_register_widget_areas' );

function hv_register_menu() {
    register_nav_menu( 'primary', __( 'Hoofdmenu', TEXTDOMAIN ) );
}
add_action( 'after_setup_theme', 'hv_register_menu' );


function get_title_meta(){
    if(is_archive()){
        return get_the_archive_title();
    }
    else {
        return get_the_title();
    }
}



function my_login_page() { ?>
    <style type="text/css">
        body.login {
            background: #177FBF;
        }

        label {
            color: #ffffff !important;
        }

        #wp-submit {
            border: 2px solid #fff;
            border-radius: 0;
            color: #fff;
            font-weight: 600;
            background: transparent;
            text-shadow: none;
        }
        #wp-submit:hover {
            background-color: #fff;
            color: #177FBF;
            text-shadow: none;
        }

        .login form .input, .login input[type=text] {
            background: transparent !important;
            box-shadow: none;
            border: none;
            color: #ffffff;
            border-bottom: 2px solid #ffffff;
        }

        #loginform {
            background: transparent;
            box-shadow: none;
        }

        body.login #nav a, body.login #backtoblog a {color: #ffffff;}
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/inc/img/hockey-vacatures-logo.png);
            height:65px;
            width:320px;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_page' );
