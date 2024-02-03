<?
// 정렬
if($b_array == "RAND") {
  $b_array_now = "rand()";
} else if($b_array == "ASC") {
  $b_array_now = "signdate ASC, fid ASC, thread ASC";
} else {
  $b_array_now = "signdate DESC, fid DESC, thread ASC";
}


$queryAll = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate'";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate'";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate' AND $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query,$dbconn);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);

// 현재의 페이지에서 출력할 게시물의 범위
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

// 전체 페이지수를 계산
$total_page = ceil($total_record/$num_per_page);


// COLPAN
if($b_option == "0") {
   $td_colspan = "7";
} else {
   $td_colspan = "6";
}


// 퍼미션 정의 - 리스트와 쓰기 버튼 활성화 여부 *************************************** //
if($b_permit == '0' OR ($login_id AND $login_id != "" AND $login_level > "2")) {

  $act_read = "on";
  $act_post = "on";

} else {

  if($login_id AND $login_id != "") {
    if($b_permit == "5") {
      if($member_level > "4") {
        $act_read = "on";
        $act_post = "on";
      } else {
        $act_read = "off";
        $act_post = "off";
      }
    } else if($b_permit == "4") {
      $act_read = "on";
      $act_post = "on";
    } else if($b_permit == "3") {
      $act_read = "on";
      $act_post = "off";
    } else if($b_permit == "2") {
      $act_read = "on";
      $act_post = "off";
    } else if($b_permit == "1") {
      $act_read = "on";
      $act_post = "on";
    } else {
      $act_read = "on";
      $act_post = "on";
    }

  } else {

    if($b_permit < "3") {
      $act_read = "on";
      $act_post = "off";
    } else {
      $act_read = "off";
      $act_post = "off";
    }
  
  }

}
?>


<SCRIPT LANGUAGE="JavaScript"> 
<!-- 
function imgResize(img){ 
  img1= new Image(); 
  img1.src=(img); 
  imgControll(img); 
} 

function imgControll(img){ 
  if((img1.width!=0)&&(img1.height!=0)){ 
    viewImage(img); 
  } 
  else{ 
    controller="imgControll('"+img+"')"; 
    intervalID=setTimeout(controller,20); 
  } 
} 

function viewImage(img){ 
        W=img1.width; 
        H=img1.height; 
        O="width="+W+",height="+H; 
        imgWin=window.open("","",O); 
        imgWin.document.write("<html><head><title>Image Preview</title></head>");
        imgWin.document.write("<body topmargin=0 leftmargin=0>");
        imgWin.document.write("<img src="+img+" onclick='self.close()'>");
        imgWin.document.close();
} 
//  --> 
</script> 


<?
// 현재페이지의 범위내에 출력할 결과레코드세트
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,fid,name,email,homepage,subject,comment,signdate,ref,thread,
              m_filetype,m_imgdsp,m_html,userfile,filesize,m_ip,m_nlbr,m_caption,videoclip
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate' ORDER BY $b_array_now";
} else {
   $query = "SELECT uid,fid,name,email,homepage,subject,comment,signdate,ref,thread,
              m_filetype,m_imgdsp,m_html,userfile,filesize,m_ip,m_nlbr,m_caption,videoclip
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate' AND $keyfield LIKE '%$key%' ORDER BY $b_array_now";
}
$result= mysql_query($query,$dbconn);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}

// 게시물의 가상번호(게시물의 개수에 따른 일련번호)
$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $my_uid = mysql_result($result,$i,0);
   $my_fid = mysql_result($result,$i,1);
   $my_name = mysql_result($result,$i,2); 
   $my_email = mysql_result($result,$i,3);
   $my_homepage = mysql_result($result,$i,4);
   $my_subject = mysql_result($result,$i,5);
   $my_comment = mysql_result($result,$i,6);
   $my_signdate = mysql_result($result,$i,7);
   $my_ref = mysql_result($result,$i,8);
   $my_thread = mysql_result($result,$i,9);
   $my_filetype = mysql_result($result,$i,10);
   $my_imgdsp = mysql_result($result,$i,11);
   $my_html = mysql_result($result,$i,12);
   $my_userfile = mysql_result($result,$i,13);
   $my_filesize = (int)(mysql_result($result,$i,14));
   $my_ip = mysql_result($result,$i,15);
   $my_nl2br = mysql_result($result,$i,16);
   $my_caption = mysql_result($result,$i,17);
   $my_videoclip = mysql_result($result,$i,18);
   
   if($my_videoclip == "" AND !$mode) {
    $mode = "small";
   }

   // addslashes() 함수로 escape된 제목의 문자열을 원상복귀
   $my_subject = stripslashes($my_subject);
   $my_comment = stripslashes($my_comment);
   $my_caption = stripslashes($my_caption);

   $my_subject = htmlspecialchars($my_subject);
   $my_caption = htmlspecialchars($my_caption);

   if(!strcmp($keyfield,"subject") && $key) {
     $my_subject = eregi_replace("($key)", "<font color=red>\\1</font>", $my_subject);
   }
   if(!strcmp($keyfield,"comment") && $key) { 
     $my_comment = eregi_replace("($key)","<font color=red>\\1</font>",$my_comment);
   }

   // HTML TAG OR TEXT
   if($my_html == "0") {
     $my_comment = htmlspecialchars($my_comment);
   }
   if($my_nl2br == "1") {
    $my_comment = nl2br($my_comment);
   }

   
   $full_filename = explode(".", "$my_userfile");
   $extension = $full_filename[sizeof($full_filename)-1];


  if($gate == "host") {
    $savedir = "$home/user_file";
  } else {
    $savedir = "$home/erp/$gate/user_file";
  }


  echo ("$my_comment<br>");

   $article_num--;
}
?>





