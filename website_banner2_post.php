<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }
if(!$key_gate) { $key_gate = $client_id; }

$mmenu = "website";
$smenu = "website_banner2";

if(!$step_next) {
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Work, Bootstrap, Responsive">
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


// Save Directory
if($client_id == "host") {
	$savedir = "user_file";
} else {
	// $savedir = "user/$client_id/user_file";
	$savedir = "user_file";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_032?> &gt; <?=$txt_web_banner2_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="website_banner2_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type='hidden' name='bn_key' value="<?=$bn_key?>">
								
								
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' 
													ORDER BY userlevel DESC";
											$resultD = mysql_query($queryD);

											echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo ("<option value=\"\">:: $txt_comm_frm24</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$web_client_id = mysql_result($resultD,$i,0);
												$web_client_name = mysql_result($resultD,$i,1);
												$web_client_homepage = mysql_result($resultD,$i,2);
        
												if($web_client_id == $key_gate) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$PHP_SELF?key_gate=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_05?></label>
                                        <div class="col-sm-9">
											<?
                                            $queryA = "SELECT count(uid) FROM wpage_banner1 WHERE gate = '$key_gate' AND branch_code = '$login_branch'";
											$resultA = mysql_query($queryA);
											$total_recordA = mysql_result($resultA,0,0);

											$queryB = "SELECT b_id,b_type FROM wpage_banner1 WHERE gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY b_id ASC";
											$resultB = mysql_query($queryB);
		
											// value of $b_id
		
											echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo ("<option value='$PHP_SELF?b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate'>:: Select Banner Image</option>");

											for($i = 0; $i < $total_recordA; $i++) {
												$bn_id = mysql_result($resultB,$i,0);
												$bn_type = mysql_result($resultB,$i,1);
												
												if($bn_type == "2") {
													$bn_type_txt = "GIF (Animation)";
												} else if($bn_type == "3") {
													$bn_type_txt = "PNG";
												} else {
													$bn_type_txt = "JPG";
												}
        
												if($bn_id == $bn_key) {
													echo("<option value='$PHP_SELF?b_loco=$b_loco&b_room=$b_room&bn_key=$bn_id&key_gate=$key_gate' selected>$bn_id :: $bn_type_txt</option>");
												} else {
													echo("<option value='$PHP_SELF?b_loco=$b_loco&b_room=$b_room&bn_key=$bn_id&key_gate=$key_gate'>$bn_id :: $bn_type_txt</option>");
												}
											}
											echo ("</select>");
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_05b?></label>
                                        <div class="col-sm-6">
											<?
                                            $queryC = "SELECT count(uid) FROM wpage_config 
													WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '1' AND lang = '$lang'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT b_loco,b_title FROM wpage_config 
													WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '1' AND lang = '$lang'
														ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
											$resultD = mysql_query($queryD);
		
											echo ("<select name='b_loco' class='form-control'>
											<option value='top'>-- top : Intro Top Banner (top)</option>
											<option value='main_prev'>-- A : The Previous Edition (main_prev)
											<option value='main_intro'>-- Intro Stripe Banner (main_intro)</option></option>");
		
	
											// left banner
											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
													$menu_name = stripslashes($menu_name);
			
												if($b_loco == "main_left" AND $b_room == $menu_code) {
													echo("<option value='main_left|$menu_code' selected>-- B : Stripe Banners - $menu_name</option>");
												} else {
													echo("<option value='main_left|$menu_code'>-- B : Stripe Banners - $menu_name</option>");
												}
			
												// Sub menu
												$query2C = "SELECT count(uid) FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'";
												$result2C = mysql_query($query2C);
												$total_record2C = mysql_result($result2C,0,0);

												$query2D = "SELECT b_loco,b_title,room FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'
														ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
												$result2D = mysql_query($query2D);
			
												for($i2 = 0; $i2 < $total_record2C; $i2++) {
													$smenu_code = mysql_result($result2D,$i2,0);
													$smenu_name = mysql_result($result2D,$i2,1);
														$smenu_name = stripslashes($smenu_name);
													$smenu_room = mysql_result($result2D,$i2,2);
			
													if($b_loco == "main_left" AND $b_room == $smenu_room) {
														echo("<option value='main_left|$smenu_room' selected>-- B : Stripe Banners - $menu_name &gt; $smenu_name</option>");
													} else {
														echo("<option value='main_left|$smenu_room'>-- B : Stripe Banners - $menu_name &gt; $smenu_name</option>");
													}
			
												}
			
											}
		
											echo ("
											<option value='main_mid'>-- C : Banner / Video Clip (main_mid)</option>");
		
		
											// header banner
											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
													$menu_name = stripslashes($menu_name);
			
												if($b_loco == "top_logo" AND $b_room == $menu_code) {
													echo("<option value='top_logo|$menu_code' selected>-- D : Header Banners - $menu_name</option>");
												} else {
													echo("<option value='top_logo|$menu_code'>-- D : Header Banners - $menu_name</option>");
												}
			
												// Sub menu
												$query3C = "SELECT count(uid) FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'";
												$result3C = mysql_query($query3C);
												$total_record3C = mysql_result($result3C,0,0);

												$query3D = "SELECT b_loco,b_title,room FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'
														ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
												$result3D = mysql_query($query3D);
			
												for($i3 = 0; $i3 < $total_record3C; $i3++) {
													$smenu_code3 = mysql_result($result3D,$i3,0);
													$smenu_name3 = mysql_result($result3D,$i3,1);
														$smenu_name3 = stripslashes($smenu_name3);
													$smenu_room3 = mysql_result($result3D,$i3,2);
			
													if($b_loco == "top_logo" AND $b_room == $smenu_room3) {
														echo("<option value='top_logo|$smenu_room3' selected>-- D : Header Banners - $menu_name &gt; $smenu_name3</option>");
													} else {
														echo("<option value='top_logo|$smenu_room3'>-- D : Header Banners - $menu_name &gt; $smenu_name3</option>");
													}
			
												}
			
											}
		
											echo ("
											<option value='main_midf1'>-- E : Fixed Banner 1 / Survey (main_midf1)</option>
											<option value='main_midf2'>-- F : Fixed Banner 2 (main_midf2)</option>
											<!-- option value='main_midt1'>-- G : Multiple Contents Banners 1 (main_midt1)</option -->
											<option value='main_midt2'>-- H : Multiple Contents Banners (main_midt2)</option>");
		
		
											// right banner
											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
													$menu_name = stripslashes($menu_name);
			
												if($b_loco == "main_right" AND $b_room == $menu_code) {
													echo("<option value='main_right|$menu_code' selected>-- I : Right Banners - $menu_name</option>");
												} else {
													echo("<option value='main_right|$menu_code'>-- I : Right Banners - $menu_name</option>");
												}
			
												// Sub menu
												$query4C = "SELECT count(uid) FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'";
												$result4C = mysql_query($query4C);
												$total_record4C = mysql_result($result4C,0,0);

												$query4D = "SELECT b_loco,b_title,room FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'
														ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
												$result4D = mysql_query($query4D);
			
												for($i4 = 0; $i4 < $total_record4C; $i4++) {
													$smenu_code4 = mysql_result($result4D,$i4,0);
													$smenu_name4 = mysql_result($result4D,$i4,1);
														$smenu_name4 = stripslashes($smenu_name4);
													$smenu_room4 = mysql_result($result4D,$i4,2);
			
													if($b_loco == "main_right" AND $b_room == $smenu_room4) {
														echo("<option value='main_right|$smenu_room4' selected>-- I : Right Banners - $menu_name &gt; $smenu_name4</option>");
													} else {
														echo("<option value='main_right|$smenu_room4'>-- I : Right Banners - $menu_name &gt; $smenu_name4</option>");
													}
			
												}
			
											}
		
		
											echo ("
											<option value='intro'>-- intro : Introduction Page Screen</option>
											<option value='popup'>-- Popup Layer</option>
											</select>");
											?>
		
                                        </div>

										<div class="col-sm-1">Arrange</div>
										<div class="col-sm-2">
											<input type='text' name='b_ord' maxlength=5 value='1' class='form-control' style='text-align: center'>
										</div>
                                    </div>
									
									<?
									if($bn_key) {

									$query_key = "SELECT b_type FROM wpage_banner1 WHERE b_id = '$bn_key' AND gate = '$key_gate' AND branch_code = '$login_branch'";
									$result_key = mysql_query($query_key);
										if(!$result_key) { error("QUERY_ERROR"); exit; }
									$row_key = mysql_fetch_object($result_key);

									$bk_type = $row_key->b_type;

									if($bk_type == "2") {
										$bk_type_ext = "gif";
									} else if($bk_type == "3") {
										$bk_type_ext = "png";
									} else {
										$bk_type_ext = "jpg";
									}
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
                                            <image src='$savedir/banner_{$bn_key}.{$bk_type_ext}' border=0>
                                        </div>
                                    </div>");
									
									}
									?>
									
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_08?></label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" name="b_url" placeholder="http://">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_06b?></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="user_id">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Image Alt</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="b_alt">
                                        </div>
										<div class="col-sm-3"><?=$txt_web_banner2_09?></div>
										<div class="col-sm-3">
                                            <input type="color" class="form-control" name="b_bgcolor">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Target</label>
                                        <div class="col-sm-3">
												<select name='b_targetA' class="form-control">
												<option value='_top'>_top</option>
												<option value='_blank'>_blank</option>
												<option value='_self'>_self</option>
												<option value='_new'>_new</option>
												<option value='1'>Custom</option>
												</select>
                                        </div>
										<div class="col-sm-3"><?=$txt_web_banner2_10?></div>
										<div class="col-sm-3">
                                            <input type="text" class="form-control" name='b_targetB' maxlength="20">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_11?></label>
                                        <div class="col-sm-9">
                                            <input type='radio' name='b_show' value='1' checked> <font color=blue>ON</font> &nbsp; 
											<input type='radio' name='b_show' value='0'> <font color=red>OFF</font>
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

	

  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


	$signdate = time();
	$date1 = date("Ymd",$signdate);
	$date2 = date("His",$signdate);
	$dates = "$date1"."$date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
  $b_loco_xpd = explode("|",$b_loco);
  $new_b_loco = $b_loco_xpd[0];
  $new_b_room = $b_loco_xpd[1];


  if($pin_key) {
  
		$result_mx = mysql_query("SELECT max(uid) FROM wpage_banner2");
		if(!$result_mx) { error("QUERY_ERROR"); exit; }
		$row_mx = mysql_fetch_row($result_mx);
		if($row_mx[0]) {
			$new_uid = $row_mx[0] + 1;
		} else {
			$new_uid = 1;
		}
		
		if($b_targetA == "1") {
			$b_target = $b_targetB;
		} else {
			$b_target = $b_targetA;
		}

		if(!$b_ord) {
			$b_ord = "1";
		}

    $query_M1  = "INSERT INTO wpage_banner2 (uid,user_id,b_id,b_loco,b_room,b_ord,b_alt,b_url,b_target,b_show,bgcolor,
				lang,signdate,upd_date,gate,branch_code) VALUES ('$new_uid','$user_id','$bn_key','$new_b_loco','$new_b_room','$b_ord',
				'$b_alt','$b_url','$b_target','$b_show','$b_bgcolor','$lang','$dates','$dates','$key_gate','$login_branch')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_banner2.php?key_gate=$key_gate'>");
  exit;
  
  }
  
  }
  
}

}
?>