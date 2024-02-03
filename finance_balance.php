<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "finance_balance";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/table-responsive.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
	
	<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
if(!$sorting_key) { $sorting_key = "shop"; }
if($sorting_key == "bank") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "field") { $chk2 = "selected"; } else { $chk2 = ""; }



// 기산일: $report_start_date
$report_start_date = "20140101";

$rs_year = substr($report_start_date,0,4);
$rs_month = substr($report_start_date,4,2);
$rs_date = substr($report_start_date,6,2);


  // 오늘 날짜
  $signdate = time();

  // 오늘 날짜를 년월일별로 구하기
  $today = date("Ymd");
  $this_year = date("Y");
  $this_month = date("m");
  $this_yearmonth = date("ym");
  $this_date = date("d");
  $this_week = date("D");
	      
  if(!$p_date_set) { $p_date_set = date("Ymd",$signdate); }

  if(!$p_year) { $p_year = date("Y",$signdate); }
  if(!$p_yearmonth) { $p_yearmonth = date("Ym",$signdate); }
  if(!$p_month) { $p_month = date("m",$signdate); }
  if(!$p_date) { $p_date = date("d",$signdate); }
  if(!$p_hour) { $p_hour = date("H",$signdate); }

  // 해당 연월일 계산 함수
  function get_totaldays ($p_year, $p_month) {
		$p_date =1;
		while(checkdate($p_month, $p_date, $p_year)) {
		$p_date++;
	}
	
	$p_date--;
	return $p_date;
	}

	// 선택한 월의 총 일수를 구함.
		$totaldays = get_totaldays($p_year,$p_month);

	// 선택한 월의 1일의 요일을 구함. 일요일은 0.
		$first_day = date('w', mktime(0,0,0,$p_month,1,$p_year));

	// 윤년 확인
		if($p_month==2){
		if(!($p_year%4))$totaldays++;
		if(!($p_year%100))$totaldays--;
		if(!($p_year%400))$totaldays++;
		}



$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_read = "$home/finance_balance.php";




