<?
$dbconn = mysql_connect($DB_SERVER,$DB_LOGIN,$DB_PASSWORD) or die("Failed to connect the Database!");
$status = mysql_select_db($DB,$dbconn);
if (!$status) {
   error("DB_ERROR");
   exit;
}
?>
