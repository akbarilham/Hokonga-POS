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
  
  // 주문일
  $exp_due_date = explode("-",$new_due_dates);
  
  $due_dates = "$exp_due_date[0]"."$exp_due_date[1]"."$exp_due_date[2]";
  $due_datesF = "$due_dates"."$post_date2";
  
  // Purchase Order Number
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_po_num = "PO-"."$exp_branch_code"."-"."$post_dates";
  



if($cart_mode == "CART_NEW") {

	if($unpack_unit_name != "" AND $unpack_unit_qty > 0) {
		$new_cart_qty2 = $new_cart_qty * $unpack_unit_qty;
		$new_unpack_unit_qty2 = $unpack_unit_qty;
	} else {
		$new_cart_qty2 = $new_cart_qty;
		$new_unpack_unit_qty2 = 0;
	}
	
	
	// IDR로 통일
	if(!$po_currency) {
		$po_currency == "IDR";
	}
	
	if($po_currency == "USD") {
		$new_cart_price_orgin2 = $new_cart_price_orgin * $now_xchange_rate;
	} else {
		$new_cart_price_orgin2 = $new_cart_price_orgin;
	}

      // 카트정보 입력
      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,f_class,user_id,user_ip,
            pcode,qty,expire,date,p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,cbm) 
			values ('','','$login_branch','out','$login_id','$m_ip','','$new_cart_qty2','0','$post_dates',
			'$new_cart_pname','$new_cart_price_orgin2','$new_cart_qty','$new_unpack_unit_qty2','$unpack_unit_name','$new_cbm')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
	  
      // 주문 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;


} else if($cart_mode == "CART_ADD") {

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
      // echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&mode=upd&uid=$cart_prd_uid&otype=$otype'>");
	  echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?otype=$otype'>");
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
      
      // 카트 수정
		if($po_currency == "USD") {
			$new_cart_amount2 = $new_cart_amount * $now_xchange_rate;
		} else {
			$new_cart_amount2 = $new_cart_amount;
		}
	  
      $result_C3 = mysql_query("UPDATE shop_cart SET p_price = '$new_cart_amount2', qty = '$new_cart_qty2', unpack_qty = '$new_unpack_qty2', cbm = '$new_cbm' 
					WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_C3) { error("QUERY_ERROR"); exit; }
	  
	  $result_C4 = mysql_query("UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'",$dbconn);
      if(!$result_C4) { error("QUERY_ERROR"); exit; }
      
      // 주문 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;

} else if($carts == "Update All") {
	
	// Deklarasi
	$query = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0'";
	$result = mysql_query($query);
	if (!$result) {   error("QUERY_ERROR");   exit; }
		
	$total = @mysql_result($result,0,0);	
	
	for ($k = 0; $k < $total; $k++){
	
	$uid_k = $uids[$k];
	
	// Different Unit
	if($H_unpack_qty > 0 AND $H_unpack_unit_uid > 0) {
		$new_cart_qty2 = $new_cart_qty[$k] * $H_unpack_unit_qty;
		$new_unpack_qty2 = $new_cart_qty[$k];
	} else {
		$new_cart_qty2 = $new_cart_qty[$k];
		$new_unpack_qty2 = 0;
	}
	
      $this_cart_qty_sell = $H_prd_stock_sell + $new_cart_qty2; // 조정된 판매수량(+)
      $this_cart_qty_now = $H_prd_stock_now - $new_cart_qty2; // 조정된 재고수량(-)
      //var_dump($now_xchange_rate);
	  
      // 카트 수정	
		if($po_currency == "USD") {
			$new_cart_amount2 = $new_cart_amount[$k] * $now_xchange_rate;
		} else {
			$new_cart_amount2 = $new_cart_amount[$k];
		}		
	  
	  $query_C3 = "UPDATE shop_cart SET p_price = '$new_cart_amount2', qty = '$new_cart_qty2', unpack_qty = '$new_unpack_qty2', cbm = '$new_cbm' 
					WHERE uid = '$uid_k'";
      $result_C3 = mysql_query($query_C3,$dbconn);
      if(!$result_C3) { error("QUERY_ERROR"); exit; }
	  //echo '<br/>'.$query_C3;
	  
	  $query_C4 = "UPDATE shop_product_list SET cbm = '$new_cbm' WHERE pcode = '$H_cart_pcode'";
	  $result_C4 = mysql_query($query_C4,$dbconn);
      if(!$result_C4) { error("QUERY_ERROR"); exit; }	  
	  
	}
	  //die();
      
      // 주문 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;

} else if($carts == "Delete") {

	  $totalhits = count($check_list);
	  
	  for($k=0; $k<$totalhits; $k++){
		
	  $au = $check_list[$k];
		
      $this_cart_qty_sell = $H_prd_stock_sell; // 본래의 판매수량
      $this_cart_qty_now = $H_prd_stock_now; // 본래의 재고수량
      
      // 카트 삭제
      $result_D3 = mysql_query("DELETE FROM shop_cart WHERE uid = '$au'",$dbconn);
      if(!$result_D3) { error("QUERY_ERROR"); exit; }
	  
	  }
      //die();
	  
      // 주문 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;


} else if($cart_mode == "ORDER") { // 주문 발송

		$do_port1 = addslashes($do_port1);
		$do_port2 = addslashes($do_port2);
		
		if($now_group_admin == "1") {
			$new_branch_code2 = $new_branch_code;
		} else {
			$new_branch_code2 = $login_branch;
		}

      $H_ppn_price = (10 / 100) * $H_total_price;    

      // Table finance
    $new_process = "1";
    $new_fname1 = "Ref. "."$new_po_num";
	  $new_fname2 = "PPN for "."$new_po_num";
	
	$eta_date = $post_date1.'|'.$post_date1.'|'.$post_date1;

      if ($po_tax == 0) {

        $query_PPN2 = "INSERT INTO shop_purchase (uid,branch_code,gate,client_code,manager_code,po_num,
              po_qty,currency,po_tamount,order_date,do_port1,do_port2,xchg_rate,items,eta_date) values ('','$new_branch_code2','$login_gate',
        '$new_buyer_code','$login_id','$new_po_num','$H_total_qty','$new_currency','$H_total_price','$due_datesF',
        '$do_port1','$do_port2','$now_xchange_rate','$items','$eta_date')";
        $result_PPN2 = mysql_query($query_PPN2);
        if (!$result_PPN2) { error("QUERY_ERROR"); exit; }

/*        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname1','$new_buyer_code','$new_currency','$H_total_price','$due_datesF','$new_process','$new_po_num','0')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }    */    

      }
      
      // if ppn on, insert new row (ppn price data)
      if($po_tax == 1) {
		
        // Insert into Tables
        $query_P2 = "INSERT INTO shop_purchase (uid,branch_code,gate,client_code,manager_code,po_num,
              po_qty,currency,po_tamount,order_date,do_port1,do_port2,xchg_rate,po_ppn,items,eta_date) values ('','$new_branch_code2','$login_gate','$new_buyer_code','$login_id','$new_po_num','$H_total_qty','$new_currency','$H_total_price','$due_datesF','$do_port1','$do_port2','$now_xchange_rate','$H_ppn_price','$items','$eta_date')";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }

