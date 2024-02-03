<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td>&nbsp;</td>
  <td align=center>영업</td>
  <td align=center>수금</td>
  <td align=center>당일 수금</td>
  <td align=center>미수금</td>
  <td align=center>기타</td>
</tr>


<!----------- 총 합계 // ------------------------------------------------------------->
<?
// 매출금
$query_sum_pys1 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND currency = 'IDR'";
$result_sum_pys1 = mysql_query($query_sum_pys1);
if (!$result_sum_pys1) { error("QUERY_ERROR"); exit; }

$sum_pys1_amount1 = @mysql_result($result_sum_pys1,0,0);
$sum_pys1_amount1_K = number_format($sum_pys1_amount1);

// 수금
$query_sum_pys2 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pys2 = mysql_query($query_sum_pys2);
if (!$result_sum_pys2) { error("QUERY_ERROR"); exit; }

$sum_pys2_amount1 = @mysql_result($result_sum_pys2,0,0);
$sum_pys2_amount1_K = number_format($sum_pys2_amount1);

// 수금 - 당일
$query_sum_pys2D = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_date_set%' AND f_class = 'in' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pys2D = mysql_query($query_sum_pys2D);
if (!$result_sum_pys2D) { error("QUERY_ERROR"); exit; }

$sum_pys2D_amount1 = @mysql_result($result_sum_pys2D,0,0);
$sum_pys2D_amount1_K = number_format($sum_pys2D_amount1);


// 미수금
$query_sum_pys3 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND currency = 'IDR' AND pay_state < '2'";
$result_sum_pys3 = mysql_query($query_sum_pys3);
if (!$result_sum_pys3) { error("QUERY_ERROR"); exit; }

$sum_pys3_amount1 = @mysql_result($result_sum_pys3,0,0);
$sum_pys3_amount1_K = number_format($sum_pys3_amount1);


echo ("
<tr>
  <td align=center>계</td>
  <td align=right>$sum_pys1_amount1_K&nbsp;</td>
  <td align=right>$sum_pys2_amount1_K&nbsp;</td>
  <td align=right>$sum_pys2D_amount1_K&nbsp;</td>
  <td align=right>$sum_pys3_amount1_K&nbsp;</td>
  <td align=right>&nbsp;</td>
</tr>");
?>


<!----------- BEFORE // ------------------------------------------------------------->
<?
$p_lastyear_now = $report_start_date."000000";


// 매출금
$query_sum_pybs1 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date < '$p_lastyear_now' AND f_class = 'in' AND currency = 'IDR'";
$result_sum_pybs1 = mysql_query($query_sum_pybs1);
if (!$result_sum_pybs1) { error("QUERY_ERROR"); exit; }

$sum_pybs1_amount1 = @mysql_result($result_sum_pybs1,0,0);
$sum_pybs1_amount1_K = number_format($sum_pybs1_amount1);

// 수금
$query_sum_pybs2 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date < '$p_lastyear_now' AND f_class = 'in' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pybs2 = mysql_query($query_sum_pybs2);
if (!$result_sum_pybs2) { error("QUERY_ERROR"); exit; }

$sum_pybs2_amount1 = @mysql_result($result_sum_pybs2,0,0);
$sum_pybs2_amount1_K = number_format($sum_pybs2_amount1);

// 미수금
$query_sum_pybs3 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date < '$p_lastyear_now' AND f_class = 'in' AND currency = 'IDR' AND pay_state < '2'";
$result_sum_pybs3 = mysql_query($query_sum_pybs3);
if (!$result_sum_pybs3) { error("QUERY_ERROR"); exit; }

$sum_pybs3_amount1 = @mysql_result($result_sum_pybs3,0,0);
$sum_pybs3_amount1_K = number_format($sum_pybs3_amount1);


echo ("
<tr>
  <td align=center>BEFORE</td>
  <td align=right>$sum_pybs1_amount1_K&nbsp;</td>
  <td align=right>$sum_pybs2_amount1_K&nbsp;</td>
  <td align=right>&nbsp;</td>
  <td align=right>$sum_pybs3_amount1_K&nbsp;</td>
  <td align=right>&nbsp;</td>
</tr>");
?>


<!----------- 매월 합계 // ----------------------------------------------------------->
<?
for($m = $m_s; $m <= $m_f; $m++) {

  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  $this_month_set = "$p_year"."$mm";

// 매출금
$query_sum_pyms1 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$this_month_set%' AND f_class = 'in' AND currency = 'IDR'";
$result_sum_pyms1 = mysql_query($query_sum_pyms1);
if (!$result_sum_pyms1) { error("QUERY_ERROR"); exit; }

$sum_pyms1_amount1 = @mysql_result($result_sum_pyms1,0,0);
$sum_pyms1_amount1_K = number_format($sum_pyms1_amount1);

// 수금
$query_sum_pyms2 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$this_month_set%' AND f_class = 'in' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pyms2 = mysql_query($query_sum_pyms2);
if (!$result_sum_pyms2) { error("QUERY_ERROR"); exit; }

$sum_pyms2_amount1 = @mysql_result($result_sum_pyms2,0,0);
$sum_pyms2_amount1_K = number_format($sum_pyms2_amount1);

// 수금 - 당일
$query_sum_pys2D = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_date_set%' AND f_class = 'in' AND currency = 'IDR' AND pay_state = '2'";
$result_sum_pys2D = mysql_query($query_sum_pys2D);
if (!$result_sum_pys2D) { error("QUERY_ERROR"); exit; }

$sum_pys2D_amount1 = @mysql_result($result_sum_pys2D,0,0);
$sum_pys2D_amount1_K = number_format($sum_pys2D_amount1);

// 미수금
$query_sum_pyms3 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$this_month_set%' AND f_class = 'in' AND currency = 'IDR' AND pay_state < '2'";
$result_sum_pyms3 = mysql_query($query_sum_pyms3);
if (!$result_sum_pyms3) { error("QUERY_ERROR"); exit; }

$sum_pyms3_amount1 = @mysql_result($result_sum_pyms3,0,0);
$sum_pyms3_amount1_K = number_format($sum_pyms3_amount1);

echo ("
<tr>
  <td align=center>{$mm}월</td>
  <td align=right>$sum_pyms1_amount1_K&nbsp;</td>
  <td align=right>$sum_pyms2_amount1_K&nbsp;</td>
  <td align=right></td>
  <td align=right>$sum_pyms3_amount1_K&nbsp;</td>
  <td align=right>&nbsp;</td>
</tr>");
}
?>
</table>
