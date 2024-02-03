<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
  <td height=22 colspan=2 align=center style="<?=$BOX_TOP1?>">Criteria</td>
  <td align=center style="<?=$BOX_TOP2?>"><b><?=$p_year?></b></td>
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
  
  echo ("<td align=center style='$BOX_TOP2'>$mm_txt</td>");
  
  }
  ?>
</tr>

<?
$p_date_set2 = $p_date_set."235959";
$p_month_set1 = $p_yearmonth."01000000";
$p_month_set2 = $p_yearmonth."31235959";

// 합계 구하기

    
    // 지출 - 연간 누적
    $query_sum_tB1 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_year%' AND process = '2'
      AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
    $result_sum_tB1 = mysql_query($query_sum_tB1);
    if (!$result_sum_tB1) { error("QUERY_ERROR"); exit; }

    $sum_tB1_amount = @mysql_result($result_sum_tB1,0,0);
    $sum_tB1_amount_K = number_format($sum_tB1_amount);


echo ("
<tr height=22>
  <td bgcolor=#EFEFEF width=8% style='$BOX_LAIN1'>&nbsp;<b>COST</b></td>
  <td bgcolor=#EFEFEF width=16% align=center style='$BOX_LAIN2'><b>TOTAL</b></td>
  <td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>$sum_tB1_amount_K&nbsp;</td>"); ?>
  
  <?
  // 지출 - 매월(반복)
  for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
    
    $query_sum_mB = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$this_month_set%' AND process = '2'
      AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
    $result_sum_mB = mysql_query($query_sum_mB);
    if (!$result_sum_mB) { error("QUERY_ERROR"); exit; }

    $sum_mB_amount = @mysql_result($result_sum_mB,0,0);
    $sum_mB_amount_K = number_format($sum_mB_amount);
    
  
    echo ("<td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>{$sum_mB_amount_K}&nbsp;</td>");
  
  }
  ?>
