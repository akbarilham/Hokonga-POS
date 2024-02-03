<h3>Search</h3>
						
	<br />
						
<ol class="faq-list">

<?
// Á¤·Ä
if($b_array == "RAND") {
  $b_array_now = "rand()";
} else if($b_array == "ASC") {
  $b_array_now = "fid ASC, thread ASC";
} else {
  $b_array_now = "fid DESC, thread ASC";
}


$query_c = "SELECT count(uid) FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate'";
$result_c = mysql_query($query_c,$dbconn);
if (!$result_c) {
   error("QUERY_ERROR");
   exit;
}
$total_record = @mysql_result($result_c,0,0);


$query = "SELECT uid,fid,name,email,subject,comment,signdate,ref,thread,m_filetype,m_nlbr 
    FROM wpage_content WHERE room = '$room' AND lang = '$lang' AND notice = '0' AND gate = '$gate' ORDER BY $b_array_now";
$result= mysql_query($query,$dbconn);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}

for($i = 0; $i < $total_record; $i++) {
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
   $my_nlbr = mysql_result($result,$i,10);

   
   $my_subject = stripslashes($my_subject);
   $my_comment = stripslashes($my_comment);
				
   $my_subject2 = nl2br($my_subject);
   if($my_nlbr == "1") {
		$my_comment = nl2br($my_comment);
   }

   
	echo ("
			<li>
				<h4>$my_subject</h4>
				<p>$my_comment</h4>
			</li>
		");
   
   
   
}
?>
</ol>
