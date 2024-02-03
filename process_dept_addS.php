<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

	$b_code = substr($m_catg,0,2); // Main Category Code
	
	// New Small Category Code
	$rm_query = "SELECT scode FROM dept_catgsml WHERE mcode = '$m_catg' ORDER BY scode DESC";
	$rm_result = mysql_query($rm_query);
		if (!$rm_result) { error("QUERY_ERROR"); exit; }
	$max_scode = @mysql_result($rm_result,0,0);
  
	$max_num = substr($max_scode,4);
    
	$new_num1 = $max_num + 1;
	$new_num = sprintf("%02d", $new_num1); // 2 digits
    
	if($max_scode == "") {
		$addcode = $m_catg . "01";
	} else {
		$addcode = $m_catg . "$new_num";
	}
    
	
	$s_name = addslashes($new_sname);

	$query_S1  = "INSERT INTO dept_catgsml (lcode, mcode, scode, sname, lang, branch_code) 
	              VALUES ('$b_code','$m_catg','$addcode','$s_name', '$lang', '$login_branch')";
	$result_S1 = mysql_query($query_S1);
		if(!$result_S1) {	error("QUERY_ERROR");	exit;	}


echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
exit;

}
?>