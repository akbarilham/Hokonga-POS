<?php
// The function header by sending raw excel
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
header("Content-type: application/vnd-ms-excel");
header("Content-type: application/vnd.google-apps.spreadsheet");

 
 ?>

 <?
	$today = date("Ymd");
  $this_year = date("Y");
  $this_month = date("m");
  $this_yearmonth = date("ym");
  $this_date = date("d");
  $this_week = date("D");
	if (!$p_year){
			if(!$p_month){
				$sorting_filter = "date like '$this_year-%' ";
			}else{
				$sorting_filter = "date like '$this_year-$p_month-%' ";
			}
	}else{
			if(!$p_month){
				$sorting_filter = "date like '$p_year-%'  ";
			}else{
				$sorting_filter = "date like '$p_year-$p_month-%' ";
			}
	}

	if(!$keyA ){
		$key = "";
	}else{
		$key = "AND branch_code = '$keyA'";
	}

	if (!$hr_type){
		$type = "userlevel > '0'";
		$em ='All';
	}else{
		if ($hr_type == 1){
			$type = "userlevel > '0' AND ctr_sa = '0'";
			$em = 'Reguler';
		}elseif ($hr_type == 2) {
			$type ="userlevel > '0' AND ctr_sa = '1'";
			$em = 'Non-Reguler (SA)';
		}elseif ($hr_type == 3) {
			$type ="userlevel > '0' AND temp = '1'";
			$em = 'Temporary';
		}else{
			$type ="userlevel > '0'";
			$em ='All';
		}
	}
	
	if(!$keyA){
		$br ='All Corporates';
		$br2 = 'ALL';
	}else{
		$query_cbi = "SELECT branch_name,branch_name2 FROM client_branch where branch_code = '$keyA'";
		$result_cbi = mysql_query($query_cbi);
		if (!$result_cbi) {   error("QUERY_ERROR");   exit; }
		$br =  @mysql_result($result_cbi,0,0);
		$br2 =  @mysql_result($result_cbi,0,1);
	}


	if(!$div){
		$divi = "";
	}else{
		$divi = "AND LEFT(corp_dept_code,2) = '$div'";
	}

	if(!$dept){
		$dep = "";
	}else{
		$dep = "AND LEFT(corp_dept_code,4) = '$dept'";
	}

	?>
	
		
		<table>
		<tr>
			<td colspan='12' style='text-transform: uppercase;' align='left'> EMPLOYEE : <?=$em?></td>
			<td >
			<?
			if($p_month == 1){
				$month = 'JANUARI';
				echo $month;
			}else if($p_month == 2){
				$month = 'FEBRUARI';
				echo $month;
			}else if($p_month == 3){
				$month = 'MARET';
				echo $month;
			}else if($p_month == 4){
				$month = 'APRIL';
				echo $month;
			}else if($p_month == 5){
				$month = 'MEI';
				echo $month;
			}else if($p_month == 6){
				$month = 'JUNI';
				echo $month;
			}else if($p_month == 7){
				$month = 'JULI';
				echo $month;
			}else if($p_month == 8){
				$month = 'AGUSTUS';
				echo $month;
			}else if($p_month == 9){
				$month = 'SEPTEMBER';
				echo $month;
			}else if($p_month == 10){
				$month = 'OKTOBER';
				echo $month;
			}else if($p_month == 11){
				$month = 'NOVEMBER';
				echo $month;
			}else if($p_month == 12){
				$month = 'DESEMBER';
				echo $month;
			}else {
				$month = 'TAHUN';
				echo $month;
			}
			// Defines the name of the export file "codelution-export.xls"
			header("Content-Disposition: attachment; filename=ABSEN_DAN_SP_KARYAWAN_".$month."_".$p_year."_".$br2.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");

			?>
			<? echo ' '.$p_year?>
			</td>
		</tr>

		<tr>
			<td style='font-size:17; padding: 2px 2px 8px; font-weight: bold;' colspan='13' align='center'>
				ABSEN DAN SP KARYAWAN <?=$month?> <?=$p_year?>
			</td>
		</tr>
		<tr>
			<td style='font-size:14; padding: 2px 2px 8px; font-weight: bold; text-transform: uppercase;' colspan='13' align='center'>
				<?=$br?>
			</td>
		</tr>
		<tr></tr>
		</table>
		<table border='1' ><thead>
		<tr>
			<th style='background:#81d4fa'>No.</th>
			<th style='background:#81d4fa'>Kode PT</th>
			<th style='background:#81d4fa'>Nama</th>
			<th style='background:#81d4fa'>Divisi</th>
			<th style='background:#81d4fa'>Departmen</th>
			<th style='background:#81d4fa'>Jabatan</th>
			<th style='background:#81d4fa'>Kerja</th>
			<th style='background:#81d4fa'>Tidak Masuk</th>
			<th style='background:#81d4fa'>Ijin</th>
			<th style='background:#81d4fa'>Lambat</th>
			<th style='background:#81d4fa'>Pulang Cepat</th>
			<th style='background:#81d4fa'>Lembur</th>
			<th style='background:#81d4fa'>SP</th>
		</tr>
		</thead>
				
		<tbody>
	<?
// Add data table



	$query = "SELECT count(code) FROM member_staff where userlevel != '0' AND $type $key $divi $dep";
	$result = mysql_query($query);
	if (!$result) {   error("QUERY_ERROR");   exit; }
	$total =  @mysql_result($result,0,0);

	

	for ($i = 0; $i < $total ; $i++){

	$query_ms = "SELECT code,name,branch_code,corp_title,LEFT(corp_dept_code,2),corp_dept FROM member_staff where userlevel != '0' $key AND $type $divi $dep";
	$result_ms = mysql_query($query_ms);
	if (!$result_ms) {   error("QUERY_ERROR");   exit; }
	$code_ms = @mysql_result($result_ms,$i,0);
	$name_ms = @mysql_result($result_ms,$i,1);
	$branch = @mysql_result($result_ms,$i,2);
	$corp_title = @mysql_result($result_ms,$i,3);
	$corp_dept_code = @mysql_result($result_ms,$i,4);
	$departemen =  @mysql_result($result_ms,$i,5);

	$query_divs = "SELECT lname FROM dept_catgbig where lcode = '$corp_dept_code' ";
	$result_divs = mysql_query($query_divs);
	if (!$result_divs) {   error("QUERY_ERROR");   exit; }
	$divisi = mysql_result($result_divs,0,0);

	$query_cb = "SELECT branch_name2 FROM client_branch where branch_code = '$branch'";
	$result_cb = mysql_query($query_cb);
	if (!$result_cb) {   error("QUERY_ERROR");   exit; }
	$branch_name2 =  @mysql_result($result_cb,0,0);
	
	// Work in
	$query_wt = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',10), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',10), '|', -1) != '0:0' AND code = '$code_ms' AND $sorting_filter";
	$result_wt = mysql_query($query_wt);
	if (!$result_wt) {   error("QUERY_ERROR");   exit; }
	$workin =  @mysql_result($result_wt,0,0);

	// Work out
	$query_wo = "SELECT count(SUBSTRING_INDEX( history,  '|', 1))
				FROM member_staff_history WHERE SUBSTRING_INDEX( history,  '|', 1) = '0'
				AND code = '$code_ms' AND $sorting_filter";
	$result_wo = mysql_query($query_wo);
	if (!$result_wo) {   error("QUERY_ERROR");   exit; }
	$workout =  @mysql_result($result_wo,0,0);	

	//Izin
	$query_iz = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',2), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',2), '|', -1) != '' AND code = '$code_ms' AND $sorting_filter";
	$result_iz = mysql_query($query_iz);
	if (!$result_iz) {   error("QUERY_ERROR");   exit; }
	$izin =  @mysql_result($result_iz,0,0);

	//Late
	$query_te = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',8), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',8), '|', -1) != '' AND code = '$code_ms' AND $sorting_filter";
	$result_te = mysql_query($query_te);
	if (!$result_te) {   error("QUERY_ERROR");   exit; }
	$late =  @mysql_result($result_te,0,0);		

	//Workout Early
	$query_we = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',9), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',9), '|', -1) != '' AND SUBSTRING_INDEX( SUBSTRING_INDEX( history,  '|', 9 ) ,  '|', -1 ) !=  '17:30' AND code = '$code_ms' AND $sorting_filter";
	$result_we = mysql_query($query_we);
	if (!$result_we) {   error("QUERY_ERROR");   exit; }
	$wo_early =  @mysql_result($result_we,0,0);		

	//Overwork
	$query_ow = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',12), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',12), '|', -1) != '' AND code = '$code_ms' AND $sorting_filter";
	$result_ow = mysql_query($query_ow);
	if (!$result_ow) {   error("QUERY_ERROR");   exit; }
	$overwork =  @mysql_result($result_ow,0,0);					

	// Warning
	$query_wa = "SELECT count(SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',11), '|', -1) )
				FROM member_staff_history WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(history,'|',11), '|', -1) > '0' AND code = '$code_ms' AND $sorting_filter";
	$result_wa = mysql_query($query_wa);
	if (!$result_wa) {   error("QUERY_ERROR");   exit; }
	$w_warning =  @mysql_result($result_wa,0,0);	

	$query_AB = "SELECT uid,name,date, history,code
			 FROM member_staff_history where code = '$code_ms'";
			 $result_AB = mysql_query($query_AB);
			if (!$result_AB) {   error("QUERY_ERROR");   exit; }

	$uid =  @mysql_result($result_AB,0,0);
	$name =  @mysql_result($result_AB,0,1);
	$date =  @mysql_result($result_AB,0,2);
	$history =  @mysql_result($result_AB,0,3);
	$ex_history = explode("|", $history);
	$work_off_type =  $ex_history[0];
	$work_time1 =  $ex_history[1];
	$work_time2 =  $ex_history[2];
	$work_in =  $ex_history[3];
	$work_out =  $ex_history[4];
	$work_in_early =  $ex_history[5];
	$work_in_late =  $ex_history[6];
	$work_out_early =  $ex_history[7];
	$work_over =  $ex_history[8];
	$work_hours =  $ex_history[9];
	$warning =  $ex_history[10];
	$code =  @mysql_result($result_AB,0,4);
	

?>


<tr>
	<td><?php echo $i+1?></td>
	<td><?=$branch_name2?></td>
	<td><?=$name_ms?></td>
	<td><?=$divisi?></td>
	<td><?=$departemen?></td>
	<td><?=$corp_title?></td>
	<td><?=$workin?></td>
	<td><?=$workout?></td>
	<td><?=$izin?></td>
	<td><?=$late?></td>
	<td><?=$wo_early?></td>
	<td><?=$overwork?></td>
	<td><?=$w_warning?></td>
</tr>


 <? }?>
 </tbody>
</table>
<? 
?>