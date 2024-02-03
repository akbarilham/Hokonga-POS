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

$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";
?>

<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr height=22>
  <td width=6% colspan=2 rowspan=2 align=center style="<?=$BOX_TOP1?>"><b><?=$p_month_txt?></b></td>
  <td colspan=2 align=center style="<?=$BOX_TOP2?>"><b>TOTAL</b></td>
  <?
  // BANKs
  $query_x1c = "SELECT count(uid) FROM code_bank WHERE currency = 'IDR' AND userlevel > '0'";
  $result_x1c = mysql_query($query_x1c);
  $total_x1c = @mysql_result($result_x1c,0,0);
  $total_x1c2 = $total_x1c + 1;
  
  $query_x2c = "SELECT count(uid) FROM code_bank WHERE currency = 'USD' AND userlevel > '0'";
  $result_x2c = mysql_query($query_x2c);
  $total_x2c = @mysql_result($result_x2c,0,0);
  $total_x2c2 = $total_x2c + 1;
  
  echo ("
  <td colspan=$total_x1c2 align=center style='$BOX_TOP2'>RUPIAH</td>
  <td colspan=$total_x2c2 align=center style='$BOX_TOP2'>USD</td>
  ");
  ?>
</tr>

<tr height=22>
  <td width=10% align=center style='<?=$BOX_LAIN2?>'>RUPIAH</td>
  <td width=10% align=center style='<?=$BOX_LAIN2?>'>USD</td>
  <?
  $query_xb1 = "SELECT bank_code,bank_name FROM code_bank 
            WHERE currency = 'IDR' AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb1 = mysql_query($query_xb1);
  
  echo ("<td align=center style='$BOX_LAIN2'>CASH</td>");

  for($xb1 = 0; $xb1 < $total_x1c; $xb1++) {
    $xb1_bank_code = mysql_result($result_xb1,$xb1,0);
    $xb1_bank_name = mysql_result($result_xb1,$xb1,1);
    
    echo ("<td align=center style='$BOX_LAIN2'>$xb1_bank_name</td>");
  
  }
  
  $query_xb2 = "SELECT bank_code,bank_name FROM code_bank 
            WHERE currency = 'USD' AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb2 = mysql_query($query_xb2);
  
  echo ("<td align=center style='$BOX_LAIN2'>CASH</td>");

  for($xb2 = 0; $xb2 < $total_x2c; $xb2++) {
    $xb2_bank_code = mysql_result($result_xb2,$xb2,0);
    $xb2_bank_name = mysql_result($result_xb2,$xb2,1);
    
    echo ("<td align=center style='$BOX_LAIN2'>$xb2_bank_name</td>");
  
  }
  ?>
</tr>


<!------------------------ 전월 합계 // -------------------------------------------------------------------->

<tr height=22>
  <td colspan=2 align=center style='<?=$BOX_LAIN1?>'>BEFORE M</td>
  
  <?
  // 전월 합계
  $query_psum1 = "SELECT sum(amount) FROM finance WHERE pay_date < '$p_month_set1' 
                  AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
  $result_psum1 = mysql_query($query_psum1);
  if (!$result_psum1) { error("QUERY_ERROR"); exit; }

  $psum1_pay_amount = @mysql_result($result_psum1,0,0);
  $psum1_pay_amount_K = number_format($psum1_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$psum1_pay_amount_K}&nbsp;</td>");
  
  $query_psum2 = "SELECT sum(amount) FROM finance WHERE pay_date < '$p_month_set1' 
                  AND f_class = 'in' AND process = '2' AND currency = 'USD'";
  $result_psum2 = mysql_query($query_psum2);
  if (!$result_psum2) { error("QUERY_ERROR"); exit; }

  $psum2_pay_amount = @mysql_result($result_psum2,0,0);
  $psum2_pay_amount_K = number_format($psum2_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$psum2_pay_amount_K}&nbsp;</td>");
  

  // 전월 계좌별 소계
  // Cash
  $query_csum1 = "SELECT sum(amount) FROM finance WHERE pay_type = 'cash' 
                  AND pay_date < '$p_month_set1' AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
  $result_csum1 = mysql_query($query_csum1);
  if (!$result_csum1) { error("QUERY_ERROR"); exit; }

  $csum1_pay_amount = @mysql_result($result_csum1,0,0);
  $csum1_pay_amount_K = number_format($csum1_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$csum1_pay_amount_K}&nbsp;</td>");
  
  // Banks
  $query_xb1 = "SELECT bank_code,bank_name FROM code_bank WHERE currency = 'IDR' 
                AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb1 = mysql_query($query_xb1);

  for($xb1 = 0; $xb1 < $total_x1c; $xb1++) {
    $xb1_bank_code = mysql_result($result_xb1,$xb1,0);
    $xb1_bank_name = mysql_result($result_xb1,$xb1,1);
    
    $query_bsum1 = "SELECT sum(amount) FROM finance WHERE pay_type = 'bank' AND bank_name = '$xb1_bank_code' 
      AND pay_date < '$p_month_set1' AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
    $result_bsum1 = mysql_query($query_bsum1);
    if (!$result_bsum1) { error("QUERY_ERROR"); exit; }

    $bsum1_pay_amount = @mysql_result($result_bsum1,0,0);
    $bsum1_pay_amount_K = number_format($bsum1_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>{$bsum1_pay_amount_K}&nbsp;</td>");
  
  }
  
  // Cash
  $query_csum2 = "SELECT sum(amount) FROM finance WHERE pay_type = 'cash' AND pay_date < '$p_month_set1' 
                  AND f_class = 'in' AND process = '2' AND currency = 'USD'";
  $result_csum2 = mysql_query($query_csum2);
  if (!$result_csum2) { error("QUERY_ERROR"); exit; }

  $csum2_pay_amount = @mysql_result($result_csum2,0,0);
  $csum2_pay_amount_K = number_format($csum2_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$csum2_pay_amount_K}&nbsp;</td>");
  
  // Banks
  $query_xb2 = "SELECT bank_code,bank_name FROM code_bank WHERE currency = 'USD' 
                AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb2 = mysql_query($query_xb2);
  
  for($xb2 = 0; $xb2 < $total_x2c; $xb2++) {
    $xb2_bank_code = mysql_result($result_xb2,$xb2,0);
    $xb2_bank_name = mysql_result($result_xb2,$xb2,1);
    
    $query_bsum2 = "SELECT sum(amount) FROM finance WHERE pay_type = 'bank' AND bank_name = '$xb2_bank_code' 
      AND pay_date < '$p_month_set1' AND f_class = 'in' AND process = '2' AND currency = 'USD'";
    $result_bsum2 = mysql_query($query_bsum2);
    if (!$result_bsum2) { error("QUERY_ERROR"); exit; }

    $bsum2_pay_amount = @mysql_result($result_bsum2,0,0);
    $bsum2_pay_amount_K = number_format($bsum2_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>{$bsum2_pay_amount_K}&nbsp;</td>");
  
  }
  ?>
</tr>




<!----- 일자별 반복 // ------------------------------------------------------------------------->
<?
for($d = 1; $d <= $totaldays2; $d++) {

  // 요일 구하기 (0=일요일)
  $wd = date('w', mktime(0,0,0,$p_month,$d,$p_year));
  if($wd == "0") { $wd_txt = "SUN"; }
  if($wd == "1") { $wd_txt = "MON"; }
  if($wd == "2") { $wd_txt = "TUE"; }
  if($wd == "3") { $wd_txt = "WED"; }
  if($wd == "4") { $wd_txt = "THU"; }
  if($wd == "5") { $wd_txt = "FRI"; }
  if($wd == "6") { $wd_txt = "SAT"; }
  
  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";
  $this_date_set_F = $this_date_set . "999999";

  echo ("
  <tr height=18>
    <td align=right style='$BOX_LAIN1'>$d&nbsp;</td>
    <td align=center style='$BOX_LAIN2'>$wd_txt</td>");
    ?>

  <?
  // 합계
  $query_pdsum1 = "SELECT sum(amount) FROM finance WHERE pay_date <= '$this_date_set_F' 
                  AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
  $result_pdsum1 = mysql_query($query_pdsum1);
  if (!$result_pdsum1) { error("QUERY_ERROR"); exit; }

  $pdsum1_pay_amount = @mysql_result($result_pdsum1,0,0);
  $pdsum1_pay_amount_K = number_format($pdsum1_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$pdsum1_pay_amount_K}&nbsp;</td>");
  
  $query_pdsum2 = "SELECT sum(amount) FROM finance WHERE pay_date <= '$this_date_set_F' 
                  AND f_class = 'in' AND process = '2' AND currency = 'USD'";
  $result_pdsum2 = mysql_query($query_pdsum2);
  if (!$result_pdsum2) { error("QUERY_ERROR"); exit; }

  $pdsum2_pay_amount = @mysql_result($result_pdsum2,0,0);
  $pdsum2_pay_amount_K = number_format($pdsum2_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$pdsum2_pay_amount_K}&nbsp;</td>");
  

  // 계좌별 소계
  // Cash
  $query_cdsum1 = "SELECT sum(amount) FROM finance WHERE pay_type = 'cash' AND pay_date <= '$this_date_set_F' 
                  AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
  $result_cdsum1 = mysql_query($query_cdsum1);
  if (!$result_cdsum1) { error("QUERY_ERROR"); exit; }

  $cdsum1_pay_amount = @mysql_result($result_cdsum1,0,0);
  $cdsum1_pay_amount_K = number_format($cdsum1_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$cdsum1_pay_amount_K}&nbsp;</td>");
  
  // Banks
  $query_xb1 = "SELECT bank_code,bank_name FROM code_bank WHERE currency = 'IDR' 
                AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb1 = mysql_query($query_xb1);

  for($xb1 = 0; $xb1 < $total_x1c; $xb1++) {
    $xb1_bank_code = mysql_result($result_xb1,$xb1,0);
    $xb1_bank_name = mysql_result($result_xb1,$xb1,1);
    
    $query_bdsum1 = "SELECT sum(amount) FROM finance WHERE pay_type = 'bank' AND bank_name = '$xb1_bank_code' 
      AND pay_date <= '$this_date_set_F' AND f_class = 'in' AND process = '2' AND currency = 'IDR'";
    $result_bdsum1 = mysql_query($query_bdsum1);
    if (!$result_bdsum1) { error("QUERY_ERROR"); exit; }

    $bdsum1_pay_amount = @mysql_result($result_bdsum1,0,0);
    $bdsum1_pay_amount_K = number_format($bdsum1_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>{$bdsum1_pay_amount_K}&nbsp;</td>");
  
  }
  
  // Cash
  $query_cdsum2 = "SELECT sum(amount) FROM finance WHERE pay_type = 'cash' AND pay_date <= '$this_date_set_F' 
                  AND f_class = 'in' AND process = '2' AND currency = 'USD'";
  $result_cdsum2 = mysql_query($query_cdsum2);
  if (!$result_cdsum2) { error("QUERY_ERROR"); exit; }

  $cdsum2_pay_amount = @mysql_result($result_cdsum2,0,0);
  $cdsum2_pay_amount_K = number_format($cdsum2_pay_amount);
  
  echo ("<td align=right style='$BOX_LAIN2'>{$cdsum2_pay_amount_K}&nbsp;</td>");
  
  // Banks
  $query_xb2 = "SELECT bank_code,bank_name FROM code_bank WHERE currency = 'USD' 
                AND userlevel > '0' ORDER BY bank_code ASC";
  $result_xb2 = mysql_query($query_xb2);
  
  for($xb2 = 0; $xb2 < $total_x2c; $xb2++) {
    $xb2_bank_code = mysql_result($result_xb2,$xb2,0);
    $xb2_bank_name = mysql_result($result_xb2,$xb2,1);
    
    $query_bdsum2 = "SELECT sum(amount) FROM finance WHERE pay_type = 'bank' AND bank_name = '$xb2_bank_code' 
      AND pay_date <= '$this_date_set_F' AND f_class = 'in' AND process = '2' AND currency = 'USD'";
    $result_bdsum2 = mysql_query($query_bdsum2);
    if (!$result_bdsum2) { error("QUERY_ERROR"); exit; }

    $bdsum2_pay_amount = @mysql_result($result_bdsum2,0,0);
    $bdsum2_pay_amount_K = number_format($bdsum2_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>{$bdsum2_pay_amount_K}&nbsp;</td>");
  
  }
  ?>
</tr>




<? } ?>
</table>  
