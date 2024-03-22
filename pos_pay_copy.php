<?php
/*
 Modified by : Cihuy Programmer;
*/
include "config/common.php";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";

function start_transaction(){
	mysqli_query($dbconn, "START TRANSACTION");
}

function begin(){
	mysqli_query($dbconn, "BEGIN");
}

function commit(){
	mysqli_query($dbconn, "COMMIT");
}

function rollback(){
	mysqli_query($dbconn, "ROLLBACK");
}

$voids = $_GET['voids'];
$transcode = $_GET['trans'];

// Get data count from POS DETAIL
$query_pos_detail_C = "SELECT count(transcode) FROM pos_detail2 WHERE transcode = '$transcode' AND temp='9'";
$result_pos_detail_C = mysqli_query($dbconn, $query_pos_detail_C);
if (!$result_pos_detail_C) {   error("QUERY_ERROR");   exit; }
$total_pos_detail = @mysqli_result($result_pos_detail_C,0,0);

// Get data from POS TOTAL
$query_pos_total = "SELECT transaction_code,trx_date,sales_code,total
					FROM pos_total2 WHERE transcode = '$transcode'";
$result_pos_total = mysqli_query($dbconn, $query_pos_total);
if (!$result_pos_total) {   error("QUERY_ERROR");   exit; }

$transaction_code = @mysqli_result($result_pos_total,0,0);
$trx_date_J = @mysqli_result($result_pos_total,0,1);
$payments = @mysqli_result($result_pos_total,0,3);
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
$detail_J = $_GET['detail'];
$pos_client_id = $_GET['lid'];

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
} else if ($total_pos_detail > 18 AND $total_pos_detail <= 40) {
	$test = 2; // Jumlah nomor halaman
	$new_totale = $total_pos_detail; //Jumlah row item
	$modulus = $new_totale-18;
} else if ($total_pos_detail > 40 AND $total_pos_detail <= 60) {
	$test = 3; // Jumlah nomor halaman
	$new_totale = $total_pos_detail; //Jumlah row item
	$modulus = $new_totale-40;
}

// Kassier Aantal
$query_kassier_2 = "SELECT no,sales_code from pos_client where id_number = '$pos_client_id'";
$fetch_kassier_2 = mysqli_query($dbconn, $query_kassier_2);
if (!$fetch_kassier_2) { error("QUERY_ERROR"); exit; }
$kassier_aantal = mysqli_result($fetch_kassier_2,0,0);
$sales_code = mysqli_result($fetch_kassier_2,0,1);

