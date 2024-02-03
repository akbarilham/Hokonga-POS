<?
// 월 표시
if($p_month == "01") { $p_month_txt = "JAN"; }
else if($p_month == "02") { $p_month_txt = "FEB"; }
else if($p_month == "03") { $p_month_txt = "MAR"; }
else if($p_month == "04") { $p_month_txt = "APR"; }
else if($p_month == "05") { $p_month_txt = "MAY"; }
else if($p_month == "06") { $p_month_txt = "JUN"; }
else if($p_month == "07") { $p_month_txt = "JUL"; }
else if($p_month == "08") { $p_month_txt = "AUG"; }
else if($p_month == "09") { $p_month_txt = "SEP"; }
else if($p_month == "10") { $p_month_txt = "OCT"; }
else if($p_month == "11") { $p_month_txt = "NOV"; }
else if($p_month == "12") { $p_month_txt = "DEC"; }

// 그래프 단위
$main_half = "200";
if(!$max_stock) {
  $max_stock = "1000";
}

// 합계 구하기
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

$query_sumt = "SELECT sum(qty_now),sum(qty_org),sum(qty_sell) FROM shop_product_list_shop WHERE store_date <= '$p_month_set2'";
$result_sumt = mysql_query($query_sumt);
$total_sumt = @mysql_result($result_sumt,0,0);
$total_sumt_org = @mysql_result($result_sumt,0,1);
$total_sumt_sell = @mysql_result($result_sumt,0,2);


