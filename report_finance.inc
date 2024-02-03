<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr>
  <td height=22 colspan=2 align=center>항 목</td>
  <td align=center>월간누적</td>
  <td align=center>일</td>
</tr>

<?
$p_date_set2 = $p_date_set."235959";
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

// 합계 구하기

    // 수익 - 월간 누적
    $query_sum_tA1 = "SELECT sum(amount) FROM finance 
      WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
      AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
    $result_sum_tA1 = mysql_query($query_sum_tA1);
    if (!$result_sum_tA1) { error("QUERY_ERROR"); exit; }

    $sum_tA1_amount = @mysql_result($result_sum_tA1,0,0);
    $sum_tA1_amount_K = number_format($sum_tA1_amount);

    // 수익 - 일일
    $query_sum_tA2 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_date_set%' AND process = '2'
      AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR - Daily
    $result_sum_tA2 = mysql_query($query_sum_tA2);
    if (!$result_sum_tA2) { error("QUERY_ERROR"); exit; }

    $sum_tA2_amount = @mysql_result($result_sum_tA2,0,0);
    $sum_tA2_amount_K = number_format($sum_tA2_amount);


    // 지출 - 월간 누적
    $query_sum_tB1 = "SELECT sum(amount) FROM finance 
      WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
      AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR
    $result_sum_tB1 = mysql_query($query_sum_tB1);
    if (!$result_sum_tB1) { error("QUERY_ERROR"); exit; }

    $sum_tB1_amount = @mysql_result($result_sum_tB1,0,0);
    $sum_tB1_amount_K = number_format($sum_tB1_amount);

    // 지출 - 일일
    $query_sum_tB2 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_date_set%' AND process = '2'
      AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR - Daily
    $result_sum_tB2 = mysql_query($query_sum_tB2);
    if (!$result_sum_tB2) { error("QUERY_ERROR"); exit; }

    $sum_tB2_amount = @mysql_result($result_sum_tB2,0,0);
    $sum_tB2_amount_K = number_format($sum_tB2_amount);

