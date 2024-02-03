<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$bname = addslashes($bname);

$result = mysql_query("UPDATE code_payclass1 SET lname = '$bname' WHERE lcode = '$bcode'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_payclass.php?gate=$login_gate'>");
exit;

}
?>