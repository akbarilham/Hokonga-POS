<?
$query_t7c = "SELECT count(uid) FROM payroll_list WHERE mb_code = '$user_code'";
$result_t7c = mysql_query($query_t7c);
  if (!$result_t7c) { error("QUERY_ERROR"); exit; }
$total_t7c = @mysql_result($result_t7c,0,0);

$query_t7_dtl = "SELECT uid,year,yearmonth,pay_type,payroll_code,deduction_code,days_total,days_off,days_on,currency,
				amount_avrg,amount_avrg_cost,amount_avrg_net,amount_deduction,amount_incentive,amount_bonus,
				amount_offset,amount_tax,amount_final,pay_amount,pay_diff,pay_status,due_date,pay_date 
				FROM payroll_list WHERE mb_code = '$user_code' AND uid = '$j_uid'";
$result_t7_dtl = mysql_query($query_t7_dtl);
if (!$result_t7_dtl) { error("QUERY_ERROR"); exit; }

	$t7_dtl_uid = @mysql_result($result_t7_dtl,0,0);
	$t7_dtl_year = @mysql_result($result_t7_dtl,0,1);
	$t7_dtl_yearmonth = @mysql_result($result_t7_dtl,0,2);
	$t7_dtl_pay_type = @mysql_result($result_t7_dtl,0,3);
	$t7_dtl_payroll_code = @mysql_result($result_t7_dtl,0,4);
	$t7_dtl_deduction_code = @mysql_result($result_t7_dtl,0,5);
	$t7_dtl_days_total = @mysql_result($result_t7_dtl,0,6);
	$t7_dtl_days_off = @mysql_result($result_t7_dtl,0,7);
	$t7_dtl_days_on = @mysql_result($result_t7_dtl,0,8);
	$t7_dtl_currency = @mysql_result($result_t7_dtl,0,9);
	$t7_dtl_amount_avrg = @mysql_result($result_t7_dtl,0,10);
		$t7_dtl_amount_avrg_k = number_format($t7_dtl_amount_avrg);
	$t7_dtl_amount_avrg_cost = @mysql_result($result_t7_dtl,0,11);
		$t7_dtl_amount_avrg_cost_k = number_format($t7_dtl_amount_avrg_cost);
	$t7_dtl_amount_avrg_net = @mysql_result($result_t7_dtl,0,12);
		$t7_dtl_amount_avrg_net_k = number_format($t7_dtl_amount_avrg_net);
	$t7_dtl_amount_deduction = @mysql_result($result_t7_dtl,0,13);
		$t7_dtl_amount_deduction_k = number_format($t7_dtl_amount_deduction);
	$t7_dtl_amount_incentive = @mysql_result($result_t7_dtl,0,14);
		$t7_dtl_amount_incentive_k = number_format($t7_dtl_amount_incentive);
	$t7_dtl_amount_bonus = @mysql_result($result_t7_dtl,0,15);
		$t7_dtl_amount_bonus_k = number_format($t7_dtl_amount_bonus);
	$t7_dtl_amount_offset = @mysql_result($result_t7_dtl,0,16);
		$t7_dtl_amount_offset_k = number_format($t7_dtl_amount_offset);
	$t7_dtl_amount_tax = @mysql_result($result_t7_dtl,0,17);
		$t7_dtl_amount_tax_k = number_format($t7_dtl_amount_tax);
	$t7_dtl_amount_final = @mysql_result($result_t7_dtl,0,18);
		$t7_dtl_amount_final_k = number_format($t7_dtl_amount_final);
	$t7_dtl_pay_amount = @mysql_result($result_t7_dtl,0,19);
		$t7_dtl_pay_amount_k = number_format($t7_dtl_pay_amount);
	$t7_dtl_pay_diff = @mysql_result($result_t7_dtl,0,20);
		$t7_dtl_pay_diff_k = number_format($t7_dtl_pay_diff);
	$t7_dtl_pay_status = @mysql_result($result_t7_dtl,0,21);
	$t7_dtl_due_dates = @mysql_result($result_t7_dtl,0,22);
	$t7_dtl_pay_dates = @mysql_result($result_t7_dtl,0,23);
  
$t7_dtl_payroll_code_xpd = explode("-",$t7_dtl_payroll_code);
$t7_dtl_query_cname = "SELECT mname_abr FROM code_jobclass2 WHERE lcode = '$t7_dtl_payroll_code_xpd[0]' AND mcode = '$t7_dtl_payroll_code_xpd[1]'";
$t7_dtl_result_cname = mysql_query($t7_dtl_query_cname);
	if (!$t7_dtl_result_cname) {   error("QUERY_ERROR");   exit; }
$t7_dtl_payroll_name = @mysql_result($t7_dtl_result_cname,0,0);
$t7_dtl_payroll_code2 = "$t7_dtl_payroll_name"."-"."$t7_dtl_payroll_code_xpd[2]";

$t7_dtl_query_cname_d = "SELECT driver FROM code_jobclass1 WHERE lcode = '$t7_dtl_payroll_code_xpd[0]'";
$t7_dtl_result_cname_d = mysql_query($t7_dtl_query_cname_d);
	if (!$t7_dtl_result_cname_d) {   error("QUERY_ERROR");   exit; }
$t7_dtl_payroll_driver = @mysql_result($t7_dtl_result_cname_d,0,0);

if($t7_dtl_payroll_driver == "1") {
	$t7_dtl_payroll_driver_txt = "&gt; driver";
} else {
	$t7_dtl_payroll_driver_txt = "&nbsp;";
}


echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_07
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=7&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t7c > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=7&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");





