<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td>&nbsp;</td>
  <td align=center>매입수량</td>
  <td align=center>매입금</td>
  <td align=center>지불금</td>
  <td align=center>미지불금</td>
</tr>

<!----------- 총 합계 // ------------------------------------------------------------->
<?
// 매입금
$query_sum_ps1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$p_year%' AND f_class = 'out' AND currency = 'IDR'";
$result_sum_ps1 = mysql_query($query_sum_ps1);
if (!$result_sum_ps1) { error("QUERY_ERROR"); exit; }

$sum_ps1_amount1 = @mysql_result($result_sum_ps1,0,0);
$sum_ps1_amount1_K = number_format($sum_ps1_amount1);

// 지불금
$query_sum_ps2 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$p_year%' AND f_class = 'out' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_ps2 = mysql_query($query_sum_ps2);
if (!$result_sum_ps2) { error("QUERY_ERROR"); exit; }

$sum_ps2_amount1 = @mysql_result($result_sum_ps2,0,0);
$sum_ps2_amount1_K = number_format($sum_ps2_amount1);

// 미지불금
$query_sum_ps3 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$p_year%' AND f_class = 'out' AND currency = 'IDR' AND pay_state < '2'";
$result_sum_ps3 = mysql_query($query_sum_ps3);
if (!$result_sum_ps3) { error("QUERY_ERROR"); exit; }

$sum_ps3_amount1 = @mysql_result($result_sum_ps3,0,0);
$sum_ps3_amount1_K = number_format($sum_ps3_amount1);

echo ("
<tr>
  <td align=center>계</td>
  <td align=right></td>
  <td align=right>$sum_ps1_amount1_K&nbsp;</td>
  <td align=right>$sum_ps2_amount1_K&nbsp;</td>
  <td align=right>$sum_ps3_amount1_K&nbsp;</td>
</tr>");


?>  

<!----------- 매월 합계 // ----------------------------------------------------------->
<?
for($m = $m_s; $m <= $m_f; $m++) {

  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  $this_month_set = "$p_year"."$mm";

// 매입금
$query_sum_pms1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$this_month_set%' AND f_class = 'out' AND currency = 'IDR'";
$result_sum_pms1 = mysql_query($query_sum_pms1);
if (!$result_sum_pms1) { error("QUERY_ERROR"); exit; }

$sum_pms1_amount1 = @mysql_result($result_sum_pms1,0,0);
$sum_pms1_amount1_K = number_format($sum_pms1_amount1);

// 지불금
$query_sum_pms2 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$this_month_set%' AND f_class = 'out' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pms2 = mysql_query($query_sum_pms2);
if (!$result_sum_pms2) { error("QUERY_ERROR"); exit; }

$sum_pms2_amount1 = @mysql_result($result_sum_pms2,0,0);
$sum_pms2_amount1_K = number_format($sum_pms2_amount1);

// 미지불금
$query_sum_pms3 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$login_branch' 
                AND pay_date LIKE '$this_month_set%' AND f_class = 'out' AND currency = 'IDR' AND pay_state < '2'";
$result_sum_pms3 = mysql_query($query_sum_pms3);
if (!$result_sum_pms3) { error("QUERY_ERROR"); exit; }

$sum_pms3_amount1 = @mysql_result($result_sum_pms3,0,0);
$sum_pms3_amount1_K = number_format($sum_pms3_amount1);

echo ("
<tr>
  <td align=center>{$mm}월</td>
  <td align=right></td>
  <td align=right>$sum_pms1_amount1_K&nbsp;</td>
  <td align=right>$sum_pms2_amount1_K&nbsp;</td>
  <td align=right>$sum_pms3_amount1_K&nbsp;</td>
</tr>");
}
?>
</table>
