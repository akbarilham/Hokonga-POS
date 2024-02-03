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
$smenu = "website_content";

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
$query = "SELECT uid,room,name,head,subject,subtitle,comment,m_html,m_nlbr,m_filetype,userfile,m_imgdsp,m_caption,img_count,signdate,
			display,media_chk,media_link FROM wpage_content WHERE uid = $uid AND gate = '$key_gate' AND branch_code = '$login_branch'";
$result = mysql_query($query,$dbconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}

$new_uid  = mysql_result($result,0,0);
$my_room = mysql_result($result,0,1);
$my_name = mysql_result($result,0,2);
$my_head = mysql_result($result,0,3);
$my_subject = mysql_result($result,0,4);
$my_subtitle = mysql_result($result,0,5);
$my_comment = mysql_result($result,0,6);
$my_m_html = mysql_result($result,0,7);
$my_nlbr = mysql_result($result,0,8);
$my_filetype = mysql_result($result,0,9);
$my_userfile = mysql_result($result,0,10);
	if($my_userfile != "") {
		$my_userfile_txt = "<font color=blue>O</font>";
	} else {
		$my_userfile_txt = "<font color=red>X</font>";
	}
$my_imgdsp = mysql_result($result,0,11);
$my_caption = mysql_result($result,0,12);
$my_img_count = mysql_result($result,0,13);
$my_signdate = mysql_result($result,0,14);
$my_display = mysql_result($result,0,15);
$my_media_chk = mysql_result($result,0,16);
$my_media_link = mysql_result($result,0,17);


// Restore Escaped String
$my_name = stripslashes($my_name);
$my_head = stripslashes($my_head);
$my_subject = stripslashes($my_subject);
$my_comment = stripslashes($my_comment);
$my_subtitle = stripslashes($my_subtitle);
$my_caption = stripslashes($my_caption);

$encoded_key = urlencode($key);

	
	// Photo Images
	$org_imgfile1 = "weekly_"."$uid"."_1.jpg";
	
	$query_img1 = "SELECT count(uid) FROM wpage_content_photo WHERE userfile = '$org_imgfile1' AND bbs_uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_img1 = mysql_query($query_img1,$dbconn);
	if(!$result_img1) { error("QUERY_ERROR"); exit; }

	$img1_count  = @mysql_result($result_img1,0,0);
	
	if($img1_count > 0) {
		$img1_userfile_txt = "<font color=blue>O</font>";
		$img1_mode = "update";
	} else {
		$img1_userfile_txt = "<font color=red>X</font>";
		$img1_mode = "post";
	}
	
	
	$org_imgfile2 = "weekly_"."$uid"."_2.jpg";
	
	$query_img2 = "SELECT count(uid) FROM wpage_content_photo WHERE userfile = '$org_imgfile2' AND bbs_uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_img2 = mysql_query($query_img2,$dbconn);
	if(!$result_img2) { error("QUERY_ERROR"); exit; }

	$img2_count  = @mysql_result($result_img2,0,0);
	
	if($img2_count > 0) {
		$img2_userfile_txt = "<font color=blue>O</font>";
		$img2_mode = "update";
	} else {
		$img2_userfile_txt = "<font color=red>X</font>";
		$img2_mode = "post";
	}
	
	
	$org_imgfile3 = "weekly_"."$uid"."_3.jpg";
	
	$query_img3 = "SELECT count(uid) FROM wpage_content_photo WHERE userfile = '$org_imgfile3' AND bbs_uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_img3 = mysql_query($query_img3,$dbconn);
	if(!$result_img3) { error("QUERY_ERROR"); exit; }

	$img3_count  = @mysql_result($result_img3,0,0);
	
	if($img3_count > 0) {
		$img3_userfile_txt = "<font color=blue>O</font>";
		$img3_mode = "update";
	} else {
		$img3_userfile_txt = "<font color=red>X</font>";
		$img3_mode = "post";
	}
	
	
	$org_imgfile4 = "weekly_"."$uid"."_4.jpg";
	
	$query_img4 = "SELECT count(uid) FROM wpage_content_photo WHERE userfile = '$org_imgfile4' AND bbs_uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_img4 = mysql_query($query_img4,$dbconn);
	if(!$result_img4) { error("QUERY_ERROR"); exit; }

	$img4_count  = @mysql_result($result_img4,0,0);
	
	if($img4_count > 0) {
		$img4_userfile_txt = "<font color=blue>O</font>";
		$img4_mode = "update";
	} else {
		$img4_userfile_txt = "<font color=red>X</font>";
		$img4_mode = "post";
	}


