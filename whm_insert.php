<? 

include "config/common.inc";
if (!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {   
    include "config/dbconn.inc";
        //parameter
    $uid   		= $_POST["id"];
    $barcode   	= $_POST["code"];
    $item_code  = $_POST["item"];
    $date 		=  date("Y-m-d");
    $query = "INSERT INTO wms_stock (uid,gudang_code,loc_code,puid,org_barcode,org_pcode,post_date) VALUES ('','','','$uid','$barcode','$item_code','$date')";
    $fetch = mysql_query($query);
}

?>