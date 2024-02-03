<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "purchase";
$smenu = "inventory_purchase2";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_purchase2.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_purchase2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_list2 = "$home/inventory_purchase3.php?sorting_key=$sorting_key";

$link_act = "$home/inventory_purchase1_act.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
// $sorting_filter = "branch_code = '$login_gate' AND do_status < '3' AND check_status > '0'";
$sorting_filter = "f_class = 'out' AND do_status < '3' AND check_status > '0'";

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
            <?=$hsm_name_04_071?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_purchase2.php'>
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
			
		
		
		<form name='signform' class="form-horizontal" method='post' action='inventory_purchase2.php'>
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
            <th><?=$txt_stf_member_55?></th>
            <th><?=$txt_invn_purchase_06?></th>
			<th colspan=2>Q'ty</th>
			<th><?=$txt_invn_purchase_07?></th>
			<th><?=$txt_invn_stockin_60?></th>
			<th><div align=center><i class='fa fa-check-square-o'></i></div></th>
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
		
		
			if($lang == "ko") {
				$check_date_txt = "$chkday1"."/"."$chkday2"."/"."$chkday3";
			} else {
				$check_date_txt = "$chkday3"."-"."$chkday2"."-"."$chkday1";
			}
		
		
		$query_sum = "SELECT sum(qty_check),sum(qty_loss) FROM shop_cart WHERE order_num = '$po_num' AND f_class = 'out' AND expire = '1' AND check_status > '0'";
		$result_sum = mysql_query($query_sum);
		if (!$result_sum) {   error("QUERY_ERROR");   exit; }
      
		$sum_qty_check = @mysql_result($result_sum,0,0);
			$sum_qty_check_K = number_format($sum_qty_check);
		$sum_qty_loss = @mysql_result($result_sum,0,1);
			$sum_qty_loss_K = number_format($sum_qty_loss);
   

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
  echo("<td bgcolor='$highlight_color'><a href='$link_list&mode=view&now_po_num=$po_num&uid=$li_uid'>$po_num</a></td>");
   
  echo("<td bgcolor='$highlight_color' align=right>$po_qty_K</td>");
  echo("<td bgcolor='$highlight_color' align=right><font color=#000>$sum_qty_check_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color=#000>$li_currency $po_tamount_K</font></td>");
  echo("<td bgcolor='$highlight_color'>$check_date_txt</td>");
  
  // Check
  if($order_status > 1) {
      echo("<td bgcolor='$highlight_color' align=center><input type=checkbox name='check_$li_uid' value='1'></td>");
  } else {
      echo("<td bgcolor='$highlight_color'>&nbsp;</td>");
  }
  
  
  
  echo("<td bgcolor='$highlight_color'>
 
		<div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>Go <span class='caret'></span></button>
            <ul role='menu' class='dropdown-menu' style='margin-left: -80px'>");
				// if($pay_status < 2) {
					if($order_status > 1) {
						echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-gavel'></i> $txt_invn_stockin_48</a></font></li>");
					} else {
						// echo ("<li><a href='$link_act&act_mode=approve&uid=$li_uid'><i class='fa fa-gavel'></i> $txt_invn_stockin_47</a></li>");
					}
					echo ("
					<!--<li><a href='$link_act&act_mode=send&uid=$li_uid'><i class='fa fa-envelope'></i> $txt_invn_stockin_49</a></li>-->
					<li class='divider'></li>");
				// }
				echo ("
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
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,qty_check,qty_loss,qty_diff_org,memo,
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
					$H_qty_check = mysql_result($result_H,$h,16);
						$H_qty_check_K = number_format($H_qty_check);
					$H_qty_loss = mysql_result($result_H,$h,17);
						$H_qty_loss_K = number_format($H_qty_loss);
					$H_qty_diff = mysql_result($result_H,$h,18);
						$H_qty_diff_K = number_format($H_qty_diff);
					$H_qty_memo = mysql_result($result_H,$h,19);
					$H_check_status = mysql_result($result_H,$h,20);
					$H_check_date = mysql_result($result_H,$h,21);
					
					      
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
						<td colspan=2>
							$dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}
						</td>
						<!--<td class='text-center'><strong>$dari_amount_K</strong></td>-->
						<td align=right>$H_qty_K</td>
						<td align=right><font color=#000>$H_qty_check_K</font></td>
						<td align=right>$li_currency $dari_tamount_K</td>
						<td>$H_unpack_unit_name</td>
						<td></td>
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
		echo ("
		<input type=hidden name='add_mode' value='LIST_PAY'>
		<input type=hidden name='add_uid' value='$upd_uid'>
		<input type=hidden name='add_branch_code' value='$upd_branch_code'>
		<input type=hidden name='add_client_code' value='$upd_client_code'>
		<input type=hidden name='add_currency' value='$upd_currency'>
		<input type=hidden name='add_po_tamount' value='$upd_po_tamount'>
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_gudang_code" required>
											<?
											if($now_group_admin == "1") {
												echo("<option value=\"\">:: $txt_invn_stockin_chk07</option>");
											}
              
											if($now_group_admin == "1") {
												$queryC2 = "SELECT count(uid) FROM code_gudang";
											} else {
												$queryC2 = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$login_branch'";
											}
											$resultC2 = mysql_query($queryC2);
											$total_recordC2 = @mysql_result($resultC2,0,0);

											if($now_group_admin == "1") {
												$queryD2 = "SELECT gudang_code,gudang_name,userlevel FROM code_gudang ORDER BY gudang_code ASC";
											} else {
												$queryD2 = "SELECT gudang_code,gudang_name,userlevel FROM code_gudang WHERE branch_code = '$login_branch' ORDER BY gudang_code ASC";
											}
											$resultD2 = mysql_query($queryD2);

											for($i = 0; $i < $total_recordC2; $i++) {
												$menu_code2 = mysql_result($resultD2,$i,0);
												$menu_name2 = mysql_result($resultD2,$i,1);
												$menu_level2 = mysql_result($resultD2,$i,2);
        
												if($menu_code2 == $upd_gudang_code OR $menu_code2 == "WH_02") {
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

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
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
  $post_date3 = date("Ym",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
 
  // 인보이스 발행번호
  $rm_query = "SELECT max(uid) FROM shop_payment_invoice ORDER BY uid DESC";
  $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_uid = @mysql_result($rm_result,0,0);
  $new_max_uid = $max_uid + 1;

  $new_max_uid6 = sprintf("%06d", $new_max_uid); // 6자리수
  
  $new_inv_num = "INV-"."$exp_branch_code"."-"."$post_date1d"."-"."$new_max_uid6";
  
  

  if($add_mode == "LIST_CHG") {
  


    
  
    
  
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;


  } else if($add_mode == "LIST_PAY") {
  
      
      // 정보 추출 및 수정
      $query_RC = "SELECT count(uid) FROM shop_purchase WHERE do_status < '3'";
      $result_RC = mysql_query($query_RC,$dbconn);
      if (!$result_RC) { error("QUERY_ERROR"); exit; }
      
      $total_RC = @mysql_result($result_RC,0,0);
      
      $query_R1 = "SELECT uid,branch_code,client_code,po_num,currency,po_tamount FROM shop_purchase WHERE do_status < '3' ORDER BY uid ASC";
      $result_R1 = mysql_query($query_R1,$dbconn);
      if (!$result_R1) { error("QUERY_ERROR"); exit; }

      for($r = 0; $r < $total_RC; $r++) {
        $r_uid = mysql_result($result_R1,$r,0);
        $r_branch_code = mysql_result($result_R1,$r,1);
        $r_supp_code = mysql_result($result_R1,$r,2);
        $r_po_num = mysql_result($result_R1,$r,3);
		$r_currency = mysql_result($result_R1,$r,4);
		$r_po_tamount = mysql_result($result_R1,$r,5);
		
		// 실제 수량에 대한 인보이스 총액
		
        

        // 체크 값
        $check_org_uid = "check_$r_uid";
        $check_uid = ${$check_org_uid};
        
        if($check_uid == "1") {
        
			// Purchase Cart
			$query_HC = "SELECT count(uid) FROM shop_cart WHERE order_num = '$r_po_num' AND f_class = 'out' AND expire = '1'";
			$result_HC = mysql_query($query_HC);
			if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
			$total_HC = @mysql_result($result_HC,0,0);

			$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
				p_name,p_price,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency,qty_check,org_pcode,org_barcode FROM shop_cart 
				WHERE order_num = '$r_po_num' AND f_class = 'out' AND expire = '1' ORDER BY date ASC";
			$result_H = mysql_query($query_H);
			if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
			$H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
    
			$cart_no = 1;
    
			for($h = 0; $h < $total_HC; $h++) {
				$H_cart_uid = mysql_result($result_H,$h,0);
				$H_prd_uid = mysql_result($result_H,$h,1);
				$H_pcode = mysql_result($result_H,$h,2);
				$H_qty = mysql_result($result_H,$h,3);
					$total_qty = $total_qty + $H_qty;
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
				$H_unpack_unit_uid = mysql_result($result_H,$h,14);
				$H_unpack_unit_qty = mysql_result($result_H,$h,15);
				$H_unpack_unit_name = mysql_result($result_H,$h,16);
				$H_currency = mysql_result($result_H,$h,17);
				$H_qty_check = mysql_result($result_H,$h,18);
				$H_org_pcode = mysql_result($result_H,$h,19);
				$H_org_barcode = mysql_result($result_H,$h,20);
      
				if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
				if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
				if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
				if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
				if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
				if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
				if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
				$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
				
				#$new_group_code = substr($H_pcode,0,7);
				$m_cat_code = substr($H_pcode,0,4);
		
      
      
				// 상품명, 상품별 결제액
				$query_dari = "SELECT uid,pname,price_orgin,price_market,price_sale,stock_org,stock_now,gcode FROM shop_product_list WHERE uid = '$H_prd_uid'";
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
				$baru_gcode = $row_dari->gcode;
		
				
				
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
									org_uid,stock,date,price_orgin,pay_status,org_pcode,org_barcode) values ('','$login_branch','$m_cat_code','$baru_gcode',
									'$H_pcode','$new_gudang_code','$r_supp_code','$new_uid','$H_qty_check','$post_dates',
									'$new_price_orgin','1','$H_org_pcode','$H_org_barcode')"; // Changed
						$result_S1 = mysql_query($query_S1);
						if (!$result_S1) { error("QUERY_ERROR"); exit; }
            
            
						// 상품 품목 합산
						$my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
									FROM shop_product_catg WHERE pcode = '$baru_gcode' ORDER BY pcode DESC";
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
									WHERE pcode = '$baru_gcode'",$dbconn);
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
          
							$query_Sc = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,shop_code,pcode,qty_org,qty_now,store_date,org_pcode,org_barcode,gname,pname) 
										values ('','$new_uid','$login_branch','','$H_pcode','$newA_qty_org','$newA_qty_now','$post_dates','$H_org_pcode','$H_org_barcode','$H_pname','$H_pname')";
							$result_Sc = mysql_query($query_Sc);
							if (!$result_Sc) { error("QUERY_ERROR"); exit; }
          
						}
/*
						$fms_query = "SELECT count(uid) FROM final_monthly_stock WHERE pcode = '$H_pcode' AND gudang_code = '$new_gudang_code' AND shop_code = '' AND pname = '$H_pname'";
						$fms_result = mysql_query($fms_query,$dbconn);
							if (!$scv_result) { error("QUERY_ERROR"); exit; }
						$fms_count = @mysql_result($fms_result,0,0);						

						$stock_loss = $sum_qty_loss;

						if($fms_count > "1") {

							// 동일한 값, 창고 업데이트가 있는지
							$result_Tv = mysql_query("UPDATE final_monthly_stock SET stock_begin = '$newA_qty_org', stock_in = '$newA_qty_now', stock_end = '$newA_qty_now' WHERE pcode = '$H_pcode' AND gudang_code = '$new_gudang_code' AND pname = '$H_pname' ",$dbconn);
							if(!$result_Tv) { error("QUERY_ERROR"); exit; }

						} else {

							// 동일한 값, 창 삽입물이 없다면
							$query_gudang = "INSERT INTO final_monthly_stock (branch_code,gudang_code,supp_code,shop_code,catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,stock_begin,stock_in,stock_out,stock_sell,stock_loss,stock_end,date) VALUES ('$login_branch','$new_gudang_code','$r_supp_code','','$m_cat_code','$baru_gcode','$H_pcode','$H_org_pcode','$H_org_barcode','$H_pname','$H_pname','$newA_qty_org','$newA_qty_org','$stock_out','$stock_sell','$stock_loss','$newA_qty_org','$post_date3')";
							$fetch_gudang = mysql_query($query_gudang);
							if (!$fetch_gudang) { error("QUERY_ERROR"); exit; }				

						}
						*/
						// Update Cart
						$result_HCL = mysql_query("UPDATE shop_cart SET do_status = '3' WHERE uid = '$H_cart_uid'",$dbconn);
						if(!$result_HCL) { error("QUERY_ERROR"); exit; }
			

				}
		
		
		
		
		
		
			}
          
			// 정보 수정
			$result_CHG2 = mysql_query("UPDATE shop_purchase SET do_status = '3' WHERE uid = '$r_uid'",$dbconn);
			if(!$result_CHG2) { error("QUERY_ERROR"); exit; }
        
        }
     
    }
     
    // 결제 총액 추출
    
    
     
    // 결제 정보 테이블에 정보 입력 [수량 차이가 있을 경우 이를 참고 사항에 넣음 - 클레임 걸 때 활용]
    
	/*
      $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,pay_type,pay_state,
        pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,pay_date) 
        values ('','$login_branch','$login_gate','$new_supp_code','out','$new_pay_num','$new_pay_type','1',
        '$r_po_tamount','$r_po_tamount','0','0','$post_dates')";
      $result_P2 = mysql_query($query_P2);
      if (!$result_P2) { error("QUERY_ERROR"); exit; }
    */

  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_purchase3.php'>");
    exit;
  
  }
  

}

}
?>