<?
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
?>

<!DOCTYPE html>
<!--[if IE 7 ]>
<html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<!-- =========================================
head
========================================== -->

<head>
    <!-- =========================================
    Basic
    ========================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?=$website_name?></title>
    <meta name="keywords" content="Feel Buy, HTML5, CSS3, responsive, Template"/>
    <meta name="author" content="Cloud Software"/>
    <meta name="description" content="Feel Buy - Responsive HTML5/CSS3 Template"/>

    <!-- =========================================
    Mobile Configurations
    ========================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>


    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/icostyle.css"/>
    <!-- //Fonts -->


    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css/normalize.css"/>

    <!-- Owl Carousel CSS -->
    <link href="css/owl.carousel.css" rel="stylesheet" media="screen">

    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen"/>

    <!-- =========================================
    CSS
    ========================================== -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/prettyPhoto.css"/>
    <link rel="stylesheet" href="css/offcanvas.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link href="css/responsive.css" rel="stylesheet" media="screen"/>


    <!-- =========================================
    Head Libs
    ========================================== -->
    <script src="js/modernizr-2.6.2.min.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
<!-- /head -->


<!-- =========================================
body
========================================== -->
<body>
<!-- wrapper -->
<div class="wrapper offcanvas-container" id="offcanvas-container">

<!-- inner-wrapper -->
<div class="inner-wrapper offcanvas-pusher">
<!-- container -->
<div class="container">


<? include "header.inc"; ?>




