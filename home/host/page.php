<?
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$result_tlh = mysql_query("SELECT b_title,b_loco FROM wpage_config WHERE gate = '$gate' AND lang = '$lang' AND room = '$room' AND onoff = '1'");
if (!$result_tlh) { error("QUERY_ERROR"); exit; }
          
$tlh_name = @mysql_result($result_tlh,0,0);
	$tlh_name = stripslashes($tlh_name);
$tlh_loco = @mysql_result($result_tlh,0,1);

if($tlh_loco == "bbs" OR $tlh_loco == "help") {
	$tlh_loco_icon = "icon-bullhorn";
} else if($tlh_loco == "service") {
	$tlh_loco_icon = "icon-globe";
} else if($tlh_loco == "product") {
	$tlh_loco_icon = "icon-tags";
} else {
	$tlh_loco_icon = "icon-book";
}
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


    <!-- =========================================
    CSS
    ========================================== -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
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

<!-- Page title -->
<div class="page-title">
    <h1>About Us</h1>

    <!-- BREADCRUMBS -->
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a><span class="divider"></span></li>
        <li class="active"><?=$tlh_name?></li>
    </ul>
</div>
<!-- //Page title -->


<section class="about-us-wrapper">
    <div class="row">
        <div class="col-md-12">
		
		
					<?
					$query_self = "SELECT uid,b_type,b_depth,b_option,b_lagday,b_rows,b_thread,b_permit,b_title,host_link,host_link_gate,host_link_url 
									FROM wpage_config WHERE room = '$room' AND lang = '$lang'";
					$result_self = mysql_query($query_self,$dbconn);
					if (!$result_self) { error("QUERY_ERROR"); exit; }

					$row_b = mysql_fetch_object($result_self);

					$b_uid = $row_b->uid;
					$b_type = $row_b->b_type;
					$b_depth = $row_b->b_depth;
					$b_option = $row_b->b_option;
					$notify_new_article = $row_b->b_lagday; // Days of New Article Notification
					$num_per_page = $row_b->b_rows; // Number of Articles per page
					$b_array = $row_b->b_thread;
					$b_permit = $row_b->b_permit;
					$b_title = $row_b->b_title;
					$host_link = $row_b->host_link;
					$host_link_gate = $row_b->host_link_gate;
					$host_link_room = $row_b->host_link_url;
					
					$link_list = "$home/page.php?lang=$lang&gate=$gate&mmenu=$mmenu&room=$room&b_type=$b_type&b_option=$b_option";

					$page_per_block = 10;
  
					if($host_link == "1") {
							$b_room = $host_link_room;
						if($host_link_gate == "") {
							$b_gate = "host";
						} else {
							$b_gate = $host_link_gate;
						}
					} else {
							$b_room = $room;
							$b_gate = $gate;
					}


					if(!$page) {
						$page = 1;
					}
  
					// Display
					if($b_type == "bbs" OR $b_type == "bbsm" OR $b_type == "bbsj" OR $b_type == "news" OR $b_type == "qna") {
						$b_type_link = "bbs";
					} else {
						$b_type_link = $b_type;
					}

					include "page_sub_{$b_type_link}.inc";
					
  
  
					if($b_option == "8") { // 폼 메일 부착
						include "page_sub_mail.php";
					}
					?>
            
        </div>
    </div>
    <!--end of welcome-text -->


    <div class="featured mt-50">
        <div class="row">
            <div class="col-md-4 mb-30">
                <!-- title -->
                <div class="lead-title">
                    <h2>WHY CHOOSE US</h2>
                </div>
                <!-- //title -->

                <div id="tabs">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#approch" data-toggle="tab">&nbsp;<i
                                class="fa fa-briefcase"></i></a></li>
                        <li><a href="#support" data-toggle="tab">&nbsp;<i class="fa fa-comments-o"></i></a></li>
                        <li><a href="#capabilities" data-toggle="tab">&nbsp; <i class="fa fa-wrench"></i></a></li>
                        <li><a href="#home" data-toggle="tab">&nbsp; <i class="fa fa-home"></i></a></li>
                        <li><a href="#others" data-toggle="tab">&nbsp; <i class="fa fa-headphones"></i></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab_container">
                        <div class="tab-content">
                            <div class="tab-pane active fade in" id="approch">
                                <p>Nulla dapibus malesuada libero, ut iaculis elit mattis quis. Sed nec dui tortor, ut
                                    venenatis libero. Etiam venenatis, nisl sit amet vestibulum molestie, nulla orci
                                    consequat leo, vitae commodo odio lectus vitae lacus. Morbi sed dictum diam. Aenean
                                    et ipsum eget leo auctor dignissim. Maecenas tincidunt dictum nibh.</p>

                                <div class="readmore"><a href="#">Read More</a></div>
                            </div>

                            <div class="tab-pane fade" id="support">
                                <p>Sit amet vestibulum molestie, nulla orci consequat leo, vitae commodo odio lectus
                                    vitae lacus. Morbi sed dictum diam. Aenean et ipsum eget leo auctor dignissim.
                                    Maecenas tincidunt dictum nibh.Nulla dapibus malesuada libero, ut iaculis elit
                                    mattis quis. Sed nec dui tortor, ut venenatis libero. Etiam venenatis, nisl</p>

                                <div class="readmore"><a href="#">Read More</a></div>
                            </div>

                            <div class="tab-pane fade" id="capabilities">
                                <p>Malesuada libero, ut iaculis elit mattis quis. Sed nec dui tortor, ut venenatis
                                    libero. Etiam venenatis, nisl sit amet vestibulum molestie, nulla orci consequat
                                    leo, vitae commodo odio lectus vitae lacus. Morbi sed dictum diam. Aenean et ipsum
                                    eget leo auctor dignissim. Maecenas tincidunt dictum nibh Nulla dapibus.</p>

                                <div class="readmore"><a href="#">Read More</a></div>
                            </div>

                            <div class="tab-pane fade" id="home">
                                <p>Malesuada libero, ut iaculis elit mattis quis. Sed nec dui tortor, ut venenatis
                                    libero. Etiam venenatis, nisl sit amet vestibulum molestie, nulla orci consequat
                                    leo, vitae commodo odio lectus vitae lacus. Morbi sed dictum diam. Aenean et ipsum
                                    eget leo auctor dignissim. Maecenas tincidunt dictum nibh Nulla dapibus.</p>

                                <div class="readmore"><a href="#">Read More</a></div>
                            </div>

                            <div class="tab-pane fade" id="others">
                                <p>Libero, ut iaculis elit mattis quis. Sed nec dui tortor, ut venenatis libero. Etiam
                                    venenatis, nisl sit amet vestibulum molestie, nulla orci consequat leo, vitae
                                    commodo odio lectus vitae lacus. Morbi sed dictum diam. Aenean et ipsum eget leo
                                    auctor dignissim. Maecenas tincidunt dictum nibh Nulla dapibus .</p>

                                <div class="readmore"><a href="#">Read More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-30">
                <!-- title -->
                <div class="lead-title">
                    <h2>More about us</h2>
                </div>
                <!-- //title -->


                <!-- Accordion -->
                <div class="faq-cat-content">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#section1">
                                    <h4 class="panel-title">
                                        Who we are?
                                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                    </h4>
                                </a>
                            </div>

                            <div id="section1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#section2">
                                    <h4 class="panel-title">
                                        What we do?
                                        <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                                    </h4>
                                </a>
                            </div>

                            <div id="section2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#section3">
                                    <h4 class="panel-title">
                                        Why we do it?
                                        <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                                    </h4>
                                </a>
                            </div>

                            <div id="section3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                                    brunch. Food truck quinoa
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-30">
                <!-- title -->
                <div class="lead-title">
                    <h2>Capabilities</h2>
                </div>
                <!-- //title -->

                <h3>Illustration</h3>

                <div class="progress">
                    <div style="width: 30%;" class="progress-bar progress-bar-info"><span>30%</span>
                    </div>
                </div>

                <h3>Design Ideas</h3>

                <div class="progress">
                    <div style="width: 60%;" class="progress-bar progress-bar-info"><span>60%</span>
                    </div>
                </div>

                <h3>Design Plan</h3>

                <div class="progress">
                    <div style="width: 70%;" class="progress-bar progress-bar-info"><span>70%</span>
                    </div>
                </div>

                <h3>Interior Design</h3>

                <div class="progress">
                    <div style="width: 90%;" class="progress-bar progress-bar-info"><span>90%</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- end of about us wrapper -->


