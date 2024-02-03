<?
include "config/common.inc";
GLOBAL $cart_mode;

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
  
  $new_branch_code = $login_branch;
  $new_shop_code = $login_shop;
  // Redirection Link
  $order_redirect = "sales_order2.php";
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
  if(isset($_POST['new_branch_code'])){
    $new_branch_code = $_POST['new_branch_code'];
  }
  if(isset($_POST['cart_prd_uid'])){
    $cart_prd_uid = $_POST['cart_prd_uid'];
  }
  if (isset($_POST['cart_prd_code'])) {
    $cart_prd_code = $_POST['cart_prd_code'];
  }
  if (isset($_POST['cart_prd_name'])) {
    $cart_prd_pname = $_POST['cart_prd_name'];
  }
  if (isset($_POST['cart_org_pcode'])) {
    $org_pcode = $_POST['cart_org_pcode'];
  }
  if (isset($_POST['cart_org_barcode'])) {
    $org_barcode = $_POST['cart_org_barcode'];
  }
  if (isset($_POST['new_shop_code'])) {
    $new_shop_code = $_POST['new_shop_code'];
  }
  if (isset($_POST['cart_price_sale'])) {
    $prd_price_sale = $_POST['cart_price_sale'];
  }
  if (isset($_POST['new_price_sale'])) {
    $new_price_sale = $_POST['new_price_sale'];
  }
  if (isset($_POST['post_dates'])) {
    $post_dates = $_POST['post_dates'];
  }
  if (isset($_POST['cart_cbm'])) {
    $H_cbm = $_POST['cart_cbm'];
  }
  if (isset($_POST['cart_qty'])) {
    $cart_qty = $_POST['cart_qty'];
  }
  if (isset($_POST['cart_opt1'])) {
    $H_p_opt1 = $_POST['cart_opt1'];
  }
  if (isset($_POST['cart_opt2'])) {
    $H_p_opt1 = $_POST['cart_opt2'];
  }
  if (isset($_POST['cart_opt3'])) {
    $H_p_opt1 = $_POST['cart_opt3'];
  }
  if (isset($_POST['cart_opt4'])) {
    $H_p_opt1 = $_POST['cart_opt4'];
  }
  if (isset($_POST['cart_opt5'])) {
    $H_p_opt1 = $_POST['cart_opt5'];
  }//tambahan baru 
//==================================================
if($cart_mode == "CART_ADD") {


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
      $row_hd1 = mysql_fetch_array($result_hd1);

      $hd1_uid = $row_hd1['uid'];
      $hd1_stock_sell = $row_hd1['qty_sell'];
      $hd1_stock_now = $row_hd1['qty_now'];
      
      $re1_stock_sell = $hd1_stock_sell + $new_qty_sell;
      $re1_stock_now = $hd1_stock_now - $new_qty_sell;
      
      $result_re1 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$re1_stock_sell', 
                    qty_now = '$re1_stock_now' WHERE uid = '$cart_prd_uid'",$dbconn);
      if(!$result_re1) { error("QUERY_ERROR"); exit; }
      
      
      // 상품 재고정보 수정 ------------------------------------------------------------------------- //
      $query_qs1 = "SELECT uid,stock_sell,stock_now FROM shop_product_list WHERE pcode = '$cart_prd_code'";
      $result_qs1 = mysql_query($query_qs1);
        if(!$result_qs1) { error("QUERY_ERROR"); exit; }
      $row_qs1 = mysql_fetch_array($result_qs1);

      $qs1_uid = $row_qs1['uid'];
      $qs1_stock_sell = $row_qs1['stock_sell'];
      $qs1_stock_now = $row_qs1['stock_now'];
      
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

}

}
?>
