<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  


if($add_mode == "ACC_UPD") {

    if(!$new_acc_chk) {
      $new_acc_chk = "0";
    }

    if($key) {
      $result_CHG = mysql_query("UPDATE code_acc_list SET acc_name = '$new_acc_name', $key = '$new_acc_chk' 
                  WHERE acc_code = '$new_acc_code'",$dbconn);
    } else {
      $result_CHG = mysql_query("UPDATE code_acc_list SET acc_name = '$new_acc_name' 
                  WHERE uid = '$new_acc_uid'",$dbconn);
    }
    if(!$result_CHG) { error("QUERY_ERROR"); exit; }


} else if($add_mode == "ACC_DEL") {

    $result_DEL = mysql_query("DELETE FROM code_acc_list WHERE acc_code = '$new_acc_code'",$dbconn);
    if(!$result_DEL) { error("QUERY_ERROR"); exit; }


} else if($add_mode == "ACC_ADD") {

    
    // 새로운 계정 항목 코드 생성
    $rm_query = "SELECT acc_code FROM code_acc_list WHERE catg = '$new_catg' ORDER BY acc_code DESC";
    $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
    $max_room = @mysql_result($rm_result,0,0);
  
    $exp_room1 = substr($max_room,2,2);
    $new_room_num1 = $exp_room1 + 1;
    if($new_room_num1 < 10) { $new_room_num = "0".$new_room_num1; } else { $new_room_num = $new_room_num1; }
    
    if($max_room == "") {
      $new_acc_code = $new_catg . "01";
    } else {
      $new_acc_code = $new_catg . "$new_room_num";
    }
    
    
    // 언어별 등록
    if($key) {
    $query_ADD1 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,$key) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','en','1')";
    $result_ADD1 = mysql_query($query_ADD1);
    if (!$result_ADD1) { error("QUERY_ERROR"); exit; }
    
    $query_ADD2 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,$key) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','in','1')";
    $result_ADD2 = mysql_query($query_ADD2);
    if (!$result_ADD2) { error("QUERY_ERROR"); exit; }
    
    $query_ADD3 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,$key) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','ko','1')";
    $result_ADD3 = mysql_query($query_ADD3);
    if (!$result_ADD3) { error("QUERY_ERROR"); exit; }
    } else {
    $query_ADD1 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,branch_code) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','en','$key')";
    $result_ADD1 = mysql_query($query_ADD1);
    if (!$result_ADD1) { error("QUERY_ERROR"); exit; }
    
    $query_ADD2 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,branch_code) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','in','$key')";
    $result_ADD2 = mysql_query($query_ADD2);
    if (!$result_ADD2) { error("QUERY_ERROR"); exit; }
    
    $query_ADD3 = "INSERT INTO code_acc_list (uid,f_class,catg,acc_code,acc_name,lang,branch_code) 
        values ('','$new_class','$new_catg','$new_acc_code','$new_acc_name','ko','$key')";
    $result_ADD3 = mysql_query($query_ADD3);
    if (!$result_ADD3) { error("QUERY_ERROR"); exit; }
    }


}

// 리스트로 돌아가기
echo("<meta http-equiv='Refresh' content='0; URL=$home/system_account.php?keyfield=$keyfield&key=$key'>");
exit;


}
?>
