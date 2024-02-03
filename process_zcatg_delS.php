<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


	  $query = "DELETE FROM zone_acc_level4 WHERE code4 = '$scode'";
	  $result = mysql_query($query);
	  if(!$result) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
	  exit;

}
?>