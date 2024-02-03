<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


if(!strcmp($mode,"big")) {

	$mid_query = "SELECT * FROM zone_acc_level3 WHERE code2 = '$bcode'";
	$mid_result = mysql_query($mid_query);  // 쿼리문을 SQL서버에 전송
	  if (!$mid_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rows = mysql_fetch_row($mid_result);
	$mcode = $rows[0];

	if(!$mcode) {

		$query = "DELETE FROM zone_acc_level2 WHERE code2 = '$bcode'";
		$result = mysql_query($query);

		if(!$result) {
		 error("QUERY_ERROR");
		 exit;
		}

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
		exit;
	
	} else if($mcode) {

		?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk02?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
		exit;

	}


} else if(!strcmp($mode,"mid")) {


	$sml_query = "SELECT * FROM zone_acc_level4 WHERE code3 = '$mcode'";
	$sml_result = mysql_query($sml_query);  // 쿼리문을 SQL서버에 전송
	  if (!$sml_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rowsml = mysql_fetch_row($sml_result);
	$scode = $rowsml[0];

	if(!$scode) {

	  $query4 = "DELETE FROM zone_acc_level3 WHERE code3 = '$mcode'";
	  $result4 = mysql_query($query4);
	  if(!$result4) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
	  exit;
	 
	} else if($scode) {

		?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk02?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
		exit;

	}

 
}

}
?>
