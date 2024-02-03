<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

	$b_code = substr($m_catg,0,2); // 대분류 코드를 얻는다.
	
	// 소분류 코드 생성
	$rm_query = "SELECT scode FROM shop_catgsml WHERE mcode = '$m_catg' ORDER BY scode DESC";
  $rm_result = mysql_query($rm_query);
  if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_scode = @mysql_result($rm_result,0,0);
  
  $max_num = substr($max_scode,4);
    
  $new_num1 = $max_num + 1;
  $new_num = sprintf("%02d", $new_num1); // 2자리수
    
  if($max_scode == "") {
    $addcode = $m_catg . "01";
  } else {
    $addcode = $m_catg . "$new_num";
  }
    
	
	$s_name = addslashes($new_sname);

	// 소분류 항목을 추가 (3개 언어 동시에)
	$query_S1  = "INSERT INTO shop_catgsml (lcode, mcode, scode, sname, lang, gate, branch_code) 
	              VALUES ('$b_code','$m_catg','$addcode','$s_name', 'en', '$login_gate', '$login_branch')";
	$result_S1 = mysql_query($query_S1);
		if(!$result_S1) {	error("QUERY_ERROR");	exit;	}

  $query_S2  = "INSERT INTO shop_catgsml (lcode, mcode, scode, sname, lang, gate, branch_code) 
	              VALUES ('$b_code','$m_catg','$addcode','$s_name', 'in', '$login_gate', '$login_branch')";
	$result_S2 = mysql_query($query_S2);
		if(!$result_S2) {	error("QUERY_ERROR");	exit;	}

  $query_S3  = "INSERT INTO shop_catgsml (lcode, mcode, scode, sname, lang, gate, branch_code) 
	              VALUES ('$b_code','$m_catg','$addcode','$s_name', 'ko', '$login_gate', '$login_branch')";
	$result_S3 = mysql_query($query_S3);
		if(!$result_S3) {	error("QUERY_ERROR");	exit;	}


echo("<meta http-equiv='Refresh' content='0; URL=$home/system_category.php?gate=$login_gate'>");
exit;

}
?>