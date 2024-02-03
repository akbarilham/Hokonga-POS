<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "google";
$smenu = "google_maps";
?>

<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              Basic
                              <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                          </header>
                          <div class="panel-body">
                              <div id="gmap_basic" class="gmaps"></div>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              Markers
                              <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                          </header>
                          <div class="panel-body">
                              <div id="gmap_marker" class="gmaps"></div>
                          </div>
                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              Geolocation
                              <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                          </header>
                          <div class="panel-body">
                              <div id="gmap_geo" class="gmaps"></div>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-6">
                      <section class="panel">
                          <header class="panel-heading">
                              Polylines
                              <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                          </header>
                          <div class="panel-body">
                              <div id="gmap_polylines" class="gmaps"></div>
                          </div>
                      </section>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Geocoding
                              <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-remove"></a>
                            </span>
                          </header>
                          <div class="panel-body">
                              <form class="form-inline" role="form">
                                  <div class="form-group">
                                      <input type="text" id="gmap_geocoding_address" class=" form-control" placeholder="Address..." />
                                  </div>
                                  <input type="button" id="gmap_geocoding_btn" class="btn" value="Search" />
                              </form>
                              <br>
                              <div id="gmap_geocoding" class="gmaps"></div>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      
	  <? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="js/gmaps.js"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>


    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

    <script src="js/gmaps-scripts.js"></script>

    <script>
      jQuery(document).ready(function() {
          GoogleMaps.init();
      });
    </script>


  </body>
</html>

<? } ?>