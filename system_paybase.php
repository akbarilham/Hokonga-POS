<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_paybase";

if(!$step_next) {
	
	// Default Value
	if($year AND $key == "1" AND !$key1) {
		$key1 = "01";
	}

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_paybase.php";
$link_post = "$home/system_paybase_post.php";
$link_upd = "$home/system_paybase_upd.php";
$link_del = "$home/system_paybase_del.php";


// Table Style
$style_box = "BACKGROUND-COLOR: #FFFFFF; FONT-FAMILY: Verdana, Arial, 돋움, 굴림; FONT-SIZE: 9pt; BORDER-BOTTOM: cccccc 1px solid; BORDER-LEFT: cccccc 1px solid; BORDER-RIGHT: cccccc 1px solid; BORDER-TOP: cccccc 1px solid; HEIGHT: 20px";
$style_btn = "BACKGROUND-COLOR: #EFEFEF; FONT-FAMILY: Verdana, Arial, 돋움, 굴림; FONT-SIZE: 9pt; BORDER-BOTTOM: aaaaaa 1px solid; BORDER-LEFT: aaaaaa 1px solid; BORDER-RIGHT: aaaaaa 1px solid; BORDER-TOP: aaaaaa 1px solid; HEIGHT: 22px";
$style_area = "BACKGROUND-COLOR: #FFFFFF; FONT-FAMILY: Verdana, Arial, 돋움, 굴림; FONT-SIZE: 9pt; BORDER-BOTTOM: cccccc 1px solid; BORDER-LEFT: cccccc 1px solid; BORDER-RIGHT: cccccc 1px solid; BORDER-TOP: cccccc 1px solid";
$style_blnk = "BORDER: 1px solid #FFFFFF; text-align: right; HEIGHT: 20px";

$BOX_TOP1 = "BORDER: #777777 1px solid";
$BOX_TOP2 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid; BORDER-TOP: #777777 1px solid";
$BOX_LAIN1 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid; BORDER-LEFT: #777777 1px solid";
$BOX_LAIN2 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid";
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
    <link href="css/table-responsive.css" rel="stylesheet" />
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



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">

<?
if(!$year) {
	$year = date("Y");
}
$Y_start = "2014";
$Y_now = date("Y");
$Y_prev = $Y_now - 1;
$Y_next = $Y_now + 1;

// Filter
if($key > 0) {
	if($key1 > 0) {
		$my_filter = "year = '$year' AND job_bcode = '$key' AND job_mcode = '$key1'";
	} else {
		$my_filter = "year = '$year' AND job_bcode = '$key'";
	}
} else {
		$my_filter = "year = '$year'";
}


if(!$sorting_key) { $sorting_key = "payroll_code"; }
// if($sorting_key == "uid") {
  // $sort_now = "DESC";
// } else {
  $sort_now = "ASC";
// }

if($sorting_key == "job_bcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "job_mcode") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "pay_mcode") { $chk3 = "selected"; } else { $chk3 = ""; }


if(!$page) { $page = 1; }


$query_all = "SELECT count(uid) FROM payroll_baseline WHERE year = '$year'";
$result_all = mysql_query($query_all);
if (!$result_all) {
   error("QUERY_ERROR");
   exit;
}
$all_record = @mysql_result($result_all,0,0);


$query = "SELECT count(uid) FROM payroll_baseline WHERE $my_filter";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = @mysql_result($result,0,0);
?>
    

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_09_43?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-2">
			
			<?
			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF'>:: Select Year</option>");

			for($Y = $Y_start; $Y <= $Y_next; $Y++) {
        
				if($Y == $year) {
					$slc_Y = "selected";
				} else {
					$slc_Y = "";
				}

				echo("<option value='$PHP_SELF?year=$Y&keyfield=$keyfield&key=$key' $slc_Y>&nbsp; $Y</option>");
			}
			echo("</select>
			
			</div>
			
			<div class='col-sm-6'></div>
			
			<div class='col-sm-4'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF'>:: Select Job Category</option>");
  
			$queryC = "SELECT count(uid) FROM code_jobclass1 WHERE lang = '$lang'";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT lcode,lname FROM code_jobclass1 WHERE lang = '$lang' ORDER BY lcode ASC";
			$resultD = mysql_query($queryD);
		
			for($m = 0; $m < $total_recordC; $m++) {
				$menu_lcode = mysql_result($resultD,$m,0);
				$menu_lname = mysql_result($resultD,$m,1);
			
				if($menu_lcode == $key) {
					$menu_slct = "selected";
				} else {
					$menu_slct = "";
				}
	  
				echo ("<option value='$PHP_SELF?year=$year&key=$menu_lcode' $menu_slct>$menu_lcode. $menu_lname</option>");
			}
			echo("</select>");
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
			
<table width=100% cellspacing=0 cellpadding=0 border=0>
<?
if($total_record < 1) {
	
		if($key < "1" OR !$key) {
			$submit_dis = "disabled";
		} else {
			$submit_dis = "";
		}
	
		echo ("
		<form name='signform2' method='post' action='system_paybase.php'>
		<input type='hidden' name='step_next' value='permit_post'>
		<input type='hidden' name='lang' value='$lang'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='year' value='$year'>
	
		<tr><td colspan=2 height=60>&nbsp;</td></tr>
		<tr height=22>
			<td colspan=2 align=center><input $submit_dis type='submit' value='Create Payroll Table Year $year' class='btn btn-primary''></td>
		</tr>
		<tr><td colspan=2 height=60>&nbsp;</td></tr>
		</form>
		");
	
	
	
	
	
	} else {
	
	
		// Job Level
		echo ("<tr><td colspan=2 height=22 bgcolor=#EFEFEF align=center>
		<table width=100% cellspacing=0 cellpadding=0 border=0>
		<tr><td align=center>");
			if(!eregi("[^[:space:]]+",$key1)) {
				echo ("<a href='$link_list?year=$year&key=$key'><u><font color=#444444>All</font></u></a>");
			} else {
				echo ("<a href='$link_list?year=$year&key=$key'><font color=#888888>All</font></a>");
			}
		
		$query_lv1 = "SELECT mcode FROM code_jobclass2 WHERE lcode = '$key' AND lang = '$lang' ORDER BY mcode ASC";
		$result_lv1 = mysql_query($query_lv1);
		$row_lv1 = mysql_num_rows($result_lv1);
          
		while($row_lv1 = mysql_fetch_object($result_lv1)) {
			$lv1_mcode = $row_lv1->mcode;
		
			if($key1 == $lv1_mcode) {
				echo("&nbsp;| <a href='$link_list?year=$year&key=$key&key1=$lv1_mcode'><u><font color=#444444>$lv1_mcode</font></u></a>");
			} else {
				echo("&nbsp;| <a href='$link_list?year=$year&key=$key&key1=$lv1_mcode'><font color=#888888>$lv1_mcode</font></a>");
			}
		}
		
		// edit module
		if($key > "0") {
			if($mode == "edit") {
				echo ("&nbsp;| <a href='$link_list?year=$year&key=$key&key1=$key1'><font color=#888888>View</font></a>");
			} else {
				echo ("&nbsp;| <a href='$link_list?year=$year&key=$key&key1=$key1&mode=edit'><font color=#444444>Edit</font></a>");
			}
		}
		
		// days
		$query_days = "SELECT days FROM payroll_days WHERE year = '$year' ORDER BY year DESC";
		$result_days = mysql_query($query_days);
		$days = @mysql_result($result_days,0,0);
		
		if($days < "1") {
			$days = "22";
		}
		
		echo ("
		</td>
		
		<form name='days' method='post' action='paybase.php'>
		<input type='hidden' name='step_next' value='permit_days'>
		<input type='hidden' name='lang' value='$lang'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='key1' value='$key1'>
		<input type='hidden' name='year' value='$year'>
	
		<td width=30 align=right><input type='text' name='days' value='$days' style='$style_box; WIDTH: 30px; text-align: center'></td>
		</tr>
		</form>
		</table>
	
		</td></tr>
		
		
		<tr><td colspan=2 height=10></td></tr>
		<tr>
			<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td width=15% height=20 style='$BOX_TOP1;' align=center>Job Title</td>
						<td width=85%>
							<table width=100% cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td width=5% style='$BOX_TOP2'></td>
								<td width=95%>
									<table width=100% cellspacing=0 cellpadding=0 border=0>
									<tr height=22>
										<td width=4% style='$BOX_TOP2' align=center>&nbsp;</td>
										<td width=13% style='$BOX_TOP2' align=center>Code</td>
										<td width=14% style='$BOX_TOP2' align=center>Basic</td>
										<td width=11% style='$BOX_TOP2' align=center>Diff</td>
										<td width=10% style='$BOX_TOP2' align=center>Title Pay</td>
										<td width=10% style='$BOX_TOP2' align=center>Acc/Trs</td>
										<td width=10% style='$BOX_TOP2' align=center>W.Day B</td>
										<td width=12% style='$BOX_TOP2' align=center>Special</td>
										<td width=16% style='$BOX_TOP2' align=center>Average</td>
									</tr>
									</table>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					");
					
					if($mode == "edit") {
					
					// Minimum Wage
					$query_amw1 = "SELECT area_code FROM code_jobclass1 WHERE lcode = '$key' AND lang = '$lang' ORDER BY lcode DESC";
					$result_amw1 = mysql_query($query_amw1);
					$job_area_code = @mysql_result($result_amw1,0,0);
					
					$query_amw2 = "SELECT minimum_wage FROM code_area WHERE area_code = '$job_area_code' ORDER BY uid DESC";
					$result_amw2 = mysql_query($query_amw2);
					$job_minimum_wage = @mysql_result($result_amw2,0,0);
					
					if($value2 < 1) {
						$default_value2 = "40000";
					} else {
						$default_value2 = $value2;
					}
					
					if($value3 < 1) {
						$default_value3 = "20000";
					} else {
						$default_value3 = $value3;
					}
					
					if($value4 < 1) {
						$default_value4 = "12000";
					} else {
						$default_value4 = $value4;
					}
					
					if($value5 < 1) {
						$default_value5 = "12000";
					} else {
						$default_value5 = $value5;
					}
					
					
					echo ("
					<tr>
						<td width=15% height=22 style='$BOX_LAIN1;' align=center>&nbsp;</td>
						<td width=85%>
							<table width=100% cellspacing=0 cellpadding=0 border=0>
							<tr>
								<td width=5% style='$BOX_LAIN2'></td>
								<td width=95%>
									<table width=100% cellspacing=0 cellpadding=0 border=0>
									<tr height=22>
										<td width=4% style='$BOX_LAIN2' align=center>&nbsp;</td>
										<td width=13% style='$BOX_LAIN2' align=center>$job_area_code</td>
										
										<form name='value1' method='post' action='$link_list?year=$year&key=$key&key1=$key1&mode=edit'>
										<input type=hidden name='value2' value='$value2'>
										<input type=hidden name='value3' value='$value3'>
										<input type=hidden name='value4' value='$value4'>
										<input type=hidden name='value5' value='$value5'>
										<input type=hidden name='value6' value='$value6'>
										<td width=14% style='$BOX_LAIN2' align=center><input type=text name='value1' value='$job_minimum_wage' style='$style_blnk; WIDTH: 87px;'></td>
										</form>
										
										<form name='value2' method='post' action='$link_list?year=$year&key=$key&key1=$key1&mode=edit'>
										<input type=hidden name='value1' value='$value1'>
										<input type=hidden name='value3' value='$value3'>
										<input type=hidden name='value4' value='$value4'>
										<input type=hidden name='value5' value='$value5'>
										<input type=hidden name='value6' value='$value6'>
										<td width=11% style='$BOX_LAIN2' align=center><input type=text name='value2' value='$default_value2' style='$style_blnk; WIDTH: 80px;'></td>
										</form>
										
										<form name='value3' method='post' action='$link_list?year=$year&key=$key&key1=$key1&mode=edit'>
										<input type=hidden name='value1' value='$value1'>
										<input type=hidden name='value2' value='$value2'>
										<input type=hidden name='value4' value='$value4'>
										<input type=hidden name='value5' value='$value5'>
										<input type=hidden name='value6' value='$value6'>
										<td width=10% style='$BOX_LAIN2' align=center><input type=text name='value3' value='$default_value3' style='$style_blnk; WIDTH: 70px;'></td>
										</form>
										
										<form name='value4' method='post' action='$link_list?year=$year&key=$key&key1=$key1&mode=edit'>
										<input type=hidden name='value1' value='$value1'>
										<input type=hidden name='value2' value='$value2'>
										<input type=hidden name='value3' value='$value3'>
										<input type=hidden name='value5' value='$value5'>
										<input type=hidden name='value6' value='$value6'>
										<td width=10% style='$BOX_LAIN2' align=center><input type=text name='value4' value='$default_value4' style='$style_blnk; WIDTH: 70px;'></td>
										</form>
										
										<form name='value5' method='post' action='$link_list?year=$year&key=$key&key1=$key1&mode=edit'>
										<input type=hidden name='value1' value='$value1'>
										<input type=hidden name='value2' value='$value2'>
										<input type=hidden name='value3' value='$value3'>
										<input type=hidden name='value5' value='$value5'>
										<input type=hidden name='value6' value='$value6'>
										<td width=10% style='$BOX_LAIN2' align=center><input type=text name='value5' value='$default_value5' style='$style_blnk; WIDTH: 70px;'></td>
										</form>
										
										
										<td width=12% style='$BOX_LAIN2' align=center>&nbsp;</td>
										<td width=16% style='$BOX_LAIN2' align=center>&nbsp;</td>
									</tr>
									</table>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					
					
					<form name='signform2' method='post' action='system_paybase.php'>
					<input type='hidden' name='step_next' value='permit_update'>
					<input type='hidden' name='lang' value='$lang'>
					<input type='hidden' name='gate' value='$login_gate'>
					<input type='hidden' name='keyfield' value='$keyfield'>
					<input type='hidden' name='year' value='$year'>
					<input type='hidden' name='key' value='$key'>
					<input type='hidden' name='key1' value='$key1'>
					");
					
					}
		
					
					// if($key > "0") {
					
					if($key1 > "0") {
					$query_mm2 = "SELECT uid,lcode,mcode,mname,mname_abr,highlevel FROM code_jobclass2 WHERE lcode = '$key' AND mcode = '$key1' AND lang = '$lang' ORDER BY mcode ASC";
					} else {
					$query_mm2 = "SELECT uid,lcode,mcode,mname,mname_abr,highlevel FROM code_jobclass2 WHERE lcode = '$key' AND lang = '$lang' ORDER BY mcode ASC";
					}
					$result_mm2 = mysql_query($query_mm2);
						$row_mm2 = mysql_num_rows($result_mm2);
          
					while($row_mm2 = mysql_fetch_object($result_mm2)) {
						$mm2_uid = $row_mm2->uid;
						$mm2_lcode = $row_mm2->lcode;
						$mm2_mcode = $row_mm2->mcode;
						$mm2_mname = $row_mm2->mname;
						$mm2_mdesc = $row_mm2->mname_abr;
						$mm2_exec = $row_mm2->highlevel;
						
						echo ("
						<tr>
							<td width=15% style='$BOX_LAIN1; padding-left: 10px;' valign=top><br><br><b>$mm2_mcode. $mm2_mdesc</b><br><br>$mm2_mname</td>
							<td width=85%>
									<table width=100% cellspacing=0 cellpadding=0>");
									
									
									$query_mm3 = "SELECT uid,lcode FROM code_payclass1 ORDER BY lcode ASC";
									$result_mm3 = mysql_query($query_mm3);
									$row_mm3 = mysql_num_rows($result_mm3);
									
									$m = 1;
          
									while($row_mm3 = mysql_fetch_object($result_mm3)) {
										$mm3_uid = $row_mm3->uid;
										$mm3_lcode = $row_mm3->lcode;
				
										
									
									echo ("
									<tr>
										<td width=5% style='$BOX_LAIN2;' align=center>$mm3_lcode</td>
										<td width=95%>
												<table width=100% cellspacing=0 cellpadding=0>");
					
									
									$paybase_key = "$mm2_lcode"."-"."$mm2_mcode"."-"."$mm3_lcode";
									$paybase_key_pre = "$mm2_lcode"."-"."$mm2_mcode";
									
									
									$query_x2 = "SELECT count(mcode) FROM code_payclass2 WHERE lcode = '$mm3_lcode'";
									$result_x2 = mysql_query($query_x2);
									$total_x2 = @mysql_result($result_x2,0,0);
									
									$query = "SELECT uid,job_bcode,job_mcode,job_mdesc,job_exec,job_area,pay_bcode,pay_mcode,payroll_code,
											amount_basic,amount_jgap,amount_jtitle,amount_wtrans,amount_wbonus,amount_special,amount_avrg,amount_avrg_prev 
											FROM payroll_baseline WHERE payroll_code LIKE '$paybase_key%' ORDER BY payroll_code ASC";
									$result = mysql_query($query);
									if (!$result) {   error("QUERY_ERROR");   exit; }


									$n = 1;
									
									for($i = 0; $i < $total_x2; $i++) {
										$uid = mysql_result($result,$i,0);
										$job_bcode = mysql_result($result,$i,1);
										$job_mcode = mysql_result($result,$i,2);
										$job_mdesc = mysql_result($result,$i,3);
										$job_exec = mysql_result($result,$i,4);
										$job_area = mysql_result($result,$i,5);
										$pay_bcode = mysql_result($result,$i,6);
										$pay_mcode = mysql_result($result,$i,7);
											$pay_mcode2 = substr($pay_mcode,1);
										$payroll_code = mysql_result($result,$i,8);
										$amount_basic = mysql_result($result,$i,9);
											$amount_basic_K = number_format($amount_basic);
										$amount_jgap = mysql_result($result,$i,10);
											$amount_jgap_K = number_format($amount_jgap);
										$amount_jtitle = mysql_result($result,$i,11);
											$amount_jtitle_K = number_format($amount_jtitle);
										$amount_wtrans = mysql_result($result,$i,12);
											$amount_wtrans_K = number_format($amount_wtrans);
										$amount_wbonus = mysql_result($result,$i,13);
											$amount_wbonus_K = number_format($amount_wbonus);
										$amount_special = mysql_result($result,$i,14);
											$amount_special_K = number_format($amount_special);
										$amount_avrg = mysql_result($result,$i,15);
											$amount_avrg_K = number_format($amount_avrg);
										$amount_avrg_prev = mysql_result($result,$i,16);
											$amount_avrg_prev_K = number_format($amount_avrg_prev);
										
										$s = ($m * 6) - 6 + $n;
						
										
										// difference
										$query_next = "SELECT amount_basic FROM payroll_baseline 
													WHERE payroll_code > '$payroll_code' ORDER BY payroll_code ASC";
										$result_next = mysql_query($query_next);
										if (!$result_next) {   error("QUERY_ERROR");   exit; }
										
										$amount_basic_next = @mysql_result($result_next,0,0);
											$amount_basic_next_K = number_format($amount_basic_next);
										
										$amount_diff = $amount_basic_next - $amount_basic;
											$amount_diff_K = number_format($amount_diff);
										
										if($s == 60) {
											$amount_diff_K2 = "";
										} else {
											$amount_diff_K2 = $amount_diff_K;
										}
										
										
										// default values
										if($i == 0 AND $m == 1) {
											if($amount_basic > 0) {
												$amount_basic2 = $amount_basic;
											} else {
												$amount_basic2 = $value1;
											}
										} else {
											if($amount_basic > 0) {
												$amount_basic2 = $amount_basic;
											} else {
												$amount_basic2 = $value1 + ( $value2 * $s ) - $value2;
											}
										
										}
										
										if($amount_jtitle > 0) {
											$amount_jtitle2 = $amount_jtitle;
										} else {
											$amount_jtitle2 = $value3;
										}
										
										if($amount_wtrans > 0) {
											$amount_wtrans2 = $amount_wtrans;
										} else {
											$amount_wtrans2 = $value4;
										}
										
										if($amount_wbonus > 0) {
											$amount_wbonus2 = $amount_wbonus;
										} else {
											$amount_wbonus2 = $value5;
										}
										
										// Average Wage
										if($amount_avrg > 0) {
											$amount_avrg2 = $amount_avrg;
										} else {
											$amount_avrg2 = ( $amount_basic2 + $amount_jtitle2 ) + (( $amount_wtrans2 + $admount_wbonus2 ) * $days);
										}
										$amount_avrg2_K = number_format($amount_avrg2);
										
										
			
					
											if($mode == "edit") {
											
											echo ("
											<tr height=18>
												<td width=4% style='$BOX_LAIN2' align=center>$pay_mcode2</td>
												<td width=13% style='$BOX_LAIN2' align=center>$payroll_code</td>
												<td width=14% style='$BOX_LAIN2' align=center><input type=text name='amount_basic[$uid]' value='$amount_basic2' style='$style_blnk; WIDTH: 87px;'></td>
												<td width=11% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_diff_K2</td>
												<td width=10% style='$BOX_LAIN2' align=center><input type=text name='amount_jtitle[$uid]' value='$amount_jtitle2' style='$style_blnk; WIDTH: 70px;'></td>
												<td width=10% style='$BOX_LAIN2' align=center><input type=text name='amount_wtrans[$uid]' value='$amount_wtrans2' style='$style_blnk; WIDTH: 70px;'></td>
												<td width=10% style='$BOX_LAIN2' align=center><input type=text name='amount_wbonus[$uid]' value='$amount_wbonus2' style='$style_blnk; WIDTH: 70px;'></td>
												<td width=12% style='$BOX_LAIN2' align=center><input type=text name='amount_special[$uid]' value='$amount_special' style='$style_blnk; WIDTH: 86px;'></td>
												<td width=16% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_avrg2_K</td>
							
											</tr>");
											
											} else {
											
											echo ("
											<tr height=18>
												<td width=4% style='$BOX_LAIN2' align=center>$pay_mcode2</td>
												<td width=13% style='$BOX_LAIN2' align=center>$payroll_code</td>
												<td width=14% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_basic_K</td>
												<td width=11% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_diff_K2</td>
												<td width=10% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_jtitle_K</td>
												<td width=10% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_wtrans_K</td>
												<td width=10% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_wbonus_K</td>
												<td width=12% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_special_K</td>
												<td width=16% style='$BOX_LAIN2; padding-right: 5px;' align=right>$amount_avrg_K</td>
							
											</tr>");
											
											}
			
									$n++;
									}
											echo ("</table>
										</td>
									</tr>");
									
									
									$m++;
									}
									
									echo ("
									</table>
							</td>
						</tr>");
					
					}
					
					
					// }
					
					if($key1 > "0") {
						$sub_dis = "";
					} else {
						$sub_dis = "disabled";
					}
					
					if($mode == "edit") {
	
					echo ("
					<tr><td colspan=2 height=14></td></tr>
					<tr>
						<td colspan=2 height=20 align=center>
							<input $sub_dis type=checkbox name='reset_all' value='1'> <font color=red>$txt_comm_frm07</font> &nbsp;&nbsp;&nbsp;
							<input $sub_dis type=submit name='submit' value='$txt_comm_frm27' class='btn btn-primary'>
						</td>
					</tr>");
					
					}
					
					echo ("
					<tr><td colspan=2 height=20></td></tr>
					</form>
					</table>
			</td>
		</tr>");
			
	
	
	}			
?>		
</table>
			
        </div>
		
        </section>
						
	</div>
	</div>
	</div>
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	<? include "footer.inc"; ?>

</section>


	<!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>

</html>


<?
} else if($step_next == "permit_days") {

	$query = "SELECT count(days) FROM payroll_days WHERE year = '$year'";
	$result = mysql_query($query);
	if (!$result) { error("QUERY_ERROR"); exit; }
	$db_days = @mysql_result($result,0,0);

	if($db_days > "0") {
	
			$query_upd = "UPDATE payroll_days SET days = '$days' WHERE year = '$year'"; 
			$result_upd = mysql_query($query_upd);
			if(!$result_upd) { error("QUERY_ERROR"); exit; }
	
	} else {
	
		$query_add = "INSERT INTO payroll_days (year, days) VALUES ('$year','$days')"; 
		$result_add = mysql_query($query_add);
		if(!$result_add) { error("QUERY_ERROR"); exit; }
	
	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_paybase.php?year=$year&key=$key&key1=$key1'>");
	exit;





} else if($step_next == "permit_update") {

		$query_days = "SELECT days FROM payroll_days WHERE year = '$year' ORDER BY year DESC";
		$result_days = mysql_query($query_days);
		$days = @mysql_result($result_days,0,0);
		
		if($days < "1") {
			$days = "22";
		}



	if(!$reset_all) {
		$reset_all = "0";
	}


	if(!eregi("[^[:space:]]+",$key1)) {
		if(!eregi("[^[:space:]]+",$key)) {
			$my_filter = "year = '$year'";
		} else {
			$my_filter = "year = '$year' AND job_bcode = '$key'";
		}
	} else {
		if(!eregi("[^[:space:]]+",$key)) {
			$my_filter = "year = '$year' AND job_mcode = '$key1'";
		} else {
			$my_filter = "year = '$year' AND job_mcode = '$key1' AND job_bcode = '$key'";
		}
	}
	
	$query = "SELECT count(uid) FROM payroll_baseline WHERE $my_filter";
	$result = mysql_query($query);
	if (!$result) { error("QUERY_ERROR"); exit; }
	$total_record = @mysql_result($result,0,0);
	
	$query = "SELECT uid FROM payroll_baseline WHERE $my_filter ORDER BY payroll_code ASC";
	$result = mysql_query($query);
	if (!$result) { error("QUERY_ERROR");   exit; }
	
	
	if($reset_all == "1") {
	
			$query_upd = "UPDATE payroll_baseline SET amount_basic = '0', amount_jtitle = '0', 
					amount_wtrans = '0', amount_wbonus = '0', amount_avrg = '0' WHERE $my_filter"; 
			$result_upd = mysql_query($query_upd);
			if(!$result_upd) { error("QUERY_ERROR"); exit; }
	
	} else {


		for($i = 0; $i < $total_record; $i++) {
			$uid = mysql_result($result,$i,0);
	
			// Average Wage
			$amount_avrg = ( $amount_basic[$uid] + $amount_jtitle[$uid] + $amount_special[$uid] ) + (( $amount_wtrans[$uid] + $admount_wbonus[$uid] ) * $days);
		
	
			$query_upd = "UPDATE payroll_baseline SET amount_basic = '$amount_basic[$uid]', amount_jtitle = '$amount_jtitle[$uid]', 
					amount_wtrans = '$amount_wtrans[$uid]', amount_wbonus = '$amount_wbonus[$uid]', amount_special = '$amount_special[$uid]', 
					amount_avrg = '$amount_avrg' 
					WHERE $my_filter AND uid = '$uid'"; 
			$result_upd = mysql_query($query_upd);
			if(!$result_upd) { error("QUERY_ERROR"); exit; }
	
		}
	
	}


	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_paybase.php?year=$year&key=$key&key1=$key1'>");
	exit;


} else if($step_next == "permit_post") {

		
		$query_mm1 = "SELECT area_code FROM code_jobclass1 WHERE lcode = '$key' AND lang = '$lang' ORDER BY lcode ASC, uid DESC";
		$result_mm1 = mysql_query($query_mm1);
				
		$mm1_area = @mysql_result($result_mm1,0,0);
		
		
		$query_mm2 = "SELECT uid,lcode,mcode,mname_abr,highlevel FROM code_jobclass2 WHERE lcode = '$key' AND lang = '$lang' ORDER BY mcode ASC";
		$result_mm2 = mysql_query($query_mm2);
		$row_mm2 = mysql_num_rows($result_mm2);
          
		while($row_mm2 = mysql_fetch_object($result_mm2)) {
			$mm2_uid = $row_mm2->uid;
			$mm2_lcode = $row_mm2->lcode;
			$mm2_mcode = $row_mm2->mcode;
			$mm2_mdesc = $row_mm2->mname_abr;
			$mm2_exec = $row_mm2->highlevel;
			
			$query_mm3 = "SELECT uid,lcode FROM code_payclass1 ORDER BY lcode ASC";
			$result_mm3 = mysql_query($query_mm3);
			$row_mm3 = mysql_num_rows($result_mm3);
          
			while($row_mm3 = mysql_fetch_object($result_mm3)) {
				$mm3_uid = $row_mm3->uid;
				$mm3_lcode = $row_mm3->lcode;
				
				$query_mm4 = "SELECT uid,mcode FROM code_payclass2 WHERE lcode = '$mm3_lcode' ORDER BY mcode ASC";
				$result_mm4 = mysql_query($query_mm4);
				$row_mm4 = mysql_num_rows($result_mm4);
          
				while($row_mm4 = mysql_fetch_object($result_mm4)) {
					$mm4_uid = $row_mm4->uid;
					$mm4_mcode = $row_mm4->mcode;
					
					// Payroll Code
					$mmf_payroll_code = "$mm2_lcode"."-"."$mm2_mcode"."-"."$mm4_mcode";
					
					// Duplication Check
					$query_chk = "SELECT count(uid) FROM payroll_baseline WHERE year = '$year' AND job_bcode = '$key' AND job_mcode = '$mm2_mcode' 
								AND payroll_code = '$mmf_payroll_code'";
					$result_chk = mysql_query($query_chk);
				
					$chk_cnt = @mysql_result($result_chk,0,0);
					
					
					// Data Entry
					echo ("Now [$mmf_payroll_code] is being checked & recorded. Please wait ....<br>");
						
					if($chk_cnt < "1") {
						$query_P1  = "INSERT INTO payroll_baseline (uid, year, job_bcode, job_mcode, job_mdesc, job_exec, job_area, pay_bcode, pay_mcode,
								payroll_code) VALUES ('','$year','$mm2_lcode','$mm2_mcode','$mm2_mdesc','$mm2_exec','$mm1_area', '$mm3_lcode','$mm4_mcode',
								'$mmf_payroll_code')";
						$result_P1 = mysql_query($query_P1);
						if(!$result_P1) {	error("QUERY_ERROR");	exit;	}
					}
					
					
					
					
				}
			
			}

			
		}
			

	echo("<meta http-equiv='Refresh' content='20; URL=$home/system_paybase.php'>");
	exit;

}

}
?>
