<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/user_functions_{$lang}.inc";


$bname = addslashes($bname);

$result = mysql_query("UPDATE shop_catgbig SET lname = '$bname' WHERE lcode = '$bcode' AND lang = '$lang'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
exit;

}
?>