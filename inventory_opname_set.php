<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_opname_set";
$step_next = $_POST['step_next'] ? $_POST['step_next'] : '' ; // new code for step_next post
$new_uid = $_POST['new_uid']?$_POST['new_uid']:'';
$new_branch_code = $_POST['new_branch_code']?$_POST['new_branch_code']:'';
$stock_last_dates = $_POST['stock_last_dates']?$_POST['stock_last_dates']:'';
if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_opname_set.php";
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
if(!$page) { $page = 1; }

$query = "SELECT count(uid) FROM client_branch WHERE branch_code != 'CORP_01'";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);


	// Stock in WH
	$query_ttlW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'in'";
	$result_ttlW1 = mysql_query($query_ttlW1);
		if (!$result_ttlW1) { error("QUERY_ERROR"); exit; }
	$prd_ttlW_qty_in = @mysql_result($result_ttlW1,0,0);

	$query_ttlW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code != ''";
	$result_ttlW2 = mysql_query($query_ttlW2);
		if (!$result_ttlW2) { error("QUERY_ERROR"); exit; }
	$prd_ttlW_qty_out = @mysql_result($result_ttlW2,0,0);

	$prd_ttlW_qty_now = $prd_ttlW_qty_in - $prd_ttlW_qty_out;
		$prd_ttlW_qty_now_K = number_format($prd_ttlW_qty_now);
	
	// Stock in Branch Shop
	$query_ttlSA1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code LIKE 'B%'";
	$result_ttlSA1 = mysql_query($query_ttlSA1);
		if (!$result_ttlSA1) { error("QUERY_ERROR"); exit; }
	$prd_ttlSA_qty_in = @mysql_result($result_ttlSA1,0,0);
		$prd_ttlSA_qty_in_K = number_format($prd_ttlSA_qty_in);

	$query_ttlSA2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out2' AND shop_code LIKE 'B%'";
	$result_ttlSA2 = mysql_query($query_ttlSA2);
		if (!$result_ttlSA2) { error("QUERY_ERROR"); exit; }
	$prd_ttlSA_qty_out = @mysql_result($result_ttlSA2,0,0);
		$prd_ttlSA_qty_out_K = number_format($prd_ttlSA_qty_out);
	
	$prd_ttlSA_qty_now = $prd_ttlSA_qty_in - $prd_ttlSA_qty_out;
		$prd_ttlSA_qty_now_K = number_format($prd_ttlSA_qty_now);

	// Stock in Consignment Store
	$query_ttlSB1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code LIKE 'A%'";
	$result_ttlSB1 = mysql_query($query_ttlSB1);
		if (!$result_ttlSB1) { error("QUERY_ERROR"); exit; }
	$prd_ttlSB_qty_in = @mysql_result($result_ttlSB1,0,0);
		$prd_ttlSB_qty_in_K = number_format($prd_ttlSB_qty_in);

	$query_ttlSB2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out2' AND shop_code LIKE 'A%'";
	$result_ttlSB2 = mysql_query($query_ttlSB2);
		if (!$result_ttlSB2) { error("QUERY_ERROR"); exit; }
	$prd_ttlSB_qty_out = @mysql_result($result_ttlSB2,0,0);
		$prd_ttlSB_qty_out_K = number_format($prd_ttlSB_qty_out);
	
	$prd_ttlSB_qty_now = $prd_ttlSB_qty_in - $prd_ttlSB_qty_out;
		$prd_ttlSB_qty_now_K = number_format($prd_ttlSB_qty_now);

// Grand Total
$grand_total = $prd_ttlW_qty_now + $prd_ttlSA_qty_now + $prd_ttlSB_qty_now;
$grand_total_K = number_format($grand_total);
?>
    

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Time Reset for Stock Opname
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th><?=$txt_comm_frm23?></th>
            <th>System Date</th>
			<th>Warehouse</th>
			<th>Branch Shop</th>
			<th>Associate</th>
			<th>Ending Date of Stock</th>
			<th>Update</th>
        </tr>
        </thead>
		
		
        <tbody>
