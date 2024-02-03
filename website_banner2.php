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
$smenu = "website_banner2";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/website_banner2.php";
$link_post = "$home/website_banner2_post.php";
$link_upd = "$home/website_banner2_upd.php";
$link_del = "$home/website_banner2_del.php";


if($b_room != "") {
		$sorting_filter = "gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$b_loco' AND b_room = '$b_room'";
} else {
	if($b_loco != "") {
		$sorting_filter = "gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$b_loco'";
	} else {
		$sorting_filter = "gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang'";
	}
}


if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wpage_banner2 WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wpage_banner2 WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_08_032?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			
		
		
			<div class="row">
			
			<div class="col-sm-6">
			
		<?
		$queryC = "SELECT count(uid) FROM wpage_config WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '1' AND lang = '$lang'";
		$resultC = mysql_query($queryC);
		$total_recordC = mysql_result($resultC,0,0);

		$queryD = "SELECT b_loco,b_title FROM wpage_config WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '1' AND lang = '$lang'
               ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
		$resultD = mysql_query($queryD);

		echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
		echo ("<option value='$PHP_SELF?key_gate=$key_gate'>Select Banner Location</option>");
		
		if($b_loco == "top") {
			echo ("<option value='$PHP_SELF?b_loco=top&key_gate=$key_gate' selected>-- top : Intro Top Banner (top)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=top&key_gate=$key_gate'>-- top : Intro Top Banner (top)</option>");
		}
		
		if($b_loco == "main_intro") {
			echo ("<option value='$PHP_SELF?b_loco=main_intro&key_gate=$key_gate' selected>-- Intro Stripe Banner (main_intro)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_intro&key_gate=$key_gate'>-- Intro Stripe Banner (main_intro)</option>");
		}
		
		if($b_loco == "main_prev") {
			echo ("<option value='$PHP_SELF?b_loco=main_prev&key_gate=$key_gate' selected>-- A : The Previous Edition (main_prev)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_prev&key_gate=$key_gate'>-- A : The Previous Edition (main_prev)</option>");
		}
		
		// left banner
		for($i = 0; $i < $total_recordC; $i++) {
			$menu_code = mysql_result($resultD,$i,0);
			$menu_name = mysql_result($resultD,$i,1);
			
			if($b_loco == "main_left" AND $b_room == $menu_code) {
				echo("<option value='$PHP_SELF?b_loco=main_left&b_room=$menu_code&key_gate=$key_gate' selected>-- B : Stripe Banners - $menu_name</option>");
			} else {
				echo("<option value='$PHP_SELF?b_loco=main_left&b_room=$menu_code&key_gate=$key_gate'>-- B : Stripe Banners - $menu_name</option>");
			}
			
			// Sub menu
			$query2C = "SELECT count(uid) FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'";
			$result2C = mysql_query($query2C);
			$total_record2C = mysql_result($result2C,0,0);

			$query2D = "SELECT b_loco,b_title,room FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$menu_code' AND b_depth = '2' AND lang = '$lang'
               ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
			$result2D = mysql_query($query2D);
			
			for($i2 = 0; $i2 < $total_record2C; $i2++) {
				$smenu_code = mysql_result($result2D,$i2,0);
				$smenu_name = mysql_result($result2D,$i2,1);
				$smenu_room = mysql_result($result2D,$i2,2);
			
				if($b_loco == "main_left" AND $b_room == $smenu_room) {
					echo("<option value='$PHP_SELF?b_loco=main_left&b_room=$smenu_room&key_gate=$key_gate' selected>-- B : Stripe Banners - $menu_name &gt; $smenu_name</option>");
				} else {
					echo("<option value='$PHP_SELF?b_loco=main_left&b_room=$smenu_room&key_gate=$key_gate'>-- B : Stripe Banners - $menu_name &gt; $smenu_name</option>");
				}
			
			}
			
			
		}
		
		if($b_loco == "main_mid") {
			echo ("<option value='$PHP_SELF?b_loco=main_mid&key_gate=$key_gate' selected>-- C : Banner / Video Clip (main_mid)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_mid&key_gate=$key_gate'>-- C : Banner / Video Clip (main_mid)</option>");
		}
		
		
		// header banner
		for($hi = 0; $hi < $total_recordC; $hi++) {
			$hmenu_code = mysql_result($resultD,$hi,0);
			$hmenu_name = mysql_result($resultD,$hi,1);
			
			if($b_loco == "top_logo" AND $b_room == $hmenu_code) {
				echo("<option value='$PHP_SELF?b_loco=top_logo&b_room=$hmenu_code&key_gate=$key_gate' selected>-- D : Header Banners - $hmenu_name</option>");
			} else {
				echo("<option value='$PHP_SELF?b_loco=top_logo&b_room=$hmenu_code&key_gate=$key_gate'>-- D : Header Banners - $hmenu_name</option>");
			}
			
			// Sub menu
			$query3C = "SELECT count(uid) FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$hmenu_code' AND b_depth = '2' AND lang = '$lang'";
			$result3C = mysql_query($query3C);
			$total_record3C = mysql_result($result3C,0,0);

			$query3D = "SELECT b_loco,b_title,room FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$hmenu_code' AND b_depth = '2' AND lang = '$lang'
               ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
			$result3D = mysql_query($query3D);
			
			for($hi3 = 0; $hi3 < $total_record3C; $hi3++) {
				$hsmenu_code3 = mysql_result($result3D,$hi3,0);
				$hsmenu_name3 = mysql_result($result3D,$hi3,1);
				$hsmenu_room3 = mysql_result($result3D,$hi3,2);
			
				if($b_loco == "top_logo" AND $b_room == $hsmenu_room3) {
					echo("<option value='$PHP_SELF?b_loco=top_logo&b_room=$hsmenu_room3&key_gate=$key_gate' selected>-- D : Header Banners - $hmenu_name &gt; $hsmenu_name3</option>");
				} else {
					echo("<option value='$PHP_SELF?b_loco=top_logo&b_room=$hsmenu_room3&key_gate=$key_gate'>-- D : Header Banners - $hmenu_name &gt; $hsmenu_name3</option>");
				}
			
			}
			
		}
		
		
		
			
		
		
		if($b_loco == "main_midf1") {
			echo ("<option value='$PHP_SELF?b_loco=main_midf1&key_gate=$key_gate' selected>-- E : Fixed Banner 1 / Survey (main_midf1)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_midf1&key_gate=$key_gate'>-- E : Fixed Banner 1 / Survey (main_midf1)</option>");
		}
		
		if($b_loco == "main_midf2") {
			echo ("<option value='$PHP_SELF?b_loco=main_midf2&key_gate=$key_gate' selected>-- F : Fixed Banner 2 (main_midf2)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_midf2&key_gate=$key_gate'>-- F : Fixed Banner 2 (main_midf2)</option>");
		}
		
		
		if($b_loco == "main_midt2") {
			echo ("<option value='$PHP_SELF?b_loco=main_midt2&key_gate=$key_gate' selected>-- H : Multiple Contents Banners (main_midt2)</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=main_midt2&key_gate=$key_gate'>-- H : Multiple Contents Banners (main_midt2)</option>");
		}
		
		
		
		// right banner
		for($ri = 0; $ri < $total_recordC; $ri++) {
			$rmenu_code = mysql_result($resultD,$ri,0);
			$rmenu_name = mysql_result($resultD,$ri,1);
			
			if($b_loco == "main_right" AND $b_room == $rmenu_code) {
				echo("<option value='$PHP_SELF?b_loco=main_right&b_room=$rmenu_code&key_gate=$key_gate' selected>-- I : Right Banners - $rmenu_name</option>");
			} else {
				echo("<option value='$PHP_SELF?b_loco=main_right&b_room=$rmenu_code&key_gate=$key_gate'>-- I : Right Banners - $rmenu_name</option>");
			}
			
			// Sub menu
			$query4C = "SELECT count(uid) FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$rmenu_code' AND b_depth = '2' AND lang = '$lang'";
			$result4C = mysql_query($query4C);
			$total_record4C = mysql_result($result4C,0,0);

			$query4D = "SELECT b_loco,b_title,room FROM wpage_config 
					WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND b_loco = '$rmenu_code' AND b_depth = '2' AND lang = '$lang'
               ORDER BY b_depth ASC, b_ord ASC, b_num ASC";
			$result4D = mysql_query($query4D);
			
			for($i4 = 0; $i4 < $total_record4C; $i4++) {
				$smenu_code4 = mysql_result($result4D,$i4,0);
				$smenu_name4 = mysql_result($result4D,$i4,1);
				$smenu_room4 = mysql_result($result4D,$i4,2);
			
				if($b_loco == "main_right" AND $b_room == $smenu_room4) {
					echo("<option value='$PHP_SELF?b_loco=main_right&b_room=$smenu_room4&key_gate=$key_gate' selected>-- I : Right Banners - $rmenu_name &gt; $smenu_name4</option>");
				} else {
					echo("<option value='$PHP_SELF?b_loco=main_right&b_room=$smenu_room4&key_gate=$key_gate'>-- I : Right Banners - $rmenu_name &gt; $smenu_name4</option>");
				}
			
			}
			
		}

		
		
		if($b_loco == "intro") {
			echo ("<option value='$PHP_SELF?b_loco=intro&key_gate=$key_gate' selected>-- intro : Introduction Page Screen</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=intro&key_gate=$key_gate'>-- intro : Introduction Page Screen</option>");
		}
		
		if($b_loco == "popup") {
			echo ("<option value='$PHP_SELF?b_loco=popup&key_gate=$key_gate' selected>-- Popup Layer</option>");
		} else {
			echo ("<option value='$PHP_SELF?b_loco=popup&key_gate=$key_gate'>-- Popup Layer</option>");
		}
		
		echo ("</select>");
		?>
			</div>
			
			
			<div class='col-sm-3'>&nbsp;</div>
			<div class='col-sm-3'>
			
			<? echo ("
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control pull-right'>
			<option value='$PHP_SELF?sorting_key=b_id&key=$key&keyfield=$keyfield&key_gate=$key_gate'>$txt_web_banner1_order0</option>
			<option value='$PHP_SELF?sorting_key=uid&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk1>$txt_web_banner1_order1</option>
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
   <th>$txt_web_banner2_05</th>
   <th>$txt_web_banner1_05</th>
   <th>Note</th>
   <th>$txt_web_banner2_06</th>
   <th>$txt_web_content_12</th>
   <th>$bdtxt_04</th>
   <th>$txt_comm_frm12</th>
   <th>$txt_comm_frm13</th>
</tr>
</thead>

<tbody>
");


$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query_x = "SELECT uid,b_id,b_loco,b_ord,b_alt,b_url,b_show,signdate,user_id,b_room FROM wpage_banner2 
			WHERE $sorting_filter ORDER BY b_loco ASC, b_room ASC, b_ord ASC, b_id ASC";
} else {
   $query_x = "SELECT uid,b_id,b_loco,b_ord,b_alt,b_url,b_show,signdate,user_id,b_room FROM wpage_banner2 
			WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY b_loco ASC, b_room ASC, b_ord ASC, b_id ASC";
}

