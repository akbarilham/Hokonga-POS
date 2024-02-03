<?
session_start();
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "sales";
$smenu = "sales_collection";
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
if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
} // new code for step_next post
if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/sales_collection.php?sorting_key=$sorting_key";
$link_upd = "$home/sales_collection.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
// 리스트 범위
if($login_level > "2") {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate' AND f_class = 'in' AND f_intype = '1' AND pay_state < '2'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate'";
} else {
  $sorting_filter = "branch_code = '$login_branch' AND shop_code = '$login_shop' AND f_class = 'in' AND f_intype = '1' AND pay_state < '2'";
  $sorting_filter_G = "branch_code = '$login_branch' AND client_id = '$login_gate'";
  $sorting_filter_S = "branch_code = '$login_branch' AND shop_code = '$login_shop'";
}
//======== get sorting_key from url ===========
$sorting_key = $_GET['sorting_key'];
if (isset($_GET['P_uid'])) {
  $P_uid = $_GET['P_uid'];
}
  

// 정렬 필터링
if(!$sorting_key) { $sorting_key = "pay_date"; }
if($sorting_key == "order_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "order_date") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "pay_num") { $chk1 = "selected"; } else { $chk1 = ""; }


//===================== new page code ======================
//Yogi Anditia
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
//===========================================================

// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_02_041?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?

			echo ("
			<form name='search' method='post' action='sales_collection.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='pay_num'>$txt_invn_payment_15</option>
				<option value='pay_date'>$txt_invn_payment_03</option>
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
			<option value='$PHP_SELF?sorting_key=pay_date&keyfield=$keyfield&key=$key'>$txt_invn_payment_03</option>
			<option value='$PHP_SELF?sorting_key=pay_num&keyfield=$keyfield&key=$key' $chk1>$txt_invn_payment_15</option>
			<option value='$PHP_SELF?sorting_key=order_date&keyfield=$keyfield&key=$key' $chk4>$txt_sales_sales_27</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th><?=$txt_invn_stockout_05?></th>
            <th><?=$txt_invn_payment_15?></th>
			<th colspan=2><?=$txt_invn_payment_02?></th>
			<th><?=$txt_invn_payment_10?></th>
			<th><?=$txt_comm_frm34?></th>
			<th><?=$txt_invn_return_03?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<tr>
			<td></td>
			<td></td>
			<td>IDR</td>
			<td>USD</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
			
			
<?
// 합계 구하기
if(!eregi("[^[:space:]]+",$key)) {
  $query_sumA = "SELECT sum(pay_amount) FROM shop_payment 
                WHERE $sorting_filter AND currency = 'IDR' ORDER BY $sorting_key $sort_now";
} else {
  $query_sumA = "SELECT sum(pay_amount) FROM shop_payment 
                WHERE $sorting_filter AND currency = 'IDR' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sumA = mysql_query($query_sumA);
if (!$result_sumA) { error("QUERY_ERROR"); exit; }
$sum_pay_amount_IDR = @mysql_result($result_sumA,0,0);
$sum_pay_amount_IDR_K = number_format($sum_pay_amount_IDR);

if(!eregi("[^[:space:]]+",$key)) {
  $query_sumB = "SELECT sum(pay_amount) FROM shop_payment 
                WHERE $sorting_filter AND currency = 'USD' ORDER BY $sorting_key $sort_now";
} else {
  $query_sumB = "SELECT sum(pay_amount) FROM shop_payment 
                WHERE $sorting_filter AND currency = 'USD' AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sumB = mysql_query($query_sumB);
if (!$result_sumB) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_USD = @mysql_result($result_sumB,0,0);
$sum_pay_amount_USD_K = number_format($sum_pay_amount_USD);

echo ("
<tr>
  <td colspan=2 align=center>Total</td>
  <td align=right><font color=#000000><b>$sum_pay_amount_IDR_K</b></font></td>
  <td align=right><font color=#000000><b>$sum_pay_amount_USD_K</b></font></td>
  <td align=right></td>
  <td align=right></td>
  <td align=right></td>
</tr>
");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,shop_code,pay_num,pay_type,pay_state,pay_amount,pay_amount_money,pay_amount_point,
              order_date,pay_date,f_intype,currency 
      FROM shop_payment WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,shop_code,pay_num,pay_type,pay_state,pay_amount,pay_amount_money,pay_amount_point,
              order_date,pay_date,f_intype,currency 
      FROM shop_payment WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $pay_uid = mysql_result($result,$i,0);   
   $pay_gate = mysql_result($result,$i,1);
   $pay_shop_code = mysql_result($result,$i,2);
   $pay_num = mysql_result($result,$i,3);
   $pay_type = mysql_result($result,$i,4);
   $pay_status = mysql_result($result,$i,5);
   $pay_amount = mysql_result($result,$i,6);
      $pay_amount_K = number_format(floatval($pay_amount));
   $pay_amount_money = mysql_result($result,$i,7);
      $pay_amount_money_K = number_format($pay_amount_money);
   $pay_amount_point = mysql_result($result,$i,8);
      $pay_amount_point_K = number_format($pay_amount_point);
   $post_date = mysql_result($result,$i,9);
   $pay_date = mysql_result($result,$i,10);
   $f_intype = mysql_result($result,$i,11); // 2: 반품
   $pay_currency = mysql_result($result,$i,12);
   
   // 통화별 금액
   if($pay_currency == "USD") {
    $pay_amount_IDR_K = "";
    $pay_amount_USD_K = "$pay_amount_K";
   } else {
    $pay_amount_IDR_K = "$pay_amount_K";
    $pay_amount_USD_K = "";
   }
   
   
   // 결제일
   $uday1 = substr($pay_date,0,4);
	 $uday2 = substr($pay_date,4,2);
	 $uday3 = substr($pay_date,6,2);
	 $uday4 = substr($pay_date,8,2);
	 $uday5 = substr($pay_date,10,2);
	 $uday6 = substr($pay_date,12,2);

    if($lang == "ko") {
	    $pay_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	  } else {
	    $pay_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	  }

   $wday1 = substr($post_date,0,4);
	 $wday2 = substr($post_date,4,2);
	 $wday3 = substr($post_date,6,2);
	 $wday4 = substr($post_date,8,2);
	 $wday5 = substr($post_date,10,2);
	 $wday6 = substr($post_date,12,2);

   if($post_date == "0" OR $post_date == "") {
      $pay_date_txt = "<font color=#AAAAAA>$pay_date_txt</font>";
   } else {
    if($lang == "ko") {
	    $post_date_txt = "$wday1"."/"."$wday2"."/"."$wday3";
	  } else {
	    $post_date_txt = "$wday3"."-"."$wday2"."-"."$wday1";
	  }
   }


    
    // 결제 유형
    if($pay_type == "cash") {
      $pay_type_txt = "$txt_invn_payment_10_1";
    } else if($pay_type == "bank") {
      $pay_type_txt = "$txt_invn_payment_10_2";
    } else if($pay_type == "account") {
      $pay_type_txt = "$txt_invn_payment_10_3";
    } else if($pay_type == "card") {
      $pay_type_txt = "$txt_invn_payment_10_4";
    } else if($pay_type == "voucher") {
      $pay_type_txt = "$txt_invn_payment_10_5";
    } else if($pay_type == "credit") {
      $pay_type_txt = "Credit";
    } else {
      $pay_type_txt = "$txt_invn_payment_10_6";
    }
    
    // 바우처 결제
    if($pay_amount_point > "0") {
      $pay_voucher_txt = "+ $txt_invn_payment_10_5";
    } else {
      $pay_voucher_txt = "";
    }

    // 처리 내용
    if($pay_status == "2") {
        $prc_status_txt = "<i class='fa fa-print'></i> <a href='$link_upd&mode=check&uid=$pay_uid&P_uid=$pay_uid'><font color=blue>$txt_invn_return_04</font></a>"; // 수금완료[마감]
    } else if($pay_status == "1") {
        $prc_status_txt = "<i class='fa fa-print'></i> <a href='$link_upd&mode=check&uid=$pay_uid&P_uid=$pay_uid'><font color=black>$txt_invn_return_09s</font></a>"; // 처리중
    } else {
        $prc_status_txt = "<font color=red>$txt_invn_payment_05</font>"; // 미지불
    }

    // 줄 색깔
    if($uid == $pay_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }

  if($pay_amount > 0) {
  echo ("<tr height=22>");
  echo("<td bgcolor='$highlight_color'>{$pay_shop_code}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$pay_uid'>{$pay_num}</a></td>");
  echo("<td bgcolor='$highlight_color' align=right><a href='$link_upd&mode=check&uid=$pay_uid'>{$pay_amount_IDR_K}</a></td>");
  echo("<td bgcolor='$highlight_color' align=right><a href='$link_upd&mode=check&uid=$pay_uid'>{$pay_amount_USD_K}</a></td>");

  echo("<td bgcolor='$highlight_color'>$pay_type_txt {$pay_voucher_txt}</td>");

  echo("<td bgcolor='$highlight_color'>{$post_date_txt}</td>");
  echo("<td bgcolor='$highlight_color'>{$prc_status_txt}</td>");
  echo("</tr>");
  
  if($mode == "check" AND $pay_num != "" AND $pay_uid == $uid) {
  
    // 상세 리스트 [반환 상품 정보]
    if($f_intype == "2") {
    $query_re = "SELECT uid,catg_code,pcode,pname,price_orgin,stock_org,tprice_orgin,return_date,
                pay_code FROM shop_product_return WHERE pay_code = '$pay_num'";
    $result_re = mysql_query($query_re);
    if(!$result_re) { error("QUERY_ERROR"); exit; }
    $row_re = mysql_fetch_object($result_re);

    $re_uid = $row_re->uid;
    $re_catg_code = $row_re->catg_code;
    $re_pcode = $row_re->pcode;
    $re_pname = $row_re->pname;
    $re_price = $row_re->price_orgin;
    $re_qty = $row_re->stock_org;
    $re_tprice = $row_re->tprice_orgin;
    $re_date = $row_re->return_date;
    
    $re_tprice = $re_price * $re_qty;
    
    $re_price_K = number_format($re_price);
    $re_tprice_K = number_format($re_tprice);
    
        echo ("
        <tr height=22>
          <td colspan=2 align=right><i class='fa fa-caret-right'></i></td>
          <td colspan=5>
              <table width=100% cellspacing=0 cellpadding=0 border=0 style='margin: -10px'>
              <tr height=20>
                <td width=68%>&nbsp;[$re_pcode] {$re_pname}</td>
                <td width=10% align=right>$re_price_K &nbsp;</td>
                <td width=7% align=right bgcolor=#EFEFEF>$re_qty &nbsp;</td>
                <td width=12% align=right>$re_tprice_K &nbsp;</td>
              </tr>
              </table>
          </td>
        </tr>");
    
    
    } else {
    // 상세 리스트 [카트]
    $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$pay_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
                p_price,p_saleprice FROM shop_cart WHERE pay_num = '$pay_num' ORDER BY pcode ASC";
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
      
      if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
      if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
      
      
      // 상품명, 상품별 결제액
		$rm2_query = "SELECT uid,catg_code,gcode,pname,org_pcode,org_barcode FROM shop_product_list WHERE pcode = '$H_pcode'";
        $rm2_result = mysql_query($rm2_query);
        if (!$rm2_result) { error("QUERY_ERROR"); exit; }
        
        $H_org_uid = @mysql_result($rm2_result,0,0);
        $H_catg_code = @mysql_result($rm2_result,0,1);
        $H_gcode = @mysql_result($rm2_result,0,2);
		$H_pname = @mysql_result($rm2_result,0,3);
			$H_pname = stripslashes($H_pname);
		$H_org_pcode = @mysql_result($rm2_result,0,4);
		$H_org_barcode = @mysql_result($rm2_result,0,5);
		
		
      $query_dari = "SELECT uid,pname,price_sale FROM shop_product_list_shop WHERE pcode = '$H_pcode'";
      $result_dari = mysql_query($query_dari);
      if(!$result_dari) { error("QUERY_ERROR"); exit; }
      $row_dari = mysql_fetch_object($result_dari);

      $dari_uid = $row_dari->uid;
      $dari_pname = $row_dari->pname;
      $dari_price_sale = $row_dari->price_sale;
      
      // $dari_tprice_sale = $dari_price_sale * $H_qty;
      $dari_tprice_sale = $H_p_saleprice * $H_qty;
      
      $dari_price_orgin_K = number_format($dari_price_sale);
      if($H_p_saleprice < "1") {
        $dari_price_sale_K = number_format($dari_price_sale);
      } else {
        $dari_price_sale_K = number_format($H_p_saleprice);
      }
      $dari_tprice_sale_K = number_format($dari_tprice_sale);
      
      
      echo ("
        <tr height=22>
          <td colspan=2 align=right>$H_pcode &nbsp; <i class='fa fa-caret-right'></i></td>
          <td colspan=6>
              <table width=100% cellspacing=0 cellpadding=0 border=0 style='margin: -10px'>
              <tr>
                <td width=56%>[$H_org_pcode] {$H_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5}</td>
                <td width=12% align=right><font color=#777777>$dari_price_orgin_K</font> &nbsp;</td>
                <td width=12% align=right>$dari_price_sale_K &nbsp;</td>
                <td width=7% align=right bgcolor=#EFEFEF>$H_qty &nbsp;</td>
                <td width=12% align=right>$dari_tprice_sale_K &nbsp;</td>
              </tr>
              </table>
          </td>
        </tr>");
    $cart_no++;
    }
  
  }
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
		
	
	
<?if($P_uid) { ?>

<div id="showimage" style="position:absolute;width:720px;left:193px;top:126px; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000; filter:alpha(opacity=85); z-index: 1001">
<!--  위 태그에서 위치를 지정해 줄 수 있습니다  --->

<table border="0" width="720" bgcolor="orange" cellspacing="0" cellpadding="1">
  
      <tr>
        <td height=20 id="dragbar" style="cursor:hand; cursor:pointer" width="100%" onMousedown="initializedrag(event)"><ilayer width="100%" onSelectStart="return false"><layer width="100%" onMouseover="dragswitch=1;if (ns4) drag_dropns(showimage)" onMouseout="dragswitch=0"><font face="Verdana"
        color="#FFFFFF">&nbsp;&nbsp;<b>Receipt</b></font></layer></ilayer></td>
        <td align=right style="cursor:hand" nowrap><a href="#" onClick="hidebox();return false"><font color=333333>X</font></a>&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr height=10 valign=top>
        <td width="100%" bgcolor="#FFFFFF" colspan="2" valign=top>

            <iFrame src="<?=$home?>/sales_receipt_print.php?P_uid=<?=$P_uid?>" style="BORDER; 0px solid; WIDTH: 720px; HEIGHT: 450px"></iFrame>

        </td>
      </tr>
    
</table>
</div>

<? } ?>
		
	
		<?
		echo ("
		<form name='signform2' class='cmxform form-horizontal adminex-form' method='post' action='sales_collection.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_key' value='$sorting_key'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='page' value='$page'>
		");
		
		
		if($mode == "check" AND $uid) { // 결제정보 변경

          // 결제 정보 테이블
          $pm_query = "SELECT uid,pay_num,bank_name,pay_type,pay_bank,remit_code,order_date,pay_date,pay_state,
                      branch_code,gate,shop_code,pay_amount,pay_amount_money,pay_amount_point,pay_card,mb_type,client_code 
                      FROM shop_payment WHERE uid = '$uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_pay_num = @mysql_result($pm_result,0,1);
          $pm_bank_name = @mysql_result($pm_result,0,2);
          $pm_pay_type = @mysql_result($pm_result,0,3);
          $pm_pay_bank = @mysql_result($pm_result,0,4);
          $pm_remit_code = @mysql_result($pm_result,0,5);
          $upd_post_date = @mysql_result($pm_result,0,6);
          $upd_pay_date = @mysql_result($pm_result,0,7);
          $upd_pay_status = @mysql_result($pm_result,0,8);
          $upd_branch_code = @mysql_result($pm_result,0,9);
          $upd_gate = @mysql_result($pm_result,0,10);
          $upd_shop_code = @mysql_result($pm_result,0,11);
          $upd_pay_amount = @mysql_result($pm_result,0,12);
            $upd_pay_amount_K = number_format($upd_pay_amount);
          $upd_pay_amount_money = @mysql_result($pm_result,0,13);
            $upd_pay_amount_money_K = number_format($upd_pay_amount_money);
          $upd_pay_amount_point = @mysql_result($pm_result,0,14);
            $upd_pay_amount_point_K = number_format($upd_pay_amount_point);
          $upd_pay_card = @mysql_result($pm_result,0,15);
          $upd_mb_type = @mysql_result($pm_result,0,16);
          $upd_mb_code = @mysql_result($pm_result,0,17);
		  
			// Buyer Name
			$query_bname = "SELECT name,corp_name FROM member_main WHERE code = '$upd_mb_code'";
			$result_bname = mysql_query($query_bname);
			$upd_mb_name1 = @mysql_result($result_bname,0,0);
			$upd_mb_name2 = @mysql_result($result_bname,0,1);
			
			if($upd_mb_name1 != "") {
				$upd_mb_name = $upd_mb_name1;
			} else {
				$upd_mb_name = $upd_mb_name2;
			}

          
          // shop_code를 통해 subgate_code 알아냄
          $pm3_query = "SELECT gate,subgate FROM client_shop WHERE shop_code = '$upd_shop_code'";
          $pm3_result = mysql_query($pm3_query);
          if (!$pm3_result) { error("QUERY_ERROR"); exit; }
    
          $upd_shop_gate = @mysql_result($pm3_result,0,0);
          $upd_shop_subgate = @mysql_result($pm3_result,0,1);
          
          
          
          if($pm_pay_type == "cash") { $pay_type_slc_cash = "selected"; } else { $pay_type_slc_cash = ""; }
          if($pm_pay_type == "bank") { $pay_type_slc_bank = "selected"; } else { $pay_type_slc_bank = ""; }
          if($pm_pay_type == "account") { $pay_type_slc_account = "selected"; } else { $pay_type_slc_account = ""; }
          if($pm_pay_type == "card") { $pay_type_slc_card = "selected"; } else { $pay_type_slc_card = ""; }
          if($pm_pay_type == "voucher") { $pay_type_slc_voucher = "selected"; } else { $pay_type_slc_voucher = ""; }
          
          // 고객 유형
          if($upd_mb_type == "1") {
            $mb_type_chk1 = "checked";
            $mb_type_chk0 = "";
          } else {
            $mb_type_chk1 = "";
            $mb_type_chk0 = "checked";
          }
          
          // 처리 버튼
          if($upd_pay_status == "2") {
            $submit_txt = $txt_invn_payment_14;
          } else if($upd_pay_status == "1") {
            $submit_txt = $txt_invn_payment_14;
          } else {
            $submit_txt = $txt_invn_payment_09;
          }

            // 지불일
            $Aday1 = substr($upd_post_date,0,4);
	          $Aday2 = substr($upd_post_date,4,2);
	          $Aday3 = substr($upd_post_date,6,2);
	          $Aday4 = substr($upd_post_date,8,2);
	          $Aday5 = substr($upd_post_date,10,2);
	          $Aday6 = substr($upd_post_date,12,2);
	          
	          if($upd_post_date == "0" OR $upd_post_date == "") {
	            $upd_post_dates = "--";
	          } else {
            if($lang == "ko") {
	            $upd_post_dates = "$Aday1"."/"."$Aday2"."/"."$Aday3".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	          } else {
	            $upd_post_dates = "$Aday3"."-"."$Aday2"."-"."$Aday1".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	          }
	          }
	          
	          
            $Cday1 = substr($upd_pay_date,0,4);
	          $Cday2 = substr($upd_pay_date,4,2);
	          $Cday3 = substr($upd_pay_date,6,2);
	          $Cday4 = substr($upd_pay_date,8,2);
	          $Cday5 = substr($upd_pay_date,10,2);
	          $Cday6 = substr($upd_pay_date,12,2);
	          
	          if($upd_pay_date == "0" OR $upd_pay_date == "") {
	            $upd_pay_dates = "--";
	          } else {
            if($lang == "ko") {
	            $upd_pay_dates = "$Cday1"."/"."$Cday2"."/"."$Cday3".", "."$Cday4".":"."$Cday5".":"."$Cday6";
	          } else {
	            $upd_pay_dates = "$Cday3"."-"."$Cday2"."-"."$Cday1".", "."$Cday4".":"."$Cday5".":"."$Cday6";
	          }
	          }
          
          
          // 지불 처리
          if($upd_pay_status == "0") {
            $upd_pay_status_chk0 = "checked";
            $upd_pay_status_chk1 = "";
            $upd_pay_status_chk2 = "";
          } else if($upd_pay_status == "1") {
            $upd_pay_status_chk0 = "";
            $upd_pay_status_chk1 = "checked";
            $upd_pay_status_chk2 = "";
          } else if($upd_pay_status == "2") {
            $upd_pay_status_chk0 = "";
            $upd_pay_status_chk1 = "";
            $upd_pay_status_chk2 = "checked";
          }
          
          
          
    // 상세 리스트 [카트] ---- Harga Faktur 총액 추출 위한 로직
    $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$pm_pay_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5 
      FROM shop_cart WHERE pay_num = '$pm_pay_num' ORDER BY pcode ASC";
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
      
      if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
      if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
      
      
      // 상품명, 상품별 결제액
      $query_dari = "SELECT uid,pname,price_market FROM shop_product_list WHERE pcode = '$H_pcode'";
      $result_dari = mysql_query($query_dari);
      if(!$result_dari) { error("QUERY_ERROR"); exit; }
      $row_dari = mysql_fetch_object($result_dari);

      $dari_uid = $row_dari->uid;
      $dari_pname = $row_dari->pname;
      $dari_price_market = $row_dari->price_market;
      
      $dari_tprice_market = $dari_price_market * $H_qty;
      
      $upd_pay_amount_faktur = $upd_pay_amount_faktur + $dari_tprice_market;

    $cart_no++;
    }
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_client' value='$upd_gate'>
	  <input type=hidden name='new_mb_code' value='$upd_mb_code'>
	  <input type=hidden name='new_mb_name' value='$upd_mb_name'>
      <input type=hidden name='new_shop_gate' value='$upd_shop_gate'>
      <input type=hidden name='new_shop_subgate' value='$upd_shop_subgate'>
      <input type=hidden name='new_shop_code' value='$upd_shop_code'>
      <input type=hidden name='new_tprice_orgin' value='$upd_pay_amount'>
      <input type=hidden name='new_tprice_money' value='$upd_pay_amount_money'>
      <input type=hidden name='new_tprice_point' value='$upd_pay_amount_point'>
      
      <input type=hidden name='new_tprice_faktur' value='$upd_pay_amount_faktur'>
      
      <input type=hidden name='new_pay_uid' value='$pm_uid'>
      <input type=hidden name='new_pay_num' value='$pm_pay_num'>");
	  ?>
          
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Payment Collection Form
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-4">
											<input disabled <?=$catg_disableA?> type=text name='dis_new_client' value='<?=$upd_gate?>' class='form-control'>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_payment_15?></label>
                                        <div class="col-sm-4">
											<input disabled type=text name='dis_pay_code' value='<?=$pm_pay_num?>' class='form-control'>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><font color=#000000><?=$txt_invn_payment_02?></font></label>
                                        <div class="col-sm-4">
											<input disabled type=text name='dis_new_tprice_orgin' value='<?=$upd_pay_amount_K?>' class='form-control' style='text-align: right'>
										</div>
                                    </div>
									
									<? if($upd_pay_amount_point > "0") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-2">
											<input disabled type=text name='dis_new_tprice_money' value='<?=$upd_pay_amount_money_K?>' class='form-control' style='text-align: right'>
										</div>
										<label for="cname" class="control-label col-sm-2"><div align=right>+ <?=$txt_invn_payment_10_5?></div></label>
										<div class="col-sm-2">
											<input disabled type=text name='dis_new_tprice_point' value='<?=$upd_pay_amount_point_K?>' class='form-control' style='text-align: right'>
										</div>
                                    </div>
									
									<? } ?>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sales_sales_13?></label>
                                        <div class="col-sm-4">
											<input type=text name='dis_mb_name' value='<?=$upd_mb_code?> - <?=$upd_mb_name?>' class='form-control'>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sales_sales_14?></label>
                                        <div class="col-sm-4">
											<input type=radio name='new_mb_type' value='1' <?=$mb_type_chk1?>> <?=$txt_sales_sales_14_1?> &nbsp;&nbsp;&nbsp; 
											<input type=radio name='new_mb_type' value='0' <?=$mb_type_chk0?>> <?=$txt_sales_sales_14_2?>
										</div>
                                    </div>
									
									<?
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_10</label>
                                        <div class='col-sm-4'>
											<select name='new_pay_type' class='form-control'>
											<option value='cash' $pay_type_slc_cash>$txt_invn_payment_10_1</option>
											<option value='bank' $pay_type_slc_bank>$txt_invn_payment_10_2</option>
              
											<option value='card' $pay_type_slc_card>$txt_invn_payment_10_4</option>
											<option value='voucher' $pay_type_slc_voucher>$txt_invn_payment_10_5</option>
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_20</label>
                                        <div class='col-sm-4'>");
												$query_K1C = "SELECT count(uid) FROM code_card WHERE branch_code = '$login_branch' AND userlevel > '0'";
												$result_K1C = mysql_query($query_K1C);
												$total_K1C = @mysql_result($result_K1C,0,0);
                
												$query_K1 = "SELECT card_code,card_name FROM code_card 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY card_code ASC";
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
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_16</label>
                                        <div class='col-sm-4'>
											<input type='text' class='form-control' name='new_pay_bank' value='$pm_pay_bank'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_13</label>
                                        <div class='col-sm-4'>
											<input type='text' class='form-control' name='new_remit_code' value='$pm_remit_code'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_sales_sales_27</label>
                                        <div class='col-sm-4'>
											<input disabled type='text' class='form-control' name='dis_post_date' value='$upd_post_dates'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_03</label>
                                        <div class='col-sm-4'>
											<input disabled type='text' class='form-control' name='dis_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>
									");
									
									if($login_level > "1") { echo ("
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'><input type=checkbox name='chg_date' value='1'> <font color=red>Change Date</font></label>
                                        <div class='col-sm-4'>
											<input type='text' class='form-control' name='chg_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>");
									
									}
									
									
									echo ("
									<!---------- payment status // -------------------------------------------------->
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_19</label>
                                        <div class='col-sm-9'>");
											
											if($upd_pay_status == "2") {
												echo("
												<input type=radio name='new_pay_status' value='' checked> <font color=blue>$txt_invn_return_04</font> &nbsp;&nbsp; 
												<input disabled type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04</font> &nbsp;&nbsp; 
												");
											} else if($upd_pay_status == "1") {
												echo("
												<input type=radio name='new_pay_status' value='' checked> <font color=black>$txt_invn_return_09</font> &nbsp;&nbsp; 
												<input type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04 ($txt_comm_frm08)</font> &nbsp;&nbsp; 
												");
											} else {
												echo("
												<input type=radio name='new_pay_status' value='1' checked> <font color=red>$txt_invn_return_09</font> &nbsp;&nbsp; 
												<input type=radio name='new_pay_status' value=''> $txt_comm_frm06 
												");
											}
			  
											echo ("
										</div>
                                    </div>");

          
									// FINANCE 테이블에 입력
									if($upd_pay_status < "2") { echo (" 
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>
											<div align=right><input type=radio name='new_pay_status' value='2'> $txt_sales_sales_44</div></label>
                                        <div class='col-sm-4'>");

												$query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'in'";
												$result_AC = mysql_query($query_AC);
													if (!$result_AC) { error("QUERY_ERROR"); exit; }
												$total_AC = @mysql_result($result_AC,0,0);
                
												echo ("<select name='new_acc_code' class='form-control'>");
                
												$query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'in' ORDER BY catg ASC";
												$result_A = mysql_query($query_A);
													if (!$result_A) {   error("QUERY_ERROR");   exit; }

												for($a = 0; $a < $total_AC; $a++) {
													$fA_uid = mysql_result($result_A,$a,0);
													$fA_class = mysql_result($result_A,$a,1);
													$fA_catg = mysql_result($result_A,$a,2);
   
													$fA_catg_txt = "txt_sys_account_05_"."$fA_catg";
                  
													echo ("<option disabled value='$fA_catg'> ($fA_catg) ${$fA_catg_txt}</option>");
                  
													$query_H1C = "SELECT count(uid) FROM code_acc_list 
																WHERE catg = '$fA_catg' AND lang = '$lang' AND $login_branch = '1'";
													$result_H1C = mysql_query($query_H1C);
													if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
                      
													$total_H1C = @mysql_result($result_H1C,0,0); 
                      
													$query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
																WHERE catg = '$fA_catg' AND lang = '$lang' AND $login_branch = '1' ORDER BY acc_code ASC";
													$result_H1 = mysql_query($query_H1);
													if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
													for($h1 = 0; $h1 < $total_H1C; $h1++) {
														$H1_acc_uid = mysql_result($result_H1,$h1,0);   
														$H1_acc_code = mysql_result($result_H1,$h1,1);
														$H1_acc_name = mysql_result($result_H1,$h1,2);
                        
                        
														// 디스플레이
														if($H1_acc_code == $upd_acc_code) {
															$H1_acc_code_slct = "selected";
														} else {
															$H1_acc_code_slct = "";
														}
                        
														echo ("<option value='$H1_acc_code' $H1_acc_code_slct>&nbsp;&nbsp; ($H1_acc_code) $H1_acc_name</option>");
                        
													}
               
												}
												
												echo ("
											</select>
										</div>
                                    </div>");
									
									}
									
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='$submit_txt'>
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
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  
  
  $m_ip = getenv('REMOTE_ADDR');
  
  // 상위 계정항목
  $new_fcatg = substr($new_acc_code,0,2);
  
  // 결제일 변경 시
  if(!$chg_date) { $chg_date = "0"; }
  
  if($chg_date == "1") {
    $post_dates = "$chg_pay_date";
  } else {
    $post_dates = "$post_date1"."$post_date2";
  }
  

  if($add_mode == "LIST_CHG") {
  

    if($new_pay_status == "2") { // 결제마감
    
        if($new_acc_code == "") {

          popup_msg("$txt_fin_cost_chk01");
          exit;
      
        } else {
        
        
        // 결제 정보 수정 [마감]
        $result_CHG = mysql_query("UPDATE shop_payment SET pay_type = '$new_pay_type', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card', 
            mb_type = '$new_mb_type', client_code = '$new_mb_code', name1 = '$new_mb_name', pay_state = '2', pay_date = '$post_dates', 
            subgate = '$new_shop_subgate' WHERE uid = '$new_pay_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }

        
        // finance 테이블에 총 Harga Faktur를 적용
        
        // finance 테이블에 입력
        $new_process = "2";
        $new_fname = "Ref. $new_pay_num";
        $new_currency = "IDR";
        
        if($new_tprice_point > 0) {
          $new_fremark = "$txt_invn_payment_22 ( + $txt_invn_payment_10_5 )";
        } else {
          $new_fremark = "";
        }
    
        
        if($new_tprice_point > 0) {
          $query_F2 = "INSERT INTO finance (uid,branch_code,gate,subgate,shop_code,f_class,f_paylink,f_catg,f_code,f_name,f_remark,currency,
          pay_type,amount,post_date,pay_date,process,pay_num,bank_name,remit_code,pay_bank,pay_card,settle_status,settle_date) values ('',
          '$login_branch','$new_client','$new_shop_subgate','$new_shop_code','in','1','$new_fcatg','$new_acc_code','$new_fname','$new_fremark','$new_currency',
          '$new_pay_type','$new_tprice_money','$post_dates','$post_dates','$new_process','$new_pay_num','$new_bank_code','$new_remit_code',
          '$new_pay_bank','$new_pay_card','1','$post_date1')";
          $result_F2 = mysql_query($query_F2);
          if (!$result_F2) { error("QUERY_ERROR"); exit; }
        
          $query_F3 = "INSERT INTO finance (uid,branch_code,gate,subgate,shop_code,f_class,f_paylink,f_catg,f_code,f_name,f_remark,currency,
          pay_type,amount,post_date,process,pay_num,bank_name,remit_code,pay_bank,pay_card,settle_status,settle_date) values ('',
          '$login_branch','$new_client','$new_shop_subgate','$new_shop_code','in','1','$new_fcatg','$new_acc_code','$new_fname','$txt_invn_payment_10_5','$new_currency',
          '$new_pay_type','$new_tprice_point','$post_dates','$new_process','$new_pay_num','$new_bank_code','$new_remit_code',
          '$new_pay_bank','$new_pay_card','1','$post_date1')";
          $result_F3 = mysql_query($query_F3);
          if (!$result_F3) { error("QUERY_ERROR"); exit; }

        } else { // SHS 본사와의 정산을 위해 총액은 harga faktur를 반영 // finance_shop으로 구분 필요
        
          $query_F2 = "INSERT INTO finance (uid,branch_code,gate,subgate,shop_code,f_class,f_paylink,f_catg,f_code,f_name,f_remark,currency,
          pay_type,amount,post_date,pay_date,process,pay_num,bank_name,remit_code,pay_bank,pay_card,settle_status,settle_date) values ('',
          '$login_branch','$new_client','$new_shop_subgate','$new_shop_code','in','1','$new_fcatg','$new_acc_code','$new_fname','$new_fremark','$new_currency',
          '$new_pay_type','$new_tprice_faktur','$post_dates','$post_dates','$new_process','$new_pay_num','$new_bank_code','$new_remit_code',
          '$new_pay_bank','$new_pay_card','1','$post_date1')";
          $result_F2 = mysql_query($query_F2);
          if (!$result_F2) { error("QUERY_ERROR"); exit; }
        
        }
        
        // 카트 정보 수정
        $result_re1 = mysql_query("UPDATE shop_cart SET shop_code = '$new_shop_code', settle_status = '1', 
                      settle_date = '$post_date1', subgate = '$new_shop_subgate' WHERE pay_num = '$new_pay_num'",$dbconn);
        if(!$result_re1) { error("QUERY_ERROR"); exit; }
        
        }
        
        
        
        


    } else if($new_pay_status == "0") { // 결제취소 [상품 재고 정보 복구] ----------------------------- //
    
        // 카트에서 상품정보 추출
        $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$new_pay_num'";
        $result_HC = mysql_query($query_HC);
        if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
        $total_HC = @mysql_result($result_HC,0,0);
        
        $query_H = "SELECT uid,pcode,qty FROM shop_cart WHERE pay_num = '$new_pay_num' ORDER BY pcode ASC";
        $result_H = mysql_query($query_H);
        if (!$result_H) {   error("QUERY_ERROR");   exit; }
        
        for($h = 0; $h < $total_HC; $h++) {
          $H_cart_uid = mysql_result($result_H,$h,0);
          $H_cart_pcode = mysql_result($result_H,$h,1);
          $H_cart_qty = mysql_result($result_H,$h,2);

        
            // Shop별 하위 테이블 상품 재고정보 수정
            $query_hd1 = "SELECT uid,qty_sell,qty_now FROM shop_product_list_shop WHERE pcode = '$H_cart_pcode'";
            $result_hd1 = mysql_query($query_hd1);
              if(!$result_hd1) { error("QUERY_ERROR"); exit; }
            $row_hd1 = mysql_fetch_object($result_hd1);

            $hd1_uid = $row_hd1->uid;
            $hd1_stock_sell = $row_hd1->qty_sell;
            $hd1_stock_now = $row_hd1->qty_now;
      
            $re1_stock_sell = $hd1_stock_sell - $H_cart_qty;
            $re1_stock_now = $hd1_stock_now + $H_cart_qty;
      
            $result_re1 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$re1_stock_sell', 
                    qty_now = '$re1_stock_now' WHERE pcode = '$H_cart_pcode'",$dbconn);
            if(!$result_re1) { error("QUERY_ERROR"); exit; }


            // 상품 재고정보 수정 ------------------------------------------------------------------------- //
            $query_hd2 = "SELECT uid,stock_sell,stock_now FROM shop_product_list WHERE pcode = '$H_cart_pcode'";
            $result_hd2 = mysql_query($query_hd2);
              if(!$result_hd2) { error("QUERY_ERROR"); exit; }
            $row_hd2 = mysql_fetch_object($result_hd2);

            $hd2_uid = $row_hd2->uid;
            $hd2_stock_sell = $row_hd2->stock_sell;
            $hd2_stock_now = $row_hd2->stock_now;
      
            $re2_stock_sell = $hd2_stock_sell - $H_cart_qty;
            $re2_stock_now = $hd2_stock_now + $H_cart_qty;
      
            $result_re2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$re2_stock_sell', 
                    stock_now = '$re2_stock_now' WHERE pcode = '$H_cart_pcode'",$dbconn);
            if(!$result_re2) { error("QUERY_ERROR"); exit; }


        }


        // 결제 정보 삭제
        $query_D1 = "DELETE FROM shop_payment WHERE uid = '$new_pay_uid'";
        $result_D1 = mysql_query($query_D1);
        if (!$result_D1) { error("QUERY_ERROR"); exit; }
        
        // 카트 정보 삭제
        $query_D1 = "DELETE FROM shop_cart WHERE pay_num = '$new_pay_num'";
        $result_D1 = mysql_query($query_D1);
        if (!$result_D1) { error("QUERY_ERROR"); exit; }
        
        // qty 하위테이블 정보 삭제
        $query_D2 = "DELETE FROM shop_product_list_qty WHERE pay_num = '$new_pay_num'";
        $result_D2 = mysql_query($query_D2);
        if (!$result_D2) { error("QUERY_ERROR"); exit; }
        
        
        
    } else {
    
        // 결제 정보 수정 [결제일 변경 가능 여부]
        if($chg_date == "1") {
          $result_CHG = mysql_query("UPDATE shop_payment SET pay_type = '$new_pay_type', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card',
            mb_type = '$new_mb_type', client_code = '$new_mb_code', name1 = '$new_mb_name', pay_date = '$post_dates', subgate = '$new_shop_subgate' 
            WHERE uid = '$new_pay_uid'",$dbconn);
        } else {
          $result_CHG = mysql_query("UPDATE shop_payment SET pay_type = '$new_pay_type', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card',
            mb_type = '$new_mb_type', client_code = '$new_mb_code', name1 = '$new_mb_name', subgate = '$new_shop_subgate' 
            WHERE uid = '$new_pay_uid'",$dbconn);
        }
          if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
    }
    
    
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_collection.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;


  } else if($add_mode == "LIST_PAY") {
  
    // 결제 마감하기
    
  
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_collection.php?mode=check&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page'>");
    exit;
  
  }

}

}
?>