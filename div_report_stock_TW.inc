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


// DB
if($grpShp) {
    $page_dbtable_in = "sum(qty_org), sum(qty_org*price_orgin) FROM shop_product_list_shop";
    $page_dbtable_out = "sum(qty_sell), sum(qty_sell*price_orgin) FROM shop_product_list_shop";
    $page_dbtable_date = "post_date";
} else {
    $page_dbtable_in = "sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty";
    $page_dbtable_out = "sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty";
    $page_dbtable_date = "date";
}


// 검색 필터
if($grpBrc) {
  if($grpShp) {
    $this_filter_in = "shop_code = '$grpShp' AND branch_code = '$grpBrc'";
    $this_filter_out = "shop_code = '$grpShp' AND branch_code = '$grpBrc'";
  } else {
    $this_filter_in = "branch_code = '$grpBrc' AND flag = 'in'";
    $this_filter_out = "branch_code = '$grpBrc' AND flag = 'out'";
  }
} else {
    $this_filter_in = "flag = 'in'";
    $this_filter_out = "flag = 'out'";
}


// 해당 주간 검색 필터링
$page_date_setA = "$w_date_setA"."000000";
$page_date_setB = "$w_date_setB"."999999";

$page_yearA = substr($w_date_setA,0,4);
$page_monthA = substr($w_date_setA,4,2);
$page_dateA = substr($w_date_setA,6,2);

$page_yearB = substr($w_date_setB,0,4);
$page_monthB = substr($w_date_setB,4,2);
$page_dateB = substr($w_date_setB,6,2);

