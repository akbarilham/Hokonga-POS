<?php
include "config/common.php";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$query_getcl = "SELECT id_number from pos_client where sales_code = '$login_id' AND hostname = '$hostname'";
$result_getcl = mysql_query($query_getcl);
$id_number   = @mysql_result($result_getcl, 0, 0);
	
$query_ps = "SELECT count(uid) FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number'";
$result_ps = mysql_query($query_ps);
if (!$result_ps) {   error("QUERY_ERROR");   exit; } 
$total_ps =  @mysql_result($result_ps,0,0);

//get matched data from skills table
$query_pos = "SELECT uid,pos_clientID,detail,datedetail,transcode,temp,qty FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number' order by uid desc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {   error("QUERY_ERROR");   exit; } 

	for ($i=0; $i < $total_ps; $i++) { 
		$uid 			=  @mysql_result($result_pos,$i,0);
		$pos_clientID 	=  @mysql_result($result_pos,$i,1);
		$detail 		=  @mysql_result($result_pos,$i,2);
		$datedetail 	=  @mysql_result($result_pos,$i,3);
		$transcode 		=  @mysql_result($result_pos,$i,4);
		$temp 			=  @mysql_result($result_pos,$i,5);
		$qty1 			=  @mysql_result($result_pos,$i,6);
		
		$new_detail = explode('|',$detail);
		$arrCount = count($new_detail);

		for ($j=0; $j < $arrCount ; $j++){	
			if($j == 3){
			}else if($j == 2){
			}else if($j == 4){
			}else if($j == 5){
				$gross +=$new_detail[$j];
			}else if($j == 6){
				$nett +=$new_detail[$j];
			}else if($j == 7){
				$nettvat +=$new_detail[$j];
			}else if($j == 8){
				$vat +=$new_detail[$j];
			}else{
			}
			
		}
		$qty +=$qty1;
	}

	//$nettvat += $netvat;
	//$vat += $vat1;
	//$nett += $nett1;
	//$qty += $qty1;
	//$gross += $gross1;
    
    $totdis = $nett - $gross;
    //return json data
    $data[] = array(
        'harga' => number_format($nettvat),
        'ppn' =>  number_format($vat),
        'total' => number_format($nett),
        'totqty' => number_format($qty),
        'totdis' => number_format($totdis),
        'gross' => number_format($gross),
		'transcode' => $transcode
      );
    echo json_encode($data);
}
?>