<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


if(!strcmp($mode,"big")) {

	$mid_query = "SELECT * FROM dir6_catgmid WHERE lcode = '$bcode'";
	$mid_result = mysql_query($mid_query);  // �������� SQL������ ����
	  if (!$mid_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rows = mysql_fetch_row($mid_result);
	$mcode = $rows[0];

	if(!$mcode) {

		$query = "DELETE FROM dir6_catgbig WHERE lcode = '$bcode'";
		$result = mysql_query($query);

		if(!$result) {
		 error("QUERY_ERROR");
		 exit;
		}

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tdir.php?gate=$login_gate'>");
		exit;


	} else if($mcode) {

		?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk02?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tdir.php?gate=$login_gate'>");
		exit;

	}


} else if(!strcmp($mode,"mid")) {


  // �ߺз� ���Ž� �ش� ��α� ������ ������ �������� ���ϵ��� ��
  
  
  
  
	
  if(!$p_mcode) {
	  $query = "DELETE FROM dir6_catgmid WHERE mcode = '$mcode'";
	  $result = mysql_query($query);
	  if(!$result) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tdir.php?gate=$login_gate'>");
	  exit;

  } else {
  
    ?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk03?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_tdir.php?gate=$login_gate'>");
		exit;
  
  
  }

}

}
?>