$result_x = mysql_query($query_x);
if (!$result_x) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($ix = $first; $ix <= $last; $ix++) {
   $bx_uid = mysql_result($result_x,$ix,0);   
   $bx_id = mysql_result($result_x,$ix,1);
   $bx_loco = mysql_result($result_x,$ix,2);
   $bx_ord = mysql_result($result_x,$ix,3);
   $bx_alt = mysql_result($result_x,$ix,4);
   $bx_url = mysql_result($result_x,$ix,5);
   $bx_show = mysql_result($result_x,$ix,6);
   $signdate = mysql_result($result_x,$ix,7);
		$date1 = substr($signdate,0,4);
		$date2 = substr($signdate,4,2);
		$date3 = substr($signdate,6,2);
		$time1 = substr($signdate,8,2);
		$time2 = substr($signdate,10,2);
		$time3 = substr($signdate,12,2);
		
		if($lang == "ko") {
			$signdate_txt = "$date1"."/"."$date2"."/"."$date3";
		} else {
			$signdate_txt = "$date3"."-"."$date2"."-"."$date1";
		}
		
	 
	$user_id = mysql_result($result_x,$ix,8);
	$bx_room = mysql_result($result_x,$ix,9);
	
	// Banner Note
	$query4F = "SELECT memo FROM wpage_banner1 WHERE gate = '$login_gate' AND b_id = '$bx_id' ORDER BY uid DESC";
	$result4F = mysql_query($query4F);
	$bx_memo = @mysql_result($result4F,0,0);
		$bx_memo = stripslashes($bx_memo);
	
	
	if(!strcmp($keyfield,"$bx_id") && $key) {
      $bx_id = eregi_replace("($key)", "<font color=red>\\1</font>", $bx_id);
    }


  echo("<tr>");
  
  // Location
   echo("<td>{$bx_loco} ({$bx_ord})</td>");    

  // Banner Code
   echo("<td>{$bx_id}</td>");
   echo("<td>{$bx_memo}</td>");
  
  // Account
   echo("<td>{$user_id}</td>");

  // Show
  if($bx_show == "1") {
    $bx_show_txt = "<font color=blue>ON</font>";
  } else {
    $bx_show_txt = "<font color=red>OFF</font>";
  }
  
   echo("<td>$bx_show_txt</td>");

  // Signdate
   echo("<td>$signdate_txt</td>");
   echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$bx_uid&b_loco=$bx_loco&b_room=$bx_room&key_gate=$key_gate'><font color='navy'>$txt_comm_frm12</font></a></td>");
   echo("<td><a href='$link_del?keyfield=$keyfield&key=$key&page=$page&uid=$bx_uid&b_loco=$bx_loco&b_room=$bx_room&key_gate=$key_gate'><font color='navy'>$txt_comm_frm13</font></a></td>");
   echo("</tr>");

   $article_num--;
}
?>

<tbody>
</table>
</section>
		
				<br>
				
				<a href="<?echo("$link_post?&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate")?>"><input type="button" value="<?=$txt_web_banner2_07?>" class="btn btn-primary"></a>

				
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&b_loco=$b_loco&b_room=$b_room&key_gate=$key_gate\">Next $page_per_block</a>");
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