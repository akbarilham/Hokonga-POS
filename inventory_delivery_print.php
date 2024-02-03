<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_delivery";
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
$query_HC = "SELECT do_num FROM shop_product_list_do WHERE uid = '$P_uid'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$do_num = @mysql_result($result_HC,0,0);



// 수신자 정보
$mb_query = "SELECT uid,supp_name,supp_code,email,phone1,phone_fax,zipcode,addr1,addr2 FROM client_supplier WHERE supp_code = '$pm_client_code'";
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


// Logo
$query_logo = "SELECT img1 FROM client_branch WHERE branch_code = '$login_branch'";
$result_logo = mysql_query($query_logo);
if(!$result_logo) { error("QUERY_ERROR"); exit; }
   $row_logo = mysql_fetch_object($result_logo);

$logo_file = $row_logo->img1;

if($logo_file != "") {
	$logo_img_file = "user_file/$logo_file";
} else {
	$logo_img_file = "img/logo/logo_host.png";
}


$query_do = "SELECT uid,gate,gudang_code,shop_code,user_id,user_code_pic,user_code_get FROM shop_product_list_do WHERE do_num = '$do_num'";
$result_do = mysql_query($query_do);
if (!$result_do) {   error("QUERY_ERROR");   exit; }

$doa_uid = @mysql_result($result_do,0,0);
$doa_gudang_code = @mysql_result($result_do,0,1);
$doa_shop_code = @mysql_result($result_do,0,2);
$doa_user_id = @mysql_result($result_do,0,3);
$doa_user_code_pic = @mysql_result($result_do,0,4);
$doa_user_code_get = @mysql_result($result_do,0,5);

// Manager Names
$query_m1 = "SELECT name FROM member_staff WHERE id = '$doa_user_id' ORDER BY uid DESC";
$result_m1 = mysql_query($query_m1,$dbconn);
    
$doa_manager_name = @mysql_result($result_m1,0,0);

$query_m2 = "SELECT name FROM member_staff WHERE code = '$doa_user_code_pic' ORDER BY uid DESC";
$result_m2 = mysql_query($query_m2,$dbconn);
    
$doa_manager_pic_name = @mysql_result($result_m2,0,0);

$query_m3= "SELECT name FROM member_staff WHERE code = '$doa_user_code_get' ORDER BY uid DESC";
$result_m3 = mysql_query($query_m3,$dbconn);
    
$doa_manager_get_name = @mysql_result($result_m3,0,0);
?>


