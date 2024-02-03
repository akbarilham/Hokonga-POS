<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$new_highlevel) {
	$new_highlevel = "1";
}

$new_mname = addslashes($new_mname);

$result1 = mysql_query("UPDATE code_jobclass2 SET mname_abr = '$new_mname_abr', highlevel = '$new_highlevel' WHERE lcode = '$new_lcode' AND mcode = '$new_mcode'");
if (!$result1) { error("QUERY_ERROR"); exit;	}

$result = mysql_query("UPDATE code_jobclass2 SET mname = '$new_mname' WHERE lcode = '$new_lcode' AND mcode = '$new_mcode' AND lang = '$lang'");
if (!$result) { error("QUERY_ERROR"); exit;	}


echo("<meta http-equiv='Refresh' content='0; URL=$home/system_jobclass.php?gate=$login_gate'>");
exit;

}
?>