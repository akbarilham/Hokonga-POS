<?
$query_t8c = "SELECT count(uid) FROM member_staff_work WHERE code = '$user_code'";
$result_t8c = mysql_query($query_t8c);
  if (!$result_t8c) { error("QUERY_ERROR"); exit; }
$total_t8c = @mysql_result($result_t8c,0,0);

$query_t8_dtl = "SELECT uid,name,nik,date1,date2,twork_in_early,twork_in_late,twork_out_early,twork_over,twork_hours,
				total_off_report,total_warning,twork_score,work_score1,work_score2,work_score3,work_score4,work_score5,memo 
				FROM member_staff_work WHERE code = '$user_code'";
$result_t8_dtl = mysql_query($query_t8_dtl);
if (!$result_t8_dtl) { error("QUERY_ERROR"); exit; }

	$t8_dtl_uid = @mysql_result($result_t8_dtl,0,0);
	$t8_dtl_name = @mysql_result($result_t8_dtl,0,1);
	$t8_dtl_nik = @mysql_result($result_t8_dtl,0,2);
	$t8_dtl_date1 = @mysql_result($result_t8_dtl,0,3);
	$t8_dtl_date2 = @mysql_result($result_t8_dtl,0,4);
	$t8_dtl_twork_in_early = @mysql_result($result_t8_dtl,0,5);
	$t8_dtl_twork_in_late = @mysql_result($result_t8_dtl,0,6);
	$t8_dtl_twork_out_early = @mysql_result($result_t8_dtl,0,7);
	$t8_dtl_twork_over = @mysql_result($result_t8_dtl,0,8);
	$t8_dtl_twork_hours = @mysql_result($result_t8_dtl,0,9);
	$t8_dtl_total_off_report = @mysql_result($result_t8_dtl,0,10);
	$t8_dtl_total_warning = @mysql_result($result_t8_dtl,0,11);
	$t8_dtl_twork_score = @mysql_result($result_t8_dtl,0,12);
	$t8_dtl_work_score1 = @mysql_result($result_t8_dtl,0,13);
	$t8_dtl_work_score2 = @mysql_result($result_t8_dtl,0,14);
	$t8_dtl_work_score3 = @mysql_result($result_t8_dtl,0,15);
	$t8_dtl_work_score4 = @mysql_result($result_t8_dtl,0,16);
	$t8_dtl_work_score5 = @mysql_result($result_t8_dtl,0,17);
	$t8_dtl_memo = @mysql_result($result_t8_dtl,0,18);
  
  

echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_08
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=8&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t8c > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=8&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
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
    <th>$txt_hr_work_05</th>
	<th>$txt_hr_work_15</th>
	<th>$txt_hr_work_12</th>
	<th>$txt_hr_work_11</th>
	<th>$txt_hr_work_162</th>
	<th>$txt_hr_work_20</th>
	<th>$txt_hr_work_13</th>
</tr>
</thead>
		
		
<tbody>");

// Total
    
      
if($total_t8c > "0") {

  // Total
  echo ("
  <tr>
	<td>-</td>
    <td>$t8_dtl_date1 ~ $t8_dtl_date2</td>
	<td>$total_days</td>
	<td>$t8_dtl_twork_hours</td>
	<td>$t8_dtl_twork_over</td>
	<td>$t8_dtl_total_off_report</td>
	<td>$t8_dtl_total_warning</td>
  </tr>");



for($t8 = 0; $t8 < $total_t8c; $t8++) {

	$t8_uid = mysql_result($result_t8_dtl,$t8,0);
	$t8_name = mysql_result($result_t8_dtl,$t8,1);
	$t8_nik = mysql_result($result_t8_dtl,$t8,2);
	$t8_date1 = mysql_result($result_t8_dtl,$t8,3);
	$t8_date2 = mysql_result($result_t8_dtl,$t8,4);
	$t8_twork_in_early = mysql_result($result_t8_dtl,$t8,5);
	$t8_twork_in_late = mysql_result($result_t8_dtl,$t8,6);
	$t8_twork_out_early = mysql_result($result_t8_dtl,$t8,7);
	$t8_twork_over = mysql_result($result_t8_dtl,$t8,8);
	$t8_twork_hours = mysql_result($result_t8_dtl,$t8,9);
	$t8_total_off_report = mysql_result($result_t8_dtl,$t8,10);
	$t8_total_warning = mysql_result($result_t8_dtl,$t8,11);
	$t8_twork_score = mysql_result($result_t8_dtl,$t8,12);
	$t8_work_score1 = mysql_result($result_t8_dtl,$t8,13);
	$t8_work_score2 = mysql_result($result_t8_dtl,$t8,14);
	$t8_work_score3 = mysql_result($result_t8_dtl,$t8,15);
	$t8_work_score4 = mysql_result($result_t8_dtl,$t8,16);
	$t8_work_score5 = mysql_result($result_t8_dtl,$t8,17);
	$t8_memo = mysql_result($result_t8_dtl,$t8,18);
    
  
	$total_t8cm = $total_t8c - 1;
  
	// 선택된 항목
	if(!$j_uid) {
		if($t8 == 0) {
			$t8_td_color = "#FAFAB4";
		} else {
			$t8_td_color = "#FFFFFF";
		}
	} else {
		if($t8_uid == $j_uid) {
			$t8_td_color = "#FAFAB4";
		} else {
			$t8_td_color = "#FFFFFF";
		}
	}
  
  
	echo ("
	<tr>
		<td>-</td>
		<td>$t8_date1 ~ $t8_date2</td>
		<td>$total_days</td>
		<td>$t8_twork_hours</td>
		<td>$t8_twork_over</td>
		<td>$t8_total_off_report</td>
		<td>$t8_total_warning</td>
	</tr>");
	}


}


if($login_level > "4") {

	// Default Data Entry
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
	
	
	// Payroll
	
	

// Review
if(($total_t8c > "0" AND ($mode == "upd" OR $mode == "del")) OR $mode == "add") {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='mb_code' value='$user_code'>
<input type=hidden name='j_uid' value='$t8_dtl_uid'>


<tr>
	<td>
		<select name='new_yearmonth' class='form-control'>
		<option value='$pyearmonth'>$monthyear_txt</option>
		<option value='$pyearmonth2'>$monthyear2_txt</option>
		</select>
	</td>
	<td></td>
	<td></td>
	<td></td>
	<td>1</td>
	<td></td>
	<td>2</td>
	<td>3</td>
</tr>");

}



}
echo ("
</tbody>
</table>
<section>");
?>
