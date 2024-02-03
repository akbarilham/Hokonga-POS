<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$bname = addslashes($bname);
$big_memo = addslashes($big_memo);

if($uid) {
  $result_uid = mysql_query("UPDATE dir6_catgbig SET mb_code1 = '$big_mb_code1', mb_code2 = '$big_mb_code2', 
            mb_code3 = '$big_mb_code3', memo = '$big_memo' WHERE lcode = '$bcode' AND gate = '$login_gate'");
  if (!$result_uid) { error("QUERY_ERROR"); exit;	}
}

$result = mysql_query("UPDATE dir6_catgbig SET lname = '$bname' WHERE lcode = '$bcode' AND lang = '$lang' AND gate = '$login_gate'");
if (!$result) { error("QUERY_ERROR"); exit;	}

echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tdir.php?gate=$login_gate&mode=$mode&uid=$uid'>");
exit;

}
?>