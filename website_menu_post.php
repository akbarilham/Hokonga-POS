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
$smenu = "website_menu";

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


$ord_query = "SELECT b_ord FROM wpage_config WHERE b_depth = '1' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY b_ord DESC";
$ord_result = mysql_query($ord_query);
if (!$ord_result) { error("QUERY_ERROR"); exit; }
$max_ord = @mysql_result($ord_result,0,0);

$max_ord1 = substr($max_ord,0,1);
$max_ord2 = substr($max_ord,1,2);
	$max_ord2p = $max_ord2 + 1;

if($max_ord2p < 10) { $max_ord2pd = "0"."$max_ord2p"; } else { $max_ord2pd = $max_ord2p; }
$new_max_ord = "$max_ord1"."$max_ord2pd";



$cnt_query = "SELECT count(room) FROM wpage_config WHERE room = 'main' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch'";
$cnt_result = mysql_query($cnt_query);
if (!$cnt_result) { error("QUERY_ERROR"); exit; }
$cnt_main = @mysql_result($cnt_result,0,0);
	
if ($cnt_main < '1') {
	$new_menu_id = "main";
} else {

if($b_depth == "3") {
  $rm_query = "SELECT room FROM wpage_config 
			WHERE b_loco = '$pcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '3' AND room LIKE '$room%' 
			ORDER BY room DESC";
  $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
    $max_room = @mysql_result($rm_result,0,0);
  
    $exp_room = explode("_",$max_room);
    $exp_room1 = $exp_room[1];
    $exp_room2 = substr($exp_room1,4);
    $new_room_num1 = $exp_room2 + 1;
    if($new_room_num1 < 10) { $new_room_num = "0".$new_room_num1; } else { $new_room_num = $new_room_num1; }
  
  if($max_room == "") {
    $new_menu_id = $room ."01";
  } else {
    $new_menu_id = $room ."$new_room_num";
  }
} else if($b_depth == "2") {
  $rm_query = "SELECT room FROM wpage_config 
			WHERE b_loco = '$pcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '2' ORDER BY room DESC";
  $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
    $max_room = @mysql_result($rm_result,0,0);
  
    $exp_room = explode("_",$max_room);
    $exp_room1 = $exp_room[1];
    $exp_room2 = substr($exp_room1,2);
    $new_room_num1 = $exp_room2 + 1;
    if($new_room_num1 < 10) { $new_room_num = "0".$new_room_num1; } else { $new_room_num = $new_room_num1; }
  
  if($max_room == "") {
    $new_menu_id = $pcode . "_"."$lang"."01";
  } else {
    $new_menu_id = $pcode . "_"."$lang"."$new_room_num";
  }
} else {
    $new_menu_id = "";
}
}


