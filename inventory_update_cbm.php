<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_update_cbm";

if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_update_cbm.php";
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
if(!$sorting_key) { $sorting_key = "org_pcode"; }

if($sorting_key == "org_pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "org_barcode") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "box_qty") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "box_cbm") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "pname") { $chk9 = "selected"; } else { $chk9 = ""; }

if(!$sort_now) { $sort_now = "ASC"; }


if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM shop_product_list";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM shop_product_list WHERE $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);
	$total_record_K = number_format($total_record);


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
            <?=$title_module_0213?> - Barcode & CBM (<?=$total_record_K?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_update_cbm.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='org_pcode' $chk1>Code</option>
				<option value='org_barcode' $chk2>Barcode</option>
				<option value='box_qty' $chk3>Qty/Box</option>
				<option value='box_cbm' $chk4>CBM/Box</option>
				<option value='pname' $chk9>Description</option>
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
				<option value='$PHP_SELF?sorting_key=org_pcode&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk1>Code</option>
				<option value='$PHP_SELF?sorting_key=org_barcode&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk2>Barcode</option>
				<option value='$PHP_SELF?sorting_key=box_qty&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk3>Qty/Box</option>
				<option value='$PHP_SELF?sorting_key=box_cbm&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk4>CBM/Box</option>
				<option value='$PHP_SELF?sorting_key=pname&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk9>Description</option>
				</select>
			</div>
			");
			
			?>
			
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
			
        
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Code</th>
			<th>Barcode</th>
			<!--<th>Description</th>-->
			<th>Qty/Box</th>
			<th>CBM/Box</th>
			<th>Qty/Bundle</th>
			<th>CBM/Bundle</th>
			<th>Qty/PCS</th>
			<th>CBM/PCS</th>
        </tr>
        </thead>
		
		
        <tbody>
<?
echo ("
    <form name='signform5' method='post' action='inventory_update_cbm.php'>
    <input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">");
	
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,org_pcode,org_barcode,pcode,pname,box_qty,box_cbm,bundle_qty,bundle_cbm,pcs_qty,pcs_cbm FROM shop_product_list 
			ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,org_pcode,org_barcode,pcode,pname,box_qty,box_cbm,bundle_qty,bundle_cbm,pcs_qty,pcs_cbm FROM shop_product_list 
			WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $org_uid = mysql_result($result,$i,0);   
   $org_pcode = mysql_result($result,$i,1);
   $org_barcode = mysql_result($result,$i,2);
   $pcode = mysql_result($result,$i,3);
   $pname = mysql_result($result,$i,4);
		$pname = stripslashes($pname);
   $box_qty = mysql_result($result,$i,5);
   $box_cbm = mysql_result($result,$i,6);
   $bundle_qty = mysql_result($result,$i,7);
   $bundle_cbm = mysql_result($result,$i,8);
   $pcs_qty = mysql_result($result,$i,9);
   $pcs_cbm = mysql_result($result,$i,10);

   
  echo ("<tr>");
  echo ("
    <td><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='bottom' data-original-title='$pname'>$org_pcode</a></td>
	<td><input type=text name='new_org_barcode[$org_uid]' value=\"$org_barcode\" class='form-control' style='width:150px'></td>
	<!--<td>$pname</td>-->
	<td><input type=text name='new_box_qty[$org_uid]' value=\"$box_qty\" class='form-control'></td>
	<td><input type=text name='new_box_cbm[$org_uid]' value=\"$box_cbm\" class='form-control'></td>
	<td><input type=text name='new_bundle_qty[$org_uid]' value=\"$bundle_qty\" class='form-control'></td>
	<td><input type=text name='new_bundle_cbm[$org_uid]' value=\"$bundle_cbm\" class='form-control'></td>
	<td><input type=text name='new_pcs_qty[$org_uid]' value=\"$pcs_qty\" class='form-control'></td>
	<td><input type=text name='new_pcs_cbm[$org_uid]' value=\"$pcs_cbm\" class='form-control'></td>
    ");
  
  echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		
		<input type="submit" value="Update this Page" class="btn btn-primary">
		</form>
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
	$signdates1 = date("Ymd",$signdate); 
	$signdates2 = date("His",$signdate); 
  
	$m_ip = getenv('REMOTE_ADDR');
	
	$num_per_page = 50; // number of article lines per page
	$page_per_block = 10; // number of pages displayed in the bottom
	
if(!$sorting_key) { $sorting_key = "org_pcode"; }
if(!$sort_now) { $sort_now = "ASC"; }


if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM shop_product_list";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM shop_product_list WHERE $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);
	$total_record_K = number_format($total_record);


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


	$time_limit = 60*60*24*$notify_new_article; 
	

	if(!eregi("[^[:space:]]+",$key)) {
		$query_li = "SELECT uid FROM shop_product_list ORDER BY $sorting_key $sort_now";
	} else {
		$query_li = "SELECT uid FROM shop_product_list WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
	$result_li = mysql_query($query_li);
	if (!$result_li) {   error("QUERY_ERROR");   exit; }


	for($li = $first; $li <= $last; $li++) {
		$li_uid = mysql_result($result_li,$li,0);   

		$result = mysql_query("UPDATE shop_product_list SET org_barcode = '$new_org_barcode[$li_uid]', box_qty = '$new_box_qty[$li_uid]',
				box_cbm = '$new_box_cbm[$li_uid]', bundle_qty = '$new_bundle_qty[$li_uid]', bundle_cbm = '$new_bundle_cbm[$li_uid]', 
				pcs_qty = '$new_pcs_qty[$li_uid]', pcs_cbm = '$new_pcs_cbm[$li_uid]' WHERE uid = '$li_uid'");
		if (!$result) { error("QUERY_ERROR"); exit;	}

		
	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_update_cbm.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

}

}
?>