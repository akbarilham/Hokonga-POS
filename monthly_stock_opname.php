<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_item_list";

if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/restore_item_list.php";


$query_cnts = "SELECT count(num) FROM temp_table_item2 WHERE num < '1'";
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
if(!$sorting_key) { $sorting_key = "pcode"; }

if($sorting_key == "barcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "catgsml") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "pname") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "num") { $chk5 = "selected"; } else { $chk5 = ""; }

if(!$sort_now) { $sort_now = "ASC"; }




if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(pname) FROM temp_table_item2";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(pname) FROM temp_table_item2 WHERE $keyfield LIKE '%$key%'";  
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
            Data Mining - temp_table_item (<?=$total_record?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='restore_item_list.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='pcode'>Code</option>
				<option value='barcode' $chk1>Barcode</option>
				<option value='catgsml' $chk2>Category</option>
				<option value='pname' $chk3>Item Name</option>
				<option value='num' $chk5>#</option>
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
				<option value='$PHP_SELF?sorting_key=pcode&sort_now=$sort_now&keyfield=$keyfield&key=$key'>Code</option>
				<option value='$PHP_SELF?sorting_key=barcode&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk1>Barcode</option>
				<option value='$PHP_SELF?sorting_key=catgsml&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk2>Category</option>
				<option value='$PHP_SELF?sorting_key=pname&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk3>Item Name</option>
				<option value='$PHP_SELF?sorting_key=num&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk5>#</option>
				</select>
			</div>
			");
			
			?>
			
			</div>
			
			<div>&nbsp;</div>
			
		
		
        
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
			<th>#</th>
            <th>Code</th>
            <th>Category 1</th>
			<th>Category 2</th>
			<th>Category 3</th>
			<th>Item Name</th>
			<th>Cond.</th>
			<th>Upd</th>
			<th>Del</th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT num,pcode,barcode,pname,catgbig,catgmid,catgsml,condi FROM temp_table_item2 ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT num,pcode,barcode,pname,catgbig,catgmid,catgsml,condi FROM temp_table_item2 WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $num = mysql_result($result,$i,0);
   $pcode = mysql_result($result,$i,1);
   $barcode = mysql_result($result,$i,2);
   $pname = mysql_result($result,$i,3);
   $catgbig = mysql_result($result,$i,4);
   $catgmid = mysql_result($result,$i,5);
   $catgsml = mysql_result($result,$i,6);
   $condi = mysql_result($result,$i,7);

  echo ("<tr>");

  echo ("
    <form name='signform1' method='post' action='restore_item_list.php'>
    <input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">
	<input type='hidden' name='org_num' value=\"$num\">
	<input type='hidden' name='org_pcode' value=\"$pcode\">
	<input type='hidden' name='org_barcode' value=\"$barcode\">
	<input type='hidden' name='org_catgsml' value=\"$catgsml\">
	<input type='hidden' name='org_pname' value=\"$pname\">");
	
	echo ("<td>$num</td>");
	
	$query_d1 = "SELECT count(pcode) FROM temp_table_item2 WHERE pcode = '$pcode' ORDER BY pcode ASC";
	$result_d1 = mysql_query($query_d1);
	if (!$result_d1) {   error("QUERY_ERROR");   exit; }
	$pcode_cnt = @mysql_result($result_d1,0,0);
	
    
	if($pcode == "" OR $pcode_cnt > 1) {
		echo ("<td><input type=text name='new_pcode' value=\"$pcode\" class='form-control' style='background-color: #FAFAA0'></td>");
	} else {
		echo ("<td><input type=text name='new_pcode' value=\"$pcode\" class='form-control'></td>");
	}
	
	/*
	if($barcode) {
		echo ("<td><input type=text name='new_barcode' value=\"$barcode\" class='form-control'></td>");
	} else {
		echo ("<td><input type=text name='new_barcode' value=\"$barcode\" class='form-control' style='background-color: #FAFAA0'></td>");
	}
	*/
	
	
			// Category
			$c1_query = "SELECT lcode FROM shop_catgbig WHERE lang = '$lang' AND lname = '$catgbig'";
			$c1_result = mysql_query($c1_query);
				if (!$c1_result) { error("QUERY_ERROR"); exit; }
			$R_lcode = @mysql_result($c1_result,0,0);
			
			$c2_query = "SELECT mcode FROM shop_catgmid WHERE lang = '$lang' AND lcode = '$R_lcode' AND mname = '$catgmid'";
			$c2_result = mysql_query($c2_query);
				if (!$c2_result) { error("QUERY_ERROR"); exit; }
			$R_mcode = @mysql_result($c2_result,0,0);
			
			$c3_query = "SELECT scode FROM shop_catgsml WHERE lang = '$lang' AND mcode = '$R_mcode' AND sname = '$catgsml'";
			$c3_result = mysql_query($c3_query);
				if (!$c3_result) { error("QUERY_ERROR"); exit; }
			$R_scode = @mysql_result($c3_result,0,0);
			
			if($R_scode > "0") {
				$R_catg_code = $R_scode;
			} else {
				$R_catg_code = "$R_mcode"."01";
			}
	
	if($R_lcode) {
		echo ("<td><input type=text name='new_catgbig' value=\"$catgbig\" class='form-control'></td>");
	} else {
		echo ("<td><input type=text name='new_catgbig' value=\"$catgbig\" class='form-control' style='background-color: #FAFAA0'></td>");
	}
	
	if($R_mcode) {
		echo ("<td><input type=text name='new_catgmid' value=\"$catgmid\" class='form-control'></td>");
	} else {
		echo ("<td><input type=text name='new_catgmid' value=\"$catgmid\" class='form-control' style='background-color: #FAFAA0'></td>");
	}
	
	if($R_scode) {
		echo ("<td><input type=text name='new_catgsml' value=\"$catgsml\" class='form-control'></td>");
	} else {
		echo ("<td><input type=text name='new_catgsml' value=\"$catgsml\" class='form-control' style='background-color: #FAFAA0'></td>");
	}
	
	echo ("
	<td><input type=text name='new_pname' value=\"$pname\" class='form-control'></td>
	
	<td>
		<select name='new_condi' class='form-control'>");
		if($condi == "Going") {
			echo ("<option value='Going' selected>Going</option>");
		} else {
			echo ("<option value='Going'>Going</option>");
		}
		if($condi == "Discontinued") {
			echo ("<option value='Discontinued' selected>Dis</option>");
		} else {
			echo ("<option value='Discontinued'>Dis</option>");
		}
		if($condi == "Stop") {
			echo ("<option value='Stop' selected>Stop</option>");
		} else {
			echo ("<option value='Stop'>Stop</option>");
		}
		echo ("
		</select>
	</td>
	
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
	
	<form name='signform2' method='post' action='restore_item_list.php'>
    <input type='hidden' name='step_next' value='permit_delete'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">
	<input type='hidden' name='org_num' value=\"$num\">
	<input type='hidden' name='org_pcode' value=\"$pcode\">
	<input type='hidden' name='org_barcode' value=\"$barcode\">
	<input type='hidden' name='org_catgsml' value=\"$catgsml\">
	<input type='hidden' name='org_pname' value=\"$pname\">
	
	<td><input $dis_submit type='submit' value='$txt_comm_frm13' class='btn btn-default btn-xs'></td>
    </form>
    ");
  
  
  
  
  echo("</tr>");

   $article_num--;
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
				if($total_cnts > 0) {
					
				echo ("
				<form name='trimform1' method='post' action='restore_item_list.php'>
				<input type='hidden' name='step_next' value='permit_trim1'>
				<input type='hidden' name='sorting_key' value='$sorting_key'>
				<input type='hidden' name='sort_now' value='$sort_now'>
				<input type='hidden' name='keyfield' value='$keyfield'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='page' value='$page'>
				
				<input class='btn btn-danger' type='submit' value='Delete $total_cnts Records !'>
				</form>");
				
				} else {
					
				echo ("
				<form name='trimform2' method='post' action='restore_item_list.php'>
				<input type='hidden' name='step_next' value='permit_trim2'>
				<input type='hidden' name='sorting_key' value='$sorting_key'>
				<input type='hidden' name='sort_now' value='$sort_now'>
				<input type='hidden' name='keyfield' value='$keyfield'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='page' value='$page'>
				
				<input class='btn btn-primary' type='submit' value='Update Data now !'>
				</form>");
				
				}
				?>
		
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
} else if($step_next == "permit_trim1") {

		$query1 = "DELETE FROM temp_table_item2 WHERE num < '1'";
		$result1 = mysql_query($query1);
		if(!$result1) { error("QUERY_ERROR"); exit; }
		
		$queryC2 = "SELECT count(num) FROM temp_table_item2";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,pcode,barcode,pname,catgbig,catgmid,catgsml FROM temp_table_item2 ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_barcode = mysql_result($resultD2,$ra,2);
			$R_pname = mysql_result($resultD2,$ra,3);
			$R_catg1_name = mysql_result($resultD2,$ra,4);
			$R_catg2_name = mysql_result($resultD2,$ra,5);
			$R_catg3_name = mysql_result($resultD2,$ra,6);
				
			// $R_condi = mysql_result($resultD2,$ra,6);
			
				if($R_catg1_name == "Making Special and B2B" OR $R_catg1_name == "Making Special and B3B" OR $R_catg1_name == "Making Special and B4B") {
					$R_catg1_name2 = "Making Special";
					$R_catg1_upd = "1";
				} else if($R_catg1_name == "Kichenware") {
					$R_catg1_name2 = "Kitchenware"; // page 28
					$R_catg1_upd = "1";
				} else {
					$R_catg1_name2 = $R_catg1_name;
					$R_catg1_upd = "0";
				}
				
				if($R_catg2_name == "ZZF") {
					$R_catg2_name2 = "0.05g (ZZF)"; // page 51, 98-107, 118-119 (Food Storage)
					$R_catg2_upd = "1";
				} else if($R_catg2_name == "Aqua") {
					$R_catg2_name2 = "Aqua (PP,PC,PET)"; // page 54-56,60-61, 73, 75-82, 91-92 (Water Bottle)
					$R_catg2_upd = "1";
				} else {
					$R_catg2_name2 = $R_catg2_name;
					$R_catg2_upd = "0";
				}
				
				if($R_catg3_name == "Bag&Towel") {
					$R_catg3_name = "Bag & Towel"; // page 11
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Bottle(Hot & Cool)") {
					$R_catg3_name = "Bottle (Hot & Cool)"; // page 14-15
					$R_catg3_upd = "1";
				// } else if($R_catg3_name == "Cookplus Mixing Bowl") {
				// 	$R_catg2_name = "Bowl"; // page 19-20
				//  $R_catg3_upd = "1";
				} else if($R_catg3_name == "CUP&MUG") {
					$R_catg3_name = "CUP & MUG"; // page 21 (Water Bottle - Hot & Cool)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Ettom Kichen") {
				 	$R_catg3_name = "Ettom Kitchen"; // page 28
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Fork/Spoon/, Silby") {
				 	$R_catg3_name = "Fork/Spoon/Silby"; // page 41-42 (Tableware - Cutlery)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Multilock") {
					$R_catg3_name = "Multi Lock";
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Freezerlock") {
					$R_catg3_name = "Freezer Lock"; // page 46-47 (Food Storage - Simple Storage)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Travel bag") {
					$R_catg3_name = "Travel Bag"; // page 124-125 (Living Storage - Storage)
					$R_catg3_upd = "1";
				} else {
					$R_catg3_name2 = $R_catg3_name;
					$R_catg3_upd = "0";
				}
			
			echo ("Writing $R_num ...<br>");
			
			if($R_catg1_upd == "1") {
				$result_U1 = mysql_query("UPDATE temp_table_item2 SET catgbig = '$R_catg1_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
			}
			if($R_catg2_upd == "1") {
				$result_U2 = mysql_query("UPDATE temp_table_item2 SET catgmid = '$R_catg2_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U2) { error("QUERY_ERROR"); exit; }
			}
			if($R_catg3_upd == "1") {
				$result_U3 = mysql_query("UPDATE temp_table_item2 SET catgsml = '$R_catg3_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U3) { error("QUERY_ERROR"); exit; }
			}
			
		
		}
		
	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;


} else if($step_next == "permit_trim2") {

		$queryC2 = "SELECT count(num) FROM temp_table_item2";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,pcode,barcode,pname,catgbig,catgmid,catgsml FROM temp_table_item2 ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_barcode = mysql_result($resultD2,$ra,2);
			$R_pname = mysql_result($resultD2,$ra,3);
			$R_catg1_name = mysql_result($resultD2,$ra,4);
			$R_catg2_name = mysql_result($resultD2,$ra,5);
			$R_catg3_name = mysql_result($resultD2,$ra,6);
				
			// $R_condi = mysql_result($resultD2,$ra,6);
			
				if($R_catg1_name == "Making Special and B2B" OR $R_catg1_name == "Making Special and B3B" OR $R_catg1_name == "Making Special and B4B") {
					$R_catg1_name2 = "Making Special";
					$R_catg1_upd = "1";
				} else if($R_catg1_name == "Kichenware") {
					$R_catg1_name2 = "Kitchenware"; // page 28
					$R_catg1_upd = "1";
				} else {
					$R_catg1_name2 = $R_catg1_name;
					$R_catg1_upd = "0";
				}
				
				if($R_catg2_name == "ZZF") {
					$R_catg2_name2 = "0.05g (ZZF)"; // page 51, 98-107, 118-119 (Food Storage)
					$R_catg2_upd = "1";
				} else if($R_catg2_name == "Aqua") {
					$R_catg2_name2 = "Aqua (PP,PC,PET)"; // page 54-56,60-61, 73, 75-82, 91-92 (Water Bottle)
					$R_catg2_upd = "1";
				} else {
					$R_catg2_name2 = $R_catg2_name;
					$R_catg2_upd = "0";
				}
				
				if($R_catg3_name == "Bag&Towel") {
					$R_catg3_name = "Bag & Towel"; // page 11
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Bottle(Hot & Cool)") {
					$R_catg3_name = "Bottle (Hot & Cool)"; // page 14-15
					$R_catg3_upd = "1";
				// } else if($R_catg3_name == "Cookplus Mixing Bowl") {
				// 	$R_catg2_name = "Bowl"; // page 19-20
				//  $R_catg3_upd = "1";
				} else if($R_catg3_name == "CUP&MUG") {
					$R_catg3_name = "CUP & MUG"; // page 21 (Water Bottle - Hot & Cool)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Ettom Kichen") {
				 	$R_catg3_name = "Ettom Kitchen"; // page 28
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Fork/Spoon/, Silby") {
				 	$R_catg3_name = "Fork/Spoon/Silby"; // page 41-42 (Tableware - Cutlery)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Multilock") {
					$R_catg3_name = "Multi Lock";
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Freezerlock") {
					$R_catg3_name = "Freezer Lock"; // page 46-47 (Food Storage - Simple Storage)
					$R_catg3_upd = "1";
				} else if($R_catg3_name == "Travel bag") {
					$R_catg3_name = "Travel Bag"; // page 124-125 (Living Storage - Storage)
					$R_catg3_upd = "1";
				} else {
					$R_catg3_name2 = $R_catg3_name;
					$R_catg3_upd = "0";
				}
			
			echo ("Writing $R_num ...<br>");
			
			if($R_catg1_upd == "1") {
				$result_U1 = mysql_query("UPDATE temp_table_item2 SET catgbig = '$R_catg1_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
			}
			if($R_catg2_upd == "1") {
				$result_U2 = mysql_query("UPDATE temp_table_item2 SET catgmid = '$R_catg2_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U2) { error("QUERY_ERROR"); exit; }
			}
			if($R_catg3_upd == "1") {
				$result_U3 = mysql_query("UPDATE temp_table_item2 SET catgsml = '$R_catg3_name2'	WHERE pcode = '$R_pcode' AND num = '$R_num'");
				if(!$result_U3) { error("QUERY_ERROR"); exit; }
			}
			
		
		}

	echo("<meta http-equiv='Refresh' content='10; URL=$home/restore_item_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;
	

} else if($step_next == "permit_delete") {

	$query = "DELETE FROM temp_table_item2 WHERE pcode = '$org_pcode' AND num = '$org_num'";
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

} else if($step_next == "permit_update") {

	$signdate = time();
	$signdates1 = date("Ymd",$signdate); 
	$signdates2 = date("His",$signdate); 
  
	$m_ip = getenv('REMOTE_ADDR');
	$new_pname = addslashes($new_pname);

	$result = mysql_query("UPDATE temp_table_item2 SET pcode = '$new_pcode', condi = '$new_condi', pname = '$new_pname', 
			catgbig = '$new_catgbig', catgmid = '$new_catgmid', catgsml = '$new_catgsml' 
			WHERE pcode = '$org_pcode' AND num = '$org_num'");
	if (!$result) { error("QUERY_ERROR"); exit;	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

}

}
?>