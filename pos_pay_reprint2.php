<?php
/*
 Modified by : Cihuy Programmer;
*/	
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

// Get Elements
$transcode = $_GET['reprint'];
$void = $_GET['void'];
$voids = $_GET['voids'];

// Get data count from POS DETAIL
$query_pos_detail_C = "SELECT count(transcode) FROM pos_detail_backup WHERE transcode = '$transcode' AND temp = '9'";
$result_pos_detail_C = mysql_query($query_pos_detail_C);
if (!$result_pos_detail_C) {   error("QUERY_ERROR");   exit; }
$total_pos_detail = @mysql_result($result_pos_detail_C,0,0);

// Get data from POS TOTAL
$query_pos_total = "SELECT transaction_code,trx_date,sales_code,total 
					FROM pos_total2 WHERE transcode = '$transcode'";
$result_pos_total = mysql_query($query_pos_total);
if (!$result_pos_total) {   error("QUERY_ERROR");   exit; }
$transaction_code = @mysql_result($result_pos_total,0,0);
$trx_date_J = @mysql_result($result_pos_total,0,1);
$sales_code = @mysql_result($result_pos_total,0,2);
$payments = @mysql_result($result_pos_total,0,3);
$payments_ex = explode("|", $payments);

$total_item = $payments_ex[0];
$total_nett = $payments_ex[2];
$total_gross = $payments_ex[1];
$cash_amount = $payments_ex[5];
$cash_remain = $payments_ex[6];
$credit_amount = $payments_ex[7];
$debit_amount = $payments_ex[8];
$krediet_kaart = $payments_ex[9];
$debiet_kaart = $payments_ex[10];
$card_type = $payments_ex[11];

$nf_cash_amount = number_format($cash_amount);
$trx_date = substr($trx_date_J,0,-3);

if ($krediet_kaart != '' AND $cash_amount == 0 AND $debiet_kaart == '') {
//	echo 'CC';
    $card_no = $krediet_kaart;
} else if ($debiet_kaart != '' AND $cash_amount == 0 AND $krediet_kaart == '') {
//	echo 'DC';
    $card_no = $debiet_kaart;
} else if ($krediet_kaart != '' AND $cash_amount != '' AND $debiet_kaart == '') {
//	echo 'TK';
    $card_no = $krediet_kaart;
} else if ($debiet_kaart != '' AND $cash_amount != '' AND $krediet_kaart == '') {
//	echo 'TD';
    $card_no = $debiet_kaart;
} 


if ($total_pos_detail < 18 ) {
	$test = 1; // Jumlah nomor halaman
	$new_totale = $total_pos_detail; //Jumlah row item
	$khusus = 1; // Khusus halaman awal
} else if ($total_pos_detail > 18 AND $total_pos_detail < 40) {
	$test = 2; // Jumlah nomor halaman
	$new_totale = $total_pos_detail; //Jumlah row item
	$modulus = $new_totale-18;
} else if ($total_pos_detail > 40 AND $total_pos_detail < 60) {
	$test = 3; // Jumlah nomor halaman
	$new_totale = $total_pos_detail; //Jumlah row item
	$modulus = $new_totale-40;
}

// Kassier Aantal
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$query_kassier_2 = "SELECT no from pos_client where hostname = '$hostname'";
$fetch_kassier_2 = mysql_query($query_kassier_2);
if (!$fetch_kassier_2) { error("QUERY_ERROR"); exit; }
$kassier_aantal = mysql_result($fetch_kassier_2,0,0);

// Kassier naam
$query_kassier = "SELECT user_name FROM admin_user WHERE user_id = '$sales_code'";
$fetch_kassier = mysql_query($query_kassier);
$kassier_naam = mysql_result($fetch_kassier,0,0);
?>

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
<? 

