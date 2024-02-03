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
 

if($act_mode == "stage2") {

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_do_check = '$post_dates', do_status = '2' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/logistic_docheck.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

} else if($act_mode == "stage3") {

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_way_takeoff = '$post_dates', do_status = '3' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/logistic_docheck.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

} else if($act_mode == "stage4") {

		// Arrival (Destination)
		$query_do = "SELECT do_num FROM shop_product_list_do WHERE uid = '$uid'";
		$result_do = mysql_query($query_do);
			if (!$result_do) {   error("QUERY_ERROR");   exit; }
    
		$do_num = @mysql_result($result_do,0,0);
		
		
		$query_sum = "SELECT branch_code,branch_code2,gudang_code2,shop_code2 FROM shop_product_list_qty WHERE do_num = '$do_num' ORDER BY uid DESC";
		$result_sum = mysql_query($query_sum);
			if (!$result_sum) {   error("QUERY_ERROR");   exit; }
    
		$branch_code = @mysql_result($result_sum,0,0);
		$branch_code2 = @mysql_result($result_sum,0,1);
		$gudang_code2 = @mysql_result($result_sum,0,2);
		$shop_code2 = @mysql_result($result_sum,0,3);

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET branch_code = '$branch_code', branch_code2 = '$branch_code2', 
					gudang_code2 = '$gudang_code2', shop_code2 = '$shop_code2', date_way_arrival = '$post_dates', do_status = '4' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/logistic_docheck.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

} else if($act_mode == "stage5") {

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_do_done = '$post_dates', do_status = '5' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/logistic_docheck.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
      exit;

}

}
?>
