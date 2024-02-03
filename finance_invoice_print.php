<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "finance_invoice";
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


		  // INVOICE Data
		  $pm_query = "SELECT uid,branch_code,gate,shop_code,inv_no,pay_num,client_code,currency,inv_amount,inv_date,inv_date2,due_date,
					userfile,user_id,user_ip,tax_no,pay_status,post_date,apprv_date,pay_date FROM shop_payment_invoice WHERE uid = '$P_uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_branch_code = @mysql_result($pm_result,0,1);
          $pm_gate = @mysql_result($pm_result,0,2);
          $pm_shop_code = @mysql_result($pm_result,0,3);
          $pm_inv_no = @mysql_result($pm_result,0,4);
          $pm_pay_num = @mysql_result($pm_result,0,5);
          $pm_client_code = @mysql_result($pm_result,0,6);
          $pm_currency = @mysql_result($pm_result,0,7);
          $pm_inv_amount = @mysql_result($pm_result,0,8);
				$pm_inv_amount_k = number_format($pm_inv_amount);
          $pm_inv_date = @mysql_result($pm_result,0,9);
          $pm_inv_date2 = @mysql_result($pm_result,0,10);
          $pm_due_date = @mysql_result($pm_result,0,11);
          $pm_userfile = @mysql_result($pm_result,0,12);
          $pm_user_id = @mysql_result($pm_result,0,13);
          $pm_user_ip = @mysql_result($pm_result,0,14);
          $pm_tax_no = @mysql_result($pm_result,0,15);
		  $pm_pay_status = @mysql_result($pm_result,0,16);
		  $pm_post_date = @mysql_result($pm_result,0,17);
		  $pm_apprv_date = @mysql_result($pm_result,0,18);
		  $pm_pay_date = @mysql_result($pm_result,0,19);
		  
			// Client Name
			$pmn_query = "SELECT name,corp_name FROM member_main WHERE code = '$pm_client_code' ORDER BY uid DESC";
			$pmn_result = mysql_query($pmn_query);
				if (!$pmn_result) { error("QUERY_ERROR"); exit; }
			$pm_client_name1 = @mysql_result($pmn_result,0,0);
			$pm_client_name2 = @mysql_result($pmn_result,0,1);
			
			if($pm_client_name2 != "") {
				$pm_client_name = $pm_client_name2;
			} else {
				$pm_client_name = $pm_client_name1;
			}
			
          
          // Pay Status
		if($pm_pay_status == "2") {
			$inv_status_txt = "Paid";
		} else if($pm_pay_status == "1") {
			$inv_status_txt = "Unpaid";
		} else {
			$inv_status_txt = "Unpaid";
		}
		  
		  // Payment Process
		  if($pm_pay_status == "0") {
            $pm_pay_status_chk0 = "checked";
            $pm_pay_status_chk1 = "";
            $pm_pay_status_chk2 = "";
          } else if($pm_pay_status == "1") {
            $pm_pay_status_chk0 = "";
            $pm_pay_status_chk1 = "checked";
            $pm_pay_status_chk2 = "";
          } else if($pm_pay_status == "2") {
            $pm_pay_status_chk0 = "";
            $pm_pay_status_chk1 = "";
            $pm_pay_status_chk2 = "checked";
          }

            // Dates
			$iday_exp = explode("-",$pm_inv_date);
			$iday1 = $iday_exp[0];
			$iday2 = $iday_exp[1];
			$iday3 = $iday_exp[2];

			if($lang == "ko") {
				$pm_inv_date_txt = "$iday1"."/"."$iday2"."/"."$iday3";
			} else {
				$pm_inv_date_txt = "$iday3"."-"."$iday2"."-"."$iday1";
			}
			
			$dday_exp = explode("-",$pm_due_date);
			$dday1 = $dday_exp[0];
			$dday2 = $dday_exp[1];
			$dday3 = $dday_exp[2];

			if($lang == "ko") {
				$pm_due_date_txt = "$dday1"."/"."$dday2"."/"."$dday3";
			} else {
				$pm_due_date_txt = "$dday3"."-"."$dday2"."-"."$dday1";
			}
			
			
            $w_day1 = substr($pm_post_date,0,4);
	        $w_day2 = substr($pm_post_date,4,2);
	        $w_day3 = substr($pm_post_date,6,2);
	        $w_day4 = substr($pm_post_date,8,2);
	        $w_day5 = substr($pm_post_date,10,2);
	        $w_day6 = substr($pm_post_date,12,2);
            
			if($lang == "ko") {
	            $pm_post_dates = "$w_day1"."/"."$w_day2"."/"."$w_day3".", "."$w_day4".":"."$w_day5".":"."$w_day6";
	        } else {
	            $pm_post_dates = "$w_day3"."-"."$w_day2"."-"."$w_day1".", "."$w_day4".":"."$w_day5".":"."$w_day6";
	        }
			
          
            
			
			// Currency
			if($pm_currency == "USD") {
				$pm_currency_tag = "US$";
			} else {
				$pm_currency_tag = "Rp.";
			}
			
			// Approval
			if($pm_apprv_date > "0") {
				$pm_apprv_chk = "1";
			} else {
				$pm_apprv_chk = "0";
			}
			
			



// Recepient
$mb_query = "SELECT uid,name,corp_name,email,phone,phone_fax,zipcode,addr1,addr2 FROM member_main WHERE code = '$pm_client_code'";
$mb_result = mysql_query($mb_query);
if (!$mb_result) { error("QUERY_ERROR"); exit; }
    
