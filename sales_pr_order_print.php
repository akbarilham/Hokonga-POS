<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "purchaseB";
$smenu = "sales_pr_order";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>

	<title><?=$web_erp_name?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
	
    <link href="css/invoice/style.css" rel="stylesheet">
	<link href="css/invoice/style-responsive.css" rel="stylesheet">
	
   
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>



<body class="print-body">

<section>

<?
// 파일 저장 디렉토리
$savedir = "user_file";


// 발주 정보 테이블
$pm_query = "SELECT uid,branch_code,po_num,po_qty,po_tamount,client_code,order_date,currency FROM shop_purchase WHERE uid = '$P_uid'";
$pm_result = mysql_query($pm_query);
if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
$pm_uid = @mysql_result($pm_result,0,0);
$pm_branch_code = @mysql_result($pm_result,0,1);
$pm_po_num = @mysql_result($pm_result,0,2);
$pm_po_qty = @mysql_result($pm_result,0,3);
$pm_po_amount = @mysql_result($pm_result,0,4);

$pm_client_code = @mysql_result($pm_result,0,5);
$qs_date = @mysql_result($pm_result,0,6);
$pm_currency = @mysql_result($pm_result,0,7);

if($pm_currency == "USD") {
	$pm_po_amount_K = number_format($pm_po_amount,2);
	$pm_currency_tag = "US$";
} else {
	$pm_po_amount_K = number_format($pm_po_amount);
	$pm_currency_tag = "Rp.";
}


  $qday1 = substr($qs_date,0,4);
  $qday2 = substr($qs_date,4,2);
	$qday3 = substr($qs_date,6,2);

  // if($lang == "ko") {
	//   $qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3";
	// } else {
	  $qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1";
	// }


// 상세 발주 정보
$query_HC = "SELECT count(uid) FROM shop_cart WHERE order_num = '$pm_po_num' AND f_class = 'b2b' AND expire = '1'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);



// 수신자 정보
$mb_query = "SELECT uid,shop_name,shop_code,email,phone1,phone_fax,zipcode,addr1,addr2 FROM client_shop WHERE shop_code = '$pm_client_code'";
$mb_result = mysql_query($mb_query);
if (!$mb_result) { error("QUERY_ERROR"); exit; }
    
$mb_uid = @mysql_result($mb_result,0,0);
$mb_corp_name = @mysql_result($mb_result,0,1);
$mb_corp_code = @mysql_result($mb_result,0,2);
$mb_email = @mysql_result($mb_result,0,3);
$mb_phone1 = @mysql_result($mb_result,0,4);
$mb_phone_fax = @mysql_result($mb_result,0,5);
$mb_zipcode = @mysql_result($mb_result,0,6);
$mb_addr1 = @mysql_result($mb_result,0,7);
$mb_addr2 = @mysql_result($mb_result,0,8);


// 발신자(지사) 정보
$query = "SELECT uid,branch_code,branch_name,branch_type,ceo_name,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,img1 
          FROM client_branch WHERE branch_code = '$pm_branch_code'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$branch_code = $row->branch_code;
$branch_name = $row->branch_name;
$branch_type = $row->branch_type;
$ceo_name = $row->ceo_name;
$email = $row->email;
$homepage = $row->homepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$zipcode = $row->zipcode;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row->memo;
$photo1 = $row->img1;


if($photo1 != "") {
  $logo_txt = "<img src='$savedir/$photo1' border=0>";
} else {
  $logo_txt = "<b>$branch_name</b>";
}

$signdate = time();
$signdate_txt = date("d M Y",$signdate);
?>


