<?php 

include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";


if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

$query_ps = "SELECT count(uid) FROM pos_detail where uid='$id' AND sales_code = '$login_id' AND hostname = '$hostname'";
$result_ps = mysql_query($query_ps);
$total =  @mysql_result($result_ps,0,0);

$query_pos = "SELECT uid,transaction_code FROM pos_detail where uid='$id' AND sales_code = '$login_id' AND hostname = '$hostname' order by date asc";
    $result_pos = mysql_query($query_pos);
    if (!$result_pos) {   error("QUERY_ERROR");   exit; }

    for ($i=0; $i < $total; $i++) { 
    $uid =  @mysql_result($result_pos,$i,0);
    $trans =  @mysql_result($result_pos,$i,1);

    if($uid == $id){
    	$sql_query="DELETE FROM pos_detail WHERE uid='$id' AND hostname='$hostname' AND sales_code='$login_id'";
		mysql_query($sql_query);
    }
   
}
if($val == true AND $id == true){
    echo "<meta http-equiv='Refresh' content='2; URL=$home/pos.php'>";
}else{
    echo "done";    
}
 

}
?>