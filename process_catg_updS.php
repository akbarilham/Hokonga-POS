<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

	$new_sname = addslashes($new_sname);

	$query_con1 = "UPDATE shop_catgsml SET condi = '$new_condi' WHERE scode = '$new_scode'"; 
	$result_con1 = mysql_query($query_con1);
	if(!$result_con1) { error("QUERY_ERROR"); exit; }
	
	$query_con2 = "UPDATE shop_catgsml SET sname = '$new_sname' WHERE scode = '$new_scode' AND lang = '$lang'"; 
	$result_con2 = mysql_query($query_con2);
	if(!$result_con2) { error("QUERY_ERROR"); exit; }
	

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
exit;

}
?>