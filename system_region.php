<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_region";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_region.php";
$link_post = "$home/system_region_post.php";
$link_upd = "$home/system_region_upd.php";
$link_del = "$home/system_region_del.php";
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
   $query = "SELECT count(uid) FROM code_area";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM code_area WHERE $keyfield LIKE '%$key%'";  
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
            <?=$txt_sys_area_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">

        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <!--<th>No.</th>-->
			<!--<th><?=$txt_sys_area_06?></th>-->
            <th><?=$txt_sys_area_05?></th>
            <th colspan=2><?=$txt_sys_area_07?></th>
			<th><?=$txt_comm_frm42?></th>
			<th><?=$txt_sys_area_08?></th>
			<th><?=$txt_sys_area_09?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,country_code,area_code,area_name,area_name2,currency,delivery_cost,ord_no,minimum_wage,area_zone FROM code_area 
			ORDER BY country_code ASC, ord_no ASC, area_name ASC";
} else {
   $query = "SELECT uid,country_code,area_code,area_name,area_name2,currency,delivery_cost,ord_no,minimum_wage,area_zone FROM code_area 
			WHERE $keyfield LIKE '%$key%' ORDER BY country_code ASC, ord_no ASC, area_name ASC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

// for($i = $first; $i <= $last; $i++) {
for($i = 0; $i < $total_record; $i++) {
   $uid = mysql_result($result,$i,0);   
   $country_code = mysql_result($result,$i,1);
   $area_code = mysql_result($result,$i,2);
   $area_name = mysql_result($result,$i,3);
   $area_name2 = mysql_result($result,$i,4);
   $currency = mysql_result($result,$i,5);
   $delivery_cost = mysql_result($result,$i,6);
    $delivery_cost_K = number_format($delivery_cost);
   $ord_no = mysql_result($result,$i,7);
   $minimum_wage = mysql_result($result,$i,8);
    $minimum_wage_K = number_format($minimum_wage);
   $area_zone = mysql_result($result,$i,9);
   
		if($area_zone == "Jawa") {
			$area_zone_txt = "Jawa";
		} else if($area_zone == "Bali") {
			$area_zone_txt = "Bali dan Nusa Tenggara";
		} else if($area_zone == "Sumatera") {
			$area_zone_txt = "Sumatera";
		} else if($area_zone == "Sulawesi") {
			$area_zone_txt = "Sulawesi";
		} else if($area_zone == "Kalimantan") {
			$area_zone_txt = "Kalimantan";
		} else if($area_zone == "Maluku") {
			$area_zone_txt = "Maluku dan Papua";
		} else {
			$area_zone_txt = "Undefined";
		}

    $area_name = stripslashes($area_name);
    $area_name2 = stripslashes($area_name2);
	

	// 검색어 폰트색깔 지정
	if(!strcmp($key,"$area_code") && $key) {
		$area_code = eregi_replace("($key)", "<font color=red>\\1</font>", $area_code);
	}
	if(!strcmp($key,"$area_name") && $key) {
		$area_name = eregi_replace("($key)", "<font color=red>\\1</font>", $area_name);
	}


	// Country Name
	$queryS = "SELECT country_name FROM code_country WHERE country_code = '$country_code'";
	$resultS = mysql_query($queryS);

	$country_name = @mysql_result($resultS,0,0);
   

  echo ("<tr>");
  // echo("<td>$ord_no</td>");
  // echo("<td>$country_name</td>");
  
  echo("<td><a href='$link_upd?uid=$uid'>$area_code</a></td>");
  echo("<td>$area_name</td>");
  echo("<td>$area_name2</td>");
  echo("<td>$area_zone_txt</td>");
  echo("<td align=right>$currency $delivery_cost_K &nbsp;</td>");
  echo("<td align=right>$currency $minimum_wage_K &nbsp;</td>");

  echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
		
				<a href="<?=$link_post?>"><input type="button" value="<?=$txt_comm_frm03?>" class="btn btn-primary"></a>
			
				<!--
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
				-->
			
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


  </body>

</html>

<? } ?>