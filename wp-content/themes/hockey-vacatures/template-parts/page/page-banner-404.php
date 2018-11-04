<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

global $post;

$background_image = get_stylesheet_directory_uri().'/inc/img/hockey-vacatures-banner-1.jpg';
?>
<div id="page-banner" style="background-image: url(<?php echo $background_image; ?>)">
    <div class="d-table w-100 h-100">
        <div class="d-table-cell align-middle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1><?php echo __( '404 Pagina niet gevonden', TEXTDOMAIN ); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="page-banner-spacer"></div>