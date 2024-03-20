<?php
include "config/common.php";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

    include "config/dbconn.php";
    include "config/text_main_{$lang}.php";
    include "config/user_functions_{$lang}.php";
    
    //get search term
    $searchTerm = $_GET['term'];

    $search_exploded = explode ("-", $searchTerm);
     $x=0;
    foreach($search_exploded as $search_each)
    {
        $x++;
        if($x==1){
            $find .="
                LEFT(org_barcode,8) LIKE '%$search_each%' 
                OR LEFT(org_pcode,4) LIKE '%$search_each%'
                OR org_pcode LIKE '%$search_each%'
                OR org_barcode LIKE '%$search_each%' 
                OR REPLACE(pname, ' ', '') = REPLACE('%$search_each%', ' ', '')
                OR pname LIKE '%$search_each%' 
                OR RIGHT(org_barcode,6) LIKE '%$search_each%'
                OR RIGHT(org_pcode,4) LIKE '%$search_each%'     
            ";    
        }
        else{
            $find .="   AND LEFT(org_barcode,8) LIKE '%$search_each%' 
                        OR LEFT(org_pcode,4) LIKE '%$search_each%'
                        OR org_pcode LIKE '%$search_each%' 
                        OR pname LIKE '%$search_each%' 
                        OR RIGHT(org_barcode,6) LIKE '%$search_each%'
                        OR RIGHT(org_pcode,4) LIKE '%$search_each%'
            ";
        }
    }
    //get matched data from skills table
    $query = "SELECT uid,org_pcode,org_barcode,pname,price_sale,dc_rate FROM item_masters WHERE  $find AND stok_awal >= 1 ORDER BY org_pcode ASC";
    $fetch = mysql_query($query);
    while ($row = mysql_fetch_array($fetch)) {
        $data[] = array( 
         'label' => $row['org_pcode'].' - '.substr($row['pname'],0,30).' - '.$row['org_barcode']
        , 'value' => $row['org_barcode']
        , 'lbl1' => $row['org_pcode']
        , 'desc' => $row['pname']
        , 'uid' => $row['uid']
        , 'price' => $row['price_sale']
        , 'disc' => $row['dc_rate']
    	);
    }
    
    //return json data
    echo json_encode($data);
}
?>