if($grpShp) {
  $this_filter = "post_date > '$page_date_setA' AND post_date < '$page_date_setB'";
  $this_filterA = "post_date < '$page_date_setA'";
} else {
  $this_filter = "date > '$page_date_setA' AND date < '$page_date_setB'";
  $this_filterA = "date < '$page_date_setA'";
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

$link_view = "$home/table_report.php?lang=$lang&loco=page_server&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp&w_date_setA=$w_date_setA&w_date_setB=$w_date_setB&p_quarter=$p_quarter&mode=stock_TW";
?>



<table width=100% cellspacing=0 cellpadding=0 style="BORDER-TOP: #888888 1px solid; BORDER-LEFT: #888888 1px solid; BORDER-BOTTOM: #888888 1px solid; BORDER-RIGHT: #888888 1px solid">
<tr>
  <td rowspan=2 width=200 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><b><?=$page_dateA?>-<?=$page_monthA?> ~ <?=$page_dateB?>-<?=$page_monthB?>-<?=$p_year?></b></td>
  <td height=22 colspan=2 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><?=$txt_invn_stockin_31?></td>
  <td colspan=2 align=center style='BORDER-RIGHT: #CCCCCC 1px solid'><?=$txt_invn_stockin_32?></td>
  <td colspan=2 align=center><?=$txt_invn_stockin_33?></td>
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
// 이전 합계 구하기
$query_ptsum1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND $this_filterA";
$result_ptsum1 = mysql_query($query_ptsum1);
   
  $ptsum1_qty_org = @mysql_result($result_ptsum1,0,0);
  $ptsum1_price_org = @mysql_result($result_ptsum1,0,1);
    $ptsum1_price_org_K = number_format($ptsum1_price_org);

$query_ptsum2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_out AND $this_filterA";
$result_ptsum2 = mysql_query($query_ptsum2);
   
  $ptsum2_qty_org = @mysql_result($result_ptsum2,0,0);
  $ptsum2_price_org = @mysql_result($result_ptsum2,0,1);
    $ptsum2_price_org_K = number_format($ptsum2_price_org);

  $ptsum3_qty_org = $ptsum1_qty_org - $ptsum2_qty_org;
  $ptsum3_price_org = $ptsum1_price_org - $ptsum2_price_org;
    $ptsum3_price_org_K = number_format($ptsum3_price_org);

    
// 합계 구하기
$dd = sprintf("%02d", $p_date);
$full_date_set = "$p_year"."$p_month"."$dd";

$query_tsum1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND $this_filter";
$result_tsum1 = mysql_query($query_tsum1);
   
  $tsum1_qty_org = @mysql_result($result_tsum1,0,0);
  $tsum1_price_org = @mysql_result($result_tsum1,0,1);
    $tsum1_price_org_K = number_format($tsum1_price_org);

$query_tsum2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_out AND $this_filter";
$result_tsum2 = mysql_query($query_tsum2);
   
  $tsum2_qty_org = @mysql_result($result_tsum2,0,0);
  $tsum2_price_org = @mysql_result($result_tsum2,0,1);
    $tsum2_price_org_K = number_format($tsum2_price_org);

  $tsum3_qty_org = $tsum1_qty_org - $tsum2_qty_org;
  $tsum3_price_org = $tsum1_price_org - $tsum2_price_org;
    $tsum3_price_org_K = number_format($tsum3_price_org);

  // 누적 합계
  $tsum4_qty_org = $ptsum3_qty_org + $tsum3_qty_org;
  $tsum4_price_org = $ptsum3_price_org + $tsum3_price_org;
    $tsum4_price_org_K = number_format($tsum4_price_org);
    

echo ("
<tr>
  <td height=22 align=center style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>&nbsp;</b></td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$ptsum3_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid'><b>$ptsum3_price_org_K</b>&nbsp;</td>
</tr>
<tr>
  <td height=22 align=center style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>TOTAL</b></td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum1_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum1_price_org_K</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum2_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum2_price_org_K</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'><b>$tsum4_qty_org</b>&nbsp;</td>
  <td align=right style='BORDER-TOP: #888888 1px solid'><b>$tsum4_price_org_K</b>&nbsp;</td>
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
    
    // 이전 합계 구하기
    $query_psum1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND catg_code = '$dirM_mcode' AND $this_filterA";
    $result_psum1 = mysql_query($query_psum1);
   
      $psum1_qty_org = @mysql_result($result_psum1,0,0);
      $psum1_price_org = @mysql_result($result_psum1,0,1);
        $psum1_price_org_K = number_format($psum1_price_org);

    $query_psum2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_in AND catg_code = '$dirM_mcode' AND $this_filterA";
    $result_psum2 = mysql_query($query_psum2);
   
      $psum2_qty_org = @mysql_result($result_psum2,0,0);
      $psum2_price_org = @mysql_result($result_psum2,0,1);
        $psum2_price_org_K = number_format($psum2_price_org);

    $psum3_qty_org = $psum1_qty_org - $psum2_qty_org;
    $psum3_price_org = $psum1_price_org - $psum2_price_org;
      $psum3_price_org_K = number_format($psum3_price_org);
    
    
    // 합계 구하기
    $query_sum1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND catg_code = '$dirM_mcode' AND $this_filter";
    $result_sum1 = mysql_query($query_sum1);
   
      $sum1_qty_org = @mysql_result($result_sum1,0,0);
      $sum1_price_org = @mysql_result($result_sum1,0,1);
        $sum1_price_org_K = number_format($sum1_price_org);

    $query_sum2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_out AND catg_code = '$dirM_mcode' AND $this_filter";
    $result_sum2 = mysql_query($query_sum2);
   
      $sum2_qty_org = @mysql_result($result_sum2,0,0);
      $sum2_price_org = @mysql_result($result_sum2,0,1);
        $sum2_price_org_K = number_format($sum2_price_org);

      $sum3_qty_org = $sum1_qty_org - $sum2_qty_org;
      $sum3_price_org = $sum1_price_org - $sum2_price_org;
        $sum3_price_org_K = number_format($sum3_price_org);

      // 누적 합계
      $sum4_qty_org = $psum3_qty_org + $sum3_qty_org;
      $sum4_price_org = $psum3_price_org + $sum3_price_org;
        $sum4_price_org_K = number_format($sum4_price_org);
        
        
echo ("
<tr>
  <td height=22 style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr>
        <td width=5></td>
        <td width=28>[$dirM_mcode]</td>
        <td><a href='$link_view&uid=$dirM_mcode'>$dirM_mname</a></td>
      </tr>
      </table>
  </td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum1_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum1_price_org_K}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum2_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum2_price_org_K}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sum4_qty_org}&nbsp;</td>
  <td align=right style='BORDER-TOP: #CCCCCC 1px solid'>{$sum4_price_org_K}&nbsp;</td>
