<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user";

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
            <?=$txt_sys_user_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>

        <div class="panel-body">

							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_user_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="key" value="<?=$key?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type="hidden" name="key1" value="<?=$key1?>">
								<input type="hidden" name="key2" value="<?=$key2?>">

									<!--
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">

											<?
                                            $queryA = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultA = mysql_query($queryA);
											$total_recordA = @mysql_result($resultA,0,0);

											$queryB = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultB = mysql_query($queryB);

											echo("<select name='select1' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value='$PHP_SELF'>:: $txt_comm_frm23</option>");

											for($b = 0; $b < $total_recordA; $b++) {
												$br_menu_code = mysql_result($resultB,$b,0);
												$br_menu_name = mysql_result($resultB,$b,1);

												if($br_menu_code == $key) {
													$br_slc_hr = "selected";
												} else {
													$br_slc_hr = "";
												}

												echo("<option value='$PHP_SELF?key=$br_menu_code&key1=$key1&key2=$key2' $br_slc_hr>[ $br_menu_code ] $br_menu_name</option>");
											}
											echo("</select>");
											?>

                                        </div>
                                    </div>
									-->

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">

											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = @mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client WHERE userlevel > '0'
														ORDER BY client_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);

												if($menu_level > "2") {
													$depth_span = "";
													$depth_disable = "disabled";
												} else {
													$depth_span = "&nbsp;&nbsp;&gt;&nbsp;&nbsp;";
													$depth_disable = "";
												}

												if($key_gate == $menu_code) {
													$gate_id_slc = "selected";
												} else {
													$gate_id_slc = "";
												}

												echo("<option value='$PHP_SELF?key=$key&key_gate=$menu_code' $gate_id_slc>{$depth_span}[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>

                                        </div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">System Manager</label>
                                        <div class="col-sm-9">

											<?
											$queryE = "SELECT count(id) FROM member_staff WHERE userlevel > '0'";
											$resultE = mysql_query($queryE);
											$total_recordE = @mysql_result($resultE,0,0);

											$queryF = "SELECT id,name,userlevel,branch_code FROM member_staff WHERE userlevel > '0' ORDER BY name ASC";
											$resultF = mysql_query($queryF);

											echo("<select name='select3' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

											echo("<option value='$PHP_SELF?key=$key&key1=1'>:: Create User Account here.</option>");

											if($total_recordE < 1) {
												if($key AND $key1 == "1") {
													echo("<option value=\"\">! No user</option>");
												} else {
													echo("<option value=\"\" selected>! No user</option>");
												}
											}

											for($f = 0; $f < $total_recordE; $f++) {
												$mbr_id = mysql_result($resultF,$f,0);
												$mbr_name = mysql_result($resultF,$f,1);
													$mbr_name = stripslashes($mbr_name);
												$mbr_level = mysql_result($resultF,$f,2);
												$mbr_corp_code = mysql_result($resultF,$f,3);

												// Branch Name
												$tbr_query = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$mbr_corp_code'";
												$tbr_result = mysql_query($tbr_query);
													if (!$tbr_result) { error("QUERY_ERROR"); exit; }
												$mbr_corp_name = @mysql_result($tbr_result,0,0);

												// member_staff -- [gate]
												$t21_query = "SELECT gate FROM member_staff WHERE id = '$mbr_id'";
												$t21_result = mysql_query($t21_query);
													if (!$t21_result) { error("QUERY_ERROR"); exit; }
												$mbr_gate = @mysql_result($t21_result,0,0);

												if($mbr_gate == $key_gate) {
													$mbr_gate_txt = "&nbsp; *";
												} else {
													$mbr_gate_txt = "";
												}

												if($mbr_id == $key2) {
													$mbr_id_slc = "selected";
												} else {
													$mbr_id_slc = "";
												}

												echo("<option value='$PHP_SELF?key=$key&key_gate=$key_gate&key1=2&key2=$mbr_id' $mbr_id_slc>[ $mbr_id ] $mbr_name{$mbr_gate_txt} [$mbr_corp_name]</option>");
											}


											echo("</select>");
											?>

                                        </div>
                                    </div>

									<? if($key1 == "1") { ?>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_05?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="id" maxlength="12" type="id" required />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">Password</div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="passwd" maxlength="12" type="password" required />
                                        </div>
										<div class="col-sm-3">(Unix Encoding)</div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="user_name" maxlength="60" type="text" required />
                                        </div>
                                    </div>


                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" name="email" maxlength="120" required />
                                        </div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" maxlength="120" type="url" />
                                        </div>
                                    </div>

									<? } ?>


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


	if($key1 == "2") {
		$new_id = $key2;
	} else {
		$new_id = $id;
	}

  // ID Block List
  if($new_id == "admin" OR $new_id == "info" OR $new_id == "guest" OR $new_id == "test" OR $new_id == "gate"
    OR $new_id == "root" OR $new_id == "daemon" OR $new_id == "sync" OR $new_id == "shutdown" OR $new_id == "halt"
    OR $new_id == "mail" OR $new_id == "email" OR $new_id == "news" OR $new_id == "uucp" OR $new_id == "operator"
    OR $new_id == "games" OR $new_id == "game" OR $new_id == "gopher" OR $new_id == "nobody" OR $new_id == "dbus"
    OR $new_id == "avahi" OR $new_id == "mailnull" OR $new_id == "smmsp" OR $new_id == "nscd" OR $new_id == "vcsa"
    OR $new_id == "rpcuser" OR $new_id == "nfsnobody" OR $new_id == "sshd" OR $new_id == "pcap" OR $new_id == "haldaemon"
    OR $new_id == "apache" OR $new_id == "mysql" OR $new_id == "dovecot" OR $new_id == "named" OR $new_id == "name"
    OR $new_id == "lpcstest") {
    error("ID_NOT_PERMITTED");
    exit;
  } else {


  // ID Duplication Check
  $result = mysql_query("SELECT count(user_id) FROM admin_user WHERE user_id = '$new_id'");
  if (!$result) {
    error("QUERY_ERROR");
    exit;
  }
  $rows = @mysql_result($result,0,0);
  if ($rows) {
    error("ID_EXISTS");
    exit;
  } else {


  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {



  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');


		// Group Admin Account
		if($login_branch == "CORP_01") {
			$new_group_admin = "1";
		} else {
			$new_group_admin = "0";
		}



  // Gate Name
  $br2_query = "SELECT client_id FROM client WHERE branch_code = '$login_branch' AND userlevel = '3' ORDER BY uid DESC";
  $br2_result = mysql_query($br2_query);
	if (!$br2_result) { error("QUERY_ERROR"); exit; }
  $br2_gate_code = @mysql_result($br2_result,0,0);

  if($br_userlevel > "2") {
    $newup_gate_code = "$key_gate";
    $newup_subgate_code = "";
  } else {
    $newup_gate_code = "$br2_gate_code";
    $newup_subgate_code = "$key_gate";
  }






  if($pin_key) {


	if($key1 == "2") { // Extract from Staff DB

		$mb_query = "SELECT name,passwd,email,homepage,branch_code,gate FROM member_staff WHERE id = '$key2' ORDER BY uid DESC";
		$mb_result = mysql_query($mb_query);
			if (!$mb_result) { error("QUERY_ERROR"); exit; }
		$new_mb_name = @mysql_result($mb_result,0,0);
		$new_mb_passwd = @mysql_result($mb_result,0,1);
		$new_mb_email = @mysql_result($mb_result,0,2);
		$new_mb_homepage = @mysql_result($mb_result,0,3);
		$new_mb_branch = @mysql_result($mb_result,0,4);
		$new_mb_gate = @mysql_result($mb_result,0,5);

		$mb2_query = "SELECT count(user_id) FROM admin_user WHERE user_id = '$key2' ORDER BY uid DESC";
		$mb2_result = mysql_query($mb2_query);
			if (!$mb2_result) { error("QUERY_ERROR"); exit; }
		$new_mb_count = @mysql_result($mb2_result,0,0);

		// When Staff ID exists
		if($new_mb_count > 0) {

			$query_U1 = "UPDATE admin_user SET group_admin = '1' WHERE user_id = '$key2'";
			$result_U1 = mysql_query($query_U1);
			if (!$result_U1) { error("QUERY_ERROR"); exit; }


		} else {

			$query_M1 = "INSERT INTO admin_user (uid,branch_code,gate,subgate,staff_sync,staff_id,staff_passwd,user_id,user_pw,
					user_name,user_email,user_website,user_level,signdate,group_admin)
					values ('','$new_mb_branch','$new_mb_gate','$key_gate','1','$key2','$new_mb_passwd','$key2','$new_mb_passwd',
					'$new_mb_name','$new_mb_email','$new_mb_homepage','0',$signdate,'$new_group_admin')";
			$result_M1 = mysql_query($query_M1);
			if (!$result_M1) { error("QUERY_ERROR"); exit; }

		}

	} else {

			$query_M2 = "INSERT INTO admin_user (uid,branch_code,gate,subgate,user_id,user_pw,user_pw2,
					user_name,user_email,user_website,user_level,signdate,group_admin)
					values ('','$login_branch','$newup_gate_code','$newup_subgate_code','$id',old_password('$passwd'),'$passwd',
					'$user_name','$email','$homepage','0',$signdate,'$new_group_admin')";
			$result_M2 = mysql_query($query_M2);
			if (!$result_M2) { error("QUERY_ERROR"); exit; }

	}

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_user.php'>");
  exit;

  }
  }
  }
  }

}

}
?>
