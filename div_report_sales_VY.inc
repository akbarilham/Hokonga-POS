<?
// 월 최대값(baseline 추출)
if($grpBrc) {
  $query_max = "SELECT baseline FROM client_branch WHERE branch_code = '$grpBrc'";
} else {
  $query_max = "SELECT baseline FROM client_branch WHERE branch_code = 'CORP_01'";
}
$result_max = mysql_query($query_max);
  if (!$result_max) { error("QUERY_ERROR"); exit; }

$max_sales_P = @mysql_result($result_max,0,0);

if(!$max_sales) {
  $max_sales = "10000000";
}

$max_sales_K = number_format($max_sales);

$max_salesH = $max_sales / 2;
$max_salesH_K = number_format($max_salesH);

if($grpBrc) {
    $main_half = "320";
    $main_half2 = "160";
} else {
    $main_half = "200";
    $main_half2 = "100";
}


if($grpBrc) {
echo ("
<table width=100% cellspacing=0 cellpadding=0 style='$style_area'>
<tr>
  <td height=26>&nbsp; <b>$rp_title2_full</b></td>
</tr>
</table>
<br>");
}


// 해당 연도의 매출액 추출
if($grpBrc) {
  if($grpShp) {
    $query_xsdt = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  } else {
    $query_xsdt = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  }
} else {
    $query_xsdt = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR'";
}
$result_xsdt = mysql_query($query_xsdt);
if (!$result_xsdt) { error("QUERY_ERROR"); exit; }

$xsdt_pay_amount = @mysql_result($result_xsdt,0,0);
$xsdt_pay_amount_K = number_format($xsdt_pay_amount);


// 수금완료
if($grpBrc) {
  if($grpShp) {
    $query_xsdt2 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2'";
  } else {
    $query_xsdt2 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2'";
  }
} else {
    $query_xsdt2 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2'";
}
$result_xsdt2 = mysql_query($query_xsdt2);
if (!$result_xsdt2) { error("QUERY_ERROR"); exit; }

$xsdt2_pay_amount = @mysql_result($result_xsdt2,0,0);
$xsdt2_pay_amount_K = number_format($xsdt2_pay_amount);


// 처리중, 미수
if($grpBrc) {
  if($grpShp) {
    $query_xsdt3 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2'";
  } else {
    $query_xsdt3 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2'";
  }
} else {
    $query_xsdt3 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state < '2'";
}
$result_xsdt3 = mysql_query($query_xsdt3);
if (!$result_xsdt3) { error("QUERY_ERROR"); exit; }

$xsdt3_pay_amount = @mysql_result($result_xsdt3,0,0);
$xsdt3_pay_amount_K = number_format($xsdt3_pay_amount);


// cash
if($grpBrc) {
  if($grpShp) {
    $query_xsdt4 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_type != 'credit'";
  } else {
    $query_xsdt4 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_type != 'credit'";
  }
} else {
    $query_xsdt4 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_type != 'credit'";
}
$result_xsdt4 = mysql_query($query_xsdt4);
if (!$result_xsdt4) { error("QUERY_ERROR"); exit; }

$xsdt4_pay_amount = @mysql_result($result_xsdt4,0,0);
$xsdt4_pay_amount_K = number_format($xsdt4_pay_amount);


// cash - 수금완료
if($grpBrc) {
  if($grpShp) {
    $query_xsdt5 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2' AND pay_type != 'credit'";
  } else {
    $query_xsdt5 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2' AND pay_type != 'credit'";
  }
} else {
    $query_xsdt5 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2' AND pay_type != 'credit'";
}
$result_xsdt5 = mysql_query($query_xsdt5);
if (!$result_xsdt5) { error("QUERY_ERROR"); exit; }

$xsdt5_pay_amount = @mysql_result($result_xsdt5,0,0);
$xsdt5_pay_amount_K = number_format($xsdt5_pay_amount);


// cash - 처리중, 미수
if($grpBrc) {
  if($grpShp) {
    $query_xsdt6 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2' AND pay_type != 'credit'";
  } else {
    $query_xsdt6 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2' AND pay_type != 'credit'";
  }
} else {
    $query_xsdt6 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state < '2' AND pay_type != 'credit'";
}
$result_xsdt6 = mysql_query($query_xsdt6);
if (!$result_xsdt6) { error("QUERY_ERROR"); exit; }

$xsdt6_pay_amount = @mysql_result($result_xsdt6,0,0);
$xsdt6_pay_amount_K = number_format($xsdt6_pay_amount);


// credit
if($grpBrc) {
  if($grpShp) {
    $query_xsdt7 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_type = 'credit'";
  } else {
    $query_xsdt7 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_type = 'credit'";
  }
} else {
    $query_xsdt7 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_type = 'credit'";
}
$result_xsdt7 = mysql_query($query_xsdt7);
if (!$result_xsdt7) { error("QUERY_ERROR"); exit; }

$xsdt7_pay_amount = @mysql_result($result_xsdt7,0,0);
$xsdt7_pay_amount_K = number_format($xsdt7_pay_amount);


// credit - 수금완료
if($grpBrc) {
  if($grpShp) {
    $query_xsdt8 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2' AND pay_type = 'credit'";
  } else {
    $query_xsdt8 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state = '2' AND pay_type = 'credit'";
  }
} else {
    $query_xsdt8 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state = '2' AND pay_type = 'credit'";
}
$result_xsdt8 = mysql_query($query_xsdt8);
if (!$result_xsdt8) { error("QUERY_ERROR"); exit; }

$xsdt8_pay_amount = @mysql_result($result_xsdt8,0,0);
$xsdt8_pay_amount_K = number_format($xsdt8_pay_amount);


// credit - 처리중, 미수
if($grpBrc) {
  if($grpShp) {
    $query_xsdt9 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2' AND pay_type = 'credit'";
  } else {
    $query_xsdt9 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                  AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR' 
                  AND pay_state < '2' AND pay_type = 'credit'";
  }
} else {
    $query_xsdt9 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$p_year%' AND f_class = 'in' 
                  AND f_intype = '1' AND currency = 'IDR' AND pay_state < '2' AND pay_type = 'credit'";
}
$result_xsdt9 = mysql_query($query_xsdt9);
if (!$result_xsdt9) { error("QUERY_ERROR"); exit; }

$xsdt9_pay_amount = @mysql_result($result_xsdt9,0,0);
$xsdt9_pay_amount_K = number_format($xsdt9_pay_amount);
?>

<script language="javascript">
<? include "./config/javascript/BalloonHint.js"; ?>
</script>

<div id="balloonHint" style="display:none">
<table width=134 border="0" cellspacing="0" cellpadding=0 bgcolor="#FFFFFF" style="border:1px solid #6699CC">
<tr><td height=24 align=right><font size=2>{{hint}}</font>&nbsp;</td></tr>
</table>
</div>

<script language="javascript">balloonHint("balloonHint")</script>


<? if(!$grpShp AND $vmode == "shop") { ?>

<table width=100% cellspacing=0 cellpadding=0 style="<?=$style_area?>">
<tr>
  <td width=35% height=22 align=right style="BORDER-RIGHT: #CCCCCC 1px solid"><b>Total</b> &nbsp;</td>
  <td>&nbsp; <b><?=$xsdt_pay_amount_K?></b></td>
</tr>

<tr>
<?
echo ("
  <td valign=top align=right style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
  <td valign=top align=right style='BORDER-TOP: #CCCCCC 1px solid; PADDING: 4px;'>");
  
	if($max_sales == "10000000000") {
		echo ("<a href='$link_report&max_sales=10000000000'><u>10,000,000,000</u></a>");
	} else {
		echo ("<a href='$link_report&max_sales=10000000000'>10,000,000,000</a>");
	}
	if($max_sales == "5000000000") {
		echo ("<br><a href='$link_report&max_sales=5000000000'><u>5,000,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=5000000000'>5,000,000,000</a>");
	}
    if($max_sales == "1000000000") {
		echo ("<br><a href='$link_report&max_sales=1000000000'><u>1,000,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=1000000000'>1,000,000,000</a>");
	}
    if($max_sales == "500000000") {
		echo ("<br><a href='$link_report&max_sales=500000000'><u>500,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=500000000'>500,000,000</a>");
	}
    if($max_sales == "100000000") {
		echo ("<br><a href='$link_report&max_sales=100000000'><u>100,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=100000000'>100,000,000</a>");
	}
    if($max_sales == "50000000") {
		echo ("<br><a href='$link_report&max_sales=50000000'><u>50,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=50000000'>50,000,000</a>");
	}
    if($max_sales == "10000000") {
		echo ("<br><a href='$link_report&max_sales=10000000'><u>10,000,000</u></a>");
	} else {
		echo ("<br><a href='$link_report&max_sales=10000000'>10,000,000</a>");
	}
	?>
  </td>
</tr>

  <?
  // 전체 SHOP
  if($grpBrc) {
    $querySS = "SELECT shop_code,shop_name FROM client_shop WHERE branch_code = '$grpBrc' ORDER BY shop_code ASC";
  } else {
    $querySS = "SELECT shop_code,shop_name FROM client_shop ORDER BY shop_code ASC";
  }
  $resultSS = mysql_query($querySS);
    if (!$resultSS) {   error("QUERY_ERROR");   exit; }

  for($S = 0; $S < $tot_shps; $S++) {
    $SS_shop_code = mysql_result($resultSS,$S,0);   
    $SS_shop_name = mysql_result($resultSS,$S,1);
  
  

  // 해당 SHOP의 매출액 추출
  $query_sd1 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$SS_shop_code' 
                AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  $result_sd1 = mysql_query($query_sd1);
  if (!$result_sd1) { error("QUERY_ERROR"); exit; }

  $sd1_pay_amount = @mysql_result($result_sd1,0,0);
  $sd1_pay_amount_K = number_format($sd1_pay_amount);
  
  // 기준 최대값보다 클 수 없음
  if($sd1_pay_amount > $max_sales) {
    $sd1_pay_amount = $max_sales;
  }
  
  if($sd1_pay_amount < "1") {
    $sd1_pay_amount_K2 = "";
  } else {
    $sd1_pay_amount_K2 = $sd1_pay_amount_K;
  }
  
  // 최대값에 대한 백분율
  $sd1_pcnt = ( $sd1_pay_amount / $max_sales ) * 100;
  

  $ddp1 = sprintf("%02d", $sd1_pcnt);
  $ddp2 = 100 - $ddp1;
  
  $ddp1m = ($main_half / 100) * $ddp1;
  
	echo ("
	<tr>
		<td style='BORDER-TOP: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; PADDING: 4px;'>$SS_shop_name</td>
		<td>
			<div class='progress progress-xs'>
            <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='$ddp1m' aria-valuemin='0' aria-valuemax='100' style='width: $ddp1m%'>
                <span class='sr-only'>$ddp1m% Complete</span>
            </div>
            </div>
		</td>
	</tr>");
  
	}
	?>
</table>

<? } else { ?>

<table width=100% cellspacing=0 cellpadding=0 style="<?=$style_area?>">
<tr>
  <td width=130 height=22 align=right style="BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid"><b>Total</b> &nbsp;</td>
  <td colspan="<?=$totaldays2?>" style="BORDER-BOTTOM: #CCCCCC 1px solid;">&nbsp; <b><?=$xsdt_pay_amount_K?></b></td>
  <td style="BORDER-BOTTOM: #CCCCCC 1px solid;">&nbsp;</td>
</tr>
<tr>
  <td valign=top style="BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid">
    <table width=100% cellspacing=0 cellpadding=0 border=0>
    <tr><td height=<?=$main_half2?> align=right valign=top><?=$max_sales_K?>&nbsp;</td></tr>
    <tr><td height=<?=$main_half2?> align=right valign=top><?=$max_salesH_K?>&nbsp;</td></tr>
    </table>
  </td>
  
  <?
  for($m = $m_s; $m <= $m_f; $m++) {
  
  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  $this_month_set = "$p_year"."$mm";
  
  // 해당 월의 매출액 추출
  if($grpBrc) {
    if($grpShp) {
      $query_sd1 = "SELECT sum(pay_amount) FROM shop_payment WHERE shop_code = '$grpShp' AND branch_code = '$grpBrc' 
                    AND pay_date LIKE '$this_month_set%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
    } else {
      $query_sd1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$grpBrc' 
                    AND pay_date LIKE '$this_month_set%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
    }
  } else {
      $query_sd1 = "SELECT sum(pay_amount) FROM shop_payment WHERE pay_date LIKE '$this_month_set%' AND f_class = 'in' 
                    AND f_intype = '1' AND currency = 'IDR'";
  }
  $result_sd1 = mysql_query($query_sd1);
  if (!$result_sd1) { error("QUERY_ERROR"); exit; }

  $sd1_pay_amount = @mysql_result($result_sd1,0,0);
  $sd1_pay_amount_K = number_format($sd1_pay_amount);
  
  // 기준 최대값보다 클 수 없음
  if($sd1_pay_amount > $max_sales) {
    $sd1_pay_amount = $max_sales;
  }
  
  if($sd1_pay_amount < "1") {
    $sd1_pay_amount_K2 = "";
  } else {
    $sd1_pay_amount_K2 = $sd1_pay_amount_K;
  }
  
  // 최대값에 대한 백분율
  $sd1_pcnt = ( $sd1_pay_amount / $max_sales ) * 100;
  

  $ddp1 = sprintf("%02d", $sd1_pcnt);
  $ddp2 = 100 - $ddp1;
  
  $ddp1m = ($main_half / 100) * $ddp1;
  
  
	echo ("
    <td width=2% height=$main_half align=center valign=bottom style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% height=$main_half cellspacing=0 cellpadding=0 border=0>
      <tr><td width=100% height=$ddp2% align=center valign=bottom></td></tr>
      <tr>
        <td width=100% height=$ddp1% align=center valign=bottom>");
          if($ddp1m > 1) {
            echo ("<img src='$home/img/icon/graph_01.gif' width=50% height='$ddp1m' border=0 valign=bottom hint='$sd1_pay_amount_K2'>");
          } echo ("
        </td>
      </tr>
      </table>
    </td>");
  
  }
  
  echo ("
  <td valign=top align=right style='BORDER-BOTTOM: #CCCCCC 1px solid'>
    <br><a href='$link_report&max_sales=10000000000'>10,000,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=5000000000'>5,000,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=1000000000'>1,000,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=500000000'>500,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=100000000'>100,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=50000000'>50,000,000</a>&nbsp;
    <br><a href='$link_report&max_sales=10000000'>10,000,000</a>&nbsp;
    <br>
  
  
  </td>");
  ?>
</tr>


<tr>
  <td align=center height=40><b><?=$p_date?>-<?=$p_month_txt?>-<?=$p_year?></b></td>
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

  
  
  echo ("<td align=center>$mm_txt</td>");
  
  }
  ?>
  <td></td>
</tr>
</table>

<? } ?>





<br>
<? echo ("
<table width=100% cellspacing=0 cellpadding=0 style='$style_area'>
<tr height=22>
   <td width=130 align=center style='BACKGROUND-COLOR: #EFEFEF; BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>&nbsp;</td>
   <td align=center style='BACKGROUND-COLOR: #EFEFEF; BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$txt_sales_sales_16</td>
   <td align=center style='BACKGROUND-COLOR: #EFEFEF; BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$txt_invn_return_04</td>
   <td align=center style='BACKGROUND-COLOR: #EFEFEF; BORDER-BOTTOM: #CCCCCC 1px solid'>$txt_invn_payment_23</td>
</tr>
<tr><td colspan=4 height=2></td></tr>
<tr height=22>
   <td align=center style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Total</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt_pay_amount_K &nbsp;</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt2_pay_amount_K &nbsp;</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid'>$xsdt3_pay_amount_K &nbsp;</td>
</tr>
<tr height=22>
   <td align=center style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>Cash</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt4_pay_amount_K &nbsp;</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt5_pay_amount_K &nbsp;</td>
   <td align=right style='BORDER-BOTTOM: #CCCCCC 1px solid'>$xsdt6_pay_amount_K &nbsp;</td>
</tr>
<tr height=22>
   <td align=center style='BORDER-RIGHT: #CCCCCC 1px solid'>Credit</td>
   <td align=right style='BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt7_pay_amount_K &nbsp;</td>
   <td align=right style='BORDER-RIGHT: #CCCCCC 1px solid'>$xsdt8_pay_amount_K &nbsp;</td>
   <td align=right>$xsdt9_pay_amount_K &nbsp;</td>
</tr>
</table>");?>

<br>


<?
if(!$grpBrc) {
// BRANCHes
$query_x1c = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
$result_x1c = mysql_query($query_x1c);
$total_x1c = @mysql_result($result_x1c,0,0);
  
  
$query_x1 = "SELECT branch_code,branch_name2 FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
$result_x1 = mysql_query($query_x1);

for($x1 = 0; $x1 < $total_x1c; $x1++) {
  $x1_branch_code = mysql_result($result_x1,$x1,0);
  $x1_branch_name = mysql_result($result_x1,$x1,1);
  
  
  // 해당 연도의 매출액 추출
  $query_xsdm = "SELECT sum(pay_amount) FROM shop_payment 
              WHERE branch_code = '$x1_branch_code' AND pay_date LIKE '$p_year%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  $result_xsdm = mysql_query($query_xsdm);
  if (!$result_xsdm) { error("QUERY_ERROR"); exit; }

  $xsdm_pay_amount = @mysql_result($result_xsdm,0,0);
  $xsdm_pay_amount_K = number_format($xsdm_pay_amount);
?>

<br>
<table width=100% cellspacing=0 cellpadding=0 style="<?=$style_area?>">
<tr>
  <td width=130 height=22 style="BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid">&nbsp; <b><?=$x1_branch_name?></b></td>
  <td colspan=12 style="BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid">&nbsp; <b><?=$xsdm_pay_amount_K?></b></td>
  <td style="BORDER-BOTTOM: #CCCCCC 1px solid">&nbsp;</td>
</tr>
<tr>
  <td valign=top style="BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid">
    <table width=100% cellspacing=0 cellpadding=0 border=0>
    <tr><td height=100 align=right valign=top><?=$max_sales_K?>&nbsp;</td></tr>
    <tr><td height=100 align=right valign=top><?=$max_salesH_K?>&nbsp;</td></tr>
    </table>
  </td>
  
  <?
  for($m = $m_s; $m <= $m_f; $m++) {
  
  // 해당 월을 2자리 수자로 표현
  $mm = sprintf("%02d", $m);
  $this_month_set = "$p_year"."$mm";
  
  // 해당 월의 매출액 추출
  $query_xsd1 = "SELECT sum(pay_amount) FROM shop_payment WHERE branch_code = '$x1_branch_code' AND pay_date LIKE '$this_month_set%' AND f_class = 'in' AND f_intype = '1' AND currency = 'IDR'";
  $result_xsd1 = mysql_query($query_xsd1);
  if (!$result_xsd1) { error("QUERY_ERROR"); exit; }

  $xsd1_pay_amount = @mysql_result($result_xsd1,0,0);
  $xsd1_pay_amount_K = number_format($xsd1_pay_amount);
  
  // 기준 최대값보다 클 수 없음
  if($xsd1_pay_amount > $max_sales) {
    $xsd1_pay_amount = $max_sales;
  }
  
  if($xsd1_pay_amount < "1") {
    $xsd1_pay_amount_K2 = "";
  } else {
    $xsd1_pay_amount_K2 = $xsd1_pay_amount_K;
  }
  
  // 최대값에 대한 백분율
  $xsd1_pcnt = ( $xsd1_pay_amount / $max_sales ) * 100;
  

  $xddp1 = sprintf("%02d", $xsd1_pcnt);
  $xddp2 = 100 - $xddp1;
  
  $xddp1m = ($main_half / 100) * $xddp1;
  
  
  echo ("
    <td width=6% height=200 align=center style='BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid'>
      <table width=100% height=200 cellspacing=0 cellpadding=0 border=0>
      <tr><td width=100% height=$xddp2% align=center valign=bottom></td></tr>
      <tr>
        <td width=100% height=$ddp1% align=center valign=bottom>");
          if($xddp1m > 1) {
            echo ("<img src='$home/img/icon/graph_01.gif' width=50% height=$xddp1m border=0 valign=bottom hint='$xsd1_pay_amount_K2'>");
          } echo ("
        </td>
      </tr>
      </table>
    </td>");
  
  }
  ?>
  <td valign=top align=right style='BORDER-BOTTOM: #CCCCCC 1px solid'>&nbsp;</td>
</tr>


<tr>
  <td align=center height=40><b><?=$p_year?></b></td>
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

  
  
  echo ("<td align=center>$mm_txt</td>");
  
  }
  ?>
  <td></td>
</tr>
</table>

<? } } ?>