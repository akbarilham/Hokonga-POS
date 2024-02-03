<?php
/*
 Modified by : Cihuy Programmer;
*/	

if(!$login_id OR $login_id == "" OR $login_level < "1") {

} else {

$transaction_code = $bespreking_kode;
$voids = $_GET['voids'];

// Get data count from POS DETAIL
$query_pos_detail_C = "SELECT count(transaction_code) FROM pos_detail WHERE transaction_code = '$transaction_code' AND temp='9'";
$result_pos_detail_C = mysql_query($query_pos_detail_C);
if (!$result_pos_detail_C) {   error("QUERY_ERROR");   exit; }
$total_pos_detail = @mysql_result($result_pos_detail_C,0,0);

// Get data from POS TOTAL
$query_pos_total = "SELECT trx_date,user_id,total_item,total_gross,total_nett,cash_amount,cash_remain,
					credit_amount,debit_amount,card_type,credit_no,debit_no 
					FROM pos_total WHERE transaction_code = '$transaction_code'";
$result_pos_total = mysql_query($query_pos_total);
if (!$result_pos_total) {   error("QUERY_ERROR");   exit; }
$trx_date_J = @mysql_result($result_pos_total,0,0);
$login = @mysql_result($result_pos_total,0,1);
$total_item = @mysql_result($result_pos_total,0,2);
$total_gross = @mysql_result($result_pos_total,0,3);
$total_nett = @mysql_result($result_pos_total,0,4);
$cash_amount = @mysql_result($result_pos_total,0,5);
$cash_remain = @mysql_result($result_pos_total,0,6);
$credit_amount = @mysql_result($result_pos_total,0,7);
$debit_amount = @mysql_result($result_pos_total,0,8);
$card_type = @mysql_result($result_pos_total,0,9);
$krediet_kaart = @mysql_result($result_pos_total,0,10);
$debiet_kaart = @mysql_result($result_pos_total,0,11);

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

// Kassier naam
$query_kassier = "SELECT user_name FROM admin_user WHERE user_id = '$login'";
$fetch_kassier = mysql_query($query_kassier);
$kassier_naam = mysql_result($fetch_kassier,0,0);

// Kassier Aantal
$query_kassier_2 = "SELECT cashier_id from pos_total where user_id = '$login'";
$fetch_kassier_2 = mysql_query($query_kassier_2);
if (!$fetch_kassier_2) { error("QUERY_ERROR"); exit; }
$kassier_aantal = mysql_result($fetch_kassier_2,0,0);
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

body {
		counter-reset: newitemk; 
	}

	#pageke::after{
		counter-increment: itemk;
	}

	#pageke::before {
		counter-increment: newitemk;
		content: counter(newitemk)"/";
	}

</style>	


<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">

<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<body style="width:105mm;height:148mm;max-width: 105mm; max-height: 148mm" >
<? 

for ($k=0; $k<$test; $k++) { 
	if ($k == 0 OR $khusus == 1) {
?>
<div class="page-break">
	
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : <?=$transaction_code?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 22%">
			<div> <?=date("d/m/Y H:i", strtotime($trx_date))?> </div>
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
		<? if($voids == 'leemte') { ?>
		<i> Void - </i> [Copy] 
		<? } else { ?>
		[Copy]
		<?}?>		
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,org_pcode,date,price,sales_code,transcode,temp,qty,barcode,disc_rate,vat,nett,temp 
				  from pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";			 
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

<!-- Sisa nya perhitungan -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break">
	
	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : <?=$transaction_code?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?=$test?></div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,org_pcode,date,price,sales_code,transcode,temp,qty,barcode,disc_rate,vat,nett,temp 
				  from pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";			 
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
			<div> No : <?=$transaction_code?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?=$test?></div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";
	$result_total_pay = mysql_query($query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysql_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,org_pcode,date,price,sales_code,transcode,temp,qty,barcode,disc_rate,vat,nett,temp 
				  from pos_detail WHERE transaction_code = '$transaction_code' AND temp = '9'";			 
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


	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) { 
		$uid_3 = @mysql_result($result_pay,$i,0);
		$pcode_3 = @mysql_result($result_pay,$i,1);
		$datetime_3 = @mysql_result($result_pay,$i,2);
		$price_3= @mysql_result($result_pay,$i,3);
		$scode_3 = @mysql_result($result_pay,$i,4);
		$tcode_3 = @mysql_result($result_pay,$i,5);
		$temp_3 = @mysql_result($result_pay,$i,6);
		$qty_k_3 = @mysql_result($result_pay,$i,7);
		$barcode_3 = @mysql_result($result_pay,$i,8);
		$disc_rate_3 = @mysql_result($result_pay,$i,9);
		$vat_k_3 = @mysql_result($result_pay,$i,10);
		$nett_3 = @mysql_result($result_pay,$i,11);

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

<?
//-------------------------------------------------------------------------------------------------------------------
} 
?>