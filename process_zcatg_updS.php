<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

	$new_sname = addslashes($new_sname);

	$query_con2 = "UPDATE zone_acc_level4 SET name4 = '$new_sname' WHERE code4 = '$new_scode'"; 
	$result_con2 = mysql_query($query_con2);
	if(!$result_con2) { error("QUERY_ERROR"); exit; }
	

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
exit;

}
?>