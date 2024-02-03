<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "table";
$smenu = "table_report";

$step_next = $_POST['step_next'];
if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/table_report.php";

// $report_last_date = "YYYY1231";
// $report_start_date = "YYYY0101";
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

	// month와 year의 변수값이 지정되어있지 않으면 오늘로 지정.
		if(!$p_month)$p_month=(int)$this_month;
		if(!$p_year)$p_year=$this_year;
		if(!$p_date)$p_date=$this_date;

	// 지난달과 다음달을 보는 루틴
		$year_p=$p_year-1;
		$year_n=$p_year+1;
		if($p_month==1){
			$year_prev=$year_p;
			$year_next=$p_year;
			$month_prev=12;
			$month_next=$p_month+1;
		}
		if($p_month==12){
			$year_prev=$p_year;
			$year_next=$year_n;
			$month_prev=$p_month-1;
			$month_next=1;
		}
		if($p_month!=1 && $p_month!=12){
			$year_prev=$p_year;
			$year_next=$p_year;
			$month_prev=$p_month-1;
			$month_next=$p_month+1;
		}



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
		
		// 선택한 월의 전월의 총 일수
		$p_month_A = $p_month - 1;
		if($p_month_A == 0) {
		  $p_year_AA = $p_year - 1;
		  $p_month_AA = 12;
		} else {
		  $p_year_AA = $p_year;
		  $p_month_AA = $p_month_A;
		}
		
		$totaldays_AA = get_totaldays($p_year_AA,$p_month_AA);
		

	// 선택한 월의 1일의 요일을 구함. 일요일은 0.
		$first_day = date('w', mktime(0,0,0,$p_month,1,$p_year));

	// 윤년 확인
		if($p_month==2){
		if(!($p_year%4))$totaldays++;
		if(!($p_year%100))$totaldays--;
		if(!($p_year%400))$totaldays++;
		}

// 해당 지사/Shop 이름 추출
if($grpBrc) {
  $query_name1 = "SELECT branch_name FROM client_branch WHERE branch_code = '$grpBrc'";
  $result_name1 = mysql_query($query_name1);
    if (!$result_name1) { error("QUERY_ERROR"); exit; }
  $rp_title1 = @mysql_result($result_name1,0,0);
}
if($grpShp) {
  $query_name2 = "SELECT shop_name FROM client_shop WHERE shop_code = '$grpShp'";
  $result_name2 = mysql_query($query_name2);
    if (!$result_name2) { error("QUERY_ERROR"); exit; }
  $rp_title2 = @mysql_result($result_name2,0,0);
  $rp_title2_full = "$rp_title1"." &gt; "."$rp_title2";
} else {
  $rp_title2_full = $rp_title1;
}


// 전체 Shop 수
if($grpBrc) {
  $query_shu = "SELECT count(uid) FROM client_shop WHERE branch_code = '$grpBrc'";
} else {
  $query_shu = "SELECT count(uid) FROM client_shop";
}
  $result_shu = mysql_query($query_shu);
    if (!$result_shu) { error("QUERY_ERROR"); exit; }
  $tot_shps = @mysql_result($result_shu,0,0);
  



// vmode
if(!$vmode) {
  $vmode = "shop";
}
$mode = $_GET['mode'];
$p_year = $_GET['p_year'];
$p_month = $_GET['p_month'];
$p_yearmonth = $_GET['p_yearmonth'];
$keyA = $_GET['keyA'];
$keyB = $_GET['keyB'];
$link_report = "$PHP_SELF?lang=$lang&loco=page_server&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&grpAll=$grpAll&grpBrc=$grpBrc&grpShp=$grpShp&w_date_setA=$w_date_setA&w_date_setB=$w_date_setB&p_quarter=$p_quarter";

$style_area = "BORDER: #AAAAAA 1px solid";
$BOX_TOP1 = "BORDER: #777777 1px solid";
$BOX_TOP2 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid; BORDER-TOP: #777777 1px solid";
$BOX_LAIN1 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid; BORDER-LEFT: #777777 1px solid";
$BOX_LAIN2 = "BORDER-BOTTOM: #777777 1px solid; BORDER-RIGHT: #777777 1px solid";

