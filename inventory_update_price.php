<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_update_price";

if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_update_price.php";
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
if($sorting_key == "price_orgin") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "price_market") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "price_sale") { $chk5 = "selected"; } else { $chk5 = ""; }
if($sorting_key == "price_sale2") { $chk6 = "selected"; } else { $chk6 = ""; }
if($sorting_key == "pname") { $chk9 = "selected"; } else { $chk9 = ""; }

if(!$sort_now) { $sort_now = "ASC"; }


if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(org_pcode) FROM shop_product_list";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(org_pcode) FROM shop_product_list WHERE $keyfield LIKE '%$key%'";  
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
            <?=$title_module_0214?> - Prices (<?=$total_record_K?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_update_price.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='org_pcode' $chk1>Code</option>
				<option value='org_barcode' $chk2>Barcode</option>
				<option value='price_orgin' $chk3>Purchase Price</option>
				<option value='price_market' $chk4>Tag Price</option>
				<option value='price_sale' $chk5>Sales Price</option>
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
				<option value='$PHP_SELF?sorting_key=price_orgin&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk3>Purchase Price</option>
				<option value='$PHP_SELF?sorting_key=price_market&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk4>Tag Price</option>
				<option value='$PHP_SELF?sorting_key=price_sale&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk5>Sales Price</option>
				<option value='$PHP_SELF?sorting_key=pname&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk9>Description</option>
				</select>
			</div>
			");
			
			?>
			
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
			
        
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Code</th>
			<th>Description</th>
			<th>&nbsp;</th>
			<th>Purchase Price</th>
			<th>Outlet Price (IDR)</th>
			<th>Sales Price (IDR)</th>
        </tr>
        </thead>
		
		
        <tbody>
<?
echo ("
    <form name='signform' method='post' action='inventory_update_price.php'>
    <input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">");
	
	
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,org_pcode,org_barcode,pcode,pname,price_orgin,price_market,price_sale,price_sale2,currency_buy,xprice_buy FROM shop_product_list 
			ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,org_pcode,org_barcode,pcode,pname,price_orgin,price_market,price_sale,price_sale2,currency_buy,xprice_buy FROM shop_product_list 
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
   $price_orgin = mysql_result($result,$i,5);
   $price_market = mysql_result($result,$i,6);
   $price_sale = mysql_result($result,$i,7);
   $price_sale2 = mysql_result($result,$i,8);
   $currency_buy = mysql_result($result,$i,9);
   $xprice_buy = mysql_result($result,$i,10);
   
	if($price_orgin < 1) {
		$price_orgin = "";
	}
	if($price_market < 1) {
		$price_market = "";
	}
	if($price_sale < 1) {
		$price_sale = "";
	}
	if($price_sale2 < 1) {
		$price_sale2 = "";
	}
	if($xprice_buy < 1) {
		$xprice_buy = "";
	}
	
	if($xprice_buy < 1) {
		$new_cur_slc_IDR = "";
		$new_cur_slc_USD = "selected";
	} else {
	if($currency_buy == "USD") {
		$new_cur_slc_IDR = "";
		$new_cur_slc_USD = "selected";
	} else {
		$new_cur_slc_IDR = "selected";
		$new_cur_slc_USD = "";
	}
	}
	

  echo ("<tr>

	<input type='hidden' name='org_pcode[$org_uid]' value='$org_pcode'>
	<input type='hidden' name='org_currency[$org_uid]' value='$currency_buy'>
    <!--<td><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='bottom' data-original-title='$pname[$org_uid]'>$org_pcode</a></td>-->
	<!--<td><input type=text name='new_org_barcode[$org_uid]' value=\"$org_barcode\" class='form-control' style='width:150px'></td>-->
	
	<td>$org_pcode</td>
	<td>$pname</td>
	<td>
		<select name='new_currency_buy[$org_uid]' class='form-control'>
		<option value='IDR' $new_cur_slc_IDR>IDR</option>
		<option value='USD' $new_cur_slc_USD>USD</option>
		</select>
	<td><input type=text name='new_xprice_buy[$org_uid]' value=\"$xprice_buy\" class='form-control'></td>
	<td><input type=text name='new_price_market[$org_uid]' value=\"$price_market\" class='form-control'></td>
	<td><input type=text name='new_price_sale[$org_uid]' value=\"$price_sale\" class='form-control'></td>
    ");
  
  
  
  
  echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		
		<div class='form-group'>
			<div class='col-sm-1'>
				<input type="checkbox" name="chg_check" value="1"> <font color=red>Change</font>
			</div>
            <div class='col-sm-2'>
				<input type="date" class="form-control" name="chg_date" value="">
			</div>
			<div class='col-sm-3'>
				<input type="submit" value="Update this Page" class="btn btn-primary">
			</div>
		</div>
		
			
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
	
	if(!$chg_check) { $chg_check = "0"; }
	
	
	
	$num_per_page = 50; // number of article lines per page
	$page_per_block = 10; // number of pages displayed in the bottom
	
	
	if(!$sorting_key) { $sorting_key = "org_pcode"; }
	if(!$sort_now) { $sort_now = "ASC"; }

	if(!$page) { $page = 1; }

	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(org_pcode) FROM shop_product_list";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(org_pcode) FROM shop_product_list WHERE $keyfield LIKE '%$key%'";  
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
	
	
		if($new_price_market[$li_uid] < 1) {
			$new_price_market[$li_uid] = "0";
		}
		if($new_price_sale[$li_uid] < 1) {
			$new_price_sale[$li_uid] = "0";
		}
		if($new_price_sale2[$li_uid] < 1) {
			$new_price_sale2[$li_uid] = "0";
		}
		
		
		// Currency
		$new_currency = "IDR";
		
		
		// Original Price
		$new_price_buy_cost = 0; // RESET !!
		$new_price_origin = $new_xprice_buy[$li_uid] + $new_price_buy_cost;
		
		$new_price_orgin_IDR = $new_price_origin * $now_xchange_rate;
		
		if($chg_check == "1") {
		
		
		
		} else {
			
			if($new_currency != $new_currency_buy[$li_uid]) {
				$result1 = mysql_query("UPDATE shop_product_list SET price_orgin = '$new_price_origin_IDR', price_market = '$new_price_market[$li_uid]', 
					price_sale = '$new_price_sale[$li_uid]', price_sale2 = '$new_price_sale[$li_uid]', currency = '$new_currency', 
					currency_buy = '$new_currency_buy[$li_uid]', xprice_buy = '$new_xprice_buy[$li_uid]', xprice_buy_cost = '$new_price_buy_cost', 
					xchg_rate = '$now_xchange_rate', xchg_date = '$now_xchange_date' WHERE uid = '$li_uid'");
				if (!$result1) { error("QUERY_ERROR"); exit;	}
			}
	
			$result2 = mysql_query("UPDATE shop_product_list SET price_market = '$new_price_market[$li_uid]', 
					price_sale = '$new_price_sale[$li_uid]', price_sale2 = '$new_price_sale[$li_uid]', currency = '$new_currency' WHERE uid = '$li_uid'");
			if (!$result2) { error("QUERY_ERROR"); exit;	}
		
		}
	
	}
	

	echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_update_price.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

}

}
?>