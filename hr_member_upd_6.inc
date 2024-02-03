<?
$query_t6c = "SELECT count(uid) FROM member_staff_spec WHERE code = '$user_code'";
$result_t6c = mysql_query($query_t6c);
  if (!$result_t6c) { error("QUERY_ERROR"); exit; }
$total_t6c = @mysql_result($result_t6c,0,0);


$query_t6_dtl = "SELECT uid,guide,blood_type,wed_date,fn_status,hobby,talent,sp_gift,health,
              car_no,parking_no,memo FROM member_staff_spec WHERE code = '$user_code'";
$result_t6_dtl = mysql_query($query_t6_dtl);
if (!$result_t6_dtl) { error("QUERY_ERROR"); exit; }

  $t6_dtl_uid = @mysql_result($result_t6_dtl,0,0);
  $t6_dtl_guide = @mysql_result($result_t6_dtl,0,1);
  $t6_dtl_blood_type = @mysql_result($result_t6_dtl,0,2);
    if($t6_dtl_blood_type == "A") {
      $t6_dtl_blood_type_chkA = "selected";
      $t6_dtl_blood_type_chkB = "";
      $t6_dtl_blood_type_chkAB = "";
      $t6_dtl_blood_type_chkO = "";
    } else if($t6_dtl_blood_type == "B") {
      $t6_dtl_blood_type_chkA = "";
      $t6_dtl_blood_type_chkB = "selected";
      $t6_dtl_blood_type_chkAB = "";
      $t6_dtl_blood_type_chkO = "";
    } else if($t6_dtl_blood_type == "AB") {
      $t6_dtl_blood_type_chkA = "";
      $t6_dtl_blood_type_chkB = "";
      $t6_dtl_blood_type_chkAB = "selected";
      $t6_dtl_blood_type_chkO = "";
    } else if($t6_dtl_blood_type == "O") {
      $t6_dtl_blood_type_chkA = "";
      $t6_dtl_blood_type_chkB = "";
      $t6_dtl_blood_type_chkAB = "";
      $t6_dtl_blood_type_chkO = "selected";
    }
  $t6_dtl_wed_date = @mysql_result($result_t6_dtl,0,3);
  $t6_dtl_fn_status = @mysql_result($result_t6_dtl,0,4);
  $t6_dtl_hobby = @mysql_result($result_t6_dtl,0,5);
  $t6_dtl_talent = @mysql_result($result_t6_dtl,0,6);
  $t6_dtl_sp_gift = @mysql_result($result_t6_dtl,0,7);
  $t6_dtl_health = @mysql_result($result_t6_dtl,0,8);
  $t6_dtl_car_no = @mysql_result($result_t6_dtl,0,9);
  $t6_dtl_parking_no = @mysql_result($result_t6_dtl,0,10);
  $t6_dtl_memo = @mysql_result($result_t6_dtl,0,11);


if($total_t6c > "0") {

echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_06
	<span class='tools pull-right'>
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>


<br>
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0601</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_guide' value='$t6_dtl_guide'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0602</div>
    <div class='col-sm-4'>
		<select name='dtl_blood_type' class='form-control'>
        <option value=''>:: $txt_comm_frm19 ::</option>
        <option value='A' $t6_dtl_blood_type_chkA>A</option>
        <option value='B' $t6_dtl_blood_type_chkB>B</option>
        <option value='AB' $t6_dtl_blood_type_chkAB>AB</option>
        <option value='O' $t6_dtl_blood_type_chkO>O</option>
        </select>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-3 control-label'>$txt_tab_hr_member_0603</label>
    <div class='col-sm-3'>
		<input type='date' class='form-control' id='l-name' name='dtl_wed_date' value='$t6_dtl_wed_date'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0604</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_fn_status' value='$t6_dtl_fn_status'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0605</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_hobby' value='$t6_dtl_hobby'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0606</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_talent' value='$t6_dtl_talent'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0607 </label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_sp_gift' value='$t6_dtl_sp_gift'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0608</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_health' value='$t6_dtl_health'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0609</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_car_no' value='$t6_dtl_car_no'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0610</div>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='dtl_parking_no' value='$t6_dtl_parking_no'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='dtl_memo' class='form-control' rows=4>$t6_dtl_memo</textarea>
	</div>
</div>");




} else if($mode == "create") {

  echo ("
  <table width=100% cellspacing=0 cellpadding=0 border=0>
  <tr>
    <td height=60 align=center>
      <a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=6&class=A&mode=create&hr_type=$hr_type&hr_retire=$hr_retire'><font color=red>$txt_comm_frm331</font></a>
    </td>
  </tr>
  </table>");

} else {

  echo ("
  <table width=100% cellspacing=0 cellpadding=0 border=0>
  <tr>
    <td height=60 align=center>
      <a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=6&class=A&mode=create&hr_type=$hr_type&hr_retire=$hr_retire'><font color=#006699>$txt_comm_frm33</font></a>
    </td>
  </tr>
  </table>");

}
?>
