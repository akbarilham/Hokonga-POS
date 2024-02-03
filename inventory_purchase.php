<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "purchase";
$smenu = "inventory_purchase";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "inventory_purchase.php";

// Configuration
$signdate_now = time();
$now_date1 = date("Ymd",$signdate_now);
$now_date2 = date("His",$signdate_now);
  
  
// Filtering
if($otype == "A") {
	$sorting_filter = "f_class = 'out' AND do_status < '3'";
} else if($otype == "B") {
	$sorting_filter = "f_class = 'out' AND do_status > '2'";
} else {
	$sorting_filter = "f_class = 'out'";
}

if(!$sorting_key) { $sorting_key = "order_date"; } // po_num
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

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
		  <? include "navbar_inventory_purchase.inc"; ?>
              
              <div class="row">
                  <div class="col-sm-12">
                      <section class="panel">
                          <header class="panel-heading">
								<?=$hsm_name_04_06?>
								
								<span class="tools pull-right">
									<? if($mode == "view" AND $now_po_num) { ?>
									<a href="inventory_purchase.php?mode=order_del&del_uid=<?=$now_po_num?>&otype=<?=$otype?>" class="fa fa-trash-o"></a>
									<? } ?>
									<a href="javascript:;" class="fa fa-chevron-down"></a>
								</span>
                          </header>
						  
                          <div class="panel-body">
						  
			
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_purchase.php'>
			<input type='hidden' name='otype' value='$otype'>
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
			<option value='$PHP_SELF?sorting_key=po_num&key=$key&keyfield=$keyfield&otype=$otype'>$txt_invn_purchase_06s</option>
			<option value='$PHP_SELF?sorting_key=client_code&key=$key&keyfield=$keyfield&otype=$otype' $chk3>$txt_stf_member_55</option>
			<option value='$PHP_SELF?sorting_key=order_date&key=$key&keyfield=$keyfield&otype=$otype' $chk4>$txt_invn_purchase_08</option>
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
										<th>Q'ty</th>
										<th><?=$txt_invn_purchase_07?></th>
										<th>PIB</th>
										<th>Next Stat</th>
										<th><?=$txt_invn_purchase_08s?></th>
										<th>Correction</th>										
										<th><?=$txt_comm_frm11?></th>
                                      </tr>
                                      </thead>
                                      <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status,check_status,
			xchg_rate,unit,eta_date,eta_status,revisi,wrong_status FROM shop_purchase WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
   $query = "SELECT uid,branch_code,client_code,manager_code,po_num,po_qty,po_tamount,products,order_date,currency,order_status,do_status,pay_status,check_status,
			xchg_rate,unit,eta_date,eta_status,revisi,wrong_status FROM shop_purchase WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
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
   $check_status = mysql_result($result,$i,13);
   $xchg_rate = mysql_result($result,$i,14);
   $po_unit = mysql_result($result,$i,15);
   $eta_date = mysql_result($result,$i,16);
   $eta_statu = mysql_result($result,$i,17);
   $revisi = mysql_result($result,$i,18);
   $revi = explode("|",$revisi);
   $wrong_status = mysql_result($result,$i,19);
   // Delivery Status
   
	
	// Supplier Name
	$query_supp = "SELECT supp_name FROM client_supplier WHERE supp_code = '$client_code'";
	$result_supp = mysql_query($query_supp);
   
	$supp_name = @mysql_result($result_supp,0,0);
		$supp_name = stripslashes($supp_name);
   
   
   
	if($li_currency == "USD") {
		$po_tamount_K = number_format($po_tamount,2);
		$xchg_rate_K = number_format($xchg_rate);
	} else {
		$po_tamount_K = number_format($po_tamount);
		$xchg_rate_K = "";
	}
   
   // Order Date
	//$order_date1 = substr($po_num,6,8);
   $order_date1 = substr($order_date,0,8);
  
  // 발주일
	$uday1 = substr($order_date1,0,4);
	$uday2 = substr($order_date1,4,2);
	$uday3 = substr($order_date1,6,2);
	
	
  if($lang == "ko") {
	  $order_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	} else {
	  $order_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	}
  

   // 3일이 지나면 경고
   $date_diffs = $now_date1 - $order_date1;
	if ($wrong_status == 1){
  	
			$date_diff_warning = "<span class='badge bg-inverse'>Incorrect</span>";
	
  } else {
  	if($pay_status < 2 AND $do_status < 1 AND $date_diffs > 3) {
			$date_diff_warning = "<span class='badge bg-important'>Expire</span>";
	} else {
		if($do_status > 2) {
			$date_diff_warning = "&nbsp;&nbsp; <i class='fa fa-check'></id>";
		} else {
			$date_diff_warning = "";
		}
	}
  }
      
	/* if($pay_status < 2 AND $do_status < 1 AND $date_diffs > 3) {
			$date_diff_warning = "<span class='badge bg-important'>Expire</span>";
	} else {
		if($do_status > 2) {
			$date_diff_warning = "&nbsp;&nbsp; <i class='fa fa-check'></id>";
		} else {
			$date_diff_warning = "";
		}
	} */
   
	//eta status
	if($revi[0] == 2 AND $revi[1] == 2 AND $revi[2] == 2){
		$eta_status == 1;
		$li_status = "Arrived";
	}else if($revi[0] == 2 AND $revi[1] == 2 AND $revi[2] == 1){
		$eta_status == 2;
		$li_status = "ETA";
	}else if($revi[0] == 2 AND $revi[1] == 1 AND $revi[2] == 1){
		$eta_status == 3;
		$li_status = "ETD";
	}else{
		$li_status = "Edit";
	}
   
	// color
	if($mode == "order_del" AND $del_uid == $po_num) {
		$td_color_now = "#FAFAB4";
	} else {
		$td_color_now = "#ffffff";
	}
	
   

  echo ("<tr>");
  echo("<td bgcolor='$td_color_now'>$article_num</td>");
  echo("<td bgcolor='$td_color_now'><a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='$supp_name'>$client_code</a></td>");
  echo("<td bgcolor='$td_color_now'><a href='$link_list?mode=view&now_po_num=$po_num&otype=$otype&page=$page'>$po_num</a> $date_diff_warning</td>");
  echo("<td bgcolor='$td_color_now' align=right>$po_qty</td>");
  if($li_currency == "USD") {
	echo("<td bgcolor='$td_color_now' align=right><a href='#' data-placement='right' data-toggle='tooltip' class='tooltips' data-original-title='$xchg_rate_K'><font color=#000>$li_currency $po_tamount_K</font></a></td>");
	echo ("<td bgcolor='$td_color_now'><a href='$link_list?mode=PIB&update=PIB&now_po_num=$po_num&page=$page'>PIB</a></td>");
	echo ("<td bgcolor='$td_color_now'><a href='$link_list?mode=eta&otype=$li_status&now_po_num=$po_num&page=$page'>$li_status</a></td>");
  } else {
	echo("<td bgcolor='$td_color_now' align=right><font color=#000>$li_currency $po_tamount_K</font></td>");
	echo ("<td bgcolor='$td_color_now'>--</td>");
	echo ("<td bgcolor='$td_color_now'>--</td>");
  }
  echo("<td bgcolor='$td_color_now'>$order_date_txt</td>");
    if ($wrong_status == 1){
  	echo("<td bgcolor='$td_color_now'><a href='$link_list?wrs=wrong&now_po_num=$po_num'>&#x2716;</a></td>");
  } else {
  	echo("<td bgcolor='$td_color_now'><a href='$link_list?wrs=wrong&now_po_num=$po_num'>&#10004;</a></td>");
  // Print
  echo("<td bgcolor='$td_color_now'><a class='btn btn-default btn-xs' target='_blank' href='inventory_purchase_print.php?P_uid=$uid'><i class='fa fa-print'></i> Print </a></td>");	
  }
  
  echo("<td bgcolor='$td_color_now'></td>");
  
  
  echo("</tr>");
  
  
			if($mode == "view" AND $now_po_num == $po_num) {
			
			$query_HCc = "SELECT count(uid) FROM shop_cart WHERE order_num = '$now_po_num' AND f_class = 'out' AND expire = '1'";
			$result_HCc = mysql_query($query_HCc);
			if (!$result_HCc) {   error("QUERY_ERROR");   exit; }
    
			$total_HCc = @mysql_result($result_HCc,0,0);
  
				$query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
							p_name,p_price,unpack_qty,unpack_unit_qty,unpack_unit_name,org_pcode,org_barcode FROM shop_cart 
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
					$H_org_pcode = @mysql_result($result_H,$h,16);
					$H_org_barcode = mysql_result($result_H,$h,17);
      
					if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
					if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
					if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
					if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
					if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
					if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
					if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
					$H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
					
					
					
      
      
					// 상품명, 상품별 결제액
					$query_dari = "SELECT uid,gcode,pname,price_orgin,tprice_orgin,stock_now,stock_sell,unit FROM shop_product_list WHERE uid = '$H_prd_uid'";
					$result_dari = mysql_query($query_dari);
					if(!$result_dari) { error("QUERY_ERROR"); exit; }
					$row_dari = mysql_fetch_object($result_dari);

					$dari_uid = $row_dari->uid;
					$dari_gcode = $row_dari->gcode;
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
					
					// Unit
					$dari_unit = $row_dari->unit;
					
					if($dari_unit != "") {
						$dari_unit_reset = $dari_unit;
					} else {
						$dari_unit_reset = $H_unpack_unit_name;
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
					
					
					$query_gnam = "SELECT pname FROM shop_product_catg WHERE pcode = '$dari_gcode'";
					$result_gnam = mysql_query($query_gnam);
   
					$prd_gname = @mysql_result($result_gnam,0,0);
					$prd_gname = stripslashes($prd_gname);
		
      
					echo ("
					<tr>
						<td></td>
						<td colspan=2><a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='[$dari_gcode] $prd_gname'>
							[$H_org_pcode] $dari_pname {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a>
						</td>
						<!--<td class='text-center'><strong>$dari_amount_K</strong></td>-->
						<td align=right>$H2_qty</td>
						<td align=right>$li_currency $dari_tamount_K</td>
						<td>$dari_unit_reset</td>
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
								
								 
			
				<a href="inventory_purchase.php?mode=show_cart"><button class="btn btn-primary"><i class="fa fa-shopping-cart"></i> <?=$txt_invn_purchase_13?></button></a>
				
				<? if($mode == "order_del" AND $del_uid AND $pay_status < 2 AND $do_status < 1) { ?>
				<a href="inventory_purchase_del.php?mode=order_del&del_uid=<?=$del_uid?>&otype=<?=$otype?>"><button class="btn btn-warning"><i class="fa fa-trash-o"></i> <?=$txt_comm_frm052?></button></a>
				<? } ?>
				
			
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&otype=$otype\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&otype=$otype\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key&otype=$otype\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key&otype=$otype\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key&otype=$otype\">Next $page_per_block</a>");
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

	  	if ($wrs == 'wrong') {

	  ?>
				<div class="row">
				<div class="col-sm-12">
				<section class="panel">
				<header class="panel-heading">
				   Purchase Order - Correction Status 
				</header>
				<div class="panel-body">
					<section id="unseen">
					<form name='correction' method='post' action='inventory_purchase.php'>
						<table class="table table-bordered table-condensed">
						<thead>
						<tr>
							
							<th><?=$txt_invn_purchase_06?></th>
							<th>Correction Status</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$now_po_num?></td>
								<td>
									<select name="cor_status" class="form-control">
										<option value="0">Benar</option>									
										<option value="1">Salah</option>
									</select>
								</td>
							</tr>
						</tbody>
						</table>
						<input type='submit' name='correction' value="Save" class="btn btn-primary">
						<input type="hidden" name="cart_mode" value="correction">	
						<input type="hidden" name="po2" value="<?php echo $now_po_num; ?>">	
						</form>
					</section>
				</div>
				</section>
				</div>
				</div>	  
	  <? } 

	  if ($cart_mode == 'correction'){ 	
	  	
		  $query_wrs = "UPDATE shop_purchase SET wrong_status = '$cor_status' WHERE po_num = '$po2'";
		  //var_dump($query_wrs); die();
		  $result_wrs = mysql_query($query_wrs,$dbconn);
	      if(!$result_wrs) { error("QUERY_ERROR"); exit; }

	      echo("<meta http-equiv='Refresh' content='0; URL=inventory_purchase.php?now_po_num=$po2'>");
	      exit;

	  }
		
		//PIB
		if($mode == "PIB" OR $update == "PIB" ) {
			?>
				<div class="row">
				<div class="col-sm-12">
				<section class="panel">
				<header class="panel-heading">
				   PEMBERITAHUAN IMPOR BARANG (PIB) (<?=$now_po_num?>)
				</header>
				<div class="panel-body">
					<section id="unseen">
					<form name='pib' method='post' action='inventory_purchase_cart.php'>
						<table class="table table-bordered table-condensed">
						<thead>
						<tr>
							
							<th colspan="2">PIB</th>
							<th>Jumlah Pembayaran PIB</th>
						</tr>
						</thead>
						<?
							$query_pib1 = "SELECT bm,ppn_import,pph22,adm_bank,status_pib,po_tamount,xchg_rate,currency,custom,freight,thc,adm,docfee,insurance 
							FROM shop_purchase 
							WHERE po_num = '$now_po_num'";
							$result_pib1 = mysql_query($query_pib1);
							if (!$result_pib1) {   error("QUERY_ERROR");   exit; }
							$bea1 = mysql_result($result_pib1,0,0);
							$ppn_import1 = mysql_result($result_pib1,0,1);
							$pph22 = mysql_result($result_pib1,0,2);
							$adm_bank1 = mysql_result($result_pib1,0,3);
							$status_pib = mysql_result($result_pib1,0,4);
							$po_tamount = mysql_result($result_pib1,0,5);
							$xchg_rate = mysql_result($result_pib1,0,6);
							$currency = mysql_result($result_pib1,0,7);
							$custom = mysql_result($result_pib1,0,8);
							$freight1 = mysql_result($result_pib1,0,9);
							$thc1 = mysql_result($result_pib1,0,10);
							$adm1 = mysql_result($result_pib1,0,11);
							$docfee1 = mysql_result($result_pib1,0,12);
							$insurance1 = mysql_result($result_pib1,0,13);
							$total_pib = $bea1 + $ppn_import1 + $pph22 + $adm_bank1;
							$total_advance = $freight1 + $thc1 + $adm1 + $docfee1 + $insurance1;
							if ($currency = "USD"){
								$amnt = $po_tamount * $xchg_rate;
								$ten = 0.1;
								$ppn_amnt = $amnt * $ten;
							}elseif($currency = "IDR") {
								$ten = 0.1;
								$ppn_amnt = $po_tamount * $ten;
							}
							$this_due_dates = date("Y-m-d");
						?>
						<tbody>
							<tr>
								<td><b>1.</b></td>
								<td>Bea Masuk</td>
								<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount1" name='bea' value=<? echo $bea1; ?>></td>
								<td><span class='displayamount1'></span></td>
								
							</tr>
							<tr>
								<td><b>2.</b></td>
								<td>PPN Import</td>
								<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount2" name='ppn_import' value=<? echo $ppn_import1; ?>></td>
								<td><span class='displayamount2'></span></td>
							</tr>
							<tr>
								<td><b>3.</b></td>
								<td>Pph Pasal 22 Import</td>
								<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount3" name='pph_22' value=<? echo $pph22; ?>></td>
								<td><span class='displayamount3'></span></td>
							</tr>
							<tr>
								<td><b>4.</b></td>
								<td>Adm Bank</td>
								<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount4" name='adm_bank' value=<? echo $adm_bank1; ?>></td>
								<td><span class='displayamount4'></span></td>
							</tr>
							<tr>
								<td><b>5.</b></td>
								<td>Custom Clearance</td>
								<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount5" name='custom' value=<? echo $custom; ?>></td>
								<td><span class='displayamount5'></span></td>
							</tr>
							<tr>
								<td colspan="2"><b>Total Pembayaran PIB</b></td>
								<td><b>Rp. <? echo number_format(floatval($total_pib),2); ?></b></td>
							</tr>							
							<tr>
								<td style='background:#EEEEEE;' colspan="4"></td>
							</tr>	
						</tbody>
						
							<thead>
								<tr>
									
									<th colspan="2">Advance </th>
									<th >Jumlah Pembayaran Advance</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><b>1.</b></td>
									<td>Freight</td>
									<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount6" name='freight' value=<? echo $freight1; ?>></td>
									<td><span class='displayamount6'></span></td>
								</tr>
								<tr>
									<td><b>2.</b></td>
									<td>THC</td>
									<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount7" name='thc' value=<? echo $thc1; ?>></td>
									<td><span class='displayamount7'></span></td>
								</tr>
								<tr>
									<td><b>3.</b></td>
									<td>ADM</td>
									<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount8" name='adm' value=<? echo $adm1; ?>></td>
									<td><span class='displayamount8'></span></td>
								</tr>
								<tr>
									<td><b>4.</b></td>
									<td>Doc Fee</td>
									<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text'  class="form-control amount9" name='docfee' value=<? echo $docfee1; ?>></td>
									<td><span class='displayamount9'></span></td>
								</tr>
								<tr>
									<td><b>5.</b></td>
									<td>Insurance</td>
									<td><input <?php if($status_pib == 9) echo "disabled"; ?> id="numbersOnly" pattern="[0-9.]+" type='text' class="form-control amount10" name='insurance' value=<? echo $insurance1; ?>></td>
									<td><span class='displayamount5'></span></td>
								</tr>
								<tr>
									<td colspan="2"><b>Total Pembayaran Advance</b></td>
									<td><b>US$ <? echo number_format(floatval($total_advance),2); ?></b></td>
								</tr>	
							</tbody>
						</table>
						<? if ($status_pib == 9) { ?>
						<input disabled type='submit' name='pib' value="Save" class="btn btn-primary">
						<input disabled type='submit' name='pib' value="Send" class="btn btn-primary">						
						<? } else { ?>
						<input type='hidden' class='form-control' name='po' value='<?echo $now_po_num?>' >
						<input type='submit' name='pib' value="Save" class="btn btn-primary">
						<input <?php if($status_pib == NULL) echo "disabled"; ?> type='submit' name='pib' value="Send" class="btn btn-primary">						
						<input type="hidden" name="cart_mode" value="PIB">
						<input type=hidden name='new_branch_code' value=<? echo $login_branch; ?>>
						<input type=hidden name='new_currency' value=<? echo $po_currency; ?>>
						<input type=hidden name='new_due_dates' value=<? echo $this_due_dates; ?>>
						<input type="hidden" name="amount" value=<? echo $total_pib; ?>>
						<input type=hidden name='mode' value='order_form'>						
						<? } ?>
						</form>
					</section>
				</div>
				</section>
				</div>
				</div>
				<?
		}
		
		//Update Status eta
		if($mode == "eta" OR $eta != null) {
			?>
				<div class="row">
				<div class="col-sm-12">
				<section class="panel">
				<header class="panel-heading">
				   ETA Update (<?=$now_po_num?>)
				</header>
				<div class="panel-body">
					<section id="unseen">
						<form name='eta_upd' method='post' action='inventory_purchase.php'>
						<table class="table table-bordered table-condensed">
						<thead>
						<tr>
							<th>Pilih</th>
							<th>Tanggal</th>
							<th>Stat</th>
						</tr>
						</thead>
						<tbody>
						<?
							$query_eta = "SELECT eta_date,revisi FROM shop_purchase 
									WHERE po_num = '$now_po_num'";
							$result_eta = mysql_query($query_eta);
							if (!$result_eta) {   error("QUERY_ERROR");   exit; }
							$eta_date = mysql_result($result_eta,0,0);
							$rev = mysql_result($result_eta,0,1);
							$dateplode = explode("|",$eta_date);
							$revi = explode("|",$rev);
							$num_row = count($dateplode);
							for($h = 0; $h < $num_row; $h++) {
								$eta_date1=$dateplode[$h];
								// 발주일
								$uday1 = substr($eta_date1,0,4);
								$uday2 = substr($eta_date1,4,2);
								$uday3 = substr($eta_date1,6,2);

								  if($lang == "ko") {
									  $order_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
									} else {
									  $order_date_txt = "$uday1"."-"."$uday2"."-"."$uday3";
									}
								?>
								<tr>
									<td>
										<?
											if ($h == 0){
												echo "Stuffing";
											}elseif($h == 1){
												echo "ETD";
											}else{
												echo "ETA";
											}
										?>
									</td>
									<td>
										
										<input  <?php if($revi[$h] == 2) echo "readonly"; ?> type='text' class='form-control' name='eta_dates[]' placeholder="YYYY-MM-DD" value='<?  echo $order_date_txt;?>' >
										
									</td>
									<td>
										<select name='revisi[]' class='form-control'>
											<option value="1" <?php if($revi[$h] == 2) echo "hidden"; ?>>none</option>
											<option value="2" <?php if($revi[$h] == 2) echo "selected"; ?>>done</option>
										</select>
									</td>
								</tr>
								<?
							}
						?>
						<input type='hidden' class='form-control' name='eta_up' value='eta_up' >
						<input type='hidden' class='form-control' name='po' value='<?echo $now_po_num?>' >
						</tbody>
						</table>
						<input type='submit' value="Update" class="btn btn-primary">
						</form>
					</section>
				</div>
				</section>
				</div>
				</div>
				<?
		}
		if($eta_up == "eta_up") { 
		
			
			$date = implode("|",$eta_dates);
			$dates = explode("-",$date);
			$etadate = implode("",$dates);
			$revisi=$_POST['revisi'];
			$revision = implode("|",$revisi);
			#var_dump($revision);
			$result_eta = mysql_query("UPDATE shop_purchase SET eta_date='$etadate',revisi='$revision' WHERE po_num = '$po'",$dbconn);
			if(!$result_eta) { error("QUERY_ERROR"); exit; }
		}
		// Shopping Cart
		
		
		if($total_HC > "0" OR ($mode == "show_cart" OR $mode == "order_form")) {
		?>
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_invn_purchase_13?>
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
				<th><?=$txt_invn_stockin_36?></th>
				<th>CBM</th>
				<th><?=$txt_sales_sales_10?> (<?=$po_currency?>)</th>
				<!--<th><?=$txt_comm_frm12?></th>-->
				<th><?=$txt_comm_frm13?></th>
			</tr>
			</thead>
		
			<tbody>
			
	  <?
	  $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
				p_name,p_price,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency,org_pcode,org_barcode,cbm FROM shop_cart 
				WHERE user_id = '$login_id' AND f_class = 'out' AND expire = '0' ORDER BY date ASC";
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
		  $total_qty_K = number_format($total_qty);
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
		$H_org_pcode = mysql_result($result_H,$h,18);
		$H_org_barcode = mysql_result($result_H,$h,19);
		$H_cbm = mysql_result($result_H,$h,20);

		$array_uid[] = $H_cart_uid;
		$array_org_pcode[] = $H_org_pcode;
		$array_qty[] = $H_qty;
		$array_price[] = $H_p_price;
		
		#var_dump($array_org_pcode);
      
        if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
        if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
        if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
        if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
        if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
        if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
        if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
        $H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
		
      
      
        // 상품명, 상품별 결제액
        $query_dari = "SELECT uid,pname,price_orgin,tprice_orgin,stock_now,stock_sell,cbm,unit FROM shop_product_list WHERE uid = '$H_prd_uid'";
        $result_dari = mysql_query($query_dari);
        if(!$result_dari) { error("QUERY_ERROR"); exit; }
        $row_dari = mysql_fetch_object($result_dari);

        $dari_uid = $row_dari->uid;
		
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
		if($H_cbm > 0) {
			$dari_cbm = $H_cbm;
		} else {
			$dari_cbm = $row_dari->cbm;
		}
		
		// Unit
		$dari2_unit = $row_dari->unit;
		
		if($dari2_unit != "") {
			$dari2_qty_reset = 500;
			$dari2_unit_reset = $dari2_unit;
		} else {
			$dari2_qty_reset = 500;
			$dari2_unit_reset = $H_unpack_unit_name;
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
      <form name='cart_upd' method='post' action='inventory_purchase_cart.php'>
      <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
	  <input type=hidden name='H_cart_pcode' value='$H_pcode'>
      <input type=hidden name='H_cart_gate' value='$H_cart_shop'>
      <input type=hidden name='H_prd_uid' value='$dari_uid'>
      <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
      <input type=hidden name='H_prd_stock_now' value='$qty_max'>
	  <input type=hidden name='H_unpack_qty' value='$H_unpack_qty'>
	  <input type=hidden name='H_unpack_unit_uid' value='$H_unpack_unit_uid'>
	  <input type=hidden name='H_unpack_unit_qty' value='$H_unpack_unit_qty'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  <input type='hidden' name='po_currency' value='$po_currency'>
	  <input type='hidden' name='otype' value='$otype'>
	  
      
      <tr height=22>
        <td>$cart_no</td>
        <td>$H_org_pcode</td>
        <td>{$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</td>
        <td align=right><input type='text' name='new_cart_amount[]' maxlength=10 value='$dari_amount2R' class='form-control' style='WIDTH: 90px; text-align: right'></td>
        <td align=center><input type='text' name='new_cart_qty[]' maxlength=6 value='$H2_qty' class='form-control' style='WIDTH: 90px; text-align: right'></td>
		<td>$dari2_unit_reset</td>
		<td align=center><input type='text' name='new_cbm' maxlength=8 value='$dari_cbm' class='form-control' style='WIDTH: 90px; text-align: right'></td>
        <td align=right>{$dari_tamount_K}</td>
        <td><input type=checkbox name='check_list[]' value='$H_cart_uid' class='btn btn-default'></td>
		<!--<td><input type=text name='checkbox[]' value='$H_cart_uid' class='btn btn-default'></td>-->
		
		<input type=hidden name='uids[]' value='$H_cart_uid'>
		

      </tr>");
      
      $cart_no++;
      }

	  //var_dump($array_del);


	  
	  // UPDATE LOOP
	echo("<tr/>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><input type='submit' name='carts' value='Update All' class='btn btn-primary'></td>
			<td><input type='submit' name='carts' value='Delete' class='btn btn-primary'></td>
		 </form>");

		
      // 신규 상품 주문
      echo ("
      <form name='cart_newprd' method='post' action='inventory_purchase_cart.php'>
      <input type=hidden name='cart_mode' value='CART_NEW'>
	  <input type=hidden name='H_cart_pcode' value='$H_pcode'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  <input type='hidden' name='po_currency' value='$po_currency'>
	  <input type='hidden' name='otype' value='$otype'>
      
      <tr height=25>
        <td colspan=2 align=center>+</td>
        <td><input type='text' name='new_cart_pname' class='form-control' required></td>
        <td align=right><input type='text' name='new_cart_price_orgin' maxlength=10 class='form-control' style='WIDTH: 100px; text-align: right' required></td>
        <td align=center><input type='text' name='new_cart_qty' maxlength=6 value='$dari2_qty_reset' class='form-control' style='WIDTH: 90px; text-align: right' required></td>
        <td>
				<select name='unpack_unit_name' class='form-control'>
				<option value=\"\">$dari2_unit_reset</option>");
			
				$query_u1 = "SELECT count(uid) FROM shop_product_unit";
				$result_u1 = mysql_query($query_u1,$dbconn);
					if (!$result_u1) { error("QUERY_ERROR"); exit; }
      
				$total_unit = @mysql_result($result_u1,0,0);
      
				$query_u2 = "SELECT uid,unit_name FROM shop_product_unit ORDER BY unit_name ASC"; 
				$result_u2 = mysql_query($query_u2,$dbconn);
					if (!$result_u2) { error("QUERY_ERROR"); exit; }

				for($u = 0; $u < $total_unit; $u++) {
					$unit_uid = mysql_result($result_u2,$u,0);
					$unit_name = mysql_result($result_u2,$u,1);
					
					echo ("<option value='$unit_name'>$unit_name</option>");
				}
				
				echo ("
				</select>
		
		
		</td>
		<td align=center><input type='text' name='new_cbm' maxlength=8 class='form-control' style='WIDTH: 90px; text-align: right'></td>
		<td align=right><input type='text' name='unpack_unit_qty' maxlength=10 class='form-control' style='WIDTH: 85px; text-align: right' placeholder='Qty/Unit'></td>
        <td colspan=2 align=center><input type=submit value='+ $txt_invn_purchase_10' class='btn btn-default'></td>
      </tr>
      </form>");
      
      
      
      // TOTAL
      echo ("
      <form name='order_check' method='post' action='inventory_purchase.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type=hidden name='new_client' value='$H_cart_gate'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  <input type='hidden' name='otype' value='$otype'>

      <tr height=22>
        <td colspan=4 align=center>
			<input type=radio name='po_currency' value='IDR' $po_currency_IDR_chk> IDR &nbsp;&nbsp; 
			<input type=radio name='po_currency' value='USD' $po_currency_USD_chk> USD
		</td>
        <td align=center>{$total_qty_K}</td>
		<td></td>
		<td></td>
        <td align=right><font color=#000000><b>{$p_total_price_K}</b></font></td>
        <td colspan=2 align=center><input type=submit value='$txt_invn_purchase_09' class='btn btn-primary'></td>
      </tr>
      </form> 
	  </table>");
	  

	  ?>
	  	
      </section>    

	  <?
      // Order Form
	  $this_due_dates = date("Y-m-d");
	  
	  if($p_total_price < 1) {
		$order_btn_dis = "disabled";
	  } else {
	    $order_btn_dis = "";
	  }
	  $code = array_merge($array_org_pcode,$array_qty,$array_price);
	  $items = implode("|",$code);
	  //echo $pcode_RAY;
	//var_dump($pcode_RAY); die();
	  
      if($mode == "order_form") {

      echo ("
      <form name='signform' method='post' action='inventory_purchase_cart.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='cart_mode' value='ORDER'>
      <input type=hidden name='new_client' value='$new_client'>
	  <input type=hidden name='new_currency' value='$po_currency'>
      <input type=hidden name='new_branch_code' value='$login_branch'>
      <input type=hidden name='H_po' value='now_po_num'>
      <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
	  <input type=hidden name='H_cart_pcode' value='$array_org_pcode'>
      <input type=hidden name='items' value='$items'>
	  <input type=hidden name='H_price' value='$array_price'>
	  <input type=hidden name='H_total_qty' value='$total_qty'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type='hidden' name='key_shop' value='$key_shop'>
	  <input type='hidden' name='otype' value='$otype'>
      
      <table width=100% cellspacing=1 cellpadding=1 border=0>
      <tr height=22>
        <td style='BORDER: 1px solid #AAAAAA'>
            <table width=100% cellspacing=0 cellpadding=0 border=0>
            <tr><td colspan=8 height=16></td></tr>");
			
			if($now_group_admin == "1") {
            
			echo ("
			<tr>
              <td width=2%></td>
              <td width=17% height=20 bgcolor=#EFEFEF align=right>$txt_comm_frm23 &nbsp;</td>
              <td width=1%></td>
              <td width=30%>");
              
                  // Branch
                  $query_A1C = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
                  $result_A1C = mysql_query($query_A1C);
                  if (!$result_A1C) { error("QUERY_ERROR"); exit; }
    
                  $total_A1C = @mysql_result($result_A1C,0,0);

                  $query_B1 = "SELECT uid,branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY branch_code ASC";
                  $result_B1 = mysql_query($query_B1);
                  if (!$result_B1) { error("QUERY_ERROR"); exit; }
                  
                  echo("<select name='new_branch_code' class='form-control' style='WIDTH: 300px'>");
				  
                  for($a1 = 0; $a1 < $total_A1C; $a1++) {
                    $A1_uid = mysql_result($result_B1,$a1,0);
                    $A1_code = mysql_result($result_B1,$a1,1);
                    $A1_corp_name = mysql_result($result_B1,$a1,2);
					
					if($A1_code == $login_branch) {
						$A1_code_slct = "selected";
					} else {
						$A1_code_slct = "";
					}
                    
                    echo ("<option value='$A1_code' $A1_code_slct>$A1_corp_name</option>");
                  }
                  echo ("</select>");
              
              echo ("
              </td>
            </tr>
            <tr><td colspan=8 height=6></td></tr>");
			
			}
			
			
			echo ("
			<tr>
              <td width=2%></td>
              <td width=17% height=20 bgcolor=#EFEFEF align=right>$txt_sales_sales_13 &nbsp;</td>
              <td width=1%></td>
              <td width=30%>");
              
                  // Client 이름
                  $query_C1C = "SELECT count(uid) FROM client_supplier WHERE userlevel > '0'";
                  $result_C1C = mysql_query($query_C1C);
                  if (!$result_C1C) { error("QUERY_ERROR"); exit; }
    
                  $total_C1C = @mysql_result($result_C1C,0,0);

                  $query_C1 = "SELECT uid,supp_code,supp_name FROM client_supplier WHERE userlevel > '0' ORDER BY supp_name ASC";
                  $result_C1 = mysql_query($query_C1);
                  if (!$result_C1) { error("QUERY_ERROR"); exit; }
                  
                  echo("<select name='new_buyer_code' class='form-control' style='WIDTH: 200px'>");
                  echo("<option value=''>:: $txt_comm_frm19</option>");
    
                  for($c1 = 0; $c1 < $total_C1C; $c1++) {
                    $C1_uid = mysql_result($result_C1,$c1,0);
                    $C1_code = mysql_result($result_C1,$c1,1);
                    $C1_corp_name = mysql_result($result_C1,$c1,2);
                    
                    echo ("<option value='$C1_code'>$C1_corp_name</option>");
                  }
                  echo ("</select>");
              
              echo ("
              </td>
              <td width=17% bgcolor=#EFEFEF align=right>$txt_sales_sales_11 &nbsp;</td>
              <td width=1%></td>
              <td width=30%><input readonly type=text name='new_amount' value='$po_currency $p_total_price_K' class='form-control' style='WIDTH: 200px; text-align: right'>
              <td width=2%></td>
            </tr>
            <tr><td colspan=8 height=6></td></tr>
            
            
            <tr>
              <td></td>
              <td height=20 bgcolor=#EFEFEF align=right>$txt_invn_payment_20 &nbsp;</td>
              <td></td>
              <td>");
                
                
                $query_K1C = "SELECT count(uid) FROM code_card WHERE userlevel > '0'";
                $result_K1C = mysql_query($query_K1C);
                $total_K1C = @mysql_result($result_K1C,0,0);
                
                $query_K1 = "SELECT card_code,card_name FROM code_card WHERE userlevel > '0' ORDER BY card_code ASC";
                $result_K1 = mysql_query($query_K1);
                
                echo ("<select name='new_pay_card' class='form-control' style='WIDTH: 200px'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($w1 = 0; $w1 < $total_K1C; $w1++) {
                  $card_code = mysql_result($result_K1,$w1,0);
                  $card_name = mysql_result($result_K1,$w1,1);
                
                  echo ("<option value='$card_code'>$card_name</option>");
                }
                echo ("</select>
              </td>
              <td bgcolor=#EFEFEF align=right>$txt_invn_payment_21 &nbsp;</td>
              <td></td>
              <td>");
                
                
                $query_K2C = "SELECT count(uid) FROM code_bank WHERE userlevel > '0'";
                $result_K2C = mysql_query($query_K2C);
                $total_K2C = @mysql_result($result_K2C,0,0);
                
                $query_K2 = "SELECT bank_code,bank_name FROM code_bank WHERE userlevel > '0' ORDER BY bank_code ASC";
                $result_K2 = mysql_query($query_K2);
                
                echo ("<select name='new_shop_bank' class='form-control' style='WIDTH: 200px'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($w2 = 0; $w2 < $total_K2C; $w2++) {
                  $bank_code = mysql_result($result_K2,$w2,0);
                  $bank_name = mysql_result($result_K2,$w2,1);
                
                  echo ("<option value='$bank_code'>$bank_name</option>");
                }
                echo ("</select>
              </td>
              <td></td>
            </tr>
            <tr><td colspan=8 height=6></td></tr>
			
            <tr>
              <td></td>
              <td height=20 bgcolor=#EFEFEF align=right>$txt_invn_payment_16 &nbsp;</td>
              <td></td>
              <td><input type=text name='new_pay_bank' class='form-control' style='WIDTH: 200px'></td>
              <td bgcolor=#EFEFEF align=right>$txt_invn_payment_13 &nbsp;</td>
              <td></td>
              <td><input type=text name='new_remit_code' class='form-control' style='WIDTH: 200px'></td>
              <td></td>
            </tr>
            <tr><td colspan=8 height=6></td></tr>
			
			<!--
			<tr>
              <td></td>
              <td height=20 bgcolor=#EFEFEF align=right>$txt_invn_stockout_42 &nbsp;</td>
              <td></td>
              <td>");
			  
				$query_p1c = "SELECT count(uid) FROM code_port WHERE p_type = '1' OR p_type = '0'";
                $result_p1c = mysql_query($query_p1c);
                $total_p1c = @mysql_result($result_p1c,0,0);
                
                $query_p1 = "SELECT port_code,port_name FROM code_port WHERE p_type = '1' OR p_type = '0' ORDER BY port_name ASC";
                $result_p1 = mysql_query($query_p1);
                
                echo ("<select name='do_port1' class='form-control' style='WIDTH: 200px'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($p1 = 0; $p1 < $total_p1c; $p1++) {
                  $port_code1 = mysql_result($result_p1,$p1,0);
                  $port_name1 = mysql_result($result_p1,$p1,1);
                
                  echo ("<option value='$port_code1'>$port_name1</option>");
                }
                echo ("</select>
			  
			  </td>
              <td bgcolor=#EFEFEF align=right>$txt_invn_stockout_431 &nbsp;</td>
              <td></td>
              <td>");
			  
				$query_p2c = "SELECT count(uid) FROM code_port WHERE p_type = '2' OR p_type = '0'";
                $result_p2c = mysql_query($query_p2c);
                $total_p2c = @mysql_result($result_p2c,0,0);
                
                $query_p2 = "SELECT port_code,port_name FROM code_port WHERE p_type = '2' OR p_type = '0' ORDER BY port_name ASC";
                $result_p2 = mysql_query($query_p2);
                
                echo ("<select name='do_port2' class='form-control' style='WIDTH: 200px'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($p2 = 0; $p2 < $total_p2c; $p2++) {
                  $port_code2 = mysql_result($result_p2,$p2,0);
                  $port_name2 = mysql_result($result_p2,$p2,1);
                
                  echo ("<option value='$port_code2'>$port_name2</option>");
                }
            //var_dump($po_currency.'--'.$li_currency);
            if ($po_currency == "USD") {

			echo ("-->
			<tr>
              <td></td>
              <td height=20 bgcolor=#EFEFEF align=right>$txt_sales_sales_27 &nbsp;</td>
              <td></td>
              <td><input type=date name='new_due_dates' value='$this_due_dates' class='form-control' style='WIDTH: 200px'></td>
              <td></td>			
			</tr>
			
			<tr>
			  <td></td>
              <td colspan=6><input $order_btn_dis type='submit' value='$txt_invn_purchase_11' class='btn btn-primary'></td>
			  <td></td>
			</tr>
			<tr><td colspan=8 height=16></td></tr>
            </table>
				</td>
			  </tr>
		      </table>
		      </form>");
            } else {
				//$this_due_dates = date("Y-m-d");
                echo ("<!--</select>
			  
			  </td>
              <td></td>
            </tr>
            <tr><td colspan=8 height=6></td></tr>
			-->
			
           
            <tr>
              <td></td>
              <td height=20 bgcolor=#EFEFEF align=right>$txt_sales_sales_27 &nbsp;</td>
              <td></td>
              <td><input type=date name='new_due_dates' value='$this_due_dates' class='form-control' style='WIDTH: 200px'></td>
              <td height=20 bgcolor=#EFEFEF align=right>Tax &nbsp;</td>
              <td></td>
			 
			  <td>
				<input type=radio name='po_tax' value='1'> VAT &nbsp;&nbsp; 
				<input type=radio name='po_tax' value='0' checked> non VAT
			  </td>
			  
			  <td></td>
			</tr>
			<tr><td colspan=8 height=16></td></tr>
			
			<tr>
			  <td></td>
              <td colspan=6><input $order_btn_dis type='submit' value='$txt_invn_purchase_11' class='btn btn-primary'></td>
			  <td></td>
			</tr>
			<tr><td colspan=8 height=16></td></tr>
            </table>
		</td>
	  </tr>
      </table>
      </form>");
            }
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
	
	<script src="js/jquery.donutchart.js"></script>
	
	<script>
	(function () {

        $("#donutchart1").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
        $("#donutchart2").donutchart("animate");

        $("#donutchart3").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart3").donutchart("animate");

        $("#donutchart4").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");
		
		$("#donutchart6").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart6").donutchart("animate");
		
		$("#donutchart7").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart7").donutchart("animate");

    }());
	
	function formatAmountNoDecimals( number ) {
    var rgx = /(\d+)(\d{3})/;
    while( rgx.test( number ) ) {
        number = number.replace( rgx, '$1' + ',' + '$2' );
    }
    return number;
}

function formatAmount( number ) {

    // remove all the characters except the numeric values
    
    regex = /\./g;
    if (regex.test(number) == true){
    	number = number.replace( /[^0-9]/g, '' );
    	number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );
    	// set the precision
    	number = new Number( number );
    	number = number.toFixed( 2 );    // only works with the "."
    	// change the splitter to "."
    	number = number.replace( /\./g, '.' );
    }else{
    	number = number.replace( /[^0-9]/g, '' );
    	 // set the default value
    	if(number.length == 0 ) number = "0";
    	//else if(number.length == 1 ) number = number + ".00";
   		//else if( number.length == 2 ) number = number + ".00";
    }
    // format the amount
    x = number.split( '.' );
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';

    return formatAmountNoDecimals( x1 ) + x2;
}


$(function() {
	<?php for ($x=1 ; $x < 10 ; $x++){?>
		$( '.amount<?php echo $x ?>' ).keyup( function() {
			//$(this ).val( formatAmount( $(this).val() ) ); //in input tag
			$('.displayamount<?php echo $x?>').text(
				formatAmount($(this).val())
			);
		});
	<?php } ?>
});	
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
            values ('','$new_prd_uid','$br_branch_code','$new_gudang_code','out','$login_id','$m_ip',
            '$new_prd_code','$new_stock_org','$new_product_color','$new_product_size',
            '$new_product_option1','$new_product_option2','$new_product_option3','$new_product_option4','$new_product_option5',
            '0','$post_dates','$new_pay_num')";
        $result_C2 = mysql_query($query_C2);
        if (!$result_C2) { error("QUERY_ERROR"); exit; }

        // 결제 정보 테이블에 정보 입력 + // 인보이스 발행
        $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date,
            loan_flag,loan_trans_code,invoice_dates,invoice_print) 
            values ('','$new_branch_code','$new_gudang_code','$new_supp_code','out','$new_pay_num','$new_bank_name',
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
            values ('','$new_prd_uid','$br_branch_code','$new_gudang_code','out','$login_id','$m_ip',
            '$new_prd_code','$new_stock_org','$new_product_color','$new_product_size',
            '$new_product_option1','$new_product_option2','$new_product_option3','$new_product_option4','$new_product_option5',
            '0','$post_dates','$new_pay_num')";
        $result_C2 = mysql_query($query_C2);
        if (!$result_C2) { error("QUERY_ERROR"); exit; }

        // 결제 정보 테이블에 정보 입력
        $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date) 
            values ('','$new_branch_code','$new_gudang_code','$new_supp_code','out','$new_pay_num','$new_bank_name',
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
    echo("<meta http-equiv='Refresh' content='0; URL=inventory_payment.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&otype=$otype'>");
    exit;


  } else if($add_mode == "LIST_PAY") {
  
      
      // 상품 정보 추출 및 수정
      $query_RC = "SELECT count(uid) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND flag = 'in' AND pay_status = '0'";
      $result_RC = mysql_query($query_RC,$dbconn);
      if (!$result_RC) { error("QUERY_ERROR"); exit; }
      
      $total_RC = @mysql_result($result_RC,0,0);
      
      $query_R1 = "SELECT uid,pcode,branch_code,gudang_code,supp_code,stock FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND flag = 'in' AND pay_status = '0' ORDER BY uid ASC";
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
            '$r_branch_code','$r_gudang_code','out','$login_id','$m_ip','$r_code','$r_stock_org',
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
        values ('','$login_branch','$login_gate','$new_supp_code','out','$new_pay_num','$new_pay_type','1',
        '$r_total_price_orgin','$r_total_price_orgin','0','0','$post_dates')";
      $result_P2 = mysql_query($query_P2);
      if (!$result_P2) { error("QUERY_ERROR"); exit; }
    // }

  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=inventory_payment2.php'>");
    exit;
  
  }
  

}

}
?>