// Kassier naam
$query_kassier = "SELECT user_name FROM admin_user WHERE user_id = '$sales_code'";
$fetch_kassier = mysqli_query($dbconn, $query_kassier);
$kassier_naam = mysqli_result($fetch_kassier,0,0);
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
		counter-reset: newpage;
		}

	#pageke::after{
		counter-increment: pages;
	}

	#pageke::before {
		counter-increment: newpage;
		content: counter(newpage)"/";
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
			<div> No : ES<?php echo $kassier_aantal?>-<?php echo substr($transaction_code, 4)?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?php echo $test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
			<div> <?php echo date("d/m/Y H:i", strtotime($trx_date))?> </div>
		</div>
	</div>

	<center ><br/>
		<div> Feelbuy - Telp: 021-7566-363 </div>
		<div> NPWP : 21.078.015.1-411.000</div>
	</center><br/>
	<div style="float:left;">
		<div> Cashier : [<?php echo $kassier_aantal?>] - <?php echo $kassier_naam?> </div>
	</div>
	<div style="float: right;">
		<?php if($voids == 'leemte') { ?>
		<i> Void - </i> [Copy]
    <?php } else if($total_nett < 0) { ?>
    <i> Return - </i> [Copy]
		<?php } else { ?>
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

	<?php
	// Total all carts
	$query_total_pay = "SELECT count(uid) FROM pos_detail2
	WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysqli_query($dbconn, $query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysqli_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail2
	WHERE pos_clientID ='$pos_client_id' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysqli_query($dbconn, $query_pay);
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
		$uid = @mysqli_result($result_pay,$i,0);
		$detail = @mysqli_result($result_pay,$i,1);
		$detail_ex = explode("|", $detail);
		$detail_J_ex = explode("|", $detail_J);
		$datedetail = @mysqli_result($result_pay,$i,2);
		$temp = @mysqli_result($result_pay,$i,3);
		$qty_k = @mysqli_result($result_pay,$i,4);

		$pcode = $detail_ex[0];
		$barcode = $detail_ex[1];
		$price = $detail_ex[3];
		$disc_rate = $detail_ex[4];
		$gross = $detail_ex[5];
		$nett = $detail_ex[6];
		$vat = $detail_ex[8];
	    $subtotal = number_format($nett);

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode'";
	    $result = mysqli_query($dbconn, $query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname =  @mysqli_result($result,0,0);
	    $p_name = explode(" ", $pname);

	    ?>
		<tr>
			<td>
				<span><?php echo substr($pcode,0,12)?></span>
			</td>
			<td>
				<span><?php echo substr($p_name[0],0,7).' '.substr($p_name[1],0,7);?></span>
				<!--<span><?php echo substr($pname,0,20);?></span>-->
			</td>
			<td>
				<center><span><?php echo number_format($qty_k)?></span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo number_format($price)?></span></center>
			</td>
			<td>
				<center><span><?php echo $disc_rate?>%</span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo $subtotal?></span></center>
			</td>
		</tr>

	<?php
	}
	?>

	<?php if ($khusus == 1) { ?>
		<tr class="lyn" style="margin-top: 30%">
			<td colspan="2"><span><b><center>TOTAL</center></b></span></td>
			<td><span><b><center><?php echo number_format($total_item)?></center></b></span></td>
			<td><center><span class="formaat"><b><?php echo number_format($total_gross)?></b></span></center></td>
			<td>&nbsp;</td>
			<td colspan="3"><center><span class="formaat"><b><?php echo number_format($total_nett)?></b></span></center></td>
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
			<?php if($card_type == '6' OR $card_type == '9' OR $card_type == 'TK' OR $card_type == 'TD') { ?>
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($card_no,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') { ?>
			<tr>
				<td colspan="3">Kartu Debit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($debiet_kaart,-4);?></td>
			</tr>
			<tr>
				<td colspan="3">Kartu Kredit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($krediet_kaart,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else { ?>
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
			<?php } ?>
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
				<td class="formaat"><b><?php echo $nf_cash_amount?></b></td>
			</tr>
			<?	if ($card_type == '9' OR $card_type == 'TK') { // Krediet	?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_amount)?></b></td>
			</tr>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>
			<?php } else { // No Krediet dan Debiet ?>
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
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } ?>
		</table>
		</div>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>
	<?php } ?>

	</table>
	</center>

	<?php if ($khusus != 1) { ?>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>

	<?php } ?>

   </div>
	<!-- Sluiting div separator - Closing div separator -->
</div>

<?php  } else if($k == 1) { ?>

<!-- Sisa nya perhitungan -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : ES<?php echo $kassier_aantal?>-<?php echo substr($transaction_code, 4)?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?php echo $test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
			<div> <?php echo date("d/m/Y H:i", strtotime($trx_date))?> </div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail2
	WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysqli_query($dbconn, $query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysqli_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail2
	WHERE pos_clientID ='$pos_client_id' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysqli_query($dbconn, $query_pay);
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
		$uid_2 = @mysqli_result($result_pay,$i,0);
		$detail_2 = @mysqli_result($result_pay,$i,1);
		$detail_ex_2 = explode("|", $detail_2);
		$detail_J_ex_2 = explode("|", $detail_J);
		$datedetail_2 = @mysqli_result($result_pay,$i,2);
		$temp_2 = @mysqli_result($result_pay,$i,3);
		$qty_k_2 = @mysqli_result($result_pay,$i,4);

		$pcode_2 = $detail_ex_2[0];
		$barcode_2 = $detail_ex_2[1];
		$price_2 = $detail_ex_2[3];
		$disc_rate_2 = $detail_ex_2[4];
		$gross_2 = $detail_ex_2[5];
		$nett_2 = $detail_ex_2[6];
		$vat_2 = $detail_ex_2[8];
	    $subtotal_2 = number_format($nett_2);

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_2'";
	    $result = mysqli_query($dbconn, $query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_2 =  @mysqli_result($result,0,0);

	    ?>
		<tr>
			<td>
				<span><?php echo substr($pcode_2,0,12)?></span>
			</td>
			<td>
				<span><?php echo substr($p_name[0],0,7).' '.substr($p_name[1],0,7);?></span>
			</td>
			<td>
				<center><span><?php echo number_format($qty_k_2)?></span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo number_format($price_2)?></span></center>
			</td>
			<td>
				<center><span><?php echo $disc_rate_2?>%</span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo $subtotal_2?></span></center>
			</td>
		</tr>

	<?
	}
	?>

	<?php if ($khusus == '2') { ?>

		<tr class="lyn" style="margin-top: 30%">
			<td colspan="2"><span><b><center>TOTAL</center></b></span></td>
			<td><span><b><center><?php echo number_format($total_item)?></center></b></span></td>
			<td><center><span class="formaat"><b><?php echo number_format($total_gross)?></b></span></center></td>
			<td>&nbsp;</td>
			<td colspan="3"><center><span class="formaat"><b><?php echo number_format($total_nett);?></b></span></center></td>
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
			<?php if($card_type == '6' OR $card_type == '9') { ?>
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($card_no,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') { ?>
			<tr>
				<td colspan="3">Kartu Debit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($debiet_kaart,-4);?></td>
			</tr>
			<tr>
				<td colspan="3">Kartu Kredit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($krediet_kaart,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else { ?>
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
			<?php } ?>
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
				<td class="formaat"><b><?php echo $nf_cash_amount?></b></td>
			</tr>
			<?php if ($card_type == '9' OR $card_type == 'TK') { // Krediet ?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_amount)?></b></td>
			</tr>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>
			<?php } else { // No Krediet dan Debiet ?>
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
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } ?>
		</table>
		</div>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>

		<?php } ?>

		</table>
		</center>

		<?php if ($khusus != 2) { ?>

			<center>
			<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
				<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
				<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
			</div>
			</center>

		<?php 	} ?>

   </div>
	<!-- Sluiting div separator - Closing div separator -->
</div>

<?php  } else if($k == 2) { ?>

<!-- Sisa 3 perhitungan -->
<!-- /////////////////////////////////////////////////////////////////////////// -->

<div class="page-break" style="border: green solid 0px">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : ES<?php echo $kassier_aantal?>-<?php echo substr($transaction_code, 4)?> </div>
		</div>
		<div id="pageke" class="bok" style="float: left; margin-left: 20%"><?php echo $test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
			<div> <?php echo date("d/m/Y H:i", strtotime($trx_date))?> </div>
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
	$query_total_pay = "SELECT count(uid) FROM pos_detail2
	WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '9'";
	$result_total_pay = mysqli_query($dbconn, $query_total_pay);
	if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
	$totuid = @mysqli_result($result_total_pay,0,0);

	// Show all carts
	$query_pay = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail2
	WHERE pos_clientID ='$pos_client_id' AND temp = '9' AND transcode = '$transcode'";
	$result_pay = mysqli_query($dbconn, $query_pay);
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
	$angka_sekarang_3 = $angka_sekarang_3;

	// Looping for carts
	for ($i; $i <$totuid_K3; $i++) {
		$uid_3 = @mysqli_result($result_pay,$i,0);
		$detail_3 = @mysqli_result($result_pay,$i,1);
		$detail_ex_3 = explode("|", $detail_3);
		$detail_J_ex_3 = explode("|", $detail_J);
		$datedetail_3 = @mysqli_result($result_pay,$i,2);
		$temp_3 = @mysqli_result($result_pay,$i,3);
		$qty_k_3 = @mysqli_result($result_pay,$i,4);

		$pcode_3 = $detail_ex_3[0];
		$barcode_3 = $detail_ex_3[1];
		$price_3 = $detail_ex_3[3];
		$disc_rate_3 = $detail_ex_3[4];
		$gross_3 = $detail_ex_3[5];
		$nett_3 = $detail_ex_3[6];
		$vat_3 = $detail_ex_3[8];
	    $subtotal_3 = number_format($nett_3);

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_3'";
	    $result = mysqli_query($dbconn, $query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_3 =  @mysqli_result($result,0,0);
	    $p_name_3 = explode(" ", $pname_3);

	    ?>
		<tr>
			<td>
				<span><?php echo substr($pcode_3,0,12)?></span>
			</td>
			<td>
				<span><?php echo substr($p_name_3[0],0,7).' '.substr($p_name_3[1],0,7);?></span>
			</td>
			<td>
				<center><span><?php echo number_format($qty_k_3)?></span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo number_format($price_3)?></span></center>
			</td>
			<td>
				<center><span><?php echo $disc_rate_3?>%</span></center>
			</td>
			<td>
				<center><span class="formaat"><?php echo $subtotal_3?></span></center>
			</td>
		</tr>

	<?
	}

	if ($khusus == 3) {
	?>

		<tr class="lyn" style="margin-top: 30%">
			<td colspan="2"><span><b><center>TOTAL</center></b></span></td>
			<td><span><b><center><?php echo number_format($total_item)?></center></b></span></td>
			<td><center><span class="formaat"><b><?php echo number_format($total_gross)?></b></span></center></td>
			<td>&nbsp;</td>
			<td colspan="3"><center><span class="formaat"><b><?php echo number_format($total_nett);?></b></span></center></td>
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
			<?php if($card_type == '6' OR $card_type == '9') { ?>
			<tr>
				<td colspan="3">Nomor Kartu : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($card_no,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') { ?>
			<tr>
				<td colspan="3">Kartu Debit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($debiet_kaart,-4);?></td>
			</tr>
			<tr>
				<td colspan="3">Kartu Kredit : </td>
			</tr>
			<tr>
				<td colspan="3"><?php echo '****-****-****-'.substr($krediet_kaart,-4);?></td>
			</tr>
			<tr>
				<td><i>Harga sudah termasuk PPN</i></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php } else { ?>
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
			<?php } ?>
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
				<td class="formaat"><b><?php echo $nf_cash_amount?></b></td>
			</tr>
			<?php if ($card_type == '9' OR $card_type == 'TK') { // Krediet ?>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kartu</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_card_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($card_type == '6' OR $card_type == 'TD') {  // Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_card_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } else if ($krediet_kaart != '' AND $debiet_kaart != '') {  // Krediet & Debiet ?>
			<!-- Debiet  -->
			<tr>
				<td colspan="3">Debit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($debit_card_amount)?></b></td>
			</tr>
			<!-- Krediet  -->
			<tr>
				<td colspan="3">Kredit</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?php echo number_format($credit_card_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b>0</b></td>
			</tr>
			<?php } else { // No Krediet dan Debiet ?>
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
				<td class="formaat"><b><?php echo number_format($cash_remain)?></b></td>
			</tr>
			<?php } ?>
		</table>
		</div>

		<center>
		<div class="col-md-12" style="margin-top:5%; border: 0px solid blue; float: left; margin-left: 5%">
			<div style="font-size: 8pt"> Barang yang sudah di beli, tidak dapat ditukar atau di kembalikan </div>
			<div style="font-size: 8pt"> Terima kasih atas kunjungan nya</div>
		</div>
		</center>
   <?php } ?>

	</table>
	</center>

   </div>
	<!-- Sluiting div separator - Closing div separator -->
</div>

<?php } ?>

<?
}
?>
	</div>
</body>
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

start_transaction();
begin();
$query_fin = "INSERT INTO pos_detail_backup (sales_code,detail,datedetail,transcode,temp,qty,dump)
SELECT '$sales_code',detail,datedetail,transcode,temp,qty,'$detail_J' FROM pos_detail2 WHERE transcode = '$transcode'";
$fetch_fin = mysqli_query($dbconn, $query_fin);
if (!$fetch_fin) { rollback(); error("QUERY_ERROR"); }
commit();

start_transaction();
begin();
$query_del = "DELETE FROM pos_detail2 WHERE transcode = '$transcode'";
$fetch_del = mysqli_query($dbconn, $query_del);
if (!$fetch_del) { rollback(); error("QUERY_ERROR"); }
commit();

start_transaction();
begin();
$query_del2 = "DELETE FROM pos_total2 WHERE transcode = '$transcode' AND total IS NULL";
$fetch_del2 = mysqli_query($dbconn, $query_del2);
if (!$fetch_del2) { rollback(); error("QUERY_ERROR"); }
commit();

//-------------------------------------------------------------------------------------------------------------------
echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>");
}
?>