<!-- MAIN SLIDER WRAPPER -->
<section class="slider-wrapper">
    <!-- row -->
    <div class="row">
        <!-- col-md-8 -->
        <div class="col-md-8 col-sm-12 col-xs-12">
            <!-- left-slider -->
            <div class="left-slider mb-30">
                <!-- tp-banner-container -->
                <div class="tp-banner-container">
                    <!-- tp-banner -->
                    <div class="tp-banner">
                        <ul>
                            <!-- SLIDE  -->
                            <li data-transition="random" data-slotamount="7" data-masterspeed="300"
                                data-thumb="img/slider/thumb_slider_img_4.jpg" data-delay="5000"
                                data-saveperformance="off" data-title="Our Workplace">
                                <!-- MAIN IMAGE -->
                                <img src="img/slider/slider_img_4.jpg" alt="" data-bgposition="center center"
                                     data-kenburns="on" data-duration="9000" data-ease="Linear.easeNone"
                                     data-bgfit="100" data-bgfitend="150" data-bgpositionend="right center">
                                <!-- LAYERS -->

                                <!-- LAYER NR. 1 -->
                                <div class="tp-caption css_medium_light_white lfr tp-resizeme"
                                     data-x="200"
                                     data-y="center" data-voffset="0"
                                     data-speed="1000"
                                     data-start="1000"
                                     data-easing="Power2.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;">
                                    ARCHITECTURE OF ANY COMPLEXITY
                                </div>

                                <!-- LAYER NR. 2 -->
                                <div class="tp-caption css_small_light_white lfl tp-resizeme"
                                     data-x="120"
                                     data-y="center" data-voffset="30"
                                     data-speed="1000"
                                     data-start="1000"
                                     data-easing="Power1.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;">
                                    ARCHITECTURE OF ANY COMPLEXITY
                                </div>
                            </li>


                            <!-- SLIDE  -->
                            <li data-transition="zoomin" data-slotamount="7" data-masterspeed="300"
                                data-thumb="img/slider/thumb_slider_img_2.jpg" data-delay="5000"
                                data-saveperformance="off" data-title="New York City">
                                <!-- MAIN IMAGE -->
                                <img src="img/slider/slider_img_2.jpg" alt="" data-bgposition="center center"
                                     data-kenburns="on" data-duration="9000" data-ease="Linear.easeNone"
                                     data-bgfit="100" data-bgfitend="150" data-bgpositionend="center center">
                                <!-- LAYERS -->

                                <!-- LAYER NR. 1 -->
                                <div class="tp-caption css_medium_light_white lft tp-resizeme"
                                     data-x="center" data-hoffset="0"
                                     data-y="center" data-voffset="0"
                                     data-speed="1000"
                                     data-start="1500"
                                     data-easing="Bounce.easeOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;">
                                    VISUALISATION OF YOUR IDEAS
                                </div>

                                <!-- LAYER NR. 2 -->
                                <div class="tp-caption css_small_light_white lfb tp-resizeme"
                                     data-x="center" data-hoffset="0"
                                     data-y="center" data-voffset="30"
                                     data-speed="1000"
                                     data-start="1500"
                                     data-easing="Bounce.easeOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;">
                                    PRAESENT OLESTIE LACUS. AENEAN NONUMMY HEN.
                                </div>

                            </li>


                            <!-- SLIDE  -->
                            <li data-transition="zoomout" data-slotamount="7" data-masterspeed="300"
                                data-thumb="img/slider/thumb_slider_img_3.jpg" data-delay="5000"
                                data-saveperformance="off" data-title="Nerd Wisdom">
                                <!-- MAIN IMAGE -->
                                <img src="img/slider/slider_img_3.jpg" alt="" data-bgposition="center center"
                                     data-kenburns="on" data-duration="9000" data-ease="Linear.easeNone"
                                     data-bgfit="100" data-bgfitend="150" data-bgpositionend="right center">
                                <!-- LAYERS -->

                                <!-- LAYER NR. 1 -->
                                <div class="tp-caption css_medium_light_white skewfromright tp-resizeme"
                                     data-x="center" data-hoffset="-20"
                                     data-y="center" data-voffset="-40"
                                     data-speed="1000"
                                     data-start="1000"
                                     data-easing="Power2.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 2; max-width: auto; max-height: auto; white-space: nowrap;">MOST
                                    CREATIVE ARCHITECTURAL BUREAU
                                </div>

                                <!-- LAYER NR. 2 -->
                                <div class="tp-caption css_small_light_white skewfromleft tp-resizeme"
                                     data-x="center" data-hoffset="30"
                                     data-y="center" data-voffset="-10"
                                     data-speed="1000"
                                     data-start="1300"
                                     data-easing="Power1.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 3; max-width: auto; max-height: auto; white-space: nowrap;">
                                    PRAESENT OLESTIE LACUS. AENEAN NONUMMY HEN.
                                </div>

                                <!-- LAYER NR. 3 -->
                                <div class="tp-caption css_medium_light_white skewfromright tp-resizeme"
                                     data-x="center" data-hoffset="-50"
                                     data-y="center" data-voffset="20"
                                     data-speed="1000"
                                     data-start="1600"
                                     data-easing="Power1.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">Nam
                                    elit magna. Donec porta diam eu massa.
                                </div>

                                <!-- LAYER NR. 4 -->
                                <div class="tp-caption css_small_light_white skewfromleft tp-resizeme"
                                     data-x="center" data-hoffset="5"
                                     data-y="center" data-voffset="50"
                                     data-speed="1000"
                                     data-start="1900"
                                     data-easing="Power1.easeInOut"
                                     data-splitin="none"
                                     data-splitout="none"
                                     data-elementdelay="0.1"
                                     data-endelementdelay="0.1"
                                     data-endspeed="300"
                                     style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">Nam
                                    elit magna. Donec porta diam eu massa.
                                </div>

                            </li>

                        </ul>
                    </div>
                    <!-- /tp-banner -->
                </div>
                <!-- /tp-banner-container -->

            </div>
            <!-- /left-slider -->
        </div>
        <!-- /col-md-8 -->


        <!-- col-md-4 -->
        <div class="col-md-4 col-xs-12">


            <!-- Showcase-content1 -->
            <div id="showcase-content1">

                <div class="custom feature-green feature">
                    <div>
                        <span class="b-light-text">Only This Month !</span>
                        <span class="m-bold-text">Save up to</span>

                        <p><span class="l-bold-text">20%</span>
                            <span class="s-light-text">on residential projects</span></p>
                    </div>
                </div>

            </div>
            <!-- //Showcase-content1 -->

            <!-- Showcase-content2 -->
            <div id="showcase-content2">
                <div class="custom feature-blue feature">
                    <div>
                        <span class="b-light-text">ONe Call Can</span>
                        <span class="s-light-text">make your home Unique</span>
                        <span class="m-bold-text">+800 456 12 54</span>
                    </div>
                </div>

            </div>
            <!-- //Showcase-content2 -->
        </div>

    </div>
    <!-- /row -->
</section>
<!-- end of main slider wrapper -->


