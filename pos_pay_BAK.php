<?php
/*
 Modified by : Cihuy Programmer;
 Version : 9.0
*/	
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

function start_transaction(){
	mysql_query("START TRANSACTION");
}

function commit(){
    mysql_query("COMMIT");
}

function rollback(){
    mysql_query("ROLLBACK");
}

// -------------------Get Elements--------------------------------- //
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ip =  $_SERVER['REMOTE_ADDR'];
$total_item = $_POST['totqty'];
$total_nett = $_POST['total'];
$total_gross = $_POST['gross'];
$total_nettax = $_POST['nettvat'];
$total_vat = $_POST['vat'];
$cash_amount = $_POST['cashpay'];
$card_type = $_POST['type'];
$cash_remain = $_POST['change'];
$credit_card = $_POST['cardcre'];
$debit_card = $_POST['carddeb'];
$transcode = $_POST['transcode'];
$modulus = $_POST['modus'];
// ---------------------------------------------------- //

// -----------------Cashier Number Function---------------------- //
$query_kassier = "SELECT no from pos_client where hostname = '$hostname'";
$fetch_kassier = mysql_query($query_kassier);
if (!$fetch_kassier) { error("QUERY_ERROR"); exit; }
$kassier_aantal = mysql_result($fetch_kassier,0,0);

if ($kassier_aantal == ''){
	$kassier_aantal = '01';
}
// ---------------------------------------------------- //

// -----------------Print Method Function---------------------- //
$void = 'ja';
$cancel = 'ja';
$hold = $_GET['hold'];
// ---------------------------------------------------- //

// -----------------Card Function---------------------- //
if ($cash_amount == 0) {
	$cash_amount = '';
}

if ($credit_card != '' AND $cash_amount == 0 AND $debit_card == '') {
//	echo 'CC';
    $card_type = 9;
    $card_no = $credit_card;
} else if ($debit_card != '' AND $cash_amount == 0 AND $credit_card == '') {
//	echo 'DC';
    $card_type = 6;
    $card_no = $debit_card;
} else if ($credit_card != '' AND $debit_card != '' AND $cash_amount == '') {
//	echo 'DK';
	$krediet_kaart = $credit_card;
	$debiet_kaart = $debit_card;
	$card_type = 'DK';
} else if ($credit_card != '' AND $cash_amount != '' AND $debit_card == '') {
//	echo 'TK';
    $card_type = 'TK';
    $card_no = $credit_card;
} else if ($debit_card != '' AND $cash_amount != '' AND $credit_card == '') {
//	echo 'TD';
    $card_type = 'TD';
    $card_no = $debit_card;
} else if ($credit_card != '' AND $debit_card != '' AND $cash_amount != '') {
//	echo 'TKD';
	$krediet_kaart = $credit_card;
	$debiet_kaart = $debit_card;
	$card_type = 'TKD';    
} else if ($cash_amount != '' AND $debit_card == '' AND $credit_card == '') {
//	echo 'Tunai';
	$card_type = 3;
}


// Convert to Number Format (Cash Amount)
$nf_cash_amount = number_format($cash_amount);

// Kontant Funksie
if ($cash_amount == '') {
	$nf_cash_amount = 0;
	$cash_amount = 0;
}	

if($debit_card == ''){
	$debit_card_amount = 0;
} else {
	$debit_card_amount = $_POST['debamo'];
}

if($credit_card == ''){
	$credit_card_amount = 0;
} else {
	$credit_card_amount = $_POST['creamo'];
}

if ($debit_card_amount != '' || $credit_card_amount != '' && $cash_amount == '') {
	$cash_remain2 = 0;
}

// Remain Funksie
$kontant_bly = $cash_amount + $debit_card_amount + $credit_card_amount;
$cash_remain2 = $kontant_bly - $total_nett;

