<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>#</th>
	<th>Nama Gudang</th>
	<th>Stok Masuk</th>
	<th>Stok Keluar</th>
	<th>Stok Selisih</th>
	<th>Gross IN</th>
	<th>Gross OUT</th>
	<th>Gross Selisih</th>
</tr>
</thead>
<tbody>
<?
$query_total = "SELECT count(distinct gudang_code) FROM shop_product_list_qty"; 
$fetch_total = mysql_query($query_total);
if(!$fetch_total){ error("QUERY_ERROR"); }
$total_uid = @mysql_result($fetch_total,0,0);

if ($total_uid > 9) {
	$totale_uid = 9;
} else {
	$totale_uid = $total_uid;
}

for($k=0;$k<$totale_uid;$k++){

	$query_detail = "SELECT * FROM ( SELECT a.gudang_code,SUM(a.stock) as STOK_MASUK,a.price_orgin FROM shop_product_list_qty a WHERE flag = 'in' GROUP BY gudang_code ) T1 LEFT JOIN ( SELECT b.gudang_code,SUM(b.stock) as STOK_KELUAR, b.price_orgin FROM shop_product_list_qty b WHERE flag = 'out' GROUP BY gudang_code ) T2 ON T1.gudang_code = T2.gudang_code";
	$fetch_detail = mysql_query($query_detail);
	if(!$fetch_detail){ error("QUERY_ERROR"); }
	$gudang_code = @mysql_result($fetch_detail,$k,0);
	$stok_masuk = @mysql_result($fetch_detail,$k,1);
	$gross_masuk = @mysql_result($fetch_detail,$k,2);
	$stok_keluar = @mysql_result($fetch_detail,$k,4);
	$gross_keluar = @mysql_result($fetch_detail,$k,5);
	$stok_sisa = $stok_masuk - $stok_keluar;
	$gross_selisih = $gross_masuk - $gross_keluar;

	$query_nama = "SELECT gudang_name FROM code_gudang WHERE gudang_code = '$gudang_code'"; 
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