// Review
echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_tab_hr_member_0701</th>
    <th>$txt_tab_hr_member_0702</th>
	<th>$txt_tab_hr_member_0704</th>
	<th>Days</th>
	<th>Net Salary</th>
	<th>+/-</th>
	<th>$txt_tab_hr_member_0710</th>
	<th>$txt_tab_hr_member_0713</th>
	<th>$txt_tab_hr_member_0714</th>
</tr>
</thead>
		
		
<tbody>");

// Total
    
      
if($total_t7c > "0") {

  // Total
  echo ("
  <!--
  <tr>
    <td></td>
    <td></td>
	<td></td>
	<th></th>
	<th></th>
	<th></th>
	<td></td>
	<td></td>
	<td></td>
  </tr>-->
  ");




$query_t7 = "SELECT uid,year,yearmonth,pay_type,payroll_code,deduction_code,days_total,days_off,days_on,
			currency,amount_avrg,amount_avrg_cost,amount_avrg_net,amount_incentive,amount_bonus,amount_deduction,
			amount_offset,amount_tax,amount_final,pay_amount,pay_diff,pay_status,due_date,pay_date FROM payroll_list 
            WHERE mb_code = '$user_code' ORDER BY due_date DESC";
$result_t7 = mysql_query($query_t7);
  if (!$result_t7) { error("QUERY_ERROR"); exit; }   

	for($t7 = 0; $t7 < $total_t7c; $t7++) {

	$t7_uid = mysql_result($result_t7,$t7,0);
	$t7_year = mysql_result($result_t7,$t7,1);
    $t7_yearmonth = mysql_result($result_t7,$t7,2);
	$t7_pay_type = mysql_result($result_t7,$t7,3);
		if($t7_pay_type == "A") {
			$t7_pay_type_txt = "$txt_tab_hr_member_07021";
		} else if($t7_pay_type == "B") {
			$t7_pay_type_txt = "$txt_tab_hr_member_07022";
		}
	$t7_payroll_code = mysql_result($result_t7,$t7,4);
	$t7_deduction_code = mysql_result($result_t7,$t7,5);
	$t7_days_total = mysql_result($result_t7,$t7,6);
	$t7_days_off = mysql_result($result_t7,$t7,7);
	$t7_days_on = mysql_result($result_t7,$t7,8);
	$t7_currency = mysql_result($result_t7,$t7,9);
	$t7_amount_avrg = mysql_result($result_t7,$t7,10);
		$t7_amount_avrg_k = number_format($t7_amount_avrg);
	$t7_amount_avrg_cost = mysql_result($result_t7,$t7,11);
		$t7_amount_avrg_cost_k = number_format($t7_amount_avrg_cost);
	$t7_amount_avrg_net = mysql_result($result_t7,$t7,12);
		$t7_amount_avrg_net_k = number_format($t7_amount_avrg_net);
	$t7_amount_incentive = mysql_result($result_t7,$t7,13);
		$t7_amount_incentive_k = number_format($t7_amount_incentive);
	$t7_amount_bonus = mysql_result($result_t7,$t7,14);
		$t7_amount_bonus_k = number_format($t7_amount_bonus);
	$t7_amount_deduction = mysql_result($result_t7,$t7,15);
		$t7_amount_deduction_k = number_format($t7_amount_deduction);
	$t7_amount_offset = mysql_result($result_t7,$t7,16);
		$t7_amount_offset_k = number_format($t7_amount_offset);
	$t7_amount_tax = mysql_result($result_t7,$t7,17);
		$t7_amount_tax_k = number_format($t7_amount_tax);
	$t7_amount_final = mysql_result($result_t7,$t7,18);
		$t7_amount_final_k = number_format($t7_amount_final);
	$t7_pay_amount = mysql_result($result_t7,$t7,19);
		$t7_pay_amount_k = number_format($t7_pay_amount);
	$t7_pay_diff = mysql_result($result_t7,$t7,20);
		$t7_pay_diff_k = number_format($t7_pay_diff);
	$t7_pay_status = mysql_result($result_t7,$t7,21);
	$t7_due_date = mysql_result($result_t7,$t7,22);
		$t7_due_date_xpd = explode("-",$t7_due_date);
		if($lang == "ko") {
			$t7_due_date_txt = "$t7_due_date_xpd[0]"."/"."$t7_due_date_xpd[1]"."/"."$t7_due_date_xpd[2]";
		} else {
			$t7_due_date_txt = "$t7_due_date_xpd[2]"."-"."$t7_due_date_xpd[1]"."-"."$t7_due_date_xpd[0]";
		}
	$t7_pay_date = mysql_result($result_t7,$t7,23);
		$t7_pay_date_xpd = explode("-",$t7_pay_date);
		if($t7_pay_date > "1") {
		if($lang == "ko") {
			$t7_pay_date_txt = "$t7_pay_date_xpd[0]"."/"."$t7_pay_date_xpd[1]"."/"."$t7_pay_date_xpd[2]";
		} else {
			$t7_pay_date_txt = "$t7_pay_date_xpd[2]"."-"."$t7_pay_date_xpd[1]"."-"."$t7_pay_date_xpd[0]";
		}
		} else {
			$t7_pay_date_txt = "";
		}
	
	$t7_amount_difference = $t7_amount_final - $t7_amount_avrg_net;
		$t7_amount_difference_k = number_format($t7_amount_difference);
    
  
	$total_t7cm = $total_t7c - 1;
	
	
	
  
	// High Light
	if(!$j_uid) {
		if($t7 == 0) {
			$t7_td_color = "#FAFAB4";
		} else {
			$t7_td_color = "#FFFFFF";
		}
	} else {
		if($t7_uid == $j_uid) {
			$t7_td_color = "#FAFAB4";
		} else {
			$t7_td_color = "#FFFFFF";
		}
	}
  
  
	echo ("
	<tr>
		<td bgcolor='$t7_td_color'>$t7_yearmonth</td>
		<td bgcolor='$t7_td_color'>$t7_pay_type_txt</td>
		<td bgcolor='$t7_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=7&j_uid=$t7_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t7_amount_avrg_k</a></td>
		
		<td bgcolor='$t7_td_color'>$t7_days_on/$t7_days_total</td>
		<td bgcolor='$t7_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=7&j_uid=$t7_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t7_amount_avrg_net_k</a></td>
		<td bgcolor='$t7_td_color'>$t7_amount_difference_k</td>
		
		<td bgcolor='$t7_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=7&j_uid=$t7_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t7_amount_final_k</a></td>
		<td bgcolor='$t7_td_color'>$t7_due_date_txt</td>
		<td bgcolor='$t7_td_color'>$t7_pay_date_txt</td>
	</tr>");
	}


}


if($login_level > "4") {

	
	
	// Default Date
	$pmonth_d = sprintf("%02d", $pmonth);
	$pyearmonth = "$post_year"."-"."$pmonth_d";
	
	if($lang == "ko") {
		$monthyear_txt = "$post_year"."/"."$pmonth_d";
	} else {
		$monthyear_txt = "$pmonth_d"."-"."$post_year";
	}
	
	$pmonth2p = $pmonth + 1;
	if($pmonth2p > "12") {
		$pmonth2 = $pmonth2p - 12;
		$post_year2 = $post_year + 1;
	} else {
		$pmonth2 = $pmonth2p;
		$post_year2 = $post_year;
	}
	
	$pmonth2_d = sprintf("%02d", $pmonth2);
	$pyearmonth2 = "$post_year2"."-"."$pmonth2_d";
	
	if($lang == "ko") {
		$monthyear2_txt = "$post_year2"."/"."$pmonth2_d";
	} else {
		$monthyear2_txt = "$pmonth2_d"."-"."$post_year2";
	}
	
	
	// Default Salary Date
	$pr_salary_due_dates = "$today_month_set2"."-"."27";
	
	// Work Days
	$query_days = "SELECT days FROM payroll_days WHERE year = '$post_year' ORDER BY year DESC";
	$result_days = mysql_query($query_days);
	$wdays = @mysql_result($result_days,0,0);
		
	if($wdays < "1") {
		$wdays = "22";
	}
	
	$query_days2 = "SELECT count(uid) FROM member_staff_worktime WHERE date LIKE '$pyearmonth%' AND code = '$user_code' AND work_status = '0'";
	$result_days2 = mysql_query($query_days2);
	$ps_off_days = @mysql_result($result_days2,0,0);
	
	$ps_on_days = $wdays - $ps_off_days;
	
	// Row Span
	if($payroll_driver == "1") {
		$rowspan_dtl = "7";
	} else {
		$rowspan_dtl = "6";
	}
	
	
	
	
	// Payroll Data
	if(!$t7_dtl_payroll_code) {
		$t7_dtl_payroll_code = $payroll_code;
	}
	$query_pr = "SELECT amount_basic,amount_jtitle,amount_wtrans,amount_wbonus,amount_special,amount_wmeal,amount_wcare,amount_avrg 
				FROM payroll_baseline WHERE payroll_code = '$t7_dtl_payroll_code' ORDER BY year DESC";
	$result_pr = mysql_query($query_pr);
		if (!$result_pr) {   error("QUERY_ERROR");   exit; }

	$pr_amount_basic = @mysql_result($result_pr,0,0);
		$pr_amount_basic_k = number_format($pr_amount_basic);
	$pr_amount_jtitle = @mysql_result($result_pr,0,1);
		$pr_amount_jtitle_k = number_format($pr_amount_jtitle);
	$pr_amount_wtrans = @mysql_result($result_pr,0,2);
		$pr_amount_wtrans_ps = $pr_amount_wtrans * $ps_on_days;
		$pr_amount_wtrans_all = $pr_amount_wtrans * $wdays;
		$pr_amount_wtrans_k = number_format($pr_amount_wtrans);
		$pr_amount_wtrans_ps_k = number_format($pr_amount_wtrans_ps);
		$pr_amount_wtrans_all_k = number_format($pr_amount_wtrans_all);
	$pr_amount_wbonus = @mysql_result($result_pr,0,3);
		$pr_amount_wbonus_ps = $pr_amount_wbonus * $ps_on_days;
		$pr_amount_wbonus_all = $pr_amount_wbonus * $wdays;
		$pr_amount_wbonus_k = number_format($pr_amount_wbonus);
		$pr_amount_wbonus_ps_k = number_format($pr_amount_wbonus_ps);
		$pr_amount_wbonus_all_k = number_format($pr_amount_wbonus_all);
	$pr_amount_special = @mysql_result($result_pr,0,4);
		$pr_amount_special_ps = $pr_amount_special * $ps_on_days;
		$pr_amount_special_all = $pr_amount_special * $wdays;
		$pr_amount_special_k = number_format($pr_amount_special);
		$pr_amount_special_ps_k = number_format($pr_amount_special_ps);
		$pr_amount_special_all_k = number_format($pr_amount_special_all);
	$pr_amount_wmeal = @mysql_result($result_pr,0,5);
		$pr_amount_wmeal_ps = $pr_amount_wmeal * $ps_on_days;
		$pr_amount_wmeal_all = $pr_amount_wmeal * $wdays;
		$pr_amount_wmeal_k = number_format($pr_amount_wmeal);
		$pr_amount_wmeal_ps_k = number_format($pr_amount_wmeal_ps);
		$pr_amount_wmeal_all_k = number_format($pr_amount_wmeal_all);
	$pr_amount_wcare = @mysql_result($result_pr,0,6);
		$pr_amount_wcare_ps = $pr_amount_wcare * $ps_on_days;
		$pr_amount_wcare_all = $pr_amount_wcare * $wdays;
		$pr_amount_wcare_k = number_format($pr_amount_wcare);
		$pr_amount_wcare_ps_k = number_format($pr_amount_wcare_ps);
		$pr_amount_wcare_all_k = number_format($pr_amount_wcare_all);
	$pr_amount_avrg = @mysql_result($result_pr,0,7);
		$pr_amount_avrg_k = number_format($pr_amount_avrg);

	if($payroll_driver == "1") {
		$pr_amount_avrg_ps = $pr_amount_basic + ( ( $pr_amount_wmeal + $pr_amount_wtrans + $pr_amount_wbonus + $pr_amount_special + $pr_amount_wcare ) * $ps_on_days );
	} else {
		$pr_amount_avrg_ps = $pr_amount_basic + $pr_amount_jtitle + ( ( $pr_amount_wtrans + $pr_amount_wbonus + $pr_amount_special ) * $ps_on_days );
	}
	$pr_amount_avrg_ps_k = number_format($pr_amount_avrg_ps);
	
	
	// Default Values
	$pr_amount_avrg_cost_rate = "5";
	$pr_max_amount_title = 500000; //Maximum Title Amount 

	$pr_amount_avrg_cost_ps = $pr_amount_avrg_ps * (0.01 * $pr_amount_avrg_cost_rate);
		$pr_amount_avrg_cost_ps_k = number_format($pr_amount_avrg_cost_ps);
		
		if ($pr_amount_avrg_cost_ps > $pr_max_amount_title) {
			$pr_amount_avrg_cost_ps = $pr_max_amount_title;
		}	

	$pr_amount_avrg_cost_all = $pr_amount_avrg * (0.01 * $pr_amount_avrg_cost_rate);
		$pr_amount_avrg_cost_all_k = number_format($pr_amount_avrg_cost_all);
		
	$pr_amount_avrg_net_ps = $pr_amount_avrg_ps - $pr_amount_avrg_cost_ps;
		$pr_amount_avrg_net_ps_k = number_format($pr_amount_avrg_net_ps);
	$pr_amount_avrg_net_all = $pr_amount_avrg_ps - $pr_amount_avrg_cost_all;
		$pr_amount_avrg_net_all_k = number_format($pr_amount_avrg_net_all);
		
		
	// Deduction Formula (PTKP, PKP)
	if(!$t7_dtl_deduction_code) {
		$t7_dtl_deduction_code = $deduction_code;
	}
	if($t7_dtl_deduction_code == "TK0") {
	
		# $pr_amount_avrg; // penghasilan bruto
		$pr_ptkp = 36000000; // PTKP for TK
		$pr_amount_tanggungan = 0; // Dependent Amount
		$pr_amount_married_tax = 0; // Tax Mating
		$pr_amount_50jt = 50000000; // PKP Lapisan 50jt
		$pr_amount_250jt = 250000000; // PKP Lapisan 250jt
		$pr_amount_500jt = 500000000; // PKP Lapisan 500jt

		$pr_amount_retired = 0;
		$pr_amount_avrg_net_year = $pr_amount_avrg_net_ps * 12; // Penghasilan Neto Setahun
		$total_ptkp = $pr_ptkp + $pr_amount_tanggungan + $pr_amount_married_tax;

		if ($pr_amount_avrg_net_year > $total_ptkp) {

			$pr_amount_pkp = $pr_amount_avrg_net_year - $total_ptkp; //PKP

			if ($pr_amount_pkp < 50000000) {

				// PPH21 untuk < 50jt
				$pr_amount_pasal_terutang = $pr_amount_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month

			} else if ($pr_amount_pkp >= 50000000 AND $pr_amount_pkp < 250000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$new_pkp1 = $pr_amount_pkp - $pr_amount_50jt;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt		

			} else if ($pr_amount_pkp >= 250000000 AND $pr_amount_pkp < 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_pkp - $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = round($pr_amount_pasal_terutang3 / 12); //PPH per month > 250jt				

			} else if ($pr_amount_pkp >= 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;				
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = $pr_amount_pasal_terutang / 12; //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;	
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = $pr_amount_pasal_terutang2 / 12; //PPH per month > 50jt	

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = $pr_amount_pasal_terutang3 / 12; //PPH per month > 250jt

				// PPH21 untuk > 500jt
				$new_pkp3 = $pr_amount_pkp - $pr_amount_500jt;
				$pr_amount_pasal_terutang4 = $new_pkp3 * 0.30; //PPH Pasal 21 terutang 
				$pr_amount_deduction4 = $pr_amount_pasal_terutang4 / 12; //PPH per month > 500jt

			}

			$pr_amount_deduction = round($pr_amount_deduction1 + $pr_amount_deduction2 + $pr_amount_deduction3 + $pr_amount_deduction4);
		
		} else {

		$pr_amount_deduction = 0; //PPH 

		}
		

	}  else if($t7_dtl_deduction_code == "K0") {

		# $pr_amount_avrg; // penghasilan bruto
		$pr_ptkp = 36000000; // PTKP for TK
		$pr_amount_tanggungan = 0; // Dependent Amount
		$pr_amount_married_tax = 3000000; // Tax Mating
		$pr_amount_50jt = 50000000; // PKP Lapisan 50jt
		$pr_amount_250jt = 250000000; // PKP Lapisan 250jt
		$pr_amount_500jt = 500000000; // PKP Lapisan 500jt

		$pr_amount_retired = 0;
		$pr_amount_avrg_net_year = $pr_amount_avrg_net_ps * 12; // Penghasilan Neto Setahun
		$total_ptkp = $pr_ptkp + $pr_amount_tanggungan + $pr_amount_married_tax;

		if ($pr_amount_avrg_net_year > $total_ptkp) {

			$pr_amount_pkp = $pr_amount_avrg_net_year - $total_ptkp; //PKP

			if ($pr_amount_pkp < 50000000) {

				// PPH21 untuk < 50jt
				$pr_amount_pasal_terutang = $pr_amount_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month

			} else if ($pr_amount_pkp >= 50000000 AND $pr_amount_pkp < 250000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$new_pkp1 = $pr_amount_pkp - $pr_amount_50jt;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt		

			} else if ($pr_amount_pkp >= 250000000 AND $pr_amount_pkp < 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_pkp - $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = round($pr_amount_pasal_terutang3 / 12); //PPH per month > 250jt				

			} else if ($pr_amount_pkp >= 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;				
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = $pr_amount_pasal_terutang / 12; //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;	
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = $pr_amount_pasal_terutang2 / 12; //PPH per month > 50jt	

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = $pr_amount_pasal_terutang3 / 12; //PPH per month > 250jt

				// PPH21 untuk > 500jt
				$new_pkp3 = $pr_amount_pkp - $pr_amount_500jt;
				$pr_amount_pasal_terutang4 = $new_pkp3 * 0.30; //PPH Pasal 21 terutang 
				$pr_amount_deduction4 = $pr_amount_pasal_terutang4 / 12; //PPH per month > 500jt

			}

			$pr_amount_deduction = round($pr_amount_deduction1 + $pr_amount_deduction2 + $pr_amount_deduction3 + $pr_amount_deduction4);
		
		} else {

		$pr_amount_deduction = 0; //PPH 

		}

	} else if($t7_dtl_deduction_code == "K1") {

		# $pr_amount_avrg; // penghasilan bruto
		$pr_ptkp = 36000000; // PTKP for TK
		$pr_amount_tanggungan = 3000000; // Dependent Amount
		$pr_amount_married_tax = 3000000; // Tax Mating
		$pr_amount_50jt = 50000000; // PKP Lapisan 50jt
		$pr_amount_250jt = 250000000; // PKP Lapisan 250jt
		$pr_amount_500jt = 500000000; // PKP Lapisan 500jt

		$pr_amount_retired = 0;
		$pr_amount_avrg_net_year = $pr_amount_avrg_net_ps * 12; // Penghasilan Neto Setahun
		$total_ptkp = $pr_ptkp + $pr_amount_tanggungan + $pr_amount_married_tax;

		if ($pr_amount_avrg_net_year > $total_ptkp) {

			$pr_amount_pkp = $pr_amount_avrg_net_year - $total_ptkp; //PKP

			if ($pr_amount_pkp < 50000000) {

				// PPH21 untuk < 50jt
				$pr_amount_pasal_terutang = $pr_amount_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month

			} else if ($pr_amount_pkp >= 50000000 AND $pr_amount_pkp < 250000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$new_pkp1 = $pr_amount_pkp - $pr_amount_50jt;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt		

			} else if ($pr_amount_pkp >= 250000000 AND $pr_amount_pkp < 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_pkp - $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = round($pr_amount_pasal_terutang3 / 12); //PPH per month > 250jt				

			} else if ($pr_amount_pkp >= 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;				
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = $pr_amount_pasal_terutang / 12; //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;	
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = $pr_amount_pasal_terutang2 / 12; //PPH per month > 50jt	

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = $pr_amount_pasal_terutang3 / 12; //PPH per month > 250jt

				// PPH21 untuk > 500jt
				$new_pkp3 = $pr_amount_pkp - $pr_amount_500jt;
				$pr_amount_pasal_terutang4 = $new_pkp3 * 0.30; //PPH Pasal 21 terutang 
				$pr_amount_deduction4 = $pr_amount_pasal_terutang4 / 12; //PPH per month > 500jt

			}

			$pr_amount_deduction = round($pr_amount_deduction1 + $pr_amount_deduction2 + $pr_amount_deduction3 + $pr_amount_deduction4);
		
		} else {

		$pr_amount_deduction = 0; //PPH 

		}

	} else if($t7_dtl_deduction_code == "K2") {

		# $pr_amount_avrg; // penghasilan bruto
		$pr_ptkp = 36000000; // PTKP for TK
		$pr_amount_tanggungan = 6000000; // Dependent Amount
		$pr_amount_married_tax = 3000000; // Tax Mating
		$pr_amount_50jt = 50000000; // PKP Lapisan 50jt
		$pr_amount_250jt = 250000000; // PKP Lapisan 250jt
		$pr_amount_500jt = 500000000; // PKP Lapisan 500jt

		$pr_amount_retired = 0;
		$pr_amount_avrg_net_year = $pr_amount_avrg_net_ps * 12; // Penghasilan Neto Setahun
		$total_ptkp = $pr_ptkp + $pr_amount_tanggungan + $pr_amount_married_tax;

		if ($pr_amount_avrg_net_year > $total_ptkp) {

			$pr_amount_pkp = $pr_amount_avrg_net_year - $total_ptkp; //PKP

			if ($pr_amount_pkp < 50000000) {

				// PPH21 untuk < 50jt
				$pr_amount_pasal_terutang = $pr_amount_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month

			} else if ($pr_amount_pkp >= 50000000 AND $pr_amount_pkp < 250000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$new_pkp1 = $pr_amount_pkp - $pr_amount_50jt;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt		

			} else if ($pr_amount_pkp >= 250000000 AND $pr_amount_pkp < 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_pkp - $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = round($pr_amount_pasal_terutang3 / 12); //PPH per month > 250jt				

			} else if ($pr_amount_pkp >= 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;				
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = $pr_amount_pasal_terutang / 12; //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;	
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = $pr_amount_pasal_terutang2 / 12; //PPH per month > 50jt	

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = $pr_amount_pasal_terutang3 / 12; //PPH per month > 250jt

				// PPH21 untuk > 500jt
				$new_pkp3 = $pr_amount_pkp - $pr_amount_500jt;
				$pr_amount_pasal_terutang4 = $new_pkp3 * 0.30; //PPH Pasal 21 terutang 
				$pr_amount_deduction4 = $pr_amount_pasal_terutang4 / 12; //PPH per month > 500jt

			}

			$pr_amount_deduction = round($pr_amount_deduction1 + $pr_amount_deduction2 + $pr_amount_deduction3 + $pr_amount_deduction4);
		
		} else {

		$pr_amount_deduction = 0; //PPH 

		}

	} else if($t7_dtl_deduction_code == "K3") {

		# $pr_amount_avrg; // penghasilan bruto
		$pr_ptkp = 36000000; // PTKP for TK
		$pr_amount_tanggungan = 9000000; // Dependent Amount
		$pr_amount_married_tax = 3000000; // Tax Mating
		$pr_amount_50jt = 50000000; // PKP Lapisan 50jt
		$pr_amount_250jt = 250000000; // PKP Lapisan 250jt
		$pr_amount_500jt = 500000000; // PKP Lapisan 500jt

		//var_dump($pr_amount_avrg_cost_ps);
		$pr_amount_retired = 0;
		$pr_amount_avrg_net_year = $pr_amount_avrg_net_ps * 12; // Penghasilan Neto Setahun
		$total_ptkp = $pr_ptkp + $pr_amount_tanggungan + $pr_amount_married_tax;

		if ($pr_amount_avrg_net_year > $total_ptkp) {

			$pr_amount_pkp = $pr_amount_avrg_net_year - $total_ptkp; //PKP

			if ($pr_amount_pkp < 50000000) {

				// PPH21 untuk < 50jt
				$pr_amount_pasal_terutang = $pr_amount_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month

			} else if ($pr_amount_pkp >= 50000000 AND $pr_amount_pkp < 250000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$new_pkp1 = $pr_amount_pkp - $pr_amount_50jt;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt		

			} else if ($pr_amount_pkp >= 250000000 AND $pr_amount_pkp < 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = round($pr_amount_pasal_terutang / 12); //PPH per month < 50jt

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = round($pr_amount_pasal_terutang2 / 12); //PPH per month	> 50jt

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_pkp - $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = round($pr_amount_pasal_terutang3 / 12); //PPH per month > 250jt				

			} else if ($pr_amount_pkp >= 500000000) {

				// PPH21 untuk < 50jt
				$new_pkp = $pr_amount_50jt;				
				$pr_amount_pasal_terutang = $new_pkp * 0.05; //PPH Pasal 21 terutang 
				$pr_amount_deduction1 = $pr_amount_pasal_terutang / 12; //PPH per month

				// PPH21 untuk > 50jt
				$pr_amount_between = $pr_amount_250jt - $pr_amount_50jt;	
				$new_pkp1 = $pr_amount_between;
				$pr_amount_pasal_terutang2 = $new_pkp1 * 0.15; //PPH Pasal 21 terutang 
				$pr_amount_deduction2 = $pr_amount_pasal_terutang2 / 12; //PPH per month		

				// PPH21 untuk > 250jt
				$new_pkp2 = $pr_amount_250jt;
				$pr_amount_pasal_terutang3 = $new_pkp2 * 0.25; //PPH Pasal 21 terutang 
				$pr_amount_deduction3 = $pr_amount_pasal_terutang3 / 12; //PPH per month

				// PPH21 untuk > 500jt
				$new_pkp3 = $pr_amount_pkp - $pr_amount_500jt;
				$pr_amount_pasal_terutang4 = $new_pkp3 * 0.30; //PPH Pasal 21 terutang 
				$pr_amount_deduction4 = $pr_amount_pasal_terutang4 / 12; //PPH per month

				/*echo 'PR AMOUNT PKP = '.number_format($pr_amount_pkp);
				echo '<br/>NEW PKP = '.number_format($new_pkp);
				echo '<br/>NEW PKP1 = '.number_format($new_pkp1);
				echo '<br/>NEW PKP2 = '.number_format($new_pkp2);
				echo '<br/>NEW PKP3 = '.number_format($new_pkp3);
				echo '<br/>===================================';
				echo '<br/>PR AMOUNT DEDUCTION1 = '.number_format($pr_amount_deduction1);
				echo '<br/>PR AMOUNT DEDUCTION2 = '.number_format($pr_amount_deduction2);
				echo '<br/>PR AMOUNT DEDUCTION3 = '.number_format($pr_amount_deduction3);
				echo '<br/>PR AMOUNT DEDUCTION4 = '.number_format($pr_amount_deduction4);*/

			}

			$pr_amount_deduction = round($pr_amount_deduction1 + $pr_amount_deduction2 + $pr_amount_deduction3 + $pr_amount_deduction4);
		
		} else {

		$pr_amount_deduction = 0; //PPH 

		}

	} else {
		$pr_amount_deduction = $pr_amount_avrg_net_ps;
	}
	
	

		
	

// UPDATE & DELETE
if($total_t7c > "0" AND ($mode == "upd" OR $mode == "del")) {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='mb_payroll_code' value='$t7_dtl_payroll_code'>
<input type=hidden name='mb_deduction_code' value='$t7_dtl_deduction_code'>
<input type=hidden name='mb_days_total' value='$t7_dtl_days_total'>
<input type=hidden name='mb_amount_avrg_ps' value='$t7_dtl_amount_avrg'>
<input type=hidden name='j_uid' value='$t7_dtl_uid'>


<tr>
	<td colspan=2><i class='fa fa-caret-down'></i></td>
	<td colspan=2>
		<select name='new_days_on' class='form-control'>");
		for($wd=0;$wd<=$wdays;$wd++) {
			if($wd == $t7_dtl_days_on) {
				echo ("<option value='$wd' selected>$wd &nbsp;</option>");
			} else {
				echo ("<option value='$wd'>$wd &nbsp;</option>");
			}
		} echo ("
		</select>
	</td>
	<td colspan=5>Days</td>
</tr>

<tr>
	<td rowspan='$rowspan_dtl' colspan=2>$txt_tab_hr_member_0704 ($t7_dtl_payroll_code2) <br>$t7_dtl_payroll_driver_txt</td>
	<td colspan=2><b>Gross Salary</b></td>
	<td colspan=2 align=right><b>$t7_dtl_amount_avrg_k</b></td>
	<td colspan=3>/ $t7_dtl_amount_avrg_k</td>
</tr>
<tr>
	<td colspan=2>Basic Salary</td>
	<td colspan=2 align=right>$t7_dtl_amount_basic_k</td>
	<td colspan=3>&nbsp;</td>
</tr>");

if($payroll_driver == "1") {

echo ("
<tr>
	<td colspan=2>Tunj. Mkn *</td>
	<td colspan=2 align=right>$pr_amount_wmeal_ps_k</td>
	<td colspan=3>= $pr_amount_wmeal_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Trans. *</td>
	<td colspan=2 align=right>$pr_amount_wtrans_ps_k</td>
	<td colspan=3>= $pr_amount_wtrans_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Premi Kehadiran *</td>
	<td colspan=2 align=right>$pr_amount_wbonus_ps_k</td>
	<td colspan=3>= $pr_amount_wbonus_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Tugas *</td>
	<td colspan=2 align=right>$pr_amount_special_ps_k</td>
	<td colspan=3>= $pr_amount_special_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Car Care Allowance *</td>
	<td colspan=2 align=right>$pr_amount_wcare_ps_k</td>
	<td colspan=3>= $pr_amount_wcare_k x $ps_on_days</td>
</tr>");

} else {

echo ("
<tr>
	<td colspan=2>Tunj. Jabatan</td>
	<td colspan=2 align=right>$pr_amount_jtitle_k</td>
	<td colspan=3>&nbsp;</td>
</tr>
<tr>
	<td colspan=2>Tunj. Mkn/Trans. *</td>
	<td colspan=2 align=right>$pr_amount_wtrans_ps_k</td>
	<td colspan=3>= $pr_amount_wtrans_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Premi Kehadiran *</td>
	<td colspan=2 align=right>$pr_amount_wbonus_ps_k</td>
	<td colspan=3>= $pr_amount_wbonus_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Khusus *</td>
	<td colspan=2 align=right>$pr_amount_special_ps_k</td>
	<td colspan=3>= $pr_amount_special_k x $ps_on_days</td>
</tr>");

}


echo ("
<tr>
	<td colspan=2>Biaya Jabatan</td>
	<td>&nbsp;</td>
	<td>-</td>
	<td colspan=2><input type=text name='new_amount_avrg_cost_ps' value='$pr_amount_avrg_cost_ps' class='form-control'></td>
	<td colspan=3>= $pr_amount_avrg_ps_k x {$pr_amount_avrg_cost_rate}%</td>
</tr>
<tr>
	<td colspan=4 align=center><b>Net Salary</b></td>
	<td colspan=2 align=right><b>$pr_amount_avrg_net_ps_k</b></td>
	<td colspan=3>/ $pr_amount_avrg_net_all_k</td>
</tr>

<tr>
	<td colspan=2>$txt_tab_hr_member_0707</td>
	<td>$deduction_code</td>
	<td>+/-</td>
	<td colspan=2><input type=text name='new_amount_deduction' value='$t7_dtl_amount_deduction' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0705</td>
	<td>&nbsp;</td>
	<td>+</td>
	<td colspan=2><input type=text name='new_amount_incentive' value='$t7_dtl_amount_incentive' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0706</td>
	<td>&nbsp;</td>
	<td>+</td>
	<td colspan=2><input type=text name='new_amount_bonus' value='$t7_dtl_amount_bonus' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0708</td>
	<td>&nbsp;</td>
	<td>+/-</td>
	<td colspan=2><input type=text name='new_amount_offset' value='$t7_dtl_amount_offset' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0709</td>
	<td>&nbsp;</td>
	<td>-</td>
	<td colspan=2><input type=text name='new_amount_tax' value='$t7_dtl_amount_tax' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=4 align=center>$txt_tab_hr_member_0713</td>
	<td colspan=3><input type=date name='new_due_dates' value='$t7_dtl_due_dates' class='form-control'></td>
	<td colspan=2></td>
</tr>
<tr>
	<td colspan=4 align=center>Date of Payment</td>
	<td colspan=3><input type=date name='new_pay_dates' value='$t7_dtl_pay_dates' class='form-control'></td>
	<td colspan=2></td>
</tr>
");


// POST
} else if($mode == "add") {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='mb_payroll_code' value='$payroll_code'>
<input type=hidden name='mb_deduction_code' value='$deduction_code'>
<input type=hidden name='mb_days_total' value='$wdays'>
<input type=hidden name='mb_amount_avrg_ps' value='$pr_amount_avrg_ps'>
<input type=hidden name='j_uid' value='$t7_dtl_uid'>


<tr>
	<td>
		<select name='new_yearmonth'>
		<option value='$pyearmonth'>$monthyear_txt</option>
		<option value='$pyearmonth2'>$monthyear2_txt</option>
		</select>
	</td>
	<td>
		<select name='new_pay_type' style='width: 60px'>
		<option value='A'>$txt_tab_hr_member_07021</option>
		<option value='B'>$txt_tab_hr_member_07022</option>
		</select>
	</td>
	<td>$pr_amount_avrg_k</td>

	<td>
		<select name='new_days_on'>");
		for($wd=0;$wd<=$wdays;$wd++) {
			if($wd == $ps_on_days) {
				echo ("<option value='$wd' selected>$wd</option>");
			} else {
				echo ("<option value='$wd'>$wd</option>");
			}
		} echo ("
		</select>
	</td>
	<td>$pr_amount_avrg_net_ps_k</td>
	<td><i class='fa fa-caret-down'></i></td>
	<td colspan=3>&nbsp;</td>
</tr>

<tr>
	<td rowspan='$rowspan_dtl' colspan=2>$txt_tab_hr_member_0704 ($t7_dtl_payroll_code2) <br>$payroll_driver_txt</td>
	<td colspan=2><b>Gross Salary</b></td>
	<td colspan=2 align=right><b>$pr_amount_avrg_ps_k</b></td>
	<td colspan=3>/ $pr_amount_avrg_k</td>
</tr>
<tr>
	<td colspan=2>Basic Salary</td>
	<td colspan=2 align=right>$pr_amount_basic_k</td>
	<td colspan=3>&nbsp;</td>
</tr>");

if($payroll_driver == "1") {

echo ("
<tr>
	<td colspan=2>Tunj. Mkn *</td>
	<td colspan=2 align=right>$pr_amount_wmeal_ps_k</td>
	<td colspan=3>= $pr_amount_wmeal_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Trans. *</td>
	<td colspan=2 align=right>$pr_amount_wtrans_ps_k</td>
	<td colspan=3>= $pr_amount_wtrans_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Premi Kehadiran *</td>
	<td colspan=2 align=right>$pr_amount_wbonus_ps_k</td>
	<td colspan=3>= $pr_amount_wbonus_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Tugas *</td>
	<td colspan=2 align=right>$pr_amount_special_ps_k</td>
	<td colspan=3>= $pr_amount_special_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Car Care Allowance *</td>
	<td colspan=2 align=right>$pr_amount_wcare_ps_k</td>
	<td colspan=3>= $pr_amount_wcare_k x $ps_on_days</td>
</tr>");

} else {

echo ("
<tr>
	<td colspan=2>Tunj. Jabatan</td>
	<td colspan=2 align=right>$pr_amount_jtitle_k</td>
	<td colspan=3>&nbsp;</td>
</tr>
<tr>
	<td colspan=2>Tunj. Mkn/Trans. *</td>
	<td colspan=2 align=right>$pr_amount_wtrans_ps_k</td>
	<td colspan=3>= $pr_amount_wtrans_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Premi Kehadiran *</td>
	<td colspan=2 align=right>$pr_amount_wbonus_ps_k</td>
	<td colspan=3>= $pr_amount_wbonus_k x $ps_on_days</td>
</tr>
<tr>
	<td colspan=2>Tunj. Khusus *</td>
	<td colspan=2 align=right>$pr_amount_special_ps_k</td>
	<td colspan=3>= $pr_amount_special_k x $ps_on_days</td>
</tr>");

}


echo ("
<tr>
	<td colspan=2>Biaya Jabatan</td>
	<td>&nbsp;</td>
	<td>-</td>
	<td colspan=2><input type=text name='new_amount_avrg_cost_ps' value='$pr_amount_avrg_cost_ps' class='form-control'></td>
	<td colspan=3>= $pr_amount_avrg_ps_k x {$pr_amount_avrg_cost_rate}% </td>
</tr>
<tr>
	<td colspan=4 align=center><b>Net Salary</b></td>
	<td colspan=2 align=right><b>$pr_amount_avrg_net_ps_k</b></td>
	<td colspan=3>/ $pr_amount_avrg_net_all_k</td>
</tr>

<!--<tr>
	<td colspan=2>$txt_tab_hr_member_0707</td>
	<td>$deduction_code</td>
	<td>+/-</td>
	<td colspan=2><input type=text name='new_amount_deduction' value='$pr_amount_deduction' class='form-control'></td>
	<td colspan=3></td>
</tr>-->
<tr>
	<td colspan=2>$txt_tab_hr_member_0705</td>
	<td>&nbsp;</td>
	<td>+</td>
	<td colspan=2><input type=text name='new_amount_incentive' value='0' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0706</td>
	<td>&nbsp;</td>
	<td>+</td>
	<td colspan=2><input type=text name='new_amount_bonus' value='0' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0708</td>
	<td>&nbsp;</td>
	<td>+/-</td>
	<td colspan=2><input type=text name='new_amount_offset' value='0' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=2>$txt_tab_hr_member_0709 / PPH 21</td>
	<td>$deduction_code</td>
	<td>-</td>
	<td colspan=2><input type=text name='new_amount_tax' value='$pr_amount_deduction' class='form-control'></td>
	<td colspan=3></td>
</tr>
<tr>
	<td colspan=4 align=center>$txt_tab_hr_member_0713</td>
	<td colspan=3><input type=date name='new_due_dates' value='$pr_salary_due_dates' class='form-control'></td>
	<td colspan=2></td>
</tr>
");

}



}
echo ("
</tbody>
</table>
<section>");
?>