$tanggal = date('Y-m-d');
// ---------------------------------------------------- //

	// Condition transaction code without AS 
	$query_DS = "SELECT transaction_code from pos_detail where transaction_code not in (SELECT transaction_code from pos_detail where transaction_code like 'AS%');";
	$fetch_DS = mysql_query($query_DS);
	if (!$fetch_DS) { error("QUERY_ERROR"); exit; }
	$old_transaction_code = mysql_result($fetch_DS,0,0); 

	// Condition transaction code with AS
	$query_BS = "SELECT transcode from pos_detail where sales_code = '$login_id' AND transaction_code not in (SELECT transaction_code from pos_detail where transaction_code like 'BS%');";
	$fetch_BS = mysql_query($query_BS);
	if (!$fetch_BS) { error("QUERY_ERROR"); exit; }
	$tcode2 = mysql_result($fetch_BS,0,0); 	

	// CREATE TRANSACTION CODE ENAAA	
	if ($old_transaction_code == '') {
	
		// Transaction code begin
		$query_trans0 = "SELECT CONCAT ('BS-' ,SUBSTR( DATE_FORMAT(NOW(), '%Y%m%d'), 3, 10 ),'000', + 1 ) FROM pos_detail";
		$fetch_trans0 = mysql_query($query_trans0);
		if (!$fetch_trans0) { error("QUERY_ERROR"); exit; }
		$new_transaction_code = mysql_result($fetch_trans0,0,0);

		// INSERT invoice into database -- Booking transaction_code
		start_transaction();
		$query_book = mysql_query("INSERT INTO pos_total (transaction_code,hostname,cashier_id,sesskey) VALUES ('$new_transaction_code','$hostname','$kassier_aantal','$tcode2')",$dbconn);
		if (!$query_book) { 
			rollback();
			error("QUERY_ERROR"); 
			exit; 
		} else {
			commit();
		}	 
			

	} else if ($old_transaction_code != '') {

		// Transaction code nextval
		$query_trans = "SELECT CONCAT ('BS-', ifnull(max(right(transaction_code, 10)), 3) + 1 ) from pos_total where transaction_code like 'BS%'";
		$result_trans = mysql_query($query_trans);
		if (!$result_trans) { error("QUERY_ERROR"); exit; }
		$new_transaction_code = mysql_result($result_trans,0,0);

		// INSERT invoice into database -- Booking transaction_code	
		start_transaction();
		$query_book = mysql_query("INSERT INTO pos_total (transaction_code,hostname,cashier_id,sesskey) VALUES ('$new_transaction_code','$hostname','$kassier_aantal','$tcode2')",$dbconn);
		if (!$query_book) { 
			rollback();
			error("QUERY_ERROR"); 
			exit; 
		} else {
			commit();
		}

	}
/*
	// Condition transaction code with DS
	$query_trans1 = "SELECT MAX(transaction_code) from pos_total where sales_code = '$login_id'";
	$fetch_trans1 = mysql_query($query_trans1);
	if (!$fetch_trans1) { error("QUERY_ERROR"); exit; }
	$end_transaction_code = mysql_result($fetch_trans1,0,0); 
*/
//--------------------------------------------------------------------
?>
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<style type="text/css">

table { border-collapse:collapse; }
.table1 { border-bottom: 1px solid #000; }

th,td { padding:0 4px 0 4px; font-size:small; }
div {
    font-size:small;
}		
.lyn {
	border-top: 1px solid #000;
}
span { padding: 2px 0px 0px 5px; display: block; }

.formaat { text-align: right; }

@media screen {
	.page-break { display: none }
}

@media print {
	.page-break	{ page-break-before: always; }
	#footer { position: fixed; bottom: 0; }
}
	body {
		counter-reset: newitem;
	}

	#pagek::after{
		counter-increment: item;
		/*margin-left: 10%;*/
	}

	#pagek::before {
		counter-increment: newitem;
		content: counter(newitem)"/";
	}

</style>	


<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<html>
<head>
	<title>Receipt for Point of Sales</title>
</head>
<body style="width:105mm;height:148mm;max-width: 105mm; max-height: 148mm" >

   <?// --------------------------------------------------------------------------------------------------------- ?>
   <?// -----------------------------------Reprint Receipt------------------------------------------------------- ?>
   <? if($reprint != '') { ?>
   		<div>Reprint is not available</div>
   <? } ?>

   <?// --------------------------------------------------------------------------------------------------------- ?>
   <?// -----------------------------------Receipt for Customers------------------------------------------------- ?>
	
<? 
// Total Page
$test = $_POST['teste']; // Jumlah nomor halaman
$new_totale = $_POST['totale']; //Jumlah row item
$khusus = $_POST['khusus']; // Khusus halaman awal
$totupage = @mysql_result($result_page,0,0); //Jumlah kertas halaman

