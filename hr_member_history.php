<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "hr";
$smenu = "hr_member_history";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/hr_member_history.php";
$link_post = "$home/hr_member_work_post.php";
$link_upd = "$home/hr_member_work_upd.php";
$link_del = "$home/hr_member_work_del.php";
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

    <!--dynamic table-->
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
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
	
	<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>
	
  </head>

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>

<?
// Date
$rs_year = substr($report_start_date,0,4);
$rs_month = substr($report_start_date,4,2);
$rs_date = substr($report_start_date,6,2);
$rs_report_date2 = "$rs_year"."-"."$rs_month"."-"."$rs_date";

$signdate = time();

$today = date("Ymd");
$today2 = date("Y-m-d");

if(!$p_date_sets) { $p_date_sets = $today2; }
		
	$p_date_xpd = explode("-",$p_date_sets);
	$p_year = $p_date_xpd[0];
	$p_month = $p_date_xpd[1];
	$p_date = $p_date_xpd[2];
	
	$p_daynum = date('w', mktime(0,0,0,$p_month,$p_date,$p_year)); // 0: Sunday, 6: Saturday
	
	if($p_daynum == 0) {
		$p_day_txt = "L";
	} else if($p_daynum == 6) {
		$p_day_txt = "NS";
	} else {
		$p_day_txt = "N";
	}
	


// Filtering
if(!$sorting_key) { $sorting_key = "name"; }
// if(!$sorting_key) { $sorting_key = "signdate"; }

if($sorting_key == "signdate" OR $sorting_key == "userlevel") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "userlevel") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "code") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "birthday") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "signdate") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "regis_date") { $chk5 = "selected"; } else { $chk5 = ""; }
if($sorting_key == "id") { $chk6 = "selected"; } else { $chk6 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if($hr_dir) {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '0' AND dir1_code = '$hr_dir'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '0' AND $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir'";  
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '1' AND dir1_code = '$hr_dir'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '1' AND $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir'";  
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE dir1_code = '$hr_dir'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir'";  
	}
}
} else {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '0' AND $keyfield LIKE '%$key%'";  
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '1' AND $keyfield LIKE '%$key%'";  
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE $keyfield LIKE '%$key%'";  
	}
}	
}

