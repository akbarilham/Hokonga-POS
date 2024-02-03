<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_tcourse";

if(!$step_next) {
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
    <link href="css/table-responsive.css" rel="stylesheet" />
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
	
	<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>

  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
<?
$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_tcourse_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_tcourse_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='catg' value='<?=$catg?>'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='new_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												
												if($menu_code == $key) {
													$slc_gate = "selected";
												} else {
													$slc_gate = "";
												}

												echo("<option value='$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_051?></label>
                                        <div class="col-sm-6">
										
											<?
											$query_m1c = "SELECT count(uid) FROM dir6_catgbig WHERE lang = '$lang'";
											$result_m1c = mysql_query($query_m1c);
											$total_m1c = @mysql_result($result_m1c,0,0);

											$query_m1 = "SELECT lcode,lname FROM dir6_catgbig WHERE lang = '$lang' ORDER BY lcode ASC";
											$result_m1 = mysql_query($query_m1);

											echo("<select name='mcode' class='form-control'>");
											echo("<option value=''>:: $txt_comm_frm19</option>");

											for($m1 = 0; $m1 < $total_m1c; $m1++) {
												$m1_lcode = mysql_result($result_m1,$m1,0);
												$m1_lname = mysql_result($result_m1,$m1,1);
        
												echo ("<option disabled value='$m1_lcode'>[ $m1_lcode ] $m1_lname</option>");
        
												$query_m2c = "SELECT count(uid) FROM dir6_catgmid WHERE lcode = '$m1_lcode' AND lang = '$lang'";
												$result_m2c = mysql_query($query_m2c);
												$total_m2c = @mysql_result($result_m2c,0,0);

												$query_m2 = "SELECT mcode,mname FROM dir6_catgmid WHERE lcode = '$m1_lcode' AND lang = '$lang' ORDER BY mcode ASC";
												$result_m2 = mysql_query($query_m2);
        
												for($m2 = 0; $m2 < $total_m2c; $m2++) {
													$m2_mcode = mysql_result($result_m2,$m2,0);
													$m2_mname = mysql_result($result_m2,$m2,1);
        
													if($m2_mcode == $catg) {
														$slc_mcode = "selected";
													} else {
														$slc_mcode = "";
													}

													echo("<option value='$m2_mcode' $slc_mcode>&nbsp;&nbsp;&nbsp; [ $m2_mcode ] $m2_mname</option>");
												}
      
											}
											echo("</select>");
											?>
											
                                        </div>
										<div class="col-sm-2" align=right><?=$txt_sys_tcourse_07?></div>
										<div class="col-sm-1">
                                            <input class="form-control" id="cname" name="period" type="text" />
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_10?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="lecturer" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_11?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='trainee_type' value='A'> Type A &nbsp;&nbsp;
											<input type=radio name='trainee_type' value='B' checked> Type B &nbsp;&nbsp;
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_12?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="duration" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_16?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="tuition" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_08?> ~ <?=$txt_sys_tcourse_09?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="course_open" type="date" />
                                        </div>
										<div class="col-sm-1" align=center>~</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="course_close" type="date" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_13?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="class_hours" type="text" />
                                        </div>
                                    </div>
									
																		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm21?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" maxlength="12" name="no_robot_pw" type="text" required />
                                        </div>
										<div class="col-sm-7">
											<?=$txt_comm_frm22?> <?=$no_robot_code?>
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm03?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
							
        </div>
        </section>
		</div>
		</div>
		</div>
						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	<? include "footer.inc"; ?>

</section>


	<!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>

</html>

<?
} else if($step_next == "permit_okay") {

	

  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  $m_ip = getenv('REMOTE_ADDR');

  // 코드 자동부여 ($user_gate에 따라)
  $rm_query = "SELECT tcode FROM dirlist_train ORDER BY uid DESC";
  $rm_result = mysql_query($rm_query);
  if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_room = @mysql_result($rm_result,0,0);
  
  $exp_room = explode("_",$max_room);
  $exp_room1 = $exp_room[1];
  $new_room_num1 = $exp_room1 + 1;
  $new_room_num3 = sprintf("%03d", $new_room_num1); // 3자리수
          
  if($max_room == "") {
    $new_tcode = "TR"."$mcode"."_001";
  } else {
    $new_tcode = "TR"."$mcode"."_"."$new_room_num3";
  }


  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $br_query = "SELECT branch_code FROM client WHERE client_id = '$user_gate' ORDER BY uid DESC";
  $br_result = mysql_query($br_query);
  if (!$br_result) { error("QUERY_ERROR"); exit; }
  $br_branch_code = @mysql_result($br_result,0,0);


  if($pin_key) {

    $query_M1 = "INSERT INTO dirlist_train (uid,branch_code,gate,tcode,mcode,period,lecturer,trainee_type,duration,
          tuition,course_open,course_close,class_hours,post_date) values ('','$new_branch_code','$login_gate','$new_tcode',
          '$mcode','$period','$lecturer','$trainee_type','$duration','$tuition','$course_open','$course_close',
          '$class_hours','$post_dates')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tcourse.php?keyfield=$keyfield&key=$key&cat=$mcode'>");
  exit;
  
  }
  }

}

}
?>