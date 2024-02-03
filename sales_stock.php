<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "sales";
$smenu = "sales_stock";


if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/sales_stock.php?sorting_key=$sorting_key";
$link_list_action = "$home/sales_stock.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=upd&view=qty";

$link_post = "$home/sales_stock.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_post_catg = "$home/sales_stock.php?mode=post_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_del = "process_stock_del.php?mode=del&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_del_catg = "process_stock_del.php?mode=del_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
            <?=$hsm_name_02_022?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='sales_stock.php'>
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
			</form>
			
			
			<div class='col-sm-2'>$total_record/$all_record [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='sales_stock.php'>
			<input type='hidden' name='keyfield' value='pname'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_invn_stockin_05'> 
			</div>
			</form>
			
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
			<th><?=$txt_invn_stockin_31?></th>
			<th><?=$txt_invn_stockin_613?></th>
			<th><?=$txt_invn_stockin_32s?></th>
			<th><?=$txt_invn_stockin_33?></th>
			<th><?=$mbdtxt_06?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 검색된 재고 합계
$query_tsm1 = "SELECT sum(qty_org), sum(qty_sell), sum(qty_now) FROM shop_product_list_shop WHERE shop_code = '$login_shop'";
$result_tsm1 = mysql_query($query_tsm1);
if (!$result_tsm1) { error("QUERY_ERROR"); exit; }

$prd_tsm_qty_org = @mysql_result($result_tsm1,0,0);
 $prd_tsm_qty_org_K = number_format($prd_tsm_qty_org);
$prd_tsm_qty_sell = @mysql_result($result_tsm1,0,1);
 $prd_tsm_qty_sell_K = number_format($prd_tsm_qty_sell);
$prd_tsm_qty_now = @mysql_result($result_tsm1,0,2);
 $prd_tsm_qty_now_K = number_format($prd_tsm_qty_now);

// Loss
$query_tsm2 = "SELECT sum(stock_loss) FROM shop_product_list_qty 
			WHERE (flag = 'out' AND shop_code = '$login_shop' AND shop_code2 != '$login_shop') 
			OR (flag = 'out' AND shop_code != '$login_shop' AND shop_code2 = '$login_shop')";
$result_tsm2 = mysql_query($query_tsm2);
if (!$result_tsm2) { error("QUERY_ERROR"); exit; }

$prd_tsm_qty_loss = @mysql_result($result_tsm2,0,0);
 $prd_tsm_qty_loss_K = number_format($prd_tsm_qty_loss);

// Final Stock Now
$prd_tsm_qty_now2 = $prd_tsm_qty_now - $prd_tsm_qty_loss;
 $prd_tsm_qty_now2_K = number_format($prd_tsm_qty_now2);

echo ("
<tr>
   <td colspan=3 align=center><b>Total</b></td>
   <td align=right>{$prd_tsm_qty_org_K}</td>
   <td align=right>{$prd_tsm_qty_loss_K}</td>
   <td align=right>{$prd_tsm_qty_sell_K}</td>
   <td align=right>{$prd_tsm_qty_now2_K}</td>
   <td align=center>&nbsp;</td>
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
   
	// Stock in Shop
	$query_sub = "SELECT sum(qty_org), sum(qty_sell), sum(qty_now) FROM shop_product_list_shop WHERE pcode LIKE '$prd_gcode%' AND shop_code = '$login_shop'";
	$result_sub = mysql_query($query_sub);
   
	$sum_qty_org = @mysql_result($result_sub,0,0);
		$sum_qty_org_K = number_format($sum_qty_org);
	$sum_qty_sell = @mysql_result($result_sub,0,1);
		$sum_qty_sell_K = number_format($sum_qty_sell);
	$sum_qty_now = @mysql_result($result_sub,0,2);
		$sum_qty_now_K = number_format($sum_qty_now);
	
	// Loss in Shop
	$query_sub2 = "SELECT sum(stock_loss) FROM shop_product_list_qty 
			WHERE (gcode = '$prd_gcode' AND flag = 'out' AND shop_code = '$login_shop' AND shop_code2 != '$login_shop') 
			OR (gcode = '$prd_gcode' AND flag = 'out' AND shop_code != '$login_shop' AND shop_code2 = '$login_shop')";
	$result_sub2 = mysql_query($query_sub2);
   
	$sum_qty_loss = @mysql_result($result_sub2,0,0);
		$sum_qty_loss_K = number_format($sum_qty_loss);
	
	// Final Stock
	$sum_qty_now2 = $sum_qty_now - $sum_qty_loss;
		$sum_qty_now2_K = number_format($sum_qty_now2);

   
   if(($uid == $prd_uid AND ( $mode == "upd_catg" OR $mode == "post")) OR ($gcode == $prd_gcode AND $mode2 == "dtl")) {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>{$prd_gcode}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_list&uid=$prd_uid&mode2=dtl&gcode=$prd_gcode'>{$prd_name}</a></td>");

  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sum_qty_org_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sum_qty_loss_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sum_qty_sell_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sum_qty_now2_K</font></td>");
  echo("<td bgcolor='$highlight_color'>&nbsp;</td>");


  echo("</tr>");
  
  // 상세보기 [상품 리스트]
  if($mode2 == "dtl" AND $gcode == $prd_gcode) {
    
    $query_HC = "SELECT count(uid) FROM shop_product_list WHERE gcode = '$prd_gcode'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,gate,catg_code,gcode,pcode,pname,
      supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
      product_option4,product_option5,price_orgin FROM shop_product_list WHERE gcode = '$prd_gcode' 
      ORDER BY $sorting_key $sort_now";
    $result_H = mysql_query($query_H);
    if (!$result_H) {   error("QUERY_ERROR");   exit; }
    
    for($h = 0; $h < $total_HC; $h++) {
      $H_prd_uid = mysql_result($result_H,$h,0);
      $H_prd_gate = mysql_result($result_H,$h,1);
      $H_prd_catg = mysql_result($result_H,$h,2);
      $H_prd_gcode = mysql_result($result_H,$h,3);
	  $H_prd_code = mysql_result($result_H,$h,4);
      $H_prd_name = mysql_result($result_H,$h,5);
      $H_supp_code = mysql_result($result_H,$h,6);
      $H_shop_code = mysql_result($result_H,$h,7);
      $H_prd_color = mysql_result($result_H,$h,8);
      $H_prd_size = mysql_result($result_H,$h,9);
      $H_confirm_status = mysql_result($result_H,$h,10);
      $H_p_opt1 = mysql_result($result_H,$h,11);
      $H_p_opt2 = mysql_result($result_H,$h,12);
      $H_p_opt3 = mysql_result($result_H,$h,13);
      $H_p_opt4 = mysql_result($result_H,$h,14);
      $H_p_opt5 = mysql_result($result_H,$h,15);
      $H_prd_qty = mysql_result($result_H,$h,16);
      
		// Stock in Shop
		$query_subx = "SELECT sum(qty_org), sum(qty_sell), sum(qty_now) FROM shop_product_list_shop WHERE pcode = '$H_prd_code' AND shop_code = '$login_shop'";
		$result_subx = mysql_query($query_subx);
   
		$sumx_qty_org = @mysql_result($result_subx,0,0);
			$sumx_qty_org_K = number_format($sumx_qty_org);
		$sumx_qty_sell = @mysql_result($result_subx,0,1);
			$sumx_qty_sell_K = number_format($sumx_qty_sell);
		$sumx_qty_now = @mysql_result($result_subx,0,2);
			$sumx_qty_now_K = number_format($sumx_qty_now);
	
		// Loss in Shop
		$query_subx2 = "SELECT sum(stock_loss) FROM shop_product_list_qty 
			WHERE (pcode = '$H_prd_code' AND flag = 'out' AND shop_code = '$login_shop' AND shop_code2 != '$login_shop') 
			OR (pcode = '$H_prd_code' AND flag = 'out' AND shop_code != '$login_shop' AND shop_code2 = '$login_shop')";
		$result_subx2 = mysql_query($query_subx2);
   
		$sumx_qty_loss = @mysql_result($result_subx2,0,0);
			$sumx_qty_loss_K = number_format($sumx_qty_loss);
	
		// Final Stock
		$sumx_qty_now2 = $sumx_qty_now - $sumx_qty_loss;
			$sumx_qty_now2_K = number_format($sumx_qty_now2);
      
      
      
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
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty 
			WHERE (pcode = '$H_prd_code' AND shop_code = '$login_shop' AND shop_code2 != '$login_shop') 
			OR (pcode = '$H_prd_code' AND shop_code != '$login_shop' AND shop_code2 = '$login_shop')";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
    if($view == "qty" AND $H_prd_uid == $uid) {
      $H_prd_qty_link = "<font color=#006699><i class='fa fa-chevron-down'></i></font> <a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty&mode2=dtl&gcode=$prd_gcode'>$sumx_qty_now2_K</a>";
    } else {
      $H_prd_qty_link = "<font color=#aaaaaa><i class='fa fa-sort-down'></i></font> <a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty&view=qty&mode2=dtl&gcode=$prd_gcode' 
				data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='Show Details'>$sumx_qty_now2_K</a>";
    }
	
	

    echo ("
    <tr>
      <td align=right><i class='fa fa-caret-right'></i></td>
      <td bgcolor='$highlight_color_L'>{$H_prd_code}</td>
      <td bgcolor='$highlight_color_L'><a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty&mode2=dtl&gcode=$prd_gcode'>{$H_prd_name} 
            {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</a></td>
      <td bgcolor='$highlight_color_L' align=right>$sumx_qty_org_K</td>
	  <td bgcolor='$highlight_color_L' align=right>$sumx_qty_loss_K</td>
	  <td bgcolor='$highlight_color_L' align=right>$sumx_qty_sell_K</td>
      <td bgcolor='$highlight_color_L' align=right>{$H_prd_qty_link}</td>
      <td bgcolor='$highlight_color_L'>
	  
		<div class='btn-group'>
			<button data-toggle='dropdown' class='btn btn-default btn-xs dropdown-toggle' type='button'>Go <span class='caret'></span></button>
            <ul role='menu' class='dropdown-menu' style='margin-left: -80px'>");
				
					if($opname_check == "1") {
						echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-check'></i> $txt_invn_stockout_37</a></font></li>");
					} else {
						echo ("<li><a href='$link_list_action&act_mode=check&uid=$H_prd_uid&mode2=dtl&gcode=$prd_gcode'><i class='fa fa-check'></i> $txt_invn_stockin_63</a></li>");
					}
					
					if($opname_add == "1") {
						echo ("<li><a href='#'><font color=#AAAAAA><i class='fa fa-edit'></i> $txt_invn_stockin_65</a></font></li>");
					} else {
						echo ("<li><a href='$link_list_action&act_mode=add&uid=$H_prd_uid&mode2=dtl&gcode=$prd_gcode'><i class='fa fa-edit'></i> $txt_invn_stockin_64</a></li>");
					}
			
			echo ("
            </ul>
		</div>
	  
	  
	  </td>
    </tr>");
	
	
	
		// 재고 입력 (pos_type=2 : 가상재고)
		if($act_mode == "add" AND $uid == $H_prd_uid) {
		
		  echo ("
          <tr>
            <form name='qs_signform1' method='post' action='sales_stock.php'>
            <input type='hidden' name='step_next' value='permit_qty_check'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='page' value='$page'>
			<input type='hidden' name='uid' value='$H_prd_uid'>
            <input type='hidden' name='li_uid' value='$H_prd_uid'>
			<input type='hidden' name='li_catg_code' value='$H_prd_catg'>
            <input type='hidden' name='li_gcode' value='$H_prd_gcode'>
			<input type='hidden' name='li_pcode' value='$H_prd_code'>
			<input type='hidden' name='li_supp_code' value='$H_supp_code'>
			<input type='hidden' name='li_shop_code' value='$H_shop_code'>

            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align=right>$txt_invn_stockin_66</td>
            <td align=right></td>
			<td align=right></td>
			<td align=right><input type='text' class='form-control' name='vstock_sold_now' style='width: 60px; height: 23px; text-align: right; font-size: 1.0em' required></td>
			<td align=right></td>
            <td><input type='submit' class='btn btn-default btn-xs' value='$txt_comm_frm02'></td>
          </tr>
		  </form>");
		  
		}
		
		
	    
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $uid == "$H_prd_uid") {
    
        $query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,stock_check,stock_loss,stock_org,flag,virtual FROM shop_product_list_qty 
					  WHERE (pcode = '$H_prd_code' AND shop_code = '$login_shop' AND shop_code2 != '$login_shop') 
						OR (pcode = '$H_prd_code' AND shop_code != '$login_shop' AND shop_code2 = '$login_shop') ORDER BY date DESC";
        $result_qs2 = mysql_query($query_qs2,$dbconn);
        if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

        for($qs = 0; $qs < $total_qs; $qs++) {
          $qs_uid = mysql_result($result_qs2,$qs,0);
          $qs_stock = mysql_result($result_qs2,$qs,1);
			$qs_stock_K = number_format($qs_stock);
          $qs_date = mysql_result($result_qs2,$qs,2);
          $qs_flag = mysql_result($result_qs2,$qs,3);
          $qs_pay_num = mysql_result($result_qs2,$qs,4);
          $qs_gudang_code = mysql_result($result_qs2,$qs,5);
          $qs_supp_code = mysql_result($result_qs2,$qs,6);
          $qs_shop_code = mysql_result($result_qs2,$qs,7);
          $qs_org_uid = mysql_result($result_qs2,$qs,8);
		  $qs_stock_check = mysql_result($result_qs2,$qs,9);
			$qs_stock_check_K = number_format($qs_stock_check);
		  $qs_stock_loss = mysql_result($result_qs2,$qs,10);
			$qs_stock_loss_K = number_format($qs_stock_loss);
		  $qs_stock_org = mysql_result($result_qs2,$qs,11);
			$qs_stock_org_K = number_format($qs_stock_org);
		  $qs_flag = mysql_result($result_qs2,$qs,12);
		  $qs_virtual = mysql_result($result_qs2,$qs,13);
          
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
			if($qs_flag == "out") { // 입고 <-- 출고(WH)
				$qs_input_K = $qs_stock_K;
				$qs_sold_K = "";
			} else if($qs_flag == "out2") { // 판매
				$qs_input_K = "";
				$qs_sold_K = $qs_stock_K;
			}
          
          
          // 공급자 이름 추출
          $query_qs6 = "SELECT name FROM member_main WHERE code = '$qs_supp_code'";
          $result_qs6 = mysql_query($query_qs6,$dbconn);
          if (!$result_qs6) { error("QUERY_ERROR"); exit; }   
          
          $qs_supp_name = @mysql_result($result_qs6,0,0);
          
          if($qs_virtual == "1") {
            $qs_uid_font_color = "red";
          } else {
            $qs_uid_font_color = "#000";
          }
          
          echo ("
          <tr>
            <td>&nbsp;</td>
            <td>$qs_flag_txt</td>
            <td align=right>
				$qs_gudang_code</a> 
				<a href='#' data-placement='top' data-toggle='tooltip' class='tooltips' data-original-title='$qs_supp_name'>[$qs_supp_code]</a> 
				$qs_date_txt
            </td>
            <td align=right>$qs_input_K</td>
			<td align=right></td>
			<td align=right><font color='$qs_uid_font_color'>{$qs_sold_K}</font></td>
			<td align=right></td>
            <td></td>
          </tr>");
            
        }
    
    
    
      }
    
    }

  } // -- dtl
  
  
  // echo("<tr><td colspan=8 height=2 bgcolor=#FFFFFF></td></tr>");

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
} else if($step_next == "permit_qty_check") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
	
	if($pos_type == "3") { // Associate - Virtual Stock
	
	
		// 상품 qty 하위 테이블 입력 [shop_product_list와 shop_product_list_shop 자료는 반영하지 않음]
		$query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,shop_code,
                catg_code,gcode,pcode,stock,date,virtual) values ('','$li_uid','out2','$login_branch','$li_supp_code','$login_shop',
				'$li_catg_code','$li_gcode','$li_pcode','$vstock_sold_now','$post_dates','1')";
        $result_SH3 = mysql_query($query_SH3);
        if (!$result_SH3) { error("QUERY_ERROR"); exit; }

		

	} else if($pos_type == "2") { // Branch Shop - Real Stock
	
	
	}
  

	echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_stock.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$li_uid&page=$page&view=qty&pos_type=$pos_type&view=qty&mode2=$mode2&gcode=$gcode'>");
	exit;


}

}
?>