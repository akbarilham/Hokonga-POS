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


// 검색 필터
if($grpBrc) {
  if($grpShp) {
    $this_filter_in = "shop_code = '$grpShp' AND branch_code = '$grpBrc' AND flag = 'in'";
  } else {
    $this_filter_in = "branch_code = '$grpBrc' AND flag = 'in'";
  }
} else {
    $this_filter_in = "flag = 'in'";
}


// 해당 분기의 매출액 추출
$p_qt = substr($p_quarter,4,1);

if($p_qt == "1") {
  $p_qtA = "$p_year"."01"."00000000";
  $p_qtB = "$p_year"."03"."99999999";
  $mq_s = "1";
  $mq_f = "3";
} else if($p_qt == "2") {
  $p_qtA = "$p_year"."04"."00000000";
  $p_qtB = "$p_year"."06"."99999999";
  $mq_s = "4";
  $mq_f = "6";
} else if($p_qt == "3") {
  $p_qtA = "$p_year"."07"."00000000";
  $p_qtB = "$p_year"."09"."99999999";
  $mq_s = "7";
  $mq_f = "9";
} else if($p_qt == "4") {
  $p_qtA = "$p_year"."10"."00000000";
  $p_qtB = "$p_year"."12"."99999999";
  $mq_s = "10";
  $mq_f = "12";
}


if($grpShp) {
  $this_filter = "post_date > '$p_qtA' AND post_date < '$p_qtB%'";
  $this_filterA = "post_date < '$p_qtA'";
} else {
  $this_filter = "date > '$p_qtA' AND date < '$p_qtB%'";
  $this_filterA = "date < '$p_qtA'";
}


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



<table width=100% cellspacing=0 cellpadding=0 style="BORDER-TOP: #888888 1px solid; BORDER-LEFT: #888888 1px solid; BORDER-BOTTOM: #888888 1px solid; BORDER-RIGHT: #888888 1px solid">
<tr>
  <td rowspan=2 width=200 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><b><?=$p_qt?>/4-<?=$p_year?></b></td>
  <td height=22 colspan=2 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><?=$txt_invn_stockin_31?></td>
  <td colspan=2 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><?=$txt_invn_stockin_34?></td>
  <td colspan=2 align=center><?=$txt_invn_stockin_35?></td>
</tr>
<tr>
  <td height=22 align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Qty</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Amount</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Qty</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Amount</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Qty</td>
  <td align=center style='BORDER-TOP: #CCCCCC 1px solid'>Amount</td>
</tr>

<?
// 합계 구하기
$query_tsum1 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty 
                  WHERE $this_filter_in AND $this_filter";
$result_tsum1 = mysql_query($query_tsum1);
   
  $tsum1_qty_org = @mysql_result($result_tsum1,0,0);
  $tsum1_price_org = @mysql_result($result_tsum1,0,1);
    $tsum1_price_org_K = number_format($tsum1_price_org);

$query_tsum2 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty 
                  WHERE $this_filter_in AND $this_filter 
                  AND date_expire > 0 AND date_expire < '$p_date_set'";
$result_tsum2 = mysql_query($query_tsum2);
   
  $tsum2_qty_org = @mysql_result($result_tsum2,0,0);
  $tsum2_price_org = @mysql_result($result_tsum2,0,1);
    $tsum2_price_org_K = number_format($tsum2_price_org);

  $tsum3_qty_org = $tsum1_qty_org - $tsum2_qty_org;
  $tsum3_price_org = $tsum1_price_org - $tsum2_price_org;
    $tsum3_price_org_K = number_format($tsum3_price_org);


echo ("
<tr>
  <td height=22 align=center style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>TOTAL</b></td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum1_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum1_price_org_K</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum2_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum2_price_org_K</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum3_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid'><b>$tsum3_price_org_K</b>&nbsp;</td>
</tr>");


// 상품별 합계
$query_dirMIDc = "SELECT count(mcode) FROM shop_catgmid WHERE lang = '$lang'";
$result_dirMIDc = mysql_query($query_dirMIDc);
$cnt_dirMIDc = @mysql_result($result_dirMIDc,0,0);
  
$query_dirMID = "SELECT lcode,mcode,mname FROM shop_catgmid WHERE lang = '$lang' ORDER BY mcode ASC";
  $result_dirMID = mysql_query($query_dirMID);
	
  for($dr = 0; $dr < $cnt_dirMIDc; $dr++) {
    $dirM_lcode = mysql_result($result_dirMID,$dr,0);
    $dirM_mcode = mysql_result($result_dirMID,$dr,1);
    $dirM_mname = mysql_result($result_dirMID,$dr,2);
    
    
    // 합계 구하기
    $query_sum1 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty 
                  WHERE $this_filter_in AND catg_code = '$dirM_mcode' AND $this_filter";
    $result_sum1 = mysql_query($query_sum1);
   
      $sum1_qty_org = @mysql_result($result_sum1,0,0);
      $sum1_price_org = @mysql_result($result_sum1,0,1);
        $sum1_price_org_K = number_format($sum1_price_org);

    $query_sum2 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty 
                  WHERE $this_filter_in AND catg_code = '$dirM_mcode' AND $this_filter 
                  AND date_expire > 0 AND date_expire < '$p_date_set'";
    $result_sum2 = mysql_query($query_sum2);
   
      $sum2_qty_org = @mysql_result($result_sum2,0,0);
      $sum2_price_org = @mysql_result($result_sum2,0,1);
        $sum2_price_org_K = number_format($sum2_price_org);

      $sum3_qty_org = $sum1_qty_org - $sum2_qty_org;
      $sum3_price_org = $sum1_price_org - $sum2_price_org;
        $sum3_price_org_K = number_format($sum3_price_org);


echo ("
<tr>
  <td height=22 style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr>
        <td width=5></td>
        <td width=28>[$dirM_mcode]</td>
        <td>$dirM_mname</td>
      </tr>
      </table>
  </td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum1_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum1_price_org_K}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum2_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum2_price_org_K}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum3_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid'>{$sum3_price_org_K}&nbsp;</td>
</tr>");
}
?>



</table>
