<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "finance_invoice";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/finance_invoice.php?sorting_key=$sorting_key";
$link_upd = "$home/finance_invoice.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

// Invoice
$link_view = "finance_invoice_print.php";
$radio_chk_dis = "disabled";

// Today
$this_date = date("Y-m-d");
$this_y = date("y");
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
if($login_level > "3") {
  $sorting_filter = "branch_code = '$login_branch'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch'";
} else if($login_level == "3") {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate'";
} else if($login_level == "2") {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_subgate'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate'";
} else {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate' AND shop_code = '$login_shop'";
  $sorting_filter_G = "branch_code = '$login_branch' AND client_id = '$login_gate'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate' AND shop_code = '$login_shop'";
}


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "inv_date"; }
if($sorting_key == "uid") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "inv_no") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pay_num") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_payment_invoice WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_payment_invoice WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_payment_invoice WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$title_module_0905?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='finance_invoice.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='inv_date'>$txt_fin_cost_06</option>
				<option value='inv_no' $chk1>$txt_sales_sales_211</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			<div class='col-sm-1'></div>
			</form>
			
			
			<div class='col-sm-2'>Total: $total_record / $all_record &nbsp;[ <font color='navy'>$page</font> / $total_page ]</div>
			
			<div class='col-sm-2' align=right>$txt_comm_frm14 : </div>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=inv_date&keyfield=$keyfield&key=$key'>$txt_fin_cost_06</option>
			<option value='$PHP_SELF?sorting_key=inv_no&keyfield=$keyfield&key=$key' $chk1>$txt_sales_sales_211</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th><?=$txt_fin_cost_06?></th>
            <th><?=$txt_sales_sales_211?></th>
			<th><?=$txt_fin_income_03?> (IDR)</th>
			<th><?=$txt_fin_income_03?> (USD)</th>
			<th><?=$txt_sales_sales_219?></th>
			<th><?=$txt_sales_sales_217?></th>
			<th><?=$txt_comm_frm11?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 합계 구하기
if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_IDR = "SELECT sum(inv_amount) FROM shop_payment_invoice 
                WHERE currency = 'IDR' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_IDR = "SELECT sum(inv_amount) FROM shop_payment_invoice 
                WHERE currency = 'IDR' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sum_IDR = mysql_query($query_sum_IDR);
if (!$result_sum_IDR) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_IDR = @mysql_result($result_sum_IDR,0,0);
$sum_pay_amount_IDR_K = number_format($sum_pay_amount_IDR);

if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_USD = "SELECT sum(inv_amount) FROM shop_payment_invoice 
                WHERE currency = 'USD' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_USD = "SELECT sum(inv_amount) FROM shop_payment_invoice
                WHERE currency = 'USD' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sum_USD = mysql_query($query_sum_USD);
if (!$result_sum_USD) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_USD = @mysql_result($result_sum_USD,0,0);
$sum_pay_amount_USD_K = number_format($sum_pay_amount_USD);