if($grpBrc) {
echo ("
<table width=100% cellspacing=0 cellpadding=0 style='$style_area'>
<tr>
  <td height=26>&nbsp; <b>$rp_title2_full</b></td>
</tr>
</table>
<br>");
}
?>


<script language="javascript">
<? include "./config/javascript/BalloonHint.js"; ?>
</script>

<div id="balloonHint" style="display:none">
<table width=60 border="0" cellspacing="0" cellpadding=0 bgcolor="#FFFFFF" style="border:1px solid #6699CC">
<tr><td height=24 align=right><font size=2>{{hint}}</font>&nbsp;</td></tr>
</table>
</div>

<script language="javascript">balloonHint("balloonHint")</script>

<table width=100% cellspacing=0 cellpadding=0 style="BORDER-TOP: #888888 1px solid; BORDER-LEFT: #888888 1px solid; BORDER-BOTTOM: #888888 1px solid; BORDER-RIGHT: #888888 1px solid">
<tr>
  <td width=200 height=200 align=center style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td width=80 align=center style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <?
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $pt_date_set = "$p_year"."$p_month"."$dd";
  $pt_date_set1 = $pt_date_set."000000";
  $pt_date_set2 = $pt_date_set."235959";
  
  
    // Stock (today)
    $query_dirMID_Ad4p = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE store_date <= '$pt_date_set2'";
    $result_dirMID_Ad4p = mysql_query($query_dirMID_Ad4p);
    $dirAd_sum_nowp = @mysql_result($result_dirMID_Ad4p,0,0);

    
    // 최대값에 대한 백분율
    $sd1_pcnt = ( $dirAd_sum_nowp / $max_stock ) * 100;
  
    $ddp1 = sprintf("%02d", $sd1_pcnt);
    $ddp2 = 100 - $ddp1;
  
    $ddp1m = ($main_half / 100) * $ddp1;
    
    echo ("
    <td width=2% height=$main_half align=center valign=bottom style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% height=$main_half cellspacing=0 cellpadding=0 border=0>
      <tr><td width=100% height=$ddp2% align=center valign=bottom></td></tr>
      <tr>
        <td width=100% height=$ddp1% align=center valign=bottom>");
          if($ddp1m > 1) {
            echo ("<img src='$home/image/icon/graph_01.gif' width=50% height=$ddp1m border=0 valign=bottom hint='$dirAd_sum_nowp'>");
          } echo ("
        </td>
      </tr>
      </table>
    </td>");
  
  }
  
  echo ("
  <td valign=top align=right>
    <br><a href='$link_report&mode=stock_TM&max_stock=50000'>50,000</a>&nbsp;
    <br><a href='$link_report&mode=stock_TM&max_stock=10000'>10,000</a>&nbsp;
    <br><a href='$link_report&mode=stock_TM&max_stock=5000'>5,000</a>&nbsp;
    <br><a href='$link_report&mode=stock_TM&max_stock=1000'>1,000</a>&nbsp;
    <br>
  
  
  </td>");
  ?>
</tr>

<tr>
  <td height=22 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'>Category</td>
  <td align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><b><?=$p_month_txt?>, <?=$p_year?></b></td>
  <?
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";
  
  echo ("<td align=center style='BORDER-RIGHT: #CCCCCC 1px solid'>$d</td>");
  
  }
  
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");
  ?>
</tr>


<?
echo ("
<tr bgcolor=#EFEFEF>
  <td height=22 align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>TOTAL</b></td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$total_sumt</b></td>");
  
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $pt_date_set = "$p_year"."$p_month"."$dd";
  $pt_date_set1 = $pt_date_set."000000";
  $pt_date_set2 = $pt_date_set."235959";
  
  
    // Stock (today)
    $query_dirMID_Ad4p = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE store_date <= '$pt_date_set2'";
    $result_dirMID_Ad4p = mysql_query($query_dirMID_Ad4p);
    $dirAd_sum_nowp = @mysql_result($result_dirMID_Ad4p,0,0);
    
  echo ("<td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$dirAd_sum_nowp</td>");
  
  }
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");
  
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
                      WHERE catg_code = '$dirM_mcode' AND store_date <= '$p_month_set2'";
    $result_dirMID_t = mysql_query($query_dirMID_t);
    $dirAd_sum_t = @mysql_result($result_dirMID_t,0,0);
  

echo ("
<tr>
  <td height=22 style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp; [$dirM_mcode] $dirM_mname</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$dirAd_sum_t</b></td>");
  
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";
  $this_date_set1 = $this_date_set."000000";
  $this_date_set2 = $this_date_set."235959";
  
  
    // Stock (today)
    $query_dirMID_Ad41 = "SELECT sum(qty_now) FROM shop_product_list_shop 
                          WHERE catg_code = '$dirM_mcode' AND store_date <= '$this_date_set2'";
    $result_dirMID_Ad41 = mysql_query($query_dirMID_Ad41);
    $dirAd_sum_now1 = @mysql_result($result_dirMID_Ad41,0,0);
    
  echo ("<td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$dirAd_sum_now1</td>");
  
  }
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");

echo ("</tr>");
}
?>


</table>


<br>

<?
if(!$grpBrc) {
// BRANCHes
$this_cols = $totaldays2 + 2;

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
  <td colspan=<?=$this_cols?> height=22 style='BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp; <b><?=$x1_branch_name?></b></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td width=200 height=22 align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Category</td>
  <td width=80 align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b><?=$p_month_txt?>, <?=$p_year?></b></td>
  <?
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";
  
  echo ("<td width=2% align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$d</td>");
  
  }
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");
  ?>
</tr>

<?
// 합계 구하기
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

$query_sumt = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE branch_code = '$x1_branch_code' AND store_date <= '$p_month_set2'";
$result_sumt = mysql_query($query_sumt);
$total_sumt = @mysql_result($result_sumt,0,0);

echo ("
<tr bgcolor=#EFEFEF>
  <td height=22 align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>TOTAL</b></td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$total_sumt</b></td>");
  
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $pt_date_set = "$p_year"."$p_month"."$dd";
  $pt_date_set1 = $pt_date_set."000000";
  $pt_date_set2 = $pt_date_set."235959";
  
  
    // Stock (today)
    $query_dirMID_Ad4p = "SELECT sum(qty_now) FROM shop_product_list_shop WHERE branch_code = '$x1_branch_code' AND store_date <= '$pt_date_set2'";
    $result_dirMID_Ad4p = mysql_query($query_dirMID_Ad4p);
    $dirAd_sum_nowp = @mysql_result($result_dirMID_Ad4p,0,0);
    
  echo ("<td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$dirAd_sum_nowp</td>");
  
  }
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");
  
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
                      WHERE branch_code = '$x1_branch_code' AND catg_code = '$dirM_mcode' AND store_date <= '$p_month_set2'";
    $result_dirMID_t = mysql_query($query_dirMID_t);
    $dirAd_sum_t = @mysql_result($result_dirMID_t,0,0);
  

echo ("
<tr>
  <td height=22 style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp; [$dirM_mcode] $dirM_mname</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$dirAd_sum_t</b></td>");
  
  for($d = 1; $d <= $totaldays2; $d++) {

  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";
  $this_date_set1 = $this_date_set."000000";
  $this_date_set2 = $this_date_set."235959";
  
  
    // Stock (today)
    $query_dirMID_Ad41 = "SELECT sum(qty_now) FROM shop_product_list_shop 
                          WHERE branch_code = '$x1_branch_code' AND catg_code = '$dirM_mcode' AND store_date <= '$this_date_set2'";
    $result_dirMID_Ad41 = mysql_query($query_dirMID_Ad41);
    $dirAd_sum_now1 = @mysql_result($result_dirMID_Ad41,0,0);
    
  echo ("<td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$dirAd_sum_now1</td>");
  
  }
  echo ("<td style='BORDER-TOP: #CCCCCC 1px solid'>&nbsp;</td>");

echo ("</tr>");
}
?>


</table>
<? } } ?>
