<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


if($mode == "del") { // 상품 삭제


    // 품목 uid 추출
    $query_upd = "SELECT catg_uid,store_type FROM shop_product_list WHERE uid = '$uid'";
    $result_upd = mysql_query($query_upd);
    if(!$result_upd) { error("QUERY_ERROR"); exit; }
    $row_upd = mysql_fetch_object($result_upd);

    $new_catg_uid = $row_upd->catg_uid;
    $new_store_type = $row_upd->store_type;

    // 상품 정보 삭제
    $query  = "DELETE FROM shop_product_list WHERE uid = '$uid'"; 
    $result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }
  
    // 상품 품목 합산 (상품 리스트에서)
    $query_sum1 = "SELECT sum(tprice_orgin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
    $result_sum1 = mysql_query($query_sum1);
      if (!$result_sum1) { error("QUERY_ERROR"); exit; }
    $ts_price_orgin = @mysql_result($result_sum1,0,0);

    $query_sum2 = "SELECT sum(tprice_market) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
    $result_sum2 = mysql_query($query_sum2);
      if (!$result_sum2) { error("QUERY_ERROR"); exit; }
    $ts_price_market = @mysql_result($result_sum2,0,0);
    
    $query_sum3 = "SELECT sum(tprice_sale) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
    $result_sum3 = mysql_query($query_sum3);
      if (!$result_sum3) { error("QUERY_ERROR"); exit; }
    $ts_price_sale = @mysql_result($result_sum3,0,0);
    
    $query_sum4 = "SELECT sum(tprice_margin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
    $result_sum4 = mysql_query($query_sum4);
      if (!$result_sum4) { error("QUERY_ERROR"); exit; }
    $ts_price_margin = @mysql_result($result_sum4,0,0);
    
    $query_sum5 = "SELECT sum(stock_org) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
    $result_sum5 = mysql_query($query_sum5);
      if (!$result_sum5) { error("QUERY_ERROR"); exit; }
    $ts_stock_org = @mysql_result($result_sum5,0,0);
    
    // 상품 출고 테이블 삭제
    if($new_store_type == "1") {
      $query_2  = "DELETE FROM shop_product_list_qty WHERE org_uid = '$new_catg_uid'"; 
      $result_2 = mysql_query($query_2);
      if(!$result_2) { error("QUERY_ERROR"); exit; }
    }
    
    
    // 품목 정보 변경
    $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_sale2 = '$ts_price_sale', tprice_margin = '$ts_price_margin', 
                tstock_org = '$ts_stock_org' WHERE uid = '$new_catg_uid'",$dbconn);
    if(!$result_T) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in2.php?sorting_table=$sorting_table&sorting_key=$sorting_key&keyfield=$keyfield&key=$key'>");
  exit;


} else if($mode == "del_catg") { // 품목 삭제


  // 상품리스트에 동일한 코드가 있을 경우 삭제 불가능
  $result_dl = mysql_query("SELECT count(uid) FROM shop_product_list WHERE catg_uid = '$uid'");
  if (!$result_dl) { error("QUERY_ERROR"); exit; }
  $rows = @mysql_result($result_dl,0,0);
  
  if ($rows) {
    popup_msg("$txt_invn_stockin_chk05 \\n{$txt_invn_stockin_chk06}");
    break;
  
  } else {
  

	$query_upd = "SELECT pcode FROM shop_product_catg WHERE uid = '$uid'";
    $result_upd = mysql_query($query_upd);
		if(!$result_upd) { error("QUERY_ERROR"); exit; }
    $row_upd = mysql_fetch_object($result_upd);
	
	$del_gcode = $row_upd->pcode;
	
	// 정보 삭제
    $query = "DELETE FROM shop_product_catg WHERE uid = '$uid'"; 
    $result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }
	
	$query2 = "DELETE FROM shop_product_catg_unit WHERE gcode = '$del_gcode'"; 
    $result2 = mysql_query($query2);
    if(!$result2) { error("QUERY_ERROR"); exit; }
	
	
  
  }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in2.php?sorting_table=$sorting_table&sorting_key=$sorting_key&keyfield=$keyfield&key=$key'>");
  exit;

}

}
?>
