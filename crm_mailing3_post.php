<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }

$mmenu = "crm";
$smenu = "crm_mailing3";

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

// Mail Group
$query_G1 = "SELECT count(uid) FROM mail_user_group WHERE branch_code = '$login_branch'";
$result_G1 = mysql_query($query_G1,$dbconn);
	if (!$result_G1) { error("QUERY_ERROR"); exit; }
$total_group = @mysql_result($result_G1,0,0);
?>
    


        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?echo("$title_module_08043")?> &gt; <?=$txt_web_mailing_07?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		

		
		<div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="crm_mailing3_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='rmode' value='3'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,homepage FROM client 
														WHERE web_flag = '1' AND branch_code = '$login_branch' ORDER BY userlevel DESC";
											$resultD = mysql_query($queryD);
											if (!$resultD) {   error("QUERY_ERROR");   exit; }

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$web_client_id = mysql_result($resultD,$i,0);
												$web_client_name = mysql_result($resultD,$i,1);
												$web_client_homepage = mysql_result($resultD,$i,2);
        
												if($web_client_id == $client_id) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$PHP_SELF?keyfield=gate&key=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<? if($total_group > 0) { ?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Group</label>
                                        <div class="col-sm-9">
												<?
												echo ("
												<select name='new_room' class='form-control'>
												<option value=\"\">:: $txt_comm_frm19</option>");
						
												$query_G2 = "SELECT room FROM mail_user_group WHERE branch_code = '$login_branch' ORDER BY room ASC"; 
												$result_G2 = mysql_query($query_G2,$dbconn);
													if (!$result_G2) { error("QUERY_ERROR"); exit; }

												for($g = 0; $g < $total_group; $g++) {
													$group_name = mysql_result($result_G2,$g,0);
													
													if($room == $group_name) {
														echo ("<option value='$group_name' selected>$group_name</option>");
													} else {
														echo ("<option value='$group_name'>$group_name</option>");
													}
												}
												echo ("</select>");
												?>
                                        </div>
                                    </div>
									<? } ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="name" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Email</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="email" type="email" placeholder="example@email.com" autocomplete="off" required/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="phone" type="tel" />
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
  $new_room = addslashes($new_room);


  if($pin_key) {
  
		$result = mysql_query("SELECT count(email) FROM mail_user_list WHERE email = '$email' AND branch_code = '$login_branch'");
		if (!$result) { error("QUERY_ERROR"); exit; }
		$rows = mysql_result($result,0,0);
		if ($rows) {
			popup_msg("$txt_web_mailing_chk_01");
			break;
		} else {
		
			$query_add = "INSERT INTO mail_user_list (uid,room,name,email,phone,post_date,last_date,lang,mail_now,gate,branch_code)
						VALUES ('','$new_room','$name','$email','$phone','$dates','$dates','$lang','1','$login_gate','$login_branch')";
			$result_add = mysql_query($query_add);
			if(!$result_add) { error("QUERY_ERROR"); exit; }
		
		
		}


  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_mailing3.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&room=$new_room'>");
  exit;
  
  }
  
  }
  

}

}
?>