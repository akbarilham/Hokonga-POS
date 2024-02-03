<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/user_functions_{$lang}.inc";


$new_mname = addslashes($new_mname);

$result = mysql_query("UPDATE zone_acc_level3 SET name3 = '$new_mname' WHERE code3 = '$new_mcode'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
exit;

}
?>