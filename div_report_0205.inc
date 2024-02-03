<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>#</th>
	<th>Nama PT</th>
	<th>Masuk</th>
	<th>Keluar</th>
	<th>Return</th>	
	<th>Stok Akhir</th>
	<th>Inventory</th>
	<th>Selisih</th>
</tr>
</thead>
<tbody>
<?
$keyA = $_GET['keyA'];
if ($keyA == '') {
	$enaa = " ";
} else {
	$enaa = "AND branch_code = '$keyA'";	
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
	$val = mysql_query('select 1 from $dari2 LIMIT 1');
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


$query_total = "SELECT count(distinct branch_code) FROM $dari WHERE 1 $enaa $YM"; 
$fetch_total = mysql_query($query_total);
if(!$fetch_total){ error("QUERY_ERROR"); }
$total_uid = @mysql_result($fetch_total,0,0);

if ($total_uid > 9) {
	$totale_uid = 9;
} else {
	$totale_uid = $total_uid;
}

for($k=0;$k<$totale_uid;$k++){

	$query_detail = "SELECT * FROM ( SELECT a.branch_code,SUM(a.stock) as STOK_MASUK,a.price_orgin FROM $dari a WHERE flag = 'in' $enaa $YM GROUP BY branch_code ) T1 LEFT JOIN ( SELECT b.branch_code,SUM(b.stock) as STOK_KELUAR, b.price_orgin FROM $dari b WHERE flag = 'out' GROUP BY branch_code ) T2 ON T1.branch_code = T2.branch_code";
	$fetch_detail = mysql_query($query_detail);
	if(!$fetch_detail){ error("QUERY_ERROR"); }
	$branch_code = @mysql_result($fetch_detail,$k,0);
	$stok_masuk = @mysql_result($fetch_detail,$k,1);
	$gross_masuk = @mysql_result($fetch_detail,$k,2);
	$stok_keluar = @mysql_result($fetch_detail,$k,4);
	$gross_keluar = @mysql_result($fetch_detail,$k,5);
	$stok_sisa = $stok_masuk - $stok_keluar;
	$gross_selisih = $gross_masuk - $gross_keluar;

	$query_nama = "SELECT branch_name FROM client_branch WHERE branch_code = '$branch_code'"; 
	$fetch_nama = mysql_query($query_nama);
	if(!$fetch_nama){ error("QUERY_ERROR"); }
	$naam_PT = @mysql_result($fetch_nama,0,0);		

	$ki = $k + 1;
?>
<tr>
	<td><?=$ki?></td>
	<td><?=$naam_PT?></td>	
	<td><?=number_format($stok_masuk)?></td>
	<td><?=number_format($stok_keluar)?></td>
	<td><?=number_format($stok_sisa)?></td>
	<td><?=number_format($gross_masuk)?></td>
	<td><?=number_format($gross_keluar)?></td>
	<td><?=number_format($gross_selisih)?></td>
</tr>
<?
}
?>
</tbody>
</table>
</section>
