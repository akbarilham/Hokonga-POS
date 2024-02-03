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

      
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_do_check = '$post_dates', do_status = '2' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_delivery2.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($act_mode == "send") { // DO 발송

	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
		$post_date1d = date("ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
  
	$m_ip = getenv('REMOTE_ADDR');
	
	// SX - Sales-Data eXchange
	$exp_br_code = explode("_",$login_branch);
	$exp_branch_code = $exp_br_code[1];
	
	$new_sx_num = "SX-"."$exp_branch_code"."-"."$post_dates";
	
	// 인보이스 발행번호
	$rm_query = "SELECT max(uid) FROM shop_payment_invoice ORDER BY uid DESC";
	$rm_result = mysql_query($rm_query);
		if (!$rm_result) { error("QUERY_ERROR"); exit; }
	$max_uid = @mysql_result($rm_result,0,0);
	$new_max_uid = $max_uid + 1;

	$new_max_uid6 = sprintf("%06d", $new_max_uid); // 6자리수
  
	$new_inv_num = "INV-"."$exp_branch_code"."-"."$post_date1d"."-"."$new_max_uid6";
	
	

		
		$query_do = "SELECT uid,gate,gudang_code,shop_code,do_num,do_qty,date_do_post,date_do_check,date_do_done,do_status,
					branch_code2,gudang_code2,shop_code2,sx_num,do_tamount FROM shop_product_list_do WHERE uid = '$uid'";
		$result_do = mysql_query($query_do);
		if (!$result_do) {   error("QUERY_ERROR");   exit; }

		$do_uid = @mysql_result($result,0,0);   
		$do_gate = @mysql_result($result,0,1);
		$do_gudang_code = @mysql_result($result,0,2);
		$do_shop_code = @mysql_result($result,0,3);
		$do_num = @mysql_result($result,0,4);
		$do_qty = @mysql_result($result,0,5);
		$date_do_post = @mysql_result($result,0,6);
		$date_do_check = @mysql_result($result,0,7);
		$date_do_takeoff = @mysql_result($result,0,8);
		$date_do_arrival = @mysql_result($result,0,9);
		$date_do_done = @mysql_result($result,0,10);
		$do_status = @mysql_result($result,0,11);
		$do_cost = @mysql_result($result,0,12);
		$do_wait_avrg = @mysql_result($result,0,13);
		$do_wait = @mysql_result($result,0,14);
		$do_branch_code2 = @mysql_result($result,0,15);
		$do_gudang_code2 = @mysql_result($result,0,16);
		$do_shop_code2 = @mysql_result($result,0,17);
		$do_sx_num = @mysql_result($result,0,18);
		$do_tamount = @mysql_result($result,0,19);
   
   
		$query_sum = "SELECT sum(stock) FROM shop_product_list_qty WHERE do_num = '$do_num'";
		$result_sum = mysql_query($query_sum);
			if (!$result_sum) {   error("QUERY_ERROR");   exit; }
    
		$qty_sum = @mysql_result($result_sum,0,0);
		
		
		// SX Document Generation (Finance)
        $new_process = "2";
        $new_fname = "Ref. $new_sx_num";
		$new_ftamount = $do_tamount;
		$new_fremark1 = "SX to $do_shop_code2"." / "."$do_gudang_code2"." / "."$do_branch_code2";
		$new_fremark2 = "SX from $do_shop_code"." / "."$do_gudang_code"." / "."$login_branch";
        
		if($do_branch_code2 != $login_branch) {
		
			if($do_shop_code2 != "") {
		
				$query_F1 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
						amount,post_date,process,pay_num) values ('','$login_branch','$login_gate','in','1',
						'$new_fname','$new_fremark1','$dari_currency','$new_ftamount','$post_dates','$new_process','$new_sx_num')";
				$result_F1 = mysql_query($query_F1);
				if (!$result_F1) { error("QUERY_ERROR"); exit; }
		
				$query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
						amount,post_date,process,pay_num) values ('','$new_branch_code','$new_gudang_code','out','1',
						'$new_fname','$new_fremark2','$dari_currency','$new_ftamount','$post_dates','$new_process','$new_sx_num')";
				$result_F2 = mysql_query($query_F2);
				if (!$result_F2) { error("QUERY_ERROR"); exit; }
		
			} else { // Corporate A - Corporate B : Transaction Data into Billing Info
			
				$query_P1 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,pay_state,
							pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date) 
							values ('','$login_branch','$login_gate','$do_branch_code2','in','$new_sx_num','1',
							'$new_ftamount','$new_ftamount','0','0','$do_qty','$post_dates')";
				$result_P1 = mysql_query($query_P1);
				if (!$result_P1) { error("QUERY_ERROR"); exit; }
			
			}
		
		}
		
		
		// Send DO
		
		
		
		// Update DO Data
		$result_CHGs = mysql_query("UPDATE shop_product_list_do SET date_do_sent = '$post_dates' WHERE uid = '$uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }
		
		
		



      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_delivery2.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


}

}
?>
