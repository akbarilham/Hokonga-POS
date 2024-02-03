<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "purchase";
$smenu = "inventory_purchase3";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_purchase3.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_purchase3.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_list2 = "$home/inventory_purchase2.php?sorting_key=$sorting_key";

$link_act = "$home/inventory_purchase3_act.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
// $sorting_filter = "branch_code = '$login_gate' AND do_status > '2' AND check_status > '0'";
$sorting_filter = "f_class = 'out' AND do_status > '2' AND check_status > '0'";

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
            <?=$hsm_name_04_072?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_purchase3.php'>
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
			
		
		
		<form name='signform' class="form-horizontal" method='post' action='inventory_purchase3.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>No.</th>
            <th><?=$txt_sys_supplier_14?></th>
            <th><?=$txt_invn_purchase_06?></th>
			<th colspan=2>Q'ty</th>
			<th><?=$txt_invn_purchase_07?></th>
			<th><?=$txt_invn_stockin_60?></th>
			<th colspan=2><?=$txt_invn_stockout_39?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			
			<td><?=$txt_invn_stockin_611?></td>
			<td><?=$txt_invn_stockin_612?></td>
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
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
   
	// Supplier Name
	$query_supp = "SELECT supp_name FROM client_supplier WHERE supp_code = '$client_code'";
	$result_supp = mysql_query($query_supp);
   
	$supp_name = @mysql_result($result_supp,0,0);
		$supp_name = stripslashes($supp_name);
   
  
   
		$chkday1 = substr($check_date,0,4);
		$chkday2 = substr($check_date,4,2);
		$chkday3 = substr($check_date,6,2);
		
		
			if($lang == "ko") {
				$check_date_txt = "$chkday1"."/"."$chkday2"."/"."$chkday3";
			} else {
				$check_date_txt = "$chkday3"."-"."$chkday2"."-"."$chkday1";
			}
		
		// Get Total Qty Check and Qty Loss
		$query_sum = "SELECT sum(qty_check),sum(qty_loss) FROM shop_cart WHERE order_num = '$po_num' AND f_class = 'out' AND expire = '1' AND check_status > '0'";
		$result_sum = mysql_query($query_sum);
		if (!$result_sum) {   error("QUERY_ERROR");   exit; }
      
		$sum_qty_check = @mysql_result($result_sum,0,0);
			$sum_qty_check_K = number_format($sum_qty_check);
		$sum_qty_loss = @mysql_result($result_sum,0,1);
			$sum_qty_loss_K = number_format($sum_qty_loss);
			
   
	// Uncompleted Stock-input
	$query_ucp = "SELECT count(uid) FROM shop_cart WHERE order_num = '$po_num' AND f_class = 'out' AND expire = '1' AND do_status < '3'";
	$result_ucp = mysql_query($query_ucp);
			if (!$result_ucp) {   error("QUERY_ERROR");   exit; }
    
	$total_unpick = @mysql_result($result_ucp,0,0);
	
	if($total_unpick > 0) {
		$total_unpick_txt = "&nbsp; <font color=red><i class='fa fa-warning'></i> $total_unpick</font>";
	} else {
		$total_unpick_txt = " ";
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
	
   if($uid == $li_uid AND $mode == "view") {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }
  


  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'><a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='$supp_name'>$client_code</a></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_list&mode=view&now_po_num=$po_num&uid=$li_uid'>$po_num</a> $total_unpick_txt</td>");
   
  echo("<td bgcolor='$highlight_color' align=right>$po_qty_K</td>");
  echo("<td bgcolor='$highlight_color' align=right><font color=#000>$sum_qty_check_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color=#000>$li_currency $po_tamount_K</font></td>");
  echo("<td bgcolor='$highlight_color'>$check_date_txt</td>");
  
  // Check
  
  
  
  
  echo("<td bgcolor='$highlight_color'>
 
		<div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>Go <span class='caret'></span></button>
            <ul role='menu' class='dropdown-menu' style='margin-left: -80px'>
					<li><a href='#'><font color=#AAAAAA><i class='fa fa-gavel'></i> $txt_invn_stockin_48</a></font></li>
					<li class='divider'></li>
					<li><a href='inventory_purchase_print.php?P_uid=$li_uid' target='_blank'><i class='fa fa-print'></i> $txt_invn_stockin_50</a></li>
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
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,do_status,qty_check,qty_loss,qty_diff_org,memo,
							check_status, check_date FROM shop_cart 
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
					$H_do_status = mysql_result($result_H,$h,16);
					$H_qty_check = mysql_result($result_H,$h,17);
						$H_qty_check_K = number_format($H_qty_check);
					$H_qty_loss = mysql_result($result_H,$h,18);
						$H_qty_loss_K = number_format($H_qty_loss);
					$H_qty_diff = mysql_result($result_H,$h,19);
						$H_qty_diff_K = number_format($H_qty_diff);
					$H_qty_memo = mysql_result($result_H,$h,20);
					$H_check_status = mysql_result($result_H,$h,21);
					$H_check_date = mysql_result($result_H,$h,22);
      
					if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
					if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
					if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
					if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
					if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
					if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
					if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
					$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
      
      
					// 상품명, 상품별 결제액
					$query_dari = "SELECT uid,pname,price_orgin,tprice_orgin,stock_now,stock_sell,org_pcode FROM shop_product_list WHERE uid = '$H_prd_uid'";
					$result_dari = mysql_query($query_dari);
					if(!$result_dari) { error("QUERY_ERROR"); exit; }
					$row_dari = mysql_fetch_object($result_dari);

					$dari_uid = $row_dari->uid;
					$dari_org_pcode = $row_dari->org_pcode;
					
					if($H_pcode == "") {
						$dari_pname = $H_pname;
					} else {
						$dari_pname = $row_dari->pname;
					}
        
					if($H_pcode == "" OR $H_p_price > 0) {
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
		
		
					$dari_tamount = $dari_amount2R * $H_qty_check; // Changed
		
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
					<tr>
						<td></td>
						<td colspan=2>");
														
							if($H_do_status < 3) {
								echo ("
								<a href='$link_list&mode=view&now_po_num=$po_num&uid=$li_uid&cart_uid=$H_cart_uid'>[$dari_org_pcode] $dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a> &nbsp; 
								<font color=red><i class='fa fa-warning'></i></font>");
							} else {
								echo ("[$dari_org_pcode] $dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}");
							}
							
							echo ("
						</td>
						<!--<td class='text-center'><strong>$dari_amount_K</strong></td>-->
						<td align=right>$H_qty_K</td>
						<td align=right><font color=#000>$H_qty_check_K</font></td>
						<td align=right>$li_currency $dari_tamount_K</td>
						<td>$H_unpack_unit_name</td>
						<td colspan=2></td>
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
		
		
				<a href="<?=$link_list2?>"><input type="button" value="<?=$hsm_name_04_071?>" class="btn btn-primary"></a>
			
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
		// PO Currency
		if(!$po_currency) {
			$po_currency = "IDR";
		}
		
		if($po_currency == "USD") {
			$po_currency_IDR_chk = "";
			$po_currency_USD_chk = "checked";
		} else {
			$po_currency_IDR_chk = "checked";
			$po_currency_USD_chk = "";
		}
		
		
		// Form
		if($mode == "view" AND $uid AND $cart_uid) {
		
		
		  $query_upd = "SELECT uid,branch_code,client_code,po_num,po_qty,currency,po_tamount,order_date FROM shop_purchase WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);
          
          $upd_uid = $row_upd->uid;
          $upd_branch_code = $row_upd->branch_code;
          $upd_client_code = $row_upd->client_code;
          $upd_po_num = $row_upd->po_num;
          $upd_po_qty = $row_upd->po_qty;
          $upd_currency = $row_upd->currency;
		  $upd_po_tamount = $row_upd->po_tamount;
		  $upd_post_date = $row_upd->order_date;
              $Aday1 = substr($upd_post_date,0,4);
	          $Aday2 = substr($upd_post_date,4,2);
	          $Aday3 = substr($upd_post_date,6,2);
	          
            if($lang == "ko") {
	            $upd_post_dates = "$Aday1"."/"."$Aday2"."/"."$Aday3";
	          } else {
	            $upd_post_dates = "$Aday3"."-"."$Aday2"."-"."$Aday1";
	          }
		
		
		
		echo ("
		<input type=hidden name='add_mode' value='LIST_CHG'>
		<input type=hidden name='new_uid' value='$upd_uid'>
		<input type=hidden name='new_branch_code' value='$upd_branch_code'>
		<input type=hidden name='new_supp_code' value='$upd_client_code'>
		<input type=hidden name='new_po_num' value='$upd_po_num'>
		<input type=hidden name='new_po_qty' value='$upd_po_qty'>
		<input type=hidden name='new_currency' value='$upd_currency'>
		<input type=hidden name='new_po_tamount' value='$upd_po_tamount'>
		<input type=hidden name='new_cart_uid' value='$cart_uid'>
		");
		
		?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_071?>
			
            
        </header>
		
        <div class="panel-body">
		
								<div class="cmxform form-horizontal adminex-form">
		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_purchase_06?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="dis_po_num" value="<?=$upd_po_num?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_06?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_pcode" type="text" required/>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_gudang_code" required>
											<?
											if($login_level > '2') {
												echo("<option value=\"\">:: $txt_invn_stockin_chk07</option>");
											}
              
											if($login_level > '2') {
												$queryC2 = "SELECT count(uid) FROM code_gudang";
											} else {
												$queryC2 = "SELECT count(uid) FROM code_gudang";
											}
											$resultC2 = mysql_query($queryC2);
											$total_recordC2 = @mysql_result($resultC2,0,0);

											if($login_level > '2') {
												$queryD2 = "SELECT gudang_code,gudang_name,userlevel FROM code_gudang ORDER BY gudang_code ASC";
											} else {
												$queryD2 = "SELECT gudang_code,gudang_name,userlevel FROM code_gudang ORDER BY gudang_code ASC";
											}
											$resultD2 = mysql_query($queryD2);

											for($i = 0; $i < $total_recordC2; $i++) {
												$menu_code2 = mysql_result($resultD2,$i,0);
												$menu_name2 = mysql_result($resultD2,$i,1);
												$menu_level2 = mysql_result($resultD2,$i,2);
        
												if($menu_code2 == $upd_gudang_code) {
													$slc_gate2 = "selected";
													$slc_disable2 = "";
												} else {
													$slc_gate2 = "";
													$slc_disable2 = "disabled";
												}

												echo("<option value='$menu_code2' $slc_gate2>$menu_name2 [ $menu_code2 ]</option>");
											}
											?>
											</select>
										</div>
                                    </div>

									
									<?
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_sales_sales_27</label>
										<div class='col-sm-3'>
											<input disabled class='form-control' name='dis_post_date' value='$upd_post_dates'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='$txt_invn_stockin_46'>
										</div>
                                    </div>");
									
									
									?>
								</div>
		</div>
		</section>
		</div>
		</div>

	
	  <? } ?>
		
	</form>
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

        $("#donutchart4").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");
		
		$("#donutchart6").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
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
  
  $m_ip = getenv('REMOTE_ADDR');
  


  

  if($add_mode == "LIST_CHG") {
  

			// Purchase Cart
			$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
				p_name,p_price,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency,qty_check FROM shop_cart 
				WHERE uid = '$new_cart_uid' ORDER BY date ASC";
			$result_H = mysql_query($query_H);
			if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
			$H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
    
			$cart_no = 1;
    
				$H_cart_uid = @mysql_result($result_H,0,0);
				$H_prd_uid = @mysql_result($result_H,0,1);
				$H_pcode_blnk = @mysql_result($result_H,0,2); // Changed
				$H_qty = @mysql_result($result_H,0,3);
					$total_qty = $total_qty + $H_qty;
				$H_p_color = @mysql_result($result_H,0,4);
				$H_p_size = @mysql_result($result_H,0,5);
				$H_p_opt1 = @mysql_result($result_H,0,6);
				$H_p_opt2 = @mysql_result($result_H,0,7);
				$H_p_opt3 = @mysql_result($result_H,0,8);
				$H_p_opt4 = @mysql_result($result_H,0,9);
				$H_p_opt5 = @mysql_result($result_H,0,10);
				$H_pname = @mysql_result($result_H,0,11);
				$H_p_price = @mysql_result($result_H,0,12);
				$H_unpack_qty = @mysql_result($result_H,0,13);
				$H_unpack_unit_uid = @mysql_result($result_H,0,14);
				$H_unpack_unit_qty = @mysql_result($result_H,0,15);
				$H_unpack_unit_name = @mysql_result($result_H,0,16);
				$H_currency = @mysql_result($result_H,0,17);
				$H_qty_check = mysql_result($result_H,0,18);
      
				if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
				if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
				if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
				if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
				if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
				if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
				if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
				$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
				
				$H_pcode = $new_pcode; // IMPORATNT data from form
				$new_group_code = substr($H_pcode,0,7);
				$m_cat_code = substr($H_pcode,0,4);
		
      
      
				// 상품명, 상품별 결제액
				$query_dari = "SELECT uid,pname,price_orgin,price_market,price_sale,stock_org,stock_now FROM shop_product_list WHERE uid = '$H_prd_uid'";
				$result_dari = mysql_query($query_dari);
				if(!$result_dari) { error("QUERY_ERROR"); exit; }
				$row_dari = mysql_fetch_object($result_dari);

				$new_uid = $row_dari->uid;
				$new_pname = $row_dari->pname;
				$new_price_orgin = $row_dari->price_orgin; // Original Price
				$new_price_market = $row_dari->price_market;
				$new_price_sale = $row_dari->price_sale;
				$new_stock_org = $row_dari->stock_org;
				$old_stock_now = $row_dari->stock_now;
		
				
				
				// Stock Input - 현재 등록된 상품코드가 있을 경우에만 입고
				
				if($H_pcode != "") {
				
						// 상품 재고 변동 관리 [동일 상품] - Gudang Code 넘겨 받아야 함
						
						$new_price_margin = $new_price_sale - $new_price_orgin;
						    
						// 수량 합산
						$reset_qty = $new_stock_org + $H_qty_check; // Changed
						$reset_qty_now = $old_stock_now + $H_qty_check; // Changed
            
            
						// 상품 합계
						$ct_price_orgin = $new_price_orgin * $reset_qty;
						$ct_price_market = $new_price_market * $reset_qty;
						$ct_price_sale = $new_price_sale * $reset_qty;
						$ct_price_margin = $new_price_margin * $reset_qty;
            
						// 상품 정보 변경
						$result_CHG5 = mysql_query("UPDATE shop_product_list SET tprice_orgin = '$ct_price_orgin', 
							tprice_market = '$ct_price_market', tprice_sale = '$ct_price_sale', tprice_sale2 = '$ct_price_sale', 
							tprice_margin = '$ct_price_margin', stock_org = '$reset_qty', stock_now = '$reset_qty_now', 
							upd_date = '$post_dates' WHERE uid = '$new_uid'",$dbconn);
						if(!$result_CHG5) { error("QUERY_ERROR"); exit; }
            
            
						// 하위 수량 테이블 생성 - inventory_payment2로 값이 넘어가지 않도록 함 (pay_status = 1)
						$query_S1 = "INSERT INTO shop_product_list_qty (uid,branch_code,catg_code,gcode,pcode,gudang_code,supp_code,
									org_uid,stock,date,price_orgin,pay_status) values ('','$login_branch','$m_cat_code','$new_group_code',
									'$H_pcode','$new_gudang_code','$r_supp_code','$new_uid','$H_qty_check','$post_dates',
									'$new_price_orgin','1')"; // Changed
						$result_S1 = mysql_query($query_S1);
						if (!$result_S1) { error("QUERY_ERROR"); exit; }
            
            
						// 상품 품목 합산
						$my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
									FROM shop_product_catg WHERE pcode = '$new_group_code' ORDER BY pcode DESC";
						$my_result = mysql_query($my_query);
						if (!$my_result) { error("QUERY_ERROR"); exit; }

						$my_catg_uid = @mysql_result($my_result,0,0);
						$my_price_orgin = @mysql_result($my_result,0,1);
						$my_price_market = @mysql_result($my_result,0,2);
						$my_price_sale = @mysql_result($my_result,0,3);
						$my_price_margin = @mysql_result($my_result,0,4);
						$my_stock_org = @mysql_result($my_result,0,5);
    
						$ts_stock_org = $my_stock_org + $H_qty_check; // Changed
						$ts_price_orgin = $my_price_orgin + ( $new_price_orgin * $H_qty_check ); // Changed
						$ts_price_market = $my_price_market + ( $new_price_sale * $H_qty_check ); // Changed
						$ts_price_sale = $my_price_sale + ( $new_price_sale * $H_qty_check ); // Changed
						$ts_price_margin = $my_price_margin + ( $new_price_margin * $H_qty_check ); // Changed
    
						$result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
									tprice_sale = '$ts_price_sale', tprice_margin = '$ts_price_margin', tstock_org = '$ts_stock_org' 
									WHERE pcode = '$new_group_code'",$dbconn);
						if(!$result_T) { error("QUERY_ERROR"); exit; }


						// Shop 미지정 재고 입력 필드 존재 여부 ----------------------------------------------------------------- //
          
						$scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$H_pcode' AND shop_code = ''";
						$scv_result = mysql_query($scv_query,$dbconn);
							if (!$scv_result) { error("QUERY_ERROR"); exit; }
						$scv_count = @mysql_result($scv_result,0,0);
          
						$s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
									WHERE pcode = '$H_pcode' AND shop_code = ''"; // Shop이 미지정된 재고 수량
						$s_resultB = mysql_query($s_queryB,$dbconn);
							if (!$s_resultB) { error("QUERY_ERROR"); exit; }
						$sB_qty_org = @mysql_result($s_resultB,0,0);
						$sB_qty_now = @mysql_result($s_resultB,0,1);
						$sB_qty_sell = @mysql_result($s_resultB,0,2);
            
						$newA_qty_org = $sB_qty_org + $H_qty_check; // 새 입력값에서 현재의 재고를 더함 // Changed
						$newA_qty_now = $sB_qty_now + $H_qty_check; // 새 입력값에서 현재의 재고를 더함 // Changed
            
						// 하위 Shop 지정 정보 및 수량 정보 수정
						if($scv_count > "0") { // Shop 미지정 재고가 1 이상일 때

							// Shop이 미지정된 재고수량 변경
							$result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
									WHERE pcode = '$H_pcode' AND shop_code = ''",$dbconn);
							if(!$result_Tv) { error("QUERY_ERROR"); exit; }

						} else {
          
							$query_Sc = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,shop_code,pcode,qty_org,qty_now,store_date) 
										values ('','$new_uid','$login_branch','','$H_pcode','$newA_qty_org','$newA_qty_now','$post_dates')";
							$result_Sc = mysql_query($query_Sc);
							if (!$result_Sc) { error("QUERY_ERROR"); exit; }
          
						}
						
						// Update Cart
						$result_HCL = mysql_query("UPDATE shop_cart SET do_status = '3' WHERE uid = '$H_cart_uid'",$dbconn);
						if(!$result_HCL) { error("QUERY_ERROR"); exit; }
			

				}
    
  
    
  
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase3.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;


  } else if($add_mode == "LIST_PAY") {
  
  
	echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase3.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;

  }
  

}

}
?>