// 리스트 범위
if($login_level > "2") {
  $sorting_filter_P = "branch_code = '$login_branch'";
  $sorting_filter_G = "branch_code = '$login_branch'";
  $sorting_filter_W = "branch_code = '$login_branch' AND userlevel < '6'";
} else {
  $sorting_filter_P = "branch_code = '$login_branch' AND gate = '$login_gate'";
  $sorting_filter_G = "branch_code = '$login_branch' AND gate = '$login_gate'";
  $sorting_filter_W = "branch_code = '$login_branch' AND client_id = '$login_gate'";
}
?>
    

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$title_module_0906?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			
	
	<div class='col-sm-2'>
	<?
	// 월 반복 (기산월로부터 이달까지)
    
    if($rs_year == $this_year) {
      $m_s = $rs_month;
      $m_f = $this_month;
    } else {
    if($p_year == $this_year) {
      $m_s = 1;
      $m_f = $this_month;
    } else {
      $m_s = $rs_month;
      $m_f = 12;
    }
    }
    
    echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

    for($m = $m_s; $m <= $m_f; $m++) {

      // 해당 월을 2자리 수자로 표현
      $mm = sprintf("%02d", $m);
      $this_month_set = "$p_year"."$mm";
      
      if($mm == $p_month) {
        echo ("<option value='$PHP_SELF?p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set' selected>$mm</a></option>");
      } else {
        echo ("<option value='$PHP_SELF?p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set'>$mm</a></option>");
      }
    
    }
    
    echo ("</select>");
	?>
	</div>
	
	<div class='col-sm-2'>

	<?
    // 연 반복 (기산년부터 금년까지)
    $yy_s = $rs_year;
    $yy_f = $this_year;
    
    echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
  
    for($yy = $yy_s; $yy <= $yy_f; $yy++) {

      if($p_year == $yy) {
        echo ("<option value='$PHP_SELF?p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$yy</a></option>");
      } else {
        echo ("<option value='$PHP_SELF?p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth'>$yy</a></option>");
      }

    }
    
    echo ("</select>");
	?>
	
	</div>
	
	<div class='col-sm-5'></div>
			
			<?
			echo ("
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=shop'>&nbsp; Shops</option>
			<option value='$PHP_SELF?sorting_key=bank' $chk1>&nbsp; $txt_invn_payment_10</option>
			<option value='$PHP_SELF?sorting_key=field' $chk2>&nbsp; $txt_fin_balance_06</option>
			</select>");
			
			// 날짜의 시작과 종료
			$d_s = 1;
			$d_f = $p_date;
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Category</th>
            <th>Date</th>
			<th colspan=2><?=$txt_fin_balance_01?></th>
			<th colspan=2><?=$txt_fin_balance_02?></th>
			<th colspan=2><?=$txt_fin_balance_03?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<tr>
			<td colspan=2>&nbsp;</td>
			<td>IDR</td>
			<td>USD</td>
			<td>IDR</td>
			<td>USD</td>
			<td>IDR</td>
			<td>USD</td>
		</tr>



		
<?
// 해당 월
  $full_month_set = "$p_year"."$p_month";

// 합계 구하기
  $query_tsum1 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
  $result_sum1 = mysql_query($query_tsum1);
  if (!$result_sum1) { error("QUERY_ERROR"); exit; }

  $sum_pay_tamount1 = @mysql_result($result_sum1,0,0);
  $sum_pay_tamount1_K = number_format($sum_pay_tamount1);

  $query_tsum2 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_class = 'in' AND currency = 'USD'"; // Income, USD
  $result_sum2 = mysql_query($query_tsum2);
  if (!$result_sum2) { error("QUERY_ERROR"); exit; }

  $sum_pay_tamount2 = @mysql_result($result_sum2,0,0);
  $sum_pay_tamount2_K = number_format($sum_pay_tamount2);
  
  $query_tsum3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
  $result_sum3 = mysql_query($query_tsum3);
  if (!$result_sum3) { error("QUERY_ERROR"); exit; }

  $sum_pay_tamount3 = @mysql_result($result_sum3,0,0);
  $sum_pay_tamount3_K = number_format($sum_pay_tamount3);

  $query_tsum4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
  $result_sum4 = mysql_query($query_tsum4);
  if (!$result_sum4) { error("QUERY_ERROR"); exit; }

  $sum_pay_tamount4 = @mysql_result($result_sum4,0,0);
  $sum_pay_tamount4_K = number_format($sum_pay_tamount4);
  
  // 이익 (수익 - 지출)
  $sum_pay_tsaldo_IDR = $sum_pay_tamount1 - $sum_pay_tamount3;
  $sum_pay_tsaldo_IDR_K = number_format($sum_pay_tsaldo_IDR);
  
  $sum_pay_tsaldo_USD = $sum_pay_tamount2 - $sum_pay_tamount4;
  $sum_pay_tsaldo_USD_K = number_format($sum_pay_tsaldo_USD);


  
  // 누적합계
  $query_taccsum1 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND process = '2'
                AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
  $result_taccsum1 = mysql_query($query_taccsum1);
  if (!$result_taccsum1) { error("QUERY_ERROR"); exit; }

  $sum_pay_taccamount1 = @mysql_result($result_taccsum1,0,0);
  $sum_pay_taccamount1_K = number_format($sum_pay_taccamount1);

  $query_taccsum2 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND process = '2'
                AND f_class = 'in' AND currency = 'USD'"; // Income, USD
  $result_taccsum2 = mysql_query($query_taccsum2);
  if (!$result_taccsum2) { error("QUERY_ERROR"); exit; }

  $sum_pay_taccamount2 = @mysql_result($result_taccsum2,0,0);
  $sum_pay_taccamount2_K = number_format($sum_pay_taccamount2);
  
  $query_taccsum3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND process = '2'
                AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
  $result_taccsum3 = mysql_query($query_taccsum3);
  if (!$result_taccsum3) { error("QUERY_ERROR"); exit; }

  $sum_pay_taccamount3 = @mysql_result($result_taccsum3,0,0);
  $sum_pay_taccamount3_K = number_format($sum_pay_taccamount3);

  $query_taccsum4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND process = '2'
                AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
  $result_taccsum4 = mysql_query($query_taccsum4);
  if (!$result_taccsum4) { error("QUERY_ERROR"); exit; }

  $sum_pay_taccamount4 = @mysql_result($result_taccsum4,0,0);
  $sum_pay_taccamount4_K = number_format($sum_pay_taccamount4);
  
  
  $sum_pay_taccsaldo_IDR = $sum_pay_taccamount1 - $sum_pay_taccamount3;
  $sum_pay_taccsaldo_IDR_K = number_format($sum_pay_taccsaldo_IDR);
  
  $sum_pay_taccsaldo_USD = $sum_pay_taccamount2 - $sum_pay_taccamount4;
  $sum_pay_taccsaldo_USD_K = number_format($sum_pay_taccsaldo_USD);
  

  echo ("
  <tr height=22>
    <td colspan=2 align=center bgcolor=#FFFFFF><font color=#000000>$txt_fin_balance_04</font></td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccamount1_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccamount2_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccamount3_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccamount4_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccsaldo_IDR_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_taccsaldo_USD_K</font>&nbsp;</td>
  </tr>
  
  <tr height=22>
    <td colspan=2 align=center bgcolor=#FFFFFF><font color=#000000>$txt_fin_balance_05</font></td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tamount1_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tamount2_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tamount3_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tamount4_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tsaldo_IDR_K</font>&nbsp;</td>
    <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_pay_tsaldo_USD_K</font>&nbsp;</td>
  </tr>
  ");



if($sorting_key == "bank") {

    echo ("
    <tr height=22>
      <td colspan=2 bgcolor=#FFFFFF>&nbsp; 
        <a href='$link_read?sorting_key=bank&mode=read&class=bank&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set'>$txt_invn_payment_10</a>
      </td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
    </tr>");
  
    // CASH
      
      // 항목별 합계
      $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_x9 = mysql_query($query_sum_x9);
      if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

      $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
      $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
      $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
      $result_sum_x9 = mysql_query($query_sum_x9);
      if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

      $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
      $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
      $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
      $result_sum_x3 = mysql_query($query_sum_x3);
      if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

      $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
      $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
      $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
      $result_sum_x4 = mysql_query($query_sum_x4);
      if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

      $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
      $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
      $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
      $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
      $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
      $sum_x9_amount6_K = number_format($sum_x9_amount6);
      
      // 줄 색깔
      if($mode == "read" AND $subcode == cash) {
        $highlight_color = "#FAFAB4";
      } else {
        $highlight_color = "#FFFFFF";
      }
      
  
      echo ("
      <tr height=22>
        <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
          <a href='$link_read?sorting_key=bank&mode=read&class=bank&subcode=cash&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>$txt_invn_payment_10_1</a>
        </td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
      </tr>
      ");
      
      // [일일 리스트 - CASH]
      if($mode == "read" AND $subcode == cash) {
      
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'cash' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }      
      
      }
      
      

    // CARD
      
      // 항목별 합계
      $query_sum_x8 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_x8 = mysql_query($query_sum_x8);
      if (!$result_sum_x8) { error("QUERY_ERROR"); exit; }

      $sum_x8_amount1 = @mysql_result($result_sum_x8,0,0);
      $sum_x8_amount1_K = number_format($sum_x8_amount1);
      
      $query_sum_x8 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
      $result_sum_x8 = mysql_query($query_sum_x8);
      if (!$result_sum_x8) { error("QUERY_ERROR"); exit; }

      $sum_x8_amount2 = @mysql_result($result_sum_x8,0,0);
      $sum_x8_amount2_K = number_format($sum_x8_amount2);
      
      $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
      $result_sum_x3 = mysql_query($query_sum_x3);
      if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

      $sum_x8_amount3 = @mysql_result($result_sum_x3,0,0);
      $sum_x8_amount3_K = number_format($sum_x8_amount3);
      
      $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
      $result_sum_x4 = mysql_query($query_sum_x4);
      if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

      $sum_x8_amount4 = @mysql_result($result_sum_x4,0,0);
      $sum_x8_amount4_K = number_format($sum_x8_amount4);
      
      $sum_x8_amount5 = $sum_x8_amount1 - $sum_x8_amount3;
      $sum_x8_amount5_K = number_format($sum_x8_amount5);
      
      $sum_x8_amount6 = $sum_x8_amount2 - $sum_x8_amount4;
      $sum_x8_amount6_K = number_format($sum_x8_amount6);
      
      // 줄 색깔
      if($mode == "read" AND $subcode == card) {
        $highlight_color = "#FAFAB4";
      } else {
        $highlight_color = "#FFFFFF";
      }
  
      echo ("
      <tr height=22>
        <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
          <a href='$link_read?sorting_key=bank&mode=read&class=bank&subcode=card&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>$txt_invn_payment_10_4</a>
        </td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount1_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount2_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount3_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount4_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount5_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x8_amount6_K</font>&nbsp;</td>
      </tr>
      ");
      
      
      // [일일 리스트 - CARD]
      if($mode == "read" AND $subcode == card) {
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'card' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }      
      
      
      }

    
    
    // BANKs
    $query_x2c = "SELECT count(uid) FROM code_bank WHERE branch_code = '$login_branch' AND userlevel > '0'";
    $result_x2c = mysql_query($query_x2c);
    $total_x2c = @mysql_result($result_x2c,0,0);

    $query_x2 = "SELECT bank_code,bank_name FROM code_bank 
                WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY bank_code ASC";
    $result_x2 = mysql_query($query_x2);

    for($x2 = 0; $x2 < $total_x2c; $x2++) {
      $x2_shop_code = mysql_result($result_x2,$x2,0);
      $x2_shop_name = mysql_result($result_x2,$x2,1);
      
      // 항목별 합계
      $query_sum_x2 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_x2 = mysql_query($query_sum_x2);
      if (!$result_sum_x2) { error("QUERY_ERROR"); exit; }

      $sum_x2_amount1 = @mysql_result($result_sum_x2,0,0);
      $sum_x2_amount1_K = number_format($sum_x2_amount1);
      
      $query_sum_x2 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
      $result_sum_x2 = mysql_query($query_sum_x2);
      if (!$result_sum_x2) { error("QUERY_ERROR"); exit; }

      $sum_x2_amount2 = @mysql_result($result_sum_x2,0,0);
      $sum_x2_amount2_K = number_format($sum_x2_amount2);
      
      $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
      $result_sum_x3 = mysql_query($query_sum_x3);
      if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

      $sum_x2_amount3 = @mysql_result($result_sum_x3,0,0);
      $sum_x2_amount3_K = number_format($sum_x2_amount3);
      
      $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
      $result_sum_x4 = mysql_query($query_sum_x4);
      if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

      $sum_x2_amount4 = @mysql_result($result_sum_x4,0,0);
      $sum_x2_amount4_K = number_format($sum_x2_amount4);
      
      $sum_x2_amount5 = $sum_x2_amount1 - $sum_x2_amount3;
      $sum_x2_amount5_K = number_format($sum_x2_amount5);
      
      $sum_x2_amount6 = $sum_x2_amount2 - $sum_x2_amount4;
      $sum_x2_amount6_K = number_format($sum_x2_amount6);
      
      // 줄 색깔
      if($mode == "read" AND $subcode == $x2_shop_code) {
        $highlight_color = "#FAFAB4";
      } else {
        $highlight_color = "#FFFFFF";
      }
  
      echo ("
      <tr height=22>
        <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
          <a href='$link_read?sorting_key=bank&mode=read&class=bank&subcode=$x2_shop_code&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>{$x2_shop_name}</a>
        </td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount1_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount2_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount3_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount4_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount5_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x2_amount6_K</font>&nbsp;</td>
      </tr>
      ");
      
      
      // [일일 리스트 - BANK]
      if($mode == "read" AND $subcode == $x2_shop_code) {
      
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND pay_type = 'bank' AND bank_name = '$x2_shop_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }
      
      
      }
  
    }  





} else if($sorting_key == "field") { // 계정항목별 보기



    echo ("
    <tr height=22>
      <td colspan=2 bgcolor=#FFFFFF>&nbsp; 
        <a href='$link_read?sorting_key=field&mode=read&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set'>$txt_fin_balance_06</a>
      </td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
    </tr>");


    // ACCOUNTING FIELDs - INCOME
    $query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'in'";
    $result_AC = mysql_query($query_AC);
    if (!$result_AC) { error("QUERY_ERROR"); exit; }
    $total_AC = @mysql_result($result_AC,0,0);

    echo ("
    <tr height=22>
      <td colspan=2 bgcolor=#FFFFFF>&nbsp; $txt_fin_balance_01</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
    </tr>");
    
    $query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'in' ORDER BY catg ASC";
    $result_A = mysql_query($query_A);
    if (!$result_A) {   error("QUERY_ERROR");   exit; }

    for($a = 0; $a < $total_AC; $a++) {
      $fA_uid = mysql_result($result_A,$a,0);
      $fA_class = mysql_result($result_A,$a,1);
      $fA_catg = mysql_result($result_A,$a,2);
   
      $fA_catg_txt = "txt_sys_account_05_"."$fA_catg";
        echo ("
        <tr height=22>
          <td colspan=2 bgcolor=#FFFFFF>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;($fA_catg) ${$fA_catg_txt}</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
        </tr>
        ");
      
      // INCOME
      $query_H1C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fA_catg' AND lang = '$lang' AND $login_branch = '1'";
      $result_H1C = mysql_query($query_H1C);
      if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H1C = @mysql_result($result_H1C,0,0); 
                      
      $query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
                  WHERE catg = '$fA_catg' AND lang = '$lang' AND $login_branch = '1' ORDER BY acc_code ASC";
      $result_H1 = mysql_query($query_H1);
      if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
      for($h1 = 0; $h1 < $total_H1C; $h1++) {
        $H1_acc_uid = mysql_result($result_H1,$h1,0);   
        $H1_acc_code = mysql_result($result_H1,$h1,1);
        $H1_acc_name = mysql_result($result_H1,$h1,2);

        // 항목별 합계
        $query_sum_xA = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_xA = mysql_query($query_sum_xA);
        if (!$result_sum_xA) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount1 = @mysql_result($result_sum_xA,0,0);
        $sum_xA_amount1_K = number_format($sum_xA_amount1);
      
        $query_sum_xA = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_xA = mysql_query($query_sum_xA);
        if (!$result_sum_xA) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount2 = @mysql_result($result_sum_xA,0,0);
        $sum_xA_amount2_K = number_format($sum_xA_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_xA_amount3_K = number_format($sum_xA_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_xA_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_xA_amount4_K = number_format($sum_xA_amount4);
      
        $sum_xA_amount5 = $sum_xA_amount1 - $sum_xA_amount3;
        $sum_xA_amount5_K = number_format($sum_xA_amount5);
      
        $sum_xA_amount6 = $sum_xA_amount2 - $sum_xA_amount4;
        $sum_xA_amount6_K = number_format($sum_xA_amount6);
        
        // 줄 색깔
        if($mode == "read" AND $subcode == $H1_acc_code) {
          $highlight_color = "#FAFAB4";
        } else {
          $highlight_color = "#FFFFFF";
        }
  
        echo ("
        <tr height=22>
                    <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
            <a href='$link_read?sorting_key=field&mode=read&subcode=$H1_acc_code&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>($H1_acc_code) {$H1_acc_name}</a>
          </td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xA_amount6_K</font>&nbsp;</td>
        </tr>
        ");

        
        // [일일 리스트 - Fields A]
        if($mode == "read" AND $subcode == $H1_acc_code) {
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H1_acc_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }
        
        
        }
      
      
      }
    
    }


    // ACCOUNTING FIELDs - OUTGOING
    $query_BC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'out'";
    $result_BC = mysql_query($query_BC);
    if (!$result_BC) { error("QUERY_ERROR"); exit; }
    $total_BC = @mysql_result($result_BC,0,0);
    
    echo ("
    <tr height=22>
      <td colspan=2 bgcolor=#FFFFFF>&nbsp; $txt_fin_balance_02</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
    </tr>");
    
    $query_B = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'out' ORDER BY catg ASC";
    $result_B = mysql_query($query_B);
    if (!$result_B) {   error("QUERY_ERROR");   exit; }

    for($b = 0; $b < $total_BC; $b++) {
      $fB_uid = mysql_result($result_B,$b,0);
      $fB_class = mysql_result($result_B,$b,1);
      $fB_catg = mysql_result($result_B,$b,2);
   
      $fB_catg_txt = "txt_sys_account_06_"."$fB_catg";
      echo ("
        <tr height=22>
          <td colspan=2 bgcolor=#FFFFFF>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;($fB_catg) ${$fB_catg_txt}</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF>&nbsp;</td>
        </tr>
        ");
      
      // OUTGOING
      $query_H2C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fB_catg' AND lang = '$lang' AND $login_branch = '1'";
      $result_H2C = mysql_query($query_H2C);
      if (!$result_H2C) {   error("QUERY_ERROR");   exit; }
                      
      $total_H2C = @mysql_result($result_H2C,0,0); 
                      
      $query_H2 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
                  WHERE catg = '$fB_catg' AND lang = '$lang' AND $login_branch = '1' ORDER BY acc_code ASC";
      $result_H2 = mysql_query($query_H2);
      if (!$result_H2) {   error("QUERY_ERROR");   exit; }
    
      for($h2 = 0; $h2 < $total_H2C; $h2++) {
        $H2_acc_uid = mysql_result($result_H2,$h2,0);   
        $H2_acc_code = mysql_result($result_H2,$h2,1);
        $H2_acc_name = mysql_result($result_H2,$h2,2);

        // 항목별 합계
        $query_sum_xB = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_xB = mysql_query($query_sum_xB);
        if (!$result_sum_xB) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount1 = @mysql_result($result_sum_xB,0,0);
        $sum_xB_amount1_K = number_format($sum_xB_amount1);
      
        $query_sum_xB = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_xB = mysql_query($query_sum_xB);
        if (!$result_sum_xB) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount2 = @mysql_result($result_sum_xB,0,0);
        $sum_xB_amount2_K = number_format($sum_xB_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_xB_amount3_K = number_format($sum_xB_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_xB_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_xB_amount4_K = number_format($sum_xB_amount4);
      
        $sum_xB_amount5 = $sum_xB_amount1 - $sum_xB_amount3;
        $sum_xB_amount5_K = number_format($sum_xB_amount5);
      
        $sum_xB_amount6 = $sum_xB_amount2 - $sum_xB_amount4;
        $sum_xB_amount6_K = number_format($sum_xB_amount6);
        
        // 줄 색깔
        if($mode == "read" AND $subcode == $H2_acc_code) {
          $highlight_color = "#FAFAB4";
        } else {
          $highlight_color = "#FFFFFF";
        }
  
        echo ("
        <tr height=22>
          <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
            <a href='$link_read?sorting_key=field&mode=read&subcode=$H2_acc_code&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>($H2_acc_code) {$H2_acc_name}</a>
          </td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_xB_amount6_K</font>&nbsp;</td>
        </tr>
        ");
        
        
        // [일일 리스트 - Fields B]
        if($mode == "read" AND $subcode == $H2_acc_code) {
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND f_code = '$H2_acc_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }
        
        
        }
      
      
      
      }
    
    }




} else { // 매장(SHOP)별 보기



    echo ("
    <tr height=22>
      <td colspan=2 bgcolor=#FFFFFF>&nbsp; 
        <a href='$link_read?sorting_key=shop&mode=read&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set'>$txt_invn_gudang_01</a>
      </td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
      <td align=right bgcolor=#FFFFFF>&nbsp;</td>
    </tr>");
  
    // SHOPs
    $query_x1c = "SELECT count(uid) FROM client WHERE $sorting_filter_W AND userlevel > '0'";
    $result_x1c = mysql_query($query_x1c);
    $total_x1c = @mysql_result($result_x1c,0,0);

    $query_x1 = "SELECT client_id,client_name FROM client 
                WHERE $sorting_filter_W AND userlevel > '0' ORDER BY client_code ASC";
    $result_x1 = mysql_query($query_x1);

    for($x1 = 0; $x1 < $total_x1c; $x1++) {
      $x1_shop_code = mysql_result($result_x1,$x1,0);
      $x1_shop_name = mysql_result($result_x1,$x1,1);
      
      // 항목별 합계
      $query_sum_x1 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
      $result_sum_x1 = mysql_query($query_sum_x1);
      if (!$result_sum_x1) { error("QUERY_ERROR"); exit; }

      $sum_x1_amount1 = @mysql_result($result_sum_x1,0,0);
      $sum_x1_amount1_K = number_format($sum_x1_amount1);
      
      $query_sum_x2 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
      $result_sum_x2 = mysql_query($query_sum_x2);
      if (!$result_sum_x2) { error("QUERY_ERROR"); exit; }

      $sum_x1_amount2 = @mysql_result($result_sum_x2,0,0);
      $sum_x1_amount2_K = number_format($sum_x1_amount2);
      
      $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
      $result_sum_x3 = mysql_query($query_sum_x3);
      if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

      $sum_x1_amount3 = @mysql_result($result_sum_x3,0,0);
      $sum_x1_amount3_K = number_format($sum_x1_amount3);
      
      $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_month_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
      $result_sum_x4 = mysql_query($query_sum_x4);
      if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

      $sum_x1_amount4 = @mysql_result($result_sum_x4,0,0);
      $sum_x1_amount4_K = number_format($sum_x1_amount4);
      
      $sum_x1_amount5 = $sum_x1_amount1 - $sum_x1_amount3;
      $sum_x1_amount5_K = number_format($sum_x1_amount5);
      
      $sum_x1_amount6 = $sum_x1_amount2 - $sum_x1_amount4;
      $sum_x1_amount6_K = number_format($sum_x1_amount6);
      
      // 줄 색깔
      if($mode == "read" AND $subcode == $x1_shop_code) {
        $highlight_color = "#FAFAB4";
      } else {
        $highlight_color = "#FFFFFF";
      }
  
      echo ("
      <tr height=22>
        <td colspan=2 bgcolor='$highlight_color'>&nbsp; <i class='fa fa-caret-right'></i>&nbsp;
          <a href='$link_read?sorting_key=shop&mode=read&class=shop&subcode=$x1_shop_code&p_year=$p_year&p_month=$p_month&p_yearmonth=$full_month_set&code_set=$full_date_set'>{$x1_shop_name}</a>
        </td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount1_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount2_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount3_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount4_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount5_K</font>&nbsp;</td>
        <td align=right bgcolor='$highlight_color'><font color=#000000>$sum_x1_amount6_K</font>&nbsp;</td>
      </tr>
      ");
  
      // [일일 리스트 - SHOPs]
      if($mode == "read" AND $subcode == $x1_shop_code) {
      
      
        // 날짜의 시작과 종료
        if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

        for($d = 1; $d <= $totaldays2; $d++) {
          
          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $full_date_set = "$p_year"."$p_month"."$dd";
          $full_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
    
    
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'in' AND currency = 'IDR'"; // Income, IDR
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount1 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount1_K = number_format($sum_x9_amount1);
      
        $query_sum_x9 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'in' AND currency = 'USD'"; // Income, USD
        $result_sum_x9 = mysql_query($query_sum_x9);
        if (!$result_sum_x9) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount2 = @mysql_result($result_sum_x9,0,0);
        $sum_x9_amount2_K = number_format($sum_x9_amount2);
      
        $query_sum_x3 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'out' AND currency = 'IDR'"; // Outcome, IDR
        $result_sum_x3 = mysql_query($query_sum_x3);
        if (!$result_sum_x3) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount3 = @mysql_result($result_sum_x3,0,0);
        $sum_x9_amount3_K = number_format($sum_x9_amount3);
      
        $query_sum_x4 = "SELECT sum(amount) FROM finance 
                WHERE $sorting_filter_P AND pay_date LIKE '$full_date_set%' AND process = '2'
                AND gate = '$x1_shop_code' AND f_class = 'out' AND currency = 'USD'"; // Outcome, USD
        $result_sum_x4 = mysql_query($query_sum_x4);
        if (!$result_sum_x4) { error("QUERY_ERROR"); exit; }

        $sum_x9_amount4 = @mysql_result($result_sum_x4,0,0);
        $sum_x9_amount4_K = number_format($sum_x9_amount4);
      
        $sum_x9_amount5 = $sum_x9_amount1 - $sum_x9_amount3;
        $sum_x9_amount5_K = number_format($sum_x9_amount5);
      
        $sum_x9_amount6 = $sum_x9_amount2 - $sum_x9_amount4;
        $sum_x9_amount6_K = number_format($sum_x9_amount6);
        
  
        echo ("
        <tr height=22>
          <td bgcolor=#FFFFFF align=right><i class='fa fa-caret-right'></i> &nbsp;</td>
          <td align=center bgcolor=#FFFFFF><font color=#000000>$full_dd_txt</font></td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount1_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount2_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount3_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount4_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount5_K</font>&nbsp;</td>
          <td align=right bgcolor=#FFFFFF><font color=#000000>$sum_x9_amount6_K</font>&nbsp;</td>
        </tr>
        ");
  
        }


      }

    }

}
?>				
		
		
		
		
		
		
		
        </tbody>
        </table>
		</section>
		

		</div>
		</section>
		</div>
		</div>

		

		
						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>
</html>


<? } ?>