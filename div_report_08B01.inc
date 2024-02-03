<section id='unseen'>
<div class="adv-table">
<form name='print_all' method='post' target="_blank" action='exporttoxls.php'>
<table class="display table table-bordered table-striped table-condensed" id="dynamic-table"><thead>
<tr>
    <th>#</th>
    <th>Kode PT</th>
	<th>Nama</th>
	<th>Divisi</th>
	<th>Departmen</th>
	<th>Jabatan</th>
	<th>Kerja</th>
	<th>Tidak Masuk</th>
	<th>Ijin</th>
	<th>Terlambat</th>
	<th>Pulang Cepat</th>
	<th>Lembur</th>
	<th>SP</th>
</tr>
</thead>
		
<tbody>
<?php
//echo 'KeyA = '.$keyA;
	
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
		$key = "branch_code != '' ";
	}else{
		$key = "branch_code = '$keyA'";
	}

	if (!$hr_type){
		$type = "userlevel > '0'";
	}else{
		if ($hr_type == 1){
			$type = "userlevel > '0' AND ctr_sa = '0'";
		}elseif ($hr_type == 2) {
			$type ="userlevel > '0' AND ctr_sa = '1'";
		}elseif ($hr_type == 3) {
			$type ="userlevel > '0' AND temp = '1'";
		}else{
			$type ="userlevel > '0'";
		}
	}

	if(!$div){
		$divi = "uid > '0'";
	}else{
		$divi = "LEFT(corp_dept_code,2) = '$div'";
	}

	if(!$dept){
		$dep = "org_uid >= '0'";
	}else{
		$dep = "LEFT(corp_dept_code,4) = '$dept'";
	}

	$query = "SELECT count(code) FROM member_staff where userlevel != '0' AND $type AND $key AND $divi AND $dep";
	$result = mysql_query($query);
	if (!$result) {   error("QUERY_ERROR");   exit; }
	$total =  @mysql_result($result,0,0);

	

	for ($i = 0; $i < $total ; $i++){

	$query_ms = "SELECT code,name,branch_code,corp_title,LEFT(corp_dept_code,2),corp_dept FROM member_staff where userlevel != '0' AND $key AND $type AND $divi AND $dep";
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

	$query_AB = "SELECT uid,name,date, history
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
	//$code =  @mysql_result($result_AB,0,4);

?>

<tr>
	<td><?=$i+1?></td>
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

<input type='hidden' name='branch[]' value='<?=$branch?>' />
<input type='hidden' name='name_ms[]' value='<?=$name_ms?>' />
<input type='hidden' name='code_ms[]' value='<?=$code_ms?>' />
<input type='hidden' name='divisi[]' value='<?=$divisi?>' />
<input type='hidden' name='departemen[]' value='<?=$departemen?>' />
<input type='hidden' name='workin[]' value='<?=$workin?>' />
<input type='hidden' name='workout[]' value='<?=$workout?>' />
<input type='hidden' name='izin[]' value='<?=$izin?>' />
<input type='hidden' name='late[]' value='<?=$late?>' />
<input type='hidden' name='wo_early[]' value='<?=$wo_early?>' />
<input type='hidden' name='overwork[]' value='<?=$overwork?>' />
<input type='hidden' name='w_warning[]' value='<?=$w_warning?>' />
<?
$print_all = array($branch,$name_ms,'Divisi','Departemen',$workin,$workout,$izin,$late,$wo_early,$overwork,$w_warning);
 } ?>
</tbody>
</table>
<input type='hidden' name='p_month' value='<?=$p_month?>' />
<input type='hidden' name='p_year' value='<?=$p_year?>' />
<input type='hidden' name='sorting_filter' value='<?=$sorting_filter?>' />
<input type='hidden' name='keyA' value='<?=$keyA?>' />
<input type='hidden' name='hr_type' value='<?=$hr_type?>' />
<input type='hidden' name='mm' value='<?=$mm?>' />
<input type='hidden' name='div' value='<?=$div?>' />
<input type='hidden' name='dept' value='<?=$dept?>' />

	<div class='col-sm-3'>
	    <span class='input-group-btn'>
	        <input type='submit' class="form-control" value="Print"><i class='fa fa-print'></i>
	    </span>
	</div>
	</form>

</section>
</div>