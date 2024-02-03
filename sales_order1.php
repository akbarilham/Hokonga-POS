<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
if(isset($_POST['key']) ){// new code for step_next post
$key = $_POST['key'];
}
if (isset($_POST['key_shop'])) {
  $key_shop = $_POST['key_shop'];
}
if (isset($_POST['sorting_key'])) {
  $sorting_key = $_POST['sorting_key'];
}
if (isset($_POST['keyfield'])) {
  $keyfield = $_POST['keyfield'];
}
if(isset($_POST['mode'])){
  $mode = $_POST['mode'];
} 
if(isset($_POST['page'])){
  $page = $_POST['page'];
} 
$step_next = false;
if(isset($_POST['new_buyer_type'])){
  $new_buyer_type = $_POST['new_buyer_type'];
}
if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
} // new code for step_next post
if(isset($_POST['add_mode'])){
 $add_mode = $_POST['add_mode'];
} // new code for step_next post
if(isset($_POST['new_cart_qty'])){
  $new_cart_qty = $_POST['new_cart_qty'];
}



$mmenu = "sales";
$smenu = "sales_order1";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/sales_order1.php?sorting_key=$sorting_key&key_shop=$key_shop";
$link_upd = "$home/sales_order1.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page";
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
  if($key_shop != "") {
    $sorting_filter = "branch_code = '$login_branch' AND shop_code = '$key_shop'";
    $sorting_filter_SHOP = "branch_code = '$login_branch'";
  } else {
    $sorting_filter = "branch_code = '$login_branch'";
    $sorting_filter_SHOP = "branch_code = '$login_branch'";
  }
} else {
  $sorting_filter = "branch_code = '$login_branch' AND shop_code = '$login_shop'";
  $sorting_filter_SHOP = "branch_code = '$login_branch' AND shop_code = '$login_shop'";
}


if(!$sorting_key) { $sorting_key = "pname"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "gname") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "pname") { $chk6 = "selected"; } else { $chk6 = ""; }
if($sorting_key == "org_pcode") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "org_barcode") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "post_date") { $chk5 = "selected"; } else { $chk5 = ""; }


// Supplier Code
$query_prv = "SELECT prd_code FROM client_branch WHERE branch_code = '$login_branch'";
$result_prv = mysql_query($query_prv);
if(!$result_prv) { error("QUERY_ERROR"); exit; }
$row_prv = mysql_fetch_object($result_prv);

$prv_entry = $row_prv->prd_code;


if(!$page) { 
  if(isset($_GET['page'])){
    $page = intval($_GET['page']); //get value from url
    if(intval($_GET['page'])==null){
      $page = 1;
    }else{
      $page = intval($_GET['page']); 
    }
  }else{
    $page = 1;
  }
}


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_list_shop WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list_shop WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  if($keyfield == "all") {
	$query = "SELECT count(uid) FROM shop_product_list_shop WHERE $sorting_filter AND (org_pcode LIKE '%$key%' OR gname LIKE '%$key%' OR pname LIKE '%$key%')";
  } else {
	$query = "SELECT count(uid) FROM shop_product_list_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
  }
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


// Shop Name
$query_shn = "SELECT shop_name FROM client_shop WHERE shop_code = '$login_shop' AND branch_code = '$login_branch'";
$result_shn = mysql_query($query_shn);
if (!$result_shn) {   error("QUERY_ERROR");   exit; }
    
$shop_name = @mysql_result($result_shn,0,0);


