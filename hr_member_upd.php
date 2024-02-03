<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "hr";
$smenu = "hr_member";

if(!$step_next) {

$query = "SELECT uid,org_uid,org_db,sync_date,sync_on,branch_code,ctr_branch_code,gate,name,name2,code,id,
          birthday,calendar,gender,email,homepage,job_class,job1,job2,job,pay_class,payroll_code,deduction_code,corp_name,corp_dept_code,corp_dept,corp_title,corp_desc,
          zipcode,addr1,addr2,phone,phone_cel,phone_fax,mlist,m_ip,memo,userlevel,signdate,paydate,
          shop_point,counter,country_code,mb_type,reseller,photo1,photo2,crmflag,log_in,log_out,
          visit,lang,bank_name,acct_name,acct_no,uncoll,nationality_code,visa_type,passport_no,passport_expire,
          marital_status,spouse_link,spouse_code,spouse_name,fam_head,fam_code,fam_degree,fam_degree2,age_group,
          dir1_code,dir2_code,dir3_code,group1_code,group2_code,group3_code,regis_date,enter_date,baptism_date,baptism_church,faith_level,
          upd_id,upd_ip,upd_date,expel_date,expel_reason,expel_reason2,passing_date,guide,religion,idcard_no,fam_child,temp FROM member_staff WHERE uid = '$uid'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$staff_uid = $row->uid;
$org_uid = $row->org_uid;
$org_db = $row->org_db;
$sync_date = $row->sync_date;
$sync_on = $row->sync_on;
  if($sync_on == "2") {
    $sync_on_txt = "<font color=green>$txt_hr_member_12</font>";
  } else if($sync_on == "1") {
    $sync_on_txt = "<font color=blue>$txt_hr_member_11</font>";
  } else {
    $sync_on_txt = "$txt_hr_member_10";
  }
$branch_code = $row->branch_code;
$ctr_branch_code = $row->ctr_branch_code;
$user_gate = $row->gate;
$user_name = $row->name;
$user_name2 = $row->name2;
$user_code = $row->code;
$user_id = $row->id;
$birth_date = $row->birthday;
  $birthyear = substr($birth_date,0,4);
  $birthmonth = substr($birth_date,4,2);
    $birthmonth1 = substr($birth_date,4,1);
    $birthmonth2 = substr($birth_date,5,1);
  $birthday = substr($birth_date,6,2);
    $birthday1 = substr($birth_date,6,1);
    $birthday2 = substr($birth_date,7,1);
  $birth_dates = "$birthyear"."-"."$birthmonth"."-"."$birthday";
  
  if($lang == "ko") {
	  $birth_dates_txt = "$birthyear"."/"."$birthmonth"."/"."$birthday";
  } else {
	  $birth_dates_txt = "$birthday"."-"."$birthmonth"."-"."$birthyear";
  }
  
  if($birthmonth1 == "0") {
    $birth_m = $birthmonth2;
  } else {
    $birth_m = $birthmonth;
  }
  if($birthday1 == "0") {
    $birth_d = $birthday2;
  } else {
    $birth_d = $birthday;
  }
$calendar = $row->calendar;
  if($calendar == "S") {
    $calendar_chkS = "checked";
    $calendar_chkL = "";
  } else if($calendar == "L") {
    $calendar_chkS = "";
    $calendar_chkL = "checked";
  }
$gender = $row->gender;
  if($gender == "M") {
    $gender_chkM = "checked";
    $gender_chkF = "";
  } else if($gender == "F") {
    $gender_chkM = "";
    $gender_chkF = "checked";
  }
$email = $row->email;
$homepage = $row->homepage;
$job_class = $row->job_class;
$job1 = $row->job1;
$job2 = $row->job2;
$job = $row->job;
$pay_class = $row->pay_class;
$payroll_code = $row->payroll_code;
$deduction_code = $row->deduction_code;
$corp_name = $row->corp_name;
$corp_dept_code = $row->corp_dept_code;
$corp_dept = $row->corp_dept;
$corp_title = $row->corp_title;
$corp_desc = $row->corp_desc;
  $corp_desc = stripslashes($corp_desc);
$zipcode = $row->zipcode;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$phone = $row->phone;
$phone_cel = $row->phone_cel;
$phone_fax = $row->phone_fax;
$mlist = $row->mlist;
  if($mlist == "0") {
    $mlist_chk1 = "";
    $mlist_chk0 = "checked";
  } else {
    $mlist_chk1 = "checked";
    $mlist_chk0 = "";
  }
$m_ip = $row->m_ip;
$memo = $row->memo;
  $memo = stripslashes($memo);
$userlevel = $row->userlevel;
$signdate = $row->signdate;

    $pday1 = substr($signdate,0,4);
	  $pday2 = substr($signdate,4,2);
	  $pday3 = substr($signdate,6,2);
	  $pday4 = substr($signdate,8,2);
	  $pday5 = substr($signdate,10,2);
	  $pday6 = substr($signdate,12,2);

    if($lang == "ko") {
	    $signdate_txt = "$pday1"."/"."$pday2"."/"."$pday3".", "."$pday4".":"."$pday5".":"."$pday6";
	  } else {
	    $signdate_txt = "$pday3"."-"."$pday2"."-"."$pday1".", "."$pday4".":"."$pday5".":"."$pday6";
	  }
  
$paydate = $row->paydate;
$shop_point = $row->shop_point;
$counter = $row->counter;
$country_code = $row->country_code;
  if($country_code == "in") {
    $country_code_chk_in = "selected";
    $country_code_chk_ml = "";
    $country_code_chk_sg = "";
    $country_code_chk_au = "";
    $country_code_chk_ko = "";
  } else if($country_code == "ml") {
    $country_code_chk_in = "";
    $country_code_chk_ml = "selected";
    $country_code_chk_sg = "";
    $country_code_chk_au = "";
    $country_code_chk_ko = "";
  } else if($country_code == "sg") {
    $country_code_chk_in = "";
    $country_code_chk_ml = "";
    $country_code_chk_sg = "selected";
    $country_code_chk_au = "";
    $country_code_chk_ko = "";
  } else if($country_code == "au") {
    $country_code_chk_in = "";
    $country_code_chk_ml = "";
    $country_code_chk_sg = "";
    $country_code_chk_au = "selected";
    $country_code_chk_ko = "";
  } else if($country_code == "ko") {
    $country_code_chk_in = "";
    $country_code_chk_ml = "";
    $country_code_chk_sg = "";
    $country_code_chk_au = "";
    $country_code_chk_ko = "selected";
  }
$mb_type = $row->mb_type;
$reseller = $row->reseller;
  if($reseller == "1") {
    $reseller_chk0 = "";
    $reseller_chk1 = "checked";
  } else {
    $reseller_chk0 = "checked";
    $reseller_chk1 = "";
  }
$photo1 = $row->photo1;
  
$photo2 = $row->photo2;
  if($photo2 == "none" OR $photo2 == "") {
    $photo_img2 = "img/User_Photo_"."$gender".".png";
    $photo_img2_txt = "";
  } else {
    $photo_img2 = "user_file/$photo2";
    $photo_img2_txt = "<font color=blue>O</font>";
  }
$crmflag = $row->crmflag;
$log_in = $row->log_in;
$log_out = $row->log_out;
$visit = $row->visit;
$join_lang = $row->lang;
$bank_name = $row->bank_name;
$acct_name = $row->acct_name;
$acct_no = $row->acct_no;
$uncoll = $row->uncoll;
  if($uncoll == "1") {
    $uncoll_chk = "checked";
  } else {
    $uncoll_chk = "";
  }
$nationality_code = $row->nationality_code;
if($nationality_code == "in") {
    $nationality_code_chk_in = "selected";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "ml") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "selected";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "sg") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "selected";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "au") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "selected";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "ko") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "selected";
  }
$visa_type = $row->visa_type;
$passport_no = $row->passport_no;
$passport_expire = $row->passport_expire;
$marital_status = $row->marital_status;
  if($marital_status == "1") {
    $marital_status_chk_1 = "selected";
    $marital_status_chk_2 = "";
    $marital_status_chk_3 = "";
    $marital_status_chk_4 = "";
    $marital_status_chk_5 = "";
  } else if($marital_status == "2") {
    $marital_status_chk_1 = "";
    $marital_status_chk_2 = "selected";
    $marital_status_chk_3 = "";
    $marital_status_chk_4 = "";
    $marital_status_chk_5 = "";
  } else if($marital_status == "3") {
    $marital_status_chk_1 = "";
    $marital_status_chk_2 = "";
    $marital_status_chk_3 = "selected";
    $marital_status_chk_4 = "";
    $marital_status_chk_5 = "";
  } else if($marital_status == "4") {
    $marital_status_chk_1 = "";
    $marital_status_chk_2 = "";
    $marital_status_chk_3 = "";
    $marital_status_chk_4 = "selected";
    $marital_status_chk_5 = "";
  } else if($marital_status == "5") {
    $marital_status_chk_1 = "";
    $marital_status_chk_2 = "";
    $marital_status_chk_3 = "";
    $marital_status_chk_4 = "";
    $marital_status_chk_5 = "selected";
  }
$spouse_link = $row->spouse_link;
  if($spouse_link == "1") {
    $spouse_link_chk = "checked";
  } else {
    $spouse_link_chk = "";
  }
$spouse_code = $row->spouse_code;
$spouse_name = $row->spouse_name;
$fam_head = $row->fam_head;
  if($fam_head == "0") {
    $fam_head_chk_0 = "selected";
    $fam_head_chk_1 = "";
    $fam_head_chk_2 = "";
  } else if($fam_head == "1") {
    $fam_head_chk_0 = "";
    $fam_head_chk_1 = "selected";
    $fam_head_chk_2 = "";
  } else if($fam_head == "2") {
    $fam_head_chk_0 = "";
    $fam_head_chk_1 = "";
    $fam_head_chk_2 = "selected";
  }
$fam_code = $row->fam_code;
$fam_degree = $row->fam_degree;
  if($fam_degree == "1") {
    $fam_degree_chk1 = "selected";
    $fam_degree_chk2 = "";
    $fam_degree_chk9 = "";
  } else if($fam_degree == "2") {
    $fam_degree_chk1 = "";
    $fam_degree_chk2 = "selected";
    $fam_degree_chk9 = "";
  } else if($fam_degree == "9") {
    $fam_degree_chk1 = "";
    $fam_degree_chk2 = "";
    $fam_degree_chk9 = "selected";
  }
$fam_degree2 = $row->fam_degree2;
$age_group = $row->age_group;
  if($age_group == "0") {
    $age_group_chk_0 = "selected";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "1") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "selected";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "2") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "selected";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "3") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "selected";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "4") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "selected";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "5") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "selected";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "6") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "selected";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "7") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "selected";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "";
  } else if($age_group == "8") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "selected";
    $age_group_chk_9 = "";
  } else if($age_group == "9") {
    $age_group_chk_0 = "";
    $age_group_chk_1 = "";
    $age_group_chk_2 = "";
    $age_group_chk_3 = "";
    $age_group_chk_4 = "";
    $age_group_chk_5 = "";
    $age_group_chk_6 = "";
    $age_group_chk_7 = "";
    $age_group_chk_8 = "";
    $age_group_chk_9 = "selected";
  }
