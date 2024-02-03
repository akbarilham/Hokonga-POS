<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user2";

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
  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
<?
$uid = $_GET['uid'];
$query = "SELECT uid,branch_code,gate,subgate,user_id,user_pw2,user_level,user_name,user_email,user_website,default_lang,signdate,
          log_ip,log_in,log_out,visit,shop_code,shop_userlevel,pos_code FROM admin_user WHERE uid = '$uid'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
$mb_branch_code = $row->branch_code;
$user_subgate = $row->subgate;
$user_id = $row->user_id;
$user_pw2 = $row->user_pw2;
$userlevel = $row->user_level;
$user_name = $row->user_name;
$email = $row->user_email;
$homepage = $row->user_website;
$user_lang = $row->default_lang;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$log_ip = $row->log_ip;
$log_in = $row->log_in;
  if($log_in == "1") {
    $log_ins = "$txt_sys_user_12";
  } else {
    if($lang == "ko") {
      $log_ins = date("Y/m/d, H:i:s",$log_in);	
    } else {
      $log_ins = date("d-m-Y, H:i:s",$log_in);	
    }
  }
$log_out = $row->log_out;
  if($log_out == "1") {
    $log_outs = "--";
  } else {
    if($lang == "ko") {
      $log_outs = date("Y/m/d, H:i:s",$log_out);	
    } else {
      $log_outs = date("d-m-Y, H:i:s",$log_out);	
    }
  }