<!-- Slider Bottom Wrapper -->
<section class="slider-bottom-wrapper mt-50">
    <!-- row -->
    <div class="row">
        <!-- col-md-4 -->
        <div class="col-md-4 mb-30">
            <article class="featured-content">
                <!-- title -->
                <div class="lead-title">
                    <h2>New Technologies</h2>
                </div>
                <!-- //title -->
                <!-- promo-thumb -->
                <div class="promo-thumb">
                    <img alt="" src="img/feature-img1.jpg" class="img-responsive">
                </div>
                <!-- /promo-thumb -->

                <!-- promo-text -->
                <div class="promo-text">
                    <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        Maecenas venenatis sollicitudin neque, vel rhoncus sem suscipit id.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
                <!-- /promo-text -->
            </article>
        </div>
        <!-- /col-md-4 -->


        <!-- col-md-4 -->
        <div class="col-md-4 mb-30">
            <article class="featured-content">
                <!-- title -->
                <div class="lead-title">
                    <h2>Eco materials</h2>
                </div>
                <!-- //title -->
                <!-- promo-thumb -->
                <div class="promo-thumb">
                    <img alt="" src="img/feature-img2.jpg" class="img-responsive">
                </div>
                <!-- /promo-thumb -->

                <!-- promo-text -->
                <div class="promo-text">
                    <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        Maecenas venenatis sollicitudin neque, vel rhoncus sem suscipit id.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
                <!-- /promo-text -->
            </article>
        </div>
        <!-- /col-md-4 -->

        <!-- col-md-4 -->
        <div class="col-md-4 mb-30">
            <article class="featured-content">
                <!-- title -->
                <div class="lead-title">
                    <h2>Creative Ideas</h2>
                </div>
                <!-- //title -->
                <!-- promo-thumb -->
                <div class="promo-thumb">
                    <img alt="" src="img/feature-img3.jpg" class="img-responsive">
                </div>
                <!-- /promo-thumb -->

                <!-- promo-text -->
                <div class="promo-text">
                    <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        Maecenas venenatis sollicitudin neque, vel rhoncus sem suscipit id.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
                <!-- /promo-text -->
            </article>
        </div>
        <!-- /col-md-4 -->

    </div>
    <!-- row -->
</section>
<!-- /Slider Bottom Wrapper -->


<!-- Service Wrapper -->
<section class="service-wrapper mt-50">
    <!-- row -->
    <div class="row">
        <!-- col-md-12 -->
        <div class="col-md-12">
            <!-- title -->
            <div class="lead-title">
                <h2>Our Services</h2>
            </div>
            <!-- //title -->
        </div>
        <!-- /col-md-12 -->
    </div>
    <!-- /row -->


    <!-- services-box -->
    <div class="row">
        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-flask "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Painting</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-leaf "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Garden</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

    </div>
    <!-- /row -->


    <div class="row">
        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-headphones "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Outdoor</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-flash "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Electronics</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

    </div>
    <!-- /row -->


    <div class="row">
        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-thumb-tack "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Furniture</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

        <!-- col-md-6 -->
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="services-box">
				<span class="pull-left">
					<i style="" class="fa fa-lightbulb-o "></i>
				</span>

                <div class="media-body">
                    <h2 class="media-heading">Lightening</h2>

                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        Proin commodo leo ac lacus eleifend egestas. Curabitur gravida tortor non est volutpat eget
                        cursus mauris semper.</p>

                    <div class="readmore"><a href="#">More</a></div>
                </div>
            </div>
            <!-- //services-box -->
        </div>

    </div>
    <!-- /row -->
</section>
<!-- /Service Wrapper -->



<!-- Portfolio-content -->
<section class="portfolio-content">
    <div class="lead-title">
        <h2>Our Recent Project</h2>
    </div>

    <div class="grid-block">
        <figure class="effect-layla">
            <img src="img/project-thumb/project-1.jpg" alt="img01"/>
            <figcaption>
                <h2>Home <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-2.jpg" alt="img01"/>
            <figcaption>
                <h2>Office <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-3.jpg" alt="img01"/>
            <figcaption>
                <h2>Outdoor <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-4.jpg" alt="img01"/>
            <figcaption>
                <h2>Interior <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-5.jpg" alt="img01"/>
            <figcaption>
                <h2>Pool <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-6.jpg" alt="img01"/>
            <figcaption>
                <h2>Dinning<span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-7.jpg" alt="img01"/>
            <figcaption>
                <h2>Living <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>
        <figure class="effect-layla">
            <img src="img/project-thumb/project-8.jpg" alt="img01"/>
            <figcaption>
                <h2>Garden <span>Design</span></h2>

                <p>Lily likes to play with crayons and pencils</p>
                <a href="#">View more</a>
            </figcaption>
        </figure>

    </div>
</section><!-- /Portfolio-content -->