echo ("
<tr height=22>
  <td width=20%>&nbsp;비용</td>
  <td width=30% align=center>계</td>
  <td width=25% align=right>$sum_tB1_amount_K&nbsp;</td>
  <td width=25% align=right>$sum_tB2_amount_K&nbsp;</td>
</tr>");


    // OUTGOING
    $query_BC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'out'";
    $result_BC = mysql_query($query_BC);
    if (!$result_BC) { error("QUERY_ERROR"); exit; }
    $total_BC = @mysql_result($result_BC,0,0);
    
    $query_B = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'out' ORDER BY catg ASC";
    $result_B = mysql_query($query_B);
    if (!$result_B) {   error("QUERY_ERROR");   exit; }

    for($b = 0; $b < $total_BC; $b++) {
      $fB_uid = mysql_result($result_B,$b,0);
      $fB_class = mysql_result($result_B,$b,1);
      $fB_catg = mysql_result($result_B,$b,2);
   
      $fB_catg_txt = "txt_sys_account_06_"."$fB_catg";
      
      $query_H2C = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
      $result_H2C = mysql_query($query_H2C);
      if (!$result_H2C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H2C = @mysql_result($result_H2C,0,0);
      
      // Sub-Total
      $query_sum_tB3 = "SELECT sum(amount) FROM finance 
      WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
        AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR
      $result_sum_tB3 = mysql_query($query_sum_tB3);
      if (!$result_sum_tB3) { error("QUERY_ERROR"); exit; }

      $sum_tB3_amount = @mysql_result($result_sum_tB3,0,0);
      $sum_tB3_amount_K = number_format($sum_tB3_amount);

      $query_sum_tB5 = "SELECT sum(amount) FROM finance 
        WHERE pay_date LIKE '$p_date_set%' AND process = '2'
        AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR - Daily
      $result_sum_tB5 = mysql_query($query_sum_tB5);
      if (!$result_sum_tB5) { error("QUERY_ERROR"); exit; }

      $sum_tB5_amount = @mysql_result($result_sum_tB5,0,0);
      $sum_tB5_amount_K = number_format($sum_tB5_amount);
      
      
      
      echo ("
      <tr>
        <td align=right>${$fB_catg_txt}&nbsp;</td>
        <td align=center>계</td>
        <td align=right>$sum_tB3_amount_K&nbsp;</td>
        <td align=right>$sum_tB5_amount_K&nbsp;</td>
      </tr>");

                      
      $query_H2 = "SELECT uid,branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
      $result_H2 = mysql_query($query_H2);
      if (!$result_H2) {   error("QUERY_ERROR");   exit; }
    
      for($h2 = 0; $h2 < $total_H2C; $h2++) {
        $H2_acc_uid = mysql_result($result_H2,$h2,0);   
        $H2_acc_code = mysql_result($result_H2,$h2,1);
        $H2_acc_name = mysql_result($result_H2,$h2,2);

        // 항목별 합계
        $query_sum_xB = "SELECT sum(amount) FROM finance 
                WHERE branch_code = '$H2_acc_code' AND pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
                AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR
        $result_sum_xB = mysql_query($query_sum_xB);
        if (!$result_sum_xB) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount1 = @mysql_result($result_sum_xB,0,0);
        $sum_xB_amount1_K = number_format($sum_xB_amount1);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE branch_code = '$H2_acc_code' AND pay_date LIKE '$p_date_set%' AND process = '2'
                AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_xB_amount3_K = number_format($sum_xB_amount3);
      

      if($h2 == "0") {
      echo ("
      <tr>
        <td rowspan='$total_H2C'>&nbsp;</td>
        <td align=right>$H2_acc_name&nbsp;</td>
        <td align=right>$sum_xB_amount1_K&nbsp;</td>
        <td align=right>$sum_xB_amount3_K&nbsp;</td>
      </tr>");
      } else {
      echo ("
      <tr>
        <td align=right>$H2_acc_name&nbsp;</td>
        <td align=right>$sum_xB_amount1_K&nbsp;</td>
        <td align=right>$sum_xB_amount3_K&nbsp;</td>
      </tr>");
      }

    }

  }



echo ("
<tr height=22>
  <td>&nbsp;수익</td>
  <td align=center>계</td>
  <td width=25% align=right>$sum_tA1_amount_K&nbsp;</td>
  <td width=25% align=right>$sum_tA2_amount_K&nbsp;</td>
</tr>");




    // INCOMING
    $query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'in'";
    $result_AC = mysql_query($query_AC);
    if (!$result_AC) { error("QUERY_ERROR"); exit; }
    $total_AC = @mysql_result($result_AC,0,0);
    
    $query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'in' ORDER BY catg ASC";
    $result_A = mysql_query($query_A);
    if (!$result_A) {   error("QUERY_ERROR");   exit; }

    for($a = 0; $a < $total_AC; $a++) {
      $fA_uid = mysql_result($result_A,$a,0);
      $fA_class = mysql_result($result_A,$a,1);
      $fA_catg = mysql_result($result_A,$a,2);
   
      $fA_catg_txt = "txt_sys_account_05_"."$fA_catg";
      
      $query_H1C = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
      $result_H1C = mysql_query($query_H1C);
      if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H1C = @mysql_result($result_H1C,0,0);
      
      // Sub-Total
      $query_sum_tA3 = "SELECT sum(amount) FROM finance 
      WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
        AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_tA3 = mysql_query($query_sum_tA3);
      if (!$result_sum_tA3) { error("QUERY_ERROR"); exit; }

      $sum_tA3_amount = @mysql_result($result_sum_tA3,0,0);
      $sum_tA3_amount_K = number_format($sum_tA3_amount);

      $query_sum_tA5 = "SELECT sum(amount) FROM finance 
        WHERE pay_date LIKE '$p_date_set%' AND process = '2'
        AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR - Daily
      $result_sum_tA5 = mysql_query($query_sum_tA5);
      if (!$result_sum_tA5) { error("QUERY_ERROR"); exit; }

      $sum_tA5_amount = @mysql_result($result_sum_tA5,0,0);
      $sum_tA5_amount_K = number_format($sum_tA5_amount);
      
      
      
      echo ("
      <tr>
        <td align=right>${$fA_catg_txt}&nbsp;</td>
        <td align=center>계</td>
        <td align=right>$sum_tA3_amount_K&nbsp;</td>
        <td align=right>$sum_tA5_amount_K&nbsp;</td>
      </tr>");

                      
      $query_H1 = "SELECT uid,branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
      $result_H1 = mysql_query($query_H1);
      if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
      for($h1 = 0; $h1 < $total_H1C; $h1++) {
        $H1_acc_uid = mysql_result($result_H1,$h1,0);   
        $H1_acc_code = mysql_result($result_H1,$h1,1);
        $H1_acc_name = mysql_result($result_H1,$h1,2);

        // 항목별 합계
        $query_sum_xA = "SELECT sum(amount) FROM finance 
                WHERE branch_code = '$H1_acc_code' AND pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
                AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_xA = mysql_query($query_sum_xA);
        if (!$result_sum_xA) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount1 = @mysql_result($result_sum_xA,0,0);
        $sum_xA_amount1_K = number_format($sum_xA_amount1);
      
        $query_sum_x3A = "SELECT sum(amount) FROM finance 
                WHERE branch_code = '$H1_acc_code' AND pay_date LIKE '$p_date_set%' AND process = '2'
                AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3A = mysql_query($query_sum_x3A);
        if (!$result_sum_x3A) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount3 = @mysql_result($result_sum_x3A,0,0);
        $sum_xA_amount3_K = number_format($sum_xA_amount3);
      

      if($h1 == "0") {
      echo ("
      <tr>
        <td rowspan='$total_H1C'>&nbsp;</td>
        <td align=right>$H1_acc_name&nbsp;</td>
        <td align=right>$sum_xA_amount1_K&nbsp;</td>
        <td align=right>$sum_xA_amount3_K&nbsp;</td>
      </tr>");
      } else {
      echo ("
      <tr>
        <td align=right>$H1_acc_name&nbsp;</td>
        <td align=right>$sum_xA_amount1_K&nbsp;</td>
        <td align=right>$sum_xA_amount3_K&nbsp;</td>
      </tr>");
      }

    }

  }
?>
</table>

<br>
<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<?
// 영업이익
$query_YAm = "SELECT sum(amount) FROM finance 
  WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
  AND f_catg = 'A1' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
$result_YAm = mysql_query($query_YAm);
if (!$result_YAm) { error("QUERY_ERROR"); exit; }

$sum_YAm = @mysql_result($result_YAm,0,0);

$query_YBm = "SELECT sum(amount) FROM finance 
  WHERE pay_date >= '$p_month_set1' AND pay_date <= '$p_date_set2' AND process = '2'
  AND f_catg = 'B1' AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR
$result_YBm = mysql_query($query_YBm);
if (!$result_YBm) { error("QUERY_ERROR"); exit; }

$sum_YBm = @mysql_result($result_YBm,0,0);
        
$query_YAd = "SELECT sum(amount) FROM finance 
  WHERE pay_date LIKE '$p_date_set%' AND process = '2'
  AND f_catg = 'A1' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
$result_YAd = mysql_query($query_YAd);
if (!$result_YAd) { error("QUERY_ERROR"); exit; }

$sum_YAd = @mysql_result($result_YAd,0,0);

$query_YBd = "SELECT sum(amount) FROM finance 
  WHERE pay_date LIKE '$p_date_set%' AND process = '2'
  AND f_catg = 'B1' AND f_class = 'out' AND currency = 'IDR'"; // Income, IDR
$result_YBd = mysql_query($query_YBd);
if (!$result_YBd) { error("QUERY_ERROR"); exit; }

$sum_YBd = @mysql_result($result_YBd,0,0);

$sum_tY1_amount = $sum_YAm - $sum_YBm;
  $sum_tY1_amount_K = number_format($sum_tY1_amount);
$sum_tY2_amount = $sum_YAd - $sum_YBd;
  $sum_tY2_amount_K = number_format($sum_tY2_amount);


// 경상이익

$sum_tR1_amount = $sum_tA1_amount - $sum_tB1_amount;
  $sum_tR1_amount_K = number_format($sum_tR1_amount);
$sum_tR2_amount = $sum_tA2_amount - $sum_tB2_amount;
  $sum_tR2_amount_K = number_format($sum_tR2_amount);

echo ("
<tr height=22>
  <td width=50%>&nbsp;영업이익</td>
  <td width=25% align=right>$sum_tY1_amount_K&nbsp;</td>
  <td width=25% align=right>$sum_tY2_amount_K&nbsp;</td>
</tr>
<tr height=22>
  <td width=50%>&nbsp;경상이익</td>
  <td width=25% align=right>$sum_tR1_amount_K&nbsp;</td>
  <td width=25% align=right>$sum_tR2_amount_K&nbsp;</td>
</tr>");
?>
</table>

