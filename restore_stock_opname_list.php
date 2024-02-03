<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_stock_opname_list";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/restore_stock_opname_list.php";


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
if(!$sort_now) { $sort_now = "ASC"; }




if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(pnum) FROM table_ini_stock";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(pnum) FROM table_ini_stock WHERE $keyfield LIKE '%$key%'";  
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

$query_ini = "SELECT count(num) FROM table_ini_store";
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
            Data Mining - table_ini_stock (<?=$total_record?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='restore_stock_opname_list.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='pnum'>#</option>
				<option value='org_pcode' $chk1>Product Code</option>
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
				</select>
			</div>
			");
			
			?>
			
			</div>
			
			<div>&nbsp;</div>
			
		
		
        <?
		if(!eregi("[^[:space:]]+",$key)) {
			$query = "SELECT pnum,org_pcode,total_qty,stores FROM table_ini_stock ORDER BY $sorting_key $sort_now";
		} else {
			$query = "SELECT pnum,org_pcode,total_qty,stores FROM table_ini_stock WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
		}

		$result = mysql_query($query);
		if (!$result) {   error("QUERY_ERROR");   exit; }

		$article_num = $total_record - $num_per_page*($page-1);
		?>
		
		<div class="row">
		<div class='col-sm-3'>
				<section>
				<table class="table table-bordered table-condensed">
				<thead>
				<tr>
					<th>#</th>
					<th>Prd. Code</th>
					<th>Total</th>
				</tr>
				</thead>
		
		
				<tbody>
				<?
				for($i = $first; $i <= $last; $i++) {
					$pnum = mysql_result($result,$i,0);
					$org_pcode = mysql_result($result,$i,1);
					$total_qty = mysql_result($result,$i,2);
					
					$query_pr = "SELECT pname FROM shop_product_list WHERE org_pcode = '$org_pcode'";
					$result_pr = mysql_query($query_pr);
						if (!$result_pr) { error("QUERY_ERROR"); exit; }
					$pr_pname = @mysql_result($result_pr,0,0);
					
					echo ("
					<tr>
						<td>$pnum</td>
						<td><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='left' 
							data-original-title='$pr_pname'>$org_pcode</a></td>
						<td>$total_qty</td>
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
				

					for($num=1; $num<=$total_ini_store; $num++) {
						
						if($num > 537) { // WH
				
							if($num == 538) {
								$gd_shop_code = "WH_02";
							} else if($num == 539) {
								$gd_shop_code = "WH_06";
							} else if($num == 540) {
								$gd_shop_code = "WH_07";
							} else if($num == 541) {
								$gd_shop_code = "WH_08";
							}
				
							$query_gd = "SELECT branch_code,gudang_name FROM code_gudang WHERE gudang_code = '$gd_shop_code'";
							$result_gd = mysql_query($query_gd);
								if (!$result_gd) { error("QUERY_ERROR"); exit; }
							$gd_branch_code = @mysql_result($result_gd,0,0);
							$gd_shop_name = @mysql_result($result_gd,0,1);
						
						} else {
						
							// Shop List
							$query_sh = "SELECT shop_code,branch_code,associate,group_code,shop_name FROM client_shop WHERE num_tmp = '$num'";
							$result_sh = mysql_query($query_sh);
								if (!$result_sh) { error("QUERY_ERROR"); exit; }
							$gd_shop_code = @mysql_result($result_sh,0,0);
							$gd_branch_code = @mysql_result($result_sh,0,1);
							$gd_associate = @mysql_result($result_sh,0,2);
							$gd_group_code = @mysql_result($result_sh,0,3);
							$gd_shop_name = @mysql_result($result_sh,0,4);
							
							// Warehouse
							$query_gd = "SELECT gudang_code FROM code_gudang WHERE branch_code = '$sh_branch_code' ORDER BY gudang_code ASC";
							$result_gd = mysql_query($query_gd);
								if (!$result_gd) { error("QUERY_ERROR"); exit; }
							$gd_gudang_code = @mysql_result($result_gd,0,0);
							
						}
						
						$query_br = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$gd_branch_code'";
						$result_br = mysql_query($query_br);
							if (!$result_br) { error("QUERY_ERROR"); exit; }
						$br_branch_name = @mysql_result($result_br,0,0);
						
						echo ("<th><div style='width: 100px'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' 
							data-original-title='$br_branch_name &gt; $gd_shop_name'>$gd_shop_code</a></div></th>");
					}

				
				?>
				</tr>
				</thead>
		
		
				<tbody>
				<?
				for($i2 = $first; $i2 <= $last; $i2++) {
					$pnum2 = mysql_result($result,$i2,0);
					$org_pcode2 = mysql_result($result,$i2,1);
					$total_qty2 = mysql_result($result,$i2,2);
					$stores2 = mysql_result($result,$i2,3);
					
					$sp_opt2 = explode("|", $stores2);

					echo ("<tr>");
					for($o2=0; $o2<count($sp_opt2); $o2++) {
						echo ("<td style='border: 1px solid #DEDEDE;'><div style='width: 100px'>$sp_opt2[$o2]</div></td>");
					}
					echo ("</tr>");

				}
				?>
				</tbody>
				</table>
				</section>
			
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
} else if($step_next == "permit_trim1") {

		
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

}
?>