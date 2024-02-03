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

$link_list = "$home/hr_member.php";
$link_post = "$home/hr_member_post.php?hr_type=$hr_type&hr_retire=$hr_retire";
$link_upd = "$home/hr_member_upd.php";
$link_del = "$home/hr_member_del.php";
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
if(!$hr_retire) { $hr_retire = "0"; }
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
if($hr_retire == "0") {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0' AND ctr_sa = '0' OR ctr_sa = '2' AND temp = '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0' AND ctr_sa = '0' OR ctr_sa = '2' AND temp = '0' $keyfield LIKE '%$key%'";  
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0' AND ctr_sa = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0' AND ctr_sa = '1' AND $keyfield LIKE '%$key%'";  
	}
} else if($hr_type == "3") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '2' OR temp = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE ctr_sa = '2' OR temp = '1' AND $keyfield LIKE '%$key%'";  
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel > '0' AND $keyfield LIKE '%$key%'";  
	}
}
} else {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND ctr_sa = '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND ctr_sa = '0' AND $keyfield LIKE '%$key%'";  
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND ctr_sa = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND ctr_sa = '1' AND $keyfield LIKE '%$key%'";  
	}
} else if($hr_type == "3") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND temp = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND temp = '1' AND $keyfield LIKE '%$key%'";  
	}	
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM member_staff WHERE userlevel = '0' AND $keyfield LIKE '%$key%'";  
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
                  <?=$txt_stf_staff_01?> 
					<?
					if($hr_type == "1") {
						echo ("($txt_hr_member_382)");
					} else if($hr_type == "2") {
						echo ("($txt_hr_member_381)");
					} else if($hr_type == "3") {
						echo ("($txt_hr_member_383)");
					}
					?>
			
             <span class="tools pull-right">
				<a href="<?=$link_post?>" class="fa fa-pencil"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
                <a href="javascript:;" class="fa fa-times"></a>
             </span>
              </header>
              <div class="panel-body">
			  
			  
				<div class="row">
				<div class="col-sm-4">
			
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

					echo("<option value='$PHP_SELF?keyfield=branch_code&key=$menu_code&hr_type=$hr_type&hr_retire=$hr_retire&hr_temp=$hr_temp' $slc_gate>[ $menu_code ] $menu_name</option>");
				}
				echo("</select>");
				?>
			
				</div>
				</div>
				
				<div>&nbsp;</div>
				
				
			  
              <div class="adv-table">
              <table class="display table table-bordered table-striped table-condensed" id="dynamic-table">
              <thead>
              <tr>
                <th><?=$txt_comm_frm23?></th>
				<? if($hr_retire == "1") { ?>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_stf_staff_09?></th>
				<th><?=$txt_stf_staff_15?></th>
				<th><?=$txt_stf_staff_16?></th>
				<th><?=$txt_hr_member_38?></th>
				<th><?=$txt_hr_member_380?></th>
				<? } else if ($hr_temp == "1") { ?>
				<th><?=$txt_stf_staff_07?></th>
				<th>User ID</th>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_stf_staff_09?></th>
				<th><?=$txt_stf_staff_15?></th>
				<th><?=$txt_stf_staff_16?></th>
				<th>Status</th>
				<th><?=$txt_hr_member_38?></th> 
				<? } else { ?>
				<th><?=$txt_stf_staff_07?></th>
				<th>User ID</th>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_stf_staff_09?></th>
				<th><?=$txt_stf_staff_15?></th>
				<th><?=$txt_stf_staff_16?></th>
				<th><?=$txt_hr_member_38?></th>
				<? } ?>				
              </tr>
              </thead>
              <tbody>
              <?
$time_limit = 60*60*24*$notify_new_article; 