<!--body wrapper start-->
    <div class="wrapper">
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-3">
                        <h1 class="invoice-title">Purchase Request</h1>
                    </div>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-5 col-xs-offset-4 ">
                        <img class="inv-logo" src="img/logo/logo_host.png" alt=""/>
                        <p><?=$addr2?><br><?=$addr1?> <?=$zipcode?></p>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <h4 class="inv-to">Purchase Request by</h4>
                            <h2 class="corporate-id"><?=$mb_corp_name?></h2>
                            <p><?=$mb_addr2?><br><?=$mb_addr1?> <?=$mb_zipcode?>
								<br>TEL : <?=$mb_phone1?>
								<br>Email : <?=$mb_email?>
							</p>

                        </div>
                        <div class="col-md-4 col-md-offset-3 col-sm-4 col-sm-offset-3 col-xs-4 col-xs-offset-3">
                            <div class="inv-col"><span>PR No. :</span> <?=$pm_po_num?></div>
                            <div class="inv-col"><span>PR Date :</span> <?=$signdate_txt?></div>
                            <h1 class="t-due">TOTAL</h1>
                            <h2 class="amnt-value"><?=$pm_currency_tag?> <?=$pm_po_amount_K?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-invoice">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Item Description</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total</th>
                </tr>
                </thead>
                <tbody>
				
				<?
				$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name FROM shop_cart 
							WHERE order_num = '$pm_po_num' AND f_class = 'b2b' AND expire = '1' ORDER BY date ASC";
				$result_H = mysql_query($query_H);
				if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
				$H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
    
				$cart_no = 1;
    
				for($h = 0; $h < $total_HC; $h++) {
					$H_cart_uid = mysql_result($result_H,$h,0);
					$H_prd_uid = mysql_result($result_H,$h,1);
					$H_pcode = mysql_result($result_H,$h,2);
					$H_qty = mysql_result($result_H,$h,3);
						$total_qty = $total_qty + $H_qty;
						$total_qty_K = number_format($total_qty);
					$H_p_color = mysql_result($result_H,$h,4);
					$H_p_size = mysql_result($result_H,$h,5);
					$H_p_opt1 = mysql_result($result_H,$h,6);
					$H_p_opt2 = mysql_result($result_H,$h,7);
					$H_p_opt3 = mysql_result($result_H,$h,8);
					$H_p_opt4 = mysql_result($result_H,$h,9);
					$H_p_opt5 = mysql_result($result_H,$h,10);
					$H_pname = mysql_result($result_H,$h,11);
					$H_p_price = mysql_result($result_H,$h,12);
					$H_unpack_qty = mysql_result($result_H,$h,13);
					$H_unpack_unit_qty = mysql_result($result_H,$h,14);
					$H_unpack_unit_name = mysql_result($result_H,$h,15);
      
					if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
					if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
					if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
					if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
					if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
					if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
					if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
					$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
      
      
					// 상품명, 상품별 결제액
					$query_dari = "SELECT uid,pname,price_orgin,tprice_orgin,stock_now,stock_sell FROM shop_product_list WHERE uid = '$H_prd_uid'";
					$result_dari = mysql_query($query_dari);
					if(!$result_dari) { error("QUERY_ERROR"); exit; }
					$row_dari = mysql_fetch_object($result_dari);

					$dari_uid = $row_dari->uid;
					if($H_pcode == "") {
						$dari_pname = $H_pname;
					} else {
						$dari_pname = $row_dari->pname;
					}
        
					if($H_pcode == "") {
						$dari_amount = $H_p_price;
					} else {
						$dari_amount = $row_dari->price_orgin;
					}
					
					
					// by Product Unit
					if($H_unpack_qty > 0) {
						if($H_pcode != "") {
							$H2_qty = $H_unpack_qty;
							$dari_amount2 = $dari_amount * $H_unpack_unit_qty;
						} else {
							$H2_qty = $H_unpack_qty;
							$dari_amount2 = $dari_amount;
						}
					} else {
							$H2_qty = $H_qty;
							$dari_amount2 = $dari_amount;
					}
		
		
					if($pm_currency == "USD") {
						$dari_amount2R = $dari_amount2 / $now_xchange_rate;
					} else {
						$dari_amount2R = $dari_amount2;
					}
					if($pm_currency == "USD") {
						$dari_amount2R_K = number_format($dari_amount2R,2);
					} else {
						$dari_amount2R_K = number_format($dari_amount2R);
					}
		
		
					$dari_tamount = $dari_amount2R * $H2_qty;
		
					if($pm_currency == "USD") {
						$dari_tamount_K = number_format($dari_tamount,2);
					} else {
						$dari_tamount_K = number_format($dari_tamount);
					}
			
					$dari_stock_now = $row_dari->stock_now;
						$qty_max = $dari_stock_now + $H_qty; // 재고와 카트의 주문수량의 합 (주문 가능한 수량의 최대값)
					$dari_stock_sell = $row_dari->stock_sell;
					$qty_sold = $dari_stock_sell - $H_qty; // 판매량에서 카트의 주문수량을 공제 (본래의 판매량)
        
					// 합계
					$p_total_price = $p_total_price + $dari_tamount;
					if($pm_currency == "USD") {
						$p_total_price_K = number_format($p_total_price,2);
					} else {
						$p_total_price_K = number_format($p_total_price);
					}
					
					if($H_unpack_unit_name == "0") {
						$H_unpack_unit_name = "";
					}
      
					echo ("
					<tr>
						<td>$cart_no</td>
						<td>
							<h4>$dari_pname</h4>
							<p>{$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</p>
						</td>
						<td class='text-center'><strong>$dari_amount2R_K</strong></td>
						<td class='text-center'><strong>$H_qty</strong></td>
						<td class='text-center'><strong>$dari_tamount_K</strong></td>
					</tr>");
      
				$cart_no++;
				}
				?>
				

                <tr>
                    <td colspan="2" class="payment-method">
                        <h4>Comment</h4>
                        
                        
                        <br>
                        <h3 class="inv-label"></h3>
                    </td>
                    <td class="text-right">
                        <p>Sub Total</p>
                        <p>&nbsp;</p>
                        <p><strong>GRAND TOTAL</strong></p>
                    </td>
					<td class="text-center">
                        <p><?=$total_qty_K?></p>
                        <p>&nbsp;</p>
                        <p><strong><?=$total_qty_K?></strong></p>
                    </td>
                    <td class="text-center">
                        <p><?=$p_total_price_K?></p>
                        <p>&nbsp;</p>
                        <p><strong><?=$p_total_price_K?></strong></p>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <!--body wrapper end

</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="js/invoice/jquery-1.10.2.min.js"></script>
<script src="js/invoice/jquery-migrate-1.2.1.min.js"></script>
<script src="js/invoice/bootstrap.min.js"></script>
<script src="js/invoice/modernizr.min.js"></script>


<!--common scripts for all pages-->
<script src="js/invoice/scripts.js"></script>

<script type="text/javascript">
    window.print();
</script>

</body>
</html>

<? } ?>