for ($k=0; $k<$test; $k++) { 
	if ($k == 0 OR $khusus == 1) {
?>
<div class="page-break">
	
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : <?=$new_transaction_code?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <? echo date('d/m/Y H:i')?> </div>
		</div>
	</div>
	
	<center><br/>
		<div> Lock&Lock - Telp: 021-5316-4854 </div>
		<div> NPWP : 01.997.873.3-441.000</div>	
	</center><br/>
	<div style="float:left;">
		<div> Cashier : [01] - <?=$login?> </div>
	</div>
	<div style="float: right;">
		<div style="float: right;"> [Customer] </div>
	</div>

	<center>
	<!-- <table border="0" id='table1'> -->
	<table border="0" id='table1' style="border-top: 1px solid #000; width:100%; max-width:105mm">
		<thead id='table1'>
		<tr>
			<th id='table1'>
				<center><span>Item</span></center>
			</th>
            <th id='table1'>
            	<center><span>Name</span></center>
            </th>
            <th id='table1'>
            	<center><span>Qty</span></center>
            </th>
            <th id='table1'>
            	<center><span>Normal</span></center>
            </th>
            <th id='table1'>
            	<center><span>Disc</span></center>
            </th>
			<th id='table1'>
				<center><span>Amount</span></center>
			</th>
		</tr>
		</thead>

	<?
	// Total all carts
	$query_total_pay = "SELECT count(uid) FROM pos_detail WHERE sales_code ='$login' AND temp = 0 AND hostname = '$hostname'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,org_pcode,date,price,sales_code,transcode,temp,qty,barcode,disc_rate,vat,nett,temp 
				  from pos_detail WHERE sales_code ='$login' AND temp = 0 AND hostname = '$hostname'";			 
	$result_pay = mysql_query($query_pay);
	if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	if ($new_totale > 20 AND $new_totale <= 40){
		$totuid_K3 = $new_totale-$modulus;
		$i = 0;
	} else if ($new_totale > 40 AND $new_totale <= 60) {
		$totuid_K3 = $new_totale-$modulus;
		$i = 0;
	} else {
		$totuid_K3 = $totuid;
		$i = 0;
	}

	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid = @mysql_result($result_pay,$i,0);
		$pcode = @mysql_result($result_pay,$i,1);
		$datetime = @mysql_result($result_pay,$i,2);
		$price = @mysql_result($result_pay,$i,3);
		$scode = @mysql_result($result_pay,$i,4);
		$tcode = @mysql_result($result_pay,$i,5);
		$temp = @mysql_result($result_pay,$i,6);
		$qty_k = @mysql_result($result_pay,$i,7);
		$barcode = @mysql_result($result_pay,$i,8);
		$disc_rate = @mysql_result($result_pay,$i,9);
		$vat_k = @mysql_result($result_pay,$i,10);
		$nett = @mysql_result($result_pay,$i,11);
		$status = @mysql_result($result_pay,$i,12);

		$subtotal_k = $price*$qty_k;
	    $subtotal = number_format($nett);    

	    $query = "SELECT pname FROM shop_product_list WHERE org_pcode = '$pcode'";
	    $result = mysql_query($query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname =  @mysql_result($result,0,0);
	    $p_name = explode(" ", $pname);
	    
	    ?>
		<tr>
			<td>
				<span><?=$pcode?></span>
			</td>
			<td>
				<span><? echo substr($p_name[0],0,7).' '.substr($p_name[1],0,7);?></span>
				<!--<span><? echo substr($pname,0,20);?></span>-->		
			</td>
			<td>
				<center><span><?=number_format($qty_k)?></span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=number_format($price)?></span></center>
			</td>	
			<td>
				<center><span><?=$disc_rate?>%</span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=$subtotal?></span></center>
			</td>
		</tr>
	
	<? 
	}
	?>

	<? if ($khusus == 1) { ?>
		<tr class="lyn" style="margin-top: 30%">
			<td colspan="2"><span><b><center>TOTAL</center></b></span></td>
			<td><span><b><center><?=number_format($total_item)?></center></b></span></td>	
			<td><center><span class="formaat"><b><?=number_format($total_gross)?></b></span></center></td>	
			<td>&nbsp;</td>
			<td colspan="3"><center><span class="formaat"><b><?=number_format($total_nett)?></b></span></center></td>
		</tr>	

	</table>
	</center>
	<div style="margin:1px"></div>
	<!-- div separator -->
	<div class="col-lg-12" style="border: 0px solid red; ">

		<!-- linker kolom  - left column -->
		<div class="col-md-24" style="border: 0px solid green; float: left; width: 49%; ">
		<table border="0" id='table1' style="border: 0px solid green; float: left;">
			<tr>
				<td height="">&nbsp;</td>
			</tr>
			<? if($card_type == '6' OR $card_type == '9' OR $card_type == 'TK' OR $card_type == 'TD') { ?>
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($card_no,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>			
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>							
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') { ?>
			<tr>
				<td colspan="3">Kartu Debit : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($debiet_kaart,-4);?></td>
			</tr>			
			<tr>
				<td colspan="3">Kartu Kredit : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($krediet_kaart,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>			
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>													
			<? } else { ?>								
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>							
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td height="">&nbsp;</td>
			</tr>
			<? } ?>																				
		</table>		
		</div>

		<!-- regter kolom - right column -->
		<div class="col-md-24" style="border: 0px solid yellow; float: right; width: 50%">
		<table border="0" id='table1' style="border:0px solid red; float: right;">
			<tr>
				<td height="">&nbsp;</td>
			</tr>			
			<!-- Kontant  -->
			<tr>
				<td colspan="3">Tunai</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=$nf_cash_amount?></b></td>
			</tr>			
			<?	if ($card_type == '9' OR $card_type == 'TK') { // Krediet	?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td><b><?=number_format($credit_card_amount)?></b></td>
			</tr>										
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>								
			<? } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_card_amount)?></b></td>
			</tr>		
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>															
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_card_amount)?></b></td>
			</tr>		
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td><b><?=number_format($credit_card_amount)?></b></td>
			</tr>				
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>																		
			<? } else { // No Krediet dan Debiet ?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
			</tr>													
			<? } ?>			
		</table>			
		</div>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>
	<? } ?>

	</table>
	</center>

   </div>
	<!-- Sluiting div separator - Closing div separator -->		
</div>

<?  } else if($k == $test-1 AND $khusus != 1) { ?>

<!-- Sisa nya perhitungan -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break">
	
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : <?=$new_transaction_code?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <? echo date('d/m/Y H:i')?> </div>
		</div>
	</div>
	<br/>

	<center>
	<!-- <table border="0" id='table1'> -->
	<table border="0" id='table1' style="border-top: 0px solid #000;width:100%; max-width:105mm">
		<thead id='table1'>
		<tr>
			<th id='table1'>
				<center><span>Item</span></center>
			</th>
            <th id='table1'>
            	<center><span>Name</span></center>
            </th>
            <th id='table1'>
            	<center><span>Qty</span></center>
            </th>
            <th id='table1'>
            	<center><span>Normal</span></center>
            </th>
            <th id='table1'>
            	<center><span>Disc</span></center>
            </th>
			<th id='table1'>
				<center><span>Amount</span></center>
			</th>
		</tr>
		</thead>

	<?

	// Total all carts
	$query_total_pay = "SELECT count(uid) FROM pos_detail WHERE sales_code ='$login' AND temp = 0 AND hostname = '$hostname'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,org_pcode,date,price,sales_code,transcode,temp,qty,barcode,disc_rate,vat,nett,temp 
				  from pos_detail WHERE sales_code ='$login' AND temp = 0 AND hostname = '$hostname'";			 
				//echo $query_pay;
	$result_pay = mysql_query($query_pay);
	if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	if ($new_totale > 20 AND $new_totale <= 40){
		$totuid_K3 = $new_totale;
		$i = 20;
	} else if ($new_totale > 40 AND $new_totale <= 60) {
		$totuid_K3 = $new_totale;
		$i = 40;
	} else {
		$totuid_K3 = $totuid;
		$i = 0;
	}

	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid_2 = @mysql_result($result_pay,$i,0);
		$pcode_2 = @mysql_result($result_pay,$i,1);
		$datetime_2 = @mysql_result($result_pay,$i,2);
		$price_2 = @mysql_result($result_pay,$i,3);
		$scode_2 = @mysql_result($result_pay,$i,4);
		$tcode_2 = @mysql_result($result_pay,$i,5);
		$temp_2 = @mysql_result($result_pay,$i,6);
		$qty_k_2 = @mysql_result($result_pay,$i,7);
		$barcode_2 = @mysql_result($result_pay,$i,8);
		$disc_rate_2 = @mysql_result($result_pay,$i,9);
		$vat_k_2 = @mysql_result($result_pay,$i,10);
		$nett_2 = @mysql_result($result_pay,$i,11);
		$status_2 = @mysql_result($result_pay,$i,12);

		$subtotal_k_2 = $price_2*$qty_k_2;
	    $subtotal_2 = number_format($nett_2);	    

	    $query = "SELECT pname FROM shop_product_list WHERE org_pcode = '$pcode_2'";
	    $result = mysql_query($query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_2 =  @mysql_result($result,0,0);
	    
	    ?>
		<tr>
			<td>
				<span><?=$pcode_2?></span>
			</td>
			<td>
				<span><? echo substr($p_name[0],0,7).' '.substr($p_name[1],0,7);?></span>
			</td>
			<td>
				<center><span><?=number_format($qty_k_2)?></span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=number_format($price_2)?></span></center>
			</td>	
			<td>
				<center><span><?=$disc_rate_2?>%</span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=$subtotal_2?></span></center>
			</td>
		</tr>
	
	<? 
	}
	?>

		<tr class="lyn" style="margin-top: 30%">
			<td colspan="2"><span><b><center>TOTAL</center></b></span></td>
			<td><span><b><center><?=number_format($total_item)?></center></b></span></td>	
			<td><center><span class="formaat"><b><?=number_format($total_gross)?></b></span></center></td>	
			<td>&nbsp;</td>
			<td colspan="3"><center><span class="formaat"><b><?=number_format($total_nett);?></b></span></center></td>
		</tr>	

	</table>
	</center>
	<div style="margin:1px"></div>
	<!-- div separator -->
	<div class="col-lg-12" style="border: 0px solid red; ">

		<!-- linker kolom  - left column -->
		<div class="col-md-24" style="border: 0px solid green; float: left; width: 49%; ">
		<table border="0" id='table1' style="border: 0px solid green; float: left;">
			<tr>
				<td height="">&nbsp;</td>
			</tr>
			<? if($card_type == '6' OR $card_type == '9') { ?>
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($card_no,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>			
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>							
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') { ?>
			<tr>
				<td colspan="3">Kartu Debit : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($debiet_kaart,-4);?></td>
			</tr>			
			<tr>
				<td colspan="3">Kartu Kredit : </td>
			</tr>							
			<tr>
				<td colspan="3"><? echo '****-****-****-'.substr($krediet_kaart,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>			
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>										
			<? } else { ?>								
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>							
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td height="">&nbsp;</td>
			</tr>
			<? } ?>																				
		</table>		
		</div>

		<!-- regter kolom - right column -->
		<div class="col-md-24" style="border: 0px solid yellow; float: right; width: 50%">
		<table border="0" id='table1' style="border:0px solid red; float: right;">
			<tr>
				<td height="">&nbsp;</td>
			</tr>			
			<!-- Kontant  -->
			<tr>
				<td colspan="3">Tunai</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=$nf_cash_amount?></b></td>
			</tr>			
			<? if ($card_type == '9' OR $card_type == 'TK') { // Krediet ?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td><b><?=number_format($credit_card_amount)?></b></td>
			</tr>										
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>								
			<? } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_card_amount)?></b></td>
			</tr>		
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>														
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_card_amount)?></b></td>
			</tr>		
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td><b><?=number_format($credit_card_amount)?></b></td>
			</tr>				
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>						
			<? } else { // No Krediet dan Debiet ?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
			</tr>													
			<? } ?>			
		</table>			
		</div>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>

   </div>
	<!-- Sluiting div separator - Closing div separator -->		
