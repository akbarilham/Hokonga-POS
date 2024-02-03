<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td colspan=2 width=16% align=center>&nbsp;</td>
  <td width=14% align=center><b>TOTAL</b></td>
  
  <?
  // client_code 추출
  $query_P1 = "SELECT count(uid) FROM client_supplier WHERE  userlevel > '0'";
  $result_P1 = mysql_query($query_P1,$dbconn);
  if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
  $total_P1ss = @mysql_result($result_P1,0,0);
      
  $query_P2 = "SELECT uid,supp_code,supp_name FROM client_supplier 
              WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_P2 = mysql_query($query_P2,$dbconn);
  if (!$result_P2) { error("QUERY_ERROR"); exit; }   

  for($p = 0; $p < $total_P1ss; $p++) {
    $supp_uid = mysql_result($result_P2,$p,0);
    $supp_code = mysql_result($result_P2,$p,1);
    $supp_name = mysql_result($result_P2,$p,2);
  
    echo ("<td align=center>$supp_name</td>");
  
  
  }
  ?>
</tr>

<!------------------- 연 합계 // ------------------------------------------->
<tr height=22>
  <td rowspan=4 bgcolor=#EFEFEF width=6% align=center><b><?=$p_year?></b></td>
  <td bgcolor=#EFEFEF width=10%>&nbsp;QUANTITY</td>
  
  <?
  // 합계
  $query_tm1 = "SELECT sum(qty) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_date LIKE '$p_year%'";
  $result_tm1 = mysql_query($query_tm1);
  $tm1_qty = @mysql_result($result_tm1,0,0);

  $tm1_qty_K = number_format($tm1_qty);
  
  echo ("<td bgcolor=#EFEFEF align=right>{$tm1_qty_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PV1 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PV1 = mysql_query($query_PV1,$dbconn);
  if (!$result_PV1) { error("QUERY_ERROR"); exit; }   

  for($pv1 = 0; $pv1 < $total_P1ss; $pv1++) {
    $pv1_supp_code = mysql_result($result_PV1,$pv1,0);
    
    $query_sm1 = "SELECT sum(qty) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pv1_supp_code' AND pay_date LIKE '$p_year%'";
    $result_sm1 = mysql_query($query_sm1);
    $sm1_qty = @mysql_result($result_sm1,0,0);

    $sm1_qty_K = number_format($sm1_qty);
  
    echo ("<td bgcolor=#EFEFEF align=right>{$sm1_qty_K}&nbsp;</td>");
  }
  ?>
</tr>

<tr height=22>
  <td bgcolor=#EFEFEF>&nbsp;AMOUNT</td>
  
  <?
  // 합계
  $query_tm2 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_date LIKE '$p_year%'";
  $result_tm2 = mysql_query($query_tm2);
  $tm2_pay_amount = @mysql_result($result_tm2,0,0);

  $tm2_pay_amount_K = number_format($tm2_pay_amount);
  
  echo ("<td bgcolor=#EFEFEF align=right>{$tm2_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PV2 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PV2 = mysql_query($query_PV2,$dbconn);
  if (!$result_PV2) { error("QUERY_ERROR"); exit; }   

  for($pv2 = 0; $pv2 < $total_P1ss; $pv2++) {
    $pv2_supp_code = mysql_result($result_PV2,$pv2,0);
    
    $query_sm2 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pv2_supp_code' AND pay_date LIKE '$p_year%'";
    $result_sm2 = mysql_query($query_sm2);
    $sm2_pay_amount = @mysql_result($result_sm2,0,0);

    $sm2_pay_amount_K = number_format($sm2_pay_amount);
  
    echo ("<td bgcolor=#EFEFEF align=right>{$sm2_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>



<tr height=22>
  <td bgcolor=#EFEFEF>&nbsp;PAY</td>
  
  <?
  // 합계
  $query_tm3 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_state = '2' AND pay_date LIKE '$p_year%'";
  $result_tm3 = mysql_query($query_tm3);
  $tm3_pay_amount = @mysql_result($result_tm3,0,0);

  $tm3_pay_amount_K = number_format($tm3_pay_amount);
  
  echo ("<td bgcolor=#EFEFEF align=right>{$tm3_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PV3 = "SELECT supp_code FROM client_supplier 
              WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PV3 = mysql_query($query_PV3,$dbconn);
  if (!$result_PV3) { error("QUERY_ERROR"); exit; }   

  for($pv3 = 0; $pv3 < $total_P1ss; $pv3++) {
    $pv3_supp_code = mysql_result($result_PV3,$pv3,0);
    
    $query_sm3 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pv3_supp_code' AND pay_state = '2' AND pay_date LIKE '$p_year%'";
    $result_sm3 = mysql_query($query_sm3);
    $sm3_pay_amount = @mysql_result($result_sm3,0,0);

    $sm3_pay_amount_K = number_format($sm3_pay_amount);
  
    echo ("<td bgcolor=#EFEFEF align=right>{$sm3_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>

<tr height=22>
  <td bgcolor=#EFEFEF>&nbsp;UNCOLLECTED</td>
  
  <?
  // 합계
  $query_tm4 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_state < '2' AND pay_date LIKE '$p_year%'";
  $result_tm4 = mysql_query($query_tm4);
  $tm4_pay_amount = @mysql_result($result_tm4,0,0);

  $tm4_pay_amount_K = number_format($tm4_pay_amount);
  
  echo ("<td bgcolor=#EFEFEF align=right>{$tm4_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PV4 = "SELECT supp_code FROM client_supplier 
              WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PV4 = mysql_query($query_PV4,$dbconn);
  if (!$result_PV4) { error("QUERY_ERROR"); exit; }   

  for($pv4 = 0; $pv4 < $total_P1ss; $pv4++) {
    $pv4_supp_code = mysql_result($result_PV4,$pv4,0);
    
    $query_sm4 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pv4_supp_code' AND pay_state < '2' AND pay_date LIKE '$p_year%'";
    $result_sm4 = mysql_query($query_sm4);
    $sm4_pay_amount = @mysql_result($result_sm4,0,0);

    $sm4_pay_amount_K = number_format($sm4_pay_amount);
  
    echo ("<td bgcolor=#EFEFEF align=right>{$sm4_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>



<!----------- 매월 합계 // ----------------------------------------------------------->
<?
for($m = $m_s; $m <= $m_f; $m++) {

  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  $this_month_set = "$p_year"."$mm";
  
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
  ?>
  
  
<tr height=22>
  <td rowspan=4 width=6% align=center><b><?=$mm_txt?></b></td>
  <td width=10%>&nbsp;QUANTITY</td>
  
  <?
  // 합계
  $query_td1 = "SELECT sum(qty) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_date LIKE '$this_month_set%'";
  $result_td1 = mysql_query($query_td1);
  $td1_qty = @mysql_result($result_td1,0,0);

  $td1_qty_K = number_format($td1_qty);
  
  echo ("<td align=right>{$td1_qty_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PVd1 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PVd1 = mysql_query($query_PVd1,$dbconn);
  if (!$result_PVd1) { error("QUERY_ERROR"); exit; }   

  for($pvd1 = 0; $pvd1 < $total_P1ss; $pvd1++) {
    $pvd1_supp_code = mysql_result($result_PVd1,$pvd1,0);
    
    $query_sd1 = "SELECT sum(qty) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pvd1_supp_code' AND pay_date LIKE '$this_month_set%'";
    $result_sd1 = mysql_query($query_sd1);
    $sd1_qty = @mysql_result($result_sd1,0,0);

    $sd1_qty_K = number_format($sd1_qty);
  
    echo ("<td align=right>{$sd1_qty_K}&nbsp;</td>");
  }
  ?>
</tr>

<tr height=22>
  <td>&nbsp;AMOUNT</td>
  
  <?
  // 합계
  $query_td2 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_date LIKE '$this_month_set%'";
  $result_td2 = mysql_query($query_td2);
  $td2_pay_amount = @mysql_result($result_td2,0,0);

  $td2_pay_amount_K = number_format($td2_pay_amount);
  
  echo ("<td align=right>{$td2_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PVd2 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PVd2 = mysql_query($query_PVd2,$dbconn);
  if (!$result_PVd2) { error("QUERY_ERROR"); exit; }   

  for($pvd2 = 0; $pvd2 < $total_P1ss; $pvd2++) {
    $pvd2_supp_code = mysql_result($result_PVd2,$pvd2,0);
    
    $query_sd2 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pvd2_supp_code' AND pay_date LIKE '$this_month_set%'";
    $result_sd2 = mysql_query($query_sd2);
    $sd2_pay_amount = @mysql_result($result_sd2,0,0);

    $sd2_pay_amount_K = number_format($sd2_pay_amount);
  
    echo ("<td align=right>{$sd2_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>



<tr height=22>
  <td>&nbsp;PAY</td>
  
  <?
  // 합계
  $query_td3 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_state = '2' AND pay_date LIKE '$this_month_set%'";
  $result_td3 = mysql_query($query_td3);
  $td3_pay_amount = @mysql_result($result_td3,0,0);

  $td3_pay_amount_K = number_format($td3_pay_amount);
  
  echo ("<td align=right>{$td3_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PVd3 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PVd3 = mysql_query($query_PVd3,$dbconn);
  if (!$result_PVd3) { error("QUERY_ERROR"); exit; }   

  for($pvd3 = 0; $pvd3 < $total_P1ss; $pvd3++) {
    $pvd3_supp_code = mysql_result($result_PVd3,$pvd3,0);
    
    $query_sd3 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pvd3_supp_code' AND pay_state = '2' AND pay_date LIKE '$this_month_set%'";
    $result_sd3 = mysql_query($query_sd3);
    $sd3_pay_amount = @mysql_result($result_sd3,0,0);

    $sd3_pay_amount_K = number_format($sd3_pay_amount);
  
    echo ("<td align=right>{$sd3_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>

<tr height=22>
  <td>&nbsp;UNCOLLECTED</td>
  
  <?
  // 합계
  $query_td4 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                AND pay_state < '2' AND pay_date LIKE '$this_month_set%'";
  $result_td4 = mysql_query($query_td4);
  $td4_pay_amount = @mysql_result($result_td4,0,0);

  $td4_pay_amount_K = number_format($td4_pay_amount);
  
  echo ("<td align=right>{$td4_pay_amount_K}&nbsp;</td>");

  // 공급사별 합계
  $query_PVd4 = "SELECT supp_code FROM client_supplier WHERE  userlevel > '0' ORDER BY supp_code ASC";
  $result_PVd4 = mysql_query($query_PVd4,$dbconn);
  if (!$result_PVd4) { error("QUERY_ERROR"); exit; }   

  for($pvd4 = 0; $pvd4 < $total_P1ss; $pvd4++) {
    $pvd4_supp_code = mysql_result($result_PVd4,$pvd4,0);
    
    $query_sd4 = "SELECT sum(pay_amount) FROM shop_payment WHERE f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                      AND client_code = '$pvd4_supp_code' AND pay_state < '2' AND pay_date LIKE '$this_month_set%'";
    $result_sd4 = mysql_query($query_sd4);
    $sd4_pay_amount = @mysql_result($result_sd4,0,0);

    $sd4_pay_amount_K = number_format($sd4_pay_amount);
  
    echo ("<td align=right>{$sd4_pay_amount_K}&nbsp;</td>");
  }
  ?>
</tr>





<?
}
?>
</table>