$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);
?>

	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                <div class="col-sm-12">
              <section class="panel">
              <header class="panel-heading">
					<?echo("$txt_hr_work_011")?> &gt; <?=$txt_stf_staff_01?> 
					<?
					if($hr_type == "1") {
						echo ("($txt_hr_member_382)");
					} else if($hr_type == "2") {
						echo ("($txt_hr_member_381)");
					}
					?>
			
             <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-times"></a>
             </span>
              </header>
              <div class="panel-body">
			  
			  
				<div class="row">
				<div class="col-sm-3">
			
				<?
				$queryC = "SELECT count(uid) FROM client_branch WHERE branch_code != 'CORP_01' AND userlevel > '0'";
				$resultC = mysql_query($queryC);
				$total_recordC = mysql_result($resultC,0,0);

				$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code != 'CORP_01' AND userlevel > '0' 
							ORDER BY branch_code ASC, userlevel DESC";
				$resultD = mysql_query($queryD);

				echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
				echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");

				for($i = 0; $i < $total_recordC; $i++) {
					$menu_code = mysql_result($resultD,$i,0);
					$menu_name = mysql_result($resultD,$i,1);
        
					if($menu_code == $key) {
						$slc_gate = "selected";
						$slc_disable = "";
					} else {
						$slc_gate = "";
						$slc_disable = "disabled";
					}

					echo("<option value='$PHP_SELF?keyfield=branch_code&key=$menu_code&hr_type=$hr_type&hr_dir=$hr_dir' $slc_gate>$menu_name</option>");
				}
				echo("</select>");
				?>
			
				</div>
				
				<div class="col-sm-3">
			
				<?
				if($keyfield == "branch_code") {
				$queryE = "SELECT count(uid) FROM client WHERE branch_code = '$key' AND userlevel > '0'";
				$resultE = mysql_query($queryE);
				$total_recordE = mysql_result($resultE,0,0);

				$queryF = "SELECT client_id,client_name FROM client WHERE branch_code = '$key' AND userlevel > '0' 
							ORDER BY client_id ASC";
				$resultF = mysql_query($queryF);

				echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
				echo("<option value='$PHP_SELF'>:: $txt_comm_frm240</option>");

				for($f = 0; $f < $total_recordE; $f++) {
					$client_code = mysql_result($resultF,$f,0);
					$client_name = mysql_result($resultF,$f,1);
        
					if($client_code == $hr_dir) {
						$slc_dir = "selected";
						$slc_dir_disable = "";
					} else {
						$slc_dir = "";
						$slc_dir_disable = "disabled";
					}

					echo("<option value='$PHP_SELF?keyfield=branch_code&key=$key&hr_type=$hr_type&hr_dir=$client_code' $slc_dir>[ $client_code ] $client_name</option>");
				}
				echo("</select>");
				}
				?>
			
				</div>
				
				<div class="col-sm-3"></div>
				
				<form name='search_date' method='post' action='hr_member_history.php'>
				<input type='hidden' name='hr_type' value='<?=$hr_type?>'>
				<input type='hidden' name='hr_dir' value='<?=$hr_dir?>'>
				<input type='hidden' name='date_key' value='1'>
			
				<div class="col-sm-3">
					<div class="input-group m-bot15">
                        <input type="date" name="p_date_sets" class="form-control" value="<?=$p_date_sets?>" min="<?=$rs_report_date2?>" max="<?=$today2?>">
                        <span class="input-group-btn">
                            <input type="submit" class="btn btn-white" value="Go">
                        </span>
                    </div>
				</div>
				</div>
				</form>
			  		  
			  
              <div class="adv-table">
              <table class="display table table-bordered table-striped table-condensed" id="dynamic-table">
              <thead>
              <tr>
                <th><?=$txt_comm_frm23?></th>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_hr_work_04?></th>
				<th><?=$txt_hr_work_05?></th>
				<th><?=$txt_hr_work_06?></th>
				<th><?=$txt_hr_work_07?></th>
				<th><?=$txt_hr_work_17?></th>
				<th><i class="fa fa-thumbs-o-down"></i></th>
				<!--<th>Tick for Updated</th>-->
				<th></th>
              </tr>
              </thead>
              <tbody>
              <?
$time_limit = 60*60*24*$notify_new_article; 

if($hr_dir) {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '0' AND dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '0' AND $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '1' AND dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '1' AND $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE $keyfield LIKE '%$key%' AND dir1_code = '$hr_dir' ORDER BY $sorting_key $sort_now";
	}
}
} else {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '0' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '1' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE ctr_sa = '1' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,regis_date
				FROM member_staff WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
}
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);



