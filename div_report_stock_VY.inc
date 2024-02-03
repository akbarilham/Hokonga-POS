<table width=100% cellspacing=0 cellpadding=0 style="BORDER-TOP: #888888 1px solid; BORDER-LEFT: #888888 1px solid; BORDER-BOTTOM: #888888 1px solid; BORDER-RIGHT: #888888 1px solid">
<tr>
  <td height=22 align=center>Category</td>
  <td align=center><b><?=$p_year?></b></td>
  <?
  for($m = $m_s; $m <= $m_f; $m++) {

  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  
  // 월 표시
  if($mm == "01") { $mm_txt = "JAN"; }
  else if($mm == "02") { $mm_txt = "FEB"; }
  else if($mm == "03") { $mm_txt = "MAR"; }
  else if($mm == "04") { $mm_txt = "APR"; }
  else if($mm == "05") { $mm_txt = "MAY"; }
  else if($mm == "06") { $mm_txt = "JUN"; }
  else if($mm == "07") { $mm_txt = "JUL"; }
  else if($mm == "08") { $mm_txt = "AUG"; }
  else if($mm == "09") { $mm_txt = "SEP"; }
  else if($mm == "10") { $mm_txt = "OCT"; }
  else if($mm == "11") { $mm_txt = "NOV"; }
  else if($mm == "12") { $mm_txt = "DEC"; }
  
  echo ("<td align=center>$mm_txt</td>");
  
  }
  ?>
</tr>

<?
$p_date_set2 = $p_date_set."235959";
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

// 합계 구하기
$query_sumt = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE store_date LIKE '$p_year%'";
$result_sumt = mysql_query($query_sumt);
$total_sumt = @mysql_result($result_sumt,0,0);

echo ("
<tr bgcolor=#EFEFEF>
  <td height=22 align=center><b>TOTAL</b></td>
  <td align=center><b>$total_sumt</b></td>");
  
  // 매월(반복)
  for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
  
  
    // Stock (today)
    $query_dirMID_Ad4p = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE store_date LIKE '$this_month_set%'";
    $result_dirMID_Ad4p = mysql_query($query_dirMID_Ad4p);
    $dirAd_sum_nowp = @mysql_result($result_dirMID_Ad4p,0,0);
    
  echo ("<td align=right>$dirAd_sum_nowp</td>");
  
  }
  
echo ("</tr>");

$query_dirMIDc = "SELECT count(mcode) FROM shop_catgmid WHERE lang = '$lang'";
$result_dirMIDc = mysql_query($query_dirMIDc);
$cnt_dirMIDc = @mysql_result($result_dirMIDc,0,0);
  
$query_dirMID = "SELECT lcode,mcode,mname FROM shop_catgmid WHERE lang = '$lang' ORDER BY mcode ASC";
  $result_dirMID = mysql_query($query_dirMID);
	
  for($dr = 0; $dr < $cnt_dirMIDc; $dr++) {
    $dirM_lcode = mysql_result($result_dirMID,$dr,0);
    $dirM_mcode = mysql_result($result_dirMID,$dr,1);
    $dirM_mname = mysql_result($result_dirMID,$dr,2);
    
    $query_dirMID_t = "SELECT sum(qty_now) FROM shop_product_list_shop 
                      WHERE catg_code = '$dirM_mcode' AND store_date LIKE '$p_year%'";
    $result_dirMID_t = mysql_query($query_dirMID_t);
    $dirAd_sum_t = @mysql_result($result_dirMID_t,0,0);
  

echo ("
<tr>
  <td height=22>&nbsp; [$dirM_mcode] $dirM_mname</td>
  <td align=center><b>$dirAd_sum_t</b></td>");
  
    // 매월(반복)
    for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
  
  
    // Stock (today)
    $query_dirMID_Ad41 = "SELECT sum(qty_now) FROM shop_product_list_shop 
                        WHERE catg_code = '$dirM_mcode' AND store_date LIKE '$this_month_set%'";
    $result_dirMID_Ad41 = mysql_query($query_dirMID_Ad41);
    $dirAd_sum_now1 = @mysql_result($result_dirMID_Ad41,0,0);
    
  echo ("<td align=right>$dirAd_sum_now1</td>");
  
  }

echo ("</tr>");
}
?>


</table>


<br>

<?
// BRANCHes
$query_x1c = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
$result_x1c = mysql_query($query_x1c);
$total_x1c = @mysql_result($result_x1c,0,0);
  
  
$query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
$result_x1 = mysql_query($query_x1);

