<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/user_functions_{$lang}.inc";


$bname = addslashes($bname);

$result = mysql_query("UPDATE wms_catgbig SET lname = '$bname' WHERE lcode = '$bcode'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_wloc_catg.php'>");
exit;

}
?>