<?
$query_tCc = "SELECT count(uid) FROM member_staff_retire WHERE code = '$user_code'";
$result_tCc = mysql_query($query_tCc);
  if (!$result_tCc) { error("QUERY_ERROR"); exit; }
$total_tCc = @mysql_result($result_tCc,0,0);

$query_tC_dtl = "SELECT uid,branch_code,regis_date,retire_date,retire_pay_tamount,retire_pay_amount,retire_pay_date,retire_pay_status,
				retire_pay2_amount,retire_pay2_date,retire_pay2_status,memo,post_date FROM member_staff_retire WHERE code = '$user_code' 
				ORDER BY post_date DESC";
$result_tC_dtl = mysql_query($query_tC_dtl);
if (!$result_tC_dtl) { error("QUERY_ERROR"); exit; }

	$tC_dtl_uid = @mysql_result($result_tC_dtl,0,0);
	$tC_dtl_branch_code = @mysql_result($result_tC_dtl,0,1);
	$tC_dtl_regis_date = @mysql_result($result_tC_dtl,0,2);
	$tC_dtl_retire_date = @mysql_result($result_tC_dtl,0,3);
	$tC_dtl_retire_pay_tamount = @mysql_result($result_tC_dtl,0,4);
		$tC_dtl_retire_pay_tamount_K = number_format($tC_dtl_retire_pay_tamount);
	$tC_dtl_retire_pay_amount = @mysql_result($result_tC_dtl,0,5);
		$tC_dtl_retire_pay_amount_K = number_format($tC_dtl_retire_pay_amount);
	$tC_dtl_retire_pay_date = @mysql_result($result_tC_dtl,0,6);
	$tC_dtl_retire_pay_status = @mysql_result($result_tC_dtl,0,7);
	$tC_dtl_retire_pay2_amount = @mysql_result($result_tC_dtl,0,8);
		$tC_dtl_retire_pay2_amount_K = number_format($tC_dtl_retire_pay2_amount);
	$tC_dtl_retire_pay2_date = @mysql_result($result_tC_dtl,0,9);
	$tC_dtl_retire_pay2_status = @mysql_result($result_tC_dtl,0,10);
	$tC_dtl_memo = @mysql_result($result_tC_dtl,0,11);
	$tC_dtl_post_date = @mysql_result($result_tC_dtl,0,12);

$query_tC2_dtl = "SELECT branch_code,regis_date FROM member_staff WHERE code = '$user_code'";
$result_tC2_dtl = mysql_query($query_tC2_dtl);
if (!$result_tC2_dtl) { error("QUERY_ERROR"); exit; }

	$tC2_dtl_branch_code = @mysql_result($result_tC2_dtl,0,0);
		$query_gname2 = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$tC2_dtl_branch_code'";
		$result_gname2 = mysql_query($query_gname2);
			if (!$result_gname2) {   error("QUERY_ERROR");   exit; }
		$tC2_dtl_branch_name = @mysql_result($result_gname2,0,0);
	$tC2_dtl_regis_date = @mysql_result($result_tC2_dtl,0,1);
	

// 입사일
if($total_tCc > 0) {
	$upd_dtl_regis_date = $tC_dtl_retire_date;
} else {
	$upd_dtl_regis_date = $tC2_dtl_regis_date;
}




echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_C
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_tCc > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
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
	<th>$txt_comm_frm23</th>
    <th>$txt_tab_hr_member_C02</th>
    <th>$txt_tab_hr_member_C03</th>
	<!--<th>$txt_tab_hr_member_C06</th>-->
	<th>$txt_tab_hr_member_C01</th>
	<th>$txt_tab_hr_member_C05</th>
</tr>
</thead>
		
		
<tbody>");


    
      
