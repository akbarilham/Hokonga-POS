<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


	$p_query = "SELECT * FROM member_staff WHERE corp_dept_code = '$scode' AND userlevel > '0'";
	$p_result = mysql_query($p_query);
	  if (!$p_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rowsP = mysql_fetch_row($p_result);
	$p_mcode = $rowsP[1];
	
  if(!$p_mcode) {
	  $query = "DELETE FROM dept_catgsml WHERE scode = '$scode'";
	  $result = mysql_query($query);
	  if(!$result) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
	  exit;

  } else {
  
    ?>
		<script language="javascript">
		alert("Cannot remove.");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
		exit;
  
  
  }
  
}
?>