for($i = $first; $i < $total_record; $i++) {
   $uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$branch_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$group_branch_name = @mysql_result($result_gname,0,0);
   $user_gate = mysql_result($result,$i,2);
   $user_code = mysql_result($result,$i,3);
   $user_name = mysql_result($result,$i,4);
   $user_gender = mysql_result($result,$i,5);
   $user_birthday = mysql_result($result,$i,6);
   $email = mysql_result($result,$i,7);
   $userlevel = mysql_result($result,$i,8);
   $signdate = mysql_result($result,$i,9);
   $user_mb_id = mysql_result($result,$i,10);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $user_regis_date = mysql_result($result,$i,11);
	$regis_date_ex = explode("-",$user_regis_date);
	if($lang == "ko") {
		$regis_dates = "$regis_date_ex[0]"."/"."$regis_date_ex[1]"."/"."$regis_date_ex[2]";
	} else {
		$regis_dates = "$regis_date_ex[2]"."-"."$regis_date_ex[1]"."-"."$regis_date_ex[0]";
	}
   
	
	// ¼ºº°
  if($user_gender == "M") {
    $user_gender_txt = "<font color=blue>$txt_stf_staff_10</font>";
  } else if($user_gender == "F") {
    $user_gender_txt = "<font color=red>$txt_stf_staff_11</font>";
  }
  
  // »ý³â¿ùÀÏ
  $uday1 = substr($user_birthday,0,4);
	$uday2 = substr($user_birthday,4,2);
	$uday3 = substr($user_birthday,6,2);

  if($lang == "ko") {
	  $user_birthday_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	} else {
	  $user_birthday_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	}
  

  // °Ë»ö¾î ÆùÆ®»ö±ò ÁöÁ¤
  if(!strcmp($key,"$name") && $key) {
    $name = eregi_replace("($key)", "<font color=navy>\\1</font>", $name);
  }
  if(!strcmp($key,"$code") && $key) {
    $user_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_code);
  }


  echo ("<tr class='gradeC'>");
  echo("<td>$group_branch_name</td>");


  
  echo("<td>$user_name</td>");
   

  // È¸¿ø±¸ºÐ
  if($userlevel == "0") {
	  $level_name = "<font color=red>Hold</font>";
  } else if($userlevel == "1") {
	  $level_name = "-&gt;-";
  } else if($userlevel == "2") {
	  $level_name = "<font color=blue>Front Desk</font>";
  } else if($userlevel == "3") {
	  $level_name = "<font color=blue>Local Admin</font>";
  } else if($userlevel == "4") {
	  $level_name = "Back-Office";
  } else if($userlevel == "5") {
	  $level_name = "Admin";
  } else {
	  $level_name = "Unknown";
  }

	// Work
	$query_Hc = "SELECT count(uid) FROM member_staff_history WHERE code = '$user_code' AND date = '$p_date_sets' ORDER BY uid DESC";
    $result_Hc = mysql_query($query_Hc);
		if (!$result_Hc) {   error("QUERY_ERROR");   exit; }
    $H_count = @mysql_result($result_Hc,0,0);
	
	$query_H = "SELECT uid,nik,history FROM member_staff_history WHERE code = '$user_code' AND date = '$p_date_sets' ORDER BY uid DESC";
    $result_H = mysql_query($query_H);
		if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
    $H_uid = @mysql_result($result_H,0,0);
    $H_nik = @mysql_result($result_H,0,1);
    $H_history = @mysql_result($result_H,0,2);
    $H_ex_history = explode("|", $H_history);
	$H_work_status = $H_ex_history[0];
	$H_work_off_type = $H_ex_history[1];
	$H_work_time1 = $H_ex_history[2];
	$H_work_time2 = $H_ex_history[3];
	$H_work_in = $H_ex_history[4];
	$H_work_out = $H_ex_history[5];
	$H_off_report = $H_ex_history[6];
	$H_off_report_why = $H_ex_history[7];
	$H_warning = $H_ex_history[8];
	$H_work_in_early = $H_ex_history[9];
	$H_work_in_late = $H_ex_history[10];
	$H_work_out_early = $H_ex_history[11];
	$H_work_hours = $H_ex_history[12];
	$H_work_over = $H_ex_history[13];
	
	if($H_count > 0) {
		$step_action = "update";
		$step_submit = $txt_comm_frm12;
		$p_work_chk_txt = "<i class='fa fa-check-square-o'></i>";
	} else {
		$step_action = "post";
		$step_submit = $txt_comm_frm01s;
		$p_work_chk_txt = "&nbsp;";
	}
	
	if($H_count > 0) {
			$H2_work_times = "$H_work_time1"."~"."$H_work_time2";
			$H2_work_in = $H_work_in;
			$H2_work_out = $H_work_out;
	} else {
		if($p_daynum == 0) {
			$H2_work_times = "00:00"."~"."00:00";
			$H2_work_in = "00:00";
			$H2_work_out = "00:00";
		} else if($p_daynum == 6) {
			$H2_work_times = "08:30"."~"."12:00";
			$H2_work_in = "08:30";
			$H2_work_out = "12:00";
		} else {
			$H2_work_times = "08:30"."~"."17:30";
			$H2_work_in = "08:30";
			$H2_work_out = "17:30";
		}
	}
	if($H_work_off_type == "1") {
		$H_work_off_type_chk1 = "selected";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "2") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "selected";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "3") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "selected";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "4") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "selected";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "5") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "selected";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "6") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "selected";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "7") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "selected";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "8") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "selected";
		$H_work_off_type_chk9 = "";
	} else if($H_work_off_type == "9") {
		$H_work_off_type_chk1 = "";
		$H_work_off_type_chk2 = "";
		$H_work_off_type_chk3 = "";
		$H_work_off_type_chk4 = "";
		$H_work_off_type_chk5 = "";
		$H_work_off_type_chk6 = "";
		$H_work_off_type_chk7 = "";
		$H_work_off_type_chk8 = "";
		$H_work_off_type_chk9 = "selected";
	}
	
	if($H_warning == "1") {
		$H_warning_chk = "checked";
	} else {
		$H_warning_chk = "";
	}
	
	echo ("
	<form name='signform1' method='post' action='hr_member_history.php'>
    <input type='hidden' name='step_next' value='permit_okay'>
	<input type='hidden' name='step_action' value='$step_action'>
	<input type='hidden' name='new_uid' value=\"$H_uid\">
	<input type='hidden' name='new_date_sets' value=\"$p_date_sets\">
	<input type='hidden' name='new_shift' value=\"$p_day_txt\">
	<input type='hidden' name='new_branch_code' value=\"$branch_code\">
	<input type='hidden' name='new_user_code' value=\"$user_code\">
	<input type='hidden' name='new_user_name' value=\"$user_name\">
	<input type='hidden' name='new_user_nik' value=\"$H_nik\">
	<input type='hidden' name='hr_type' value=\"$hr_type\">
	<input type='hidden' name='hr_dir' value=\"$hr_dir\">
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">

	
	<!--<td><input type='text' name='nik' value='$H_nik' style='width:50px; border:1px solid #ffffff'></td>-->
	<!--<td>$p_date_sets</td>-->
	<td>$p_day_txt &nbsp; $p_work_chk_txt</td>");
	
	if($H_count > 0 AND $H_work_status > 0 AND $H_work_hours > "0") {
		echo ("<td><input type='text' name='work_times' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$txt_hr_work_12 - $H_work_hours' value='$H2_work_times' placeholder='00:00~00:00' data-mask='99:99~99:99' style='width:90px; border:1px solid #ffffff'></td>");
	} else {
		echo ("<td><input type='text' name='work_times' value='$H2_work_times' placeholder='00:00~00:00' data-mask='99:99~99:99' style='width:90px; border:1px solid #ffffff'></td>");
	}
	
	if($H_count > 0 AND $H_work_status > 0 AND $H_work_in_early > "0") {
		echo ("<td><input type='text' name='work_in' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$txt_hr_work_08 - $H_work_in_early' value='$H_work_in' placeholder='00:00' data-mask='99:99' style='width:40px; border:1px solid #ffffff'></td>");
	} else if($H_count > 0 AND $H_work_status > 0 AND $H_work_in_late > "0") {
		echo ("<td><input type='text' name='work_in' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$txt_hr_work_09 - $H_work_in_late' value='$H_work_in' placeholder='00:00' data-mask='99:99' style='width:40px; border:1px solid #ffffff'></td>");
	} else {
		echo ("<td><input type='text' name='work_in' value='$H_work_in' placeholder='00:00' data-mask='99:99' style='width:40px; border:1px solid #ffffff'></td>");
	}
	
	if($H_count > 0 AND $H_work_status > 0 AND $H_work_out_early > "0") {
		echo ("<td><input type='text' name='work_out' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$txt_hr_work_10 - $H_work_out_early' value='$H_work_out' placeholder='00:00' data-mask='99:99' style='width:40px; border:1px solid #ffffff'></td>");
	} else {
		echo ("<td><input type='text' name='work_out' value='$H_work_out' placeholder='00:00' data-mask='99:99' style='width:40px; border:1px solid #ffffff'></td>");
	}
	
	echo ("	
	<td>
		<select name='work_off_type'>");
		if($H_count > 0) {
			if($H_work_in > 0) {
				echo ("
				<option value='on'>ON</option>");
			} else {
				echo ("
				<option>OFF</option>
				<option value='1' $H_work_off_type_chk1>$txt_hr_work_171</option>
				<option value='2' $H_work_off_type_chk2>$txt_hr_work_172</option>
				<option value='3' $H_work_off_type_chk3>$txt_hr_work_173</option>
				<option value='4' $H_work_off_type_chk4>$txt_hr_work_174</option>
				<option value='5' $H_work_off_type_chk5>$txt_hr_work_175</option>
				<option value='6' $H_work_off_type_chk6>$txt_hr_work_176</option>
				<option value='7' $H_work_off_type_chk7>$txt_hr_work_177</option>
				<option value='8' $H_work_off_type_chk8>$txt_hr_work_178</option>
				<option value='9' $H_work_off_type_chk9>$txt_hr_work_179</option>
				");
			}
		} else {
				echo ("
				<option></option>
				<option value='1'>$txt_hr_work_171</option>
				<option value='2'>$txt_hr_work_172</option>
				<option value='3'>$txt_hr_work_173</option>
				<option value='4'>$txt_hr_work_174</option>
				<option value='5'>$txt_hr_work_175</option>
				<option value='6'>$txt_hr_work_176</option>
				<option value='7'>$txt_hr_work_177</option>
				<option value='8'>$txt_hr_work_178</option>
				<option value='9'>$txt_hr_work_179</option>
				");
		}
		echo ("
		</select>
	</td>
	<td><input type='checkbox' name='warning' value='1' $H_warning_chk></td>
    <td><input type='submit' value='$step_submit' class='btn btn-default btn-xs'></td>
    </form>	
	");
	
	
  echo("</tr>");

   $article_num--;
}
?>
 
              </tbody>        
              <tfoot>
              <tr>
                <th><?=$txt_comm_frm23?></th>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_hr_work_04?></th>
				<th><?=$txt_hr_work_05?></th>
				<th><?=$txt_hr_work_06?></th>
				<th><?=$txt_hr_work_07?></th>
				<th><?=$txt_hr_work_17?></th>
				<th><i class="fa fa-thumbs-o-down"></i></th>
				<th></th>
              </tr>
              </tfoot>
              </table>


              </div>
              </div>
              <!--<input type="submit" name="histories" value="<?=$step_submit; ?>" class="btn btn-primary">
              </form>-->                    
              </section>
              </div>
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
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	
	<script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init.js"></script>


    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

  </body>
</html>



<?
} else if($step_next == "permit_okay") {
	
	if(!$warning) { $warning = "0"; }
	
	if($work_off_type == "on") {
			$new_work_status = "2";
			$new_work_off_type = "";
	} else {
		if($work_in > "0") {
			$new_work_status = "2";
			$new_work_off_type = "";
		} else {
			$new_work_status = "0";
			$new_work_off_type = $work_off_type;
		}
	}
	
	$work_times_xpd = explode("~",$work_times);
	$work_time1 = $work_times_xpd[0];
		$work_time1_xpd = explode(":",$work_time1);
		$work_time1h = $work_time1_xpd[0];
		$work_time1m = $work_time1_xpd[1];
	$work_time2 = $work_times_xpd[1];
		$work_time2_xpd = explode(":",$work_time2);
		$work_time2h = $work_time2_xpd[0];
		$work_time2m = $work_time2_xpd[1];
	
	$work_in_xpd = explode(":",$work_in);
		$work_inh = $work_in_xpd[0];
		$work_inm = $work_in_xpd[1];
	$work_out_xpd = explode(":",$work_out);
		$work_outh = $work_out_xpd[0];
		$work_outm = $work_out_xpd[1];
	
	
	// CPT DTG
	if($work_time1 > $work_in) {
		$work_in1h_diff = $work_time1h - $work_inh;
		$work_in1m_diff = $work_time1m - $work_inm;
	
		if($work_in1m_diff < 0) {
			$work_in1h = $work_in1h_diff + 1;
			$work_in1m = $work_in1m_diff + 60;
		} else {
			$work_in1h = $work_in1h_diff;
			$work_in1m = $work_in1m_diff;
		}
		$new_work_in_early = "$work_in1h".":"."$work_in1m";
	} else {
		$new_work_in_early = "";
	}
	
	// Lateness
	if($work_time1 < $work_in) {
		$work_in2h_diff = $work_inh - $work_time1h;
		$work_in2m_diff = $work_inm - $work_time1m;
	
		if($work_in2m_diff < 0) {
			$work_in2h = $work_in2h_diff + 1;
			$work_in2m = $work_in2m_diff + 60;
		} else {
			$work_in2h = $work_in2h_diff;
			$work_in2m = $work_in2m_diff;
		}
		$new_work_in_late = "$work_in2h".":"."$work_in2m";
	} else {
		$new_work_in_late = "";
	}
	
	// CPT PLG
	if($work_time2 > $work_out) {
		$work_out1h_diff = $work_time2h - $work_outh;
		$work_out1m_diff = $work_time2m - $work_outm;
	
		if($work_out1m_diff < 0) {
			$work_out1h = $work_out1h_diff + 1;
			$work_out1m = $work_out1m_diff + 60;
		} else {
			$work_out1h = $work_out1h_diff;
			$work_out1m = $work_out1m_diff;
		}
		$new_work_out_early = "$work_out1h".":"."$work_out1m";
	} else {
		$new_work_out_early = "";
	}
	
	// Overwork
	if($work_out > $work_time2) {
		$work_over1h_diff = $work_outh - $work_time2h;
		$work_over1m_diff = $work_outm - $work_time2m;
	
		if($work_over1m_diff < 0) {
			$work_over1h = $work_over1h_diff - 1;
			$work_over1m = $work_over1m_diff + 60;
		} else {
			$work_over1h = $work_over1h_diff;
			$work_over1m = $work_over1m_diff;
		}
		$new_work_over = "$work_over1h".":"."$work_over1m";
	} else {
		$new_work_over = "";
	}

	// JAM KERJA
	$work_hrs_diff_h = $work_outh - $work_inh;
	$work_hrs_diff_m = $work_outm - $work_inm;
	
	if($work_hrs_diff_m < 0) {
		$work_hrs_h = $work_hrs_diff_h + 1;
		$work_hrs_m = $work_hrs_diff_m + 60;
	} else {
		$work_hrs_h = $work_hrs_diff_h;
		$work_hrs_m = $work_hrs_diff_m;
	}
	$new_work_hours = "$work_hrs_h".":"."$work_hrs_m";
		
	$insert_history = array($new_work_status,$new_work_off_type,$work_time1,$work_time2,$work_in,$work_out,$new_work_in_early,$new_work_in_late,$new_work_out_early,$new_work_hours,$warning,$new_work_over);
	$im_history = implode("|", $insert_history);
	$today3 = date("Y-m-d");
	
	// Database
	if($step_action == "post") {
			$query_add = "INSERT INTO member_staff_history (uid,branch_code,code,name,nik,date,shift,history)
				VALUES ('','$new_branch_code','$new_user_code','$new_user_name','$new_user_nik','$new_date_sets','$new_shift','$im_history')";
			$result_add = mysql_query($query_add);
			if(!$result_add) { error("QUERY_ERROR"); exit; }
  
	} else if($step_action == "update") {
			$result2 = mysql_query("UPDATE member_staff_history SET nik = '$new_user_nik', history = '$im_history' WHERE uid = '$new_uid'");
			if (!$result2) { error("QUERY_ERROR"); exit;	}
	}
  

  echo("<meta http-equiv='Refresh' content='0; URL=$home/hr_member_history.php?hr_type=$hr_type&hr_dir=$hr_dir&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&p_date_sets=$new_date_sets'>");
  exit;

}

}
?>
