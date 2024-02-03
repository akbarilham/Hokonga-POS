<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_item_store_list";

if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/restore_item_store_list.php";


$query_cnts = "SELECT count(num) FROM table_ini_store";
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
if(!$sorting_key) { $sorting_key = "num"; }

if($sorting_key == "store_code") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "store_name") { $chk2 = "selected"; } else { $chk2 = ""; }

if(!$sort_now) { $sort_now = "ASC"; }




if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(num) FROM table_ini_store";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(num) FROM table_ini_store WHERE $keyfield LIKE '%$key%'";  
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
            Data Mining - table_ini_store (<?=$total_record?>)
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='restore_item_store_list.php'>
			<div class='col-sm-3'>
				<select name='keyfield' class='form-control'>
				<option value='num'>Code</option>
				<option value='store_code' $chk1>Store Code</option>
				<option value='store_name' $chk2>Store Name</option>
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
				<option value='$PHP_SELF?sorting_key=num&sort_now=$sort_now&keyfield=$keyfield&key=$key'>#</option>
				<option value='$PHP_SELF?sorting_key=store_code&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk1>Store Code</option>
				<option value='$PHP_SELF?sorting_key=store_name&sort_now=$sort_now&keyfield=$keyfield&key=$key' $chk2>Store Name</option>
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
			<th>New Code</th>
			<th>PT</th>
            <th>Store Name</th>
			<th>Upd</th>
			<th>Del</th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT num,store_code,store_name,branch_code,new_code FROM table_ini_store ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT num,store_code,store_name,branch_code,new_code FROM table_ini_store WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $num = mysql_result($result,$i,0);
   $store_code = mysql_result($result,$i,1);
   $store_name = mysql_result($result,$i,2);
   $store_branch = mysql_result($result,$i,3);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$store_branch'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$store_branch_name = @mysql_result($result_gname,0,0);
	$new_store_code = mysql_result($result,$i,4);

  echo ("<tr>");

  echo ("
    <form name='signform1' method='post' action='restore_item_store_list.php'>
    <input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">
	<input type='hidden' name='org_num' value=\"$num\">
	<input type='hidden' name='org_scode' value=\"$store_code\">
	<input type='hidden' name='org_sname' value=\"$store_name\">");
	
	echo ("<td>$num</td>");
	
	$query_cd = "SELECT count(*) FROM client_shop WHERE shop_name = '$store_name' AND branch_code = '$store_branch'";
	$result_cd = mysql_query($query_cd);
		if (!$result_cd) { error("QUERY_ERROR"); exit; }
	$new_shop_cnt = @mysql_result($result_cd,0,0);
	
	$query_d1 = "SELECT count(num) FROM table_ini_store WHERE store_code = '$store_code' ORDER BY store_code ASC";
	$result_d1 = mysql_query($query_d1);
		if (!$result_d1) {   error("QUERY_ERROR");   exit; }
	$store_code_cnt = @mysql_result($result_d1,0,0);
	
    echo ("<td>$store_code</td>");
	
	if($new_shop_cnt > 1 OR $store_code_cnt > 1) {
		echo ("<td><input type=text name='new_scode' value=\"$new_store_code\" class='form-control' style='background-color: #FAFAA0'></td>");
	} else {
		echo ("<td><input type=text name='new_scode' value=\"$new_store_code\" class='form-control'></td>");
	}
	

	echo ("
	<td>$store_branch_name</td>
	<td><input type=text name='new_sname' value=\"$store_name\" class='form-control'></td>
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
	
	<form name='signform2' method='post' action='restore_item_store_list.php'>
    <input type='hidden' name='step_next' value='permit_delete'>
	<input type='hidden' name='sorting_key' value=\"$sorting_key\">
	<input type='hidden' name='sort_now' value=\"$sort_now\">
	<input type='hidden' name='keyfield' value=\"$keyfield\">
	<input type='hidden' name='key' value=\"$key\">
	<input type='hidden' name='page' value=\"$page\">
	<input type='hidden' name='org_num' value=\"$num\">
	<input type='hidden' name='org_scode' value=\"$store_code\">
	<input type='hidden' name='org_sname' value=\"$store_name\">
	
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
				/*
				echo ("
				<form name='trimform2' method='post' action='restore_item_store_list.php'>
				<input type='hidden' name='step_next' value='permit_trim2'>
				<input type='hidden' name='sorting_key' value='$sorting_key'>
				<input type='hidden' name='sort_now' value='$sort_now'>
				<input type='hidden' name='keyfield' value='$keyfield'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='page' value='$page'>
				
				<input class='btn btn-primary' type='submit' value='Update Store Data now !'>
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

		
		$queryC2 = "SELECT count(num) FROM table_ini_store";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,store_code,store_name,branch_code FROM table_ini_store ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_scode = mysql_result($resultD2,$ra,1);
			$R_sname = mysql_result($resultD2,$ra,2);
			$R_branch = mysql_result($resultD2,$ra,3);

			
			echo ("Writing $R_num ...<br>");
			
			
			
		
		}
		
	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_store_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;


} else if($step_next == "permit_trim2") { // Store Update : IMPORTANT !!!

		$queryC2 = "SELECT count(num) FROM table_ini_store";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,store_code,store_name,branch_code,new_code FROM table_ini_store ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_scode = mysql_result($resultD2,$ra,1);
			$R_sname = mysql_result($resultD2,$ra,2);
			$R_branch = mysql_result($resultD2,$ra,3);
			$R_new_code = mysql_result($resultD2,$ra,4);
			
			echo ("Writing $R_num [$R_new_code]...<br>");
			
			if($R_new_code) {
				$result_U1 = mysql_query("UPDATE client_shop SET shop_code = '$R_new_code' WHERE num_tmp = '$R_num'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
			}
		
		}

	echo("<meta http-equiv='Refresh' content='10; URL=$home/restore_item_store_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;
	

} else if($step_next == "permit_delete") {

	$query = "DELETE FROM table_ini_store WHERE num = '$org_num'";
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_store_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

} else if($step_next == "permit_update") {

	$signdate = time();
	$signdates1 = date("Ymd",$signdate); 
	$signdates2 = date("His",$signdate); 
  
	$m_ip = getenv('REMOTE_ADDR');
	$new_sname = addslashes($new_sname);

	$result = mysql_query("UPDATE table_ini_store SET new_code = '$new_scode', store_name = '$new_sname' WHERE num = '$org_num'");
	if (!$result) { error("QUERY_ERROR"); exit;	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_store_list.php?sorting_key=$sorting_key&sort_now=$sort_now&keyfield=$keyfield&key=$key&page=$page'>");
	exit;

}

}
?>