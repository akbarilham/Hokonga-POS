<?
$query_t3Ac = "SELECT count(uid) FROM member_staff_job WHERE code = '$user_code'";
$result_t3Ac = mysql_query($query_t3Ac);
  if (!$result_t3Ac) { error("QUERY_ERROR"); exit; }
$total_t3Ac = @mysql_result($result_t3Ac,0,0);


$query_t3A_dtl = "SELECT uid,job_catg,job,corp_name,corp_dept,corp_jobclass,corp_title,corp_desc,
              corp_zipcode,corp_addr1,corp_addr2,corp_phone,corp_fax,corp_website,work_in,work_out,
              memo,post_date FROM member_staff_job WHERE code = '$user_code' AND uid = '$j_uid'";
$result_t3A_dtl = mysql_query($query_t3A_dtl);
if (!$result_t3A_dtl) { error("QUERY_ERROR"); exit; }

  $t3A_dtl_uid = @mysql_result($result_t3A_dtl,0,0);
  $t3A_dtl_job_catg = @mysql_result($result_t3A_dtl,0,1);
  $t3A_dtl_job = @mysql_result($result_t3A_dtl,0,2);
  $t3A_dtl_corp_name = @mysql_result($result_t3A_dtl,0,3);
  $t3A_dtl_corp_dept = @mysql_result($result_t3A_dtl,0,4);
  $t3A_dtl_corp_jobclass = @mysql_result($result_t3A_dtl,0,5);
  $t3A_dtl_corp_title = @mysql_result($result_t3A_dtl,0,6);
  $t3A_dtl_corp_desc = @mysql_result($result_t3A_dtl,0,7);
  $t3A_dtl_corp_zipcode = @mysql_result($result_t3A_dtl,0,8);
  $t3A_dtl_corp_addr1 = @mysql_result($result_t3A_dtl,0,9);
  $t3A_dtl_corp_addr2 = @mysql_result($result_t3A_dtl,0,10);
  $t3A_dtl_corp_phone = @mysql_result($result_t3A_dtl,0,11);
  $t3A_dtl_corp_fax = @mysql_result($result_t3A_dtl,0,12);
  $t3A_dtl_corp_website = @mysql_result($result_t3A_dtl,0,13);
  $t3A_dtl_work_in = @mysql_result($result_t3A_dtl,0,14);
  $t3A_dtl_work_out = @mysql_result($result_t3A_dtl,0,15);
  $t3A_dtl_memo = @mysql_result($result_t3A_dtl,0,16);
  $t3A_dtl_post_date = @mysql_result($result_t3A_dtl,0,17);



  
echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_0301
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=3&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t3Ac > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=3&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");




