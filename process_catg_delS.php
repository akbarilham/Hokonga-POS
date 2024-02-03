<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


	// 소분류 제거시 해당 상품이 있으면 삭제하지 못하도록 함
	$p_query = "SELECT * FROM shop_product_list WHERE catg_code = '$scode'";
	$p_result = mysql_query($p_query);  // 쿼리문을 SQL서버에 전송
	  if (!$p_result) {
	     error("QUERY_ERROR");
	     exit;
	  }   

	$rowsP = mysql_fetch_row($p_result);
	$p_mcode = $rowsP[1];
	
  if(!$p_mcode) {
	  $query = "DELETE FROM shop_catgsml WHERE scode = '$scode'";
	  $result = mysql_query($query);
	  if(!$result) {
	    error("QUERY_ERROR");
	  exit;
	  }

	  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
	  exit;

  } else {
  
    ?>
		<script language="javascript">
		alert("<?=$txt_sys_category_chk03?>");
		</script>
		<?

		echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
		exit;
  
  
  }
  
}
?>