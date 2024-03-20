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
/*
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
            $find .="  AND LEFT(org_barcode,8) LIKE '%$search_each%' 
                        OR LEFT(org_pcode,4) LIKE '%$search_each%'
                        OR org_pcode LIKE '%$search_each%' 
                        OR pname LIKE '%$search_each%' 
                        OR RIGHT(org_barcode,6) LIKE '%$search_each%'
                        OR RIGHT(org_pcode,4) LIKE '%$search_each%'

                        ";
        }
    }*/
    //get matched data from skills table
    $query = "SELECT uid,transaction_code,total_item,total_nett,cash_amount,card_amount,remain FROM pos_total WHERE  transaction_code LIKE '%$search_each%'  ORDER BY org_pcode ASC";
    $fetch = mysql_query($query);
    while ($row = mysql_fetch_array($fetch)) {
        $data[] = array( 
         'uid' => $row['uid']
        , 'transaction_code' => $row['transaction_code']
        , 'total_item' => $row['total_item']
        , 'total_nett' => $row['total_nett']
        , 'cash_amount' => $row['cash_amount']
        , 'card_amount' => $row['card_amount']
        , 'remain' => $row['remain']
    	);
    }
    
    //return json data
    echo json_encode($data);
}
?>