<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member2";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/crm_member2.php";
$link_post = "$home/crm_member2_post.php?mb_level=$mb_level&mb_type=$mb_type&key=$key";
$link_upd = "$home/crm_member2_upd.php";
$link_del = "$home/crm_member2_del.php";
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
if($mb_level) {
	$my_filter = "userlevel = '$mb_level'";
} else {
	$my_filter = "userlevel > '3'";
}

// 정렬 필터링
if(!$sorting_key) { $sorting_key = "corp_name"; }
if($sorting_key == "signdate" OR $sorting_key == "userlevel") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

// 고객 코드/회원 ID
$tb_memberid_txt = "$txt_stf_member_05"; // 고객 코드
// $tb_memberid_txt = "$txt_stf_member_06"; // 회원 ID

if($sorting_key == "userlevel") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "code") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "birthday") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "signdate") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "id") { $chk5 = "selected"; } else { $chk5 = ""; }
if($sorting_key == "name") { $chk6 = "selected"; } else { $chk6 = ""; }

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM member_main WHERE $my_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM member_main WHERE $my_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_06_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-4">
			
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
			
			<div class='col-sm-2'></div>
			
			<div class='col-sm-2' align=right>$txt_comm_frm14 : </div>
			
			<div class='col-sm-4'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=corp_name&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type'>$txt_stf_member_08</option>
			<option value='$PHP_SELF?sorting_key=name&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk6>$txt_stf_staff_08</option>
			<option value='$PHP_SELF?sorting_key=code&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk2>$txt_stf_member_55</option>
			<option value='$PHP_SELF?sorting_key=birthday&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk3>$txt_stf_staff_12</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk4>$txt_sys_client_06</option>
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
            <th><?=$txt_stf_member_55?></th>
			<th><?=$txt_stf_member_08?></th>
			<th><?=$txt_sys_supplier_08?></th>
			<th><?=$txt_sys_consign_153?></th>
			<th>&nbsp;</th>
			<th><?=$txt_sys_client_06?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,gate,code,id,name,gender,birthday,email,userlevel,signdate,corp_name,corp_margin
    FROM member_main WHERE $my_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,branch_code,gate,code,id,name,gender,birthday,email,userlevel,signdate,corp_name,corp_margin
    FROM member_main WHERE $my_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
		$query_gname = "SELECT branch_name2 FROM client_branch WHERE branch_code = '$branch_code'";
		$result_gname = mysql_query($query_gname);
			if (!$result_gname) {   error("QUERY_ERROR");   exit; }
		$branch_name2 = @mysql_result($result_gname,0,0);
   $user_gate = mysql_result($result,$i,2);
   $user_code = mysql_result($result,$i,3);
   $user_id = mysql_result($result,$i,4);
   $user_name = mysql_result($result,$i,5);
   $user_gender = mysql_result($result,$i,6);
   $user_birthday = mysql_result($result,$i,7);
   $email = mysql_result($result,$i,8);
   $userlevel = mysql_result($result,$i,9);
   $signdate = mysql_result($result,$i,10);
   $corp_name = mysql_result($result,$i,11);
   $corp_margin = mysql_result($result,$i,12);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
	
	// 성별
  if($user_gender == "M") {
    $user_gender_txt = "<font color=blue>$txt_stf_staff_10</font>";
  } else if($user_gender == "F") {
    $user_gender_txt = "<font color=red>$txt_stf_staff_11</font>";
  }
  
  // 생년월일
  $uday1 = substr($user_birthday,0,4);
	$uday2 = substr($user_birthday,4,2);
	$uday3 = substr($user_birthday,6,2);

  if($lang == "ko") {
	  $user_birthday_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	} else {
	  $user_birthday_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	}
  
  // 지사 코드
  $exp_branch_code = explode("_",$branch_code);
  $exp_branch_code1 = $exp_branch_code[1];

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$name") && $key) {
    $name = eregi_replace("($key)", "<font color=navy>\\1</font>", $name);
  }
  if(!strcmp($key,"$code") && $key) {
    $user_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $user_code);
  }


  echo ("<tr>");
  echo("<td>$branch_name2</td>");
  echo("<td>$user_code</td>");

  $exp_branch_code = explode("_",$branch_code);
  $exp_branch_code1 = $exp_branch_code[1];
  
  // if($corp_name != "") {
    echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&mb_level=$mb_level&mb_type=$mb_type'>$corp_name</a></td>");
  // } else {
    echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$uid&mb_level=$mb_level&mb_type=$mb_type'>$user_name</a></td>");
  // }
   

  // 회원구분
  if($userlevel == "0") {
	  $level_name = "<font color=red>Hold</font>";
  } else if($userlevel == "1") {
	  $level_name = "<font color=blue>Customer</font>";
  } else if($userlevel == "5") {
	  $level_name = "Staff";
  } else if($userlevel == "6") {
	  $level_name = "Admin";
  } else {
	  $level_name = "Unknown";
  }

  // echo("<td>$user_gender_txt</td>");
  // echo("<td align=center>$user_birthday_txt</td>");
  
  echo("<td>$corp_margin %</td>");
  
  
	// Document (pencil/file-text-o/print)
	// Distributor
	$queryG = "SELECT count(code) FROM member_main_distributor WHERE code = '$user_code'";
	$resultG = mysql_query($queryG);
	$total_distrib = @mysql_result($resultG,0,0);
											
											
	$queryH = "SELECT uid,contract_num FROM member_main_distributor WHERE code = '$user_code' ORDER BY code DESC";
	$resultH = mysql_query($queryH);

	$H_uid = mysql_result($resultH,0,0);
	$H_contract_num = mysql_result($resultH,0,1);
	
	if($total_distrib > 0) {
		$icon_filetype = "<a href='#'><i class='fa fa-file-text-o'></i></a>";
	} else {
		$icon_filetype = "&nbsp;";
	}
  
  echo("<td>$icon_filetype</td>");
  echo("<td>$signdates</td>");
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