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
  
  // Purchase Order Number
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_po_num = "PO-"."$exp_branch_code"."-"."$post_dates";
  



if($cart_mode == "CART_ADD") {

      // 동일한 제품 유무여부 체크
      $query_logn = "SELECT count(uid) FROM shop_cart 
                    WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0' AND pcode = '$cart_prd_code'";
      $result_logn = mysql_query($query_logn);
      if (!$result_logn) { error("QUERY_ERROR"); exit; }   

      $cart_cnt = @mysql_result($result_logn,0,0);

      // if($cart_cnt > 0) {
      //   popup_msg("$txt_sales_sales_chk01");
      //   exit;
      
      // } else {
	  
	  
	  
	  // Product Unit Qty Definition
	  $unpack_exp = explode("|",$unpack_unit_set);
	  
	  if($unpack_unit_set != "" AND $unpack_exp[0] > "1") {
		$new_cart_qty = $cart_qty * $unpack_exp[1];
		$new_unpack_qty = $cart_qty;
	  } else {
		$new_cart_qty = $cart_qty;
		$new_unpack_qty = 0;
	  }

      
      // 카트정보 입력
      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,f_class,user_id,user_ip,
            pcode,qty,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_name,p_price,
			unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,org_pcode,org_barcode,cbm) 
            values ('','$cart_prd_uid','$login_branch','out','$login_id','$m_ip','$cart_prd_code','$new_cart_qty',
            '$cart_opt1','$cart_opt2','$cart_opt3','$cart_opt4','$cart_opt5','0','$post_dates','$cart_prd_name','$cart_price_orgin',
			'$new_unpack_qty','$unpack_exp[0]','$unpack_exp[1]','$unpack_exp[2]','$cart_org_pcode','$cart_org_barcode','$cart_cbm')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
	  
	  $result_C4 = mysql_query("UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'",$dbconn);
      if(!$result_C4) { error("QUERY_ERROR"); exit; }
      
      // 상품 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock1D.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&mode=upd&uid=$cart_prd_uid'>");
      exit;
      
      // }
      
      
} else if($cart_mode == "CART_UPD") {


	// Different Unit
	if($H_unpack_qty > 0 AND $H_unpack_unit_uid > 0) {
		$new_cart_qty2 = $new_cart_qty * $H_unpack_unit_qty;
		$new_unpack_qty2 = $new_cart_qty;
	} else {
		$new_cart_qty2 = $new_cart_qty;
		$new_unpack_qty2 = 0;
	}

      $this_cart_qty_sell = $H_prd_stock_sell + $new_cart_qty2; // 조정된 판매수량(+)
      $this_cart_qty_now = $H_prd_stock_now - $new_cart_qty2; // 조정된 재고수량(-)
      
      $result_C3 = mysql_query("UPDATE shop_cart SET qty = '$new_cart_qty2', unpack_qty = '$new_unpack_qty2', cbm = '$new_cbm' WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_C3) { error("QUERY_ERROR"); exit; }
	  
	  $result_C4 = mysql_query("UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'",$dbconn);
      if(!$result_C4) { error("QUERY_ERROR"); exit; }
      
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock1D.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&po_currency=$po_currency'>");
      exit;


} else if($cart_mode == "CART_DEL") {

      $this_cart_qty_sell = $H_prd_stock_sell; // 본래의 판매수량
      $this_cart_qty_now = $H_prd_stock_now; // 본래의 재고수량
      
      $result_D3 = mysql_query("DELETE FROM shop_cart WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_D3) { error("QUERY_ERROR"); exit; }
      
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock1D.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&po_currency=$po_currency'>");
      exit;

}

}
?>