$mb_uid = @mysql_result($mb_result,0,0);
$mb_name = @mysql_result($mb_result,0,1);
$mb_corp_name = @mysql_result($mb_result,0,2);
$mb_email = @mysql_result($mb_result,0,3);
$mb_phone = @mysql_result($mb_result,0,4);
$mb_phone_fax = @mysql_result($mb_result,0,5);
$mb_zipcode = @mysql_result($mb_result,0,6);
$mb_addr1 = @mysql_result($mb_result,0,7);
$mb_addr2 = @mysql_result($mb_result,0,8);


// Sender
$query = "SELECT uid,branch_code,branch_name,branch_type,ceo_name,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,img1 FROM client_branch WHERE branch_code = '$pm_branch_code'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$sd_uid = $row->uid;
$sd_branch_code = $row->branch_code;
$sd_branch_name = $row->branch_name;
$sd_branch_type = $row->branch_type;
$sd_ceo_name = $row->ceo_name;
$sd_email = $row->email;
$sd_homepage = $row->homepage;
$sd_phone1 = $row->phone1;
$sd_phone2 = $row->phone2;
$sd_phone_fax = $row->phone_fax;
$sd_phone_cell = $row->phone_cell;
$sd_addr1 = $row->addr1;
$sd_addr2 = $row->addr2;
$sd_zipcode = $row->zipcode;
$sd_userlevel = $row->userlevel;
$sd_signdate = $row->signdate;
  if($lang == "ko") {
    $sd_signdates = date("Y/m/d, H:i:s",$sd_signdate);	
  } else {
    $sd_signdates = date("d-m-Y, H:i:s",$sd_signdate);	
  }
$sd_memo = $row->memo;
$sd_photo1 = $row->img1;


if($sd_photo1 != "") {
  $sd_logo_txt = "<img class='inv-logo' src='$savedir/$sd_photo1' alt='$sd_branch_name'>";
} else {
  $sd_logo_txt = "<img class='inv-logo' src='img/logo/logo_host.png' alt='$sd_branch_name'>";
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
                        <h1 class="invoice-title">INVOICE</h1>
                    </div>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-5 col-xs-offset-4 ">
                        <?echo("$sd_logo_txt")?>
                        <p><?=$sd_addr2?><br><?=$sd_addr1?> <?=$sd_zipcode?></p>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <h4 class="inv-to">SHIPPING ADDRESS</h4>
                            <h2 class="corporate-id"><?=$mb_corp_name?></h2>
                            <p><?=$mb_addr2?><br><?=$mb_addr1?> <?=$mb_zipcode?>
								<br>TEL : <?=$mb_phone1?>
								<br>Email : <?=$mb_email?>
							</p>

                        </div>
                        <div class="col-md-4 col-md-offset-3 col-sm-4 col-sm-offset-3 col-xs-4 col-xs-offset-3">
                            <div class="inv-col"><span>Invoice No. :</span> <?=$pm_inv_no?></div>
                            <div class="inv-col"><span>Invoice Date :</span> <?=$pm_inv_date_txt?></div>
							<div class="inv-col"><span>Due Date :</span> <?=$pm_due_date_txt?></div>
							<div class="inv-col"><span>Invoice Status :</span> <?=$inv_status_txt?></div>
							
                            <h1 class="t-due">TOTAL</h1>
                            <h2 class="amnt-value"><?=$pm_currency_tag?> <?=$pm_inv_amount_k?></h2>
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
				$query_HC = "SELECT count(uid) FROM shop_payment_invoice_cart WHERE inv_no = '$inv_no'";
				$result_HC = mysql_query($query_HC);
				if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
				$total_HC = @mysql_result($result_HC,0,0);
    
				$query_H = "SELECT uid,catg_code,pcode,org_pcode,pname,currency,p_unit_price,p_qty,p_unit,p_total_price 
							FROM shop_payment_invoice_cart WHERE inv_no = '$inv_no' ORDER BY pcode ASC";
				$result_H = mysql_query($query_H);
				if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
				$cart_no = 1;
    
				for($h = 0; $h < $total_HC; $h++) {
					$H_cart_uid = mysql_result($result_H,$h,0);
					$H_catg_code = mysql_result($result_H,$h,1);
					$H_pcode = mysql_result($result_H,$h,2);
					$H_org_pcode = mysql_result($result_H,$h,3);
					$H_pname = mysql_result($result_H,$h,4);
						$H_pname = stripslashes($H_pname);
					$H_currency = mysql_result($result_H,$h,5);
					$H_unit_price = mysql_result($result_H,$h,6);
						$H_unit_price_k = number_format($H_unit_price);
					$H_qty = mysql_result($result_H,$h,7);
						$H_qty_k = number_format($H_qty);
					$H_unit = mysql_result($result_H,$h,8);
					$H_tamount = mysql_result($result_H,$h,9);
						$H_tamount_k = number_format($H_tamount);
				
      
					echo ("
					<tr>
						<td>$cart_no</td>
						<td><h4>[$H_org_pcode] $H_pname</h4></p></td>
						<td class='text-center'><strong>$H_unit_price_k</strong></td>
						<td class='text-center'><strong>$H_qty_k $H_unit</strong></td>
						<td class='text-center'><strong>$H_tamount_k</strong></td>
					</tr>");
      
				$cart_no++;
				}
				?>
				

                <tr>
                    <td colspan="3" class="payment-method">
                        <h4></h4>
                        
                        
                        <br>&nbsp;<br>
                        <h3 class="inv-label">Thank you for your business</h3>
                    </td>
                    <td class="text-right">
                        <p>Sub Total</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p><strong>GRAND TOTAL</strong></p>
                    </td>
                    <td class="text-center">
                        <p><?=$pm_inv_amount_k?></p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p><strong><?=$pm_inv_amount_k?></strong></p>
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