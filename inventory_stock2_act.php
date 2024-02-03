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
 

if($act_mode == "check") {


		// PO Amount 변경 - 인보이스 변경 불가능 - 결제시 참고함
		

      
		$result_CHGs = mysql_query("UPDATE shop_purchase SET check_status = '1', check_date = '$post_dates' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=$mode&now_po_num=$now_po_num&uid=$uid'>");
      exit;


}

}
?>
