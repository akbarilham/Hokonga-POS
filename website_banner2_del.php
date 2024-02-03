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
$query = "SELECT uid,b_id,b_loco,b_ord,b_alt,b_url,b_target,b_show,bgcolor,user_id,user_code,ref,signdate,upd_date,
		videoclip_play, videoclip,b_left,b_top,fontcolor FROM wpage_banner2 WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

   $uid = $row->uid;   
   $b_id = $row->b_id;
   $b_loco = $row->b_loco; 
   $b_ord = $row->b_ord;  
   $b_alt = $row->b_alt;   
   $b_url = $row->b_url;
   $b_target = $row->b_target;   
   $b_show = $row->b_show;
   $b_bgcolor = $row->bgcolor;
   $user_id = $row->user_id;
   $user_code = $row->user_code;
   $ref = $row->ref;
	$ref_K = number_format($ref);
   $signdate = $row->signdate;
		$date1 = substr($signdate,0,4);
		$date2 = substr($signdate,4,2);
		$date3 = substr($signdate,6,2);
		$time1 = substr($signdate,8,2);
		$time2 = substr($signdate,10,2);
		$time3 = substr($signdate,12,2);
		
		if($lang == "ko") {
			$signdate_txt = "$date1"."/"."$date2"."/"."$date3".", "."$time1".":"."$time2".":"."$time3";
		} else {
			$signdate_txt = "$date3"."-"."$date2"."-"."$date1".", "."$time1".":"."$time2".":"."$time3";
		}
		
   $upd_date = $row->upd_date;
		$udate1 = substr($upd_date,0,4);
		$udate2 = substr($upd_date,4,2);
		$udate3 = substr($upd_date,6,2);
		$utime1 = substr($upd_date,8,2);
		$utime2 = substr($upd_date,10,2);
		$utime3 = substr($upd_date,12,2);
		
		if($lang == "ko") {
			$upd_date_txt = "$udate1"."/"."$udate2"."/"."$udate3".", "."$utime1".":"."$utime2".":"."$utime3";
		} else {
			$upd_date_txt = "$udate3"."-"."$udate2"."-"."$udate1".", "."$utime1".":"."$utime2".":"."$utime3";
		}
   $videoclip_play = $row->videoclip_play;
		if($videoclip_play == "1") {
			$videoclip_play_chk = "checked";
		} else {
			$videoclip_play_chk = "";
		}
   $videoclip = $row->videoclip;
   $b_left = $row->b_left;
   $b_top = $row->b_top;
   $b_fontcolor = $row->fontcolor;
   
   

	if($b_target == "_top") {
      $selectA = "selected";
      $input = "0";
    } else if($b_target == "_blank") {
      $selectB = "selected";
      $input = "0";
    } else if($b_target == "_self") {
      $selectC = "selected";
      $input = "0";
    } else if($b_target == "_new") {
      $selectD = "selected";
      $input = "0";
    } else {
      $selectE = "selected";
      $input = "1";
    }
	
	if($b_show == "1") {
        $checkA = "checked";
        $checkB = "";
    } else {
        $checkA = "";
        $checkB = "checked";
    }



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
            <?=$hsm_name_08_032?> &gt; <?=$txt_web_banner2_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="website_banner2_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type='hidden' name='bn_key' value="<?=$bn_key?>">
								<input type='hidden' name='uid' value='<?=$uid?>'>
								<input type='hidden' name='b_loco' value='<?=$b_loco?>'>
								<input type='hidden' name='b_room' value='<?=$b_room?>'>
								<input type='hidden' name='b_id' value='<?=$b_id?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
								
								
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
		
		echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

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
			
			
			if($bn_id == $bn_key OR $bn_id == $b_id) {
				echo("<option value='$PHP_SELF?b_loco=$b_loco&b_room=$b_room&b_id=$bn_id&bn_key=$bn_id&key_gate=$key_gate' selected>$bn_id :: $bn_type_txt</option>");
			} else {
				echo("<option disabled value='$PHP_SELF?b_loco=$b_loco&b_room=$b_room&b_id=$bn_id&bn_key=$bn_id&key_gate=$key_gate'>$bn_id :: $bn_type_txt</option>");
			}
        
      }
      echo ("
      </select>");
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

		$queryD = "SELECT b_loco,b_title FROM wpage_config WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '1' AND lang = '$lang'
               ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
		$resultD = mysql_query($queryD);
		
		echo ("<select name='dis_b_loco' class='form-control'>");
		if($b_loco == "top") {
			echo ("<option value='top' selected>-- top : Intro Top Banner (top)</option>");
		} else {
			echo ("<option disabled value='top'>-- top : Intro Top Banner (top)</option>");
		}
		
		if($b_loco == "main_intro") {
			echo ("<option value='main_intro' selected>-- Intro Stripe Banner (main_intro)</option>");
		} else {
			echo ("<option disabled value='main_intro'>-- Intro Stripe Banner (main_intro)</option>");
		}
		
		if($b_loco == "main_prev") {
			echo ("<option value='main_prev' selected>-- A : The Previous Edition (main_prev)</option>");
		} else {
			echo ("<option disabled value='main_prev'>-- A : The Previous Edition (main_prev)</option>");
		}
		
		
		// left banner
		for($i = 0; $i < $total_recordC; $i++) {
			$menu_code = mysql_result($resultD,$i,0);
			$menu_name = mysql_result($resultD,$i,1);
				$menu_name = stripslashes($menu_name);
			
			if($b_loco == "main_left" AND $b_room == $menu_code) {
				echo("<option value='main_left|$menu_code' selected>-- B : Stripe Banners - $menu_name</option>");
			} else {
				echo("<option disabled value='main_left|$menu_code'>-- B : Stripe Banners - $menu_name</option>");
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
					echo("<option disabled value='main_left|$smenu_room'>-- B : Stripe Banners - $menu_name &gt; $smenu_name</option>");
				}
			
			}
			
		}
		
		if($b_loco == "main_mid") {
			echo ("<option value='main_mid' selected>-- C : Banner / Video Clip (main_mid)</option>");
		} else {
			echo ("<option disabled value='main_mid'>-- C : Banner / Video Clip (main_mid)</option>");
		}
		
		// header banner
		for($i = 0; $i < $total_recordC; $i++) {
			$menu_code = mysql_result($resultD,$i,0);
			$menu_name = mysql_result($resultD,$i,1);
				$menu_name = stripslashes($menu_name);
			
			if($b_loco == "top_logo" AND $b_room == $menu_code) {
				echo("<option value='top_logo|$menu_code' selected>-- D : Header Banners - $menu_name</option>");
			} else {
				echo("<option disabled value='top_logo|$menu_code'>-- D : Header Banners - $menu_name</option>");
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
					echo("<option disabled value='top_logo|$smenu_room3'>-- D : Header Banners - $menu_name &gt; $smenu_name3</option>");
				}
			
			}
			
		}
		
		
		if($b_loco == "main_midf1") {
			echo ("<option value='main_midf1' selected>-- E : Fixed Banner 1 / Survey (main_midf1)</option>");
		} else {
			echo ("<option disabled value='main_midf1'>-- E : Fixed Banner 1 / Survey (main_midf1)</option>");
		}
		
		if($b_loco == "main_midf2") {
			echo ("<option value='main_midf2' selected>-- F : Fixed Banner 2 (main_midf2)</option>");
		} else {
			echo ("<option disabled value='main_midf2'>-- F : Fixed Banner 2 (main_midf2)</option>");
		}
		
		if($b_loco == "main_midt2") {
			echo ("<option value='main_midt2' selected>-- H : Multiple Contents Banners (main_midt2)</option>");
		} else {
			echo ("<option disabled value='main_midt2'>-- H : Multiple Contents Banners (main_midt2)</option>");
		}
		
		
		
		// right banner
		for($i = 0; $i < $total_recordC; $i++) {
			$menu_code = mysql_result($resultD,$i,0);
			$menu_name = mysql_result($resultD,$i,1);
				$menu_name = stripslashes($menu_name);
			
			if($b_loco == "main_right" AND $b_room == $menu_code) {
				echo("<option value='main_right|$menu_code' selected>-- I : Right Banners - $menu_name</option>");
			} else {
				echo("<option disabled value='main_right|$menu_code'>-- I : Right Banners - $menu_name</option>");
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
					echo("<option disabled value='main_right|$smenu_room4'>-- I : Right Banners - $menu_name &gt; $smenu_name4</option>");
				}
			
			}
			
		}

		
		
		if($b_loco == "intro") {
			echo ("<option value='intro' selected>-- intro : Introduction Page Screen</option>");
		} else {
			echo ("<option disabled value='intro'>-- intro : Introduction Page Screen</option>");
		}
		
		if($b_loco == "popup") {
			echo ("<option value='popup' selected>-- Popup Layer</option>");
		} else {
			echo ("<option disabled value='popup'>-- Popup Layer</option>");
		}
		
		echo ("
		</select>");
											?>
		
                                        </div>

										<div class="col-sm-1">Arrange</div>
										<div class="col-sm-2">
											<input type='text' name='b_ord' value='<?=$b_ord?>' maxlength=5 class='form-control' style='text-align: center'>
										</div>
                                    </div>
									
									<?
									if($bn_key OR $b_id) {


									if($bn_key) {
										$query_key = "SELECT b_id,b_type FROM wpage_banner1 WHERE b_id = '$bn_key' AND gate = '$key_gate' AND branch_code = '$login_branch'";
									} else {
										$query_key = "SELECT b_id,b_type FROM wpage_banner1 WHERE b_id = '$b_id' AND gate = '$key_gate' AND branch_code = '$login_branch'";
									}
									$result_key = mysql_query($query_key);
										if(!$result_key) { error("QUERY_ERROR"); exit; }
									$row_key = mysql_fetch_object($result_key);

									$bk_id = $row_key->b_id;
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
                                            <image src='$savedir/banner_{$bk_id}.{$bk_type_ext}' border=0>
                                        </div>
                                    </div>");
									
									}
									?>
									
									
									<? if($b_loco == "main_mid") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">
											<input type='checkbox' name='videoclip_play' value='1' $videoclip_play_chk> YouTube Included
										</label>
                                        <div class="col-sm-9">
											
                                            <select  name='videoclip' class='form-control'>
											<?
											$query_smx2 = "SELECT uid,b_loco,room,subject FROM wpage_content 
												WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang='$lang' AND b_type = 'emag' AND b_depth = '2' AND display = '1' 
												ORDER BY subject ASC, uid DESC";
											$result_smx2 = mysql_query($query_smx2);
											$row_smx2 = mysql_num_rows($result_smx2);
          
											while($row_smx2 = mysql_fetch_object($result_smx2)) {
												$smx2_uid = $row_smx2->uid;
												$smx2_loco = $row_smx2->b_loco;
												$smx2_room = $row_smx2->room;
												$smx2_mname = $row_smx2->subject;
													$smx2_mname = stripslashes($smx2_mname);
			
												if($videoclip == $smx2_uid) {
													$smx2_select = "selected";
												} else {
													$smx2_select = "";
												}
												echo ("<option $smx2_disable value='$smx2_uid' $smx2_select>[ $smx2_room ] $smx2_mname</option>");
			
											}
											?>
											</select>
											
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_08?></label>
                                        <div class="col-sm-9">
                                            <input type="url" class="form-control" name="b_url" value="<?=$b_url?>" placeholder="http://">
                                        </div>
                                    </div>
									
								
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_12?></label>
                                        <div class="col-sm-3">
                                            <input disabled type="text" class="form-control" name="ref" value="<?=$ref?>" style="text-align: right">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_13?></label>
                                        <div class="col-sm-3">
                                            <input disabled type="text" class="form-control" name="signdate_txt" value="<?=$signdate_txt?>">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_14?></label>
                                        <div class="col-sm-3">
                                            <input disabled type="text" class="form-control" name="upd_date_txt" value="<?=$upd_date_txt?>">
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_11?></label>
                                        <div class="col-sm-9">
                                            <input type='radio' name='b_show' value='1' <?=$checkA?>> <font color=blue>ON</font> &nbsp; 
											<input type='radio' name='b_show' value='0' <?=$checkB?>> <font color=red>OFF</font>
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

	

	$signdate = time();
	$date1 = date("Ymd",$signdate);
	$date2 = date("His",$signdate);
	$dates = "$date1"."$date2";

	
    $query_M1  = "DELETE FROM wpage_banner2 WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_banner2.php?key_gate=$key_gate'>");
  exit;
  
  
}

}
?>