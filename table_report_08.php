<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "table";
$smenu = "table_report_08";

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
  // if(!$p_yearmonth) { $p_yearmonth = date("Ym",$signdate); }
  // if(!$p_month) { $p_month = date("m",$signdate); }
  // if(!$p_date) { $p_date = date("d",$signdate); }
  // if(!$p_hour) { $p_hour = date("H",$signdate); }
  
// $mode = Report Subject
if(!$mode) {
	$mode = "0801";
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
	
	<script language="javascript">
	function Popup_Win(ref) {
		var window_left = 0;
		var window_top = 0;
		ref = ref;      
		window.open(ref,"printpreWin",'width=810,height=650,status=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$title_report?> &gt; <?=$title_report_08?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			$mode = $_GET['mode'];
			$p_year = $_GET['p_year'];
			$p_month = $_GET['p_month'];
			$p_yearmonth = $_GET['p_yearmonth'];
			$keyA = $_GET['keyA'];
			$keyB = $_GET['keyB'];
			echo ("
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
				
				// Report Subjects
				if($mode == "0801") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0801&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0801</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0801&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0801</a></option>");
				}
				if($mode == "0802") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0802&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0802</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0802&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0802</a></option>");
				}
				if($mode == "0803") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0803&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0803</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0803&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0803</a></option>");
				}
				if($mode == "0804") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0804&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0804</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0804&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0804</a></option>");
				}
				if($mode == "0805") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0805&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0805</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0805&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0805</a></option>");
				}
				if($mode == "0806") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0806&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0806</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0806&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0806</a></option>");
				}
				if($mode == "0811") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0811&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0811</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0811&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0811</a></option>");
				}
				if($mode == "0812") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0812&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0812</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0812&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0812</a></option>");
				}
				if($mode == "0813") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0813&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$title_report_0813</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=0813&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth'>$title_report_0813</a></option>");
				}
				
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>");
				
				// Months
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
				echo ("<option value='$PHP_SELF?keyA=$keyA&mode=$mode&p_year=$p_year'>:: $txt_comm_month</a></option>");
				
				for($m = $m_s; $m <= $m_f; $m++) {

					$mm = sprintf("%02d", $m);
					$this_month_set = "$p_year"."$mm";
					
					$mm_txt = "txt_comm_month_"."$mm";
      
					if($mm == $p_month) {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set' selected>${$mm_txt}</a></option>");
					} else {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set'>${$mm_txt}</a></option>");
					}
    
				}
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>");
				
				// Years
				$yy_s = $rs_year;
				$yy_f = $this_year;
    
				echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

				for($yy = $yy_s; $yy <= $yy_f; $yy++) {

					if($p_year == $yy) {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth' selected>$yy</a></option>");
					} else {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth'>$yy</a></option>");
					}

				}
				echo ("
				</select>
			</div>
			
			
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF'>:: $txt_comm_frm30</option>");
			
				$query_guc = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
				$result_guc = mysql_query($query_guc);
				$total_guc = @mysql_result($result_guc,0,0);

				$query_gu = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
				$result_gu = mysql_query($query_gu);
			
				for($gu = 0; $gu < $total_guc; $gu++) {
					$k_branch_code = mysql_result($result_gu,$gu,0);
					$k_branch_name = mysql_result($result_gu,$gu,1);
        
					if($k_branch_code == $keyA) {
						$slc_branch = "selected";
					} else {
						$slc_branch = "";
					}
				
					echo ("<option value='$PHP_SELF?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth' $slc_branch>$k_branch_name</option>");
				}
			
				echo ("
				</select>
			</div>
			");
			
			?>
			
			</div>
			
			<div>&nbsp;</div>
			
			

			<?
			if($mode) {
				$main_module = "div_report_"."$mode".".inc";
			} else {
				$main_module = "div_report_0801.inc";
			}

			include "$main_module";
			?>
		
		</section>
        </div>
		
        </section>
		</div>
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
	
	<script src="js/jquery.donutchart.js"></script>
	
	<script>
	(function () {

        $("#donutchart1").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
        $("#donutchart2").donutchart("animate");

        $("#donutchart3").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart3").donutchart("animate");

        $("#donutchart4").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");
		
		$("#donutchart6").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart6").donutchart("animate");
		
		$("#donutchart7").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart7").donutchart("animate");

    }());
	</script>


  </body>
</html>


<? } ?>