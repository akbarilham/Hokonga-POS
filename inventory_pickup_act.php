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
 

if($act_mode == "stage4") {

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_way_arrival = '$post_dates', do_status = '4' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pickup.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

} else if($act_mode == "stage5") {

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_do_done = '$post_dates', do_status = '5' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pickup.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

}

}
?>
