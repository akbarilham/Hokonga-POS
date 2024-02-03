<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  

if($mode == "order_del") {
      
		$result_D1 = mysql_query("DELETE FROM shop_purchase WHERE po_num = '$del_uid'",$dbconn);
		if(!$result_D1) { error("QUERY_ERROR"); exit; }
		
		$result_D2 = mysql_query("DELETE FROM finance WHERE pay_num = '$del_uid'",$dbconn);
		if(!$result_D2) { error("QUERY_ERROR"); exit; }
		
		$result_D3 = mysql_query("DELETE FROM shop_cart WHERE order_num = '$del_uid'",$dbconn);
		if(!$result_D3) { error("QUERY_ERROR"); exit; }
      
      // 주문 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;

}

}
?>
