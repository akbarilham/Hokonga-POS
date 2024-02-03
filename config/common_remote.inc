<?
$DB1_SERVER="localhost";
$DB1_LOGIN="root";
$DB1_PASSWORD="";
$DB1="feelbuy"; 

$dbconn1 = mysql_connect($DB1_SERVER,$DB1_LOGIN,$DB1_PASSWORD) or die("Failed to connect the Server Database!");
$status1 = mysql_select_db($DB1,$dbconn1);
if (!$status1) { error("DB_ERROR"); exit; }



// Directory
//$home1 = "http://feelbuy.ikbiz.com";
// $root1 = "/home/feelbuy";
$home1 = "http://10.10.2.10/feelbuy";
$root1 = "/var/www/html/feelbuy";

$home2 = "http://localhost/feelbuy-shop";
$root = "/home/feelbuy-shop";

?>
