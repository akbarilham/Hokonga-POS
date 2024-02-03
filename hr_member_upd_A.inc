<?
$query_tAc = "SELECT count(uid) FROM member_staff_addr WHERE code = '$user_code'";
$result_tAc = mysql_query($query_tAc);
  if (!$result_tAc) { error("QUERY_ERROR"); exit; }
$total_tAc = @mysql_result($result_tAc,0,0);


$query_tA_dtl = "SELECT uid,fam_sync,fam_code,zipcode,addr1,addr2,phone,phone_cel,post_date 
              FROM member_staff_addr WHERE uid = '$j_uid'";
$result_tA_dtl = mysql_query($query_tA_dtl);
if (!$result_tA_dtl) { error("QUERY_ERROR"); exit; }

  $tA_dtl_uid = @mysql_result($result_tA_dtl,0,0);
  $tA_dtl_fam_sync = @mysql_result($result_tA_dtl,0,1);
    if($tA_dtl_fam_sync == "0") {
      $tA_dtl_fam_sync_chk = "";
    } else if($tA_dtl_fam_sync == "1") {
      $tA_dtl_fam_sync_chk = "checked";
    }
  $tA_dtl_fam_code = @mysql_result($result_tA_dtl,0,2);
  $tA_dtl_zipcode = @mysql_result($result_tA_dtl,0,3);
  $tA_dtl_addr1 = @mysql_result($result_tA_dtl,0,4);
  $tA_dtl_addr2 = @mysql_result($result_tA_dtl,0,5);
  $tA_dtl_phone = @mysql_result($result_tA_dtl,0,6);
  $tA_dtl_phone_cel = @mysql_result($result_tA_dtl,0,7);
  $tA_dtl_post_date = @mysql_result($result_tA_dtl,0,8);
  
    // 날짜 분리
    $tA_dtl_post_dayEX = explode("-",$tA_dtl_post_date);
    $tA_dtl_post_day1 = $tA_dtl_post_dayEX[0];
	  $tA_dtl_post_day2 = $tA_dtl_post_dayEX[1];
	  $tA_dtl_post_day3 = $tA_dtl_post_dayEX[2];
	
	  if($lang == "ko") {
	    $tA_dtl_post_date_txt = $tA_dtl_post_date;
	  } else {
	    $tA_dtl_post_date_txt = "$tA_dtl_post_day3"."-"."$tA_dtl_post_day2"."-"."$tA_dtl_post_day1";
	  }
	  
    // 세대주 주소 추출
    $tAB_dtl_query = "SELECT zipcode,addr1,addr2,phone,phone_cel,post_date FROM member_staff_addr WHERE code = '$tA_dtl_fam_code'";
    $tAB_dtl_result = mysql_query($tAB_dtl_query);
      if (!$tAB_dtl_result) { error("QUERY_ERROR"); exit; }
    
    $tAB_dtl_zipcode = @mysql_result($tAB_dtl_result,0,0);
    $tAB_dtl_addr1 = @mysql_result($tAB_dtl_result,0,1);
    $tAB_dtl_addr2 = @mysql_result($tAB_dtl_result,0,2);
    $tAB_dtl_phone = @mysql_result($tAB_dtl_result,0,3);
    $tAB_dtl_phone_cel = @mysql_result($tAB_dtl_result,0,4);
    $tAB_dtl_post_date = @mysql_result($tAB_dtl_result,0,5);
    
      // 날짜 분리
      $tAB_dtl_post_dayEX = explode("-",$tAB_dtl_post_date);
      $tAB_dtl_post_day1 = $tAB_dtl_post_dayEX[0];
	    $tAB_dtl_post_day2 = $tAB_dtl_post_dayEX[1];
	    $tAB_dtl_post_day3 = $tAB_dtl_post_dayEX[2];
	
	    if($lang == "ko") {
	      $tAB_dtl_post_date_txt = $tAB_dtl_post_date;
	    } else {
	      $tAB_dtl_post_date_txt = "$tAB_dtl_post_day3"."-"."$tAB_dtl_post_day2"."-"."$tAB_dtl_post_day1";
	    }


	  $this_zipcode = $tA_dtl_zipcode;
      $this_addr1 = $tA_dtl_addr1;
      $this_addr2 = $tA_dtl_addr2;
      $this_phone = $tA_dtl_phone;
      $this_post_date = $tA_dtl_post_date;
      


echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_A
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=A&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_tAc > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=A&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");





// Review
if($total_tAc > "0" AND ($mode == "upd" OR $mode == "del")) {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='j_uid' value='$tA_dtl_uid'>
<input type=hidden name='upd_fam_head' value='$fam_head'>
<input type=hidden name='upd_fam_code' value='$fam_code'>

<br>
<div class='form-group'>
    <label class='col-sm-6 control-label'><input type=checkbox name='fam_sync' value='1' $tA_dtl_fam_sync_chk> $txt_tab_hr_member_A01</label>
	<div class='col-sm-2'></div>
    <div class='col-sm-4'>
		<input type='date' class='form-control' id='l-name' name='new_post_date' value='$this_post_date' max='$post_date1_dash'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_14</label>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='zipcode' value='$this_zipcode' maxlength=7 placeholder='$txt_sys_client_15'>
	</div>
	<div class='col-sm-2'>TEL.</div>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='phone' value='$this_phone'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='addr2' value='$this_addr2' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_16)</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='addr1' value='$this_addr1' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_17)</div>
