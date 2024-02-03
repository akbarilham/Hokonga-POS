<?
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
require "config/user_functions_{$lang}.inc";

$mmenu = "main";
$smenu = "dashboard";

if(!$login_id OR $login_level < "1") {

	echo ("<meta http-equiv='Refresh' content='0; URL=user_login.php'>");
	#echo ("<meta http-equiv='Refresh' content='0; URL=pos_login.php'>");

} else {

$signdate = time();

$this_year = date("Y");
$this_month = date("m");
$this_yearmonth = date("ym");

if(!$p_year) { $p_year = date("Y",$signdate); }
if(!$p_yearmonth) { $p_yearmonth = date("Ym",$signdate); }
if(!$p_date_set) { $p_date_set = date("Ymd",$signdate); }

$rs_year = substr($report_start_date,0,4);
$rs_month = substr($report_start_date,4,2);
$rs_date = substr($report_start_date,6,2);



// Previous 12 Months
$p_y12 = $this_year;
$p_m12 = $this_month;

$p_m11p = $this_month - 1;
if($p_m11p < 1) { $p_y11 = $this_year - 1; $p_m11 = $this_month - 1 + 12; } else { $p_y11 = $this_year;	$p_m11 = $this_month - 1; }
$p_m10p = $this_month - 2;
if($p_m10p < 1) { $p_y10 = $this_year - 1; $p_m10 = $this_month - 2 + 12; } else { $p_y10 = $this_year;	$p_m10 = $this_month - 2; }
$p_m09p = $this_month - 1;
if($p_m09p < 1) { $p_y09 = $this_year - 1; $p_m09 = $this_month - 3 + 12; } else { $p_y09 = $this_year;	$p_m09 = $this_month - 3; }
$p_m08p = $this_month - 1;
if($p_m08p < 1) { $p_y08 = $this_year - 1; $p_m08 = $this_month - 4 + 12; } else { $p_y08 = $this_year;	$p_m08 = $this_month - 4; }
$p_m07p = $this_month - 1;
if($p_m07p < 1) { $p_y07 = $this_year - 1; $p_m07 = $this_month - 5 + 12; } else { $p_y07 = $this_year;	$p_m07 = $this_month - 5; }
$p_m06p = $this_month - 1;
if($p_m06p < 1) { $p_y06 = $this_year - 1; $p_m06 = $this_month - 6 + 12; } else { $p_y06 = $this_year;	$p_m06 = $this_month - 6; }
$p_m05p = $this_month - 1;
if($p_m05p < 1) { $p_y05 = $this_year - 1; $p_m05 = $this_month - 7 + 12; } else { $p_y05 = $this_year;	$p_m05 = $this_month - 7; }
$p_m04p = $this_month - 1;
if($p_m04p < 1) { $p_y04 = $this_year - 1; $p_m04 = $this_month - 8 + 12; } else { $p_y04 = $this_year;	$p_m04 = $this_month - 8; }
$p_m03p = $this_month - 1;
if($p_m03p < 1) { $p_y03 = $this_year - 1; $p_m03 = $this_month - 9 + 12; } else { $p_y03 = $this_year;	$p_m03 = $this_month - 9; }
$p_m02p = $this_month - 1;
if($p_m02p < 1) { $p_y02 = $this_year - 1; $p_m02 = $this_month - 10 + 12; } else { $p_y02 = $this_year; $p_m02 = $this_month - 10; }
$p_m01p = $this_month - 1;
if($p_m01p < 1) { $p_y01 = $this_year - 1; $p_m01 = $this_month - 11 + 12; } else { $p_y01 = $this_year; $p_m01 = $this_month - 11; }

$p_m01 = sprintf("%02d", $p_m01); $p_m01_txt = "txt_comm_mon_"."$p_m01"; $p_ym01 = "$p_y01"."$p_m01"; $p_ym01f = "$p_ym01"."32"; $p_yms01 = "$p_y01"."-"."$p_m01";
$p_m02 = sprintf("%02d", $p_m02); $p_m02_txt = "txt_comm_mon_"."$p_m02"; $p_ym02 = "$p_y02"."$p_m02"; $p_ym02f = "$p_ym02"."32"; $p_yms02 = "$p_y02"."-"."$p_m02";
$p_m03 = sprintf("%02d", $p_m03); $p_m03_txt = "txt_comm_mon_"."$p_m03"; $p_ym03 = "$p_y03"."$p_m03"; $p_ym03f = "$p_ym03"."32"; $p_yms03 = "$p_y03"."-"."$p_m03";
$p_m04 = sprintf("%02d", $p_m04); $p_m04_txt = "txt_comm_mon_"."$p_m04"; $p_ym04 = "$p_y04"."$p_m04"; $p_ym04f = "$p_ym04"."32"; $p_yms04 = "$p_y04"."-"."$p_m04";
$p_m05 = sprintf("%02d", $p_m05); $p_m05_txt = "txt_comm_mon_"."$p_m05"; $p_ym05 = "$p_y05"."$p_m05"; $p_ym05f = "$p_ym05"."32"; $p_yms05 = "$p_y05"."-"."$p_m05";
$p_m06 = sprintf("%02d", $p_m06); $p_m06_txt = "txt_comm_mon_"."$p_m06"; $p_ym06 = "$p_y06"."$p_m06"; $p_ym06f = "$p_ym06"."32"; $p_yms06 = "$p_y06"."-"."$p_m06";
$p_m07 = sprintf("%02d", $p_m07); $p_m07_txt = "txt_comm_mon_"."$p_m07"; $p_ym07 = "$p_y07"."$p_m07"; $p_ym07f = "$p_ym07"."32"; $p_yms07 = "$p_y07"."-"."$p_m07";
$p_m08 = sprintf("%02d", $p_m08); $p_m08_txt = "txt_comm_mon_"."$p_m08"; $p_ym08 = "$p_y08"."$p_m08"; $p_ym08f = "$p_ym08"."32"; $p_yms08 = "$p_y08"."-"."$p_m08";
$p_m09 = sprintf("%02d", $p_m09); $p_m09_txt = "txt_comm_mon_"."$p_m09"; $p_ym09 = "$p_y09"."$p_m09"; $p_ym09f = "$p_ym09"."32"; $p_yms09 = "$p_y09"."-"."$p_m09";
$p_m10 = sprintf("%02d", $p_m10); $p_m10_txt = "txt_comm_mon_"."$p_m10"; $p_ym10 = "$p_y10"."$p_m10"; $p_ym10f = "$p_ym10"."32"; $p_yms10 = "$p_y10"."-"."$p_m10";
$p_m11 = sprintf("%02d", $p_m11); $p_m11_txt = "txt_comm_mon_"."$p_m11"; $p_ym11 = "$p_y11"."$p_m11"; $p_ym11f = "$p_ym11"."32"; $p_yms11 = "$p_y11"."-"."$p_m11";
$p_m12 = sprintf("%02d", $p_m12); $p_m12_txt = "txt_comm_mon_"."$p_m12"; $p_ym12 = "$p_y12"."$p_m12"; $p_ym12f = "$p_ym12"."32"; $p_yms12 = "$p_y12"."-"."$p_m12";



// Earning
$query_idx_mb01 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym01f'";
$result_idx_mb01 = mysql_query($query_idx_mb01);
	if (!$result_idx_mb01) { error("QUERY_ERROR"); exit; }
$idx_mb01 = @mysql_result($result_idx_mb01,0,0);
$idx_mb01d = $idx_mb01 / 10; if($idx_mb01d > 100) { $idx_mb01d = 100; }

$query_idx_mb02 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym02f'";
$result_idx_mb02 = mysql_query($query_idx_mb02);
	if (!$result_idx_mb02) { error("QUERY_ERROR"); exit; }
$idx_mb02 = @mysql_result($result_idx_mb02,0,0);
$idx_mb02d = $idx_mb02 / 10; if($idx_mb02d > 100) { $idx_mb02d = 100; }

$query_idx_mb03 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym03f'";
$result_idx_mb03 = mysql_query($query_idx_mb03);
	if (!$result_idx_mb03) { error("QUERY_ERROR"); exit; }
$idx_mb03 = @mysql_result($result_idx_mb01,0,0);
$idx_mb03d = $idx_mb03 / 10; if($idx_mb03d > 100) { $idx_mb03d = 100; }

$query_idx_mb04 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym04f'";
$result_idx_mb04 = mysql_query($query_idx_mb04);
	if (!$result_idx_mb04) { error("QUERY_ERROR"); exit; }
$idx_mb04 = @mysql_result($result_idx_mb04,0,0);
$idx_mb04d = $idx_mb04 / 10; if($idx_mb04d > 100) { $idx_mb04d = 100; }

$query_idx_mb05 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym05f'";
$result_idx_mb05 = mysql_query($query_idx_mb05);
	if (!$result_idx_mb05) { error("QUERY_ERROR"); exit; }
$idx_mb05 = @mysql_result($result_idx_mb05,0,0);
$idx_mb05d = $idx_mb05 / 10; if($idx_mb05d > 100) { $idx_mb05d = 100; }

$query_idx_mb06 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym06f'";
$result_idx_mb06 = mysql_query($query_idx_mb06);
	if (!$result_idx_mb06) { error("QUERY_ERROR"); exit; }
$idx_mb06 = @mysql_result($result_idx_mb06,0,0);
$idx_mb06d = $idx_mb06 / 10; if($idx_mb06d > 100) { $idx_mb06d = 100; }

$query_idx_mb07 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym07f'";
$result_idx_mb07 = mysql_query($query_idx_mb07);
	if (!$result_idx_mb07) { error("QUERY_ERROR"); exit; }
$idx_mb07 = @mysql_result($result_idx_mb07,0,0);
$idx_mb07d = $idx_mb07 / 10; if($idx_mb07d > 100) { $idx_mb07d = 100; }

$query_idx_mb08 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym08f'";
$result_idx_mb08 = mysql_query($query_idx_mb08);
	if (!$result_idx_mb08) { error("QUERY_ERROR"); exit; }
$idx_mb08 = @mysql_result($result_idx_mb08,0,0);
$idx_mb08d = $idx_mb08 / 10; if($idx_mb08d > 100) { $idx_mb08d = 100; }

$query_idx_mb09 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym09f'";
$result_idx_mb09 = mysql_query($query_idx_mb09);
	if (!$result_idx_mb09) { error("QUERY_ERROR"); exit; }
$idx_mb09 = @mysql_result($result_idx_mb09,0,0);
$idx_mb09d = $idx_mb09 / 10; if($idx_mb09d > 100) { $idx_mb09d = 100; }

$query_idx_mb10 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym10f'";
$result_idx_mb10 = mysql_query($query_idx_mb10);
	if (!$result_idx_mb10) { error("QUERY_ERROR"); exit; }
$idx_mb10 = @mysql_result($result_idx_mb10,0,0);
$idx_mb10d = $idx_mb10 / 10; if($idx_mb10d > 100) { $idx_mb10d = 100; }

$query_idx_mb11 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym11f'";
$result_idx_mb11 = mysql_query($query_idx_mb11);
	if (!$result_idx_mb11) { error("QUERY_ERROR"); exit; }
$idx_mb11 = @mysql_result($result_idx_mb01,0,0);
$idx_mb11d = $idx_mb11 / 10; if($idx_mb11d > 100) { $idx_mb11d = 100; }

$query_idx_mb12 = "SELECT count(code) FROM member_main WHERE branch_code = '$login_branch' AND userlevel > '1' AND regis_date < '$p_ym12f'";
$result_idx_mb12 = mysql_query($query_idx_mb12);
	if (!$result_idx_mb12) { error("QUERY_ERROR"); exit; }
$idx_mb12 = @mysql_result($result_idx_mb12,0,0);
$idx_mb12d = $idx_mb12 / 10; if($idx_mb12d > 100) { $idx_mb12d = 100; }
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
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">

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
  </head>

  <body>

  <section id="container" >

	  <? include "header.inc"; ?>


      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!--state overview start-->
              <div class="row state-overview">
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol terques">
                              <i class="fa fa-user"></i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  0
                              </h1>
                              <p>New Users</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol red">
                              <i class="fa fa-tags"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2">
                                  0
                              </h1>
                              <p>Sales</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol yellow">
                              <i class="fa fa-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count3">
                                  0
                              </h1>
                              <p>New Order</p>
                          </div>
                      </section>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                      <section class="panel">
                          <div class="symbol blue">
                              <i class="fa fa-bar-chart-o"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count4">
                                  0
                              </h1>
                              <p>Total Profit</p>
                          </div>
                      </section>
                  </div>
              </div>
              <!--state overview end-->

              <div class="row">
                  <div class="col-lg-8">
                      <!--custom chart start-->
                      <div class="border-head">
                          <h3>Earning Graph</h3>
                      </div>
                      <div class="custom-bar-chart">
                          <ul class="y-axis">
                              <li><span>100</span></li>
                              <li><span>80</span></li>
                              <li><span>60</span></li>
                              <li><span>40</span></li>
                              <li><span>20</span></li>
                              <li><span>0</span></li>
                          </ul>
                          <div class="bar">
                              <div class="title">JAN</div>
                              <div class="value tooltips" data-original-title="80%" data-toggle="tooltip" data-placement="top">80%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">FEB</div>
                              <div class="value tooltips" data-original-title="50%" data-toggle="tooltip" data-placement="top">50%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">MAR</div>
                              <div class="value tooltips" data-original-title="40%" data-toggle="tooltip" data-placement="top">40%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">APR</div>
                              <div class="value tooltips" data-original-title="55%" data-toggle="tooltip" data-placement="top">55%</div>
                          </div>
                          <div class="bar">
                              <div class="title">MAY</div>
                              <div class="value tooltips" data-original-title="20%" data-toggle="tooltip" data-placement="top">20%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">JUN</div>
                              <div class="value tooltips" data-original-title="39%" data-toggle="tooltip" data-placement="top">39%</div>
                          </div>
                          <div class="bar">
                              <div class="title">JUL</div>
                              <div class="value tooltips" data-original-title="75%" data-toggle="tooltip" data-placement="top">75%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">AUG</div>
                              <div class="value tooltips" data-original-title="45%" data-toggle="tooltip" data-placement="top">45%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">SEP</div>
                              <div class="value tooltips" data-original-title="50%" data-toggle="tooltip" data-placement="top">50%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">OCT</div>
                              <div class="value tooltips" data-original-title="42%" data-toggle="tooltip" data-placement="top">42%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">NOV</div>
                              <div class="value tooltips" data-original-title="60%" data-toggle="tooltip" data-placement="top">60%</div>
                          </div>
                          <div class="bar ">
                              <div class="title">DEC</div>
                              <div class="value tooltips" data-original-title="90%" data-toggle="tooltip" data-placement="top">90%</div>
                          </div>
                      </div>
                      <!--custom chart end-->
                  </div>
                  <div class="col-lg-4">
                      <!--new earning start-->

						<?
            $p_currency = $_GET['p_currency']?$_GET['p_currency']:'';
						if(!$p_currency) { $p_currency = $now_currency1; }

						$query_sum_01 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms01%'";
						$result_sum_01 = mysql_query($query_sum_01);
							if (!$result_sum_01) { error("QUERY_ERROR"); exit; }
						$oamount_01 = @mysql_result($result_sum_01,0,0);

						$query_sum_02 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms02%'";
						$result_sum_02 = mysql_query($query_sum_02);
							if (!$result_sum_02) { error("QUERY_ERROR"); exit; }
						$oamount_02 = @mysql_result($result_sum_02,0,0);

						$query_sum_03 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms03%'";
						$result_sum_03 = mysql_query($query_sum_03);
							if (!$result_sum_03) { error("QUERY_ERROR"); exit; }
						$oamount_03 = @mysql_result($result_sum_03,0,0);

						$query_sum_04 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms04%'";
						$result_sum_04 = mysql_query($query_sum_04);
							if (!$result_sum_04) { error("QUERY_ERROR"); exit; }
						$oamount_04 = @mysql_result($result_sum_04,0,0);

						$query_sum_05 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms05%'";
						$result_sum_05 = mysql_query($query_sum_05);
							if (!$result_sum_05) { error("QUERY_ERROR"); exit; }
						$oamount_05 = @mysql_result($result_sum_05,0,0);

						$query_sum_06 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms06%'";
						$result_sum_06 = mysql_query($query_sum_06);
							if (!$result_sum_06) { error("QUERY_ERROR"); exit; }
						$oamount_06 = @mysql_result($result_sum_06,0,0);

						$query_sum_07 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms07%'";
						$result_sum_07 = mysql_query($query_sum_07);
							if (!$result_sum_07) { error("QUERY_ERROR"); exit; }
						$oamount_07 = @mysql_result($result_sum_07,0,0);

						$query_sum_08 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms08%'";
						$result_sum_08 = mysql_query($query_sum_08);
							if (!$result_sum_08) { error("QUERY_ERROR"); exit; }
						$oamount_08 = @mysql_result($result_sum_08,0,0);

						$query_sum_09 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms09%'";
						$result_sum_09 = mysql_query($query_sum_09);
							if (!$result_sum_09) { error("QUERY_ERROR"); exit; }
						$oamount_09 = @mysql_result($result_sum_09,0,0);

						$query_sum_10 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms10%'";
						$result_sum_10 = mysql_query($query_sum_10);
							if (!$result_sum_10) { error("QUERY_ERROR"); exit; }
						$oamount_10 = @mysql_result($result_sum_10,0,0);

						$query_sum_11 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms11%'";
						$result_sum_11 = mysql_query($query_sum_11);
							if (!$result_sum_11) { error("QUERY_ERROR"); exit; }
						$oamount_11 = @mysql_result($result_sum_11,0,0);

						$query_sum_12 = "SELECT sum(amount) FROM finance WHERE currency = '$p_currency' AND process = '2' AND pay_date LIKE '$p_yms12%'";
						$result_sum_12 = mysql_query($query_sum_12);
							if (!$result_sum_12) { error("QUERY_ERROR"); exit; }
						$oamount_12 = @mysql_result($result_sum_12,0,0);
							$oamount_12_k = number_format($oamount_12);

						if($p_currency == "IDR") {
							$p_currency_tag = "Rp.";
						} else if($p_currency == "USD") {
							$p_currency_tag = "$";
						}
						?>

                      <div class="panel terques-chart">
                          <div class="panel-body chart-texture">
                              <div class="chart">
                                  <div class="heading">
                                      <span><?=$today_month_set_txt?></span>
                                      <strong><?=$p_currency_tag?> <?=$oamount_12_k?></strong>
                                  </div>
                                  <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[<?=$oamount_01?>,<?=$oamount_02?>,<?=$oamount_03?>,<?=$oamount_04?>,<?=$oamount_05?>,<?=$oamount_06?>,<?=$oamount_07?>,<?=$oamount_08?>,<?=$oamount_09?>,<?=$oamount_10?>,<?=$oamount_11?>]"></div>
                              </div>
                          </div>
                          <div class="chart-tittle">
                              <span class="title"><?=$frn1_mmenu_052?></span>
                              <span class="value">
									<?
									if($p_currency == $now_currency1) {
										echo ("<a href='index.php?p_year=$p_year&p_currency=$now_currency1' class='active'>$now_currency1</a> |&nbsp;");
									} else {
										echo ("<a href='index.php?p_year=$p_year&p_currency=$now_currency1'>$now_currency1</a> |&nbsp;");
									}
									if($p_currency == $now_currency2) {
										echo ("<a href='index.php?p_year=$p_year&p_currency=$now_currency2' class='active'>$now_currency2</a>");
									} else {
										echo ("<a href='index.php?p_year=$p_year&p_currency=$now_currency2'>$now_currency2</a>");
									}
									?>
                              </span>
                          </div>
                      </div>
                      <!--new earning end-->

                      <!--total earning start-->
                      <div class="panel green-chart">
                          <div class="panel-body">
                              <div class="chart">
                                  <div class="heading">
                                      <span>June</span>
                                      <strong>23 Days | 65%</strong>
                                  </div>
                                  <div id="barchart"></div>
                              </div>
                          </div>
                          <div class="chart-tittle">
                              <span class="title">Total Earning</span>
                              <span class="value">$, 76,54,678</span>
                          </div>
                      </div>
                      <!--total earning end-->
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-4">
                      <!--user info table start-->
                      <section class="panel">
                          <div class="panel-body">
                              <a href="#" class="task-thumb">
                                  <img src="<?=$login_photo_img1?>" style="width: 80px" alt="">
                              </a>
                              <div class="task-thumb-details">
                                  <h1><a href="#"><?=$login_name2?></a></h1>
                                  <p><?=$last_login_txt?></p>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                                <tr>
                                    <td>
                                        <i class=" fa fa-tasks"></i>
                                    </td>
                                    <td>New Task Issued</td>
                                    <td> 02</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </td>
                                    <td>Task Pending</td>
                                    <td> 14</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-envelope"></i>
                                    </td>
                                    <td>Inbox</td>
                                    <td> 45</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class=" fa fa-bell-o"></i>
                                    </td>
                                    <td>New Notification</td>
                                    <td><?=$uid_total?></td>
                                </tr>
                              </tbody>
                          </table>
                      </section>
                      <!--user info table end-->
                  </div>
                  <div class="col-lg-8">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Work Progress</h1>
                                  <p><?=$login_name2?></p>
                              </div>
                              <div class="task-option">
                                  <select class="styled">
                                      <option>Anjelina Joli</option>
                                      <option>Tom Crouse</option>
                                      <option>Jhon Due</option>
                                  </select>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                                  <td>1</td>
                                  <td>
                                      Target Sell
                                  </td>
                                  <td>
                                      <span class="badge bg-important">75%</span>
                                  </td>
                                  <td>
                                    <div id="work-progress1"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>2</td>
                                  <td>
                                      Product Delivery
                                  </td>
                                  <td>
                                      <span class="badge bg-success">43%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress2"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>3</td>
                                  <td>
                                      Payment Collection
                                  </td>
                                  <td>
                                      <span class="badge bg-info">67%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress3"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>4</td>
                                  <td>
                                      Work Progress
                                  </td>
                                  <td>
                                      <span class="badge bg-warning">30%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress4"></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td>5</td>
                                  <td>
                                      Delivery Pending
                                  </td>
                                  <td>
                                      <span class="badge bg-primary">15%</span>
                                  </td>
                                  <td>
                                      <div id="work-progress5"></div>
                                  </td>
                              </tr>
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-8">
                      <!--timeline start-->
                      <section class="panel">
                          <div class="panel-body">
                                  <div class="text-center mbot30">
                                      <h3 class="timeline-title">Timeline</h3>
                                      <p class="t-info">This is a project timeline</p>
                                  </div>

                                  <div class="timeline">
                                      <article class="timeline-item">
                                          <div class="timeline-desk">
                                              <div class="panel">
                                                  <div class="panel-body">
                                                      <span class="arrow"></span>
                                                      <span class="timeline-icon red"></span>
                                                      <span class="timeline-date">08:25 am</span>
                                                      <h1 class="red">12 July | Sunday</h1>
                                                      <p>Lorem ipsum dolor sit amet consiquest dio</p>
                                                  </div>
                                              </div>
                                          </div>
                                      </article>
                                      <article class="timeline-item alt">
                                          <div class="timeline-desk">
                                              <div class="panel">
                                                  <div class="panel-body">
                                                      <span class="arrow-alt"></span>
                                                      <span class="timeline-icon green"></span>
                                                      <span class="timeline-date">10:00 am</span>
                                                      <h1 class="green">10 July | Wednesday</h1>
                                                      <p><a href="#">Jonathan Smith</a> added new milestone <span><a href="#" class="green">ERP</a></span></p>
                                                  </div>
                                              </div>
                                          </div>
                                      </article>
                                      <article class="timeline-item">
                                          <div class="timeline-desk">
                                              <div class="panel">
                                                  <div class="panel-body">
                                                      <span class="arrow"></span>
                                                      <span class="timeline-icon blue"></span>
                                                      <span class="timeline-date">11:35 am</span>
                                                      <h1 class="blue">05 July | Monday</h1>
                                                      <p><a href="#">Anjelina Joli</a> added new album <span><a href="#" class="blue">PARTY TIME</a></span></p>
                                                      <div class="album">
                                                          <a href="#">
                                                              <img alt="" src="img/sm-img-1.jpg">
                                                          </a>
                                                          <a href="#">
                                                              <img alt="" src="img/sm-img-2.jpg">
                                                          </a>
                                                          <a href="#">
                                                              <img alt="" src="img/sm-img-3.jpg">
                                                          </a>
                                                          <a href="#">
                                                              <img alt="" src="img/sm-img-1.jpg">
                                                          </a>
                                                          <a href="#">
                                                              <img alt="" src="img/sm-img-2.jpg">
                                                          </a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </article>
                                      <article class="timeline-item alt">
                                          <div class="timeline-desk">
                                              <div class="panel">
                                                  <div class="panel-body">
                                                      <span class="arrow-alt"></span>
                                                      <span class="timeline-icon purple"></span>
                                                      <span class="timeline-date">3:20 pm</span>
                                                      <h1 class="purple">29 June | Saturday</h1>
                                                      <p>Lorem ipsum dolor sit amet consiquest dio</p>
                                                      <div class="notification">
                                                          <i class=" fa fa-exclamation-sign"></i> New task added for <a href="#">Denial Collins</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </article>
                                      <article class="timeline-item">
                                          <div class="timeline-desk">
                                              <div class="panel">
                                                  <div class="panel-body">
                                                      <span class="arrow"></span>
                                                      <span class="timeline-icon light-green"></span>
                                                      <span class="timeline-date">07:49 pm</span>
                                                      <h1 class="light-green">10 June | Friday</h1>
                                                      <p><a href="#">Jonatha Smith</a> added new milestone <span><a href="#" class="light-green">prank</a></span> Lorem ipsum dolor sit amet consiquest dio</p>
                                                  </div>
                                              </div>
                                          </div>
                                      </article>
                                  </div>

                                  <div class="clearfix">&nbsp;</div>
                              </div>
                      </section>
                      <!--timeline end-->
                  </div>
                  <div class="col-lg-4">
                      <!--revenue start-->
                      <section class="panel">
                          <div class="revenue-head">
                              <span>
                                  <i class="fa fa-bar-chart-o"></i>
                              </span>
                              <h3>Revenue</h3>
                              <span class="rev-combo pull-right">
                                 June 2013
                              </span>
                          </div>
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-lg-6 col-sm-6 text-center">
                                      <div class="easy-pie-chart">
                                          <div class="percentage" data-percent="35"><span>35</span>%</div>
                                      </div>
                                  </div>
                                  <div class="col-lg-6 col-sm-6">
                                      <div class="chart-info chart-position">
                                          <span class="increase"></span>
                                          <span>Revenue Increase</span>
                                      </div>
                                      <div class="chart-info">
                                          <span class="decrease"></span>
                                          <span>Revenue Decrease</span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="panel-footer revenue-foot">
                              <ul>
                                  <li class="first active">
                                      <a href="javascript:;">
                                          <i class="fa fa-bullseye"></i>
                                          Graphical
                                      </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class=" fa fa-th-large"></i>
                                          Tabular
                                      </a>
                                  </li>
                                  <li class="last">
                                      <a href="javascript:;">
                                          <i class=" fa fa-align-justify"></i>
                                          Listing
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </section>
                      <!--revenue end-->
                      <!--features carousel start-->
                      <section class="panel">
                          <div class="flat-carousal">
                              <div id="owl-demo" class="owl-carousel owl-theme">
                                  <div class="item">
                                      <h1>Flatlab is new model of admin dashboard for happy use</h1>
                                      <div class="text-center">
                                          <a href="javascript:;" class="view-all">View All</a>
                                      </div>
                                  </div>
                                  <div class="item">
                                      <h1>Fully responsive and build with Bootstrap 3.0</h1>
                                      <div class="text-center">
                                          <a href="javascript:;" class="view-all">View All</a>
                                      </div>
                                  </div>
                                  <div class="item">
                                      <h1>Responsive Frontend is free if you get this.</h1>
                                      <div class="text-center">
                                          <a href="javascript:;" class="view-all">View All</a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="panel-body">
                              <ul class="ft-link">
                                  <li class="active">
                                      <a href="javascript:;">
                                          <i class="fa fa-bars"></i>
                                          Sales
                                      </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class=" fa fa-calendar-o"></i>
                                          promo
                                      </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class=" fa fa-camera"></i>
                                          photo
                                      </a>
                                  </li>
                                  <li>
                                      <a href="javascript:;">
                                          <i class=" fa fa-circle"></i>
                                          other
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </section>
                      <!--features carousel end-->
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-8">
                      <!--latest product info start-->
                      <section class="panel post-wrap pro-box">
                          <aside>
                              <div class="post-info">
                                  <span class="arrow-pro right"></span>
                                  <div class="panel-body">
                                      <h1><strong>popular</strong> <br> Brand of this week</h1>
                                      <div class="desk yellow">
                                          <h3>Dimond Ring</h3>
                                          <p>Lorem ipsum dolor set amet lorem ipsum dolor set amet ipsum dolor set amet</p>
                                      </div>
                                      <div class="post-btn">
                                          <a href="javascript:;">
                                              <i class="fa fa-chevron-circle-left"></i>
                                          </a>
                                          <a href="javascript:;">
                                              <i class="fa fa-chevron-circle-right"></i>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          </aside>
                          <aside class="post-highlight yellow v-align">
                              <div class="panel-body text-center">
                                  <div class="pro-thumb">
                                      <img src="img/ring.jpg" alt="">
                                  </div>
                              </div>
                          </aside>
                      </section>
                      <!--latest product info end-->
                      <!--twitter feedback start-->
                      <section class="panel post-wrap pro-box">
                          <aside class="post-highlight terques v-align">
                              <div class="panel-body">
                                  <h2>Flatlab is new model of admin dashboard <a href="javascript:;"> http://demo.com/</a> 4 days ago  by jonathan smith</h2>
                              </div>
                          </aside>
                          <aside>
                              <div class="post-info">
                                  <span class="arrow-pro left"></span>
                                  <div class="panel-body">
                                      <div class="text-center twite">
                                          <h1>Twitter Feed</h1>
                                      </div>

                                      <footer class="social-footer">
                                          <ul>
                                              <li>
                                                  <a href="#">
                                                    <i class="fa fa-facebook"></i>
                                                  </a>
                                              </li>
                                              <li class="active">
                                                  <a href="#">
                                                      <i class="fa fa-twitter"></i>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#">
                                                      <i class="fa fa-google-plus"></i>
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#">
                                                      <i class="fa fa-pinterest"></i>
                                                  </a>
                                              </li>
                                          </ul>
                                      </footer>
                                  </div>
                              </div>
                          </aside>
                      </section>
                      <!--twitter feedback end-->
                  </div>
                  <div class="col-lg-4">
                      <div class="row">
                          <div class="col-xs-6">
                              <!--pie chart start-->
                              <section class="panel">
                                  <div class="panel-body">
                                      <div class="chart">
                                          <div id="pie-chart" ></div>
                                      </div>
                                  </div>
                                  <footer class="pie-foot">
                                      Free: 260GB
                                  </footer>
                              </section>
                              <!--pie chart start-->
                          </div>
                          <div class="col-xs-6">
                              <!--follower start-->
                              <section class="panel">
                                  <div class="follower">
                                      <div class="panel-body">
                                          <h4>Jonathan Smith</h4>
                                          <div class="follow-ava">
                                              <img src="img/follower-avatar.jpg" alt="">
                                          </div>
                                      </div>
                                  </div>

                                  <footer class="follower-foot">
                                      <ul>
                                          <li>
                                              <h5>2789</h5>
                                              <p>Follower</p>
                                          </li>
                                          <li>
                                              <h5>270</h5>
                                              <p>Following</p>
                                          </li>
                                      </ul>
                                  </footer>
                              </section>
                              <!--follower end-->
                          </div>
                      </div>
                      <!--weather statement start-->
                      <section class="panel">
                          <div class="weather-bg">
                              <div class="panel-body">
                                  <div class="row">
                                      <div class="col-xs-6">
                                        <i class="fa fa-cloud"></i>
                                          Jakarta
                                      </div>
                                      <div class="col-xs-6">
                                          <div class="degree">
                                              24<sup>o</sup>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <footer class="weather-category">
                              <ul>
                                  <li class="active">
                                      <h5>humidity</h5>
                                      56%
                                  </li>
                                  <li>
                                      <h5>precip</h5>
                                      1.50 in
                                  </li>
                                  <li>
                                      <h5>winds</h5>
                                      10 mph
                                  </li>
                              </ul>
                          </footer>

                      </section>
                      <!--weather statement end-->
                  </div>
              </div>

          </section>
      </section>
      <!--main content end-->

      <? include "right_slidebar.inc"; ?>

      <? include "footer.inc"; ?>


  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>

	<?
	// Counter 1 - Member
	// $query_count1 = "SELECT count(uid) FROM member_main WHERE branch_code = '$login_branch'";
	$query_count1 = "SELECT count(uid) FROM member_main";
	$result_count1 = mysql_query($query_count1,$dbconn);
		if (!$result_count1) { error("QUERY_ERROR"); exit; }
	$zcount1 = @mysql_result($result_count1,0,0);

	// Counter 2 - Sales
	// $query_count2 = "SELECT count(uid) FROM finance WHERE f_class = 'in' AND branch_code = '$login_branch'";
	$query_count2 = "SELECT count(uid) FROM finance WHERE f_class = 'in'";
	$result_count2 = mysql_query($query_count2,$dbconn);
		if (!$result_count2) { error("QUERY_ERROR"); exit; }
	// $zcount2 = @mysql_result($result_count2,0,0);
	$zcount2 = 927;

	// Counter 3 - Order
	// $query_count3 = "SELECT count(uid) FROM finance WHERE f_class = 'in' AND branch_code = '$login_branch'";
	$query_count3 = "SELECT count(uid) FROM finance WHERE f_class = 'in'";
	$result_count3 = mysql_query($query_count3,$dbconn);
		if (!$result_count3) { error("QUERY_ERROR"); exit; }
	// $zcount3 = @mysql_result($result_count3,0,0);
	$zcount3 = 815;

	// Counter 4 - Income
	// $query_count4 = "SELECT sum(amount) FROM finance WHERE f_class = 'in' AND currency = '$now_currency1' AND branch_code = '$login_branch'";
	$query_count4 = "SELECT sum(amount) FROM finance WHERE f_class = 'in' AND currency = '$now_currency1'";
	$result_count4 = mysql_query($query_count4,$dbconn);
		if (!$result_count4) { error("QUERY_ERROR"); exit; }
	$zcount4pre = @mysql_result($result_count4,0,0);
	// $zcount4 = $zcount4pre / 1000;
	$zcount4 = 10328;

	// Counter 5 - Delivery
	$query_count5a = "SELECT count(uid) FROM shop_product_list_qty WHERE flag = 'out'";
	$result_count5a = mysql_query($query_count5a,$dbconn);
		if (!$result_count5a) { error("QUERY_ERROR"); exit; }
	$zcount5a = @mysql_result($result_count5a,0,0);

	$query_count5 = "SELECT count(uid) FROM shop_product_list_qty WHERE flag = 'out' AND do_status > '0'";
	$result_count5 = mysql_query($query_count5,$dbconn);
		if (!$result_count5) { error("QUERY_ERROR"); exit; }
	$zcount5b = @mysql_result($result_count5,0,0);

	$ratio_zcount5_pre = ( $zcount5b / $zcount5a ) * 100;
	$zcount5 = round($ratio_zcount5_pre);
	?>

	<script>
	function countUp(count)
	{
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
	}

	countUp("<?=$zcount1?>");


	function countUp2(count)
	{
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count2'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
	}

	countUp2("<?=$zcount2?>");


	function countUp3(count)
	{
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count3'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
	}

	countUp3("<?=$zcount3?>");


	function countUp4(count)
	{
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count4'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
	}

	countUp4("<?=$zcount4?>");
	</script>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>


<? } ?>