echo ("
<tr height=22>
  <td colspan=2><div align=right>Total</div></td>
  <td><div align=right><font color=#000000><b>$sum_pay_amount_IDR_K</b></font></div></td>
  <td><div align=right><font color=#000000><b>$sum_pay_amount_USD_K</b></font></div></td>
  <td><div align=right>&nbsp;</div></td>
  <td><div align=right>&nbsp;</div></td>
  <td><div align=right>&nbsp;</div></td>
</tr>
");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,inv_no,pay_num,client_code,currency,inv_amount,inv_date,userfile,user_id,user_ip,tax_no,pay_status,pay_date,post_date 
		FROM shop_payment_invoice WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,inv_no,pay_num,client_code,currency,inv_amount,inv_date,userfile,user_id,user_ip,tax_no,pay_status,pay_date,post_date 
		FROM shop_payment_invoice WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $inv_uid = mysql_result($result,$i,0);   
   $inv_gate = mysql_result($result,$i,1);
   $inv_no = mysql_result($result,$i,2);
   $inv_pay_num = mysql_result($result,$i,3);
   $inv_client_code = mysql_result($result,$i,4);
   $inv_currency = mysql_result($result,$i,5);
   $inv_amount = mysql_result($result,$i,6);
   $inv_date = mysql_result($result,$i,7);
   $inv_userfile = mysql_result($result,$i,8);
   $inv_user_id = mysql_result($result,$i,9);
   $inv_user_ip = mysql_result($result,$i,10);
   $inv_tax_no = mysql_result($result,$i,11);
   $inv_pay_status = mysql_result($result,$i,12);
   $inv_pay_date = mysql_result($result,$i,13);
   $inv_post_date = mysql_result($result,$i,14);
   
	// Client Name
	$rf_query = "SELECT name,corp_name FROM member_main WHERE code = '$inv_client_code'";
    $rf_result = mysql_query($rf_query);
		if (!$rf_result) { error("QUERY_ERROR"); exit; }
    $inv_client_name1 = @mysql_result($rf_result,0,0);
	$inv_client_name2 = @mysql_result($rf_result,0,1);
	
	if($inv_client_name2 != "") {
		$inv_client_name = $inv_client_name2;
	} else {
		$inv_client_name = $inv_client_name1;
	}
   
   
	// Currency
	if($inv_currency == "USD") {
		$inv_amount_IDR = "";
		$inv_amount_USD = $inv_amount;
	} else {
		$inv_amount_IDR = $inv_amount;
		$inv_amount_USD = "";
	}
	$inv_amount_IDR_K = number_format($inv_amount_IDR);
	$inv_amount_USD_K = number_format($inv_amount_USD); // 소수점 보이도록
   
	// Date
	$wday_exp = explode("-",$inv_date);
	$wday1 = $wday_exp[0];
	$wday2 = $wday_exp[1];
	$wday3 = $wday_exp[2];

    if($lang == "ko") {
	    $inv_date_txt = "$wday1"."/"."$wday2"."/"."$wday3";
	} else {
	    $inv_date_txt = "$wday3"."-"."$wday2"."-"."$wday1";
	}
	
	$pday1 = substr($inv_pay_date,0,4);
	$pday2 = substr($inv_pay_date,4,2);
	$pday3 = substr($inv_pay_date,6,2);
	$pday4 = substr($inv_pay_date,8,2);
	$pday5 = substr($inv_pay_date,10,2);
	$pday6 = substr($inv_pay_date,12,2);

    if($lang == "ko") {
	    $inv_pay_date_txt = "$pday1"."/"."$pday2"."/"."$pday3";
	} else {
	    $inv_pay_date_txt = "$pday3"."-"."$pday2"."-"."$pday1";
	}
	
	$sday1 = substr($inv_post_date,0,4);
	$sday2 = substr($inv_post_date,4,2);
	$sday3 = substr($inv_post_date,6,2);
	$sday4 = substr($inv_post_date,8,2);
	$sday5 = substr($inv_post_date,10,2);
	$sday6 = substr($inv_post_date,12,2);

    if($lang == "ko") {
	    $inv_post_date_txt = "$sday1"."/"."$sday2"."/"."$sday3";
	} else {
	    $inv_post_date_txt = "$sday3"."-"."$sday2"."-"."$sday1";
	}
	
	if($inv_date > "0") {
		$inv_full_date_txt = "<font color='#000000'>$inv_date_txt</font>";
	} else {
		$inv_full_date_txt = "<font color='#aaaaaa'>$inv_post_date_txt</font>";
	}
	
	
	// Pay Status
	if($inv_pay_status == "2") {
		$inv_status_txt = "<font color=#006699>$txt_sales_sales_2171</font>";
	} else if($inv_pay_status == "1") {
		$inv_status_txt = "$txt_sales_sales_2172";
	} else {
		$inv_status_txt = "$txt_sales_sales_2172";
	}


    // Line Color
    if($uid == $inv_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
	

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$inv_full_date_txt</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$inv_uid'>$inv_no</a></td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$inv_uid'>{$inv_amount_IDR_K}</a></div></td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$inv_uid'>{$inv_amount_USD_K}</a></div></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$inv_uid'>$inv_client_name</a></td>");
  echo("<td bgcolor='$highlight_color'>$inv_status_txt</td>");
  if($inv_date > "0") {
	echo("<td bgcolor='$highlight_color'><a href='$link_view?P_uid=$inv_uid' target='_print'><i class='fa fa-print'></i> $txt_comm_frm11</a></td>");
  } else {
	echo("<td bgcolor='$highlight_color'>&nbsp;</td>");
  }
  echo("</tr>");
  
  
	if($mode == "check" AND $inv_uid == $uid) {
  

		$query_HC = "SELECT count(uid) FROM shop_payment_invoice_cart WHERE inv_no = '$inv_no'";
		$result_HC = mysql_query($query_HC);
		if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
		$total_HC = @mysql_result($result_HC,0,0);
    
		$query_H = "SELECT uid,catg_code,pcode,org_pcode,pname,currency,p_unit_price,p_qty,p_unit,p_total_price 
					FROM shop_payment_invoice_cart WHERE inv_no = '$inv_no' ORDER BY pcode ASC";
		$result_H = mysql_query($query_H);
		if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
		$cart_no = 1;
    
		for($h = 0; $h < $total_HC; $h++) {
			$H_cart_uid = mysql_result($result_H,$h,0);
			$H_catg_code = mysql_result($result_H,$h,1);
			$H_pcode = mysql_result($result_H,$h,2);
			$H_org_pcode = mysql_result($result_H,$h,3);
			$H_pname = mysql_result($result_H,$h,4);
				$H_pname = stripslashes($H_pname);
			$H_currency = mysql_result($result_H,$h,5);
			$H_unit_price = mysql_result($result_H,$h,6);
				$H_unit_price_k = number_format($H_unit_price);
			$H_qty = mysql_result($result_H,$h,7);
				$H_qty_k = number_format($H_qty);
			$H_unit = mysql_result($result_H,$h,8);
			$H_tamount = mysql_result($result_H,$h,9);
				$H_tamount_k = number_format($H_tamount);
      

      
			echo ("
			<tr height=22>
				<td colspan=2><div align=right><i class='fa fa-caret-right'></i></div></td>
				<td colspan=6>[$H_pcode] {$H_pname} | 
					$H_unit_price_k x $H_qty_k $H_unit = $H_tamount_k
				</td>
			</tr>");
			
			$cart_no++;
			
		}
  
	}
  
  
  
  
  
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
		if($mode == "check" AND $uid) { // UPDATE Invoice

          $pm_query = "SELECT uid,branch_code,gate,shop_code,inv_no,pay_num,client_code,currency,inv_amount,inv_date,inv_date2,due_date,
					userfile,user_id,user_ip,tax_no,pay_status,post_date,apprv_date,pay_date FROM shop_payment_invoice WHERE uid = '$uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_branch_code = @mysql_result($pm_result,0,1);
          $pm_gate = @mysql_result($pm_result,0,2);
          $pm_shop_code = @mysql_result($pm_result,0,3);
          $pm_inv_no = @mysql_result($pm_result,0,4);
          $pm_pay_num = @mysql_result($pm_result,0,5);
          $pm_client_code = @mysql_result($pm_result,0,6);
          $pm_currency = @mysql_result($pm_result,0,7);
          $pm_inv_amount = @mysql_result($pm_result,0,8);
          $pm_inv_date = @mysql_result($pm_result,0,9);
          $pm_inv_date2 = @mysql_result($pm_result,0,10);
          $pm_due_date = @mysql_result($pm_result,0,11);
          $pm_userfile = @mysql_result($pm_result,0,12);
          $pm_user_id = @mysql_result($pm_result,0,13);
          $pm_user_ip = @mysql_result($pm_result,0,14);
          $pm_tax_no = @mysql_result($pm_result,0,15);
		  $pm_pay_status = @mysql_result($pm_result,0,16);
		  $pm_post_date = @mysql_result($pm_result,0,17);
		  $pm_apprv_date = @mysql_result($pm_result,0,18);
		  $pm_pay_date = @mysql_result($pm_result,0,19);
		  
			// Client Name
			$pmn_query = "SELECT name,corp_name FROM member_main WHERE code = '$pm_client_code' ORDER BY uid DESC";
			$pmn_result = mysql_query($pmn_query);
				if (!$pmn_result) { error("QUERY_ERROR"); exit; }
			$pm_client_name1 = @mysql_result($pmn_result,0,0);
			$pm_client_name2 = @mysql_result($pmn_result,0,1);
			
			if($pm_client_name2 != "") {
				$pm_client_name = $pm_client_name2;
			} else {
				$pm_client_name = $pm_client_name1;
			}
			
          
          // Payment
          if($pm_pay_status == "2") {
            $submit_txt = $txt_fin_income_01;
          } else if($pm_pay_status == "1") {
            $submit_txt = $txt_fin_income_01;
          } else {
            $submit_txt = $txt_invn_payment_09;
          }
		  
		  // Payment Process
		  if($pm_pay_status == "0") {
            $pm_pay_status_chk0 = "checked";
            $pm_pay_status_chk1 = "";
            $pm_pay_status_chk2 = "";
          } else if($pm_pay_status == "1") {
            $pm_pay_status_chk0 = "";
            $pm_pay_status_chk1 = "checked";
            $pm_pay_status_chk2 = "";
          } else if($pm_pay_status == "2") {
            $pm_pay_status_chk0 = "";
            $pm_pay_status_chk1 = "";
            $pm_pay_status_chk2 = "checked";
          }

            // Dates
            $w_day1 = substr($pm_post_date,0,4);
	        $w_day2 = substr($pm_post_date,4,2);
	        $w_day3 = substr($pm_post_date,6,2);
	        $w_day4 = substr($pm_post_date,8,2);
	        $w_day5 = substr($pm_post_date,10,2);
	        $w_day6 = substr($pm_post_date,12,2);
            
			if($lang == "ko") {
	            $pm_post_dates = "$w_day1"."/"."$w_day2"."/"."$w_day3".", "."$w_day4".":"."$w_day5".":"."$w_day6";
	        } else {
	            $pm_post_dates = "$w_day3"."-"."$w_day2"."-"."$w_day1".", "."$w_day4".":"."$w_day5".":"."$w_day6";
	        }
			
			// if(!$pm_apprv_date) {
			// 	$pm_apprv_date = $this_date;
			// }
	          
            
			
			// Currency
			if($pm_currency == "USD") {
				$currency_chk_IDR = "";
				$currency_chk_USD = "checked";
			} else {
				$currency_chk_IDR = "checked";
				$currency_chk_USD = "";
			}
			
			// Approval
			if($pm_apprv_date > "0") {
				$pm_apprv_chk = "1";
			} else {
				$pm_apprv_chk = "0";
			}
          

      echo ("
      <form name='signform2' class='cmxform form-horizontal adminex-form' method='post' action='finance_invoice.php'>
      <input type='hidden' name='step_next' value='permit_upd'>
      <input type='hidden' name='sorting_key' value='$sorting_key'>
      <input type='hidden' name='keyfield' value='$keyfield'>
      <input type='hidden' name='key' value='$key'>
      <input type='hidden' name='page' value='$page'>
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='org_branch_code' value='$pm_branch_code'>
      <input type=hidden name='org_client' value='$pm_gate'>
      <input type=hidden name='org_inv_uid' value='$pm_uid'>
      <input type=hidden name='org_inv_no' value='$pm_inv_no'>");
	  ?>

		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sales_sales_20?>
			
            
        </header>
		
        <div class="panel-body">
			
				<? echo ("
				<div class='form-group'>
					<label for='cname' class='control-label col-sm-2'>$txt_sales_sales_211</label>
					<div class='col-sm-4'>
						<input type=text name='new_invoice_no' value='$pm_inv_no' class='form-control'>
					</div>
					<label class='control-label col-sm-2'>$txt_sales_sales_13</label>
					<div class='col-sm-4'>
						<input disabled type=text name='dis_client_name' value='$pm_client_name' class='form-control'>
					</div>
				</div>
									
				
				<div class='form-group'>
					<label class='control-label col-sm-2'>$txt_sales_sales_17</label>
					<div class='col-sm-4'>
						<input type='date' class='form-control' name='new_due_date' value='$pm_due_date'>
					</div>
					<label class='control-label col-sm-2'>$txt_sales_sales_2161</label>
					<div class='col-sm-4'>
						<input disabled type='text' class='form-control' name='new_post_dates' value='$pm_post_dates'>
					</div>
				</div>
				
				<div class='form-group'>");
				
					if($pm_apprv_chk == "1") {
						echo ("
						<label class='control-label col-sm-2'>$txt_sales_sales_2163</label>
						<div class='col-sm-4'>
							<input disabled type='date' class='form-control' name='new_apprv_date' value='$pm_apprv_date'>
						</div>");
					} else {
						echo ("
						<label class='control-label col-sm-2'><input type='checkbox' name='new_apprv_chk' value='1' $pm_apprv_chk'> $txt_sales_sales_2163</label>
						<div class='col-sm-4'>
							<input type='date' class='form-control' name='new_apprv_date' value='$pm_apprv_date'>
						</div>");
					}
					
					if($pm_inv_date > "0") {
							echo ("
							<label class='control-label col-sm-2'>$txt_sales_sales_2162</label>
							<div class='col-sm-4'>
								<input disabled type='date' class='form-control' name='new_inv_date' value='$pm_inv_date'>
							</div>");
					} else {
						if($pm_apprv_chk == "1") {
							echo ("
							<label class='control-label col-sm-2'><input type='checkbox' name='new_send_chk' value='1'> Send</label>
							<div class='col-sm-4'>
								<input type='date' class='form-control' name='new_inv_date' value='$this_date'>
							</div>");
						} else {
							echo ("
							<label class='control-label col-sm-2'>&gt;</label>
							<div class='col-sm-4'>
								Please confirm invoice.
							</div>");
						}
					}
					
					echo ("
				</div>

				
				<div class='form-group'>
					<label class='control-label col-sm-2'></label>
					<div class='col-sm-4'>
						<input class='btn btn-primary' type='submit' value='$txt_comm_frm28'>
					</div>
					<div class='col-sm-6'></div>
				</div>
				");
				?>
								

		</div>
		</section>
		</div>
		</div>
		</form>

		
		
		
	  <? } else { ?>
		
		
		<?
		// Total Count
		$query_ct = "SELECT count(uid) FROM shop_payment_invoice_cart WHERE $sorting_filter AND pay_status < '1'";
		$result_ct = mysql_query($query_ct);
		$total_ct = mysql_result($result_ct,0,0);
		
		// Invoice Cart
		$query_cat = "SELECT client_code FROM shop_payment_invoice_cart WHERE $sorting_filter AND pay_status < '1'";
		$result_cat = mysql_query($query_cat);
		$ini_client_code = mysql_result($result_cat,0,0);
		
		
		
		$query_py = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter AND f_class = 'in' AND f_intype = '1' AND pay_state < '2'";
		$result_py = mysql_query($query_py);
		$total_py = mysql_result($result_py,0,0);
												
		if($total_py > 0) {
			$submit_disable = "";
		} else {
			$submit_disable = "disabled";
		}
	  
		echo ("
		<form name='signform' class='cmxform form-horizontal adminex-form' method='post' action='finance_invoice.php'>
		<input type='hidden' name='step_next' value='permit_add'>");
		?>
		

		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        
		
        <div class="panel-body">
		
		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm19?></label>
                                        <div class="col-sm-6">
												<?
												$query_p = "SELECT pay_num,currency,pay_amount,client_code,name1,pay_date FROM shop_payment 
														WHERE $sorting_filter AND f_class = 'in' AND f_intype = '1' AND pay_state < '2' ORDER BY pay_date ASC";
												$result_p = mysql_query($query_p);
												
												echo("<select name='add_pay_num' class='form-control' required>");
												echo("<option value=\"\">:: $txt_comm_frm19</option>");

												for($i = 0; $i < $total_py; $i++) {
													$p_pay_num = mysql_result($result_p,$i,0);
													$p_currency = mysql_result($result_p,$i,1);
													$p_pay_amount = mysql_result($result_p,$i,2);
														$p_pay_amount_K = number_format($p_pay_amount);
													$p_client_code = mysql_result($result_p,$i,3);
														if(!$p_client_code) { $p_client_code = "Undefined"; }
													$p_client_name = mysql_result($result_p,$i,4);
													$p_pay_date = mysql_result($result_p,$i,5);
													
													$p_uday1 = substr($p_pay_date,0,4);
													$p_uday2 = substr($p_pay_date,4,2);
													$p_uday3 = substr($p_pay_date,6,2);
													$p_uday4 = substr($p_pay_date,8,2);
													$p_uday5 = substr($p_pay_date,10,2);
													$p_uday6 = substr($p_pay_date,12,2);

													if($lang == "ko") {
														$p_pay_date_txt = "$p_uday1"."/"."$p_uday2"."/"."$p_uday3";
													} else {
														$p_pay_date_txt = "$p_uday3"."-"."$p_uday2"."-"."$p_uday1";
													}
													
													// Customer
													$cc_query = "SELECT client_code FROM shop_payment_invoice_cart WHERE pay_num = '$p_pay_num' AND inv_no = '' 
																ORDER BY client_code DESC";
													$cc_result = mysql_query($cc_query);
														if (!$cc_result) { error("QUERY_ERROR"); exit; }
													$du_client_code = @mysql_result($cc_result,0,0);
													
													
													// Duplication
													$rc_query = "SELECT count(uid) FROM shop_payment_invoice_cart WHERE pay_num = '$p_pay_num'";
													$rc_result = mysql_query($rc_query);
														if (!$rc_result) { error("QUERY_ERROR"); exit; }
													$p_pay_count = @mysql_result($rc_result,0,0);
													
													if($p_pay_count > 0) {
														$p_pay_dis = "disabled";
													} else {
														$p_pay_dis = "";
													}
													
													if(!$ini_client_code OR $ini_client_code == $p_client_code) {
														echo("<option $p_pay_dis value='$p_pay_num'>[$p_pay_num][$p_pay_date_txt] [ $p_client_code - $p_client_name ] $p_currency $p_pay_amount_K</option>");
													}
												}
												echo ("
												</select>
										</div>
										<div class='col-sm-3'>
												<input $submit_disable class='btn btn-primary' type='submit' value='$txt_comm_frm051s'>
										</div>
                                    </div>");
									?>
									
		</div>
		</section>
		</div>
		</div>
		</form>
		
	  <? } ?>
	  
	  
	  
	  

	  
	  
		<?
		$query_py2 = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter AND f_class = 'in' AND f_intype = '1' AND pay_state < '2'";
		$result_py2 = mysql_query($query_py2);
		$total_py2 = mysql_result($result_py2,0,0);
		
		
												
		if($total_ct > "0" AND ($mode == "" OR $mode == "order_form")) {
		?>
	  
	  <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        
		<section class="panel">
        <header class="panel-heading">
            <?=$txt_sales_sales_214?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<section id="unseen">
			<table class="table table-bordered table-condensed">
			<thead>
			<tr>
				<th>#</th>
				<th><?=$txt_invn_stockin_02?></th>
				<th><?=$txt_invn_stockin_122?></th>
				<th><?=$txt_invn_stockin_17?></th>
				<th><?=$txt_invn_stockin_36?></th>
				<th><?=$txt_invn_stockin_121?></th>
				<th><?=$txt_invn_stockin_614?></th>
			</tr>
			</thead>
			
			<tbody>
			
			<?
			$query_p2 = "SELECT pay_num,currency,pay_amount,client_code,name1,pay_date FROM shop_payment 
					WHERE $sorting_filter AND f_class = 'in' AND f_intype = '1' AND pay_state < '2' ORDER BY pay_date ASC";
			$result_p2 = mysql_query($query_p2);
		
			for($i2 = 0; $i2 < $total_py2; $i2++) {
				$p2_pay_num = mysql_result($result_p2,$i2,0);
				$p2_currency = mysql_result($result_p2,$i2,1);
				$p2_pay_amount = mysql_result($result_p2,$i2,2);
					$p2_pay_amount_K = number_format($p2_pay_amount);
				$p2_client_code = mysql_result($result_p2,$i2,3);
				$p2_client_name = mysql_result($result_p2,$i2,4);
				$p2_pay_date = mysql_result($result_p2,$i2,5);
													
				$p2_uday1 = substr($p2_pay_date,0,4);
				$p2_uday2 = substr($p2_pay_date,4,2);
				$p2_uday3 = substr($p2_pay_date,6,2);
				$p2_uday4 = substr($p2_pay_date,8,2);
				$p2_uday5 = substr($p2_pay_date,10,2);
				$p2_uday6 = substr($p2_pay_date,12,2);

				if($lang == "ko") {
					$p2_pay_date_txt = "$p2_uday1"."/"."$p2_uday2"."/"."$p2_uday3";
				} else {
					$p2_pay_date_txt = "$p2_uday3"."-"."$p2_uday2"."-"."$p2_uday1";
				}
													
				// Customer Name
				
				
				
				// Duplication
				$rd2_query = "SELECT count(pay_num) FROM shop_payment_invoice_cart WHERE pay_num = '$p2_pay_num' AND inv_no = ''";
				$rd2_result = mysql_query($rd2_query);
					if (!$rd2_result) { error("QUERY_ERROR"); exit; }
				$p2_pay_count = @mysql_result($rd2_result,0,0);
													
				if($p2_pay_count > 0) {
													
					echo("
					<tr>
						<td colspan=5>[$p_pay_num][$p_pay_date_txt] [ $p_client_code - $p_client_name ]</td>
						<td><div align=right><b>$p_currency $p_pay_amount_K</b></div></td>
						
						<form name='cart_del' method='post' action='finance_invoice.php'>
						<input type=hidden name='step_next' value='permit_cart_del'>
						<input type=hidden name='del_pay_num' value='$p2_pay_num'>
						<td><input type=submit value='$txt_comm_frm13' class='btn btn-default btn-xs'></td>
						</form>
					</tr>");
													

			
					$query_ct2 = "SELECT count(uid) FROM shop_payment_invoice_cart WHERE $sorting_filter AND pay_status < '1' AND pay_num = '$p2_pay_num' AND inv_no = ''";
					$result_ct2 = mysql_query($query_ct2);
					$total_ct2 = mysql_result($result_ct2,0,0);
					
					$query_H2 = "SELECT uid,inv_no,inv_date,org_pcode,pcode,pname,currency,p_unit_price,p_qty,p_unit,p_total_price 
							FROM shop_payment_invoice_cart WHERE $sorting_filter AND pay_status < '1' AND pay_num = '$p2_pay_num' AND inv_no = '' ORDER BY pcode ASC";
					$result_H2 = mysql_query($query_H2);
					if (!$result_H2) {   error("QUERY_ERROR");   exit; }
		
					
					$cart_no2 = 1;
    
					for($h2 = 0; $h2 < $total_ct2; $h2++) {
						$H2_cart_uid = mysql_result($result_H2,$h2,0);
						$H2_inv_no = mysql_result($result_H2,$h2,1);
						$H2_inv_date = mysql_result($result_H2,$h2,2);
						$H2_org_pcode = mysql_result($result_H2,$h2,3);
						$H2_pcode = mysql_result($result_H2,$h2,4);
						$H2_pname = mysql_result($result_H2,$h2,5);
							$H2_pname = stripslashes($H2_pname);
						$H2_currency = mysql_result($result_H2,$h2,6);
						$H2_unit_price = mysql_result($result_H2,$h2,7);
							$H2_unit_price_k = number_format($H2_unit_price);
						$H2_qty = mysql_result($result_H2,$h2,8);
							$H2_qty_k = number_format($H2_qty);
						$H2_unit = mysql_result($result_H2,$h2,9);
						$H2_amount = mysql_result($result_H2,$h2,10);
							$H2_amount_k = number_format($H2_amount);

						echo ("
						<tr>
							<td>$cart_no2</td>
							<td>[$H2_pcode] $H2_pname</td>
							<td><div align=right>$H2_unit_price_k</div></td>
							<td><div align=right>$H2_qty_k</div></td>
							<td>$H2_unit</td>
							<td><div align=right>$H2_amount_k</div></td>
							<td>$H2_org_pcode</td>
						</tr>");
			
						$cart2_no++;
					}
			
			
				}
				
			}
			
			
			// SUM
			$query_sum = "SELECT sum(p_total_price),client_code,currency FROM shop_payment_invoice_cart WHERE $sorting_filter AND pay_status < '1'";
			$result_sum = mysql_query($query_sum);
			$total_sum = @mysql_result($result_sum,0,0);
				$total_sum_k = number_format($total_sum);
			$client_code = @mysql_result($result_sum,0,1);
			$client_currency = @mysql_result($result_sum,0,2);

			if($total_ct > "0") {
					
			echo ("
			<form name='order_check' method='post' action='finance_invoice.php'>
			<input type=hidden name='mode' value='order_form'>
			<input type=hidden name='order_currency' value='$client_currency'>
			<input type=hidden name='order_total_sum' value='$total_sum'>
			<input type=hidden name='order_client_code' value='$client_code'>
			<input type=hidden name='order_client_name' value='$client_name'>

			<tr>
				<td colspan=5 align=center><b>$txt_sales_sales_11</b></td>
				<td align=right><font color=#000000><b>$client_currency $total_sum_k</b></font></td>");
				
				if($mode != "order_form") {
					echo ("<td><input type=submit value='$txt_comm_frm28' class='btn btn-primary'></td>");
				} else {
					echo ("<td></td>");
				}
				
				echo ("
			</tr>
			</form>");
			
			}
			?>
			</tbody>
			
			</table>
			</section>
			
			
		
		
			<?	
			if($mode == "order_form") {
      
				
				
				$login_branch_exp = explode("_",$login_branch);
				$login_branch2 = $login_branch_exp[1];
				
				$query_sum2 = "SELECT max(uid) FROM shop_payment_invoice WHERE branch_code = '$login_branch'";
				$result_sum2 = mysql_query($query_sum2);
				$max_uid = @mysql_result($result_sum2,0,0);
				
				$new_max_uid = $max_uid + 1;
				$new_max_uid5 = sprintf("%05d", $new_max_uid); // 5 digits
		
				// INVOICE NO.
				$default_invoice_no = "$this_y"."-"."$login_branch2"."-"."$new_max_uid5";
		
	  
				echo ("
				<form name='order_confirm' class='cmxform form-horizontal adminex-form' method='post' action='finance_invoice.php'>
				<input type=hidden name='step_next' value='permit_order'>
				<input type=hidden name='order_currency' value='$client_currency'>
				<input type=hidden name='order_total_sum' value='$total_sum'>
				<input type=hidden name='order_client_code' value='$client_code'>
				<input type=hidden name='order_client_name' value='$client_name'>
				<input type=hidden name='sorting_filter' value='$sorting_filter'>
				<input type=hidden name='page' value='$page'>

				<div class='form-group'>
					<label for='cname' class='control-label col-sm-2'>$txt_sales_sales_211</label>
					<div class='col-sm-4'>
						<input type=text name='new_invoice_no' value='$default_invoice_no' class='form-control'>
					</div>
			
					<label class='control-label col-sm-2'>$txt_sales_sales_13</label>
					<div class='col-sm-4'>");
			
						$query_z1C = "SELECT count(id) FROM member_main WHERE userlevel > '3' AND mb_type = '3'";
						$result_z1C = mysql_query($query_z1C);
						$total_z1C = @mysql_result($result_z1C,0,0);
                
						$query_z1 = "SELECT id,code,name,corp_name FROM member_main WHERE userlevel > '3' AND mb_type = '3' ORDER BY name ASC";
						$result_z1 = mysql_query($query_z1);
                
						echo ("<select name='new_client_code' class='form-control' required>");

						for($z1 = 0; $z1 < $total_z1C; $z1++) {
							$zbuyer_id = mysql_result($result_z1,$z1,0);
							$zbuyer_code = mysql_result($result_z1,$z1,1);
							$zbuyer_name = mysql_result($result_z1,$z1,2);
							$zbuyer_corp = mysql_result($result_z1,$z1,3);
					  
							if($zbuyer_code == $order_client_code) {
								echo ("<option value='$zbuyer_code' selected>[$zbuyer_code] $zbuyer_corp</option>");
							} else {
								echo ("<option disabled value='$zbuyer_code'>[$zbuyer_code] $zbuyer_corp</option>");
							}
					  
						}
						echo ("</select>
					</div>
				</div>
									
				
				<!--				
				<div class='form-group'>
                    <label for='cname' class='control-label col-sm-2'>$txt_invn_payment_20</label>
                    <div class='col-sm-4'>");
						$query_K1C = "SELECT count(uid) FROM code_card WHERE branch_code = '$login_branch' AND userlevel > '0'";
						$result_K1C = mysql_query($query_K1C);
						$total_K1C = @mysql_result($result_K1C,0,0);
                
						$query_K1 = "SELECT card_code,card_name FROM code_card WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY card_code ASC";
						$result_K1 = mysql_query($query_K1);
                
						echo ("<select name='new_pay_card' class='form-control'>");
						echo ("<option value=\"\">:: $txt_comm_frm19</option>");

						for($w1 = 0; $w1 < $total_K1C; $w1++) {
							$card_code = mysql_result($result_K1,$w1,0);
							$card_name = mysql_result($result_K1,$w1,1);
                
							if($upd_pay_card == $card_code) {
								echo ("<option value='$card_code' selected>$card_name</option>");
							} else {
								echo ("<option value='$card_code'>$card_name</option>");
							}
						}
						echo ("</select>
					</div>
                                    
                    <label for='cname' class='control-label col-sm-2'>$txt_invn_payment_21</label>
                    <div class='col-sm-4'>");
						$query_K2C = "SELECT count(uid) FROM code_bank WHERE branch_code = '$login_branch' AND userlevel > '0'";
						$result_K2C = mysql_query($query_K2C);
						$total_K2C = @mysql_result($result_K2C,0,0);
                
						$query_K2 = "SELECT bank_code,bank_name FROM code_bank WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY bank_code ASC";
						$result_K2 = mysql_query($query_K2);
                
						echo ("<select name='new_bank_code' class='form-control'>");
						echo ("<option value=\"\">:: $txt_comm_frm19</option>");

						for($w2 = 0; $w2 < $total_K2C; $w2++) {
							$bank_code = mysql_result($result_K2,$w2,0);
							$bank_name = mysql_result($result_K2,$w2,1);
                
							if($pm_bank_name == $bank_code) {
								echo ("<option value='$bank_code' selected>$bank_name</option>");
							} else {
								echo ("<option value='$bank_code'>$bank_name</option>");
							}
						}
						echo ("</select>
					</div>
                </div>
				-->
				
		
				<div class='form-group'>
					<label class='control-label col-sm-2'>$txt_sales_sales_17</label>
					<div class='col-sm-4'>
						<input type='date' class='form-control' name='new_due_date' value='$this_date'>
					</div>
					
					<label class='control-label col-sm-2'>$txt_fin_cost_06</label>
					<div class='col-sm-4'>
						<input type='date' class='form-control' name='new_post_dates' value='$this_date'>
					</div>
				</div>
				
				
				<div class='form-group'>
					<label class='control-label col-sm-2'></label>
					<div class='col-sm-4'>
						<input class='btn btn-primary' type='submit' value='$txt_comm_frm28'>
					</div>
					<div class='col-sm-6'></div>
				</div>
				");
		
			}
			?>
		
			</div>
			</form>
		
		
		
		
									
		</div>
		</section>
		</div>
		</div>

		
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
	
	if(!$new_apprv_chk) { $new_apprv_chk = "0"; }
	if(!$new_send_chk) { $new_send_chk = "0"; }
	
  
	$m_ip = getenv('REMOTE_ADDR');
  
	$result_UP1 = mysql_query("UPDATE shop_payment_invoice SET inv_no = '$new_invoice_no', due_date = '$new_due_date' WHERE uid = '$org_inv_uid'",$dbconn);
	if(!$result_UP1) { error("QUERY_ERROR"); exit; }
  
	$result_UP2 = mysql_query("UPDATE shop_payment_invoice_cart SET inv_no = '$new_invoice_no', due_date = '$new_due_date' WHERE inv_no = '$org_inv_no'",$dbconn);
	if(!$result_UP2) { error("QUERY_ERROR"); exit; }
	
	// Invoice Approval
	if($new_apprv_chk == "1") {
		
		$result_UP3 = mysql_query("UPDATE shop_payment_invoice SET apprv_date = '$new_apprv_date' WHERE uid = '$org_inv_uid'",$dbconn);
		if(!$result_UP3) { error("QUERY_ERROR"); exit; }
		
	}
	
	
	// Invoice Sending
	if($new_send_chk == "1") {
		
		$result_UP3a = mysql_query("UPDATE shop_payment_invoice SET inv_date = '$new_inv_date' WHERE uid = '$org_inv_uid'",$dbconn);
		if(!$result_UP3a) { error("QUERY_ERROR"); exit; }
		
		$result_UP3b = mysql_query("UPDATE shop_payment_invoice_cart SET inv_date = '$new_inv_date' WHERE inv_no = '$org_inv_no'",$dbconn);
		if(!$result_UP3b) { error("QUERY_ERROR"); exit; }
		
		// Send INVOICE
		
	}
    
    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_invoice.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=check&uid=$org_inv_uid'>");
    exit;




} else if($step_next == "permit_cart_del") {
	
	$result_D3 = mysql_query("DELETE FROM shop_payment_invoice_cart WHERE pay_num = '$del_pay_num'",$dbconn);
    if(!$result_D3) { error("QUERY_ERROR"); exit; }
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_invoice.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;



} else if($step_next == "permit_add") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";

	$m_ip = getenv('REMOTE_ADDR');
	

	// LOOPING
	$query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$add_pay_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
                p_price,p_saleprice,branch_code,gate,shop_code,currency FROM shop_cart WHERE pay_num = '$add_pay_num' ORDER BY pcode ASC";
    $result_H = mysql_query($query_H);
    if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
    $cart_no = 1;
    
    for($h = 0; $h < $total_HC; $h++) {
      $H_cart_uid = mysql_result($result_H,$h,0);
      $H_prd_uid = mysql_result($result_H,$h,1);
      $H_pcode = mysql_result($result_H,$h,2);
      $H_qty = mysql_result($result_H,$h,3);
      $H_p_color = mysql_result($result_H,$h,4);
      $H_p_size = mysql_result($result_H,$h,5);
      $H_p_opt1 = mysql_result($result_H,$h,6);
      $H_p_opt2 = mysql_result($result_H,$h,7);
      $H_p_opt3 = mysql_result($result_H,$h,8);
      $H_p_opt4 = mysql_result($result_H,$h,9);
      $H_p_opt5 = mysql_result($result_H,$h,10);
      $H_p_price = mysql_result($result_H,$h,11);
      $H_p_saleprice = mysql_result($result_H,$h,12);
	  $H_branch_code = mysql_result($result_H,$h,13);
	  $H_gate = mysql_result($result_H,$h,14);
	  $H_shop_code = mysql_result($result_H,$h,15);
	  $H_currency = mysql_result($result_H,$h,16);
      
      if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
      if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
      
		// Client Code
		$rm1_query = "SELECT client_code,name1 FROM shop_payment WHERE pay_num = '$add_pay_num'";
        $rm1_result = mysql_query($rm1_query);
			if (!$rm1_result) { error("QUERY_ERROR"); exit; }
        $H_client_code = @mysql_result($rm1_result,0,0);
		$H_client_name = @mysql_result($rm1_result,0,1);
      
		// Product Details
		$rm2_query = "SELECT uid,catg_code,gcode,pname,org_pcode,org_barcode,brand_code,unit FROM shop_product_list WHERE pcode = '$H_pcode'";
        $rm2_result = mysql_query($rm2_query);
			if (!$rm2_result) { error("QUERY_ERROR"); exit; }
        $H_org_uid = @mysql_result($rm2_result,0,0);
        $H_catg_code = @mysql_result($rm2_result,0,1);
        $H_gcode = @mysql_result($rm2_result,0,2);
		$H_pname = @mysql_result($rm2_result,0,3);
			$H_pname = stripslashes($H_pname);
		$H_org_pcode = @mysql_result($rm2_result,0,4);
		$H_org_barcode = @mysql_result($rm2_result,0,5);
		$H_brand_code = @mysql_result($rm2_result,0,6);
		$H_unit = @mysql_result($rm2_result,0,7);
		
		
      $query_dari = "SELECT uid,pname,price_sale FROM shop_product_list_shop WHERE pcode = '$H_pcode'";
      $result_dari = mysql_query($query_dari);
      if(!$result_dari) { error("QUERY_ERROR"); exit; }
      $row_dari = mysql_fetch_object($result_dari);

      $dari_uid = $row_dari->uid;
      $dari_pname = $row_dari->pname;
      $dari_price_sale = $row_dari->price_sale;
      
      // $dari_tprice_sale = $dari_price_sale * $H_qty;
      $dari_tprice_sale = $H_p_saleprice * $H_qty;
	  

		// Insert
		$query_F2 = "INSERT INTO shop_payment_invoice_cart (uid,branch_code,gate,shop_code,inv_no,inv_date,pay_num,client_code,
			catg_code,brand_code,pcode,org_pcode,org_barcode,pname,currency,p_unit_price,p_qty,p_unit,p_total_price) values ('',
			'$H_branch_code','$H_gate','$H_shop_code','','$post_dates','$add_pay_num','$H_client_code',
			'$H_catg_code','$H_brand_code','$H_pcode','$H_org_pcode','$H_org_barcode','$dari_pname','$H_currency',
			'$H_p_saleprice','$H_qty','$H_unit','$dari_tprice_sale')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }
	
		
	$cart_no++;
	}
  

    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_invoice.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;



} else if($step_next == "permit_order") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	$new_post_date_exp = explode("-",$new_post_dates);
	$new_post_dates2 = "$new_post_date_exp[0]"."$new_post_date_exp[1]"."$new_post_date_exp[2]"."$post_date2";
	
	$m_ip = getenv('REMOTE_ADDR');
	
	

		$query_P1 = "INSERT INTO shop_payment_invoice (uid,branch_code,gate,shop_code,inv_no,client_code,currency,inv_amount,inv_date,
			due_date,post_date,user_id,user_ip) values ('','$login_branch','$login_gate','$login_shop','$new_invoice_no',
			'$order_client_code','$order_currency','$order_total_sum','','$new_due_date','$post_dates','$login_id','$m_ip')";
		$result_P1 = mysql_query($query_P1);
		if (!$result_P1) { error("QUERY_ERROR"); exit; }
		
		// Looping (pay_num)
		
		$query_py = "SELECT count(uid) FROM shop_payment WHERE branch_code = '$login_branch' AND f_class = 'in' AND f_intype = '1' AND pay_state < '2'";
		$result_py = mysql_query($query_py);
		$total_py = mysql_result($result_py,0,0);
		
		
		$query_p = "SELECT pay_num FROM shop_payment 
					WHERE branch_code = '$login_branch' AND f_class = 'in' AND f_intype = '1' AND pay_state < '2' ORDER BY pay_date ASC";
		$result_p = mysql_query($query_p);

		for($i = 0; $i < $total_py; $i++) {
			$p_pay_num = mysql_result($result_p,$i,0);
		
			$result_P2 = mysql_query("UPDATE shop_payment_invoice_cart SET inv_no = '$new_invoice_no', due_date = '$new_due_date', 
					inv_date = '', pay_status = '1' WHERE pay_num = '$p_pay_num'",$dbconn);
			if(!$result_P2) { error("QUERY_ERROR"); exit; }
		
			$result_P3 = mysql_query("UPDATE shop_payment SET ins_check = '1', ins1_amount = '$order_total_sum', ins1_date = '$new_post_dates2' 
					WHERE pay_num = '$p_pay_num'",$dbconn);
			if(!$result_P3) { error("QUERY_ERROR"); exit; }
			
		}
		

    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_invoice.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;

}

}
?>