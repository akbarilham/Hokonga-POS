<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


if(!strcmp($mode,"big")) {

	$mid_query = "SELECT * FROM dept_catgmid WHERE lcode = '$bcode'";
	$mid_result = mysql_query($mid_query);
	  if (!$mid_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rows = mysql_fetch_row($mid_result);
	$mcode = $rows[0];

	if(!$mcode) {

		$query = "DELETE FROM dept_catgbig WHERE lcode = '$bcode'";
		$result = mysql_query($query);

		if(!$result) {
		 error("QUERY_ERROR");
		 exit;
		}

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
		exit;


	} else if($mcode) {

		?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk02?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
		exit;

	}


} else if(!strcmp($mode,"mid")) {


	$p_query = "SELECT * FROM dept_catgsml WHERE mcode = '$mcode'";
	$p_result = mysql_query($p_query);
	  if (!$p_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rowsP = mysql_fetch_row($p_result);
	$p_mcode = $rowsP[1];
	
  if(!$p_mcode) {
	  $query = "DELETE FROM dept_catgmid WHERE mcode = '$mcode'";
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
		alert("<?=$txt_sys_category_chk03?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
		exit;
  
  
  }

}

}
?>
