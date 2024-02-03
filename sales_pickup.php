<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "sales";
$smenu = "sales_pickup";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/sales_pickup.php?sorting_key=$sorting_key";
$link_upd = "$home/sales_pickup.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_act = "$home/sales_pickup_act.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
$sorting_filter = "do_status > '3'";


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "date_do_post"; }
// if($sorting_key == "date_do_post") {
  // $sort_now = "DESC";
// } else {
  $sort_now = "ASC";
// }

if($sorting_key == "date_do_check") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "date_do_done") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "do_status") { $chk3 = "selected"; } else { $chk3 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_list_do WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list_do WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_list_do WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_02_021?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='sales_pickup.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='date_do_post'>$txt_invn_stockout_36</option>
				<option value='date_do_check' $chk1>$txt_invn_stockout_37</option>
				<option value='date_do_done' $chk2>$txt_invn_stockout_38</option>
				<option value='do_status' $chk3>$txt_invn_stockout_39</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			<div class='col-sm-1'></div>
			</form>
			
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<div class='col-sm-2' align=right>$txt_comm_frm14 : </div>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=date_do_post&keyfield=$keyfield&key=$key'>$txt_invn_stockout_36</option>
			<option value='$PHP_SELF?sorting_key=date_do_check&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockout_37</option>
			<option value='$PHP_SELF?sorting_key=date_do_done&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockout_38</option>
			<option value='$PHP_SELF?sorting_key=do_status&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockout_39</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>SJ No.</th>
            <th>Qty</th>
            <th><?=$txt_invn_stockout_36?></th>
			<th><?=$txt_invn_stockout_37?></th>
			<th><?=$txt_invn_stockout_421?></th>
			<th><?=$txt_invn_stockout_431?></th>
			<th><?=$txt_invn_stockout_38?></th>
			
			<th bgcolor=#efefef><?=$txt_invn_stockout_393?></th>
			<th bgcolor=#efefef><?=$txt_invn_stockin_613?></th>
			<th bgcolor=#efefef><?=$txt_invn_stockin_614?></th>
			
			<th><?=$txt_invn_stockout_39?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,gudang_code,shop_code,do_num,do_qty,date_do_post,date_do_check,date_way_takeoff,date_way_arrival,date_do_done,
			do_status,do_cost,do_wait_avrg,do_wait FROM shop_product_list_do WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,gudang_code,shop_code,do_num,do_qty,date_do_post,date_do_check,date_way_takeoff,date_way_arrival,date_do_done,
			do_status,do_cost,do_wait_avrg,do_wait FROM shop_product_list_do 
			WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $do_uid = mysql_result($result,$i,0);   
   $do_gate = mysql_result($result,$i,1);
   $do_gudang_code = mysql_result($result,$i,2);
   $do_shop_code = mysql_result($result,$i,3);
   $do_num = mysql_result($result,$i,4);
   $do_qty = mysql_result($result,$i,5);
      $do_qty_K = number_format($pay_amount);
   $date_do_post = mysql_result($result,$i,6);
   $date_do_check = mysql_result($result,$i,7);
   $date_do_takeoff = mysql_result($result,$i,8);
   $date_do_arrival = mysql_result($result,$i,9);
   $date_do_done = mysql_result($result,$i,10);
   $do_status = mysql_result($result,$i,11);
   $do_cost = mysql_result($result,$i,12);
   $do_wait_avrg = mysql_result($result,$i,13);
   $do_wait = mysql_result($result,$i,14);
   
   
	$query_sum = "SELECT sum(stock) FROM shop_product_list_qty WHERE do_num = '$do_num'";
	$result_sum = mysql_query($query_sum);
			if (!$result_sum) {   error("QUERY_ERROR");   exit; }
    
	$qty_sum = @mysql_result($result_sum,0,0);
   
   
    // 영수증 유무
    
	
	
   
	// Dates
	$date1Y = substr($date_do_post,0,4);
	$date1m = substr($date_do_post,4,2);
	$date1d = substr($date_do_post,6,2);
	$date1H = substr($date_do_post,8,2);
	$date1i = substr($date_do_post,10,2);
	$time1 = "$date1H".":"."$date1i";
	
	if($date_do_post > 1) {
		if($lang == "ko") {
			$date_do_post_txt = "$date1Y"."/"."$date1m"."/"."$date1d";
		} else {
			$date_do_post_txt = "$date1d"."-"."$date1m"."-"."$date1Y";
		}
	} else {
			$date_do_post_txt = "<font color=red>x</font>";
	}
	
	$date2Y = substr($date_do_check,0,4);
	$date2m = substr($date_do_check,4,2);
	$date2d = substr($date_do_check,6,2);
	$date2H = substr($date_do_check,8,2);
	$date2i = substr($date_do_check,10,2);
	$time2 = "$date2H".":"."$date2i";
	
	if($date_do_check > 1) {
		if($lang == "ko") {
			$date_do_check_txt = "$date2m"."/"."$date2d".", $time2";
		} else {
			$date_do_check_txt = "$date2d"."-"."$date2m".", $time2";
		}
	} else {
			$date_do_check_txt = "<font color=red>x</font>";
	}
	
	
	$date3Y = substr($date_do_takeoff,0,4);
	$date3m = substr($date_do_takeoff,4,2);
	$date3d = substr($date_do_takeoff,6,2);
	$date3H = substr($date_do_takeoff,8,2);
	$date3i = substr($date_do_takeoff,10,2);
	$time3 = "$date3H".":"."$date3i";
	
	if($date_do_takeoff > 1) {
		if($lang == "ko") {
			$date_do_takeoff_txt = "$date3m"."/"."$date3d".", $time3";
		} else {
			$date_do_takeoff_txt = "$date3d"."-"."$date3m".", $time3";
		}
	} else {
			$date_do_takeoff_txt = "<font color=red>x</font>";
	}
	
	$date4Y = substr($date_do_arrival,0,4);
	$date4m = substr($date_do_arrival,4,2);
	$date4d = substr($date_do_arrival,6,2);
	$date4H = substr($date_do_arrival,8,2);
	$date4i = substr($date_do_arrival,10,2);
	$time4 = "$date4H".":"."$date4i";
	
	if($date_do_arrival > 1) {
		if($lang == "ko") {
			$date_do_arrival_txt = "$date4m"."/"."$date4d".", $time4";
		} else {
			$date_do_arrival_txt = "$date4d"."-"."$date4m".", $time4";
		}
	} else {
			$date_do_arrival_txt = "<font color=red>x</font>";
	}
	
	
	
	
	$date5Y = substr($date_do_done,0,4);
	$date5m = substr($date_do_done,4,2);
	$date5d = substr($date_do_done,6,2);
	$date5H = substr($date_do_done,8,2);
	$date5i = substr($date_do_done,10,2);
	$time5 = "$date5H".":"."$date5i";
	
	if($date_do_done > 1) {
		if($lang == "ko") {
			$date_do_done_txt = "$date5m"."/"."$date5d".", $time5";
		} else {
			$date_do_done_txt = "$date5d"."-"."$date5m".", $time5";
		}
	} else {
			$date_do_done_txt = "<font color=red>x</font>";
	}
	
	
		// Check
		$query_sum = "SELECT sum(stock_check),sum(stock_loss) FROM shop_product_list_qty WHERE do_num = '$do_num' AND flag = 'out' AND do_status > '0'";
		$result_sum = mysql_query($query_sum);
		if (!$result_sum) {   error("QUERY_ERROR");   exit; }
      
		$sum_qty_check = @mysql_result($result_sum,0,0);
			$sum_qty_check_K = number_format($sum_qty_check);
		$sum_qty_loss = @mysql_result($result_sum,0,1);
			$sum_qty_loss_K = number_format($sum_qty_loss);
	
		$query_sum2 = "SELECT count(stock) FROM shop_product_list_qty WHERE do_num = '$do_num' AND flag = 'out' AND do_status < '5'";
		$result_sum2 = mysql_query($query_sum2);
		if (!$result_sum2) {   error("QUERY_ERROR");   exit; }
      
		$count_qty_uncheck = @mysql_result($result_sum2,0,0);
	
	
	
	
   

    // 줄 색깔
    if($uid == $do_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    


  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$do_uid'>{$do_num}</a></td>");
  echo("<td bgcolor='$highlight_color' align=right><a href='$link_upd&mode=check&uid=$do_uid'>{$qty_sum}</a></td>");

  echo("<td bgcolor='$highlight_color'>$date_do_post_txt</td>");
  echo("<td bgcolor='$highlight_color'>$date_do_check_txt</td>");
  echo("<td bgcolor='$highlight_color'>$date_do_takeoff_txt</td>"); // take-off
  echo("<td bgcolor='$highlight_color'>$date_do_arrival_txt</td>"); // arrival
  echo("<td bgcolor='$highlight_color'>$date_do_done_txt</td>");
  echo("<td bgcolor='$highlight_color' align=right>$sum_qty_check_K</td>");
  echo("<td bgcolor='$highlight_color' align=right>$sum_qty_loss_K</td>");
  echo("<td bgcolor='$highlight_color'></td>");
  
  echo("
  <td bgcolor='$highlight_color'>
  
		<div class='btn-group'>
			<button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>Go <span class='caret'></span></button>
            <ul role='menu' class='dropdown-menu' style='margin-left: -80px'>");
				
					echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-check'></i> $txt_invn_stockout_37</a></font></li>");
					echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-location-arrow'></i> $txt_invn_stockout_421</a></font></li>");
					echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-bullhorn'></i> $txt_invn_stockout_431</a></font></li>");
					
					if($date_do_done > 1 OR $count_qty_uncheck > 0) {
						echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-check-square-o'></i> $txt_invn_stockout_393</a></font></li>");
					} else {
						echo ("<li><a href='$link_act&act_mode=stage5&uid=$do_uid'><i class='fa fa-check-square-o'></i> $txt_invn_stockout_393</a></li>");
					}
					
					echo ("<li class='divider'></li>");
				
				echo ("
                <li><a href='inventory_delivery_print.php?P_uid=$do_uid' target='_blank'><i class='fa fa-print'></i> Print SJ</a></li>
            </ul>
		</div>
  
  
  </td>");
  echo("</tr>");
  
  if($mode == "check" AND $do_uid == $uid) {
  
    // 상세 리스트
    $query_HC = "SELECT count(uid) FROM shop_product_list_qty WHERE do_num = '$do_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
	
	$query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,date,pcode,
				branch_code2,gudang_code2,shop_code2,sx_num,check_date,stock_check,stock_loss,stock_org,loss_type,memo,do_status 
				FROM shop_product_list_qty WHERE do_num = '$do_num' ORDER BY date ASC";
    $result_qs2 = mysql_query($query_qs2,$dbconn);
    if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

    for($qs = 0; $qs < $total_HC; $qs++) {
          $qs_uid = mysql_result($result_qs2,$qs,0);
          $qs_stock = mysql_result($result_qs2,$qs,1);
          $qs_date = mysql_result($result_qs2,$qs,2);
          $qs_flag = mysql_result($result_qs2,$qs,3);
          $qs_pay_num = mysql_result($result_qs2,$qs,4);
          $qs_gudang_code = mysql_result($result_qs2,$qs,5);
          $qs_supp_code = mysql_result($result_qs2,$qs,6);
          $qs_shop_code = mysql_result($result_qs2,$qs,7);
          $qs_org_uid = mysql_result($result_qs2,$qs,8);
          $qs_date = mysql_result($result_qs2,$qs,9);
		  $qs_pcode = mysql_result($result_qs2,$qs,10);
			$qs_branch_code2 = mysql_result($result_qs2,$qs,11);
			$qs_gudang_code2 = mysql_result($result_qs2,$qs,12);
			$qs_shop_code2 = mysql_result($result_qs2,$qs,13);
			$qs_sx_num = mysql_result($result_qs2,$qs,14);
			$qs_check_date = mysql_result($result_qs2,$qs,15);
			$qs_stock_check = mysql_result($result_qs2,$qs,16);
				$qs_stock_check_K = number_format($qs_stock_check);
			$qs_stock_loss = mysql_result($result_qs2,$qs,17);
				$qs_stock_loss_K = number_format($qs_stock_loss);
			$qs_stock_org = mysql_result($result_qs2,$qs,18);
			$qs_stock_loss_type = mysql_result($result_qs2,$qs,19);
			$qs_stock_memo = mysql_result($result_qs2,$qs,20);
			$qs_do_status = mysql_result($result_qs2,$qs,21);
			
			if($qs_stock_loss > 0) { // original stock from delivery team -- IMPORTANT!
				$qs_stock1 = $qs_stock_org;
			} else {
				$qs_stock1 = $qs_stock;
			}
			$qs_stock1_K = number_format($qs_stock1);
			
			if($qs_do_status < 5 AND $qs_check_date < 1) {
				$qs_stock2 = $qs_stock;
			} else {
				$qs_stock2 = $qs_stock_check;
			}
   
	
	// 도착지 정보
	if($qs_branch_code2 != "" AND $qs_branch_code2 != $login_branch) {
		$dest_branch_txt = "$qs_branch_code2"." &gt; ";
		$dest_shop_txt = $qs_shop_code2;
	} else {
		$dest_branch_txt = "";
		$dest_shop_txt = $qs_shop_code;
	}
	if($qs_gudang_code2 != "" AND $qs_gudang_code2 != $qs_gudang_code) {
		$dest_gudang_txt = "$qs_gudang_code2"." &gt; ";
	} else {
		$dest_gudang_txt = "";
	}
	
	if($qs_sx_num != "") {
		$qs_sx_num_txt = "<font color=red>+ SX</font>";
	} else {
		$qs_sx_num_txt = "";
	}
	
	
          
          $qday1 = substr($qs_date,0,4);
	        $qday2 = substr($qs_date,4,2);
	        $qday3 = substr($qs_date,6,2);
	        $qday4 = substr($qs_date,8,2);
	        $qday5 = substr($qs_date,10,2);
	        $qday6 = substr($qs_date,12,2);
		

          if($lang == "ko") {
	          $qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3".", "."$qday4".":"."$qday5".":"."$qday6";
	        } else {
	          $qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1".", "."$qday4".":"."$qday5".":"."$qday6";
	        }
      
      
      
		// 상품 정보 추출
		$query_dari = "SELECT uid,pname,product_option1,product_option2,product_option3,product_option4,product_option5,
			price_orgin,dc_rate,save_point FROM shop_product_list WHERE pcode = '$qs_pcode'";
		$result_dari = mysql_query($query_dari);
		if(!$result_dari) { error("QUERY_ERROR"); exit; }
		$row_dari = mysql_fetch_object($result_dari);

		$dari_uid = $row_dari->uid;
		$dari_pname = $row_dari->pname;
		$dari_product_option1 = $row_dari->product_option1;
		$dari_product_option2 = $row_dari->product_option2;
		$dari_product_option3 = $row_dari->product_option3;
		$dari_product_option4 = $row_dari->product_option4;
		$dari_product_option5 = $row_dari->product_option5;
		$prd_price_orgin = $row_dari->price_orgin;
			$prd_price_orgin_K = number_format($prd_price_orgin);
		$prd_dc_rate = $row_dari->dc_rate;
		$prd_save_point = $row_dari->save_point;
		
		if($dari_product_option1 != "") { $dari_product_option1_txt = "[$dari_product_option1]"; } else { $dari_product_option1_txt = ""; }
		if($dari_product_option2 != "") { $dari_product_option2_txt = "[$dari_product_option2]"; } else { $dari_product_option2_txt = ""; }
		if($dari_product_option3 != "") { $dari_product_option3_txt = "[$dari_product_option3]"; } else { $dari_product_option3_txt = ""; }
		if($dari_product_option4 != "") { $dari_product_option4_txt = "[$dari_product_option4]"; } else { $dari_product_option4_txt = ""; }
		if($dari_product_option5 != "") { $dari_product_option5_txt = "[$dari_product_option5]"; } else { $dari_product_option5_txt = ""; }
      
      
		echo ("
		<form name='signform' method='post' action='sales_pickup.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_key' value='$sorting_key'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='page' value='$page'>
		<input type='hidden' name='uid' value='$do_uid'>
		<input type='hidden' name='do_num' value='$do_num'>
		<input type='hidden' name='new_qs_uid' value='$qs_uid'>
		<input type='hidden' name='stock_from' value='$qs_stock'>
					
        <tr>
			<td align=right><i class='fa fa-caret-right'></i></td>
			
            <td align=right>$qs_stock1_K</td>
			<td colspan=3>$qs_pcode {$dari_pname} {$dari_product_option1_txt}{$dari_product_option2_txt}</td>
            <td>{$dest_branch_txt}{$dest_gudang_txt}{$dest_shop_txt} {$prd_sx_num_txt}</td>
			<td></td>");
						
			if($qs_check_date > 0) {
				echo ("<td align=right>
					<span class='form-group has-success'>
					<input type='text' class='form-control' id='inputSuccess' name='stock_check' value='$qs_stock_check' style='width: 90px; height: 23px; text-align: right; font-size: 1.0em'>
					</span>
				</td>");
			} else {
				echo ("<td align=right>
					<input type='text' class='form-control' name='stock_check' value='$qs_stock' style='width: 90px; height: 23px; text-align: right; font-size: 1.0em'>
				</td>");
			}
			
			echo ("
			<td align=right>$qs_stock_loss_K</td>
			<td>
				<select class='form-control' name='stock_loss_type' style='padding: 3px; width: 100px; height: 23px; font-size: 0.85em'>
				<option value=\"\">$txt_comm_frm19</option>");
				if($qs_stock_loss_type == "1") { echo ("
				<option value='1' selected>$txt_invn_stockin_6131</option>"); } else { echo ("<option value='1'>$txt_invn_stockin_6131</option>"); }
				if($qs_stock_loss_type == "2") { echo ("
				<option value='2' selected>$txt_invn_stockin_6132</option>"); } else { echo ("<option value='2'>$txt_invn_stockin_6132</option>"); }
				if($qs_stock_loss_type == "3") { echo ("
				<option value='3' selected>$txt_invn_stockin_6133</option>"); } else { echo ("<option value='3'>$txt_invn_stockin_6133</option>"); }
				if($qs_stock_loss_type == "4") { echo ("
				<option value='4' selected>$txt_invn_stockin_6134</option>"); } else { echo ("<option value='4'>$txt_invn_stockin_6134</option>"); }
				if($qs_stock_loss_type == "5") { echo ("
				<option value='5' selected>$txt_invn_stockin_6135</option>"); } else { echo ("<option value='5'>$txt_invn_stockin_6135</option>"); }
				echo ("
				</select>
			
			</td>
			<td><input type='submit' class='btn btn-default btn-xs' value='$txt_comm_frm02'></td>
        </form>");
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
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
    $post_date1d = date("ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
	
	$stock_memo = addslashes($stock_memo);
	$new_stock_loss = $stock_from - $stock_check;
	
	
	$result_CHG1 = mysql_query("UPDATE shop_product_list_qty SET stock_check = '$stock_check', stock_loss = '$new_stock_loss', 
					stock_org = '$stock_from', loss_type = '$stock_loss_type', do_status = '5', check_date = '$post_dates' WHERE uid = '$new_qs_uid'",$dbconn);
	if(!$result_CHG1) { error("QUERY_ERROR"); exit; }
  
  
  

    echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_pickup.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=check&do_num=$do_num&uid=$uid'>");
    exit;
 
}

}
?>