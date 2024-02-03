<script language="javascript" src="utilities.js"></script>
<link rel="stylesheet" href="css/jquery-ui-pos.css">
  <script src="js/jquery-1.10.2-pos.js"></script>
  <script src="js/jquery-ui-pos.js"></script>
<?php
/*
 Modified by : Cihuy Programmer;
 Version : 2.11
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

function begin(){
	mysql_query("BEGIN");
}

function commit(){
 	mysql_query("COMMIT");
}

function rollback(){
 	mysql_query("ROLLBACK");
}

// -------------------Get Elements--------------------------------- //
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$transcode = $_GET['transcode'];
$modulus = $_GET['modus'];

$total_item = $_GET['totqty'];
$total_nett = $_GET['total'];
$total_gross = $_GET['gross'];
$cash_amount = $_GET['cashpay'];
$card_type = $_POST['type'];
$cash_remain = $_GET['change'];
$credit_card = $_GET['cardcre'];
$debit_card = $_GET['carddeb'];
$hold = $_POST['hold'];
$detail_J = $_GET['detail'];
$pos_client_id = $_GET['lid'];
// --------------------------------------------------------------- //

// -----------------Cashier Number Function---------------------- //
$query_kassier = "SELECT no,sales_code from pos_client where id_number = '$pos_client_id'";
$fetch_kassier = mysql_query($query_kassier);
if (!$fetch_kassier) { error("QUERY_ERROR"); exit; }
$kassier_aantal = mysql_result($fetch_kassier,0,0);
$sales_code = mysql_result($fetch_kassier,0,1);

if ($kassier_aantal == ''){
	$kassier_aantal = '01';
}
// ------------------------------------------------------------ //


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
	$debit_card_amount = $_GET['debamo'];
}

if($credit_card == ''){
	$credit_card_amount = 0;
} else {
	$credit_card_amount = $_GET['creamo'];
}

if ($debit_card_amount != '' || $credit_card_amount != '' && $cash_amount == '') {
	$cash_remain2 = 0;
}

// Remain Funksie
$kontant_bly = $cash_amount + $debit_card_amount + $credit_card_amount;
$cash_remain2 = $kontant_bly - $total_nett;

$tanggal = date('Y-m-d H:i');

// Kassier naam
$query_kassier = "SELECT user_name FROM admin_user WHERE user_id = '$sales_code'";
$fetch_kassier = mysql_query($query_kassier);
$kassier_naam = mysql_result($fetch_kassier,0,0);
// ---------------------------------------------------- //

	// Condition transaction code without AS
	$query_ES = "SELECT uid from pos_total2";
	$fetch_ES = mysql_query($query_ES);
	if (!$fetch_ES) { error("QUERY_ERROR"); exit; }
	$old_transaction_code = mysql_result($fetch_ES,0,0);

	// CREATE TRANSACTION CODE ENAAA
	if ($old_transaction_code == '') {

		// Transaction code begin
		$query_trans0 = "SELECT CONCAT ('ES$kassier_aantal' ,SUBSTR( DATE_FORMAT(NOW(), '%Y%m'), 3, 10 ),'000', + 1 ) FROM pos_detail2";
		$fetch_trans0 = mysql_query($query_trans0);
		if (!$fetch_trans0) { error("QUERY_ERROR"); exit; }
		$new_transaction_code = mysql_result($fetch_trans0,0,0);

		if ($hold != '') {

			// INSERT invoice into database -- Booking transaction_code
			start_transaction();
			begin();
			$query_book = mysql_query("INSERT INTO pos_total2 (transaction_code,sales_code,transcode) VALUES ('$new_transaction_code','$sales_code','$transcode')",$dbconn);
			if (!$query_book) { rollback();	error("QUERY_ERROR");	exit;	}
      commit();

		} else {

			// INSERT invoice into database -- Booking transaction_code
			start_transaction();
			begin();
			$query_book = mysql_query("INSERT INTO pos_total2 (transaction_code,sales_code,transcode) VALUES ('$new_transaction_code','$sales_code','$transcode')",$dbconn);
			if (!$query_book) { rollback();	error("QUERY_ERROR");	exit;	}
			commit();

		}


	} else if ($old_transaction_code != '') {

		// Transaction code nextval
		$query_trans = "SELECT CONCAT ('ES', ifnull(max(right(transaction_code, 10)), 3) + 1 ) from pos_total2 where transaction_code like 'ES%'";
		$result_trans = mysql_query($query_trans);
		if (!$result_trans) { error("QUERY_ERROR"); exit; }
		$new_transaction_code = mysql_result($result_trans,0,0);

		if ($hold != '') {

			// INSERT invoice into database -- Booking transaction_code
			start_transaction();
			begin();
			$query_book = mysql_query("INSERT INTO pos_total2 (transaction_code,sales_code,transcode) VALUES ('$new_transaction_code','$sales_code','$transcode')",$dbconn);
			if (!$query_book) { rollback();	error("QUERY_ERROR");	exit;	}
			commit();

		} else {

			// INSERT invoice into database -- Booking transaction_code
			start_transaction();
			begin();
			$query_book = mysql_query("INSERT INTO pos_total2 (transaction_code,sales_code,transcode) VALUES ('$new_transaction_code','$sales_code','$transcode')",$dbconn);
			if (!$query_book) { rollback();	error("QUERY_ERROR");	exit;	}
			commit();

		}

	}

/*
	// Condition transaction code with ES
	$query_trans1 = "SELECT MAX(transaction_code) from pos_total2 where sales_code = '$login_id'";
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

<?
// Total Page
$test = $_GET['teste']; // Jumlah nomor halaman
$new_totale = $_GET['totale']; //Jumlah row item
$khusus = $_GET['khusus']; // Khusus halaman awal
$totupage = @mysql_result($result_page,0,0); //Jumlah kertas halaman

for ($k=0; $k<$test; $k++) {
	if ($k == 0 OR $khusus == 1) {
?>
<div class="page-break" style="border: red solid 0px">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : ES<?=$kassier_aantal?>-<?=substr($new_transaction_code, 4)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
			<div> <? echo date('d/m/Y H:i')?> </div>
		</div>
	</div>

	<center><br/>
		<div> Feelbuy - Telp: 021-7566-363 </div>
		<div> NPWP : 21.078.015.1-411.000</div>
	</center><br/>
	<div style="float:left;">
		<div> Cashier : [<?=$kassier_aantal?>] - <?=$kassier_naam?> </div>
	</div>
	<div style="float: right;">
    <?php if($total_nett < 0 ) {?>
      <div style="float: right;"> Return - [Customer] </div>
    <?php } else { ?>
		<div style="float: right;"> [Customer] </div>
    <?php } ?>
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
	if ($hold != '') {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,qty from pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	} else {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '0'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,temp,qty,package FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '0' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	}

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
		$detail_J_ex = explode("|", $detail_J);
		$datedetail = @mysql_result($result_pay,$i,2);
		$temp = @mysql_result($result_pay,$i,3);
		$qty_k = @mysql_result($result_pay,$i,4);
		$package = @mysql_result($result_pay,$i,5);

		$pcode = $detail_ex[0];
		$barcode = $detail_ex[1];
		$price = $detail_ex[3];
		$disc_rate = $detail_ex[4];
		$gross = $detail_ex[5];
		$nett = $detail_ex[6];
		$netvat = $detail_ex[7];
		$vat = $detail_ex[8];
		$total_nettax += $netvat;
		$total_vat += $vat;
		$subtotal = number_format($nett);

		//--------------- Item master attributes -------------------------- //

	    $query = "SELECT pname,dc_rate,dc_rate_WH,stok_awal,stok_gudang FROM item_masters WHERE org_pcode = '$pcode'";
	    $result = mysql_query($query);
	    if (!$result) { error("QUERY_ERROR"); exit; }
	    $pname =  @mysql_result($result,0,0);
	    	$p_name = explode(" ", $pname);
	    $dc_rate = @mysql_result($result,0,1);
	    $dc_rate_WH = @mysql_result($result,0,2);
	    $stok_awal = @mysql_result($result,0,3);
	    $stok_gudang = @mysql_result($result,0,4);
/*
	    if ($stok_awal > '0') {

		    if ($hold != '') {

				// Update item master
				$query_item = "	UPDATE item_masters
								SET stok_awal = stok_awal - ( SELECT qty FROM pos_detail
								WHERE org_pcode =  '$pcode' AND transcode = '$hold')
								WHERE org_pcode = '$pcode'";
				$result_item = mysql_query($query_item);
				if (!$result_item) {   error("QUERY_ERROR");   exit; }

			} else {

				// Update item master
				$query_item = "	UPDATE item_masters
								SET stok_awal = stok_awal - ( SELECT qty FROM pos_detail
								WHERE org_pcode =  '$pcode' AND transcode = '$transcode')
								WHERE org_pcode = '$pcode'";
				$result_item = mysql_query($query_item);
				if (!$result_item) {   error("QUERY_ERROR");   exit; }

			}

		}  else if ($stok_awal == '0' AND $stok_gudang > '0')  {

		    if ($hold != '') {

				// Update item master
				$query_item = "	UPDATE item_masters
								SET stok_gudang = stok_gudang - ( SELECT qty FROM pos_detail
								WHERE org_pcode =  '$pcode' AND transcode = '$hold')
								WHERE org_pcode = '$pcode'";
				$result_item = mysql_query($query_item);
				if (!$result_item) {   error("QUERY_ERROR");   exit; }

			} else {

				// Update item master
				$query_item = "	UPDATE item_masters
								SET stok_gudang = stok_gudang - ( SELECT qty FROM pos_detail
								WHERE org_pcode =  '$pcode' AND transcode = '$transcode')
								WHERE org_pcode = '$pcode'";
				$result_item = mysql_query($query_item);
				if (!$result_item) {   error("QUERY_ERROR");   exit; }

			}

		}
*/
		//--------------- Item master attributes -------------------------- //

	    ?>
		<tr>
			<td>
				<span><?=substr($pcode,0,12)?></span>
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
				<td class="formaat"><b><?=number_format($credit_card_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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
<div class="page-break" style="border: blue solid 0px">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> No : ES<?=$kassier_aantal?>-<?=substr($new_transaction_code, 4)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
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

	if ($hold != '') {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,qty from pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	} else {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '0'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '0' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	}

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
		$detail_J_ex_2 = explode("|", $detail_J);
		$datedetail_2 = @mysql_result($result_pay,$i,2);
		$temp_2 = @mysql_result($result_pay,$i,3);
		$qty_k_2 = @mysql_result($result_pay,$i,4);

		$pcode_2 = $detail_ex_2[0];
		$barcode_2 = $detail_ex_2[1];
		$price_2 = $detail_ex_2[3];
		$disc_rate_2 = $detail_ex_2[4];
		$gross_2 = $detail_ex_2[5];
		$nett_2 = $detail_ex_2[6];
		$netvat_2 = $detail_ex_2[7];
		$vat_2 = $detail_ex_2[8];
		$total_nettax += $netvat_2;
		$total_vat += $vat_2;
		$subtotal_2 = number_format($nett_2);

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_2'";
	    $result = mysql_query($query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_2 =  @mysql_result($result,0,0);
	    $p_name_2 = explode(" ", $pname_2);
	    ?>
		<tr>
			<td>
				<span><?=substr($pcode_2,0,12)?></span>
			</td>
			<td>
				<span><? echo substr($p_name_2[0],0,7).' '.substr($p_name_2[1],0,7);?></span>
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
				<td class="formaat"><b><?=number_format($credit_card_amount)?></b></td>
			</tr>
			<!-- Bly - Remains -->
			<tr>
				<td colspan="3">Kembali</td>
				<td>&nbsp;:&nbsp;</td>
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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
			<div> No : ES<?=$kassier_aantal?>-<?=substr($new_transaction_code, 4)?> </div>
		</div>
		<div id="pagek" class="box" style="float: left; margin-left: 20%"><?=$test?></div>
		<div style="float: left; border: 0px solid blue; margin-left: 20%">
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

	if ($hold != '') {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,qty from pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '1' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	} else {

		// Total all carts
		$query_total_pay = "SELECT count(uid) FROM pos_detail2
		WHERE pos_clientID = '$pos_client_id' AND transcode = '$transcode' AND temp = '0'";
		$result_total_pay = mysql_query($query_total_pay);
		if (!$result_total_pay) {   error("QUERY_ERROR");   exit; }
		$totuid = @mysql_result($result_total_pay,0,0);

		// Show all carts
		$query_pay = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail2
		WHERE pos_clientID ='$pos_client_id' AND temp = '0' AND transcode = '$transcode'";
		$result_pay = mysql_query($query_pay);
		if (!$result_pay) {   error("QUERY_ERROR");   exit; }

	}


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
		$detail_J_ex_3 = explode("|", $detail_J);
		$datedetail_3 = @mysql_result($result_pay,$i,2);
		$temp_3 = @mysql_result($result_pay,$i,3);
		$qty_k_3 = @mysql_result($result_pay,$i,4);

		$pcode_3 = $detail_ex_3[0];
		$barcode_3 = $detail_ex_3[1];
		$price_3 = $detail_ex_3[3];
		$disc_rate_3 = $detail_ex_3[4];
		$gross_3 = $detail_ex_3[5];
		$nett_3 = $detail_ex_3[6];
		$netvat_3 = $detail_ex_3[7];
		$vat_3 = $detail_ex_3[8];
		$total_nettax += $netvat_3;
		$total_vat += $vat_3;
	    $subtotal_3 = number_format($nett_3);

	    $query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode_3'";
	    $result = mysql_query($query);
	    if (!$result) {   error("QUERY_ERROR");   exit; }
	    $pname_3 =  @mysql_result($result,0,0);
	    $p_name_3 = explode(" ", $pname_3);

	    ?>
		<tr>
			<td>
				<span><?=substr($pcode_3,0,12)?></span>
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
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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
				<td class="formaat"><b><?=number_format($cash_remain2)?></b></td>
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

<? } ?>

	</div>
</body>
</html>
<script type="text/javascript">
// $('html').bind('keypress', function(event)
// {
//    if(event.keyCode == 13)
//    {
//       return false;
//    }
// });
$(document).keypress(
  function(event){
   if (event.which == '13') {
      event.preventDefault();
    }
});
  window.print();
</script>
<?
}
	$tanggal = date('Y-m-d H:i');
	$payments = $total_item.'|'.$total_gross.'|'.$total_nett.'|'.$total_nettax.'|'.$total_vat.'|'.$cash_amount.'|'.$cash_remain2.'|'.$credit_card_amount.'|'.$debit_card_amount.'|'.$credit_card.'|'.$debit_card.'|'.$card_type;

	/*
	$credit_card_exp = explode("-", $credit_card);
	$credit_card_md1 = base64_encode($credit_card_exp[0].$credit_card_exp[1]);
	$credit_card_md2 = base64_encode($credit_card_exp[2].$credit_card_exp[3]);
	$credit_card_final = base64_encode($credit_card_md1.$credit_card_md2);

	$debit_card_exp = explode("-", $debit_card);
	$debit_card_md1 = base64_encode($debit_card_exp[0].$debit_card_exp[1]);
	$debut_card_md2 = base64_encode($debit_card_exp[2].$debit_card_exp[3]);
	$debit_card_final = base64_encode($debit_card_md1.$debit_card_md2);
	*/

	if ($hold != '') {

		// UPDATE transaction code and TEMP ( BEGIN )
		start_transaction();
		begin();
		$query_trans_upd = "UPDATE pos_detail2 SET temp = '9' where transcode = '$hold' AND temp = '1'";
		$fetch_trans_upd = mysql_query($query_trans_upd);
		if (!$fetch_trans_upd) { rollback(); error("QUERY_ERROR"); exit; }
		commit();

		// Get Booking transaction code
		$query_bespreking = "SELECT transaction_code FROM pos_total2 where transcode = '$transcode'";
		$fetch_bespreking = mysql_query($query_bespreking);
		if (!$fetch_bespreking) { error("QUERY_ERROR"); exit; }
		$bespreking_kode = mysql_result($fetch_bespreking,0,0);

		// Finishing
		start_transaction();
		begin();
		$query_total = mysql_query("UPDATE pos_total2 SET trx_date = '$tanggal', total = '$payments', status = 'P', dump = '$detail_J' WHERE transaction_code = '$bespreking_kode'",$dbconn);
		if (!$query_total) { rollback(); error("QUERY_ERROR"); exit; }
		commit();


	} else {

		// UPDATE transaction code and TEMP ( BEGIN )
		start_transaction();
		begin();
		$query_trans_upd = "UPDATE pos_detail2 SET temp = '9' where transcode = '$transcode' AND temp = '0'";
		$fetch_trans_upd = mysql_query($query_trans_upd);
		if (!$fetch_trans_upd) { rollback(); error("QUERY_ERROR"); exit; }
		commit();

		// Get Booking transaction code
		$query_bespreking = "SELECT transaction_code FROM pos_total2 where transcode = '$transcode'";
		$fetch_bespreking = mysql_query($query_bespreking);
		if (!$fetch_bespreking) { error("QUERY_ERROR"); exit; }
		$bespreking_kode = mysql_result($fetch_bespreking,0,0);

		// Finishing
		start_transaction();
		begin();
		$query_total = mysql_query("UPDATE pos_total2 SET trx_date = '$tanggal', total = '$payments', status = 'P', dump = '$detail_J' WHERE transaction_code = '$bespreking_kode'",$dbconn);
		if (!$query_total) { rollback(); error("QUERY_ERROR"); exit; }
		commit();

	}
////--------------------------------------------------------------------
echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_pay_copy.php?trans=$transcode&besprek=$bespreking_kode&detail=$detail_J&lid=$pos_client_id'>");

}
?>
