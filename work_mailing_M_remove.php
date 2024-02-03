<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }

if($rmode == "1") {
	$query_dbm = "UPDATE member_staff SET crmflag = '0' WHERE uid = '$uid' AND branch_code = '$login_branch'";
} else {
	$query_dbm = "UPDATE member_main SET crmflag = '0' WHERE uid = '$uid' AND branch_code = '$login_branch'";
}
$result_dbm = mysql_query($query_dbm,$dbconn);

    if(!$result_dbm) {
      error("QUERY_ERROR");
      exit;
    }


// Retour
if(!$rmode) { $smenu_here = "crm_mailing2"; } else { $smenu_here = "crm_mailing"."$rmode"; }

echo("<meta http-equiv='Refresh' content='0; URL=$home/$smenu_here.php?lang=$lang&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&room=$room&page=$page'>");
exit;

}
?>