// 장바구니에 담긴 상품 수
$query_HC = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);
?>
    
						
		<!--body wrapper start-->
        <div class="wrapper">
		
		
		<? if($mode != "order_form") { ?>
		
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_02_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
			
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='sales_order1.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='org_pcode'>Original Code</option>
				<option value='org_barcode'>Original Barcode</option>
				<option value='pcode'>$txt_invn_stockin_06</option>
				<option value='pname'>$txt_invn_stockin_05</option>
				<option value='post_date'>$txt_invn_stockin_18</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			</form>
			
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='sales_order1.php'>
			<input type='hidden' name='keyfield' value='all'>
			<div class='col-sm-3'>
				<input type='text' name='key' value='$key' class='form-control'> 
			</div>
			</form>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=pname&keyfield=$keyfield&key=$key'>$txt_invn_stockin_05</option>
			<option value='$PHP_SELF?sorting_key=gname&keyfield=$keyfield&key=$key' $chk2>$txt_invn_stockin_04</option>
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=org_pcode&keyfield=$keyfield&key=$key' $chk3>$txt_invn_stockin_30</option>
			<option value='$PHP_SELF?sorting_key=org_barcode&keyfield=$keyfield&key=$key' $chk4>Original Barcode</option>
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key' $chk5>$txt_invn_stockin_18</option>
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
            <th><?=$txt_invn_stockin_06?></th>
            <th><?=$txt_invn_stockin_05?></th>
			<th><?=$txt_invn_stockin_12?></th>
			<th>Stock</th>
			<th>Sold</th>
			<th>Remains</th>
			<th colspan=2><?=$txt_sales_sales_04?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 합계 구하기
if(!eregi("[^[:space:]]+",$key)) {
		$query_sumA = "SELECT sum(qty_org),sum(qty_sell),sum(qty_now) FROM shop_product_list_shop 
					WHERE $sorting_filter";
} else {
	if($keyfield == "all") {
		$query_sumA = "SELECT sum(qty_org),sum(qty_sell),sum(qty_now) FROM shop_product_list_shop 
					WHERE $sorting_filter AND (org_pcode LIKE '%$key%' OR gname LIKE '%$key%' OR pname LIKE '%$key%')";
	} else {
		$query_sumA = "SELECT sum(qty_org),sum(qty_sell),sum(qty_now) FROM shop_product_list_shop 
					WHERE $sorting_filter AND $keyfield LIKE '%$key%'";
	}
}
$result_sumA = mysql_query($query_sumA);
if (!$result_sumA) { error("QUERY_ERROR"); exit; }

$sum_qty_org = @mysql_result($result_sumA,0,0);
$sum_qty_org_K = number_format($sum_qty_org);

$sum_qty_sell = @mysql_result($result_sumA,0,1);
$sum_qty_sell_K = number_format($sum_qty_sell);

$sum_qty_now = @mysql_result($result_sumA,0,2);
$sum_qty_now_K = number_format($sum_qty_now);

echo ("
<tr>
  <td colspan=3 align=center>Total</td>
  <td align=right></td>
  <td align=right><font color=#000000><b>$sum_qty_org_K</b></font></td>
  <td align=right><font color=#000000><b>$sum_qty_sell_K</b></font></td>
  <td align=right><font color=#000000><b>$sum_qty_now_K</b></font></td>
  <td colspan=2>&nbsp;</td>
</tr>
");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
		$query = "SELECT uid,shop_code,catg_code,pcode,pname,price_orgin,price_sale,price_market,
				qty_org,qty_now,qty_sell,sold_out,product_color,product_size,
				product_option1,product_option2,product_option3,product_option4,product_option5,org_pcode,org_barcode,gname FROM shop_product_list_shop 
				WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
	if($keyfield == "all") {
		$query = "SELECT uid,shop_code,catg_code,pcode,pname,price_orgin,price_sale,price_market,
				qty_org,qty_now,qty_sell,sold_out,product_color,product_size,
				product_option1,product_option2,product_option3,product_option4,product_option5,org_pcode,org_barcode,gname FROM shop_product_list_shop 
				WHERE $sorting_filter AND (org_pcode LIKE '%$key%' OR gname LIKE '%$key%' OR pname LIKE '%$key%') ORDER BY $sorting_key $sort_now";
	} else {
		$query = "SELECT uid,shop_code,catg_code,pcode,pname,price_orgin,price_sale,price_market,
				qty_org,qty_now,qty_sell,sold_out,product_color,product_size,
				product_option1,product_option2,product_option3,product_option4,product_option5,org_pcode,org_barcode,gname FROM shop_product_list_shop 
				WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
	}
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_gate = mysql_result($result,$i,1);
   $prd_catg = mysql_result($result,$i,2);
   $prd_code = mysql_result($result,$i,3);
   $prd_name = mysql_result($result,$i,4);
   $prd_price_orgin = mysql_result($result,$i,5);
      $prd_price_orgin_K = number_format($prd_price_orgin);
   $prd_price_sale = mysql_result($result,$i,6);
      $prd_price_sale_K = number_format($prd_price_sale);
   $prd_price_margin = mysql_result($result,$i,7);
      $prd_price_margin_K = number_format($prd_price_margin);
   $prd_qty_org = mysql_result($result,$i,8);
   $prd_qty_now = mysql_result($result,$i,9);
   $prd_qty_sell = mysql_result($result,$i,10);
   $prd_sold_out = mysql_result($result,$i,11);
   $prd_color = mysql_result($result,$i,12);
   $prd_size = mysql_result($result,$i,13);
   $H_p_opt1 = mysql_result($result,$i,14);
   $H_p_opt2 = mysql_result($result,$i,15);
   $H_p_opt3 = mysql_result($result,$i,16);
   $H_p_opt4 = mysql_result($result,$i,17);
   $H_p_opt5 = mysql_result($result,$i,18);
   $H_org_pcode = mysql_result($result,$i,19);
   $H_org_barcode = mysql_result($result,$i,20);
   $prd_gname = mysql_result($result,$i,21);
		$prd_gname = stripslashes($prd_gname);
   

      // 기타 옵션
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
   
   
   // 현재 재고 수량
   
      
   // 매진 표시
   if($prd_qty_now == "0" OR $prd_sold_out == "1") {
    $soldout_icon = "<i class='fa fa-ban'></i>";
   } else {
    $soldout_icon = "";
   }
   
   // 폰트 칼라
   if($prd_qty_now == "0") {
      $prd_font_color = "red";
   } else {
      $prd_font_color = "#0066CC";
   }

   // 줄 색깔
   if($uid == $prd_uid AND ( $mode == "search" OR $mode == "order" )) {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }
    
    // 상품 색상과 크기
    if($prd_color != "") {
      $prd_color_txt = "[$prd_color]";
    } else {
      $prd_color_txt = "";
    }
    if($prd_size != "") {
      $prd_size_txt = "[$prd_size]";
    } else {
      $prd_size_txt = "";
    }
    
    
    // Expired Date
    $query_ex = "SELECT date_expire FROM shop_product_list_qty WHERE pcode = '$prd_code' ORDER BY date_expire DESC";
    $result_ex = mysql_query($query_ex);
    if(!$result_ex) { error("QUERY_ERROR"); exit; }
    $date_expire = @mysql_result($result_ex,0,0);
      $date_ex1 = substr($date_expire,0,4);
      $date_ex2 = substr($date_expire,4,2);
      $date_ex3 = substr($date_expire,6,2);
    
    // 오늘날짜로부터 남은날수
    $date_now = date("Ymd");
    $date_now1 = date("Y");
    $date_now2 = date("m");
    $date_now3 = date("d");
    
    $date_rm1 = $date_ex1 - $date_now1;
    $date_rm2 = $date_ex2 - $date_now2;
    $date_rm3 = $date_ex3 - $date_now3;
    
    if($date_expire > 0) {
    if($date_now > $date_expire) {
      $date_color = "red";
      $date_rms = "x";

    } else {
      $date_color = "#006699";
        if($date_rm1 > 0) {
          $date_rm2s = $date_rm2 + ($date_rm1 * 12);
        } else {
          $date_rm2s = $date_rm2;
        }
        if($date_rm2s > 0) {
          $date_rms = "30+";
        } else {
          $date_rms = $date_rm3;
        }
    }
    } else {
      $date_color = "#FFFFFF";
          $date_rms = "";
    }
	
	// Badge
	if($date_expire > 0) {
    if($date_now > $date_expire) {
		$sales_badge = "<span class='badge badge-warning'>$date_rms</span>";
	} else {
		$sales_badge = "<span class='badge badge-success'>$date_rms</span>";
	}
	} else {
		$sales_badge = " ";
	}
	
	
	
	
    

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  
  // echo("<td bgcolor='$highlight_color'>{$prd_gate}</td>");
  echo("<td bgcolor='$highlight_color'>{$H_org_pcode}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=search&uid=$prd_uid' data-placement='top' 
		data-toggle='tooltip' class='tooltips' data-original-title='[$prd_code] $prd_gname'>{$prd_name} 
          {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a> {$soldout_icon} $sales_badge</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_price_sale_K}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_qty_org}</td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='#0066CC'>{$prd_qty_sell}</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='$prd_font_color'>{$prd_qty_now}</td>");
  
	// Cart
	$query_H2 = "SELECT uid,pcode,qty,unpack_qty,unpack_unit_uid,unpack_unit_qty,unpack_unit_name,currency FROM shop_cart 
				WHERE user_id = '$login_id' AND pcode = '$prd_code' AND f_class = 'in' AND expire = '0' ORDER BY date ASC";
    $result_H2 = mysql_query($query_H2);
      if (!$result_H2) {   error("QUERY_ERROR");   exit; }
      
    $H2_cart_uid = @mysql_result($result_H2,0,0);
    $H2_pcode = @mysql_result($result_H2,0,1);
    $H2_qty = @mysql_result($result_H2,0,2);
	$H2_unpack_qty = @mysql_result($result_H2,0,3);
	$H2_unpack_unit_uid = @mysql_result($result_H2,0,4);
	$H2_unpack_unit_qty = @mysql_result($result_H2,0,5);
	$H2_unpack_unit_name = @mysql_result($result_H2,0,6);
	$H2_currency = @mysql_result($result_H2,0,7);
	
	if($prd_qty_now < 1) {
		$H_sumbit_dis = "disabled";
	} else {
		$H_sumbit_dis = "";
	}
	
	if($H2_cart_uid > 0) {
		
	echo ("
	<form name='p_cart_dtl_del' method='post' action='sales_order_cart1.php'>
	<input type=hidden name='cart_mode' value='CART_DEL'>
	<input type=hidden name='H_cart_uid' value='$H2_cart_uid'>
	<input type=hidden name='sorting_key' value='$sorting_key'>
	<input type=hidden name='key_shop' value='$key_shop'>
	<input type=hidden name='keyfield' value='$keyfield'>
	<input type=hidden name='key' value='$key'>
	<input type=hidden name='page' value='$page'>
	
	<td bgcolor='$highlight_color'><input type='text' name='cart_qty' value='$H2_qty' maxlength=6  
				style='border: 1px solid #006699; background-color: #efefef; color: #006699; width:60px; height: 20px; padding-right: 5px; text-align: right'></td>
	<td><input type='submit' value='-' class='btn btn-default btn-xs' style='color: red;'></td>
	</form>");
	
	} else {
		
  
	echo ("
	<form name='p_cart_dtl_add' method='post' action='sales_order_cart1.php'>
	<input type=hidden name='cart_mode' value='CART_ADD'>
	<input type=hidden name='cart_prd_uid' value='$prd_uid'>
	<input type=hidden name='cart_prd_code' value='$prd_code'>
	<input type=hidden name='cart_prd_name' value='$prd_pname'>
	<input type=hidden name='cart_org_pcode' value='$org_pcode'>
	<input type=hidden name='cart_org_barcode' value='$org_barcode'>
	<input type=hidden name='cart_price_sale' value='$prd_price_sale'>
	<input type=hidden name='sorting_key' value='$sorting_key'>
	<input type=hidden name='key_shop' value='$key_shop'>
	<input type=hidden name='keyfield' value='$keyfield'>
	<input type=hidden name='key' value='$key'>
	<input type=hidden name='page' value='$page'>
	<input type=hidden name='cart_opt1' value='$H_p_opt1'>
	<input type=hidden name='cart_opt2' value='$H_p_opt2'>
	<input type=hidden name='cart_opt3' value='$H_p_opt3'>
	<input type=hidden name='cart_opt4' value='$H_p_opt4'>
	<input type=hidden name='cart_opt5' value='$H_p_opt5'>
	<input type=hidden name='cart_cbm' value='$H_cbm'>
	
	<td bgcolor='$highlight_color'><input $H_sumbit_dis type='text' name='cart_qty' value=\"\" maxlength=6 value='10' 
				style='width:60px; height: 20px; padding-right: 5px; text-align: right' required></td>
	<td><input $H_sumbit_dis type='submit' value='+' class='btn btn-default btn-xs'></td>
	</form>");
	
	
	}
  
  
  
  echo("</tr>");
  
   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
		
			<br />
			<div class="row">
			<div class="col-sm-2">
				<?
				if($mode == "") { // 상품 업데이트 버튼
          
				echo ("
				<form name='product_update_all' method='post' action='sales_order1.php'>
				<input type='hidden' name='step_next' value='permit_okay'>
				<input type='hidden' name='add_mode' value='update_all'>
				
				<div class='form-actions'>
					<input type='submit' class='btn btn-primary' value='$txt_comm_frm29'>
				</div>
				</form>");
				
				}
				?>
			</div>
			
			<div class="col-sm-2">
				<? if($total_HC > "0") { ?>
          
				<div class="form-actions">
					<a href="sales_order1.php"><button class="btn btn-danger"><i class="fa fa-shopping-cart"></i> <?=$txt_sales_sales_05?></button></a>
				</div>
				
				<? } ?>
			</div>
			
			
			<div class="col-sm-8" align=right>
			
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
			</div>
			
        </div>
		
        </section>
		</div>
		</div>
		
	
		<? } ?>


		
		
		
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Shopping Cart
			
            
        </header>
		
        <div class="panel-body">
		
		<?
		// 현금/론 구분

     if(!$stat) {
        if(isset($_POST['btn_hutang'])){
          $stat = "credit";
        } else if(isset($_POST['btn_kas'])) {
          $stat = "cash";
        } else {
          $stat = $_POST['stat'];
        }
      }
 
      
      
      // 장바구니
      if($total_HC > "0" AND ($mode == "" OR $mode == "order_form")) {
      
      $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
                  shop_code,p_price,p_saleprice FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' 
                  ORDER BY pcode ASC";
      $result_H = mysql_query($query_H);
      if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
        $H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
		?>
		
		

		
		
	  <?
	  echo ("
	  <div class='row'>
		<div class='col-sm-6'>&raquo; $now_branch_name &gt; $login_gate</div>
		<div class='col-sm-6 pull-right'><input type=radio name=dischek value='1' checked> <b>$stat</b></div>
	  </div>
	  
	  <span>&nbsp;</span>
	  
	  <section id='unseen'>
		<table class='table table-bordered table-striped table-condensed'>
        <thead>
		<tr>
			<th>#</th>
			<th>$txt_invn_stockin_06</th>
			<th>$txt_invn_stockin_05</th>
			<th>$txt_sales_sales_09</th>
			<th>$txt_invn_stockin_17</th>
			<th>$txt_sales_sales_10</th>
			<th>$txt_comm_frm12</th>
			<th>$txt_comm_frm13</th>
		</tr>
		</thead>
		
		<tbody>
		");

    
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
        $H_cart_shop_code = mysql_result($result_H,$h,11);
        $H_p_price = mysql_result($result_H,$h,12);
        $H_p_saleprice = mysql_result($result_H,$h,13);
		
		$H2_gcode = substr($H_pcode,0,7);
   
			$query_gnam2 = "SELECT gname,pname,org_pcode,price_sale FROM shop_product_list WHERE pcode = '$H_pcode'";
			$result_gnam2 = mysql_query($query_gnam2);
   
			$prd_gname2 = @mysql_result($result_gnam2,0,0);
				$prd_gname2 = stripslashes($prd_gname2);
			$prd_pname2 = @mysql_result($result_gnam2,0,1);
				$prd_pname2 = stripslashes($prd_pname2);
			$org_pcode2 = @mysql_result($result_gnam2,0,2);
			$price_sale2 = @mysql_result($result_gnam2,0,3);
				$price_sale2_K = number_format($price_sale2);

      
        if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
        if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
        if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
        if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
        if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
        if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
        if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
        $H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
      
      
      
				// 상품명, 상품별 결제액
				$query_li = "SELECT uid,pname,qty_now,qty_sell,price_sale,price_orgin,price_market FROM shop_product_list_shop 
							WHERE pcode = '$H_pcode' AND shop_code = '$login_shop' ORDER BY uid DESC";
                $result_li = mysql_query($query_li);
                  if (!$result_li) {   error("QUERY_ERROR");   exit; }
                $li_uid = @mysql_result($result_li,0,0);
				$li_pname = @mysql_result($result_li,0,1);
					$li_pname = stripslashes($li_pname);
				$li_stock_now = @mysql_result($result_li,0,2);
				$li_stock_sell = @mysql_result($result_li,0,3);
				$li_price_sale = @mysql_result($result_li,0,4);
					$li_price_sale_K = number_format($li_price_sale);
				$harga_orgin = @mysql_result($result_li,0,5);
				$harga_faktur = @mysql_result($result_li,0,6);
				
				// Maximum Quantity
				$qty_max = $li_stock_now + $H_qty; // 재고와 카트의 주문수량의 합 (주문 가능한 수량의 최대값, 본래의 재고량)
				$qty_sold = $li_stock_sell - $H_qty; // 판매량에서 카트의 주문수량을 공제 (본래의 판매량)
				
				
				// Total
				$li_tprice_sale = $li_price_sale * $H_qty;
					$li_tprice_sale_K = number_format($li_tprice_sale);
				  
				  
				// Grand Total
                $p_total_price = $p_total_price + ($li_price_sale * $H_qty);
                $p_total_price_K = number_format($p_total_price);
          
      

      echo ("
      <form name='cart_upd' method='post' action='sales_order_cart1.php'>
      <input type=hidden name='cart_mode' value='CART_UPD'>
	  <input type=hidden name='sub_type' value='1'>
      <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
	  <input type=hidden name='harga_orgin' value='$harga_orgin'>
      <input type=hidden name='harga_faktur' value='$harga_faktur'>
	  <input type=hidden name='harga_jual' value='$li_price_sale'>
      <input type=hidden name='H_shop_uid' value='$li_uid'>
      <input type=hidden name='H_prd_code' value='$H_pcode'>
      <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
      <input type=hidden name='H_prd_stock_now' value='$qty_max'>
      <input type='hidden' name='key_shop' value='$key_shop'>
      <input type='hidden' name='page' value='$page'>
      <input type='hidden' name='stat' value='$stat'>

      
      <tr height=22>
        <td>$cart_no</td>
        <td>$org_pcode2</td>
        <td><a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' 
			data-original-title='[$H2_gcode] $prd_gname2'>{$prd_pname2} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a></td>");
        if($stat == "cash") {
          echo ("<td align=right><input type=text class='form-control' name='new_unit_saleprice' value='$li_price_sale' style='text-align: right'></td>");
        } else {
          echo ("<td align=right>$li_price_sale_K</td>");
        }
        
        echo ("
        <td>
        
          <select name='new_cart_qty' class='form-control'>");
          for($t = 1; $t <= $qty_max; $t++) {
            if($H_qty == $t) {
              echo("<option value='$t' selected>$t</option>");
            } else {
              echo("<option value='$t'>$t</option>");
            }
          }
        
        echo ("</select>
		</td>
        <td align=right>$li_tprice_sale_K</td>
        <td><input type=submit value='$txt_comm_frm12' class='form-control'></td>
        </form>
        
        <form name='cart_del' method='post' action='sales_order_cart1.php'>
        <input type=hidden name='cart_mode' value='CART_DEL'>
		<input type=hidden name='sub_type' value='1'>
        <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
        <input type=hidden name='H_shop_uid' value='$dari_uid'>
        <input type=hidden name='H_prd_code' value='$H_pcode'>
        <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
        <input type=hidden name='H_prd_stock_now' value='$qty_max'>
        <input type='hidden' name='key_shop' value='$key_shop'>
        <input type='hidden' name='page' value='$page'>
	      <input type='hidden' name='stat' value='$stat'>

        <td><input type=submit value='$txt_comm_frm13' class='form-control'></td>
        </form>
      </tr>");
      
      $cart_no++;
      }
      
      if($new_buyer_type == "0") {
        $new_buyer_type_chk0 = "checked";
        $new_buyer_type_chk1 = "";
        $new_buyer_type_chk2 = "";
      } else if($new_buyer_type == "2") {
        $new_buyer_type_chk0 = "";
        $new_buyer_type_chk1 = "";
        $new_buyer_type_chk2 = "checked";
      } else {
        $new_buyer_type_chk0 = "";
        $new_buyer_type_chk1 = "checked";
        $new_buyer_type_chk2 = "";
      }

      // 합계
      echo ("
      <form name='order_check' method='post' action='sales_order1.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type=hidden name='new_client' value='$H_cart_gate'>
      <input type='hidden' name='key_shop' value='$key_shop'>
      <input type='hidden' name='page' value='$page'>
      <!--<input type='hidden' name='stat' value='$stat'>-->

      <tr>
        <td colspan=3 align=center>
          <input type=radio name='new_buyer_type' value='1' $new_buyer_type_chk1> B2B &nbsp&nbsp; &nbsp&nbsp; 
          <input type=radio name='new_buyer_type' value='0' $new_buyer_type_chk0> Direct Sales &nbsp&nbsp; &nbsp&nbsp; 
        </td>
        <td align=center><b>$txt_sales_sales_11</b></td>
        <td align=center>{$total_qty}</td>
        <td align=right><font color=#000000><b>{$p_total_price_K}</b></font></td>
        <td colspan=2><!--<input type=submit value='$txt_sales_sales_12' class='btn btn-primary'>-->
				<input type='submit' id='btn_cash' name='btn_kas' class='btn btn-primary' value='Cash' />
				<input type='submit' id='btn_credit' name='btn_hutang' class='btn btn-primary' value='Credit' />
		</td>
      </tr>
      </form>");
      
      
      echo ("
	  </tbody>
	  </table>
	  </section>");
      }
      
      
      
      // 주문 양식
      if($mode == "order_form") {
      
		$this_dates = date("Y-m-d");
	  
	  if($smode == "order_confirm") {
	  
		echo ("<form name='order_check' class='cmxform form-horizontal adminex-form' method='post' action='sales_order_cart1.php'>");
		$submit_txt = "$txt_sales_sales_06";
	  
	  } else {
	  
		echo ("
		<form name='order_check' class='cmxform form-horizontal adminex-form' method='post' action='sales_order1.php'>
		<input type=hidden name='smode' value='order_confirm'>");
		$submit_txt = "$txt_comm_frm18";
	  
	  }
	  
	  
	  
      echo ("
	  <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='cart_mode' value='ORDER'>
      <input type=hidden name='new_shop_code' value='$H_cart_gate'>
      <input type=hidden name='new_branch_code' value='$login_branch'>
      <input type=hidden name='new_buyer_type' value='$new_buyer_type'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type=hidden name='key_shop' value='$key_shop'>
      <input type=hidden name='page' value='$page'>
	  <input type=hidden name='stat' value='$stat'>
      

		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_sales_sales_13</label>
            <div class='col-sm-4'>");
					
					$new_buyer_code = $_POST['new_buyer_code'];
			
					if($new_buyer_type == "1") { // B2B

                    $query_z1C = "SELECT count(id) FROM member_main WHERE userlevel > '3' AND mb_type = '3'";
                    $result_z1C = mysql_query($query_z1C);
                    $total_z1C = @mysql_result($result_z1C,0,0);
                
                    $query_z1 = "SELECT id,code,name,corp_name FROM member_main WHERE userlevel > '3' AND mb_type = '3' ORDER BY name ASC";
                    $result_z1 = mysql_query($query_z1);
                
                    echo ("<select name='new_buyer_code' class='form-control' required>");
                    echo ("<option value=''>:: $txt_comm_frm19 ($txt_sales_sales_32)</option>");

                    for($z1 = 0; $z1 < $total_z1C; $z1++) {
                      $zbuyer_id = mysql_result($result_z1,$z1,0);
                      $zbuyer_code = mysql_result($result_z1,$z1,1);
                      $zbuyer_name = mysql_result($result_z1,$z1,2);
                      $zbuyer_corp = mysql_result($result_z1,$z1,3);
					  
		    
					  if($new_buyer_code == $zbuyer_code) {
						  echo ("<option value='$zbuyer_code' selected>[$zbuyer_code] $zbuyer_corp</option>");
					  } else {
						  echo ("<option value='$zbuyer_code'>[$zbuyer_code] $zbuyer_corp</option>");
					  }
                    }
                    echo ("</select>");
                
                } else { // Direct Sale
                
                    $query_z2C = "SELECT count(id) FROM member_main WHERE userlevel > '0' AND mb_type < '3'";
                    $result_z2C = mysql_query($query_z2C);
                    $total_z2C = @mysql_result($result_z2C,0,0);
                
                    $query_z2 = "SELECT id,code,name FROM member_main WHERE userlevel > '0' AND mb_type < '3' ORDER BY name ASC";
                    $result_z2 = mysql_query($query_z2);
                
                    echo ("<select name='new_buyer_code' class='form-control' required>");
                    echo ("<option value=''>:: $txt_comm_frm19</option>");

                    for($z2 = 0; $z2 < $total_z2C; $z2++) {
                      $z2buyer_id = mysql_result($result_z2,$z2,0);
                      $z2buyer_code = mysql_result($result_z2,$z2,1);
                      $z2buyer_name = mysql_result($result_z2,$z2,2);
					  
					  if($new_buyer_code == $z2buyer_code) {
						$z2buyer_code_slc = "selected";
					  } else {
						$z2buyer_code_slc = "";
					  }
                
                      echo ("<option value='$z2buyer_code' $z2buyer_code_slc>[$z2buyer_code] $z2buyer_name</option>");
                    }
                    echo ("</select>");
                
                // } else {
                //   echo ("<input type=text name='new_buyer_name' class='form-control'>");
                }
				
				echo ("
			</div>
			<label class='control-label col-sm-2'>$txt_sys_user_05</label>
            <div class='col-sm-4'>
				<input disabled type=text name='dis_manager_id' value='$login_id' class='form-control'>
			</div>
        </div>
		
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_02</label>
            <div class='col-sm-4'>
				<input type=text name='new_final_amount' value='$p_total_price' class='form-control'>
			</div>
			<label class='control-label col-sm-2'>$txt_invn_payment_10</label>
            <div class='col-sm-4'>");
			
				//IF BUTTON 'CASH' SELECTED THE CASH PAYMENT SHOWED
				if($stat == "cash") {
		
				echo ("
                <select name='new_pay_type' class='form-control'>
                <option value='cash'>$txt_invn_payment_10_1</option>
                <option value='bank'>$txt_invn_payment_10_2</option>
                
                <option value='card'>$txt_invn_payment_10_4</option>
                <!--<option value='voucher'>$txt_invn_payment_10_5</option>-->
                </select>
				");

				} else if($stat == "credit") {
					echo ("<input readonly type='text' name='dis_new_pay_type' value='Credit' class='form-control'>");
					echo ("<input type='hidden' name='new_pay_type' value='credit'>");
				}
				
				echo ("
			</div>
        </div>");
		
		
		// Promotion
		$query_pr1 = "SELECT uid,dc2_amount FROM client_shop 
                            WHERE branch_code = '$login_branch' AND shop_code = '$login_shop' ORDER BY dc2_upd DESC";
        $result_pr1 = mysql_query($query_pr1);
                
        $pr1_dc_uid = @mysql_result($result_pr1,0,0);
		$pr1_dc_rate = @mysql_result($result_pr1,0,1);
		
		if($new_pay_promo) {
			$pr1_dc_rate = $new_pay_promo;
		}
		
		// Discount 1
		$new_promo_dc_rate = 1 - ( $pr1_dc_rate / 100 );
		
		if($new_promo_dc_rate > 0) {
			$p_total_priceA = $p_total_price * $new_promo_dc_rate;
		} else {
			$p_total_priceA = $p_total_price;
		}
		$p_total_priceA_K = number_format($p_total_priceA);
		
		
		if($pr1_dc_rate > 0) {
		
		
		echo ("
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_sys_consign_152</label>
            <div class='col-sm-2'>
				<input type=text name='new_pay_promo' value='$pr1_dc_rate' class='form-control' maxlength=4 style='text-align: center'>
			</div>
			<div class='col-sm-2'>% Discount</div>
			<div class='col-sm-2'>$txt_sales_sales_11</div>
			<div class='col-sm-4'>
				<input disabled type=text name='new_total_priceA' value='$p_total_priceA_K' class='form-control'>
			</div>
		</div>");
		
		
		
		
		}
		
		
		
		
		
		echo ("
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_sales_sales_23</label>
            <div class='col-sm-6'>
				<select name='new_pay_voucher_set' class='form-control'>
                <option value='0'>:: $txt_comm_frm19</option>");
                
				// expire_date (YYYY-MM-DD)
				$signdate = time();
				$v_sales_dates = date("Y-m-d",$signdate);
				
                $query_V1C = "SELECT count(uid) FROM shop_voucher WHERE branch_code = '$login_branch' AND onoff = '1' AND expire_date >= '$v_sales_dates'";
                $result_V1C = mysql_query($query_V1C);
                $total_V1C = @mysql_result($result_V1C,0,0);
                
                $query_V1 = "SELECT uid,voucher_code,voucher_value FROM shop_voucher 
                            WHERE branch_code = '$login_branch' AND onoff = '1' AND expire_date >= '$v_sales_dates' ORDER BY voucher_value ASC";
                $result_V1 = mysql_query($query_V1);
                
                for($v1 = 0; $v1 < $total_V1C; $v1++) {
                  $voucher_uid = mysql_result($result_V1,$v1,0);
                  $voucher_code = mysql_result($result_V1,$v1,1);
                  $voucher_value = mysql_result($result_V1,$v1,2);
                    $voucher_value_K = number_format($voucher_value);
                  
                  $voucher_set = "$voucher_uid"."|"."$voucher_value";
                  
                  echo ("<option value='$voucher_set'>Rp. $voucher_value_K</option>");
                }
                
                echo ("
                </select>
			</div>
			
			<div class='col-sm-2'>
                <select name='new_pay_voucher_qty' class='form-control'>");
                for($n = 1; $n < 11; $n++) {
                  // if($H_qty == $n) {
                  //   echo("<option value='$n' selected>$n</option>");
                  // } else {
                    echo("<option value='$n'>$n</option>");
                  // }
                }
                echo ("
                </select>
			</div>
			<div class='col-sm-2'></div>
        </div>");
		
		
		if($new_buyer_type > "0") { // Membership Mileage & Discount
		
		echo ("
		<div class='form-group'>");
		
			// Special Price
			
		
				$query_V2 = "SELECT point_amount,dc_amount,point_upd FROM client_shop 
							WHERE branch_code = '$login_branch' AND shop_code = '$login_shop' ORDER BY point_upd DESC";
				$result_V2 = mysql_query($query_V2,$dbconn);
    
				$V2_mpoint_rate = @mysql_result($result_V2,0,0);
				$V2_dc_rate = @mysql_result($result_V2,0,1);
				$V2_upd_date = @mysql_result($result_V2,0,2);
				
				if($new_pay_saleoff) {
					$V2_dc_rate = $new_pay_saleoff;
				}
				
				$V2_mpoint = $p_total_price * ( $V2_mpoint_rate * 0.01 );
					$V2_mpoint_K = number_format($V2_mpoint);
              
				if($V2_dc_rate > 0) {
					$V2_dc_rate_txt = "<font color=blue>$txt_sales_sales_24</font>";
				} else {
					$V2_dc_rate_txt = "$txt_sales_sales_24";
				}
				
				echo ("

			<label class='control-label col-sm-2'>$V2_dc_rate_txt</label>
            <div class='col-sm-2'>
				<input type=text name='new_pay_saleoff' value='$V2_dc_rate' class='form-control' maxlength=4 style='text-align: center'>
			</div>
			<div class='col-sm-2'>% Discount</div>
			
			<label class='control-label col-sm-2'>Mileage</label>
            <div class='col-sm-2'>
				<input disabled type=text name='new_mpoint' value='$V2_mpoint_K' class='form-control' style='text-align: center'>
			</div>
			<div class='col-sm-2'>P ({$V2_mpoint_rate}%)</div>
        </div>");
		
		}
		
		
		// Discount 2
		$new_mbr_dc_rate = 1 - ( $V2_dc_rate / 100 );
		
		if($new_mbr_dc_rate > 0) {
			$p_total_priceB = $p_total_priceA * $new_mbr_dc_rate;
		} else {
			$p_total_priceB = $p_total_priceA;
		}
		$p_total_priceB_K = number_format($p_total_priceB);
		
		
		
		
		echo ("
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_20</label>
            <div class='col-sm-4'>");
			
				$query_K1C = "SELECT count(uid) FROM code_card WHERE userlevel > '0'";
                $result_K1C = mysql_query($query_K1C);
                $total_K1C = @mysql_result($result_K1C,0,0);
                
                $query_K1 = "SELECT card_code,card_name FROM code_card WHERE userlevel > '0' ORDER BY card_code ASC";
                $result_K1 = mysql_query($query_K1);
                
                echo ("<select name='new_pay_card' class='form-control'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($w1 = 0; $w1 < $total_K1C; $w1++) {
                  $card_code = mysql_result($result_K1,$w1,0);
                  $card_name = mysql_result($result_K1,$w1,1);
                
                  echo ("<option value='$card_code'>$card_name</option>");
                }
                echo ("</select>
				
			</div>
			<label class='control-label col-sm-2'>$txt_invn_payment_21</label>
            <div class='col-sm-4'>");
				
				$query_K2C = "SELECT count(uid) FROM code_bank WHERE userlevel > '0' AND branch_code = '$login_branch'";
                $result_K2C = mysql_query($query_K2C);
                $total_K2C = @mysql_result($result_K2C,0,0);
                
                $query_K2 = "SELECT bank_code,bank_name FROM code_bank 
                            WHERE userlevel > '0' AND branch_code = '$login_branch' ORDER BY bank_code ASC";
                $result_K2 = mysql_query($query_K2);
                
                echo ("<select name='new_shop_bank' class='form-control'>");
                echo ("<option value=''>:: $txt_comm_frm19</option>");

                for($w2 = 0; $w2 < $total_K2C; $w2++) {
                  $bank_code = mysql_result($result_K2,$w2,0);
                  $bank_name = mysql_result($result_K2,$w2,1);
                
                  echo ("<option value='$bank_code'>$bank_name</option>");
                }
                echo ("</select>
				
			</div>
        </div>
		
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_16</label>
            <div class='col-sm-4'>
				<input type=text name='new_pay_bank' class='form-control'>
			</div>
			<label class='control-label col-sm-2'>$txt_invn_payment_13</label>
            <div class='col-sm-4'>
				<input type=text name='new_remit_code' class='form-control'>
			</div>
        </div>
		
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_03</label>
            <div class='col-sm-4'>
				<input type='date' class='form-control' name='add_due_dates' value='$this_dates'>
			</div>
			
        </div>
		
		<div class='form-group'>
            <div class='col-sm-offset-2 col-sm-2'>
				<input class='btn btn-primary' type='submit' value='$submit_txt'>
			</div>
			<div class='col-sm-8'><b>Rp. &nbsp; $p_total_priceB_K</b></div>
        </div>
		");
		
		}
		?>
		
	</div>
	</form>
		
						
						
						
    
    
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
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  $m_ip = getenv('REMOTE_ADDR');
  
  
  if($add_mode == "update_all") { // 모든 상품 업데이트
  
      $queryC2 = "SELECT count(uid) FROM shop_product_list";
      $resultC2 = mysql_query($queryC2);
      $total_recordC2 = @mysql_result($resultC2,0,0);

      $queryD2 = "SELECT uid,branch_code,shop_code,catg_code,gcode,pcode,pname,gudang_code,supp_code,
                  product_option1,product_option2,product_option3,product_option4,product_option5,
                  price_orgin,price_market,price_sale,price_sale2,price_margin,dc_rate,save_point,
                  sold_out,stock_org,stock_sell,stock_now,post_date,org_pcode FROM shop_product_list ORDER BY uid ASC";
      $resultD2 = mysql_query($queryD2);
      
      for($ra = 0; $ra < $total_recordC2; $ra++) {
        $R_uid = mysql_result($resultD2,$ra,0);
        $R_branch = mysql_result($resultD2,$ra,1);
        $R_shop_code = mysql_result($resultD2,$ra,2);
        $R_catg_code = mysql_result($resultD2,$ra,3);
        $R_gcode = mysql_result($resultD2,$ra,4);
        $R_pcode = mysql_result($resultD2,$ra,5);
        $R_pname = mysql_result($resultD2,$ra,6);
        $R_gudang_code = mysql_result($resultD2,$ra,7);
        $R_supp_code = mysql_result($resultD2,$ra,8);
        $R_opt1 = mysql_result($resultD2,$ra,9);
        $R_opt2 = mysql_result($resultD2,$ra,10);
        $R_opt3 = mysql_result($resultD2,$ra,11);
        $R_opt4 = mysql_result($resultD2,$ra,12);
        $R_opt5 = mysql_result($resultD2,$ra,13);
        $R_price_orgin = mysql_result($resultD2,$ra,14);
        $R_price_market = mysql_result($resultD2,$ra,15);
        $R_price_sale = mysql_result($resultD2,$ra,16);
        $R_price_sale2 = mysql_result($resultD2,$ra,17);
        $R_price_margin = mysql_result($resultD2,$ra,18);
        $R_dc_rate = mysql_result($resultD2,$ra,19);
        $R_save_point = mysql_result($resultD2,$ra,20);
        $R_sold_out = mysql_result($resultD2,$ra,21);
        $R_qty_org = mysql_result($resultD2,$ra,22);
        $R_qty_sell = mysql_result($resultD2,$ra,23);
        $R_qty_now = mysql_result($resultD2,$ra,24);
        $R_post_date = mysql_result($resultD2,$ra,25);
        $R_org_pcode = mysql_result($resultD2,$ra,26);
		
		$queryD3 = "SELECT uid,pname FROM shop_product_catg WHERE pcode = '$R_gcode'";
		$resultD3 = mysql_query($queryD3);
      
        $R_guid = @mysql_result($resultD3,0,0);
		$R_gname = @mysql_result($resultD3,0,1);
			$R_gname2 = addslashes($R_gname);
		
		
		$queryD4c = "SELECT count(uid),uid FROM shop_product_catg_unit WHERE gcode = '$R_gcode'";
		$resultD4c = mysql_query($queryD4c);
      
        $U_count = @mysql_result($resultD4c,0,0);
		$U_uid = @mysql_result($resultD4c,0,1);
		
		echo "Updating Data [$R_gcode] $R_pcode ...<br>";
		
		if($U_count > 0) {
		
			$result_U1 = mysql_query("UPDATE shop_product_catg_unit SET unit_name = 'Carton' WHERE uid = '$R_uid'");
			if(!$result_U1) { error("QUERY_ERROR"); exit; }
		
		} else {
		
			$query_U2 = "INSERT INTO shop_product_catg_unit (uid,branch_code,catg_uid,gcode,unit_name,unit_qty) 
						values ('','CORP_01','$U_uid','$R_gcode','Carton','20')";
			$result_U2 = mysql_query($query_U2);
			if (!$result_U2) { error("QUERY_ERROR"); exit; }
		
		}
			
		
		
        
        // Update
		$result_UR1 = mysql_query("UPDATE shop_product_list SET gname = '$R_gname' WHERE pcode = '$R_pcode'");
        if(!$result_UR1) { error("QUERY_ERROR"); exit; }
		
        $result_UR2 = mysql_query("UPDATE shop_product_list_shop SET catg_code = '$R_catg_code', gcode = '$R_gcode', 
            gname = '$R_gname', pname = '$R_pname', gudang_code = '$R_gudang_code', supp_code = '$R_supp_code', 
            product_option1 = '$R_opt1', product_option2 = '$R_opt2', product_option3 = '$R_opt3', 
            product_option4 = '$R_opt4', product_option5 = '$R_opt5', 
            price_orgin = '$R_price_orgin', price_market = '$R_price_market', price_sale = '$R_price_sale', 
            price_sale2 = '$R_price_sale2', price_margin = '$R_price_margin', dc_rate = '$R_dc_rate', 
            save_point = '$R_save_point', sold_out = '$R_sold_out', post_date = '$R_post_date', 
            org_pcode = '$R_org_pcode' WHERE pcode = '$R_pcode'");
        if(!$result_UR2) { error("QUERY_ERROR"); exit; }
        
      }
  
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='10; URL=$home/sales_order1.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page'>");
      exit;
  
  }

}

}
?>