// Review
if(($total_t3Ac > "0" AND $class == "A"  AND ($mode == "upd" OR $mode == "del")) OR ($mode == "add" AND $class == "A")) {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='j_uid' value='$t3A_dtl_uid'>

<br>
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0302</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_job_catg' value='$t3A_dtl_job_catg'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0303</div>
    <div class='col-sm-4'>
		  <select name='dtl_job' class='form-control'>
          <option value=''>:: $txt_comm_frm19 ::</option>");
          $query_J3c = "SELECT count(uid) FROM code_job3 WHERE job_class = 'L' AND lang = '$lang'";
          $result_J3c = mysql_query($query_J3c,$dbconn);
            if (!$result_J3c) { error("QUERY_ERROR"); exit; }
      
          $total_J3c = @mysql_result($result_J3c,0,0);
      
          $query_J3 = "SELECT job_code,job_name FROM code_job3 WHERE job_class = 'L' AND lang = '$lang' 
                      ORDER BY job_code ASC";
          $result_J3 = mysql_query($query_J3,$dbconn);
          if (!$result_J3) { error("QUERY_ERROR"); exit; }   

          for($j3 = 0; $j3 < $total_J3c; $j3++) {
            $J3_job_code = mysql_result($result_J3,$j3,0);
            $J3_job_name = mysql_result($result_J3,$j3,1);
              
            if($t3A_dtl_job == $J3_job_code) {
              echo ("<option value='$J3_job_code' selected>$J3_job_name</option>");
            } else {
              echo ("<option value='$J3_job_code'>$J3_job_name</option>");
            }
            
          }
          echo ("
          </select>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0304</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_name' value='$t3A_dtl_corp_name'>
	</div>
	<div class='col-sm-2'>$txt_stf_staff_15</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_dept' value='$t3A_dtl_corp_dept'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0305</label>
    <div class='col-sm-8'>
		<textarea name='dtl_corp_desc' class='form-control' rows=4>$t3A_dtl_corp_desc</textarea>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_stf_staff_17</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_jobclass' value='$t3A_dtl_corp_jobclass'>
	</div>
	<div class='col-sm-2'>$txt_stf_staff_16</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_title' value='$t3A_dtl_corp_title'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_14</label>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='dtl_corp_zipcode' value='$t3A_dtl_corp_zipcode' maxlength=7 placeholder='$txt_sys_client_15'>
	</div>
	<div class='col-sm-2'></div>
    <div class='col-sm-4'></div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_addr2' value='$t3A_dtl_corp_addr2' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_16)</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='dtl_corp_addr1' value='$t3A_dtl_corp_addr1' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_17)</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_05</label>
    <div class='col-sm-8'>
		<input type='url' class='form-control' id='l-name' name='dtl_corp_website' value='$t3A_dtl_corp_website' placeholder='http://'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_08</label>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='dtl_corp_phone' value='$t3A_dtl_corp_phone'>
	</div>
	<div class='col-sm-2'>FAX</div>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='dtl_corp_fax' value='$t3A_dtl_corp_fax'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0306</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_work_in' value='$t3A_dtl_work_in' placeholder='YYYY.MM' data-mask='9999.99'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0307</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_work_out' value='$t3A_dtl_work_out' placeholder='YYYY.MM' data-mask='9999.99'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='dtl_memo' class='form-control' rows=4>$t3A_dtl_memo</textarea>
	</div>
</div>
");

}


if($total_t3Ac > "0") {

echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_tab_hr_member_0302</th>
    <th>$txt_tab_hr_member_0303</th>
    <th>$txt_tab_hr_member_0304</th>
	<th>$txt_stf_staff_15</th>
	<th>$txt_stf_staff_17</th>
	<th>$txt_tab_hr_member_0306</th>
	<th>$txt_tab_hr_member_0307</th>
</tr>
</thead>
		
		
<tbody>");


$query_t3A = "SELECT uid,job_catg,job,corp_name,corp_dept,corp_jobclass,work_in,work_out 
              FROM member_staff_job WHERE code = '$user_code' ORDER BY work_in ASC, post_date ASC";
$result_t3A = mysql_query($query_t3A);
  if (!$result_t3A) { error("QUERY_ERROR"); exit; }   

for($t3A = 0; $t3A < $total_t3Ac; $t3A++) {

  $t3A_uid = mysql_result($result_t3A,$t3A,0);
  $t3A_job_catg = mysql_result($result_t3A,$t3A,1);
  $t3A_job = mysql_result($result_t3A,$t3A,2);
    // 직업명
    $t3A1_query = "SELECT job_name FROM code_job3 WHERE job_code = '$t3A_job' AND lang = '$lang'";
    $t3A1_result = mysql_query($t3A1_query);
      if (!$t3A1_result) { error("QUERY_ERROR"); exit; }
    $t3A_job_name = @mysql_result($t3A1_result,0,0);
  $t3A_corp_name = mysql_result($result_t3A,$t3A,3);
  $t3A_corp_dept = mysql_result($result_t3A,$t3A,4);
  $t3A_corp_jobclass = mysql_result($result_t3A,$t3A,5);
  $t3A_work_in = mysql_result($result_t3A,$t3A,6);
  $t3A_work_out = mysql_result($result_t3A,$t3A,7);
  
  $total_t3Acm = $total_t3Ac - 1;
  
  // 선택된 항목
  if(!$j_uid) {
    if($t3A == $total_t3Acm) {
      $t3A_td_color = "#FAFAB4";
    } else {
      $t3A_td_color = "#FFFFFF";
    }
  } else {
    if($t3A_uid == $j_uid) {
      $t3A_td_color = "#FAFAB4";
    } else {
      $t3A_td_color = "#FFFFFF";
    }
  }
  
  echo ("
  <tr>
    <td bgcolor='$t3A_td_color'>$t3A_job_catg</td>
    <td bgcolor='$t3A_td_color'>$t3A_job_name</td>
    <td bgcolor='$t3A_td_color'>&nbsp; <a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=3&j_uid=$t3A_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t3A_corp_name</a></td>
    <td bgcolor='$t3A_td_color'>$t3A_corp_dept</td>
    <td bgcolor='$t3A_td_color'>$t3A_corp_jobclass</td>
    <td bgcolor='$t3A_td_color'>$t3A_work_in</td>
    <td bgcolor='$t3A_td_color'>$t3A_work_out</td>
  </tr>");
}


}
echo ("
</tbody>
</table>
<section>");





// School
$query_t3Bc = "SELECT count(uid) FROM member_staff_school WHERE code = '$user_code'";
$result_t3Bc = mysql_query($query_t3Bc);
  if (!$result_t3Bc) { error("QUERY_ERROR"); exit; }
$total_t3Bc = @mysql_result($result_t3Bc,0,0);


$query_t3B_dtl = "SELECT uid,sch_catg,sch_name,sch_area,sch_dept,sch_class,fin_flag,sch_in,sch_out,
              memo,post_date FROM member_staff_school WHERE code = '$user_code' AND uid = '$j_uid'";
$result_t3B_dtl = mysql_query($query_t3B_dtl);
if (!$result_t3B_dtl) { error("QUERY_ERROR"); exit; }

  $t3B_dtl_uid = @mysql_result($result_t3B_dtl,0,0);
  $t3B_dtl_sch_catg = @mysql_result($result_t3B_dtl,0,1);
  $t3B_dtl_sch_name = @mysql_result($result_t3B_dtl,0,2);
  $t3B_dtl_sch_area = @mysql_result($result_t3B_dtl,0,3);
  $t3B_dtl_sch_dept = @mysql_result($result_t3B_dtl,0,4);
  $t3B_dtl_sch_class = @mysql_result($result_t3B_dtl,0,5);
  $t3B_dtl_fin_flag = @mysql_result($result_t3B_dtl,0,6);
      if($t3B_dtl_fin_flag == "0") {
        $t3B_dtl_fin_flag_chk0 = "checked";
        $t3B_dtl_fin_flag_chk1 = "";
        $t3B_dtl_fin_flag_chk2 = "";
      } else if($t3B_dtl_fin_flag == "1") {
        $t3B_dtl_fin_flag_chk0 = "";
        $t3B_dtl_fin_flag_chk1 = "checked";
        $t3B_dtl_fin_flag_chk2 = "";
      } else if($t3B_dtl_fin_flag == "2") {
        $t3B_dtl_fin_flag_chk0 = "";
        $t3B_dtl_fin_flag_chk1 = "";
        $t3B_dtl_fin_flag_chk2 = "checked";
      }
  $t3B_dtl_sch_in = @mysql_result($result_t3B_dtl,0,7);
  $t3B_dtl_sch_out = @mysql_result($result_t3B_dtl,0,8);
  $t3B_dtl_memo = @mysql_result($result_t3B_dtl,0,9);
  $t3B_dtl_post_date = @mysql_result($result_t3B_dtl,0,10);



echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_0351
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=3&class=B&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t3Bc > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=3&j_uid=$j_uid&class=B&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");



// Review
if(($total_t3Bc > "0" AND $class == "B" AND ($mode == "upd" OR $mode == "del")) OR ($mode == "add" AND $class == "B")) {

echo ("
<input type=hidden name='class' value='B'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='j_uid' value='$t3B_dtl_uid'>

<br>
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0352</label>
    <div class='col-sm-4'>
		  
		  <select name='dtl_sch_catg' class='form-control'>
          <option value=''>:: $txt_comm_frm19 ::</option>");
          
          if($t3B_dtl_sch_catg == "1") {
            echo ("<option value='1' selected>$txt_tab_hr_member_03531</option>");
          } else {
            echo ("<option value='1'>$txt_tab_hr_member_03531</option>");
          }
          
          if($t3B_dtl_sch_catg == "2") {
            echo ("<option value='2' selected>$txt_tab_hr_member_03532</option>");
          } else {
            echo ("<option value='2'>$txt_tab_hr_member_03532</option>");
          }
          
          if($t3B_dtl_sch_catg == "3") {
            echo ("<option value='3' selected>$txt_tab_hr_member_03533</option>");
          } else {
            echo ("<option value='3'>$txt_tab_hr_member_03533</option>");
          }
          
          if($t3B_dtl_sch_catg == "4") {
            echo ("<option value='4' selected>$txt_tab_hr_member_03534</option>");
          } else {
            echo ("<option value='4'>$txt_tab_hr_member_03534</option>");
          }
          
          if($t3B_dtl_sch_catg == "5") {
            echo ("<option value='5' selected>$txt_tab_hr_member_03535</option>");
          } else {
            echo ("<option value='5'>$txt_tab_hr_member_03535</option>");
          }
          
          if($t3B_dtl_sch_catg == "6") {
            echo ("<option value='6' selected>$txt_tab_hr_member_03536</option>");
          } else {
            echo ("<option value='6'>$txt_tab_hr_member_03536</option>");
          }
          
          if($t3B_dtl_sch_catg == "7") {
            echo ("<option value='7' selected>$txt_tab_hr_member_03537</option>");
          } else {
            echo ("<option value='7'>$txt_tab_hr_member_03537</option>");
          }
          
          if($t3B_dtl_sch_catg == "8") {
            echo ("<option value='8' selected>$txt_tab_hr_member_03538</option>");
          } else {
            echo ("<option value='8'>$txt_tab_hr_member_03538</option>");
          }
          
          if($t3B_dtl_sch_catg == "9") {
            echo ("<option value='9' selected>$txt_tab_hr_member_03539</option>");
          } else {
            echo ("<option value='9'>$txt_tab_hr_member_03539</option>");
          }

          echo ("
          </select> 
		  
	</div>
    <div class='col-sm-6'>
		<input type='text' class='form-control' id='l-name' name='dtl_sch_name' value='$t3B_dtl_sch_name'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0354</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_sch_area' value='$t3B_dtl_sch_area'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0355</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_sch_dept' value='$t3B_dtl_sch_dept'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0356</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_sch_in' value='$t3B_dtl_sch_in' placeholder='YYYY.MM' data-mask='9999.99'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0357</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_sch_out' value='$t3B_dtl_sch_out' placeholder='YYYY.MM' data-mask='9999.99'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0358</label>
    <div class='col-sm-8'>
		<input type=radio name='dtl_fin_flag' value='0' $t3B_dtl_fin_flag_chk0> $txt_tab_hr_member_03580 &nbsp;&nbsp; 
        <input type=radio name='dtl_fin_flag' value='1' $t3B_dtl_fin_flag_chk1> $txt_tab_hr_member_03581 &nbsp;&nbsp; 
        <input type=radio name='dtl_fin_flag' value='2' $t3B_dtl_fin_flag_chk2> $txt_tab_hr_member_03582 &nbsp;&nbsp; 
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='dtl_memo' class='form-control' rows=4>$t3B_dtl_memo</textarea>
	</div>
</div>
");

}


if($total_t3Bc > "0") {

echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_tab_hr_member_0353</th>
    <th>$txt_tab_hr_member_0352</th>
    <th>$txt_tab_hr_member_0354</th>
	<th>$txt_tab_hr_member_0355</th>
	<th>$txt_tab_hr_member_0356</th>
	<th>$txt_tab_hr_member_0357</th>
	<th>$txt_tab_hr_member_0358</th>
</tr>
</thead>
		
		
<tbody>");


$query_t3B = "SELECT uid,sch_catg,sch_name,sch_area,sch_dept,sch_in,sch_out,fin_flag 
              FROM member_staff_school WHERE code = '$user_code' ORDER BY sch_in ASC, post_date ASC";
$result_t3B = mysql_query($query_t3B);
  if (!$result_t3B) { error("QUERY_ERROR"); exit; }   

for($t3B = 0; $t3B < $total_t3Bc; $t3B++) {

  $t3B_uid = mysql_result($result_t3B,$t3B,0);
  $t3B_sch_catg = mysql_result($result_t3B,$t3B,1);
    if($t3B_sch_catg == "1") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03531";
    } else if($t3B_sch_catg == "2") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03532";
    } else if($t3B_sch_catg == "3") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03533";
    } else if($t3B_sch_catg == "4") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03534";
    } else if($t3B_sch_catg == "5") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03535";
    } else if($t3B_sch_catg == "6") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03536";
    } else if($t3B_sch_catg == "7") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03537";
    } else if($t3B_sch_catg == "8") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03538";
    } else if($t3B_sch_catg == "9") {
      $t3B_sch_catg_txt = "$txt_tab_hr_member_03539";
    }
  $t3B_sch_name = mysql_result($result_t3B,$t3B,2);
  $t3B_sch_area = mysql_result($result_t3B,$t3B,3);
  $t3B_sch_dept = mysql_result($result_t3B,$t3B,4);
  $t3B_sch_in = mysql_result($result_t3B,$t3B,5);
  $t3B_sch_out = mysql_result($result_t3B,$t3B,6);
  $t3B_fin_flag = mysql_result($result_t3B,$t3B,7);
    if($t3B_fin_flag == "0") {
      $t3B_fin_flag_txt = "$txt_tab_hr_member_03580";
    } else if($t3B_fin_flag == "1") {
      $t3B_fin_flag_txt = "$txt_tab_hr_member_03581";
    } else if($t3B_fin_flag == "2") {
      $t3B_fin_flag_txt = "$txt_tab_hr_member_03582";
    }
  $total_t3Bcm = $total_t3Bc - 1;
  
  // 선택된 항목
  if(!$j_uid) {
    if($t3B == $total_t3Bcm) {
      $t3B_td_color = "#FAFAB4";
    } else {
      $t3B_td_color = "#FFFFFF";
    }
  } else {
    if($t3B_uid == $j_uid) {
      $t3B_td_color = "#FAFAB4";
    } else {
      $t3B_td_color = "#FFFFFF";
    }
  }
  
  echo ("
  <tr height=22>
    <td bgcolor='$t3B_td_color'>$t3B_sch_catg_txt</td>
    <td bgcolor='$t3B_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=$tab&j_uid=$t3B_uid&class=B&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t3B_sch_name</a></td>
    <td bgcolor='$t3B_td_color'>$t3B_sch_area</td>
    <td bgcolor='$t3B_td_color'>$t3B_sch_dept</td>
    <td bgcolor='$t3B_td_color'>$t3B_sch_in</td>
    <td bgcolor='$t3B_td_color'>$t3B_sch_out</td>
    <td bgcolor='$t3B_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=$tab&j_uid=$t3B_uid&class=B&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t3B_fin_flag_txt</a></td>
  </tr>");
}


}
echo ("
</tbody>
</table>
<section>");
?>