if($b_depth > "1") {
	$b_type_bbs_chk = "selected";
	$b_type_x_chk = "";
} else {
	$b_type_bbs_chk = "";
	$b_type_x_chk = "selected";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_01?> &gt; <?=$txt_web_menu_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="website_menu_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="lang" value="<?=$lang?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type="hidden" name="org_room" value="<?=$new_menu_id?>">
								<input type="hidden" name="b_depth" value="<?=$b_depth?>">
								<input type="hidden" name="new_max_ord" value="<?=$new_max_ord?>">
								
								
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
											if (!$resultD) { error("QUERY_ERROR"); exit; }

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
									
									
									<? if($b_depth > "1") { ?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">
											<?
											if($b_depth > "2") { 
												echo ("$txt_web_menu_131 - $txt_web_menu_132"); 
											} else {
												echo ("$txt_web_menu_131");
											}
											?>
										</label>
                                        <div class="col-sm-3">
												<?
												$queryC = "SELECT count(uid) FROM wpage_config WHERE lang = '$lang' AND b_depth = '1' 
														AND gate = '$key_gate' AND branch_code = '$login_branch'";
												$resultC = mysql_query($queryC);
												$total_recordC = @mysql_result($resultC,0,0);

												$queryD = "SELECT room,b_loco,b_title FROM wpage_config WHERE lang = '$lang' AND b_depth = '1' 
														AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY b_num ASC, b_loco ASC, room ASC";
												$resultD = mysql_query($queryD);
												?>

												<select name="b_loco" class="form-control">
												<?
												for($i = 0; $i < $total_recordC; $i++) {
													$menu_room = mysql_result($resultD,$i,0);
													$menu_loco = mysql_result($resultD,$i,1);
													$menu_title = mysql_result($resultD,$i,2);
														$menu_title = stripslashes($menu_title);
        
													if($menu_loco == $pcode) {
														$menu_slct = "selected"; 
														$menu_dis = "";
													} else {
														$menu_slct = ""; 
														$menu_dis = "disabled";
													}
													echo("<option $menu_dis value='$menu_loco' $menu_slct>&gt; $menu_title ($menu_loco)</option>");
												}
												?>
												</select>
                                        </div>
										
										<div class="col-sm-3">
												<?
												if($b_depth == "3") {
      
													$queryE1 = "SELECT count(uid) FROM wpage_config 
																WHERE lang = '$lang' AND b_depth = '2' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$pcode'";
													$resultE1 = mysql_query($queryE1);
													$total_recordE1 = @mysql_result($resultE1,0,0);

													$queryE2 = "SELECT room,b_title FROM wpage_config 
																WHERE lang = '$lang' AND b_depth = '2' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$pcode'
																ORDER BY b_num ASC, b_loco ASC, room ASC";
													$resultE2 = mysql_query($queryE2);
      
													echo ("<select name='b_loco_sub' class='form-control'>");
      
													for($j = 0; $j < $total_recordE1; $j++) {
														$smenu_code = mysql_result($resultE2,$j,0);
														$smenu_name = mysql_result($resultE2,$j,1);
															$smenu_name = stripslashes($smenu_name);
        
														if($smenu_code == $room) {
															$smenu_slct = "selected"; 
															$smenu_dis = "";
														} else {
															$smenu_slct = ""; 
															$smenu_dis = "disabled";
														}
														echo("<option $smenu_dis value='$smenu_code' $smenu_slct>&gt; $smenu_name ($smenu_code)</option>");
													}
      
													echo ("</select>");
      
												}
												?>
                                        </div>
										
										<div class="col-sm-3">
                                            <?
											echo ("<input type='checkbox' name='onoff' value='1' checked> <font color=green>$txt_web_menu_14</font>");
											?>
                                        </div>
                                    </div>
									<? } ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_12?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="room" value="<?=$new_menu_id?>" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="b_title" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
									<? if ($cnt_main > '0') { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_06?></label>
                                        <div class="col-sm-9">
												<select name='b_type' class="form-control">
												<? if($pcode == "main") { ?>
												<option value="">Home Page Components</option>
												<option value="islide">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Slide Show Full Screen</option>
												<option value="icol1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box Full Width</option>
												<option value="icol3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 3 Columns</option>
												<option value="icol4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 4 Columns</option>
												<option value="igrid3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Grid Slide 3 Columns</option>
												<option value="imovie">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Movie Clip Full Screen</option>
												<option value="icontact">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Contact Intro Full Screen</option>
												<option value="ipricing">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Pricing 1~4 Columns</option>
												<option value="icountdown">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Countdown 4 Columns</option>
												<option value="ifullimg">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Image Background Full Screen</option>
												<option value="iteam">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Team Intro 3 Columns</option>
												<option value="itesti">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Testimonial Slide Full Width</option>
												
												<? } else { ?>
												<option value="blog3">Blog</option>
												<option value="blog1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Full Width</option>
												<option value="blog3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 3 Columns</option>
												<option value="blog4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 4 Columns</option>
												<option value="blogx">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Only Text</option>
												
												<option value="pofo4">Portfolio</option>
												<option value="pofo2">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 2 Columns</option>
												<option value="pofo3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 3 Columns</option>
												<option value="pofo4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 4 Columns</option>
												<option value="pofo5">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 5 Columns</option>
												<option value="pofod1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description Full Width (List)</option>
												<option value="pofod2">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 2 Columns</option>
												<option value="pofod3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 3 Columns</option>
												<option value="pofod4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 4 Columns</option>
												
												<option value="vod">VOD</option>
												<option value="emag">Magazine</option>
												<option value="bbs" <?=$b_type_bbs_chk?>>Message List</option>
												<option value="qna">Q&A</option>
												<option value="faq">FAQ</option>
												<option value="week">Weekly Bulletin</option>
												<option value="time">Timeline</option>
												<option value="team">Team Intro 4 Columns</option>
												<option value="contact">Contact (Google Map)</option>
												
												<option value="blnk"><?=$txt_web_menu_type_blnk?></option>
												<option value="link"><?=$txt_web_menu_type_link?></option>

												<?
												if($b_depth < "3") {
													echo ("<option value='x' $b_type_x_chk>$txt_web_menu_type_x</option>");
												}
												?>
												
												<? } ?>
												</select> 
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_07?></label>
                                        <div class="col-sm-9">
												<select name='b_option' class="form-control">
												<option value='0'><?=$txt_web_menu_opt_0?></option>
												<option value='1' selected><?=$txt_web_menu_opt_1?></option>
												<option value='3'><?=$txt_web_menu_opt_3?></option>
												<option value='4'><?=$txt_web_menu_opt_4?></option>
												<option value='5'><?=$txt_web_menu_opt_5?></option>
												<option value='6'><?=$txt_web_menu_opt_6?></option>
												<option value='8'><?=$txt_web_menu_opt_8?></option>
												</select>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_15?></label>
                                        <div class="col-sm-2">
												<select name='b_lagday' class="form-control">
												<option value='1' selected>1 <?=$txt_web_menu_08d?></option>
												<option value='2'>2 <?=$txt_web_menu_08dp?></option>
												<option value='3'>3 <?=$txt_web_menu_08dp?></option>
												<option value='4'>4 <?=$txt_web_menu_08dp?></option>
												<option value='5'>5 <?=$txt_web_menu_08dp?></option>
												<option value='6'>6 <?=$txt_web_menu_08dp?></option>
												<option value='7'>7 <?=$txt_web_menu_08dp?></option>
												</select>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_16?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="b_rows" value="20" maxlength="2" style="text-align: center" type="text" required />
                                        </div>
										<div class="col-sm-7">
												<?=$txt_web_menu_082?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_17?></label>
                                        <div class="col-sm-9">
												<select name='b_permit' class="form-control">
												<option value='0'>0 - <?=$txt_web_menu_permit_0?></option>
												<option value='1'>1 - <?=$txt_web_menu_permit_1?></option>
												<option value='2' selected>2 - <?=$txt_web_menu_permit_2?></option>
												<option value='3'>3 - <?=$txt_web_menu_permit_3?></option>
												<option value='4'>4 - <?=$txt_web_menu_permit_4?></option>
												<option value='5'>5 - <?=$txt_web_menu_permit_5?></option>
												<option value='6'>6 - <?=$txt_web_menu_permit_6?></option>
												</select> 
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

	

  if($b_depth == "") {	$b_depth = "1"; }
  if(!$b_rows) { $b_rows = "20"; }
  if($b_option == "") {	$b_option = "0"; }
  if($b_lagday == "") {	$b_lagday = "1"; }
  if($b_permit == "") {	$b_permit = "1"; }
  if(!$show_intro) { $show_intro = "0"; }
  if(!$show_foot) { $show_foot = "0"; }
  if(!$show_head) { $show_head = "0"; }
  if(!$show_short) { $show_short = "0"; }
  
  $b_title = addslashes($b_title);


  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');


	$result_q1 = mysql_query("SELECT count(room) FROM wpage_config WHERE room = '$room' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch'");
	if (!$result_q1) { error("QUERY_ERROR"); exit; }
	$rows_q1 = @mysql_result($result_q1,0,0);
	if ($rows_q1) {
		popup_msg("The Menu Code you submitted exists already.");
		break;
	}

	// b_num
	$result_q2 = mysql_query("SELECT max(uid) FROM wpage_config",$dbconn);
	if (!$result_q2) { error("QUERY_ERROR"); exit; }
	$row_q2 = mysql_fetch_row($result_q2);
	if($row_q2[0]) {
		$new_uid = $row_q2[0] + 1;
	} else {
		$new_uid = 1;
	}
  
  
  if($pin_key) {
  
	

    if($org_room == "main") {
			$new_room = "main";
			$new_b_loco = "main";
			$new_b_ord = "A01";
	} else {
		if(!$b_loco) {
			$new_room = $room;
			$new_b_loco = $room;
			$new_b_ord = "$new_max_ord";
		} else {
			$new_room = $room;
			$new_b_loco = $b_loco;
			$new_b_ord = "$new_max_ord";
		}
	}
	
	if($org_room == "main") {
			$new_onoff = "1";
	} else {
		if(!$onoff) {
			$new_onoff = "0";
		} else {
			$new_onoff = $onoff;
		}
	}
	
	if($b_type == "blnk") {
		$new_b_thread = "ASC";
	} else {
		$new_b_thread = "DESC";
	}
	if($b_type == "alb1" OR $b_type == "alb2" OR $b_type == "alb5" OR $b_type == "albx") {
		$b_option_new = "1";
	} else {
		$b_option_new = $b_option;
	}


	$query_M1  = "INSERT INTO wpage_config (uid, room, b_num, b_ord, b_depth, b_loco, b_title, b_type, b_option, b_lagday, b_rows, b_permit, 
          b_thread, onoff, lang, gate, branch_code) VALUES ('','$new_room', '$new_uid', '$new_b_ord', '$b_depth', '$new_b_loco', '$b_title', '$b_type', 
		  '$b_option_new', '$b_lagday', '$b_rows', '$b_permit', '$new_b_thread', '$new_onoff','$lang','$key_gate','$login_branch')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_menu.php?key_gate=$key_gate'>");
  exit;
  
  }
  }


}

}
?>