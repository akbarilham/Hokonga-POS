<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "asset";
$smenu = "finance_amort";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/finance_amort.php?sorting_key=$sorting_key";
$link_upd = "$home/finance_amort.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
if($login_level > "2") {
  $sorting_filter = "branch_code = '$login_branch'";
} else {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate'";
}


// Sorting
if(!$sorting_key) { $sorting_key = "purchase_date"; }
if($sorting_key == "purchase_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "p_code") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "p_name") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM asset WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM asset WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM asset WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$title_module_0402?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='finance_deprec.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='purchase_date'>Purchase Date</option>
				<option value='p_code'>Asset Code</option>
				<option value='p_name'>Asset Name</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			<div class='col-sm-1'></div>
			</form>
			
			
			<div class='col-sm-3'>Total: $total_record / $all_record &nbsp;[ <font color='navy'>$page</font> / $total_page ]</div>
			
			<div class='col-sm-1' align=right></div>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=purchase_date&keyfield=$keyfield&key=$key'>Purchase Date</option>
			<option value='$PHP_SELF?sorting_key=p_code&keyfield=$keyfield&key=$key' $chk1>Asset Code</option>
			<option value='$PHP_SELF?sorting_key=p_name&keyfield=$keyfield&key=$key' $chk2>Asset Name</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>Date</th>
            <th><?=$txt_sys_user_07?></th>
			<th>Asset Name</th>
			<th>Asset Type</th>
			<th>Q'ty</th>
			<th>Unit</th>
			<th>Amount (<?=$now_currency1?>)</th>
			<th>Amount (<?=$now_currency2?>)</th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// SUM
if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_1 = "SELECT sum(total_amount) FROM asset 
				WHERE currency = '$now_currency1' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_1 = "SELECT sum(total_amount) FROM asset 
                WHERE currency = '$now_currency1' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sum_1 = mysql_query($query_sum_1);
if (!$result_sum_1) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_1 = @mysql_result($result_sum_1,0,0);
$sum_pay_amount_1_k = number_format($sum_pay_amount_1);

if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_2 = "SELECT sum(total_amount) FROM asset 
                WHERE currency = '$now_currency2' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_2 = "SELECT sum(total_amount) FROM asset 
                WHERE currency = '$now_currency2' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sum_2 = mysql_query($query_sum_2);
if (!$result_sum_2) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_2 = @mysql_result($result_sum_2,0,0);
$sum_pay_amount_2_k = number_format($sum_pay_amount_2);

echo ("
<tr height=22>
  <td colspan=2><div align=right>Total</div></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><div align=right><font color=#000000><b>$sum_pay_amount_1_k</b></font></div></td>
  <td><div align=right><font color=#000000><b>$sum_pay_amount_2_k</b></font></div></td>
</tr>
");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,p_code,p_type,p_name,currency,qty,unit,unit_amount,total_amount,purchase_date,p_status 
      FROM asset WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,p_code,p_type,p_name,currency,qty,unit,unit_amount,total_amount,purchase_date,p_status 
      FROM asset WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $p_uid = mysql_result($result,$i,0);
   $p_gate = mysql_result($result,$i,1);
   $p_code = mysql_result($result,$i,2);
   $p_type = mysql_result($result,$i,3);
		if($p_type == "2") {
			$p_type_txt = "Licns";
		} else if($p_type == "3") {
			$p_type_txt = "Land";
		} else if($p_type == "4") {
			$p_type_txt = "Bldg";
		} else if($p_type == "5") {
			$p_type_txt = "IP";
		} else {
			$p_type_txt = "-";
		}
   $p_name = mysql_result($result,$i,4);
		$p_name = stripslashes($p_name);
   $p_currency = mysql_result($result,$i,5);
   $p_qty = mysql_result($result,$i,6);
		$p_qty_k = number_format($p_qty);
   $p_unit = mysql_result($result,$i,7);
   $p_unit_amount = mysql_result($result,$i,8);
		$p_unit_amount_k = number_format($p_unit_amount);
   $p_total_amount = mysql_result($result,$i,9);
   $purchase_date = mysql_result($result,$i,10);
   $p_status = mysql_result($result,$i,11);
   
   if($p_currency == $now_currency1) {
		$p_total_amount_1 = $p_total_amount;
		$p_total_amount_2 = "";
		
   } else if($p_currency == $now_currency2) {
		$p_total_amount_1 = "";
		$p_total_amount_2 = $p_total_amount;
   }
   
   $p_total_amount_1_k = number_format($p_total_amount_1);
   $p_total_amount_2_k = number_format($p_total_amount_2); // Dicimal Point
   
	// Purchse Date
	$purchase_date_xpd = explode("-",$purchase_date);
	$wday1 = $purchase_date_xpd[0];
	$wday2 = $purchase_date_xpd[1];
	$wday3 = $purchase_date_xpd[2];
	
	if($lang == "ko") {
	    $purchase_date_txt = "$wday1"."/"."$wday2"."/"."$wday3";
	} else {
	    $purchase_date_txt = "$wday3"."-"."$wday2"."-"."$wday1";
	}


	// High Light
    if($uid == $p_uid AND $mode == "check") {
		$highlight_color = "#FAFAB4";
    } else {
		$highlight_color = "#FFFFFF";
    }
	
	// Font Color
	if($p_status == "0") {
		$font_color = "#AAAAAA";
	} else {
		$font_color = "#000000";
	}
	

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'><font color='$font_color'>$purchase_date_txt</font></td>");
  echo("<td bgcolor='$highlight_color'><font color='$font_color'>$p_gate</font></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$p_uid'><font color='$font_color'>($p_code) $p_name</font></a></td>");
  echo("<td bgcolor='$highlight_color'><font color='$font_color'>$p_type_txt</font></td>");
  echo("<td bgcolor='$highlight_color'><font color='$font_color'>$p_qty_k</font></td>");
  echo("<td bgcolor='$highlight_color'><font color='$font_color'>$p_unit</font></td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$p_uid'><font color='$font_color'>$p_total_amount_1_k</font></a></div></td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$p_uid'><font color='$font_color'>$p_total_amount_2_k</font></a></div></td>");
  echo("</tr>");
  
  $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
		
				<a href="<?echo("$link_upd&mode=request")?>"><input type="button" value="New Asset" class="btn btn-primary"></a>
			
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
					echo("<li><a href=\"$link_list&page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list&page=$page_num&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list&page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list&page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list&page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
				}
				?>
				</ul>
			
        </div>
		
        </section>
		</div>
		</div>
		
	
		

		
	
		<?
		if($mode == "check" AND $uid) { // Update

          $pm_query = "SELECT uid,branch_code,gate,shop_code,gudang_code,supp_code,user_code,org_pcode,org_barcode,
					loco_gate,loco_shop_code,p_code,p_type,p_name,p_detail,memo,
					currency,qty,unit,unit_amount,total_amount,p_status,purchase_date,post_date,expire_date FROM asset WHERE uid = '$uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $upd_uid = @mysql_result($pm_result,0,0);
          $upd_branch_code = @mysql_result($pm_result,0,1);
          $upd_gate = @mysql_result($pm_result,0,2);
          $upd_shop_code = @mysql_result($pm_result,0,3);
          $upd_gudang_code = @mysql_result($pm_result,0,4);
          $upd_supp_code = @mysql_result($pm_result,0,5);
          $upd_user_code = @mysql_result($pm_result,0,6);
          $upd_org_pcode = @mysql_result($pm_result,0,7);
		  $upd_org_barcode = @mysql_result($pm_result,0,8);
          $upd_loco_gate = @mysql_result($pm_result,0,9);
          $upd_loco_shop_code = @mysql_result($pm_result,0,10);
          $upd_p_code = @mysql_result($pm_result,0,11);
          $upd_p_type = @mysql_result($pm_result,0,12);
          $upd_p_name = @mysql_result($pm_result,0,13);
          $upd_p_detail = @mysql_result($pm_result,0,14);
          $upd_memo = @mysql_result($pm_result,0,15);
          $upd_currency = @mysql_result($pm_result,0,16);
          $upd_qty = @mysql_result($pm_result,0,17);
          $upd_unit = @mysql_result($pm_result,0,18);
          $upd_unit_amount = @mysql_result($pm_result,0,19);
          $upd_total_amount = @mysql_result($pm_result,0,20);
		  $upd_p_status = @mysql_result($pm_result,0,21);
		  $upd_purchase_date = @mysql_result($pm_result,0,22);
		  $upd_post_date = @mysql_result($pm_result,0,23);
		  $upd_expire_date = @mysql_result($pm_result,0,24);

            // Dates
            $Aday1 = substr($upd_post_date,0,4);
	        $Aday2 = substr($upd_post_date,4,2);
	        $Aday3 = substr($upd_post_date,6,2);
	        $Aday4 = substr($upd_post_date,8,2);
	        $Aday5 = substr($upd_post_date,10,2);
	        $Aday6 = substr($upd_post_date,12,2);
            
			if($lang == "ko") {
	            $upd_post_dates = "$Aday1"."/"."$Aday2"."/"."$Aday3".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	        } else {
	            $upd_post_dates = "$Aday3"."-"."$Aday2"."-"."$Aday1".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	        }
	          
         
          
          // Status
          if($upd_p_status == "0") {
            $upd_p_status_chk0 = "checked";
            $upd_p_status_chk1 = "";
            $upd_p_status_chk2 = "";
          } else if($upd_p_status == "1") {
            $upd_p_status_chk0 = "";
            $upd_p_status_chk1 = "checked";
            $upd_p_status_chk2 = "";
          } else if($upd_p_status == "2") {
            $upd_p_status_chk0 = "";
            $upd_p_status_chk1 = "";
            $upd_p_status_chk2 = "checked";
          }
          
          // Currency
          if($upd_currency == $now_currency1) {
            $currency_chk_1 = "checked";
            $currency_chk_2 = "";
          } else if($upd_currency == $now_currency2) {
            $currency_chk_1 = "";
            $currency_chk_2 = "checked";
          }
          

      echo ("
      <form name='signform2' class='cmxform form-horizontal adminex-form' method='post' action='finance_deprec.php'>
      <input type='hidden' name='step_next' value='permit_upd'>
      <input type='hidden' name='sorting_key' value='$sorting_key'>
      <input type='hidden' name='keyfield' value='$keyfield'>
      <input type='hidden' name='key' value='$key'>
      <input type='hidden' name='page' value='$page'>
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_client' value='$upd_gate'>
      <input type=hidden name='new_p_uid' value='$upd_uid'>
      <input type=hidden name='new_p_code' value='$upd_p_code'>");
	  ?>
          
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Asset
			
            
        </header>
		
        <div class="panel-body">
			
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_gate">
											<?
											if($login_level > '2') {
												echo("<option value=\"\">:: $txt_comm_frm24</option>");
											}
											$query_G1 = "SELECT count(uid) FROM client WHERE branch_code = '$login_branch' AND userlevel > '0'";
											$result_G1 = mysql_query($query_G1,$dbconn);
												if (!$result_G1) { error("QUERY_ERROR"); exit; }
											$total_G1ss = @mysql_result($result_G1,0,0);
      
											$query_G2 = "SELECT uid,client_id,client_name FROM client 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY client_id ASC";
											$result_G2 = mysql_query($query_G2,$dbconn);
											if (!$result_G2) { error("QUERY_ERROR"); exit; }   

											for($g = 0; $g < $total_G1ss; $g++) {
												$gate_uid = mysql_result($result_G2,$g,0);
												$gate_code = mysql_result($result_G2,$g,1);
												$gate_name = mysql_result($result_G2,$g,2);
												
												if($upd_gate == $gate_code) {
													$gate_slct = "selected";
												} else {
													$gate_slct = "";
												}
												echo("<option value='$gate_code' $gate_slct>$gate_name [$gate_code]</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Shop</label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_shop_code">
											<?
											if($login_level > '2') {
												echo("<option value=\"\">:: $txt_comm_frm241</option>");
											}
											$query_S1 = "SELECT count(uid) FROM client_shop WHERE branch_code = '$login_branch' AND userlevel > '0'";
											$result_S1 = mysql_query($query_S1,$dbconn);
												if (!$result_S1) { error("QUERY_ERROR"); exit; }
											$total_S1ss = @mysql_result($result_S1,0,0);
      
											$query_S2 = "SELECT uid,shop_code,shop_name FROM client_shop 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY shop_code ASC";
											$result_S2 = mysql_query($query_S2,$dbconn);
												if (!$result_S2) { error("QUERY_ERROR"); exit; }   

											for($s = 0; $s < $total_S1ss; $s++) {
												$shop_uid = mysql_result($result_S2,$s,0);
												$shop_code = mysql_result($result_S2,$s,1);
												$shop_name = mysql_result($result_S2,$s,2);
              
												if($upd_shop_code == $shop_code) {
													$shop_slct = "selected";
												} else {
													$shop_slct = "";
												}
												
												echo("<option value='$shop_code' $shop_slct>$shop_name [$shop_code]</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									
									<?
									// Asset Details
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Code</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_p_code' value='$upd_p_code' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Type</label>
                                        <div class='col-sm-3'>
											<select name='new_p_type' class='form-control' required>");
											if($upd_p_type == "1") {
												echo ("<option value='1' selected>Estate</option>");
											} else {
												echo ("<option value='1'>Estate</option>");
											}
											if($upd_p_type == "2") {
												echo ("<option value='2' selected>Machinery/Automobile (License)</option>");
											} else {
												echo ("<option value='2'>Machinery/Automobile (License)</option>");
											}
											if($upd_p_type == "3") {
												echo ("<option value='3' selected>Real Estate - Land</option>");
											} else {
												echo ("<option value='3'>Real Estate - Land</option>");
											}
											if($upd_p_type == "4") {
												echo ("<option value='4' selected>Real Estate - Building</option>");
											} else {
												echo ("<option value='4'>Real Estate - Building</option>");
											}
											if($upd_p_type == "5") {
												echo ("<option value='5' selected>Intellectual Property</option>");
											} else {
												echo ("<option value='5'>Intellectual Property</option>");
											}
											echo ("
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Name</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_p_name' value='$upd_p_name' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Description</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_p_detail' value='$upd_p_detail' >
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_sys_bank_13</label>
                                        <div class='col-sm-9'>
											<input type=radio name='new_currency' value='$now_currency1' $currency_chk_1> $now_currency1 &nbsp;&nbsp;&nbsp; 
											<input type=radio name='new_currency' value='$now_currency2' $currency_chk_2> $now_currency2
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Quantity</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_qty' value='$upd_qty' style='text-align: right'>
										</div>
										<label for='cname' class='control-label col-sm-3'>Unit</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_unit' value='$upd_unit' >
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Unit Amount</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_unit_amount' value='$upd_unit_amount' style='text-align: right'>
										</div>
										<label for='cname' class='control-label col-sm-3'>Total Amount</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_total_amount' value='$upd_total_amount' style='text-align: right' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Purchase Date</label>
                                        <div class='col-sm-3'>
											<input type='date' class='form-control' name='new_purchase_date' value='$upd_purchase_date' max='$today_full_set2'>
										</div>
										<label for='cname' class='control-label col-sm-3'>Expiry Date</label>
                                        <div class='col-sm-3'>
											<input type='date' class='form-control' name='new_expire_date' value='$upd_expire_date' max='$today_full_set2'>
										</div>
                                    </div>
									
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Property Status</label>
                                        <div class='col-sm-3'>
											<input type='radio' name='new_p_status' value='2' $upd_p_status_chk2> Paid &nbsp;&nbsp; 
											<input type='radio' name='new_p_status' value='1' $upd_p_status_chk1> In Process &nbsp;&nbsp; 
											<input type='radio' name='new_p_status' value='0' $upd_p_status_chk0> <font color=red>Expired</font>
										</div>
										<div class='col-sm-6'>
											<input type='checkbox' name='new_del_chk' value='1'> <font color=red>Delete</font>
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='Save'>
										</div>
                                    </div>");
									?>
								

		</div>
		</section>
		</div>
		</div>
		</form>

		
		
		
	  <? } else if($mode == "request") { ?>
		
		<?
		echo ("
		<form name='signform' class='cmxform form-horizontal adminex-form' method='post' action='finance_deprec.php'>
		<input type='hidden' name='step_next' value='permit_add'>
		<input type='hidden' name='sorting_key' value='$sorting_key'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='page' value='$page'>
		<input type=hidden name='add_mode' value='LIST_ADD'>
		<input type=hidden name='new_branch_code' value='$login_branch'>
		<input type=hidden name='new_client' value='$key'>");
		?>
		
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            New Asset
			
            
        </header>
		
        <div class="panel-body">
		
		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_gate">
											<?
											if($login_level > '2') {
												echo("<option value=\"\">:: $txt_comm_frm24</option>");
											}
											$query_G1 = "SELECT count(uid) FROM client WHERE branch_code = '$login_branch' AND userlevel > '0'";
											$result_G1 = mysql_query($query_G1,$dbconn);
												if (!$result_G1) { error("QUERY_ERROR"); exit; }
											$total_G1ss = @mysql_result($result_G1,0,0);
      
											$query_G2 = "SELECT uid,client_id,client_name FROM client 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY client_id ASC";
											$result_G2 = mysql_query($query_G2,$dbconn);
											if (!$result_G2) { error("QUERY_ERROR"); exit; }   

											for($g = 0; $g < $total_G1ss; $g++) {
												$gate_uid = mysql_result($result_G2,$g,0);
												$gate_code = mysql_result($result_G2,$g,1);
												$gate_name = mysql_result($result_G2,$g,2);
              
												echo("<option value='$gate_code'>$gate_name [$gate_code]</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Shop</label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_shop_code">
											<?
											if($login_level > '2') {
												echo("<option value=\"\">:: $txt_comm_frm241</option>");
											}
											$query_S1 = "SELECT count(uid) FROM client_shop WHERE branch_code = '$login_branch' AND userlevel > '0'";
											$result_S1 = mysql_query($query_S1,$dbconn);
												if (!$result_S1) { error("QUERY_ERROR"); exit; }
											$total_S1ss = @mysql_result($result_S1,0,0);
      
											$query_S2 = "SELECT uid,shop_code,shop_name FROM client_shop 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY shop_code ASC";
											$result_S2 = mysql_query($query_S2,$dbconn);
												if (!$result_S2) { error("QUERY_ERROR"); exit; }   

											for($s = 0; $s < $total_S1ss; $s++) {
												$shop_uid = mysql_result($result_S2,$s,0);
												$shop_code = mysql_result($result_S2,$s,1);
												$shop_name = mysql_result($result_S2,$s,2);
              
												echo("<option value='$shop_code'>$shop_name [$shop_code]</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									
									<?
									// Asset Details
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Code</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_p_code' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Type</label>
                                        <div class='col-sm-3'>
											<select name='new_p_type' class='form-control' required>
											<option value='1'>Estate</option>
											<option value='2'>Machinery/Automobile (License)</option>
											<option value='3'>Real Estate - Land</option>
											<option value='4'>Real Estate - Building</option>
											<option value='5'>Intellectual Property</option>
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Asset Name</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_p_name' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Description</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_p_detail'>
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_sys_bank_13</label>
                                        <div class='col-sm-9'>
											<input type=radio name='new_currency' value='$now_currency1' checked> $now_currency1 &nbsp;&nbsp;&nbsp; 
											<input type=radio name='new_currency' value='$now_currency2'> $now_currency2
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Quantity</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_qty' style='text-align: right'>
										</div>
										<label for='cname' class='control-label col-sm-3'>Unit</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_unit'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Unit Amount</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_unit_amount' style='text-align: right'>
										</div>
										<label for='cname' class='control-label col-sm-3'>Total Amount</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='new_total_amount' style='text-align: right' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>Purchase Date</label>
                                        <div class='col-sm-3'>
											<input type='date' class='form-control' name='new_purchase_date' value='$today_full_set2' max='$today_full_set2'>
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='Submit'>
										</div>
                                    </div>");
									?>
								
		
		</div>
		</section>
		</div>
		</div>
		</form>
		
	  <? } ?>

		

		
						
						
						
    
    
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
} else if($step_next == "permit_upd") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
  if(!$new_del_chk) { $new_del_chk = "0"; }
  
  $new_p_name = addslashes($new_p_name);
  $new_p_detail = addslashes($new_p_detail);
  

    if($new_del_chk == "1") { // Delete
    
        $query_D1 = "DELETE FROM asset WHERE uid = '$new_p_uid'";
        $result_D1 = mysql_query($query_D1);
        if (!$result_D1) { error("QUERY_ERROR"); exit; }
        
    } else {
    
        $result_CHG = mysql_query("UPDATE asset SET gate = '$new_gate', shop_code = '$new_shop_code', 
            p_code = '$new_p_code', p_type = '$new_p_type', p_name = '$new_p_name', p_detail = '$new_p_detail', 
			currency = '$new_currency', qty = '$new_qty', unit = '$new_unit', unit_amount = '$new_unit_amount', total_amount = '$new_total_amount', 
            p_status = '$new_p_status', purchase_date = '$new_purchase_date', expire_date = '$new_expire_date' WHERE uid = '$new_p_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
    }

    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_deprec.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;


} else if($step_next == "permit_add") {
  

  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $new_p_name = addslashes($new_p_name);
  $new_p_detail = addslashes($new_p_detail);
  
  $m_ip = getenv('REMOTE_ADDR');
  
    $query_F2 = "INSERT INTO asset (uid,branch_code,gate,shop_code,p_code,p_type,p_name,p_detail,currency,
        qty,unit,unit_amount,total_amount,p_status,purchase_date,post_date) values ('',
        '$login_branch','$new_gate','$new_shop_code','$new_p_code','$new_p_type','$new_p_name','$new_p_detail','$new_currency',
        '$new_qty','$new_unit','$new_unit_amount','$new_total_amount','1','$new_purchase_date','$post_dates')";
    $result_F2 = mysql_query($query_F2);
    if (!$result_F2) { error("QUERY_ERROR"); exit; }
  
  
    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_deprec.php?mode=check&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page'>");
    exit;
  

}

}
?>