<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

global $post;
?>

<div id="page-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/inc/img/hockeyvacatures-banner.jpg' ?>');">
    <div class="d-table w-100 h-100">
        <div class="d-table-cell align-middle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1><?php echo __( '404 Pagina niet gevonden', TEXTDOMAIN ); ?></h1>
                        <br>
                        <a class="btn btn-primary" href="#"><?php echo __( 'Terug naar home', TEXTDOMAIN ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>