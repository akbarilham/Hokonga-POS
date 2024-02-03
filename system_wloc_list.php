<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_wloc_list";

// Default Value
if(!$key_br) { $key_br = "CORP_02"; }
if(!$key) { $key = "WH_02"; }

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_wloc_list.php";
$link_post = "$home/system_wloc_list_post.php?keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg";
$link_upd = "$home/system_wloc_list_upd.php";
$link_del = "$home/system_wloc_list_del.php";
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

$query = "SELECT count(uid),sum(cbm) FROM wms_location_list WHERE gudang_code = '$key'";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = @mysql_result($result,0,0);
$total_cbm = @mysql_result($result,0,1);
	$total_cbm_k = number_format($total_cbm,1);

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
            <?=$hsm_name_09_1702?>
			
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
			echo("<option value='$PHP_SELF'>:: $txt_comm_frm25</option>");

			for($i = 0; $i < $total_recordC; $i++) {
				$menu_code = mysql_result($resultD,$i,0);
				$menu_name = mysql_result($resultD,$i,1);
        
				if($menu_code == $key_br) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

				echo("<option value='$PHP_SELF?key_br=$menu_code&key=$key' $slc_gate>$menu_name</option>");
			}
			echo("</select>");
			?>
			
			</div>
			
			<div class="col-sm-4">
			
			<?
			$queryC2 = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$key_br' AND userlevel > '0'";
			$resultC2 = mysql_query($queryC2);
			$total_recordC2 = mysql_result($resultC2,0,0);

			$queryD2 = "SELECT gudang_code,gudang_name FROM code_gudang WHERE branch_code = '$key_br' AND userlevel > '0' ORDER BY userlevel DESC, gudang_code ASC";
			$resultD2 = mysql_query($queryD2);

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF'>:: $txt_comm_frm431</option>");

			for($i2 = 0; $i2 < $total_recordC2; $i2++) {
				$menu_code2 = mysql_result($resultD2,$i2,0);
				$menu_name2 = mysql_result($resultD2,$i2,1);
        
				if($menu_code2 == $key) {
					$slc_gate2 = "selected";
				} else {
					$slc_gate2 = "";
				}

				echo("<option value='$PHP_SELF?key_br=$key_br&key=$menu_code2' $slc_gate2>[ $menu_code2 ] $menu_name2</option>");
			}
			echo("</select>");
			?>
			
			</div>
			
			<div class="col-sm-2" align=right>Total CBM</div>
			<div class="col-sm-2"><input type="text" class="form-control" name="total_cbm" value="<?=$total_cbm_k?>" style="text-align: right"></div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th colspan=3><?=$txt_sys_wloc_05?></th>
			<th><?=$txt_sys_wloc_06?></th>
			<th><?=$txt_sys_wloc_07?></th>
			<th>CBM</th>
			<th><?=$txt_sys_wloc_09?></th>
			<th><?=$txt_sys_wloc_10?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

$query = "SELECT uid,catg_code,loc_code,loc_name,loc_option,code_pic,cbm,post_date,upd_date 
    FROM wms_location_list WHERE gudang_code = '$key' ORDER BY catg_code ASC, loc_code ASC";
$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $loc_uid = mysql_result($result,$i,0);
   $catg_code = mysql_result($result,$i,1);
   $loc_code = mysql_result($result,$i,2);
   $loc_name = mysql_result($result,$i,3);
   $loc_option = mysql_result($result,$i,4);
		if($loc_option != "") {
			$loc_option_txt = "&nbsp; ($loc_option)";
		} else {
			$loc_option_txt = "";
		}
   $code_pic = mysql_result($result,$i,5);
		$query_name = "SELECT name FROM member_staff WHERE code = '$code_pic'";
		$result_name = mysql_query($query_name);
			if (!$result_name) {   error("QUERY_ERROR");   exit; }
		$name_pic = @mysql_result($result_name,0,0);
   $loc_cbm = mysql_result($result,$i,6);
   $post_date = mysql_result($result,$i,7);
   $upd_date = mysql_result($result,$i,8);


  echo ("<tr>");
  
	$i_prev = $i - 1;
	$catg_codeP = mysql_result($result,$i_prev,1);
	
	$catg_code_big = substr($catg_code,0,2);
	$catg_code_mid = substr($catg_code,0,4);
	
	$catgP_code_big = substr($catg_codeP,0,2);
	$catgP_code_mid = substr($catg_codeP,0,4);
	
	// Category Name
	$query_name1 = "SELECT lname FROM wms_catgbig WHERE lcode = '$catg_code_big'";
	$result_name1 = mysql_query($query_name1);
		if (!$result_name1) {   error("QUERY_ERROR");   exit; }
	$catg_code_big_name = @mysql_result($result_name1,0,0);
	
	$query_name2 = "SELECT mname FROM wms_catgmid WHERE mcode = '$catg_code_mid'";
	$result_name2 = mysql_query($query_name2);
		if (!$result_name2) {   error("QUERY_ERROR");   exit; }
	$catg_code_mid_name = @mysql_result($result_name2,0,0);
	
	$query_name3 = "SELECT sname FROM wms_catgsml WHERE scode = '$catg_code'";
	$result_name3 = mysql_query($query_name3);
		if (!$result_name3) {   error("QUERY_ERROR");   exit; }
	$catg_code_name = @mysql_result($result_name3,0,0);
	
	
	
	if($catg_code != $catg_codeP) {
		if($catg_code_mid != $catgP_code_mid) {
			if($catg_code_big != $catgP_code_big) {
				echo ("<td>$catg_code_big_name</td><td>$catg_code_mid_name</td><td>$catg_code_name</td>");
			} else {
				echo ("<td></td><td>$catg_code_mid_name</td><td>$catg_code_name</td>");
			}
		} else {
			if($catg_code_big != $catgP_code_big) {
				echo ("<td>$catg_code_big_name</td><td></td><td>$catg_code_name</td>");
			} else {
				echo ("<td></td><td></td><td>$catg_code_name</td>");
			}
		}
	} else {
		if($catg_code_mid != $catgP_code_mid) {
			if($catg_code_big != $catgP_code_big) {
				echo ("<td>$catg_code_big_name</td><td>$catg_code_mid_name</td><td></td>");
			} else {
				echo ("<td></td><td>$catg_code_mid_name</td><td></td>");
			}
		} else {
			if($catg_code_big != $catgP_code_big) {
				echo ("<td>$catg_code_big_name</td><td></td><td></td>");
			} else {
				echo ("<td></td><td></td><td></td>");
			}
		}
	}
	
	
  echo("<td><a href='$link_upd?uid=$loc_uid&keyfield=$keyfield&key=$key&key_br=$key_br'>{$loc_code}</a></td>");
  echo("<td><a href='$link_upd?uid=$loc_uid&keyfield=$keyfield&key=$key&key_br=$key_br'>{$loc_name} {$loc_option_txt}</a></td>");
  echo("<td align=right>$loc_cbm</td>");
  echo("<td>$name_pic</td>");
  echo("<td>$post_date</td>");
  
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$key&key_br=$key_br&catg=$catg\">Next $page_per_block</a>");
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