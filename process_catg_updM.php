<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/user_functions_{$lang}.inc";


$new_mname = addslashes($new_mname);

$result = mysql_query("UPDATE shop_catgmid SET mname = '$new_mname' WHERE mcode = '$new_mcode' AND lang = '$lang'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
exit;

}
?>