<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_voucher";

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
$query = "SELECT uid,branch_code,gate,voucher_code,voucher_value,currency,qty_org,qty_sell,qty_now,
          onoff,post_date,expire_date FROM shop_voucher WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$shop_uid = $row->uid;
$shop_branch_code = $row->branch_code;
$shop_gate = $row->gate;
$voucher_code = $row->voucher_code;
$voucher_value = $row->voucher_value;
  $voucher_value_K = number_format($voucher_value);
$upd_currency = $row->currency;
$qty_org = $row->qty_org;
$qty_sell = $row->qty_sell;
$qty_now = $row->qty_now;
$onoff = $row->onoff;
$post_dates = $row->post_date;
$expire_dates = $row->expire_date;


// 통화
if($upd_currency == "USD") {
  $currency_chk_IDR = "";
  $currency_chk_USD = "checked";
} else {
  $currency_chk_IDR = "checked";
  $currency_chk_USD = "";
}

// 화폐 단위
if($upd_currency == "USD") {
  $currency_tag = "US$";
} else {
  $currency_tag = "Rp.";
}

// Activation
if($onoff == "1") {
  $onoff_chk0 = "";
  $onoff_chk1 = "checked";
} else {
  $onoff_chk0 = "checked";
  $onoff_chk1 = "";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_voucher_03?>
            <span class="tools pull-right">
				<a href="system_voucher_del.php?uid=<?=$shop_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_voucher_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='shop_uid' value='<?=$shop_uid?>'>
								<input type='hidden' name='old_qty_sell' value='<?=$qty_sell?>'>
								<input type='hidden' name='key_field' value='<?=$key_field?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_voucher_06?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="dis_voucher_value" value="<?=$currency_tag?> <?=$voucher_value_K?>" type="text" />
                                        </div>
										<div class="col-sm-6">
											
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_voucher_07?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="new_qty_org" value="<?=$qty_org?>" type="text" />
                                        </div>
										<div class="col-sm-1">-</div>
										<div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="dis_qty_sell" value="<?=$qty_sell?>" type="text" />
                                        </div>
										<div class="col-sm-1">=</div>
										<div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="dis_qty_now" value="<?=$qty_now?>" type="text" />
                                        </div>
										
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_voucher_09?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="new_post_dates" value="<?=$post_dates?>" type="date" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_voucher_10?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="new_expire_dates" value="<?=$expire_dates?>" type="date" />
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_voucher_08?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='new_onoff' value='1' <?=$onoff_chk1?>> <font color=blue>On</font> &nbsp;&nbsp;&nbsp; 
											<input type=radio name='new_onoff' value='0' <?=$onoff_chk0?>> <font color=red>Off</font>
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


	// 바우처 수량
	$new_qty_now = $new_qty_org - $old_qty_sell;

	$query  = "UPDATE shop_voucher SET qty_org = '$new_qty_org', qty_now = '$new_qty_now', onoff = '$new_onoff', 
            post_date = '$new_post_dates', expire_date = '$new_expire_dates' WHERE uid = '$shop_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_voucher.php?keyfield=$keyfield&key=$key&page=$page'>");
  exit;
  
  
}

}
?>