<?
echo ("
<tr>
	<td><div align=right><b>TOTAL</b></div></td>
	<td><div align=right><b>$grand_total_K</b></td>
	<td><div align=right><b>$prd_ttlW_qty_now_K</b></td>
	<td><div align=right><b>$prd_ttlSA_qty_now_K</b></td>
	<td><div align=right><b>$prd_ttlSB_qty_now_K</b></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>");


$sys_signdate = time();
$sys_this_date = date("Y-m-d",$sys_signdate);
	
$time_limit = 60*60*24*$notify_new_article; 

$query = "SELECT uid,branch_code,branch_name,stock_last_date,signdate FROM client_branch WHERE branch_code != 'CORP_01' ORDER BY userlevel DESC, branch_code ASC";
$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
   $branch_code = mysql_result($result,$i,1);
   $branch_name = mysql_result($result,$i,2);
   $stock_last_date = mysql_result($result,$i,3);
		$last_date1 = substr($stock_last_date,0,4);
		$last_date2 = substr($stock_last_date,4,2);
		$last_date3 = substr($stock_last_date,6,2);
		$stock_last_dates = "$last_date1"."-"."$last_date2"."-"."$last_date3";
   $signdate = mysql_result($result,$i,4);
	    $signdates = date("Y-m-d",$signdate);
	 $baseline = mysql_result($result,$i,8);
	 $baseline2 = mysql_result($result,$i,9);
	
	
	// Stock in WH
	$query_sumW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'in' AND branch_code = '$branch_code'";
	$result_sumW1 = mysql_query($query_sumW1);
		if (!$result_sumW1) { error("QUERY_ERROR"); exit; }
	$prd_sumW_qty_in = @mysql_result($result_sumW1,0,0);

	$query_sumW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code != '' AND branch_code = '$branch_code'";
	$result_sumW2 = mysql_query($query_sumW2);
		if (!$result_sumW2) { error("QUERY_ERROR"); exit; }
	$prd_sumW_qty_out = @mysql_result($result_sumW2,0,0);

	$prd_sumW_qty_now = $prd_sumW_qty_in - $prd_sumW_qty_out;
		$prd_sumW_qty_now_K = number_format($prd_sumW_qty_now);
	
	// Stock in Branch Shop
	$query_sumSA1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code LIKE 'B%' AND branch_code = '$branch_code'";
	$result_sumSA1 = mysql_query($query_sumSA1);
		if (!$result_sumSA1) { error("QUERY_ERROR"); exit; }
	$prd_sumSA_qty_in = @mysql_result($result_sumSA1,0,0);
		$prd_sumSA_qty_in_K = number_format($prd_sumSA_qty_in);

	$query_sumSA2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out2' AND shop_code LIKE 'B%' AND branch_code = '$branch_code'";
	$result_sumSA2 = mysql_query($query_sumSA2);
		if (!$result_sumSA2) { error("QUERY_ERROR"); exit; }
	$prd_sumSA_qty_out = @mysql_result($result_sumSA2,0,0);
		$prd_sumSA_qty_out_K = number_format($prd_sumSA_qty_out);
	
	$prd_sumSA_qty_now = $prd_sumSA_qty_in - $prd_sumSA_qty_out;
		$prd_sumSA_qty_now_K = number_format($prd_sumSA_qty_now);

	// Stock in Consignment Store
	$query_sumSB1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out' AND shop_code LIKE 'A%' AND branch_code = '$branch_code'";
	$result_sumSB1 = mysql_query($query_sumSB1);
		if (!$result_sumSB1) { error("QUERY_ERROR"); exit; }
	$prd_sumSB_qty_in = @mysql_result($result_sumSB1,0,0);
		$prd_sumSB_qty_in_K = number_format($prd_sumSB_qty_in);

	$query_sumSB2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE ini = '1' AND flag = 'out2' AND shop_code LIKE 'A%' AND branch_code = '$branch_code'";
	$result_sumSB2 = mysql_query($query_sumSB2);
		if (!$result_sumSB2) { error("QUERY_ERROR"); exit; }
	$prd_sumSB_qty_out = @mysql_result($result_sumSB2,0,0);
		$prd_sumSB_qty_out_K = number_format($prd_sumSB_qty_out);
	
	$prd_sumSB_qty_now = $prd_sumSB_qty_in - $prd_sumSB_qty_out;
		$prd_sumSB_qty_now_K = number_format($prd_sumSB_qty_now);
		
	 

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$branch_name") && $key) {
    $branch_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $branch_name);
  }
  if(!strcmp($key,"$branch_code") && $key) {
    $branch_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $branch_code);
  }


  echo ("
  <tr>
    <td>[$branch_code] {$branch_name}</td>
    <td>$signdates</td>
	<td><div align=right>$prd_sumW_qty_now_K</div></td>
	<td><div align=right>$prd_sumSA_qty_now_K</div></td>
	<td><div align=right>$prd_sumSB_qty_now_K</div></td>
    
    <form name='signform1' method='post' action='inventory_opname_set.php'>
    <input type='hidden' name='step_next' value='permit_update'>
    <input type='hidden' name='new_uid' value=\"$uid\">
	<input type='hidden' name='new_branch_code' value=\"$branch_code\">
    
    <td><input type=date name='stock_last_dates' value='$stock_last_dates' max='$sys_this_date' class='form-control''></td>
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
  </tr>
  ");

   $article_num--;
}





