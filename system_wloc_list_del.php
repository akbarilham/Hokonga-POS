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
$query = "SELECT uid,branch_code,gudang_code,gate,catg_code,loc_code,loc_name,loc_option,code_pic,cbm,post_date,upd_date FROM wms_location_list WHERE uid = '$uid'";
$result = mysql_query($query);
	if (!$result) {   error("QUERY_ERROR");   exit; }
$loc_uid = @mysql_result($result,0,0);
$loc_branch_code = @mysql_result($result,0,1);
$loc_gudang_code = @mysql_result($result,0,2);
$loc_gate = @mysql_result($result,0,3);
$loc_catg_code = @mysql_result($result,0,4);
	$loc_catg_code_m = substr($loc_catg_code,0,4);
$loc_code = @mysql_result($result,0,5);
$loc_name = @mysql_result($result,0,6);
$loc_option = @mysql_result($result,0,7);
$loc_code_pic = @mysql_result($result,0,8);
$loc_cbm = @mysql_result($result,0,9);
$loc_post_date = @mysql_result($result,0,10);
$loc_upd_date = @mysql_result($result,0,11);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_wloc_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_wloc_list_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='loc_uid' value='<?=$loc_uid?>'>
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

											echo("<select disabled name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
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
													
													if($menu_code2 == $loc_gudang_code) {
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
													
													if($m2_mcode == $loc_catg_code_m) {
														$slc_mcode = "selected";
													} else {
														$slc_mcode = "";
													}

													echo("<option value='$m2_mcode' $slc_mcode>&nbsp;&nbsp;&nbsp; [ $m2_mcode ] $m2_mname</option>");
													
													$query_m3c = "SELECT count(uid) FROM wms_catgsml WHERE mcode = '$m2_mcode'";
													$result_m3c = mysql_query($query_m3c);
													$total_m3c = @mysql_result($result_m3c,0,0);

													$query_m3 = "SELECT scode,sname FROM wms_catgsml WHERE mcode = '$m2_mcode' ORDER BY scode ASC";
													$result_m3 = mysql_query($query_m3);
        
													for($m3 = 0; $m3 < $total_m3c; $m3++) {
														$m3_scode = mysql_result($result_m3,$m3,0);
														$m3_sname = mysql_result($result_m3,$m3,1);
													
														if($m3_scode == $loc_catg_code) {
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_06?></label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="loc_code" value="<?echo("$loc_code")?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_name" value="<?echo("$loc_name")?>" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_option" type="text" value="<?echo("$loc_option")?>" placeholder="<?=$txt_invn_zonopt_05?>" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">CBM</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="loc_cbm" value="<?echo("$loc_cbm")?>" type="text" />
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_10?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="regis_date" value="<?=$loc_post_date?>" max="<?=$today_full_set2?>" type="date" />
                                        </div>
										<label for="cname" class="control-label col-sm-3"><?=$txt_sys_wloc_11?></label>
										<div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="update_date" value="<?=$loc_upd_date?>" max="<?=$today_full_set2?>" type="date" />
                                        </div>
                                    </div>
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm08?>">
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
	

	$query  = "DELETE FROM wms_location_list WHERE uid = '$loc_uid'";
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_wloc_list.php?keyfield=$keyfield&key=$key&key_br=$key_br'>");
	exit;

}

}
?>