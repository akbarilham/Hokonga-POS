<?
// if($now_biz_type == "9") {
	$total_AC = "5";
// } else {
// 	$total_AC = "2";
// }


$query_tsum1 = "SELECT sum(amount) FROM finance 
    WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' AND f_class = 'in' AND currency = '$now_currency1'";
$result_tsum1 = mysql_query($query_tsum1);
if (!$result_tsum1) { error("QUERY_ERROR"); exit; }

$sum_pay_tamount1 = @mysql_result($result_tsum1,0,0);
$sum_pay_tamount1_K = number_format($sum_pay_tamount1);
		
$query_tsum2 = "SELECT sum(amount) FROM finance 
    WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' AND f_class = 'in' AND currency = '$now_currency2'";
$result_tsum2 = mysql_query($query_tsum2);
if (!$result_tsum2) { error("QUERY_ERROR"); exit; }

$sum_pay_tamount2 = @mysql_result($result_tsum2,0,0);
$sum_pay_tamount2_K = number_format($sum_pay_tamount2);
		
		
		echo ("
		
		<section id='unseen'>
		<table class='table table-bordered table-striped table-condensed'>
        <thead>
        <tr>
            <th>Category</th>
			<th>$now_currency1</th>
			<th>$now_currency2</th>
        </tr>
        </thead>
		
		
        <tbody>");
		
		
		$query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'in' ORDER BY catg ASC";
		$result_A = mysql_query($query_A);
		if (!$result_A) {   error("QUERY_ERROR");   exit; }

		for($a = 0; $a < $total_AC; $a++) {
			$fA_uid = mysql_result($result_A,$a,0);
			$fA_class = mysql_result($result_A,$a,1);
			$fA_catg = mysql_result($result_A,$a,2);
   
			// if($now_biz_type == "9") {
				$fA_catg_txt = "txt_sys_account_ch05_"."$fA_catg";
			// } else {
			// 	$fA_catg_txt = "txt_sys_account_05_"."$fA_catg";
			// }
			
			
			$query_sum1 = "SELECT sum(amount) FROM finance 
					WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' 
					AND f_class = 'in' AND f_catg = '$fA_catg' AND currency = '$now_currency1'";
			$result_sum1 = mysql_query($query_sum1);
			if (!$result_sum1) { error("QUERY_ERROR"); exit; }

			$sum_pay_amount1 = @mysql_result($result_sum1,0,0);
			$sum_pay_amount1_K = number_format($sum_pay_amount1);
			
			$query_sum2 = "SELECT sum(amount) FROM finance 
					WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' 
					AND f_class = 'in' AND f_catg = '$fA_catg' AND currency = '$now_currency2'";
			$result_sum2 = mysql_query($query_sum2);
			if (!$result_sum2) { error("QUERY_ERROR"); exit; }

			$sum_pay_amount2 = @mysql_result($result_sum2,0,0);
			$sum_pay_amount2_K = number_format($sum_pay_amount2);
			
			if($sum_pay_amount1 > 0 OR $sum_pay_amount2 > 0) {
			
			echo ("
			<tr>
				<td><b>${$fA_catg_txt}</b></td>
				<td><div align=right><b>$sum_pay_amount1_K</b></div></td>
				<td><div align=right><b>$sum_pay_amount2_K</b></div></td>
			</tr>");
			
			
			$query_H1C = "SELECT count(uid) FROM code_acc_list WHERE $login_branch = '1' AND catg = '$fA_catg' AND lang = '$lang'";
			$result_H1C = mysql_query($query_H1C);
			if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
    
			$total_H1C = @mysql_result($result_H1C,0,0);
    
			$query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
						WHERE $login_branch = '1' AND catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
			$result_H1 = mysql_query($query_H1);
			if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
			for($h1 = 0; $h1 < $total_H1C; $h1++) {
				$H1_acc_uid = mysql_result($result_H1,$h1,0);   
				$H1_acc_code = mysql_result($result_H1,$h1,1);
				$H1_acc_name = mysql_result($result_H1,$h1,2);
				
				
				$query_pro1 = "SELECT sum(amount) FROM finance 
					WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' 
					AND f_class = 'in' AND f_catg = '$fA_catg' AND f_code = '$H1_acc_code' AND currency = '$now_currency1'";
				$result_pro1 = mysql_query($query_pro1);
				if (!$result_pro1) { error("QUERY_ERROR"); exit; }
				
				$pay_amount1 = @mysql_result($result_pro1,0,0);
				$pay_amount1_K = number_format($pay_amount1);
				
				$query_pro2 = "SELECT sum(amount) FROM finance 
					WHERE branch_code = '$login_branch' AND pay_date LIKE '$p_yearmonth%' AND process = '2' 
					AND f_class = 'in' AND f_catg = '$fA_catg' AND f_code = '$H1_acc_code' AND currency = '$now_currency2'";
				$result_pro2 = mysql_query($query_pro2);
				if (!$result_pro2) { error("QUERY_ERROR"); exit; }

				$pay_amount2 = @mysql_result($result_pro2,0,0);
				$pay_amount2_K = number_format($pay_amount2);
			
			
				echo ("
				<tr>
					<td style='padding-left: 40px'>$H1_acc_name</td>
					<td><div align=right>$pay_amount1_K</div></td>
					<td><div align=right>$pay_amount2_K</div></td>
				</tr>");
			}
			
			}
			
		
		}
		
		
		// Total
		echo ("
		<tr>
			<td><b>$txt_fin_balance_05</b></td>
			<td><div align=right><b>$sum_pay_tamount1_K</b></div></td>
			<td><div align=right><b>$sum_pay_tamount2_K</b></div></td>
		</tr>
		
		</tbody>
		</table>
		</section>");
		
		
?>