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

      if ($po_tax == 0) {

        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname1','$new_buyer_code','$new_currency','$H_total_price','$due_datesF','$new_process','$new_po_num','0')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; } 

      }
      
      // if ppn on, insert new row (ppn price data)
      if($po_tax == 1) {

        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname1','$new_buyer_code','$new_currency','$H_total_price','$due_datesF','$new_process','$new_po_num','0')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }        

        $query_PPN1 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname2','$new_buyer_code','$new_currency','$H_ppn_price','$due_datesF','$new_process','$new_po_num','1')";
        $result_PPN1 = mysql_query($query_PPN1);
        if (!$result_PPN1) { error("QUERY_ERROR"); exit; }

      }

    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase1.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
    exit;


} else if($act_mode == "send") { // PO ¹ß¼Û

		// PO Form
		
		
		
		// Send Email
		


      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase1.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


}

}
?>