$dir1_code = $row->dir1_code;
$dir2_code = $row->dir2_code;
$dir3_code = $row->dir3_code;
$group1_code = $row->group1_code;
$group2_code = $row->group2_code;
$group3_code = $row->group3_code;
$regis_date = $row->regis_date;
  $regisyear = substr($regis_date,0,4);
  $regismonth = substr($regis_date,4,2);
    $regismonth1 = substr($regis_date,4,1);
    $regismonth2 = substr($regis_date,5,1);
  $regisday = substr($regis_date,6,2);
    $regisday1 = substr($regis_date,6,1);
    $regisday2 = substr($regis_date,7,1);
  
  if($regismonth1 == "0") {
    $regis_m = $regismonth2;
  } else {
    $regis_m = $regismonth;
  }
  if($regisday1 == "0") {
    $regis_d = $regisday2;
  } else {
    $regis_d = $regisday;
  }
$enter_date = $row->enter_date;
$baptism_date = $row->baptism_date;
$baptism_church = $row->baptism_church;
$faith_level = $row->faith_level;
  if($faith_level == "0") {
    $faith_level_chk_0 = "selected";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "1") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "selected";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "2") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "selected";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "3") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "selected";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "4") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "selected";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "5") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "selected";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "";
  } else if($faith_level == "6") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "selected";
    $faith_level_chk_7 = "";
  } else if($faith_level == "7") {
    $faith_level_chk_0 = "";
    $faith_level_chk_1 = "";
    $faith_level_chk_2 = "";
    $faith_level_chk_3 = "";
    $faith_level_chk_4 = "";
    $faith_level_chk_5 = "";
    $faith_level_chk_6 = "";
    $faith_level_chk_7 = "selected";
  }
$upd_id = $row->upd_id;
$upd_ip = $row->upd_ip;
$upd_date = $row->upd_date;

    $uday1 = substr($upd_date,0,4);
	  $uday2 = substr($upd_date,4,2);
	  $uday3 = substr($upd_date,6,2);
	  $uday4 = substr($upd_date,8,2);
	  $uday5 = substr($upd_date,10,2);
	  $uday6 = substr($upd_date,12,2);

    if($lang == "ko") {
	    $upd_date_txt = "$uday1"."/"."$uday2"."/"."$uday3".", "."$uday4".":"."$uday5".":"."$uday6";
	  } else {
	    $upd_date_txt = "$uday3"."-"."$uday2"."-"."$uday1".", "."$uday4".":"."$uday5".":"."$uday6";
	  }


$expel_date = $row->expel_date;
$expel_reason = $row->expel_reason;
if($expel_reason == "1") {
  $expel_reason_chk1 = "checked";
  $expel_reason_chk9 = "";
} else if($expel_reason == "9") {
  $expel_reason_chk1 = "";
  $expel_reason_chk9 = "checked";
}
$expel_reason2 = $row->expel_reason2;
$passing_date = $row->passing_date;
$guide = $row->guide;
$main_religion = $row->religion;

	if($main_religion == "1") {
      $main_religion_chk_1 = "selected";
      $main_religion_chk_2 = "";
      $main_religion_chk_3 = "";
      $main_religion_chk_4 = "";
      $main_religion_chk_5 = "";
      $main_religion_chk_9 = "";
    } else if($main_religion == "2") {
      $main_religion_chk_1 = "";
      $main_religion_chk_2 = "selected";
      $main_religion_chk_3 = "";
      $main_religion_chk_4 = "";
      $main_religion_chk_5 = "";
      $main_religion_chk_9 = "";
    } else if($main_religion == "3") {
      $main_religion_chk_1 = "";
      $main_religion_chk_2 = "";
      $main_religion_chk_3 = "selected";
      $main_religion_chk_4 = "";
      $main_religion_chk_5 = "";
      $main_religion_chk_9 = "";
    } else if($main_religion == "4") {
      $main_religion_chk_1 = "";
      $main_religion_chk_2 = "";
      $main_religion_chk_3 = "";
      $main_religion_chk_4 = "selected";
      $main_religion_chk_5 = "";
      $main_religion_chk_9 = "";
    } else if($main_religion == "5") {
      $main_religion_chk_1 = "";
      $main_religion_chk_2 = "";
      $main_religion_chk_3 = "";
      $main_religion_chk_4 = "";
      $main_religion_chk_5 = "selected";
      $main_religion_chk_9 = "";
    } else if($main_religion == "9") {
      $main_religion_chk_1 = "";
      $main_religion_chk_2 = "";
      $main_religion_chk_3 = "";
      $main_religion_chk_4 = "";
      $main_religion_chk_5 = "";
      $main_religion_chk_9 = "selected";
    }

$idcard_no = $row->idcard_no;
$fam_child = $row->fam_child;
$temp = $row->temp;

// Image
$savedir = "user_file";

if($photo1 == "none") {
    $staff_photo_img1 = "img/User_Photo_"."$gender".".png";
    $staff_photo_img1_txt = "";
} else {
    $staff_photo_img1 = "user_file/$photo1";
    $staff_photo_img1_txt = "<font color=blue>O</font>";
}


  $signdate = time();
  $post_year = date("Y",$signdate);
  $pmonth = date("m",$signdate);
  $pdate = date("d",$signdate);
  $phour = date("H",$signdate);
  
  $start_year = $post_year - 100;
  $start_year10 = $post_year - 10;
  $start_year20 = $post_year - 20;
  $start_year30 = $post_year - 30;
  $start_year40 = $post_year - 40;
  
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  $post_date1_dash = date("Y-m-d",$signdate);

// 3 Months ago
$past_month3 = date('Ymd',mktime(0,0,0,$pmonth-3,$pdate,$post_year));


// Retired(0), Non-regular(1), Regular(2), New(2)

if($userlevel == "0") {
    $userlevel_chk0 = "selected";
    $userlevel_chk1 = "";
    $userlevel_chk2 = "";
    $userlevel_chk3 = "";
    $userlevel_dis0 = "";
    $userlevel_dis1 = "disabled";
    $userlevel_dis2 = "disabled";
    $userlevel_dis3 = "disabled";
} else if($userlevel == "1") {
    if($regis_date < $past_month3) {
      $userlevel_chk0 = "";
      $userlevel_chk1 = "selected";
      $userlevel_chk2 = "";
      $userlevel_chk3 = "";
      $userlevel_dis0 = "";
      $userlevel_dis1 = "";
      $userlevel_dis2 = "";
      $userlevel_dis3 = "disabled";
      
      $query_MS7 = "UPDATE member_staff SET temp = '0' WHERE uid = '$staff_uid'";
      $result_MS7 = mysql_query($query_MS7);
      if (!$result_MS7) { error("QUERY_ERROR"); exit; }     

    } else {
      
      $userlevel_chk0 = "";
      $userlevel_chk1 = "";
      $userlevel_chk2 = "";
      $userlevel_chk3 = "selected";
      $userlevel_dis0 = "";
      $userlevel_dis1 = "disabled";
      $userlevel_dis2 = "";
      $userlevel_dis3 = "";

      $query_MS7 = "UPDATE member_staff SET ctr_sa = '2', temp = '1' WHERE uid = '$staff_uid'";
      $result_MS7 = mysql_query($query_MS7);
      if (!$result_MS7) { error("QUERY_ERROR"); exit; }      

    }

} else if($userlevel == "2") {
    if($regis_date < $past_month3) {
      $userlevel_chk0 = "";
      $userlevel_chk1 = "";
      $userlevel_chk2 = "selected";
      $userlevel_chk3 = "";
      $userlevel_dis0 = "";
      $userlevel_dis1 = "";
      $userlevel_dis2 = "";
      $userlevel_dis3 = "disabled";
  	
    	$query_MS7 = "UPDATE member_staff SET temp = '0' WHERE uid = '$staff_uid'";
    	$result_MS7 = mysql_query($query_MS7);
    	if (!$result_MS7) { error("QUERY_ERROR"); exit; }			

    } else { 

      $userlevel_chk0 = "";
      $userlevel_chk1 = "";
      $userlevel_chk2 = "";
      $userlevel_chk3 = "selected";
      $userlevel_dis0 = "";
      $userlevel_dis1 = "";
      $userlevel_dis2 = "disabled";
      $userlevel_dis3 = "";

      $query_MS7 = "UPDATE member_staff SET ctr_sa = '2', temp = '1' WHERE uid = '$staff_uid'";
      $result_MS7 = mysql_query($query_MS7);
      if (!$result_MS7) { error("QUERY_ERROR"); exit; }      
    }
  
}  else if($temp == "1") {
    $userlevel_chk0 = "";
    $userlevel_chk1 = "";
    $userlevel_chk2 = "";
    $userlevel_chk3 = "selected";
    $userlevel_dis0 = "";
    $userlevel_dis1 = "disabled";
    $userlevel_dis2 = "disabled";
    $userlevel_dis3 = "";
} 


// Payroll Code
$payroll_code_xpd = explode("-",$payroll_code);
$query_cname = "SELECT mname_abr FROM code_jobclass2 WHERE lcode = '$payroll_code_xpd[0]' AND mcode = '$payroll_code_xpd[1]'";
$result_cname = mysql_query($query_cname);
	if (!$result_cname) {   error("QUERY_ERROR");   exit; }
$payroll_name = @mysql_result($result_cname,0,0);
$payroll_code2 = "$payroll_name"."-"."$payroll_code_xpd[2]";

$query_cname_d = "SELECT driver FROM code_jobclass1 WHERE lcode = '$payroll_code_xpd[0]'";
$result_cname_d = mysql_query($query_cname_d);
	if (!$result_cname_d) {   error("QUERY_ERROR");   exit; }
$payroll_driver = @mysql_result($result_cname_d,0,0);

if($payroll_driver == "1") {
	$payroll_driver_txt = "&gt; driver";
} else {
	$payroll_driver_txt = "&nbsp;";
}

// Age
$my_age = $post_year - $birthyear;

