<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td>&nbsp;</td>
  <td align=center>RUPIAH</td>
  <td align=center>USD</td>
</tr>

<?
$p_date_set_F = $p_date_set . "999999";

  // 수익(계)
  $query_sum_tsjRA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND f_class = 'in' AND currency = 'IDR'"; // IDR
  $result_sum_tsjRA = mysql_query($query_sum_tsjRA);
  if (!$result_sum_tsjRA) { error("QUERY_ERROR"); exit; }
  $sum_tsjRA_amount1 = @mysql_result($result_sum_tsjRA,0,0);
  
  // 지출(계)
  $query_sum_tsjRB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND f_class = 'out' AND currency = 'IDR'"; // IDR
  $result_sum_tsjRB = mysql_query($query_sum_tsjRB);
  if (!$result_sum_tsjRB) { error("QUERY_ERROR"); exit; }
  $sum_tsjRB_amount1 = @mysql_result($result_sum_tsjRB,0,0);
  
  // 수익(CASH)
  $query_sum_sjCRA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'IDR'"; // IDR
  $result_sum_sjCRA = mysql_query($query_sum_sjCRA);
  if (!$result_sum_sjCRA) { error("QUERY_ERROR"); exit; }
  $sum_sjCRA_amount1 = @mysql_result($result_sum_sjCRA,0,0);
  
  // 지출(CASH)
  $query_sum_sjCRB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'IDR'"; // IDR
  $result_sum_sjCRB = mysql_query($query_sum_sjCRB);
  if (!$result_sum_sjCRB) { error("QUERY_ERROR"); exit; }
  $sum_sjCRB_amount1 = @mysql_result($result_sum_sjCRB,0,0);

  
  
  // 출력 :: 잔액
  $jan_tsjR_amount1 = $sum_tsjRA_amount1 - $sum_tsjRB_amount1;
    $jan_tsjR_amount1_K = number_format($jan_tsjR_amount1);
  $jan_sjCR_amount1 = $sum_sjCRA_amount1 - $sum_sjCRB_amount1;
    $jan_sjCR_amount1_K = number_format($jan_sjCR_amount1);


  // 수익(계)
  $query_sum_tsjA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND f_class = 'in' AND currency = 'USD'"; // USD
  $result_sum_tsjA = mysql_query($query_sum_tsjA);
  if (!$result_sum_tsjA) { error("QUERY_ERROR"); exit; }
  $sum_tsjA_amount1 = @mysql_result($result_sum_tsjA,0,0);
  
  // 지출(계)
  $query_sum_tsjB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND f_class = 'out' AND currency = 'USD'"; // USD
  $result_sum_tsjB = mysql_query($query_sum_tsjB);
  if (!$result_sum_tsjB) { error("QUERY_ERROR"); exit; }
  $sum_tsjB_amount1 = @mysql_result($result_sum_tsjB,0,0);
  
  // 수익(CASH)
  $query_sum_sjCA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'USD'"; // USD
  $result_sum_sjCA = mysql_query($query_sum_sjCA);
  if (!$result_sum_sjCA) { error("QUERY_ERROR"); exit; }
  $sum_sjCA_amount1 = @mysql_result($result_sum_sjCA,0,0);
  
  // 지출(CASH)
  $query_sum_sjCB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'USD'"; // USD
  $result_sum_sjCB = mysql_query($query_sum_sjCB);
  if (!$result_sum_sjCB) { error("QUERY_ERROR"); exit; }
  $sum_sjCB_amount1 = @mysql_result($result_sum_sjCB,0,0);

  
  
  // 출력 :: 잔액
  $jan_tsj_amount1 = $sum_tsjA_amount1 - $sum_tsjB_amount1;
    $jan_tsj_amount1_K = number_format($jan_tsj_amount1);
  $jan_sjC_amount1 = $sum_sjCA_amount1 - $sum_sjCB_amount1;
    $jan_sjC_amount1_K = number_format($jan_sjC_amount1);
  


  
  echo ("
  <tr>
    <td align=center>계</td>
    <td align=right>$jan_tsjR_amount1_K&nbsp;</td>
    <td align=right>$jan_tsj_amount1_K&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;CASH</td>
    <td align=right>$jan_sjCR_amount1_K&nbsp;</td>
    <td align=right>$jan_sjC_amount1_K&nbsp;</td>
  </tr>
  ");


// 은행 계좌
$query_xbc = "SELECT count(uid) FROM code_bank WHERE userlevel > '0'";
$result_xbc = mysql_query($query_xbc);
$total_xbc = @mysql_result($result_xbc,0,0);

$query_xb = "SELECT bank_code,bank_name FROM code_bank WHERE userlevel > '0' ORDER BY bank_code ASC";
$result_xb = mysql_query($query_xb);

for($xb = 0; $xb < $total_xbc; $xb++) {
    $xb_bank_code = mysql_result($result_xb,$xb,0);
    $xb_bank_name = mysql_result($result_xb,$xb,1);

    // RUPIAH ----------------------------------------------------------------------------- //
    // 수익(계좌)
    $query_sum_fcRA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$xb_bank_code' AND f_class = 'in' AND currency = 'IDR'"; // IDR
    $result_sum_fcRA = mysql_query($query_sum_fcRA);
    if (!$result_sum_fcRA) { error("QUERY_ERROR"); exit; }
  
    $sum_fcRA_amount1 = @mysql_result($result_sum_fcRA,0,0);
    
    // 지출(계좌)
    $query_sum_fcRB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$xb_bank_code' AND f_class = 'out' AND currency = 'IDR'"; // IDR
    $result_sum_fcRB = mysql_query($query_sum_fcRB);
    if (!$result_sum_fcRB) { error("QUERY_ERROR"); exit; }
  
    $sum_fcRB_amount1 = @mysql_result($result_sum_fcRB,0,0);
    
    // 출력 :: 잔액
    $sum_fcR_amount1 = $sum_fcRA_amount1 - $sum_fcRB_amount1;
    $sum_fcR_amount1_K = number_format($sum_fcR_amount1);
    
    
    // USD ----------------------------------------------------------------------------- //
    // 수익(계좌)
    $query_sum_fcA = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$xb_bank_code' AND f_class = 'in' AND currency = 'USD'"; // USD
    $result_sum_fcA = mysql_query($query_sum_fcA);
    if (!$result_sum_fcA) { error("QUERY_ERROR"); exit; }
  
    $sum_fcA_amount1 = @mysql_result($result_sum_fcA,0,0);
    
    // 지출(계좌)
    $query_sum_fcB = "SELECT sum(amount) FROM finance WHERE pay_date <= '$p_date_set_F' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$xb_bank_code' AND f_class = 'out' AND currency = 'USD'"; // USD
    $result_sum_fcB = mysql_query($query_sum_fcB);
    if (!$result_sum_fcB) { error("QUERY_ERROR"); exit; }
  
    $sum_fcB_amount1 = @mysql_result($result_sum_fcB,0,0);
    
    // 출력 :: 잔액
    $sum_fc_amount1 = $sum_fcA_amount1 - $sum_fcB_amount1;
    $sum_fc_amount1_K = number_format($sum_fc_amount1);


  echo ("
  <tr>
    <td>&nbsp;$xb_bank_name</td>
    <td align=right>$sum_fcR_amount1_K&nbsp;</td>
    <td align=right>$sum_fc_amount1_K&nbsp;</td>
  </tr>");

}
?>








</table>
