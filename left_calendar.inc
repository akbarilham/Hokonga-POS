<?
$link_cal_df = "$PHP_SELF?lang=$lang&loco=page_server&mode=$mode&vmode=$vmode&&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";

if(!$mode OR $mode == "sales_VW" OR $mode == "sales_VM" OR $mode == "sales_VQ" OR $mode == "sales_VY") {
  $link_cal_dfD = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VD&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfW = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VW&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfM = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VM&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfQ = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VQ&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfY = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VY&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
} else if($mode == "stock_TD" OR $mode == "stock_TW" OR $mode == "stock_TM" OR $mode == "stock_TQ" OR $mode == "stock_TY") {
  $link_cal_dfD = "$PHP_SELF?lang=$lang&loco=page_server&mode=stock_TD&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfW = "$PHP_SELF?lang=$lang&loco=page_server&mode=stock_TW&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfM = "$PHP_SELF?lang=$lang&loco=page_server&mode=stock_TM&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfQ = "$PHP_SELF?lang=$lang&loco=page_server&mode=stock_TQ&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfY = "$PHP_SELF?lang=$lang&loco=page_server&mode=stock_TY&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
} else if($mode == "expire_TD" OR $mode == "expire_TW" OR $mode == "expire_TM" OR $mode == "expire_TQ" OR $mode == "expire_TY") {
  $link_cal_dfD = "$PHP_SELF?lang=$lang&loco=page_server&mode=expire_TD&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfW = "$PHP_SELF?lang=$lang&loco=page_server&mode=expire_TW&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfM = "$PHP_SELF?lang=$lang&loco=page_server&mode=expire_TM&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfQ = "$PHP_SELF?lang=$lang&loco=page_server&mode=expire_TQ&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfY = "$PHP_SELF?lang=$lang&loco=page_server&mode=expire_TY&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
} else {
  $link_cal_dfD = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VD&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfW = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VW&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfM = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VM&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfQ = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VQ&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
  $link_cal_dfY = "$PHP_SELF?lang=$lang&loco=page_server&mode=sales_VY&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp";
}
?>

