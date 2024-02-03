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
$query = "SELECT uid,branch_code,gate,tcode,mcode,period,lecturer,trainee_type,duration,tuition,
          course_open,course_close,class_hours,course_detail,memo,post_date,
          eta01_chk,eta02_chk,eta03_chk,eta04_chk,eta05_chk,eta06_chk,
          eta07_chk,eta07_name,eta08_chk,eta08_name,eta09_chk,eta09_name,eta10_name 
          FROM dirlist_train WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$t_uid = $row->uid;
$branch_code = $row->branch_code;
$user_gate = $row->gate;
$tcode = $row->tcode;
$mcode = $row->mcode;
$period = $row->period;
$lecturer = $row->lecturer;
$trainee_type = $row->trainee_type;
  if($trainee_type == "A") {
    $trainee_type_chkA = "checked";
    $trainee_type_chkB = "";
    $trainee_type_chkC = "";
  } else if($trainee_type == "B") {
    $trainee_type_chkA = "";
    $trainee_type_chkB = "checked";
    $trainee_type_chkC = "";
  } else if($trainee_type == "C") {
    $trainee_type_chkA = "";
    $trainee_type_chkB = "";
    $trainee_type_chkC = "checked";
  }
$duration = $row->duration;
$tuition = $row->tuition;
$course_open = $row->course_open;
$course_close = $row->course_close;
$class_hours = $row->class_hours;
$course_detail = $row->course_detail;
$memo = $row->memo;
$post_date = $row->post_date;
    $pday1 = substr($post_date,0,4);
	  $pday2 = substr($post_date,4,2);
	  $pday3 = substr($post_date,6,2);
	  $pday4 = substr($post_date,8,2);
	  $pday5 = substr($post_date,10,2);
	  $pday6 = substr($post_date,12,2);

    if($lang == "ko") {
	    $post_date_txt = "$pday1"."/"."$pday2"."/"."$pday3".", "."$pday4".":"."$pday5".":"."$pday6";
	  } else {
	    $post_date_txt = "$pday3"."-"."$pday2"."-"."$pday1".", "."$pday4".":"."$pday5".":"."$pday6";
	  }

$eta01_chk = $row->eta01_chk;
$eta01_name = "$txt_sys_tcourse_1501";
$eta02_chk = $row->eta02_chk;
$eta02_name = "$txt_sys_tcourse_1502";
$eta03_chk = $row->eta03_chk;
$eta03_name = "$txt_sys_tcourse_1503";
$eta04_chk = $row->eta04_chk;
$eta04_name = "$txt_sys_tcourse_1504";
$eta05_chk = $row->eta05_chk;
$eta05_name = "$txt_sys_tcourse_1505";
$eta06_chk = $row->eta06_chk;
$eta06_name = "$txt_sys_tcourse_1506";
$eta07_chk = $row->eta07_chk;
$eta07_name = $row->eta07_name;
$eta08_chk = $row->eta08_chk;
$eta08_name = $row->eta08_name;
$eta09_chk = $row->eta09_chk;
$eta09_name = $row->eta09_name;
$eta10_chk = $row->eta10_chk;
$eta10_name = $row->eta10_name;

if($eta01_chk == "1") { $eta01_chk_chk = "checked"; } else { $eta01_chk_chk = ""; }
if($eta02_chk == "1") { $eta02_chk_chk = "checked"; } else { $eta02_chk_chk = ""; }
if($eta03_chk == "1") { $eta03_chk_chk = "checked"; } else { $eta03_chk_chk = ""; }
if($eta04_chk == "1") { $eta04_chk_chk = "checked"; } else { $eta04_chk_chk = ""; }
if($eta05_chk == "1") { $eta05_chk_chk = "checked"; } else { $eta05_chk_chk = ""; }
if($eta06_chk == "1") { $eta06_chk_chk = "checked"; } else { $eta06_chk_chk = ""; }
if($eta07_chk == "1") { $eta07_chk_chk = "checked"; } else { $eta07_chk_chk = ""; }
if($eta08_chk == "1") { $eta08_chk_chk = "checked"; } else { $eta08_chk_chk = ""; }
if($eta09_chk == "1") { $eta09_chk_chk = "checked"; } else { $eta09_chk_chk = ""; }
if($eta10_chk == "1") { $eta10_chk_chk = "checked"; } else { $eta10_chk_chk = ""; }
?>

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_tcourse_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_tcourse_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='t_uid' value='<?=$t_uid?>'>
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_06?></label>
                                        <div class="col-sm-2">
											<input readonly class="form-control" id="cname" name="dis_tcode" value='<?=$tcode?>' type="text" />
										</div>
										<div class="col-sm-6">
										
											<?
											$query_m1c = "SELECT count(uid) FROM dir6_catgbig WHERE lang = '$lang'";
											$result_m1c = mysql_query($query_m1c);
											$total_m1c = @mysql_result($result_m1c,0,0);

											$query_m1 = "SELECT lcode,lname FROM dir6_catgbig WHERE lang = '$lang' ORDER BY lcode ASC";
											$result_m1 = mysql_query($query_m1);

											echo("<select name='mcode' class='form-control'>");


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
        
													if($m2_mcode == $mcode) {
														$slc_mcode = "selected";
														$slc_disable = "";
													} else {
														$slc_mcode = "";
														$slc_disable = "disabled";
													}

													echo("<option $slc_disable value='$m2_mcode' $slc_mcode>&nbsp;&nbsp;&nbsp; [ $m2_mcode ] $m2_mname</option>");
												}
      
											}
											echo("</select>");
											?>
											
                                        </div>
										<div class="col-sm-1">
                                            <input readonly class="form-control" id="cname" name="period" value='<?=$period?>' type="text" />
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_10?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="lecturer" value="<?=$lecturer?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_11?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='trainee_type' value='A' <?=$trainee_type_chkA?>> Type A &nbsp;&nbsp;
											<input type=radio name='trainee_type' value='B' <?=$trainee_type_chkB?>> Type B &nbsp;&nbsp;
											<input type=radio name='trainee_type' value='C' <?=$trainee_type_chkC?>> Type C &nbsp;&nbsp;
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_12?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="duration" value="<?=$duration?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_16?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="tuition" value="<?=$tuition?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_08?> ~ <?=$txt_sys_tcourse_09?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="course_open" value="<?=$course_open?>" type="date" />
                                        </div>
										<div class="col-sm-1" align=center>~</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cdate" name="course_close" value="<?=$course_close?>" type="date" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_tcourse_13?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="class_hours" value="<?=$class_hours?>" type="text" />
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


    $query  = "DELETE FROM dirlist_train WHERE uid = '$t_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tcourse.php?keyfield=$keyfield&key=$key&cat=$catg'>");
  exit;
  

}

}
?>