<?
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$update_num = $_POST['num'];
$update_org = $_POST['org_shop_code'];

# -------------------------------------------------------

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(num) FROM table_store_name_cvj";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(num) FROM table_store_name_cvj WHERE $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);

for($i = 0; $i < $total_record; $i++) {

  echo 'update num = '; print_r($update_num); 
  echo '<br>update org = '; print_r($update_org);
  echo '<br/>total_record = '; print_r($total_record); 
  # die();
/*
   if ($update_org){
      $query_update = "UPDATE table_store_name_cvj SET org_shop_code = '$update_org' 
                       WHERE num = '$update_num'";
      $result_update = mysql_query($query_update);
      echo 'Update process for '.$update_org.' is success';
      if (!$result_update) {   error("QUERY_ERROR");   exit; }
   } /*else if (!$update_org) {
     $update_org = 
   }*/
  }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/check_code_cvj.php'>");
?>