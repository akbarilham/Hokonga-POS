<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user2";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_user2.php";
$link_post = "$home/system_user2_post.php";
$link_upd = "$home/system_user2_upd.php";
$link_del = "$home/system_user2_del.php";
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
if(!$sorting_key) { $sorting_key = "shop_code"; }
if($sorting_key == "signdate" OR $sorting_key == "user_level") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

// 검색 필터링
$my_filer = "shop_flag = '$shop_flag' AND user_level < '2'";


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
	if($keyfield == "all") {
		$query = "SELECT count(uid) FROM admin_user WHERE $my_filer AND ( shop_code LIKE '%$key%' OR user_id LIKE '%$key%' OR user_name LIKE '%$key%' )";  
	} else {
		$query = "SELECT count(uid) FROM admin_user WHERE $my_filer AND $keyfield LIKE '%$key%'";  
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
            <?=$txt_sys_user2_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
			
			<div class="row">
			<div class="col-sm-4">
			
			<?
			$queryC = "SELECT count(uid) FROM client WHERE userlevel > '2' AND userlevel < '6'";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT client_id,client_name FROM client WHERE userlevel > '2' AND userlevel < '6' ORDER BY client_id ASC";
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

				echo("<option value='$PHP_SELF?keyfield=gate&key=$menu_code&shop_flag=$shop_flag' $slc_gate>&nbsp; [ $menu_code ] $menu_name</option>");
			}
			echo("</select>
			
			</div>
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='system_user2.php'>
			<input type='hidden' name='shop_flag' value='$shop_flag'>
			<input type='hidden' name='keyfield' value='all'>
			<div class='col-sm-3'>
				<input type='text' name='key' value='$key' class='form-control'> 
			</div>
			</form>
			
			<div class='col-sm-3'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=shop_code&key=$key&keyfield=$keyfield&shop_flag=$shop_flag'>Shop Code</option>
			<option value='$PHP_SELF?sorting_key=user_id&key=$key&keyfield=$keyfield&shop_flag=$shop_flag' $chk1>$txt_sys_user_05</option>
			<option value='$PHP_SELF?sorting_key=user_name&key=$key&keyfield=$keyfield&shop_flag=$shop_flag' $chk2>$txt_sys_user_06</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield&shop_flag=$shop_flag' $chk3>$txt_sys_client_06</option>
			<option value='$PHP_SELF?sorting_key=user_level&key=$key&keyfield=$keyfield&shop_flag=$shop_flag' $chk4>$txt_sys_user_08</option>
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
            <th colspan=2>Branch &gt; <?=$txt_sys_user2_07?></th>
            <th><?=$txt_sys_user_05?></th>
            <th><?=$txt_sys_user_06?></th>
			<th><?=$txt_sys_user_09?></th>
			<th><?=$txt_sys_user_10?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,branch_code,gate,subgate,user_id,user_name,user_level,signdate,log_in,visit,shop_code
				FROM admin_user WHERE $my_filer ORDER BY $sorting_key $sort_now, user_level DESC, shop_userlevel DESC";
} else {
	if($keyfield == "all") {
		$query = "SELECT uid,branch_code,gate,subgate,user_id,user_name,user_level,signdate,log_in,visit,shop_code
				FROM admin_user WHERE $my_filer AND ( shop_code LIKE '%$key%' OR user_id LIKE '%$key%' OR user_name LIKE '%$key%' ) 
				ORDER BY $sorting_key $sort_now, user_level DESC, shop_userlevel DESC";
	} else {
		$query = "SELECT uid,branch_code,gate,subgate,user_id,user_name,user_level,signdate,log_in,visit,shop_code
				FROM admin_user WHERE $my_filer AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, user_level DESC, shop_userlevel DESC";
	}
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
   $user_gate = mysql_result($result,$i,2);
   $user_subgate = mysql_result($result,$i,3);
   $user_id = mysql_result($result,$i,4);
   $user_name = mysql_result($result,$i,5);
   $userlevel = mysql_result($result,$i,6);
   $signdate = mysql_result($result,$i,7);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $logdate = mysql_result($result,$i,8);
   if($logdate == "1") {
      $logdates = "$txt_sys_user_12";
   } else {
    if($lang == "ko") {
	    $logdates = date("y/m, H:i",$logdate);
	  } else {
	    $logdates = date("d-m, H:i",$logdate);
	  }
	 }
   $log_visit = mysql_result($result,$i,9);
   $user_shop_code = mysql_result($result,$i,10);

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$user_name") && $key) {
    $user_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_name);
  }
  if(!strcmp($key,"$user_id") && $key) {
    $user_id = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_id);
  }

  // 구분
  $exp_branch_code = explode("_",$branch_code);
  $exp_branch_code1 = $exp_branch_code[1];
  
  if(!$branch_code == "") {
    $exp_branch_code2 = $exp_branch_code1;
  } else {
    $exp_branch_code2 = "01";
  }


  echo ("<tr height=22>");
  echo("<td align=center>$article_num</td>");
  
  
    if($userlevel > "0") {
      $userlevel_font = "blue";
    } else {
      $userlevel_font = "red";
    }
  
    echo("<td width=10%>{$user_gate}</td>");
    echo("<td width=14%><font color='$userlevel_font'>$user_shop_code</font></td>");
    
  echo("<td><a href='$link_upd?sorting_key=$sorting_key&shop_flag=$shop_flag&keyfield=$keyfield&key=$key&page=$page&uid=$uid'><font color='$userlevel_font'>{$user_id}</font></a></td>");
  echo("<td><a href='$link_upd?sorting_key=$sorting_key&shop_flag=$shop_flag&keyfield=$keyfield&key=$key&page=$page&uid=$uid'><font color='$userlevel_font'>{$user_name}</font></a></td>");
  echo("<td>$logdates</td>");
  echo("<td>$log_visit</td>");
  echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
					
				<a href="<?echo("$link_post?keyfield=$keyfield&key=$key&sorting_key=$sorting_key&shop_flag=$shop_flag")?>"><input type="button" value="<?=$txt_comm_frm03?>" class="btn btn-primary"></a>
				
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&shop_flag=$shop_flag\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&shop_flag=$shop_flag\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&shop_flag=$shop_flag\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&shop_flag=$shop_flag\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&sorting_key=$sorting_key&shop_flag=$shop_flag\">Next $page_per_block</a>");
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