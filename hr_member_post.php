<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "hr";
$smenu = "hr_member";

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
            <?=$txt_stf_staff_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="hr_member_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='hr_type' value='<?=$hr_type?>'>
								<input type='hidden' name='hr_retire' value='<?=$hr_retire?>'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
											$queryCb = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultCb = mysql_query($queryCb);
											$total_recordCb = mysql_result($resultCb,0,0);

											$queryDb = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultDb = mysql_query($queryDb);

											echo("<select name='new_branch_code' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value=\"\">:: $txt_comm_frm32</option>");

											for($ib = 0; $ib < $total_recordCb; $ib++) {
												$bmenu_code = mysql_result($resultDb,$ib,0);
												$bmenu_name = mysql_result($resultDb,$ib,1);
        
												if($key == $bmenu_code) {
													echo("<option value='$PHP_SELF?hr_type=$hr_type&key=$bmenu_code' selected>[ $bmenu_code ] $bmenu_name</option>");
												} else {
													echo("<option value='$PHP_SELF?hr_type=$hr_type&key=$bmenu_code'>[ $bmenu_code ] $bmenu_name</option>");
												}
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_15?></label>
                                        <div class="col-sm-9">
										
											<?
											$queryC = "SELECT count(uid) FROM client WHERE branch_code = '$key' AND userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client WHERE branch_code = '$key' AND userlevel > '0' 
														ORDER BY userlevel DESC, client_id ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='user_gate' class='form-control' required>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
        
												if($menu_level > "5") {
													$depth_span = "";
												} else if($menu_level == "5") {
													$depth_span = "&nbsp;&nbsp;&nbsp;&nbsp;";
												} else if($menu_level == "4") {
													$depth_span = "&nbsp;&nbsp;&nbsp;&nbsp; &gt; &nbsp;&nbsp;&nbsp;&nbsp;";
												} else {
													$depth_span = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &gt; &nbsp;&nbsp;&nbsp;&nbsp;";
												}
        
												if($menu_code == $key) {
													$br_slc_hr = "selected";
												} else {
													$br_slc_hr = "";
												}

												echo("<option value='$menu_code'>{$depth_span}[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">User ID</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="mb_id" maxlength="12" type="id" required />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">Password</div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="mb_passwd" maxlength="12" type="password" required />
                                        </div>
										<div class="col-sm-3">(Unix Encoding)</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="name" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_09?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='gender' value='M' checked> <?=$txt_stf_staff_10?> &nbsp;&nbsp;
											<input type=radio name='gender' value='F'> <?=$txt_stf_staff_11?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_12?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="user_birthdates" size="16" type="date" value="" />
										</div>
                                    </div>
									
									
									<!--									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_15?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_dept" type="text" />
                                        </div>
                                    </div>
									-->
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_16?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_title" type="text" />
                                        </div>
                                    </div>
									
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" name="email" maxlength="120" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_cel" maxlength="60" type="tel" />
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

	
	$birthday_exp = explode("-",$user_birthdates);
	$birth1 = $birthday_exp[0];
	$birth2 = $birthday_exp[1];
	$birth3 = $birthday_exp[2];
	
	$birthday = "$birth1"."$birth2"."$birth3";

  // 신청한 이름/생년월일과 동일한 이름/생년월일이 존재하는지 확인
  $result = mysql_query("SELECT count(name) FROM member_staff WHERE id = '$mb_id' OR (name = '$name' AND birthday = '$birthday')");
  if (!$result) {
    error("QUERY_ERROR");
    exit;
  }
  $rows = @mysql_result($result,0,0);
  if ($rows) {
    popup_msg("$txt_stf_staff_chk02 \\n\\n{$txt_stf_staff_chk03}");
    break;
  } else {



  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  
  // 사원코드
  $staff_code = $signdate;



  if($pin_key) {
  
	
	if(!ereg("[a-z]{1}[0-9a-z]+$",$mb_id)) {
	    error("INVALID_ID");
	    exit;
	}
	
	if(!ereg("[[:alnum:]+]{4,12}",$mb_passwd)) {
	    error("INVALID_PASSWD");
	    exit;
	}
	
	// SA
	if($hr_type == "2") {
		$new_ctr_sa = "1";
	} else {
		$new_ctr_sa = "0";
	}
  

    $query_M1 = "INSERT INTO member_staff (uid,branch_code,gate,ctr_sa,name,code,id,passwd,gender,birthday,calendar,
          corp_title,email,phone,phone_cel,userlevel,signdate,dir1_code,nationality_code) values ('','$key',
          '$user_gate','$new_ctr_sa','$name','$staff_code','$mb_id',password('$mb_passwd'),'$gender','$birthday','$calendar',
          '$corp_title','$email','$phone','$phone_cel','2','$signdate','$user_gate','in')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/hr_member.php?hr_type=$hr_type&hr_retire=$hr_retire'>");
  exit;
  
  }
  }
  }

 
}

}
?>