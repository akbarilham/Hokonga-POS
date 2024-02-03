<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "graph";
$smenu = "graph_morris";
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
    <link href="assets/morris.js-0.4.3/morris.css" rel="stylesheet" />
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

          <section class="wrapper site-min-height">
              <!-- page start-->
              <div id="morris">
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Jaguar 'E' Type vehicles in the UK
                              </header>
                              <div class="panel-body">
                                  <div id="hero-graph" class="graph"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  iPhone CPU benchmarks
                              </header>
                              <div class="panel-body">
                                  <div id="hero-bar" class="graph"></div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Quarterly Apple iOS device unit sales
                              </header>
                              <div class="panel-body">
                                  <div id="hero-area" class="graph"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Donut flavours
                              </header>
                              <div class="panel-body">
                                  <div id="hero-donut" class="graph"></div>
                              </div>
                          </section>
                      </div>
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
    <!--<script src="js/jquery-1.8.3.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/morris.js-0.4.3/morris.min.js" type="text/javascript"></script>
    <script src="assets/morris.js-0.4.3/raphael-min.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

    <!-- script for this page only-->
    <script src="js/morris-script.js"></script>


  </body>
</html>

<? } ?>