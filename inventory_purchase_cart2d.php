<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$key_shop) {
	$key_shop = "host";
}


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
  $exp_due_date = explode("-",$new_due_dates);
  
  $due_dates = "$exp_due_date[0]"."$exp_due_date[1]"."$exp_due_date[2]";
  $due_datesF = "$due_dates"."$post_date2";



$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

  

// Filtering
if(!$sorting_key) { $sorting_key = "pname"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "gname") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "pname") { $chk6 = "selected"; } else { $chk6 = ""; }
if($sorting_key == "org_pcode") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "org_barcode") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "post_date") { $chk5 = "selected"; } else { $chk5 = ""; }


if(!$page) { $page = 1; }


// Total
$queryAll = "SELECT count(uid) FROM shop_product_list";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list WHERE pname != ''";
} else {
  $encoded_key = urlencode($key);
  if($keyfield == "all") {
	$query = "SELECT count(uid) FROM shop_product_list WHERE org_pcode LIKE '%$key%' OR gname LIKE '%$key%' OR pname LIKE '%$key%'";
  } else {
	$query = "SELECT count(uid) FROM shop_product_list WHERE $keyfield LIKE '%$key%' AND pname != ''";  
  }
}

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




// LOOPING
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,pname,price_orgin,stock_org,stock_sell,stock_now,
			supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
			product_option4,product_option5,cbm,gname,unit FROM shop_product_list WHERE pname != '' ORDER BY $sorting_key $sort_now";
  } else {
	if($keyfield == "all") {
		$query = "SELECT uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,pname,price_orgin,stock_org,stock_sell,stock_now,
			supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
			product_option4,product_option5,cbm,gname,unit FROM shop_product_list WHERE org_pcode LIKE '%$key%' OR gname LIKE '%$key%' OR pname LIKE '%$key%' 
			ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,pname,price_orgin,stock_org,stock_sell,stock_now,
			supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
			product_option4,product_option5,cbm,gname,unit FROM shop_product_list WHERE $keyfield LIKE '%$key%' AND pname != '' ORDER BY $sorting_key $sort_now";
	}
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_branch = mysql_result($result,$i,1);
   $prd_catg = mysql_result($result,$i,2);
      $prd_catg1 = substr($prd_catg,0,1);
      $prd_catg2 = substr($prd_catg,1,1);
      $prd_catg_txt = "$prd_catg1"."."."$prd_catg2".".";
   $prd_gcode = mysql_result($result,$i,3);
   $prd_pcode = mysql_result($result,$i,4);
   $org_pcode = mysql_result($result,$i,5);
   $org_barcode = mysql_result($result,$i,6);
   $prd_name = mysql_result($result,$i,7);
		$prd_name = stripslashes($prd_name);
   $prd_price_orgin = mysql_result($result,$i,8);
      $prd_price_orgin_K = number_format($prd_price_orgin);
   $prd_stock_org = mysql_result($result,$i,9);
      $prd_stock_org_K = number_format($prd_stock_org);
   $prd_stock_sell = mysql_result($result,$i,10);
      $prd_stock_sell_K = number_format($prd_stock_sell);
   $prd_stock_now = mysql_result($result,$i,11);
      $prd_stock_now_K = number_format($prd_stock_now);
   $H_supp_code = mysql_result($result,$i,12);
   $H_shop_code = mysql_result($result,$i,13);
   $H_prd_color = mysql_result($result,$i,14);
   $H_prd_size = mysql_result($result,$i,15);
   $H_prd_confirm = mysql_result($result,$i,16);
   $H_p_opt1 = mysql_result($result,$i,17);
   $H_p_opt2 = mysql_result($result,$i,18);
   $H_p_opt3 = mysql_result($result,$i,19);
   $H_p_opt4 = mysql_result($result,$i,20);
   $H_p_opt5 = mysql_result($result,$i,21);
   $H_cbm = mysql_result($result,$i,22);
   $prd_gname = mysql_result($result,$i,23);
		$prd_gname = stripslashes($prd_gname);
   $H_unit = mysql_result($result,$i,24);
   
	 
   
   $query_sub = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'in'";
   $result_sub = mysql_query($query_sub);
   
   $sum_qty_org = @mysql_result($result_sub,0,0);
   
	// Total Quantity
    $query_sux = "SELECT price_orgin, sum(stock) FROM shop_product_list_qty WHERE org_uid = '$prd_uid' AND flag = 'in'";
    $result_sux = mysql_query($query_sux);
   
    $sumx_price_org = @mysql_result($result_sux,0,0);
    $sumx_qty_org = @mysql_result($result_sux,0,1);
      
    $sumx_tprice_org = $sumx_price_org * $sumx_qty_org;
      
      
    // Sub-Table
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'in'";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);

	
	// Cart
	$query_H = "SELECT uid,pcode,qty,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency FROM shop_cart 
				WHERE user_id = '$login_id' AND pcode = '$prd_pcode' AND f_class = 'out' AND expire = '0' ORDER BY date ASC";
    $result_H = mysql_query($query_H);
      if (!$result_H) {   error("QUERY_ERROR");   exit; }
    $H_cart_uid = @mysql_result($result_H,0,0);
    $H_pcode = @mysql_result($result_H,0,1);
    $H_qty = @mysql_result($result_H,0,2);
			$H_unpack_qty = @mysql_result($result_H,0,3);
	$H_unpack_unit_uid = @mysql_result($result_H,0,4);
	$H_unpack_unit_qty = @mysql_result($result_H,0,5);
	$H_unpack_unit_name = @mysql_result($result_H,0,6);
	$H_currency = @mysql_result($result_H,0,7);
	
		// by Product Unit
		if($H_unpack_qty > 0) {
			if($H_pcode != "") {
				$H2_qty = $H_unpack_qty;
			} else {
				$H2_qty = $H_unpack_qty;
			}
		} else {
			$H2_qty = $H_qty;
		}
	
	// echo "($H_cart_uid) $new_cart_qty[$prd_uid]<br>";
	
	
	if($H_cart_uid > 0) {
		
		// Different Unit
		if($H_unpack_qty > 0 AND $H_unpack_unit_uid > 0) {
			$new_cart_qty2[$prd_uid] = $new_cart_qty[$prd_uid] * $H_unpack_unit_qty;
			$new_unpack_qty2[$prd_uid] = $new_cart_qty[$prd_uid];
		} else {
			$new_cart_qty2[$prd_uid] = $new_cart_qty[$prd_uid];
			$new_unpack_qty2[$prd_uid] = 0;
		}

		$result_C3 = mysql_query("UPDATE shop_cart SET qty = '$new_cart_qty2[$prd_uid]', unpack_qty = '$new_unpack_qty2[$prd_uid]', cbm = '$new_cbm' WHERE uid = '$H_cart_uid'",$dbconn);
		if(!$result_C3) { error("QUERY_ERROR"); exit; }
	  
		// $result_C4 = mysql_query("UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'",$dbconn);
		// if(!$result_C4) { error("QUERY_ERROR"); exit; }

	} else {
		
		// Product Unit Qty Definition
		$unpack_exp = explode("|",$unpack_unit_set[$prd_uid]);
	  
		if($unpack_unit_set[$prd_uid] != "" AND $unpack_exp[0] > "1") {
			$new_cart_qty2[$prd_uid] = $new_cart_qty[$prd_uid] * $unpack_exp[1];
			$new_unpack_qty2[$prd_uid] = $new_cart_qty[$prd_uid];
		} else {
			$new_cart_qty2[$prd_uid] = $new_cart_qty[$prd_uid];
			$new_unpack_qty2[$prd_uid] = 0;
		}

		if($new_cart_qty[$prd_uid] > 0) {
		
			$query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,f_class,user_id,user_ip,
					pcode,qty,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_name,p_price,
					unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,org_pcode,org_barcode,cbm) 
					values ('','$prd_uid','$login_branch','out','$login_id','$m_ip','$prd_pcode','$new_cart_qty2[$prd_uid]',
					'$H_p_opt1','$H_p_opt2','$H_p_opt3','$H_p_opt4','$H_p_opt5','0','$post_dates','$prd_name','$prd_price_orgin',
					'$new_unpack_qty2[$prd_uid]','$unpack_exp[0]','$unpack_exp[1]','$unpack_exp[2]','$org_pcode','$org_barcode','$cart_cbm')";
			$result_C2 = mysql_query($query_C2);
			if (!$result_C2) { error("QUERY_ERROR"); exit; }
	  
			// $result_C4 = mysql_query("UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'",$dbconn);
			// if(!$result_C4) { error("QUERY_ERROR"); exit; }
		
		}

	
	}
	
}
  


echo("<meta http-equiv='Refresh' content='0; URL=inventory_stock1D.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&po_currency=$po_currency'>");
exit;

}
?>
