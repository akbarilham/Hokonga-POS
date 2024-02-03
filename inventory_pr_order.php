<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_pr_order";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_pr_order.php";

// Configuration
$signdate_now = time();
$now_date1 = date("Ymd",$signdate_now);
$now_date2 = date("His",$signdate_now);
  
  
// Filtering
$sorting_filter = "f_class = 'in' AND do_status < '3'";

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
$query_HC = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);
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
  </head>

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              
              <div class="row">
                  <div class="col-sm-12">
                      <section class="panel">
                          <header class="panel-heading">
								<?=$hsm_name_02_02?>
								
								<span class="tools pull-right">
									<a href="javascript:;" class="fa fa-chevron-down"></a>
								</span>
                          </header>
						  
                          <div class="panel-body">
						  
			
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_pr_order.php'>
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
										<th><?=$txt_sys_shop_06?></th>
										<th><?=$txt_invn_purchase_06?></th>
										<th>Q'ty</th>
										<th><?=$txt_invn_purchase_07?></th>
										<th><?=$txt_invn_purchase_08s?></th>
										<th><?=$txt_comm_frm11?></th>
                                      </tr>
                                      </thead>
                                      <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status
    FROM shop_purchase WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status
    FROM shop_purchase WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);
   $branch_code = mysql_result($result,$i,1);
   $client_code = mysql_result($result,$i,2);
   $manager_code = mysql_result($result,$i,3);
   $po_num = mysql_result($result,$i,4);
   $po_qty = mysql_result($result,$i,5);
   $po_tamount = mysql_result($result,$i,6);
   $po_products = mysql_result($result,$i,7);
   $order_date = mysql_result($result,$i,8);
   $li_currency = mysql_result($result,$i,9);
   $order_status = mysql_result($result,$i,10);
   $do_status = mysql_result($result,$i,11);
   $pay_status = mysql_result($result,$i,12);
   
   // Delivery Status
   
   
   
   
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
	$date_diff_warning = "<span class='badge bg-important'>Expire</span>";
   } else {
    $date_diff_warning = "";
   }
   

  echo ("<tr>");
  echo("<td>$article_num</td>");
  echo("<td><a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='Shop Name here'>$client_code</a></td>");
  echo("<td><a href='$link_list?mode=view&now_po_num=$po_num'>$po_num</a> $date_diff_warning</td>");
   
  echo("<td align=right>$po_qty</td>");
  echo("<td align=right><font color=#000>$li_currency $po_tamount_K</font></td>");
  echo("<td>$order_date_txt</td>");
  
  // Print
  echo("<td><a class='btn btn-default btn-xs' target='_blank' href='inventory_pr_order_print.php?P_uid=$uid'><i class='fa fa-print'></i> Print </a></td>");
  
  echo("</tr>");
  
  
			if($mode == "view" AND $now_po_num == $po_num) {
			
			$query_HCc = "SELECT count(uid) FROM shop_cart WHERE order_num = '$now_po_num' AND f_class = 'in' AND expire = '1'";
			$result_HCc = mysql_query($query_HCc);
			if (!$result_HCc) {   error("QUERY_ERROR");   exit; }
    
			$total_HCc = @mysql_result($result_HCc,0,0);
  
				$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name FROM shop_cart 
							WHERE order_num = '$now_po_num' AND f_class = 'in' AND expire = '1' ORDER BY date ASC";
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
		
      
					echo ("
					<tr>
						<td></td>
						<td colspan=2>
							$dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}
						</td>
						<!--<td class='text-center'><strong>$dari_amount_K</strong></td>-->
						<td align=right>$H2_qty</td>
						<td align=right>$li_currency $dari_tamount_K</td>
						<td>$H_unpack_unit_name</td>
						<td></td>
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
								
								 
			
				<a href="inventory_pr_order.php?mode=show_cart"><button class="btn btn-primary"><i class="fa fa-shopping-cart"></i> <?=$txt_invn_purchase_13pr?></button></a>
			
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
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
		
		
		// Shopping Cart
		
		if($total_HC > "0" OR ($mode == "show_cart" OR $mode == "order_form")) {
		?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_invn_purchase_13pr?>
			
            
        </header>
		
        <div class="panel-body">
			
			<section id="unseen">
            <table class="table table-bordered table-condensed">
            <thead>
			<tr>
				<th>#</th>
				<th><?=$txt_invn_stockin_06?></th>
				<th><?=$txt_invn_stockin_05?></th>
				<th><?=$txt_sales_sales_09?> (<?=$po_currency?>)</th>
				<th><?=$txt_invn_stockin_17?></th>
				<th><?=$txt_sales_sales_10?> (<?=$po_currency?>)</th>
				<th><?=$txt_comm_frm12?></th>
				<th><?=$txt_comm_frm13?></th>
			</tr>
			</thead>
		
			<tbody>
			
	  <?
	  $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
				p_name,p_price,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency FROM shop_cart 
				WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' ORDER BY date ASC";
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
		
		
		if($po_currency == "USD") {
			$dari_amount2R = $dari_amount2 / $now_xchange_rate;
		} else {
			$dari_amount2R = $dari_amount2;
		}
		if($po_currency == "USD") {
			$dari_amount2R_K = number_format($dari_amount2R,2);
        } else {
			$dari_amount2R_K = number_format($dari_amount2R);
		}
		
		
		$dari_tamount = $dari_amount2R * $H2_qty;
		
		if($po_currency == "USD") {
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
		if($po_currency == "USD") {
			$p_total_price_K = number_format($p_total_price,2);
		} else {
			$p_total_price_K = number_format($p_total_price);
		}
        
      
      echo ("
      <form name='cart_upd' method='post' action='inventory_pr_order_cart.php'>
      <input type=hidden name='cart_mode' value='CART_UPD'>
      <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
      <input type=hidden name='H_cart_gate' value='$H_cart_shop'>
      <input type=hidden name='H_prd_uid' value='$dari_uid'>
      <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
      <input type=hidden name='H_prd_stock_now' value='$qty_max'>
	  <input type=hidden name='H_unpack_qty' value='$H_unpack_qty'>
	  <input type=hidden name='H_unpack_unit_uid' value='$H_unpack_unit_uid'>
	  <input type=hidden name='H_unpack_unit_qty' value='$H_unpack_unit_qty'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  <input type='hidden' name='po_currency' value='$po_currency'>
      
      <tr height=22>
        <td>$cart_no</td>
        <td>$H_pcode</td>
        <td>{$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</td>
        <td align=right>{$dari_amount2R_K}</td>
        <td align=center><input type='text' name='new_cart_qty' maxlength=6 value='$H2_qty' class='form-control' style='WIDTH: 90px; text-align: right'></td>
        <td align=right>{$dari_tamount_K}</td>
        <td><input type=submit value='U' class='btn btn-default'></td>
        </form>
        
        <form name='cart_del' method='post' action='inventory_pr_order_cart.php'>
        <input type=hidden name='cart_mode' value='CART_DEL'>
        <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
        <input type=hidden name='H_prd_uid' value='$dari_uid'>
        <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
        <input type=hidden name='H_prd_stock_now' value='$qty_max'>
        <input type='hidden' name='key_shop' value='$key_shop'>
		<input type='hidden' name='po_currency' value='$po_currency'>
		
        <td><input type=submit value='D' class='btn btn-default'></td>
        </form>
      </tr>");
      
      $cart_no++;
      }
      

      
      // 합계
      echo ("
      <form name='order_check' method='post' action='inventory_pr_order.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type=hidden name='new_client' value='$H_cart_gate'>
      <input type='hidden' name='key_shop' value='$key_shop'>

      <tr height=22>
        <td colspan=4 align=center>
			<input type=radio name='po_currency' value='IDR' $po_currency_IDR_chk> IDR &nbsp;&nbsp; 
			<input disabled type=radio name='po_currency' value='USD' $po_currency_USD_chk> USD
		</td>
        <td align=center>{$total_qty}</td>
        <td align=right><font color=#000000><b>{$p_total_price_K}</b></font></td>
        <td colspan=2 align=center><input type=submit value='$txt_invn_purchase_09' class='btn btn-primary'></td>
      </tr>
      </form>");
	  ?>
	  </table>
      </section>
      

	  <?
      // Order Form
	  $this_due_dates = date("Y-m-d");
	  
	  if($p_total_price < 1) {
		$order_btn_dis = "disabled";
	  } else {
	    $order_btn_dis = "";
	  }
	  
      if($mode == "order_form") {
      
      echo ("
      <form name='signform' class='cmxform form-horizontal adminex-form' method='post' action='inventory_pr_order_cart.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='cart_mode' value='ORDER'>
      <input type=hidden name='new_client' value='$new_client'>
	  <input type=hidden name='new_currency' value='$po_currency'>
      <input type=hidden name='new_branch_code' value='$login_branch'>
      <input type=hidden name='H_total_qty' value='$total_qty'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  
      
      
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_sales_sales_11</label>
            <div class='col-sm-4'>
				<input type=text name='new_amount' value='$po_currency $p_total_price_K' class='form-control'>
			</div>
			<label class='control-label col-sm-1'>$txt_invn_stockout_05</label>
            <div class='col-sm-5'><input type=text name='dis_shop_code' value='$login_shop' class='form-control'></div>
        </div>

		<!--
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_03</label>
            <div class='col-sm-4'>
				<input type='date' class='form-control' name='new_due_dates' value='$this_due_dates'>
			</div>
        </div>
		-->
		
		<div class='form-group'>
            <div class='col-sm-offset-2 col-sm-10'>
				<input $order_btn_dis class='btn btn-primary' type='submit' value='$txt_invn_purchase_11pr'>
			</div>
        </div>

      </form>");
      
      }
	  ?>
			
			
			
		</div>
		</section>
		</div>
		</div>

		<? } ?>
              
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      
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
  
  // Sales Number
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_pay_num = "PP-"."$exp_branch_code"."-"."$signdate";
  $new_trans_num = "TR-"."$exp_branch_code"."-"."$signdate";
  
  // 인보이스 발행번호
  $rm_query = "SELECT max(uid) FROM shop_payment_invoice ORDER BY uid DESC";
  $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_uid = @mysql_result($rm_result,0,0);
  $new_max_uid = $max_uid + 1;

  $new_max_uid6 = sprintf("%06d", $new_max_uid); // 6자리수
  
  $new_inv_num = "INV-"."$exp_branch_code"."-"."$post_date1d"."-"."$new_max_uid6";
  
  

  if($add_mode == "LIST_CHG") {
  

    if($new_pay_status == "4") { // 결제처리 - 은행대출 신청[인보이스 발행], 실제 대출 신청액 산정
    
        if($new_supp_code == "") {
          popup_msg("$txt_sys_supplier_13");
          break;
        } else {
    
        
        
        // 상품 정보 수정
        $result_CHG = mysql_query("UPDATE shop_product_list_qty SET pay_num = '$new_pay_num', pay_status = '1', 
                      pay_date = '$post_dates' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 카트 정보 입력
        $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,qty,
            product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,pay_num) 
            values ('','$new_prd_uid','$br_branch_code','$new_gudang_code','in','$login_id','$m_ip',
            '$new_prd_code','$new_stock_org','$new_product_color','$new_product_size',
            '$new_product_option1','$new_product_option2','$new_product_option3','$new_product_option4','$new_product_option5',
            '0','$post_dates','$new_pay_num')";
        $result_C2 = mysql_query($query_C2);
        if (!$result_C2) { error("QUERY_ERROR"); exit; }

        // 결제 정보 테이블에 정보 입력 + // 인보이스 발행
        $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date,
            loan_flag,loan_trans_code,invoice_dates,invoice_print) 
            values ('','$new_branch_code','$new_gudang_code','$new_supp_code','in','$new_pay_num','$new_bank_name',
            '$new_remit_code','$new_pay_type','$new_pay_bank','1','$loan_amount','$loan_amount','0','0',
            '$new_stock_org','$post_dates','1','$new_trans_num','$post_dates','1')";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }
        
        
        }
    
    
    
    } else if($new_pay_status == "2") { // 결제마감
    
        // 결제 정보 수정
        $result_CHG = mysql_query("UPDATE shop_payment SET client_code = '$new_supp_code', pay_type = '$new_pay_type', 
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_state = '2' 
            WHERE uid = '$org_pay_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }

    } else if($new_pay_status == "1") { // 결제처리
    
        if($new_supp_code == "") {
          popup_msg("$txt_sys_supplier_13");
          break;
        } else {
    
        // 상품 정보 수정
        $result_CHG = mysql_query("UPDATE shop_product_list_qty SET pay_num = '$new_pay_num', pay_status = '1', 
                      pay_date = '$post_dates' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 카트 정보 입력
        $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,qty,
            product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,pay_num) 
            values ('','$new_prd_uid','$br_branch_code','$new_gudang_code','in','$login_id','$m_ip',
            '$new_prd_code','$new_stock_org','$new_product_color','$new_product_size',
            '$new_product_option1','$new_product_option2','$new_product_option3','$new_product_option4','$new_product_option5',
            '0','$post_dates','$new_pay_num')";
        $result_C2 = mysql_query($query_C2);
        if (!$result_C2) { error("QUERY_ERROR"); exit; }

        // 결제 정보 테이블에 정보 입력
        $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date) 
            values ('','$new_branch_code','$new_gudang_code','$new_supp_code','in','$new_pay_num','$new_bank_name',
            '$new_remit_code','$new_pay_type','$new_pay_bank','1','$new_tprice_orgin','$new_tprice_orgin','0','0',
            '$new_stock_org','$post_dates')";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }
        
        }

        
    } else if($new_pay_status == "0") { // 결제취소
    
        // 상품 정보 수정
        $result_CHG = mysql_query("UPDATE shop_product_list_qty SET pay_num = '', pay_status = '0' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 결제 정보 삭제
        $query_D1 = "DELETE FROM shop_payment WHERE uid = '$org_pay_uid'";
        $result_D1 = mysql_query($query_D1);
        if (!$result_D1) { error("QUERY_ERROR"); exit; }
        
        // 카트 정보 삭제
        $query_D2 = "DELETE FROM shop_cart WHERE prd_uid = '$new_uid'";
        $result_D2 = mysql_query($query_D2);
        if (!$result_D2) { error("QUERY_ERROR"); exit; }
        
        
        
        
    } else {
    
        // 결제 정보 수정
        $result_CHGs = mysql_query("UPDATE shop_payment SET client_code = '$new_supp_code', pay_type = '$new_pay_type', 
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank' 
            WHERE uid = '$org_pay_uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }
    
    }
    
    
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_order.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;


  } else if($add_mode == "LIST_PAY") {
  
      
      // 상품 정보 추출 및 수정
      $query_RC = "SELECT count(uid) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND flag = 'out' AND pay_status = '0'";
      $result_RC = mysql_query($query_RC,$dbconn);
      if (!$result_RC) { error("QUERY_ERROR"); exit; }
      
      $total_RC = @mysql_result($result_RC,0,0);
      
      $query_R1 = "SELECT uid,pcode,branch_code,gudang_code,supp_code,stock FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND flag = 'out' AND pay_status = '0' ORDER BY uid ASC";
      $result_R1 = mysql_query($query_R1,$dbconn);
      if (!$result_R1) { error("QUERY_ERROR"); exit; }

      for($r = 0; $r < $total_RC; $r++) {
        $r_uid = mysql_result($result_R1,$r,0);
        $r_code = mysql_result($result_R1,$r,1);
        $r_branch_code = mysql_result($result_R1,$r,2);
        $r_gudang_code = mysql_result($result_R1,$r,3);
        $r_supp_code = mysql_result($result_R1,$r,4);
        $r_stock_org = mysql_result($result_R1,$r,5);
        
        
        $query_R2 = "SELECT uid,pname,product_option1,product_option2,product_option3,product_option4,product_option5,
          price_orgin FROM shop_product_list WHERE pcode = '$r_code' ORDER BY uid ASC";
        $result_R2 = mysql_query($query_R2,$dbconn);
        if (!$result_R2) { error("QUERY_ERROR"); exit; }
        
        $r_prd_uid = mysql_result($result_R2,0,0);
        $r_name = mysql_result($result_R2,0,1);
        $r_product_option1 = mysql_result($result_R2,0,2);
        $r_product_option2 = mysql_result($result_R2,0,3);
        $r_product_option3 = mysql_result($result_R2,0,4);
        $r_product_option4 = mysql_result($result_R2,0,5);
        $r_product_option5 = mysql_result($result_R2,0,6);
        $r_price_orgin = mysql_result($result_R2,0,7);
        
        
        // 체크 값
        $check_org_uid = "check_$r_uid";
        $check_uid = ${$check_org_uid};
        
        if($check_uid == "1") {
        
        // 결제 총액
        $r_total_price_orgin = $r_total_price_orgin + ($r_price_orgin * $r_stock_org);
        
          // 카트정보 입력
          $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,qty,
            p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,pay_num) values ('','$r_prd_uid',
            '$r_branch_code','$r_gudang_code','in','$login_id','$m_ip','$r_code','$r_stock_org',
            '$r_product_option1','$r_product_option2','$r_product_option3','$r_product_option4','$r_product_option5',
            '0','$post_dates','$new_pay_num')";
          $result_C2 = mysql_query($query_C2);
          if (!$result_C2) { error("QUERY_ERROR"); exit; }
          
          // 상품 정보 수정
          $result_CHG2 = mysql_query("UPDATE shop_product_list_qty SET pay_num = '$new_pay_num', pay_status = '1', 
                      pay_date = '$post_dates', branch_code = '$r_branch_code' WHERE uid = '$r_uid'",$dbconn);
          if(!$result_CHG2) { error("QUERY_ERROR"); exit; }
        
        }
     
    }
     
    // 결제 총액 추출
    
    
     
    // 결제 정보 테이블에 정보 입력
    // if($ts_price_orgin) {
      $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,pay_type,pay_state,
        pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,pay_date) 
        values ('','$login_branch','$login_gate','$new_supp_code','in','$new_pay_num','$new_pay_type','1',
        '$r_total_price_orgin','$r_total_price_orgin','0','0','$post_dates')";
      $result_P2 = mysql_query($query_P2);
      if (!$result_P2) { error("QUERY_ERROR"); exit; }
    // }

  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_collection.php'>");
    exit;
  
  }
  

}

}
?>