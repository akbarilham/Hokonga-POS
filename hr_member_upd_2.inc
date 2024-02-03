<?



echo ("
<header class='panel-heading'>
	$txt_tab_hr_member_02
	<span class='tools pull-right'>
		<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=2&class=A&mode=add&hr_type=$hr_type&hr_retire=$hr_retire' class='fa fa-pencil'></a>");
		
		if($total_t2c > "0" AND $j_uid) {
			echo ("<a href='hr_member_upd.php?uid=$staff_uid&mb_level=$mb_level&tab=2&j_uid=$j_uid&class=A&mode=del' class='fa fa-trash-o'></a>");
		}
		echo ("
		<a href=\"javascript:;\" class='fa fa-chevron-down'></a>
	</span>
</header>");



echo ("
<section id='unseen'>
<table class='table table-bordered table-condensed'>
<thead>
<tr>
    <th>$txt_hr_member_331</th>
    <th>$txt_tab_hr_member_0201</th>
    <th>$txt_stf_staff_08</th>
	<th>$txt_stf_staff_09</th>
	<th>$txt_tab_hr_member_0202</th>
	<th>$txt_hr_member_32</th>
	<th>$txt_tab_hr_member_03</th>
	<th>$txt_tab_hr_member_0203</th>
	<th>$txt_tab_hr_member_04</th>
</tr>
</thead>
		
		
<tbody>");


if($fam_code == "" OR !$fam_code) {
  $fam_code = "Unlinked";
}

if($fam_head == "1") {
  $query_t2c = "SELECT count(uid) FROM member_main WHERE code = '$user_code' OR fam_code = '$user_code'";
} else {
  $query_t2c = "SELECT count(uid) FROM member_main WHERE code = '$user_code' OR code = '$fam_code' OR fam_code = '$fam_code'";
}

$result_t2c = mysql_query($query_t2c);
$total_t2c = @mysql_result($result_t2c,0,0);

if($fam_head == "1") {
  $query_t2 = "SELECT code,fam_head,name,gender,fam_degree,fam_degree2,birthday,job2,corp_name,group1_code,
            dir2_code,edu_degree,faith_level,regis_date,religion,uid,age_group,spouse_link,marital_status,
            expel_date,expel_reason,passing_date,userlevel 
            FROM member_main WHERE code = '$user_code' OR fam_code = '$user_code' 
            ORDER BY birthday ASC, signdate ASC";
} else {
  $query_t2 = "SELECT code,fam_head,name,gender,fam_degree,fam_degree2,birthday,job2,corp_name,group1_code,
            dir2_code,edu_degree,faith_level,regis_date,religion,uid,age_group,spouse_link,marital_status,
            expel_date,expel_reason,passing_date,userlevel 
            FROM member_main WHERE code = '$user_code' OR code = '$fam_code' OR fam_code = '$fam_code' 
            ORDER BY birthday ASC, signdate ASC";
}

$result_t2 = mysql_query($query_t2);

for($t2 = 0; $t2 < $total_t2c; $t2++) {

  $t2_user_code = mysql_result($result_t2,$t2,0);
  $t2_fam_head = mysql_result($result_t2,$t2,1);
    if($t2_fam_head == "1") {
      $t2_fam_head_chk = "checked";
    } else if($t2_fam_head == "0") {
      $t2_fam_head_chk = "";
    }
    
    $t2_fam_head_code = "$t2_fam_head"."_"."$t2_user_code";
  $t2_name = mysql_result($result_t2,$t2,2);
  $t2_gender = mysql_result($result_t2,$t2,3);
    if($t2_gender == "M") {
      $t2_gender_txt = "$txt_stf_staff_10";
    } else if($t2_gender == "F") {
      $t2_gender_txt = "$txt_stf_staff_11";
    }
  $t2_fam_degree = mysql_result($result_t2,$t2,4);
  $t2_fam_degree2 = mysql_result($result_t2,$t2,5);
  $t2_birthday = mysql_result($result_t2,$t2,6);
    $t2_birth1 = substr($t2_birthday,0,4);
    $t2_birth2 = substr($t2_birthday,4,2);
    $t2_birth3 = substr($t2_birthday,6,2);
    
    if($lang == "ko") {
      $t2_birthday_txt = "$t2_birth1"."/"."$t2_birth2"."/"."$t2_birth3";
    } else {
      $t2_birthday_txt = "$t2_birth3"."-"."$t2_birth2"."-"."$t2_birth1";
    }
    
    // 나이 계산
    $t2_age = $post_year - $t2_birth1;
    
  $t2_job2 = mysql_result($result_t2,$t2,7);
  $t2_corp_name = mysql_result($result_t2,$t2,8);
  $t2_group1_code = mysql_result($result_t2,$t2,9);
  $t2_dir2_code = mysql_result($result_t2,$t2,10);
  $t2_edu_degree = mysql_result($result_t2,$t2,11);
  $t2_faith_level = mysql_result($result_t2,$t2,12);
    if($t2_faith_level == "1") {
      $t2_faith_level_txt = "$txt_hr_member_372";
    } else if($t2_faith_level == "2") {
      $t2_faith_level_txt = "$txt_hr_member_373";
    } else if($t2_faith_level == "3") {
      $t2_faith_level_txt = "$txt_hr_member_376";
    } else if($t2_faith_level == "4") {
      $t2_faith_level_txt = "$txt_hr_member_374";
    } else if($t2_faith_level == "5") {
      $t2_faith_level_txt = "$txt_hr_member_371";
    } else if($t2_faith_level == "6") {
      $t2_faith_level_txt = "$txt_hr_member_375";
    } else {
      $t2_faith_level_txt = "&nbsp;";
    }
  $t2_regisday = mysql_result($result_t2,$t2,13);
    $t2_regis1 = substr($t2_regisday,0,4);
    $t2_regis2 = substr($t2_regisday,4,2);
    $t2_regis3 = substr($t2_regisday,6,2);
    
    if($lang == "ko") {
      $t2_regisday_txt = "$t2_regis1"."/"."$t2_regis2"."/"."$t2_regis3";
    } else {
      $t2_regisday_txt = "$t2_regis3"."-"."$t2_regis2"."-"."$t2_regis1";
    }
    
  $t2_religion = mysql_result($result_t2,$t2,14);
  $t2_uid = mysql_result($result_t2,$t2,15);
  $t2_age_group = mysql_result($result_t2,$t2,16);
    if($t2_age_group == "8") {
      $t2_age_group_txt = "$txt_hr_member_341";
    } else if($t2_age_group == "7") {
      $t2_age_group_txt = "$txt_hr_member_342";
    } else if($t2_age_group == "6") {
      $t2_age_group_txt = "$txt_hr_member_343";
    } else if($t2_age_group == "5") {
      $t2_age_group_txt = "$txt_hr_member_344";
    } else if($t2_age_group == "4") {
      $t2_age_group_txt = "$txt_hr_member_345";
    } else if($t2_age_group == "0") {
      $t2_age_group_txt = "$txt_hr_member_346";
    } else {
      $t2_age_group_txt = "&nbsp;";
    }
  $t2_spouse_link = mysql_result($result_t2,$t2,17);
    if($t2_fam_head == "1") {
          $t2_fam_relv_txt = "$txt_hr_member_331";
    } else {
      if($t2_spouse_link == "1") {
        if($t2_gender == "M") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0210M";
        } else if($t2_gender == "F") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0210F";
        }
      } else {
        if($t2_fam_degree == "1") {
          if($t2_gender == "M") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0211M";
          } else if($t2_gender == "F") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0211F";
          }
        } else if($t2_fam_degree == "2") {
          if($t2_gender == "M") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0212M";
          } else if($t2_gender == "F") {
            $t2_fam_relv_txt = "$txt_tab_hr_member_0212F";
          }
        } else if($t2_fam_degree == "9") {
            $t2_fam_relv_txt = "$t2_fam_degree2";
        } else if($t2_fam_degree == "") {
            $t2_fam_relv_txt = "$t2_fam_degree2";
        }
      }
    }
  $t2_marital_status = mysql_result($result_t2,$t2,18);
    if($t2_marital_status == "1") {
      $t2_marital_status_txt = "$txt_hr_member_321";
    } else if($t2_marital_status == "2") {
      $t2_marital_status_txt = "$txt_hr_member_322";
    } else if($t2_marital_status == "3") {
      $t2_marital_status_txt = "$txt_hr_member_323";
    } else if($t2_marital_status == "4") {
      $t2_marital_status_txt = "$txt_hr_member_324";
    } else if($t2_marital_status == "5") {
      $t2_marital_status_txt = "$txt_hr_member_325";
    } else {
      $t2_marital_status_txt = "&nbsp;";
    }
  
  $t2_expel_date = mysql_result($result_t2,$t2,19);
  $t2_expel_reason = mysql_result($result_t2,$t2,20);
    if($t2_expel_reason == "9") {
      $t2_expel_reason_tag = "<i class='fa fa-bookmark'></i>";
    } else {
      $t2_expel_reason_tag = "";
    }
  $t2_passing_date = mysql_result($result_t2,$t2,21);
  $t2_userlevel = mysql_result($result_t2,$t2,22);

  
  // 직분명
  $t21_query = "SELECT job_name FROM code_job2 WHERE job_code = '$t2_job2' AND lang = '$lang'";
  $t21_result = mysql_query($t21_query);
    if (!$t21_result) { error("QUERY_ERROR"); exit; }
  $t21_job2_name = @mysql_result($t21_result,0,0);
  
  // 직장/학교
  $t22_query = "SELECT corp_name FROM member_staff_job WHERE code = '$t2_user_code' ORDER BY work_in DESC, uid DESC";
  $t22_result = mysql_query($t22_query);
    if (!$t22_result) { error("QUERY_ERROR"); exit; }
  $t22_corp_name = @mysql_result($t22_result,0,0);
  
  $t23_query = "SELECT sch_name,sch_catg FROM member_staff_school WHERE code = '$t2_user_code' ORDER BY sch_in DESC, uid DESC";
  $t23_result = mysql_query($t23_query);
    if (!$t23_result) { error("QUERY_ERROR"); exit; }
  $t23_sch_name = @mysql_result($t23_result,0,0);
  $t23_sch_catg = @mysql_result($t23_result,0,1);
  
  if($t2_age < "19" AND !$t22_corp_name) {
    $t2_jobsch_name = "$t23_sch_name";
  } else {
    $t2_jobsch_name = "$t22_corp_name";
  }
  
  
  // 학력
    if($t23_sch_catg == "1") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03531";
    } else if($t23_sch_catg == "2") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03532";
    } else if($t23_sch_catg == "3") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03533";
    } else if($t23_sch_catg == "4") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03534";
    } else if($t23_sch_catg == "5") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03535";
    } else if($t23_sch_catg == "6") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03536";
    } else if($t23_sch_catg == "7") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03537";
    } else if($t23_sch_catg == "8") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03538";
    } else if($t23_sch_catg == "9") {
      $t23_sch_catg_txt = "$txt_tab_hr_member_03539";
    } else {
      $t23_sch_catg_txt = "&nbsp;";
    }
  
  
  // 종교
  $t24_query = "SELECT religion,religion2 FROM member_staff_religion WHERE code = '$t2_user_code' ORDER BY relg_in DESC, uid DESC";
  $t24_result = mysql_query($t24_query);
    if (!$t24_result) { error("QUERY_ERROR"); exit; }
  $t24_religion = @mysql_result($t24_result,0,0);
  $t24_religion2 = @mysql_result($t24_result,0,1);
  
    if($t24_religion == "1") {
      $t24_religion_txt = "$txt_tab_hr_member_0401";
    } else if($t24_religion == "2") {
      $t24_religion_txt = "$txt_tab_hr_member_0402";
    } else if($t24_religion == "3") {
      $t24_religion_txt = "$txt_tab_hr_member_0403";
    } else if($t24_religion == "4") {
      $t24_religion_txt = "$txt_tab_hr_member_0404";
    } else if($t24_religion == "5") {
      $t24_religion_txt = "$txt_tab_hr_member_0405";
    } else if($t24_religion == "9") {
      $t24_religion_txt = "$t24_religion2";
    } else {
      $t24_religion_txt = "&nbsp;";
    }

  
  
  // 본인인 경우
  if($t2_user_code == $user_code) {
    $t2_td_color = "#FAFAB4";
  } else {
    $t2_td_color = "#FFFFFF";
  }
  
  // 제적자인 경우
  if($t2_userlevel < "2") {
    $t2_font_color = "#666666";
  } else {
    $t2_font_color = "#000000";
  }
  
  
  echo ("
  <tr>
    <td bgcolor='$t2_td_color'><input type=radio name='fam_head_select' value='$t2_user_code' $t2_fam_head_chk></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_fam_relv_txt</font></td>
    <td bgcolor='$t2_td_color'>$t2_expel_reason_tag<a href='hr_member_upd.php?uid=$t2_uid&&mb_level=$mb_level&tab=2&hr_type=$hr_type&hr_retire=$hr_retire'><font color='$t2_font_color'>{$t2_name}</font></a></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_gender_txt</font></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_age</font></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_marital_status_txt</font></td>

    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_jobsch_name</font></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t23_sch_catg_txt</font></td>
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t2_faith_level_txt</font></td>
    
    <td bgcolor='$t2_td_color'><font color='$t2_font_color'>$t24_religion_txt</font></td>
  </tr>");
}
?>
</tbody>
</table>
<section>
