<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
	
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }

$mmenu = "crm";
$smenu = "crm_newsletter";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_dir = "$home";
$link_list = "$home/crm_newsletter.php";
$link_post = "$home/crm_newsletter_post.php";
$link_upd = "$home/crm_newsletter_upd.php";
$link_del = "$home/crm_newsletter_del.php";
$link_send = "$home/crm_newsletter_send.php";
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

<?
$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_dir = "$home";
$link_list = "$home/crm_newsletter.php";
$link_post = "$home/crm_newsletter_post.php";
$link_upd = "$home/crm_newsletter_upd.php";
$link_del = "$home/crm_newsletter_del.php";
$link_send = "$home/crm_newsletter_send.php";


$sorting_filter = "lang = '$lang' AND branch_code = '$login_branch'";

if(!$sorting_key) { $sorting_key = "uid"; }
if($sorting_key == "post_date" OR $sorting_key == "send_date" OR $sorting_key == "uid") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "cnt_subject") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "issue_no") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "post_date") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "sent_date") { $chk4 = "selected"; } else { $chk4 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM mail_delivery WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM mail_delivery WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$txt_web_nletter_01?>
			
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
        
							if($web_client_id == $client_id) {
								$slc_gate = "selected";
								$slc_disable = "";
							} else {
								$slc_gate = "";
								$slc_disable = "disabled";
							}

							echo("<option $slc_disable value='$PHP_SELF?client_id=$client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
						}
						echo("</select>
			
			</div>
			
			<div class='col-sm-3' align=right></div>
			
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=uid&key=$key&keyfield=$keyfield'>$txt_web_banner2_14</option>
			<option value='$PHP_SELF?sorting_key=cnt_subject&key=$key&keyfield=$keyfield' $chk1>$bdtxt_02</option>
			<option value='$PHP_SELF?sorting_key=issue_no&key=$key&keyfield=$keyfield' $chk2>$txt_web_nletter_06</option>
			<option value='$PHP_SELF?sorting_key=post_date&key=$key&keyfield=$keyfield' $chk3>$txt_sys_client_06</option>
			<option value='$PHP_SELF?sorting_key=sent_date&key=$key&keyfield=$keyfield' $chk4>$txt_web_mailing_08</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
		<? echo ("
        <tr>
            <th>#</th>
			<th>$bdtxt_02</th>
			<th>$txt_web_mailing_09</th>
			<th>*</th>
			<th>$txt_web_mailing_10</th>
			<th>$txt_sys_client_06</th>
			<th>$txt_web_mailing_08s</th>
			<th>$txt_comm_frm12</th>
			<th>$txt_comm_frm13</th>
        </tr>"); ?>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,room,issue_no,cnt_head,cnt_subject,count_sent,send_flag,post_date,sent_date FROM mail_delivery 
			WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,room,issue_no,cnt_head,cnt_subject,count_sent,send_flag,post_date,sent_date FROM mail_delivery 
			WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $m_uid = mysql_result($result,$i,0);
   $m_room = mysql_result($result,$i,1);   
   $m_no = mysql_result($result,$i,2);
   $m_head = mysql_result($result,$i,3);
   $m_subject = mysql_result($result,$i,4);
   $m_count = mysql_result($result,$i,5);
	$m_count_K = number_format($m_count);
   $m_flag = mysql_result($result,$i,6);
   $m_postdate = mysql_result($result,$i,7);
   $m_sentdate = mysql_result($result,$i,8);


     $post_date1 = substr($m_postdate,0,4);
     $post_date2 = substr($m_postdate,4,2);
     $post_date3 = substr($m_postdate,6,2);
     $post_time = substr($m_postdate,8,8);
          
		if($lang == "ko") {
			$m_postdates = "$post_date1"."/"."$post_date2"."/"."$post_date3";
		} else {
			$m_postdates = "$post_date3"."-"."$post_date2"."-"."$post_date1";
		}


     $sent_date1 = substr($m_sentdate,2,2);
     $sent_date2 = substr($m_sentdate,4,2);
     $sent_date3 = substr($m_sentdate,6,2);
     $sent_time = substr($m_sentdate,8,8);
          
		if($lang == "ko") {
			$m_sentdates = "$sent_date1"."/"."$sent_date2"."/"."$sent_date3";
		} else {
			$m_sentdates = "$sent_date3"."-"."$sent_date2"."-"."$sent_date1";
		}

	// Strip Slashes
	$m_subject = stripslashes($m_subject);
	$m_subject = htmlspecialchars($m_subject);
   
	if(!strcmp($key,"$name") && $key) {
      $name = eregi_replace("($key)", "<font color=red>\\1</font>", $name);
	}
	if(!strcmp($key,"$name") && $key) {
      $name = eregi_replace("($key)", "<font color=red>\\1</font>", $name);
	}


	echo("<tr>");
	echo("<td><div align=right>$article_num</div></td>");
  
	echo("<td>[$m_head] $m_subject</td>");
	echo("<td><div align=right>$m_count_K</div></td>");


	if($m_flag == "1") {
		$m_flag_txt = "<font color=blue>- v -</font>";
	} else {
		$m_flag_txt = "<font color=red>- , -</font>";
	} 
	echo("<td>{$m_flag_txt}</td>");
      
   

	// Mail Sending
	if($m_flag == "1") {
		echo("<td><a href=\"$link_send?keyfield=$keyfield&key=$key&page=$page&uid=$m_uid\" onMouseOver=\"status='Add this To the Mailing List'\" onMouseOut=\"status=''\"><font color=maroon>$txt_web_mailing_11</font></a></td>");
	} else {
		echo("<td><a href=\"$link_send?keyfield=$keyfield&key=$key&page=$page&uid=$m_uid\" onMouseOver=\"status='Add this To the Mailing List'\" onMouseOut=\"status=''\"><font color=green>$txt_web_mailing_12</font></a></td>");
	}

	echo("<td>$m_postdates</td>");
	echo("<td>$m_sentdates</td>");
     
	echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$m_uid'><font color='navy'>$txt_comm_frm12</font></a></td>");
	echo("<td><a href='$link_del?keyfield=$keyfield&key=$key&page=$page&uid=$m_uid'><font color='navy'>$txt_comm_frm13</font></a></td>");
	echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
				<a href="<?=$link_post?>"><input type="button" value="<?=$txt_web_nletter_05?>" class="btn btn-primary"></a>
			
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