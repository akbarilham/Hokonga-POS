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
$smenu = "crm_mailing1";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_dir = "$home";
$link_list = "$home/crm_mailing1.php";
$link_post = "$home/crm_mailing1_post.php";
$link_upd = "$home/crm_mailing1_upd.php";
$link_del = "$home/crm_mailing1_del.php";
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
if($now_group_admin == "1" OR $login_level > "3") {
	$sorting_filter = "email != ''";
} else {
	$sorting_filter = "email != '' AND branch_code = '$login_branch'";
}


if(!$sorting_key) { $sorting_key = "signdate"; }
if($sorting_key == "signdate") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "name") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "email") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "phone_cel") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "birthday") { $chk5 = "selected"; } else { $chk5 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM member_staff WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM member_staff WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?echo("$title_module_08041")?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-6">
			
			<?
			if($now_group_admin == "1" OR $login_level > "3") {
				$query_kr = "SELECT count(uid) FROM client_branch";
			} else {
				$query_kr = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
			}
			$result_kr = mysql_query($query_kr);
				if (!$result_kr) { error("QUERY_ERROR"); exit; }
			$total_kr = @mysql_result($result_kr,0,0);

			if($now_group_admin == "1" OR $login_level > "3") {
				$query = "SELECT branch_code,branch_name,userlevel FROM client_branch ORDER BY branch_code ASC";
			} else {
				$query = "SELECT branch_code,branch_name,userlevel FROM client_branch WHERE branch_code = '$login_branch' ORDER BY branch_code ASC";
			}
			$result = mysql_query($query);
				if (!$result) {   error("QUERY_ERROR");   exit; }

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			if($now_group_admin == "1" OR $login_level > "3") {
				echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");
			}

			for($i = 0; $i < $total_kr; $i++) {
				$branch_code = mysql_result($result,$i,0);
				$branch_name = mysql_result($result,$i,1);
				$userlevel = mysql_result($result,$i,2);
        
				if($branch_code == $key) {
					$slc_brc = "selected";
				} else {
					$slc_brc = "";
				}

				echo("<option value='$PHP_SELF?keyfield=branch_code&key=$branch_code&mb_level=$mb_level&mb_type=$mb_type' $slc_brc>[$branch_code] $branch_name</option>");
			}
			echo("</select>
			
			</div>
			
			
			<div class='col-sm-3' align=right></div>
			
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield'>$txt_sys_client_06</option>
			<option value='$PHP_SELF?sorting_key=name&key=$key&keyfield=$keyfield' $chk1>$txt_stf_staff_08</option>
			<option value='$PHP_SELF?sorting_key=email&key=$key&keyfield=$keyfield' $chk2>Email</option>
			<option value='$PHP_SELF?sorting_key=phone_cel&key=$key&keyfield=$keyfield' $chk4>$txt_sys_client_09</option>
			<option value='$PHP_SELF?sorting_key=birthday&key=$key&keyfield=$keyfield' $chk5>$txt_stf_staff_12</option>
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
			<th>$txt_stf_staff_08</th>
			<th>$txt_stf_staff_09</th>
			<th>Email</th>
			<th>$txt_stf_staff_12</th>
			<th>$txt_web_mailing_01</th>
			<th>$txt_web_mailing_02</th>
        </tr>"); ?>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,name,gender,id,email,userlevel,signdate,mlist,crmflag,memo,birthday FROM member_staff 
			WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,name,gender,id,email,userlevel,signdate,mlist,crmflag,memo,birthday FROM member_staff 
			WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid2 = mysql_result($result,$i,0);
   $name = mysql_result($result,$i,1);
   $gender = mysql_result($result,$i,2);
		if($gender == "F") {
			$gender_txt = "<font color=red>F</font>";
		} else {
			$gender_txt = "<font color=blue>M</font>";  
		}
   $id = mysql_result($result,$i,3);
   $email = mysql_result($result,$i,4);
   $userlevel = mysql_result($result,$i,5);
   $signdate = mysql_result($result,$i,6);
	   $signdates = date("Y-m-d",$signdate);

   $mlist = mysql_result($result,$i,7);
   $crmflag = mysql_result($result,$i,8);
   $m_mails = mysql_result($result,$i,9);
   $birthday = mysql_result($result,$i,10);
		$birth1 = substr($birthday,0,4);
		$birth2 = substr($birthday,4,2);
		$birth3 = substr($birthday,6,2);
		
		if($lang == "ko") {
			$birthday_txt = "$birth1"."/"."$birth2"."/"."$birth3";
		} else {
			$birthday_txt = "$birth3"."-"."$birth2"."-"."$birth1";
		}
      
   
   if(!strcmp($key,"$name") && $key) {
      $name = eregi_replace("($key)", "<font color=red>\\1</font>", $name);
   }
   if(!strcmp($key,"$name") && $key) {
      $name = eregi_replace("($key)", "<font color=red>\\1</font>", $name);
   }


	echo("<tr>");
	echo("<td><div align=right>$article_num</div></td>");
  
	echo("<td><font color=black title='$m_mails'>$name</font></td>");
	echo("<td>$gender_txt</td>");
	echo("<td>$email</td>");
	echo("<td>$birthday_txt</td>");
      
   

	if($mlist == "1") {
		$mlist_txt = "<font color=blue>$txt_web_mailing_01_yes</font>";
	} else {
		$mlist_txt = "......";
	}
	echo("<td bgcolor=#FFFFFF align=center>$mlist_txt</td>");
	
    if($crmflag == "1") {
		echo("<td bgcolor=#FFFFFF align=\"center\"><a href=\"$link_dir/work_mailing_M_remove.php?lang=$lang&gate=$login_gate&uid=$uid2&page=$page&keyfield=$keyfield&key=$key&rmode=1\" onMouseOver=\"status='drop this record'\" onMouseOut=\"status=''\"><font color=#888888>$txt_web_mailing_021</font></a></td>");
	} else {
		echo("<td bgcolor=#FFFFFF align=\"center\"><a href=\"$link_dir/work_mailing_M_add.php?lang=$lang&gate=$login_gate&uid=$uid2&page=$page&keyfield=$keyfield&key=$key&rmode=1\" onMouseOver=\"status='Add this To the Mailing List'\" onMouseOut=\"status=''\"><font color=green>$txt_web_mailing_022</font></a></td>");
	}
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&mb_level=$mb_level&mb_type=$mb_type\">Next $page_per_block</a>");
				}
				?>
				</ul>
				
				
				
			<table width=100% cellspacing=0 cellpadding=0 border=0>
			<form method="post" class="form-horizontal" action="<?echo("$link_list")?>">
			<input type="hidden" name="keyfield" value="mlist">
			<tr>
			<td width=35%>
		  
				<?=$txt_web_mailing_01?> : &nbsp;&nbsp; 
				<? if($key == "1") { ?>
				<input type=radio name=key value='1' checked> <?=$txt_web_mailing_01_yes?> &nbsp;&nbsp; 
				<? } else { ?>
				<input type=radio name=key value='1'> <?=$txt_web_mailing_01_yes?> &nbsp;&nbsp; 
				<? } ?>
				<? if($key == "0") { ?>
				<input type=radio name=key value='0' checked> <?=$txt_web_mailing_01_no?> 
				<? } else { ?>
				<input type=radio name=key value='0'> <?=$txt_web_mailing_01_no?> 
				<? } ?>
				
				&nbsp;&nbsp; 
				<input type="submit" name="submit" class="btn btn-default" value=" <?=$txt_comm_frm26?> ">
		  
			</td>
			</form>
		  
			<td width=65% align=right>
			<?
			echo ("
  
			<b>$txt_web_mailing_03</b> : <font color=green><b>$total_SL_count</b></font> / $total_record ( Excl. <b>$rest_SL_count</b> ) | &nbsp;
			<a href='$link_dir/work_mailing_M_add_all.php?lang=$lang&gate=$login_gate&page=$page&rmode=1'><font color=blue>[ $txt_web_mailing_04 ]</font></a>
			<a href='$link_dir/work_mailing_M_remove_all.php?lang=$lang&gate=$login_gate&page=$page&rmode=1'><font color=red>[ $txt_web_mailing_05 ]</font></a>
      
			");
			?>
			</td>
			</tr>
			<tr><td colspan=2 height=10></td></tr>
			</table>
			
	
	<form method="post2" class="form-horizontal" action="<?echo("$link_send?room=staff")?>">		
	<div class="form-group ">
    <div class="col-sm-6">
    <?
	if($now_group_admin == "1" OR $login_level > "3") {
		$query_lt = "SELECT count(uid) FROM mail_delivery WHERE lang = '$lang'";
	} else {
		$query_lt = "SELECT count(uid) FROM mail_delivery WHERE lang = '$lang' AND branch_code = '$login_branch'";
	}
    $result_lt = mysql_query($query_lt);
      if (!$result_lt) { error("QUERY_ERROR"); exit; }
    $total_letter = @mysql_result($result_lt,0,0);

    if($now_group_admin == "1" OR $login_level > "3") {
		$query_letter = "SELECT uid,issue_no,cnt_head,cnt_subject,count_sent FROM mail_delivery 
                    WHERE lang = '$lang' ORDER BY uid DESC";
	} else {
		$query_letter = "SELECT uid,issue_no,cnt_head,cnt_subject,count_sent FROM mail_delivery 
                    WHERE lang = '$lang' AND branch_code = '$login_branch' ORDER BY uid DESC";
	}
    $result_letter = mysql_query($query_letter);
      if (!$result_letter) {   error("QUERY_ERROR");   exit; }

    echo ("<select name='uid' class='form-control' required>");
	echo ("<option value=\"\">:: $txt_web_mailing_06</option>");
    
    for($ml = 0; $ml < $total_letter; $ml++) {
      $ml_uid = mysql_result($result_letter,$ml,0);
      $ml_no = mysql_result($result_letter,$ml,1);
      $ml_head = mysql_result($result_letter,$ml,2);
      $ml_subject = mysql_result($result_letter,$ml,3);
      $ml_count = mysql_result($result_letter,$ml,4);
      
          $ml_subject = stripslashes($ml_subject);
          $ml_subject = htmlspecialchars($ml_subject);
          
    echo ("<option value='$ml_uid'>$ml_no [$ml_head] $ml_subject</option>");
    }
    ?>
    <select>
	</div>

    <input type="hidden" name="keyfield" value="<?=$keyfield?>">
    <input type="hidden" name="key" value="<?=$encoded_key?>">
	<input type="hidden" name="rmode" value="1">
    
	<div class="col-sm-6">
		<input type="submit" name="submit" value="<?=$txt_comm_frm18?>" class="btn btn-primary">
	</div>
	</div>
	</form>
				
				
				
							
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