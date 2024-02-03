<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_shop";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_shop.php";
$link_post = "$home/system_shop_post.php?asso_type=$asso_type&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_upd = "$home/system_shop_upd.php";
$link_del = "$home/system_shop_del.php";
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
if(!$sorting_key) { $sorting_key = "shop_name"; }
// if(!$sorting_key) { $sorting_key = "signdate"; }

if($sorting_key == "signdate") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "shop_code") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "shop_name") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "signdate") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "area") { $chk4 = "selected"; } else { $chk4 = ""; }


if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if($asso_type == "A") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop WHERE associate = '1'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE associate = '1' AND $keyfield LIKE '%$key%'";  
	}
} else if($asso_type == "B") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop WHERE associate = '0'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE associate = '0' AND $keyfield LIKE '%$key%'";  
	}
} else if($asso_type == "E") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop WHERE shop_type = 'on'";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE shop_type = 'on' AND $keyfield LIKE '%$key%'";  
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE $keyfield LIKE '%$key%'";  
	}
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
            <?=$txt_sys_shop_01?> 
			
			<?
			if($asso_type == "A") {
				echo ("($txt_sys_shop_072)");
			} else if($asso_type == "B") {
				echo ("($txt_sys_shop_071)");
			} else if($asso_type == "E") {
				echo ("($txt_sys_shop_074)");
			}
			?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-4">
			
			<?
			$queryC = "SELECT count(uid) FROM client WHERE userlevel > '1' AND userlevel < '6'";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT client_id,client_name FROM client WHERE userlevel > '1' AND userlevel < '6' ORDER BY client_code ASC";
			$resultD = mysql_query($queryD);

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF'>:: $txt_comm_frm20</option>");

			for($i = 0; $i < $total_recordC; $i++) {
				$menu_code = mysql_result($resultD,$i,0);
				$menu_name = mysql_result($resultD,$i,1);
        
				if($menu_code == $key) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

			echo("<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=$sorting_key&keyfield=subgate&key=$menu_code' $slc_gate>&nbsp; $menu_name [ $menu_code ]</option>");
			}
			echo("</select>
			
			</div>
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='system_shop.php'>
			<input type='hidden' name='asso_type' value='$asso_type'>
			<input type='hidden' name='keyfield' value='shop_name'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_sys_shop_06'> 
			</div>
			</form>
			
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=subgate&key=$key&keyfield=$keyfield'>Branch</option>
			<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=shop_code&key=$key&keyfield=$keyfield' $chk3>$txt_sys_shop_05</option>
			<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=shop_name&key=$key&keyfield=$keyfield' $chk1>$txt_sys_shop_06</option>
			<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=signdate&key=$key&keyfield=$keyfield' $chk2>$txt_sys_client_06</option>
			<option value='$PHP_SELF?asso_type=$asso_type&sorting_key=area&key=$key&keyfield=$keyfield' $chk4>$txt_sys_shop_16</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>No.</th>
			<th><?=$txt_comm_frm23?></th>
			<th>System</th>
            <th><?=$txt_sys_shop_05?></th>
            <th><?=$txt_sys_shop_06?></th>
			<th><?=$txt_sys_shop_07?></th>
			<th><?=$txt_sys_shop_16?></th>
			<th><?=$txt_sys_shop_09?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if($asso_type == "A") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE associate = '1' ORDER BY shop_code $sort_now, gate ASC, subgate ASC";
	} else {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE associate = '1' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	}
} else if($asso_type == "B") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE associate = '0' ORDER BY shop_code $sort_now, gate ASC, subgate ASC";
	} else {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE associate = '0' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	}
} else if($asso_type == "E") {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE shop_type = 'on' ORDER BY shop_code $sort_now, gate ASC, subgate ASC";
	} else {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE shop_type = 'on' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	}
} else {
	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop ORDER BY shop_code $sort_now, gate ASC, subgate ASC";
	} else {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area
		FROM client_shop WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	}
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   //$uid = mysql_result($result,$i,0);
	$shop_uid = mysql_result($result,$i,0);
   $shop_gate = mysql_result($result,$i,1);
   $shop_subgate = mysql_result($result,$i,2);
   $shop_code = mysql_result($result,$i,3);
   $shop_type = mysql_result($result,$i,4);
   $shop_name = mysql_result($result,$i,5);
   $shop_manager = mysql_result($result,$i,6);
   $userlevel = mysql_result($result,$i,7);
   $signdate = mysql_result($result,$i,8);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $shop_corp = mysql_result($result,$i,9);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$shop_corp'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$shop_corp_name = @mysql_result($result_gname,0,0);
   $shop_consign = mysql_result($result,$i,10);
   $shop_associate = mysql_result($result,$i,11);
   $shop_area = mysql_result($result,$i,12);
   
   

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$shop_name") && $key) {
    $shop_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $shop_name);
  }
  if(!strcmp($key,"$shop_code") && $key) {
    $shop_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $shop_code);
  }


  echo ("<tr height=22>");
  echo("<td align=center>$article_num</td>");
  echo("<td>{$shop_corp_name}</td>");
  echo("<td>{$shop_subgate}</td>");
  echo("<td><a href='$link_upd?asso_type=$asso_type&uid=$shop_uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>$shop_code</a></td>");
  echo("<td><a href='$link_upd?asso_type=$asso_type&uid=$shop_uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>$shop_name</a></td>");
  
  if($shop_associate == "1") {
	$shop_consign_txt = "<font color=#006699>$txt_sys_shop_073</font>";
  } else {
	$shop_consign_txt = "$txt_sys_shop_071";
  }
  echo("<td>{$shop_consign_txt}</td>");
  
	$query_AR = "SELECT area_code,area_name FROM code_area WHERE area_code = '$shop_area' ORDER BY area_name ASC";
	$result_AR = mysql_query($query_AR);
	
	$shop_area_code = @mysql_result($result_AR,0,0);
	$shop_area_name = @mysql_result($result_AR,0,1);
  
  echo("<td>$shop_area</td>");
  
    
  if($shop_type == "on") {
    $shop_type_txt = "<font color=blue>On-line</font>";
  } else {
    $shop_type_txt = "<font color=black>Off-line</font>";
  }
  // echo("<td>{$shop_type_txt}</td>");

  // echo("<td>{$shop_manager}</td>");
   

  // SHOP 구분
  if($userlevel == "0") {
	  $level_name = "<font color=red>$txt_sys_shop_10</font>";
  } else if($userlevel == "1") {
	  $level_name = "-&gt;-";
  } else if($userlevel == "2") {
	  $level_name = "<font color=blue>$txt_sys_shop_11</font>";
  } else {
	  $level_name = "-!-";
  }

  echo("<td>$level_name</td>");
  echo("</tr>");

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
					echo("<li><a href=\"$link_list?page=$my_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&asso_type=$asso_type\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&asso_type=$asso_type\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&asso_type=$asso_type\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&asso_type=$asso_type\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&asso_type=$asso_type\">Next $page_per_block</a>");
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