</tr>


    <?
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
      
      $query_H2C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fB_catg' AND lang = '$lang'";
      $result_H2C = mysql_query($query_H2C);
      if (!$result_H2C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H2C = @mysql_result($result_H2C,0,0);
      
      // Sub-Total Yearly
      $query_sum_tB3 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_year%' AND process = '2'
        AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
      $result_sum_tB3 = mysql_query($query_sum_tB3);
      if (!$result_sum_tB3) { error("QUERY_ERROR"); exit; }

      $sum_tB3_amount = @mysql_result($result_sum_tB3,0,0);
      $sum_tB3_amount_K = number_format($sum_tB3_amount);

      
      echo ("
      <tr height=22>
        <td align=right style='$BOX_LAIN1'>${$fB_catg_txt}&nbsp;</td>
        <td align=center style='$BOX_LAIN2'>TOTAL</td>
        <td align=right style='$BOX_LAIN2'>$sum_tB3_amount_K&nbsp;</td>"); ?>
        
        <?
        // 지출 - 매월(반복)
        for($m = $m_s; $m <= $m_f; $m++) {

        $mm = sprintf("%02d", $m);
        $this_month_set = "$p_year"."$mm";
    
        $query_sum_fB = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_catg = '$fB_catg' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
        $result_sum_fB = mysql_query($query_sum_fB);
        if (!$result_sum_fB) { error("QUERY_ERROR"); exit; }

        $sum_fB_amount = @mysql_result($result_sum_fB,0,0);
        $sum_fB_amount_K = number_format($sum_fB_amount);
        
         echo ("<td align=right style='$BOX_LAIN2'>{$sum_fB_amount_K}&nbsp;</td>");
        
        }
        ?>
      </tr>

      
      <?
      $query_H2 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
                  WHERE catg = '$fB_catg' AND lang = '$lang' ORDER BY acc_code ASC";
      $result_H2 = mysql_query($query_H2);
      if (!$result_H2) {   error("QUERY_ERROR");   exit; }
    
      for($h2 = 0; $h2 < $total_H2C; $h2++) {
        $H2_acc_uid = mysql_result($result_H2,$h2,0);   
        $H2_acc_code = mysql_result($result_H2,$h2,1);
        $H2_acc_name = mysql_result($result_H2,$h2,2);

        // 항목별 합계
        $query_sum_xB = "SELECT sum(amount) FROM finance 
                WHERE pay_date LIKE '$p_year%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
        $result_sum_xB = mysql_query($query_sum_xB);
        if (!$result_sum_xB) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount1 = @mysql_result($result_sum_xB,0,0);
        $sum_xB_amount1_K = number_format($sum_xB_amount1);
      

      if($h2 == "0") {
      echo ("
      <tr height=22>
        <td rowspan='$total_H2C' style='$BOX_LAIN1'>&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$H2_acc_name&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$sum_xB_amount1_K&nbsp;</td>");
      } else {
      echo ("
      <tr height=22>
        <td align=right style='$BOX_LAIN2'>$H2_acc_name&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$sum_xB_amount1_K&nbsp;</td>");
      }
      ?>
      
        <?
        // 지출 - 매월(반복)
        for($m = $m_s; $m <= $m_f; $m++) {

        $mm = sprintf("%02d", $m);
        $this_month_set = "$p_year"."$mm";
    
        $query_sum_fcB = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
        $result_sum_fcB = mysql_query($query_sum_fcB);
        if (!$result_sum_fcB) { error("QUERY_ERROR"); exit; }

        $sum_fcB_amount = @mysql_result($result_sum_fcB,0,0);
        $sum_fcB_amount_K = number_format($sum_fcB_amount);
        
         echo ("<td align=right style='$BOX_LAIN2'>{$sum_fcB_amount_K}&nbsp;</td>");
        
        }
        ?>
      </tr>
      
    <?

    }

  }






    // 수익 - 연간 누적
    $query_sum_tA1 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_year%' AND process = '2'
      AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
    $result_sum_tA1 = mysql_query($query_sum_tA1);
    if (!$result_sum_tA1) { error("QUERY_ERROR"); exit; }

    $sum_tA1_amount = @mysql_result($result_sum_tA1,0,0);
    $sum_tA1_amount_K = number_format($sum_tA1_amount);


echo ("
<tr height=22>
  <td bgcolor=#EFEFEF style='$BOX_LAIN1'>&nbsp;<b>INCOME</b></td>
  <td bgcolor=#EFEFEF align=center style='$BOX_LAIN2'><b>TOTAL</b></td>
  <td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>$sum_tA1_amount_K&nbsp;</td>"); ?>
  
  <?
  // 수익 - 매월(반복)
  for($m = $m_s; $m <= $m_f; $m++) {

    $mm = sprintf("%02d", $m);
    $this_month_set = "$p_year"."$mm";
    
    $query_sum_mA = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$this_month_set%' AND process = '2'
      AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
    $result_sum_mA = mysql_query($query_sum_mA);
    if (!$result_sum_mA) { error("QUERY_ERROR"); exit; }

    $sum_mA_amount = @mysql_result($result_sum_mA,0,0);
    $sum_mA_amount_K = number_format($sum_mA_amount);
    
  
    echo ("<td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>{$sum_mA_amount_K}&nbsp;</td>");
  
  }
  ?>
</tr>



    <?
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
      
      $query_H1C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fA_catg' AND lang = '$lang'";
      $result_H1C = mysql_query($query_H1C);
      if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H1C = @mysql_result($result_H1C,0,0);
      
      // Sub-Total Yearly
      $query_sum_tA3 = "SELECT sum(amount) FROM finance 
      WHERE pay_date LIKE '$p_year%' AND process = '2'
        AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_tA3 = mysql_query($query_sum_tA3);
      if (!$result_sum_tA3) { error("QUERY_ERROR"); exit; }

      $sum_tA3_amount = @mysql_result($result_sum_tA3,0,0);
      $sum_tA3_amount_K = number_format($sum_tA3_amount);
      
      
      echo ("
      <tr height=22>
        <td align=right style='$BOX_LAIN1'>${$fA_catg_txt}&nbsp;</td>
        <td align=center style='$BOX_LAIN2'>TOTAL</td>
        <td align=right style='$BOX_LAIN2'>$sum_tA3_amount_K&nbsp;</td>"); ?>
        
        <?
        // 수익 - 매월(반복)
        for($m = $m_s; $m <= $m_f; $m++) {

        $mm = sprintf("%02d", $m);
        $this_month_set = "$p_year"."$mm";
    
        $query_sum_fA = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_catg = '$fA_catg' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_fA = mysql_query($query_sum_fA);
        if (!$result_sum_fA) { error("QUERY_ERROR"); exit; }

        $sum_fA_amount = @mysql_result($result_sum_fA,0,0);
        $sum_fA_amount_K = number_format($sum_fA_amount);
        
         echo ("<td align=right style='$BOX_LAIN2'>{$sum_fA_amount_K}&nbsp;</td>");
        
        }
        ?>
      </tr>

      <?
      $query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
                  WHERE catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
      $result_H1 = mysql_query($query_H1);
      if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
      for($h1 = 0; $h1 < $total_H1C; $h1++) {
        $H1_acc_uid = mysql_result($result_H1,$h1,0);   
        $H1_acc_code = mysql_result($result_H1,$h1,1);
        $H1_acc_name = mysql_result($result_H1,$h1,2);

        // 항목별 합계
        $query_sum_xA = "SELECT sum(amount) FROM finance 
                WHERE pay_date LIKE '$p_year%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_xA = mysql_query($query_sum_xA);
        if (!$result_sum_xA) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount1 = @mysql_result($result_sum_xA,0,0);
        $sum_xA_amount1_K = number_format($sum_xA_amount1);
      

      if($h1 == "0") {
      echo ("
      <tr height=22>
        <td rowspan='$total_H1C' style='$BOX_LAIN1'>&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$H1_acc_name&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$sum_xA_amount1_K&nbsp;</td>");
      } else {
      echo ("
      <tr height=22>
        <td align=right style='$BOX_LAIN2'>$H1_acc_name&nbsp;</td>
        <td align=right style='$BOX_LAIN2'>$sum_xA_amount1_K&nbsp;</td>");
      }
      ?>
      
        <?
        // 수익 - 매월(반복)
        for($m = $m_s; $m <= $m_f; $m++) {

        $mm = sprintf("%02d", $m);
        $this_month_set = "$p_year"."$mm";
    
        $query_sum_fcA = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_fcA = mysql_query($query_sum_fcA);
        if (!$result_sum_fcA) { error("QUERY_ERROR"); exit; }

        $sum_fcA_amount = @mysql_result($result_sum_fcA,0,0);
        $sum_fcA_amount_K = number_format($sum_fcA_amount);
        
         echo ("<td align=right style='$BOX_LAIN2'>{$sum_fcA_amount_K}&nbsp;</td>");
        
        }
        ?>
      </tr>
      
      <?

    }

  }
?>




<?
// 영업이익

// Yearly
$query_YAm = "SELECT sum(amount) FROM finance 
  WHERE pay_date LIKE '$p_year%' AND process = '2'
  AND f_catg = 'A1' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
$result_YAm = mysql_query($query_YAm);
if (!$result_YAm) { error("QUERY_ERROR"); exit; }

$sum_YAm = @mysql_result($result_YAm,0,0);

$query_YBm = "SELECT sum(amount) FROM finance 
  WHERE pay_date LIKE '$p_year%' AND process = '2'
  AND f_catg = 'B1' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
$result_YBm = mysql_query($query_YBm);
if (!$result_YBm) { error("QUERY_ERROR"); exit; }

$sum_YBm = @mysql_result($result_YBm,0,0);

$sum_tY1_amount = $sum_YAm - $sum_YBm;
  $sum_tY1_amount_K = number_format($sum_tY1_amount);
  
  echo ("
  <tr height=22>
    <td bgcolor=#EFEFEF colspan=2 style='$BOX_LAIN1'>&nbsp;<b>SALES PROFIT</b></td>
    <td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>$sum_tY1_amount_K&nbsp;</td>") ?>
    
    <?
    // 매월(반복)
    for($m = $m_s; $m <= $m_f; $m++) {

      $mm = sprintf("%02d", $m);
      $this_month_set = "$p_year"."$mm";
      
      
      // Income
      $query_sum_rA = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_catg = 'A1' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_rA = mysql_query($query_sum_rA);
      if (!$result_sum_rA) { error("QUERY_ERROR"); exit; }

      $sum_rA_amount = @mysql_result($result_sum_rA,0,0);
      
      
      // Outgoing
      $query_sum_rB = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_catg = 'B1' AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
      $result_sum_rB = mysql_query($query_sum_rB);
      if (!$result_sum_rB) { error("QUERY_ERROR"); exit; }

      $sum_rB_amount = @mysql_result($result_sum_rB,0,0);
      
      
      $sum_rvm_amount = $sum_rA_amount - $sum_rB_amount;
        $sum_rvm_amount_K = number_format($sum_rvm_amount);

      echo ("<td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>{$sum_rvm_amount_K}&nbsp;</td>");
        
   }
   ?>
   </tr>



<?
// 경상이익

// Yearly
$sum_tR1_amount = $sum_tA1_amount - $sum_tB1_amount;
  $sum_tR1_amount_K = number_format($sum_tR1_amount);
  
  echo ("
  <tr height=22>
    <td bgcolor=#EFEFEF colspan=2 style='$BOX_LAIN1'>&nbsp;<b>NET PROFIT</b></td>
    <td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>$sum_tR1_amount_K&nbsp;</td>"); ?>

    <?
    // 매월(반복)
    for($m = $m_s; $m <= $m_f; $m++) {

      $mm = sprintf("%02d", $m);
      $this_month_set = "$p_year"."$mm";
    
      // Income
      $query_sum_rpA = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_rpA = mysql_query($query_sum_rpA);
      if (!$result_sum_rpA) { error("QUERY_ERROR"); exit; }

      $sum_rpA_amount = @mysql_result($result_sum_rpA,0,0);
      
      
      // Outgoing
      $query_sum_rpB = "SELECT sum(amount) FROM finance 
            WHERE pay_date LIKE '$this_month_set%' AND process = '2'
            AND f_class = 'out' AND currency = 'IDR'"; // Outgoing, IDR
      $result_sum_rpB = mysql_query($query_sum_rpB);
      if (!$result_sum_rpB) { error("QUERY_ERROR"); exit; }

      $sum_rpB_amount = @mysql_result($result_sum_rpB,0,0);
      
      
      $sum_rpvm_amount = $sum_rpA_amount - $sum_rpB_amount;
        $sum_rpvm_amount_K = number_format($sum_rpvm_amount);

      echo ("<td bgcolor=#EFEFEF align=right style='$BOX_LAIN2'>{$sum_rpvm_amount_K}&nbsp;</td>");
    
    
    }
    ?>
</tr>


</table>

