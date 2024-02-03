<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "table";
$smenu = "table_corporate";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/table_corporate.php";
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
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
$query = "SELECT count(uid) FROM code_shop_option";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);
?>
    


		
		<section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row-fluid" id="draggable_portlets">
                  <div class="col-md-4 column sortable">
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-default">
                          <div class="panel-heading">Corporate 1</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-primary">
                          <div class="panel-heading">Corporate 2</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-success">
                          <div class="panel-heading">Corporate 3</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                  </div>
                  <div class="col-md-4 column sortable">
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-warning">
                          <div class="panel-heading">Corporate 4</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-danger">
                          <div class="panel-heading">Corporate 5</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-info">
                          <div class="panel-heading">Corporate 6</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                  </div>
                  <div class="col-md-4 column sortable">
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-default">
                          <div class="panel-heading">Corporate 7</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-success">
                          <div class="panel-heading">Corporate 8</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                      <!-- BEGIN Portlet PORTLET-->
                      <div class="panel panel-primary">
                          <div class="panel-heading">Corporate 9</div>
                          <div class="panel-body">
                              Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
                              Cras mattis consectetur purus sit amet fermentum. Duis mollis.
                          </div>
                      </div>
                      <!-- END Portlet PORTLET-->
                  </div>
              </div>
              <!-- page end-->
          </section>
        
		

						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/draggable-portlet.js"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

      <script>
          jQuery(document).ready(function() {
              DraggablePortlet.init();
          });
      </script>


  </body>
</html>


<?
} else if($step_next == "permit_okay") {



  echo("<meta http-equiv='Refresh' content='0; URL=$home/table_corporate.php'>");
  exit;


}

}
?>