</div>
");




} else if($mode == "add") {

echo ("
<input type=hidden name='class' value='A'>
<input type=hidden name='mode' value='add'>
<input type=hidden name='j_uid' value='$tA_dtl_uid'>
<input type=hidden name='upd_fam_head' value='$fam_head'>
<input type=hidden name='upd_fam_code' value='$fam_code'>

<br>
<div class='form-group'>
    <label class='col-sm-6 control-label'><input type=checkbox name='fam_sync' value='1' $tA_dtl_fam_sync_chk> $txt_tab_hr_member_A01</label>
	<div class='col-sm-2'></div>
    <div class='col-sm-4'>
		<input type='date' class='form-control' id='l-name' name='new_post_date' value='$post_date1_dash' max='$post_date1_dash'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_14</label>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='zipcode' maxlength=7 placeholder='$txt_sys_client_15'>
	</div>
	<div class='col-sm-2'>TEL.</div>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='phone'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='addr2' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_16)</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'></label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='addr1' maxlength=120>
	</div>
	<div class='col-sm-2'>($txt_sys_client_17)</div>
</div>
");


}






if($total_tAc > "0") {

echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_sys_client_14</th>
    <th>$txt_sys_client_08</th>
    <th>$txt_fin_cost_06</th>
</tr>
</thead>
		
		
<tbody>");


if($fam_head == "1") {
	$query_tAx = "SELECT count(uid) FROM member_staff_addr WHERE code = '$user_code' ORDER BY post_date ASC";
} else {
	$query_tAx = "SELECT count(uid) FROM member_staff_addr 
              WHERE code = '$user_code' OR ( fam_code = '$fam_code' AND fam_sync = '1' ) ORDER BY post_date ASC";
}
$result_tAx = mysql_query($query_tAx);
  if (!$result_tAx) { error("QUERY_ERROR"); exit; }   

$total_tAx = @mysql_result($result_tAx,0,0);
  

$query_tA = "SELECT uid,fam_sync,fam_code,zipcode,addr1,addr2,phone,phone_cel,post_date FROM member_staff_addr 
            WHERE code = '$user_code' ORDER BY post_date ASC";
$result_tA = mysql_query($query_tA);
  if (!$result_tA) { error("QUERY_ERROR"); exit; }   

for($tA = 0; $tA < $total_tAx; $tA++) {

  $tA_uid = mysql_result($result_tA,$tA,0);
  $tA_fam_sync = mysql_result($result_tA,$tA,1);
  $tA_fam_code = mysql_result($result_tA,$tA,2);
  $tA_zipcode = mysql_result($result_tA,$tA,3);
  $tA_addr1 = mysql_result($result_tA,$tA,4);
  $tA_addr2 = mysql_result($result_tA,$tA,5);
  $tA_phone = mysql_result($result_tA,$tA,6);
  $tA_phone_cel = mysql_result($result_tA,$tA,7);
  $tA_post_date = mysql_result($result_tA,$tA,8);

    // 날짜 분리
    $tA_post_dayEX = explode("-",$tA_post_date);
    $tA_post_day1 = $tA_post_dayEX[0];
	  $tA_post_day2 = $tA_post_dayEX[1];
	  $tA_post_day3 = $tA_post_dayEX[2];
	
	  if($lang == "ko") {
	    $tA_post_date_txt = $tA_post_date;
	  } else {
	    $tA_post_date_txt = "$tA_post_day3"."-"."$tA_post_day2"."-"."$tA_post_day1";
	  }
	
	if($tA_fam_sync == "1") {
	  $sync_tag = "<i class='fa fa-share'></i>";
	} else {
	  $sync_tag = "";
	}


  $total_tAcm = $total_tAx - 1;
  
	if(!$j_uid) {
		if($tA == $total_tAcm) {
			$tA_td_color = "#FAFAB4";
		} else {
			$tA_td_color = "#FFFFFF";
		}
	} else {
		if($tA_uid == $j_uid) {
			$tA_td_color = "#FAFAB4";
		} else {
			$tA_td_color = "#FFFFFF";
		}
	}
  
  echo ("
  <tr>
    <td bgcolor='$tA_td_color'>$sync_tag <a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=A&j_uid=$tA_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$tA_addr2 $tA_addr1 $tA_zipcode</a></td>
    <td bgcolor='$tA_td_color'>$tA_phone</td>
    <td bgcolor='$tA_td_color'>$tA_post_date_txt</td>
  </tr>");
  
}


}
?>
</tbody>
</table>
<section>