for ($k=0; $k<$test; $k++) { 
	if ($k == 0 OR $khusus == 1) {
?>
<div class="page-break">
	
	<?if($void!=''){?>
		<img src="img_pos/void.png" width="100%" height="200" style='position: absolute;left: 0px;top: 0px;z-index: -1;opacity: 0.4;filter: alpha(opacity=40);'>
	<?}?>
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : DS-<?=substr($transaction_code, 2)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <?=date("d/m/Y H:i", strtotime($trx_date))?>  </div>
		</div>
	</div>
	
	<center ><br/>
		<div> Feelbuy - Telp: 021-7566-363 </div>
		<div> NPWP : 21.078.015.1-411.000</div>	
	</center><br/>
	<div style="float:left;">
		<div> Cashier : [<?=$kassier_aantal?>] - <?=$kassier_naam?> </div>
	</div>
	<div style="float: right;">
		<div style="float: right;">
			<? if ($void != '') { ?>
			[VOID] 
			<? } else if ($voids == 'leemte') { ?>
			<i> Void </i> - [Customer]
			<? } else { ?>
			<i> Reprint</i> - [Customer]
			<? } ?>
		</div>
	</div>

	<center>
	<!-- <table border="0" id='table1'> -->
	
	<table border="0" id='table1' style="border-top: 1px solid #000; width:100%; max-width:105mm" >
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail_backup
	WHERE sales_code = '$sales_code' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,dump,qty,package FROM pos_detail_backup 
	WHERE sales_code ='$sales_code' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysql_query($query_pay);
	if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	if ($new_totale > 18 AND $new_totale <= 40){
		$totuid_K3 = $new_totale-$modulus;
		$i = 0;
	} else if ($new_totale > 40 AND $new_totale <= 60) {
		$totuid_K3 = $new_totale-30;
		$i = 0;
	} else {
		$totuid_K3 = $totuid;
		$i = 0;
	}

	$angka_sebelumnya = 2;
	$angka_sekarang = 3;

	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid = @mysql_result($result_pay,$i,0);
		$detail = @mysql_result($result_pay,$i,1);
		$detail_ex = explode("|", $detail);
		$datedetail = @mysql_result($result_pay,$i,2);
		$temp = @mysql_result($result_pay,$i,3);
		$dump = @mysql_result($result_pay,$i,4);		
		$dump_ex = explode("|", $dump);
		$qty_k = @mysql_result($result_pay,$i,5);
		$package = @mysql_result($result_pay,$i,5);

		$pcode = $detail_ex[0];
		$barcode = $detail_ex[1];
		$price = $detail_ex[3];
		if ($fibo == '') {
		# Di mulai dari angka 2
			$angka_sebelumnya = 0;
			$angka_sekarang = 2;
		}	

		if ($fibo > 0) {
			$angka_sebelumnya = $fibo;
			$angka_sekarang = 3;
		}			

		$fibo = $angka_sekarang + $angka_sebelumnya;
		$angka_sebelumnya = $fibo;
		$angka_sekarang = 3;			

		if($pack != ''){
		$pcount="SELECT sum(qty) FROM pos_detail2 where pos_clientID = '$id_number'  group by transcode" ; 
		$fetch_pcount=mysql_query($pcount); 
		$cuidp=mysql_result($fetch_pcount,0,0); 
			
			
			if($pack == 1){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack'"; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$dis1 = $codecp * ($sps*0.1);
				
			}else if($pack == 2){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' "; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$dis2 = $codecp * ($sps*0.1);
			}else if($pack == 3){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' "; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$dis3 = $codecp * ($sps*0.1);
			}else if($pack == 4){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' "; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$dis4 = $codecp * ($sps*0.1);
			}else if($pack == 5){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' "; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$dis5 = $codecp * ($sps*0.1);
			}else if($pack == 6){
				$codecount="SELECT sum(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' "; 
				$fetch_codecount=mysql_query($codecount); 
				$codecp	=mysql_result($fetch_codecount,0,0);
				
				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$pack'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysql_result($result_getcatdis2, 0, 0);
				
				$xpack = $sps/$pack;
				$deci = floor($codecp/3);
				
				$dis6 = $deci*($xpack*0.1);
			}else if($pack == 7){
				$codecount="SELECT qty,org_pcode FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' AND org_pcode = '$packcode' "; 
				$fetch_codecount=mysql_query($codecount); 
				$qtycps	=mysql_result($fetch_codecount,0,0);
				$coda	=mysql_result($fetch_codecount,0,1);
				
				$deci = floor($qtycps/6);
				
				$query_getcatdis2 = "SELECT org_pcode,price_sale from item_masters Where org_pcode = '$coda'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$op   = @mysql_result($result_getcatdis2, 0, 0);
				$ps   = @mysql_result($result_getcatdis2, 0, 1);
				
				if($coda == $op){
					$d7 += $deci*($ps*0.1);
				}
			}else if($pack == 8){
				$codecount="SELECT qty,org_pcode FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$pack' AND org_pcode = '$packcode' "; 
				$fetch_codecount=mysql_query($codecount); 
				$qtycps	=mysql_result($fetch_codecount,0,0);
				$coda	=mysql_result($fetch_codecount,0,1);
				
				$deci = floor($qtycps/3);
				
				$query_getcatdis2 = "SELECT org_pcode,price_sale from item_masters Where org_pcode = '$coda'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$op   = @mysql_result($result_getcatdis2, 0, 0);
				$ps   = @mysql_result($result_getcatdis2, 0, 1);
				
				if($coda == $op){
					$d8 += $deci*($ps*0.1);
				}
			}
		}

		$diskon_if = $dump_ex[$fibo];
		if ($diskon_if == '1') {
			$disc_rate = 15;	
			$nett_k = $detail_ex[6];
			$nett_j = $nett_k * 0.15;
			$nett = $nett_k - $nett_j;   
		} else if($diskon_if != '1') {
			$disc_rate = 0;	
			$nett = $detail_ex[6];
		}		
		$gross = $detail_ex[5];
		$vat = $detail_ex[8];
	    $subtotal = number_format($nett);    

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode'";
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
				<td><b><?=number_format($credit_amount)?></b></td>
			</tr>										
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
			</tr>								
			<? } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_amount)?></b></td>
			</tr>		
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
			</tr>															
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_amount)?></b></td>
			</tr>		
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td><b><?=number_format($credit_amount)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
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

	<? if ($khusus != 1) { ?> 

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>	

	<? } ?>

   </div>
	<!-- Sluiting div separator - Closing div separator -->		
