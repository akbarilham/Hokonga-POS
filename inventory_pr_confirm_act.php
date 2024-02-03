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
 

if($act_mode == "approve") {

      
		$result_CHGs = mysql_query("UPDATE shop_purchase SET order_status = '2' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_confirm.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($act_mode == "send") { // PR ¹ß¼Û



      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_confirm.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


}

}
?>
