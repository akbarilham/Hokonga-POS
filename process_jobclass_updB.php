<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$bname = addslashes($bname);

/*
$result1 = mysql_query("UPDATE code_jobclass1 SET area_code = '$area_code' WHERE lcode = '$bcode'");
if (!$result1) { error("QUERY_ERROR"); exit;	}
*/

$result = mysql_query("UPDATE code_jobclass1 SET lname = '$bname' WHERE lcode = '$bcode' AND lang = '$lang'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_jobclass.php?gate=$login_gate'>");
exit;

}
?>