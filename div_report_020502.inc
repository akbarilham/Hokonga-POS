<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>#</th>
    <th>Nama PT</th>
	<th>Nama Toko</th>
	<th>Dari Gudang</th>
	<th>Stok Masuk</th>
	<th>Stok Keluar</th>
	<th>Sisa Stok</th>
	<th>Gross</th>
	<th>Nett</th>
</tr>
</thead>
<tbody>
<?
$keyA = $_GET['keyA'];
if ($keyA == '') {
	$enaa = " ";
} else {
	$enaa = "AND branch_code2 = '$keyA'";	
}

$now_yearmonth = date("Ym");

$p_year = $_GET['p_year'];
$p_month = $_GET['p_month'];
$p_yearmonth = $p_year.$p_month;
$p_yearmonth2 = $p_year.$p_month;

if($p_yearmonth == $now_yearmonth) {
	$dari = "shop_product_list_qty";
} else if ($p_yearmonth != $now_yearmonth) {
	$dari2 = "shop_product_list_qty_".$p_yearmonth;
	$query = "select 1 from $dari2 LIMIT 1";
	$val = mysql_query($query);
	if($val != ''){
		$dari = $dari2;
	} else {
		$dari = "shop_product_list_qty";
	}
}
if ($p_yearmonth2 == '') {
	$YM = "";
} else {
	$YM = "AND date LIKE '$p_yearmonth2%'";
}

$query_c = "SELECT COUNT(uid) FROM $dari WHERE flag = 'out' AND do_num != '' $enaa $YM";
$fetch_c = mysql_query($query_c);
if(!$fetch_c){ error("QUERY_ERROR"); }
$count_rows = @mysql_result($fetch_c,0,0);

for($k=0;$k<$count_rows;$k++){

	$query = "SELECT branch_code, gudang_code, shop_code, stock, stock_loss, branch_code2, gudang_code2, shop_code2
	FROM $dari WHERE flag = 'out' AND do_num != '' $enaa $YM ORDER BY branch_code2,shop_code2 ASC";
	$fetch = mysql_query($query);
	if(!$fetch){ error("QUERY_ERROR"); }
	$branch_code = @mysql_result($fetch,$k,0);
	$gudang_code = @mysql_result($fetch,$k,1);
	$shop_code = @mysql_result($fetch,$k,2);
	$stock = @mysql_result($fetch,$k,3);
	$stock_loss = @mysql_result($fetch,$k,4);
	$stock_now = $stock - $stock_loss;
	$branch_code2 = @mysql_result($fetch,$k,5);
	$gudang_code2 = @mysql_result($fetch,$k,6);
	$shop_code2 = @mysql_result($fetch,$k,7);

	if ($branch_code2 == '') {

		$query_nama = "SELECT branch_name FROM client_branch WHERE branch_code = '$branch_code'"; 
		$fetch_nama = mysql_query($query_nama);
		if(!$fetch_nama){ error("QUERY_ERROR"); }
		$naam_PT = @mysql_result($fetch_nama,0,0);		

	} else {

		$query_nama = "SELECT branch_name FROM client_branch WHERE branch_code = '$branch_code2'"; 
		$fetch_nama = mysql_query($query_nama);
		if(!$fetch_nama){ error("QUERY_ERROR"); }
		$naam_PT = @mysql_result($fetch_nama,0,0);		

	}

	if ($shop_code2 == '') {

		$query_toko = "SELECT shop_name FROM client_shop WHERE shop_code = '$shop_code'"; 
		$fetch_toko = mysql_query($query_toko);
		if(!$fetch_toko){ error("QUERY_ERROR"); }
		$naam_toko = @mysql_result($fetch_toko,0,0);		

	} else {

		$query_toko = "SELECT shop_name FROM client_shop WHERE shop_code = '$shop_code2'"; 
		$fetch_toko = mysql_query($query_toko);
		if(!$fetch_toko){ error("QUERY_ERROR"); }
		$naam_toko = @mysql_result($fetch_toko,0,0);		

	}

	if ($gudang_code2 == '') {

		$query_gudang = "SELECT gudang_name FROM code_gudang WHERE gudang_code = '$gudang_code'"; 
		$fetch_gudang = mysql_query($query_gudang);
		if(!$fetch_gudang){ error("QUERY_ERROR"); }
		$naam_gudang = @mysql_result($fetch_gudang,0,0);		

	} else {

		$query_gudang = "SELECT gudang_name FROM code_gudang WHERE gudang_code = '$gudang_code2'"; 
		$fetch_gudang = mysql_query($query_gudang);
		if(!$fetch_gudang){ error("QUERY_ERROR"); }
		$naam_gudang = @mysql_result($fetch_gudang,0,0);		

	}

	$ki = $k + 1;	
?>
<tr>
	<td><?=$ki?></td>
	<td><?=$naam_PT?></td>
	<? if($stock_loss == 0){ ?>
		<td><?=$naam_toko?></td>	
	<? } else { ?>
		<td bgcolor="#F7F700"><? echo $naam_toko.' ( -'.$stock_loss.')'?></td>	
	<? } ?>
	<td><?=$naam_gudang?></td>
	<td><?=$stock_now?></td>
	<td>-</td>
	<td>-</td>
	<td>-</td>
	<td>-</td>	
</tr>
<? } ?>
</tbody>
</table>
</section>
