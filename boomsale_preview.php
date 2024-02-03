<?
include "config/common.inc";
include "config/dbconn.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>

<table class="table table1"  id="delTable" >
	<style>
		.strikeout {
		  font-size: 1.5em;
		  line-height: 1em;
		  position: relative;
		}
		
		.strikeout::after {
		  border-bottom: 0.125em solid red;
		  content: "";
		  left: 0;
		  margin-top: calc(0.125em / 2 * -1);
		  position: absolute;
		  right: 0;
		  top: 50%;
		  transform: rotate(-8deg);
		}
		.harga {
		  font-size: 4em;
		  line-height: 1em;
		  color:red;
		  -webkit-print-color-adjust:exact;
		  text-align:middle;
		}
		@media print{
			.harga{
		  -webkit-print-color-adjust:exact;
			}
		}
		.img{
			width:90px;
			height:90px;
		}
	</style>
<?php


$query_ps = "SELECT count(uid) FROM boomsale where temp = '0' AND sales_code = '$login_id' AND hostname = '$hostname'";
$result_ps = mysql_query($query_ps);
 if (!$result_ps) {   error("QUERY_ERROR");   exit; } 
$total =  @mysql_result($result_ps,0,0);

$query_pos = "SELECT org_pcode,transcode,price,qty,nett,gross,vat,disc_rate,barcode,uid,temp FROM boomsale where temp = '0' AND sales_code = '$login_id' AND hostname = '$hostname' order by date desc";
$result_pos = mysql_query($query_pos);
 if (!$result_pos) {   error("QUERY_ERROR");   exit; } 

for ($i=0; $i < $total; $i++) { 

$pcode =  @mysql_result($result_pos,$i,0);
$transcode1 =  @mysql_result($result_pos,$i,1);
$price =  @mysql_result($result_pos,$i,2);
$qty =  @mysql_result($result_pos,$i,3);
$nett =  @mysql_result($result_pos,$i,4);
$gross =  @mysql_result($result_pos,$i,5);
$vat =  @mysql_result($result_pos,$i,6);
$disc =  @mysql_result($result_pos,$i,7);
$barcode =  @mysql_result($result_pos,$i,8);
$uid =  @mysql_result($result_pos,$i,9);
$status =  @mysql_result($result_pos,$i,10);

$query = "SELECT pname FROM item_masters WHERE org_pcode = '$pcode'";
$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }
$pname =  @mysql_result($result,0,0);

?>
<tr id='<?=$uid?>'>
<?
	$file = 'img_pos/'.$pcode.'.jpg'; // 'images/'.$file (physical path)

	if (file_exists($file)) {
		$gambar = 'img_pos/'.$pcode.'.jpg';
	} else {
		$gambar = 'img_pos/feelbuy.jpg';
	}
?>
<td><img class="img" style='width:90px;height:90px;' src="<?=$gambar?>" alt=""/></td>

<td><h4 style='margin-bottom:-14px;'><?=$pcode?></h4></br><h4>Rp <span class="strikeout"><?=number_format($price);?></span></h4></td>
<td><span class='harga'><?=number_format($disc)?>%</span></td> 
<td><span class='harga'>Rp <?=number_format($nett)?></span></td> 



</tr>
<?}?>
</table>
<?}?>