<table width=100% border="0" cellspacing="0" cellpadding="0">
<tr>
<td height=16>

		<table width=100% border="0" cellspacing="0" cellpadding="0">
    <tr>
    <?
    // 년도 추출
    $cal_year2 = substr($today,0,4);
		$report_start_year = substr($report_start_date,0,4);
    
    // 달 추출, 달을 2자리 수자로 만들기
		$p_month_D2 = sprintf("%02d", $p_month);
		$cal_month = "$p_year"."$p_month_D2";
		$cal_month2 = substr($today,0,6);
		
		$report_start_month = substr($report_start_date,0,6);
		$rs_year = substr($report_start_date,0,4);
		$rs_month = substr($report_start_date,4,2);
		
		// 분기(5자리) 추출
		if($this_month == "1" OR $this_month == "2" OR $this_month == "3") {
		  $this_qutr = "1";
		} else if($this_month == "4" OR $this_month == "5" OR $this_month == "6") {
		  $this_qutr = "2";
		} else if($this_month == "7" OR $this_month == "8" OR $this_month == "9") {
		  $this_qutr = "3";
		} else if($this_month == "10" OR $this_month == "11" OR $this_month == "12") {
		  $this_qutr = "4";
		}
    $this_yqutr = "$this_year"."$this_qutr";
    
		if($p_month == "1" OR $p_month == "2" OR $p_month == "3") {
		  $p_qutr = "1";
		} else if($p_month == "4" OR $p_month == "5" OR $p_month == "6") {
		  $p_qutr = "2";
		} else if($p_month == "7" OR $p_month == "8" OR $p_month == "9") {
		  $p_qutr = "3";
		} else if($p_month == "10" OR $p_month == "11" OR $p_month == "12") {
		  $p_qutr = "4";
		}
    $cal_yqutr = "$p_year"."$p_qutr";
    
    if($rs_month == "1" OR $rs_month == "2" OR $rs_month == "3") {
		  $rs_qutr = "1";
		} else if($rs_month == "4" OR $rs_month == "5" OR $rs_month == "6") {
		  $rs_qutr = "2";
		} else if($rs_month == "7" OR $rs_month == "8" OR $rs_month == "9") {
		  $rs_qutr = "3";
		} else if($rs_month == "10" OR $rs_month == "11" OR $rs_month == "12") {
		  $rs_qutr = "4";
		}
    $rs_yqutr = "$rs_year"."$rs_qutr";
    
    
    
    
    echo ("
    <td width=16 height=20 align=center><a href='$link_cal_dfM&p_month=$month_prev&p_year=$year_prev'><i class='fa fa-chevron-left'></i></a></td>
    <td align=center>");
		
    // 이달 이후의 월은 링크를 해제
		if($cal_month > $cal_month2 OR $cal_month < $report_start_month) {
      echo("$p_month -&nbsp;");
    } else {
      echo("<a href='$link_cal_dfM&p_month=$p_month&p_year=$p_year'><u>$p_month</u></a> -&nbsp;");
    }
    
    // 분기
    if($cal_yqutr > $this_yqutr OR $cal_yqutr < $rs_yqutr) {
      echo("[ $p_qutr/4 ] -&nbsp;</a>");
    } else {
      echo("<a href='$link_cal_dfQ&p_month=$p_month&p_year=$p_year&p_quarter=$cal_yqutr'>[ <u>$p_qutr/4</u> ] -&nbsp;</a>");
    }
    
    // 금년 이후의 연도는 링크를 해제
    if($p_year > $cal_year2 OR $p_year < $report_start_year) {
      echo("$p_year");
    } else {
      echo("<a href='$link_cal_dfY&p_month=$p_month&p_year=$p_year'><u>$p_year</u></a>");
    }
    
    echo ("
      </td>
    <td width=16 align=center><a href='$link_cal_dfM&p_month=$month_next&p_year=$year_next'><i class='fa fa-chevron-right'></i></a></td>");
    ?>
    </tr>
    </table>

</td>
</tr>

<tr><td height="2"></td></tr>

<tr>
<td>

<!----------------- callendar BODY // ----------------------------------------------------------------------------------------------------------------->

<table width=100% border="0" cellspacing="0" cellpadding="0">

<?
// ============================ SHOW CALENDAR ========================================= //

	echo ("
	<tr><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>
	<tr align=center height=18>
		<td align=center><font color='#DE2E67'>S</font></td>
		<td align=center>M</td>
		<td align=center>T</td>
		<td align=center>W</td>
		<td align=center>T</td>
		<td align=center>F</td>
		<td align=center><font color='#247DA6'>S</font></td>
		<td align=center></td>
	</tr>
	<tr><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>
	<tr><td colspan=8 height=2></td></tr>

	");

	echo ("<tr height=16 align=center>");

	$col = 0;
	for($i = 0; $i < $first_day; $i++) { // 공백 칸 출력
		echo (" <td></td> ");
		$col++;
	}


	for($j = 1; $j <= $totaldays; $j++) {

		//======= 오늘 날짜 구하기 =============================//

			// 달과 날짜를 2자리 수자로 만들기
			$d_month = sprintf("%02d", $p_month);
			$d_j = sprintf("%02d", $j);
			$cal_date = "{$p_year}{$d_month}{$d_j}"; // 총 8자리 수자조합

		//======= 오늘날짜 셀 배경색 설정을 위한 정의 ============//

		if($p_date == $j) {
			$bgcolor_today = "#EEEE99";
		} else {
			$bgcolor_today = "";
		}

		//======= 토/일요일 날짜색 지정하기 =======================//

		if($col == 0) {
			$font_sunday = "<font color='#DE2E67'>";
		} else if($col == 6) {
			$font_sunday = "<font color='#247DA6'>";
		} else {
			$font_sunday = "<font color='black'>";
		}
		
		//======= 날짜 보여주기 =================================//
		

		  echo ("<td align=center height=16 class=\"calendar01\" bgcolor='$bgcolor_today'>");
		  
		  // 오늘 이후의 날짜는 링크를 해제
		  if($cal_date > $today OR $cal_date < $report_start_date) {
		    echo ("{$font_sunday}$j</font></td>");
		  } else {
		    echo ("<a href=\"$link_cal_dfD&p_year=$p_year&p_month=$p_month&p_date=$j&p_date_set=$cal_date\"><u>{$font_sunday}$j</font></u></a></td>");
		  }
		  
		// 주간 리포트를 위한 리포트 시작일과 종료일
		$j1 = $j - 6;
		$j2 = $j;
		
		if($j1 < 0) { // 전달의 날 수
		  $j1s = $totaldays_AA + $j1 + 1;
		} else {
		  $j1s = $j1;
		}
		
		// 달과 날짜를 2자리 수자로 만들기
		$d_month_AA = sprintf("%02d", $p_month_AA);
		$d_j_AA = sprintf("%02d", $j1s);
			
		$p_date_setA = "$p_year_AA"."$d_month_AA"."$d_j_AA";
		
		if($col == 6) {
		  // 오늘 이후의 날짜는 링크를 해제
		  if($cal_date > $today OR $cal_date < $report_start_date) {
		    echo ("<td align=center height=16>$j1s~$j2</td>");
		  } else {
		    echo ("<td align=center height=16><a href=\"$link_cal_dfW&p_year=$p_year&p_month=$p_month&p_date=$j&w_date_setA=$p_date_setA&w_date_setB=$cal_date\"><u>$j1s~$j2</u></a></td>");
		  }
		}

		$col++;


	if($col == 7) {
		echo (" </tr> ");
		if($j != $totaldays) { echo(" <tr> "); }
		$col = 0;
	}
}

while($col > 0 AND $col < 7) {
	echo (" <td height=16></td> ");
	$col++;
}

?>

</tr>
<tr><td colspan=8 height=2></td></tr>
<tr><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>
</table>
<!----------------- // callendar BODY ----------------------------------------------------------------------------------------------------------------->

</td>
</tr>
</table>

