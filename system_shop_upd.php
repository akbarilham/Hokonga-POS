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
$uid = $_GET['uid'];
$query = "SELECT uid,branch_code,gate,subgate,code,associate,group_code,shop_code,shop_name,shop_type,manager,email,homepage,phone1,phone2,phone_fax,
          phone_cell,area,area_uid,area_code,addr1,addr2,zipcode,userlevel,signdate,memo FROM client_shop WHERE uid = '$uid'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$branch_code = $row->branch_code;
$user_gate = $row->gate;
$user_subgate = $row->subgate;
$user_code = $row->code;
$user_associate = $row->associate;
$group_code = $row->group_code;
$shop_code = $row->shop_code;
$shop_name = $row->shop_name;
$shop_type = $row->shop_type;
$shop_manager = $row->manager;
$email = $row->email;
$homepage = $row->homepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
$area = $row->area;
$area_uid = $row->area_uid;
$area_code = $row->area_code;
	$area_code1 = substr($area_code,0,3);
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$zipcode = $row->zipcode;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row->memo;


if($shop_type == "on") {
  $shop_type_chk1 = "checked";
  $shop_type_chk2 = "";
} else if($shop_type == "off") {
  $shop_type_chk1 = "";
  $shop_type_chk2 = "checked";
}
?>

						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_shop_03?>
            <span class="tools pull-right">
				<a href="system_shop_del.php?asso_type=<?=$asso_type?>&uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_shop_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='user_associate' value='<?=$user_associate?>'>
								<input type='hidden' name='asso_type' value='<?=$asso_type?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='key_pos_uid' value='<?=$key_pos_uid?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE userlevel > '1' AND userlevel < '6'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel,branch_code,associate FROM client WHERE userlevel > '1' AND userlevel < '6' 
														ORDER BY branch_code ASC, userlevel DESC, client_code ASC";
											$resultD = mysql_query($queryD);

											echo ("<select name='user_subgate' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
												$menu_corp = mysql_result($resultD,$i,3);
												$associate_flag = mysql_result($resultD,$i,4);
        
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
		
												if($menu_code == $user_subgate) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $depth_disable value='$menu_code' $slc_gate>$depth_span $menu_name [ $menu_code ]</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="dis_shop_code" value="<?=$shop_code?>" type="text" />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1"><?=$txt_comm_frm23?></div>
										<div class="col-sm-3">
                                            <input readonly class="form-control" id="cname" name="dis_branch_code" value="<?=$branch_code?>" type="text" />
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
												
												if($cn_area_uid == $area_uid) {
													$key_area_slct = "selected";
												} else {
													$key_area_slct = "";
												}
												
												echo ("<option value='$cn_area_uid' $key_area_slct>$cn_area_name_txt</option>");
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									
									
									<? if($user_associate == "1") { ?>
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
			
												if($pt_user_code == $user_code) {
													echo ("<option value='$pt_user_code' selected>$pt_user_name</option>");
												} else {
													echo ("<option value='$pt_user_code'>$pt_user_name</option>");
												}
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

											echo("<select name='consign_group_code' class='form-control'>");

											for($k = 0; $k < $total_record_k; $k++) {
												$cn_branch_code = mysql_result($result_K2,$k,0);
												$cn_group_code = mysql_result($result_K2,$k,1);
												$cn_group_name = mysql_result($result_K2,$k,2);
												$cn_group_type = mysql_result($result_K2,$k,3);
			
												if($cn_group_code == $group_code) {
													echo ("<option value='$cn_group_code' selected>$cn_group_name</option>");
												} else {
													echo ("<option value='$cn_group_code'>$cn_group_name</option>");
												}
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									<? } ?>
									
									<? } ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="shop_name" value="<?=$shop_name?>" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="shop_manager" value="<?=$shop_manager?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">POS</label>
                                        <div class="col-sm-3">
											<?
											$query_pos1 = "SELECT count(uid) FROM client_shop_pos WHERE branch_code = '$branch_code' AND shop_code = '$shop_code'";
											$result_pos1 = mysql_query($query_pos1);
											$total_pos = @mysql_result($result_pos1,0,0);

											$query_pos = "SELECT uid,pos_code,pos_name FROM client_shop_pos 
														WHERE branch_code = '$branch_code' AND shop_code = '$shop_code' ORDER BY pos_code ASC";
											$result_pos = mysql_query($query_pos);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											
											if($total_pos < 1) {
												echo ("<option value='#'>:: $txt_sales_sales_53</option>");
											} else {
												echo ("<option value='$PHP_SELF?asso_type=$asso_type&uid=$uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>:: $txt_sales_sales_54</option>");
												
												for($p = 0; $p < $total_pos; $p++) {
													$cn_pos_uid = mysql_result($result_pos,$p,0);
													$cn_pos_code = mysql_result($result_pos,$p,1);
													$cn_pos_name = mysql_result($result_pos,$p,2);
													
													if($cn_pos_uid == $key_pos_uid) {
														$cn_pos_slct = "selected";
													} else {
														$cn_pos_slct = "";
													}
			
													echo ("<option value='$PHP_SELF?asso_type=$asso_type&uid=$uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&key_pos_uid=$cn_pos_uid' $cn_pos_slct>$cn_pos_code</option>");
												}
												
											}
											echo("</select>");
											?>
                                        </div>
										<div class="col-sm-1">
                                            &nbsp;
                                        </div>
										<div class="col-sm-2">
											<?
											$query_pos2 = "SELECT pos_code,pos_name FROM client_shop_pos WHERE uid = '$key_pos_uid' ORDER BY uid ASC";
											$result_pos2 = mysql_query($query_pos2);
											
											$cn_pos_code2 = @mysql_result($result_pos2,0,0);
											$cn_pos_name2 = @mysql_result($result_pos2,0,1);
											
											
											if($key_pos_uid) {
												echo ("<input type='text' name='shop_pos_code' value='$cn_pos_code2' class='form-control'>");
											} else {
												echo ("<input type='text' name='shop_pos_code' class='form-control'>");
											}
											?>
                                        </div>
										<div class="col-sm-3">
											<?
											if($key_pos_uid) {
												echo ("
												<input type='radio' name='pos_upd_act' value='upd'> $txt_sales_sales_51 &nbsp;&nbsp; 
												<input type='radio' name='pos_upd_act' value='del'> $txt_sales_sales_52");
											} else {
												echo ("
												<input type='checkbox' name='pos_upd_add' value='1'> $txt_sales_sales_50");
											}
											?>
										</div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" value="<?=$email?>" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Office)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone1" value="<?=$phone1?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Home)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone2" value="<?=$phone2?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">FAX</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_fax" value="<?=$phone_fax?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_cell" value="<?=$phone_cell?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_15?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="zipcode" name="zipcode" value="<?=$zipcode?>" maxlength="6" type="tel" />
                                        </div>
										<div class="col-sm-7"></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_16?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr2" value="<?=$addr2?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_17?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr1" value="<?=$addr1?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_09?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>$txt_sys_shop_10</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>$txt_sys_shop_10</font> &nbsp;");
											}

											if(!strcmp($userlevel,"1")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\" CHECKED> In Process &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\"> In Process &nbsp;");
											}
   
											if(!strcmp($userlevel,"2")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\" CHECKED> <font color=blue>$txt_sys_shop_11</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\"> <font color=blue>$txt_sys_shop_11</font> &nbsp;");
											}
											?>
                                            
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3"><?=$txt_sys_client_26?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="memo"><?echo("$memo")?></textarea>
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
                                            <input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
                                        </div>
										<div class="col-sm-5"></div>
                                    </div>
											
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

	
	if(!$pos_upd_add) { $pos_upd_add = "0"; }
	
	if($pos_upd_add == "1" OR $pos_upd_act == "upd") {
		if(!$shop_pos_code) { // Alert
			popup_msg("$txt_sales_sales_chk06");
			break;
		}
	}
	
	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	$memo = addslashes($memo);
	
	
	if($user_associate == "1") {
		$query_con1 = "UPDATE client_shop SET group_code = '$consign_group_code', code = '$consign_user_code' WHERE uid = '$user_uid'"; 
		$result_con1 = mysql_query($query_con1);
		if(!$result_con1) { error("QUERY_ERROR"); exit; }
	}
	
	// Shop Details
	$query_dtl = "SELECT branch_code,gate,subgate,shop_code FROM client_shop WHERE uid = '$user_uid' ORDER BY uid ASC";
	$result_dtl = mysql_query($query_dtl);
		if (!$result_dtl) { error("QUERY_ERROR"); exit; }
	$dtl_branch_code = @mysql_result($result_dtl,0,0);
	$dtl_gate = @mysql_result($result_dtl,0,1);
	$dtl_subgate = @mysql_result($result_dtl,0,2);
	$dtl_shop_code = @mysql_result($result_dtl,0,3);
	
	
	// POS
	if($pos_upd_act == "del") {
		
		$query_pos_del = "DELETE FROM client_shop_pos WHERE uid = '$key_pos_uid'"; 
		$result_pos_del = mysql_query($query_pos_del);
		if(!$result_pos_del) { error("QUERY_ERROR"); exit; }
		
	} else if($pos_upd_act == "upd") {
		
		$query_pos_upd = "UPDATE client_shop_pos SET pos_code = '$shop_pos_code' WHERE uid = '$key_pos_uid'"; 
		$result_pos_upd = mysql_query($query_pos_upd);
		if(!$result_pos_upd) { error("QUERY_ERROR"); exit; }
		
	} else if($pos_upd_add == "1") {
		
		$query_pos_add = "INSERT INTO client_shop_pos (uid,branch_code,gate,subgate,shop_code,pos_code,pos_name,regis_date) 
						VALUES ('','$dtl_branch_code','$dtl_gate','$dtl_subgate','$dtl_shop_code','$shop_pos_code','$shop_pos_code','$post_dates')"; 
		$result_pos_add = mysql_query($query_pos_add);
		if(!$result_pos_add) { error("QUERY_ERROR"); exit; }
		
	}
	
	
	// Area Code
	// $shop_area_code = substr($shop_area,0,3);
	
	$query_AR2 = "SELECT area_code,area_name,area_zone FROM code_area WHERE uid = '$new_area_uid' ORDER BY uid ASC";
	$result_AR2 = mysql_query($query_AR2);
		if (!$result_AR2) { error("QUERY_ERROR"); exit; }
	$shop_area_code = @mysql_result($result_AR2,0,0);
	$shop_area_name = @mysql_result($result_AR2,0,1);
	$shop_area_zone = @mysql_result($result_AR2,0,2);

	$query  = "UPDATE client_shop SET userlevel = '$userlevel', shop_name = '$shop_name', 
              manager = '$shop_manager', email = '$email', homepage = '$homepage', zipcode = '$zipcode', addr1 = '$addr1', addr2 = '$addr2', 
              area_uid = '$new_area_uid', area_code = '$shop_area_code', area = '$shop_area_name', area_zone = '$shop_area_zone', 
			  phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', phone_cell = '$phone_cell', memo = '$memo' WHERE uid = '$user_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_shop.php?asso_type=$asso_type&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
	exit;
  
}

}
?>