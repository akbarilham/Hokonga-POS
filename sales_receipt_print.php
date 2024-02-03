<script>
function printWindow(){
   bV = parseInt(navigator.appVersion)
   if (bV >= 4) window.print()
}
</script>

<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


// 파일 저장 디렉토리
$savedir = "user_file";

$loco = "page_client";
$mmenu = "inventory";
$smenu = "invoice";
$smenu_title = "$txt_sales_sales_22";

$icon = "$home/image/icon";
$link_print = "javascript:printWindow()";
$P_uid = $_GET['P_uid'];
// 결제 정보 테이블
$pm_query = "SELECT uid,pay_num,bank_name,pay_type,pay_bank,remit_code,pay_date,pay_state,
            branch_code,gate,pay_amount,pay_fee_tax,client_code,name1,product,order_date,due_date,
            invoice_dates,currency,loan_flag,loan_trans_code FROM shop_payment WHERE uid = '$P_uid'";
$pm_result = mysql_query($pm_query);
if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
$pm_uid = @mysql_result($pm_result,0,0);
$pm_pay_num = @mysql_result($pm_result,0,1);
$pm_bank_name = @mysql_result($pm_result,0,2);
$pm_pay_type = @mysql_result($pm_result,0,3);
$pm_pay_bank = @mysql_result($pm_result,0,4);
$pm_remit_code = @mysql_result($pm_result,0,5);
$upd_pay_date = @mysql_result($pm_result,0,6);
$upd_pay_status = @mysql_result($pm_result,0,7);
$upd_branch_code = @mysql_result($pm_result,0,8);
$upd_gate = @mysql_result($pm_result,0,9);
$upd_pay_amount = @mysql_result($pm_result,0,10);
  $upd_pay_amount_K = number_format(floatval($upd_pay_amount));
$upd_pay_tax = @mysql_result($pm_result,0,11);
  $upd_pay_tax_K = number_format(floatval($upd_pay_tax));
$upd_client_code = @mysql_result($pm_result,0,12);
$upd_client_name = @mysql_result($pm_result,0,13);
$upd_products = @mysql_result($pm_result,0,14);
$upd_order_date = @mysql_result($pm_result,0,15);
  // 주문일
  $Oday1 = substr($upd_order_date,0,4);
	$Oday2 = substr($upd_order_date,4,2);
	$Oday3 = substr($upd_order_date,6,2);
	// if($lang == "ko") { 
	//   $upd_order_dates = "$Oday1"."/"."$Oday2"."/"."$Oday3";
	// } else {
	  $upd_order_dates = "$Oday3"."-"."$Oday2"."-"."$Oday1";
	// }

$upd_due_date = @mysql_result($pm_result,0,16);
$upd_invoice_date = @mysql_result($pm_result,0,17);
  $iday1 = substr($upd_invoice_date,0,4);
	$iday2 = substr($upd_invoice_date,4,2);
	$iday3 = substr($upd_invoice_date,6,2);
	$upd_invoice_dates = "$iday3"."-"."$iday2"."-"."$iday1";

$upd_currency = @mysql_result($pm_result,0,18);
$upd_loan_flag = @mysql_result($pm_result,0,19);
$upd_trans_code = @mysql_result($pm_result,0,20);

          // 총 수량
          $query_qt1 = "SELECT sum(qty) FROM shop_cart WHERE f_class = 'out' AND pay_num = '$pm_pay_num'";
          $result_qt1 = mysql_query($query_qt1);
          $sum_qt1 = @mysql_result($result_qt1,0,0);
          $sum_qt1_K = number_format($sum_qt1);

// 통화
if($upd_currency == "USD") {
  $upd_currency_tag = "US$";
} else {
  $upd_currency_tag = "Rp.";
}

if($upd_pay_tax > "0") {
  $upd_pay_amount1 = $upd_pay_amount - $upd_pay_tax;
} else {
  $upd_pay_amount1 = $upd_pay_amount;
}
$upd_pay_amount1_K = number_format(floatval($upd_pay_amount1));

