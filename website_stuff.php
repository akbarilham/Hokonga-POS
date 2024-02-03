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
$smenu = "website_stuff";

if(!$step_next) {

$link_list = "$home/website_stuff.php";
$link_post = "$home/website_stuff_post.php";
$link_upd = "$home/website_stuff_upd.php";
$link_del = "$home/website_stuff_del.php";

if(!$key) { $key = "copy"; }
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

						
		<!--body wrapper start-->
        <div class="wrapper">
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_04?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			
		
		
			<div class="row">
			
			<div class="col-sm-6">
			
						<?
						$queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
						$resultC = mysql_query($queryC);
						$total_recordC = mysql_result($resultC,0,0);

						$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' ORDER BY userlevel DESC";
						$resultD = mysql_query($queryD);
						if (!$resultD) {   error("QUERY_ERROR");   exit; }

						echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

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
			
			<div class="col-sm-6">
			
		<select name='select' onChange="MM_jumpMenu('parent',this,0)" class="form-control">
		<option>:: <?=$txt_web_stuff_01?> ::</option>
		<? if($key == "intro") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=intro&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_01?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=intro&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_01?></option>
		<? } ?>
		<? if($key == "info") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=info&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_02?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=info&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_02?></option>
		<? } ?>
		<? if($key == "join") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=join&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_03?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=join&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_03?></option>
		<? } ?>
		<? if($key == "terms") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=terms&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_04?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=terms&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_04?></option>
		<? } ?>
		<? if($key == "notice") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=notice&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_05?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=notice&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_05?></option>
		<? } ?>
		<? if($key == "footbox") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=footbox&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_06?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=footbox&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_06?></option>
		<? } ?>
		<? if($key == "footbox2") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=footbox2&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_07?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=footbox2&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_07?></option>
		<? } ?>
		<? if($key == "copy") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=copy&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_08?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=copy&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_08?></option>
		<? } ?>
		<? if($key == "xmail_auto1") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_auto1&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_09?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_auto1&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_09?></option>
		<? } ?>
		<? if($key == "xmail_auto2") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_auto2&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_10?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_auto2&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_10?></option>
		<? } ?>
		<? if($key == "xmail_banks") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_banks&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_11?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_banks&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_11?></option>
		<? } ?>
		<? if($key == "xmail_footer") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_footer&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_12?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=xmail_footer&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_12?></option>
		<? } ?>
		
		<? if($key == "shop_payment") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=shop_payment&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_13?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=shop_payment&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_13?></option>
		<? } ?>
		<? if($key == "shop_shipping") { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=shop_shipping&key_gate=<?=$key_gate?>" selected><?=$txt_web_stuff_loco_14?></option>
		<? } else { ?>
		<option value="<?=$PHP_SELF?>?keyfield=room&key=shop_shipping&key_gate=<?=$key_gate?>"><?=$txt_web_stuff_loco_14?></option>
		<? } ?>
		</select>
		
			</div>
		
		</div>
		
		<br>
			

			
			
<?
$sorting_filter = "room = '$key' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch'";

$query_cnt = "SELECT count(uid) FROM wpage_stuff WHERE $sorting_filter";
$result_cnt = mysql_query($query_cnt);
if (!$result_cnt) {   error("QUERY_ERROR");   exit; }

$cnt_uid = @mysql_result($result_cnt,0,0);

