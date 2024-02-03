<?
// 정렬
if($b_array == "RAND") {
  $b_array_now = "rand()";
} else if($b_array == "ASC") {
  $b_array_now = "fid ASC, thread ASC";
} else {
  $b_array_now = "fid DESC, thread ASC";
}


// Notice -----------------------------------------------------------------------------------

$query_All = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice > '0' AND gate = '$gate'";
$result_All = mysql_query($query_All,$dbconn);
if (!$result_All) {
   error("QUERY_ERROR");
   exit;
}
$all_record_N = mysql_result($result_All,0,0);

// -------------------------------------------------------------------------------------------

$time_limit_N = 60*60*24*$notify_new_article; 


$queryAll = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND gate = '$gate'";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate'";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate' AND $keyfield LIKE '%$key%'";  
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


// COLSPAN
if($b_option == "0") {
   $td_colspan = "7";
} else {
   $td_colspan = "6";
}


// 회원 등급 추출
$queryFr = "SELECT userlevel FROM member_main WHERE id = '$member_id' AND gate = '$gate'";
$resultFr = mysql_query($queryFr,$dbconn);
$member_level = @mysql_result($resultFr,0,0);


if($b_permit == '0' OR ($login_id AND $login_id != "" AND $login_level > "2")) {

  $act_read = "on";
  $act_post = "on";

} else {

  if($member_id AND $member_id != "") {
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


			

			<?
			echo ("
			<form name='search' method='post' action='$link_list'>
			<select name='keyfield' style='width: 120px'>
            <option value='subject'>$bdtxt_02</option>
			<option value='name'>$bdtxt_07</option>
			<option value='comment'>$bdtxt_08</option>
			</select>
			
			<input type='text' name='key'>
			
			<span class='pull-right'>");
			
				if(!eregi("[^[:space:]]+",$key)) {
					echo("<b>$total_record</b> Articles");   
				} else {
					echo("Searched : <b>$total_record</b> Articles (Total <b>$all_record</b>)");
				} 

				echo ("	&nbsp;&nbsp;( <font color='navy'>$page</font> / $total_page )
			
			</span>");
			
			
			
			if($mode == "view" AND $now_number) { // Open Article
			

				$query_v = "SELECT subject,signdate,ref,m_nlbr,comment FROM wpage_content WHERE uid = $now_number LIMIT 1";
				$result_v = mysql_query($query_v,$dbconn);
					if(!$result_v) { error("QUERY_ERROR"); exit; }
				$row_v = mysql_fetch_row($result_v);

				$myv_subject = $row_v[0];
				if($lang == "ko") {
					$myv_signdate = date("Y/m/d, H:i:s",$row_v[1]);
					$myv_signdate2 = date("Y/m/d",$row_v[1]);
				} else {
					$myv_signdate = date("d-M-Y, H:i:s",$row_v[1]);
					$myv_signdate2 = date("d M Y",$row_v[1]);
				}
				$myv_ref = $row_v[2];
				$myv_nlbr = $row_v[3];
				$myv_comment = $row_v[4];
				
				$myv_subject = stripslashes($myv_subject);
				$myv_comment = stripslashes($myv_comment);
				
				$myv_subject2 = nl2br($myv_subject);
				if($myv_nlbr == "1") {
					$myv_comment = nl2br($myv_comment);
				}
				
				// Page View
				$myv_ref = $myv_ref + 1;	
				$result_ref = mysql_query("UPDATE wpage_content SET ref = $myv_ref WHERE uid = $now_number",$dbconn);
				if(!$result_ref) { error("QUERY_ERROR"); exit; }

			
				echo ("
				<table class='display table'>
				<tbody>
				<tr>
					<td>
						<h3>$myv_subject2</h3>
						<p>$myv_comment</p>
					</td>
				</tr>
				</tbody>
				</table>
				");

			}
			?>



<div class="table-responsive">
<table class='display table table-bordered'>
</form>

<thead>
<?
echo ("
<tr>
   <th>$bdtxt_01</th>
");

// Table Title ________________________________________________ //
if($b_option == "0") {
   echo ("
   <th>$bdtxt_02</th>
   ");
} else { // Title if File Attached
   echo ("
   <th>$bdtxt_02</th>
   <th></th>
   ");
}
echo ("
   <th>$bdtxt_03</t>
   <th>$bdtxt_04</t>
   <th>$bdtxt_05</t>
</tr>
</thead>


<tbody>
");





$time_limit_N = 60*60*24*$notify_new_article; 

$query_N = "SELECT uid,fid,name,email,subject,comment,signdate,ref,thread,m_filetype,videoclip
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice > '0' AND gate = '$gate' 
    ORDER BY $b_array_now";
$result_N= mysql_query($query_N,$dbconn);
if (!$result_N) {
   error("QUERY_ERROR");
   exit;
}


for($n = 0; $n < $all_record_N; $n++) {
   $N_uid = mysql_result($result_N,$n,0);
   $N_fid = mysql_result($result_N,$n,1);
   $N_name = mysql_result($result_N,$n,2); 
   $N_email = mysql_result($result_N,$n,3);
   $N_subject = mysql_result($result_N,$n,4);
   $N_comment = mysql_result($result_N,$n,5);
   $N_signdate = mysql_result($result_N,$n,6);
   $N_ref = mysql_result($result_N,$n,7);
   $N_thread = mysql_result($result_N,$n,8);
   $N_filetype = mysql_result($result_N,$n,9);
   $N_videoclip = mysql_result($result_N,$n,10);

   
   // addslashes() 함수로 escape된 제목의 문자열을 원상복귀
   $N_subject = stripslashes($N_subject);
  ?>
  
  <tr>


  <?
   echo("   <td><i class='icon-bullhorn'></i></td>");
   echo("   <td>");


   // 현재 펼쳐진 글을 표시 *
	   if ($now_number == $N_uid) {
	      echo("<font color=red><i class='icon-caret-up'></i></font>");
	   }
   
   // 원칙상 제목에는 HTML 태그를 불허
   $N_subject = htmlspecialchars($N_subject);

   // 제목을 검색시에는 검색어를 붉은색으로 출력
   if(!strcmp($keyfield,"subject") && $key) {
      $N_subject = eregi_replace("($key)", "<font color=red>\\1</font>",$N_subject);
   }


   // 게시물의 제목을 출력
   if($act_read == "on") {
      echo("<a class='myA' href=\"$link_list&mode=view&page=$page&now_number=$N_uid&keyfield=$keyfield&key=$encoded_key\" onMouseOver=\"status='Read';return true;\" onMouseOut=\"status=''\">$N_subject</a>\n");
   } else {
      echo("$N_subject\n");
   }
   
   
   // 게시물의 작성시간으로부터 게시물이 최근에 작성된 글인지를 판별, 그에 따라 색깔이 다른 아이콘을 출력
   $date_diff_N = time() -  $N_signdate;

      if ($date_diff_N < $time_limit_N) {
         echo("<i class='icon-time></i>");
      }


   // 파일의 포함될 때 파일을 나타내는 아이콘 출력
   if($b_option == "0") {
	    echo ("</td>\n");
   } else {
   
   if($b_option == "6") {
    if($N_videoclip != "") { 
      $N_filetype2 = "flv";
    } else {
      $N_filetype2 = "non";
    }
   } else {
	  if($N_filetype == "zip" OR $N_filetype == "ZIP") {
		  $N_filetype2 = "zip";
	  } else if($N_filetype == "exe" OR $N_filetype == "EXE") {
		  $N_filetype2 = "exe";
	  } else if($N_filetype == "doc" OR $N_filetype == "DOC") {
		  $N_filetype2 = "doc";
	  } else if($N_filetype == "hwp" OR $N_filetype == "HWP") {
		  $N_filetype2 = "hwp";
	  } else if($N_filetype == "ppt" OR $N_filetype == "PPT") {
		  $N_filetype2 = "ppt";
	  } else if($N_filetype == "xls" OR $N_filetype == "XLS") {
		  $N_filetype2 = "xls";
	  } else if($N_filetype == "pdf" OR $N_filetype == "PDF") {
		  $N_filetype2 = "pdf";
	  } else if($N_filetype == "swf" OR $N_filetype == "SWF") {
		  $N_filetype2 = "swf";
	  } else if($N_filetype == "gif" OR $N_filetype == "GIF") {
		  $N_filetype2 = "gif";
	  } else if($N_filetype == "jpg" OR $N_filetype == "JPG") {
		  $N_filetype2 = "jpg";
	  } else if($N_filetype == "wma" OR $N_filetype == "WMA") {
		  $N_filetype2 = "wma";
	  } else if($N_filetype == "wmv" OR $N_filetype == "WMV") {
		  $N_filetype2 = "wmv";
	  } else if($N_filetype == "non") { // 파일이 없을 때
		  $N_filetype2 = "non";
	  } else { // 위에 열거된 파일이 아닐 때
		  $N_filetype2 = "etc";
	  }
	}

	echo ("</td>\n");
	echo ("<td><i class='icon-paper-clip'></i></td>\n");	
  
   }

   // ------- 제목 끝


   // 글쓴이의 이메일주소를 출력
   if (!$N_email) {
      echo("<td>$N_name</td>");
   } else {
      echo("<td><a href=\"mailto:$N_email\">$N_name</a></td>");
   }


   
   // 게시물의 작성시간과 조회수를 출력
   if($lang == "ko") {
    $N_signdates = date("m/d",$N_signdate);
   } else {
    $N_signdates = date("d-M",$N_signdate);
   }
   echo("<td>$N_signdates</td>");
   echo("<td><div align=right>$N_ref</div></td>");
   echo("</tr>");      

}




// -----------------------------------------------------------------------------------------------


$time_limit = 60*60*24*$notify_new_article; 

// 현재페이지의 범위내에 출력할 결과레코드세트
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,fid,name,email,subject,comment,signdate,ref,thread,m_filetype,nondis,id,videoclip
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate' ORDER BY $b_array_now";
} else {
   $query = "SELECT uid,fid,name,email,subject,comment,signdate,ref,thread,m_filetype,nondis,id,videoclip
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate' AND $keyfield LIKE '%$key%' 
    ORDER BY $b_array_now";
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
   $my_subject = mysql_result($result,$i,4);
   $my_comment = mysql_result($result,$i,5);
   $my_signdate = mysql_result($result,$i,6);
   $my_ref = mysql_result($result,$i,7);
   $my_thread = mysql_result($result,$i,8);
   $my_filetype = mysql_result($result,$i,9);
   $my_nondis = mysql_result($result,$i,10);
   $my_user_id = mysql_result($result,$i,11);
   $my_videoclip = mysql_result($result,$i,12);

   
   // addslashes() 함수로 escape된 제목의 문자열을 원상복귀
   $my_subject = stripslashes($my_subject);

   echo ("<tr>");
   echo("   <td>$article_num</td>");
   echo("   <td>");



   // 응답의 단계에 따라 출력할 제목의 문자열을 안쪽으로 indent
   $reply_indent = 2;
   $spacer = strlen($my_thread)-1;
   
   // 원글에 대한 답변글이 $reply_indent 값 이상이 되면 답변글의 출력indent를 고정
   if($spacer > $reply_indent) $spacer = $reply_indent;
    for($j = 0; $j < $spacer; $j++) {
      echo("&nbsp;");
   }

   // 현재 펼쳐진 글을 표시 *
	   if ($now_number == $my_uid) {
	      echo("<font color=red><i class='icon-caret-up'></i></font> ");
	   }
   
   // 답변글에 아이콘 *
     if($spacer > '0') {
	    echo ("<i class='icon-comment-alt'></i>");
     }

   
   if($spacer > '0') { // 답변글의 경우 원글의 id 추출
      $query_Re = "SELECT uid,id FROM wpage_content WHERE fid = '$my_fid' AND uid != '$my_uid' AND gate = '$gate' ORDER BY signdate ASC";
      $result_Re = mysql_query($query_Re);
      $my_reply_uid = @mysql_result($result_Re,0,0);
      $my_reply_id = @mysql_result($result_Re,0,1);
      
      $my_read_id = $my_reply_id;
   } else {
      $my_read_id = $my_user_id;
   }
   
   // 원칙상 제목에는 HTML 태그를 불허
   $my_subject = htmlspecialchars($my_subject);

   // 제목을 검색시에는 검색어를 붉은색으로 출력
   if(!strcmp($keyfield,"subject") && $key) {
      $my_subject = eregi_replace("($key)", "<font color=red>\\1</font>", $my_subject);
   }

   // 본문의 총 라인수를 계산
   $line = explode("\n",$my_comment);
   $line_of_comment = sizeof($line);

   // 게시물의 제목을 출력
   if($my_nondis == "1") {
      if($my_read_id == $member_id OR $login_level > "2") {
        echo("<a class='myA' href=\"$link_list&mode=view&b_permit&b_permit&page=$page&now_number=$my_uid&keyfield=$keyfield&key=$encoded_key\" onMouseOver=\"status='Read';return true;\" onMouseOut=\"status=''\"><font color=red>$my_subject</font></a>\n");
      } else {
        echo("<font color=red>$bdtxt_94</font>\n");
      }
   } else {
      if($act_read == "on") {
        echo("<a class='myA' href=\"$link_list&mode=view&b_permit=$b_permit&page=$page&now_number=$my_uid&keyfield=$keyfield&key=$encoded_key\" onMouseOver=\"status='Read';return true;\" onMouseOut=\"status=''\">$my_subject</a>\n");
      } else {
        echo("$my_subject\n");
      }
   }
   
   
   // 게시물의 작성시간으로부터 게시물이 최근에 작성된 글인지를 판별, 그에 따라 색깔이 다른 아이콘을 출력
   $date_diff = time() -  $my_signdate;

      if ($date_diff < $time_limit) {
         echo("<i class='icon-time'></i>");
      }


   // 파일의 포함될 때 파일을 나타내는 아이콘 출력
   if($b_option == "0") {
	    echo ("</td>\n");
   } else {
   
   if($b_option == "6") {
    if($my_videoclip != "") { 
      $my_filetype2 = "flv";
    } else {
      $my_filetype2 = "non";
    }
   } else {
	  if($my_filetype == "zip" OR $my_filetype == "ZIP") {
		  $my_filetype2 = "zip";
	  } else if($my_filetype == "exe" OR $my_filetype == "EXE") {
		  $my_filetype2 = "exe";
	  } else if($my_filetype == "doc" OR $my_filetype == "DOC") {
		  $my_filetype2 = "doc";
	  } else if($my_filetype == "hwp" OR $my_filetype == "HWP") {
		  $my_filetype2 = "hwp";
	  } else if($my_filetype == "ppt" OR $my_filetype == "PPT") {
		  $my_filetype2 = "ppt";
	  } else if($my_filetype == "xls" OR $my_filetype == "XLS") {
		  $my_filetype2 = "xls";
	  } else if($my_filetype == "pdf" OR $my_filetype == "PDF") {
		  $my_filetype2 = "pdf";
	  } else if($my_filetype == "swf" OR $my_filetype == "SWF") {
		  $my_filetype2 = "swf";
	  } else if($my_filetype == "gif" OR $my_filetype == "GIF") {
		  $my_filetype2 = "gif";
	  } else if($my_filetype == "jpg" OR $my_filetype == "JPG") {
		  $my_filetype2 = "jpg";
	  } else if($my_filetype == "wma" OR $my_filetype == "WMA") {
		  $my_filetype2 = "wma";
	  } else if($my_filetype == "wmv" OR $my_filetype == "WMV") {
		  $my_filetype2 = "wmv";
	  } else if($my_filetype == "non") { // 파일이 없을 때
		  $my_filetype2 = "non";
	  } else { // 위에 열거된 파일이 아닐 때
		  $my_filetype2 = "etc";
	  }
	}

	echo ("</td>\n");
	echo ("<td><i class='icon-paper_clip'></i></td>\n");	
  
   }

   // ------- 제목 끝


   // 글쓴이의 이메일주소를 출력
   if (!$my_email) {
      echo("<td>$my_name</td>");
   } else {
      echo("<td><a href=\"mailto:$my_email\">$my_name</a></td>");
   }


   
   // 게시물의 작성시간과 조회수를 출력
   if($lang == "ko") {
    $my_signdates = date("m/d",$my_signdate);
   } else {
    $my_signdates = date("d-M",$my_signdate);
   }
   echo("<td>$my_signdates</td>");
   echo("<td><div align=right>$my_ref</div></td>");
   echo("</tr>");      

   $article_num--;
}
?>

</tbody>
</table>
</div>


				<ul class="pagination pagination-sm">
				<?
				echo ("<li><a href='$link_list'><i class='icon-reorder'></i></a></li>");
				
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">Next $page_per_block</a></li>");
				}
				?>
			</ul>
