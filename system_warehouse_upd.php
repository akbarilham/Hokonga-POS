<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_warehouse";

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
$query = "SELECT uid,branch_code,gate,gudang_code,gudang_name,manager,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo FROM code_gudang WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$branch_code = $row->branch_code;
$user_gate = $row->gate;
$shop_code = $row->gudang_code;
$shop_name = $row->gudang_name;
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
            <?=$txt_invn_gudang_03?>
            <span class="tools pull-right">
				<a href="system_warehouse_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_warehouse_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='new_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
        
												if($menu_code == $branch_code) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option value='$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_05?></label>
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="shop_name" value="<?=$shop_name?>" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_07?></label>
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

	
	$memo = addslashes($memo);

	$query  = "UPDATE code_gudang SET gate = '$login_gate', userlevel = '$userlevel', gudang_name = '$shop_name', 
              manager = '$shop_manager', email = '$email', homepage = '$homepage', zipcode = '$zipcode', 
              addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', 
              phone_cell = '$phone_cell', memo = '$memo', branch_code = '$new_branch_code' WHERE uid = '$user_uid'"; 

	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_warehouse.php'>");
  exit;
  

}

}
?>