</div>
<?
	} 
} 
?>

   <?// --------------------------------------------------------------------------------------------------------- ?>
   <?// -----------------------------------Receipt Copy for us--------------------------------------------------- ?>
   <? /*
	
		*/ ?>
   <?// --------------------------------------------------------------------------------------------------------- ?>
   <?// -----------------------------------End Receipt Copy for us----------------------------------------------- ?>
	</div>	
</body>
</html>
<script type="text/javascript">
	window.print();
</script>
<? echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>");	?>
<?
	$tanggal = date('Y-m-d');

/*	if ($hold != '') {

		// UPDATE transaction code and TEMP ( BEGIN )
		start_transaction();
		$query_trans_upd = "UPDATE pos_detail SET temp = '9', transaction_code = '$new_transaction_code' where hostname = '$hostname' AND sales_code = '$login' AND transcode = '$tcode2' AND temp = '1'";
		$fetch_trans_upd = mysql_query($query_trans_upd);
		if (!$fetch_trans_upd) { 
			rollback();
			error("QUERY_ERROR"); 
			exit; 
		} else {
			commit();
		}

		// Get Booking transaction code
		$query_bespreking = "SELECT transaction_code,hostname,cashier_id,sesskey FROM pos_total where hostname = '$hostname' AND cashier_id = '$kassier_aantal' AND sesskey = '$tcode2'";
		$fetch_bespreking = mysql_query($query_bespreking);
		if (!$fetch_bespreking) { error("QUERY_ERROR"); exit; }
		$bespreking_kode = mysql_result($fetch_bespreking,0,0);
		$bespreking_hostname = mysql_result($fetch_bespreking,0,1);
		$bespreking_kassier = mysql_result($fetch_bespreking,0,2);
		$bespreking_tcode = mysql_result($fetch_bespreking,0,3);
		
		// Finishing 
		start_transaction();
		$query_total = mysql_query("UPDATE pos_total SET trx_date = '$tanggal', user_id = '$login_id', hostname = '$bespreking_hostname',cashier_id = '$bespreking_kassier', total_item = '$total_item', total_gross = '$total_gross', total_nett = '$total_nett', total_nettax = '$total_nettax', total_vat = '$total_vat', cash_amount = '$cash_amount', cash_remain = '$cash_remain2',credit_amount = '$credit_card_amount',debit_amount = '$debit_card_amount', credit_no = '$credit_card', debit_no = '$debit_card' , card_type = '$card_type', status = 'P' WHERE transaction_code = '$bespreking_kode'",$dbconn);
		if (!$query_total) { 
			rollback();
			error("QUERY_ERROR"); 
			exit;
		} else {
			commit();
		}

		if ($total_item != ''){
			rollback();
		}

	} else { */

		// UPDATE transaction code and TEMP ( BEGIN )
		start_transaction();
		$query_trans_upd = "UPDATE pos_detail SET temp = '9', transaction_code = '$new_transaction_code' where hostname = '$hostname' AND sales_code = '$login' AND transcode = '$tcode2' AND temp = '0'";
		$fetch_trans_upd = mysql_query($query_trans_upd);
		if (!$fetch_trans_upd) { 
			rollback();
			error("QUERY_ERROR"); 
			exit; 
		} else {
			commit();
		}

		// Get Booking transaction code
		$query_bespreking = "SELECT transaction_code,hostname,cashier_id,sesskey FROM pos_total where hostname = '$hostname' AND cashier_id = '$kassier_aantal' AND sesskey = '$tcode2'";
		$fetch_bespreking = mysql_query($query_bespreking);
		if (!$fetch_bespreking) { error("QUERY_ERROR"); exit; }
		$bespreking_kode = mysql_result($fetch_bespreking,0,0);
		$bespreking_hostname = mysql_result($fetch_bespreking,0,1);
		$bespreking_kassier = mysql_result($fetch_bespreking,0,2);
		$bespreking_tcode = mysql_result($fetch_bespreking,0,3);
		
		// Finishing 
		start_transaction();
		$query_total = mysql_query("UPDATE pos_total SET trx_date = '$tanggal', user_id = '$login_id', hostname = '$bespreking_hostname',cashier_id = '$bespreking_kassier', total_item = '$total_item', total_gross = '$total_gross', total_nett = '$total_nett', total_nettax = '$total_nettax', total_vat = '$total_vat', cash_amount = '$cash_amount', cash_remain = '$cash_remain2',credit_amount = '$credit_card_amount',debit_amount = '$debit_card_amount', credit_no = '$credit_card', debit_no = '$debit_card' , card_type = '$card_type', status = 'P' WHERE transaction_code = '$bespreking_kode'",$dbconn);
		if (!$query_total) { 
			rollback();
			error("QUERY_ERROR"); 
			exit;
		} else {
			commit();
		}

		if ($total_item != ''){
			rollback();
		} 
	//}

//-------------------------------------------------------------------- 
} 
?>