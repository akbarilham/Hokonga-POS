<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member2";

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
            <?=$txt_stf_member_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="crm_member2_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								
                                    
									<? if($mb_level AND $mb_level < "7") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm24?></label>
                                        <div class="col-sm-9">
										
											<?
											if($now_group_admin == "1" OR $login_level > "3") {
												$queryE = "SELECT count(uid) FROM client_branch";
											} else {
												$queryE = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
											}
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											if($now_group_admin == "1" OR $login_level > "3") {
												$queryF = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											} else {
												$queryF = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code = '$login_branch' 
															ORDER BY branch_code ASC";
											}
											$resultF = mysql_query($queryF);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											if($now_group_admin == "1" OR $login_level > "3") {
												echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");
											}

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($branch_code == $key) {
													$slc_brc = "selected";
												} else {
													$slc_brc = "";
												}
        
        
												echo("<option value='$PHP_SELF?keyfield=branch_code&key=$branch_code&mb_level=$mb_level&mb_type=$mb_type' $slc_brc>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<? if($key) { ?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$hsm_name_06_021?></label>
                                        <div class="col-sm-9">
										
											<?
											$queryG = "SELECT count(code) FROM member_main WHERE userlevel = '7' AND branch_code = '$key'";
											$resultG = mysql_query($queryG);
												if (!$resultG) {   error("QUERY_ERROR");   exit; }
											$total_recordG = @mysql_result($resultG,0,0);

											$queryH = "SELECT code,corp_name FROM member_main WHERE userlevel = '7' AND branch_code = '$key' ORDER BY name ASC";
											$resultH = mysql_query($queryH);
												if (!$resultH) {   error("QUERY_ERROR");   exit; }

											echo("<select name='user1_code' class='form-control' required>");

											for($h = 0; $h < $total_recordG; $h++) {
												$level1_code = mysql_result($resultH,$h,0);
												$level1_name = mysql_result($resultH,$h,1);
        
        
												echo("<option value='$level1_code'>$level1_name</option>");
											}
											echo("</select>");
											?>
										
										
										</div>
                                    </div>
									<? } ?>
									
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm24?></label>
                                        <div class="col-sm-9">
										
											<?
                                            if($now_group_admin == "1" OR $login_level > "3") {
												$queryE = "SELECT count(uid) FROM client_branch";
											} else {
												$queryE = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
											}
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											if($now_group_admin == "1" OR $login_level > "3") {
												$queryF = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											} else {
												$queryF = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code = '$login_branch' 
															ORDER BY branch_code ASC";
											}
											$resultF = mysql_query($queryF);

											echo("<select name='user_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($branch_code == $key) {
													$slc_brc = "selected";
												} else {
													$slc_brc = "";
												}

												echo("<option value='$branch_code' $slc_brc>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									<? } ?>
									
									
								
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_name" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="name" maxlength="60" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_153?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="corp_margin" maxlength="6" type="text" />
                                        </div>
										<div class="col-sm-1">%</div>
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

	$name = addslashes($name);
	$corp_name = addslashes($corp_name);

  // Duplication Check
  $result = mysql_query("SELECT count(name) FROM member_main WHERE name = '$name' AND corp_name = '$corp_name'");
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
  
  
	// Member Code
	$staff_code = "M".$signdate;

	if(!$user_branch_code) {
		$user_branch_code = $key;
	}

  

  if($pin_key) {
  
	if(!$mb_level) {
		$mb_level = "7";
	}
  
	if($mb_level == "7") {
		$new_level1_code = "";
	} else {
		$new_level1_code = $user1_code;
	}

    $query_M1 = "INSERT INTO member_main (uid,branch_code,gate,name,code,level1_code,id,gender,birthday,mb_type,reseller,
          corp_name,corp_dept,corp_title,corp_margin,email,phone,phone_cel,userlevel,signdate,lang) values ('',
          '$user_branch_code','$login_gate','$name','$staff_code','$new_level1_code','$user_id','$gender','$birthday','3','1',
          '$corp_name','$corp_dept','$corp_title','$corp_margin','$email','$phone','$phone_cel','$mb_level',$signdate,'$lang')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member2.php?keyfield=$keyfield&key=$key&mb_level=$mb_level&mb_type=$mb_type'>");
  exit;
  
  }
  }
  }

 
}

}
?>