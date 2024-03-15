<?php 

include "config/common.php";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";

echo $_GET['id'];
echo $_GET['val'];

if(isset($_POST['idm'])) {
    $id = $_POST['idm'];
}else{
    $id = $_POST['idp'];
}

$query_ps = "SELECT count(uid) FROM pos_detail where sales_code = '$login_id' AND hostname = '$hostname'";
$result_ps = mysql_query($query_ps);
$total =  @mysql_result($result_ps,0,0);

$query_pos = "SELECT uid,qty,price,disc_rate FROM pos_detail where uid = '$id' AND sales_code = '$login_id' AND hostname = '$hostname' order by date asc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {   error("QUERY_ERROR");   exit; }

for ($i=0; $i < $total; $i++) { 
$uid =  @mysql_result($result_pos,$i,0);
$qty =  @mysql_result($result_pos,$i,1);
$price =  @mysql_result($result_pos,$i,2);
$disc =  @mysql_result($result_pos,$i,3);
if(isset($_POST['idm'])) {
    $qtym = $qty - 1;
}else{
    $qtym = $qty + 1;
}
$newgross = $qtym*$price;
$newdis = $newgross*($disc/100);
$newnett = $newgross-$newdis;
$newvat = $newnett/11;
$newnettvat = $newvat*10;
    
if($uid == $id){
    $sql_query="UPDATE pos_detail SET qty = '$qtym', gross = '$newgross',nett = '$newnett',netvat = '$newnettvat',vat = '$newvat' WHERE  hostname='$hostname' AND sales_code='$login_id' AND uid='$uid'";
    mysql_query($sql_query);
}

}
echo "done"; 

}
?>
<meta http-equiv='Refresh' content='2; URL=$home/pos.php'>
