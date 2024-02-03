<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "finance_income2";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/finance_income2.php?sorting_key=$sorting_key";
$link_upd = "$home/finance_income2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

// Order View
$link_view = "order1_view.php";
$radio_chk_dis = "disabled";
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
// Filtering
if($login_level > "3") {
  $sorting_filter = "branch_code = '$login_branch' AND f_class = 'in' AND f_paylink = '1' AND settle_date LIKE '$p_yearmonth%'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch'";
} else if($login_level == "3") {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate' AND f_class = 'in' AND f_paylink = '1'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate'";
} else if($login_level == "2") {
  $sorting_filter = "branch_code = '$login_branch' AND subgate = '$login_subgate' AND f_class = 'in' AND f_paylink = '1'";
  $sorting_filter_G = "branch_code = '$login_branch' AND userlevel < '6'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate'";
} else {
  $sorting_filter = "branch_code = '$login_branch' AND gate = '$login_gate' AND shop_code = '$login_shop' AND f_class = 'in' AND f_paylink = '1'";
  $sorting_filter_G = "branch_code = '$login_branch' AND client_id = '$login_gate'";
  $sorting_filter_S = "branch_code = '$login_branch' AND gate = '$login_gate' AND shop_code = '$login_shop'";
}


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "pay_date"; }
if($sorting_key == "pay_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "f_code") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "f_name") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM finance WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM finance WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM finance WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_05_02_2?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='finance_income2.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='f_code'>$txt_fin_cost_07</option>
				<option value='f_name'>$txt_fin_income_04</option>
				<option value='f_remark'>$txt_fin_cost_05</option>
				<option value='post_date'>$txt_fin_cost_06</option>
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
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key'>$txt_fin_cost_06</option>
			<option value='$PHP_SELF?sorting_key=f_code&keyfield=$keyfield&key=$key' $chk1>$txt_fin_cost_07</option>
			<option value='$PHP_SELF?sorting_key=f_name&keyfield=$keyfield&key=$key' $chk2>$txt_fin_income_04</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th><?=$txt_fin_cost_06?></th>
            <th><?=$txt_sys_shop_05?></th>
			<th><?=$txt_fin_income_03?> (IDR)</th>
			<th><?=$txt_fin_income_03?> (USD)</th>
			<th><?=$txt_fin_income_04?></th>
			<th><?=$txt_invn_return_03?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 합계 구하기
if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_IDR = "SELECT sum(amount) FROM finance 
                WHERE currency = 'IDR' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_IDR = "SELECT sum(amount) FROM finance 
                WHERE currency = 'IDR' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
}
$result_sum_IDR = mysql_query($query_sum_IDR);
if (!$result_sum_IDR) { error("QUERY_ERROR"); exit; }

$sum_pay_amount_IDR = @mysql_result($result_sum_IDR,0,0);
$sum_pay_amount_IDR_K = number_format($sum_pay_amount_IDR);

