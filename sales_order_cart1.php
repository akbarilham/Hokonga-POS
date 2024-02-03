<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
  //=============== get value from post ==================
  if(isset($_POST['key']) ){// new code for post
  $key = $_POST['key'];
  }
  if (isset($_POST['key_shop'])) {
    $key_shop = $_POST['key_shop'];
  }
  if (isset($_POST['sorting_key'])) {
    $sorting_key = $_POST['sorting_key'];
  }
  if (isset($_POST['keyfield'])) {
    $keyfield = $_POST['keyfield'];
  }
  if(isset($_POST['cart_mode'])){
    $cart_mode = $_POST['cart_mode'];
  } 
  if(isset($_POST['page'])){
    $page = $_POST['page'];
  }
  if(isset($_POST['add_mode'])){
    $add_mode = $_POST['add_mode'];
  }

   if (isset($_POST['H_cart_uid'])) {
    $H_cart_uid = $_POST['H_cart_uid'];
   }
  if(isset($_POST['add_mode'])){
    $add_mode = $_POST['add_mode'];
  } // new code for step_next post

  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  // 결제 예정일
  $due_date_xp = explode("-",$add_due_dates);
  if ( ! isset($due_date_xp[1]) || ! isset($due_date_xp[2])) {
   $due_date_xp[1] = null;
   $due_date_xp[2] = null;
  }
  $due_dates = "$due_date_xp[0]"."$due_date_xp[1]"."$due_date_xp[2]";
  $due_datesF = "$due_dates"."$post_date2";
  
  // 만기일
  $tempo_dates = $tempo_date1 + $tempo_date2 + $tempo_date3;
  
  
  $m_ip = getenv('REMOTE_ADDR');
  
  // Sales Number
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_pay_num = "SO-"."$exp_branch_code"."-"."$signdate";
  

  
  $m_ip = getenv('REMOTE_ADDR');
  
  $new_branch_code = $login_branch;
  $new_shop_code = $login_shop;
  
  
  // Redirection Link
  $order_redirect = "sales_order1.php";
  

  
