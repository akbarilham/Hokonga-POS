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
            <?=$hsm_name_08_01?> &gt; <?=$txt_web_menu_03?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="website_menu_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="lang" value="<?=$lang?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type='hidden' name="org_pcode" value="<?=$pcode?>">
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
									
									<? if($pcode != "main") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_06?></label>
                                        <div class="col-sm-9">
												<select name='b_type' class="form-control" required>
												<? if($pcode == "main") { ?>
												<option value="">Home Page Components</option>
												<? if($b_type == 'islide') { ?>
												<option value="islide" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Slide Show Full Screen</option>
												<? } else {?>
												<option value="islide">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Slide Show Full Screen</option>
												<? } ?>
												
												<? if($b_type == 'icol1') { ?>
												<option value="icol1" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box Full Width</option>
												<? } else {?>
												<option value="icol1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box Full Width</option>
												<? } ?>
												
												<? if($b_type == 'icol3') { ?>
												<option value="icol3" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 3 Columns</option>
												<? } else {?>
												<option value="icol3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'icol4') { ?>
												<option value="icol4" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 4 Columns</option>
												<? } else {?>
												<option value="icol4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Text Box 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'igrid3') { ?>
												<option value="igrid3" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Grid Slide 3 Columns</option>
												<? } else {?>
												<option value="igrid3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Grid Slide 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'imovie') { ?>
												<option value="imovie" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Movie Clip Full Screen</option>
												<? } else {?>
												<option value="imovie">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Movie Clip Full Screen</option>
												<? } ?>
												
												<? if($b_type == 'icontact') { ?>
												<option value="icontact" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Contact Intro Full Screen</option>
												<? } else {?>
												<option value="icontact">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Contact Intro Full Screen</option>
												<? } ?>
												
												<? if($b_type == 'ipricing') { ?>
												<option value="ipricing" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Pricing 1~4 Columns</option>
												<? } else {?>
												<option value="ipricing">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Pricing 1~4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'icountdown') { ?>
												<option value="icountdown" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Countdown 4 Columns</option>
												<? } else {?>
												<option value="icountdown">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Countdown 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'ifullimg') { ?>
												<option value="ifullimg" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Image Background Full Screen</option>
												<? } else {?>
												<option value="ifullimg">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Image Background Full Screen</option>
												<? } ?>
												
												<? if($b_type == 'iteam') { ?>
												<option value="iteam" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Team Intro 3 Columns</option>
												<? } else {?>
												<option value="iteam">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Team Intro 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'itesti') { ?>
												<option value="itesti" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Testimonial Slide Full Width</option>
												<? } else {?>
												<option value="itesti">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Testimonial Slide Full Width</option>
												<? } ?>
												
												<? } else { ?>
												<option value="blog3">Blog</option>
												<? if($b_type == 'blog1') { ?>
												<option value="blog1" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Full Width</option>
												<? } else {?>
												<option value="blog1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Full Width</option>
												<? } ?>
												
												<? if($b_type == 'blog3') { ?>
												<option value="blog3" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 3 Columns</option>
												<? } else {?>
												<option value="blog3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'blog4') { ?>
												<option value="blog4" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 4 Columns</option>
												<? } else {?>
												<option value="blog4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'blogx') { ?>
												<option value="blogx" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Only Text</option>
												<? } else {?>
												<option value="blogx">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Blog Only Text</option>
												<? } ?>
												
												<option value="pofo4">Portfolio</option>
												<? if($b_type == 'pofo2') { ?>
												<option value="pofo2" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 2 Columns</option>
												<? } else {?>
												<option value="pofo2">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 2 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofo3') { ?>
												<option value="pofo3" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 3 Columns</option>
												<? } else {?>
												<option value="pofo3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofo4') { ?>
												<option value="pofo4" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 4 Columns</option>
												<? } else {?>
												<option value="pofo4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofo5') { ?>
												<option value="pofo5" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 5 Columns</option>
												<? } else {?>
												<option value="pofo5">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio 5 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofod1') { ?>
												<option value="pofod1" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description Full Width (List)</option>
												<? } else {?>
												<option value="pofod1">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description Full Width (List)</option>
												<? } ?>
												
												<? if($b_type == 'pofod2') { ?>
												<option value="pofod2" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 2 Columns</option>
												<? } else {?>
												<option value="pofod2">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 2 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofod3') { ?>
												<option value="pofod3" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 3 Columns</option>
												<? } else {?>
												<option value="pofod3">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 3 Columns</option>
												<? } ?>
												
												<? if($b_type == 'pofod4') { ?>
												<option value="pofod4" selected>&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 4 Columns</option>
												<? } else {?>
												<option value="pofod4">&nbsp;&nbsp;&nbsp;&nbsp; &gt; Portfolio Description 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'vod') { ?>
												<option value="vod" selected>VOD</option>
												<? } else {?>
												<option value="vod">VOD</option>
												<? } ?>
												
												<? if($b_type == 'emag') { ?>
												<option value="emag" selected>Magazine</option>
												<? } else {?>
												<option value="emag">Magazine</option>
												<? } ?>
												
												<? if($b_type == 'bbs') { ?>
												<option value="bbs" selected>Message List</option>
												<? } else {?>
												<option value="bbs">Message List</option>
												<? } ?>
												
												<? if($b_type == 'qna') { ?>
												<option value="qna" selected>Q&A</option>
												<? } else {?>
												<option value="qna">Q&A</option>
												<? } ?>
												
												<? if($b_type == 'faq') { ?>
												<option value="faq" selected>FAQ</option>
												<? } else {?>
												<option value="faq">FAQ</option>
												<? } ?>
												
												<? if($b_type == 'week') { ?>
												<option value="week" selected>Weekly Bulletin</option>
												<? } else {?>
												<option value="week">Weekly Bulletin</option>
												<? } ?>
												
												<? if($b_type == 'time') { ?>
												<option value="time" selected>Timeline</option>
												<? } else {?>
												<option value="time">Timeline</option>
												<? } ?>
												
												<? if($b_type == 'team') { ?>
												<option value="team" selected>Team Intro 4 Columns</option>
												<? } else {?>
												<option value="team">Team Intro 4 Columns</option>
												<? } ?>
												
												<? if($b_type == 'contact') { ?>
												<option value="contact" selected>Contact (Google Map)</option>
												<? } else {?>
												<option value="contact">Contact (Google Map)</option>
												<? } ?>
												
												<? if($b_type == 'blnk') { ?>
												<option value="blnk" selected><?=$txt_web_menu_type_blnk?></option>
												<? } else {?>
												<option value="blnk"><?=$txt_web_menu_type_blnk?></option>
												<? } ?>
												
												<? if($b_type == 'link') { ?>
												<option value="link" selected><?=$txt_web_menu_type_link?></option>
												<? } else {?>
												<option value="link"><?=$txt_web_menu_type_link?></option>
												<? } ?>
	
												<? if($b_depth < "3") { ?>
												<? if($b_type == 'x') { ?>
												<option value='x' selected><?=$txt_web_menu_type_x?></option>
												<? } else {?>
												<option value='x'><?=$txt_web_menu_type_x?></option>
												<? } ?>
												<? } ?>
												
												<? } ?>
												</select> 
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_07?></label>
                                        <div class="col-sm-9">
												<select name='b_option' class="form-control">
												<? if($b_option == "0") { ?>
												<option value="0" selected><?=$txt_web_menu_opt_0?></option>
												<? } else {?>
												<option value="0"><?=$txt_web_menu_opt_0?></option>
												<? } ?>

												<? if($b_option == "1") { ?>
												<option value="1" selected><?=$txt_web_menu_opt_1?></option>
												<? } else {?>
												<option value="1"><?=$txt_web_menu_opt_1?></option>
												<? } ?>

												<!--
												<? if($b_option == "2") { ?>
												<option value="2" selected><?=$txt_web_menu_opt_2?></option>
												<? } else {?>
												<option value="2"><?=$txt_web_menu_opt_2?></option>
												<? } ?>
												-->

												<? if($b_option == "3") { ?>
												<option value="3" selected><?=$txt_web_menu_opt_3?></option>
												<? } else {?>
												<option value="3"><?=$txt_web_menu_opt_3?></option>
												<? } ?>

												<? if($b_option == "4") { ?>
												<option value="4" selected><?=$txt_web_menu_opt_4?></option>
												<? } else {?>
												<option value="4"><?=$txt_web_menu_opt_4?></option>
												<? } ?>

												<? if($b_option == "5") { ?>
												<option value="5" selected><?=$txt_web_menu_opt_5?></option>
												<? } else {?>
												<option value="5"><?=$txt_web_menu_opt_5?></option>
												<? } ?>

												<? if($b_option == "6") { ?>
												<option value="6" selected><?=$txt_web_menu_opt_6?></option>
												<? } else {?>
												<option value="6"><?=$txt_web_menu_opt_6?></option>
												<? } ?>

												<? if($b_option == "8") { ?>
												<option value="8" selected><?=$txt_web_menu_opt_8?></option>
												<? } else {?>
												<option value="8"><?=$txt_web_menu_opt_8?></option>
												<? } ?>
												</select>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_15?></label>
                                        <div class="col-sm-2">
												<select name='b_lagday' class="form-control">
												<? if($b_lagday == "1") { ?>
												<option value="1" selected>1 <?=$txt_web_menu_08d?></option>
												<? } else {?>
												<option value="1">1 <?=$txt_web_menu_08d?></option>
												<? } ?>

												<? if($b_lagday == "2") { ?>
												<option value="2" selected>2 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="2">2 <?=$txt_web_menu_08dp?></option>
												<? } ?>

												<? if($b_lagday == "3") { ?>
												<option value="3" selected>3 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="3">3 <?=$txt_web_menu_08dp?></option>
												<? } ?>

												<? if($b_lagday == "4") { ?>
												<option value="4" selected>4 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="4">4 <?=$txt_web_menu_08dp?></option>
												<? } ?>

												<? if($b_lagday == "5") { ?>
												<option value="5" selected>5 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="5">5 <?=$txt_web_menu_08dp?></option>
												<? } ?>

												<? if($b_lagday == "6") { ?>
												<option value="6" selected>6 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="6">6 <?=$txt_web_menu_08dp?></option>
												<? } ?>

												<? if($b_lagday == "7") { ?>
												<option value="7" selected>7 <?=$txt_web_menu_08dp?></option>
												<? } else {?>
												<option value="7">7 <?=$txt_web_menu_08dp?></option>
												<? } ?>
												</select>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_16?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="b_rows" value="<?=$b_rows?>" maxlength="2" style="text-align: center" type="text" required />
                                        </div>
										<div class="col-sm-7">
												<?=$txt_web_menu_082?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_19?></label>
                                        <div class="col-sm-9">
												<? if($b_thread == "DESC") { ?>
												<input type=radio name="b_thread" value="DESC" checked> <?=$txt_web_menu_191?> &nbsp;&nbsp; 
												<? } else { ?>
												<input type=radio name="b_thread" value="DESC"> <?=$txt_web_menu_191?> &nbsp;&nbsp; 
												<? } ?>
    
												<? if($b_thread == "ASC") { ?>
												<input type=radio name="b_thread" value="ASC" checked> <?=$txt_web_menu_192?> &nbsp;&nbsp; 
												<? } else { ?>
												<input type=radio name="b_thread" value="ASC"> <?=$txt_web_menu_192?> &nbsp;&nbsp; 
												<? } ?>
    
												<? if($b_thread == "RAND") { ?>
												<input type=radio name="b_thread" value="RAND" checked> <?=$txt_web_menu_193?> &nbsp;&nbsp; 
												<? } else { ?>
												<input type=radio name="b_thread" value="RAND"> <?=$txt_web_menu_193?> &nbsp;&nbsp; 
												<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_17?></label>
                                        <div class="col-sm-9">
												<select name='b_permit' class="form-control">
												<? if($b_permit == "0") { ?>
												<option value="0" selected>0 - <?=$txt_web_menu_permit_0?></option>
												<? } else {?>
												<option value="0">0 - <?=$txt_web_menu_permit_0?></option>
												<? } ?>

												<? if($b_permit == "1") { ?>
												<option value="1" selected>1 - <?=$txt_web_menu_permit_1?></option>
												<? } else {?>
												<option value="1">1 - <?=$txt_web_menu_permit_1?></option>
												<? } ?>

												<? if($b_permit == "2") { ?>
												<option value="2" selected>2 - <?=$txt_web_menu_permit_2?></option>
												<? } else {?>
												<option value="2">2 - <?=$txt_web_menu_permit_2?></option>
												<? } ?>

												<? if($b_permit == "3") { ?>
												<option value="3" selected>3 - <?=$txt_web_menu_permit_3?></option>
												<? } else {?>
												<option value="3">3 - <?=$txt_web_menu_permit_3?></option>
												<? } ?>
	
												<? if($b_permit == "4") { ?>
												<option value="4" selected>4 - <?=$txt_web_menu_permit_4?></option>
												<? } else {?>
												<option value="4">4 - <?=$txt_web_menu_permit_4?></option>
												<? } ?>

												<? if($b_permit == "5") { ?>
												<option value="5" selected>5 - <?=$txt_web_menu_permit_5?></option>
												<? } else {?>
												<option value="5">5 - <?=$txt_web_menu_permit_5?></option>
												<? } ?>

												<? if($b_permit == "6") { ?>
												<option value="6" selected>6 - <?=$txt_web_menu_permit_6?></option>
												<? } else {?>
												<option value="6">6 - <?=$txt_web_menu_permit_6?></option>
												<? } ?>
												</select> 
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									<? if($b_depth > "1" AND $pcode != "main") { ?>
									<? if($b_type == "alb1" OR $b_type == "alb5") { ?>
										
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_20?></label>
                                        <div class="col-sm-3">
												<select name="host_link_gate" class="form-control">
												<option value="">:: <?=$txt_comm_frm19?></option>
												<?
												$queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1'";
												$resultC = mysql_query($queryC);
												$total_recordC = mysql_result($resultC,0,0);

												$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' ORDER BY userlevel DESC";
												$resultD = mysql_query($queryD);
      
												for($i = 0; $i < $total_recordC; $i++) {
													$left_var_id = mysql_result($resultD,$i,0);
													$left_var_name = mysql_result($resultD,$i,1);
													$left_var_gatepage = mysql_result($resultD,$i,2);
        
													if($host_link_gate == $left_var_id) {
														echo ("<option value='$left_var_id' selected>[$left_var_id] $left_var_gatepage</option>");
													} else {
														echo ("<option value='$left_var_id'>[$left_var_id] $left_var_gatepage</option>");
													}
												}
												?>
												</select>
                                        </div>
										<div class="col-sm-3">
												<input type="text" name="host_link_room" maxlength=120 value="<?=$host_link_room?>" class="form-control"> 
										</div>
										<div class="col-sm-3">
												<input type="checkbox" name="host_link" value="1" <?=$host_link_chk?>> <font color=blue><?=$txt_web_menu_22?></font>
										</div>
                                    </div>
									
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_21?></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="host_link_room" maxlength=120 value="<?=$host_link_room?>" class="form-control"> 
                                        </div>
										<div class="col-sm-6">
											<input type="checkbox" name="host_link" value="1" <?=$host_link_chk?>> <font color=blue><?=$txt_web_menu_22?></font>
										</div>
                                    </div>
									
									<? } ?>
									<? } ?>
									

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
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
  if(!$show_intro2) { $show_intro2 = "0"; }
  if(!$show_foot) { $show_foot = "0"; }
  if(!$show_head) { $show_head = "0"; }
  if(!$show_short) { $show_short = "0"; }
  
  $b_title = addslashes($b_title);

  if($b_depth == "1") {
	if($org_pcode == "main") {
		$query_M1 = "UPDATE wpage_config SET b_title = '$b_title', onoff = '$new_onoff' WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_M1 = mysql_query($query_M1);
		if (!$result_M1) { error("QUERY_ERROR"); exit; }
	} else {
		$query_M1 = "UPDATE wpage_config SET b_ord = '$b_ord', b_title = '$b_title', b_type = '$b_type', 
			b_option = '$b_option', b_lagday = '$b_lagday', b_rows = '$b_rows', b_permit = '$b_permit', b_thread = '$b_thread', 
			onoff = '$new_onoff' WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_M1 = mysql_query($query_M1);
		if (!$result_M1) { error("QUERY_ERROR"); exit; }
		
		$query_M2 = "UPDATE wpage_content SET b_type = '$b_type' WHERE room = '$org_room' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_M2 = mysql_query($query_M2);
		if(!$result_M2) { error("QUERY_ERROR"); exit; }
	}
  } else {
		$query_M1 = "UPDATE wpage_config SET b_title = '$b_title', b_type = '$b_type', 
			b_option = '$b_option', b_lagday = '$b_lagday', b_rows = '$b_rows', b_permit = '$b_permit', b_thread = '$b_thread', 
			onoff = '$new_onoff', show_short = '$show_short', show_intro = '$show_intro', show_intro2 = '$show_intro2', show_head = '$show_head', show_foot = '$show_foot', 
			host_link = '$host_link', host_link_url = '$host_link_room', host_link_gate = '$host_link_gate' 
			WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_M1 = mysql_query($query_M1);
		if (!$result_M1) { error("QUERY_ERROR"); exit; }
		
		$query_M2 = "UPDATE wpage_content SET b_type = '$b_type' WHERE room = '$org_room' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result_M2 = mysql_query($query_M2);
		if(!$result_M2) { error("QUERY_ERROR"); exit; }
  }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_menu.php?key_gate=$key_gate'>");
  exit;
  
}

}
?>