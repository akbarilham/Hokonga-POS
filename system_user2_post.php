<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user2";

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
            <?=$txt_sys_user2_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_user2_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_gate' value="<?=$key1?>">
								<input type="hidden" name="key" value="<?=$key?>">
								<input type="hidden" name="key1" value="<?=$key1?>">
								<input type='hidden' name='shop_flag' value='<?=$shop_flag?>'>

								
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
        
												echo("<option value='$PHP_SELF?key=$br_menu_code&key1=$key1&shop_flag=$shop_flag' $br_slc_hr>[ $br_menu_code ] $br_menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?> (Branch)</label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE branch_code = '$key' AND userlevel > '2' AND userlevel < '6'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client 
													WHERE branch_code = '$key' AND userlevel > '2' AND userlevel < '6' ORDER BY client_id ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='select2' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value='$PHP_SELF'>:: $txt_sys_user_07</option>");

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
        
												if($menu_code == $key1) {
													$br_slc_hr = "selected";
												} else {
													$br_slc_hr = "";
												}
        
												echo("<option value='$PHP_SELF?key=$key&key1=$menu_code&shop_flag=$shop_flag' $br_slc_hr>{$depth_span}[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user2_07?></label>
                                        <div class="col-sm-9">
										
											<?
											if($key1 != "") {
												$filter2 = "branch_code = '$key' AND gate = '$key1' AND userlevel > '0'";
											} else {
												$filter2 = "branch_code = '$key' AND userlevel > '0'";
											}
											
                                            $queryC2 = "SELECT count(uid) FROM client_shop WHERE $filter2";
											$resultC2 = mysql_query($queryC2);
											$total_recordC2 = @mysql_result($resultC2,0,0);

											$queryD2 = "SELECT shop_code,shop_name FROM client_shop WHERE $filter2 ORDER BY shop_code ASC";
											$resultD2 = mysql_query($queryD2);

											echo("<select name='user_shop_code' class='form-control' required>");

											for($i2 = 0; $i2 < $total_recordC2; $i2++) {
												$menu_code2 = mysql_result($resultD2,$i2,0);
												$menu_name2 = mysql_result($resultD2,$i2,1);
												
												echo("<option value='$menu_code2'>[ $menu_code2 ] $menu_name2</option>");
																								
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_05?></label>
                                        <div class="col-sm-9">
                                            <?
                                            $queryE = "SELECT count(id) FROM member_staff WHERE branch_code = '$key' AND userlevel > '0' AND userlevel < '3'";
											$resultE = mysql_query($queryE);
											$total_recordE = @mysql_result($resultE,0,0);

											$queryF = "SELECT id,name,userlevel FROM member_staff WHERE branch_code = '$key' AND userlevel > '0' AND userlevel < '3' 
														ORDER BY name ASC";
											$resultF = mysql_query($queryF);

											echo("<select name='mb_id' class='form-control' required>");
											
											echo("<option value=\"\">:: $txt_comm_frm242</option>");

											for($f = 0; $f < $total_recordE; $f++) {
												$mbr_id = mysql_result($resultF,$f,0);
												$mbr_name = mysql_result($resultF,$f,1);
												$mbr_level = mysql_result($resultF,$f,2);
												
												echo("<option value='$mbr_id'>[ $mbr_id ] $mbr_name</option>");
											}
											
											
											echo("</select>");
											?>
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

	

  // ID가 특정 아이디(ID)일 때 입력 거부
  if($id == "admin" OR $id == "info" OR $id == "guest" OR $id == "test" OR $id == "gate" 
    OR $id == "root" OR $id == "daemon" OR $id == "sync" OR $id == "shutdown" OR $id == "halt" 
    OR $id == "mail" OR $id == "email" OR $id == "news" OR $id == "uucp" OR $id == "operator" 
    OR $id == "games" OR $id == "game" OR $id == "gopher" OR $id == "nobody" OR $id == "dbus"
    OR $id == "avahi" OR $id == "mailnull" OR $id == "smmsp" OR $id == "nscd" OR $id == "vcsa"
    OR $id == "rpcuser" OR $id == "nfsnobody" OR $id == "sshd" OR $id == "pcap" OR $id == "haldaemon"
    OR $id == "apache" OR $id == "mysql" OR $id == "dovecot" OR $id == "named" OR $id == "name"
    OR $id == "lpcstest") {
    error("ID_NOT_PERMITTED");
    exit;
  } else {


  // 신청한 아이디와 동일한 아이디가 존재하는지 확인
 /*  $result = mysql_query("SELECT count(user_id) FROM admin_user WHERE user_id = '$id'");
  if (!$result) {
    error("QUERY_ERROR");
    exit;
  }
  $rows = @mysql_result($result,0,0);
  if ($rows) {
    error("ID_EXISTS");
    exit;
  }  */ 


  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');


  ########## Client 정보 테이블에서 Branch Code 추출 #############################
  $br_query = "SELECT branch_code,userlevel FROM client WHERE client_id = '$user_gate' ORDER BY uid DESC";
  $br_result = mysql_query($br_query);
  if (!$br_result) { error("QUERY_ERROR"); exit; }
  $br_branch_code = @mysql_result($br_result,0,0);
  $br_userlevel = @mysql_result($br_result,0,1);
  
  $br2_query = "SELECT client_id FROM client WHERE branch_code = '$key' AND userlevel = '3' ORDER BY uid DESC";
  $br2_result = mysql_query($br2_query);
  if (!$br2_result) { error("QUERY_ERROR"); exit; }
  $br2_gate_code = @mysql_result($br2_result,0,0);
  
  if($br_userlevel > "2") {
    $newup_gate_code = "$user_gate";
    $newup_subgate_code = "";
  } else {
    $newup_gate_code = "$br2_gate_code";
    $newup_subgate_code = "$user_gate";
  }
  
  

  if($pin_key) {
  
		$mb_query = "SELECT name,passwd,email,homepage FROM member_staff WHERE branch_code = '$key' AND id = '$mb_id' ORDER BY uid DESC";
		$mb_result = mysql_query($mb_query);
			if (!$mb_result) { error("QUERY_ERROR"); exit; }
		$new_mb_name = @mysql_result($mb_result,0,0);
		$new_mb_passwd = @mysql_result($mb_result,0,1);
		$new_mb_email = @mysql_result($mb_result,0,2);
		$new_mb_homepage = @mysql_result($mb_result,0,3);

    $query_M1 = "INSERT INTO admin_user (uid,branch_code,gate,subgate,staff_sync,staff_id,staff_passwd,user_id,user_pw,
          user_name,user_email,user_website,user_level,signdate,shop_flag,shop_code)
          values ('','$key','$newup_gate_code','$newup_subgate_code','1','$mb_id','$new_mb_passwd','$mb_id','$new_mb_passwd',
          '$new_mb_name','$new_mb_email','$new_mb_homepage','0',$signdate,'$shop_flag','$user_shop_code')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_user2.php?shop_flag=$shop_flag'>");
  exit;
  
  }
  }
  
  }

}

}
?>