if($cnt_uid > 0) {


	$query = "SELECT uid,room,subject,comment,image_show,image_type,onoff,signdate FROM wpage_stuff WHERE $sorting_filter ORDER BY uid DESC";
	$result = mysql_query($query);
	if (!$result) {   error("QUERY_ERROR");   exit; }

		$foot_uid = @mysql_result($result,0,0);
		$foot_room = @mysql_result($result,0,1);
		$foot_subject = @mysql_result($result,0,2);
			$foot_subject = stripslashes($foot_subject);
		$foot_comment = @mysql_result($result,0,3);
			$foot_comment = stripslashes($foot_comment);
		$image_show = @mysql_result($result,0,4);
		$image_type = @mysql_result($result,0,5);
		$onoff = @mysql_result($result,0,6);
		$signdate = @mysql_result($result,0,7);
		
		
		if($image_show == "0") {
			$image_show_chk0 = "checked";
			$image_show_chk1 = "";
		} else if($image_show == "1") {
			$image_show_chk0 = "";
			$image_show_chk1 = "checked";
		}

		if($image_type == "1") {
			$image_type_txt = "<font color=blue>JPG</font>";
		} else if($image_type == "2") {
			$image_type_txt = "<font color=blue>GIF</font>";
		} else if($image_type == "3") {
			$image_type_txt = "<font color=blue>PNG</font>";
		} else if($image_type == "4") {
			$image_type_txt = "<font color=red>Not Image File</font>";
		} else {
			$image_type_txt = "v";
		}

		if($image_type == "0") {
				$image_input_txt = "$txt_web_content_10";
		} else {
			if($lang == "ko") {
				$image_input_txt = "$txt_web_content_10 <font color=red>$txt_web_content_10p</font>";
			} else {
				$image_input_txt = "<font color=red>$txt_web_content_10p</font> $txt_web_content_10";
			}
		}

	echo ("
	<form name='signform1' method='post' class='cmxform form-horizontal adminex-form' ENCTYPE='multipart/form-data' action='website_stuff.php'>
	<input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='lang' value='$lang'>
	<input type='hidden' name='key_gate' value='$key_gate'>
	<input type='hidden' name='room' value='$foot_room'>
	<input type='hidden' name='org_image_type' value='$image_type'>
	<input type='hidden' name='new_uid' value='$foot_uid'>");
	?>

	
	
									
										<? if($key == "notice" OR $key == "shop_payment" OR $key == "shop_shipping") { ?>
										
										<div class="form-group">											
											<label for="cname" class="control-label col-sm-3"><?=$txt_web_content_17?></label>
											<div class="col-sm-9">
												<input type="radio" name="image_show" value="0" <?=$image_show_chk0?>> Text/Html &nbsp;&nbsp;&nbsp;&nbsp; 
												<input type="radio" name="image_show" value="1" <?=$image_show_chk1?>> Image (<?=$image_type_txt?>)
											</div>
										</div>
										
										<div class="form-group">											
											<label for="cname" class="control-label col-sm-3"><?=$image_input_txt?></label>
											<div class="col-sm-9">
												<input type="file" class="form-control" name="userfile" placeholder="JPG / GIF / PNG">
											</div>
										</div>
										
										<?
										if($onoff == "1") {
											$checkA = "checked";
											$checkB = "";
										} else {
											$checkA = "";
											$checkB = "checked";
										}
										?>
										
										<div class="form-group">											
											<label for="cname" class="control-label col-sm-3"><?=$txt_web_content_12?></label>
											<div class="col-sm-9">
												<input type="radio" name="onoff" value='1' <?=$checkA?>> <font color=blue>ON</font> &nbsp; 
												<input type="radio" name="onoff" value='0' <?=$checkB?>> <font color=red>OFF</font>
											</div>
										</div>
	
										<? } ?>
										
										<div class="form-group">											
											<label for="cname" class="control-label col-sm-3"><?=$txt_web_content_07?></label>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="foot_subject" value="<?=$foot_subject?>">
											</div>
										</div>
										
										<div class="form-group">											
											<label for="cname" class="control-label col-sm-3"><?=$txt_web_content_09?></label>
											<div class="col-sm-9">
												<textarea class="form-control" name="foot_comment" required><?=$foot_comment?></textarea>
											</div>
										</div>
										
										<div class="form-group">
											<div class="col-sm-offset-3 col-sm-9">
												<input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
												<input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
											</div>
										</div>
										
									
									</form>

<?
} else {

	echo ("
	<form name='signform2' class='form-horizontal' method='post' action='website_stuff.php'>
	<input type='hidden' name='step_next' value='permit_post'>
	<input type='hidden' name='lang' value='$lang'>
	<input type='hidden' name='key_gate' value='$key_gate'>
	<input type='hidden' name='room' value='$key'>
	
	<fieldset>
	
		<div>&nbsp;</div><br>
		<input class='btn btn-primary' type='submit' value='$txt_web_content_16'>
		
	</fieldset>
	</form>
	");


}
?>
	
	
	
	
			
		
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
} else if($step_next == "permit_update") {

  $signdate = time();
	$today = date('Ymd'); 
	$time = date('YmdHis');
  
  $foot_subject = addslashes($foot_subject);
  $foot_comment = addslashes($foot_comment);
  
  $m_ip = getenv('REMOTE_ADDR');
  
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}
	
  
  $new_file = "info_"."$room"."_"."$lang";
  
		if($userfile != "") {

			$full_filename = explode(".", "$userfile_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(strcmp($extension,"JPG") AND 
			   strcmp($extension,"jpg") AND
			   strcmp($extension,"GIF") AND
			   strcmp($extension,"gif") AND
			   strcmp($extension,"PNG") AND
			   strcmp($extension,"png")) 
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
			} else {
			  $image_type = "4";
			  $extension2 = $extension;
			}
			

			$new_filename = "$new_file".".{$extension2}";

			if($userfile != "") {
			if(!copy("$userfile","$savedir/$userfile_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$userfile_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			}

		}
  
		if(!$image_type) {
			$image_type = $org_image_type;
		}
  
  

	$result = mysql_query("UPDATE wpage_stuff SET subject = '$foot_subject', comment = '$foot_comment', 
			image_show = '$image_show', image_type = '$image_type', onoff = '$onoff' 
			WHERE uid = '$new_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'");
	if (!$result) { error("QUERY_ERROR"); exit;	}




  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_stuff.php?keyfield=room&key=$room&key_gate=$key_gate'>");
  exit;
  

} else if($step_next == "permit_post") {

  $signdate = time();
	$today = date('Ymd'); 
	$time = date('YmdHis');
  
  $foot_subject = addslashes($foot_subject);
  $foot_comment = addslashes($foot_comment);
  
  $m_ip = getenv('REMOTE_ADDR');

	$query = "INSERT INTO wpage_stuff (uid, room, subject, comment, signdate, lang, gate, branch_code) VALUES 
          ('', '$room', 'Title', 'Contents here ...', '$time', '$lang', '$key_gate', '$login_branch')";
	$result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }



  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_stuff.php?keyfield=room&key=$room&key_gate=$key_gate'>");
  exit;
  
}

}
?>