$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);

  if($my_display == "1") {
    $display_chk1 = "checked";
	$display_chk0 = "";
  } else {
    $display_chk1 = "";
	$display_chk0 = "checked";
  }


  if($my_imgdsp == "1") {
    $dsp_chk1 = "checked";
  } else {
    $dsp_chk1 = "";
  }
  if($my_imgdsp == "2") {
    $dsp_chk2 = "checked";
  } else {
    $dsp_chk2 = "";
  }
  if($my_imgdsp == "3") {
    $dsp_chk3 = "checked";
  } else {
    $dsp_chk3 = "";
  }

  if($my_imgdsp == "4") {
    $dsp_chk4 = "checked";
  } else {
    $dsp_chk4 = "";
  }
  if($my_imgdsp == "5") {
    $dsp_chk5 = "checked";
  } else {
    $dsp_chk5 = "";
  }
  if($my_imgdsp == "6") {
    $dsp_chk6 = "checked";
  } else {
    $dsp_chk6 = "";
  }  

  if($my_imgdsp == "7") {
    $dsp_chk7 = "checked";
  } else {
    $dsp_chk7 = "";
  }
  if($my_imgdsp == "8") {
    $dsp_chk8 = "checked";
  } else {
    $dsp_chk8 = "";
  }
  if($my_imgdsp == "9") {
    $dsp_chk9 = "checked";
  } else {
    $dsp_chk9 = "";
  }  

  
if($my_media_chk == "0") {
	$my_media_chk0 = "checked";
} else {
	$my_media_chk1 = "";
}

