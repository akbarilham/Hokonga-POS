<?
$query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = '$login_id'";
$fetch_0509 = mysql_query($query_0509);
$smode_0509_K3 = @mysql_result($fetch_0509,0,2);
$module_0509 = substr($smode_0509_K3,8,1);
?>
