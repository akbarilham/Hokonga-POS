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
  
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_do_num = "SJ-"."$exp_branch_code"."-"."$post_dates";
  
  $do_note = addslashes($do_note);
 


if($act_mode == "del") {

      
		$result_D1 = mysql_query("DELETE FROM shop_purchase WHERE uid = '$uid'",$dbconn);
		if(!$result_D1) { error("QUERY_ERROR"); exit; }
		
		$result_D2 = mysql_query("DELETE FROM shop_cart WHERE order_num = '$po_num'",$dbconn);
		if(!$result_D2) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_pr_confirm.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($act_mode == "approve") {

      
		$result_CHGs = mysql_query("UPDATE shop_purchase SET order_status = '2' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_pr_confirm.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($act_mode == "send") { // PR ¹ß¼Û

		$result_CHG1 = mysql_query("UPDATE shop_purchase SET do_status = '1' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHG1) { error("QUERY_ERROR"); exit; }
		
		// Data Extraction
		$query_do = "SELECT branch_code,gate,po_num,po_qty,po_tamount,order_date FROM shop_purchase WHERE uid = '$uid'";
		$result_do = mysql_query($query_do);
		if (!$result_do) {   error("QUERY_ERROR");   exit; }

		$po_branch_code = @mysql_result($result,0,0);   
		$po_gate = @mysql_result($result,0,1);
		$po_num = @mysql_result($result,0,2);
		$po_qty = @mysql_result($result,0,3);
		$po_tamount = @mysql_result($result,0,4);
		$po_order_date = @mysql_result($result,0,5);
		
		// DO (shop_purchase_do) --- Surat Jalan
		
		
		


      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_pr_confirm.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


}

}
?>
