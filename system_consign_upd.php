<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_consign";

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
$query = "SELECT uid,branch_code,group_code,group_name,group_type,manager,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,share_normal,share_promo FROM client_consign WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$group_uid = $row->uid;
$group_branch_code = $row->branch_code;
$group_code = $row->group_code;
$group_name = $row->group_name;
$group_type = $row->group_type;
$group_manager = $row->manager;
$email = $row->email;
$homepage = $row->homepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
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
$share_normal = $row->share_normal;
$share_promo = $row->share_promo;


if($group_type == "1") {
  $group_type_chk1 = "checked";
  $group_type_chk2 = "";
  $group_type_chk3 = "";
  $group_type_chk4 = "";
  $disabledA = "";
  $disabledB = "disabled";
} else if($group_type == "2") {
  $group_type_chk1 = "";
  $group_type_chk2 = "checked";
  $group_type_chk3 = "";
  $group_type_chk4 = "";
  $disabledA = "disabled";
  $disabledB = "";
} else if($group_type == "3") {
  $group_type_chk1 = "";
  $group_type_chk2 = "";
  $group_type_chk3 = "checked";
  $group_type_chk4 = "";
  $disabledA = "disabled";
  $disabledB = "";
} else if($group_type == "4") {
  $group_type_chk1 = "";
  $group_type_chk2 = "";
  $group_type_chk3 = "";
  $group_type_chk4 = "checked";
  $disabledA = "disabled";
  $disabledB = "";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_consign_03?>
            <span class="tools pull-right">
				<a href="system_consign_del.php?uid=<?=$group_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_consign_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$group_uid?>'>
								<input type='hidden' name='user_group_code' value='<?=$group_code?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type="hidden" name="keyfield" value="<?=$keyfield?>">
								<input type="hidden" name="key" value="<?=$key?>">
								<input type="hidden" name="page" value="<?=$page?>">
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='user_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												
												if($menu_code == $shop_branch_code) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="group_code" value="<?=$group_code?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="group_name" value="<?=$group_name?>" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_07?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='group_type' value='1' <?=$group_type_chk1?>> <?=$txt_sys_shop_151?> &nbsp;&nbsp; 
											<input type=radio name='group_type' value='2' <?=$group_type_chk2?>> <?=$txt_sys_shop_152?> &nbsp;&nbsp; 
											<input type=radio name='group_type' value='3' <?=$group_type_chk3?>> Department Store &nbsp;&nbsp; 
											<input type=radio name='group_type' value='4' <?=$group_type_chk4?>> Special Store
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_consign_15?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="share_normal" value="<?=$share_normal?>" maxlength="5" type="text" style="text-align: center"/>
                                        </div>
										<div class="col-sm-1">%</div>
										<div class="col-sm-2" align=right><?=$txt_sys_consign_152?></div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="share_promo" value="<?=$share_promo?>" maxlength="5" type="text" style="text-align: center"/>
                                        </div>
										<div class="col-sm-2">% / <?=$txt_sys_consign_153?></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="group_manager" value="<?=$group_manager?>" maxlength="60" type="text" />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" name="email" value="<?=$email?>" maxlength="120" />
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_09?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>$txt_sys_supplier_10</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>$txt_sys_supplier_10</font> &nbsp;");
											}

											if(!strcmp($userlevel,"1")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\" CHECKED> In Process &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\"> In Process &nbsp;");
											}
   
											if(!strcmp($userlevel,"2")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\" CHECKED> <font color=blue>$txt_sys_supplier_11</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\"> <font color=blue>$txt_sys_supplier_11</font> &nbsp;");
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


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	$group_name = addslashes($group_name);
  
		
		// Profit Share Data
		$query_max = "SELECT share_normal,share_promo FROM client_consign_share ORDER BY upd_date DESC";
		$result_max = mysql_query($query_max);
		if (!$result_max) {   error("QUERY_ERROR");   exit; }

		$max_share_normal = @mysql_result($result_max,0,0);
		$max_share_promo = @mysql_result($result_max,0,1);
		
		if($max_share_normal != $share_normal OR $max_share_promo != $share_promo) {
		
			$query_P2 = "INSERT INTO client_consign_share (uid,branch_code,group_code,share_normal,share_promo,upd_date) 
				values ('','$login_branch','$user_group_code','$share_normal','$share_promo','$post_dates')";
			$result_P2 = mysql_query($query_P2);
			if (!$result_P2) { error("QUERY_ERROR"); exit; }
		
		}
		

	$query = "UPDATE client_consign SET userlevel = '$userlevel', group_name = '$group_name', group_type = '$group_type', 
              manager = '$group_manager', email = '$email', homepage = '$homepage', zipcode = '$zipcode', 
              addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', 
              phone_cell = '$phone_cell', memo = '$memo', share_normal = '$share_normal', share_promo = '$share_promo' WHERE uid = '$user_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_consign.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
  exit;
  

}

}
?>