if($pm_pay_type == "credit") {
  $pm_pay_type_txt = "NOTA KREDIT";
} else {
  $pm_pay_type_txt = "RECEIPT";
}





// 지사 정보
$query = "SELECT uid,branch_code,branch_name,branch_type,ceo_name,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,img1 
          FROM client_branch WHERE branch_code = '$upd_branch_code'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_array($result);

$user_uid = $row['uid'];
$branch_code = $row['branch_code'];
$branch_name = $row['branch_name'];
$branch_type = $row['branch_type'];
$ceo_name = $row['ceo_name'];
$email = $row['email'];
$homepage = $row['homepage'];
$phone1 = $row['phone1'];
$phone2 = $row['phone2'];
$phone_fax = $row['phone_fax'];
$phone_cell = $row['phone_cell'];
$addr1 = $row['addr1'];
$addr2 = $row['addr2'];
$zipcode = $row['zipcode'];
$userlevel = $row['userlevel'];
$signdate = $row['signdate'];
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row['memo'];
$photo1 = $row['img1'];


if($photo1 != "") {
  $logo_txt = "<img src='$savedir/$photo1' border=0>";
} else {
  $logo_txt = "<b>$branch_name</b>";
}

$signdate = time();
$signdate_txt = date("d M Y",$signdate);


// 발행자
$ug_query = "SELECT user_name,user_level FROM admin_user WHERE user_id = '$login_id' ORDER BY user_level DESC";
$ug_result = mysql_query($ug_query);
if (!$ug_result) { error("QUERY_ERROR"); exit; }
    
$ug_name = @mysql_result($ug_result,0,0);
$ug_level = @mysql_result($ug_result,0,1);

$ug2_query = "SELECT user_name,user_level FROM admin_user 
              WHERE branch_code = '$login_branch' AND user_level = '3' ORDER BY user_level DESC";
$ug2_result = mysql_query($ug2_query);
if (!$ug2_result) { error("QUERY_ERROR"); exit; }
    
$ug2_name = @mysql_result($ug2_result,0,0);
$ug2_level = @mysql_result($ug2_result,0,1);



// 서명권자
// $sg_query = "SELECT name,corp_title FROM member_staff WHERE userlevel > '0' AND sign_auth = '1' ORDER BY userlevel DESC";
$sg_query = "SELECT name,corp_title FROM member_staff WHERE userlevel > '0' ORDER BY userlevel DESC";
$sg_result = mysql_query($sg_query);
if (!$sg_result) { error("QUERY_ERROR"); exit; }
    
$sg_name = @mysql_result($sg_result,0,0);
$sg_title = @mysql_result($sg_result,0,1);

// 입고증명



// 고객 정보
$mb_query = "SELECT uid,name,corp_name,bank_name,acct_name,acct_no,mb_type FROM member_main WHERE code = '$upd_client_code'";
$mb_result = mysql_query($mb_query);
if (!$mb_result) { error("QUERY_ERROR"); exit; }
    
$mb_uid = @mysql_result($mb_result,0,0);
$mb_client_name = @mysql_result($mb_result,0,1);
$mb_corp_name = @mysql_result($mb_result,0,2);
$mb_bank_name = @mysql_result($mb_result,0,3);
$mb_acct_name = @mysql_result($mb_result,0,4);
$mb_acct_no = @mysql_result($mb_result,0,5);
$mb_type = @mysql_result($mb_result,0,6);

// Group Farmer일 때 (mb_type = 4)
if($mb_corp_name != "") {
	if($mb_client_name != "") {
		$mb_client_names = "$mb_corp_name : $mb_client_name";
	} else {
		$mb_client_names = "$mb_corp_name";
	}
} else {
		$mb_client_names = "$mb_client_name";
}
?>

<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/table-responsive.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

  </head>




      
	  
      <!--main content start-->
      <section id="main-content">
	  
		<div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
		
        <div class="panel-body">
    
