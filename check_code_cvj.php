<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "check_code_cvj";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
/*
$link_list = "$home/system_warehouse.php";
$link_post = "$home/system_warehouse_post.php";
$link_upd = "$home/system_warehouse_upd.php";
$link_del = "$home/system_warehouse_del.php";
*/
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



// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(num) FROM table_store_name_cvj";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(num) FROM table_store_name_cvj WHERE $keyfield LIKE '%$key%'";  
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
            Check Shop Code 
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
        
		<section id="unseen">
    <!-- <form action='update_process_cvj.php' method='POST'> -->
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Num</th>
            <th>Shop Name</th>
            <th>Shop Code</th>
			<th>Original Shop Code</th>
      <!--<th>Status</th> -->
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT num,shop_name,shop_code,org_shop_code
    FROM table_store_name_cvj ORDER BY shop_name ASC";
} else {
   $query = "SELECT num,shop_name,shop_code,org_shop_code
    FROM table_store_name_cvj WHERE $keyfield LIKE '%$key%' ORDER BY shop_name ASC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

// for($i = $first; $i <= $last; $i++) {
for($i = 0; $i < $total_record; $i++) {
   $num = mysql_result($result,$i,0);
   $shop_name = mysql_result($result, $i, 1);   
   $shop_code = mysql_result($result,$i,2);
   $org_shop_code = mysql_result($result,$i,3);
		$query_gname = "SELECT group_code FROM client_shop WHERE shop_code = '$shop_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
	 $group_code = @mysql_result($result_gname,0,0);

    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$gudang_name") && $key) {
    $gudang_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $gudang_name);
  }
  if(!strcmp($key,"$gudang_code") && $key) {
    $gudang_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $gudang_code);
  }

  $array_num  = array($i => $num);
  $array_org_shop_code = array($i=>$org_shop_code);
  //print_r($array_org_shop_code);

  echo ("<form action='update_process_cvj.php' method='POST'>");
  echo ("<tr>");
  echo ("<td><input type='hidden' name='num' value='$array_num[$i]'>{$num}</td>");
  echo ("<td><a href='$link_upd?uid=$num'>$shop_name</a></td>");
  echo ("<td><a href='$link_upd?uid=$num'>$shop_code</a></td>");
  echo ("<td><input type='text' name='org_shop_code' value='$array_org_shop_code[$i]' class='form-control'></td>");
  echo ("</tr>");
  /*
  echo('<input type="submit" value="Update Shop Code" class="btn btn-primary">');
  echo ("</form>");  
  */

// permasalahan utama tidak dapat mengirim semua data looping
   $article_num--;
}

?>
		
        </tbody>
        </table>
      
        <input type="submit" value="Update Shop Code" class="btn btn-primary">
      </form>        
      
		</section>
		


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
			</div>
			
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