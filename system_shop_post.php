<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_shop";

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
            <?=$txt_sys_shop_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_shop_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='key_associate' value='<?=$key_associate?>'>
								<input type='hidden' name='asso_type' value='<?=$asso_type?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE userlevel > '1' AND userlevel < '6'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel,branch_code,consign,associate FROM client WHERE userlevel > '1' AND userlevel < '6' 
														ORDER BY branch_code ASC, userlevel DESC, client_code ASC";
											$resultD = mysql_query($queryD);

											echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo ("<option value=\"\">:: $txt_comm_frm24</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
												$menu_corp = mysql_result($resultD,$i,3);
												$consign_flag = mysql_result($resultD,$i,4);
												$associate_flag = mysql_result($resultD,$i,5);
        
												if($menu_level > "4") {
													$depth_span = "";
													$depth_disable = "disabled";
												} else if($menu_level == "4") {
													$depth_span = "&nbsp;&nbsp;";
													$depth_disable = "disabled";
												} else if($menu_level == "3") {
													$depth_span = "&nbsp;&nbsp;&nbsp;&nbsp;";
													$depth_disable = "disabled";
												} else {
													$depth_span = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
													$depth_disable = "";
												}
		
												if($menu_code == $key) {
													$select_now = "selected";
												} else {
													$select_now = "";
												}
        

												echo("<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=$sorting_key&keyfield=subgate&key=$menu_code&key_associate=$associate_flag&key_area=$key_area' $select_now>$depth_span $menu_corp - $menu_name ( $menu_code )</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									<? if($asso_type == "A" OR $asso_type == "B") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_16?></label>
                                        <div class="col-sm-9">
											<?
											$query_ARc = "SELECT count(area_name) FROM code_area";
											$result_ARc = mysql_query($query_ARc);
											$total_AR = @mysql_result($result_ARc,0,0);

											$query_AR = "SELECT uid,area_code,area_name,area_name2,area_name3 FROM code_area ORDER BY ord_no ASC";
											$result_AR = mysql_query($query_AR);

											echo ("<select name='new_area_uid' class='form-control'>");
											echo ("<option value=\"\">:: $txt_sys_shop_17</option>");

											for($ar = 0; $ar < $total_AR; $ar++) {
												$cn_area_uid = mysql_result($result_AR,$ar,0);
												$cn_area_code = mysql_result($result_AR,$ar,1);
												$cn_area_name = mysql_result($result_AR,$ar,2);
												$cn_area_name2 = mysql_result($result_AR,$ar,3);
												$cn_area_name3 = mysql_result($result_AR,$ar,4);
												
												$cn_area_name = stripslashes($cn_area_name);
												$cn_area_name2 = stripslashes($cn_area_name2);
												$cn_area_name3 = stripslashes($cn_area_name3);
												
												if($cn_area_name == $cn_area_name2) {
													$cn_area_name_pre = "$cn_area_name";
												} else {
													$cn_area_name_pre = "$cn_area_name"." &gt; "."$cn_area_name2";
												}
												
												if($cn_area_name2 == $cn_area_name3) {
													$cn_area_name_txt = "$cn_area_name_pre";
												} else {
													$cn_area_name_txt = "$cn_area_name_pre"." &gt; "."$cn_area_name3";
												}
			
												echo ("<option value='$cn_area_uid'>$cn_area_name_txt</option>");
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									
																		
									<? if($key AND $key_associate == "1") { ?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm41?></label>
                                        <div class="col-sm-9">
                                            <?
											$query_PT1 = "SELECT count(code) FROM member_main WHERE userlevel = '3'";
											$result_PT1 = mysql_query($query_PT1);
											$total_record_pt = @mysql_result($result_PT1,0,0);

											$query_PT2 = "SELECT branch_code,code,name FROM member_main WHERE userlevel = '3' 
														ORDER BY name ASC";
											$result_PT2 = mysql_query($query_PT2);

											echo("<select name='consign_user_code' class='form-control'>");
											echo ("<option value=\"\">:: $txt_comm_frm411</option>");

											for($pt = 0; $pt < $total_record_pt; $pt++) {
												$pt_branch_code = mysql_result($result_PT2,$pt,0);
												$pt_user_code = mysql_result($result_PT2,$pt,1);
												$pt_user_name = mysql_result($result_PT2,$pt,2);
			
												echo ("<option value='$pt_user_code'>$pt_user_name</option>");
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_14?></label>
                                        <div class="col-sm-9">
                                            <?
											$query_K1 = "SELECT count(uid) FROM client_consign WHERE userlevel > '0'";
											$result_K1 = mysql_query($query_K1);
											$total_record_k = @mysql_result($result_K1,0,0);

											$query_K2 = "SELECT branch_code,group_code,group_name,group_type FROM client_consign WHERE userlevel > '0' 
														ORDER BY group_name ASC";
											$result_K2 = mysql_query($query_K2);

											echo("<select name='group_code' class='form-control'>");

											for($k = 0; $k < $total_record_k; $k++) {
												$cn_branch_code = mysql_result($result_K2,$k,0);
												$cn_group_code = mysql_result($result_K2,$k,1);
												$cn_group_name = mysql_result($result_K2,$k,2);
												$cn_group_type = mysql_result($result_K2,$k,3);
			
												echo ("<option value='$cn_group_code'>$cn_group_name</option>");
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="asso_shop_code" type="text" required />
                                        </div>
                                    </div>
									<? } ?>
									
									<? } ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="shop_name" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="shop_manager" type="text" />
                                        </div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" type="url" />
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

	
  if($asso_type == "E") {
	$rm_query = "SELECT shop_code FROM client_shop WHERE shop_type = 'on' ORDER BY shop_code DESC";
  } else {
	$rm_query = "SELECT shop_code FROM client_shop WHERE associate = '$key_associate' ORDER BY shop_code DESC";
  }
  $rm_result = mysql_query($rm_query);
  if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_room = @mysql_result($rm_result,0,0);
  
  $new_room1 = substr($max_room,0,1);
  $new_room2 = substr($max_room,1);
  
  $new_room2p = $new_room2 + 1;
  $new_room2_num5 = sprintf("%05d", $new_room2p); // 5자리수
  
  if(!$key_associate) { $key_associate = "0"; }
  
  if($asso_type == "E") {
	  $new_shop_type = "on";
  } else {
	  $new_shop_type = "off";
  }
  
	if($asso_type == "E") {
			$key_associate_tag = "E"; // Online Shop
	} else {
		if($key_associate == "1") {
			$key_associate_tag = "A"; // Associate Store
		} else {
			$key_associate_tag = "B"; // Branch Shop
		}
	}
  
  if($asso_type == "A") {
		$new_shop_code = $asso_shop_code;
  } else {
	if(!$max_room OR $max_room == "") {
		$new_shop_code = "$key_associate_tag"."00001";
	} else {
		$new_shop_code = "$new_room1"."$new_room2_num5";
	}
  }

  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  $shop_name = addslashes($shop_name);
  
  


  ########## Client 정보 테이블에서 Branch Code 추출 #############################
  $br_query = "SELECT branch_code FROM client WHERE client_id = '$key' ORDER BY uid DESC";
  $br_result = mysql_query($br_query);
  if (!$br_result) { error("QUERY_ERROR"); exit; }
  $br_branch_code = @mysql_result($br_result,0,0);
  
  
  // 검토 후 수정요: Sales Manager(2), Branch Manager(3), Regional Manager(4)가 반드시 있어야 하는가의 문제
  $br2_query = "SELECT client_id FROM client WHERE branch_code = '$br_branch_code' AND userlevel > '2' ORDER BY userlevel ASC, uid DESC";
  $br2_result = mysql_query($br2_query);
  if (!$br2_result) { error("QUERY_ERROR"); exit; }
  $br2_gate_code = @mysql_result($br2_result,0,0);
  
	// Area Code
	// $shop_area_code = substr($shop_area,0,3);
  
	$query_AR2 = "SELECT area_code,area_name,area_zone FROM code_area WHERE uid = '$new_area_uid' ORDER BY uid ASC";
	$result_AR2 = mysql_query($query_AR2);
		if (!$result_AR2) { error("QUERY_ERROR"); exit; }
	$shop_area_code = @mysql_result($result_AR2,0,0);
	$shop_area_name = @mysql_result($result_AR2,0,1);
	$shop_area_zone = @mysql_result($result_AR2,0,2);
  

  if($pin_key) {

    $query_M1 = "INSERT INTO client_shop (uid,branch_code,gate,subgate,code,associate,group_code,shop_code,shop_name,shop_type,manager,
          area,area_code,area_uid,email,homepage,userlevel,signdate) values ('','$br_branch_code','$key','$key','$consign_user_code','$key_associate','$group_code',
          '$new_shop_code','$shop_name','$new_shop_type','$shop_manager','$shop_area_name','$shop_area_code','$new_area_uid','$email','$homepage','1',$signdate)";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_shop.php?asso_type=$asso_type&sorting_key=$sorting_key&page=$page'>");
	exit;
  
  }
  }
  
}

}
?>