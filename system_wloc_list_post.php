<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_wloc_list";

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
            <?=$txt_sys_wloc_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_wloc_list_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='key_br' value='<?=$key_br?>'>
								<input type='hidden' name='catg' value='<?=$catg?>'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm43?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value=\"$PHP_SELF\">:: $txt_comm_frm431</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);

												echo("<option disabled value='$PHP_SELF?key_br=$menu_code' $slc_gate>$menu_name</option>");
												
												$queryC2 = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$menu_code' AND userlevel > '0'";
												$resultC2 = mysql_query($queryC2);
												$total_recordC2 = mysql_result($resultC2,0,0);

												$queryD2 = "SELECT gudang_code,gudang_name FROM code_gudang 
															WHERE branch_code = '$menu_code' AND userlevel > '0' ORDER BY userlevel DESC, gudang_code ASC";
												$resultD2 = mysql_query($queryD2);


												for($i2 = 0; $i2 < $total_recordC2; $i2++) {
													$menu_code2 = mysql_result($resultD2,$i2,0);
													$menu_name2 = mysql_result($resultD2,$i2,1);
													
													if($menu_code2 == $key) {
														$slc_gudang = "selected";
													} else {
														$slc_gudang = "";
													}

													echo("<option value='$PHP_SELF?key_br=$menu_code&key=$menu_code2' $slc_gudang>&nbsp;&nbsp;&nbsp; $menu_name2</option>");
													
												}
			
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_05?></label>
                                        <div class="col-sm-9">
										
											<?
											$query_m1c = "SELECT count(uid) FROM wms_catgbig";
											$result_m1c = mysql_query($query_m1c);
											$total_m1c = @mysql_result($result_m1c,0,0);

											$query_m1 = "SELECT lcode,lname FROM wms_catgbig ORDER BY lcode ASC";
											$result_m1 = mysql_query($query_m1);

											echo("<select name='catg_code' class='form-control' required>");
											echo("<option value=\"\">:: $txt_comm_frm19</option>");

											for($m1 = 0; $m1 < $total_m1c; $m1++) {
												$m1_lcode = mysql_result($result_m1,$m1,0);
												$m1_lname = mysql_result($result_m1,$m1,1);
        
												echo ("<option disabled value='$m1_lcode'>[ $m1_lcode ] $m1_lname</option>");
        
												$query_m2c = "SELECT count(uid) FROM wms_catgmid WHERE lcode = '$m1_lcode'";
												$result_m2c = mysql_query($query_m2c);
												$total_m2c = @mysql_result($result_m2c,0,0);

												$query_m2 = "SELECT mcode,mname FROM wms_catgmid WHERE lcode = '$m1_lcode' ORDER BY mcode ASC";
												$result_m2 = mysql_query($query_m2);
        
												for($m2 = 0; $m2 < $total_m2c; $m2++) {
													$m2_mcode = mysql_result($result_m2,$m2,0);
													$m2_mname = mysql_result($result_m2,$m2,1);

													echo("<option value='$m2_mcode'>&nbsp;&nbsp;&nbsp; [ $m2_mcode ] $m2_mname</option>");
													
													$query_m3c = "SELECT count(uid) FROM wms_catgsml WHERE mcode = '$m2_mcode'";
													$result_m3c = mysql_query($query_m3c);
													$total_m3c = @mysql_result($result_m3c,0,0);

													$query_m3 = "SELECT scode,sname FROM wms_catgsml WHERE mcode = '$m2_mcode' ORDER BY scode ASC";
													$result_m3 = mysql_query($query_m3);
        
													for($m3 = 0; $m3 < $total_m3c; $m3++) {
														$m3_scode = mysql_result($result_m3,$m3,0);
														$m3_sname = mysql_result($result_m3,$m3,1);
													
														if($m3_scode == $catg) {
															$slc_scode = "selected";
														} else {
															$slc_scode = "";
														}
														
														echo("<option value='$m3_scode' $slc_scode>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [ $m3_scode ] $m3_sname</option>");

													
													}
												}
      
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_name" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_option" type="text" placeholder="<?=$txt_invn_zonopt_05?>" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">CBM</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_cbm" type="text" />
                                        </div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_09?></label>
                                        <div class="col-sm-9">
											<?
                                            $query_stc = "SELECT count(uid) FROM member_staff WHERE branch_code = '$key_br' AND userlevel > '0'";
											$result_stc = mysql_query($query_stc);
											$total_stc = @mysql_result($result_stc,0,0);

											$query_st = "SELECT code,name FROM member_staff WHERE branch_code = '$key_br' AND userlevel > '0' ORDER BY name ASC";
											$result_st = mysql_query($query_st);

											echo("<select name='code_pic' class='form-control'>");
											echo("<option value=''>:: $txt_comm_frm19</option>");

											for($st = 0; $st < $total_stc; $st++) {
												$stf_code = mysql_result($result_st,$st,0);
												$stf_name = mysql_result($result_st,$st,1);
												
												echo ("<option value='$stf_code'>$stf_name</option>");
											}
											echo ("</select>");
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_10?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="regis_date" value="<?=$today_full_set2?>" max="<?=$today_full_set2?>" type="date" />
                                        </div>
										<label for="cname" class="control-label col-sm-3"></label>
										<div class="col-sm-3">
                                            
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
  

  // New Location Code (12 digits - Flag(2) Corp(2) WH(2) Serial Number(4) )
  // Flag Warehouse Location = 05
  $new_branch_code = $key_br;
	$new_branch_code_xpd = explode("_",$new_branch_code);
	$new_branch_code2 = $new_branch_code_xpd[1];
  $new_gudang_code = $key;
	$new_gudang_code_xpd = explode("_",$new_gudang_code);
	$new_gudang_code2 = $new_gudang_code_xpd[1];
  
  
  $rm_query = "SELECT loc_code FROM wms_location_list ORDER BY loc_code DESC";
  $rm_result = mysql_query($rm_query);
	if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_room = @mysql_result($rm_result,0,0);
  
  $exp_room1 = substr($max_room,6);
	$new_room_num1 = $exp_room1 + 1;
  $new_room_num4 = sprintf("%04d", $new_room_num1); // 4 digits
  
  $catg_tail = substr($catg_code,4);
  if($catg_tail < 1) {
	  $new_catg_code = "$catg_code"."00";
  } else {
	  $new_catg_code = $catg_code;
  }
          
  if($max_room == "") {
    $new_loc_code = "05"."$new_branch_code2"."$new_gudang_code2"."0001";
  } else {
    $new_loc_code = "05"."$new_branch_code2"."$new_gudang_code2"."$new_room_num4";
  }


  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  if($pin_key) {

    $query_M1 = "INSERT INTO wms_location_list (uid,branch_code,gudang_code,gate,catg_code,loc_code,loc_name,loc_option,cbm,code_pic,post_date,upd_date) 
		values ('','$new_branch_code','$new_gudang_code','$login_gate','$new_catg_code','$new_loc_code','$loc_name','$loc_option','$loc_cbm','$code_pic',
		'$regis_date','$regis_date')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_wloc_list.php?keyfield=$keyfield&key=$key&key_br=$key_br'>");
  exit;
  
  }
  }

}

}
?>