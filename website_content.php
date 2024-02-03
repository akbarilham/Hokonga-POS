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
$smenu = "website_content";


$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/website_content.php";
$link_post = "$home/website_content_post.php";
$link_upd = "$home/website_content_upd.php";
$link_del = "$home/website_content_del.php";

$sorting_filter = "lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch'";

if(!$sorting_key) { $sorting_key = "signdate"; }
if($sorting_key == "signdate" OR $sorting_key == "upd_date" OR $sorting_key == "uid" OR $sorting_key == "fid") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "subject") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "comment") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "signdate") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "upd_date") { $chk4 = "selected"; } else { $chk4 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wpage_content WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wpage_content WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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


if($client_id == "host") {
	$savedir = "user_file";
} else {
	// $savedir = "user/$client_id/user_file";
	$savedir = "user_file";
}
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
		
		
		<?
		// Preview
		if($mode == "preview" AND $p_uid) {
	
	
		$query_prv = "SELECT subject,subtitle,comment,m_html,m_nlbr,m_filetype,userfile,m_imgdsp,m_caption,img_count,signdate 
				FROM wpage_content WHERE uid = $p_uid";
		$result_prv = mysql_query($query_prv,$dbconn);
			if(!$result_prv) { error("QUERY_ERROR"); exit; }

		$my_subject = @mysql_result($result_prv,0,0);
		$my_subtitle = @mysql_result($result_prv,0,1);
		$my_comment = @mysql_result($result_prv,0,2);
		$my_m_html = @mysql_result($result_prv,0,3);
		$my_nlbr = @mysql_result($result_prv,0,4);
		$my_filetype = @mysql_result($result_prv,0,5);
		$my_userfile = @mysql_result($result_prv,0,6);
		$my_imgdsp = @mysql_result($result_prv,0,7);
		$my_caption = @mysql_result($result_prv,0,8);
		$my_img_count = @mysql_result($result_prv,0,9);
		$my_signdate = @mysql_result($result_prv,0,10);


		// Restore Escaped String
		$my_subject = stripslashes($my_subject);
		$my_comment = stripslashes($my_comment);
		$my_subtitle = stripslashes($my_subtitle);
		$my_caption = stripslashes($my_caption);

		if($my_nlbr == "1") {
			$my_comment = nl2br($my_comment);
		}
		?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <div class="panel-body">
		
			<?=$my_comment?>
			
			<?
			if($my_filetype != "jpg" AND $my_filetype != "gif" AND $my_filetype != "png") {
				echo ("<br><br><li><a href='$savedir/$my_userfile'>$my_userfile</a>");
			}
			?>
		
		</div>
		</section>
		</div>
		</div>
		
		<? } ?>
		
		
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_02?>
			
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
			
			<div class="col-sm-6">&nbsp;</div>
			</div>
			
			<br>
			
			
			<div class="row">
			<div class="col-sm-6">
			
			<?
			echo ("
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF'>:: Select Menu ::</option>");
		
			$query_mmx = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
						WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_depth = '1' ORDER BY b_ord ASC, b_num ASC";
			$result_mmx = mysql_query($query_mmx);
			$row_mmx = mysql_num_rows($result_mmx);
          
			while($row_mmx = mysql_fetch_object($result_mmx)) {
				$mmx_uid = $row_mmx->uid;
				$mmx_room = $row_mmx->room;
				$mmx_mnum = $row_mmx->b_num;
				$mmx_mord = $row_mmx->b_ord;
				$mmx_mcode = $row_mmx->b_loco;
				$mmx_mname = $row_mmx->b_title;
					$mmx_mname = stripslashes($mmx_mname);
				$mmx_mshow = $row_mmx->onoff;
				$mmx_type = $row_mmx->b_type;
				$mmx_option = $row_mmx->b_option;
				$mmx_lagday = $row_mmx->b_lagday;
				$mmx_rows = $row_mmx->b_rows;
				$mmx_permit = $row_mmx->b_permit;
			
				if($mmx_type == "x" OR $mmx_type == "pop" OR $mmx_type == "link" OR $mmx_type == "rss") {
					$mmx_disable = "disabled";
				} else {
					$mmx_disable = "";
				}
				if($key == $mmx_room) {
					$mmx_select = "selected";
				} else {
					$mmx_select = "";
				}
				echo ("<option $mmx_disable value='$PHP_SELF?keyfield=room&key=$mmx_room&b_depth=1&key_type=$mmx_type&key_gate=$key_gate' $mmx_select>[ $mmx_room ] $mmx_mname</option>");
			
			
				$query_smx2 = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
							WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$mmx_mcode' AND b_depth = '2' 
							ORDER BY b_ord ASC, b_num ASC";
				$result_smx2 = mysql_query($query_smx2);
				$row_smx2 = mysql_num_rows($result_smx2);
          
				while($row_smx2 = mysql_fetch_object($result_smx2)) {
					$smx2_uid = $row_smx2->uid;
					$smx2_room = $row_smx2->room;
					$smx2_mnum = $row_smx2->b_num;
					$smx2_mord = $row_smx2->b_ord;
					$smx2_mcode = $row_smx2->b_loco;
					$smx2_mname = $row_smx2->b_title;
						$smx2_mname = stripslashes($smx2_mname);
					$smx2_mshow = $row_smx2->onoff;
					$smx2_type = $row_smx2->b_type;
					$smx2_option = $row_smx2->b_option;
					$smx2_lagday = $row_smx2->b_lagday;
					$smx2_rows = $row_smx2->b_rows;
					$smx2_permit = $row_smx2->b_permit;
			
					if($smx2_type == "emag" OR $smx2_type == "blnk" OR $smx2_type == "news" OR $smx2_type == "week") {
						$smx2_disable = "";
					} else {
						$smx2_disable = "disabled";
					}
					if($key == $smx2_room) {
						$smx2_select = "selected";
					} else {
						$smx2_select = "";
					}
					echo ("<option value='$PHP_SELF?keyfield=room&key=$smx2_room&b_depth=2&key_type=$smx2_type&key_gate=$key_gate' $smx2_select>&nbsp;&nbsp; [ $smx2_room ] $smx2_mname</option>");
				
				
					$query_smx3 = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
								WHERE gate = '$key_gate' AND branch_code = '$login_branch' AND lang = '$lang' AND b_loco = '$mmx_mcode' AND room LIKE '$smx2_room%' AND b_depth = '3' 
								ORDER BY b_ord ASC, b_num ASC";
					$result_smx3 = mysql_query($query_smx3);
					$row_smx3 = mysql_num_rows($result_smx3);
          
					while($row_smx3 = mysql_fetch_object($result_smx3)) {
						$smx3_uid = $row_smx3->uid;
						$smx3_room = $row_smx3->room;
						$smx3_mnum = $row_smx3->b_num;
						$smx3_mord = $row_smx3->b_ord;
						$smx3_mcode = $row_smx3->b_loco;
						$smx3_mname = $row_smx3->b_title;
							$smx3_mname = stripslashes($smx3_mname);
						$smx3_mshow = $row_smx3->onoff;
						$smx3_type = $row_smx3->b_type;
						$smx3_option = $row_smx3->b_option;
						$smx3_lagday = $row_smx3->b_lagday;
						$smx3_rows = $row_smx3->b_rows;
						$smx3_permit = $row_smx3->b_permit;
			
						if($smx3_type == "emag" OR $smx3_type == "blnk" OR $smx3_type == "news") {
							$smx3_disable = "";
						} else {
							$smx3_disable = "disabled";
						}
						if($key == $smx3_room) {
							$smx3_select = "selected";
						} else {
							$smx3_select = "";
						}
						echo ("<option value='$PHP_SELF?keyfield=room&key=$smx3_room&b_depth=3&key_type=$smx3_type&key_gate=$key_gate' $smx3_select>&nbsp;&nbsp;&nbsp;&nbsp; [ $smx3_room ] $smx3_mname</option>");
				
					}
				
			
				}
		
		
			}
		
			echo("</select>
			
			</div>
			
			<div class='col-sm-3'>&nbsp;</div>
			<div class='col-sm-3'>
			
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control pull-right'>
			<option value='$PHP_SELF?sorting_key=room&key=$key&keyfield=$keyfield&key_gate=$key_gate'>$txt_web_content_order5</option>
			<option value='$PHP_SELF?sorting_key=subject&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk1>$txt_web_content_order1</option>
			<option value='$PHP_SELF?sorting_key=comment&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk2>$txt_web_content_order2</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk3>$txt_web_content_order3</option>
			<option value='$PHP_SELF?sorting_key=upd_date&key=$key&keyfield=$keyfield&key_gate=$key_gate' $chk4>$txt_web_content_order4</option>
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
   <th>No.</th>
   <th>$txt_web_menu_12</th>
   <th>$bdtxt_02</th>
   <th>$bdtxt_04</th>
   <th>$bdtxt_05</th>
   <th>$txt_comm_frm12</th>
   <th>$txt_comm_frm13</th>
</tr>
</thead>

<tbody>
");


$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,b_loco,room,subject,ref,display,b_type,signdate FROM wpage_content WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,b_loco,room,subject,ref,display,b_type,signdate FROM wpage_content WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $b_uid = mysql_result($result,$i,0);   
   $b_loco = mysql_result($result,$i,1);   
   $b_room = mysql_result($result,$i,2);
   $b_subject = mysql_result($result,$i,3);
		$b_subject = stripslashes($b_subject);
   $b_ref = (int)(mysql_result($result,$i,4));
   $b_display = mysql_result($result,$i,5);
   $b_type = mysql_result($result,$i,6);
   $b_signdate = mysql_result($result,$i,7);
   
	if($lang == "ko") {
		$b_signdate_txt = date("Y/m/d",$b_signdate);
	} else {
		$b_signdate_txt = date("d-M-Y",$b_signdate);
	}
				
   
	if($b_display == "1") {
		$b_display_color = "#000000";
	} else {
		$b_display_color = "#888888";
	}

	if(!strcmp($keyfield,"$b_subject") && $key) {
		$b_subject = eregi_replace("($key)", "<font color=red>\\1</font>", $b_subject);
	}


	echo("
	<tr>
		<td>$article_num</td>
		<td><font color='$b_display_color'>$b_room</font></td>
		<td><a href=\"$link_list?keyfield=$keyfield&key=$key&key_type=$b_type&page=$page&p_uid=$b_uid&mode=preview&key_gate=$key_gate\"><font color='$b_display_color'>$b_subject</font></a></td>
		<td>$b_signdate_txt</td>
		
		<td>");
		echo (number_format($b_ref));  
		echo("</td>
     
		<td><a href='$link_upd?keyfield=$keyfield&key=$key&key_type=$b_type&page=$page&uid=$b_uid&key_gate=$key_gate'><font color='navy'>$txt_comm_frm12</font></a></td>
		<td><a href='$link_del?keyfield=$keyfield&key=$key&key_type=$b_type&page=$page&uid=$b_uid&key_gate=$key_gate'><font color='navy'>$txt_comm_frm13</font></a></td>
   </tr>");

   $article_num--;
}
?>

<tbody>
</table>
</section>
		
				<br>
				<? if($key_type != "") { ?>
					<a href="<?echo("$link_post?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&key_gate=$key_gate")?>"><input type="button" value="<?=$txt_web_content_05?>" class="btn btn-primary"></a>
				<? } else { ?>
					<a href="<?echo("$link_list?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&key_type=$key_type&key_gate=$key_gate")?>"><input type="button" value="<?=$txt_web_content_06?>" class="btn btn-default"></a>
				<? } ?>
				
				<ul class="pagination pagination-sm pull-right">
				<?
				echo ("<li><a href='$link_list?&key_gate=$key_gate'><i class='fa fa-reorder'></i></a></li>");
				
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&key_gate=$key_gate\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&key_gate=$key_gate\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&key_gate=$key_gate\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&key_gate=$key_gate\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&key_gate=$key_gate\">Next $page_per_block</a>");
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