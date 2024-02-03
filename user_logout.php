<?
ob_start();
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

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

ob_end_flush(); 
echo ("<meta http-equiv='Refresh' content='0; URL=$url'>");
exit;
?>