if($mode) {
  $main_module = "div_report_"."$mode".".inc";
} else {
  $main_module = "div_report_sales_VD.inc";
}
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
    <link rel="stylesheet" type="text/css" href="assets/fuelux/css/tree-style.css" />
	
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/jquery-multi-select/css/multi-select.css" />
	
	<link href="assets/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
	
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
	</script>

  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
	
			<section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="col-sm-3">
				  
				  <div class="panel">
                      <div class="panel-heading">
                          Organization
                          <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                          </span>
                      </div>
                      <div class="panel-body">
                          <? include "left_dir.inc"; ?>
                      </div>
					  <div class="panel-body">
                          <? include "left_calendar.inc"; ?>
                      </div>
                  </div>
				  
				  
				  </aside>
                  <aside class="col-sm-9">
				  <section class="panel">
				      <div class="panel-heading">
                          Projection by Shop
						  
                          <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                          </span>
                      </div>
                      
                      <div class="panel-body">
			

      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr>
        <td width=200>
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
    
    echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" style='$style_box; WIDTH: 45px'>");

    for($m = $m_s; $m <= $m_f; $m++) {

      // 해당 월을 2자리 수자로 표현
      $mm = sprintf("%02d", $m);
      $this_month_set = "$p_year"."$mm";
      
      if($mm == $p_month) {
        echo ("<option value='$PHP_SELF?lang=$lang&loco=page_server&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set&mode=$mode&vmode=$vmode' selected>$mm</a></option>");
      } else {
        echo ("<option value='$PHP_SELF?lang=$lang&loco=page_server&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set&mode=$mode&vmode=$vmode'>$mm</a></option>");
      }
    
    }
    
    echo ("</select> &nbsp;");


    // 연 반복 (기산년부터 금년까지)
    $yy_s = $rs_year;
    $yy_f = $this_year;
    
    echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" style='$style_box; WIDTH: 60px'>");
  
    for($yy = $yy_s; $yy <= $yy_f; $yy++) {

      if($p_year == $yy) {
        echo ("<option value='$PHP_SELF?lang=$lang&loco=page_server&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth&mode=$mode&vmode=$vmode' selected>$yy</a></option>");
      } else {
        echo ("<option value='$PHP_SELF?lang=$lang&loco=page_server&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth&mode=$mode&vmode=$vmode'>$yy</a></option>");
      }

    }
    
    echo ("</select>");


          ?>

        </td>


        <td>
        
            <?
            if(!$mode OR $mode == "sales_VD" OR $mode == "sales_VW" OR $mode == "sales_VM" OR $mode == "sales_VQ" OR $mode == "sales_VY") {
              $mode_txt = "Sales Projection";
              echo ("<a href='$link_report'><u>Sales</u></a> |&nbsp;");
            } else {
              echo ("<a href='$link_report'>Sales</a> |&nbsp;");            
            }
            
            if($mode == "stock_TD" OR $mode == "stock_TW" OR $mode == "stock_TM" OR $mode == "stock_TQ" OR $mode == "stock_TY") {
              $mode_txt = "Stock";
              echo ("<u><a href='$link_report&mode=stock_TD'>Stock</a></u> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=stock_TD'>Stock</a> |&nbsp;");            
            }
            
            if($mode == "expire_TD" OR $mode == "expire_TW" OR $mode == "expire_TM" OR $mode == "expire_TQ" OR $mode == "expire_TY") {
              $mode_txt = "Expired Products";
              echo ("<u><a href='$link_report&mode=expire_TD'>Expired</a></u> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=expire_TD'>Expired</a> |&nbsp;");            
            }
            
            if($mode == "purchase") {
              $mode_txt = "Purchase";
              echo ("<a href='$link_report&mode=purchase'><u>Purchase</u></a> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=purchase'>Purchase</a> |&nbsp;");            
            }

            if($mode == "payment") {
              $mode_txt = "Payment";
              echo ("<a href='$link_report&mode=payment'><u>Payment</u></a> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=payment'>Payment</a> |&nbsp;");            
            }
            
            if($mode == "payment2") {
              $mode_txt = "Loan Payment";
              echo ("<a href='$link_report&mode=payment2'><u>Loan Payment</u></a> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=payment2'>Loan Payment</a> |&nbsp;");            
            }
            
            if($mode == "balance") {
              $mode_txt = "Balance";
              echo ("<a href='$link_report&mode=balance'><u>Balance</u></a> |&nbsp;");
            } else {
              echo ("<a href='$link_report&mode=balance'>Balance</a> |&nbsp;");            
            }
            
            if($mode == "finance_TD" OR $mode == "finance_TM") {
              $mode_txt = "Revenue Projection";
              echo ("<a href='$link_report&mode=finance_TD'><u>Revenue</u></a> &nbsp;");
            } else {
              echo ("<a href='$link_report&mode=finance_TM'>Revenue</a> &nbsp;");            
            }
            ?>
            
        
        </td>


        <td align=right>
        
          <!--
          <select name='select' onChange="MM_jumpMenu('parent',this,0)" style='<?=$style_box?>; WIDTH: 120px'>
          <?
          // 날짜의 시작과 종료
          if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

          for($d = 1; $d <= $totaldays2; $d++) {

          // 날짜를 2자리 수자로 표현
          $dd = sprintf("%02d", $d);
  
          // 해당 날짜
          $this_date_set = "$p_year"."$p_month"."$dd";
          $this_month_set = "$p_year"."$p_month";
  
          // 날짜 표현
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
          
          if($this_date_set == $p_date_set) {
            $this_date_set_slct = "selected";
          } else {
            $this_date_set_slct = "";
          }
          
          echo ("<option value='$PHP_SELF?lang=$lang&loco=page_server&p_year=$p_year&p_month=$p_month&p_yearmonth=$this_month_set&p_date_set=$this_date_set&mode=$mode&vmode=$vmode' $this_date_set_slct>$full_dd_txt</option>");
          
          }
          ?>
          </select>
          -->
        
        
        </td>

      </tr>
      </table>



