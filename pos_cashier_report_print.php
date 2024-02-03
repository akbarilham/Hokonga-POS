<?php
/*
 Modified by : Cihuy Programmer;
 Version : 2.0
*/
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
include "admin.inc";

$kasir = $_GET['kasir'];
// -------------------Start Elements-------------------------------- //
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ip =  $_SERVER['REMOTE_ADDR'];
$trans = $_POST['trans'];
// -------------------End Elements--------------------------------- //

//TOTAL CASHIER REPORT PER PAYMENT TRANSACTIONS
if ($module_0509 == '1') {
	$query_count = "SELECT count(distinct sales_code) FROM pos_total2 WHERE sales_code !=  '' AND status = 'P'";
	$fetch_count = mysql_query($query_count);
	$count_name = mysql_result($fetch_count,0,0);
} else {
	$query_count = "SELECT count(distinct sales_code) FROM pos_total2 WHERE sales_code =  '$login_id'";
	$fetch_count = mysql_query($query_count);
	$count_name = mysql_result($fetch_count,0,0);
}

if ($kasir == $login_id) {

	// Closing Method (Payment and Void Transactions)
	$query_closing = "UPDATE pos_total2 SET closing = '1' WHERE sales_code = '$login_id'";
	$fetch_closing = mysql_query($query_closing);
	if(!$fetch_closing) { error("QUERY_ERROR"); }
/*
	// Closing only void
	$query_closing_V = "UPDATE pos_total2 SET closing = '1' WHERE sales_code = '$login_id' AND status = 'V'";
	$fetch_closing_V = mysql_query($query_closing_V);
	if(!$fetch_closing_V) { error("QUERY_ERROR"); }
*/
}

?>
<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
<style type="text/css">

table { border-collapse:collapse; }
.table1 { border-bottom: 1px solid #000; }

th,td { padding:0 10px 0 10px; font-size:small; }
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
<? for ($i=0; $i < $count_name; $i++) {

	// GET sales_code WITHOUT FILTERS
	if ($module_0509 == '1') {
		$query_name = "SELECT distinct sales_code FROM pos_total2 WHERE sales_code !=  ''";
		$fetch_name = mysql_query($query_name);
		if (!$fetch_name) {   error("QUERY_ERROR");exit; }
		$name = mysql_result($fetch_name,$i,0);
	} else {
		$query_name = "SELECT distinct sales_code FROM pos_total2 WHERE sales_code =  '$login_id'";
		$fetch_name = mysql_query($query_name);
		if (!$fetch_name) {   error("QUERY_ERROR");exit; }
		$name = mysql_result($fetch_name,$i,0);
	}

	// GET TRANSACTIONS PAYMENT (EXCLUDED VOID)
	$query 			= "SELECT sales_code, count(transaction_code) AS trans,
						sum(substring_index(substring_index(total,'|',1),'|',-1)) AS qty,
						sum(substring_index(substring_index(total,'|',2),'|',-1)) AS gross,
						sum(substring_index(substring_index(total,'|',3),'|',-1)) AS nett,
						sum(substring_index(substring_index(total,'|',6),'|',-1)) AS cash,
						sum(substring_index(substring_index(total,'|',7),'|',-1)) AS remain,
						sum(substring_index(substring_index(total,'|',8),'|',-1)) AS credit,
						sum(substring_index(substring_index(total,'|',9),'|',-1)) AS debit
					  FROM pos_total2 WHERE sales_code = '$name' AND status = 'P' GROUP BY sales_code";
	$fetch_total	=mysql_query($query);
    $user_id		=mysql_result($fetch_total,0,0);
	$trans			=mysql_result($fetch_total,0,1);
	$qty			=mysql_result($fetch_total,0,2);
	$gross			=mysql_result($fetch_total,0,3);
	#$nett			=mysql_result($fetch_total,0,4);
	$cash_amount	=mysql_result($fetch_total,0,5);
	$cash_remain	=mysql_result($fetch_total,0,6);
	$credit_amount	=mysql_result($fetch_total,0,7);
	$debit_amount	=mysql_result($fetch_total,0,8);
	$nett 			= $cash_amount-$cash_remain+$debit_amount+$credit_amount;

	$query_name_K = "SELECT user_name FROM admin_user WHERE user_id = '$name';";
	$fetch_name_K = mysql_query($query_name_K);
	if (!$fetch_name_K) {   error("QUERY_ERROR");exit; }
	$cashier_name_K = mysql_result($fetch_name_K,0,0);
?>
<html>
<head>
	<title>Cashier Report for Point of Sales</title>
</head>
<body style="width:105mm;height:148mm;max-width: 105mm; max-height: 148mm" >

<div class="page-break" style="border: red solid 0px">

	<div class="row" style="border: 0px solid red; margin-left: 0%;">
		<div style="float:left; border: 0px solid green">
			<div> Laporan Closing </div>
		</div>
		<div style="float: right; border: 0px solid blue; margin-right:0;">
			<div> <? echo date('d/m/Y H:i')?> </div>
		</div>
	</div>

	<center><br/>
		<div> Feelbuy - Telp: 021-7566-363 </div>
		<div> NPWP : 21.078.015.1-411.000</div>
	</center><br/>

	<div style="float:left;">
		<div> Cashier : <?=$cashier_name_K?> </div>
	</div>
	<div style="float: right;">
		<div style="float: right;"> [ REPORT ] </div>
	</div>
	<table border="0" id='table1' style="border-top: 1px solid #000; width:100%; max-width:105mm">
    <tr style='border-top: 1px solid #000; width:100%; margin-bottom:10px;'>
      <td>Transaksi</td>
      <th style="float: right;"><?=$trans?></th>
    </tr>
    <tr>
      <td>Item</td>
      <th style="float: right;"><?=$qty?></th>
    </tr>
			<td >Uang Tunai</td>
			<th style="float: right;"><?=number_format($cash_amount)?></th>
		</tr>
    <tr>
			<td>Uang Kembali</td>
			<th style="float: right;"><?=number_format($cash_remain)?></th>
		</tr>
		<tr>
			<td>Kartu Debit</td>
			<th style="float: right;"><?=number_format($debit_amount)?></th>
		</tr>
		<tr>
			<td>Kartu Kredit</td>
			<th style="float: right;"><?=number_format($credit_amount)?></th>
    </tr>
    <tr style='border-top: 1px solid #000; width:100%; margin-bottom:10px;'>
			<td>TOTAL GROSS</td>
			<th style="float: right;"><?=number_format($gross)?></th>
		</tr>
		<tr>
			<td>TOTAL NETT</td>
			<th style="float: right;"><?=number_format($nett)?></th>
		</tr>
		<tr>
			<td>TOTAL UANG (Tunai - Kembali)</td>
			<th style="float: right;"><?=number_format($cash_amount-$cash_remain)?></th>
		</tr>
	</table>




	</div>
</body>
</html>
<? } ?>
<? if ($module_0509 == '1') { ?>
<script type="text/javascript">
	window.print();
</script>
<? } ?>
<?
/*
	$query_pos_del  = "DELETE FROM pos_detail WHERE temp = '0'";
	$result_pos_del = mysql_query($query_pos_del);
	if (!$result_pos_del) {
	    error("QUERY_ERROR");
	    exit;
	}

	$query_pos_tol  = "DELETE FROM pos_total WHERE user_id IS NULL OR sesskey = '' OR total_item IS NULL";
	$result_pos_tol = mysql_query($query_pos_tol);
	if (!$result_pos_tol) {
	    error("QUERY_ERROR");
	    exit;
	}
*/
?>
<?
echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_master.php?trans=list'>");
?>

<? } ?>
