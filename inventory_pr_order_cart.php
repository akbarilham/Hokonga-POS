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
  
  // �ֹ���
  $exp_due_date = explode("-",$new_due_dates);
  
  $due_dates = "$exp_due_date[0]"."$exp_due_date[1]"."$exp_due_date[2]";
  $due_datesF = "$due_dates"."$post_date2";
  
  // Purchase Request Order Number
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_po_num = "PR-"."$exp_branch_code"."-"."$post_dates";
  



if($cart_mode == "CART_NEW") {

      // īƮ���� �Է�
      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,f_class,user_id,user_ip,
            pcode,qty,expire,date,p_name,p_price) 
			values ('','','$login_branch','in','$login_id','$m_ip','','$cart_qty','0','$post_dates',
			'$new_cart_pname','$new_cart_price_orgin')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
      
      // �ֹ� ����Ʈ�� ���ư���
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($cart_mode == "CART_ADD") {

      // ������ ��ǰ �������� üũ
      $query_logn = "SELECT count(uid) FROM shop_cart 
                    WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' AND pcode = '$cart_prd_code'";
      $result_logn = mysql_query($query_logn);
      if (!$result_logn) { error("QUERY_ERROR"); exit; }   

      $cart_cnt = @mysql_result($result_logn,0,0);

      // if($cart_cnt > 0) {
      //   popup_msg("$txt_sales_sales_chk01");
      //   exit;
      
      // } else {
	  
	  
      
      // īƮ���� �Է�
      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,f_class,user_id,user_ip,
            pcode,qty,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_name,p_price) 
            values ('','$cart_prd_uid','$login_branch','in','$login_id','$m_ip','$cart_prd_code','$cart_qty',
            '$cart_opt1','$cart_opt2','$cart_opt3','$cart_opt4','$cart_opt5','0','$post_dates','$cart_prd_name','$cart_price_orgin')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
      
      // ��ǰ ����Ʈ�� ���ư���
	  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php'>");
      exit;
      
      // }
      
      
} else if($cart_mode == "CART_UPD") {



      $this_cart_qty_sell = $H_prd_stock_sell + $new_cart_qty; // ������ �Ǹż���(+)
      $this_cart_qty_now = $H_prd_stock_now - $new_cart_qty; // ������ ������(-)
      
      // īƮ ����
      $result_C3 = mysql_query("UPDATE shop_cart SET qty = '$new_cart_qty' WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_C3) { error("QUERY_ERROR"); exit; }
      
      // �ֹ� ����Ʈ�� ���ư���
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($cart_mode == "CART_DEL") {

      $this_cart_qty_sell = $H_prd_stock_sell; // ������ �Ǹż���
      $this_cart_qty_now = $H_prd_stock_now; // ������ ������
      
      // īƮ ����
      $result_D3 = mysql_query("DELETE FROM shop_cart WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_D3) { error("QUERY_ERROR"); exit; }
      
      // �ֹ� ����Ʈ�� ���ư���
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


} else if($cart_mode == "ORDER") { // PR �ֹ� �߼�


      // �ֹ� �߼� ���̺� ���� �Է�
	  $new_currency = "IDR";
	  $new_process = "1";
      $new_fname = "Ref. $new_po_num";

	  
      $query_P2 = "INSERT INTO shop_purchase (uid,branch_code,gate,client_code,manager_code,f_class,po_num,
            po_qty,currency,po_tamount,order_date) values ('','$login_branch','$login_gate','$login_shop','$login_id','in','$new_po_num',
            '$H_total_qty','$new_currency','$H_total_price','$post_dates')";
      $result_P2 = mysql_query($query_P2);
      if (!$result_P2) { error("QUERY_ERROR"); exit; }
      
      
      // payment collection
		$query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,shop_code,f_class,pay_num,pay_amount,pay_amount_money,
			pay_amount_point,pay_amount_delivery,order_date) values ('','$login_branch','$login_gate','$login_shop',
			'in','$new_po_num','$H_total_price','$H_total_price','0','0','$post_dates')";
		$result_P2 = mysql_query($query_P2);
		if (!$result_P2) { error("QUERY_ERROR"); exit; }
      
      
      
      // īƮ ���� ���� (expire = 1: ó����)
      $result_P3 = mysql_query("UPDATE shop_cart SET expire = '1', order_num = '$new_po_num' 
                  WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'",$dbconn);
      if(!$result_P3) { error("QUERY_ERROR"); exit; }
      
      // ���� ����Ʈ�� ���ư���
      echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency'>");
      exit;


}

}
?>
