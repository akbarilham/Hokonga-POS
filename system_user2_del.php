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
$query = "SELECT uid,gate,subgate,user_id,user_pw2,user_level,user_name,user_email,user_website,default_lang,signdate,
          log_ip,log_in,log_out,visit,shop_code FROM admin_user WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
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
?>

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_user2_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_user2_del.php">
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
                                            $queryC2 = "SELECT count(uid) FROM client_shop WHERE userlevel > '0' AND gate = '$user_gate'";
											$resultC2 = mysql_query($queryC2);
											$total_recordC2 = @mysql_result($resultC2,0,0);

											$queryD2 = "SELECT shop_code,shop_name FROM client_shop WHERE userlevel > '0' AND gate = '$user_gate' ORDER BY shop_code ASC";
											$resultD2 = mysql_query($queryD2);

											echo("<select name='user_shop_code' class='form-control'>");

											for($i2 = 0; $i2 < $total_recordC2; $i2++) {
												$menu_code2 = mysql_result($resultD2,$i2,0);
												$menu_name2 = mysql_result($resultD2,$i2,1);
												
												if($menu_code2 == $mb_shop_code) {
													$slc2_gate = "selected";
												} else {
													$slc2_gate = "";
												}
												
												echo("<option value='$menu_code2' $slc2_gate>[ $menu_code2 ] $menu_name2</option>");
																								
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
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="user_name" value="<?=$user_name?>" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" value="<?=$email?>" name="email" maxlength="120" required />
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

	
	$query  = "DELETE FROM admin_user WHERE uid = '$user_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }
  
  
  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_user2.php?sorting_key=$sorting_key&shop_flag=$shop_flag&keyfield=$keyfield&key=$key&page=$page'>");
  exit;

}

}
?>