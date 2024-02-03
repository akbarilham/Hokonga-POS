<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_incentive_fbs";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_incentive_fbs.php";
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
if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM payroll_setup_incentive_fbs";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM payroll_setup_incentive_fbs WHERE $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);
?>
    

						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Incentive Calculation - Feel Buy Shop
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>HPP Rate (%)</th>
            <th>Per-Profit Rate (%)</th>
			<th>Date</th>
			<th><?=$txt_comm_frm12?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$query_max = "SELECT uid FROM payroll_setup_incentive_fbs ORDER BY upd_date DESC";
		$result_max = mysql_query($query_max);
		if (!$result_max) {   error("QUERY_ERROR");   exit; }

		$uid_max = @mysql_result($result_max,0,0);
   
   
		if(!eregi("[^[:space:]]+",$key)) {
			$query = "SELECT uid,hpp_rate,profit_rate,upd_date FROM payroll_setup_incentive_fbs ORDER BY upd_date DESC";
		} else {
			$query = "SELECT uid,hpp_rate,profit_rate,upd_date FROM payroll_setup_incentive_fbs
					WHERE $keyfield LIKE '%$key%' ORDER BY upd_date DESC";
		}

		$result = mysql_query($query);
		if (!$result) {   error("QUERY_ERROR");   exit; }

		$article_num = $total_record - $num_per_page*($page-1);

		for($i = $first; $i <= $last; $i++) {
			$uid = mysql_result($result,$i,0);
			$hpp_rate = mysql_result($result,$i,1);
			$profit_rate = mysql_result($result,$i,2);
			$xchange_date = mysql_result($result,$i,3);
			
			$xchange_date1 = substr($xchange_date,0,4);
			$xchange_date2 = substr($xchange_date,4,2);
			$xchange_date3 = substr($xchange_date,6,2);
			$xchange_time1 = substr($xchange_date,8,2);
			$xchange_time2 = substr($xchange_date,10,2);
			$xchange_time3 = substr($xchange_date,12,2);
			
			if($lang == "ko") {
				$xchange_date_txt = "$xchange_date1"."/"."$xchange_date2"."/"."$xchange_date3";
			} else {
				$xchange_date_txt = "$xchange_date3"."-"."$xchange_date2"."-"."$xchange_date1";
			}
			
			$xchange_time_txt = "$xchange_time1".":"."$xchange_time2".":"."$xchange_time3";
		
		
			if($uid == $uid_max) {
			
			echo ("
			<tr>
			<form name='signform1' method='post' action='system_incentive_fbs.php'>
			<input type='hidden' name='step_next' value='permit_update'>
			<input type='hidden' name='new_uid' value=\"$uid\">
    
			<td><input type=text class='form-control' name='hpp_rate' maxlength=10 value=\"$hpp_rate\" style='text-align: right'></td>
			<td><input type=text class='form-control' name='profit_rate' maxlength=10 value=\"$profit_rate\" style='text-align: right'></td>
			<td>$xchange_date_txt, $xchange_time_txt</td>
			<td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default'></td>
			</form>
			</tr>
			");
			
			
			echo ("
			<tr>
				<td>Average DC Rate</td>
				<td>Offset</td>
				<td></td>
				<td></td>
			</tr>");
				
			// Sub Table
			$query_ftmx = "SELECT uid,dc_avrg,dc_offset FROM payroll_setup_incentive_fbs_sub WHERE org_uid = '$uid' ORDER BY dc_avrg ASC";
			$result_ftmx = mysql_query($query_ftmx,$dbconn);
			$row_ftmx = mysql_num_rows($result_ftmx);

				while($row_ftmx = mysql_fetch_object($result_ftmx)) {
					$ftmx_uid = $row_ftmx->uid;
					$ftmx_dc_avrg = $row_ftmx->dc_avrg;
					$ftmx_dc_offset = $row_ftmx->dc_offset;
					
				
				// Ratio Update
				echo ("
				<form name='signform_upd' method='post' action='system_incentive_fbs.php'>
				<input type='hidden' name='step_next' value='permit_subupd'>
				<input type='hidden' name='new_sub_uid' value=\"$ftmx_uid\">
				<tr>
					<td><input type=text class='form-control' name='sub_dc_avrg' maxlength=10 value=\"$ftmx_dc_avrg\" style='text-align: right'></td>
					<td><input type=text class='form-control' name='sub_dc_offset' maxlength=10 value=\"$ftmx_dc_offset\" style='text-align: right'></td>
					<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default'></td>
				</form>
				
				<form name='signform_upd' method='post' action='system_incentive_fbs.php'>
				<input type='hidden' name='step_next' value='permit_subdel'>
				<input type='hidden' name='new_sub_uid' value=\"$ftmx_uid\">
					<td><input type='submit' value='$txt_comm_frm13' class='btn btn-default'></td>
				</form>
				
				</tr>
				</form>");
			
				}
			
				// Ratio Input
				echo ("
				<form name='signform_upd' method='post' action='system_incentive_fbs.php'>
				<input type='hidden' name='step_next' value='permit_subadd'>
				<input type='hidden' name='new_uid' value=\"$uid\">
				<tr>
					<td><input type=text class='form-control' name='sub_dc_avrg' maxlength=10 style='text-align: right'></td>
					<td><input type=text class='form-control' name='sub_dc_offset' maxlength=10 style='text-align: right'></td>
					<td><input type='submit' value='Add' class='btn btn-default'></td>
					<td></td>
				</tr>
				</form>");
			
			
			
			
			} else {
			
			echo ("
			<tr>
			<td><input disabled type=text class='form-control' name='hpp_rate' maxlength=10 value=\"$hpp_rate\" style='text-align: right'></td>
			<td><input disabled type=text class='form-control' name='profit_rate' maxlength=10 value=\"$profit_rate\" style='text-align: right'></td>
			<td>$xchange_date_txt, $xchange_time_txt</td>
			<td></td>
			</tr>
			");
			
			}
		
		
		}
		
		
		?>
		
        </tbody>
        </table>
		</section>
		
			<ul class="pagination pagination-sm pull-right">
				<?
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
				}
				?>
				</ul>
		
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
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>

</html>


<?
} else if($step_next == "permit_update") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	
	// Current Data
	$max_query = "SELECT hpp_rate,profit_rate,uid FROM payroll_setup_incentive_fbs ORDER BY upd_date DESC";
	$max_result = mysql_query($max_query);
		if (!$max_result) { error("QUERY_ERROR"); exit; }
	$max_hpp_rate = @mysql_result($max_result,0,0);
	$max_profit_rate = @mysql_result($max_result,0,1);
	$max_uid = @mysql_result($max_result,0,2);
	
	$new_max_uid = $max_uid + 1;

	
	// Add & Update Data
	if($hpp_rate == $max_hpp_rate AND $profit_rate == $max_profit_rate) {
	
		$result1 = mysql_query("UPDATE payroll_setup_incentive_fbs SET hpp_rate = '$hpp_rate', profit_rate = '$profit_rate' WHERE uid = '$new_uid'");
		if (!$result1) { error("QUERY_ERROR"); exit; }

		
	} else {
	
		$query_P2 = "INSERT INTO payroll_setup_incentive_fbs (uid,branch_code,hpp_rate,profit_rate,upd_date) 
				values ('$new_max_uid','$login_branch','$hpp_rate','$profit_rate','$post_dates')";
		$result_P2 = mysql_query($query_P2);
		if (!$result_P2) { error("QUERY_ERROR"); exit; }
		
		// Create Default Sub Table
		$query_suc = "SELECT count(uid) FROM payroll_setup_incentive_fbs_sub WHERE org_uid = '$max_uid'";
        $result_suc = mysql_query($query_suc);
          if (!$result_suc) { error("QUERY_ERROR"); exit; }
        $sub_cnt = @mysql_result($result_suc,0,0);
		
		$query_sub = "SELECT dc_avrg,dc_offset FROM payroll_setup_incentive_fbs_sub WHERE org_uid = '$max_uid' ORDER BY uid ASC";
        $result_sub = mysql_query($query_sub);
          if (!$result_sub) { error("QUERY_ERROR"); exit; }
		
		for($s=0;$s<$sub_cnt;$s++) {
			$sub_dc_avrg = mysql_result($result_sub,$s,0);
			$sub_dc_offset = mysql_result($result_sub,$s,1);
			
			$query_s2 = "INSERT INTO payroll_setup_incentive_fbs_sub (uid,org_uid,branch_code,dc_avrg,dc_offset) 
				values ('','$new_max_uid','$login_branch','$sub_dc_avrg','$sub_dc_offset')";
			$result_s2 = mysql_query($query_s2);
			if (!$result_s2) { error("QUERY_ERROR"); exit; }
		}
		
		
	
	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_incentive_fbs.php'>");
	exit;


} else if($step_next == "permit_subdel") {

		$result_D = mysql_query("DELETE FROM payroll_setup_incentive_fbs_sub WHERE uid = '$new_sub_uid'");
		if (!$result_D) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_incentive_fbs.php'>");
	exit;


} else if($step_next == "permit_subupd") {

		$result1 = mysql_query("UPDATE payroll_setup_incentive_fbs_sub SET dc_avrg = '$sub_dc_avrg', dc_offset = '$sub_dc_offset' WHERE uid = '$new_sub_uid'");
		if (!$result1) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_incentive_fbs.php'>");
	exit;



} else if($step_next == "permit_subadd") {

		$query_P2 = "INSERT INTO payroll_setup_incentive_fbs_sub (uid,org_uid,branch_code,dc_avrg,dc_offset) 
				values ('','$new_uid','$login_branch','$sub_dc_avrg','$sub_dc_offset')";
		$result_P2 = mysql_query($query_P2);
		if (!$result_P2) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_incentive_fbs.php'>");
	exit;

}

}
?>