if($total_tCc > "0") {

	// Total
	$query_tCsum1_dtl = "SELECT sum(retire_pay_amount) FROM member_staff_retire WHERE code = '$user_code' AND retire_pay_status > '0' AND retire_pay_date > '1'";
	$result_tCsum1_dtl = mysql_query($query_tCsum1_dtl);
	if (!$result_tCsum1_dtl) { error("QUERY_ERROR"); exit; }

	$tCsum1_retire_pay_amount = @mysql_result($result_tCsum1_dtl,0,0);
		$tCsum1_retire_pay_amount_K = number_format($tCsum1_retire_pay_amount);
	
	$query_tCsum2_dtl = "SELECT sum(retire_pay2_amount) FROM member_staff_retire WHERE code = '$user_code' AND retire_pay2_status > '0' AND retire_pay2_date > '1'";
	$result_tCsum2_dtl = mysql_query($query_tCsum2_dtl);
	if (!$result_tCsum2_dtl) { error("QUERY_ERROR"); exit; }

	$tCsum2_retire_pay_amount = @mysql_result($result_tCsum2_dtl,0,0);
		$tCsum2_retire_pay_amount_K = number_format($tCsum2_retire_pay_amount);
  
  echo ("
  <tr>
    <td style='border-bottom: 1px solid #000'>&nbsp;</td>
    <td style='border-bottom: 1px solid #000'>$tC_dtl_regis_date</td>
	<td style='border-bottom: 1px solid #000'>&nbsp;</td>
	<td style='border-bottom: 1px solid #000'><b><font color=#000000>$tCsum1_retire_pay_amount_K</font></b></td>
	<td style='border-bottom: 1px solid #000'><b><font color=#000000>$tCsum2_retire_pay_amount_K</font></b></td>
  </tr>");




$query_tC = "SELECT uid,branch_code,regis_date,retire_date,retire_pay_tamount,retire_pay_amount,retire_pay_date,retire_pay_status,
				retire_pay2_amount,retire_pay2_date,retire_pay2_status,memo,post_date FROM member_staff_retire WHERE code = '$user_code' ORDER BY post_date DESC";
$result_tC = mysql_query($query_tC);
  if (!$result_tC) { error("QUERY_ERROR"); exit; }   

	for($tC = 0; $tC < $total_tCc; $tC++) {

	$tC_uid = @mysql_result($result_tC,$tC,0);
	$tC_branch_code = @mysql_result($result_tC,$tC,1);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$tC_branch_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$tC_branch_name = @mysql_result($result_gname,0,0);
	$tC_regis_date = @mysql_result($result_tC,$tC,2);
	$tC_retire_date = @mysql_result($result_tC,$tC,3);
	$tC_retire_pay_tamount = @mysql_result($result_tC,$tC,4);
		$tC_retire_pay_tamount_K = number_format($tC_retire_pay_tamount);
	$tC_retire_pay_amount = @mysql_result($result_tC,$tC,5);
		$tC_retire_pay_amount_K = number_format($tC_retire_pay_amount);
	$tC_retire_pay_date = @mysql_result($result_tC,$tC,6);
	$tC_retire_pay_status = @mysql_result($result_tC,$tC,7);
	$tC_retire_pay2_amount = @mysql_result($result_tC,$tC,8);
		$tC_retire_pay2_amount_K = number_format($tC_retire_pay2_amount);
	$tC_retire_pay2_date = @mysql_result($result_tC,$tC,9);
	$tC_retire_pay2_status = @mysql_result($result_tC,$tC,10);
	$tC_memo = @mysql_result($result_tC,$tC,11);
	$tC_post_date = @mysql_result($result_tC,$tC,12);
	
	if($tC_retire_pay_status > "0") {
		$tC_retire_pay_amount_txt = "<font color=#006699>$tC_retire_pay_amount_K</font>";
	} else {
		$tC_retire_pay_amount_txt = "<font color=#aaaaaa>$tC_retire_pay_amount_K</font>";
	}
	if($tC_retire_pay2_status > "0") {
		$tC_retire_pay2_amount_txt = "<font color=#006699>$tC_retire_pay2_amount_K</font>";
	} else {
		$tC_retire_pay2_amount_txt = "<font color=#aaaaaa>$tC_retire_pay2_amount_K</font>";
	}
 
	// 선택된 항목
	if(!$j_uid) {
		if($tC == 0) {
			$tC_td_color = "#FAFAB4";
		} else {
			$tC_td_color = "#FFFFFF";
		}
	} else {
		if($tC_uid == $j_uid) {
			$tC_td_color = "#FAFAB4";
		} else {
			$tC_td_color = "#FFFFFF";
		}
	}
  
  
	echo ("
	<tr>
		<td bgcolor='$tC_td_color'>$tC_branch_name</td>
		<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$tC_regis_date</a></td>
		<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$tC_retire_date</a></td>
		<!--<td bgcolor='$tC_td_color'>$tC_retire_pay_tamount_K</td>--> ");
		
		if($tC_retire_pay_status > "0" AND $tC_retire_pay_date > "1") {
			echo ("<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$tC_retire_pay_date'>$tC_retire_pay_amount_txt</a></td>");
		} else {
			echo ("<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$tC_retire_pay_amount_txt</a></td>");
		}
		if($tC_retire_pay2_status > "0" AND $tC_retire_pay2_date > "1") {
			echo ("<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$tC_retire_pay2_date'>$tC_retire_pay2_amount_txt</a></td>");
		} else {
			echo ("<td bgcolor='$tC_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=C&j_uid=$tC_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$tC_retire_pay2_amount_txt</a></td>");
		}
		echo ("
	</tr>");
	}


}


if($login_level > "4") {


if($total_tCc > "0" AND $mode == "del") { // Delete

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='del'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='j_uid' value='$tC_dtl_uid'>");


} else if($total_tCc > "0" AND $mode == "upd") { // Update

	$query_tCu_dtl = "SELECT uid,branch_code,regis_date,retire_date,retire_pay_tamount,retire_pay_amount,retire_pay_date,retire_pay_status,
				retire_pay2_amount,retire_pay2_date,retire_pay2_status,memo,post_date FROM member_staff_retire WHERE uid = '$j_uid' 
				ORDER BY post_date DESC";
	$result_tCu_dtl = mysql_query($query_tCu_dtl);
	if (!$result_tCu_dtl) { error("QUERY_ERROR"); exit; }

	$tCu_dtl_uid = @mysql_result($result_tCu_dtl,0,0);
	$tCu_dtl_branch_code = @mysql_result($result_tCu_dtl,0,1);
	$tCu_dtl_regis_date = @mysql_result($result_tCu_dtl,0,2);
	$tCu_dtl_retire_date = @mysql_result($result_tCu_dtl,0,3);
	$tCu_dtl_retire_pay_tamount = @mysql_result($result_tCu_dtl,0,4);
		$tCu_dtl_retire_pay_tamount_K = number_format($tCu_dtl_retire_pay_tamount);
	$tCu_dtl_retire_pay_amount = @mysql_result($result_tCu_dtl,0,5);
		$tCu_dtl_retire_pay_amount_K = number_format($tCu_dtl_retire_pay_amount);
	$tCu_dtl_retire_pay_date = @mysql_result($result_tCu_dtl,0,6);
	$tCu_dtl_retire_pay_status = @mysql_result($result_tCu_dtl,0,7);
	$tCu_dtl_retire_pay2_amount = @mysql_result($result_tCu_dtl,0,8);
		$tCu_dtl_retire_pay2_amount_K = number_format($tCu_dtl_retire_pay2_amount);
	$tCu_dtl_retire_pay2_date = @mysql_result($result_tCu_dtl,0,9);
	$tCu_dtl_retire_pay2_status = @mysql_result($result_tCu_dtl,0,10);
	$tCu_dtl_memo = @mysql_result($result_tCu_dtl,0,11);
	$tCu_dtl_post_date = @mysql_result($result_tCu_dtl,0,12);

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='upd'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='j_uid' value='$tCu_dtl_uid'>

<tr><td colspan=5></td></tr>
<tr>
	<td>&nbsp;</td>
	<td><input type=date name='new_regis_date' value='$tCu_dtl_regis_date' class='form-control'></td>
	<td><input type=date name='new_retire_date' value='$tCu_dtl_retire_date' class='form-control'></td>
	<!--<td>&nbsp;</td>-->
	<td><input type=date name='new_retire_pay_date' value='$tCu_dtl_retire_pay_date' class='form-control'></td>
	<td><input type=date name='new_retire_pay2_date' value='$tCu_dtl_retire_pay2_date' class='form-control'></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan=2>&nbsp;</td>
	<!--<td>&nbsp;</td>-->
	<td><input type=text name='new_retire_pay_amount' value='$tCu_dtl_retire_pay_amount' class='form-control'></td>
	<td><input type=text name='new_retire_pay2_amount' value='$tCu_dtl_retire_pay2_amount' class='form-control'></td>
</tr>");

} else if($mode == "add") {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='add'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='j_uid' value='$tC_dtl_uid'>
<input type=hidden name='mb_branch_code' value='$tC2_dtl_branch_code'>

<tr><td colspan=5></td></tr>
<tr>
	<td>$tC2_dtl_branch_name</td>
	<td><input type=date name='new_regis_date' value='$upd_dtl_regis_date' class='form-control'></td>
	<td><input type=date name='new_retire_date' value='$post_date1_dash' class='form-control'></td>
	<!--<td>&nbsp;</td>-->
	<td><input type=text name='new_retire_pay_amount' class='form-control'></td>
	<td>&nbsp;</td>
</tr>");

}

}



echo ("
</tbody>
</table>
<section>");
?>
