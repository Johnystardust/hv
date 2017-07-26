<?php
/**
 * Page Banner
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<div id="page-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri().'/inc/img/hockeyvacatures-banner.jpg'; ?>');">
    <div class="d-table w-100 h-100">
        <div class="d-table-cell align-middle">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if(is_archive()): ?>
                            <h1><?php echo post_type_archive_title(); ?></h1>
                        <?php else: ?>
                            <h1><?php echo get_the_title(); ?></h1>
                        <?php endif; ?>
                        <h2>Leer ons kennen!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