if($hr_retire == "0") {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE userlevel > '0' AND ctr_sa = '0' OR ctr_sa = '2' AND temp = '0' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE userlevel > '0' AND ctr_sa = '0' OR ctr_sa = '2' AND temp = '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE userlevel > '0' AND ctr_sa = '1' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE userlevel > '0' AND ctr_sa = '1' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else if($hr_type == "3") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE temp = '1' OR ctr_sa = '2' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date 
				FROM member_staff WHERE temp = '1' OR ctr_sa = '2'  AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}	
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel > '0' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel > '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
}
} else {
if($hr_type == "1") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' AND ctr_sa = '0' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' AND ctr_sa = '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else if($hr_type == "2") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' AND ctr_sa = '1' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' AND ctr_sa = '1' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,branch_code,gate,code,name,gender,birthday,email,userlevel,signdate,id,corp_dept,corp_title,dir1_code,regis_date,expel_date 
				FROM member_staff WHERE userlevel = '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
}
}
$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i < $total_record; $i++) {
   $uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
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
   $user_corp_dept = mysql_result($result,$i,11);
   $user_corp_title = mysql_result($result,$i,12);
   $user_corp_system = mysql_result($result,$i,13);
   $user_regis_date = mysql_result($result,$i,14);
	$regis_date_ex = explode("-",$user_regis_date);
	if($lang == "ko") {
		$regis_dates = "$regis_date_ex[0]"."/"."$regis_date_ex[1]"."/"."$regis_date_ex[2]";
	} else {
		$regis_dates = "$regis_date_ex[2]"."-"."$regis_date_ex[1]"."-"."$regis_date_ex[0]";
	}
   $user_retire_date = mysql_result($result,$i,15);
    $retire_date_ex = explode("-",$user_retire_date);
	if($lang == "ko") {
		$retire_dates = "$retire_date_ex[0]"."/"."$retire_date_ex[1]"."/"."$retire_date_ex[2]";
	} else {
		$retire_dates = "$retire_date_ex[2]"."-"."$retire_date_ex[1]"."-"."$retire_date_ex[0]";
	}
	
	// Gender
  if($user_gender == "M") {
    $user_gender_txt = "<font color=blue>$txt_stf_staff_10</font>";
  } else if($user_gender == "F") {
    $user_gender_txt = "<font color=red>$txt_stf_staff_11</font>";
  }
  
  // Date of Birth
  $uday1 = substr($user_birthday,0,4);
	$uday2 = substr($user_birthday,4,2);
	$uday3 = substr($user_birthday,6,2);

  if($lang == "ko") {
	  $user_birthday_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	} else {
	  $user_birthday_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	}
  

  if(!strcmp($key,"$name") && $key) {
    $name = eregi_replace("($key)", "<font color=navy>\\1</font>", $name);
  }
  if(!strcmp($key,"$code") && $key) {
    $user_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_code);
  }

  // User Level
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

  // Temporary Status
  $query_stat = "SELECT userlevel FROM member_staff WHERE uid = '$uid' "; 
  $result_stat = mysql_query($query_stat);
  if (!$result_stat) {   error("QUERY_ERROR");   exit; }

  $status_temp = mysql_result($result_stat,0,0);

  if ($status_temp == '1') {
  	 $status_K3 = 'Non Reguler - SA';
  } else {
     $status_K3 = 'Reguler';
  }

  // Notify
  $signdate = time();
  $post_year = date("Y",$signdate);
  $pmonth = date("m",$signdate);
  $pdate = date("d",$signdate);
  $phour = date("H",$signdate);
  $past_month3 = date('d-m-Y',mktime(0,0,0,$pmonth,$pdate,$post_year));

  $post_year2 = explode("-",$regis_dates);
  $post_year3 =$post_year2[2];
  $pmonth3 = $post_year2[1];
  $pdate3 = $post_year2[0];
  $past_month4 = date('d-m-Y',mktime(0,0,0,$pmonth3+3,$pdate3,$post_year3));

   	$selisih = ((abs(strtotime($past_month4) - strtotime($past_month3)))/(60*60*24));
   	//echo "<br/>Selisih antara ".$past_month3." dan ".$past_month4." adalah ".$selisih." hari";
   	/* if($selisih <= 14) {
   		echo 'User '.$user_name. 'perpanjangan</br>';
   	} */
  
	$exp_branch_code = explode("_",$branch_code);
	$exp_branch_code1 = $exp_branch_code[1];

	echo ("<tr class='gradeC'>");
	echo("<td>$branch_code</td>");
	
	if($hr_retire == "1") {
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&hr_type=$hr_type&hr_retire=$hr_retire'>{$user_name}</a></td>");
		echo("<td>$user_gender_txt</td>");
		echo("<td>$user_corp_dept</td>");
		echo("<td>$user_corp_title</td>");
		echo("<td>$regis_dates</td>");
		echo("<td>$retire_dates</td>");
} else if ($hr_temp == "1") {
			/* if($selisih <= 14) {
				echo 'User '.$user_name. 'perpanjangan';
			} */
		
		
		echo("<td>$user_code</td><td>$user_mb_id</td>");
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&hr_type=$hr_type&hr_temp=$hr_temp'>{$user_name}</a></td>");
		echo("<td>$user_gender_txt</td>");
		echo("<td>$user_corp_dept</td>");
		echo("<td>$user_corp_title</td>");
		echo("<td>$status_K3</td>");
		echo("<td>$regis_dates</td>");
	} else {
		echo("<td>$user_code</td><td>$user_mb_id</td>");
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&hr_type=$hr_type&hr_retire=$hr_retire'>{$user_name}</a></td>");
		echo("<td>$user_gender_txt</td>");
		echo("<td>$user_corp_dept</td>");
		echo("<td>$user_corp_title</td>");
		echo("<td>$regis_dates</td>");
	}
  
  echo("</tr>");

   $article_num--;
}
?>
 
              </tbody>
              <tfoot>
              <tr>
                <th><?=$txt_comm_frm23?></th>
				<? if($hr_retire == "1") { ?>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_stf_staff_09?></th>
				<th><?=$txt_stf_staff_15?></th>
				<th><?=$txt_stf_staff_16?></th>
				<th><?=$txt_hr_member_38?></th>
				<th><?=$txt_hr_member_380?></th>
				<? } else { ?>
				<th><?=$txt_stf_staff_07?></th>
				<th>User ID</th>
				<th><?=$txt_stf_staff_08?></th>
				<th><?=$txt_stf_staff_09?></th>
				<th><?=$txt_stf_staff_15?></th>
				<th><?=$txt_stf_staff_16?></th>
				<th><?=$txt_hr_member_38?></th>
				<? } ?>
              </tr>
              </tfoot>
              </table>


              </div>
              </div>
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
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <!--dynamic table initialization -->
	<? if($hr_retire == "1") { ?>
    <script src="js/dynamic_table_init1.js"></script>
	<? } else { ?>
	<script src="js/dynamic_table_init3.js"></script>
	<? } ?>


    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

  </body>
</html>


<? } ?>