</div>

<?  } else if($k == 1) { ?>

<!-- Halaman Tengah -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : DS-<?=substr($transaction_code, 2)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <?=date("d/m/Y H:i", strtotime($trx_date))?> </div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail_backup 
	WHERE sales_code = '$sales_code' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,dump,qty FROM pos_detail_backup 
	WHERE sales_code ='$sales_code' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysql_query($query_pay);
	if (!$result_pay) {   error("QUERY_ERROR");   exit; }	

	if ($new_totale > 18 AND $new_totale <= 40) {
		$totuid_K3 = $new_totale;
		$i = 18;
		$khusus = 2;
	} else if ($new_totale > 40 AND $new_totale <= 60) {
		$totuid_K3 = $new_totale-$modulus;
		$i = 18;
		$khusus = 3;
	} 

	$angka_sebelumnya_2 = $angka_sebelumnya;
	$angka_sekarang_2 = $angka_sekarang;
	
	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid_2 = @mysql_result($result_pay,$i,0);
		$detail_2 = @mysql_result($result_pay,$i,1);
		$detail_ex_2 = explode("|", $detail_2);
		$datedetail_2 = @mysql_result($result_pay,$i,2);
		$temp_2 = @mysql_result($result_pay,$i,3);
		$dump_2 = @mysql_result($result_pay,$i,4);		
		$dump_ex_2 = explode("|", $dump_2);
		$qty_k_2 = @mysql_result($result_pay,$i,5);

		$pcode_2 = $detail_ex_2[0];
		$barcode_2 = $detail_ex_2[1];
		$price_2 = $detail_ex_2[3];	

		$fibo_2 = $angka_sekarang_2 + $angka_sebelumnya_2;
		$angka_sebelumnya_2 = $fibo_2;
		$angka_sekarang_2 = 3;			

		$diskon_if_2 = $dump_ex_2[$fibo_2];
		if ($diskon_if_2 == '1') {
			$disc_rate_2 = 15;	
			$nett_k_2 = $detail_ex_2[6];
			$nett_j_2 = $nett_k_2 * 0.15;
			$nett_2 = $nett_k_2 - $nett_j_2;   
		} else if($diskon_if_2 != '1') {
			$disc_rate_2 = 0;	
			$nett_2 = $detail_ex_2[6];
		}			
		#echo $diskon_if_2.'<br/>';
		$gross_2 = $detail_ex_2[5];
		$vat_2 = $detail_ex_2[8]; 
	    $subtotal_2 = number_format($nett_2);	    

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_2'";
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

	<? if ($khusus == '2') { ?>

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
				<td class="formaat"><b><?=number_format($credit_amount)?></b></td>
			</tr>										
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
			</tr>								
			<? } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_amount)?></b></td>
			</tr>		
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
			</tr>														
			<? } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($debit_amount)?></b></td>
			</tr>		
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($credit_amount)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
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

		<? if ($khusus != 2) { ?> 	

			<center>
			<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
				<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
				<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
			</div>
			</center>	

		<? 	} ?>		

   </div>
	<!-- Sluiting div separator - Closing div separator -->		
</div>

