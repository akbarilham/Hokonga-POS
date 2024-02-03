<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "yearly_stock_cvj";
$step_next = $_POST['step_next'];
if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/yearly_stock_cvj.php";


$query_cnts = "SELECT count(pnum) FROM table_ini_stock";
$result_cnts = mysql_query($query_cnts);
$total_cnts = @mysql_result($result_cnts,0,0);
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
if(!$sorting_key) { $sorting_key = "pnum"; }

if($sorting_key == "org_pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "shop_code") { $chk2 = "selected"; } else { $chk2 = ""; }
if(!$sort_now) { $sort_now = "ASC"; }



//===================== new page code ======================
//Yogi Anditia
if(!$page) { 
  if(isset($_GET['page'])){
    $page = intval($_GET['page']); //get value from url
    if(intval($_GET['page'])==null){
      $page = 1;
    }else{
      $page = intval($_GET['page']); 
    }
  }else{
    $page = 1;
  }
}
//===========================================================


if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(org_pcode), shop_code FROM summary_cvj_2015";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(org_pcode), shop_code FROM summary_cvj_2015 WHERE $keyfield LIKE '%$key%' ";  
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

$query_ini = "SELECT count(org_pcode) FROM summary_cvj_2015";
$result_ini = mysql_query($query_ini);
	if (!$result_ini) { error("QUERY_ERROR"); exit; }
$total_ini_store = @mysql_result($result_ini,0,0);
?>
    

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Data Mining - Monthly Stock Opname (<?=$total_record?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			$sort_now=$_GET['sort_now'];
			echo ("
			<form name='search' method='post' action='yearly_stock_cvj.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='pnum'>#</option>
				<option value='org_pcode' $chk1>Product Code</option>
				<option value='shop_code' $chk2>Shop Code</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'>
			</div>
			</form>
			
		
			<div class='col-sm-3' align=right>");
				if($sort_now == "DESC") {
					echo ("
					<a href='$PHP_SELF?sorting_key=$sorting_key&sort_now=ASC&keyfield=$keyfield&key=$key'>ASC</a> &nbsp;&nbsp; 
					<a href='$PHP_SELF?sorting_key=$sorting_key&sort_now=DESC&keyfield=$keyfield&key=$key'><u>DESC</u></a>");
				} else {
					echo ("
					<a href='$PHP_SELF?sorting_key=$sorting_key&sort_now=ASC&keyfield=$keyfield&key=$key'><u>ASC</u></a> &nbsp;&nbsp; 
					<a href='$PHP_SELF?sorting_key=$sorting_key&sort_now=DESC&keyfield=$keyfield&key=$key'>DESC</a>");
				}
				echo ("
			</div>
			
			<div class='col-sm-3'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=pnum&sort_now=$sort_now&keyfield=$keyfield&key=$key'>#</option>
				<option value='$PHP_SELF?sorting_key=org_pcode&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk1>Product Code</option>
				<option value='$PHP_SELF?sorting_key=shop_code&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk2>Shop Code</option>				
				</select>
			</div>
			");
			
			?>
			
			</div>
			
			<div>&nbsp;</div>
			
		
		
        <?
		if(!eregi("[^[:space:]]+",$key)) {
			$query = "SELECT pnum,org_pcode,shop_code,stocks FROM summary_cvj_2015 GROUP BY org_pcode ORDER BY $sorting_key $sort_now";
		} else {
			$query = "SELECT pnum,org_pcode,shop_code,stocks FROM summary_cvj_2015 WHERE $keyfield LIKE '%$key%' GROUP BY org_pcode ORDER BY $sorting_key $sort_now";
		}

		$result = mysql_query($query);
		if (!$result) {   error("QUERY_ERROR");   exit; }

		$article_num = $total_record - $num_per_page*($page-1);
		?>
			
		<?
			
				if($key == '') {
					echo 'Isi kode';
				} else {
		?>
		<div class="row">
		<div class='col-sm-3'>
				<section>
				<table class="table table-bordered table-condensed">
				<thead>
				<tr>
					<th>#</th>
					<th>Prd. Code</th>
					<th>Remarks</th>
				</tr>
				</thead>
		
		
				<tbody>
				<?
				for($i = $first; $i <= $last; $i++) {
					$pnum = mysql_result($result,$i,0);
					$org_pcode = mysql_result($result,$i,1);
					$shop_code = mysql_result($result,$i,2);

					// Duplication Check
					$query_pr = "SELECT count(org_pcode),pname FROM shop_product_list WHERE org_pcode = '$org_pcode'";
					$result_pr = mysql_query($query_pr);
						if (!$result_pr) { error("QUERY_ERROR"); exit; }
					$pr_count = @mysql_result($result_pr,0,0);
					$pr_pname = @mysql_result($result_pr,0,1);
					
					if($pr_count > 1) { // Duplicated
						$pr_color = "#FAFAA0";
						$pr_duple_txt = "Duplicated";
					} else if($pr_count < 1) { // No Registered
						$pr_color = "gold";
						$pr_duple_txt = "No Regis.";
					} else {
						$pr_color = "";
						$pr_duple_txt = "";
					}
					
					echo ("
					<tr>
						<td>$pnum</td>
						<td bgcolor='$pr_color'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='left' 
							data-original-title='$pr_pname'>$org_pcode</a></td>
						<td>$pr_duple_txt</td>
					</tr>");

				}
				?>
				</tbody>
				</table>
				</section>
			
		</div>

		<div class='col-sm-9'>
				<section style='overflow:scroll;overflow-y:hidden;'>
				<table class="table table-bordered table-condensed">
				<thead>
				<tr>
				<?
				
					$store_branch = "CORP_03";
					$store_branch_name = "CVJ";
					$total_ini_store = 12;
					

					for($num=1; $num<=$total_ini_store; $num++) {
						
						$num2 = sprintf("%02d", $num); # print_r($num2); die();
						/*
						$query_str = "SELECT shop_code FROM table_store_name_cvj WHERE num = '$num2'";
						$result_str = mysql_query($query_str);
							if (!$result_str) { error("QUERY_ERROR"); exit; }
						$shop_code = @mysql_result($result_str,0,0);*/
						//$shop_name = @mysql_result($result_str,0,1);

						# print_r($new_shop_name);
						
						$month = array('1' => 'January', 
									   '2' => 'February',
									   '3' => 'March',
									   '4' => 'April',
									   '5' => 'May',
									   '6' => 'June',
									   '7' => 'July',
									   '8' => 'August',
									   '9' => 'September',
									   '10'=> 'October',
									   '11'=> 'November',
									   '12'=> 'Desember'
							 	);
						$months = $month[$num];
						$info = cal_info(0);
						echo ("<th colspan=6><div style='width: 100px'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' 
							data-original-title='$store_branch_name &gt; $new_shop_name'>$num. $months</a></div></th>");
						
					}
					
					echo ("<th colspan=6>TOTAL</th>");

				
				?>
				</tr>
				</thead>
				<tbody>
				<tr>
				<?
				$total_ini_store = 12;
				for($i2 = $first; $i2 <= $last; $i2++) {
					//print_r($shop_code); //die();
							 $query2 = "SELECT pnum, org_pcode,stocks
                                FROM summary_cvj_2015 WHERE shop_code = '$shop_code'
                                ORDER BY shop_code ASC";
			                    $result2 = mysql_query($query2);
			                    if (!$result2) {
			                           error("QUERY_ERROR");
			                           exit;
			                    }

		                        $pnum2 = mysql_result($result2,$i2,0);
		                        $org_pcode2 = mysql_result($result2,$i2,1);
		                        $stocks = mysql_result($result2,$i2,2);
		                        $sp_opt2 = explode("|", $stocks);
		                       
					echo ("<tr>");
					for($o2=0; $o2<count($sp_opt2); $o2++) {
						

						if ($sp_opt2 == null){
							echo ("<td style='border: 1px solid #DEDEDE;'><div style='width: 40px;'>&nbsp;&nbsp;</div></td>");
						}else{
							echo ("<td style='border: 1px solid #DEDEDE;'><div style='width: 40px;'>$sp_opt2[$o2]&nbsp;</div></td>");
						}
					}
					echo ("</tr>");
				}
				?>
				</tr>
				</tbody>
				</table>
				</section>
			<? } ?>
		</div>
		</div>
		
		
				
				
				
				
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
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$page_num&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&sort_now=$sort_now&page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
				}
				?>
				</ul>
		
		
        </div>
		
				
				<?
				/*
				echo ("
				<form name='trimform2' method='post' action='restore_stock_opname_list.php'>
				<input type='hidden' name='step_next' value='permit_trim2'>
				<input type='hidden' name='sorting_key' value='$sorting_key'>
				<input type='hidden' name='sort_now' value='$sort_now'>
				<input type='hidden' name='keyfield' value='$keyfield'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='page' value='$page'>
				
				<input class='btn btn-primary' type='submit' value='Update Initial Stock Data now !'>
				</form>");
				*/
				?>
		
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


  </body>

</html>


<?
} if($step_next == "permit_trim1") {

		
		$queryC2 = "SELECT count(pnum) FROM table_ini_stock";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT pnum,org_pcode,total_qty FROM table_ini_stock ORDER BY pnum ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_pnum = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_total_qty = mysql_result($resultD2,$ra,2);
			
			echo ("Writing $R_pnum ...<br>");
			
			
			
		
		}
		
	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;


} else if($step_next == "permit_trim2") { // Store Update : IMPORTANT !!!

		$queryC2 = "SELECT count(pnum) FROM table_ini_stock";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT pnum,org_pcode,total_qty FROM table_ini_stock ORDER BY pnum ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_pnum = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_total_qty = mysql_result($resultD2,$ra,2);
			
			echo ("Writing $R_pnum ...<br>");
			
			if($R_new_code) {
				/*
				$result_U1 = mysql_query("UPDATE client_shop SET shop_code = '$R_new_code' WHERE num_tmp = '$R_num'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
				*/
			}
		
		}

	echo("<meta http-equiv='Refresh' content='10; URL=$home/restore_stock_opname_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;
	

} else if($step_next == "permit_delete") {

	$query = "DELETE FROM table_ini_stock WHERE pnum = '$org_pnum'";
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

} else if($step_next == "permit_update") {

	$signdate = time();
	$signdates1 = date("Ymd",$signdate); 
	$signdates2 = date("His",$signdate); 
  
	$m_ip = getenv('REMOTE_ADDR');
	$new_sname = addslashes($new_sname);

	$result = mysql_query("UPDATE table_ini_stock SET total_qty = '$new_qty' WHERE pnum = '$org_pnum'");
	if (!$result) { error("QUERY_ERROR"); exit;	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;
}
