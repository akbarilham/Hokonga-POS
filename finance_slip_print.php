<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "finance_slip_print";
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
$savedir = "user_file";


// Slip Info
$pm_query = "SELECT uid,slip_num,branch_code,gate,shop_code,client_code,user_code,f_class,f_subclass,f_paylink,
			f_catg,f_code,f_codeB,f_name,f_remark,order_num,pay_num,currency,amount,currency2,amount2,org_currency,org_amount,
			xchg_type,xchg_rate,xchg_date,post_date,order_date,approval_status,approval_date,approval2_date,pay_date,process,
			settle_status,settle_date FROM finance WHERE uid = '$P_uid'";
$pm_result = mysql_query($pm_query);
if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
$pm_uid = @mysql_result($pm_result,0,0);
$pm_slip_num = @mysql_result($pm_result,0,1);
$pm_branch_code = @mysql_result($pm_result,0,2);
$pm_gate = @mysql_result($pm_result,0,3);
$pm_shop_code = @mysql_result($pm_result,0,4);
$pm_client_code = @mysql_result($pm_result,0,5);
$pm_user_code = @mysql_result($pm_result,0,6);
$pm_f_class = @mysql_result($pm_result,0,7);
$pm_f_subclass = @mysql_result($pm_result,0,8);
$pm_f_paylink = @mysql_result($pm_result,0,9);
$pm_f_catg = @mysql_result($pm_result,0,10);
$pm_f_code = @mysql_result($pm_result,0,11);
$pm_f_codeB = @mysql_result($pm_result,0,12);
$pm_f_name = @mysql_result($pm_result,0,13);
$pm_f_remark = @mysql_result($pm_result,0,14);
$pm_order_num = @mysql_result($pm_result,0,15);
$pm_pay_num = @mysql_result($pm_result,0,16);
$pm_currency = @mysql_result($pm_result,0,17);
$pm_amount = @mysql_result($pm_result,0,18);
$pm_currency2 = @mysql_result($pm_result,0,19);
$pm_amount2 = @mysql_result($pm_result,0,20);

$pm_org_currency = @mysql_result($pm_result,0,21);
$pm_org_amount = @mysql_result($pm_result,0,22);
$pm_xchg_type = @mysql_result($pm_result,0,23);
$pm_xchg_rate = @mysql_result($pm_result,0,24);
$pm_xchg_date = @mysql_result($pm_result,0,25);
$pm_post_date = @mysql_result($pm_result,0,26);
$pm_order_date = @mysql_result($pm_result,0,27);
$pm_approval_status = @mysql_result($pm_result,0,28);
$pm_approval_date = @mysql_result($pm_result,0,29);
$pm_approval2_date = @mysql_result($pm_result,0,30);
$pm_pay_date = @mysql_result($pm_result,0,31);
$pm_process = @mysql_result($pm_result,0,32);
$pm_settle_status = @mysql_result($pm_result,0,33);
$pm_settle_date = @mysql_result($pm_result,0,34);

if($pm_currency == "USD") {
	$pm_po_amount_K = number_format($pm_po_amount,2);
	$pm_currency_tag = "US$";
} else {
	$pm_po_amount_K = number_format($pm_po_amount);
	$pm_currency_tag = "Rp.";
}





// PIC
$query = "SELECT uid,branch_code,name,email,userlevel FROM member_staff WHERE code = '$pm_user_code'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$pic_uid = $row->uid;
$pic_branch_code = $row->branch_code;
$pic_name = $row->name;
$pic_email = $row->email;
$pic_userlevel = $row->userlevel;



// Logo
$query_logo = "SELECT branch_name,img1 FROM client_branch WHERE branch_code = '$login_branch'";
$result_logo = mysql_query($query_logo);
if(!$result_logo) { error("QUERY_ERROR"); exit; }
   $row_logo = mysql_fetch_object($result_logo);

$logo_branch_name = $row_logo->branch_name;
$logo_file = $row_logo->img1;

if($logo_file != "") {
	$logo_img_file = "user_file/$logo_file";
} else {
	$logo_img_file = "img/logo/logo_host.png";
}
?>


<!--body wrapper start-->
    <div class="wrapper">
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-3">
                        <h2>SLIP PAYMENT</h2>
						<p>Slip No : <?=$pm_slip_num?></p>
                    </div>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-5 col-xs-offset-4 ">
                        <img class="inv-logo" src="<?echo("$logo_img_file")?>" alt=""/>
                        <p><?=$logo_branch_name?></p>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-invoice">
                <thead>
                <tr>
                    <th colspan=5><div align=center>DEBIT</div></th>
                    <th colspan=5><div align=center>CREDIT</div></th>
                </tr>
                </thead>
                <tbody>
				
				<tr>
					<td colspan=2><div align=center>ACCOUNT</div></td>
					<td rowspan=2><div align=center>DESCRIPTION</div></td>
					<td rowspan=2><div align=center>CURRENCY</div></td>
					<td rowspan=2><div align=center>AMOUNT</div></td>
					<td colspan=2><div align=center>ACCOUNT</div></td>
					<td rowspan=2><div align=center>DESCRIPTION</div></td>
					<td rowspan=2><div align=center>CURRENCY</div></td>
					<td rowspan=2><div align=center>AMOUNT</div></td>
				</tr>
				<tr>
					<td><div align=center>CODE</div></td>
					<td><div align=center>NAME</div></td>
					<td><div align=center>CODE</div></td>
					<td><div align=center>NAME</div></td>
				</tr>
				
					
				
				<?
				$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,org_pcode,org_barcode,cbm FROM shop_cart 
							WHERE order_num = '$pm_order_num' AND f_class = 'out' AND expire = '1' ORDER BY date ASC";
				$result_H = mysql_query($query_H);
				if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
				$H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
    
				$cart_no = 1;
    
				for($h = 0; $h < $total_HC; $h++) {
					$H_cart_uid = mysql_result($result_H,$h,0);
					$H_prd_uid = mysql_result($result_H,$h,1);
					$H_pcode = mysql_result($result_H,$h,2);
					$H_qty = mysql_result($result_H,$h,3);
						$H_qty_K = number_format($H_qty);
						
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
					$H_org_pcode = mysql_result($result_H,$h,16);
					$H_org_barcode = mysql_result($result_H,$h,17);
					$H_cbm = mysql_result($result_H,$h,18);
      
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
						<td>code</td>
						<td>name</td>
						<td>description</td>
						<td>IDR</td>
						<td class='text-center'><strong>$dari_amount2R_K</strong></td>
					</tr>");
      
				$cart_no++;
				}
				?>
				

                <tr>
                    <td colspan="2" class="text-center">
                        <p><strong>TOTAL AMOUNT</strong></p>
                        <p>Rate: 12,147.-</p>
                    </td>
                    <td class="text-right">
                        <p><strong>IDR</strong></p>
                        <p>USD</p>
                    </td>
					<td colspan="2" class="text-right">
                        <p><strong>100,000</strong></p>
                        <p>8</p>
                    </td>
					
					 <td colspan="2" class="text-center">
                        <p><strong>TOTAL AMOUNT</strong></p>
                        <p>Rate: 12,147.-</p>
                    </td>
                    <td class="text-right">
                        <p><strong>IDR</strong></p>
                        <p>USD</p>
                    </td>
					<td colspan="2" class="text-right">
                        <p><strong>100,000</strong></p>
                        <p>8</p>
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