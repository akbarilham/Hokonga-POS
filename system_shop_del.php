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
$query = "SELECT uid,branch_code,gate,subgate,associate,shop_code,shop_name,shop_type,manager,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo FROM client_shop WHERE uid = '$uid'";

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
$user_associate = $row->associate;
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
            <?=$txt_sys_shop_04?>
            <span class="tools pull-right">
				<a href="system_shop_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_shop_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='user_associate' value='<?=$user_associate?>'>
								<input type='hidden' name='asso_type' value='<?=$asso_type?>'>
								
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
									
									<? if($user_associate == "1") { ?>
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

											echo("<select name='consign_code' class='form-control'>");

											for($k = 0; $k < $total_record_k; $k++) {
												$cn_branch_code = mysql_result($result_K2,$k,0);
												$cn_group_code = mysql_result($result_K2,$k,1);
												$cn_group_name = mysql_result($result_K2,$k,2);
												$cn_group_type = mysql_result($result_K2,$k,3);
			
												if($cn_group_code == $user_consign_code) {
													echo ("<option value='$cn_group_code' selected>$cn_group_name</option>");
												} else {
													echo ("<option disabled value='$cn_group_code'>$cn_group_name</option>");
												}
											}
											echo("</select>");
											?>
                                        </div>
                                    </div>
									<? } ?>
									
									
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
                                            <input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
                                        </div>
										<div class="col-sm-5"></div>
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

	

	$query  = "DELETE FROM client_shop WHERE uid = '$user_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_shop.php?asso_type=$asso_type'>");
	exit;
  
}

}
?>