if(!eregi("[^[:space:]]+",$key)) {
  $query_sum_USD = "SELECT sum(amount) FROM finance 
                WHERE currency = 'USD' AND $sorting_filter ORDER BY $sorting_key $sort_now";
} else {
  $query_sum_USD = "SELECT sum(amount) FROM finance 
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
</tr>
");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,f_catg,f_code,f_name,f_remark,pay_num,amount,post_date,pay_date,pay_type,
              process,currency,bank_name 
      FROM finance WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,f_catg,f_code,f_name,f_remark,pay_num,amount,post_date,pay_date,pay_type,
              process,currency,bank_name 
      FROM finance WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $f_uid = mysql_result($result,$i,0);   
   $f_gate = mysql_result($result,$i,1);
   $f_catg = mysql_result($result,$i,2);
   $f_code = mysql_result($result,$i,3);
   $f_name = mysql_result($result,$i,4);
   $f_remark = mysql_result($result,$i,5);
   $f_pay_num = mysql_result($result,$i,6);
   $f_amount = mysql_result($result,$i,7);
   $post_date = mysql_result($result,$i,8);
   $pay_date = mysql_result($result,$i,9);
   $pay_type = mysql_result($result,$i,10);
   $pay_status = mysql_result($result,$i,11);
   $pay_currency = mysql_result($result,$i,12);
   $f_bank_code = mysql_result($result,$i,13);
   
   // 통화별 합계
   if($pay_currency == "USD") {
    $f_amount_IDR = "";
    $f_amount_USD = $f_amount;
   } else {
    $f_amount_IDR = $f_amount;
    $f_amount_USD = "";
   }
   $f_amount_IDR_K = number_format($f_amount_IDR);
   $f_amount_USD_K = number_format($f_amount_USD); // 소수점 보이도록
   
   // 결제일
   $wday1 = substr($post_date,0,4);
	 $wday2 = substr($post_date,4,2);
	 $wday3 = substr($post_date,6,2);
	 $wday4 = substr($post_date,8,2);
	 $wday5 = substr($post_date,10,2);
	 $wday6 = substr($post_date,12,2);

   if($pay_date == "0" OR $pay_date == "") {
      // $pay_date_txt = "--";
      $pay_date_txt = "<font color=#AAAAAA>$post_date_txt</font>";
   } else {
    if($lang == "ko") {
	    $post_date_txt = "$wday1"."/"."$wday2"."/"."$wday3";
	  } else {
	    $post_date_txt = "$wday3"."-"."$wday2"."-"."$wday1";
	  }
   }
   
   $uday1 = substr($pay_date,0,4);
	 $uday2 = substr($pay_date,4,2);
	 $uday3 = substr($pay_date,6,2);
	 $uday4 = substr($pay_date,8,2);
	 $uday5 = substr($pay_date,10,2);
	 $uday6 = substr($pay_date,12,2);

   if($pay_date == "0" OR $pay_date == "") {
      // $pay_date_txt = "--";
      $pay_date_txt = "<font color=#AAAAAA>$post_date_txt</font>";
   } else {
    if($lang == "ko") {
	    $pay_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	  } else {
	    $pay_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
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
    } else {
      $pay_type_txt = "$txt_invn_payment_10_6";
    }
    
    
    // 처리 내용
    if($pay_status == "2") {  // 수금완료[마감]
      if($pay_type == "bank" AND $f_bank_code == "") {
        $prc_status_txt = "<font color=red>$txt_invn_return_04</font>";
      }else if($pay_type == "cash" AND $f_bank_code != "") {
        $prc_status_txt = "<font color=maroon>$txt_invn_return_04</font>";
      } else {
        $prc_status_txt = "<font color=blue>$txt_invn_return_04</font>";
      }
    } else if($pay_status == "1") {
        $prc_status_txt = "<font color=black>$txt_invn_return_09</font>"; // 처리중
    } else {
        $prc_status_txt = "<font color=red>$txt_invn_payment_05</font>"; // 미지불
    }


    // 줄 색깔
    if($uid == $f_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
	

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$pay_date_txt</td>");
  echo("<td bgcolor='$highlight_color'>{$f_gate}</td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$f_uid'>{$f_amount_IDR_K}</a></div></td>");
  echo("<td bgcolor='$highlight_color'><div align=right><a href='$link_upd&mode=check&uid=$f_uid'>{$f_amount_USD_K}</a></div></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$f_uid'>($f_code) $f_name</a></td>");
  echo("<td bgcolor='$highlight_color'>$prc_status_txt</td>");
  echo("</tr>");
  
  
  if($mode == "check" AND $f_uid == $uid) {
  
  
  
    // 상세 리스트 [반환 상품 정보]
    if($f_intype == "2") {
    $query_re = "SELECT uid,catg_code,pcode,pname,price_orgin,stock_org,tprice_orgin,return_date,
                pay_code FROM shop_product_return WHERE pay_code = '$f_pay_num'";
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
          <td colspan=2><div align=right><i class='icon-caret-right'></i></div></td>
          <td colspan=5>[$re_pcode] {$re_pname} | $re_price_K x $re_qty = $re_tprice_K</td>
        </tr>");
    
    
    } else {
    // 상세 리스트 [카트]
    $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$f_pay_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5 
      FROM shop_cart WHERE pay_num = '$f_pay_num' ORDER BY pcode ASC";
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
      $query_dari = "SELECT uid,pname,price_sale FROM shop_product_list WHERE pcode = '$H_pcode'";
      $result_dari = mysql_query($query_dari);
      if(!$result_dari) { error("QUERY_ERROR"); exit; }
      $row_dari = mysql_fetch_object($result_dari);

      $dari_uid = $row_dari->uid;
      $dari_pname = $row_dari->pname;
      $dari_price_sale = $row_dari->price_sale;
      
      $dari_tprice_sale = $dari_price_sale * $H_qty;
      
      $dari_price_sale_K = number_format($dari_price_sale);
      $dari_tprice_sale_K = number_format($dari_tprice_sale);
      
      
      echo ("
        <tr height=22>
          <td colspan=2><div align=right><i class='icon-caret-right'></i></div></td>
          <td colspan=5>[$H_pcode] {$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5} | 
                $dari_price_sale_K x $H_qty = $dari_tprice_sale_K
          </td>
        </tr>");
    $cart_no++;
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
		
	
		

		
	
		<?
		if($mode == "check" AND $uid) { // 결제정보 변경

          // 결제 정보 테이블
          $pm_query = "SELECT uid,pay_num,pay_type,branch_code,gate,amount,f_catg,f_code,f_name,f_remark,
                      post_date,pay_date,process,bank_name,remit_code,pay_bank,pay_card,currency FROM finance WHERE uid = '$uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_pay_num = @mysql_result($pm_result,0,1);
          $pm_pay_type = @mysql_result($pm_result,0,2);
          $upd_branch_code = @mysql_result($pm_result,0,3);
          $upd_gate = @mysql_result($pm_result,0,4);
          $upd_pay_amount = @mysql_result($pm_result,0,5);
            $upd_pay_amount_K = number_format($upd_pay_amount);
          $upd_catg = @mysql_result($pm_result,0,6);
          $upd_acc_code = @mysql_result($pm_result,0,7);
          $upd_acc_name = @mysql_result($pm_result,0,8);
          $upd_acc_remark = @mysql_result($pm_result,0,9);
          $upd_post_date = @mysql_result($pm_result,0,10);
          $upd_pay_date = @mysql_result($pm_result,0,11);
          $upd_pay_status = @mysql_result($pm_result,0,12);
          
          $pm_bank_name = @mysql_result($pm_result,0,13);
          $pm_remit_code = @mysql_result($pm_result,0,14);
          $pm_pay_bank = @mysql_result($pm_result,0,15);
          $upd_pay_card = @mysql_result($pm_result,0,16);
          $upd_currency = @mysql_result($pm_result,0,17);
          
          if($pm_pay_type == "cash") { $pay_type_slc_cash = "selected"; } else { $pay_type_slc_cash = ""; }
          if($pm_pay_type == "bank") { $pay_type_slc_bank = "selected"; } else { $pay_type_slc_bank = ""; }
          if($pm_pay_type == "account") { $pay_type_slc_account = "selected"; } else { $pay_type_slc_account = ""; }
          if($pm_pay_type == "card") { $pay_type_slc_card = "selected"; } else { $pay_type_slc_card = ""; }
          if($pm_pay_type == "voucher") { $pay_type_slc_voucher = "selected"; } else { $pay_type_slc_voucher = ""; }
          

          
          // 처리 버튼
          if($upd_pay_status == "2") {
            $submit_txt = $txt_fin_income_01;
          } else if($upd_pay_status == "1") {
            $submit_txt = $txt_fin_income_01;
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
            if($lang == "ko") {
	            $upd_post_dates = "$Aday1"."/"."$Aday2"."/"."$Aday3".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	          } else {
	            $upd_post_dates = "$Aday3"."-"."$Aday2"."-"."$Aday1".", "."$Aday4".":"."$Aday5".":"."$Aday6";
	          }
	          
            $Cday1 = substr($upd_pay_date,0,4);
	          $Cday2 = substr($upd_pay_date,4,2);
	          $Cday3 = substr($upd_pay_date,6,2);
	          $Cday4 = substr($upd_pay_date,8,2);
	          $Cday5 = substr($upd_pay_date,10,2);
	          $Cday6 = substr($upd_pay_date,12,2);
            if($lang == "ko") {
	            $upd_pay_dates = "$Cday1"."/"."$Cday2"."/"."$Cday3".", "."$Cday4".":"."$Cday5".":"."$Cday6";
	          } else {
	            $upd_pay_dates = "$Cday3"."-"."$Cday2"."-"."$Cday1".", "."$Cday4".":"."$Cday5".":"."$Cday6";
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
          
          // 통화
          if($upd_currency == "USD") {
            $currency_chk_IDR = "";
            $currency_chk_USD = "checked";
          } else {
            $currency_chk_IDR = "checked";
            $currency_chk_USD = "";
          }
          

      echo ("
      <form name='signform2' class='cmxform form-horizontal adminex-form' method='post' action='finance_income2.php'>
      <input type='hidden' name='step_next' value='permit_upd'>
      <input type='hidden' name='sorting_key' value='$sorting_key'>
      <input type='hidden' name='keyfield' value='$keyfield'>
      <input type='hidden' name='key' value='$key'>
      <input type='hidden' name='page' value='$page'>
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_client' value='$upd_gate'>
      <input type=hidden name='new_tprice_orgin' value='$upd_pay_amount'>
      
      <input type=hidden name='new_pay_uid' value='$pm_uid'>
      <input type=hidden name='new_pay_num' value='$pm_pay_num'>");
	  ?>

		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_comm_frm05?>
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user2_07?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_shop_code">
											<?
												$query_S1 = "SELECT count(uid) FROM client_shop WHERE $sorting_filter_S AND userlevel > '0'";
												$result_S1 = mysql_query($query_S1,$dbconn);
												if (!$result_S1) { error("QUERY_ERROR"); exit; }
      
												$total_S1ss = @mysql_result($result_S1,0,0);
      
												$query_S2 = "SELECT uid,shop_code,shop_name FROM client_shop 
															WHERE $sorting_filter_S AND userlevel > '0' ORDER BY shop_code ASC";
												$result_S2 = mysql_query($query_S2,$dbconn);
												if (!$result_S2) { error("QUERY_ERROR"); exit; }   

												for($s = 0; $s < $total_S1ss; $s++) {
													$shop_uid = mysql_result($result_S2,$s,0);
													$shop_code = mysql_result($result_S2,$s,1);
													$shop_name = mysql_result($result_S2,$s,2);
                
													if($shop_code == $upd_gate) {
														$shop_slct = "selected";
													} else {
														$shop_slct = "";
													}
              
													echo("<option value='$shop_code' $shop_slct>&nbsp; $shop_name [$shop_code]</option>");
												}
												?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_fin_cost_02?></label>
                                        <div class="col-sm-9">
											<?
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
												?>
											</select>
										</div>
                                    </div>
									
									
									<?
									// Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_sys_bank_13</label>
                                        <div class='col-sm-9'>
											<input type=radio name='new_currency' value='IDR' $currency_chk_IDR> IDR &nbsp;&nbsp;&nbsp; 
											<input type=radio name='new_currency' value='USD' $currency_chk_USD> USD
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_fin_income_03</label>
                                        <div class='col-sm-4'>
											<input type='text' class='form-control' name='new_amount' value='$upd_pay_amount' style='text-align: right' required>
										</div>
                                    </div>
									
									<!------- 상세 보기 // ------------->
									
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_fin_income_04</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_fname' value='$upd_acc_name' required>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_fin_income_05</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_fremark' value='$upd_acc_remark'>
										</div>
                                    </div>
									
									
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
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_21</label>
                                        <div class='col-sm-4'>");
												$query_K2C = "SELECT count(uid) FROM code_bank WHERE branch_code = '$login_branch' AND userlevel > '0'";
												$result_K2C = mysql_query($query_K2C);
												$total_K2C = @mysql_result($result_K2C,0,0);
                
												$query_K2 = "SELECT bank_code,bank_name FROM code_bank 
															WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY bank_code ASC";
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
                                    </div>");
									
									
									
									
									// 결제일
									if($upd_pay_status == "2") {
										
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_03</label>
                                        <div class='col-sm-4'>
											<input disabled type='text' class='form-control' name='dis_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>");
									
									}
									
									echo ("
									
									
									
									<!---------- payment status // -------------------------------------------------->
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_fin_income_01</label>
                                        <div class='col-sm-9'>");
											
											if($upd_pay_status == "2") {
												echo("
												<input type=radio name='new_pay_status' value='' checked> <font color=blue>$txt_invn_return_04</font> &nbsp;&nbsp; 
												<input $radio_chk_dis type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04</font> &nbsp;&nbsp; 
												");
											} else if($upd_pay_status == "1") {
												echo("
												<input type=radio name='new_pay_status' value='' checked> <font color=black>$txt_invn_return_09</font> &nbsp;&nbsp; 
												<input $radio_chk_dis type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04</font> &nbsp;&nbsp; 
												<input type=radio name='new_pay_status' value='2'> <font color=blue>$txt_invn_return_04</font>
												");
											} else {
												echo("
												<input type=radio name='new_pay_status' value='1' checked> <font color=red>$txt_invn_payment_09</font> &nbsp;&nbsp; 
												<input type=radio name='new_pay_status' value=''> $txt_comm_frm06 
												");
											}
											echo ("
										</div>
                                    </div>
									
									
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

		
		
		
	  <? } else { ?>
		
		
		<?
		if($WEB_LOGIN == "local") {
			$submit_disable = "disabled";
		} else {
			$submit_disable = "disabled";
		}
	  
		echo ("
		<form name='signform' class='cmxform form-horizontal adminex-form' method='post' action='finance_income2.php'>
		<input type='hidden' name='step_next' value='permit_okay'>");
		?>
		

		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        
		
        <div class="panel-body">
		
		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Select DataBase</label>
                                        <div class="col-sm-4">
												<?
												$queryC = "SELECT count(uid) FROM client_db";
												$resultC = mysql_query($queryC);
												$total_recordC = mysql_result($resultC,0,0);
      
												$queryD = "SELECT db_name FROM client_db ORDER BY db_name ASC";
												$resultD = mysql_query($queryD);
												
												echo("<select name='sync_db_name' class='form-control'>");

												for($i = 0; $i <= $total_recordC; $i++) {
													$db_name = mysql_result($resultD,$i,0);

													echo("<option value='$db_name'>$db_name</option>");
												}
												echo ("
												</select>
										</div>
										<div class='col-sm-2'>
												<input $submit_disable class='btn btn-primary' type='submit' value='$txt_comm_frm17'>
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
  
  
  // 상위 계정항목
  $new_fcatg = substr($new_acc_code,0,2);


    if($new_pay_status == "2") { // 수금마감
    
        // 결제 정보 수정
        $result_CHG = mysql_query("UPDATE shop_payment SET pay_type = '$new_pay_type', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card', 
            f_catg = '$new_fcatg', f_code = '$new_acc_code', currency = '$new_currency', 
            mb_type = '$new_mb_type', name1 = '$new_mb_name', pay_state = '2', pay_date = '$post_dates', 
            invoice_print = '2' WHERE pay_num = '$new_pay_num'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 결제 정보 수정 (FINANCE)
        $result_CHG2 = mysql_query("UPDATE finance SET gate = '$new_shop_code', f_catg = '$new_fcatg',
            f_code = '$new_acc_code', currency = '$new_currency', pay_type = '$new_pay_type', amount = '$new_amount', 
            f_name = '$new_fname', f_remark = '$new_fremark', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card', 
            process = '2', pay_date = '$post_dates' WHERE uid = '$new_pay_uid'",$dbconn);
        if(!$result_CHG2) { error("QUERY_ERROR2"); exit; }

    } else if($new_pay_status == "0") { // 수금취소
    
        
        // 결제 정보 삭제
        $query_D1 = "DELETE FROM shop_payment WHERE pay_num = '$new_pay_num'";
        $result_D1 = mysql_query($query_D1);
        if (!$result_D1) { error("QUERY_ERROR"); exit; }
        
        // 결제 정보 삭제 (FINANCE)
        $query_D1f = "DELETE FROM finance WHERE uid = '$new_pay_uid'";
        $result_D1f = mysql_query($query_D1f);
        if (!$result_D1f) { error("QUERY_ERROR"); exit; }
        
        // 카트 정보 삭제
        $query_D2 = "DELETE FROM shop_cart WHERE pay_num = '$new_pay_num'";
        $result_D2 = mysql_query($query_D2);
        if (!$result_D2) { error("QUERY_ERROR"); exit; }
        
        // qty 하위테이블 정보 삭제
        $query_D2f = "DELETE FROM shop_product_list_qty WHERE pay_num = '$new_pay_num'";
        $result_D2f = mysql_query($query_D2f);
        if (!$result_D2f) { error("QUERY_ERROR"); exit; }
    
        
        
    } else {
    
        
        // 결제 정보 수정
        $result_CHG = mysql_query("UPDATE shop_payment SET pay_type = '$new_pay_type', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card', 
            f_catg = '$new_fcatg', f_code = '$new_acc_code', currency = '$new_currency', 
            mb_type = '$new_mb_type', name1 = '$new_mb_name' WHERE pay_num = '$new_pay_num'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 결제 정보 수정 (FINANCE)
        $result_CHG2 = mysql_query("UPDATE finance SET gate = '$new_shop_code', f_catg = '$new_fcatg',
            f_code = '$new_acc_code', currency = '$new_currency', pay_type = '$new_pay_type', amount = '$new_amount', 
            f_name = '$new_fname', f_remark = '$new_fremark', bank_name = '$new_bank_code', 
            remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_card = '$new_pay_card' 
            WHERE uid = '$new_pay_uid'",$dbconn);
        if(!$result_CHG2) { error("QUERY_ERROR"); exit; }
        
        
        
    }
    
    
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_income2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;





} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
  $m_ip = getenv('REMOTE_ADDR');
  
  $memo = "UPDATED: "."$signdates";

  
  // DB 계정정보 추출
  $query_dbs = "SELECT db_account,db_passwd,host FROM client_db WHERE db_name = '$sync_db_name'";
  $result_dbs = mysql_query($query_dbs,$dbconn);
  if(!$result_dbs) { error("QUERY_ERROR"); exit; }
  
  $row_now = mysql_fetch_object($result_dbs);

  $now_db_account = $row_now->db_account;
  $now_db_passwd = $row_now->db_passwd;
  $now_db_host = $row_now->host;
  
  
  // 원본 DB 연결함수
  $dbconn_org = mysql_connect("localhost","$now_db_account","$now_db_passwd") or die("Failed to connect the Database!");
  $status_org = mysql_select_db($sync_db_name,$dbconn_org);
  if (!$status_org) { error("DB_ERROR"); exit; }
  
  $report_last_date2 = $report_last_date . "000000";

  // 원본 테이블에서 데이터 추출
  $query_P1 = "SELECT count(uid) FROM shop_ordersheet WHERE confirm_state = '1' AND signtime > $report_last_date2";
  $result_P1 = mysql_query($query_P1,$dbconn_org);
  if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
  $total_P1ss = @mysql_result($result_P1,0,0);
      
  $query_P2 = "SELECT uid,order_num,id,ip,name1,name2,birthday,calendar,gender,email,product,bk_memo,
            tamount,tamount_dc,tamount_money,tamount_point,tamount_delivery,tamount_orgin,tpoint,
            zipcodeA,addrA1,addrA2,phoneA,phone_cel,phone_fax,shipping_note,shipping_date,
            pay_type,pay_bank,confirm_time,maker_code,signdate,signtime,lang,gate 
            FROM shop_ordersheet WHERE confirm_state = '1' AND signtime > $report_last_date2 ORDER BY uid ASC";
  $result_P2 = mysql_query($query_P2,$dbconn_org);
  if (!$result_P2) { error("QUERY_ERROR"); exit; }   

  for($p = 0; $p < $total_P1ss; $p++) {

    $org_uid = mysql_result($result_P2,$p,0);
    $org_order_num = mysql_result($result_P2,$p,1);
    $org_id = mysql_result($result_P2,$p,2);
    $org_m_ip = mysql_result($result_P2,$p,3);
    $org_name = mysql_result($result_P2,$p,4);
    $org_name2 = mysql_result($result_P2,$p,5);
      if($org_name == "") {
        $new_name = $org_name2;
      } else {
        $new_name = $org_name;
      }
    $org_birthday = mysql_result($result_P2,$p,6);
      $new_birthday = "19" . $org_birthday;
    $org_calendar = mysql_result($result_P2,$p,7);
    $org_gender = mysql_result($result_P2,$p,8);
    $org_email = mysql_result($result_P2,$p,9);
    $org_product = mysql_result($result_P2,$p,10);
    $org_memo = mysql_result($result_P2,$p,11);
    $org_tamount = mysql_result($result_P2,$p,12);
    $org_tamount_dc = mysql_result($result_P2,$p,13);
    $org_tamount_money = mysql_result($result_P2,$p,14);
    $org_tamount_point = mysql_result($result_P2,$p,15);
    $org_tamount_delivery = mysql_result($result_P2,$p,16);
    $org_tamount_orgin = mysql_result($result_P2,$p,17);
    $org_tpoint = mysql_result($result_P2,$p,18);
    $org_zipcode = mysql_result($result_P2,$p,19);
    $org_addr1 = mysql_result($result_P2,$p,20);
    $org_addr2 = mysql_result($result_P2,$p,21);
    $org_phone = mysql_result($result_P2,$p,22);
    $org_phone_cel = mysql_result($result_P2,$p,23);
    $org_phone_fax = mysql_result($result_P2,$p,24);
    $org_shipping_note = mysql_result($result_P2,$p,25);
    $org_shipping_date = mysql_result($result_P2,$p,26);
    $org_pay_type = mysql_result($result_P2,$p,27);
    $org_pay_bank = mysql_result($result_P2,$p,28);
    $org_confirm_time = mysql_result($result_P2,$p,29);
    $org_maker_code = mysql_result($result_P2,$p,30);
    $org_signdate = mysql_result($result_P2,$p,31);
    $org_signtime = mysql_result($result_P2,$p,32);
    $org_lang = mysql_result($result_P2,$p,33);
    $org_gate = mysql_result($result_P2,$p,34);
    
    // ERP의 client에서 지정된 shop_code (gate)와 일치하는 지사코드/매장코드
    $query_erp_gate = "SELECT branch_code,client_id FROM client WHERE db_name = '$sync_db_name' AND db_gate = '$org_gate'";
    $result_erp_gate = mysql_query($query_erp_gate,$dbconn);
    
    $new_branch_code = @mysql_result($result_erp_gate,0,0);
    $new_gate = @mysql_result($result_erp_gate,0,1);

    $new_memo = $org_memo . "<br><br> $memo";
  
    // 타겟 테이블에서 org_uid가 있는지 확인
    $result_chk = mysql_query("SELECT count(uid) FROM finance 
                  WHERE org_db = '$sync_db_name' AND org_uid = '$org_uid'",$dbconn);
    if (!$result_chk) { error("QUERY_ERROR"); exit; }
    $row_chk = @mysql_result($result_chk,0,0);
  
    if($row_chk) {
      $query_upd = "UPDATE finance SET gate = '$new_gate', sync_date = '$signdate', 
            pay_type = '$org_pay_type', amount = '$org_tamount_dc' 
            WHERE org_db = '$sync_db_name' AND org_uid = '$org_uid'";
      $result_upd = mysql_query($query_upd,$dbconn);
      if (!$result_upd) { error("QUERY_ERROR"); exit; }
    
    } else {
    
      // 새로운 SO 코드 부여
      $exp_br_code = explode("_",$new_branch_code);
      $exp_branch_code = $exp_br_code[1];
  
      $new_pay_num = "SO-"."$exp_branch_code"."-"."$signdate"; // 판매 수익
      
      // 계정 관련 정보
      $new_f_name = "Ref. "."$new_pay_num"." [on]";
      $new_f_remark = "$org_order_num"." from Website";
      
      
      // 정보 입력
      $query_post = "INSERT INTO finance (uid,org_uid,org_db,sync_date,sync_on,branch_code,gate,
          f_class,f_paylink,f_catg,f_code,f_name,f_remark,order_num,pay_num,pay_type,currency,
          amount,pay_bank,memo,post_date,order_date,pay_date,process) values ('',
          '$org_uid','$sync_db_name','$signdate','1','$new_branch_code','$new_gate',
          'in','1','A1','A101','$new_f_name','$new_f_remark','$org_order_num','$new_pay_num','$org_pay_type','IDR',
          '$org_tamount_dc','$org_pay_bank','$new_memo','$org_signtime','$org_signtime','$org_confirm_time','2')";
      $result_post = mysql_query($query_post,$dbconn);
      if (!$result_post) { error("QUERY_ERROR"); exit; }

      
    }

  
  
  }
  
  
  



    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/finance_income2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;

}

}
?>