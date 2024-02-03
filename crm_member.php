<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member";


if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/crm_member.php";
$link_post = "$home/crm_member_post.php?mb_level=$mb_level&mb_type=$mb_type&keyfield=$keyfield&key=$key";
$link_upd = "$home/crm_member_upd.php";
$link_del = "$home/crm_member_del.php";
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
	$my_filter = "mb_type = '$mb_type' AND userlevel = '$mb_level'";
} else {
	$my_filter = "userlevel < '5'";
}

// 정렬 필터링
if(!$sorting_key) { $sorting_key = "name"; }
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
            <?=$hsm_name_06_01?>
			
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
			<option value='$PHP_SELF?sorting_key=name&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type'>$txt_stf_staff_08</option>
			<option value='$PHP_SELF?sorting_key=userlevel&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk1>$txt_stf_member_07</option>
			<option value='$PHP_SELF?sorting_key=id&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk5>$txt_stf_member_06</option>
			<option value='$PHP_SELF?sorting_key=code&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk2>$txt_stf_member_05</option>
			<option value='$PHP_SELF?sorting_key=birthday&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk3>$txt_stf_staff_12</option>
			<option value='$PHP_SELF?sorting_key=signdate&key=$key&keyfield=$keyfield&mb_level=$mb_level&mb_type=$mb_type' $chk4>$txt_sys_client_06</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
        <section id="unseen">
		<table class="display table table-bordered table-striped table-condensed id='dynamic-table' ">
        <thead>
        <tr>
            <th><?=$txt_comm_frm23?></th>
            <th><?=$txt_stf_member_05?></th>
			<? if($mb_type == "0") { ?>
			<th><?=$txt_stf_staff_08?></th>
			<th><?=$txt_stf_staff_09?></th>
			<th><?=$txt_stf_staff_12?></th>
			<? } else { ?>
			<th><?=$txt_stf_staff_08?> / <?=$txt_stf_member_08?></th>
			<th>Trading Terms</th> <!--nick new up-->
			<th>Level</th>
			<th>Customer Type</th>
			<? } ?>
			<th><?=$txt_sys_client_06?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,gate,code,id,name,gender,birthday,email,userlevel,signdate,do_store_type,corp_nickname
    FROM member_main WHERE $my_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,branch_code,gate,code,id,name,gender,birthday,email,userlevel,signdate,do_store_type,corp_nickname
    FROM member_main WHERE $my_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $mb_uid = mysql_result($result,$i,0);
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
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
   $do_store_type = mysql_result($result,$i,11);
   $corp_nickname = mysql_result($result,$i,12);//nick new up
   
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
  echo("<td>{$user_code}</td>");


  $exp_branch_code = explode("_",$branch_code);
  $exp_branch_code1 = $exp_branch_code[1];
  
	// 회원구분
	if($userlevel == "0") {
		$level_name = "<font color=red>Hold</font>";
	} else if($userlevel == "1") {
		$level_name = "Customer";
	} else if($userlevel == "2") {
		$level_name = "<font color=blue>Reseller</font>"; 
	} else if($userlevel == "3") {
		$level_name = "<font color=green>Consignment</font>"; // Link to Consignment Group
	} else if($userlevel == "4") {
		$level_name = "<font color=gold>B2B</font>"; // Link to Consignment Group		
	} else if($userlevel == "5") {
		$level_name = "Staff";
	} else if($userlevel == "6") {
		$level_name = "Admin";
	} else {
		$level_name = "<font color=red>Unknown</font>";
	}
  
	if($do_store_type == "hypermarket") {
		$do_store_type_txt = "HYPERMARKET";
	} else if($do_store_type == "supermarket") {
		$do_store_type_txt = "SUPERMARKET";
	} else if($do_store_type == "department") {
		$do_store_type_txt = "DEPARTMENT STORE";
	} else if($do_store_type == "hardware") {
		$do_store_type_txt = "HARDWARE MARKET";
	} else if($do_store_type == "special") {
		$do_store_type_txt = "SPECIAL TEAM";
	} else if($do_store_type == "others" OR $do_store_type == "other") {
		$do_store_type_txt = "OTHERS";
	} else if ($do_store_type == "consumer good") {
		$do_store_type_txt = "CONSUMER GOOD";
	} else if ($do_store_type == "bank") {
		$do_store_type_txt = "BANK";
	} else if ($do_store_type == "manufacturing" OR $do_store_type == "manufacture" OR $do_store_type == "manufaktur") {
		$do_store_type_txt = "MANUFACTURE";
	} else if ($do_store_type == "farmasi") {
		$do_store_type_txt = "FARMASI";
	} else if ($do_store_type == "agency") {
		$do_store_type_txt = "AGENCY";
	} else if ($do_store_type == "education") {
		$do_store_type_txt = "EDUCATION";	
	} else if ($do_store_type == "otomotif") {
		$do_store_type_txt = "OTOMOTIF";		
	} else if ($do_store_type == "electrical") {
		$do_store_type_txt = "ELECTRICAL";		
	} else if ($do_store_type == "developer") {
		$do_store_type_txt = "DEVELOPER";		
	} else if ($do_store_type == "trading") {
		$do_store_type_txt = "TRADING";		
	} else if ($do_store_type == "asuransi") {
		$do_store_type_txt = "ASURANSI";		
	} else if ($do_store_type == "oil company") {
		$do_store_type_txt = "OIL COMPANY";		
	} else if ($do_store_type == "multifinance") {
		$do_store_type_txt = "MULTIFINANCE";																	
	} else if ($do_store_type == "general contractor") {
		$do_store_type_txt = "GENERAL CONTRACTOR";		
	} else if ($do_store_type == "universitas") {
		$do_store_type_txt = "UNIVERSITAS";						
	} else if ($do_store_type == "property" OR $do_store_type == "properti") {
		$do_store_type_txt = "PROPERTY";				
	} else {
		$do_store_type_txt = "";
	}
	
	
	// Consignment Stores
	$query_sh1c = "SELECT count(uid) FROM client_shop WHERE code = '$user_code' AND associate = '1'";
	$result_sh1c = mysql_query($query_sh1c);
		if (!$result_sh1c) {   error("QUERY_ERROR");   exit; }
	$total_sh1c = @mysql_result($result_sh1c,0,0);
	
	if($userlevel == "3") {
		if($smode == "1") {
			$level_name_txt = "<a href='crm_member.php?mb_level=$mb_level&mb_type=$mb_type&page=$page&uid=$mb_uid&smode=0'>$level_name"." ($total_sh1c)</a>";
		} else {
			$level_name_txt = "<a href='crm_member.php?mb_level=$mb_level&mb_type=$mb_type&page=$page&uid=$mb_uid&smode=1'>$level_name"." ($total_sh1c)</a>";
		}
	} else {
			$level_name_txt = $level_name;
	}
  
  if($mb_type == "0") {
  
	if($user_id != "") {
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$mb_uid&mb_level=$mb_level&mb_type=$mb_type'>{$user_name} ($user_id)</a></td>");
	} else {
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$mb_uid&mb_level=$mb_level&mb_type=$mb_type'>{$user_name}</a></td>");
	}
	echo("<td>$user_gender_txt</td>");
	echo("<td>$user_birthday_txt</td>");
  
  } else {
  
	if($user_id != "") {
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$mb_uid&mb_level=$mb_level&mb_type=$mb_type'>{$user_name} ($user_id)</a></td>");
	} else {
		echo("<td><a href='$link_upd?keyfield=$keyfield&key=$key&page=$page&uid=$mb_uid&mb_level=$mb_level&mb_type=$mb_type'>{$user_name}</a></td>");
	}
	echo("<td><a href='trading_terms.php?uid=$mb_uid&tt_uid=3&page=$page'>$corp_nickname</a></td>");//nick new up
	echo("<td>$level_name_txt</td>");
	echo("<td>$do_store_type_txt</td>");
  
  }

  
  echo("<td>$signdates</td>");
  echo("</tr>");
  
  
	// Consignment Store List
	$uid = $_GET['uid'];
	if($smode == 1 AND $uid == $mb_uid) {
		
		$query_sh1 = "SELECT shop_code,shop_name FROM client_shop WHERE code = '$user_code' AND associate = '1' ORDER BY shop_code ASC";
		$result_sh1 = mysql_query($query_sh1);
			if (!$result_sh1) {   error("QUERY_ERROR");   exit; }
    
		for($sh1 = 0; $sh1 < $total_sh1c; $sh1++) {
			$sh1_shop_code = mysql_result($result_sh1,$sh1,0);
			$sh1_shop_name = mysql_result($result_sh1,$sh1,1);

		echo ("
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan=2 style='padding-left: 30px'>
				<a href='$link_list?shop_code=$sh1_shop_code&edit=1&page=$page&uid=$mb_uid&smode=1'> 
					");

					if ($shop_code == $sh1_shop_code){
						echo (" <b> [$sh1_shop_code] $sh1_shop_name </b>");
					}else{
						echo ("[$sh1_shop_code] $sh1_shop_name");
					}
					echo ("
				</a>
			</td>
			<td>&nbsp;</td>
			
			<form name='qs_signform' method='post' action='crm_member.php'>
            <input type='hidden' name='step_next' value='permit_shop_del'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
			<input type='hidden' name='mb_level' value='$mb_level'>
			<input type='hidden' name='mb_type' value='$mb_type'>
            <input type='hidden' name='page' value='$page'>
			<input type='hidden' name='upd_uid' value='$mb_uid'>
			<input type='hidden' name='upd_shop_code' value='$sh1_shop_code'>
			<td><input type='submit' value='$txt_comm_frm13' class='btn btn-default btn-xs'></td>
			</form>
		</tr>");
		
		}
	
	
	
	// Add Store
		echo ("
		<tr>
			<td>&nbsp;</td>
			
			<form name='qs_signform' method='post' action='crm_member.php'>
            <input type='hidden' name='step_next' value='permit_shop_add'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
			<input type='hidden' name='mb_level' value='$mb_level'>
			<input type='hidden' name='mb_type' value='$mb_type'>
			<input type='hidden' name='add_mb_code' value='$user_code'>
            <input type='hidden' name='page' value='$page'>
			<input type='hidden' name='upd_uid' value='$mb_uid'>
			<input type='hidden' name='upd_shop_code' value='$sh1_shop_code'>
			
			<td><div align=right>+</div></td>
			<td colspan=2 style='padding-left: 30px'>
							
							<select name='add_shop_code' class='form-control'>
							<option value=\"\">:: Register New Store ::</option>");
			
							$query_n1c = "SELECT count(uid) FROM client_shop WHERE code = '' AND associate = '1'";
							$result_n1c = mysql_query($query_n1c);
								if (!$result_n1c) {   error("QUERY_ERROR");   exit; }
    
							$total_n1c = @mysql_result($result_n1c,0,0);
							
							$query_n1 = "SELECT shop_code,shop_name FROM client_shop WHERE code = '' AND associate = '1' ORDER BY shop_code ASC";
							$result_n1 = mysql_query($query_n1);
								if (!$result_n1) {   error("QUERY_ERROR");   exit; }
    
							for($n1 = 0; $n1 < $total_n1c; $n1++) {
								$n1_shop_code = mysql_result($result_n1,$n1,0);
								$n1_shop_name = mysql_result($result_n1,$n1,1);
								
								echo ("<option value='$n1_shop_code'>[$n1_shop_code] $n1_shop_name</option>");
							}
							echo ("
							</select>
			
			</td>
			<td>&nbsp;</td>
			<td><input type='submit' value='$txt_comm_frm051s' class='btn btn-default btn-xs'></td>
			</form>
		</tr>");
	
	}
	
	

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
		
	<?
		if ($edit == 1) {
			
			$query = "SELECT uid,branch_code,gate,subgate,code,associate,group_code,shop_code,shop_name,shop_type,manager,email,homepage,phone1,phone2,phone_fax,
				phone_cell,area,area_code,addr1,addr2,zipcode,userlevel,signdate,memo,tax_no FROM client_shop WHERE shop_code = '$shop_code'";

					$result = mysql_query($query);
					if(!$result) {      
					   error("QUERY_ERROR");
					   exit;
					}
					   $row = mysql_fetch_object($result);

					$user_uid = $row->uid;
					$branch_code = $row->branch_code;
					$user_gate = $row->gate;
					$user_subgate = $row->subgate;
					$user_code = $row->code;
					$user_associate = $row->associate;
					$group_code = $row->group_code;
					$shop_code = $row->shop_code;
					$shop_name = $row->shop_name;
					$shop_type = $row->shop_type;
					$shop_manager = $row->manager;
					$email = $row->email;
					$homepage = $row->homepage;
					$phone1 = $row->phone1;
					$phone2 = $row->phone2;
					$phone_fax = $row->phone_fax;
					$phone_cell = $row->phone_cell;
					$area = $row->area;
					$area_code = $row->area_code;
					$area_code1 = substr($area_code,0,3);
					$addr1 = $row->addr1;
					$addr2 = $row->addr2;
					$zipcode = $row->zipcode;
					$userlevel = $row->userlevel;
					$signdate = $row->signdate;
					  if($lang == "ko") {
						$signdates = date("Y/m/d, H:i:s",$signdate);	
					  } else {
						$signdates = date("d-m-Y, H:i:s",$signdate);	
					  }
					$memo = $row->memo;
					$tax_no = $row->tax_no;

					if($shop_type == "on") {
					  $shop_type_chk1 = "checked";
					  $shop_type_chk2 = "";
					} else if($shop_type == "off") {
					  $shop_type_chk1 = "";
					  $shop_type_chk2 = "checked";
					}
			
			?>
			<div class="row">
				<div class="col-sm-12">
				<section class="panel">
				<header class="panel-heading">
				  Update Shop Profile
				</header>
				<div class="panel-body">
					<section id="unseen">
					<form class="cmxform form-horizontal adminex-form" name="upd_shop_profile" method="post" action='crm_member.php'>
						<input type="hidden" name="step_next" value="permit_update">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='user_associate' value='<?=$user_associate?>'>
								<input type='hidden' name='asso_type' value='<?=$asso_type?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
								<?php

									$query_PT2 = "SELECT shop_name FROM member_main WHERE code = '$user_code'";
									$result_PT2 = mysql_query($query_PT2);
									$sname = $row->shop_name;

								?>
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_08?> / <?=$txt_stf_member_08?></label>
                                        <div class="col-sm-9">
                                        	<input readonly class="form-control" id="cname" value="<?=$sname;?>" type="text" />
                                        </div>
                                    </div>
								
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="shop" value="<?=$shop_code?>" type="text" />
                                    	</div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1"><?=$txt_comm_frm23?></div>
										<div class="col-sm-3">
                                            <input readonly class="form-control" id="cname" value="<?=$branch_name2?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_06?></label>
                                        <div class="col-sm-9">
                                            <input readonly class="form-control" id="cname" value="<?=$shop_name?>" type="text" required />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" value="<?=$email?>" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Office)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone1" value="<?=$phone1?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Home)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone2" value="<?=$phone2?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">FAX</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_fax" value="<?=$phone_fax?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_cell" value="<?=$phone_cell?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_15?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="zipcode" name="zipcode" value="<?=$zipcode?>" maxlength="6" type="tel" />
                                        </div>
										<div class="col-sm-7"></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_16?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr2" value="<?=$addr2?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_17?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr1" value="<?=$addr1?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3">NPWP</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="tax" name="tax_no" value="<?=$tax_no?>">
                                        </div>
                                    </div>
								
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
                                            <!--<input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">-->
                                        </div>
                                    </div>
					</form>
					</section>
				</div>
				</section>
				</div>
				</div>
					<?
		}
		?>
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
} else if($step_next == "permit_shop_add") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	$query_add  = "UPDATE client_shop SET code = '$add_mb_code' WHERE shop_code = '$add_shop_code'";
	$result_add = mysql_query($query_add);
	if (!$result_add) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type&uid=$upd_uid'>");
	exit;

} else if($step_next == "permit_shop_del") {
	
	$query_del  = "UPDATE client_shop SET code = '' WHERE shop_code = '$upd_shop_code'";
	$result_del = mysql_query($query_del);
	if (!$result_del) { error("QUERY_ERROR"); exit; }

	echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type&uid=$upd_uid'>");
	exit;
	
}else if($step_next == "permit_update") {
	// Area Code
	$shop_area_code = substr($shop_area,0,3);

	$query  = "UPDATE client_shop SET email = '$email', zipcode = '$zipcode', area = '$shop_area_name', area_code = '$shop_area', addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', 
			phone_fax = '$phone_fax', phone_cell = '$phone_cell',tax_no='$tax_no' WHERE shop_code = '$shop'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type&uid=$upd_uid'>");
	exit;
}

}
?>
