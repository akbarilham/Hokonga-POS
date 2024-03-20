<?php
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = "SELECT org_pcode,org_barcode,pname FROM shop_product_list WHERE org_pcode LIKE '%$searchTerm%' ORDER BY org_pcode ASC";
    $fetch = mysql_query($query);
    while ($row = mysql_fetch_array($fetch)) {
        $data[] = array( 
         'label' => $row['org_pcode']
        , 'value' => $row['org_barcode']
        , 'desc' => $row['pname']
    	);
    }
    
    //return json data
    echo json_encode($data);
}
?>