</tr>");


  // 하위테이블 - 상품별 합계
  if($uid == $dirM_mcode) {

  $query_dirSUBc = "SELECT count(uid) FROM shop_product_list WHERE catg_code = '$uid'";
  $result_dirSUBc = mysql_query($query_dirSUBc);
  $cnt_dirSUBc = @mysql_result($result_dirSUBc,0,0);
  
  $query_dirSUB = "SELECT pname,pcode FROM shop_product_list WHERE catg_code = '$uid' ORDER BY pcode ASC";
  $result_dirSUB = mysql_query($query_dirSUB);
	
  for($drSUB = 0; $drSUB < $cnt_dirSUBc; $drSUB++) {
    $dirS_sname = mysql_result($result_dirSUB,$drSUB,0);
    $dirS_pcode = mysql_result($result_dirSUB,$drSUB,1);
    
    // 이전 합계 구하기
    $query_psums1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND pcode = '$dirS_pcode' AND $this_filterA";
    $result_psums1 = mysql_query($query_psums1);
   
      $psums1_qty_org = @mysql_result($result_psums1,0,0);
      $psums1_price_org = @mysql_result($result_psums1,0,1);
        $psums1_price_org_K = number_format($psums1_price_org);

    $query_psums2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_out AND pcode = '$dirS_pcode' AND $this_filterA";
    $result_psums2 = mysql_query($query_psums2);
   
      $psums2_qty_org = @mysql_result($result_psums2,0,0);
      $psums2_price_org = @mysql_result($result_psums2,0,1);
        $psums2_price_org_K = number_format($psums2_price_org);

    $psums3_qty_org = $psums1_qty_org - $psums2_qty_org;
    $psums3_price_org = $psums1_price_org - $psums2_price_org;
      $psums3_price_org_K = number_format($psums3_price_org);
    
    
    // 합계 구하기
    $query_sums1 = "SELECT $page_dbtable_in 
                  WHERE $this_filter_in AND pcode = '$dirS_pcode' AND $this_filter";
    $result_sums1 = mysql_query($query_sums1);
   
      $sums1_qty_org = @mysql_result($result_sums1,0,0);
      $sums1_price_org = @mysql_result($result_sums1,0,1);
        $sums1_price_org_K = number_format($sums1_price_org);

    $query_sums2 = "SELECT $page_dbtable_out 
                  WHERE $this_filter_out AND pcode = '$dirS_pcode' AND $this_filter";
    $result_sums2 = mysql_query($query_sums2);
   
      $sums2_qty_org = @mysql_result($result_sums2,0,0);
      $sums2_price_org = @mysql_result($result_sums2,0,1);
        $sums2_price_org_K = number_format($sums2_price_org);

      $sums3_qty_org = $sums1_qty_org - $sums2_qty_org;
      $sums3_price_org = $sums1_price_org - $sums2_price_org;
        $sums3_price_org_K = number_format($sums3_price_org);

      // 누적 합계
      $sums4_qty_org = $psums3_qty_org + $sums3_qty_org;
      $sums4_price_org = $psums3_price_org + $sums3_price_org;
        $sums4_price_org_K = number_format($sums4_price_org);


  echo ("
  <tr>
    <td height=22 style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr>
        <td width=5></td>
        <td width=28></td>
        <td>&nbsp; [$dirS_pcode] $dirS_sname</td>
      </tr>
      </table>
    </td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sums1_qty_org}&nbsp;</td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sums1_price_org_K}&nbsp;</td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sums2_qty_org}&nbsp;</td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sums2_price_org_K}&nbsp;</td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>{$sums4_qty_org}&nbsp;</td>
    <td align=right style='BORDER-TOP: #CCCCCC 1px solid'>{$sums4_price_org_K}&nbsp;</td>
  </tr>");

  }
  }

}
?>



</table>
