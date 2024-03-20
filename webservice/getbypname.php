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
    $query = "SELECT pname,org_barcode,org_pcode FROM shop_product_list WHERE pname LIKE '%$searchTerm%' ORDER BY pname ASC";
    $fetch = mysql_query($query);
    while ($row = mysql_fetch_array($fetch)) {
        $data[] = array( 
         'label' => $row['pname']
        , 'value' => $row['org_barcode']
        ,  'desc' => $row['org_pcode']
        );
    }
    
    //return json data
    echo json_encode($data);
}
?>