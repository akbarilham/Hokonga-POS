<?php

	include "config/common.inc";
	if(!$login_id OR $login_id == "" OR $login_level < "1") {
	  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
	} else {
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	include "config/dbconn.inc";
	include "config/text_main_{$lang}.inc";
	include "config/user_functions_{$lang}.inc";
	//header("Content-type: application/vnd-ms-excel");
	//header("Content-Disposition: attachment; filename=hasil.xls");
	?>
			
		    <link href="css/bootstrap.min.css" rel="stylesheet">
    		<link href="css/bootstrap-reset.css" rel="stylesheet">
	<?

			$query_getcatdis 	= "SELECT count(uid) from pos_total2 WHERE status = 'P' and total != ''";
			$result_getcatdis 	= mysql_query($query_getcatdis);
			$uid   				= @mysql_result($result_getcatdis, 0, 0);
			
			$query_getcatdis4 	= "SELECT transcode,dump,transaction_code,substring_index(substring_index(total,'|',1),'|',-1),substring_index(substring_index(total,'|',2),'|',-1),substring_index(substring_index(total,'|',3),'|',-1),sales_code,substring_index(substring_index(total,'|',6),'|',-1),substring_index(substring_index(total,'|',7),'|',-1),substring_index(substring_index(total,'|',9),'|',-1),substring_index(substring_index(total,'|',8),'|',-1),status     
			from pos_total2  WHERE status = 'P' and total != '' order by sales_code asc";
			$result_getcatdis4 	= mysql_query($query_getcatdis4);
			
			echo '<table border="1px" class="table">';
				echo '<thead>';
				echo	'<tr>';
				echo		'<th>TRANSCODE</th>';
				echo		'<th>ITEM CODE</th>';
				echo		'<th>QUANTITY</th>';
				echo		'<th>DISCOUNT</th>';
				echo		'<th>PRICE</th>';
				echo		'<th>GROSS</th>';
				echo		'<th>GROSS DIS 15%</th>';
				echo		'<th>PACKAGE DESC</th>';	
				echo		'<th>NETT FROM PAPER</th>';
				echo		'<th>CASH</th>';
				echo		'<th>REMAIN</th>';
				echo		'<th>DEBIT</th>';
				echo		'<th>CREDIT</th>';
				echo		'<th>PACKAGE DISC</th>';					
				echo	'</tr>';
				echo '</thead>';
			for($j=0;$j<$uid;$j++){
			$trans   	= @mysql_result($result_getcatdis4, $j, 0);
			$dumps   	= @mysql_result($result_getcatdis4, $j, 1);
			$transc   	= @mysql_result($result_getcatdis4, $j, 2);
			$qtyall   	= @mysql_result($result_getcatdis4, $j, 3);
			$grossall  	= @mysql_result($result_getcatdis4, $j, 4);
			$nettall  	= @mysql_result($result_getcatdis4, $j, 5);
			$scode 		= @mysql_result($result_getcatdis4, $j, 6);
			$cash 		= @mysql_result($result_getcatdis4, $j, 7);
			$remain		= @mysql_result($result_getcatdis4, $j, 8);
			$debit		= @mysql_result($result_getcatdis4, $j, 9);
			$credit		= @mysql_result($result_getcatdis4, $j, 10);
			$status		= @mysql_result($result_getcatdis4, $j, 11);
			


			if($dumps != NULL){
				$dump = $dumps;
			}else{
				$dump = 0;
			}

			$xpld 		= explode('|',$dump);
			
			$arrCount 	= count($xpld);
			$jml 		= $arrCount/3;
			//echo ($j+1).' ======= '.$trans.' | '.$jml.' Items ======= <br>';
			$l = 1;
			
			for($i=0;$i<$jml;$i++){
				$x = $i*3;
				$y = ($i*3)+1;
				$query_getcatdis1 	= "SELECT price_sale,cat from item_masters Where org_pcode = '$xpld[$x]'";
				$result_getcatdis1 	= mysql_query($query_getcatdis1);
				$price   			= @mysql_result($result_getcatdis1, 0, 0);
				$cats   			= @mysql_result($result_getcatdis1, 0, 1);
				
				$query_getcatdis2 	= "SELECT package,org_pcode from item_masters_package Where org_pcode = '$xpld[$x]'";
				$result_getcatdis2 	= mysql_query($query_getcatdis2);
				$package   			= @mysql_result($result_getcatdis2, 0, 0);
				$pcode   			= @mysql_result($result_getcatdis2, 0, 1);

				if($cats == 1){
					$cat 		= '15%';
					$disfif 	= ($price*$xpld[$y])-((($price*$xpld[$y]))*0.15);
					
				}else{
					$cat 		= 'NONE';
					$disfif 	= (($price*$xpld[$y]));
					 
				}

				if($package != ''){
					$pack 		= 'Paket '.$package;
					$dis10 		= ($disfif)*0.1;
				
				}else{
					$pack 		= '';
				}
				echo '<tr>';
				$detail 		= '<td>'.$xpld[$x].'</td><td>'.$xpld[$y].'</td><td>'.$cat.'</td><td>'.$price.'</td><td>'.$price*$xpld[$y].'</td><td>'.$disfif.'</td><td>'.$pack;
				
				echo '<td>'.$transc.'</td>'.$detail.'<br>';
				echo '</tr>';

			}

			$query_getcatdis5 	= "SELECT user_name from admin_user where user_id = '$scode'";
			$result_getcatdis5 	= mysql_query($query_getcatdis5);
			$name   			= @mysql_result($result_getcatdis5, 0, 0);

			if($status == 'V'){
				$color 	= 'background:RED';
				$void 	= ' [ VOID ]';
			}else{
				$color 	= 'background:#EEE';
				$void 	= '';
			}

			echo '
			<tr style="'.$color.'">
				
				<td>'.$name.''.$void.'</td>
				<td></td>
				<td>'.$qtyall.'</td>
				<td></td>
				<td></td>
				<td>'.$grossall.'</td>
				<td></td>
				<td></td>
				<td>'.$nettall.'</td>
				<td>'.$cash.'</td>
				<td>'.$remain.'</td>
				<td>'.$debit.'</td>
				<td>'.$credit.'</td>
				<td></td>
			</tr>';
			$counGross 		+= $grossall;
			$counNett 		+= $nettall;
			$counDebit 		+= $debit;
			$counCredit		+= $credit;
			$counCash		+= $cash;
			$counRemain		+= $remain;

			}
				
				echo '<tr style="background:Yellow">
					<td colspan="5">TOTAL</td>
					<td>'.$counGross.'</td>
					<td></td>
					<td></td>
					<td>'.$counNett.'</td>
					<td colspan="2">'.($counCash-$counRemain).'</td>
					<td>'.$counDebit.'</td>
					<td>'.$counCredit.'</td>
					<td></td>
				</tr>';
				
				echo '</table>';
	}		
?>