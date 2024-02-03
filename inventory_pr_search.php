<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_pr_search";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_pr_search.php?sorting_key=$sorting_key";
$link_list_action = "$home/inventory_pr_search.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_post = "$home/inventory_pr_search.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_post_catg = "$home/inventory_pr_search.php?mode=post_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_del = "process_pr_del.php?mode=del&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_del_catg = "process_pr_del.php?mode=del_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
		var window_left = (screen.width-800)/2;
		var window_top = (screen.height-480)/2;
		window.open(ref,"cat_win",'width=310,height=320,status=no,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
// Filtering
if(!$sorting_key) { $sorting_key = "post_date"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pname") { $chk2 = "selected"; } else { $chk2 = ""; }


// 공급자용 상품 코드 입력란 필요 여부



if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_catg";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_catg";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_catg WHERE $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_02_02a?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_pr_search.php'>
			<div class='col-sm-2'>
			<select name='keyfield' class='form-control'>
            <option value='pcode'>$txt_invn_stockin_06</option>
            <option value='pname'>$txt_invn_stockin_05</option>
            <option value='post_date'>$txt_invn_stockin_18</option>
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
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key'>$txt_invn_stockin_18</option>
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=pname&keyfield=$keyfield&key=$key' $chk2>$txt_invn_stockin_05</option>
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
			<th><?=$txt_invn_stockin_07?></th>
			<th><?=$txt_invn_stockin_17?></th>
			<th><?=$txt_invn_stockin_25?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 검색된 재고 합계
$query_tsm1 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty WHERE flag = 'in'";
$result_tsm1 = mysql_query($query_tsm1);
if (!$result_tsm1) { error("QUERY_ERROR"); exit; }

$prd_tsm_qty = @mysql_result($result_tsm1,0,0);
 $prd_tsm_qty_K = number_format($prd_tsm_qty);
$prd_tsm_price = @mysql_result($result_tsm1,0,1);
 $prd_tsm_price_K = number_format($prd_tsm_price);


echo ("
<tr>
   <td colspan=4 align=center><b>Total</b></td>
   <td align=right>{$prd_tsm_qty_K}</td>
   <td align=right>{$prd_tsm_price_K}</td>
</tr>
");


$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,tprice_orgin,tprice_sale,tprice_margin,tstock_org
      FROM shop_product_catg ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,tprice_orgin,tprice_sale,tprice_margin,tstock_org
      FROM shop_product_catg WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_branch = mysql_result($result,$i,1);
   $prd_catg = mysql_result($result,$i,2);
      $prd_catg1 = substr($prd_catg,0,1);
      $prd_catg2 = substr($prd_catg,1,1);
      $prd_catg_txt = "$prd_catg1"."."."$prd_catg2".".";
   $prd_gcode = mysql_result($result,$i,3);
   $prd_name = mysql_result($result,$i,4);
   $prd_price_orgin = mysql_result($result,$i,5);
      $prd_price_orgin_K = number_format($prd_price_orgin);
   $prd_price_sale = mysql_result($result,$i,6);
      $prd_price_sale_K = number_format($prd_price_sale);
   $prd_price_margin = mysql_result($result,$i,7);
      $prd_price_margin_K = number_format($prd_price_margin);
   $prd_qty = mysql_result($result,$i,8);
   
   // 하위 테이블에서 수량과 총매입액 추출
   $query_sub = "SELECT sum(stock) FROM shop_product_list_qty WHERE gcode = '$prd_gcode' AND flag = 'in'";
   $result_sub = mysql_query($query_sub);
   
   $sum_qty_org = @mysql_result($result_sub,0,0);

   
   if($uid == $prd_uid AND ( $mode == "upd_catg" OR $mode == "post" )) {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>{$prd_gcode}</td>");

  echo("
        <td bgcolor='$highlight_color'>{$prd_name}</td>
        <td bgcolor='$highlight_color' align=right>&nbsp;</td>
      ");

  // 상품군별 총 매입가 [산출 불가능]
  
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sum_qty_org</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>&nbsp;</font></td>");


  echo("</tr>");
  
  // 상세보기 [상품 리스트]
    
    $query_HC = "SELECT count(uid) FROM shop_product_list WHERE gcode = '$prd_gcode'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,gate,catg_code,pcode,pname,
      supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
      product_option4,product_option5,price_orgin FROM shop_product_list WHERE gcode = '$prd_gcode' 
      ORDER BY $sorting_key $sort_now";
    $result_H = mysql_query($query_H);
    if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
    for($h = 0; $h < $total_HC; $h++) {
      $H_prd_uid = mysql_result($result_H,$h,0);
      $H_prd_gate = mysql_result($result_H,$h,1);
      $H_prd_catg = mysql_result($result_H,$h,2);
      $H_prd_code = mysql_result($result_H,$h,3);
      $H_prd_name = mysql_result($result_H,$h,4);
      
      $H_supp_code = mysql_result($result_H,$h,5);
      $H_shop_code = mysql_result($result_H,$h,6);
      $H_prd_color = mysql_result($result_H,$h,7);
      $H_prd_size = mysql_result($result_H,$h,8);
      $H_confirm_status = mysql_result($result_H,$h,9);
      $H_p_opt1 = mysql_result($result_H,$h,10);
      $H_p_opt2 = mysql_result($result_H,$h,11);
      $H_p_opt3 = mysql_result($result_H,$h,12);
      $H_p_opt4 = mysql_result($result_H,$h,13);
      $H_p_opt5 = mysql_result($result_H,$h,14);
      $H_prd_qty = mysql_result($result_H,$h,15);
      
      // 총 매입수량과 액수
      $query_sux = "SELECT price_orgin, sum(stock) FROM shop_product_list_qty WHERE org_uid = '$H_prd_uid' AND flag = 'in'";
      $result_sux = mysql_query($query_sux);
   
      $sumx_price_org = @mysql_result($result_sux,0,0);
        $sumx_price_org_K = number_format($sumx_price_org);
      $sumx_qty_org = @mysql_result($result_sux,0,1);
      
      $sumx_tprice_org = $sumx_price_org * $sumx_qty_org;
        $sumx_tprice_org_K = number_format($sumx_tprice_org);
      
      
      
      if($H_supp_code == "") {
        $H_supp_code_txt = "<font color=red>$txt_invn_stockout_06</font>";
      } else {
        $H_supp_code_txt = "$H_supp_code";
      }
      
      if($H_shop_code == "") {
        $H_shop_code_txt = "<font color=#AAAAAA>$txt_invn_stockout_06</font>";
      } else {
        $H_shop_code_txt = "$txt_invn_stockout_07";
      }
      
      if($H_prd_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
        $highlight_color_L = "#EFEFEF";
      } else {
        $highlight_color_L = "#FFFFFF";
      }
      
      
      
      // 색상과 크기
      if($H_prd_color != "") {
        $H_prd_color_txt = "[$H_prd_color]";
      } else {
        $H_prd_color_txt = "";
      }
      if($H_prd_size != "") {
        $H_prd_size_txt = "[$H_prd_size]";
      } else {
        $H_prd_size_txt = "";
      }
      
      // 기타 옵션
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
    // 제품의 매장이 지정되었는지 여부
    if($H_shop_code == "") {
      $H_shop_code_txt = "<font color=red>$txt_invn_stockout_06</font>";
    } else {
      $H_shop_code_txt = "<font color=blue>$H_shop_code</font>";
    }
    
    // 하위 수량 테이블
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$H_prd_code' AND flag = 'in'";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
    if($view == "qty" AND $H_prd_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
      $H_prd_qty_link = "<i class='fa fa-chevron-down'></i> <a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty'>$sumx_qty_org</a>";
    } else {
      $H_prd_qty_link = "<a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty'>$sumx_qty_org</a>";
    }

    echo ("
    <tr>
      <td align=right><i class='fa fa-caret-right'></i></td>
      <td bgcolor='$highlight_color_L'>{$H_prd_code}</td>
      <td bgcolor='$highlight_color_L'><a href='$link_list_action&mode=upd&uid=$H_prd_uid' 
            data-toggle='tooltip' data-placement='top' title='[$H_prd_code] {$H_prd_name} - {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}'>{$H_prd_name} 
            {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a></td>
      <td bgcolor='$highlight_color_L' align=right>{$sumx_price_org_K}</td>
      <td bgcolor='$highlight_color_L' align=right>{$H_prd_qty_link}</td>
      <td bgcolor='$highlight_color_L' align=right>{$sumx_tprice_org_K}</td>
    </tr>");
    
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $uid == "$H_prd_uid") {
    
        $query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid 
                      FROM shop_product_list_qty WHERE pcode = '$H_prd_code' AND flag = 'in' ORDER BY date ASC";
        $result_qs2 = mysql_query($query_qs2,$dbconn);
        if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

        for($qs = 0; $qs < $total_qs; $qs++) {
          $qs_uid = mysql_result($result_qs2,$qs,0);
          $qs_stock = mysql_result($result_qs2,$qs,1);
          $qs_date = mysql_result($result_qs2,$qs,2);
          $qs_flag = mysql_result($result_qs2,$qs,3);
          $qs_pay_num = mysql_result($result_qs2,$qs,4);
          $qs_gudang_code = mysql_result($result_qs2,$qs,5);
          $qs_supp_code = mysql_result($result_qs2,$qs,6);
          $qs_shop_code = mysql_result($result_qs2,$qs,7);
          $qs_org_uid = mysql_result($result_qs2,$qs,8);
          
          // 상품 구입가격 [원가] ★
          $query_qsp = "SELECT price_orgin FROM shop_product_list WHERE uid = '$qs_org_uid'";
          $result_qsp = mysql_query($query_qsp,$dbconn);
          if (!$result_qsp) { error("QUERY_ERROR"); exit; }   
          
          $qs_price_orgin = @mysql_result($result_qsp,0,0);
          $qs_price_orgin_K = number_format($qs_price_orgin);
          
          $qs_tprice_orgin = $qs_price_orgin * $qs_stock;
          $qs_tprice_orgin_K = number_format($qs_tprice_orgin);
          
          
          // 상품 카트 - 결제번호 및 수량 추출
          $query_qs3 = "SELECT uid,f_class,qty FROM shop_cart WHERE pay_num = '$qs_pay_num' AND expire = '1'";
          $result_qs3 = mysql_query($query_qs3,$dbconn);
          if (!$result_qs3) { error("QUERY_ERROR"); exit; }   
          
          $qs_cart_uid = @mysql_result($result_qs3,0,0);
          $qs_f_class = @mysql_result($result_qs3,0,1);
          $qs_qty = @mysql_result($result_qs3,0,2);
          
          // 결제금액 추출 1
          $query_qs4 = "SELECT uid,pay_amount,pay_date,pay_state FROM shop_payment WHERE pay_num = '$qs_pay_num'";
          $result_qs4 = mysql_query($query_qs4,$dbconn);
          if (!$result_qs4) { error("QUERY_ERROR"); exit; }   
          
          $qs_pay_uid = @mysql_result($result_qs4,0,0);
          $qs_pay_amount = @mysql_result($result_qs4,0,1);
            $qs_pay_amount_K = number_format($qs_pay_amount);
          $qs_pay_date = @mysql_result($result_qs4,0,2);
          $qs_pay_status = @mysql_result($result_qs4,0,3);
          
          // 결제금액 추출 2
          $query_qs5 = "SELECT uid,amount,pay_date,process FROM finance WHERE pay_num = '$qs_pay_num'";
          $result_qs5 = mysql_query($query_qs5,$dbconn);
          if (!$result_qs5) { error("QUERY_ERROR"); exit; }   
          
          $qs_pay_uid2 = @mysql_result($result_qs5,0,0);
          $qs_pay_amount2 = @mysql_result($result_qs5,0,1);
            $qs_pay_amount2_K = number_format($qs_pay_amount2);
          $qs_pay_date2 = @mysql_result($result_qs5,0,2);
          $qs_pay_status2 = @mysql_result($result_qs5,0,3);
          
          if($qs_pay_status == "2") {
            $qs_pay_color = "blue";
          } else if($qs_pay_status == "1") {
            $qs_pay_color = "black";
          } else {
            $qs_pay_color = "red";
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
          
          $qs_amount = $H_prd_price_orgin * $qs_stock;
          $qs_amount_K = number_format($qs_amount);
          
          // BUY/SELL FLAG
          if($qs_flag == "out") {
            $qs_flag_txt = "<font color=red>OUT (-)</font>";
          } else if($qs_flag == "in") {
            $qs_flag_txt = "<font color=blue>IN (+)</font>";
          } else {
            $qs_flag_txt = "<font color=red>?</font>";
          }
          
          // 공급자 이름 추출
          $query_qs6 = "SELECT name FROM member_main WHERE code = '$qs_supp_code'";
          $result_qs6 = mysql_query($query_qs6,$dbconn);
          if (!$result_qs6) { error("QUERY_ERROR"); exit; }   
          
          $qs_supp_name = @mysql_result($result_qs6,0,0);
          
          if($qs_uid == $qty_uid) {
            $qs_uid_font_color = "red";
          } else {
            $qs_uid_font_color = "blue";
          }
          
          echo ("
          <tr height=22>
            
            
            <td bgcolor='#FFFFFF'>&nbsp;</td>
            <td bgcolor='#FFFFFF'>$qs_flag_txt</td>
            <td bgcolor='#FFFFFF' align=right>");
              if($qs_flag == "S") { 
                echo ("<font color='$qs_uid_font_color'>$qs_shop_code</font> <a href='#' data-toggle='tooltip' data-placement='top' title='[$qs_stock] $qs_pay_amount_K'>[$qs_pay_num]</a>");
              } else {
                echo ("<a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty&qty_uid=$qs_uid'><font color='$qs_uid_font_color'>$qs_gudang_code</font></a> <a href='#' data-toggle='tooltip' data-placement='top' title='$qs_supp_name'>[$qs_supp_code]</a>&nbsp;");
              }
              echo ("
              $qs_date_txt
            </td>
            <td bgcolor='#FFFFFF' align=right>{$qs_price_orgin_K}</td>");
            
            // 각 총매입가
            if($qs_flag == "out") { 
              echo ("<td bgcolor='#FFFFFF' align=right><font color=red>-</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
            } else {
              echo ("<td bgcolor='#FFFFFF' align=right><font color=blue>+</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
            }
            if($qs_flag == "out") { 
              echo ("<td bgcolor='#FFFFFF' align=right><input type=text name='qs_pay_amount' value='$qs_pay_amount' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
            } else {
              echo ("<td bgcolor='#FFFFFF' align=right>{$qs_tprice_orgin_K}</td>");
            }
            
            echo ("
            
          </tr>");
            
        }
    
    
    
      }
    
    }
  
  
  // echo("<tr><td colspan=8 height=2 bgcolor=#FFFFFF></td></tr>");

   $article_num--;
}



// Data Extraction
          $query_upd = "SELECT uid,catg_uid,gudang_code,supp_code,branch_code,gate,shop_code,catg_code,gcode,pcode,org_pcode,pname,
                        price_orgin,price_market,price_sale,stock_org,stock_now,catg_uid,product_color,product_size,
                        product_option1,product_option2,product_option3,product_option4,product_option5,
                        confirm_status,post_date,upd_date,lot_no,date_expire,product_desc 
                        FROM shop_product_list WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_catg_uid = $row_upd->catg_uid;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_supp_code = $row_upd->supp_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_gate = $row_upd->gate;
          $upd_shop_code = $row_upd->shop_code;
          $upd_catg_code = $row_upd->catg_code;
            $upd_catg_code1 = substr($upd_catg_code,0,1);
            $upd_catg_code2 = substr($upd_catg_code,1,1);
            $upd_catg_code_txt = "$upd_catg_code1"."."."$upd_catg_code2".".";
            
            if($upd_catg_code1 == "4") { // SAPROTAN
              $upd_lot_need = "0";
              $add_details_need = "1";
            }else if($upd_catg_code1 == "5"){
				$upd_lot_need = "0";
				$add_details_need = "0";
			}else {
              $upd_lot_need = "1";
              $add_details_need = "0";
            }
            
          $upd_gcode = $row_upd->gcode;
		  $upd_pcode = $row_upd->pcode;
          $upd_org_pcode = $row_upd->org_pcode;
          $upd_pname = $row_upd->pname;
          $upd_price_orgin = $row_upd->price_orgin;
          $upd_price_market = $row_upd->price_market;
          //$upd_price_sale = $row_upd->price_sale;
          $upd_stock_org = $row_upd->stock_org;
          $upd_stock_now = $row_upd->stock_now;
          $upd_catg_uid = $row_upd->catg_uid;
          $upd_p_color = $row_upd->product_color;
          $upd_p_size = $row_upd->product_size;
          $upd_p_option1 = $row_upd->product_option1;
          $upd_p_option2 = $row_upd->product_option2;
          $upd_p_option3 = $row_upd->product_option3;
          $upd_p_option4 = $row_upd->product_option4;
          $upd_p_option5 = $row_upd->product_option5;
          $upd_confirm_status = $row_upd->confirm_status;
          $upd_post_date = $row_upd->post_date;
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
          $upd_return_date = $row_upd->upd_date;
            $Bday1 = substr($upd_return_date,0,4); 
	          $Bday2 = substr($upd_return_date,4,2);
	          $Bday3 = substr($upd_return_date,6,2);
	          $Bday4 = substr($upd_return_date,8,2);
	          $Bday5 = substr($upd_return_date,10,2);
	          $Bday6 = substr($upd_return_date,12,2);
            if($lang == "ko") {
	            $upd_return_dates = "$Bday1"."/"."$Bday2"."/"."$Bday3".", "."$Bday4".":"."$Bday5".":"."$Bday6";
	          } else {
	            $upd_return_dates = "$Bday3"."-"."$Bday2"."-"."$Bday1".", "."$Bday4".":"."$Bday5".":"."$Bday6";
	          }
	        $upd_lot_no = $row_upd->lot_no;
	        $upd_product_desc = $row_upd->product_desc;
	        $upd_expire_date = $row_upd->date_expire;
	          $Eday1 = substr($upd_expire_date,0,4);
	          $Eday2 = substr($upd_expire_date,4,2);
	          $Eday3 = substr($upd_expire_date,6,2);
	          $Eday4 = substr($upd_expire_date,8,2);
	          $Eday5 = substr($upd_expire_date,10,2);
	          $Eday6 = substr($upd_expire_date,12,2);
	          $upd_expire_dates = "$Eday3"."$Eday2"."$Eday1";
	        
          
          
          // 해당 상품군의 옵션
          $query_upd2 = "SELECT pcode,p_opt_name1,p_opt_name2,p_opt_name3,p_opt_name4,p_opt_name5,
                        p_option1,p_option2,p_option3,p_option4,p_option5 FROM shop_product_catg WHERE uid = '$upd_catg_uid'";
          $result_upd2 = mysql_query($query_upd2);
          if(!$result_upd2) { error("QUERY_ERROR"); exit; }
          $row_upd2 = mysql_fetch_object($result_upd2);

          $upd_group_code = $row_upd2->pcode;
          $p_opt_name1 = $row_upd2->p_opt_name1;
          $p_opt_name2 = $row_upd2->p_opt_name2;
          $p_opt_name3 = $row_upd2->p_opt_name3;
          $p_opt_name4 = $row_upd2->p_opt_name4;
          $p_opt_name5 = $row_upd2->p_opt_name5;
          $p_option1 = $row_upd2->p_option1;
          $p_option2 = $row_upd2->p_option2;
          $p_option3 = $row_upd2->p_option3;
          $p_option4 = $row_upd2->p_option4;
          $p_option5 = $row_upd2->p_option5;      
//Leo
		  $query_upd_price_sale = "SELECT price_sale,supp_code FROM shop_product_list WHERE uid = '$uid'";
          $result_upd_price_sale = mysql_query($query_upd_price_sale);
          if(!$result_upd_price_sale) { error("QUERY_ERROR"); exit; }
          $row_upd_price_sale = mysql_fetch_object($result_upd_price_sale);
		  
		  $upd_price_sale = $row_upd_price_sale->price_sale;
		  $upd_supp_code = $row_upd_price_sale->supp_code;
//End Leo
?>
		
        </tbody>
        </table>
		</section>
		
		
		
		
			<br />
			<div class="row">
			<div class="col-sm-2">
			
				
				<?
				if($mode == "upd") { echo ("
				<form name='p_cart' method='post' action='sales_pr_order_cart.php'>
				<input type=hidden name='cart_mode' value='CART_ADD'>
				<input type=hidden name='cart_prd_uid' value='$upd_uid'>
				<input type=hidden name='cart_prd_code' value='$upd_pcode'>
				<input type=hidden name='cart_prd_name' value='$upd_pname'>
				<input type=hidden name='cart_price_orgin' value='$upd_price_orgin'>
				<input type=hidden name='sorting_key' value='$sorting_key'>
				<input type=hidden name='key_shop' value='$key_shop'>
				<input type=hidden name='keyfield' value='$keyfield'>
				<input type=hidden name='key' value='$key'>
				<input type=hidden name='cart_opt1' value='$upd_p_option1'>
				<input type=hidden name='cart_opt2' value='$upd_p_option2'>
				<input type=hidden name='cart_opt3' value='$upd_p_option3'>
				<input type=hidden name='cart_opt4' value='$upd_p_option4'>
				<input type=hidden name='cart_opt5' value='$upd_p_option5'>

				<input type='text' name='cart_qty' maxlength=6 value='10' class='form-control' style='text-align: center'> 
			</div>
			
			
			<div class='col-sm-2'>
				<input type='submit' value='$txt_invn_purchase_12pr' class='btn btn-primary'>
          
				</form>"); 
				}
				?>
			</div>
			
			<? if($mode == "upd") { ?>
			<div class="col-sm-8" align=right>
			<? } else { ?>
			<div class="col-sm-10" align=right>
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
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  


echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_pr_search.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page&catg=$catg&view=qty'>");
exit;
}

}
?>