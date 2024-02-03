<?
$query_t5c = "SELECT count(uid) FROM member_staff_train WHERE code = '$user_code'";
$result_t5c = mysql_query($query_t5c);
  if (!$result_t5c) { error("QUERY_ERROR"); exit; }
$total_t5c = @mysql_result($result_t5c,0,0);


$query_t5_dtl = "SELECT uid,tcode,motive,fin_flag,fin_grade,fin_evalu,pastor_memo,memo,poster_id,post_date,
              tcorp_flag,tcorp_name,train_name,train_period,train_begin,train_finish,train_memo,
              eta01_evalu,eta02_evalu,eta03_evalu,eta04_evalu,eta05_evalu,eta06_evalu,eta07_evalu, 
              eta08_evalu,eta09_evalu,eta10_evalu FROM member_staff_train WHERE code = '$user_code' AND uid = '$j_uid'";
$result_t5_dtl = mysql_query($query_t5_dtl);
if (!$result_t5_dtl) { error("QUERY_ERROR"); exit; }

  $t5_dtl_uid = @mysql_result($result_t5_dtl,0,0);
  $t5_dtl_tcode = @mysql_result($result_t5_dtl,0,1);
      // 과정 이름과 기수, 시작일, 수료일 추출
      $t5J_dtl_query = "SELECT mcode,period,course_open,course_close,lecturer,trainee_type,duration,class_hours,
                        eta01_chk,eta02_chk,eta03_chk,eta04_chk,eta05_chk,eta06_chk,
                        eta07_chk,eta07_name,eta08_chk,eta08_name,eta09_chk,eta09_name,eta10_chk,eta10_name 
                        FROM dirlist_train WHERE tcode = '$t5_dtl_tcode'";
      $t5J_dtl_result = mysql_query($t5J_dtl_query);
        if (!$t5J_dtl_result) { error("QUERY_ERROR"); exit; }
      $t5_dtl_mcode = @mysql_result($t5J_dtl_result,0,0);

          $t5JS_dtl_query = "SELECT mname FROM dir6_catgmid WHERE mcode = '$t5_dtl_mcode' AND lang = '$lang'";
          $t5JS_dtl_result = mysql_query($t5JS_dtl_query);
            if (!$t5JS_dtl_result) { error("QUERY_ERROR"); exit; }
          $t5_dtl_mcode_name = @mysql_result($t5JS_dtl_result,0,0);
      
      $t5_dtl_period = @mysql_result($t5J_dtl_result,0,1);
      $course_open = @mysql_result($t5J_dtl_result,0,2);
      $course_close = @mysql_result($t5J_dtl_result,0,3);
      $lecturer = @mysql_result($t5J_dtl_result,0,4);
      $trainee_type = @mysql_result($t5J_dtl_result,0,5);
          if($trainee_type == "C") {
            $trainee_type_chkC = "checked";
            $trainee_type_chkL = "";
            $trainee_type_chkN = "";
          } else if($trainee_type == "L") {
            $trainee_type_chkC = "";
            $trainee_type_chkL = "checked";
            $trainee_type_chkN = "";
          } else if($trainee_type == "N") {
            $trainee_type_chkC = "";
            $trainee_type_chkL = "";
            $trainee_type_chkN = "checked";
          }
      $duration = @mysql_result($t5J_dtl_result,0,6);
      $class_hours = @mysql_result($t5J_dtl_result,0,7);
      
      $eta01_chk = @mysql_result($t5J_dtl_result,0,8);
      $eta01_name = "$txt_sys_tcourse_1501";
      $eta02_chk = @mysql_result($t5J_dtl_result,0,9);
      $eta02_name = "$txt_sys_tcourse_1502";
      $eta03_chk = @mysql_result($t5J_dtl_result,0,10);
      $eta03_name = "$txt_sys_tcourse_1503";
      $eta04_chk = @mysql_result($t5J_dtl_result,0,11);
      $eta04_name = "$txt_sys_tcourse_1504";
      $eta05_chk = @mysql_result($t5J_dtl_result,0,12);
      $eta05_name = "$txt_sys_tcourse_1505";
      $eta06_chk = @mysql_result($t5J_dtl_result,0,13);
      $eta06_name = "$txt_sys_tcourse_1506";
      $eta07_chk = @mysql_result($t5J_dtl_result,0,14);
      $eta07_name = @mysql_result($t5J_dtl_result,0,15);
      $eta08_chk = @mysql_result($t5J_dtl_result,0,16);
      $eta08_name = @mysql_result($t5J_dtl_result,0,17);
      $eta09_chk = @mysql_result($t5J_dtl_result,0,18);
      $eta09_name = @mysql_result($t5J_dtl_result,0,19);
      $eta10_chk = @mysql_result($t5J_dtl_result,0,20);
      $eta10_name = @mysql_result($t5J_dtl_result,0,21);
      
      

  $t5_dtl_motive = @mysql_result($result_t5_dtl,0,2);
  $t5_dtl_fin_flag = @mysql_result($result_t5_dtl,0,3);
      if($t5_dtl_fin_flag == "0") {
        $t5_dtl_fin_flag_chk0 = "checked";
        $t5_dtl_fin_flag_chk1 = "";
        $t5_dtl_fin_flag_chk2 = "";
      } else if($t5_dtl_fin_flag == "1") {
        $t5_dtl_fin_flag_chk0 = "";
        $t5_dtl_fin_flag_chk1 = "checked";
        $t5_dtl_fin_flag_chk2 = "";
      } else if($t5_dtl_fin_flag == "2") {
        $t5_dtl_fin_flag_chk0 = "";
        $t5_dtl_fin_flag_chk1 = "";
        $t5_dtl_fin_flag_chk2 = "checked";
      }
      
  $t5_dtl_fin_grade = @mysql_result($result_t5_dtl,0,4);
  $t5_dtl_fin_evalu = @mysql_result($result_t5_dtl,0,5);
  $t5_dtl_pastor_memo = @mysql_result($result_t5_dtl,0,6);
  $t5_dtl_memo = @mysql_result($result_t5_dtl,0,7);
  $t5_dtl_poster_id = @mysql_result($result_t5_dtl,0,8);
    // 기록자 이름 추출
    $t5A_query = "SELECT user_name FROM admin_user WHERE user_id = '$t5_dtl_poster_id'";
    $t5A_result = mysql_query($t5A_query);
      if (!$t5A_result) { error("QUERY_ERROR"); exit; }
      $t5_dtl_poster_name = @mysql_result($t5A_result,0,0);
    
  $t5_dtl_post_date = @mysql_result($result_t5_dtl,0,9);
    // 날짜 형식
    $p8day1 = substr($t5_dtl_post_date,0,4);
	  $p8day2 = substr($t5_dtl_post_date,4,2);
	  $p8day3 = substr($t5_dtl_post_date,6,2);
	  $p8day4 = substr($t5_dtl_post_date,8,2);
	  $p8day5 = substr($t5_dtl_post_date,10,2);
	  $p8day6 = substr($t5_dtl_post_date,12,2);

    if($lang == "ko") {
	    $t5_dtl_post_date_txt = "$p8day1"."/"."$p8day2"."/"."$p8day3".", "."$p8day4".":"."$p8day5".":"."$p8day6";
	  } else {
	    $t5_dtl_post_date_txt = "$p8day3"."-"."$p8day2"."-"."$p8day1".", "."$p8day4".":"."$p8day5".":"."$p8day6";
	  }
  
  $t5_dtl_tchurch_flag = @mysql_result($result_t5_dtl,0,10);
  $t5_dtl_tchurch_name = @mysql_result($result_t5_dtl,0,11);
  $t5_dtl_train_name = @mysql_result($result_t5_dtl,0,12);
  $t5_dtl_train_period = @mysql_result($result_t5_dtl,0,13);
  $t5_dtl_train_begin = @mysql_result($result_t5_dtl,0,14);
  $t5_dtl_train_finish = @mysql_result($result_t5_dtl,0,15);
  $t5_dtl_train_memo = @mysql_result($result_t5_dtl,0,16);
  
  $eta01_evalu = @mysql_result($result_t5_dtl,0,17);
  $eta02_evalu = @mysql_result($result_t5_dtl,0,18);
  $eta03_evalu = @mysql_result($result_t5_dtl,0,19);
  $eta04_evalu = @mysql_result($result_t5_dtl,0,20);
  $eta05_evalu = @mysql_result($result_t5_dtl,0,21);
  $eta06_evalu = @mysql_result($result_t5_dtl,0,22);
  $eta07_evalu = @mysql_result($result_t5_dtl,0,23);
  $eta08_evalu = @mysql_result($result_t5_dtl,0,24);
  $eta09_evalu = @mysql_result($result_t5_dtl,0,25);
  $eta10_evalu = @mysql_result($result_t5_dtl,0,26);
 
  
  // 작성자가 아니면 쓰기 금지
  if($mode == "add" OR $t5_dtl_poster_id == $login_id) {
    $readonly_chk = "";
  } else {
    $readonly_chk = "readonly";
  }




echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_05
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=5&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t5c > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=$tab&j_uid=$j_uid&class=A&mode=del&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");



// Review
if(($total_t5c > "0" AND ($mode == "upd" OR $mode == "del")) OR $mode == "add" OR $mode == "add2") {

echo ("
<input type=hidden name='class' value='$class'>
<input type=hidden name='mode' value='$mode'>
<input type=hidden name='j_uid' value='$t5_dtl_uid'>

<br>
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_06</label>");
	
		  if($mode == "upd" OR $mode == "del") {
          
              if($t5_dtl_tchurch_flag == "1") {
          
              echo ("
			  <div class='col-sm-2'>
				<input readonly type=text name='dis_dtl_tcode' value='$t5_dtl_tcode' class='form-control'>
			  </div>
			  <div class='col-sm-4'>
				<input readonly type=text name='dis_dtl_mcode_name' value='$t5_dtl_mcode_name' class='form-control'>
			  </div>
			  <div class='col-sm-2'>
				<input readonly type=text name='period' value='$t5_dtl_period' class='form-control'>
			  </div>");
              
              } else if($t5_dtl_tchurch_flag == "0") {
              
              echo ("
			  <div class='col-sm-4'>
				<input readonly type=text name='dtl_tchurch_name' value='$t5_dtl_tchurch_name' maxlength=60 class='form-control'>
			  </div>
			  <div class='col-sm-4'>
				<input readonly type=text name='dtl_train_name' value='$t5_dtl_train_name' maxlength=60 class='form-control'>
			  </div>");
              }
          
          } else if($mode == "add") {
          
              $query_m1c = "SELECT count(uid) FROM dirlist_train WHERE course_close > '$post_date1_dash'";
              $result_m1c = mysql_query($query_m1c);
              $total_m1c = @mysql_result($result_m1c,0,0);

              $query_m1 = "SELECT tcode,period,course_open,course_close FROM dirlist_train WHERE course_close > '$post_date1_dash' ORDER BY tcode ASC";
              $result_m1 = mysql_query($query_m1);
              
              echo("
			  <div class='col-sm-8'>
			  <select name='dtl_tcode' class='form-control'>");

              for($m1 = 0; $m1 < $total_m1c; $m1++) {
                $m1_tcode = mysql_result($result_m1,$m1,0);
                  $m1_mcode = substr($m1_tcode,2,4);
                  
                $m1_period = mysql_result($result_m1,$m1,1);
                $m1_course_open = mysql_result($result_m1,$m1,2);
                $m1_course_close = mysql_result($result_m1,$m1,3);

                $query_m2 = "SELECT mcode,mname FROM dir6_catgMID WHERE mcode = '$m1_mcode' AND lang = '$lang' ORDER BY mcode ASC";
                $result_m2 = mysql_query($query_m2);
        
                  $m2_mcode = @mysql_result($result_m2,0,0);
                  $m2_mname = @mysql_result($result_m2,0,1);
        

                echo("<option value='$m1_tcode' $slc_mcode>[ $m1_tcode ] $m2_mname $m1_period ( $m1_course_open ~ $m1_course_close )</option>");
      
              }
              echo("</select>
			  </div>");
          
          } else if($mode == "add2") {
          
              echo ("
			  <div class='col-sm-4'>
				<input type=text name='dtl_tchurch_name' value='$txt_tab_hr_member_0501' maxlength=60 class='form-control'>
			  </div>
			  <div class='col-sm-4'>
				<input type=text name='dtl_train_name' value='$t5_dtl_train_name' maxlength=60 class='form-control'>
			  </div>");
          
          }
		  
		  echo ("
</div>");



if($mode == "upd" OR $mode == "del") {

if($t5_dtl_tchurch_flag == "1") {
echo ("
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_10</label>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='lecturer' value='$lecturer'>
	</div>
	<div class='col-sm-2'>$txt_sys_tcourse_11</div>
    <div class='col-sm-4'>
		<input disabled type=radio name='trainee_type' value='C' $trainee_type_chkC> A &nbsp;&nbsp; 
        <input disabled type=radio name='trainee_type' value='L' $trainee_type_chkL> B
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_12</label>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='duration' value='$duration'>
	</div>
	<div class='col-sm-2'>$txt_sys_tcourse_13</div>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='class_hours' value='$class_hours'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_08</label>
    <div class='col-sm-4'>
		<input disabled type='date' class='form-control' id='l-name' name='course_open' value='$course_open'>
	</div>
	<div class='col-sm-2'>~ $txt_sys_tcourse_09</div>
    <div class='col-sm-4'>
		<input disabled type='date' class='form-control' id='l-name' name='course_close' value='$course_close'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0503</label>
    <div class='col-sm-8'>
		
		  <table width=464 cellspacing=0 cellpadding=0 border=0>");
          
          if($eta01_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta01_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta01_evalu' value='$eta01_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta02_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta02_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta02_evalu' value='$eta02_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta03_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta03_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta03_evalu' value='$eta03_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta04_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta04_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta04_evalu' value='$eta04_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta05_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta05_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta05_evalu' value='$eta05_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta06_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta06_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta06_evalu' value='$eta06_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta07_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta07_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta07_evalu' value='$eta07_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta08_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta08_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta08_evalu' value='$eta08_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta09_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta09_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta09_evalu' value='$eta09_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }
          
          if($eta10_chk == "1") { echo ("
            <tr>
              <td height=20 width=160 bgcolor=#EFEFEF align=right>$eta10_name &nbsp;&nbsp;</td>
              <td width=4></td>
              <td width=300><input $readonly_chk type=text name='eta10_evalu' value='$eta10_evalu' maxlength=60 style='$style_box; WIDTH: 180px'></td>
            </tr>
            <tr><td colspan=3 height=4></td></tr>");
          }

          echo ("
          </table>
		
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0504</label>
    <div class='col-sm-8'>
		<input type=radio name='dtl_fin_flag' value='0' $t5_dtl_fin_flag_chk0> $txt_tab_hr_member_05040 &nbsp;&nbsp; 
        <input type=radio name='dtl_fin_flag' value='1' $t5_dtl_fin_flag_chk1> $txt_tab_hr_member_05041 &nbsp;&nbsp; 
        <input type=radio name='dtl_fin_flag' value='2' $t5_dtl_fin_flag_chk2> $txt_tab_hr_member_05042
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0506</label>
    <div class='col-sm-4'>
		<input $readonly_chk type='text' class='form-control' id='l-name' name='dtl_fin_grade' value='$t5_dtl_fin_grade'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0507</div>
    <div class='col-sm-4'>
		<input $readonly_chk type='text' class='form-control' id='l-name' name='dtl_fin_evalu' value='$t5_dtl_fin_evalu'>
	</div>
</div>");

} else if($t5_dtl_tchurch_flag == "0") {

echo ("
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_08</label>
    <div class='col-sm-4'>
		<input type='date' class='form-control' id='l-name' name='dtl_train_begin' value='$t5_dtl_train_begin'>
	</div>
	<div class='col-sm-2'>~ $txt_sys_tcourse_09</div>
    <div class='col-sm-4'>
		<input type='date' class='form-control' id='l-name' name='dtl_train_finish' value='$t5_dtl_train_finish'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_tcourse_12</label>
    <div class='col-sm-4'>
		<input $readonly_chk type='date' class='form-control' id='l-name' name='dtl_train_period' value='$t5_dtl_train_period'>
	</div>
	<div class='col-sm-2'>$txt_tab_hr_member_0508</div>
    <div class='col-sm-4'>
		<input $readonly_chk type='date' class='form-control' id='l-name' name='dtl_train_memo' value='$t5_dtl_train_memo'>
	</div>
</div>");

}



if($mode == "upd" OR $mode == "del") {

echo ("
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_member_0805</label>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='dis_dtl_post_date_txt' value='$t5_dtl_post_date_txt'>
	</div>
	<div class='col-sm-2'>$txt_tab_member_0806</div>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='dis_dtl_poster_name' value='$t5_dtl_poster_name'>
	</div>
</div>");

}


echo ("
<input type=hidden name='dtl_poster_id' value='$t5_dtl_poster_id'>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_tab_hr_member_0509</label>
    <div class='col-sm-8'>
		<textarea $readonly_chk name='dtl_pastor_memo' class='form-control' rows=4>$t5_dtl_pastor_memo</textarea>
	</div>
</div>");

}

echo ("
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='dtl_memo' class='form-control' rows=4>$t5_dtl_memo</textarea>
	</div>
</div>");

}





if($total_t5c > "0") {

echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_tab_hr_member_0502</th>
    <th>$txt_sys_tcourse_06 ($txt_sys_tcourse_06)</th>
    <th>$txt_sys_tcourse_08</th>
	<th>$txt_sys_tcourse_09</th>
	<th>$txt_tab_hr_member_0504</th>
	<th>$txt_tab_hr_member_0507</th>
</tr>
</thead>
		
		
<tbody>");



$query_t5 = "SELECT uid,tcorp_flag,tcorp_name,train_name,train_period,train_begin,train_finish,train_memo,
            tcode,fin_flag,poster_id,post_date,fin_evalu FROM member_staff_train WHERE code = '$user_code' 
            ORDER BY tcorp_flag ASC, tcode ASC, post_date ASC";
$result_t5 = mysql_query($query_t5);
  if (!$result_t5) { error("QUERY_ERROR"); exit; }   

for($t5 = 0; $t5 < $total_t5c; $t5++) {

  $t5_uid = mysql_result($result_t5,$t5,0);
  $t5_tchurch_flag = mysql_result($result_t5,$t5,1);
  $t5_tchurch_name = mysql_result($result_t5,$t5,2);
  $t5_train_name = mysql_result($result_t5,$t5,3);
  $t5_train_period = mysql_result($result_t5,$t5,4);
  $t5_train_begin = mysql_result($result_t5,$t5,5);
  $t5_train_finish = mysql_result($result_t5,$t5,6);
  $t5_train_memo = mysql_result($result_t5,$t5,7);
  
  $t5_tcode = mysql_result($result_t5,$t5,8);
      // 과정 이름과 기수, 시작일, 수료일 추출
      $t5C_query = "SELECT mcode,period,course_open,course_close FROM dirlist_train WHERE tcode = '$t5_tcode'";
      $t5C_result = mysql_query($t5C_query);
        if (!$t5C_result) { error("QUERY_ERROR"); exit; }
      $t5_mcode = @mysql_result($t5C_result,0,0);
      $t5_mcode2 = substr($t5_tcode,2,4);

          $t5CS_query = "SELECT mname FROM dir6_catgmid WHERE mcode = '$t5_mcode2' AND lang = '$lang'";
          $t5CS_result = mysql_query($t5CS_query);
            if (!$t5CS_result) { error("QUERY_ERROR"); exit; }
          $t5_mcode_name = @mysql_result($t5CS_result,0,0);
      
      $t5_period = @mysql_result($t5C_result,0,1);
      $t5_course_open = @mysql_result($t5C_result,0,2);
      $t5_course_close = @mysql_result($t5C_result,0,3);
  
  $t5_fin_flag = mysql_result($result_t5,$t5,9);
      if($t5_fin_flag == "0") {
        $t5_fin_flag_txt = "$txt_tab_hr_member_05040";
      } else if($t5_fin_flag == "1") {
        $t5_fin_flag_txt = "$txt_tab_hr_member_05041";
      } else if($t5_fin_flag == "2") {
        $t5_fin_flag_txt = "$txt_tab_hr_member_05042";
      }
  
  $t5_poster_id = mysql_result($result_t5,$t5,10);
      // 기록자 이름 추출
      $t5B_query = "SELECT user_name FROM admin_user WHERE user_id = '$t5_poster_id'";
      $t5B_result = mysql_query($t5B_query);
        if (!$t5B_result) { error("QUERY_ERROR"); exit; }
      $t5_poster_name = @mysql_result($t5B_result,0,0);
  $t5_pow_date = mysql_result($result_t5,$t5,11);
    $pow_day1 = substr($t5_pow_date,0,4);
	  $pow_day2 = substr($t5_pow_date,4,2);
	  $pow_day3 = substr($t5_pow_date,6,2);
	  $pow_day4 = substr($t5_pow_date,8,2);
	  $pow_day5 = substr($t5_pow_date,10,2);
	  
	  if($lang == "ko") {
	    $pow_date_txt = "$pow_day1"."/"."$pow_day2"."/"."$pow_day3".", "."$pow_day4".":"."$pow_day5";
	  } else {
	    $pow_date_txt = "$pow_day3"."-"."$pow_day2"."-"."$pow_day1".", "."$pow_day4".":"."$pow_day5";
	  }

  $t5_fin_evalu = mysql_result($result_t5,$t5,12);
  
  // 출력 내용
  if($t5_tchurch_flag == "1") {
    $t5R_church_name = "-";
    $t5R_train_name = "[$t5_mcode] $t5_mcode_name $t5_period";
    $t5R_train_begin = "$t5_course_open";
    $t5R_train_finish = "$t5_course_close";
    $t5R_train_fin_ok = "$t5_fin_flag_txt";
    $t5R_train_fin_evalu = "$t5_fin_evalu";
  } else if($t5_tchurch_flag == "0") {
    $t5R_church_name = "$t5_tchurch_name";
    $t5R_train_name = "$t5_train_name $t5_train_period";
    $t5R_train_begin = "$t5_train_begin";
    $t5R_train_finish = "$t5_train_finish";
    $t5R_train_fin_ok = "$txt_tab_hr_member_05042";
    $t5R_train_fin_evalu = "$t5_train_memo";
  }
  
  
  $total_t5cm = $total_t5c - 1;
  
  // 선택된 항목
  if(!$j_uid) {
    if($t8 == $total_t5cm) {
      $t5_td_color = "#FAFAB4";
    } else {
      $t5_td_color = "#FFFFFF";
    }
  } else {
    if($t5_uid == $j_uid) {
      $t5_td_color = "#FAFAB4";
    } else {
      $t5_td_color = "#FFFFFF";
    }
  }
  
  echo ("
  <tr height=22>
    <td bgcolor='$t5_td_color'>$t5R_church_name</td>
    <td bgcolor='$t5_td_color'><a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=5&j_uid=$t5_uid&class=A&mode=upd&hr_type=$hr_type&hr_retire=$hr_retire'>$t5R_train_name</a></td>
    <td bgcolor='$t5_td_color'>$t5R_train_begin</td>
    <td bgcolor='$t5_td_color'>$t5R_train_finish</td>
    <td bgcolor='$t5_td_color'>$t5R_train_fin_ok</td>
    <td bgcolor='$t5_td_color'>$t5R_train_fin_evalu</td>
  </tr>");
}


}
echo ("
</tbody>
</table>
<section>");
?>
