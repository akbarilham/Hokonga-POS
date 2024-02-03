<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_user.php";
$link_post = "$home/system_user_post.php";
$link_upd = "$home/system_user_upd.php";
$link_del = "$home/system_user_del.php";
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
// Sorting
if(!$sorting_key) { $sorting_key = "user_level"; }
if($sorting_key == "signdate" OR $sorting_key == "user_level") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

// Filtering
if($login_level > "8") {
  $my_filer = "shop_flag = '0'";
} else if($login_level < "9" AND $login_level > "6") {
  $my_filer = "shop_flag = '0' AND user_level < '9'";
} else if($login_level == "6") {
  $my_filer = "shop_flag = '0' AND user_level < '7'";
} else if($login_level < "6") {
  $my_filer = "shop_flag = '0' AND user_level < '6'";
}

if($sorting_key == "user_id") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "user_name") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "signdate") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "user_level") { $chk4 = "selected"; } else { $chk4 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM admin_user WHERE $my_filer";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM admin_user WHERE $my_filer AND $keyfield LIKE '%$key%'";  
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
            <?=$txt_sys_user_01?>
			
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
        
				if($menu_code == $key) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

				echo("<option value='$PHP_SELF?keyfield=branch_code&key=$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
			}
			echo("</select>
			
			</div>
			
			<div class='col-sm-2'></div>
			
			<div class='col-sm-2' align=right>$txt_comm_frm14 : </div>
			
			<div class='col-sm-4'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=branch_code&key=$key&keyfield=$keyfield'>$txt_comm_frm23</option>
			<option value='$PHP_SELF?sorting_key=user_id&key=$key&keyfield=$keyfield' $chk1>$txt_sys_user_05</option>
			<option value='$PHP_SELF?sorting_key=user_name&key=$key&keyfield=$keyfield' $chk2>$txt_sys_user_06</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield' $chk3>$txt_sys_client_06</option>
			<option value='$PHP_SELF?sorting_key=user_level&key=$key&keyfield=$keyfield' $chk4>$txt_sys_user_08</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th colspan=2><?=$txt_sys_user_08?> &gt; <?=$txt_sys_user_07?></th>
            <th><?=$txt_sys_user_05?></th>
            <th><?=$txt_sys_user_06?></th>
			<th>PT</th>
			<th><?=$txt_sys_user_09?></th>
			<th><?=$txt_sys_user_10?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,gate,user_id,user_name,user_level,signdate,log_in,visit,group_admin
    FROM admin_user WHERE $my_filer ORDER BY $sorting_key $sort_now, user_level DESC";
} else {
   $query = "SELECT uid,branch_code,gate,user_id,user_name,user_level,signdate,log_in,visit,group_admin
    FROM admin_user WHERE $my_filer AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, user_level DESC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);
   $user_corp_code = mysql_result($result,$i,1);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$user_corp_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$user_corp_name = @mysql_result($result_gname,0,0);
   $user_gate = mysql_result($result,$i,2);
   $user_id = mysql_result($result,$i,3);
   $user_name = mysql_result($result,$i,4);
   $userlevel = mysql_result($result,$i,5);
   $signdate = mysql_result($result,$i,6);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $logdate = mysql_result($result,$i,7);
   if($logdate == "1") {
      $logdates = "$txt_sys_user_12";
   } else {
    if($lang == "ko") {
	    $logdates = date("y/m, H:i",$logdate);
	  } else {
	    $logdates = date("d-m, H:i",$logdate);
	  }
	 }
   $log_visit = mysql_result($result,$i,8);
   $group_admin = mysql_result($result,$i,9);

  if(!strcmp($key,"$user_name") && $key) {
    $user_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_name);
  }
  if(!strcmp($key,"$user_id") && $key) {
    $user_id = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_id);
  }

  // User Level
  if($userlevel == "0") {
	  $level_name = "<font color=red>Hold</font>";
  } else if($userlevel == "1") {
	  $level_name = "-&gt;-";
  } else if($userlevel == "2") {
	  $level_name = "Sales";
  } else if($userlevel == "3") {
	  $level_name = "Branch";
  } else if($userlevel == "4") {
	  $level_name = "Regional";
  } else if($userlevel == "5") {
	  $level_name = "Division";
  } else if($userlevel == "6") {
	  $level_name = "<font color=green>Inventory</font>";
  } else if($userlevel == "7") {
	  $level_name = "Corporate";
  } else if($userlevel == "8") {
	  $level_name = "Admin";
  } else if($userlevel == "9") {
	  $level_name = "*";
  } else {
	  $level_name = "Unknown";
  }

  $exp_branch_code = explode("_",$branch_code);
  $exp_branch_code1 = $exp_branch_code[1];
  
  if(!$branch_code == "") {
    $exp_branch_code2 = $exp_branch_code1;
  } else {
    $exp_branch_code2 = "01";
  }
  
  if($group_admin == "1") {
	$user_admin_txt = "&nbsp;&nbsp; <font color=#006699><i class='fa fa-unlock-alt'></i></font>";
  } else {
	$user_admin_txt = "";
  }

  echo ("<tr>");
  
  if($userlevel > "7") {
    echo("<td colspan=2>{$level_name}</td>");
  } else if($userlevel < "7" AND $userlevel > "2") {
    echo("<td>$level_name</td>");
	echo("<td>{$user_gate}</td>");
  } else {
    echo("<td align=right>&gt;&nbsp;{$level_name}&nbsp;</td>");
    echo("<td>{$user_gate}</td>");
  }

  echo("<td><a href='$link_upd?uid=$uid'>{$user_id}</a>{$user_admin_txt}</td>");

  echo("<td>$user_name</td>");
  echo("<td>$user_corp_name</td>");
  echo("<td>$logdates</td>");
  echo("<td>$log_visit</td>");


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