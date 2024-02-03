<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "graph";
$smenu = "graph_flot_chart";
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
              <div class="flot-chart">
                  <!-- page start-->
                  <div class="row">
                      <div class="col-lg-12">
                          <section class="panel">
                              <header class="panel-heading">
                                  Tracking Chart
                              </header>
                              <div class="panel-body">
                                  <div id="chart-1" class="chart"></div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Selection Chart
                              </header>
                              <div class="panel-body">
                                  <div id="chart-2" class="chart"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Live Chart
                              </header>
                              <div class="panel-body">
                                  <div id="chart-3" class="chart"></div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Support Chart
                              </header>
                              <div class="panel-body">
                                  <div id="chart-4" class="chart"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Bar Chat
                              </header>
                              <div class="panel-body">
                                  <div id="chart-5" style="height:350px;"></div>
                                  <div class="btn-toolbar">
                                      <div class="btn-group stackControls">
                                          <input type="button" class="btn btn-info" value="With stacking" />
                                          <input type="button" class="btn btn-danger" value="Without stacking" />
                                      </div>
                                      <div class="space5"></div>
                                      <div class="btn-group graphControls">
                                          <input type="button" class="btn" value="Bars" />
                                          <input type="button" class="btn" value="Lines" />
                                          <input type="button" class="btn" value="Lines with steps" />

                                      </div>
                                  </div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Pie Chart
                              </header>
                              <div class="panel-body">
                                  <div id="graph1" class="chart"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Pie Chart
                              </header>
                              <div class="panel-body">
                                  <div id="graph2" class="chart"></div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Pie Chart
                              </header>
                              <div class="panel-body">
                                  <div id="graph3" class="chart"></div>
                              </div>
                          </section>
                      </div>
                      <div class="col-lg-6">
                          <section class="panel">
                              <header class="panel-heading">
                                  Donut Chart
                              </header>
                              <div class="panel-body">
                                  <div id="donut" class="chart"></div>
                              </div>
                          </section>
                      </div>
                  </div>
                  <!-- page end-->
              </div>
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

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

    <script src="assets/flot/jquery.flot.js"></script>
    <script src="assets/flot/jquery.flot.resize.js"></script>
    <script src="assets/flot/jquery.flot.pie.js"></script>
    <script src="assets/flot/jquery.flot.stack.js"></script>
    <script src="assets/flot/jquery.flot.crosshair.js"></script>




    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/flot-chart.js"></script>


  </body>
</html>

<? } ?>