?>
		
        </tbody>
        </table>
		</section>
		
        </div>
		
        </section>
						
						
						
    
    
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

	$stock_last_date_exp = explode("-",$stock_last_dates);
	$stock_last_date = "$stock_last_date_exp[0]"."$stock_last_date_exp[1]"."$stock_last_date_exp[2]";
		$stock_last_datetime = "$stock_last_date"."120000";
	
	$result1 = mysql_query("UPDATE client_branch SET stock_last_date = '$stock_last_date' WHERE uid = '$new_uid'");
	if (!$result1) { error("QUERY_ERROR"); exit;	}
	
	// Stock Update
	$result_s1 = mysql_query("UPDATE shop_product_list_qty SET date = '$stock_last_datetime', check_date = '$stock_last_datetime' 
				WHERE branch_code = '$new_branch_code'");
	if (!$result_s1) { error("QUERY_ERROR"); exit;	}
	
	$result_s1 = mysql_query("UPDATE shop_product_list_shop SET store_date = '$stock_last_datetime' 
				WHERE branch_code = '$new_branch_code'");
	if (!$result_s1) { error("QUERY_ERROR"); exit;	}
	
	
	
	// Stock Adjustment
	/*
	$query_ajc = "SELECT count(uid) FROM shop_product_list_qty WHERE branch_code = '$new_branch_code' AND flag = 'out' AND ini = '1'";
	$result_ajc = mysql_query($query_ajc);
		if (!$result_ajc) { error("QUERY_ERROR"); exit; }
	$total_ajc = mysql_result($result_ajc,0,0);
	
	$query_aj = "SELECT uid,branch_code,brand_code,gudang_code,group_code,shop_code,catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,date,stock,
				org_uid FROM shop_product_list_qty WHERE branch_code = '$new_branch_code' AND flag = 'out' AND ini = '1' ORDER BY uid";
	$result_aj = mysql_query($query_aj);
	if (!$result_aj) {   error("QUERY_ERROR");   exit; }

	for($li = 0; $li < $total_ajc; $li++) {
		$li_uid = mysql_result($result_aj,$li,0);
		$li_branch_code = mysql_result($result_aj,$li,1);
		$li_brand_code = mysql_result($result_aj,$li,2);
		$li_gudang_code = mysql_result($result_aj,$li,3);
		$li_group_code = mysql_result($result_aj,$li,4);
		$li_shop_code = mysql_result($result_aj,$li,5);
		$li_catg_code = mysql_result($result_aj,$li,6);
		$li_gcode = mysql_result($result_aj,$li,7);
		$li_pcode = mysql_result($result_aj,$li,8);
		$li_org_pcode = mysql_result($result_aj,$li,9);
		$li_org_barcode = mysql_result($result_aj,$li,10);
		$li_gname = mysql_result($result_aj,$li,11);
		$li_pname = mysql_result($result_aj,$li,12);
		$li_date = mysql_result($result_aj,$li,13);
		$li_stock = mysql_result($result_aj,$li,14);
		$li_org_uid = mysql_result($result_aj,$li,15);
		
		// new group_code
		$query_gc = "SELECT group_code FROM client_shop WHERE shop_code = '$li_shop_code'";
		$result_gc = mysql_query($query_gc);
			if (!$result_gc) { error("QUERY_ERROR"); exit; }
		$new_group_code = @mysql_result($result_gc,0,0);
		
		// new gudang_code
		$query_gd = "SELECT gudang_code FROM code_gudang WHERE branch_code = '$li_branch_code' ORDER BY gudang_code";
		$result_gd = mysql_query($query_gd);
			if (!$result_gd) { error("QUERY_ERROR"); exit; }
		$org_gudang_code = @mysql_result($result_gd,0,0);
		
		
		// UPDATE
		$result_UPD = mysql_query("UPDATE shop_product_list_qty SET group_code = '$new_group_code', gudang_code = '$org_gudang_code' WHERE uid = '$li_uid'");
		if(!$result_UPD) { error("QUERY_ERROR"); exit; }

		
		
		// when stock = 0
		if($li_stock < 1) {
			$result_D = mysql_query("DELETE FROM shop_product_list_qty WHERE uid = '$li_uid'");
			if(!$result_D) { error("QUERY_ERROR"); exit; }
		}
		
		// flag = 'in'
		$query_cnt = "SELECT count(uid) FROM shop_product_list_qty WHERE flag = 'in' AND branch_code = '$li_branch_code' 
					AND brand_code = '$li_brand_code' AND gudang_code = '$li_gudang_code' AND pcode = '$li_pcode' 
					AND shop_code = '' AND ini = '1' AND stock > '0'";
		$result_cnt = mysql_query($query_cnt);
			if (!$result_cnt) { error("QUERY_ERROR"); exit; }
		$cnt_flag_in = @mysql_result($result_cnt,0,0);
		
		if($cnt_flag_in < 1) {
		
			$query_WH = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,group_code,shop_code,gudang_code,
						catg_code,brand_code,gcode,pcode,org_pcode,org_barcode,stock,stock_check,stock_loss,date,check_date,virtual,ini) 
						values ('','$li_org_uid','in','$li_branch_code','$li_supp_code','','','$org_gudang_code','$li_catg_code',
						'$li_brand_code','$li_gcode','$li_pcode','$li_org_pcode','$li_org_barcode','$li_stock','0','0','$li_date','$li_date','0','1')";
			$result_WH = mysql_query($query_WH);
			if (!$result_WH) { error("QUERY_ERROR"); exit; }
			
		}
		
	

		echo ("
		$li_uid / $li_branch_code / $li_brand_code / $li_gudang_code ( $li_group_code )	$li_shop_code / $li_pcode [ $li_date ] - $li_stock [ $cnt_flag_in ]<br>
		");
   
	}
	*/

  echo("<meta http-equiv='Refresh' content='5; URL=$home/inventory_opname_set.php'>");
  exit;

}

}
?>