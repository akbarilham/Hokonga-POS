<?
include "../config/common.inc";
include "../config/dbconn.inc";
include "../config/text_main_{$lang}.inc";
include "../config/user_functions_{$lang}.inc";

//JSON Get
$var = $_REQUEST['var'];
$convertstring = stripslashes($var);
$objdecode 	   = json_decode($convertstring);

//JSON Declaration
$nama		= $objdecode->nama;
$pt			= $objdecode->pt;
$departemen	= $objdecode->departemen;
$jam_kerja  = $objdecode->jam_kerja;
$format		= $objdecode->format;

 // JSON Log 
$my_file = date("Ymd", time()) . '-absen' . '.txt';
if (!file_exists(date("Ymd", time()))) {
	mkdir(date("Ymd", time()));
}

$handle = fopen($my_file, 'a') or die('Cannot open file:  ' . $my_file);
$data = date('m/d/Y h:i:s a', time()) . PHP_EOL;
fwrite($handle, $data);

$data = 'Nama Staff :' . ' ' . $nama . PHP_EOL;
fwrite($handle, $data);
$data = 'PT :' . ' ' . $pt . PHP_EOL;
fwrite($handle, $data);
$data = 'Departement :' . ' ' . $departemen . PHP_EOL;
fwrite($handle, $data);
$data = 'jam_kerja :' . ' ' . $jam_kerja . PHP_EOL;
fwrite($handle, $data);

$data = '-------------------------------------------------------------------' . PHP_EOL;
fwrite($handle, $data);  

//Query Insert
if($format == 'M') {
	//$insert_data Masuk
/* 	$query_add = "INSERT INTO member_staff_worktime (uid,branch_code,code,name,nik,date,shift,
				 work_status,work_off_type,work_time1,work_time2,work_in,work_out,work_in_early,work_in_late,
				 work_out_early,work_hours,warning) VALUES ('','$new_branch_code','$new_user_code','$new_user_name',
				 '$new_user_nik','$new_date_sets','$new_shift','$new_work_status','$new_work_off_type','$work_time1',
				 '$work_time2','$work_in','$work_out','$new_work_in_early','$new_work_in_late','$new_work_out_early',
				 '$new_work_hours','$warning')"; 
	$insert_data = mysql_query($query_add);
	if(!$insert_data) { error("QUERY_ERROR"); exit; }	*/
	
	try {
		
		$status = array('status' => 'Success', 'Description' => $jam_kerja.' datang telah masuk ke Data');
		echo json_encode($status);
		$data = 'nama ' . PHP_EOL;
		fwrite($handle, $data);

	} catch (Exception $e) {

		if(!$nama){
		   $status = array('status' => 'Failure', 'Description' => 'Nama tidak ada');
		}
		if(!$jam_kerja){
		   $status = array('status' => 'Failure', 'Description' => 'Jam Kerja tidak ada');
		}
		echo json_encode($status);

		$data = 'email id Not present' . PHP_EOL;
		fwrite($handle, $data);

	}	
} else if ($format == "P") {
	//$insert_data Pulang
/* 	$query_add = "INSERT INTO member_staff_worktime (uid,branch_code,code,name,nik,date,shift,
				 work_status,work_off_type,work_time1,work_time2,work_in,work_out,work_in_early,work_in_late,
				 work_out_early,work_hours,warning) VALUES ('','$new_branch_code','$new_user_code','$new_user_name',
				 '$new_user_nik','$new_date_sets','$new_shift','$new_work_status','$new_work_off_type','$work_time1',
				 '$work_time2','$work_in','$work_out','$new_work_in_early','$new_work_in_late','$new_work_out_early',
				 '$new_work_hours','$warning')";
	//$insert_data = mysql_query($query_add);
	if(!$insert_data) { error("QUERY_ERROR"); exit; }	 */
	
	try {
		
		$status = array('status' => 'Success', 'Description' => $jam_kerja.' pulang telah masuk ke Data');
		echo json_encode($status);
		$data = 'nama ' . PHP_EOL;
		fwrite($handle, $data);

	} catch (Exception $e) {

		if(!$nama){
		   $status = array('status' => 'Failure', 'Description' => 'Nama tidak ada');
		}
		if(!$jam_kerja){
		   $status = array('status' => 'Failure', 'Description' => 'Jam Kerja tidak ada');
		}
		echo json_encode($status);

		$data = 'email id Not present' . PHP_EOL;
		fwrite($handle, $data);

	}	
	
}

$data = '-------------------------------------------------------------------' . PHP_EOL;
fwrite($handle, $data); 
?>
