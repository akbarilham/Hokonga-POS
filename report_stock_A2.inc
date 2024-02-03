<table width=100% cellspacing=0 cellpadding=0 border=1 bordercolor=#777777>
<tr height=22>
  <td colspan=2 align=center>&nbsp;</td>
  <td align=center>계</td>
  <td align=center>계약</td>
  <td align=center>Free</td>
  <td align=center>기타</td>
</tr>


<tr>
  <td rowspan=3 >&nbsp;LOCAL</td>
  <td>&nbsp;KIDS</td>
  <td align=right>&nbsp;</td>
  <td align=right>&nbsp;</td>
  <td align=right>&nbsp;</td>
  <td align=right>&nbsp;</td>
</tr>

<tr>
  <td>&nbsp;FEMALE</td>
  
  <?
  $p_date_set2 = $p_date_set."235959";
  $signdate2 = time('$p_date_set2');
  
  // FEMALE
  $query_sum_mod1 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'F' AND signdate <= $signdate2";
  $result_sum_mod1 = mysql_query($query_sum_mod1);
  if (!$result_sum_mod1) { error("QUERY_ERROR"); exit; }

  $cnt_mod1 = @mysql_result($result_sum_mod1,0,0);
  
  $query_sum_mod2 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'F' AND model_type = '1' AND signdate <= $signdate2"; // 계약직
  $result_sum_mod2 = mysql_query($query_sum_mod2);
  if (!$result_sum_mod2) { error("QUERY_ERROR"); exit; }

  $cnt_mod2 = @mysql_result($result_sum_mod2,0,0);
  
  $query_sum_mod3 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'F' AND model_type = '2' AND signdate <= $signdate2"; // FREELANCER
  $result_sum_mod3 = mysql_query($query_sum_mod3);
  if (!$result_sum_mod3) { error("QUERY_ERROR"); exit; }

  $cnt_mod3 = @mysql_result($result_sum_mod3,0,0);

  echo ("
  <td align=right>$cnt_mod1&nbsp;</td>
  <td align=right>$cnt_mod2&nbsp;</td>
  <td align=right>$cnt_mod3&nbsp;</td>
  <td align=right>&nbsp;</td>");
  ?>
</tr>

<tr>
  <td>&nbsp;MALE</td>
  
  <?
  // MALE
  $query_sum_mod5 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'M' AND signdate <= $signdate2";
  $result_sum_mod5 = mysql_query($query_sum_mod5);
  if (!$result_sum_mod5) { error("QUERY_ERROR"); exit; }

  $cnt_mod5 = @mysql_result($result_sum_mod5,0,0);
  
  $query_sum_mod6 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'M' AND model_type = '1' AND signdate <= $signdate2"; // 계약직
  $result_sum_mod6 = mysql_query($query_sum_mod6);
  if (!$result_sum_mod6) { error("QUERY_ERROR"); exit; }

  $cnt_mod6 = @mysql_result($result_sum_mod6,0,0);
  
  $query_sum_mod7 = "SELECT count(uid) FROM catalog_model WHERE branch_code = '$login_branch' 
      AND gender = 'M' AND model_type = '2' AND signdate <= $signdate2"; // FREELANCER
  $result_sum_mod7 = mysql_query($query_sum_mod7);
  if (!$result_sum_mod7) { error("QUERY_ERROR"); exit; }

  $cnt_mod7 = @mysql_result($result_sum_mod7,0,0);

  echo ("
  <td align=right>$cnt_mod5&nbsp;</td>
  <td align=right>$cnt_mod6&nbsp;</td>
  <td align=right>$cnt_mod7&nbsp;</td>
  <td align=right>&nbsp;</td>");
  ?>
</tr>
</table>
