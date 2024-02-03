<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$savedir = "user_file";


if($mode == "del") {



		
		$query_upd = "SELECT userfile FROM shop_product_catg_photo WHERE uid = '$qs_uid'";
		$result_upd = mysql_query($query_upd);
			if(!$result_upd) { error("QUERY_ERROR"); exit; }
		$row_upd = mysql_fetch_object($result_upd);

		$del_userfile = $row_upd->userfile;
	
		if(!unlink("$savedir/$del_userfile")) {
			echo "Failed to delete images involved";
			exit;
		}


		// Database
		$query_del  = "DELETE FROM shop_product_catg_photo WHERE uid = '$qs_uid'";
		$result_del = mysql_query($query_del);
		if(!$result_del) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_online.php?mode=upd_photo&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&mode=upd_photo&uid=$stock_uid&page=$page'>");
  exit;


} else if($mode == "upd") { 
  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_online.php?mode=upd_photo&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&mode=upd_photo&uid=$stock_uid&page=$page'>");
  exit;

}

}
?>