for($x1 = 0; $x1 < $total_x1c; $x1++) {
  $x1_branch_code = mysql_result($result_x1,$x1,0);
  $x1_branch_name = mysql_result($result_x1,$x1,1);
?>

<br>
<table width=100% cellspacing=0 cellpadding=0 style="BORDER-TOP: #888888 1px solid; BORDER-LEFT: #888888 1px solid; BORDER-BOTTOM: #888888 1px solid; BORDER-RIGHT: #888888 1px solid">
<tr>
  <td height=22>&nbsp; <b><?=$x1_branch_name?></b></td>
</tr>
<tr>
  <td height=22 align=center>Category</td>
  <td align=center><b><?=$p_year?></b></td>
  <?
  for($m = $m_s; $m <= $m_f; $m++) {

  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  
  // 월 표시
  if($mm == "01") { $mm_txt = "JAN"; }
  else if($mm == "02") { $mm_txt = "FEB"; }
  else if($mm == "03") { $mm_txt = "MAR"; }
  else if($mm == "04") { $mm_txt = "APR"; }
  else if($mm == "05") { $mm_txt = "MAY"; }
  else if($mm == "06") { $mm_txt = "JUN"; }
  else if($mm == "07") { $mm_txt = "JUL"; }
  else if($mm == "08") { $mm_txt = "AUG"; }
  else if($mm == "09") { $mm_txt = "SEP"; }
  else if($mm == "10") { $mm_txt = "OCT"; }
  else if($mm == "11") { $mm_txt = "NOV"; }
  else if($mm == "12") { $mm_txt = "DEC"; }
  
  echo ("<td align=center>$mm_txt</td>");
  
  }
  ?>
</tr>

<?
$p_date_set2 = $p_date_set."235959";
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

// 합계 구하기
$query_sumt = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE store_date LIKE '$p_year%'";
$result_sumt = mysql_query($query_sumt);
$total_sumt = @mysql_result($result_sumt,0,0);

echo ("
<tr bgcolor=#EFEFEF>
  <td height=22 align=center><b>TOTAL</b></td>
  <td align=center><b>$total_sumt</b></td>");
  
  // 매월(반복)
  for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
  
  
    // Stock (today)
    $query_xdirMID_Ad4p = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE branch_code = '$x1_branch_code' AND store_date LIKE '$this_month_set%'";
    $result_xdirMID_Ad4p = mysql_query($query_xdirMID_Ad4p);
    $xdirAd_sum_nowp = @mysql_result($result_xdirMID_Ad4p,0,0);
    
  echo ("<td align=right>$xdirAd_sum_nowp</td>");
  
  }
  
echo ("</tr>");

$query_xdirMIDc = "SELECT count(mcode) FROM shop_catgmid WHERE lang = '$lang'";
$result_xdirMIDc = mysql_query($query_xdirMIDc);
$cnt_xdirMIDc = @mysql_result($result_xdirMIDc,0,0);
  
$query_xdirMID = "SELECT lcode,mcode,mname FROM shop_catgmid WHERE lang = '$lang' ORDER BY mcode ASC";
  $result_xdirMID = mysql_query($query_xdirMID);
	
  for($xdr = 0; $xdr < $cnt_xdirMIDc; $xdr++) {
    $xdirM_lcode = mysql_result($result_xdirMID,$xdr,0);
    $xdirM_mcode = mysql_result($result_xdirMID,$xdr,1);
    $xdirM_mname = mysql_result($result_xdirMID,$xdr,2);
    
    $query_xdirMID_t = "SELECT sum(qty_now) FROM shop_product_list_shop 
                      WHERE branch_code = '$x1_branch_code' AND catg_code = '$xdirM_mcode' AND store_date LIKE '$p_year%'";
    $result_xdirMID_t = mysql_query($query_xdirMID_t);
    $xdirAd_sum_t = @mysql_result($result_xdirMID_t,0,0);
  

echo ("
<tr>
  <td height=22>&nbsp; [$xdirM_mcode] $xdirM_mname</td>
  <td align=center><b>$dirAd_sum_t</b></td>");
  
    // 매월(반복)
    for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
  
  
    // Stock (today)
    $query_xdirMID_Ad41 = "SELECT sum(qty_now) FROM shop_product_list_shop 
                        WHERE branch_code = '$x1_branch_code' AND catg_code = '$xdirM_mcode' AND store_date LIKE '$this_month_set%'";
    $result_xdirMID_Ad41 = mysql_query($query_xdirMID_Ad41);
    $xdirAd_sum_now1 = @mysql_result($result_xdirMID_Ad41,0,0);
    
  echo ("<td align=right>$xdirAd_sum_now1</td>");
  
  }

echo ("</tr>");
}
?>


</table>
<? } ?>

