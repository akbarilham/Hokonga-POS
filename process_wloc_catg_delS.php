<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


	$p_query = "SELECT * FROM wms_location_list WHERE catg_code = '$scode'";
	$p_result = mysql_query($p_query);
	  if (!$p_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rowsP = mysql_fetch_row($p_result);
	$p_mcode = $rowsP[1];
	
  if(!$p_mcode) {
	  $query = "DELETE FROM wms_catgsml WHERE scode = '$scode'";
	  $result = mysql_query($query);
	  if(!$result) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_wloc_catg.php'>");
	  exit;

  } else {
  
    ?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk03?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_wloc_catg.php'>");
		exit;
  
  
  }
  
}
?>