/*        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname1','$new_buyer_code','$new_currency','$H_total_price','$due_datesF','$new_process','$new_po_num','0')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }        

        $query_PPN1 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on) values ('','$new_branch_code2','$login_gate','out','1',
        '$new_fname2','$new_buyer_code','$new_currency','$H_ppn_price','$due_datesF','$new_process','$new_po_num','1')";
        $result_PPN1 = mysql_query($query_PPN1);
        if (!$result_PPN1) { error("QUERY_ERROR"); exit; }  */        

      }
      
      // // Cart Update (expire = 1: In Process)
      $result_P3 = mysql_query("UPDATE shop_cart SET expire = '1', order_num = '$new_po_num' 
                   WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0'",$dbconn);
      if(!$result_P3) { error("QUERY_ERROR"); exit; }

      // Cart Delete
      /*
      $result_P4 = mysql_query("DELETE FROM shop_cart WHERE order_num = '$new_po_num' 
                   AND user_id = '$login_id' ",$dbconn);
      if(!$result_P4) { error("QUERY_ERROR"); exit; }      
      */
      
      // Retour
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;


}  else if($cart_mode == "PIB") { // 주문 발송

    $do_port1 = addslashes($do_port1);
    $do_port2 = addslashes($do_port2);

    $new_process = "1";
    $new_fname1 = "Ref. "."$po";
    $new_fname2 = "PPN for "."$po";
    $new_fname3 = "PIB for "."$po";
    $new_fname4 = "Advance for "."$po";
    $total_pib = $bea + $ppn_import + $pph_22 + $adm_bank;
    $total_advance = $freight + $thc + $adm + $docfee + $insurance;

    if($now_group_admin == "1") {
      $new_branch_code2 = $new_branch_code;
    } else {
      $new_branch_code2 = $login_branch;
    }

      $H_ppn_price = (10 / 100) * $H_total_price;      

  if($pib == "Save") { 
      $status = 3;
      $result_pib = mysql_query("UPDATE shop_purchase SET bm='$bea', ppn_import='$ppn_import', pph22='$pph_22', adm_bank='$adm_bank', status_pib= '$status', custom='$custom', freight = '$freight', thc = '$thc', adm = '$adm', docfee = '$docfee', insurance = '$insurance' WHERE po_num = '$po' ",$dbconn);
      if(!$result_pib) { error("QUERY_ERROR"); exit; }
    }
/*    if ($pib == 'Send') { 
      $status = 9;
      $result_pib = mysql_query("UPDATE shop_purchase SET bm='$bea', ppn_import='$ppn_import', pph22='$pph_22', adm_bank='$adm_bank', status_pib= '$status',custom='$custom', freight = '$freight', thc = '$thc', adm = '$adm', docfee = '$docfee', insurance = '$insurance' WHERE po_num = '$po'",$dbconn);
  
  $eta_date = $post_date1.'|'.$post_date1.'|'.$post_date1;   

        $query_F3 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on,status_pib, bm, ppn_import, pph22,adm_bank,custom) values ('','$new_branch_code','$login_gate','out','1',
        '$new_fname3','$new_buyer_code','$new_currency','$total_pib','$due_datesF','$new_process','$po','0','$status_pib','$bea','$ppn_import','$pph_22','$adm_bank', '$custom')";
        $result_F3 = mysql_query($query_F3);
        if (!$result_F3) { error("QUERY_ERROR"); exit; }        

        $query_F4 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_name,f_remark,currency,
        amount,post_date,process,pay_num,ppn_on,status_pib, freight, thc, adm, docfee, insurance) values ('','$new_branch_code','$login_gate','out','1',
        '$new_fname4','$new_buyer_code','USD','$total_advance','$due_datesF','$new_process','$po','0','$status_pib','$freight','$thc','$adm','$docfee', '$insurance')";
        $result_F4 = mysql_query($query_F4);
        if (!$result_F4) { error("QUERY_ERROR"); exit; }        

      }
      */
      // // Cart Update (expire = 1: In Process)
      $result_P3 = mysql_query("UPDATE shop_cart SET expire = '1', order_num = '$new_po_num' 
                   WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0'",$dbconn);
      if(!$result_P3) { error("QUERY_ERROR"); exit; }

    }
      
      // Retour
      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&po_currency=$po_currency&otype=$otype'>");
      exit;



}
?>
