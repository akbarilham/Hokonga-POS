<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_shop2";

if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_shop2.php";
$link_post = "$home/system_shop2_post.php?asso_type=1&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&page=$page";
$link_upd = "$home/system_shop2_upd.php";
$link_del = "$home/system_shop2_del.php";
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
// Filtering
// $keyA = branch_code
// $keyB = group_code [ Consignment Group Name ]
// $keyC = code [ Customer ]

if($keyA) {
	if($keyB) {
		if($keyC) {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND group_code = '$keyB' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND group_code = '$keyB'";
		}
	} else {
		if($keyC) {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA'";
		}
	}
} else {
	if($keyB) {
		if($keyC) {
			$sorting_filter = "associate = '1' AND group_code = '$keyB' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND group_code = '$keyB'";
		}
	} else {
		if($keyC) {
			$sorting_filter = "associate = '1' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1'";
		}
	}
}

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

	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop WHERE $sorting_filter";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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


$query_ini = "SELECT count(uid) FROM client_shop WHERE associate = '1'";
$result_ini = mysql_query($query_ini);
	if (!$result_ini) { error("QUERY_ERROR"); exit; }
$total_ini_store = mysql_result($result_ini,0,0);
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
				echo ("($txt_sys_shop_073)");
			} else if($asso_type == "B") {
				echo ("($txt_sys_shop_071)");
			}
			?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield'>:: $txt_comm_frm30</option>");
			
				$query_guc = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
				$result_guc = mysql_query($query_guc);
				$total_guc = @mysql_result($result_guc,0,0);

				$query_gu = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
				$result_gu = mysql_query($query_gu);
			
				for($gu = 0; $gu < $total_guc; $gu++) {
					$k_branch_code = mysql_result($result_gu,$gu,0);
					$k_branch_name = mysql_result($result_gu,$gu,1);
        
					if($k_branch_code == $keyA) {
						$slc_branch = "selected";
					} else {
						$slc_branch = "";
					}
					
					$link_list_branch = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$k_branch_code&keyB=$keyB&keyC=$keyC";
				
					echo ("<option value='$link_list_branch' $slc_branch>$k_branch_name</option>");
					
				}
			
				echo ("
				</select>
			</div>
			
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyC=$keyC'>:: All Consignment Group</option>");
				//if($keyA) {
				$query_cgc = "SELECT count(group_code) FROM client_consign";
				$result_cgc = mysql_query($query_cgc);
				$total_cgc = @mysql_result($result_cgc,0,0);

				$query_cg = "SELECT group_code,group_name FROM client_consign ORDER BY group_name ASC";
				$result_cg = mysql_query($query_cg);
			
				for($cg = 0; $cg < $total_cgc; $cg++) {
					$cg_group_code = mysql_result($result_cg,$cg,0);
					$cg_group_name = mysql_result($result_cg,$cg,1);
        
					if($cg_group_code == $keyB) {
						$slc_cg = "selected";
					} else {
						$slc_cg = "";
					}
					
					$link_list_cg = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$cg_group_code&keyC=$keyC";
				
					echo ("<option value='$link_list_cg' $slc_cg>$cg_group_name</option>");
					
				}
				//}
				echo ("
				</select>
			</div>
			
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB'>:: $txt_comm_frm411</option>");
				if($keyA) {
				$query_sh1c = "SELECT count(code) FROM member_main WHERE branch_code = '$keyA' AND userlevel = '3' AND mb_type = '2'";
				$result_sh1c = mysql_query($query_sh1c);
					if (!$result_sh1c) {   error("QUERY_ERROR");   exit; }
    
				$total_sh1c = @mysql_result($result_sh1c,0,0);
							
				$query_sh1 = "SELECT code,name FROM member_main WHERE branch_code = '$keyA' AND userlevel = '3' AND mb_type = '2' ORDER BY name ASC";
				$result_sh1 = mysql_query($query_sh1);
					if (!$result_sh1) {   error("QUERY_ERROR");   exit; }
    
				for($sh1 = 0; $sh1 < $total_sh1c; $sh1++) {
					$sh1_shop_code = mysql_result($result_sh1,$sh1,0);
					$sh1_shop_name = mysql_result($result_sh1,$sh1,1);
								
					$link_list_sh1 = "$PHP_SELF?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$sh1_shop_code";
							
					if($keyC == $sh1_shop_code) {
						echo ("<option value='$link_list_sh1' selected>[$sh1_shop_code] $sh1_shop_name</option>");
					} else {
						echo ("<option value='$link_list_sh1'>[$sh1_shop_code] $sh1_shop_name</option>");
					}
				}
				}
				echo ("
				</select>
			</div>
			
			</div>
			
			<div>&nbsp;</div>
		
		
			<div class='row'>
			<div class='col-sm-4'>");
			

			$queryC = "SELECT count(uid) FROM client WHERE branch_code = '$keyA' AND userlevel > '1' AND userlevel < '6'";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT client_id,client_name FROM client WHERE branch_code = '$keyA' AND userlevel > '1' AND userlevel < '6' ORDER BY client_code ASC";
			$resultD = mysql_query($queryD);

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF?sorting_key=$sorting_key&keyA=$keyA&keyB=$keyB&keyC=$keyC'>:: $txt_comm_frm240</option>");

			for($i = 0; $i < $total_recordC; $i++) {
				$menu_code = mysql_result($resultD,$i,0);
				$menu_name = mysql_result($resultD,$i,1);
        
				if($menu_code == $key) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

			echo("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=subgate&key=$menu_code&keyA=$keyA&keyB=$keyB&keyC=$keyC' $slc_gate>&nbsp; $menu_name [ $menu_code ]</option>");
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
			<option value='$PHP_SELF?sorting_key=subgate&key=$key&keyfield=$keyfield&keyA=$keyA&keyB=$keyB&keyC=$keyC'>Branch</option>
			<option value='$PHP_SELF?sorting_key=shop_code&key=$key&keyfield=$keyfield&keyA=$keyA&keyB=$keyB&keyC=$keyC' $chk3>$txt_sys_shop_05</option>
			<option value='$PHP_SELF?sorting_key=shop_name&key=$key&keyfield=$keyfield&keyA=$keyA&keyB=$keyB&keyC=$keyC' $chk1>$txt_sys_shop_06</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield&keyA=$keyA&keyB=$keyB&keyC=$keyC' $chk2>$txt_sys_client_06</option>
			<option value='$PHP_SELF?sorting_key=area&key=$key&keyfield=$keyfield&keyA=$keyA&keyB=$keyB&keyC=$keyC' $chk4>$txt_sys_shop_16</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <!--<th>No.</th>-->
			<th>Corp.</th>
			<th>Customer</th>
			<th>Group</th>
            <th>Code</th>
            <th><?=$txt_sys_shop_06?></th>
			<!--<th><?=$txt_sys_shop_07?></th>-->
			<th><?=$txt_sys_shop_16?></th>
			<!--<th><?=$txt_sys_shop_09?></th>-->
			<th><?=$txt_comm_frm13?></th>
        </tr>
        </thead>
		
		
        <tbody>


<?
echo ("
			<form name='qs_signform' method='post' action='system_shop2.php'>
            <input type='hidden' name='step_next' value='permit_update'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
			<input type='hidden' name='keyA' value='$keyA'>
			<input type='hidden' name='keyB' value='$keyB'>
			<input type='hidden' name='keyC' value='$keyC'>
            <input type='hidden' name='page' value='$page'>");
			
$time_limit = 60*60*24*$notify_new_article; 

	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area,group_code,code
		FROM client_shop WHERE $sorting_filter ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	} else {
		$query = "SELECT uid,gate,subgate,shop_code,shop_type,shop_name,manager,userlevel,signdate,branch_code,consign,associate,area,group_code,code
		FROM client_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
	}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
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
   $shop_group_code = mysql_result($result,$i,13);
		$query_gc = "SELECT group_name FROM client_consign WHERE group_code = '$shop_group_code'";
		$result_gc = mysql_query($query_gc);
			if (!$result_gc) {   error("QUERY_ERROR");   exit; }
		$shop_group_name = @mysql_result($result_gc,0,0);
   $shop_customer_code = mysql_result($result,$i,14);
		$query_sc = "SELECT name FROM member_main WHERE code = '$shop_customer_code'";
		$result_sc = mysql_query($query_sc);
			if (!$result_sc) {   error("QUERY_ERROR");   exit; }
		$shop_customer_name = @mysql_result($result_sc,0,0);
   
	if($shop_customer_code != "") {
		$td_bgcolor = "#FFFFFF";
	} else {
		$td_bgcolor = "#FAFAA0";
	}
   

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$shop_name") && $key) {
    $shop_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $shop_name);
  }
  if(!strcmp($key,"$shop_code") && $key) {
    $shop_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $shop_code);
  }


  echo ("<tr>");
	
	// echo("<td align=center>$article_num</td>");
	echo("
	<td bgcolor='$td_bgcolor'>
	<select name='new_branch_code[$uid]'>");
	
	$query_ptc = "SELECT count(branch_code) FROM client_branch WHERE branch_code != 'CORP_01'";
	$result_ptc = mysql_query($query_ptc);
		if (!$result_ptc) {   error("QUERY_ERROR");   exit; }
    
	$total_pt = @mysql_result($result_ptc,0,0);
							
	$query_pt = "SELECT branch_code,branch_name2 FROM client_branch WHERE branch_code != 'CORP_01' ORDER BY branch_code ASC";
	$result_pt = mysql_query($query_pt);
		if (!$result_pt) {   error("QUERY_ERROR");   exit; }
    
	for($pt = 0; $pt < $total_pt; $pt++) {
		$org_branch_code = mysql_result($result_pt,$pt,0);
		$org_branch_name = mysql_result($result_pt,$pt,1);
							
		if($org_branch_code == $shop_corp) {
			echo ("<option value='$org_branch_code' selected>$org_branch_name</option>");
		} else {
			echo ("<option value='$org_branch_code'>$org_branch_name</option>");
		}
	}
  
	echo ("
	</select>
	</td>");
	
	// echo("<td>{$shop_subgate}</td>");
  
	// Consignment Group & Customer
	echo ("
	<td bgcolor='$td_bgcolor'>
	<select name='new_customer_code[$uid]'>
	<option value=\"\">:: $txt_comm_frm411</option>");
	
	$query_pt1c = "SELECT count(code) FROM member_main WHERE branch_code = '$shop_corp' AND userlevel = '3' AND mb_type = '2'";
	$result_pt1c = mysql_query($query_pt1c);
		if (!$result_pt1c) {   error("QUERY_ERROR");   exit; }
    
	$total_pt1 = @mysql_result($result_pt1c,0,0);
							
	$query_pt1 = "SELECT code,name FROM member_main WHERE branch_code = '$shop_corp' AND userlevel = '3' AND mb_type = '2' ORDER BY name ASC";
	$result_pt1 = mysql_query($query_pt1);
		if (!$result_pt1) {   error("QUERY_ERROR");   exit; }
    
	for($pt1 = 0; $pt1 < $total_pt1; $pt1++) {
		$org_customer_code = mysql_result($result_pt1,$pt1,0);
		$org_customer_name = mysql_result($result_pt1,$pt1,1);
							
		if($org_customer_code == $shop_customer_code) {
			echo ("<option value='$org_customer_code' selected>$org_customer_name</option>");
		} else {
			echo ("<option value='$org_customer_code'>$org_customer_name</option>");
		}
	}
  
	echo ("
	</select>
	</td>
  
  <td bgcolor='$td_bgcolor'>$shop_group_name</td>
  ");
  
  
	// Area
	$query_AR = "SELECT area_code,area_name FROM code_area WHERE area_code = '$shop_area' ORDER BY area_name ASC";
	$result_AR = mysql_query($query_AR);
	
	$shop_area_code = @mysql_result($result_AR,0,0);
	$shop_area_name = @mysql_result($result_AR,0,1);
  
	$link_upd_now = "$link_upd?uid=$uid&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&page=$page";
  
  echo("<td bgcolor='$td_bgcolor'><a href='#'>$shop_code</a></td>");
  echo("<td bgcolor='$td_bgcolor'><input type='text' name=new_shop_name[$uid]' size=40 value='$shop_name'></td>");
  
  if($shop_associate == "1") {
	$shop_consign_txt = "<font color=#006699>Consign.</font>";
  } else {
	$shop_consign_txt = "$txt_sys_shop_071";
  }
  // echo("<td bgcolor='$td_bgcolor'>{$shop_consign_txt}</td>");
  
	
  
    
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
  
  
  echo("<td bgcolor='$td_bgcolor'>$shop_area</td>");

  // echo("<td>$level_name</td>");
  
  echo("<td bgcolor='$td_bgcolor'><input type='checkbox' name='chk_del[$uid]' value='1'></td>"); // Check box for delete
  echo("</tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		
		<input <?=$submit_dis?> type="submit" value="Update this Page" class="btn btn-primary">
		</form>
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
					echo("<li><a href=\"$link_list?page=$my_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&sorting_key=$sorting_key&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC\">Next $page_per_block</a></li>");
				}
				
				if($keyA AND $keyB) {
					echo ("
					
					<li><a href='$link_post'>+ Add Store</li>
					");
				
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


<?
} else if($step_next == "permit_update") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	$num_per_page = 50; // number of article lines per page
	$page_per_block = 10; // number of pages displayed in the bottom
	
	
// Filtering
// $keyA = branch_code
// $keyB = group_code [ Consignment Group Name ]
// $keyC = code [ Customer ]

if($keyA) {
	if($keyB) {
		if($keyC) {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND group_code = '$keyB' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND group_code = '$keyB'";
		}
	} else {
		if($keyC) {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND branch_code = '$keyA'";
		}
	}
} else {
	if($keyB) {
		if($keyC) {
			$sorting_filter = "associate = '1' AND group_code = '$keyB' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1' AND group_code = '$keyB'";
		}
	} else {
		if($keyC) {
			$sorting_filter = "associate = '1' AND code = '$keyC'";
		} else {
			$sorting_filter = "associate = '1'";
		}
	}
}

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

	if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT count(uid) FROM client_shop WHERE $sorting_filter";
	} else {
		$encoded_key = urlencode($key);
		$query = "SELECT count(uid) FROM client_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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



if(!eregi("[^[:space:]]+",$key)) {
	$query = "SELECT uid,shop_code FROM client_shop WHERE $sorting_filter ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
} else {
	$query = "SELECT uid,shop_code FROM client_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now, gate ASC, subgate ASC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
	$uid = mysql_result($result,$i,0);
	$li_shop_code = mysql_result($result,$i,1);
		
	// UPDATE
	$new_shop_name[$uid] = addslashes($new_shop_name[$uid]);
	
	$result_U1 = mysql_query("UPDATE client_shop SET code = '$new_customer_code[$uid]', shop_name = '$new_shop_name[$uid]', 
				branch_code = '$new_branch_code[$uid]' WHERE uid = '$uid'");
	if(!$result_U1) { error("QUERY_ERROR"); exit; }
	
	if($chk_del[$uid] == "1") {
		$query_del = "DELETE FROM client_shop WHERE uid = '$uid'"; 
		$result_del = mysql_query($query_del);
		if(!$result_del) { error("QUERY_ERROR"); exit; }
	}
  
}

	
echo("<meta http-equiv='Refresh' content='0; URL=$home/system_shop2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&page=$page'>");
exit;


}

}
?>
	