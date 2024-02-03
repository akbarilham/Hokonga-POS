<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_xchange";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_xchange.php";
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
   $query = "SELECT count(uid) FROM shop_xchange";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM shop_xchange WHERE $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_09_20?> &nbsp; 
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Currency</th>
            <th colspan=2>Exchange Rate</th>
			<th>Update</th>
			<th>URL</th>
			<th>Date</th>
			<th><?=$txt_comm_frm12?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$query_max = "SELECT uid FROM shop_xchange ORDER BY upd_date DESC";
		$result_max = mysql_query($query_max);
		if (!$result_max) {   error("QUERY_ERROR");   exit; }

		$uid_max = @mysql_result($result_max,0,0);
   
   
		if(!eregi("[^[:space:]]+",$key)) {
			$query = "SELECT uid,xchange_rate,xchange_update_flag,xchange_update_url,upd_date FROM shop_xchange ORDER BY upd_date DESC";
		} else {
			$query = "SELECT uid,xchange_rate,xchange_update_flag,xchange_update_url,upd_date FROM shop_xchange 
					WHERE $keyfield LIKE '%$key%' ORDER BY upd_date DESC";
		}

		$result = mysql_query($query);
		if (!$result) {   error("QUERY_ERROR");   exit; }

		$article_num = $total_record - $num_per_page*($page-1);

		for($i = $first; $i <= $last; $i++) {
			$uid = mysql_result($result,$i,0);
			$xchange_rate = mysql_result($result,$i,1);
			$xchange_update_flag = mysql_result($result,$i,2);
			$xchange_update_url = mysql_result($result,$i,3);
			$xchange_date = mysql_result($result,$i,4);
			
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
			<td>$now_currency2</td>
    
			<form name='signform1' method='post' action='system_xchange.php'>
			<input type='hidden' name='step_next' value='permit_update'>
			<input type='hidden' name='new_uid' value=\"$uid\">
    
			<td><input type=text class='form-control' name='xchange_rate' maxlength=12 value=\"$xchange_rate\" style='text-align: right'></td>
			<td>= 1 $now_currency1</td>
			
			<td>
				<select name='xchange_update_flag' class='form-control'>");
				if($xchange_update_flag == "0") {
					echo ("<option value='0' selected>Offline</option>");
					echo ("<option value='1'>Specfic URL</option>");
				} else if($xchange_update_flag == "1") {
					echo ("<option value='0'>Offline</option>");
					echo ("<option value='1' selected>Specfic URL</option>");
				}
				echo ("
				</select>
			</td>
			<td><input type=text class='form-control' name='xchange_update_url' value=\"$xchange_update_url\"></td>
			<td>$xchange_date_txt, $xchange_time_txt</td>
			<td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default'></td>
			</form>
			</tr>
			");
			
			
			} else {
			
			echo ("
			<tr>
			<td>$now_currency2</td>
    
			<td><input disabled type=text class='form-control' name='xchange_rate' maxlength=12 value=\"$xchange_rate\" style='text-align: right'></td>
			<td>= 1 $now_currency1</td>
			
			<td>
				<select disabled name='xchange_update_flag' class='form-control'>");
				if($xchange_update_flag == "0") {
					echo ("<option value='0' selected>Offline</option>");
					echo ("<option value='1'>Specfic URL</option>");
				} else if($xchange_update_flag == "1") {
					echo ("<option value='0'>Offline</option>");
					echo ("<option value='1' selected>Specfic URL</option>");
				}
				echo ("
				</select>
			</td>
			<td><input disabled type=text class='form-control' name='xchange_update_url' value=\"$xchange_update_url\"></td>
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
	
	
	// Current Exchange Data
	$max_query = "SELECT xchange_rate FROM shop_xchange ORDER BY upd_date DESC";
	$max_result = mysql_query($max_query);
		if (!$max_result) { error("QUERY_ERROR"); exit; }
	$max_xchange_rate = @mysql_result($max_result,0,0);

	
	// Add Currency Exchange Data
	if($xchange_rate == $max_xchange_rate) {
	
		$result1 = mysql_query("UPDATE shop_xchange SET xchange_update_flag = '$xchange_update_flag', xchange_update_url = '$xchange_update_url' 
					WHERE uid = '$new_uid'");
		if (!$result1) { error("QUERY_ERROR"); exit; }
		
	} else {
	
		$query_P2 = "INSERT INTO shop_xchange (uid,branch_code,xchange_rate,xchange_update_flag,xchange_update_url,upd_date) 
				values ('','$login_branch','$xchange_rate','$xchange_update_flag','$xchange_update_url','$post_dates')";
		$result_P2 = mysql_query($query_P2);
		if (!$result_P2) { error("QUERY_ERROR"); exit; }
	
	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_xchange.php'>");
	exit;

}

}
?>