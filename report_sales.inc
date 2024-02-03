<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td colspan=2>&nbsp;</td>
  <td align=center>HOST (계)</td>
  
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
    
    echo ("<td align=center>$x1_branch_name</td>");
  }
  ?>
</tr>

<!----- 월 합계 // ____------------------------------------------------------------------------->
<tr height=22>
  <td colspan=2 align=center><?=$p_month?>월</td>
  <?
  $query_atsumR1 = "SELECT sum(pay_amount) FROM shop_payment 
        WHERE pay_date LIKE '$p_yearmonth%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  $result_atsumR1 = mysql_query($query_atsumR1);
  if (!$result_atsumR1) { error("QUERY_ERROR"); exit; }

  $atsum_pay_amountR1 = @mysql_result($result_atsumR1,0,0);
  $atsum_pay_amountR1_K = number_format($atsum_pay_amountR1);
  
  echo ("<td align=right>$atsum_pay_amountR1_K&nbsp;</td>");
  
  
  
  $query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
  $result_x1 = mysql_query($query_x1);
  
  for($x1 = 0; $x1 < $total_x1c; $x1++) {
    $x1_branch_code = mysql_result($result_x1,$x1,0);
    $x1_branch_name = mysql_result($result_x1,$x1,1);
    
    $query_s1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' 
            AND pay_date LIKE '$p_yearmonth%' AND f_class = 'in' 
            AND f_intype = '1' AND currency = 'IDR'";
    $result_s1 = mysql_query($query_s1);
    if (!$result_s1) { error("QUERY_ERROR"); exit; }

    $s1_pay_amount = @mysql_result($result_s1,0,0);
    $s1_pay_amount_K = number_format($s1_pay_amount);
  
    echo ("<td align=right>$s1_pay_amount_K&nbsp;</td>");
  }
  ?>
</tr>


<!----- 일자별 반복 // ------------------------------------------------------------------------->
<?
for($d = 1; $d <= $totaldays2; $d++) {

  // 요일 구하기 (0=일요일)
  $wd = date('w', mktime(0,0,0,$p_month,$d,$p_year));
  if($wd == "0") { $wd_txt = "일"; }
  if($wd == "1") { $wd_txt = "월"; }
  if($wd == "2") { $wd_txt = "화"; }
  if($wd == "3") { $wd_txt = "수"; }
  if($wd == "4") { $wd_txt = "목"; }
  if($wd == "5") { $wd_txt = "금"; }
  if($wd == "6") { $wd_txt = "토"; }
  
  // 날짜를 2자리 수자로 표현
  $dd = sprintf("%02d", $d);
  
  // 해당 날짜
  $this_date_set = "$p_year"."$p_month"."$dd";

  echo ("
  <tr>
    <td align=right>$d&nbsp;</td>
    <td align=center>$wd_txt</td>");
    ?>

  <?
  $query_atsumR2 = "SELECT sum(pay_amount) FROM shop_payment 
        WHERE pay_date LIKE '$this_date_set%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  $result_atsumR2 = mysql_query($query_atsumR2);
  if (!$result_atsumR2) { error("QUERY_ERROR"); exit; }

  $atsum_pay_amountR2 = @mysql_result($result_atsumR2,0,0);
  $atsum_pay_amountR2_K = number_format($atsum_pay_amountR2);
  
  echo ("<td align=right>$atsum_pay_amountR2_K&nbsp;</td>");
  
  
  $query_x1 = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
  $result_x1 = mysql_query($query_x1);
  
  for($x1 = 0; $x1 < $total_x1c; $x1++) {
    $x1_branch_code = mysql_result($result_x1,$x1,0);
    $x1_branch_name = mysql_result($result_x1,$x1,1);
    
    $query_s1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' 
            AND pay_date LIKE '$this_date_set%' AND f_class = 'in' 
            AND f_intype = '1' AND currency = 'IDR'";
    $result_s1 = mysql_query($query_s1);
    if (!$result_s1) { error("QUERY_ERROR"); exit; }

    $s1_pay_amount = @mysql_result($result_s1,0,0);
    $s1_pay_amount_K = number_format($s1_pay_amount);
  
    echo ("<td align=right>$s1_pay_amount_K&nbsp;</td>");
  }
  ?>    
</tr>

<? } ?>
</table>  
