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
$query = "SELECT uid,room,b_num,b_ord,b_depth,b_loco,b_title,b_type,b_option,b_lagday,b_rows,b_thread,b_permit,onoff,
		show_short,show_intro,show_intro2,show_head,show_foot,host_link,host_link_gate,host_link_url 
		FROM wpage_config WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

   $uid = $row->uid;   
   $room = $row->room;
   $b_num = $row->b_num;
   $b_ord = $row->b_ord;
   $b_depth = $row->b_depth;
   $b_loco = $row->b_loco;
   $b_title = $row->b_title;
		$b_title = stripslashes($b_title);
   $b_type = $row->b_type;
   $b_option = $row->b_option;
   $b_lagday = $row->b_lagday;
   $b_rows = $row->b_rows;
   $b_permit = $row->b_permit;
   $org_onoff = $row->onoff;
   $org_subonoff = $row->onoff_sub2;
   $org_title_img1 = $row->title_img1;
   $org_title_img2 = $row->title_img2;
   $org_title_img2on = $row->title_img2on;
   $show_short = $row->show_short;
   $show_intro = $row->show_intro;
   $show_intro2 = $row->show_intro2;
   $show_head = $row->show_head;
   $show_foot = $row->show_foot;
   $host_link = $row->host_link;
   $host_link_gate = $row->host_link_gate;
   $host_link_room = $row->host_link_url;
   $b_thread = $row->b_thread;
   $memo = $row->memo;
    
    if($show_intro == "1") {
      $show_intro1_chk = "checked";
    } else {
      $show_intro1_chk = "";
    }
    if($show_intro2 == "1") {
      $show_intro2_chk = "checked";
    } else {
      $show_intro2_chk = "";
    }
    
    if($show_head == "1") {
      $show_head_chk = "checked";
    } else {
      $show_head_chk = "";
    }
    if($show_foot == "1") {
      $show_foot_chk = "checked";
    } else {
      $show_foot_chk = "";
    }
    if($show_short == "1") {
      $show_short_chk = "checked";
    } else {
      $show_short_chk = "";
    }
    
    if($host_link == "1") {
      $host_link_chk = "checked";
    } else {
      $host_link_chk = "";
    }

if($org_onoff == "1") {
	$onoff_chk = "checked";
} else {
    $onoff_chk = "";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_01?> &gt; <?=$txt_web_menu_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="website_menu_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="lang" value="<?=$lang?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type='hidden' name="org_loco" value="<?=$b_loco?>">
								<input type="hidden" name="org_room" value="<?=$room?>">
								<input type="hidden" name="b_depth" value="<?=$b_depth?>">
								<input type="hidden" name="uid" value="<?=$uid?>">
								
								
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
									
									
									<? if($b_depth > "1" AND $pcode != "main") { ?>
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
														AND gate = '$key_gate' AND branch_code = '$login_branch'	ORDER BY b_num ASC, b_loco ASC, room ASC";
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
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
												<input type='checkbox' name='show_intro' value='1' <?=$show_intro1_chk?>> <?=$txt_web_menu_loco_intro1?>
												<input type='checkbox' name='show_intro2' value='1' <?=$show_intro2_chk?>> <?=$txt_web_menu_loco_intro2?>
												&nbsp;&nbsp; <input type='checkbox' name='show_head' value='1' <?=$show_head_chk?>> <?=$txt_web_menu_loco_head?>
												&nbsp;&nbsp; <input type='checkbox' name='show_foot' value='1' <?=$show_foot_chk?>> <?=$txt_web_menu_loco_foot?>
												&nbsp;&nbsp; <input type='checkbox' name='show_short' value='1' <?=$show_short_chk?>> <?=$txt_web_menu_loco_short?>
                                        </div>
                                    </div>
									
									<? } ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_12?></label>
										<?
										if($b_depth == "1") {
													if($room == "main") {
														echo ("
														<div class='col-sm-1'>
															<input disabled type=text name='b_ord' value='$b_ord' maxlength=10 class='form-control'>
														</div>
														");
													} else {
														echo ("
														<div class='col-sm-1'>
															<input type=text name='b_ord' value='$b_ord' maxlength=10 class='form-control'>
														</div>
														");
													}
										}
										?>

										<div class="col-sm-3">
												<input readonly type=text name='room' value="<?=$room?>" maxlength=20 class='form-control'>
                                        </div>
										<div class="col-sm-3">
												<input type='checkbox' name='new_onoff' value='1' <?=$onoff_chk?>> <font color=green><?=$txt_web_menu_14?></font>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="b_title" value="<?=$b_title?>" maxlength="60" type="text" required />
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

	

	if($b_depth == "1") {
		$result_q1 = mysql_query("SELECT count(uid) FROM wpage_config WHERE room LIKE '$org_room%' AND b_depth = '2' AND gate = '$key_gate' AND branch_code = '$login_branch'");
		if (!$result_q1) { error("QUERY_ERROR"); exit; }
		$rows_q1 = @mysql_result($result_q1,0,0);
		if ($rows_q1) {
			popup_msg("The Menu you submitted has Sub-category.");
			break;
		}
	} else if($b_depth == "2") {
		$result_q1 = mysql_query("SELECT count(uid) FROM wpage_config WHERE room LIKE '$org_room%' AND b_depth = '3' AND gate = '$key_gate' AND branch_code = '$login_branch'");
		if (!$result_q1) { error("QUERY_ERROR"); exit; }
		$rows_q1 = @mysql_result($result_q1,0,0);
		if ($rows_q1) {
			popup_msg("The Menu you submitted has Sub-category.");
			break;
		}
	}
	
		
		$query_D1  = "DELETE FROM wpage_config WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_D1 = mysql_query($query_D1);
		if (!$result_D1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_menu.php?key_gate=$key_gate'>");
  exit;
  
}

}
?>