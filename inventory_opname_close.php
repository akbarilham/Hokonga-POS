<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_opname_close";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_opname_close.php";


// Year Month (the eraliest)
$query_ym1 = "SELECT count(uid),date FROM shop_product_list_qty WHERE stock > 0 AND date > 1 ORDER BY date ASC";
$result_ym1 = mysql_query($query_ym1);
	if (!$result_ym1) {   error("QUERY_ERROR");   exit; }
$ym1_count = @mysql_result($result_ym1,0,0);
$ym1_date = @mysql_result($result_ym1,0,1);
		$ym1_date1 = substr($ym1_date,0,4);
		$ym1_date2 = substr($ym1_date,4,2);
$ym1_date_txt = "$ym1_date1"."-"."$ym1_date2";
$ym1_yearmonth = "$ym1_date1"."$ym1_date2";
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
//===================== new page code ======================
//Yogi Anditia
if(!$page) { 
  if(isset($_GET['page'])){
    $page = intval($_GET['page']); //get value from url
    if(intval($_GET['page'])==null){
      $page = 1;
    }else{
      $page = intval($_GET['page']); 
    }
  }else{
    $page = 1;
  }
}
//===========================================================

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
            <?=$title_module_0220?>
			
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
            <th></th>
			<th>Warehouse</th>
			<th>Branch Shop</th>
			<th>Associate</th>
			<th>Ending Date of Stock</th>
        </tr>
        </thead>
		
		
        <tbody>
<?
echo ("
<form name='signform1' method='post' action='inventory_opname_close.php'>
<input type='hidden' name='step_next' value='permit_update'>
<input type='hidden' name='step_ini' value='1'>

	
<tr>
	<td><div align=right><b>TOTAL</b></div></td>
	<td><div align=right><b>$grand_total_K</b></td>
	<td><div align=right><b>$prd_ttlW_qty_now_K</b></td>
	<td><div align=right><b>$prd_ttlSA_qty_now_K</b></td>
	<td><div align=right><b>$prd_ttlSB_qty_now_K</b></td>
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
		if($lang == "ko") {
			$stock_last_dates = "$last_date1"."/"."$last_date2"."/"."$last_date3";
		} else {
			$stock_last_dates = "$last_date3"."-"."$last_date2"."-"."$last_date1";
		}
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
    <td></td>
	<td><div align=right>$prd_sumW_qty_now_K</div></td>
	<td><div align=right>$prd_sumSA_qty_now_K</div></td>
	<td><div align=right>$prd_sumSB_qty_now_K</div></td>
    <td>$stock_last_dates</td>
  </tr>
  ");

   $article_num--;
}