$log_visit = $row->visit;
$mb_shop_code = $row->shop_code;
$shop_userlevel = $row->shop_userlevel;
$mb_pos_code = $row->pos_code;
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_user2_03?>
            <span class="tools pull-right">
				<a href="system_user2_del.php?uid=<?=$user_uid?>&shop_flag=<?=$shop_flag?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_user2_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='user_gate' value='<?=$user_gate?>'>
								<input type='hidden' name='login_level' value='<?=$login_level?>'>
								<input type='hidden' name='shop_flag' value='<?=$shop_flag?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>

								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?> (Branch)</label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE userlevel > '2' AND userlevel < '6'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client WHERE userlevel > '2' AND userlevel < '6' ORDER BY client_id ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='new_user_gate' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
        
												if($menu_level > "2") {
													$depth_span = "";
													$depth_disable = "disabled";
												} else {
													$depth_span = "&nbsp;&nbsp;&gt;&nbsp;&nbsp;";
													$depth_disable = "";
												}
        
												if($menu_code == $user_gate) {
													$br_slc_hr = "selected";
													$br_slc_dis = "";
												} else {
													$br_slc_hr = "";
													$br_slc_dis = "disabled";
												}
        
												echo("<option $br_slc_dis value='$PHP_SELF?key=$menu_code&shop_flag=$shop_flag' $br_slc_hr>{$depth_span}[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>

									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user2_07?></label>
                                        <div class="col-sm-9">
										
											<?
											if($shop_flag == "1") {
												$shop_flag_acc = "1";
											} else if($shop_flag == "2") {
												$shop_flag_acc = "0";
											}
											
                                            $queryC2 = "SELECT count(uid) FROM client_shop WHERE userlevel > '0' AND associate = '$shop_flag_acc'";
											$resultC2 = mysql_query($queryC2);
											$total_recordC2 = @mysql_result($resultC2,0,0);

											$queryD2 = "SELECT shop_code,shop_name,branch_code FROM client_shop 
													WHERE userlevel > '0' AND associate = '$shop_flag_acc' ORDER BY branch_code ASC, shop_name ASC";
											$resultD2 = mysql_query($queryD2);

											echo("<select name='user_shop_code' class='form-control'>");

											for($i2 = 0; $i2 < $total_recordC2; $i2++) {
												$menu_code2 = mysql_result($resultD2,$i2,0);
												$menu_name2 = mysql_result($resultD2,$i2,1);
												$menu_branch2 = mysql_result($resultD2,$i2,2);
												
												$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$menu_branch2'";
												$result_gname = mysql_query($query_gname);
													if (!$result_gname) {   error("QUERY_ERROR");   exit; }
												$group_branch_name = @mysql_result($result_gname,0,0);
		
												
												if($menu_code2 == $mb_shop_code) {
													$slc2_gate = "selected";
												} else {
													$slc2_gate = "";
												}
												
												echo("<option value='$menu_code2' $slc2_gate>[$group_branch_name] [ $menu_code2 ] $menu_name2</option>");
																								
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="id" value='<?=$user_id?>' maxlength="12" type="id" />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">Password</div>
										<div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="passwd" value='<?=$user_pw2?>' maxlength="12" type="text" />
                                        </div>
										<div class="col-sm-3">(Unix Encoding)</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_06?></label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="user_name" value="<?=$user_name?>" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control " id="cemail" type="email" value="<?=$email?>" name="email" maxlength="120" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_20?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="pw1" maxlength="12" type="password" />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1"><?=$txt_sys_client_21?></div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="pw2" maxlength="12" type="password" />
                                        </div>
										<div class="col-sm-3"><input disabled type=checkbox name='pw_upd' value='1'>&nbsp;<font color=red><?=$txt_sys_client_22?></font></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_08?></label>
                                        <div class="col-sm-9">
                                            <?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Hold</font> &nbsp;&nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Hold</font> &nbsp;&nbsp;&nbsp; ");
											}

											if(!strcmp($userlevel,"1")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\" CHECKED> <font color=blue>Shop Manager</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\"> <font color=blue>Shop Manager</font> &nbsp;");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"></label>
                                        <div class="col-sm-9">
                                            <?
											if(!strcmp($shop_userlevel,"1")) {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"1\" CHECKED> New &nbsp;&nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"1\"> New &nbsp;&nbsp;&nbsp; ");
											}
											
											if(!strcmp($shop_userlevel,"2")) {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"2\" CHECKED> SA & Cashier &nbsp;&nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"2\"> SA & Cashier &nbsp;&nbsp;&nbsp; ");
											}
											
											if(!strcmp($shop_userlevel,"3")) {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"3\" CHECKED> Head Cashier &nbsp;&nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"3\"> Head Cashier &nbsp;&nbsp;&nbsp; ");
											}
											
											if(!strcmp($shop_userlevel,"4")) {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"4\" CHECKED> <font color=blue>Store Manager</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"shop_userlevel\" value=\"4\"> <font color=blue>Store Manager</font> &nbsp;");
											}
											?>
										</div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">POS</label>
                                        <div class="col-sm-3">
											<?
											$query_pos1 = "SELECT count(uid) FROM client_shop_pos WHERE branch_code = '$mb_branch_code' AND shop_code = '$mb_shop_code'";
											$result_pos1 = mysql_query($query_pos1);
											$total_pos = @mysql_result($result_pos1,0,0);

											$query_pos = "SELECT pos_code,pos_name FROM client_shop_pos 
														WHERE branch_code = '$mb_branch_code' AND shop_code = '$mb_shop_code' ORDER BY pos_code ASC";
											$result_pos = mysql_query($query_pos);

											echo("<select name='user_pos_code' class='form-control'>");
											echo ("<option value='#'>:: $txt_sales_sales_56</option>");
												
											for($p = 0; $p < $total_pos; $p++) {
												$cn_pos_code = mysql_result($result_pos,$p,0);
												$cn_pos_name = mysql_result($result_pos,$p,1);
													
												if($cn_pos_code == $mb_pos_code) {
													$cn_pos_slct = "selected";
												} else {
													$cn_pos_slct = "";
												}
			
												echo ("<option value='$cn_pos_code' $cn_pos_slct>$cn_pos_code</option>");
											}
												
											echo("</select>");
											?>
                                        </div>
										<div class="col-sm-6">
                                            &nbsp;
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_11?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($user_lang,"en")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"en\" CHECKED> $txt_comm_lang_en &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"en\"> $txt_comm_lang_en &nbsp;");
											}

											if(!strcmp($user_lang,"in")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"in\" CHECKED> $txt_comm_lang_in &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"in\"> $txt_comm_lang_in &nbsp;");
											}

											if(!strcmp($user_lang,"ko")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"ko\" CHECKED> $txt_comm_lang_ko &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"ko\"> $txt_comm_lang_ko &nbsp;");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_10?></label>
                                        <div class="col-sm-2">
											<input readonly class="form-control" id="log_visit" name="log_visit" value="<?=$log_visit?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_09?></label>
                                        <div class="col-sm-4">
											<input readonly class="form-control" id="log_ins" name="log_ins" value="<?=$log_ins?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
											<input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
										</div>
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

	

  if(!$pw_upd) {
	  $pw_upd == "0";
  }

  if($pw_upd == "1") {
	  if($pw1 != $pw2){
	    popup_msg("$txt_sys_user_chk03");
	    break;
	  } else {
	    $pw = "$pw1";
	  }
  }


  if($pw_upd == "1") {
	  if(!ereg("[[:alnum:]+]{4,12}",$pw1)) {
	    error("INVALID_PASSWD");
	    exit;
	  }
  }

  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  
  // Branch & Gate
  $rm_query = "SELECT branch_code,gate FROM client_shop WHERE subgate = '$user_gate' ORDER BY uid DESC";
  $rm_result = mysql_query($rm_query);
  if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $rm_branch_code = @mysql_result($rm_result,0,0);
  $rm_gate_code = @mysql_result($rm_result,0,1);

  // Update
  // if($login_level < "6") {
  if($pw_upd == "1") {
    $query  = "UPDATE admin_user SET shop_code = '$user_shop_code', pos_code = '$user_pos_code', user_level = '$userlevel', shop_userlevel = '$shop_userlevel', 
				default_lang = '$user_lang', user_pw = password('$pw'), user_pw2 = '$pw' WHERE uid = '$user_uid'"; 
  } else {
    $query  = "UPDATE admin_user SET shop_code = '$user_shop_code', pos_code = '$user_pos_code', user_level = '$userlevel', shop_userlevel = '$shop_userlevel', 
				default_lang = '$user_lang' WHERE uid = '$user_uid'"; 
  }
  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }
  // }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_user2.php?sorting_key=$sorting_key&shop_flag=$shop_flag&keyfield=$keyfield&key=$key&page=$page'>");
  exit;

}

}
?>