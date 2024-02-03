<?
$m_ip = getenv('REMOTE_ADDR');
$signdate = time();

$today_6d = date("ymd",$signdate);
$today_8d = date("ymdH",$signdate);
$today_time = date("ymdHis",$signdate);


// Total Number of Main Menu
$result_mhx = mysql_query("SELECT count(uid) FROM wpage_config 
						WHERE gate = '$gate' AND lang = '$lang' AND b_loco != 'main' AND b_depth = '1' AND onoff = '1'");
if (!$result_mhx) { error("QUERY_ERROR"); exit; }
$cnt_mhx = @mysql_result($result_mhx,0,0);
?>



<!-- header-wrapper -->
<header class="header-wrapper clearfix">
<!-- row -->
<div class="row">
<!-- col-xs-12 -->
<div class="col-xs-12">

<!-- Logo -->
<div class="logo">
    <a title="Feel Buy" href="index.php">
        <img src="img/logo.png" alt="Feel Buy">
    </a>
</div>
<!-- /Logo -->


<!-- Top Social Icon -->
<div class="social-icon hidden-xs clearfix">
    <ul>
        <li>
            <!-- facebook -->
            <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a>
            <!-- /facebook -->
        </li>

        <li>
            <!-- twitter -->
            <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
            <!-- /twitter -->
        </li>

        <li>
            <!-- google-plus -->
            <a href="#" title="Google plus" target="_blank"><i class="fa fa-google-plus"></i></a>
            <!-- /google-plus -->
        </li>

        <li>
            <!-- youtube -->
            <a href="#" title="YouTube" target="_blank"><i class="fa fa-youtube"></i></a>
            <!-- /youtube-play -->
        </li>

        <li>
            <!-- linkedin -->
            <a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
            <!-- /linkedin -->
        </li>

        <li>
            <!-- flickr -->
            <a href="#" title="Flickr" target="_blank"><i class="fa fa-flickr"></i></a>
            <!-- /flickr -->
        </li>
    </ul>
</div>
<!-- end of Top Social Icon -->


<!-- =========================================
Menu
========================================== -->
<!-- navbar -->
<div class="navbar navbar-default mainnav">
<!-- navbar-header -->
<div class="navbar-header navbar-right pull-right">
    <!-- offcanvas-trigger-effects -->
    <div id="offcanvas-trigger-effects" class="column">
        <button type="button" class="navbar-toggle visible-sm visible-xs" data-toggle="offcanvas"
                data-target=".navbar-collapse" data-placement="right" data-effect="offcanvas-effect">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <!-- offcanvas-trigger-effects -->

</div>
<!-- /navbar-header -->



<!-- navbar-collapse -->
<div class="collapse navbar-collapse">
<!-- navbar-nav -->
<ul class="nav navbar-nav navbar-right">

<!-- Home Style -->
<li class="active dropdown"><a href="index.php">Home <b class="caret"></b></a>
    <!-- submenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom">
        <div class="submenu-inner  submenu-inner-topbottom">
            <ul class="level1 dropdown-menu">
                <li class="active"><a href="index.html">Home style One</a></li>
                <li><a href="index2.php">Home style Two</a></li>
                <li><a href="index3.php">Home style Three</a></li>
                <li><a href="index4.php">Home style Four</a></li>
                <li><a href="index5.php">Home style Five</a></li>
                <li><a href="index6.php">Home style Six</a></li>
                <li><a href="index7.php">Home style Seven</a></li>
                <li><a href="index8.php">Home style Eight</a></li>
            </ul>
        </div>
    </div>
    <!-- /submenu-wrapper -->
</li>
<!-- /Home Style -->


<!-- MEGA MENU -->
<li class="dropdown mega-fw has-megamenu"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Features<b
        class="caret"></b></a>
    <!-- megamenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom megamenu-wrapper">
        <div class="submenu-inner  submenu-inner-topbottom megamenu-inner">

            <ul class="dropdown-menu">
                <li>
                    <div class="mega-content">
                        <div class="row">

                            <div class="col-sm-3">
                                <ul class="menu-carousel">
                                    <li class="dropdown-header">Latest Design</li>

                                    <li>
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <a href="#"><img src="img/single-promo.jpg" alt="product"></a>
                                                    <h4>
                                                        <small>Office Feel Buyation</small>
                                                    </h4>
                                                    <button class="btn btn-primary btn-mega" type="button">49,99 €
                                                    </button>
                                                    <button class="btn btn-primary btn-mega" type="button"><span
                                                            class="glyphicon glyphicon-heart"></span> Add to Wishlist
                                                    </button>
                                                </div>
                                                <!-- End Item -->

                                                <div class="item">
                                                    <a href="#"><img src="img/single-promo2.jpg" class="img-responsive"
                                                                     alt="product 2"></a>
                                                    <h4>
                                                        <small>Home Feel Buyation</small>
                                                    </h4>
                                                    <button class="btn btn-primary btn-mega" type="button">9,99 €
                                                    </button>
                                                    <button class="btn btn-primary btn-mega" type="button"><span
                                                            class="glyphicon glyphicon-heart"></span> Add to Wishlist
                                                    </button>
                                                </div>
                                                <!-- End Item -->

                                                <div class="item">
                                                    <a href="#"><img src="img/single-promo.jpg" class="img-responsive"
                                                                     alt="product 3"></a>
                                                    <h4>
                                                        <small>Bedroom Feel Buyation</small>
                                                    </h4>
                                                    <button class="btn btn-primary btn-mega" type="button">49,99 €
                                                    </button>
                                                    <button class="btn btn-primary btn-mega" type="button"><span
                                                            class="glyphicon glyphicon-heart"></span> Add to Wishlist
                                                    </button>
                                                </div>
                                                <!-- End Item -->
                                            </div>
                                            <!-- End Carousel Inner -->

                                            <!-- Controls -->
                                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                <i class="fa fa-chevron-left"></i>
                                            </a>

                                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                <i class="fa fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <!-- /.carousel -->

                                    <li class="mega-carousel-more"><a href="#">View all Feel Buyation <i
                                            class="fa fa-angle-right"></i></a></li>

                                </ul>
                            </div>


                            <div class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Features</li>

                                    <li><a href="#">100% Responsive</a></li>
                                    <li><a href="#">Mega Menu</a></li>
                                    <li><a href="#">Free Supports And Update</a></li>

                                    <li class="dropdown-header">Home Variation</li>

                                    <li><a href="index.html">Home style One</a></li>
                                    <li><a href="index2.html">Home style Two</a></li>
                                    <li><a href="index3.html">Home style Three</a></li>
                                </ul>
                            </div>


                            <div class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header">Blog Pages</li>

                                    <li><a href="blog.html">Blog Standard</a></li>
                                    <li><a href="blog-single.html">Blog Single Post</a></li>

                                    <li class="dropdown-header">Pages</li>

                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="services.html">Services</a></li>
                                    <li><a href="pricing.html">Pricing</a></li>
                                    <li><a href="faq.html">FAQ Page</a></li>
                                </ul>
                            </div>


                            <div class="col-sm-3">
                                <ul class="menu-form">
                                    <li class="dropdown-header">Bonus Pages</li>
                                    <li><a href="project.html">Project</a></li>
                                    <li><a href="404.html">404 Page</a></li>
                                    <li><a href="single-project.html">Single Project</a></li>
                                    <li><a href="faq2.html">FAQ Page Two</a></li>

                                    <li class="dropdown-header">Newsletter</li>
                                    <li>
                                        <form role="form">
                                            <div class="form-group">
                                                <label class="sr-only" for="email">Email address</label>
                                                <input type="email" class="form-control" id="email"
                                                       placeholder="Enter email">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-mega btn-block">Sign in
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>


                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /megamenu-wrapper -->
</li>
<!-- /MEGA MENU -->

<!-- Pages -->
<li class="dropdown"><a href="#">Pages <b class="caret"></b></a>
    <!-- submenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom">
        <div class="submenu-inner  submenu-inner-topbottom">
            <ul class="level1 dropdown-menu">
			
				<?
				$result_mh2 = mysql_query("SELECT room,b_title,b_type,b_loco FROM wpage_config 
							WHERE gate = '$gate' AND lang = '$lang' AND b_loco != 'main' AND b_depth = '1' AND onoff = '1' ORDER BY b_ord ASC, b_num ASC");
				if (!$result_mh2) { error("QUERY_ERROR"); exit; }
          
				for($m2=0;$m2<$cnt_mhx;$m2++) {
					$mh2_code = mysql_result($result_mh2,$m2,0);
					$mh2_name = mysql_result($result_mh2,$m2,1);
						$mh2_name = stripslashes($mh2_name);
					$mh2_type = mysql_result($result_mh2,$m2,2);
					$mh2_loco = mysql_result($result_mh2,$m2,3);
					
					$link_mh2 = "$home/page.php?lang=$lang&gate=$gate&mmenu=$mh2_code&room=$mh2_loco&b_type=$mh2_type&b_depth=1";
            
					
			
				echo ("
				<li class='dropdown'><a href='$link_mh2'>$mh2_name<b class='caret'></b></a>
                    <div class='submenu-sub-wrapper submenu-wrapper-leftright'>
                        <div class='submenu-sub-inner  submenu-inner-leftright'>
                            <ul class='dropdown-menu'>");
				
					$result_shx = mysql_query("SELECT count(uid) FROM wpage_config 
						WHERE gate = '$gate' AND lang = '$lang' AND b_loco = '$mh2_loco' AND b_depth = '2' AND onoff = '1'");
					if (!$result_shx) { error("QUERY_ERROR"); exit; }
					$cnt_shx = @mysql_result($result_shx,0,0);
				
					$result_sh2 = mysql_query("SELECT room,b_title,b_type,b_loco,b_option FROM wpage_config 
							WHERE gate = '$gate' AND lang = '$lang' AND b_loco = '$mh2_loco' AND b_depth = '2' AND onoff = '1' 
							ORDER BY b_ord ASC, b_num ASC");
					if (!$result_sh2) { error("QUERY_ERROR"); exit; }
          
					for($s2=0;$s2<$cnt_shx;$s2++) {
						$sh2_code = mysql_result($result_sh2,$s2,0);
						$sh2_name = mysql_result($result_sh2,$s2,1);
							$sh2_name = stripslashes($sh2_name);
						$sh2_type = mysql_result($result_sh2,$s2,2);
						$sh2_loco = mysql_result($result_sh2,$s2,3);
						$sh2_option = mysql_result($result_sh2,$s2,4);
            
						$link_sh2 = "$home/page.php?lang=$lang&gate=$gate&mmenu=$mh2_code&b_type=$sh2_type&b_depth=2&room=$sh2_code&b_option=$sh2_option";
					
						echo ("<li><a href='$link_sh2'>$sh2_name</a></li>");
					
					}

					
								echo ("
                            </ul>
                        </div>
                    </div>
                </li>");
				
				}
				?>

				</ul>
        </div>
    </div>
    <!-- /submenu-wrapper -->
</li>
<!-- /Pages -->

<!-- Portfolio Pages -->
<li class="dropdown"><a href="#">Portfolio <b class="caret"></b></a>
    <!-- submenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom">
        <div class="submenu-inner  submenu-inner-topbottom">
            <ul class="level1 dropdown-menu">
                <li><a href="grid-portfolio.html">Grid View</a></li>
                <li><a href="portfolio-timeline.html">Timeline View</a></li>
                <li><a href="portfolio.html">Four Column</a></li>
                <li><a href="portfolio3.html">Three Column</a></li>
                <li><a href="portfolio2.html">Two Column</a></li>
            </ul>

        </div>
    </div>
    <!-- /submenu-wrapper -->
</li>
<!-- /Portfolio Pages -->

<!-- Blog Pages -->
<li class="dropdown"><a href="#">Blog <b class="caret"></b></a>
    <!-- submenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom">
        <div class="submenu-inner  submenu-inner-topbottom">
            <ul class="level1 dropdown-menu">
                <li><a href="blog.html">Standard Blog</a></li>
                <li><a href="blog-single.html">Single Blog Post</a></li>
                <li><a href="blog-timeline.html">Timeline Blog Post</a></li>
            </ul>
        </div>
    </div>
    <!-- /submenu-wrapper -->
</li>
<!-- /Blog Pages -->

<!-- Contact Pages -->
<li class="dropdown"><a href="#">Contact <b class="caret"></b></a>
    <!-- submenu-wrapper -->
    <div class="submenu-wrapper submenu-wrapper-topbottom">

        <div class="submenu-inner submenu-inner-topbottom">
            <ul class="level1 dropdown-menu">
                <li><a href="contact.html">Contact One</a></li>
                <li><a href="contact2.html">Contact Two</a></li>
            </ul>
        </div>
    </div>
    <!-- /submenu-wrapper -->
</li>
<!-- /Contact Pages -->

</ul>
<!-- /navbar-nav -->
</div>
<!-- /navbar-collapse -->
</div>
<!-- /navbar -->

<!--End of the menu-->


</div>
<!-- /col-xs-12 -->
</div>
<!-- /row -->
</header>
<!-- /header-wrapper -->