?>

        </tbody>
        </table>
		
		
		<div class='form-group'>
            <div class='col-sm-3'>
				<input type="text" class="form-control" name="ending_yearmonth" value="<?=$ym1_date_txt?>">
			</div>
			<div class='col-sm-3'>
				<? if($ym1_count > 0) { ?>
				<input class="btn btn-primary" type="submit" value="Close Stock">
				<? } else { ?>
				<input disabled class="btn btn-primary" type="submit" value="Close Stock">
				<? } ?>
			</div>
		</div>
		</form>

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


	// Date Format
	$new_yearmonth_xpd = explode("-",$ending_yearmonth); // YYYY-MM
	$new_yearmonth = "$new_yearmonth_xpd[0]"."$new_yearmonth_xpd[1]"; // YYYYMM
	
	
	// Insert Starting of Stock into Old Table (Change Flag)
	if($step_ini == "1") {
		$query_cp1 = "CREATE TABLE shop_product_list_qty_{$new_yearmonth} LIKE shop_product_list_qty";
		$result_cp1 = mysql_query($query_cp1);
			if (!$result_cp1) { error("QUERY_ERROR"); exit; }

		$query_cp2 = "INSERT INTO shop_product_list_qty_{$new_yearmonth} SELECT * FROM shop_product_list_qty";
		$result_cp2 = mysql_query($query_cp2);
			if (!$result_cp2) { error("QUERY_ERROR"); exit; }
	}
	

	// Qty
	$query1c = "SELECT count(uid) FROM shop_product_list_qty WHERE date LIKE '$new_yearmonth%'";
	$result1c = mysql_query($query1c);
		if (!$result1c) { error("QUERY_ERROR"); exit; }
	$total_items = mysql_result($result1c,0,0);
	
	if($total_items > 10000) {
		$total_list = 10000;
	} else {
		$total_list = $total_items;
	}
	
	$query1 = "SELECT branch_code,gudang_code,supp_code,group_code,shop_code,catg_code,brand_code,gcode,pcode,org_pcode,org_barcode,
			flag,stock,stock_loss,uid,price_orgin FROM shop_product_list_qty WHERE date LIKE '$new_yearmonth%'";
	$result1 = mysql_query($query1);
	if (!$result1) {   error("QUERY_ERROR");   exit; }

	for($i1 = 0; $i1 < $total_list; $i1++) {
		$li_branch_code = mysql_result($result1,$i1,0);   
		$li_gudang_code = mysql_result($result1,$i1,1);
		$li_supp_code = mysql_result($result1,$i1,2);   
		$li_group_code = mysql_result($result1,$i1,3);
		$li_shop_code = mysql_result($result1,$i1,4);
		$li_catg_code = mysql_result($result1,$i1,5);   
		$li_brand_code = mysql_result($result1,$i1,6);
		$li_gcode = mysql_result($result1,$i1,7);
		$li_pcode = mysql_result($result1,$i1,8);   
		$li_org_pcode = mysql_result($result1,$i1,9);
		$li_org_barcode = mysql_result($result1,$i1,10);
		$li_flag = mysql_result($result1,$i1,11);
		$li_stock = mysql_result($result1,$i1,12);
		$li_stock_loss = mysql_result($result1,$i1,13);
		$li_uid = mysql_result($result1,$i1,14);
		$li_price_orgin = mysql_result($result1,$i1,15);
		
		$i2 = $i1 + 1;
		
		
		// Warehouse


		
		// Duplication Check (item x store)
		$query_chk1 = "SELECT count(uid) FROM final_monthly_stock 
					WHERE pcode = '$li_pcode' AND shop_code = '$li_shop_code' AND date LIKE '$new_yearmonth%'";
		$result_chk1 = mysql_query($query_chk1);
			if (!$result_chk1) { error("QUERY_ERROR"); exit; }
		$count_chk1 = @mysql_result($result_chk1,0,0);
		
		
		// Original Stock
		$query_tar1 = "SELECT uid,stock_begin,stock_in,stock_out,stock_sell,stock_loss,stock_end FROM final_monthly_stock 
					WHERE pcode = '$li_pcode' AND shop_code = '$li_shop_code' AND date LIKE '$new_yearmonth%'";
		$result_tar1 = mysql_query($query_tar1);
			if (!$result_tar1) { error("QUERY_ERROR"); exit; }
		$org_uid = @mysql_result($result_tar1,0,0);
		$org_stock_begin = @mysql_result($result_tar1,0,1);
		$org_stock_in = @mysql_result($result_tar1,0,2);
		$org_stock_out = @mysql_result($result_tar1,0,3);
		$org_stock_sell = @mysql_result($result_tar1,0,4);
		$org_stock_loss = @mysql_result($result_tar1,0,5);
		$org_stock_end = @mysql_result($result_tar1,0,6);
		
		
		if($count_chk1 > 0 AND $org_uid) {
			
			// Flags
			if($li_flag == "in") { // Stock IN
				$new_stock_begin = $org_stock_begin + $li_stock;
				$new_stock_in = $org_stock_in + $li_stock;
				$new_stock_out = $org_stock_out;
				$new_stock_sell = $org_stock_sell;
				$new_stock_loss = $org_stock_loss;
				$new_stock_end = $new_stock_in;
			} else if($li_flag == "in2") { // Return [RESET !!]
				$new_stock_begin = $org_stock_begin + $li_stock;
				$new_stock_in = $org_stock_in + $li_stock;
				$new_stock_out = $org_stock_out;
				$new_stock_sell = $org_stock_sell;
				$new_stock_loss = $org_stock_loss;
				$new_stock_end = $new_stock_in;
			} else if($li_flag == "out") { // Stock OUT
				$new_stock_begin = $org_stock_begin + $li_stock;
				$new_stock_in = $org_stock_in + $li_stock;
				$new_stock_out = $org_stock_out + $li_stock;
				$new_stock_sell = $org_stock_sell;
				$new_stock_loss = $org_stock_loss;
				$new_stock_end = $new_stock_out - $new_stock_sell - $new_stock_loss;
			} else if($li_flag == "out2") { // Sold
				$new_stock_begin = $org_stock_begin + $li_stock;
				$new_stock_in = $org_stock_in + $li_stock;
				$new_stock_out = $org_stock_out;
				$new_stock_sell = $org_stock_sell + $li_stock;
				$new_stock_loss = $org_stock_loss;
				$new_stock_end = $new_stock_out - $new_stock_sell - $new_stock_loss;
			}
		
			$result_U1 = mysql_query("UPDATE final_monthly_stock SET stock_begin = '$new_stock_begin', stock_in = '$new_stock_in', 
					stock_out = '$new_stock_out', stock_sell = '$new_stock_sell', stock_loss = '$new_stock_loss', 
					stock_end = '$new_stock_end' WHERE uid = '$org_uid'");
			if(!$result_U1) { error("QUERY_ERROR"); exit; }
			
			echo ("<font color=red>Updating</font> $i2 ... $li_pcode [ $li_shop_code ] .... $new_stock_begin | + $new_stock_in | - $new_stock_out<br>");

		} else {
			
			// Flags
			if($li_flag == "in") { // Stock IN
				$new_stock_begin = $li_stock;
				$new_stock_in = $li_stock;
				$new_stock_out = 0;
				$new_stock_sell = 0;
				$new_stock_loss = 0;
				$new_stock_end = $new_stock_in;
			} else if($li_flag == "in2") { // Return [RESET !!]
				$new_stock_begin = $li_stock;
				$new_stock_in = $li_stock;
				$new_stock_out = 0;
				$new_stock_sell = 0;
				$new_stock_loss = 0;
				$new_stock_end = $new_stock_in;
			} else if($li_flag == "out") { // Stock OUT
				$new_stock_begin = $li_stock;
				$new_stock_in = $li_stock;
				$new_stock_out = $li_stock;
				$new_stock_sell = 0;
				$new_stock_loss = 0;
				$new_stock_end = $new_stock_out - $new_stock_sell - $new_stock_loss;
			} else if($li_flag == "out2") { // Sold
				$new_stock_begin = $li_stock;
				$new_stock_in = $li_stock;
				$new_stock_out = 0;
				$new_stock_sell = $li_stock;
				$new_stock_loss = 0;
				$new_stock_end = $new_stock_out - $new_stock_sell - $new_stock_loss;
			}
		
			$query_P1 = "INSERT INTO final_monthly_stock (uid,branch_code,gudang_code,supp_code,group_code,shop_code,catg_code,brand_code,
					gcode,pcode,org_pcode,org_barcode,stock_begin,stock_in,stock_out,stock_sell,stock_loss,stock_end,date) 
					values ('','$li_branch_code','$li_gudang_code','$li_supp_code','$li_group_code','$li_shop_code','$li_catg_code','$li_brand_code',
					'$li_gcode','$li_pcode','$li_org_pcode','$li_org_barcode','$new_stock_begin','$new_stock_in','$new_stock_out',
					'$new_stock_sell','$new_stock_loss','$new_stock_end','$new_yearmonth')";
			$result_P1 = mysql_query($query_P1);
			if (!$result_P1) { error("QUERY_ERROR"); exit; }
			
			echo ("Writing $i2 ... $li_pcode [ $li_shop_code ] .... $new_stock_begin | + $new_stock_in | - $new_stock_out<br>");
			
		}
		
		// Delete
		$query_del1 = "DELETE FROM shop_product_list_qty WHERE uid = '$li_uid'";
		$result_del1 = mysql_query($query_del1);
		if (!$result_del1) { error("QUERY_ERROR"); exit; }
			
	
	}
	
	
	
	
	
	echo ("<br>Completeing $total_items ...... $ending_yearmonth [$new_yearmonth]<br><br>");
	
	
	
	if($total_items < 10000) {
		echo("<meta http-equiv='Refresh' content='5; URL=$home/inventory_opname_close.php'>");
		exit;
	} else {
		echo("<meta http-equiv='Refresh' content='5; URL=$home/inventory_opname_close.php?step_next=permit_update&ending_yearmonth=$ending_yearmonth'>");
		exit;
	}

}

}
?>