<!-- partner-wrapper -->
<section class="partner-wrapper mt-30">
    <!-- row -->
    <div class="row">
        <!-- col-md-12 -->
        <div class="col-md-12">
            <!-- client-logo -->
            <div class="client-logo">
                <!-- Title -->
                <div class="lead-title">
                    <h2>Our Partner</h2>


                    <!-- clients-navigation -->
                    <div class="customNavigation clients-navigation">
                        <a class="next"><i class="fa fa-angle-right"></i></a>
                        <a class="prev"><i class="fa fa-angle-left"></i></a>
                    </div>
                    <!-- /clients-navigation -->

                </div>
                <!-- /Title -->

                <!-- client-logo-caruosel -->
                <div class="client-logo-caruosel">
                    <!-- clients -->
                    <div class="clients">
                        <div class="item">
                            <img src="img/client.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client2.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client3.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client4.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client5.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client6.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client3.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client4.png" alt="Image"/>
                        </div>
                        <div class="item">
                            <img src="img/client5.png" alt="Image"/>
                        </div>
                    </div>
                    <!-- /clients -->


                </div>
                <!-- /client-logo-caruosel -->
            </div>
            <!-- /client logo -->
        </div>
        <!-- /col-md-12 -->
    </div>
    <!-- /row -->
</section>
<!-- /partner-wrapper -->
</div>
<!-- /container -->


<? include "footer.inc"; ?>


</div>
<!-- /inner-wrapper -->


<!-- offcanvas-menu -->
<div class="offcanvas-menu offcanvas-effect">
    <button type="button" class="close" aria-hidden="true" data-toggle="offcanvas"
            id="off-canvas-close-btn">&times;</button>

    <h2>Sidebar Menu</h2>
    <ul>
        <li><a href="#">Home</a>
            <ul>
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="index2.html"><i class="fa fa-home"></i> Home Style Tow</a></li>
                <li><a href="index3.html"><i class="fa fa-home"></i> Home Style Three</a></li>
            </ul>
        </li>

        <li><a href="#">Pages</a>
            <ul>
                <li><a href="about.html"><i class="fa fa-user"></i> About Us</a></li>
                <li><a href="about2.html"><i class="fa fa-user"></i> About Us 2</a></li>
                <li><a href="services.html"><i class="fa fa-coffee"></i> Service</a></li>
                <li><a href="services2.html"><i class="fa fa-coffee"></i> Service 2</a></li>
                <li><a href="project.html"><i class="fa fa-magic"></i> Project</a></li>
                <li><a href="project2.html"><i class="fa fa-glass"></i> Project 2</a></li>
                <li><a href="404.html"><i class="fa fa-bell-o"></i> 404 Page</a></li>
                <li><a href="pricing.html"><i class="fa fa-puzzle-piece"></i> Pricing</a></li>
                <li><a href="pricing2.html"><i class="fa fa-puzzle-piece"></i> Pricing Two</a></li>
                <li><a href="single-project.html"><i class="fa fa-folder-open-o"></i> Single Project</a></li>
                <li><a href="single-project-2col.html"><i class="fa fa-thumbs-o-up"></i> Single Project Two</a></li>
                <li><a href="single-project-fullwidth.html"><i class="fa fa-thumbs-o-up"></i> Single FullWidth</a></li>
                <li><a href="faq.html"><i class="fa fa-laptop"></i> FAQ Page</a></li>
                <li><a href="faq2.html"><i class="fa fa-laptop"></i> FAQ Page Two</a></li>

            </ul>
        </li>


        <li><a href="#">Portfolio</a>
            <ul>
                <li><a href="grid-portfolio.html"><i class="fa fa-magic"></i> Grid View</a></li>
                <li><a href="portfolio.html"><i class="fa fa-magic"></i> Four Column</a></li>
                <li><a href="portfolio3.html"><i class="fa fa-magic"></i> Three Column</a></li>
                <li><a href="portfolio2.html"><i class="fa fa-magic"></i> Two Column</a></li>
            </ul>
        </li>

        <li><a href="#">Blog</a>
            <ul>
                <li><a href="blog.html"><i class="fa fa-pencil-square-o"></i> Blog Standard</a></li>
                <li><a href="blog-single.html"><i class="fa fa-pencil-square-o"></i> Blog single post</a></li>
            </ul>
        </li>

        <li><a href="#">Contact</a>
            <ul>
                <li><a href="contact.html"><i class="fa fa-envelope-o"></i> Contact</a></li>
                <li><a href="contact2.html"><i class="fa fa-envelope-o"></i> Contact Two</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- /offcanvas-menu -->

</div>
<!-- /wrapper -->


<!-- =========================================
JAVASCRIPT
========================================== -->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- REVOLUTION Slider  -->
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.js"></script>

<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/jquery.donutchart.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.donutchart.js"></script>

<script src="js/sidebarEffects.js"></script>
<script src="js/classie.js"></script>
<script src="js/smoothscroll.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>