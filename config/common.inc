<?
$DB_SERVER="localhost";      // Database Server machine
$DB_LOGIN="root";            // Database login ID
$DB_PASSWORD="";         // Database password
$DB="feelbuy";                // Database name


// Website Identity
$web_erp_name = "FEEL BUY ERP";
$copyright_name = "&copy; 2016 FEELBUY ERP. Built on Twitter Bootstrap & BrisHub ERP System.";


$admin_email = "erp@feelbuy.co.id";


$home ="http://127.0.0.1/feelbuy";
$home_txt = "127.0.0.1/feelbuy";
$root = "";

if(isset($_COOKIE['login_id'])) {
	$login_id = $_COOKIE['login_id'];
	$login_branch = $_COOKIE['login_branch'];
	$login_ip = $_COOKIE['login_ip'];
	$login_shop_userlevel = $_COOKIE['login_shop_userlevel'];
}
if (isset($_COOKIE['login_shop_flag'])) {
	$login_shop_flag = $_COOKIE['login_shop_flag'];
}
if (isset($_COOKIE['login_user_name'])) {
	$login_user_name = $_COOKIE['login_user_name'];
}
if (isset($_COOKIE['login_level'])) {
	$login_level = $_COOKIE['login_level'];
}
if (isset($_COOKIE['login_shop'])) {
 	$login_shop = $_COOKIE['login_shop'];
}
if (isset($_COOKIE['login_gate'])) {
 	$login_gate = $_COOKIE['login_gate'];
}
if (isset($_COOKIE['login_subgate'])) {
 	$login_subgate = $_COOKIE['login_subgate'];
 } // set cookies
?>
