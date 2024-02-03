<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$new_mname = addslashes($new_mname);

$result = mysql_query("UPDATE code_payclass2 SET mname = '$new_mname' WHERE mcode = '$new_mcode'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_payclass.php?gate=$login_gate'>");
exit;

}
?>