<? 
if($mode) {
  $main_module = "div_report_"."$mode".".inc";
} else {
  $main_module = "div_report_sales_VD.inc";
}
?>

<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr><td height=5></td></tr>
<tr>
  <td height=22 bgcolor=#EFEFEF> &nbsp;&nbsp; 
      <?
      echo ("<b>$mode_txt</b>&nbsp;");
      
      if(!$mode OR $mode == "sales_VD" OR $mode == "sales_VW" OR $mode == "sales_VM" OR $mode == "sales_VQ" OR $mode == "sales_VY") {
      if(!$grpShp) {
      if($vmode == "time") {
        echo ("<u>by Time</u>");
        echo ("&nbsp;| <a href='$link_report&mode=$mode'>by Shop</a>");
      } else {
        echo ("<u>by Shop</u>");
        echo ("&nbsp;| <a href='$link_report&mode=$mode&vmode=time'>by Time</a>");
      }
      }
      }
      
      echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
      
      // 매출
      if(!$mode OR $mode == "sales_VD" OR $mode == "sales_VW" OR $mode == "sales_VM" OR $mode == "sales_VQ" OR $mode == "sales_VY") {
      if(!$mode OR $mode == "sales_VD") {
        echo ("[ <a href='$link_report&vmode=$vmode'><u>$txt_comm_report_81</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&vmode=$vmode'>$txt_comm_report_81</a> ]");
      }
      
      if($w_date_setA AND $w_date_setB) {
      if($mode == "sales_VW") {
        echo ("[ <a href='$link_report&mode=sales_VW&vmode=$vmode'><u>$txt_comm_report_82</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=sales_VW&vmode=$vmode'>$txt_comm_report_82</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_82 ]");
      }
      
      if($mode == "sales_VM") {
        echo ("[ <a href='$link_report&mode=sales_VM&vmode=$vmode'><u>$txt_comm_report_83</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=sales_VM&vmode=$vmode'>$txt_comm_report_83</a> ]");
      }
      
      if($p_quarter) {
      if($mode == "sales_VQ") {
        echo ("[ <a href='$link_report&mode=sales_VQ&vmode=$vmode'><u>$txt_comm_report_84</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=sales_VQ&vmode=$vmode'>$txt_comm_report_84</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_84 ]");
      }
      
      if($mode == "sales_VY") {
        echo ("[ <a href='$link_report&mode=sales_VY&vmode=$vmode'><u>$txt_comm_report_85</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=sales_VY&vmode=$vmode'>$txt_comm_report_85</a> ]");
      }
      
      // 재고
      } else if($mode == "stock_TD" OR $mode == "stock_TW" OR $mode == "stock_TM" OR $mode == "stock_TQ" OR $mode == "stock_TY") {
      if($mode == "stock_TD") {
        echo ("[ <a href='$link_report&mode=stock_TD'><u>$txt_comm_report_81</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=stock_TD'>$txt_comm_report_81</a> ]");
      }
      
      if($w_date_setA AND $w_date_setB) {
      if($mode == "stock_TW") {
        echo ("[ <a href='$link_report&mode=stock_TW'><u>$txt_comm_report_82</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=stock_TW'>$txt_comm_report_82</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_82 ]");
      }
      
      if($mode == "stock_TM") {
        echo ("[ <a href='$link_report&mode=stock_TM'><u>$txt_comm_report_83</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=stock_TM'>$txt_comm_report_83</a> ]");
      }
      
      if($p_quarter) {
      if($mode == "stock_TQ") {
        echo ("[ <a href='$link_report&mode=stock_TQ'><u>$txt_comm_report_84</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=stock_TQ'>$txt_comm_report_84</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_84 ]");
      }
      
      if($mode == "stock_TY") {
        echo ("[ <a href='$link_report&mode=stock_TY'><u>$txt_comm_report_85</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=stock_TY'>$txt_comm_report_85</a> ]");
      }
      
            
      // 유효기간 만료된 제품
      } else if($mode == "expire_TD" OR $mode == "expire_TW" OR $mode == "expire_TM" OR $mode == "expire_TQ" OR $mode == "expire_TY") {
      if($mode == "expire_TD") {
        echo ("[ <a href='$link_report&mode=expire_TD'><u>$txt_comm_report_81</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=expire_TD'>$txt_comm_report_81</a> ]");
      }
      
      if($w_date_setA AND $w_date_setB) {
      if($mode == "expire_TW") {
        echo ("[ <a href='$link_report&mode=expire_TW'><u>$txt_comm_report_82</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=expire_TW'>$txt_comm_report_82</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_82 ]");
      }
      
      if($mode == "expire_TM") {
        echo ("[ <a href='$link_report&mode=expire_TM'><u>$txt_comm_report_83</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=expire_TM'>$txt_comm_report_83</a> ]");
      }
      
      if($p_quarter) {
      if($mode == "expire_TQ") {
        echo ("[ <a href='$link_report&mode=expire_TQ'><u>$txt_comm_report_84</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=expire_TQ'>$txt_comm_report_84</a> ]");
      }
      } else {
        echo ("[ $txt_comm_report_84 ]");
      }
      
      if($mode == "expire_TY") {
        echo ("[ <a href='$link_report&mode=expire_TY'><u>$txt_comm_report_85</u></a> ]");
      } else {
        echo ("[ <a href='$link_report&mode=expire_TY'>$txt_comm_report_85</a> ]");
      }
      
      }
      
      
      
      ?>
  </td>
</tr>
<tr><td height=10></td></tr>

<tr><td height=20>
	<? include "$main_module"; ?>
	</td>
</tr>
</table>
			
		
							  
							  
                      </div>
				  </section>
                  </aside>
			  </div>
			</section>
						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	<? include "footer.inc"; ?>

</section>


	<!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

    <script src="assets/fuelux/js/tree.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
  <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  
 
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

  <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    <script src="js/tree.js"></script>
	
	<!--this page  script only-->
    <script src="js/advanced-form-components.js"></script>
	<script src="js/sliders.js" type="text/javascript"></script>

  <script>
      jQuery(document).ready(function() {
          TreeView.init();
      });
  </script>


  </body>

</html>


<?
} else if($step_next == "permit_print") {



  echo("<meta http-equiv='Refresh' content='0; URL=$home/table_report.php'>");
  exit;

}

}
?>