<?    
// 인쇄 형식
echo ("
<table width=640 cellspacing=0 cellpadding=10 border=0>
<tr><td colspan=3 height=10></td></tr>

<tr>
  <td width=100 valign=top>$logo_txt</td>
  <td valign=top>
    <font style='font-size: 1.0em; color: #888'>$branch_name</font>
    <br>$addr2
    <br>$addr1 $zipcode - INDONESIA
    <br>T. $phone1
    <br>F. $phone_fax
    <br>Website : $homepage
  
  </td>
  <td align=right valign=top>
    <a href='$link_print'><i class='fa fa-print'></i></a>
    <br><br>
    $login_id<br>$login_shop<br>$login_gate<br>$login_branch
  
  </td>
</tr>

<tr><td colspan=3 height=10></td></tr>
<tr>
  <td colspan=3 height=20 valign=top>
    <font style='font-size: 1.0em; color: #888'>Kepada Yth,
    <br><b>$upd_client_code - $mb_client_names</b>
    
    <br><br><font style='font-size: 0.85em; color: #888'><b>$pm_pay_type_txt</b></font><br><b>$pm_pay_num</b>
    </font>
	<br>&nbsp;
  
  </td>
</tr>

<tr>
  <td colspan=3 height=20 valign=top>
      <table width=100% cellspacing=0 cellpadding=2 border=1 bordercolor=#888>
      <tr>
        <td height=25 align=center><font style='font-size: 0.85em; color: #888'><b>Nama Produk</b></font></td>
        <td align=center><font style='font-size: 0.85em; color: #888'><b>Harga Satuan</b></font></td>
        <td align=center><font style='font-size: 0.85em; color: #888'><b>Kuantiti</b></font></td>
        <!--<td align=center><font style='font-size: 0.85em; color: #888'><b>Potongan</b></font></td>-->
        <td align=center><font style='font-size: 0.85em; color: #888'><b>Total</b></font></td>
      </tr>");
      
      
      // 상품 구입 수량 합계
      $query_qx = "SELECT sum(qty) FROM shop_cart WHERE pay_num = '$pm_pay_num'";
      $result_qx = mysql_query($query_qx);
      if (!$result_qx) {   error("QUERY_ERROR");   exit; }
    
      $total_qx = @mysql_result($result_qx,0,0);
      
      // 상품 상세 정보 - 상세 리스트 [카트]
      $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$pm_pay_num'";
      $result_HC = mysql_query($query_HC);
      if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
      $total_HC = @mysql_result($result_HC,0,0);
     
      $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
        p_price,p_saleprice FROM shop_cart WHERE pay_num = '$pm_pay_num' ORDER BY pcode ASC";
      $result_H = mysql_query($query_H);
      if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
      $cart_no = 1;
    
      for($h = 0; $h < $total_HC; $h++) {
        $H_cart_uid = mysql_result($result_H,$h,0);
        $H_prd_uid = mysql_result($result_H,$h,1);
        $H_pcode = mysql_result($result_H,$h,2);
        $H_qty = mysql_result($result_H,$h,3);
        $H_p_color = mysql_result($result_H,$h,4);
        $H_p_size = mysql_result($result_H,$h,5);
        $H_p_opt1 = mysql_result($result_H,$h,6);
        $H_p_opt2 = mysql_result($result_H,$h,7);
        $H_p_opt3 = mysql_result($result_H,$h,8);
        $H_p_opt4 = mysql_result($result_H,$h,9);
        $H_p_opt5 = mysql_result($result_H,$h,10);
        $H_p_price = mysql_result($result_H,$h,11);
        $H_p_saleprice = mysql_result($result_H,$h,12);
        
        // 할인액
        $H_p_potong = $H_p_price - $H_p_saleprice;
         $H_p_potong_K = number_format($H_p_potong);
      
        if($H_p_color != "") { $H_p_color_txt = "$H_p_color"."|"; } else { $H_p_color_txt = ""; }
        if($H_p_size != "") { $H_p_size_txt = "$H_p_size"."/"; } else { $H_p_size_txt = ""; }
        if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
        if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
        if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
        if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
        if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
      
        // 상품명, 상품별 결제액
        $query_dari = "SELECT uid,pname,price_sale FROM shop_product_list WHERE pcode = '$H_pcode'";
        $result_dari = mysql_query($query_dari);
        if(!$result_dari) { error("QUERY_ERROR"); exit; }
        $row_dari = mysql_fetch_array($result_dari);

        $dari_uid = $row_dari['uid'];
        $dari_pname = $row_dari['pname'];
        $dari_price_sale = $row_dari['price_sale'];
      
      if($H_p_saleprice < 1) {
        $dari_price_sale_K = number_format($dari_price_sale);
        $dari_tprice_sale = $dari_price_sale * $H_qty;
      } else {
        $dari_price_sale_K = number_format($H_p_saleprice);
        $dari_tprice_sale = $H_p_saleprice * $H_qty;
      }
      $dari_tprice_sale_K = number_format($dari_tprice_sale);
      
      echo ("
      <tr>
        <td height=46>&nbsp; <font style='font-size: 0.85em; color: #222'><b>[$H_pcode] {$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5}</b></font></td>
        <td align=right><font style='font-size: 0.85em; color: #222'><b>$upd_currency_tag $dari_price_sale_K</b></font> &nbsp;&nbsp;</td>
        <td align=center><font style='font-size: 0.85em; color: #222'><b>$H_qty</b></font></td>
        <!--<td align=right><font style='font-size: 0.85em; color: #222'><b>$upd_currency_tag $H_p_potong_K</b></font> &nbsp;&nbsp;</td>-->
        <td align=right><font style='font-size: 0.85em; color: #222'><b>$upd_currency_tag $dari_tprice_sale_K</b></font> &nbsp;&nbsp;</td>
      </tr>");
      $cart_no++;
      }
      
      global $loan_permit;
      // 지불(Loan)
      if($loan_permit > 0) {
        $upd_pay_amount2 = $upd_pay_amount1 * $loan_permit * 0.01;
      } else {
        $upd_pay_amount2 = $upd_pay_amount1;
      }
      
      $upd_pay_amount2_K = number_format(floatval($upd_pay_amount2));
      // 합계
      echo ("
      <tr>
        <td height=25 colspan=2 align=center><font style='font-size: 0.85em; color: #222'><b>TOTAL</b></font></td>
        <!--<td align=center><font style='font-size: 0.85em; color: #222'><b>$total_qx</b></font></td>-->
        <td colspan=2 align=right><font style='font-size: 1.0em; color: #222'><b>$upd_currency_tag $upd_pay_amount1_K</b></font></font> &nbsp;&nbsp;</td>
      </tr>
      </table>
  </td>
</tr>

<tr>
  <td colspan=3 height=20 valign=top align=right>&nbsp;<br>
    <font style='font-size: 0.85em; color: #888'><b>$addr1, $upd_order_dates</b></font>
  </td>
</tr>");

if($pm_pay_type == "credit") {
echo ("
<tr>
  <td colspan=3 height=130>
      <table  width=100% cellspacing=0 cellpadding=5 border=1 bordercolor=#AAAAAA>
      <tr>
        <td height=20 width=50% align=center><font style='font-size: 0.85em; color: #222'><b>Buyer</b></font></td>
        <td width=50% align=center><font style='font-size: 0.85em; color: #222'><b>$branch_name</b></font></td>
      </tr>
      <tr>
        <td height=100 align=center>&nbsp;</td>
        <td align=center>&nbsp;</td>
      </tr>
      <tr>
        <td height=20 align=center><font style='font-size: 0.85em; color: #222'><b>$mb_client_name</b></font></td>
        <td align=center><font style='font-size: 0.85em; color: #222'><b>$ug_name</b></font></td>
      </tr>
      </table>
  </td>
</tr>");
}
?>

</table>
		</div>
		</section>
		</div>
		</div>
		</div>

	</section>


</body>
</html>

<? } ?>