<?
$query_t9c = "SELECT count(uid) FROM member_staff_upd WHERE code = '$user_code'";
$result_t9c = mysql_query($query_t9c);
  if (!$result_t9c) { error("QUERY_ERROR"); exit; }
$total_t9c = @mysql_result($result_t9c,0,0);

$query_t9_dtl = "SELECT uid,upd_date,marital_status,spouse_link,spouse_code,fam_head,fam_code,
              job1,job2,age_group,dir1_code,group1_code,group2_code,userlevel,expel_date,
              expel_reason,memo,signdate FROM member_staff_upd 
              WHERE code = '$user_code' AND uid = '$j_uid'";
$result_t9_dtl = mysql_query($query_t9_dtl);
if (!$result_t9_dtl) { error("QUERY_ERROR"); exit; }

  $t9_dtl_uid = @mysql_result($result_t9_dtl,0,0);
  $t9_dtl_upd_date = @mysql_result($result_t9_dtl,0,1);
  $t9_dtl_marital_status = @mysql_result($result_t9_dtl,0,2);
  $t9_dtl_spouse_link = @mysql_result($result_t9_dtl,0,3);
  $t9_dtl_spouse_code = @mysql_result($result_t9_dtl,0,4);
  $t9_dtl_fam_head = @mysql_result($result_t9_dtl,0,5);
  $t9_dtl_fam_code = @mysql_result($result_t9_dtl,0,6);
  $t9_dtl_job1 = @mysql_result($result_t9_dtl,0,7);
  $t9_dtl_job2 = @mysql_result($result_t9_dtl,0,8);
  $t9_dtl_age_group = @mysql_result($result_t9_dtl,0,9);
  $t9_dtl_dir1_code = @mysql_result($result_t9_dtl,0,10);
  $t9_dtl_group1_code = @mysql_result($result_t9_dtl,0,11);
  $t9_dtl_group2_code = @mysql_result($result_t9_dtl,0,12);
  $t9_dtl_userlevel = @mysql_result($result_t9_dtl,0,13);
  $t9_dtl_expel_date = @mysql_result($result_t9_dtl,0,14);
  $t9_dtl_expel_dreason = @mysql_result($result_t9_dtl,0,15);
  $t9_dtl_memo = @mysql_result($result_t9_dtl,0,16);
  $t9_dtl_post_date = @mysql_result($result_t9_dtl,0,17);




echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_09
	<span class='tools pull-right'>");
		
		if($total_t9c > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=9&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");




// Review
if(($total_t9c > "0" AND ($mode == "upd" OR $mode == "del")) OR $mode == "add") {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='j_uid' value='$t9_dtl_uid'>

<br>
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0901</label>
    <div class='col-sm-4'>
		<input type='date' class='form-control' id='l-name' name='dtl_upd_date' value='$t9_dtl_upd_date' max='$post_date1_dash'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='dtl_memo' class='form-control' rows=4>$t9_dtl_memo</textarea>
	</div>
</div>");

}




if($total_t9c > "0") {

echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_hr_member_32</th>
    <th>$hsm_name_09_41</th>
    <th>$hsm_name_09_42</th>
	<th>$txt_comm_frm23</th>
	<th>$txt_hr_member_34</th>
	<th>$txt_tab_hr_member_0902</th>
	<th>$txt_tab_hr_member_0901</th>
</tr>
</thead>
		
		
<tbody>");



$query_t9 = "SELECT uid,upd_date,marital_status,spouse_link,spouse_code,fam_head,fam_code,
              job_class,pay_class,age_group,dir1_code,group1_code,group2_code,userlevel,expel_date,
              expel_reason,memo,signdate,branch_code,payroll_code,deduction_code,corp_dept FROM member_staff_upd WHERE code = '$user_code' 
              ORDER BY upd_date ASC, signdate ASC";
$result_t9 = mysql_query($query_t9);
  if (!$result_t9) { error("QUERY_ERROR"); exit; }   

for($t9 = 0; $t9 < $total_t9c; $t9++) {
  $t9_uid = mysql_result($result_t9,$t9,0);
  $t9_upd_date = mysql_result($result_t9,$t9,1);
  $t9_marital_status = mysql_result($result_t9,$t9,2);
    if($t9_marital_status == "1") {
      $t9_marital_status_txt = "$txt_hr_member_321";
    } else if($t9_marital_status == "2") {
      $t9_marital_status_txt = "$txt_hr_member_322";
    } else if($t9_marital_status == "3") {
      $t9_marital_status_txt = "$txt_hr_member_323";
    } else if($t9_marital_status == "4") {
      $t9_marital_status_txt = "$txt_hr_member_324";
    } else if($t9_marital_status == "5") {
      $t9_marital_status_txt = "$txt_hr_member_325";
    }
  $t9_spouse_link = mysql_result($result_t9,$t9,3);
  $t9_spouse_code = mysql_result($result_t9,$t9,4);
  $t9_fam_head = mysql_result($result_t9,$t9,5);
  $t9_fam_code = mysql_result($result_t9,$t9,6);
  $t9_job_class = mysql_result($result_t9,$t9,7);
	$t9_job_class_lcode = substr($t9_job_class,0,1);
	$t9_job_class_mcode = substr($t9_job_class,2,2);
    $query_t9_J1 = "SELECT mname,mname_abr FROM code_jobclass2 WHERE mcode = '$t9_job_class_mcode' AND lcode = '$t9_job_class_lcode' AND lang = '$lang'";
    $result_t9_J1 = mysql_query($query_t9_J1);
      if (!$result_t9_J1) { error("QUERY_ERROR"); exit; }   
    $t9_job_class_name = @mysql_result($result_t9_J1,0,0);
	$t9_job_class_name2 = @mysql_result($result_t9_J1,0,1);
  $t9_pay_class = mysql_result($result_t9,$t9,8);
    $query_t9_J2 = "SELECT job_name FROM code_job2 WHERE job_code = '$t9_job2' AND lang = '$lang'";
    $result_t9_J2 = mysql_query($query_t9_J2);
      if (!$result_t9_J2) { error("QUERY_ERROR"); exit; }   
    $t9_job2_name = @mysql_result($result_t9_J2,0,0);
  $t9_age_group = mysql_result($result_t9,$t9,9);
    if($t9_age_group == "8") {
      $t9_age_group_txt = "$txt_hr_member_341";
    } else if($t9_age_group == "7") {
      $t9_age_group_txt = "$txt_hr_member_342";
    } else if($t9_age_group == "6") {
      $t9_age_group_txt = "$txt_hr_member_343";
    } else if($t9_age_group == "5") {
      $t9_age_group_txt = "$txt_hr_member_344";
    } else if($t9_age_group == "0") {
      $t9_age_group_txt = "$txt_hr_member_346";
    }
  $t9_dir1_code = mysql_result($result_t9,$t9,10);
  $t9_group1_code = mysql_result($result_t9,$t9,11);
    $query_t9_G1 = "SELECT cug_name FROM dirlist_cug WHERE cug_code = '$t9_group1_code'";
    $result_t9_G1 = mysql_query($query_t9_G1);
      if (!$result_t9_G1) { error("QUERY_ERROR"); exit; }   
    $t9_group1_name = @mysql_result($result_t9_G1,0,0);
  $t9_group2_code = mysql_result($result_t9,$t9,12);
  $t9_userlevel = mysql_result($result_t9,$t9,13);
    if($t9_userlevel == "0") {
      $t9_userlevel_txt = "$txt_tab_hr_member_09023";
    } else {
      $t9_userlevel_txt = "$txt_tab_hr_member_09022";
    }
  $t9_expel_date = mysql_result($result_t9,$t9,14);
  $t9_expel_reason = mysql_result($result_t9,$t9,15);
  $t9_memo = mysql_result($result_t9,$t9,16);
  $t9_signdate = mysql_result($result_t9,$t9,17);
  $t9_branch_code = mysql_result($result_t9,$t9,18);
  $t9_payroll_code = mysql_result($result_t9,$t9,19);
  $t9_deduction_code = mysql_result($result_t9,$t9,20);
  $t9_corp_dept = mysql_result($result_t9,$t9,21);
  
  
	// Corporate
	$query_t9_Jb = "SELECT branch_name FROM client_branch WHERE branch_code = '$t9_branch_code'";
    $result_t9_Jb = mysql_query($query_t9_Jb);
      if (!$result_t9_Jb) { error("QUERY_ERROR"); exit; }   
    $t9_branch_name = @mysql_result($result_t9_Jb,0,0);
	

	
  $total_t9cm = $total_t9c - 1;
  
  // Hight Light
  if(!$j_uid) {
    if($t9 == $total_t9cm) {
      $t9_td_color = "#FAFAB4";
    } else {
      $t9_td_color = "#FFFFFF";
    }
  } else {
    if($t9_uid == $j_uid) {
      $t9_td_color = "#FAFAB4";
    } else {
      $t9_td_color = "#FFFFFF";
    }
  }
  
  echo ("
  <tr>
    <td bgcolor='$t9_td_color'>$t9_marital_status_txt</td>
    <td bgcolor='$t9_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=9&j_uid=$t9_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t9_job_class_name2</a></td>
    <td bgcolor='$t9_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=9&j_uid=$t9_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t9_pay_class - $t9_deduction_code</a></td>
    <td bgcolor='$t9_td_color'>$t9_branch_name</td>
    <td bgcolor='$t9_td_color'>$t9_corp_dept</td>
    <td bgcolor='$t9_td_color'>$t9_userlevel_txt</td>
    <td bgcolor='$t9_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=9&j_uid=$t9_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t9_upd_date</a></td>
  </tr>");
}


}
echo ("
</tbody>
</table>
<section>");
?>
