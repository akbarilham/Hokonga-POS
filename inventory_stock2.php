<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "purchase";
$smenu = "inventory_stock2";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_stock2.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_stock2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_act = "$home/inventory_stock2_act.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
	
	<script language="javascript">
	function Popup_Win(ref) {
		var window_left = 0;
		var window_top = 0;
		ref = ref;      
		window.open(ref,"printpreWin",'width=810,height=650,status=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
$signdate_now = time();
$now_date1 = date("Ymd",$signdate_now);
$now_date2 = date("His",$signdate_now);
  
  
// Filtering
$sorting_filter = "f_class = 'out' AND do_status < '3'";

if(!$sorting_key) { $sorting_key = "po_num"; }
if($sorting_key == "order_date" OR $sorting_key == "po_num") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "client_code") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "order_date") { $chk4 = "selected"; } else { $chk4 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_purchase WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);

// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM shop_purchase WHERE $sorting_filter";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM shop_purchase WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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


// 장바구니에 담긴 상품 수
$query_HC = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);
?>
    

						
		<!--body wrapper start-->
        <div class="wrapper">
		<? include "navbar_inventory_purchase.inc"; ?>
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_07?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_stock2.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='po_num'>$txt_invn_purchase_06s</option>
				<option value='client_code' $chk3>$txt_stf_member_55</option>
				<option value='order_date' $chk4>$txt_invn_purchase_08</option>
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
			<option value='$PHP_SELF?sorting_key=po_num&key=$key&keyfield=$keyfield'>$txt_invn_purchase_06s</option>
			<option value='$PHP_SELF?sorting_key=client_code&key=$key&keyfield=$keyfield' $chk3>$txt_stf_member_55</option>
			<option value='$PHP_SELF?sorting_key=order_date&key=$key&keyfield=$keyfield' $chk4>$txt_invn_purchase_08</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
		
		

		
		
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>No.</th>
            <th><?=$txt_sys_supplier_14?></th>
            <th><?=$txt_invn_purchase_06?></th>
			<th><?=$txt_invn_purchase_08s?></th>
			<th colspan=4><?=$txt_invn_stockin_61?></th>
			<th><?=$txt_invn_stockin_60?></th>
			
			
			<th colspan=2><?=$txt_invn_stockout_39?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
			<td><?=$txt_invn_stockin_611?></td>
			<td><?=$txt_invn_stockin_612?></td>
			<td><?=$txt_invn_stockin_613?></td>
			<td><?=$txt_invn_stockin_614?></td>
			
			<td></td>
			<td colspan=2></td>
		</tr>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status,check_status,check_date
    FROM shop_purchase WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status,check_status,check_date
    FROM shop_purchase WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $li_uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
   $client_code = mysql_result($result,$i,2);
   $manager_code = mysql_result($result,$i,3);
   $po_num = mysql_result($result,$i,4);
   $po_qty = mysql_result($result,$i,5);
		$po_qty_K = number_format($po_qty);
   $po_tamount = mysql_result($result,$i,6);
   $po_products = mysql_result($result,$i,7);
   $order_date = mysql_result($result,$i,8);
   $li_currency = mysql_result($result,$i,9);
   $order_status = mysql_result($result,$i,10);
   $do_status = mysql_result($result,$i,11);
   $pay_status = mysql_result($result,$i,12);
   $check_status = mysql_result($result,$i,13);
   $check_date = mysql_result($result,$i,14);
   
		$chkday1 = substr($check_date,0,4);
		$chkday2 = substr($check_date,4,2);
		$chkday3 = substr($check_date,6,2);
		
		if($check_status > 0) {
			if($lang == "ko") {
				$check_date_txt = "$chkday1"."/"."$chkday2"."/"."$chkday3";
			} else {
				$check_date_txt = "$chkday3"."-"."$chkday2"."-"."$chkday1";
			}
		} else {
				$check_date_txt = "";
		}
		
   
		$query_dtc = "SELECT count(uid) FROM shop_cart WHERE order_num = '$po_num' AND f_class = 'out' AND expire = '1' AND check_status = '0'";
		$result_dtc = mysql_query($query_dtc);
		if (!$result_dtc) {   error("QUERY_ERROR");   exit; }
      
		$miss_check_cnt = @mysql_result($result_dtc,0,0); // 미확인 자료 개수
		
		if($miss_check_cnt > 0) {
				$total_uncheck_txt = "<font color=red><i class='fa fa-warning'></i> $miss_check_cnt</font>";
		} else {
			if($check_status > 0) {
				$total_uncheck_txt = "<font color=#006699>$txt_invn_stockin_62</font>";
			} else {
				$total_uncheck_txt = "$txt_invn_stockout_39";
			}
		}
		
		$query_sum = "SELECT sum(qty_check),sum(qty_loss) FROM shop_cart WHERE order_num = '$po_num' AND f_class = 'out' AND expire = '1' AND check_status > '0'";
		$result_sum = mysql_query($query_sum);
		if (!$result_sum) {   error("QUERY_ERROR");   exit; }
      
		$sum_qty_check = @mysql_result($result_sum,0,0);
			$sum_qty_check_K = number_format($sum_qty_check);
		$sum_qty_loss = @mysql_result($result_sum,0,1);
			$sum_qty_loss_K = number_format($sum_qty_loss);
			$sum_qty_loss2 = abs($sum_qty_loss); // Remove Minus
			$sum_qty_loss2_K = number_format($sum_qty_loss2);
		
		if($sum_qty_loss > 0) {
			$sum_qty_loss_txt = "<font color=red>- "."$sum_qty_loss_K"."</font>";
		} else if($sum_qty_loss < 0) {
			$sum_qty_loss_txt = "<font color=blue>+ "."$sum_qty_loss2_K"."</font>";
		} else {
			$sum_qty_loss_txt = "$sum_qty_loss_K";
		}
	
	
   

   // Order Status
   // 1: 주문 상태
   // 2: 주문 슨인
   // 3: PO 발송 완료
   
   // DO Status
   // 0: 미수령
   // 1: 수령 대기
   // 2: 수령 확인 - 입고 가능 샅태
   // 3: 입고 완료
   
   
   
   
   
   
   
   
	if($li_currency == "USD") {
		$po_tamount_K = number_format($po_tamount,2);
	} else {
		$po_tamount_K = number_format($po_tamount);
	}
   
   // Order Date
   $order_date1 = substr($order_date,0,8);

  
  // 발주일
  $uday1 = substr($order_date,0,4);
	$uday2 = substr($order_date,4,2);
	$uday3 = substr($order_date,6,2);

  if($lang == "ko") {
	  $order_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	} else {
	  $order_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	}
  

   // 3일이 지나면 경고
   $date_diffs = $now_date1 - $order_date1;
   
      
   if($pay_status < 2 AND $do_status < 1 AND $date_diffs > 3) {
	$date_diff_warning = "<span class='label label-danger'>Expire</span>";
   } else {
    $date_diff_warning = "";
   }
   
   if($uid == $li_uid AND $mode == "view") {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }
   

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>$client_code</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_list&mode=view&now_po_num=$po_num&uid=$li_uid&page=$page'>$po_num</a></td>");
  echo("<td bgcolor='$highlight_color'>$order_date_txt</td>");
   
  echo("<td bgcolor='$highlight_color' align=right>$po_qty_K</td>");
  echo("<td bgcolor='$highlight_color' align=right>$sum_qty_check_K</td>");
  echo("<td bgcolor='$highlight_color' align=right>$sum_qty_loss_txt</td>");
  echo("<td bgcolor='$highlight_color'>$total_uncheck_txt</td>");
  
  echo("<td bgcolor='$highlight_color'>$check_date_txt</td>");
  
  
  
  
  
  
  echo("<td bgcolor='$highlight_color'>
 
		<div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>Go <span class='caret'></span></button>
            <ul role='menu' class='dropdown-menu' style='margin-left: -80px'>");
					if($check_status > 1) {
							echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-check'></i> $txt_invn_stockin_62</a></font></li>");
					} else {
						if($miss_check_cnt > 0) {
							echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-check'></i> $txt_invn_stockin_63</a></font></li>");
						} else {
							echo ("<li><a href='$link_act&act_mode=check&uid=$li_uid'><i class='fa fa-check'></i> $txt_invn_stockin_63</a></li>");
						}
					}
					echo ("
            </ul>
        </div>
  
  </td>");
  
  
  if($pay_status > 1) {
	echo("<td bgcolor='$highlight_color'><i class='fa fa-money'></i></td>");
  } else {
	echo("<td bgcolor='$highlight_color'></td>");
  }
  
  echo("</tr>");
  
  
			if($mode == "view" AND $now_po_num == $po_num) {
			
			$query_HCc = "SELECT count(uid) FROM shop_cart WHERE order_num = '$now_po_num' AND f_class = 'out' AND expire = '1'";
			$result_HCc = mysql_query($query_HCc);
			if (!$result_HCc) {   error("QUERY_ERROR");   exit; }
    
			$total_HCc = @mysql_result($result_HCc,0,0);
  
				$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,qty_check,qty_loss,qty_diff_org,memo,
							check_status,check_date,org_pcode FROM shop_cart 
							WHERE order_num = '$now_po_num' AND f_class = 'out' AND expire = '1' ORDER BY date ASC";
				$result_H = mysql_query($query_H);
				if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
				$H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
    
				$cart_no = 1;
    
				for($h = 0; $h < $total_HCc; $h++) {
					$H_cart_uid = mysql_result($result_H,$h,0);
					$H_prd_uid = mysql_result($result_H,$h,1);
					$H_pcode = mysql_result($result_H,$h,2);
					$H_qty = mysql_result($result_H,$h,3);
						$total_qty = $total_qty + $H_qty;
						$H_qty_K = number_format($H_qty);
					$H_p_color = mysql_result($result_H,$h,4);
					$H_p_size = mysql_result($result_H,$h,5);
					$H_p_opt1 = mysql_result($result_H,$h,6);
					$H_p_opt2 = mysql_result($result_H,$h,7);
					$H_p_opt3 = mysql_result($result_H,$h,8);
					$H_p_opt4 = mysql_result($result_H,$h,9);
					$H_p_opt5 = mysql_result($result_H,$h,10);
					$H_pname = mysql_result($result_H,$h,11);
					$H_p_price = mysql_result($result_H,$h,12);
					$H_unpack_qty = mysql_result($result_H,$h,13);
					$H_unpack_unit_qty = mysql_result($result_H,$h,14);
					$H_unpack_unit_name = mysql_result($result_H,$h,15);
					$H_qty_check = mysql_result($result_H,$h,16);
					$H_qty_loss = mysql_result($result_H,$h,17);
						$H_qty_loss_K = number_format($H_qty_loss);
						$H_qty_loss2 = abs($H_qty_loss); // Remove Minus
						$H_qty_loss2_K = number_format($H_qty_loss2);
						
						if($H_qty_loss > 0) {
							$H_qty_loss_txt = "<font color=red>- "."$H_qty_loss_K"."</font>";
						} else if($H_qty_loss < 0) {
							$H_qty_loss_txt = "<font color=blue>+ "."$H_qty_loss2_K"."</font>";
						} else {
							$H_qty_loss_txt = "$H_qty_loss_K";
						}
		
					$H_qty_diff = mysql_result($result_H,$h,18);
						$H_qty_diff_K = number_format($H_qty_diff);
					$H_qty_memo = mysql_result($result_H,$h,19);
					$H_check_status = mysql_result($result_H,$h,20);
					$H_check_date = mysql_result($result_H,$h,21);
					$H_org_pcode = mysql_result($result_H,$h,22);
					
					// if($H_check_status < 1 AND $H_qty_check < 1) {
					if($H_check_status < 1) {
						$H_qty_check = $H_qty;
					}
					
      
					if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
					if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
					if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
					if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
					if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
					if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
					if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
					$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
      
      
					// 상품명, 상품별 결제액
					$query_dari = "SELECT uid,pname,price_orgin,tprice_orgin,stock_now,stock_sell FROM shop_product_list WHERE uid = '$H_prd_uid'";
					$result_dari = mysql_query($query_dari);
					if(!$result_dari) { error("QUERY_ERROR"); exit; }
					$row_dari = mysql_fetch_object($result_dari);

					$dari_uid = $row_dari->uid;
					if($H_pcode == "") {
						$dari_pname = $H_pname;
					} else {
						$dari_pname = $row_dari->pname;
					}
        
					if($H_pcode == "") {
						$dari_amount = $H_p_price;
					} else {
						$dari_amount = $row_dari->price_orgin;
					}
					
					// by Product Unit
					if($H_unpack_qty > 0) {
						if($H_pcode != "") {
							$H2_qty = $H_unpack_qty;
							$dari_amount2 = $dari_amount * $H_unpack_unit_qty;
						} else {
							$H2_qty = $H_unpack_qty;
							$dari_amount2 = $dari_amount;
						}
					} else {
							$H2_qty = $H_qty;
							$dari_amount2 = $dari_amount;
					}
		
		
					if($li_currency == "USD") {
						$dari_amount2R = $dari_amount2 / $now_xchange_rate;
					} else {
						$dari_amount2R = $dari_amount2;
					}
					if($li_currency == "USD") {
						$dari_amount2R_K = number_format($dari_amount2R,2);
					} else {
						$dari_amount2R_K = number_format($dari_amount2R);
					}
		
		
					$dari_tamount = $dari_amount2R * $H2_qty;
		
					if($li_currency == "USD") {
						$dari_tamount_K = number_format($dari_tamount,2);
					} else {
						$dari_tamount_K = number_format($dari_tamount);
					}
			
					$dari_stock_now = $row_dari->stock_now;
						$qty_max = $dari_stock_now + $H_qty; // 재고와 카트의 주문수량의 합 (주문 가능한 수량의 최대값)
					$dari_stock_sell = $row_dari->stock_sell;
					$qty_sold = $dari_stock_sell - $H_qty; // 판매량에서 카트의 주문수량을 공제 (본래의 판매량)
        
					// 합계
					$p_total_price = $p_total_price + $dari_tamount;
					if($li_currency == "USD") {
						$p_total_price_K = number_format($p_total_price,2);
					} else {
						$p_total_price_K = number_format($p_total_price);
					}
					
					if($H_unpack_unit_name == 0) {
						$H_unpack_unit_name = "";
					}
		
      
					echo ("
					<form name='signform' method='post' action='inventory_stock2.php'>
					<input type='hidden' name='step_next' value='permit_okay'>
					<input type='hidden' name='sorting_key' value='$sorting_key'>
					<input type='hidden' name='keyfield' value='$keyfield'>
					<input type='hidden' name='key' value='$key'>
					<input type='hidden' name='page' value='$page'>
					<input type='hidden' name='now_po_num' value='$now_po_num'>
					<input type='hidden' name='uid' value='$li_uid'>
					<input type='hidden' name='new_cart_uid' value='$H_cart_uid'>
					<input type='hidden' name='org_qty[]' value='$H_qty'>
					<input type='hidden' name='org_pcode[]' value='$H_org_pcode'>
					
					
					<tr>
						<td></td>
						<td colspan=2>
							$dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}
						</td>
						<td></td>
						<td align=right>$H_qty_K</td>");
						
						if($H_check_status > 0) {
							echo ("<td align=right>
								<span class='form-group has-success'>
								<input type='text' class='form-control' id='inputSuccess' name='qty_check[]' value='$H_qty_check' style='width: 90px; height: 23px; text-align: right; font-size: 1.0em'>
								</span>
							</td>");
						} else {
							echo ("<td align=right>
								<input type='text' class='form-control' name='qty_check[]' value='$H_qty_check' style='width: 90px; height: 23px; text-align: right; font-size: 1.0em'>
							</td>");
						}
						
						echo ("
						<td align=right>$H_qty_loss_txt</td>
						<td><input type='text' class='form-control' name='qty_memo[]' value='$H_qty_memo' style='width: 100px; height: 23px; font-size: 1.0em'></td>
						<td>$H_unpack_unit_name</td>
						<td colspan=2>Not submitted</td>
					</tr>");
      
				$cart_no++;
				}?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
  					<td align="right" colspan="6"><input type='submit' name="pycheck" class='btn btn-primary' value="Submit All"></td>
  				</tr>
  				</form>
  			<?
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
	
	<script src="js/jquery.donutchart.js"></script>
	
	<script>
	(function () {

        $("#donutchart1").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart2").donutchart("animate");

        $("#donutchart3").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart3").donutchart("animate");

        $("#donutchart4").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");
		
		$("#donutchart6").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart6").donutchart("animate");
		
		$("#donutchart7").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart7").donutchart("animate");

    }());
	</script>


  </body>
</html>


<?
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
    $post_date1d = date("ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";

  $total_qtycheck = count($qty_check);

  for ($i=0; $i < $total_qtycheck; $i++) { 

  	$new_org_qty = $qty_org[$i];
	$new_qty_memo = $qty_memo[$i];
	$new_qty_check = $qty_check[$i];
	$new_org_pcode = $org_pcode[$i];
	$new_qty_diff = $new_org_qty - $new_qty_check;
	
	$result_CHG1 = mysql_query("UPDATE shop_cart SET qty_check = '$new_qty_check', qty_final = '$new_qty_check', qty_loss = '$new_qty_diff', memo = '$new_qty_memo', check_status = '1', check_date = '$post_dates' WHERE org_pcode = '$new_org_pcode' AND order_num = '$now_po_num' ",$dbconn);
	if(!$result_CHG1) { error("QUERY_ERROR"); exit; }

  }


	echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=view&now_po_num=$now_po_num&uid=$uid'>");
    exit;


}

}
?>