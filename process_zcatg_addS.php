<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


	$b1_code = substr($m_catg,0,1);
	$b2_code = substr($m_catg,0,2);
	
	$s_name = addslashes($new_sname);

	$query_S1  = "INSERT INTO zone_acc_level4 (code1, code2, code3, code4, name4) VALUES ('$b1_code','$b2_code','$m_catg','$new_scode4','$s_name')";
	$result_S1 = mysql_query($query_S1);
		if(!$result_S1) {	error("QUERY_ERROR");	exit;	}



echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
exit;

}
?>