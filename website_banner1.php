<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }
if(!$key_gate) { $key_gate = $client_id; }

$mmenu = "website";
$smenu = "website_banner1";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/website_banner1.php";
$link_post = "$home/website_banner1_post.php";
$link_upd = "$home/website_banner1_upd.php";
$link_del = "$home/website_banner1_del.php";


$sorting_filter = "gate = '$key_gate' AND branch_code = '$login_branch'";

if(!$sorting_key) { $sorting_key = "b_id"; }
if($sorting_key == "uid") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "uid") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "memo") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wpage_banner1 WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wpage_banner1 WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Work, Bootstrap, Responsive">
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

						
		<!--body wrapper start-->
        <div class="wrapper">
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_031?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			
		
		
			<div class="row">
			
			<div class="col-sm-6">
			
						<?
						$queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
						$resultC = mysql_query($queryC);
						$total_recordC = mysql_result($resultC,0,0);

						$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' ORDER BY userlevel DESC";
						$resultD = mysql_query($queryD);
						if (!$resultD) {   error("QUERY_ERROR");   exit; }

						echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

						for($i = 0; $i < $total_recordC; $i++) {
							$web_client_id = mysql_result($resultD,$i,0);
							$web_client_name = mysql_result($resultD,$i,1);
							$web_client_homepage = mysql_result($resultD,$i,2);
        
							if($web_client_id == $key_gate) {
								$slc_gate = "selected";
								$slc_disable = "";
							} else {
								$slc_gate = "";
								$slc_disable = "disabled";
							}

							echo("<option $slc_disable value='$PHP_SELF?key_gate=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
						}
						echo("</select>");
						?>
			</div>
			
			
			<div class='col-sm-3'>&nbsp;</div>
			<div class='col-sm-3'>
			
			<? echo ("
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control pull-right'>
			<option value='$PHP_SELF?sorting_key=b_id&key=$key&keyfield=$keyfield&key_gate=$key_gate'>$txt_web_banner1_order0</option>
			<option value='$PHP_SELF?sorting_key=uid&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk1>$txt_web_banner1_order1</option>
			<option value='$PHP_SELF?sorting_key=memo&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk2>Note</option>
			</select>
			
			</div>");
			?>
			</div>
			
			<br>
			

			
			
<?
echo ("
<section id='unseen'>
<table  class=\"table table-striped table-bordered\">
<thead>
<tr height=22>
   <th>$txt_web_banner1_05s</th>
   <th>$txt_web_banner1_06</th>
   
	<form name='search' method='post' action='website_banner1.php'>
	<input type=hidden name='sorting_key' value='$sorting_key'>
	<input type=hidden name='key_gate' value='$key_gate'>
	<input type=hidden name='keyfield' value='memo'>
	
   <th align=center width=26%>Note &gt; &nbsp; <input type='text' name='key' value='$key' style='$style_box; WIDTH: 140px; padding-left: 10px;'></th>
	</form>
	
   <th>$txt_web_banner1_07</th>
   <th>$txt_comm_frm12</th>
   <th>$txt_comm_frm13</th>
</tr>
</thead>

<tbody>
");


$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,b_id,b_type,filesize,memo FROM wpage_banner1 WHERE $sorting_filter 
			ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,b_id,b_type,filesize,memo FROM wpage_banner1 WHERE $sorting_filter AND $keyfield LIKE '%$key%' 
			ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
   $b_id = mysql_result($result,$i,1);   
   $b_type = mysql_result($result,$i,2);
   $b_filesize = (int)(mysql_result($result,$i,3));
		$b_filesize_K = number_format($b_filesize);
   $b_memo = mysql_result($result,$i,4);

	// 검색어 폰트색깔 지정
	if(!strcmp($keyfield,"$b_id") && $key) {
		$b_id = eregi_replace("($key)", "<font color=red>\\1</font>", $b_id);
	}


  echo("<tr>");
    
  // Banner ID (Code)
   echo("<td>$b_id</td>");
   
  // Bannter Type
  if($b_type == "2") {
    $b_type_txt = "GIF";
  } else if($b_type == "3") {
    $b_type_txt = "PNG";
  } else {
    $b_type_txt = "JPG";
  }
  
   echo("<td>$b_type_txt</td>");
   echo("<td>$b_memo</td>");

  // File Size
   echo("<td align=right><font color=blue>$b_filesize_K</font> Bytes &nbsp;</td>");
     
   echo("<td ><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&key_gate=$key_gate'><font color='navy'>$txt_comm_frm12</font></a></td>");
   echo("<td><a href='$link_del?keyfield=$keyfield&key=$key&page=$page&uid=$uid&key_gate=$key_gate'><font color='navy'>$txt_comm_frm13</font></a></td>");
   echo("</tr>");

   $article_num--;
}
?>

<tbody>
</table>
</section>
		
				<br>
				
				<a href="<?echo("$link_post?sorting_key=$sorting_key&key_gate=$key_gate")?>"><input type="button" value="<?=$txt_web_banner1_08?>" class="btn btn-primary"></a>

				
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&key_gate=$key_gate\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&key_gate=$key_gate\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&key_gate=$key_gate\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&key_gate=$key_gate\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&key_gate=$key_gate\">Next $page_per_block</a>");
				}
				?>
				</ul>
			
		
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