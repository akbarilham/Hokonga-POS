<?php
include "config/common.php";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";

$mmenu = "user";
$smenu = "user_layout";

if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
}
global $step_next;
if(!$step_next) {

$query = "SELECT uid,gate,user_id,user_pw2,user_level,user_name,user_email,user_website,default_lang,signdate,
          log_ip,log_in,log_out,visit FROM admin_user WHERE user_id = '$login_id'";

$result = mysql_query($query);

   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
$user_id = $row->user_id;
$user_pw2 = $row->user_pw2;
$userlevel = $row->user_level;
$user_name = $row->user_name;
$email = $row->user_email;
$homepage = $row->user_website;
$default_lang = $row->default_lang;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",strtotime($signdate));	
  } else {
    $signdates = date("d-m-Y, H:i:s",strtotime($signdate));	
  }
$log_ip = $row->log_ip;
$log_in = $row->log_in;
  if($log_in == "1") {
    $log_ins = "$txt_sys_user_12";
  } else {
    if($lang == "ko") {
      $log_ins = date("Y/m/d, H:i:s",$log_in);	
    } else {
      $log_ins = date("d-m-Y, H:i:s",$log_in);	
    }
  }
$log_out = $row->log_out;
  if($log_out == "1") {
    $log_outs = "--";
  } else {
    if($lang == "ko") {
      $log_outs = date("Y/m/d, H:i:s",$log_out);	
    } else {
      $log_outs = date("d-m-Y, H:i:s",$log_out);	
    }
  }
$log_visit = $row->visit;
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
                  <div class="col-sm-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <?=$txt_user_01?>
                          </header>
                          <div class="panel-body">
                              
								<form id="user_layout" class="form-horizontal" method="post" action="user_layout.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								
								
									<div class="form-group">
								  
										<label class="col-sm-3 control-label"><?=$txt_sys_user_11?></label>
										<div class="col-sm-9">
									
                                            <div class="radios">
												<label class="label_radio">
												<?
												if(!strcmp($default_lang,"en")) {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"en\" CHECKED>$txt_comm_lang_en &nbsp;");
												} else {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"en\">$txt_comm_lang_en &nbsp;");
												}
												?>
												</label>
												
                                            
												<label class="label_radio">
												<?
												if(!strcmp($default_lang,"in")) {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"in\" CHECKED>$txt_comm_lang_in &nbsp;");
												} else {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"in\">$txt_comm_lang_in &nbsp;");
												}
												?>
												</label>
												
											
												<label class="label_radio">
												<?
												if(!strcmp($default_lang,"ko")) {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"ko\" CHECKED>$txt_comm_lang_ko &nbsp;");
												} else {
													echo("<input type=\"radio\" name=\"default_lang\" value=\"ko\">$txt_comm_lang_ko &nbsp;");
												}
												?>
												</label>
											</div>
											
										</div>
									</div>			
								
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<input type="submit" value="<?=$txt_comm_frm27?>" class="btn btn-primary">
										</div>
									</div>
											
								</form>

                          </div>
                      </section>

                  </div>
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
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>

  
  <!--custom checkbox & radio-->
  <script type="text/javascript" src="js/ga.js"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>


  <!--common script for all pages-->
  <script src="js/common-scripts.js"></script>

  <!--script for this page-->
  <script src="js/form-component.js"></script>

  </body>
</html>


<?php


} else if($step_next == "permit_okay") {

$default_lang = $_POST['default_lang'];
$user_id = $_POST['user_id'];
  // 정보 변경
  $query  = "UPDATE admin_user SET default_lang = '$default_lang' WHERE user_id = '$user_id'"; 
  $result = mysql_query($query);

  if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/user_layout.php'>");
  exit;

}

}
?>