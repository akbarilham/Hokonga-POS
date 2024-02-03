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
?>

<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr height=22>
  <td width=6% colspan=2 style="<?=$BOX_TOP1?>">&nbsp;</td>
  <td width=10% align=center style="<?=$BOX_TOP2?>"><b>TOTAL</b></td>
  
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
    
    echo ("<td align=center style='$BOX_TOP2'>$x1_branch_name</td>");
  }
  ?>
</tr>


<!----- 누적 총합계 // ----------------------------------------------------------------------------->
<tr height=22>
  <td colspan=2 align=center style='<?=$BOX_LAIN1?>'><b>Acc.</b></td>
  <?
  $query_atsumR1z = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'out' AND f_intype = '1' AND currency = 'IDR' 
        AND pay_state = '2'";
  $result_atsumR1z = mysql_query($query_atsumR1z);
  if (!$result_atsumR1z) { error("QUERY_ERROR"); exit; }

  $atsum_pay_amountR1z = @mysql_result($result_atsumR1z,0,0);
  $atsum_pay_amountR1z_K = number_format($atsum_pay_amountR1z);
  
  echo ("<td align=right style='$BOX_LAIN2'>$atsum_pay_amountR1z_K&nbsp;</td>");
  
  
  
  $query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
  $result_x1 = mysql_query($query_x1);
  
  for($x1 = 0; $x1 < $total_x1c; $x1++) {
    $x1_branch_code = mysql_result($result_x1,$x1,0);
    $x1_branch_name = mysql_result($result_x1,$x1,1);
    
    $query_s1z = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' 
            AND f_class = 'out' AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
    $result_s1z = mysql_query($query_s1z);
    if (!$result_s1z) { error("QUERY_ERROR"); exit; }

    $s1z_pay_amount = @mysql_result($result_s1z,0,0);
    $s1z_pay_amount_K = number_format($s1z_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>$s1z_pay_amount_K&nbsp;</td>");
  }
  ?>
</tr>

<!----- 월 합계 // ----------------------------------------------------------------------------->
<tr height=22>
  <td colspan=2 align=center style='<?=$BOX_LAIN1?>'><b><?=$p_month_txt?></b></td>
  <?
  $query_atsumR1 = "SELECT sum(pay_amount) FROM shop_payment 
        WHERE pay_date LIKE '$p_yearmonth%' AND f_class = 'out' AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
  $result_atsumR1 = mysql_query($query_atsumR1);
  if (!$result_atsumR1) { error("QUERY_ERROR"); exit; }

  $atsum_pay_amountR1 = @mysql_result($result_atsumR1,0,0);
  $atsum_pay_amountR1_K = number_format($atsum_pay_amountR1);
  
  echo ("<td align=right style='$BOX_LAIN2'>$atsum_pay_amountR1_K&nbsp;</td>");
  
  
  
  $query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
  $result_x1 = mysql_query($query_x1);
  
  for($x1 = 0; $x1 < $total_x1c; $x1++) {
    $x1_branch_code = mysql_result($result_x1,$x1,0);
    $x1_branch_name = mysql_result($result_x1,$x1,1);
    
    $query_s1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' 
            AND pay_date LIKE '$p_yearmonth%' AND f_class = 'out' 
            AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
    $result_s1 = mysql_query($query_s1);
    if (!$result_s1) { error("QUERY_ERROR"); exit; }

    $s1_pay_amount = @mysql_result($result_s1,0,0);
    $s1_pay_amount_K = number_format($s1_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>$s1_pay_amount_K&nbsp;</td>");
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

  echo ("
  <tr height=18>
    <td align=right style='$BOX_LAIN1'>$d&nbsp;</td>
    <td align=center style='$BOX_LAIN2'>$wd_txt</td>");
    ?>

  <?
  $query_atsumR2 = "SELECT sum(pay_amount) FROM shop_payment 
        WHERE pay_date LIKE '$this_date_set%' AND f_class = 'out' AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
  $result_atsumR2 = mysql_query($query_atsumR2);
  if (!$result_atsumR2) { error("QUERY_ERROR"); exit; }

  $atsum_pay_amountR2 = @mysql_result($result_atsumR2,0,0);
  $atsum_pay_amountR2_K = number_format($atsum_pay_amountR2);
  
  echo ("<td align=right style='$BOX_LAIN2'>$atsum_pay_amountR2_K&nbsp;</td>");
  
  
  $query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
  $result_x1 = mysql_query($query_x1);
  
  for($x1 = 0; $x1 < $total_x1c; $x1++) {
    $x1_branch_code = mysql_result($result_x1,$x1,0);
    $x1_branch_name = mysql_result($result_x1,$x1,1);
    
    $query_s1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' 
            AND pay_date LIKE '$this_date_set%' AND f_class = 'out' 
            AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
    $result_s1 = mysql_query($query_s1);
    if (!$result_s1) { error("QUERY_ERROR"); exit; }

    $s1_pay_amount = @mysql_result($result_s1,0,0);
    $s1_pay_amount_K = number_format($s1_pay_amount);
  
    echo ("<td align=right style='$BOX_LAIN2'>$s1_pay_amount_K&nbsp;</td>");
  }
  ?>    
</tr>

<? } ?>
</table>  
