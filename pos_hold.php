<?php
/*
author : Yogi Anditia
update : Cihuy
*/
include "config/common.php";
include "config/dbconn.php";
if (!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
	include "config/dbconn.inc";
	$transcode = $_GET['transcode'];

	$query_trans_upd = "UPDATE pos_detail2 SET temp = '1' WHERE temp = '0' AND transcode = '$transcode'";
	$fetch_trans_upd = mysqli_query($dbconn, $query_trans_upd);
	if (!$fetch_trans_upd) { error("QUERY_ERROR"); exit; }
	
	echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>");
}

?>