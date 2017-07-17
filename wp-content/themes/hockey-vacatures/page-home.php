<?php
/**
 * Template Name: Home Page
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<?php get_header(); ?>

<div id="banner" class="container-fluid px-0" style="background-image: url('<?php echo get_stylesheet_directory_uri().'/inc/img/hockeyvacatures-banner.jpg'; ?>')">
    <div class="overlay">
        <div class="d-table w-100 h-100">
            <div class="d-table-cell align-middle">
                <div class="container">
                    <h1>Hockey vacatures</h1>
                    <h2 class="mb-5">Voor hockeyers door hockeyers</h2>
                    <a class="btn btn-primary" href="<?php echo get_post_type_archive_link( 'vacatures' ); ?>">Ontdek het nu <i class="fa fa-angle-double-down"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cta" class="container-fluid mb-5 py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Meld u nu aan!</h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="#" class="btn btn-primary">Aanmelden <i class="fa fa-angle-double-down"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="cards" class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 card">
                <i class="fa fa-user-circle"></i>
                <h3>Solliciteren</h3>
                <p>Lorem quod hic deserunt blanditiis voluptas quisquam!</p>
                <a href="#">Lees meer <i class="fa fa-angle-double-right"></i></a>
            </div>
            <div class="col-12 col-md-3 card">
                <i class="fa fa-id-card-o"></i>
                <h3>Vacatures</h3>
                <p>Lorem quod hic deserunt blanditiis voluptas quisquam!</p>
                <a href="#">Lees meer <i class="fa fa-angle-double-right"></i></a>
            </div>
            <div class="col-12 col-md-3 card">
                <i class="fa fa-binoculars"></i>
                <h3>Headhunters</h3>
                <p>Lorem quod hic deserunt blanditiis voluptas quisquam!</p>
                <a href="#">Lees meer <i class="fa fa-angle-double-right"></i></a>
            </div>
            <div class="col-12 col-md-3 card">
                <i class="fa fa-commenting-o"></i>
                <h3>Live updates</h3>
                <p>Lorem quod hic deserunt blanditiis voluptas quisquam!</p>
                <a href="#">Lees meer <i class="fa fa-angle-double-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pl-0">
    <div class="row">
        <div class="col-7">
            <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri().'/inc/img/drag-drop.png'; ?>"/>
        </div>
        <div class="col-3">
            <div class="d-table h-100 w-100">
                <div class="d-table-cell align-middle">
                    <h5 class="font-weight-light text-uppercase">Voor hockeyers door hockeyers</h5>
                    <h2 class="text-uppercase pb-3">Werven & solliciteren</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                    <a href="#" class="btn btn-primary">Ontdek het nu</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="panels" class="container-fluid" style="background-image: url('http://matx.coderpixel.com/wp/wp-content/uploads/2016/04/desk.jpg?id=2806'); background-size: cover;">
    <div class="container">
        <div class="row py-5">
            <div class="col-12 mb-5 text-center">
                <h3>Why choose us</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
            </div>
            <div class="col-lg-6">
                <img src="http://matx.coderpixel.com/wp/wp-content/uploads/2016/04/01.jpg" alt="">
            </div>
            <div class="col-lg-6">
                <div class="panel-group">
                    <div class="panel col-12 mb-3 active">
                        <div class="panel-heading py-3">
                            <h5>Panel heading</h5>
                            <i class="fa fa-plus pull-right"></i>
                        </div>
                        <div class="panel-body">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        </div>
                    </div>
                    <div class="panel col-12 mb-3">
                        <div class="panel-heading py-3">
                            <h5>Panel heading</h5>
                            <i class="fa fa-plus pull-right"></i>
                        </div>
                        <div class="panel-body">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        </div>
                    </div>
                    <div class="panel col-12 mb-3">
                        <div class="panel-heading py-3">
                            <h5>Panel heading</h5>
                            <i class="fa fa-plus pull-right"></i>
                        </div>
                        <div class="panel-body">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="contact" class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2 class="text-uppercase">Contact us</h2>
                <ul>
                    <li>
                        <span class="circle"><i class="fa fa-home"></i></span>
                        <a href="#">Arnhem</a>
                    </li>
                    <li>
                        <span class="circle"><i class="fa fa-map-marker"></i></span>
                        <a href="#"> Broerenstraat 39</a>
                    </li>
                    <li>
                        <span class="circle"><i class="fa fa-envelope"></i></span>
                        <a href="#">INFO@HOCKEYVACATURES.NL</a>
                    </li>
                    <li>
                        <span class="circle"><i class="fa fa-phone"></i></span>
                        <a href="#">+31(0)6 23 43 42 32 </a>
                    </li>
                </ul>
            </div>
            <div class="col-6">
                <form action="#">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="naam">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="onderwerp">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="e-mail">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="bericht"></textarea>
                    </div>
                    <div class="form-group">
                        <a href="#" class="btn btn-primary">Verstuur &nbsp; <i class="fa fa-send"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="maps" class="container-fluid" style="background-image: url('inc/img/Untitled-1.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Bekijk nu alle vacatures</h3>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
