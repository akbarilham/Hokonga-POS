<?php

include "config/common.php";
include "config/dbconn.php";
if (!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
	include "config/dbconn.php";
	$transcode = $_GET['hold'];
	$id = $_GET['id'];
	$stat = $_GET['stat'];

  if ($login_id == 'superadmin') {
      $getdata = "hostname != ''";
  } else {
      $getdata = "sales_code = '$login_id'";
  }

  $query_getcly = "SELECT id_number,sales_code from pos_client where $getdata";
	$result_getcly = mysqli_query($dbconn, $query_getcly);
  if (!$result_getcly) { error("QUERY_ERROR"); exit; }
	$id_number1y   = @mysql_result($result_getcly, 0, 0);
  $sales_code1y   = @mysql_result($result_getcly, 0, 1);

	if($stat == 'update'){
		$query_trans_upd = "UPDATE pos_detail2 SET temp = '0' WHERE temp = '1'
    AND transcode = '$transcode' AND pos_clientID = '$id_number1y'";
	$fetch_trans_upd = mysqli_query($dbconn, $query_trans_upd);
	if (!$fetch_trans_upd) { error("QUERY_ERROR"); exit; }


	}else{
		$query_trans_del = "UPDATE pos_detail2 SET temp= 'D' WHERE transcode = '$transcode'";
	$fetch_trans_del = mysqli_query($dbconn, $query_trans_del);
	if (!$fetch_trans_del) { error("QUERY_ERROR"); exit; }


	}
	echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>");
}

?>
