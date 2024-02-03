<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_consign";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_consign.php";
$link_post = "$home/system_consign_post.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key";
$link_upd = "$home/system_consign_upd.php";
$link_del = "$home/system_consign_del.php";
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
if(!$sorting_key) { $sorting_key = "group_name"; }
if($sorting_key == "signdate") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "group_name") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "signdate") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM client_consign";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM client_consign WHERE $keyfield LIKE '%$key%'";  
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
            <?=$txt_sys_consign_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-4">
			
			<?
			$queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
			$resultD = mysql_query($queryD);

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF?sorting_key=$sorting_key'>:: $txt_comm_frm25</option>");

			for($i = 0; $i < $total_recordC; $i++) {
				$menu_code = mysql_result($resultD,$i,0);
				$menu_name = mysql_result($resultD,$i,1);
        
				if($menu_code == $key) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

				echo("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=branch_code&key=$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
			}
			echo("</select>
			
			</div>
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='system_consign.php'>
			<input type='hidden' name='hr_type' value='$hr_type'>
			<input type='hidden' name='sorting_key' value='$sorting_key'>
			<input type='hidden' name='keyfield' value='group_name'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_sys_consign_06'> 
			</div>
			</form>
			
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=group_code&key=$key&keyfield=$keyfield'>$txt_sys_consign_05</option>
			<option value='$PHP_SELF?sorting_key=group_name&key=$key&keyfield=$keyfield' $chk1>$txt_sys_consign_06</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield' $chk2>$txt_sys_client_06</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th><?=$txt_comm_frm23?></th>
            <th><?=$txt_sys_consign_05?></th>
            <th><?=$txt_sys_consign_06?></th>
			<th><?=$txt_sys_consign_07?></th>
			<th colspan=2><?=$txt_sys_consign_15?></th>
			<th><?=$txt_sys_supplier_09?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?=$txt_sys_consign_151?></td>
			<td><?=$txt_sys_consign_152?></td>
			<td>&nbsp;</td>
		</tr>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,group_code,group_type,group_name,manager,userlevel,signdate,branch_code,share_normal,share_promo
			FROM client_consign ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,group_code,group_type,group_name,manager,userlevel,signdate,branch_code,share_normal,share_promo
			FROM client_consign WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
   $group_code = mysql_result($result,$i,1);
   $group_type = mysql_result($result,$i,2);
   $group_name = mysql_result($result,$i,3);
   $group_manager = mysql_result($result,$i,4);
   $userlevel = mysql_result($result,$i,5);
   $signdate = mysql_result($result,$i,6);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $group_branch_code = mysql_result($result,$i,7);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$group_branch_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$group_branch_name = @mysql_result($result_gname,0,0);
   
   $share_normal = mysql_result($result,$i,8);
   $share_promo = mysql_result($result,$i,9);
   
	// Count
	$query_max = "SELECT count(uid) FROM client_consign_share WHERE group_code = '$group_code' ORDER BY upd_date DESC";
	$result_max = mysql_query($query_max);
	if (!$result_max) {   error("QUERY_ERROR");   exit; }

	$total_share = @mysql_result($result_max,0,0);
	

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$group_name") && $key) {
    $group_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $group_name);
  }
  if(!strcmp($key,"$group_code") && $key) {
    $group_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $group_code);
  }


  echo ("<tr>");
  echo("<td>$group_branch_name</td>");
  echo("<td>$group_code</td>");
  echo("<td><a href='$link_upd?uid=$uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>$group_name</a></td>");
    
  if($group_type == "1") {
    $group_type_txt = "<font color=blue>$txt_sys_shop_151</font>";
  } else if($group_type == "2") {
    $group_type_txt = "<font color=black>$txt_sys_shop_152</font>";
  } else if($group_type == "3") {
    $group_type_txt = "<font color=navy>Dep't Store</font>";
  } else if($group_type == "4") {
    $group_type_txt = "<font color=green>Spc'l Store</font>";
  }
  echo("<td>{$group_type_txt}</td>");

  if($total_share > 0) {
	echo("<td><a href='$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&mode=view&gcode=$group_code'><font color=#000000>$share_normal %</font></a></td>");
	echo("<td><a href='$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&mode=view&gcode=$group_code'><font color=#000000>$share_promo %</font></a> / $txt_sys_consign_153</td>");
  } else {
	echo("<td>$share_normal %</td>");
	echo("<td>$share_promo % / $txt_sys_consign_153</td>");
  }

  // Group 구분
  if($userlevel == "0") {
	  $level_name = "<font color=red>$txt_sys_supplier_10</font>";
  } else if($userlevel == "1") {
	  $level_name = "-&gt;-";
  } else if($userlevel == "2") {
	  $level_name = "<font color=blue>$txt_sys_supplier_11</font>";
  } else {
	  $level_name = "-!-";
  }

  echo("<td>$level_name</td>");
  echo("</tr>");
  
  
  // Sub Table
if($mode == "view" AND $gcode == $group_code) {

	$query_s = "SELECT uid,branch_code,share_normal,share_promo,upd_date FROM client_consign_share WHERE group_code = '$group_code' ORDER BY upd_date DESC";
	$result_s = mysql_query($query_s);
		if (!$result_s) {   error("QUERY_ERROR");   exit; }

	for($s = 0; $s < $total_share; $s++) {
		$s_uid = mysql_result($result_s,$s,0);
		$s_branch_code = mysql_result($result_s,$s,1);
		$s_share_normal = mysql_result($result_s,$s,2);
		$s_share_promo = mysql_result($result_s,$s,3);
		$s_upd_date = mysql_result($result_s,$s,4);
			
		$s_upd_date1 = substr($s_upd_date,0,4);
		$s_upd_date2 = substr($s_upd_date,4,2);
		$s_upd_date3 = substr($s_upd_date,6,2);
		$s_upd_time1 = substr($s_upd_date,8,2);
		$s_upd_time2 = substr($s_upd_date,10,2);
		$s_upd_time3 = substr($s_upd_date,12,2);
			
		if($lang == "ko") {
			$s_upd_date_txt = "$s_upd_date1"."/"."$s_upd_date2"."/"."$s_upd_date3";
		} else {
			$s_upd_date_txt = "$s_upd_date3"."-"."$s_upd_date2"."-"."$s_upd_date1";
		}
			
		$s_upd_time_txt = "$s_upd_time1".":"."$s_upd_time2".":"."$s_upd_time3";

		echo ("
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td><div align=right>&gt;</div></td>
			<td>$s_share_normal %</td>
			<td>$s_share_promo % / $txt_sys_consign_153</td>
			<td>$s_upd_date_txt</td>
		</tr>");
	
	}
	
  }
  
  

   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
				<a href="<?=$link_post?>"><input type="button" value="<?=$txt_comm_frm03?>" class="btn btn-primary"></a>
			
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key\">Next $page_per_block</a>");
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