$hr_member_del_link = "hr_member_del.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&mb_type=$mb_type&hr_type=$hr_type&hr_retire=$hr_retire&hr_temp=$hr_temp";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="">
      <? include "header.inc"; ?>


      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
                              <a href="#">
                                  <img src="<?=$staff_photo_img1?>">
                              </a>
                              <h1><?=$user_name?></h1>
                              <p><?=$email?></p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
								<?
								if(!$tab) {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level'> <i class='fa fa-user'></i> $txt_sys_client_23</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level'> <i class='fa fa-user'></i> $txt_sys_client_23</a></li>");
								}
								
								if($tab == "1") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=1'> <i class='fa fa-info-circle'></i> $txt_tab_hr_member_01</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=1'> <i class='fa fa-info-circle'></i> $txt_tab_hr_member_01</a></li>");
								}
								
								if($tab == "C") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=C'> <i class='fa fa-book'></i> $txt_tab_hr_member_C</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=C'> <i class='fa fa-book'></i> $txt_tab_hr_member_C</a></li>");
								}
								
								if($tab == "A") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=A'> <i class='fa fa-location-arrow'></i> $txt_tab_hr_member_A</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=A'> <i class='fa fa-location-arrow'></i> $txt_tab_hr_member_A</a></li>");
								}
								
								if($tab == "2") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=2'> <i class='fa fa-heart-o'></i> $txt_tab_hr_member_02</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=2'> <i class='fa fa-heart-o'></i> $txt_tab_hr_member_02</a></li>");
								}
								
								if($tab == "3") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=3'> <i class='fa fa-briefcase'></i> $txt_tab_hr_member_03</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=3'> <i class='fa fa-briefcase'></i> $txt_tab_hr_member_03</a></li>");
								}
								
								if($tab == "5") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=5'> <i class='fa fa-puzzle-piece'></i> $txt_tab_hr_member_05</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=5'> <i class='fa fa-puzzle-piece'></i> $txt_tab_hr_member_05</a></li>");
								}
								
								if($tab == "8") {
								 	echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=8'> <i class='fa fa-quote-left'></i> $txt_tab_hr_member_08</a></li>");
								} else {
								 	echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=8'> <i class='fa fa-quote-left'></i> $txt_tab_hr_member_08</a></li>");
								}
								
								if($tab == "7") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=7'> <i class='fa fa-trophy'></i> $txt_tab_hr_member_07</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=7'> <i class='fa fa-trophy'></i> $txt_tab_hr_member_07</a></li>");
								}
								
								if($tab == "6") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=6'> <i class='fa fa-star'></i> $txt_tab_hr_member_06</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=6'> <i class='fa fa-star'></i> $txt_tab_hr_member_06</a></li>");
								}
								
								if($tab == "9") {
									echo ("<li class='active'><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=9'> <i class='fa fa-refresh'></i> $txt_tab_hr_member_09</a></li>");
								} else {
									echo ("<li><a href='hr_member_upd.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&tab=9'> <i class='fa fa-refresh'></i> $txt_tab_hr_member_09</a></li>");
								}
								?>
						  </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">
                      
					  <!--
					  <section class="panel">
                          <div class="bio-graph-heading">
                              <?echo("$memo")?>
                          </div>
                          <div class="panel-body bio-graph-info">
                              
                              <div class="row">
								  <? echo ("
                                  <div class='bio-row'>
                                      <p><span>$txt_stf_staff_08 </span>: $user_name</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_hr_member_05 </span>: $user_code</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_stf_staff_12</span>: $birth_dates_txt ($my_age)</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_sys_client_09 </span>: $phone_cel</p>
                                  </div>");
								  ?>
                              </div>
                          </div>
                      </section>
					  -->
					  
					  
                      <section>
                          <div class="row">
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="35" data-fgColor="#e06b7d" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="red">Work Progress 1</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="63" data-fgColor="#4CC5CD" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="terques">Work Progress 2</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="75" data-fgColor="#96be4b" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="green">Work Progress 3</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-6">
                                  <div class="panel">
                                      <div class="panel-body">
                                          <div class="bio-chart">
                                              <input class="knob" data-width="100" data-height="100" data-displayPrevious=true  data-thickness=".2" value="50" data-fgColor="#cba4db" data-bgColor="#e8e8e8">
                                          </div>
                                          <div class="bio-desk">
                                              <h4 class="purple">Work Progress 4</h4>
                                              <p>Started : 15 July</p>
                                              <p>Deadline : 15 August</p>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </section>
					  
					  
					  
					  <? if(!$tab) { ?>
					  <section class="panel">

                          <header class="panel-heading">
							<?=$txt_stf_member_03?>
							<span class="tools pull-right">
								<a href="<?echo("$hr_member_del_link")?>" class="fa fa-trash-o"></a>
								<a href="javascript:;" class="fa fa-chevron-down"></a>
							</span>
						  </header>
						  
                          <div class="panel-body bio-graph-info">
                              
							  <form name='signform' class="form-horizontal" method='post' ENCTYPE='multipart/form-data' action='hr_member_upd.php'>
								<? echo ("
								<input type='hidden' name='step_next' value='permit_okay'>
								<input type='hidden' name='step_next_form' value='basic'>
								<input type='hidden' name='tab' value='$tab'>
								<input type='hidden' name='staff_uid' value='$staff_uid'>
								<input type='hidden' name='org_name' value='$user_name'>
								<input type='hidden' name='key_field' value='$key_field'>
								<input type='hidden' name='key' value='$key'>
								<input type='hidden' name='page' value='$page'>
								<input type='hidden' name='mb_level' value='$mb_level'>
								<input type='hidden' name='mb_code' value='$user_code'>
								<input type='hidden' name='mb_branch_code' value='$branch_code'>
								<input type='hidden' name='hr_type' value='$hr_type'>
								<input type='hidden' name='hr_retire' value='$hr_retire'>
	
							  
                                  <div class='form-group'>
                                      <label  class='col-sm-2 control-label'>$txt_hr_member_05</label>
                                      <div class='col-sm-6'>
                                          <input disabled type='text' class='form-control' id='l-name' name='user_code' value='$user_code'>
                                      </div>
                                      <div class='col-sm-4'>
											<select name='new_userlevel' class='form-control'>
											<option $userlevel_dis0 value='0' $userlevel_chk0>$txt_hr_member_380</option>
											<option $userlevel_dis1 value='1' $userlevel_chk1>$txt_hr_member_381</option>
											<option $userlevel_dis2 value='2' $userlevel_chk2>$txt_hr_member_382</option>
											<option $userlevel_dis3 value='4' $userlevel_chk3>$txt_tab_hr_member_09021</option>
											</select>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-2 control-label'>$txt_stf_staff_08</label>
                                      <div class='col-sm-6'>");
											if($login_level > "8") {
												echo ("<input type='text' class='form-control' id='l-name' name='new_name' value='$user_name'>");
											} else {
												echo ("<input disabled type='text' class='form-control' id='l-name' name='new_name' value='$user_name'>");
											} echo ("
                                      </div>
									  <div class='col-sm-4'>");
											if($login_level > "8") {
												echo ("
												<input type=radio name='gender' value='M' $gender_chkM> $txt_stf_staff_10 &nbsp;&nbsp;
												<input type=radio name='gender' value='F' $gender_chkF> $txt_stf_staff_11");
											} else {
												echo ("
												<input disabled type=radio name='gender' value='M' $gender_chkM> $txt_stf_staff_10 &nbsp;&nbsp;
												<input disabled type=radio name='gender' value='F' $gender_chkF> $txt_stf_staff_11");
											}
											echo ("
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-2 control-label'>$txt_hr_member_31</label>
                                      <div class='col-sm-6'>
                                          <input type='text' class='form-control' id='l-name' name='new_name2' value='$user_name2'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-2 control-label'>$txt_stf_staff_12</label>
                                      <div class='col-sm-3'>
                                          <input type='date' class='form-control' id='l-name' name='user_birthdates' value='$birth_dates'>
                                      </div>
									  <div class='col-sm-3'>( $my_age )</div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-2 control-label'>KTP No.</label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='idcard_no' value='$idcard_no'>
                                      </div>
									  <label class='col-sm-2 control-label'>$txt_tab_hr_member_04</label>
									  <div class='col-sm-4'>
											<select name='religion' class='form-control'>
											<option value=''>:: $txt_comm_frm19 ::</option>
											<option value='1' $main_religion_chk_1>$txt_tab_hr_member_0401</option>
											<option value='2' $main_religion_chk_2>$txt_tab_hr_member_0402</option>
											<option value='3' $main_religion_chk_3>$txt_tab_hr_member_0403</option>
											<option value='4' $main_religion_chk_4>$txt_tab_hr_member_0404</option>
											<option value='5' $main_religion_chk_5>$txt_tab_hr_member_0405</option>
											<option value='9' $main_religion_chk_9>$txt_tab_hr_member_0409</option>
											</select>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_hr_member_39</label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='passport_no' value='$passport_no'>
                                      </div>
									  <label class='col-sm-2 control-label'>$txt_hr_member_40</label>
                                      <div class='col-sm-4'>
                                          <input type='date' class='form-control' id='l-name' name='passport_expire' value='$passport_expire'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_hr_member_41</label>
                                      <div class='col-sm-4'>
											<select name='nationality_code' class='form-control'>
											<option value='in' $nationality_code_chk_in>Indonesia</option>
											<option value='ml' $nationality_code_chk_ml>Malaysia</option>
											<option value='sg' $nationality_code_chk_sg>Singapore</option>
											<option value='au' $nationality_code_chk_au>Australia</option>
											<option value='ko' $nationality_code_chk_ko>Korea</option>
											</select>
                                      </div>
									  <label class='col-sm-2 control-label'>$txt_hr_member_42</label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='visa_type' value='$visa_type'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_hr_member_32</label>
                                      <div class='col-sm-4'>
											<select name='marital_status' class='form-control'>
											<option value='1' $marital_status_chk_1>$txt_hr_member_321</option>
											<option value='2' $marital_status_chk_2>$txt_hr_member_322</option>
											<option value='3' $marital_status_chk_3>$txt_hr_member_323</option>
											<option value='4' $marital_status_chk_4>$txt_hr_member_324</option>
											<option value='5' $marital_status_chk_5>$txt_hr_member_325</option>
											</select>
                                      </div>
									  <label class='col-sm-2 control-label'>");
									  
											if($marital_status != "1") { 
												// echo ("<input type=checkbox name='spouse_link' value='1' $spouse_link_chk>&nbsp;");
											}
            
											echo ("$txt_hr_member_43
									  </label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='spouse_name' value='$spouse_name'>
                                      </div>
                                  </div>");
								  
									$query_F1 = "SELECT count(uid) FROM member_staff WHERE fam_head = '0' AND fam_code = '$user_code'";
									$result_F1 = mysql_query($query_F1,$dbconn);
										if (!$result_F1) { error("QUERY_ERROR"); exit; }
									$total_sub_fam = @mysql_result($result_F1,0,0);
            
									if($total_sub_fam > "0") {
										$fam_head_chk_0_disable = "disabled";
									} else {
										$fam_head_chk_0_disable = "";
									}
								  
									echo ("
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_hr_member_33</label>
                                      <div class='col-sm-4'>
									  
											<select name='fam_head' class='form-control'>");
											if($fam_head == "0" AND $fam_code != "") {
											echo ("
											<option value='0' $fam_head_chk_0>$txt_hr_member_332</option>
											<option value='1' $fam_head_chk_1>$txt_hr_member_334</option>");
											} else {
											echo ("
											<option value='1' $fam_head_chk_1>$txt_hr_member_331</option>
											<option $fam_head_chk_0_disable value='0' $fam_head_chk_0>$txt_hr_member_332</option>");
											}
          
											if($fam_head == "1") {
												$txt_fam_head_33 = "$txt_hr_member_335";
											} else {
												$txt_fam_head_33 = "$txt_hr_member_331";
											}
											echo ("
											</select>
		  
                                      </div>
									  <label class='col-sm-2 control-label'>No. Child(ren)</label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='fam_child' value='$fam_child'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_comm_frm23</label>
                                      <div class='col-sm-4'>
											
											<select name='new_branch_code' class='form-control'>");
											$query_D1c = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$result_D1c = mysql_query($query_D1c,$dbconn);
												if (!$result_D1c) { error("QUERY_ERROR"); exit; }
											$total_D1c = @mysql_result($result_D1c,0,0);
      
											$query_D1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$result_D1 = mysql_query($query_D1,$dbconn);
												if (!$result_D1) { error("QUERY_ERROR"); exit; }   

											for($d1 = 0; $d1 < $total_D1c; $d1++) {
												$D1_lcode = mysql_result($result_D1,$d1,0);
												$D1_lname = mysql_result($result_D1,$d1,1);
              
												if($branch_code == $D1_lcode) {
													echo ("<option value='$D1_lcode' selected>$D1_lname</option>");
												} else {
													echo ("<option value='$D1_lcode'>$D1_lname</option>");
												}
            
											}
											echo ("
											</select>
		  
                                      </div>
									  <label class='col-sm-2 control-label'>$txt_hr_member_34</label>
                                      <div class='col-sm-4'>
											
											<select name='corp_dept_code' class='form-control'>
											<option value=''>:: $txt_hr_member_45 ::</option>");
          
											// Department
											$query_dp1c = "SELECT count(uid) FROM dept_catgbig";
											$result_dp1c = mysql_query($query_dp1c,$dbconn);
												if (!$result_dp1c) { error("QUERY_ERROR"); exit; }
											$total_dp1c = @mysql_result($result_dp1c,0,0);
      
											$query_dp1 = "SELECT lcode,lname FROM dept_catgbig ORDER BY lcode ASC";
											$result_dp1 = mysql_query($query_dp1,$dbconn);
											if (!$result_dp1) { error("QUERY_ERROR"); exit; }   

											for($dp1 = 0; $dp1 < $total_dp1c; $dp1++) {
												$dp_lcode = mysql_result($result_dp1,$dp1,0);
												$dp_lname = mysql_result($result_dp1,$dp1,1);
              
												echo ("<option disabled value='$dp_lcode'>$dp_lname &gt;</option>");
												
												$query_dp2c = "SELECT count(uid) FROM dept_catgmid WHERE lcode = '$dp_lcode'";
												$result_dp2c = mysql_query($query_dp2c,$dbconn);
													if (!$result_dp2c) { error("QUERY_ERROR"); exit; }
												$total_dp2c = @mysql_result($result_dp2c,0,0);
      
												$query_dp2 = "SELECT mcode,mname FROM dept_catgmid WHERE lcode = '$dp_lcode' ORDER BY mcode ASC";
												$result_dp2 = mysql_query($query_dp2,$dbconn);
												if (!$result_dp2) { error("QUERY_ERROR"); exit; }   

												for($dp2 = 0; $dp2 < $total_dp2c; $dp2++) {
													$dp_mcode = mysql_result($result_dp2,$dp2,0);
													$dp_mname = mysql_result($result_dp2,$dp2,1);
														$dp_mcode6 = "$dp_mcode"."00";
													
													$query_dp3c = "SELECT count(uid) FROM dept_catgsml WHERE mcode = '$dp_mcode'";
													$result_dp3c = mysql_query($query_dp3c,$dbconn);
														if (!$result_dp3c) { error("QUERY_ERROR"); exit; }
													$total_dp3c = @mysql_result($result_dp3c,0,0);
              
													if($total_dp3c < 1) {
														
														if($dp_mcode6 == $corp_dept_code) {
															echo ("<option value='$dp_mcode6' selected>&nbsp;&nbsp;&nbsp; $dp_mname</option>");
														} else {
															echo ("<option value='$dp_mcode6'>&nbsp;&nbsp;&nbsp; $dp_mname</option>");
														}
														
													} else {
														
														echo ("<option disabled value='$dp_mcode6'>&nbsp;&nbsp;&nbsp; $dp_mname</option>");
														
														$query_dp3 = "SELECT scode,sname FROM dept_catgsml WHERE mcode = '$dp_mcode' ORDER BY scode ASC";
														$result_dp3 = mysql_query($query_dp3,$dbconn);
														if (!$result_dp3) { error("QUERY_ERROR"); exit; }   

														for($dp3 = 0; $dp3 < $total_dp3c; $dp3++) {
															$dp_scode = mysql_result($result_dp3,$dp3,0);
															$dp_sname = mysql_result($result_dp3,$dp3,1);
														
															if($dp_scode == $corp_dept_code) {
																echo ("<option value='$dp_scode' selected>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $dp_sname</option>");
															} else {
																echo ("<option value='$dp_scode'>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $dp_sname</option>");
															}
														
														}
												
													}
												
												}
            
											}
											echo ("
											</select>
		  
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_stf_staff_16</label>
                                      <div class='col-sm-4'>
                                          <input type='text' class='form-control' id='l-name' name='corp_title' value='$corp_title'>
                                      </div>
									  <label class='col-sm-2 control-label'>$hsm_name_09_41</label>
                                      <div class='col-sm-4'>
                                          
											<select name='job_class' class='form-control'>
											<option value=''>:: $txt_comm_frm19 ::</option>");
											$query_J1c = "SELECT count(uid) FROM code_jobclass1 WHERE lang = '$lang'";
											$result_J1c = mysql_query($query_J1c,$dbconn);
												if (!$result_J1c) { error("QUERY_ERROR"); exit; }
											$total_J1c = @mysql_result($result_J1c,0,0);
      
											$query_J1 = "SELECT lcode,lname FROM code_jobclass1 WHERE lang = '$lang' ORDER BY lcode ASC";
											$result_J1 = mysql_query($query_J1,$dbconn);
												if (!$result_J1) { error("QUERY_ERROR"); exit; }   

											for($j1 = 0; $j1 < $total_J1c; $j1++) {
												$J1_job_code = mysql_result($result_J1,$j1,0);
												$J1_job_name = mysql_result($result_J1,$j1,1);
              
												echo ("<option disabled value='$J1_job_code'>$J1_job_code. $J1_job_name</option>");
			
												// sub
												$query_J1sc = "SELECT count(uid) FROM code_jobclass2 WHERE lang = '$lang' AND lcode = '$J1_job_code'";
												$result_J1sc = mysql_query($query_J1sc,$dbconn);
													if (!$result_J1sc) { error("QUERY_ERROR"); exit; }
												$total_J1sc = @mysql_result($result_J1sc,0,0);
      
												$query_J1s = "SELECT mcode,mname FROM code_jobclass2 WHERE lang = '$lang' AND lcode = '$J1_job_code' ORDER BY mcode ASC";
												$result_J1s = mysql_query($query_J1s,$dbconn);
													if (!$result_J1s) { error("QUERY_ERROR"); exit; }   

												for($j1s = 0; $j1s < $total_J1sc; $j1s++) {
													$J1s_job_code = mysql_result($result_J1s,$j1s,0);
													$J1s_job_name = mysql_result($result_J1s,$j1s,1);
				
													$job_class_code = "$J1_job_code"."-"."$J1s_job_code";
              
													if($job_class == $job_class_code) {
														echo ("<option value='$job_class_code' selected>&nbsp; $J1s_job_code. $J1s_job_name</option>");
													} else {
														echo ("<option value='$job_class_code'>&nbsp; $J1s_job_code. $J1s_job_name</option>");
													}
												}
			
			
            
											}
											echo ("
											</select>
		  
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$hsm_name_09_42</label>
                                      <div class='col-sm-4'>
											
											<select name='pay_class' class='form-control'>
											<option value=\"\">:: $txt_comm_frm19 ::</option>");
											$query_J2c = "SELECT count(uid) FROM code_payclass1";
											$result_J2c = mysql_query($query_J2c,$dbconn);
												if (!$result_J2c) { error("QUERY_ERROR"); exit; }
											$total_J2c = @mysql_result($result_J2c,0,0);
      
											$query_J2 = "SELECT lcode,lname FROM code_payclass1 ORDER BY lcode ASC";
											$result_J2 = mysql_query($query_J2,$dbconn);
												if (!$result_J2) { error("QUERY_ERROR"); exit; }   

											for($j2 = 0; $j2 < $total_J2c; $j2++) {
												$J2_job_code = mysql_result($result_J2,$j2,0);
												$J2_job_name = mysql_result($result_J2,$j2,1);
              
												echo ("<option disabled value='$J2_job_code'>$J2_job_code -------</option>");
			
												// sub
												$query_J2sc = "SELECT count(uid) FROM code_payclass2 WHERE lcode = '$J2_job_code'";
												$result_J2sc = mysql_query($query_J2sc,$dbconn);
													if (!$result_J2sc) { error("QUERY_ERROR"); exit; }
												$total_J2sc = @mysql_result($result_J2sc,0,0);
      
												$query_J2s = "SELECT mcode,mname FROM code_payclass2 WHERE lcode = '$J2_job_code' ORDER BY mcode ASC";
												$result_J2s = mysql_query($query_J2s,$dbconn);
													if (!$result_J2s) { error("QUERY_ERROR"); exit; }   

												for($J2s = 0; $J2s < $total_J2sc; $J2s++) {
													$J2s_job_code = mysql_result($result_J2s,$J2s,0);
													$J2s_job_name = mysql_result($result_J2s,$J2s,1);
              
													if($pay_class == $J2s_job_code) {
														echo ("<option value='$J2s_job_code' selected>&nbsp; $J2s_job_code</option>");
													} else {
														echo ("<option value='$J2s_job_code'>&nbsp; $J2s_job_code</option>");
													}
												}
			
			
            
											}
											echo ("
											</select>
		  
                                      </div>
									  <label class='col-sm-2 control-label'><font color=#006699>$payroll_code2</font></label>
                                      <div class='col-sm-4'>
									  
											<select name='deduction_code' class='form-control'>
											<option value=\"\">:: $txt_comm_frm19 ::</option>");
											if($deduction_code == "TK0") {
												echo ("<option value='TK0' selected>TK0</option>");
											} else {
												echo ("<option value='TK0'>TK0</option>");
											}
/*                      if($deduction_code == "TK1") {
                        echo ("<option value='TK1' selected>TK1</option>");
                      } else {
                        echo ("<option value='TK1'>TK1</option>");
                      }                      
                      if($deduction_code == "TK2") {
                        echo ("<option value='TK2' selected>TK2</option>");
                      } else {
                        echo ("<option value='TK2'>TK2</option>");
                      }
                      if($deduction_code == "TK3") {
                        echo ("<option value='TK3' selected>TK3</option>");
                      } else {
                        echo ("<option value='TK3'>TK3</option>");
                      }   */                                         
											if($deduction_code == "K0") {
												echo ("<option value='K0' selected>K0</option>");
											} else {
												echo ("<option value='K0'>K0</option>");
											}
											if($deduction_code == "K1") {
												echo ("<option value='K1' selected>K1</option>");
											} else {
												echo ("<option value='K1'>K1</option>");
											}
											if($deduction_code == "K2") {
												echo ("<option value='K2' selected>K2</option>");
											} else {
												echo ("<option value='K2'>K2</option>");
											}
											if($deduction_code == "K3") {
												echo ("<option value='K3' selected>K3</option>");
											} else {
												echo ("<option value='K3'>K3</option>");
											}
											echo ("
											</select>
									  
									  </div>
									  
                                  </div>
								  <div class='form-group'>
									<label class='col-sm-2 control-label'>$txt_sys_bank_06</label>
                                      <div class='col-sm-4'>
											<select name='bank_id' class='form-control'>
												<option value=\"\">:: $txt_comm_frm19 ::</option>
												
											</select>
									  </div>
								  </div>
								  <div class='form-group'>
									<label class='col-sm-2 control-label'>$txt_sys_bank_07</label>
                                      <div class='col-sm-4'>
											<input type='text' class='form-control' id='l-name' name='account_no' value=''>
									  </div>
								  </div>
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_tab_hr_member_0308 for</label>
                                      <div class='col-sm-4'>
											
											<select name='ctr_branch_code' class='form-control'>
											<option value=\"\">:: $txt_stf_staff_061</option>");

											$query_M1c = "SELECT count(uid) FROM client_branch WHERE branch_code != '$branch_code' AND userlevel > '0'";
											$result_M1c = mysql_query($query_M1c,$dbconn);
												if (!$result_D1c) { error("QUERY_ERROR"); exit; }
											$total_M1c = @mysql_result($result_M1c,0,0);
      
											$query_N1 = "SELECT branch_code,branch_name FROM client_branch 
														WHERE branch_code != '$branch_code' AND userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$result_N1 = mysql_query($query_N1,$dbconn);
												if (!$result_N1) { error("QUERY_ERROR"); exit; }   

											for($n1 = 0; $n1 < $total_M1c; $n1++) {
												$N1_lcode = mysql_result($result_N1,$n1,0);
												$N1_lname = mysql_result($result_N1,$n1,1);
              
												if($ctr_branch_code == $N1_lcode) {
													echo ("<option value='$N1_lcode' selected>$N1_lname</option>");
												} else {
													echo ("<option value='$N1_lcode'>$N1_lname</option>");
												}
            
											}
											echo ("
											</select>
											
                                      </div>
									  <label class='col-sm-2 control-label'>$txt_hr_member_38</label>
                                      <div class='col-sm-4'>
											<input type='date' class='form-control' id='l-name' name='regis_date' value='$regis_date'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label class='col-sm-2 control-label'>$txt_hr_member_3291</label>
                                      <div class='col-sm-4'>
											<input type='date' class='form-control' id='l-name' name='expel_date' value='$expel_date'>
                                      </div>
                                      <div class='col-sm-6'>
                                          <input type=checkbox name='expel_reason' value='9' $expel_reason_chk9> $txt_hr_member_3293
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <div class='col-sm-offset-2 col-sm-10'>
                                          <input type='submit' class='btn btn-success' value='$txt_comm_frm05'>
                                      </div>
                                  </div>
                                  ");
								  ?>
                              </form>

					  </div>
                      </section>
					  
					  
					  <? } else { ?>
					  
					  <section class="panel">
					  
                          
                          <div class="panel-body bio-graph-info">
							  <form name='signform2' class="form-horizontal" ENCTYPE='multipart/form-data' method='post' action='hr_member_upd.php'>
								<? echo ("
								<input type='hidden' name='step_next' value='permit_okay'>
								<input type='hidden' name='step_next_form' value='detail'>
								<input type='hidden' name='tab' value='$tab'>
								<input type='hidden' name='mode' value='$mode'>
								<input type='hidden' name='staff_uid' value='$staff_uid'>
								<input type='hidden' name='org_name' value='$user_name'>
								<input type='hidden' name='key_field' value='$key_field'>
								<input type='hidden' name='key' value='$key'>
								<input type='hidden' name='page' value='$page'>
								<input type='hidden' name='mb_level' value='$mb_level'>
								<input type='hidden' name='mb_code' value='$user_code'>
								<input type='hidden' name='org_photo1' value='$photo1'>
								<input type='hidden' name='org_photo2' value='$photo2'>
								<input type='hidden' name='j_uid' value='$j_uid'>
								<input type='hidden' name='hr_type' value='$hr_type'>
								<input type='hidden' name='hr_retire' value='$hr_retire'>"); ?>

								<?
								if(!$tab) {
									include "hr_member_upd_1.inc";
								} else {
									include "hr_member_upd_{$tab}.inc";
								}
								?>
								
								<span>&nbsp;</span>
						
								<div class="form-group">
									<label for="cname" class="control-label col-sm-2"><?=$txt_sys_client_062?></label>
									<div class="col-sm-4">
										<input readonly class="form-control" id="signdate" name="upd_date" value="<?=$upd_date_txt?>" type="text" />
									</div>
									<div class="col-sm-2" align=right>IP</div>
									<div class="col-sm-4">
										<input readonly class="form-control" id="cname" name="upd_ip" value="<?echo("$upd_ip")?>" type="text" />
									</div>
								</div>
									
								<span>&nbsp;</span>
								<?
								if($mode == "del") {
									$member_upd_sumbit_txt = "$txt_comm_frm052";
								} else if($mode == "add" OR $mode == "add2") {
									$member_upd_sumbit_txt = "$txt_comm_frm051";
								} else if($mode == "create") {
									$member_upd_sumbit_txt = "$txt_comm_frm33";
								} else {
									$member_upd_sumbit_txt = "$txt_comm_frm05";
								}
								?>

								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
										<input class="btn btn-primary" type="submit" value="<?=$member_upd_sumbit_txt?>">
										<input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
									</div>
								</div>
                              </form>
                          </div>

                      </section>
					  
					  
					  <? } ?>
					  
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>
      <!--main content end-->

      <? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

  <script>

      //knob
      $(".knob").knob();

  </script>


  </body>
</html>



<?
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_year = date("Y",$signdate);
  $post_date1 = date("Ymd",$signdate);
    $post_date1s = date("Y-m-d",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  $m_ip = getenv('REMOTE_ADDR');

	$birthday_exp = explode("-",$user_birthdates);
	$birth1 = $birthday_exp[0];
	$birth2 = $birthday_exp[1];
	$birth3 = $birthday_exp[2];
	
	$birth_date = "$birth1"."$birth2"."$birth3";
  
  
  if(!$spouse_link) {
    $spouse_link = "0";
  }
  
  if(!$expel_reason) {
    $expel_reason = "1";
  }
  
  $savedir = "user_file";
  
  $memo = addslashes($memo);
  
  

  // Duplication Check
  if($new_name == $org_name) {
    $filter_name = "Pass";
  } else {
    $filter_name = $new_name;
  }
    
    $result = mysql_query("SELECT count(name) FROM member_staff WHERE name = '$filter_name' AND birthday = '$birth_date'");
    if (!$result) { error("QUERY_ERROR"); exit; }
    $rows = @mysql_result($result,0,0);
    
    if ($rows) {
      popup_msg("$txt_stf_staff_chk02 \\n\\n{$txt_stf_staff_chk03}");
      break;
    } else {



  $br_query = "SELECT branch_code FROM client WHERE client_id = '$user_gate' ORDER BY uid DESC";
  $br_result = mysql_query($br_query);
  if (!$br_result) { error("QUERY_ERROR"); exit; }
  $br_branch_code = @mysql_result($br_result,0,0);
  
  
    // UPDATE
    if($step_next_form == "detail") {
    
        
        
        if($tab == "A") {

        
            // Addresses

                if(!$fam_sync) {
                  $fam_sync = "0";
                }
                
                if($mode == "del") {
                
                    $query_addr_del  = "DELETE FROM member_staff_addr WHERE uid = '$j_uid'"; 
                    $result_addr_del = mysql_query($query_addr_del);
                    if(!$result_addr_del) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "add") {
                
                    if($upd_fam_head == "1") {
                      $now_fam_code = "$mb_code";
                    } else {
                      $now_fam_code = "$upd_fam_code";
                    }
                    
                    $query_addr_add = "INSERT INTO member_staff_addr (uid,code,fam_sync,fam_code,zipcode,addr1,addr2,
                        phone,post_date) values ('','$mb_code','$fam_sync','$now_fam_code','$zipcode',
                        '$addr1','$addr2','$phone','$new_post_date')";
                    $result_addr_add = mysql_query($query_addr_add);
                    if (!$result_addr_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    if($fam_sync == "1" AND $upd_fam_head == "1") {
						$query_addr_upd  = "UPDATE member_staff_addr SET post_date = '$new_post_date', 
                        fam_sync = '$fam_sync', fam_code = '$upd_fam_code', zipcode = '$zipcode', 
                        addr1 = '$addr1', addr2 = '$addr2', phone = '$phone' WHERE code = '$upd_fam_code'";
						$result_addr_upd = mysql_query($query_addr_upd);
						if (!$result_addr_upd) { error("QUERY_ERROR"); exit; }
                    }
                
                    $query_addr_upd1  = "UPDATE member_staff_addr SET zipcode = '$zipcode', 
                        addr1 = '$addr1', addr2 = '$addr2', phone = '$phone' WHERE uid = '$j_uid'";
                    $result_addr_upd1 = mysql_query($query_addr_upd1);
                    if (!$result_addr_upd1) { error("QUERY_ERROR"); exit; }
                
                }
        
        
        
        } else if($tab == "C") {

        
            // Registration/Retirement - Penssion

                if($mode == "del") {
                
                    $query_retire_del  = "DELETE FROM member_staff_retire WHERE uid = '$j_uid'"; 
                    $result_retire_del = mysql_query($query_retire_del);
                    if(!$result_retire_del) { error("QUERY_ERROR"); exit; }
                    
                } else if($mode == "add") {
                
                    $dtl_retire_memo = addslashes($dtl_retire_memo);
					
					// Date Format : YYYY-MM-DD
                
                    $query_retire_add = "INSERT INTO member_staff_retire (uid,branch_code,code,regis_date,retire_date,
						retire_pay_tamount,retire_pay_amount,post_date) 
						values ('','$mb_branch_code','$mb_code','$new_regis_date','$new_retire_date',
						'$new_retire_pay_amount','$new_retire_pay_amount','$post_dates')";
                    $result_retire_add = mysql_query($query_retire_add);
                    if (!$result_retire_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $dtl_retire_memo = addslashes($dtl_retire_memo);
					
					if($new_retire_pay_amount > 0 AND $new_retire_pay_date > 1) {
						$new_retire_pay_status = "1";
					} else {
						$new_retire_pay_status = "0";
					}
					if($new_retire_pay2_amount > 0 AND $new_retire_pay2_date > 1) {
						$new_retire_pay2_status = "1";
					} else {
						$new_retire_pay2_status = "0";
					}
					
                    $query_retire_upd1  = "UPDATE member_staff_retire SET regis_date = '$new_regis_date', retire_date = '$new_retire_date', 
                        retire_pay_amount = '$new_retire_pay_amount', retire_pay_date = '$new_retire_pay_date', retire_pay_status = '$new_retire_pay_status', 
                        retire_pay2_amount = '$new_retire_pay2_amount', retire_pay2_date = '$new_retire_pay2_date', retire_pay2_status = '$new_retire_pay2_status' 
						WHERE uid = '$j_uid'";
                    $result_retire_upd1 = mysql_query($query_retire_upd1);
                    if (!$result_retire_upd1) { error("QUERY_ERROR"); exit; }
                
                }
		
		
		
		} else if($tab == "2") {
        
        
        
        
        
        } else if($tab == "3") {

        
            // Vocational Background
            if($class == "A") {
            
                if($mode == "del") {
                
                    $query_job_del  = "DELETE FROM member_staff_job WHERE uid = '$j_uid'"; 
                    $result_job_del = mysql_query($query_job_del);
                    if(!$result_job_del) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "add") {
                
                    $dtl_corp_desc = addslashes($dtl_corp_desc);
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_job_add = "INSERT INTO member_staff_job (uid,code,job_catg,job,corp_name,corp_dept,
                        corp_jobclass,corp_title,corp_desc,corp_zipcode,corp_addr1,corp_addr2,corp_phone,corp_fax,
                        corp_website,work_in,work_out,memo,post_date) values ('','$mb_code','$dtl_job_catg',
                        '$dtl_job','$dtl_corp_name','$dtl_corp_dept','$dtl_corp_jobclass','$dtl_corp_title',
                        '$dtl_corp_desc','$dtl_corp_zipcode','$dtl_corp_addr1','$dtl_corp_addr2','$dtl_corp_phone',
                        '$dtl_corp_fax','$dtl_corp_website','$dtl_work_in','$dtl_work_out','$dtl_memo','$post_dates')";
                    $result_job_add = mysql_query($query_job_add);
                    if (!$result_job_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $dtl_corp_desc = addslashes($dtl_corp_desc);
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_job_upd  = "UPDATE member_staff_job SET job_catg = '$dtl_job_catg', job = '$dtl_job', 
                        corp_name = '$dtl_corp_name', corp_dept = '$dtl_corp_dept', corp_jobclass = '$dtl_corp_jobclass', 
                        corp_title = '$dtl_corp_title', corp_desc = '$dtl_corp_desc', corp_zipcode = '$dtl_corp_zipcode', 
                        corp_addr1 = '$dtl_corp_addr1', corp_addr2 = '$dtl_corp_addr2', corp_phone = '$dtl_corp_phone', 
                        corp_fax = '$dtl_corp_fax', corp_website = '$dtl_corp_website', work_in = '$dtl_work_in', 
                        work_out = '$dtl_work_out', memo = '$dtl_memo' WHERE uid = '$j_uid'";
                    $result_job_upd = mysql_query($query_job_upd);
                    if (!$result_job_upd) { error("QUERY_ERROR"); exit; }
                
                }

           
            } else if($class == "B") {
            
            // Academic Background
            
                if($mode == "del") {
                
                    $query_sch_del  = "DELETE FROM member_staff_school WHERE uid = '$j_uid'"; 
                    $result_sch_del = mysql_query($query_sch_del);
                    if(!$result_sch_del) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "add") {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_sch_add = "INSERT INTO member_staff_school (uid,code,sch_catg,sch_name,sch_area,sch_dept,
                        sch_class,fin_flag,sch_in,sch_out,memo,post_date) values ('','$mb_code','$dtl_sch_catg',
                        '$dtl_sch_name','$dtl_sch_area','$dtl_sch_dept','$dtl_sch_class','$dtl_fin_flag',
                        '$dtl_sch_in','$dtl_sch_out','$dtl_memo','$post_dates')";
                    $result_sch_add = mysql_query($query_sch_add);
                    if (!$result_sch_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_sch_upd  = "UPDATE member_staff_school SET sch_catg = '$dtl_sch_catg', sch_name = '$dtl_sch_name', 
                        sch_area = '$dtl_sch_area', sch_dept = '$dtl_sch_dept', sch_class = '$dtl_sch_class', 
                        fin_flag = '$dtl_fin_flag', sch_in = '$dtl_sch_in', sch_out = '$dtl_sch_out', memo = '$dtl_memo' 
                        WHERE uid = '$j_uid'";
                    $result_sch_upd = mysql_query($query_sch_upd);
                    if (!$result_sch_upd) { error("QUERY_ERROR"); exit; }
                
                }
            
            
            }
        
        
        
        } else if($tab == "4") {

        
            // Religion

                if($mode == "del") {
                
                    $query_relg_del  = "DELETE FROM member_staff_religion WHERE uid = '$j_uid'"; 
                    $result_relg_del = mysql_query($query_relg_del);
                    if(!$result_relg_del) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "add") {
                
                    if(!$dtl_faith_level) { $dtl_faith_level = "0"; }
                    if(!$dtl_faith_level2) { $dtl_faith_level2 = ""; }
                    $dtl_relg_out_why = addslashes($dtl_relg_out_why);
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_relg_add = "INSERT INTO member_staff_religion (uid,code,religion,religion2,relg_name,relg_sect,
                        relg_area,relg_in,relg_bap,relg_out,relg_out_why,faith_level,faith_level2,memo,post_date,
                        relg_title,relg_pastor) values ('','$mb_code','$dtl_religion','$dtl_religion2','$dtl_relg_name',
                        '$dtl_relg_sect','$dtl_relg_area','$dtl_relg_in','$dtl_relg_bap','$dtl_relg_out','$dtl_relg_out_why',
                        '$dtl_faith_level','$dtl_faith_level2','$dtl_memo','$post_dates','$dtl_relg_title','$dtl_relg_pastor')";
                    $result_relg_add = mysql_query($query_relg_add);
                    if (!$result_relg_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    if(!$dtl_faith_level) { $dtl_faith_level = "0"; }
                    if(!$dtl_faith_level2) { $dtl_faith_level2 = ""; }
                    $dtl_relg_out_why = addslashes($dtl_relg_out_why);
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_relg_upd  = "UPDATE member_staff_religion SET religion = '$dtl_religion', religion2 = '$dtl_religion2', 
                        relg_name = '$dtl_relg_name', relg_sect = '$dtl_relg_sect', relg_area = '$dtl_relg_area', 
                        relg_in = '$dtl_relg_in', relg_bap = '$dtl_relg_bap', relg_out = '$dtl_relg_out', 
                        faith_level = '$dtl_faith_level', faith_level2 = '$dtl_faith_level2', memo = '$dtl_memo', 
                        relg_title = '$dtl_relg_title', relg_pastor = '$dtl_relg_pastor' WHERE uid = '$j_uid'";
                    $result_relg_upd = mysql_query($query_relg_upd);
                    if (!$result_relg_upd) { error("QUERY_ERROR"); exit; }
                    
                    if($mode2 == "upd2") {
                      $query_relg_upd2  = "UPDATE member_staff SET faith_level = '$dtl_faith_level' WHERE code = '$mb_code'";
                      $result_relg_upd2 = mysql_query($query_relg_upd2);
                      if (!$result_relg_upd2) { error("QUERY_ERROR"); exit; }
                    }
                
                }
        

        } else if($tab == "5") {

        
            // Training
            if($class == "B") {
              $add_tchurch_flag = "0";
            } else {
              $add_tchurch_flag = "1";
            }
            

                if($mode == "del") {
                
                    if($dtl_poster_id == $login_id) {
                    
                    $query_train_del  = "DELETE FROM member_staff_train WHERE uid = '$j_uid'"; 
                    $result_train_del = mysql_query($query_train_del);
                    if(!$result_train_del) { error("QUERY_ERROR"); exit; }
                    
                    }
                
                } else if($mode == "add" OR $mode == "add2") {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_train_add = "INSERT INTO member_staff_train (uid,code,tcode,memo,poster_id,post_date,
                        tcorp_flag,tcorp_name,train_name) values ('','$mb_code','$dtl_tcode','$dtl_memo',
                        '$login_id','$post_dates','$add_tchurch_flag','$dtl_tchurch_name','$dtl_train_name')";
                    $result_train_add = mysql_query($query_train_add);
                    if (!$result_train_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $dtl_pastor_memo = addslashes($dtl_pastor_memo);
                    $dtl_memo = addslashes($dtl_memo);
                
                    if($dtl_poster_id == $login_id) {
                    
                    $query_train_upd1  = "UPDATE member_staff_train SET fin_flag = '$dtl_fin_flag', 
                        fin_grade = '$dtl_fin_grade', fin_evalu = '$dtl_fin_evalu', 
                        tcorp_name = '$dtl_tchurch_name', train_name = '$dtl_train_name',
                        train_period = '$dtl_train_period', train_begin = '$dtl_train_begin',
                        train_finish = '$dtl_train_finish', train_memo = '$dtl_train_memo',
                        eta01_evalu = '$eta01_evalu', eta02_evalu = '$eta02_evalu', eta03_evalu = '$eta03_evalu', 
                        eta04_evalu = '$eta04_evalu', eta05_evalu = '$eta05_evalu', eta06_evalu = '$eta06_evalu', 
                        eta07_evalu = '$eta07_evalu', eta08_evalu = '$eta08_evalu', eta09_evalu = '$eta09_evalu', 
                        eta10_evalu = '$eta10_evalu', pastor_memo = '$dtl_pastor_memo', memo = '$dtl_memo' 
                        WHERE uid = '$j_uid'";
                    $result_train_upd1 = mysql_query($query_train_upd1);
                    if (!$result_train_upd1) { error("QUERY_ERROR"); exit; }
                    
                    } else {
                    
                    $query_train_upd2  = "UPDATE member_staff_train SET memo = '$dtl_memo' WHERE uid = '$j_uid'";
                    $result_train_upd2 = mysql_query($query_train_upd2);
                    if (!$result_train_upd2) { error("QUERY_ERROR"); exit; }
                    
                    }
                
                }
        
        
        
        } else if($tab == "6") {

        
            // Special

                if($mode == "create") {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_spec_add = "INSERT INTO member_staff_spec (uid,code) values ('','$mb_code')";
                    $result_spec_add = mysql_query($query_spec_add);
                    if (!$result_spec_add) { error("QUERY_ERROR"); exit; }
                
                } else {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_spec_upd  = "UPDATE member_staff_spec SET guide = '$dtl_guide', blood_type = '$dtl_blood_type', 
                        wed_date = '$dtl_wed_date', fn_status = '$dtl_fn_status', hobby = '$dtl_hobby', 
                        talent = '$dtl_talent', sp_gift = '$dtl_sp_gift', health = '$dtl_health', 
                        car_no = '$dtl_car_no', parking_no = '$dtl_parking_no', memo = '$dtl_memo' 
                        WHERE code = '$mb_code'";
                    $result_spec_upd = mysql_query($query_spec_upd);
                    if (!$result_spec_upd) { error("QUERY_ERROR"); exit; }
                
                }


        } else if($tab == "7") {

        
            // Wages
			$new_year_xpd = explode("-",$new_yearmonth);
			$new_year = $new_year_xpd[0];

			$new_days_off = $mb_days_total - $new_days_on;
			$new_currency = "IDR";
			//Harus ganti 
			$new_amount_avrg_net_ps = $mb_amount_avrg_ps - $new_amount_avrg_cost_ps;
			$new_amount_final = $new_amount_avrg_net_ps + $new_amount_deduction + $new_amount_incentive + $new_amount_bonus + $new_amount_offset - $new_amount_tax;
			
			
                if($mode == "del") {
                
                    $query_wage_del  = "DELETE FROM payroll_list WHERE uid = '$j_uid'"; 
                    $result_wage_del = mysql_query($query_wage_del);
                    if(!$result_wage_del) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "add") {
                
                    $query_wage_add = "INSERT INTO payroll_list (uid,branch_code,year,yearmonth,pay_type,mb_code,
                        payroll_code,deduction_code,days_total,days_off,days_on,currency,amount_avrg,amount_avrg_cost,amount_avrg_net,
						amount_deduction,amount_incentive,amount_bonus,amount_offset,amount_tax,amount_final,due_date) 
                        values ('','$branch_code','$new_year','$new_yearmonth','$new_pay_type','$mb_code',
						'$mb_payroll_code','$mb_deduction_code','$mb_days_total','$new_days_off','$new_days_on','$new_currency',
                        '$mb_amount_avrg_ps','$new_amount_avrg_cost_ps','$new_amount_avrg_net_ps',
                        '$new_amount_deduction','$new_amount_incentive','$new_amount_bonus','$new_amount_offset','$new_amount_tax',
						'$new_amount_final','$new_due_dates')";
                    $result_wage_add = mysql_query($query_wage_add);
                    if (!$result_wage_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $query_wage_upd1  = "UPDATE payroll_list SET days_total = '$mb_days_total', days_off ='$new_days_off', days_on = '$new_days_on',  
                        amount_avrg = '$mb_amount_avrg_ps', amount_avrg_cost = '$new_amount_avrg_cost_ps', amount_avrg_net = '$new_amount_avrg_net_ps', 
                        amount_deduction = '$new_amount_deduction', amount_incentive = '$new_amount_incentive', amount_bonus = '$new_amount_bonus', 
                        amount_offset = '$new_amount_offset', amount_tax = '$new_amount_tax', amount_final = '$new_amount_final', 
                        due_date = '$new_due_dates', pay_date = '$new_pay_dates' WHERE uid = '$j_uid'";
                    $result_wage_upd1 = mysql_query($query_wage_upd1);
                    if (!$result_wage_upd1) { error("QUERY_ERROR"); exit; }
               
                }
		
		
		} else if($tab == "8") {

        
            // Visits

                if($mode == "del") {
                
                    if($dtl_poster_id == $login_id) {
                    
                    $query_vist_del  = "DELETE FROM member_staff_visit WHERE uid = '$j_uid'"; 
                    $result_vist_del = mysql_query($query_vist_del);
                    if(!$result_vist_del) { error("QUERY_ERROR"); exit; }
                    
                    }
                
                } else if($mode == "add") {
                
                    $dtl_visit_dateA = $vday1 + $vday2 + $vday3;
                    $dtl_visit_dateB = $vtime1 + $vtime2;
                    $dtl_visit_dates = "$dtl_visit_dateA"."$dtl_visit_dateB";
                    
                    $dtl_visit_title = addslashes($dtl_visit_title);
                    $dtl_visit_memo = addslashes($dtl_visit_memo);
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_vist_add = "INSERT INTO member_staff_visit (uid,code,visit_date,visit_title,visit_place,
                        visitor,visit_memo,memo,poster_id,post_date,worship_hymn,worship_prayer,worship_bible,worship_lead) 
                        values ('','$mb_code','$dtl_visit_dates','$dtl_visit_title','$dtl_visit_place','$dtl_visitor',
                        '$dtl_visit_memo','$dtl_memo','$login_id','$post_dates',
                        '$dtl_worship_hymn','$dtl_worship_prayer','$dtl_worship_bible','$dtl_worship_lead')";
                    $result_vist_add = mysql_query($query_vist_add);
                    if (!$result_vist_add) { error("QUERY_ERROR"); exit; }
                
                } else if($mode == "upd") {
                
                    $dtl_visit_dateA = $vday1 + $vday2 + $vday3;
                    $dtl_visit_dateB = $vtime1 + $vtime2;
                    $dtl_visit_dates = "$dtl_visit_dateA"."$dtl_visit_dateB";
                    
                    $dtl_visit_title = addslashes($dtl_visit_title);
                    $dtl_visit_memo = addslashes($dtl_visit_memo);
                    $dtl_memo = addslashes($dtl_memo);
                
                    if($dtl_poster_id == $login_id) {
                    
                    $query_vist_upd1  = "UPDATE member_staff_visit SET visit_date = '$dtl_visit_dates', 
                        visit_title = '$dtl_visit_title', visit_place = '$dtl_visit_place', visitor = '$dtl_visitor', 
                        worship_hymn = '$dtl_worship_hymn', worship_prayer = '$dtl_worship_prayer', 
                        worship_bible = '$dtl_worship_bible', worship_lead = '$dtl_worship_lead', 
                        visit_memo = '$dtl_visit_memo', memo = '$dtl_memo' WHERE uid = '$j_uid'";
                    $result_vist_upd1 = mysql_query($query_vist_upd1);
                    if (!$result_vist_upd1) { error("QUERY_ERROR"); exit; }
                    
                    } else {
                    
                    $query_vist_upd2  = "UPDATE member_staff_visit SET memo = '$dtl_memo' WHERE uid = '$j_uid'";
                    $result_vist_upd2 = mysql_query($query_vist_upd2);
                    if (!$result_vist_upd2) { error("QUERY_ERROR"); exit; }
                    
                    }
                
                }
        
        
        
        
        } else if($tab == "9") {

        
            // Updates

                if($mode == "del") {
                
                    $query_pru_del  = "DELETE FROM member_staff_upd WHERE uid = '$j_uid'"; 
                    $result_pru_del = mysql_query($query_pru_del);
                    if(!$result_pru_del) { error("QUERY_ERROR"); exit; }
                

                } else if($mode == "upd") {
                
                    $dtl_memo = addslashes($dtl_memo);
                
                    $query_pru_upd9  = "UPDATE member_staff_upd SET upd_date = '$dtl_upd_date', memo = '$dtl_memo' 
                                        WHERE uid = '$j_uid'";
                    $result_pru_upd9 = mysql_query($query_pru_upd9);
                    if (!$result_pru_upd9) { error("QUERY_ERROR"); exit; }
                
                }




        } else {
        
        
        // Delete Photo
        if(!$photo1_chg) {
          $photo1_chg = "0";
        }
        $del_filename1 = "user_file/$org_photo1";
        
        if($org_photo1 != "none" AND $photo1_chg == "1") {
          if(!unlink($del_filename1)) {
            error("FILE_DELETE_FAILURE");
            exit;
          }

          $query_Pd1  = "UPDATE member_staff SET photo1 = 'none' WHERE uid = '$staff_uid'";
          $result_Pd1 = mysql_query($query_Pd1);
            if (!$result_Pd1) { error("QUERY_ERROR"); exit; }

        }
        
        
        // Upload Photo
        if($photofile1 != "") {

			  $full_filename1 = explode(".", "$photofile1_name");
			  $extension1 = $full_filename1[sizeof($full_filename1)-1];	   
	
			  if(strcmp($extension1,"jpg") AND 
			    strcmp($extension1,"JPG") AND 
			    strcmp($extension1,"jpeg") AND 
			    strcmp($extension1,"JPEG") AND 
			    strcmp($extension1,"gif") AND 
				strcmp($extension1,"GIF") AND 
			    strcmp($extension1,"png") AND 
			    strcmp($extension1,"PNG")) 
			  { 
			    error("NO_ACCESS_UPLOAD");
			    exit;
			  }

			  $new_filename1 = "photo_"."$mb_code"."_A."."$extension1";

			  // Upload File
        if($photofile1 != "") {
			    if(!copy("$photofile1","$savedir/$photofile1_name")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
			    if(!rename("$savedir/$photofile1_name","$savedir/$new_filename1")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
   	    }
   	    
   	    $query_P1  = "UPDATE member_staff SET photo1 = '$new_filename1' WHERE uid = '$staff_uid'";
        $result_P1 = mysql_query($query_P1);
        if (!$result_P1) { error("QUERY_ERROR"); exit; }
        }
        
        
        
        if($photofile2 != "") {

			  $full_filename2 = explode(".", "$photofile2_name");
			  $extension2 = $full_filename2[sizeof($full_filename2)-1];	   
	
			  if(strcmp($extension2,"jpg") AND 
			    strcmp($extension2,"JPG") AND 
			    strcmp($extension2,"jpeg") AND 
			    strcmp($extension2,"JPEG") AND 
			    strcmp($extension2,"gif") AND 
				strcmp($extension2,"GIF") AND 
			    strcmp($extension2,"png") AND 
			    strcmp($extension2,"PNG")) 
			  { 
			    error("NO_ACCESS_UPLOAD");
			    exit;
			  }

			  $new_filename2 = "photo_"."$mb_code"."_B."."$extension2";

			  // Upload File
        if($photofile2 != "") {
			    if(!copy("$photofile2","$savedir/$photofile2_name")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
			    if(!rename("$savedir/$photofile2_name","$savedir/$new_filename2")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
   	    }
   	    
   	    $query_P2  = "UPDATE member_staff SET photo2 = '$new_filename2' WHERE uid = '$staff_uid'";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }
        }
		
		
		// Password
		if($user_pwd != "") {

			if(!ereg("[[:alnum:]+]{4,12}",$user_pwd)) {
				error("INVALID_PASSWD");
				exit;
			}
			
			$query_Pwd  = "UPDATE member_staff SET passwd = password('$user_pwd') WHERE uid = '$staff_uid'";
			$result_Pwd = mysql_query($query_Pwd);
			if (!$result_Pwd) { error("QUERY_ERROR"); exit; }
		
		}
		
		
		// Update
		if ($userlevel == "1") {
			
			$query_M1  = "UPDATE member_staff SET gate = '$new_system_gate', id = '$user_id', mlist = '$mlist', 
				  email = '$email', homepage = '$homepage', phone_cel = '$phone_cel', memo = '$memo', 
				  userlevel = '$userlevel', expel_reason2 = '$expel_reason2', 
				  upd_id = '$login_id', upd_ip = '$m_ip', upd_date = '$post_dates', 
				  ctr_sa = '1', temp = '0' WHERE uid = '$staff_uid'";
			$result_M1 = mysql_query($query_M1);		
			
		} else if ($userlevel == "2") {
			
			$query_M1  = "UPDATE member_staff SET gate = '$new_system_gate', id = '$user_id', mlist = '$mlist', 
				  email = '$email', homepage = '$homepage', phone_cel = '$phone_cel', memo = '$memo', 
				  userlevel = '$userlevel', expel_reason2 = '$expel_reason2', 
				  upd_id = '$login_id', upd_ip = '$m_ip', upd_date = '$post_dates', 
				  ctr_sa = '0', temp = '0' WHERE uid = '$staff_uid'";
			$result_M1 = mysql_query($query_M1);			
			
		} else {
		
			$query_M1  = "UPDATE member_staff SET gate = '$new_system_gate', id = '$user_id', mlist = '$mlist', 
				  email = '$email', homepage = '$homepage', phone_cel = '$phone_cel', memo = '$memo', 
				  userlevel = '$userlevel', expel_reason2 = '$expel_reason2', 
				  upd_id = '$login_id', upd_ip = '$m_ip', upd_date = '$post_dates' WHERE uid = '$staff_uid'";
			$result_M1 = mysql_query($query_M1);
			if (!$result_M1) { error("QUERY_ERROR"); exit; }
			
		}
		
  }



      
    } else if($step_next_form == "basic") {
    

        // Data Extraction
        $query_um = "SELECT job1,job2,marital_status,spouse_link,spouse_code,fam_head,fam_code,age_group,
                    dir1_code,group1_code,group2_code,userlevel,regis_date,expel_date,expel_reason,passing_date,
					job_class,pay_class,payroll_code,deduction_code,branch_code,corp_dept_code FROM member_staff WHERE code = '$mb_code'";
        $result_um = mysql_query($query_um);
          if (!$result_um) { error("QUERY_ERROR"); exit; }

        $um_job1 = @mysql_result($result_um,0,0);
        $um_job2 = @mysql_result($result_um,0,1);
        $um_marital_status = @mysql_result($result_um,0,2);
        $um_spouse_link = @mysql_result($result_um,0,3);
        $um_spouse_code = @mysql_result($result_um,0,4);
        $um_fam_head = @mysql_result($result_um,0,5);
        $um_fam_code = @mysql_result($result_um,0,6);
        $um_age_group = @mysql_result($result_um,0,7);
        $um_dir1_code = @mysql_result($result_um,0,8);
        $um_group1_code = @mysql_result($result_um,0,9);
        $um_group2_code = @mysql_result($result_um,0,10);
        $um_userlevel = @mysql_result($result_um,0,11);
        $um_regis_date = @mysql_result($result_um,0,12);
        $um_expel_date = @mysql_result($result_um,0,13);
        $um_expel_reason = @mysql_result($result_um,0,14);
        $um_passing_date = @mysql_result($result_um,0,15);
		$um_job_class = @mysql_result($result_um,0,16);
		$um_pay_class = @mysql_result($result_um,0,17);
		$um_payroll_code = @mysql_result($result_um,0,18);
		$um_deduction_code = @mysql_result($result_um,0,19);
		$um_branch_code = @mysql_result($result_um,0,20);
		$um_corp_dept_code = @mysql_result($result_um,0,21);
        
        // Faith Level
        $query_um2 = "SELECT uid,faith_level FROM member_staff_religion WHERE code = '$mb_code' 
                      ORDER BY relg_in DESC, post_date DESC";
        $result_um2 = mysql_query($query_um2);
          if (!$result_um2) { error("QUERY_ERROR"); exit; }

        $um2_faith_uid = @mysql_result($result_um2,0,0);
        $um2_faith_level = @mysql_result($result_um2,0,1);
        
        // Payroll Code
		$new_payroll_code = "$job_class"."-"."$pay_class";
		
		// Department Code & Name
		$dept_code_mid = substr($corp_dept_code,0,4);
		$dept_code_3rd = substr($corp_dept_code,4,2);
		
		if($dept_code_3rd > "0") {
			$dc3a_query = "SELECT sname FROM dept_catgsml WHERE scode = '$corp_dept_code'";
			$dc3a_result = mysql_query($dc3a_query);
				if (!$dc3a_result) { error("QUERY_ERROR"); exit; }
			$new_corp_dept = @mysql_result($dc3a_result,0,0);
				$new_corp_dept = stripslashes($new_corp_dept);
		} else {
			$dc3b_query = "SELECT mname FROM dept_catgmid WHERE mcode = '$dept_code_mid'";
			$dc3b_result = mysql_query($dc3b_query);
				if (!$dc3b_result) { error("QUERY_ERROR"); exit; }
			$new_corp_dept = @mysql_result($dc3b_result,0,0);
				$new_corp_dept = stripslashes($new_corp_dept);
		}
		
		
		
        
        // [1] Update - Registration Date is Default Date
        $query_uc = "SELECT count(uid) FROM member_staff_upd WHERE code = '$mb_code'";
        $result_uc = mysql_query($query_uc);
          if (!$result_uc) { error("QUERY_ERROR"); exit; }
        $uc_cnt = @mysql_result($result_uc,0,0);
        
        if($uc_cnt == 0) {

          $query_uc1 = "INSERT INTO member_staff_upd (uid,code,upd_date,job_class,pay_class,marital_status,spouse_link,spouse_code,
              fam_head,fam_code,age_group,dir1_code,group1_code,group2_code,userlevel,regis_date,expel_date,expel_reason,
              passing_date,signdate,branch_code,payroll_code,deduction_code,corp_dept_code,corp_dept) 
			  VALUES ('','$mb_code','$regis_date_dash','$job_class','$pay_class','$marital_status',
              '$spouse_link','$spouse_code','$fam_head','$fam_code','$age_group','$dir1_code',
              '$group1_code','$group2_code','$userlevel','$regis_date','$expel_date','$expel_reason',
              '$passing_date','$post_dates','$mb_branch_code','$new_payroll_code','$deduction_code','$corp_dept_code','$new_corp_dept')";
          $result_uc1 = mysql_query($query_uc1);
            if (!$result_uc1) { error("QUERY_ERROR"); exit; }

        } else {
        
        // Update from Comparison
        if($um_branch_code != $new_branch_code OR $um_job_class != $job_class OR $um_pay_class != $pay_class OR $um_deduction_code != $deduction_code  
			OR $um_marital_status != $marital_status OR $um_corp_dept_code != $corp_dept_code) {
        
          $query_uc2 = "INSERT INTO member_staff_upd (uid,code,upd_date,job_class,pay_class,marital_status,spouse_link,spouse_code,
              fam_head,fam_code,age_group,dir1_code,group1_code,group2_code,userlevel,regis_date,expel_date,expel_reason,
              passing_date,signdate,branch_code,payroll_code,deduction_code,corp_dept_code,corp_dept) 
			  VALUES ('','$mb_code','$post_date1s','$job_class','$pay_class','$marital_status',
              '$spouse_link','$spouse_code','$fam_head','$fam_code','$age_group','$dir1_code','$group1_code',
              '$group2_code','$userlevel','$regis_date','$expel_date','$expel_reason','$passing_date','$post_dates','$new_branch_code',
			  '$new_payroll_code','$deduction_code','$corp_dept_code','$new_corp_dept')";
          $result_uc2 = mysql_query($query_uc2);
            if (!$result_uc2) { error("QUERY_ERROR"); exit; }
        
        }
        
        }
        
        
        // [2] Religion
        $query_uc4 = "SELECT count(uid) FROM member_staff_religion WHERE code = '$mb_code'";
        $result_uc4 = mysql_query($query_uc4);
          if (!$result_uc4) { error("QUERY_ERROR"); exit; }
        $uc4_cnt = @mysql_result($result_uc4,0,0);
        
        if($uc4_cnt == 0) {

          $query_uc4a = "INSERT INTO member_staff_religion (uid,code,religion,faith_level,relg_in,post_date) 
                        VALUES ('','$mb_code','1','$faith_level','$post_year','$post_dates')";
          $result_uc4a = mysql_query($query_uc4a);
            if (!$result_uc4a) { error("QUERY_ERROR"); exit; }

        } else {
        
        // Update from Comparison
        if($um2_faith_level != $faith_level) {
        
          $query_uc4b = "UPDATE member_staff_religion SET faith_level = '$faith_level' WHERE uid = '$um2_faith_uid'";
          $result_uc4b = mysql_query($query_uc4b);
            if (!$result_uc4b) { error("QUERY_ERROR"); exit; }
        
        }
        
        }
        
        
        
        
        // Spouse
        if($spouse_link == "1" AND $spouse_code != "") {
          $query_MS1 = "UPDATE member_staff SET marital_status = '$marital_status', spouse_link = '1', 
                        spouse_code = '$mb_code' WHERE code = '$spouse_code'";
          $result_MS1 = mysql_query($query_MS1);
          if (!$result_MS1) { error("QUERY_ERROR"); exit; }
        }
        
        // Family
        if($spouse_link == "0") {
        if($fam_degree == "1" OR $fam_degree == "2") {
          $query_MS3 = "UPDATE member_staff SET fam_degree = '$fam_degree' WHERE uid = '$staff_uid'";
          $result_MS3 = mysql_query($query_MS3);
          if (!$result_MS3) { error("QUERY_ERROR"); exit; }
        } else if($fam_degree == "9") {
          $query_MS4 = "UPDATE member_staff SET fam_degree = '9', fam_degree2 = '$fam_degree2' WHERE uid = '$staff_uid'";
          $result_MS4 = mysql_query($query_MS4);
          if (!$result_MS4) { error("QUERY_ERROR"); exit; }
        }
        }
        
        // Family Head
        /*
        if($fam_head == "0" AND $fam_code != "") {
          $query_MS2 = "UPDATE member_staff SET fam_head = '1' WHERE code = '$fam_code'";
          $result_MS2 = mysql_query($query_MS2);
          if (!$result_MS2) { error("QUERY_ERROR"); exit; }
        }
        */

        // Retirement & Resign
        if($expel_date != "" OR $expel_reason == "9") {
          $query_MS5 = "UPDATE member_staff SET userlevel = '0' WHERE uid = '$staff_uid'";
          $result_MS5 = mysql_query($query_MS5);
          if (!$result_MS5) { error("QUERY_ERROR"); exit; }
        } else {
          if ($new_userlevel == 4) {
              $query_4 = "SELECT userlevel FROM member_staff WHERE uid = '$staff_uid'";
              $result_4 = mysql_query($query_4);
              if(!$result_4) { error("QUERY_ERROR"); exit; }

              $userlevel_4 = mysql_result($result_4,0,0);
              $new_userlevel = $userlevel_4;
              //var_dump($new_userlevel); die();
              #$query_MS6 = "UPDATE member_staff SET userlevel = '$new_userlevel', temp = '1' WHERE uid = '$staff_uid'";
              #$result_MS6 = mysql_query($query_MS6);
              #if (!$result_MS6) { error("QUERY_ERROR"); exit; }
          }
          $query_MS6 = "UPDATE member_staff SET userlevel = '$new_userlevel' WHERE uid = '$staff_uid'";
          $result_MS6 = mysql_query($query_MS6);
          if (!$result_MS6) { error("QUERY_ERROR"); exit; }
        }
        

		if($login_level > "8") { // Change User Name & Gender
			
			$query_MN  = "UPDATE member_staff SET name = '$new_name', gender = '$gender' WHERE uid = '$staff_uid'";
			$result_MN = mysql_query($query_MN);
			if (!$result_MN) { error("QUERY_ERROR"); exit; }
/*
      $query_UN  = "UPDATE admin_user SET user_name = '$new_name' WHERE ";
      $result_UN = mysql_query($query_UN);
      if (!$result_UN) { error("QUERY_ERROR"); exit; }
*/
		}
		

		
		// REMOVED dir1_code = '$dir1_code'
		$query_M0  = "UPDATE member_staff SET branch_code = '$new_branch_code', ctr_branch_code = '$ctr_branch_code', 
			corp_title = '$corp_title', job_class = '$job_class', pay_class = '$pay_class', payroll_code = '$new_payroll_code', deduction_code = '$deduction_code',
              name2 = '$new_name2', birthday = '$birth_date', calendar = '$calendar', guide = '$guide', 
              passport_no = '$passport_no', passport_expire = '$passport_expire', nationality_code = '$nationality_code', 
              visa_type = '$visa_type', marital_status = '$marital_status', spouse_link = '$spouse_link', 
              spouse_code = '$spouse_code', spouse_name = '$spouse_name', fam_head = '$fam_head', fam_code = '$fam_code', 
              job1 = '$job1', job2 = '$job2', age_group = '$age_group', corp_dept_code = '$corp_dept_code', corp_dept = '$new_corp_dept', 
              group1_code = '$group1_code', group2_code = '$group2_code', regis_date = '$regis_date', 
              expel_date = '$expel_date', expel_reason = '$expel_reason', passing_date = '$passing_date', 
			  religion = '$religion', idcard_no = '$idcard_no', fam_child = '$fam_child' WHERE uid = '$staff_uid'";
        $result_M0 = mysql_query($query_M0);
        if (!$result_M0) { error("QUERY_ERROR"); exit; }
    
    
    }
    
    
    $query_final  = "UPDATE member_staff SET upd_id = '$login_id', upd_ip = '$m_ip', upd_date = '$post_dates' 
                    WHERE uid = '$staff_uid'";
    $result_final = mysql_query($query_final);
      if (!$result_final) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/hr_member_upd.php?uid=$staff_uid&keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&tab=$tab&hr_type=$hr_type&hr_retire=$hr_retire'>");
  exit;
  

  }
  

}

}
?>
