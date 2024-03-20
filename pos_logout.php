<?php
include "config/common.php";
include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";

$mmenu = "user";
$smenu = "user_logout";

$url = $home;
$signdate = time();

SetCookie("login_id","",-0,"/");
SetCookie("login_level","",-0,"/");
SetCookie("login_branch","",-0,"/");
SetCookie("login_gate","",-0,"/");
SetCookie("login_subgate","",-0,"/");
SetCookie("login_shop","",-0,"/");
SetCookie("login_ip","",-0,"/");
SetCookie("loco","",-0,"/");
SetCookie("login_user_name","",-0,"/");
SetCookie("login_shop_flag","",-0,"/");
SetCookie("login_shop_userlevel","",-0,"/");
      
 
echo ("<meta http-equiv='Refresh' content='0; URL=$url'/pos_login.php>");
exit;
?>