<section class="team-member-wrapper mt-50">
    <div class="row">
        <div class="col-md-12">
            <!-- title -->
            <div class="lead-title">
                <h2>Meet our team</h2>
            </div>
            <!-- //title -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <figure class="team-member">
                <div class="post-thumbnail element">
                    <img src="img/team1.jpg" alt="Demo Image">

                    <div class="element-overly">Overly</div>
                    <a class="element-link" href="#" title=""><i class="fa fa-link"></i></a>
                </div>

                <h3>Jhon Doe
                    <small>Ceo</small>
                </h3>
                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
                    sanctus est Lorem ipsum</p>

                <div class="social-icon">
                    <ul>
                        <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a></li>

                        <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>

                        <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </figure>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <figure class="team-member">
                <div class="post-thumbnail element">
                    <img src="img/team2.jpg" alt="Demo Image">

                    <div class="element-overly">Overly</div>
                    <a class="element-link" href="#" title=""><i class="fa fa-link"></i></a>
                </div>
                <h3>Courtney Torres
                    <small>Founder</small>
                </h3>
                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
                    sanctus est Lorem ipsum</p>

                <div class="social-icon">
                    <ul>
                        <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a></li>

                        <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>

                        <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </figure>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <figure class="team-member">
                <div class="post-thumbnail element">
                    <img src="img/team3.jpg" alt="Demo Image">

                    <div class="element-overly">Overly</div>
                    <a class="element-link" href="#" title=""><i class="fa fa-link"></i></a>
                </div>
                <h3>Jayden Willis
                    <small>Manager</small>
                </h3>
                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
                    sanctus est Lorem ipsum</p>

                <div class="social-icon">
                    <ul>
                        <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a></li>

                        <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>

                        <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </figure>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <figure class="team-member">
                <div class="post-thumbnail element">
                    <img src="img/team4.jpg" alt="Demo Image">

                    <div class="element-overly">Overly</div>
                    <a class="element-link" href="#" title=""><i class="fa fa-link"></i></a>
                </div>
                <h3>Jerome Perez
                    <small>Designer</small>
                </h3>
                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata
                    sanctus est Lorem ipsum</p>

                <div class="social-icon">
                    <ul>
                        <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a></li>

                        <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>

                        <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </figure>
        </div>
    </div>
</section>


</div>
<!-- end of container -->


<? include "footer.inc"; ?>


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
<!-- jQuery REVOLUTION Slider  -->
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="rs-plugin/js/jquery.themepunch.revolution.js"></script>
<script src="js/jquery.donutchart.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/sidebarEffects.js"></script>
<script src="js/classie.js"></script>
<script src="js/smoothscroll.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>