<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }
if(!$key_gate) { $key_gate = $client_id; }


	$query_u1 = "UPDATE wpage_config SET b_num = '$target_num' WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_u1 = mysql_query($query_u1);
		if(!$result_u1) { error("QUERY_ERROR"); exit;}

	$query_u2 = "UPDATE wpage_config SET b_num = '$b_num' WHERE uid = '$target_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result_u2 = mysql_query($query_u2);
		if(!$result_u2) { error("QUERY_ERROR"); exit;}

		
echo("<meta http-equiv='Refresh' content='0; URL=$home/website_menu.php?key_gate=$key_gate'>");
exit;

}
?>


