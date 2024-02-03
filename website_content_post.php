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
$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_02?> &gt; <?=$txt_web_content_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="website_content_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="lang" value="<?=$lang?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type="hidden" name="keyfield" value="<?=$keyfield?>">
								<input type="hidden" name="key" value="<?=$key?>">
								<input type="hidden" name="key_type" value="<?=$key_type?>">
								<input type="hidden" name="sorting_key" value="<?=$sorting_key?>">
								
								
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_12?></label>
                                        <div class="col-sm-9">
                                            <?
											echo ("
											<select name='new_room' class='form-control'>
											<option value=\"\">:: Select Menu ::</option>");
		
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
												if($key == $mmx_room) {
													$mmx_select = "selected";
												} else {
													$mmx_select = "";
												}
												echo ("<option value='$mmx_room' $mmx_select>[ $mmx_room ] $mmx_mname</option>");
			
			
			
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
													if($key == $smx2_room) {
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
														if($key == $smx3_room) {
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
                                    </div>
									
									
									
									<!----- Subject ----------------------------------------------------------------------------------->
									
									<? if($key_type == "week") { ?>
										
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="subject" type="date" required />
                                        </div>
                                    </div>
										
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="subject" maxlength="120" type="text" required />
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									<!----- Sub-title ----------------------------------------------------------------------------------->
									
									<? if($key_type == "week") { ?>
									
										
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 1</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page1" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 2</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page2" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 3</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page3" type="file" />
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Page 4</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page4" type="file" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">PDF File</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="page_pdf" type="file" />
                                        </div>
                                    </div>
										
									
									<? } else if($key_type == "vod") { ?>
										
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_02?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="subtitle"></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_vod_blog_03?> & <?=$txt_vod_blog_04?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="head" type="date" />
                                        </div>
										<div class="col-sm-6">
                                            <input class="form-control" id="cname" name="name" type="text" placeholder="<?=$txt_vod_blog_04?>" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_09?></label>
                                        <div class="col-sm-9">
												<input type='radio' name='m_html' value='0'> Text &nbsp;&nbsp; <input type='radio' name='m_html' value='1' checked> HTML
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
												<input type='checkbox' name='m_nlbr' value='1' checked>Line Feed
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="comment" rows="10"></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_10?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="userfile" type="file" />
                                        </div>
                                    </div>
									
										
									<? } else { ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_08?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="subtitle"></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_ch_blog_05?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='media_chk' value='1'> <font color=blue>ON</font> &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type=radio name='media_chk' value='0' checked> <font color=red>OFF</font>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_ch_blog_06?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="media_link"></textarea>
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_09?></label>
                                        <div class="col-sm-">
												<input type='radio' name='m_html' value='0'> Text &nbsp;&nbsp; <input type='radio' name='m_html' value='1' checked> HTML
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
												<input type='checkbox' name='m_nlbr' value='1' checked>Line Feed
												
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
												
												<?
												if($key_type == "islide") {
													echo ("<font color=red>[Note] Saperated by '|' for each line</font>");
												}
												?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="comment" rows="10"></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_10?></label>
                                        <div class="col-sm-6">
                                            <input type="file" class="form-control" name="userfile"> 
                                        </div>
										<div class="col-sm-1">
                                            <input type="text" name="m_width" maxlength=4 class="form-control">
                                        </div>
										<div class="col-sm-1" align=center>x</div>
										<div class="col-sm-1">
                                            <input type="text" name="m_height" maxlength=4 class="form-control">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_content_11?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="m_caption"></textarea>
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
		    <tr><td colspan=17 height=2></td></tr>");
			
			if($key_type == "alb1" OR $key_type == "alb2" OR $key_type == "alb3" OR $key_type == "alb4" OR $key_type == "alb5") {
			echo ("
		    <tr>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='1'></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='2' checked></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='3'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='4'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='5'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='6'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='7'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='8'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='9'></td>
		    </tr>");
			} else {
			echo ("
		    <tr>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='1'></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='2'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='3'></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='4' checked></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='5'></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='6'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='7'></td>
		      <td></td>
		      <td align=center><input type=radio name='m_imgdsp' value='8'></td>
		      <td></td>
		      <td align=center><input disabled type=radio name='m_imgdsp' value='9'></td>
		    </tr>");
			}
			
			echo ("
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


	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}
	
  
  if(!$m_imgdsp) {
    $m_imgdsp = "2";
  }
  if(!$m_nlbr) {
    $m_nlbr = "0";
  }
  if(!$file_att) {
    $file_att = "1";
  }
  if(!$notice_flag) {
    $notice_flag = "0";
  }
  if(!$nondis_flag) {
    $nondis_flag = "0";
  }
  
  $result_uid = mysql_query("SELECT max(uid), max(fid) FROM wpage_content",$dbconn);
  if (!$result_uid) { error("QUERY_ERROR"); exit; }
	$row_uid = mysql_fetch_row($result_uid);
  if($row_uid[0]) {
    $new_uid = $row_uid[0] + 1;
  } else {
    $new_uid = 1;
  }   
  if($row_uid[1]) {
    $new_fid = $row_uid[1] + 1;
  } else {
    $new_fid = 1;
  }
  
  $query_dep = "SELECT b_loco,b_depth FROM wpage_config WHERE room = '$new_room' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY uid DESC";
  $result_dep = mysql_query($query_dep);
  if (!$result_dep) {   error("QUERY_ERROR");   exit; }

  $new_loco = @mysql_result($result_dep,0,0);
  $new_depth = @mysql_result($result_dep,0,1);
  
  $query_pwd = "SELECT user_pw FROM admin_user WHERE user_id = '$login_id' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY uid DESC";
  $result_pwd = mysql_query($query_pwd);
  if (!$result_pwd) {   error("QUERY_ERROR");   exit; }

  $new_pwd = @mysql_result($result_pwd,0,0);
  
  $new_display = "0"; // emag


  $signdate1 = time();
  if($backup_days > 0) {
    $signdate = $signdate1 - ( 86400 * $backup_days );
  } else {
    $signdate = $signdate1;
  }
  
  $m_ip = getenv('REMOTE_ADDR');


  // Add Slashes
  $subject = addslashes($subject);
  $subtitle = addslashes($subtitle);
  $m_caption = addslashes($m_caption);

  
  if($pin_key) {
  
	if($key_type == "week") {
	
	
		if($page_pdf != "") {
		
			$new_page_pdf = "weekly_"."$new_uid".".pdf";
			
			if(!copy($page_pdf,"$savedir/$new_pade_pdf")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
	
			$query_K9 = "INSERT INTO wpage_content (uid, fid, room, b_depth, b_loco, b_type, id, name, subject, signdate, upd_date, m_ip, 
				m_filetype, userfile, lang, gate, branch_code) VALUES ($new_uid, $new_fid, '$new_room', '$new_depth', '$new_loco', 'week', '$login_id', 
				'$website_name', '$subject', $signdate, $signdate, '$m_ip', 'pdf', '$new_page_pdf', '$lang', '$key_gate', '$login_branch')";
			$result_K9 = mysql_query($query_K9);
			if (!$result_K9) { error("QUERY_ERROR"); exit; }
		
		} else {
		
			$query_K9 = "INSERT INTO wpage_content (uid, fid, room, b_depth, b_loco, b_type, id, name, subject, signdate, upd_date, m_ip, 
				m_filetype, userfile, lang, gate, branch_code) VALUES ($new_uid, $new_fid, '$new_room', '$new_depth', '$new_loco', 'week', '$login_id', 
				'$website_name', '$subject', $signdate, $signdate, '$m_ip', 'none', '', '$lang', '$key_gate', '$login_branch')";
			$result_K9 = mysql_query($query_K9);
			if (!$result_K9) { error("QUERY_ERROR"); exit; }
		
		}
		
		if($page1 != "") {
		
			$new_page1 = "weekly_"."$new_uid"."_1.jpg";
			
			if(!copy($page1,"$savedir/$new_page1")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
	
			$query_K1 = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
						VALUES ('', $new_uid, '$new_page1', '$key_gate', '$login_branch')";
			$result_K1 = mysql_query($query_K1);
			if (!$result_K1) { error("QUERY_ERROR"); exit; }
		
		}
		
		if($page2 != "") {
		
			$new_page2 = "weekly_"."$new_uid"."_2.jpg";
			
			if(!copy($page2,"$savedir/$new_page2")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
	
			$query_K2 = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
						VALUES ('', $new_uid, '$new_page2', '$key_gate', '$login_branch')";
			$result_K2 = mysql_query($query_K2);
			if (!$result_K2) { error("QUERY_ERROR"); exit; }
		
		}
		
		if($page3 != "") {
		
			$new_page3 = "weekly_"."$new_uid"."_3.jpg";
			
			if(!copy($page3,"$savedir/$new_page3")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
	
			$query_K3 = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
						VALUES ('', $new_uid, '$new_page3', '$key_gate', '$login_branch')";
			$result_K3 = mysql_query($query_K3);
			if (!$result_K3) { error("QUERY_ERROR"); exit; }
		
		}
		
		if($page4 != "") {
		
			$new_page4 = "weekly_"."$new_uid"."_4.jpg";
			
			if(!copy($page4,"$savedir/$new_page4")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
	
			$query_K4 = "INSERT INTO wpage_content_photo (uid, bbs_uid, userfile, gate, branch_code) 
						VALUES ('', $new_uid, '$new_page4', '$key_gate', '$login_branch')";
			$result_K4 = mysql_query($query_K4);
			if (!$result_K4) { error("QUERY_ERROR"); exit; }
		
		}
		
		
	
	
		echo("<meta http-equiv='Refresh' content='0; URL=$home/website_content.php?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&key_gate=$key_gate'>");
		exit;
	
	
	} else {
  
			if($userfile != "") {
			$full_filename = explode(".", "$userfile_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(!strcmp($extension,"html") or 
			   !strcmp($extension,"htm") or
			   !strcmp($extension,"php") or
			   !strcmp($extension,"php3") or
			   !strcmp($extension,"inc") or   
			   !strcmp($extension,"pl") or
			   !strcmp($extension,"cgi") or
			   !strcmp($extension,"txt") or
			   !strcmp($extension,"asp") or
			   !strcmp($extension,"jsp") or
			   !strcmp($extension,"css") or
			   !strcmp($extension,"js") or
			   !strcmp($extension,"json") or
			   !strcmp($extension,"") or
			   !strcmp($extension,"phtml")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}
			
			if($extension == "JPG" OR $extension == "jpg" OR $extension == "JPEG" OR $extension == "jpeg") {
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
			

			$new_filename = "file_"."$new_uid"."_1.{$extension2}";

			
			if(!copy("$userfile","$savedir/$userfile_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$userfile_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
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
	
		if($extension == "JPG" OR $extension == "jpg" OR $extension == "JPEG" OR $extension == "jpeg" OR $extension == "GIF" OR $extension == "gif" 
		 OR $extension == "PNG" OR $extension == "png") { // when image files
		if($m_imgdsp == "1" OR $m_imgdsp == "2" OR $m_imgdsp == "3") { // Top Image
			$new_comment = "<p><div align=center><img src='$savedir/$new_filename' $m_dimension_txt border=0'><br><div class='captionA' style='padding-top: 4px'>$m_caption</div></div></p><p>"."$comment"."</p>";
		} else if($m_imgdsp == "4") { // float:left
			$new_comment = "<p><span class='picture mid-left'><img src='$savedir/$new_filename' $m_dimension_txt border=0><br>$m_caption</span>"."$comment"."</p>";
		} else if($m_imgdsp == "6") { // float:right
			$new_comment = "<p><span class='picture mid-right'><img src='$savedir/$new_filename' $m_dimension_txt border=0><br>$m_caption</span>"."$comment"."</p>";
		} else if($m_imgdsp == "7" OR $m_imgdsp == "8" OR $m_imgdsp == "9") { // Bottom Image
			$new_comment = "<p>"."$comment"."</p><p><div align=center><img src='$savedir/$new_filename' $m_dimension_txt border=0><br><div class='captionA' style='padding-top: 4px'>$m_caption</div></div></p>";
		} else {
			$new_comment = "<p>"."$comment"."</p>";
		}
		} else {
			$new_comment = "<p>"."$comment"."</p>";
		}
		
	} else {
			$new_comment = "<p>"."$comment"."</p>";
	}
	} else {
			$new_comment = $comment;
	}
	$new_comment = addslashes($new_comment);
	
	
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
	
	
	if($userfile != "") {
	    $query_M1 = "INSERT INTO wpage_content (uid, fid, room, b_depth, b_loco, b_type, id, name, head, subject, subtitle, 
			comment,board_passwd, signdate, upd_date, ref, thread, m_ip, m_filetype, m_imgdsp, m_html, m_nlbr, m_caption, media_chk, media_link, 
			userfile, filesize, notice, nondis, display, img_count, lang, gate, branch_code)
			VALUES ($new_uid, $new_fid, '$new_room', '$new_depth', '$new_loco', '$key_type', '$login_id', '$new_name', '$new_head', '$subject', '$subtitle', 
			'$new_comment', '$new_pwd', $signdate, $signdate, 0, 'A', '$m_ip', '$extension', '$m_imgdsp', '$m_html', '$m_nlbr', '$m_caption', '$media_chk', '$media_link', 
			'$new_filename', '$userfile_size', '$notice_flag', '$nondis_flag', '$new_display', '1', '$lang', '$key_gate', '$login_branch')";
	} else {
		$query_M1 = "INSERT INTO wpage_content (uid, fid, room, b_depth, b_loco, b_type, id, name, head, subject, subtitle, 
			comment,board_passwd, signdate, upd_date, ref, thread, m_ip, m_filetype, m_imgdsp, m_html, m_nlbr, m_caption, media_chk, media_link, 
			userfile, filesize, notice, nondis, display, lang, gate, branch_code)
			VALUES ($new_uid, $new_fid, '$new_room', '$new_depth', '$new_loco', '$key_type', '$login_id', '$new_name', '$new_head', '$subject', '$subtitle', 
			'$new_comment', '$new_pwd', $signdate, $signdate, 0, 'A', '$m_ip', 'non', '$m_imgdsp', '$m_html', '$m_nlbr', '$m_caption', '$media_chk', '$media_link', 
			'none', '0', '$notice_flag', '$nondis_flag', '$new_display', '$lang', '$key_gate', '$login_branch')";
	}
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_content.php?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&key_gate=$key_gate'>");
  exit;
  
  }
  
 }
 }


}

}
?>