<!--body wrapper start-->
    <div class="wrapper">
        <div class="panel">
            <div class="panel-body invoice">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-3">
                        <h1 class="invoice-title">Surat Jalan</h1>
                    </div>
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-5 col-xs-offset-4 ">
                        <img class="inv-logo" src="<?echo("$logo_img_file")?>" alt=""/>
                        <p><?=$addr2?><br><?=$addr1?> <?=$zipcode?></p>
                    </div>
                </div>
                <div class="invoice-address">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <h4 class="inv-to">Surat Jalan To</h4>
                            <h2 class="corporate-id">Delivery Team</h2>
                            <p>
								<?=$doa_manager_pic_name?>
							
							</p>

                        </div>
                        <div class="col-md-4 col-md-offset-3 col-sm-4 col-sm-offset-3 col-xs-4 col-xs-offset-3">
                            <div class="inv-col"><span>SJ No. :</span> <?=$do_num?></div>
                            <div class="inv-col"><span>SJ Date :</span> <?=$signdate_txt?></div>
                            <h1 class="t-due">  </h1>
                            <h2 class="amnt-value">  </h2>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-invoice">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Item Description</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Shop Code</th>
                </tr>
                </thead>
                <tbody>
				
				<?
				// 상세 리스트
    $query_HC = "SELECT count(uid) FROM shop_product_list_qty WHERE do_num = '$do_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
	
	$query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,date,pcode 
                      FROM shop_product_list_qty WHERE do_num = '$do_num' ORDER BY date ASC";
        $result_qs2 = mysql_query($query_qs2,$dbconn);
        if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

    for($qs = 0; $qs < $total_HC; $qs++) {
          $qs_uid = mysql_result($result_qs2,$qs,0);
          $qs_stock = mysql_result($result_qs2,$qs,1);
          $qs_date = mysql_result($result_qs2,$qs,2);
          $qs_flag = mysql_result($result_qs2,$qs,3);
          $qs_pay_num = mysql_result($result_qs2,$qs,4);
          $qs_gudang_code = mysql_result($result_qs2,$qs,5);
          $qs_supp_code = mysql_result($result_qs2,$qs,6);
          $qs_shop_code = mysql_result($result_qs2,$qs,7);
          $qs_org_uid = mysql_result($result_qs2,$qs,8);
          $qs_date = mysql_result($result_qs2,$qs,9);
		  $qs_pcode = mysql_result($result_qs2,$qs,10);
          
          $qday1 = substr($qs_date,0,4);
	        $qday2 = substr($qs_date,4,2);
	        $qday3 = substr($qs_date,6,2);
	        $qday4 = substr($qs_date,8,2);
	        $qday5 = substr($qs_date,10,2);
	        $qday6 = substr($qs_date,12,2);
		

          if($lang == "ko") {
	          $qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3".", "."$qday4".":"."$qday5".":"."$qday6";
	        } else {
	          $qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1".", "."$qday4".":"."$qday5".":"."$qday6";
	        }
      
      
      
		// 상품 정보 추출
		$query_dari = "SELECT uid,pname,product_option1,product_option2,product_option3,product_option4,product_option5,
			price_orgin,dc_rate,save_point FROM shop_product_list WHERE pcode = '$qs_pcode'";
		$result_dari = mysql_query($query_dari);
		if(!$result_dari) { error("QUERY_ERROR"); exit; }
		$row_dari = mysql_fetch_object($result_dari);

		$dari_uid = $row_dari->uid;
		$dari_pname = $row_dari->pname;
		$dari_product_option1 = $row_dari->product_option1;
		$dari_product_option2 = $row_dari->product_option2;
		$dari_product_option3 = $row_dari->product_option3;
		$dari_product_option4 = $row_dari->product_option4;
		$dari_product_option5 = $row_dari->product_option5;
		$prd_price_orgin = $row_dari->price_orgin;
			$prd_price_orgin_K = number_format($prd_price_orgin);
		$prd_dc_rate = $row_dari->dc_rate;
		$prd_save_point = $row_dari->save_point;
		
		if($dari_product_option1 != "") { $dari_product_option1_txt = "[$dari_product_option1]"; } else { $dari_product_option1_txt = ""; }
		if($dari_product_option2 != "") { $dari_product_option2_txt = "[$dari_product_option2]"; } else { $dari_product_option2_txt = ""; }
		if($dari_product_option3 != "") { $dari_product_option3_txt = "[$dari_product_option3]"; } else { $dari_product_option3_txt = ""; }
		if($dari_product_option4 != "") { $dari_product_option4_txt = "[$dari_product_option4]"; } else { $dari_product_option4_txt = ""; }
		if($dari_product_option5 != "") { $dari_product_option5_txt = "[$dari_product_option5]"; } else { $dari_product_option5_txt = ""; }
      
					echo ("
					<tr>
						<td>$cart_no</td>
						<td>
							<h4>$qs_pcode {$dari_pname} </h4>
							<p>{$dari_product_option1_txt}{$dari_product_option2_txt}</p>
						</td>
						<td class='text-center'><strong>$qs_stock</strong></td>
						<td class='text-center'><strong>$qs_shop_code</strong></td>
					</tr>");
      
				$cart_no++;
				}
				?>
				

                <tr>
                    <td colspan="2" class="payment-method">
                        <h4>Comment</h4>
                        
                        
                        <br>
                        <h3 class="inv-label">Thank you</h3>
                    </td>
                    <td class="text-right">
                        <p>Sub Total</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p><strong>GRAND TOTAL</strong></p>
                    </td>
                    <td class="text-center">
                        <p><?=$p_total_price_K?></p>
                        <p>&nbsp;</p>
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