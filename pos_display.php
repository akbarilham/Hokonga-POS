<?php

include "config/common.php";
include "config/dbconn.php";
if (!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

	$gross5 = $_POST['gross5'] ?? null;
	$nett5 = $_POST['nett5'] ?? null;
	$nettvat5 = $_POST['nettvat5'] ?? null;
	$vat5 = $_POST['vat5'] ?? null;
	$qty6 = $_POST['qty6'] ?? null;
	$d1 = $_POST['d1'] ?? null;
	$d2 = $_POST['d2'] ?? null;
	$d3 = $_POST['d3'] ?? null;
	$d4 = $_POST['d4'] ?? null;
	$d5 = $_POST['d5'] ?? null;
	$d6 = $_POST['d6'] ?? null;

	if($hold != '' ){
		$temp = "temp = '1' and transcode = '$hold'";
	} else {
		$temp = "temp = '0'";
	}
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$query_getclx = "SELECT id_number from pos_client where sales_code = '$login_id' AND hostname = '$hostname'";
	$result_getclx = mysqli_query($dbconn, $query_getclx);
	$id_number1x   = @mysqli_result($result_getclx, 0, 0);

	$query_psx = "SELECT count(uid) FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number1x'";
	$result_psx = mysqli_query($dbconn, $query_psx);
	if (!$result_psx) { error("QUERY_ERROR"); exit; }
	$total1x =  @mysqli_result($result_psx,0,0);

	//get matched data from skills table
	$query_posx = "SELECT uid,pos_clientID,detail,datedetail,transcode,temp,qty,package,org_pcode FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number1x'";
	$result_posx = mysqli_query($dbconn, $query_posx);
	if (!$result_posx) { error("QUERY_ERROR"); exit; }
	for ($i=0; $i < $total1x; $i++) {

		$uid5 			=  @mysqli_result($result_posx,$i,0);
		$pos_clientID5 	=  @mysqli_result($result_posx,$i,1);
		$detail5 		=  @mysqli_result($result_posx,$i,2);
		$datedetail5 	=  @mysqli_result($result_posx,$i,3);
		$transcode5 	=  @mysqli_result($result_posx,$i,4);
		$temp5 			=  @mysqli_result($result_posx,$i,5);
		$qty5 			=  @mysqli_result($result_posx,$i,6);
		$package2		=  @mysqli_result($result_pos,$i,7) ?? 0;
		$packcode3		=  @mysqli_result($result_pos,$i,8);

		$new_detail5 = explode('|',$detail5);
		$arrCount5 = count($new_detail5);
		// $query_getcatdis = "SELECT cat from item_masters Where org_pcode = '$new_detail5[0]'";
		// var_dump($query_getcatdis); die();
		// $result_getcatdis = mysqli_query($dbconn, $query_getcatdis);
		// $cat   = @mysqli_result($result_getcatdis, 0, 0);
		$cat = 1; //karena gak ditemukan kolomnya di DB
		$diskon = $dic / 100;
/*		if($package2 != ''){
		$pcount="SELECT sum(qty) FROM pos_detail2 where pos_clientID = '$id_number'  group by transcode" ;
		$fetch_pcount=mysql_query($pcount);
		$cuidp=mysqli_result($fetch_pcount,0,0);

			if($package2 == 1){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2'";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$dis1 = $codecp * ($sps*0.1);

			}else if($package2 == 2){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' ";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$dis2 = $codecp * ($sps*0.1);
			}else if($package2 == 3){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' ";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$dis3 = $codecp * ($sps*0.1);
			}else if($package2 == 4){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' ";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$dis4 = $codecp * ($sps*0.1);
			}else if($package2 == 5){
				$codecount="SELECT MIN(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' ";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$dis5 = $codecp * ($sps*0.1);
			}else if($package2 == 6){
				$codecount="SELECT sum(qty) FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' ";
				$fetch_codecount=mysql_query($codecount);
				$codecp	=mysqli_result($fetch_codecount,0,0);

				$query_getcatdis2 = "SELECT sum(price_sale) from item_masters_package Where package = '$package2'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$sps   = @mysqli_result($result_getcatdis2, 0, 0);

				$xpack = $sps/$package2;
				$deci = floor($codecp/3);

				$dis6 = $deci*3900;
			}else if($package2 == 7){
				$codecount="SELECT qty,org_pcode FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' AND org_pcode = '$packcode3' ";
				$fetch_codecount=mysql_query($codecount);
				$qtycps	=mysqli_result($fetch_codecount,0,0);
				$coda	=mysqli_result($fetch_codecount,0,1);

				$deci = floor($qtycps/6);

				$query_getcatdis2 = "SELECT org_pcode,price_sale from item_masters Where org_pcode = '$coda'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$op   = @mysqli_result($result_getcatdis2, 0, 0);
				$ps   = @mysqli_result($result_getcatdis2, 0, 1);

				if($op == 'AP_9019'){
					$d7 = $deci*6600;

				}else if($op == 'AP_9116'){
					$d7 = $deci*4200;
				}else if($op == 'AP_9216'){
					$d7 = $deci*6000;
				}
			}else if($package2 == 8){
				$codecount="SELECT qty,org_pcode FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package2' AND org_pcode = '$packcode3' ";
				$fetch_codecount=mysql_query($codecount);
				$qtycps	=mysqli_result($fetch_codecount,0,0);
				$coda	=mysqli_result($fetch_codecount,0,1);
				$deci = floor($qtycps/3);
				$query_getcatdis2 = "SELECT org_pcode,price_sale from item_masters Where org_pcode = '$coda'";
				$result_getcatdis2 = mysql_query($query_getcatdis2);
				$op   = @mysqli_result($result_getcatdis2, 0, 0);
				$ps   = @mysqli_result($result_getcatdis2, 0, 1);

				if($op == 'KC_163'){
					$d81 = $deci*6000;
				}else if($op == 'KC_162'){
					$d82 = $deci*6000;
				}else if($op == 'KC_152'){
					$d83 = $deci*7500;
				}else if($op == 'KC_151'){
					$d84 = $deci*8400;
				}else if($op == 'KC_158'){
					$d85 = $deci*5100;
				}else if($op == 'KC_160'){
					$d86 = $deci*6000;
				}else if($op == 'KC_159'){
					$d87 = $deci*6900;
				}else if($op == 'KC_164'){
					$d88 = $deci*7500;
				}
			}

		}*/

		for ($b=0; $b < $arrCount5 ; $b++){
			if($b == 3){
			}else if($b == 2){
			}else if($b == 4){
			}else if($b == 5){
				$gross5 +=$new_detail5[$b];
			}else if($b == 6){
				$nett5 +=$new_detail5[$b];
			}else if($b == 7){
				$nettvat5 +=$new_detail5[$b];
			}else if($b == 8){
				$vat5 +=$new_detail5[$b];
			}else{
			}
		$dic5 = $gross5 - $nett5;
		}
		$qty6 +=$qty5;
	}
	$dis7 = $d1+$d2+$d3;
	$dis8 = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8;
	$detail = implode('|',$detail2);
	$jml = ($net2-$dis1-$dis2-$dis3-$dis4-$dis5-$dis6-$dis7-$dis8);
	$jml15 = $jml*$diskon2;
	#$dic5 = $jml15+$dis1+$dis2+$dis3+$dis4+$dis5+$dis6+$dis7+$dis8;
	$jmlAll = $jml - $jml15;
	#$nett5 =$jmlAll+$nett3;
	$getpack = "SELECT org_pcode from item_masters_package WHERE package = '$package2'";
	$fetch_getpack = mysqli_query($dbconn, $getpack);
	$codepacks = mysqli_result($fetch_getpack,0,0);
	?>
	<div class="task-progress">
	<h1>PRODUCT CART LIST</h1>
	<p>
		<?php echo $login_id?>
	</p>
	</div>
	<div style='float:left;margin-left:15px;padding:0 20px;width:120px;'>
	Quantity
	<p style='font-size:20px;' id='totqty'>
		<?php echo $qty6?>
	</p>
	</div>
	<div style='float:left;padding:0 20px;width:120px;'>
	Normal
	<p style='font-size:20px;' id='gross'>
		<?php echo number_format($gross5)?>
	</p>
	</div>
	<div style='float:left;padding:0 20px;width:120px;'>
	Discount
	<p style='font-size:20px;' id='disc'>
		<?php echo '-'.number_format($dic5)?>
	</p>
	</div>
	<div style='float:right;margin-left:-20px;width:250px;'>
	Total
	<p id='price' style='font-size:50px; width:200px;'>
	<?php
	echo number_format($nett5);
	?>
	</p>
	</div>
	<?php
	}
?>