<?  } else if($k == 2) { ?>

<!-- Sisa 3 perhitungan -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break" style="border: green solid 0px">
	
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : DS-<?=substr($transaction_code, 2)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <?=date("d/m/Y H:i", strtotime($trx_date))?> </div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail_backup 
	WHERE sales_code = '$sales_code' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,dump,qty FROM pos_detail_backup 
	WHERE sales_code ='$sales_code' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysql_query($query_pay);
	if (!$result_pay) {   error("QUERY_ERROR");   exit; }	

	
	if ($new_totale > 18 AND $new_totale <= 40){
		$totuid_K3 = $new_totale;
		$i = 18;
		$khusus = 2;
	} else if ($new_totale > 40 AND $new_totale <= 60) {
		$totuid_K3 = $new_totale; 
		$i = 40;
		$khusus = 3;
	} else {
		$totuid_K3 = $totuid;
		$i = 0;
	}

	$angka_sebelumnya_3 = $angka_sebelumnya_2;
	$angka_sekarang_3 = $angka_sekarang_2;

	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid_3 = @mysql_result($result_pay,$i,0);
		$detail_3 = @mysql_result($result_pay,$i,1);
		$detail_ex_3 = explode("|", $detail_3);
		$datedetail_3 = @mysql_result($result_pay,$i,2);
		$temp_3 = @mysql_result($result_pay,$i,3);
		$qty_k_3 = @mysql_result($result_pay,$i,4);
		$dump_3 = @mysql_result($result_pay,$i,4);		
		$dump_ex_3 = explode("|", $dump_3);			
		$qty_k_3 = @mysql_result($result_pay,$i,5);

		$pcode_3 = $detail_ex_3[0];
		$barcode_3 = $detail_ex_3[1];
		$price_3 = $detail_ex_3[3];

		$fibo_3 = $angka_sekarang_3 + $angka_sebelumnya_3;
		$angka_sebelumnya_3 = $fibo_3;
		$angka_sekarang_3 = 3;			

		$diskon_if_3 = $dump_ex_3[$fibo_3];
		if ($diskon_if_3 == '1') {
			$disc_rate_3 = 15;	
			$nett_k_3 = $detail_ex_3[6];
			$nett_j_3 = $nett_k_3 * 0.15;
			$nett_3 = $nett_k_3 - $nett_j_3;   
		} else if($diskon_if_3 != '1') {
			$disc_rate_3 = 0;	
			$nett_3 = $detail_ex_3[6];
		}	
		$gross_3 = $detail_ex_3[5];
		$vat_3 = $detail_ex_3[8];  

		$subtotal_k_3 = $price_3*$qty_k_3;
	    $subtotal_3 = number_format($nett_3);	    

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_2'";
	    $result = mysql_query($query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_3 =  @mysql_result($result,0,0);
	    $p_name_3 = explode(" ", $pname_3);
	    
	    ?>
		<tr>
			<td>
				<span><?=$pcode_3?></span>
			</td>
			<td>
				<span><? echo substr($p_name_3[0],0,7).' '.substr($p_name_3[1],0,7);?></span>
			</td>
			<td>
				<center><span><?=number_format($qty_k_3)?></span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=number_format($price_3)?></span></center>
			</td>	
			<td>
				<center><span><?=$disc_rate_3?>%</span></center>
			</td>	
			<td>
				<center><span class="formaat"><?=$subtotal_3?></span></center>
			</td>
		</tr>
	
	<? 
	}

	if ($khusus == 3) {
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
				<td class="formaat"><b><?=number_format($credit_card_amount)?></b></td>
			</tr>										
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
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
				<td class="formaat"><b><?=number_format($credit_card_amount)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain)?></b></td>
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

<? } ?>

<?
} 
?>
	</div>	
</body>
</html>

<script type="text/javascript">
	window.print();

// slight update to account for browsers not supporting e.which
function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
// To disable f5
    /* jQuery < 1.7 */
$(document).bind("keydown", disableF5);
/* OR jQuery >= 1.7 */
$(document).on("keydown", disableF5);

</script>

<? 
// Kondisi untuk reprint dan void print
if ( ($reprint != '' AND $void != '') OR ($reprint != '' AND $voids == 'leemte') ) {
//	include "pos_reprint_copy.inc";
	echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_reprint_copy.php?trans=$transcode'>");
} else {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_master.php?trans=list'>");
}
?>

<? //echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_master.php?trans=list'>");	?>
<?
	if ($void != '' OR $voids == 'leemte'){
		$query_upd = "UPDATE pos_detail_backup SET temp = 'VA' WHERE transcode = '$transcode' AND temp='V'";		
		$fetch_upd = mysql_query($query_upd);
		if(!$fetch_upd) { echo "error "; die(); }
	}

//-------------------------------------------------------------------------------------------------------------------
} 
?>