if($my_media_chk == "1") {
	$my_media_chk1 = "checked";
} else {
	$my_media_chk1 = "";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_02?> &gt; <?=$txt_web_content_03?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="website_content_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="lang" value="<?=$lang?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type="hidden" name="keyfield" value="<?=$keyfield?>">
								<input type="hidden" name="key" value="<?=$key?>">
								<input type="hidden" name="key_type" value="<?=$key_type?>">
								<input type="hidden" name="sorting_key" value="<?=$sorting_key?>">
								<input type='hidden' name='mode' value='<?=$mode?>'>
								<input type='hidden' name='org_uid' value='<?=$new_uid?>'>
								<input type='hidden' name='org_filename' value='<?=$my_userfile?>'>
								<input type='hidden' name='org_img1_uid' value='<?=$img1_uid?>'>
								<input type='hidden' name='org_img2_uid' value='<?=$img2_uid?>'>
								<input type='hidden' name='org_img3_uid' value='<?=$img3_uid?>'>
								<input type='hidden' name='org_img4_uid' value='<?=$img4_uid?>'>
								<input type='hidden' name='org_mode1' value='<?=$img1_mode?>'>
								<input type='hidden' name='org_mode2' value='<?=$img2_mode?>'>
								<input type='hidden' name='org_mode3' value='<?=$img3_mode?>'>
								<input type='hidden' name='org_mode4' value='<?=$img4_mode?>'>
								<input type='hidden' name='org_signdate' value='<?=$my_signdate?>'>
								<input type='hidden' name='org_img_count' value='<?=$my_img_count?>'>
								
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
                                        <div class="col-sm-6">
										
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
										<div class="col-sm-3">
										
												<?
												echo ("
												<select name='new_wrt_code' class='form-control'>
												<option value=\"\">:: $txt_web_content_14 ::</option>");
		
												$query_wrt = "SELECT code,id,name FROM member_main 
															WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND userlevel = '3' ORDER BY name ASC";
												$result_wrt = mysql_query($query_wrt);
												$row_wrt = mysql_num_rows($result_wrt);
          
												while($row_wrt = mysql_fetch_object($result_wrt)) {
													$wrt_code = $row_wrt->code;
													$wrt_id = $row_wrt->id;
													$wrt_name = $row_wrt->name;
			
													if($my_wrt_code == $wrt_code) {
														echo ("<option value='$wrt_code' selected>$wrt_name</option>");
													} else {
														echo ("<option value='$wrt_code'>$wrt_name</option>");
													}
		
												}
												echo ("</select>");
												?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_12?></label>
                                        <div class="col-sm-6">
                                            <?
											echo ("
											<select name='new_room' class='form-control'>");
		
											$query_mmx = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
														WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_depth = '1' 
														ORDER BY b_ord ASC, b_num ASC";
											$result_mmx = mysql_query($query_mmx);
											$row_mmx = mysql_num_rows($result_mmx);
          
											while($row_mmx = mysql_fetch_object($result_mmx)) {
												$mmx_uid = $row_mmx->uid;
												$mmx_room = $row_mmx->room;
												$mmx_mnum = $row_mmx->b_num;
												$mmx_mord = $row_mmx->b_ord;
												$mmx_mcode = $row_mmx->b_loco;
												$mmx_mname = $row_mmx->b_title;
													$mmx_mname = stripslashes($mmx_mname);
												$mmx_mshow = $row_mmx->onoff;
												$mmx_type = $row_mmx->b_type;
												$mmx_option = $row_mmx->b_option;
												$mmx_lagday = $row_mmx->b_lagday;
												$mmx_rows = $row_mmx->b_rows;
												$mmx_permit = $row_mmx->b_permit;
			
												if($mmx_type == "x" OR $mmx_type == "pop" OR $mmx_type == "link" OR $mmx_type == "rss") {
													$mmx_disable = "";
												} else {
													$mmx_disable = "disabled";
												}
												if($my_room == $mmx_room) {
													$mmx_select = "selected";
												} else {
													$mmx_select = "";
												}
												echo ("<option $mmx_disable value='$mmx_room' $mmx_select>[ $mmx_room ] $mmx_mname</option>");
			
			
			
												$query_smx2 = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
															WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$mmx_mcode' AND b_depth = '2' 
															ORDER BY b_ord ASC, b_num ASC";
												$result_smx2 = mysql_query($query_smx2);
												$row_smx2 = mysql_num_rows($result_smx2);
          
												while($row_smx2 = mysql_fetch_object($result_smx2)) {
													$smx2_uid = $row_smx2->uid;
													$smx2_room = $row_smx2->room;
													$smx2_mnum = $row_smx2->b_num;
													$smx2_mord = $row_smx2->b_ord;
													$smx2_mcode = $row_smx2->b_loco;
													$smx2_mname = $row_smx2->b_title;
														$smx2_mname = stripslashes($smx2_mname);
													$smx2_mshow = $row_smx2->onoff;
													$smx2_type = $row_smx2->b_type;
													$smx2_option = $row_smx2->b_option;
													$smx2_lagday = $row_smx2->b_lagday;
													$smx2_rows = $row_smx2->b_rows;
													$smx2_permit = $row_smx2->b_permit;
			
													if($smx2_type == "emag" OR $smx2_type == "blnk" OR $smx2_type == "news" OR $smx2_type == "week") {
														$smx2_disable = "";
													} else {
														$smx2_disable = "disabled";
													}
													if($my_room == $smx2_room) {
														$smx2_select = "selected";
													} else {
														$smx2_select = "";
													}
													echo ("<option value='$smx2_room' $smx2_select>&nbsp;&nbsp; [ $smx2_room ] $smx2_mname</option>");
				
				
													$query_smx3 = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
																WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$mmx_mcode' AND room LIKE '$smx2_room%' AND b_depth = '3' 
																ORDER BY b_ord ASC, b_num ASC";
													$result_smx3 = mysql_query($query_smx3);
													$row_smx3 = mysql_num_rows($result_smx3);
          
													while($row_smx3 = mysql_fetch_object($result_smx3)) {
														$smx3_uid = $row_smx3->uid;
														$smx3_room = $row_smx3->room;
														$smx3_mnum = $row_smx3->b_num;
														$smx3_mord = $row_smx3->b_ord;
														$smx3_mcode = $row_smx3->b_loco;
														$smx3_mname = $row_smx3->b_title;
															$smx3_mname = stripslashes($smx3_mname);
														$smx3_mshow = $row_smx3->onoff;
														$smx3_type = $row_smx3->b_type;
														$smx3_option = $row_smx3->b_option;
														$smx3_lagday = $row_smx3->b_lagday;
														$smx3_rows = $row_smx3->b_rows;
														$smx3_permit = $row_smx3->b_permit;
			
														if($smx3_type == "emag" OR $smx3_type == "blnk" OR $smx3_type == "news") {
															$smx3_disable = "";
														} else {
															$smx3_disable = "disabled";
														}
														if($my_room == $smx3_room) {
															$smx3_select = "selected";
														} else {
															$smx3_select = "";
														}
														echo ("<option value='$smx3_room' $smx3_select>&nbsp;&nbsp;&nbsp;&nbsp; [ $smx3_room ] $smx3_mname</option>");
				
													}
				
			
												}
		
		
											}
		
											echo ("</select>");
											?>
                                        </div>
										
										<div class="col-sm-3">
											<? echo ("
											<input type=radio name='display' value='1' $display_chk1> <font color=#006699>$txt_web_content_121</font> &nbsp;&nbsp; 
											<input type=radio name='display' value='0' $display_chk0> <font color=red>$txt_web_content_122</font> ");
											?>
										</div>
                                    </div>
									
									
									<!----- Subject ----------------------------------------------------------------------------------->
									
									<? if($key_type == "week") { ?>
										
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="subject" value="<?=$my_subject?>" type="date" required />
                                        </div>
                                    </div>
										
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="subject" value="<?=$my_subject?>" maxlength="120" type="text" required />
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									<!----- Sub-title ----------------------------------------------------------------------------------->
									
									<? if($key_type == "week") { ?>
									
										
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 1 &nbsp;&nbsp; <?=$img1_userfile_txt?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page1" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 2 &nbsp;&nbsp; <?=$img2_userfile_txt?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page2" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 3 &nbsp;&nbsp; <?=$img3_userfile_txt?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page3" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 4 &nbsp;&nbsp; <?=$img4_userfile_txt?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page4" type="file" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">PDF File &nbsp;&nbsp; <?=$my_userfile_txt?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page_pdf" type="file" />
                                        </div>
                                    </div>
										
									
									<? } else if($key_type == "vod") { ?>
										
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_02?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="subtitle"><?echo("$my_subtitle")?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_03?> & <?=$txt_vod_blog_04?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="head" value="<?echo("$my_head")?>" type="date" />
                                        </div>
										<div class="col-sm-6">
                                            <input class="form-control" id="cname" name="name" value="<?echo("$my_name")?>" type="text" placeholder="<?=$txt_vod_blog_04?>" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_09?></label>
                                        <div class="col-sm-9">
												<?
												if($my_m_html == "0") {
													echo ("<input type='radio' name='m_html' value='0' checked> Text &nbsp;");
												} else {
													echo ("<input type='radio' name='m_html' value='0'> Text &nbsp;");
												}

												if($my_m_html == "1") {
													echo ("<input type='radio' name='m_html' value='1' checked> HTML &nbsp;");
												} else {
													echo ("<input type='radio' name='m_html' value='1'> HTML &nbsp;");
												}
  
												echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ");
		
												if($my_nlbr == "0") {
													echo (" &nbsp; <input type='checkbox' name='m_nlbr' value='1'> Line Feed &nbsp;");
												} else {
													echo (" &nbsp; <input type='checkbox' name='m_nlbr' value='1' checked> Line Feed &nbsp;");
												}
												?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="org_comment" rows="10"><?=$my_comment?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_10?></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cname" name="userfile" type="file" />
                                        </div>
										<div class="col-sm-3">
                                            <?
											if($my_userfile != "" AND $my_userfile != "none" AND $my_userfile != "none") {
												echo ("<input type='checkbox' name='del_img_chk' value='1'> <font color=red>$bdtxt_35D</font>");
											} else {
												echo ("$bdtxt_35");
											}
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_05?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='media_chk' value='1' <?=$my_media_chk1?>> <font color=blue>ON</font> &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type=radio name='media_chk' value='0' <?=$my_media_chk0?>> <font color=red>OFF</font>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_06?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="media_link"><?echo("$my_media_link")?></textarea>
                                        </div>
                                    </div>
									
										
									<? } else { ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_08?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="subtitle"><?=$my_subtitle?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_ch_blog_05?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='media_chk' value='1' <?=$my_media_chk1?>> <font color=blue>ON</font> &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type=radio name='media_chk' value='0' <?=$my_media_chk0?>> <font color=red>OFF</font>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_ch_blog_06?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="media_link"><?echo("$my_media_link")?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_09?></label>
                                        <div class="col-sm-9">
												<?
												if($my_m_html == "0") {
													echo ("<input type='radio' name='m_html' value='0' checked> Text &nbsp;");
												} else {
													echo ("<input type='radio' name='m_html' value='0'> Text &nbsp;");
												}

												if($my_m_html == "1") {
													echo ("<input type='radio' name='m_html' value='1' checked> HTML &nbsp;");
												} else {
													echo ("<input type='radio' name='m_html' value='1'> HTML &nbsp;");
												}
  
												echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ");
		
												if($my_nlbr == "0") {
													echo (" &nbsp; <input type='checkbox' name='m_nlbr' value='1'> Line Feed &nbsp;");
												} else {
													echo (" &nbsp; <input type='checkbox' name='m_nlbr' value='1' checked> Line Feed &nbsp;");
												}
												
												echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ");
												
												if($key_type == "islide") {
													echo ("<font color=red>[Note] Saperated by '|' for each line</font>");
												}
												?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="org_comment" rows="10"><?=$my_comment?></textarea>
                                        </div>
                                    </div>
									
									
									<? if($key_type == "emag") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><input type=checkbox name='add_content_chk' value='1'> <?=$txt_web_content_13?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="add_comment" rows="5"></textarea>
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_10?></label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="userfile"> 
                                        </div>
										<? if($key_type == "emag") { ?>
										<div class="col-sm-1">
                                            <input type="text" name="m_width" maxlength=4 class="form-control">
                                        </div>
										<div class="col-sm-1" align=center>x</div>
										<div class="col-sm-1">
                                            <input type="text" name="m_height" maxlength=4 class="form-control">
                                        </div>
										<? } else { ?>
										<div class="col-sm-3">
													<?
													if($my_userfile != "" AND $my_userfile != "none" AND $my_userfile != "none") {
													
														echo ("<input type='checkbox' name='del_img_chk' value='1'> <font color=red>$bdtxt_35D</font>");
													
													} else {
													
														echo ("$bdtxt_35");
														
													}
													?>
                                        </div>
										<? } ?>
										
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_11?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="m_caption"><?echo("$my_caption")?></textarea>
                                        </div>
                                    </div>
								
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$bdtxt_39?></label>
                                        <div class="col-sm-9">
            <?
			echo ("
			<table width=296 cellspacing=0 cellpadding=0 border=0>
		    <tr>
		      <td width=28 height=29><img src='$home/img/icon/layout_1.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_2.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_3.gif' with=28 height=29 border=0></td>
		      <td width=10></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_4.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_5.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_6.gif' with=28 height=29 border=0></td>
		      <td width=10></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_7.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_8.gif' with=28 height=29 border=0></td>
		      <td width=4></td>
		      <td width=28 height=29><img src='$home/img/icon/layout_9.gif' with=28 height=29 border=0></td>
		    </tr>
		    <tr><td colspan=17 height=2></td></tr>
			<tr>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='1' $dsp_chk1></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='2' $dsp_chk2></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='3' $dsp_chk3></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='4' $dsp_chk4></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='5' $dsp_chk5></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='6' $dsp_chk6></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='7' $dsp_chk7></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='8' $dsp_chk8></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='9' $dsp_chk9></td>
		    </tr>
		    <tr><td colspan=17 height=10></td></tr>
		    </table>");
			?>
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

	
  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}
  
  
  if(!$m_nlbr) {
    $m_nlbr = "0";
  }
  if(!$add_content_chk) {
	$add_content_chk = "0";
  }
  if(!$del_img_chk) {
	$del_img_chk = "0";
  }
  
  
  $query_dep = "SELECT b_loco,b_depth,b_type FROM wpage_config 
				WHERE room = '$new_room' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY uid DESC";
  $result_dep = mysql_query($query_dep);
  if (!$result_dep) {   error("QUERY_ERROR");   exit; }

  $new_loco = @mysql_result($result_dep,0,0);
  $new_depth = @mysql_result($result_dep,0,1);
  $new_b_type = @mysql_result($result_dep,0,2);
  
  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');


  // Add Slashes
  $subject = addslashes($subject);
  $subtitle = addslashes($subtitle);
  $m_caption = addslashes($m_caption);
  $org_comments = addslashes($org_comment);

  
  if($pin_key) {
  
	if($key_type == "week") {
	
			if($page_pdf != "") {
		
				$new_page_pdf = "weekly_"."$org_uid".".pdf";
			
				if(!copy($page_pdf,"$savedir/$new_page_pdf")) {
					error("UPLOAD_COPY_FAILURE");
					exit;
				}
	
				$query_K9 = "UPDATE wpage_content SET subject = '$subject', m_filetype = 'pdf', userfile = '$new_page_pdf' 
							WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
				$result_K9 = mysql_query($query_K9);
				if (!$result_K9) { error("QUERY_ERROR"); exit; }
		
			} else {
		
				$query_K9 = "UPDATE wpage_content SET subject = '$subject' WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
				$result_K9 = mysql_query($query_K9);
				if (!$result_K9) { error("QUERY_ERROR"); exit; }
		
			}
			
			
			
			if($page1 != "") {
		
				$new_page1 = "weekly_"."$org_uid"."_1.jpg";
			
				if(!copy($page1,"$savedir/$new_page1")) {
					error("UPLOAD_COPY_FAILURE");
					exit;
				}
				
				if($org_mode1 == "post") {
					$query_K1b = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
								VALUES ('', $org_uid, '$new_page1', '$key_gate', '$login_branch')";
					$result_K1b = mysql_query($query_K1b);
					if (!$result_K1b) { error("QUERY_ERROR"); exit; }
				}
			
			}
			
			if($page2 != "") {
		
				$new_page2 = "weekly_"."$org_uid"."_2.jpg";
			
				if(!copy($page2,"$savedir/$new_page2")) {
					error("UPLOAD_COPY_FAILURE");
					exit;
				}
				
				if($org_mode2 == "post") {
					$query_K2b = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
								VALUES ('', $org_uid, '$new_page2', '$key_gate', '$login_branch')";
					$result_K2b = mysql_query($query_K2b);
					if (!$result_K2b) { error("QUERY_ERROR"); exit; }
				}
			
			}
			
			if($page3 != "") {
		
				$new_page3 = "weekly_"."$org_uid"."_3.jpg";
			
				if(!copy($page3,"$savedir/$new_page3")) {
					error("UPLOAD_COPY_FAILURE");
					exit;
				}
				
				if($org_mode3 == "post") {
					$query_K3b = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
								VALUES ('', $org_uid, '$new_page3', '$key_gate', '$login_branch')";
					$result_K3b = mysql_query($query_K3b);
					if (!$result_K3b) { error("QUERY_ERROR"); exit; }
				}
			
			}
			
			if($page4 != "") {
		
				$new_page4 = "weekly_"."$org_uid"."_4.jpg";
			
				if(!copy($page4,"$savedir/$new_page4")) {
					error("UPLOAD_COPY_FAILURE");
					exit;
				}
				
				if($org_mode4 == "post") {
					$query_K4b = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
								VALUES ('', $org_uid, '$new_page4', '$key_gate', '$login_branch')";
					$result_K4b = mysql_query($query_K4b);
					if (!$result_K4b) { error("QUERY_ERROR"); exit; }
				}
			
			}
	
			echo("<meta http-equiv='Refresh' content='0; URL=$home/website_content_upd.php?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&uid=$org_uid&page=$page&key_gate=$key_gate'>");
			exit;

			
	} else {
  
			
			
			if($del_img_chk == "1") {
			
				$query_F1 = "UPDATE wpage_content SET m_filetype = 'non', userfile = 'none', filesize='0' 
							WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
				$result_F1 = mysql_query($query_F1);
				if (!$result_F1) { error("QUERY_ERROR"); exit; }
			
			
			} else if($userfile != "") {
			
			$full_filename = explode(".", "$userfile_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(strcmp($extension,"JPG") AND 
			   strcmp($extension,"jpg") AND
			   strcmp($extension,"GIF") AND
			   strcmp($extension,"gif") AND
			   strcmp($extension,"PNG") AND
			   strcmp($extension,"png") AND
			   strcmp($extension,"MP3") AND
			   strcmp($extension,"mp3")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}
			
			if($extension == "JPG" OR $extension == "jpg") {
			  $image_type = "1";
			  $extension2 = "jpg";
			} else if($extension == "GIF" OR $extension == "gif") {
			  $image_type = "2";
			  $extension2 = "gif";
			} else if($extension == "PNG" OR $extension == "png") {
			  $image_type = "3";
			  $extension2 = "png";
			} else if($extension == "MP3" OR $extension == "mp3") {
			  $image_type = "5";
			  $extension2 = "mp3";
			} else {
			  $image_type = "4";
			  $extension2 = $extension;
			}
			

			$new_img_count = $org_img_count+1;
			$new_filename = "file_"."$org_uid"."_{$new_img_count}.{$extension2}";

			
			if(!copy("$userfile","$savedir/$userfile_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$userfile_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			
				$query_F2 = "UPDATE wpage_content SET m_filetype = '$image_type', userfile = '$new_filename', filesize='$userfile_size'	
							WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
				$result_F2 = mysql_query($query_F2);
				if (!$result_F2) { error("QUERY_ERROR"); exit; }
			
			}

	
	if($m_width > "1") {
		if($m_height > "1") {
			$m_dimension_txt = "style='WIDTH: $m_width"."px; HEIGHT: $m_height"."px'";
		} else {
			$m_dimension_txt = "style='WIDTH: $m_width"."px'";
		}
	} else {
		if($m_height > "1") {
			$m_dimension_txt = "style='HEIGHT: $m_height"."px'";
		} else {
			$m_dimension_txt = "";
		}
	}
	
	if($key_type == "emag") {
	if($userfile != "") {
	
		if($m_imgdsp == "1" OR $m_imgdsp == "2" OR $m_imgdsp == "3") { // Top Image
			$new_add_comment = "$org_comment"."<p><div align=center><img src='$savedir/$new_filename' $m_dimension_txt border=0'><br><div class='captionA' style='padding-top: 4px'>$m_caption</div></div></p><p>"."$add_comment"."</p>";
		} else if($m_imgdsp == "4") { // float:left
			$new_add_comment = "$org_comment"."<p><span class='picture mid-left'><img src='$savedir/$new_filename' $m_dimension_txt border=0><br>$m_caption</span>"."$add_comment"."</p>";
		} else if($m_imgdsp == "6") { // float:right
			$new_add_comment = "$org_comment"."<p><span class='picture mid-right'><img src='$savedir/$new_filename' $m_dimension_txt border=0><br>$m_caption</span>"."$add_comment"."</p>";
		} else if($m_imgdsp == "7" OR $m_imgdsp == "8" OR $m_imgdsp == "9") { // Bottom Image
			$new_add_comment = "$org_comment"."<p>"."$add_comment"."</p><p><div align=center><img src='$savedir/$new_filename' $m_dimension_txt border=0><br><div class='captionA' style='padding-top: 4px'>$m_caption</div></div></p>";
		} else {
			$new_add_comment = "$org_comment"."<p>"."$add_comment"."</p>";
		}
	

	} else {
	
		if($add_content_chk == "1") {
			$new_add_comment = "$org_comment"."<p>"."$add_comment"."</p>";
		} else {
			$new_add_comment = $org_comment;
		}
		
	}
	} else {
			$new_add_comment = $org_comment;
	}
	
	$new_add_comments = addslashes($new_add_comment);
	
	$name = addslashes($name);
	$head = addslashes($head);
	
	if($key_type == "vod") {
		$new_name = $name;
		$new_head = $head;
	} else {
		$new_name = $key_gate;
		$new_head = "";
	}
	
	if(!$media_chk) {
		$media_chk = "0";
	}
	
	// Writer Name
	$query_wrtn = "SELECT id,name FROM member_main WHERE code = '$new_wrt_code' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY code DESC";
	$result_wrtn = mysql_query($query_wrtn);
	if (!$result_wrtn) {   error("QUERY_ERROR");   exit; }

	$new_wrtn_id = @mysql_result($result_wrtn,0,0);
	$new_wrtn_name = @mysql_result($result_wrtn,0,1);
	
	if(!$new_wrt_code) {
		$new_wrt_id = $login_id;
		$new_wrt_name = $website_name;
	} else {
		$new_wrt_id = $new_wrtn_id;
		$new_wrt_name = $new_wrtn_name;
	}
	
	// Original Caption
	/*
	$query_img = "UPDATE wpage_content SET m_caption = '$org_caption' WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_img = mysql_query($query_img);
	if (!$result_img) { error("QUERY_ERROR"); exit; }
	*/
	
	
	
			$query_M1 = "UPDATE wpage_content SET room = '$new_room', b_depth = '$new_depth', b_loco = '$new_loco', b_type = '$new_b_type', 
					img_count = '$new_img_count', m_filetype = '$image_type', m_imgdsp = '$m_imgdsp', m_caption = '$m_caption', 
					subject = '$subject', subtitle = '$subtitle', comment = '$new_add_comments', m_html = '$m_html', m_nlbr = '$m_nlbr', 
					upd_date = '$signdate', display = '$display', name = '$new_name', head = '$new_head', media_chk = '$media_chk', media_link = '$media_link'  
					WHERE uid = '$org_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
			$result_M1 = mysql_query($query_M1);
			if (!$result_M1) { error("QUERY_ERROR"); exit; }

    

	echo("<meta http-equiv='Refresh' content='0; URL=$home/website_content.php?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&uid=$org_uid&page=$page&key_gate=$key_gate'>");
	exit;
  
	}
  }
  
}


}

}
?>