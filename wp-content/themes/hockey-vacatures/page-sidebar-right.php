<?php
/**
 * Template Name: Page Sidebar Right
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<?php get_header(); ?>

<div id="page-<?php the_ID(); ?>" class="page-sidebar <?php post_class(); ?>">
    <div class="container-fluid px-0" style="background-image: url('<?php echo get_stylesheet_directory_uri().'/inc/img/hockeyvacatures-banner.jpg'; ?>'); min-height: 300px;">
    </div>

    <div class="container-fluid page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-8 main-column page-content">
                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/page/content', 'page' );
                    endwhile; ?>
                </div>
                <div class="col-3 push-1 px-0 sidebar-column">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- TODO: FIX: MAPS !!! -->
<div id="maps" class="container-fluid px-0">
    <div class="map-side">
        <div class="map-side-inner">
            <h3>Filters: </h3>
            <ul>
                <li><a href="#">Test Filter</a></li>
                <li><a href="#">Functie</a></li>
                <li><a href="#">Geslacht</a></li>
            </ul>
        </div>
        <a href="#" class="open-map-side"><i class="fa fa-angle-right"></i></a>
        <a href="#" class="map-exit"><i class="fa fa-times"></i></a>
    </div>
    <div id="map-canvas" class="h-100"></div>
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: {lat: 52.497215, lng: 4.996103},
                zoom: 9
            });

            var myLatLng = {lat: 52.127692, lng: 5.5596333};
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegnKkyQR90JmYSF2sJ2kMNjfxbFg5EEs&callback=initMap" async defer></script>

    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3><?php echo __('Bekijk alle vacatures', TEXTDOMAIN); ?></h3>
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