if($cart_mode == "CART_UPD") {

    // Kondisi Jika harga setelah dipotong < harga faktur
	// Youngkay Edited 22-08-2013
    
	
      $this_cart_qty_sell = $H_prd_stock_sell + $new_cart_qty; // 조정된 판매수량(+)
      $this_cart_qty_now = $H_prd_stock_now - $new_cart_qty; // 조정된 재고수량(-)
      
      // 카트 수정
      $result_C3 = mysql_query("UPDATE shop_cart SET qty = '$new_cart_qty', p_saleprice = '$new_unit_saleprice' 
                  WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_C3) { error("QUERY_ERROR"); exit; }
      
      // Shop별 하위 테이블 상품 재고정보 수정
      $result_CHG3 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$this_cart_qty_sell', 
                    qty_now = '$this_cart_qty_now' WHERE uid = '$H_shop_uid'",$dbconn);
      if(!$result_CHG3) { error("QUERY_ERROR"); exit; }
      
      // 상품 재고정보 수정 ------------------------------------------------------------------------- //
      $s_queryX = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$H_prd_code'";
      $s_resultX = mysql_query($s_queryX,$dbconn);
              if (!$s_resultX) { error("QUERY_ERROR"); exit; }
      $sX_qty_org = @mysql_result($s_resultX,0,0);
      $sX_qty_now = @mysql_result($s_resultX,0,1);
      $sX_qty_sell = @mysql_result($s_resultX,0,2);
      
      $result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$sX_qty_sell', 
                    stock_now = '$sX_qty_now' WHERE pcode = '$H_prd_code'",$dbconn);
      if(!$result_qs2) { error("QUERY_ERROR"); exit; }
      
      //status if credit or cash
     if (isset($_POST['stat'])) {
        $stat = $_POST['stat'];
      } 
      
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$order_redirect?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&stat=$stat'>");
      exit;
	  
	  
} else if($cart_mode == "CART_ADD") {


      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,qty,
            p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_price,p_saleprice) 
            values ('','$cart_prd_uid','$new_branch_code','$new_shop_code','in','$login_id','$m_ip',
            '$cart_prd_code','$cart_qty','$cart_opt1','$cart_opt2','$cart_opt3','$cart_opt4','$cart_opt5','0',
			'$post_dates','$new_price_sale','$cart_price_sale')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
      
      $query_hd1 = "SELECT uid,qty_sell,qty_now FROM shop_product_list_shop WHERE uid = '$cart_prd_uid'";
      $result_hd1 = mysql_query($query_hd1);
        if(!$result_hd1) { error("QUERY_ERROR"); exit; }
      $row_hd1 = mysql_fetch_object($result_hd1);

      $hd1_uid = $row_hd1->uid;
      $hd1_stock_sell = $row_hd1->qty_sell;
      $hd1_stock_now = $row_hd1->qty_now;
      
      $re1_stock_sell = $hd1_stock_sell + $new_qty_sell;
      $re1_stock_now = $hd1_stock_now - $new_qty_sell;
      
      $result_re1 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$re1_stock_sell', 
                    qty_now = '$re1_stock_now' WHERE uid = '$cart_prd_uid'",$dbconn);
      if(!$result_re1) { error("QUERY_ERROR"); exit; }
      
      
      // 상품 재고정보 수정 ------------------------------------------------------------------------- //
      $query_qs1 = "SELECT uid,stock_sell,stock_now FROM shop_product_list WHERE pcode = '$cart_prd_code'";
      $result_qs1 = mysql_query($query_qs1);
        if(!$result_qs1) { error("QUERY_ERROR"); exit; }
      $row_qs1 = mysql_fetch_object($result_qs1);

      $qs1_uid = $row_qs1->uid;
      $qs1_stock_sell = $row_qs1->stock_sell;
      $qs1_stock_now = $row_qs1->stock_now;
      
      $qs2_stock_sell = $qs1_stock_sell + $new_qty_sell;
      $qs2_stock_now = $qs1_stock_now - $new_qty_sell;
      
      
      $result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$qs2_stock_sell', 
                    stock_now = '$qs2_stock_now' WHERE pcode = '$cart_prd_code'",$dbconn);
      if(!$result_qs2) { error("QUERY_ERROR"); exit; }
      
      //status if credit or cash
      if (isset($_POST['stat'])) {
        $stat = $_POST['stat'];
      }
      
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$order_redirect?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&stat=$stat'>");
      exit;


} else if($cart_mode == "CART_DEL") {

      $this_cart_qty_sell = $H_prd_stock_sell; // 본래의 판매수량
      $this_cart_qty_now = $H_prd_stock_now; // 본래의 재고수량
      
      // 카트 삭제
      $result_D3 = mysql_query("DELETE FROM shop_cart WHERE uid = '$H_cart_uid'",$dbconn);
      if(!$result_D3) { error("QUERY_ERROR"); exit; }
      
      // Shop별 하위 테이블 상품 재고정보 수정
      $result_CHG3 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$this_cart_qty_sell', 
                    qty_now = '$this_cart_qty_now' WHERE uid = '$H_shop_uid'",$dbconn);
      if(!$result_CHG3) { error("QUERY_ERROR"); exit; }
      
      // 상품 재고정보 수정 ------------------------------------------------------------------------- //
      $s_queryX = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$H_prd_code'";
      $s_resultX = mysql_query($s_queryX,$dbconn);
              if (!$s_resultX) { error("QUERY_ERROR"); exit; }
      $sX_qty_org = @mysql_result($s_resultX,0,0);
      $sX_qty_now = @mysql_result($s_resultX,0,1);
      $sX_qty_sell = @mysql_result($s_resultX,0,2);
      
      $result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$sX_qty_sell', 
                    stock_now = '$sX_qty_now' WHERE pcode = '$H_prd_code'",$dbconn);
      if(!$result_qs2) { error("QUERY_ERROR"); exit; }
      
	//status if credit or cash
      if (isset($_POST['stat'])) {
        $stat = $_POST['stat'];
      }
      
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$order_redirect?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&stat=$stat'>");
      exit;



} else if($cart_mode == "ORDER") { // 주문/결제 처리


      // 회원 구분 (new_buyer_type --> mb_type) 0=비회원, 1=개인 회원, 2=기업 회원
      
          $new_due_dates = $due_dates;
          $new_pay_datesF = $due_datesF;
 
      
      
	  // (1) 특별 할인가 적용
	  $new_pay_promo_rate = 1 - ( $new_pay_promo / 100 );
	  
	  if($new_pay_promo > 0) {
		$new_final_amountA = $new_final_amount * $new_pay_promo_rate;
	  } else {
		$new_final_amountA = $new_final_amount;
	  }
	  
	  // (2) 회원 할인가 적용
      $new_pay_dc_rate = 1 - ( $new_pay_saleoff / 100 );
      
      if($new_pay_saleoff > 0) {
        $new_final_amountB = $new_final_amountA * $new_pay_dc_rate;
      } else {
	    $new_final_amountB = $new_final_amountA;
	  }
      
      
      // 바우처 결제 합계
      $exp_voucher = explode("|",$new_pay_voucher_set);
      $new_pay_voucher_uid = $exp_voucher[0];
      $new_pay_voucher_value = $exp_voucher[1];
      
      $new_pay_voucher = $new_pay_voucher_value * $new_pay_voucher_qty;
      
      
      
      // 바우처 결제 -> 포인트 결제
      $H_total_price_money = $new_final_amountB - $new_pay_voucher;
      
      // 신용 거래
      if($stat == "credit") {
        $new_pay_type = "credit";
      } else {
        if(!$new_pay_type) {
          $new_pay_type = "cash";
        }
      }
	  
	  
		// Buyer Name
		$query_bname = "SELECT name,corp_name FROM member_main WHERE code = '$new_buyer_code'";
		$result_bname = mysql_query($query_bname);
        $new_buyer_name1 = @mysql_result($result_bname,0,0);
		$new_buyer_name2 = @mysql_result($result_bname,0,1);
		
		if($new_buyer_name1 != "") {
			$new_buyer_name = $new_buyer_name1;
		} else {
			$new_buyer_name = $new_buyer_name2;
		}
					
      
      // 결제 정보 테이블에 정보 입력
      $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,shop_code,f_class,mb_type,client_code,name1,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_card,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,
            order_date,pay_date,due_date) values ('','$login_branch','$login_gate','$login_shop','in','$new_buyer_type','$new_buyer_code','$new_buyer_name',
			'$new_pay_num','$new_shop_bank','$new_remit_code','$new_pay_type','$new_pay_bank','$new_pay_card','1','$new_final_amountB','$H_total_price_money',
            '$new_pay_voucher','0','$post_dates','$new_pay_datesF','$new_due_dates')";
      $result_P2 = mysql_query($query_P2);
      if (!$result_P2) { error("QUERY_ERROR"); exit; }
	  
	  // Mileage Point
	  if($new_buyer_type > "0") {
	  
		$mp_queryX = "SELECT shop_point FROM member_main WHERE code = '$new_buyer_name'";
		$mp_resultX = mysql_query($mp_queryX,$dbconn);
              if (!$mp_resultX) { error("QUERY_ERROR"); exit; }
		$my_point = @mysql_result($mp_resultX,0,0);
	  
		$my_points = $my_point + $new_mpoint;	
		$result_ref = mysql_query("UPDATE member_main SET shop_point = $my_points WHERE code = '$new_buyer_name'",$dbconn);
		if(!$result_ref) { error("QUERY_ERROR"); exit; }
		
	  }
      
      // finance 정보 테이블에 정보 입력
      
      
      

      
      // 카트 정보 수정 (expire = 1: 처리중)
      $result_P3 = mysql_query("UPDATE shop_cart SET expire = '1', pay_num = '$new_pay_num' 
                  WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'",$dbconn);
      if(!$result_P3) { error("QUERY_ERROR"); exit; }
      
      
      // 바우처 수량 정보 수정
      $query_P4 = "SELECT qty_org,qty_sell,qty_now FROM shop_voucher WHERE uid = '$new_pay_voucher_uid'";
      $result_P4 = mysql_query($query_P4,$dbconn);
    
      $V1_qty_org = @mysql_result($result_P4,0,0);
      $V1_qty_sell = @mysql_result($result_P4,0,1);
      $V1_qty_now = @mysql_result($result_P4,0,2);
      
      $V2_qty_sell = $V1_qty_sell + $new_pay_voucher_qty;
      $V2_qty_now = $V1_qty_now - $new_pay_voucher_qty;
      
      $result_P5 = mysql_query("UPDATE shop_voucher SET qty_sell = '$V2_qty_sell', qty_now = '$V2_qty_now' 
                  WHERE uid = '$new_pay_voucher_uid'",$dbconn);
      if(!$result_P5) { error("QUERY_ERROR"); exit; }
      
      
      
      
      // 카트 정보 루핑
      $query_HC = "SELECT count(uid) FROM shop_cart 
                  WHERE pay_num = '$new_pay_num' AND user_id = '$login_id' AND f_class = 'in' AND expire = '1'";
      $result_HC = mysql_query($query_HC);
      if (!$result_HC) {   error("QUERY_ERROR");   exit; }
      
      $total_HC = @mysql_result($result_HC,0,0);
      
      $query_H = "SELECT uid,pcode,qty,gate,org_pcode,org_barcode FROM shop_cart 
                  WHERE pay_num = '$new_pay_num' AND user_id = '$login_id' AND f_class = 'in' AND expire = '1' ORDER BY pcode ASC";
      $result_H = mysql_query($query_H);
      if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
      for($h = 0; $h < $total_HC; $h++) {
        $H_cart_uid = mysql_result($result_H,$h,0);
        $H_pcode = mysql_result($result_H,$h,1);
        $H_qty = mysql_result($result_H,$h,2);
        $H_gate_code = mysql_result($result_H,$h,3);
		$H_org_pcode = mysql_result($result_H,$h,4);
		$H_org_barcode = mysql_result($result_H,$h,5);
        
        // 상품 수량 정보 입력 [uid 추출]
        $rm2_query = "SELECT uid,catg_code,gcode FROM shop_product_list WHERE pcode = '$H_pcode'";
        $rm2_result = mysql_query($rm2_query);
        if (!$rm2_result) { error("QUERY_ERROR"); exit; }
        
        $H_org_uid = @mysql_result($rm2_result,0,0);
        $H_catg_code = @mysql_result($rm2_result,0,1);
        $H_gcode = @mysql_result($rm2_result,0,2);
    
        // 상품 qty 하위 테이블 입력 [shop_product_list와 매입 자료는 이미 반영되어 있음]
        $query_PH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,pay_num,flag,branch_code,shop_code,
                catg_code,gcode,pcode,stock,date,org_pcode,org_barcode) values ('','$H_org_uid','$new_pay_num','out2',
                '$login_branch','$login_shop','$H_catg_code','$H_gcode','$H_pcode','$H_qty','$post_dates','$H_org_pcode','$H_org_barcode')";
        $result_PH3 = mysql_query($query_PH3);
        if (!$result_PH3) { error("QUERY_ERROR"); exit; }
		
		
		
		// EXTRACT original stock
		$s_queryO = "SELECT qty_org,qty_sell,qty_now FROM shop_product_list_shop 
					WHERE branch_code = '$login_branch' AND shop_code = '' AND pcode = '$H_pcode'";
		$s_resultO = mysql_query($s_queryO,$dbconn);
            if (!$s_resultO) { error("QUERY_ERROR"); exit; }
		$HO_qty_org = @mysql_result($s_resultO,0,0);
		$HO_qty_sell = @mysql_result($s_resultO,0,1);
		$HO_qty_now = @mysql_result($s_resultO,0,2);
		
		$this_cart_qty_sell = $HO_qty_sell + $H_qty; // 조정된 판매수량(+)
		$this_cart_qty_now = $HO_qty_now - $H_qty; // 조정된 재고수량(-)
      
     
		// UPDATE Stock of SHOP
		$result_CHG3 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$this_cart_qty_sell', 
                    qty_now = '$this_cart_qty_now' WHERE branch_code = '$login_branch' AND shop_code = '' AND pcode = '$H_pcode'",$dbconn);
		if(!$result_CHG3) { error("QUERY_ERROR"); exit; }
		
      
		// UPDATE Stock in All ------------------------------------------------------------------------- //
		$s_queryX = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop WHERE pcode = '$H_pcode'";
		$s_resultX = mysql_query($s_queryX,$dbconn);
            if (!$s_resultX) { error("QUERY_ERROR"); exit; }
		$sX_qty_org = @mysql_result($s_resultX,0,0);
		$sX_qty_now = @mysql_result($s_resultX,0,1);
		$sX_qty_sell = @mysql_result($s_resultX,0,2);
      
		$result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$sX_qty_sell', stock_now = '$sX_qty_now' WHERE pcode = '$H_pcode'",$dbconn);
		if(!$result_qs2) { error("QUERY_ERROR"); exit; }
		

      }
	  
	  
      
      
      // uid 출력
      $query_uid = "SELECT uid FROM shop_payment WHERE pay_num = '$new_pay_num' ORDER BY uid DESC";
      $result_uid = mysql_query($query_uid);
      if(!$result_uid) { error("QUERY_ERROR"); exit; }
      $row_uid = mysql_fetch_object($result_uid);

      $Pr_uid = $row_uid->uid;
      
      
      // 영수증 출력창
	  
	  
      
      // 결제 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_collection.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page&mode=check&uid=$Pr_uid&P_uid=$Pr_uid&pos_type=$pos_type'>");
      exit;


}

}
?>
