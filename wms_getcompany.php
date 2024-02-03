<?php
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
    
    //get search term
    $searchTerm = $_POST['com'];
    
    //get matched data from skills table
	$query = "SELECT count(uid) FROM client_shop WHERE code = '$searchTerm' ORDER BY code ASC";
    $fetch = mysql_query($query);
	$fuid   =mysql_result($fetch,0,0);
	
    $query_a = "SELECT shop_code,shop_name FROM client_shop WHERE code = '$searchTerm' ORDER BY code ASC";
    $fetch_a = mysql_query($query_a);
    echo "<select name='shop' id='shop' class='form-control'>";
    for ($k=0;$k<$fuid;$k++) {
		$code   =mysql_result($fetch_a,$k,0);
		$name   =mysql_result($fetch_a,$k,1);
		echo "<option value='".$code."'>".$name."</option>";
    }
	echo "</select>";
    

}
?>