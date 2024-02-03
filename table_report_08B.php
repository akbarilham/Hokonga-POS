<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "table";
$smenu = "table_report_08B";

// $report_last_date = "YYYY1231";
// $report_start_date = "YYYY0101";
$rs_year = substr($report_start_date,0,4);
$rs_month = substr($report_start_date,4,2);
$rs_date = substr($report_start_date,6,2);

  // Date
  $signdate = time();

  // Date Formats
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
	$mode = "08B01";
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

    <!--dynamic table-->
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
	
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
            <?=$title_report?> &gt; <?=$title_report_08B?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
				
				// Report Subjects
				if($mode == "08B01") {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=08B01&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$dept' selected>$title_report_08B01</a></option>");
				} else {
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=08B01&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$dept'>$title_report_08B01</a></option>");
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
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set&hr_type=$hr_type&div=$div&dept=$dept' selected>${$mm_txt}</a></option>");
					} else {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$mm&p_yearmonth=$this_month_set&hr_type=$hr_type&div=$div&dept=$dept'>${$mm_txt}</a></option>");
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
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$dept' selected>$yy</a></option>");
					} else {
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$dept'>$yy</a></option>");
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
				
					echo ("<option value='$PHP_SELF?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$dept' $slc_branch>$k_branch_name</option>");
				}
			
				echo ("
				</select>
			</div>
			");
			
			?>
			
			</div>
			<div>&nbsp;</div>
			<div class="row">
				<div class='col-sm-4'>
				<?php
				
					if($hr_type == 1) {
						$slc_type1 = "selected";
					}elseif($hr_type == 2){
						$slc_type2 = "selected";
					}elseif($hr_type == 3){
						$slc_type3 = "selected";
					}else{
						$slc_type4 = "selected";
					}

				$hr_type1 = 1;
				$hr_type2 = 2;
				$hr_type3 = 3;
				$hr_type4 = 4;
				echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type4&div=$div&dept=$dept' $slc_type4> :: All Employee</option>
				<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type1&div=$div&dept=$dept' $slc_type1>Reguler</option>
				<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type2&div=$div&dept=$dept' $slc_type2>Non-Reguler(SA)</option>
				<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type3&div=$div&dept=$dept' $slc_type3>Temporary</option>
				");
				
			
				echo ("
				</select>
			</div>
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF'>:: Division</option>");
				$query_div = "SELECT count(uid) FROM dept_catgbig";
				$result_div = mysql_query($query_div);
				$total_div = @mysql_result($result_div,0,0);

				$query_divs = "SELECT lcode,lname FROM dept_catgbig order by uid asc";
				$result_divs = mysql_query($query_divs);
			
				for($divs = 0; $divs < $total_div; $divs++) {
					$lcode = mysql_result($result_divs,$divs,0);
					$lname = mysql_result($result_divs,$divs,1);
        			
					if($lcode == $div) {
						$lc = "selected";
					} else {
						$lc = "";
					}
				
					echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$lcode' $lc>$lname</option>");
				
				}
			
		
				echo ("
				</select>
			</div>
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF'>:: Departement</option>");
			
				if(!$div){
					$dis = "uid != ''";
				}else{
					$dis = "lcode = '$div'";
				}
				$query_dept = "SELECT count(uid) FROM dept_catgmid WHERE $dis";
				$result_dept = mysql_query($query_dept);
				$total_dept = @mysql_result($result_dept,0,0);

				

				$query_depts = "SELECT mcode,mname FROM dept_catgmid WHERE $dis order by uid asc";
				$result_depts = mysql_query($query_depts);

				//echo (" <optgroup label='Swedish Cars'>");
					for($depts = 0; $depts < $total_dept; $depts++) {
						$mcode = mysql_result($result_depts,$depts,0);
						$mname = mysql_result($result_depts,$depts,1);
	        			
						if($mcode == $dept) {
							$mc = "selected";
						} else {
							$mc = "";
						}
						
						echo ("<option value='$PHP_SELF?keyA=$keyA&keyB=$keyB&mode=$mode&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&hr_type=$hr_type&div=$div&dept=$mcode' $mc>$mname</option>");
						
					}
				//echo (" </optgroup>");

				?>
				</select>
			</div>

			</div>
			<div>&nbsp;</div>
			
			

			<?
			if($mode) {
				$main_module = "div_report_"."$mode".".inc";
			} else {
				$main_module = "div_report_08B01.inc";
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
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

	<script src="js/dynamic_table_init2.js"></script>
	
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