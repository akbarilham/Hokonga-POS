<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_stock_in";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_stock_in.php?sorting_key=$sorting_key";
$link_list_action = "$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_post = "$home/inventory_stock_in.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_post_catg = "$home/inventory_stock_in.php?mode=post_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

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
if(!$sorting_key) { $sorting_key = "org_pcode"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pname") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "org_pcode") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "post_date") { $chk4 = "selected"; } else { $chk4 = ""; }


// Begining of Stock
$query_ym1 = "SELECT date FROM final_monthly_stock WHERE stock_end > '0' AND date > '1' ORDER BY date DESC";
$result_ym1 = mysql_query($query_ym1);
	if (!$result_ym1) {   error("QUERY_ERROR");   exit; }
$ym1_date = @mysql_result($result_ym1,0,0);
	$ym1_date1 = substr($ym1_date,0,4);
	$ym1_date2 = substr($ym1_date,4,2);



if(!$page) { $page = 1; }


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
	$total_record_K = number_format($total_record);

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
		<? include "navbar_inventory_sco.inc"; ?>
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_stock_in.php'>
			<div class='col-sm-2'>
			<select name='keyfield' class='form-control'>
			<option value='org_pcode' $chk3>Original Code</option>
			<option value='pcode' $chk1>$txt_invn_stockin_06</option>
            <option value='pname' $chk2>$txt_invn_stockin_05</option>
            <option value='post_date' $chk4>$txt_invn_stockin_18</option>
			</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			</form>
			
			
			<div class='col-sm-2'>$total_record_K [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search' method='post' action='inventory_stock_in.php'>
			<input type='hidden' name='keyfield' value='pname'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_invn_stockin_05'> 
			</div>
			</form>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=org_pcode&keyfield=$keyfield&key=$key' $chk3>Original Code</option>
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=pname&keyfield=$keyfield&key=$key' $chk2>$txt_invn_stockin_05</option>
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key' $chk4>$txt_invn_stockin_18</option>
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
			<th><?=$txt_comm_frm12?></th>
			<th><?=$txt_comm_frm13?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// Stock of Begining
$query_tsm1 = "SELECT sum(stock_end) FROM final_monthly_stock WHERE date = '$ym1_date'";
$result_tsm1 = mysql_query($query_tsm1);
	if (!$result_tsm1) { error("QUERY_ERROR"); exit; }
$prd_tsm1_qty = @mysql_result($result_tsm1,0,0);

// Stock of this Month
$query_tsm2 = "SELECT sum(stock), sum(stock*price_orgin) FROM shop_product_list_qty WHERE flag = 'in'";
$result_tsm2 = mysql_query($query_tsm2);
	if (!$result_tsm2) { error("QUERY_ERROR"); exit; }
$prd_tsm2_qty = @mysql_result($result_tsm2,0,0);
$prd_tsm2_price = @mysql_result($result_tsm2,0,1);

if($prd_tsm1_qty > 0) {
	$prd_tsm_qty = $prd_tsm1_qty - $prd_tsm2_qty;
} else {
	$prd_tsm_qty = $prd_tsm2_qty;
}
$prd_tsm_qty_K = number_format($prd_tsm_qty);

echo ("
<tr>
   <td colspan=4 align=center><b>Total</b></td>
   <td align=right>{$prd_tsm_qty_K}</td>
   <td align=right>{$prd_tsm_price_K}</td>
   <td align=center>&nbsp;</td>
   <td align=center>&nbsp;</td>
</tr>
");


$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,tprice_orgin,tprice_sale,tprice_margin,tstock_org,org_pcode
      FROM shop_product_catg ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,tprice_orgin,tprice_sale,tprice_margin,tstock_org,org_pcode
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
   $prd_org_pcode = mysql_result($result,$i,9);
   
   
   // Stock of Begining
   $query_sub1 = "SELECT sum(stock_end) FROM final_monthly_stock WHERE pcode LIKE '$prd_gcode%' AND date = '$ym1_date'";
   $result_sub1 = mysql_query($query_sub1);
		if (!$result_sub1) { error("QUERY_ERROR"); exit; }
   $sub1_qty = @mysql_result($result_sub1,0,0);
   
   // Stock of this Month
   $query_sub2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode LIKE '$prd_gcode%' AND flag = 'in'";
   $result_sub2 = mysql_query($query_sub2);
		if (!$result_sub2) { error("QUERY_ERROR"); exit; }
   $sub2_qty = @mysql_result($result_sub2,0,0);
   
	if($sub1_qty > 0) {
		$sub_qty = $sub1_qty - $sub2_qty;
	} else {
	   $sub_qty = $sub2_qty;
	}
	$sub_qty_K = number_format($sub_qty);
   
   if(($uid == $prd_uid AND ( $mode == "upd" OR $mode == "upd_catg" OR $mode == "post" )) OR ($smode == "dtl" AND $dtl_gcode == $prd_gcode)) {
    $highlight_color = "#FAFAB4";
   } else {
    $highlight_color = "#FFFFFF";
   }

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>{$prd_gcode}</td>");

  echo("
        <td bgcolor='$highlight_color'><a href='$link_list_action&smode=dtl&dtl_gcode=$prd_gcode'>[$prd_org_pcode] {$prd_name}</a></td>
        <td bgcolor='$highlight_color' align=right><a href='$link_post&uid=$prd_uid'><font color='navy'>$txt_invn_stockin_20</font></a> <i class='fa fa-chevron-down'></i></a></td>
      ");

  // 상품군별 총 매입가 [산출 불가능]
  
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>$sub_qty_K</font></td>");
  echo("<td bgcolor='$highlight_color' align=right><font color='navy'>&nbsp;</font></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_list_action&mode=upd_catg&uid=$prd_uid'>$txt_comm_frm12</a></td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_del_catg&uid=$prd_uid'>$txt_comm_frm13</a></td>");


  echo("</tr>");
  
  // 상세보기 [상품 리스트]
  if($smode == "dtl" AND $dtl_gcode == $prd_gcode) {
    
    $query_HC = "SELECT count(uid) FROM shop_product_list WHERE gcode = '$prd_gcode'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,gate,catg_code,pcode,pname,
      supp_code,shop_code,product_color,product_size,confirm_status,product_option1,product_option2,product_option3,
      product_option4,product_option5,stock_org,org_pcode FROM shop_product_list WHERE gcode = '$prd_gcode' 
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
	  $H_org_pcode = mysql_result($result_H,$h,16);
      
      // 총 매입수량과 액수
	  $query_sux1 = "SELECT sum(stock_end) FROM final_monthly_stock WHERE pcode = '$H_prd_code' AND date = '$ym1_date'";
      $result_sux1 = mysql_query($query_sux1);
		if (!$result_sux1) { error("QUERY_ERROR"); exit; }
      $sux1_qty_org = @mysql_result($result_sux1,0,0);
	  
      $query_sux2 = "SELECT price_orgin, sum(stock) FROM shop_product_list_qty WHERE org_uid = '$H_prd_uid' AND flag = 'in'";
      $result_sux2 = mysql_query($query_sux2);
		if (!$result_sux2) { error("QUERY_ERROR"); exit; }
      $sux2_price_org = @mysql_result($result_sux2,0,0);
        $sux2_price_org_K = number_format($sumx_price_org);
      $sux2_qty_org = @mysql_result($result_sux2,0,1);
      
      $sux2_tprice_org = $sux2_price_org * $sux2_qty_org;
        $sux2_tprice_org_K = number_format($sux2_tprice_org);
      
		if($sux1_qty_org > 0) {
			$sux_qty_org = $sux1_qty_org - $sux2_qty_org;
		} else {
			$sux_qty_org = $sux2_qty_org;
		}
		$sux_qty_org_K = number_format($sux_qty_org);
      
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
      
      if($H_prd_uid == $dtl_uid AND ( $smode == "dtl" OR $mode == "del" )) {
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
      $H_prd_qty_link = "<i class='fa fa-chevron-down'></i> <a href='$link_list_action&mode=$mode&smode=dtl&dtl_gcode=$prd_gcode&dtl_uid=$H_prd_uid&view=qty'>$sux_qty_org_K</a>";
    } else {
      $H_prd_qty_link = "<a href='$link_list_action&mode=$mode&smode=dtl&dtl_gcode=$prd_gcode&dtl_uid=$H_prd_uid&view=qty'>$sux_qty_org_K</a>";
    }
	
	if($H_org_pcode != "") {
		$H_org_pcode_txt = "[$H_org_pcode] &nbsp; ";
	} else {
		$H_org_pcode_txt = "";
	}

	
	
	
    echo ("
    <tr>
      <td align=right><i class='fa fa-caret-right'></i></td>
      <td bgcolor='$highlight_color_L'>{$H_prd_code}</td>
      <td bgcolor='$highlight_color_L'><a href='$link_list_action&mode=$mode&smode=dtl&dtl_gcode=$prd_gcode&dtl_uid=$H_prd_uid' 
            class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' 
			data-original-title='{$H_org_pcode_txt}{$H_prd_name} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}'>
			{$H_org_pcode_txt}{$H_prd_name} {$H_p_opt1_txt}{$H_p_opt2_txt}</a></td>
      <td bgcolor='$highlight_color_L' align=right>{$sumx_price_org_K}</td>
      <td bgcolor='$highlight_color_L' align=right>{$H_prd_qty_link}</td>
      <td bgcolor='$highlight_color_L' align=right>{$sumx_tprice_org_K}</td>
      
      <td bgcolor='$highlight_color_L'><a href='$link_list_action&mode=upd&smode=dtl&dtl_gcode=$prd_gcode&dtl_uid=$H_prd_uid'>$txt_comm_frm12</a></td>");
      
      if($H_confirm_status == "2") { // 입고 마감된 상품 삭제 불가능
        echo ("<td bgcolor='$highlight_color_L'><font color=#AAAAAA>$txt_comm_frm13</font></td>");
      } else {
        echo ("<td bgcolor='$highlight_color_L'><a href='$link_list_action&mode=del&smode=dtl&dtl_gcode=$prd_gcode&dtl_uid=$H_prd_uid'><font color=red>$txt_comm_frm13</font></a></td>");
      }
      
      echo("
    </tr>");
    
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $dtl_uid == "$H_prd_uid") {
		 
		$query_qs1 = "SELECT sum(stock_end) FROM final_monthly_stock WHERE pcode = '$H_prd_code' AND date = '$ym1_date' ORDER BY uid DESC";
        $result_qs1 = mysql_query($query_qs1,$dbconn);
        if (!$result_qs1) { error("QUERY_ERROR"); exit; }   

        $qs1_stock = @mysql_result($result_qs1,0,0);
			$qs1_stock_K = number_format($qs1_stock);
			
			if($qs1_stock > 0) {
			echo ("
			<tr>
			<td bgcolor='#FFFFFF'>&nbsp;</td>
            <td bgcolor='#FFFFFF'>$txt_invn_stockin_71</td>
            <td bgcolor='#FFFFFF' align=right></td>
            <td bgcolor='#FFFFFF' align=right>{$qs1_price_orgin_K}</td>
            <td bgcolor='#FFFFFF' align=right><font color=blue>+</font>&nbsp;<input type=text name='qs_stock' value='$qs1_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>
            <td bgcolor='#FFFFFF' align=right>{$qs1_tprice_orgin_K}</td>
			<td bgcolor='#FFFFFF'>&nbsp;</td>
			<td bgcolor='#FFFFFF'>&nbsp;</td>
            </tr>");
			}
			
			
    
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
          $query_qs6 = "SELECT supp_name FROM client_supplier WHERE supp_code = '$qs_supp_code'";
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
            <form name='qs_signform' method='post' action='inventory_stock_in.php'>
            <input type='hidden' name='step_next' value='permit_qty'>
            <input type='hidden' name='sorting_table' value='$sorting_table'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='page' value='$page'>
            <input type='hidden' name='catg' value='$catg'>
            <input type='hidden' name='new_uid' value='$H_prd_uid'>
            <input type='hidden' name='qs_uid' value='$qs_uid'>
            <input type='hidden' name='qs_flag' value='$qs_flag'>
            <input type='hidden' name='qs_pay_num' value='$qs_pay_num'>
            <input type='hidden' name='qs_cart_uid' value='$qs_cart_uid'>
            <input type='hidden' name='qs_pay_uid' value='$qs_pay_uid'>
            <input type='hidden' name='qs_pcode' value='$H_prd_code'>
            <input type='hidden' name='qs_price_orgin' value='$qs_price_orgin'>
            
            <td bgcolor='#FFFFFF'>&nbsp;</td>
            <td bgcolor='#FFFFFF'>$qs_flag_txt</td>
            <td bgcolor='#FFFFFF' align=right>");
              if($qs_flag == "out") { 
                echo ("<font color='$qs_uid_font_color'>$qs_shop_code</font> <a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' 
					data-original-title='[$qs_stock] $qs_pay_amount_K'>[$qs_pay_num]</a>");
              } else {
                echo ("<a href='$link_list_action&mode=upd&uid=$H_prd_uid&view=qty&qty_uid=$qs_uid'><font color='$qs_uid_font_color'>$qs_gudang_code</font></a> 
					<a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' 
					data-original-title='$qs_supp_name'>[$qs_supp_code]</a>&nbsp;");
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
            <td><input type=submit value='+/-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>
            </form>
            
            <form name='qs_signform' method='post' action='inventory_stock_in.php'>
            <input type='hidden' name='step_next' value='permit_qty_del'>
            <input type='hidden' name='sorting_table' value='$sorting_table'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='page' value='$page'>
            <input type='hidden' name='catg' value='$catg'>
            <input type='hidden' name='new_uid' value='$H_prd_uid'>
            <input type='hidden' name='qs_uid' value='$qs_uid'>
            <input type='hidden' name='qs_flag' value='$qs_flag'>
            <input type='hidden' name='qs_pay_num' value='$qs_pay_num'>
            <input type='hidden' name='qs_cart_uid' value='$qs_cart_uid'>
            <input type='hidden' name='qs_pay_uid' value='$qs_pay_uid'>
            <input type='hidden' name='qs_pcode' value='$H_prd_code'>
            <input type='hidden' name='qs_stock' value='$qs_stock'>
            <td><input type=submit value='-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>
            </form>
          </tr>");
            
        }
    
    
    
      }
    
    }
	
  } // -- 상세보기 (끝)
  
  
  // echo("<tr><td colspan=8 height=2 bgcolor=#FFFFFF></td></tr>");

   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
		
				<a href="<?=$link_post_catg?>"><input type="button" value="<?=$txt_invn_stockin_19?>" class="btn btn-primary"></a>
			
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
		
	
		
		
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action='inventory_stock_in.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		<?
		if($now_group_admin == "1" OR $dtl_uid) {
			$catg_disableA = "";
		} else {
			$catg_disableA = "disabled";
		}
      
		if($now_group_admin == "1") {
			$catg_disableB = "";
		} else {
			$catg_disableB = "disabled";
		}

      
          if($mode == "del" AND $dtl_uid) { // 상품 삭제

          $query_upd = "SELECT uid,gudang_code,supp_code,branch_code,gate,catg_code,gcode,pcode,pname,
                        currency,price_orgin,price_market,price_sale,stock_org,catg_uid,unit FROM shop_product_list WHERE uid = '$dtl_uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_supp_code = $row_upd->supp_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_gate = $row_upd->gate;
          $upd_catg_code = $row_upd->catg_code;
          $upd_gcode = $row_upd->gcode;
		  $upd_pcode = $row_upd->pcode;
          $upd_pname = $row_upd->pname;
		  $upd_currency = $row_upd->currency;
          $upd_price_orgin = $row_upd->price_orgin;
          $upd_price_market = $row_upd->price_market;
          $upd_price_sale = $row_upd->price_sale;
          $upd_stock_org = $row_upd->stock_org;
          $upd_catg_uid = $row_upd->catg_uid;
		  $upd_unit = $row_upd->unit;

          // 해당 상품군 코드
          $query_del2 = "SELECT pcode FROM shop_product_catg WHERE uid = '$upd_catg_uid'";
          $result_del2 = mysql_query($query_del2);
          if(!$result_del2) { error("QUERY_ERROR"); exit; }
          $row_del2 = mysql_fetch_object($result_del2);

          $upd_group_code = $row_del2->pcode;

		echo ("
		<input type=hidden name='add_mode' value='LIST_DEL'>
		<input type=hidden name='new_branch_code' value='$upd_branch_code'>
		<input type=hidden name='new_uid' value='$upd_uid'>
		<input type=hidden name='new_catg_uid' value='$upd_catg_uid'>
		<input type=hidden name='new_client' value='$upd_gate'>
		<input type=hidden name='m_cat_code' value='$upd_catg_code'>
		<input type=hidden name='new_gcode' value='$upd_gcode'>
		<input type=hidden name='new_prd_code' value='$upd_pcode'>
		<input type=hidden name='new_group_code' value='$upd_group_code'>");
		?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Delete Product
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_06?></label>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableB?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="new_gudang_code" value="<?=$upd_gudang_code?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_supp_code" required>
											<?
											echo ("<option value=\"\">:: $txt_sys_supplier_13</option>");
              
											$query_P1 = "SELECT count(uid) FROM client_supplier";
											$result_P1 = mysql_query($query_P1,$dbconn);
												if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
											$total_P1ss = @mysql_result($result_P1,0,0);
      
											$query_P2 = "SELECT uid,supp_code,supp_name,userlevel FROM client_supplier ORDER BY supp_name ASC"; 
											$result_P2 = mysql_query($query_P2,$dbconn);
												if (!$result_P2) { error("QUERY_ERROR"); exit; }

											for($p = 0; $p < $total_P1ss; $p++) {
												$supp_uid = mysql_result($result_P2,$p,0);
												$supp_code = mysql_result($result_P2,$p,1);
												$supp_name = mysql_result($result_P2,$p,2);
												$supp_userlevel = mysql_result($result_P2,$p,3);
                
												if($supp_code == $upd_supp_code) {
													$supp_slct = "selected";
													$supp_dis = "";
												} else {
													$supp_slct = "";
													$supp_dis = "disabled";
												}
              
												echo("<option $supp_dis value='$supp_code' $supp_slct>[$supp_code] $supp_name</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_05?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_prd_name" value="<?=$upd_pname?>" type="text" required />
										</div>
                                    </div>
									
									<?
									// Prices
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
										<div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_orgin' value='$upd_price_orgin' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_11</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_market' value='$upd_price_market' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_12</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_sale' value='$upd_price_sale' style='text-align: right'>
										</div>
                                    </div>
									
									<!--- Stock Change & Addional Return ----->
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_stock_org' value='$upd_stock_org' style='text-align: right'>
										</div>");
										
										if($upd_unit != "") {
											echo ("
											<div class='col-sm-2'>
												<input readonly class='form-control' name='org_unit' value='$upd_unit'>
											</div>");
										}
										
										echo ("
                                    </div>");
									?>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input <?=$catg_disableA?> class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_27?>">
                                        </div>
                                    </div>
		
		</div>
		</section>
		</div>
		</div>
		
		<?
		} else if($smode == "dtl" AND $dtl_uid) { // 상품 정보 변경

          $query_upd = "SELECT uid,catg_uid,gudang_code,supp_code,branch_code,gate,shop_code,catg_code,gcode,pcode,org_pcode,pname,
                        currency,price_orgin,price_market,price_sale,stock_org,stock_now,product_color,product_size,
                        product_option1,product_option2,product_option3,product_option4,product_option5,
                        confirm_status,post_date,upd_date,org_barcode,unit FROM shop_product_list WHERE uid = '$dtl_uid'";
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
          $upd_gcode = $row_upd->gcode;
		  $upd_pcode = $row_upd->pcode;
          $upd_org_pcode = $row_upd->org_pcode;
          $upd_pname = $row_upd->pname;
		  $upd_currency = $row_upd->currency;
          $upd_price_orgin = $row_upd->price_orgin;
          $upd_price_market = $row_upd->price_market;
          $upd_price_sale = $row_upd->price_sale;
          $upd_stock_org = $row_upd->stock_org;
          $upd_stock_now = $row_upd->stock_now;
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
		  $upd_org_barcode = $row_upd->org_barcode;
		  $upd_unit = $row_upd->unit;
          
          
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


		echo ("
		<input type=hidden name='add_mode' value='LIST_CHG'>
		<input type=hidden name='new_branch_code' value='$upd_branch_code'>
		<input type=hidden name='new_uid' value='$upd_uid'>
		<input type=hidden name='new_catg_uid' value='$upd_catg_uid'>
		<input type=hidden name='new_client' value='$upd_gate'>
		<input type=hidden name='m_cat_code' value='$upd_catg_code'>
		<input type=hidden name='old_gcode' value='$upd_gcode'>
		<input type=hidden name='new_prd_code' value='$upd_pcode'>
		<input type=hidden name='new_group_code' value='$upd_group_code'>
		<input type=hidden name='new_unit' value='$upd_unit'>
		<input type=hidden name='old_supp_code' value='$upd_supp_code'>
		<input type=hidden name='old_pname' value='$upd_pname'>
		<input type=hidden name='old_p_option1' value='$upd_p_option1'>
		<input type=hidden name='old_p_option2' value='$upd_p_option2'>
		<input type=hidden name='old_p_option3' value='$upd_p_option3'>
		<input type=hidden name='old_p_option4' value='$upd_p_option4'>
		<input type=hidden name='old_p_option5' value='$upd_p_option5'>
		<input type=hidden name='old_price_orgin' value='$upd_price_orgin'>
		<input type=hidden name='old_stock_org' value='$upd_stock_org'>
		<input type=hidden name='old_stock_now' value='$upd_stock_now'>");
		?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Product
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_06?></label>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableB?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
										<div class="col-sm-9">
											<img src="include/_barcode/html/image.php?code=code39&o=1&dpi=72&t=30&r=2&rot=0&text=<?=$upd_pcode?>&f1=Arial.ttf&f2=8&a1=&a2=&a3=" border=0>
										</div>
                                    </div>
										
									
									<? // if($prv_entry == "1") { // Provider Unique Code ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_30?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_pcode" value="<?=$upd_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-3" align=right>Original Barcode</div>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_barcode" value="<?=$upd_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<? // } ?>
									
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
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_supp_code" required>
											<?
											echo ("<option value=\"\">:: $txt_sys_supplier_13</option>");
              
											$query_P1 = "SELECT count(uid) FROM client_supplier";
											$result_P1 = mysql_query($query_P1,$dbconn);
												if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
											$total_P1ss = @mysql_result($result_P1,0,0);
      
											$query_P2 = "SELECT uid,supp_code,supp_name,userlevel FROM client_supplier ORDER BY supp_name ASC"; 
											$result_P2 = mysql_query($query_P2,$dbconn);
												if (!$result_P2) { error("QUERY_ERROR"); exit; }

											for($p = 0; $p < $total_P1ss; $p++) {
												$supp_uid = mysql_result($result_P2,$p,0);
												$supp_code = mysql_result($result_P2,$p,1);
												$supp_name = mysql_result($result_P2,$p,2);
												$supp_userlevel = mysql_result($result_P2,$p,3);
                
												if($supp_code == $upd_supp_code) {
													$supp_slct = "selected";
												} else {
													$supp_slct = "";
												}
              
												echo("<option value='$supp_code' $supp_slct>$supp_name</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_05?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_prd_name" value="<?=$upd_pname?>" type="text" required />
										</div>
                                    </div>
									
									<?
									// Product Options
          
									if($p_option1 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name1</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option1'>");
											$sp_opt1 = explode(",", $p_option1);
											for($o1=0; $o1<count($sp_opt1); $o1++) {
												if($upd_p_option1 == $sp_opt1[$o1]) {
													$slct_opt1 = "selected";
												} else {
													$slct_opt1 = "";
												}
												echo ("<option value='$sp_opt1[$o1]' $slct_opt1>$sp_opt1[$o1]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option2 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name2</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option2'>");
											$sp_opt2 = explode(",", $p_option2);
											for($o2=0; $o2<count($sp_opt2); $o2++) {
												if($upd_p_option2 == $sp_opt2[$o2]) {
													$slct_opt2 = "selected";
												} else {
													$slct_opt2 = "";
												}
												echo ("<option value='$sp_opt2[$o2]' $slct_opt2>$sp_opt2[$o2]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option3 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name3</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option3'>");
											$sp_opt3 = explode(",", $p_option3);
											for($o3=0; $o3<count($sp_opt3); $o3++) {
												if($upd_p_option3 == $sp_opt3[$o3]) {
													$slct_opt3 = "selected";
												} else {
													$slct_opt3 = "";
												}
												echo ("<option value='$sp_opt3[$o3]' $slct_opt3>$sp_opt3[$o3]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option4 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name4</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option4'>");
											$sp_opt4 = explode(",", $p_option4);
											for($o4=0; $o4<count($sp_opt4); $o4++) {
												if($upd_p_option4 == $sp_opt4[$o4]) {
													$slct_opt4 = "selected";
												} else {
													$slct_opt4 = "";
												}
												echo ("<option value='$sp_opt4[$o4]' $slct_opt4>$sp_opt4[$o4]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option5 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name5</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option5'>");
											$sp_opt5 = explode(",", $p_option5);
											for($o5=0; $o5<count($sp_opt5); $o5++) {
												if($upd_p_option5 == $sp_opt5[$o5]) {
													$slct_opt5 = "selected";
												} else {
													$slct_opt5 = "";
												}
												echo ("<option value='$sp_opt5[$o5]' $slct_opt5>$sp_opt5[$o5]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									
									// Inventory Control & Original Price
									
									if($upd_confirm_status == "2") { // 재고 마감시 입고원가 수정 불가능
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='dis_price_orgin' value='$upd_price_orgin' style='text-align: right'>
										</div>
                                    </div>
									<input type=hidden name='new_price_orgin' value='$upd_price_orgin'>");
									
									} else {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_orgin' value='$upd_price_orgin' style='text-align: right'>
										</div>
                                    </div>");
									
									}
									
									
									// Prices
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_11</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_market' value='$upd_price_market' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_12</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$upd_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_sale' value='$upd_price_sale' style='text-align: right'>
										</div>
                                    </div>
									
									<!--- Stock Change & Addional Return ----->
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_stock_org' value='$upd_stock_org' style='text-align: right'>
										</div>");
										
										if($upd_unit != "") {
											echo ("
											<div class='col-sm-2'>
												<input readonly class='form-control' name='org_unit' value='$upd_unit'>
											</div>");
										}
										
										echo ("
										<div class='col-sm-3'>
											<input type=radio name='add_stock_chk' value='0' checked> $txt_invn_stockout_14
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockout_19</label>
                                        <div class='col-sm-2'>
											<input type=radio name='add_stock_chk' value='1'> <font color=blue>$txt_invn_stockout_22</font> : 
										</div>
										<div class='col-sm-2'>
											<input class='form-control' name='chg_stock_add' value='10' style='text-align: right'>
										</div>");
										
										if($upd_unit != "") {
											echo ("
											<div class='col-sm-2'>
												<input readonly class='form-control' name='org_unit' value='$upd_unit'>
											</div>");
										}
										
										echo ("
                                    </div>");
									
									
									
									// Returns
									
									// Current Stock
									$result_chk1 = mysql_query("SELECT stock FROM shop_product_list_qty 
													WHERE pcode = '$upd_pcode' AND gudang_code = '$upd_gudang_code' AND uid = '$qty_uid'",$dbconn);
									if (!$result_chk1) { error("QUERY_ERROR"); exit; }
									$pool_qty_org1 = @mysql_result($result_chk1,0,0);
          
									if($pool_qty_org1 == "" OR $pool_qty_org1 == 0) {
										$pool_qty_org1 = "0";
									}
          
									if($qty_uid) {
									echo ("
									<input type=hidden name='qty_uid' value='$qty_uid'>
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>&nbsp;</label>
                                        <div class='col-sm-2'>
											<input type=radio name='add_stock_chk' value='2'> <font color=red>$txt_invn_stockout_03</font> : 
										</div>
										<div class='col-sm-2'>
											<select class='form-control' name='new_return_qty'>");
											if(!$pool_qty_org1) {
												echo ("<option value='0'>0</option>");
											} else {
												for($q = 1; $q <= $pool_qty_org1; $q++) {
													echo("<option value='$q' $qty_slct>$q</option>");
												}
											}
											echo ("
											</select> / $pool_qty_org1
										</div>
                                    </div>");
									}
									
									
									// Dates
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_18</label>
                                        <div class='col-sm-3'>
											<input disabled class='form-control' name='dis_post_dates' value='$upd_post_dates'>
										</div>
                                    </div>");
									
									if($upd_return_date != "0") {
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockout_24</label>
                                        <div class='col-sm-3'>
											<input disabled class='form-control' name='dis_return_dates' value='$upd_return_dates'>
										</div>
                                    </div>");
									}
									?>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_23?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
		
		</div>
		</section>
		</div>
		</div>
		
		
		<?
		} else if($mode == "upd_catg" AND $uid) { // 품목 정보 변경 [상품군 카테고리 변경]

          $query_updG = "SELECT uid,branch_code,gate,catg_code,pcode,pname,p_color,p_size,
                        p_opt_name1,p_opt_name2,p_opt_name3,p_opt_name4,p_opt_name5,
                        p_option1,p_option2,p_option3,p_option4,p_option5,org_pcode,org_barcode,unit FROM shop_product_catg WHERE uid = '$uid'";
          $result_updG = mysql_query($query_updG);
          if(!$result_updG) { error("QUERY_ERROR"); exit; }
          $row_updG = mysql_fetch_object($result_updG);

          $updG_uid = $row_updG->uid;
          $updG_branch_code = $row_updG->branch_code;
          $updG_gate = $row_updG->gate;
          $updG_catg_code = $row_updG->catg_code;
          $updG_pcode = $row_updG->pcode;
          $updG_pname = $row_updG->pname;
          $updG_p_color = $row_updG->p_color;
          $updG_p_size = $row_updG->p_size;
          $p_opt_name1 = $row_updG->p_opt_name1;
          $p_opt_name2 = $row_updG->p_opt_name2;
          $p_opt_name3 = $row_updG->p_opt_name3;
          $p_opt_name4 = $row_updG->p_opt_name4;
          $p_opt_name5 = $row_updG->p_opt_name5;
          $p_option1 = $row_updG->p_option1;
          $p_option2 = $row_updG->p_option2;
          $p_option3 = $row_updG->p_option3;
          $p_option4 = $row_updG->p_option4;
          $p_option5 = $row_updG->p_option5;
		  $updG_org_pcode = $row_updG->org_pcode;
		  $updG_org_barcode = $row_updG->org_barcode;
		  $updG_unit = $row_updG->unit;

		echo ("
		<input type=hidden name='add_mode' value='CATG_UPD'>
		<input type=hidden name='new_catg_uid' value='$updG_uid'>
		<input type=hidden name='new_chg_gcode' value='$updG_pcode'>");
		?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Item Category
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_061?></label>
										<div class="col-sm-2">
											<input class="form-control" name="new_prd_code" value="<?=$updG_pcode?>" type="text" required />
										</div>
										<div class="col-sm-3" align=right><?=$txt_invn_stockin_04?></div>
										<div class="col-sm-2">
											<input class="form-control" name="s_cat_code" value="<?=$updG_catg_code?>" type="text" required/>
										</div>
										<div class="col-sm-2">
											<input type=checkbox name='chg_mcode' value='1'> 
											<a href="javascript:Popup_Win('productcatfind.php?lang=<?=$lang?>&gate=<?=$key?>&code=catg')"><font color=red>Change Category</font></a>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_30?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_pcode" value="<?=$updG_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-3" align=right>Original Barcode</div>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_barcode" value="<?=$updG_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_051?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_prd_name" value="<?=$updG_pname?>" type="text" required />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_44?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_unit" value="<?=$updG_unit?>" type="text" />
										</div>
                                    </div>
									
									<?
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
										
										if($u == 0) {
											$unit_title = $txt_invn_stockin_44p;
										} else {
											$unit_title = "";
										}
										
										
										$query_unt = "SELECT uid,unit_qty FROM shop_product_catg_unit WHERE catg_uid = '$unit_uid' AND gcode = '$updG_pcode'"; 
										$result_unt = mysql_query($query_unt,$dbconn);
											if (!$result_unt) { error("QUERY_ERROR"); exit; }
										$unit2_uid = @mysql_result($result_unt,0,0);
										$unit2_qty = @mysql_result($result_unt,0,1);
										
              
									echo("
									<input type='hidden' name='check_$unit_uid' value='$unit_uid'>
									<input type='hidden' name='check2_$unit_uid' value='$unit2_uid'>
									
									<div class='form-group'>
										<label class='control-label col-sm-3'>$unit_title</label>
										<div class='col-sm-3'>
											<input class='form-control' name='name_$unit_uid' value='$unit_name' type='text'>
										</div>
											
										<div class='col-sm-3'>
											<input class='form-control' name='qty2_$unit_uid' value='$unit2_qty' type='text' style='text-align: right' placeholder='$txt_invn_stockin_38'>
										</div>
									</div>");
									}
									?>
									
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name1" value="<?=$p_opt_name1?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option1" value="<?=$p_option1?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name2" value="<?=$p_opt_name2?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option2" value="<?=$p_option2?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name3" value="<?=$p_opt_name3?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option3" value="<?=$p_option3?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name4" value="<?=$p_opt_name4?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option4" value="<?=$p_option4?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name5" value="<?=$p_opt_name5?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option5" value="<?=$p_option5?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_24?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
		
		</div>
		</section>
		</div>
		</div>
		
		
		<?
		} else if($mode == "post" AND $uid) { // 상품 추가 !!!!!!!!!!!!!!!!!!!!!!!!!!!!

          $query_uid = "SELECT uid,branch_code,gate,catg_code,pcode,pname,currency,p_opt_name1,p_opt_name2,p_opt_name3,
                        p_opt_name4,p_opt_name5,p_option1,p_option2,p_option3,p_option4,p_option5,org_pcode,org_barcode,unit FROM shop_product_catg 
                        WHERE uid = '$uid'";
          $result_uid = mysql_query($query_uid);
          if(!$result_uid) { error("QUERY_ERROR"); exit; }
          $row_uid = mysql_fetch_object($result_uid);

          $add_uid = $row_uid->uid;
          $add_branch_code = $row_uid->branch_code;
          $add_gate = $row_uid->gate;
          $add_catg_code = $row_uid->catg_code;
          $add_gcode = $row_uid->gcode;
          $add_pcode = $row_uid->pcode;
          $add_pname = $row_uid->pname;
		  $add_currency = $row_uid->currency;
          $add_p_color = $row_uid->p_color;
          $p_opt_name1 = $row_uid->p_opt_name1;
          $p_opt_name2 = $row_uid->p_opt_name2;
          $p_opt_name3 = $row_uid->p_opt_name3;
          $p_opt_name4 = $row_uid->p_opt_name4;
          $p_opt_name5 = $row_uid->p_opt_name5;
          $p_option1 = $row_uid->p_option1;
          $p_option2 = $row_uid->p_option2;
          $p_option3 = $row_uid->p_option3;
          $p_option4 = $row_uid->p_option4;
          $p_option5 = $row_uid->p_option5;
		  $add_org_pcode = $row_uid->org_pcode;
		  $add_org_barcode = $row_uid->org_barcode;
		  $add_unit = $row_uid->unit;
      
		echo ("
		<input type=hidden name='add_mode' value='LIST'>
		<input type=hidden name='new_branch_code' value='$add_branch_code'>
		<input type=hidden name='new_uid' value='$add_uid'>
		<input type=hidden name='new_client' value='$add_gate'>
		<input type=hidden name='new_gcode' value='$add_gcode'>
		<input type=hidden name='m_cat_code' value='$add_catg_code'>
		<input type=hidden name='new_prd_code' value='$add_pcode'>
		<input type=hidden name='new_unit' value='$add_unit'>");
		?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Add Product
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_06?></label>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$add_catg_code?>" type="text" required />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableB?> class="form-control" name="dis_new_prd_code" value="<?=$add_pcode?>" type="text" required />
										</div>
                                    </div>
									
									<? // if($prv_entry == "1") { // Provider Unique Code ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_30?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_pcode" value="<?=$add_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-3" align=right>Original Barcode</div>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_barcode" value="<?=$add_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<? // } ?>
									
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
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_supp_code" required>
											<?
											echo ("<option value=\"\">:: $txt_sys_supplier_13</option>");
              
											$query_P1 = "SELECT count(uid) FROM client_supplier";
											$result_P1 = mysql_query($query_P1,$dbconn);
												if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
											$total_P1ss = @mysql_result($result_P1,0,0);
      
											$query_P2 = "SELECT uid,supp_code,supp_name,userlevel FROM client_supplier ORDER BY supp_name ASC"; 
											$result_P2 = mysql_query($query_P2,$dbconn);
												if (!$result_P2) { error("QUERY_ERROR"); exit; }

											for($p = 0; $p < $total_P1ss; $p++) {
												$supp_uid = mysql_result($result_P2,$p,0);
												$supp_code = mysql_result($result_P2,$p,1);
												$supp_name = mysql_result($result_P2,$p,2);
												$supp_userlevel = mysql_result($result_P2,$p,3);
                
												echo("<option value='$supp_code'>[$supp_code] $supp_name</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_05?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_prd_name" value="<?=$add_pname?>" type="text" required />
										</div>
                                    </div>
									
									<?
									// Product Options
          
									if($p_option1 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name1</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option1'>");
											$sp_opt1 = explode(",", $p_option1);
											for($o1=0; $o1<count($sp_opt1); $o1++) {
												if($upd_p_option1 == $sp_opt1[$o1]) {
													$slct_opt1 = "selected";
												} else {
													$slct_opt1 = "";
												}
												echo ("<option value='$sp_opt1[$o1]' $slct_opt1>$sp_opt1[$o1]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option2 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name2</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option2'>");
											$sp_opt2 = explode(",", $p_option2);
											for($o2=0; $o2<count($sp_opt2); $o2++) {
												if($upd_p_option2 == $sp_opt2[$o2]) {
													$slct_opt2 = "selected";
												} else {
													$slct_opt2 = "";
												}
												echo ("<option value='$sp_opt2[$o2]' $slct_opt2>$sp_opt2[$o2]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option3 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name3</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option3'>");
											$sp_opt3 = explode(",", $p_option3);
											for($o3=0; $o3<count($sp_opt3); $o3++) {
												if($upd_p_option3 == $sp_opt3[$o3]) {
													$slct_opt3 = "selected";
												} else {
													$slct_opt3 = "";
												}
												echo ("<option value='$sp_opt3[$o3]' $slct_opt3>$sp_opt3[$o3]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option4 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name4</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option4'>");
											$sp_opt4 = explode(",", $p_option4);
											for($o4=0; $o4<count($sp_opt4); $o4++) {
												if($upd_p_option4 == $sp_opt4[$o4]) {
													$slct_opt4 = "selected";
												} else {
													$slct_opt4 = "";
												}
												echo ("<option value='$sp_opt4[$o4]' $slct_opt4>$sp_opt4[$o4]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									if($p_option5 != "") { echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$p_opt_name5</label>
                                        <div class='col-sm-9'>
											<select class='form-control' name='p_option5'>");
											$sp_opt5 = explode(",", $p_option5);
											for($o5=0; $o5<count($sp_opt5); $o5++) {
												if($upd_p_option5 == $sp_opt5[$o5]) {
													$slct_opt5 = "selected";
												} else {
													$slct_opt5 = "";
												}
												echo ("<option value='$sp_opt5[$o5]' $slct_opt5>$sp_opt5[$o5]</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									}
									
									
									// Prices
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$add_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_orgin' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_10</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$add_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_market' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_12</label>
                                        <div class='col-sm-1'>
											<input disabled class='form-control' name='new_currency' value='$add_currency' style='text-align: center'>
										</div>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_price_sale' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<input class='form-control' name='new_stock_org' value='0' style='text-align: right'>
										</div>
										<div class='col-sm-2'>");
											if($add_unit != "") {
												echo ("<input readonly class='form-control' name='org_unit' value='$add_unit'>");
											}
											echo ("
										</div>
                                    </div>");
									?>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input <?=$catg_disableA?> class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_20?>">
                                            <input <?=$catg_disableA?> class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
		
		</div>
		</section>
		</div>
		</div>
		
		
		
		
		<?
		} else { // 품목 추가
          
          // 상품 옵션 디폴트값 [구체적인 옵션 병경 가능]
          
          $query_opt = "SELECT p_opt_name1,p_opt_name2,p_opt_name3,p_opt_name4,p_opt_name5, 
                        p_option1,p_option2,p_option3,p_option4,p_option5 
                        FROM code_shop_option WHERE branch_code = '$login_branch'";
          $result_opt = mysql_query($query_opt);
          if(!$result_opt) { error("QUERY_ERROR"); exit; }
          $row_opt = mysql_fetch_array($result_opt);

          $p_opt_name1 = $row_opt["p_opt_name1"];
          $p_opt_name2 = $row_opt["p_opt_name2"];
          $p_opt_name3 = $row_opt["p_opt_name3"];
          $p_opt_name4 = $row_opt["p_opt_name4"];
          $p_opt_name5 = $row_opt["p_opt_name5"];
          $p_option1 = $row_opt["p_option1"];
          $p_option2 = $row_opt["p_option2"];
          $p_option3 = $row_opt["p_option3"];
          $p_option4 = $row_opt["p_option4"];
          $p_option5 = $row_opt["p_option5"];
      
		  
		          
		echo ("
		<input type=hidden name='add_mode' value='CATG'>");
		?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Add Item Category
			
            
        </header>
		
        <div class="panel-body">
								
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_04?></label>
										<div class="col-sm-2">
											<input type="button" class="btn btn-default" value="<?=$txt_invn_stockin_21?>" onClick="Popup_Win('productcatfind.php?lang=<?=$lang?>&gate=<?=$key?>&code=catg')" />
										</div>
                                        <div class="col-sm-2">
											<input class="form-control" name="s_cat_code" type="text" required />
										</div>
										<div class="col-sm-2" align=right><?=$txt_invn_stockin_061?></div>
										<div class="col-sm-3">
											<input class="form-control" name="new_prd_code" type="text" required />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_30?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_pcode" type="text" />
										</div>
										<div class="col-sm-3" align=right>Original Barcode</div>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_barcode" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_051?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_prd_name" type="text" required />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_44?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_unit" type="text" />
										</div>
                                    </div>
									
									
									
											
									<?
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
										
										if($u == 0) {
											$unit_title = $txt_invn_stockin_44p;
										} else {
											$unit_title = "";
										}
              
									echo("
									<input type='hidden' name='check_$unit_uid' value='$unit_uid'>
									
									<div class='form-group'>
										<label class='control-label col-sm-3'>$unit_title</label>
										<div class='col-sm-3'>
											<input class='form-control' name='name_$unit_uid' value='$unit_name' type='text'>
										</div>
											
										<div class='col-sm-3'>
											<input class='form-control' name='qty_$unit_uid' type='text' style='text-align: right' placeholder='$txt_invn_stockin_38'>
										</div>
									</div>");
									}
									?>
											
									
									
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name1" value="<?=$p_opt_name1?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option1" value="<?=$p_option1?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name2" value="<?=$p_opt_name2?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option2" value="<?=$p_option2?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name3" value="<?=$p_opt_name3?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option3" value="<?=$p_option3?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name4" value="<?=$p_opt_name4?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option4" value="<?=$p_option4?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <div class="col-sm-3"><input class="form-control" name="p_opt_name5" value="<?=$p_opt_name5?>" type="text" /></div>
                                        <div class="col-sm-9">
											<input class="form-control" name="p_option5" value="<?=$p_option5?>" placeholder="<?=$txt_invn_zonopt_05?>" />
										</div>
                                    </div>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_19?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
								
		
		</div>
		</section>
		</div>
		</div>
		
		<?
		}
		?>
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

        $("#donutchart1").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
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
	</script>


  </body>
</html>


<?
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
  
  
  // 상품 삭제
  if($add_mode == "LIST_DEL") {
  
    // 상품 정보 삭제
    $result_DEL1 = mysql_query("DELETE FROM shop_product_list WHERE uid = '$new_uid'",$dbconn);
    if(!$result_DEL1) { error("QUERY_ERROR"); exit; }
    
          // 상품 품목 합계 추출 (상품 리스트에서)
          $query_sum1 = "SELECT sum(tprice_orgin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum1 = mysql_query($query_sum1);
            if (!$result_sum1) { error("QUERY_ERROR"); exit; }
          $ts_price_orgin = @mysql_result($result_sum1,0,0);

          $query_sum2 = "SELECT sum(tprice_market) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum2 = mysql_query($query_sum2);
            if (!$result_sum2) { error("QUERY_ERROR"); exit; }
          $ts_price_market = @mysql_result($result_sum2,0,0);
    
          $query_sum3 = "SELECT sum(tprice_sale) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum3 = mysql_query($query_sum3);
            if (!$result_sum3) { error("QUERY_ERROR"); exit; }
          $ts_price_sale = @mysql_result($result_sum3,0,0);
    
          $query_sum4 = "SELECT sum(tprice_margin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum4 = mysql_query($query_sum4);
            if (!$result_sum4) { error("QUERY_ERROR"); exit; }
          $ts_price_margin = @mysql_result($result_sum4,0,0);
    
          $query_sum5 = "SELECT sum(stock_org) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum5 = mysql_query($query_sum5);
            if (!$result_sum5) { error("QUERY_ERROR"); exit; }
          $ts_stock_org = @mysql_result($result_sum5,0,0);

          // 품목 정보 변경
          $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_sale2 = '$ts_price_sale', tprice_margin = '$ts_price_margin', 
                tstock_org = '$ts_stock_org' WHERE uid = '$new_catg_uid'",$dbconn);
          if(!$result_T) { error("QUERY_ERROR"); exit; }
    
    // 상품 재고변동 정보 삭제
    $result_DEL2 = mysql_query("DELETE FROM shop_product_list_qty WHERE org_uid = '$new_uid'",$dbconn);
    if(!$result_DEL2) { error("QUERY_ERROR"); exit; }
    
    // 상품 출고매장 정보 삭제
    $result_DEL3 = mysql_query("DELETE FROM shop_product_list_shop WHERE pcode = '$new_prd_code'",$dbconn);
    if(!$result_DEL3) { error("QUERY_ERROR"); exit; }
    
    
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=upd_catg&smode=dtl&dtl_gcode=$new_gcode&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_catg_uid&page=$page'>");
    exit;


  
  
  // 상품 수정 및 추가
  } else if($add_mode == "LIST_CHG") {
  
      
      if($add_stock_chk == "3") { // 추가 출고
      
          // 출고할 Shop을 지정해야만 반영됨
          if($new_shop_code != "") {
          
          
              // 선택한 Shop의 하위 테이블 존재 여부
              $scv_query = "SELECT count(uid) FROM shop_product_list_shop 
                            WHERE pcode = '$new_prd_code' AND shop_code = '$new_shop_code'";
              $scv_result = mysql_query($scv_query,$dbconn);
                if (!$scv_result) { error("QUERY_ERROR"); exit; }
              $scv_count = @mysql_result($scv_result,0,0);
            
              // 선택한 Shop의 현재 재고 추출
              $s_queryK = "SELECT qty_org,qty_now,qty_sell FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code = '$new_shop_code'";
              $s_resultK = mysql_query($s_queryK,$dbconn);
                if (!$s_resultK) { error("QUERY_ERROR"); exit; }
              $sK_qty_org = @mysql_result($s_resultK,0,0);
              $sK_qty_now = @mysql_result($s_resultK,0,1);
              $sK_qty_sell = @mysql_result($s_resultK,0,2);

              $newA_qty_org = $sK_qty_org + $new_qty_part; // 현재의 재고에서 추가 수량을 더함
              $newA_qty_now = $sK_qty_now + $new_qty_part; // 현재의 재고에서 추가 수량을 더함
              
              // 하위 Shop 지정 정보 및 수량 정보 수정
              if($scv_count > "0") {
            
                  // 선택한 Shop의 재고수량 변경
                  $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                    WHERE pcode = '$new_prd_code' AND shop_code = '$new_shop_code'",$dbconn);
                    if(!$result_Tv) { error("QUERY_ERROR"); exit; }
          
              } else {
          
                  $query_S19 = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,shop_code,pcode,qty_org,qty_now,store_date,org_pcode,org_barcode,unit) 
                    values ('','$new_uid','$login_branch','$new_shop_code','$new_prd_code','$newA_qty_org','$newA_qty_now',
                    '$post_dates','$org_pcode','$org_barcode','$new_unit')";
                  $result_S19 = mysql_query($query_S19);
                  if (!$result_S19) { error("QUERY_ERROR"); exit; }
          
              }

              
              // 미출고 재고 수량 추출
              $s_queryB = "SELECT qty_org,qty_now,qty_sell,catg_code,gcode,pcode FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''"; // Shop이 미지정된 재고 수량
              $s_resultB = mysql_query($s_queryB,$dbconn);
                if (!$s_resultB) { error("QUERY_ERROR"); exit; }
              $sB_qty_org = @mysql_result($s_resultB,0,0);
              $sB_qty_now = @mysql_result($s_resultB,0,1);
              $sB_qty_sell = @mysql_result($s_resultB,0,2);
              $sB_catg_code = @mysql_result($s_resultB,0,3);
              $sB_gcode = @mysql_result($s_resultB,0,4);
              $sB_pcode = @mysql_result($s_resultB,0,5);
              
            
              $newB_qty_org = $sB_qty_org - $new_qty_part; // 현재의 미출고 재고에서 추가 수량을 뺌
              $newB_qty_now = $sB_qty_now - $new_qty_part; // 현재의 미출고 재고에서 추가 수량을 뺌
          
          
              // 미출고 Shop의 재고수량 변경
              $result_Tv2 = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newB_qty_org', qty_now = '$newB_qty_now' 
                WHERE pcode = '$new_prd_code' AND shop_code = ''",$dbconn);
              if(!$result_Tv2) { error("QUERY_ERROR"); exit; }
              
          
      
          }
          
          // echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=upd&uid=$new_uid'>");
		  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=dtl&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&dtl_gcode=$old_gcode&dtl_uid=$new_uid&page=$page'>");
          exit;
      
      
      } else if($add_stock_chk == "2") { // ★★★ 반품 ★★★
      
          // 반품 수량 공제
          $new_stock_org2 = $old_stock_org - $new_return_qty;
            
          // 이익
          $new_price_margin = $new_price_sale - $new_price_orgin;
    
          // 시장가
          if($new_price_market < "1" OR $new_price_market == "") {
            $new_price_market = $new_price_sale;
          }
          
          // (3) 상품 합계
          $t_price_orgin = $new_price_orgin * $new_stock_org2;
          $t_price_market = $new_price_market * $new_stock_org2;
          $t_price_sale = $new_price_sale * $new_stock_org2;
          $t_price_margin = $new_price_margin * $new_stock_org2;
      
          // 상품 정보 추출
          $query_dari = "SELECT uid,catg_uid,branch_code,gate,catg_code,pcode,org_pcode,org_barcode,pname,shop_code,
            product_color,product_size,product_option1,product_option2,product_option3,product_option4,product_option5,
            price_orgin,price_market,price_sale,price_sale2,price_margin,dc_rate,save_point,stock_org,stock_sell,stock_now,
            sold_out,post_date,upd_date,store_type,store_status,store_date,pay_code,pay_status,pay_date,
            confirm_status,confirm_date FROM shop_product_list WHERE uid = '$new_uid'";
          $result_dari = mysql_query($query_dari);
          if(!$result_dari) { error("QUERY_ERROR"); exit; }
          $row_dari = mysql_fetch_object($result_dari);

          $dari_uid = $row_dari->uid;
          $dari_catg_uid = $row_dari->catg_uid;
          $dari_branch_code = $row_dari->branch_code;
          $dari_gate = $row_dari->gate;
          $dari_catg_code = $row_dari->catg_code;
          $dari_pcode = $row_dari->pcode;
		  $dari_org_pcode = $row_dari->org_pcode;
		  $dari_org_barcode = $row_dari->org_barcode;
          $dari_pname = $row_dari->pname;
          $dari_shop_code = $row_dari->shop_code;
          $dari_product_color = $row_dari->product_color;
          $dari_product_size = $row_dari->product_size;
          $dari_product_option1 = $row_dari->product_option1;
          $dari_product_option2 = $row_dari->product_option2;
          $dari_product_option3 = $row_dari->product_option3;
          $dari_product_option4 = $row_dari->product_option4;
          $dari_product_option5 = $row_dari->product_option5;
          $dari_price_orgin = $row_dari->price_orgin;
          $dari_price_market = $row_dari->price_market;
          $dari_price_sale = $row_dari->price_sale;
          $dari_price_sale2 = $row_dari->price_sale2;
          $dari_price_margin = $row_dari->price_margin;
          $dari_dc_rate = $row_dari->dc_rate;
          $dari_save_point = $row_dari->save_point;
          $dari_stock_org = $row_dari->stock_org;
          $dari_stock_sell = $row_dari->stock_sell;
          $dari_stock_now = $row_dari->stock_noq;
          $dari_sold_out = $row_dari->sold_out;
          $dari_post_date = $row_dari->post_date;
          $dari_upd_date = $row_dari->dari_upd_date;
          $dari_store_type = $row_dari->store_type;
          $dari_store_status = $row_dari->store_status;
          $dari_store_date = $row_dari->store_date;
          $dari_pay_code = $row_dari->pay_code;
          $dari_pay_status = $row_dari->pay_status;
          $dari_pay_date = $row_dari->pay_date;
          $dari_conform_status = $row_dari->confirm_status;
          $dari_confirm_date = $row_dari->confirm_date;
          
          $query_dari2 = "SELECT gudang_code,supp_code FROM shop_product_list_qty WHERE uid = '$qty_uid'";
          $result_dari2 = mysql_query($query_dari2);
            if (!$result_dari2) { error("QUERY_ERROR"); exit; }
          $dari_gudang_code = @mysql_result($result_dari2,0,0);
          $dari_supp_code = @mysql_result($result_dari2,0,1);


          // 반품되는 상품의 가격 합계 ($new_return_qty)
          $t1_price_orgin = $dari_price_orgin * $new_return_qty;
          $t1_price_market = $dari_price_market * $new_return_qty;
          $t1_price_sale = $dari_price_sale * $new_return_qty;
          $t1_price_sale2 = $dari_price_sale2 * $new_return_qty;
          $t1_price_margin = $dari_price_margin * $new_return_qty;
        
          $dari2_stock_now = $dari_stock_now - $new_return_qty;

          // 반품 정보 입력
          $query_R1 = "INSERT INTO shop_product_return (uid,org_uid,branch_code,gate,catg_code,
            pcode,org_pcode,org_barcode,pname,gudang_code,supp_code,shop_code,product_color,product_size,
            product_option1,product_option2,product_option3,product_option4,product_option5,
            price_orgin,price_market,price_sale,price_sale2,price_margin,
            dc_rate,save_point,stock_org,stock_sell,
            tprice_orgin,tprice_market,tprice_sale,tprice_sale2,tprice_margin,
            sold_out,post_date,return_type,return_date,unit) 
          values ('','$new_uid','$dari_branch_code','$dari_gate','$dari_catg_code',
            '$dari_pcode','$dari_org_pcode','$dari_org_barcode','$dari_pname','$dari_gudang_code','$dari_supp_code','$dari_shop_code',
            '$dari_product_color','$dari_product_size',
            '$dari_product_option1','$dari_product_option2','$dari_product_option3','$dari_product_option4','$dari_product_option5',
            '$dari_price_orgin','$dari_price_market','$dari_price_sale','$dari_price_sale2','$dari_price_margin',
            '$dari_dc_rate','$dari_save_point','$new_return_qty','$dari_stock_sell',
            '$t1_price_orgin','$t1_price_market','$t1_price_sale','$t1_price_sale2','$t1_price_margin',
            '$dari_sold_out','$dari_post_date','6','$post_dates','$new_unit')";
          $result_R1 = mysql_query($query_R1);
          if (!$result_R1) { error("QUERY_ERROR"); exit; }
          
          
          // 상품 정보 수정
          $result_CHGs = mysql_query("UPDATE shop_product_list SET price_orgin = '$new_price_orgin', 
                price_market = '$new_price_market', 
                price_sale = '$new_price_sale', price_sale2 = '$new_price_sale', price_margin = '$new_price_margin', 
                tprice_orgin = '$t_price_orgin', tprice_market = '$t_price_market', 
                tprice_sale = '$t_price_sale', tprice_sale2 = '$t_price_sale', tprice_margin = '$t_price_margin', 
                stock_org = '$new_stock_org2', stock_now = '$new_stock_org2' WHERE uid = '$new_uid'",$dbconn);
          if(!$result_CHGs) { error("QUERY_ERROR"); exit; }
    
            // 상품 품목 공제
            $my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
                FROM shop_product_catg WHERE uid = '$new_catg_uid' ORDER BY pcode DESC";
            $my_result = mysql_query($my_query);
            if (!$my_result) { error("QUERY_ERROR"); exit; }

            $my_catg_uid = @mysql_result($my_result,0,0);
            $my_price_orgin = @mysql_result($my_result,0,1);
            $my_price_market = @mysql_result($my_result,0,2);
            $my_price_sale = @mysql_result($my_result,0,3);
            $my_price_margin = @mysql_result($my_result,0,4);
            $my_stock_org = @mysql_result($my_result,0,5);
    
            $ts_stock_org = $my_stock_org - $new_return_qty;
            $ts_price_orgin = $my_price_orgin - ( $new_price_orgin * $new_return_qty );
            $ts_price_market = $my_price_market - ( $new_price_sale * $new_return_qty );
            $ts_price_sale = $my_price_sale - ( $new_price_sale * $new_return_qty );
            $ts_price_margin = $my_price_margin - ( $new_price_margin * $new_return_qty );
    
            $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_margin = '$ts_price_margin', tstock_org = '$ts_stock_org' 
                WHERE pcode = '$new_group_code'",$dbconn);
            if(!$result_T) { error("QUERY_ERROR"); exit; }
          
          
          // 미출고 재고 테이블 정보 변경 (미출고 재고 - 반품 수량 (new_return_qty))
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$dari_pcode' AND shop_code = ''"; // Shop이 미지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
          $newA_qty_org = $sB_qty_org - $new_return_qty; // 현재의 미출고 재고에서 반품 수량을 뺌
          $newA_qty_now = $sB_qty_now - $new_return_qty; // 현재의 미출고 재고에서 반품 수량을 뺌
          
          
          // Shop이 미지정된 재고수량 변경
          $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
            WHERE pcode = '$dari_pcode' AND shop_code = ''",$dbconn);
          if(!$result_Tv) { error("QUERY_ERROR"); exit; }
          
          // 하위 재고수량 변경 ★
          $query_Tv1 = "SELECT stock FROM shop_product_list_qty WHERE uid = '$qty_uid'";
          $result_Tv1 = mysql_query($query_Tv1);
            if (!$result_Tv1) { error("QUERY_ERROR"); exit; }
          $sub_qty_now = @mysql_result($result_Tv1,0,0);
          
          $new_sub_qty_now = $sub_qty_now - $new_return_qty;
          
          $result_Tv2 = mysql_query("UPDATE shop_product_list_qty SET stock = '$new_sub_qty_now' 
            WHERE uid = '$qty_uid'",$dbconn);
          if(!$result_Tv2) { error("QUERY_ERROR"); exit; }
          

          // 완전 반품시 상품 정보 삭제
          if($new_stock_org2 == "0") {
            $query_D3 = "DELETE FROM shop_product_list WHERE uid = '$new_uid'";
            $result_D3 = mysql_query($query_D3);
            if (!$result_D3) { error("QUERY_ERROR"); exit; }
        
            $query_D4 = "DELETE FROM shop_product_list_qty WHERE org_uid = '$new_uid'";
            $result_D4 = mysql_query($query_D4);
            if (!$result_D4) { error("QUERY_ERROR"); exit; }
            
            $query_D5 = "DELETE FROM shop_product_list_shop WHERE pcode = '$dari_pcode'";
            $result_D5 = mysql_query($query_D5);
            if (!$result_D5) { error("QUERY_ERROR"); exit; }
          }
          
          // echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=upd&uid=$new_uid'>");
		  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=dtl&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&dtl_gcode=$old_gcode&dtl_uid=$new_uid&page=$page'>");
          exit;
          
      
      
      } else if($add_stock_chk == "1") { // 상품 재고 변동 관리 [동일 상품]
      
          // 최소 수량
          if($chg_stock_add < "1") {
            $chg_stock_add = "1";
          }
          
          // 이익
          $new_price_margin = $new_price_sale - $new_price_orgin;
    
          // 시장가
          if($new_price_market < "1" OR $new_price_market == "") {
            $new_price_market = $new_price_sale;
          }
          
          // ◆◆◆ 정보의 동일 여부 체크 - 동일시 상품 재고수량 변동 및 하위 수량 테이블 생성
          if(($old_pname == $new_prd_name) AND 
          ($old_p_option1 == $p_option1) AND ($old_p_option2 == $p_option2) AND ($old_p_option3 == $p_option3) AND 
          ($old_p_option4 == $p_option4) AND ($old_p_option5 == $p_option5) AND ($old_price_orgin == $new_price_orgin)) {
          
            // 수량 합산
            $reset_qty = $new_stock_org + $chg_stock_add;
            $reset_qty_now = $old_stock_now + $chg_stock_add;
            
            
            // 상품 합계
            $ct_price_orgin = $new_price_orgin * $reset_qty;
            $ct_price_market = $new_price_market * $reset_qty;
            $ct_price_sale = $new_price_sale * $reset_qty;
            $ct_price_margin = $new_price_margin * $reset_qty;
            
            // 상품 정보 변경
            $result_CHG5 = mysql_query("UPDATE shop_product_list SET tprice_orgin = '$t_price_orgin', 
                tprice_market = '$ct_price_market', tprice_sale = '$ct_price_sale', tprice_sale2 = '$ct_price_sale', 
                tprice_margin = '$ct_price_margin', stock_org = '$reset_qty', stock_now = '$reset_qty_now', 
                upd_date = '$post_dates' WHERE uid = '$new_uid'",$dbconn);
            if(!$result_CHG5) { error("QUERY_ERROR"); exit; }
            
            
            // 하위 수량 테이블 생성
            $query_S1 = "INSERT INTO shop_product_list_qty (uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,gudang_code,supp_code,
                org_uid,stock,date,price_orgin,unit) values ('','$login_branch','$s_cat_code','$new_group_code',
                '$new_prd_code','$org_pcode','$org_barcode','$new_gudang_code','$new_supp_code','$new_uid','$chg_stock_add','$post_dates',
                '$new_price_orgin','$new_unit')";
            $result_S1 = mysql_query($query_S1);
            if (!$result_S1) { error("QUERY_ERROR"); exit; }
            
            
            // 상품 품목 합산
            $my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
                FROM shop_product_catg WHERE uid = '$new_catg_uid' ORDER BY pcode DESC";
            $my_result = mysql_query($my_query);
            if (!$my_result) { error("QUERY_ERROR"); exit; }

            $my_catg_uid = @mysql_result($my_result,0,0);
            $my_price_orgin = @mysql_result($my_result,0,1);
            $my_price_market = @mysql_result($my_result,0,2);
            $my_price_sale = @mysql_result($my_result,0,3);
            $my_price_margin = @mysql_result($my_result,0,4);
            $my_stock_org = @mysql_result($my_result,0,5);
    
            $ts_stock_org = $my_stock_org + $chg_stock_add;
            $ts_price_orgin = $my_price_orgin + ( $new_price_orgin * $chg_stock_add );
            $ts_price_market = $my_price_market + ( $new_price_sale * $chg_stock_add );
            $ts_price_sale = $my_price_sale + ( $new_price_sale * $chg_stock_add );
            $ts_price_margin = $my_price_margin + ( $new_price_margin * $chg_stock_add );
    
            $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_margin = '$ts_price_margin', tstock_org = '$ts_stock_org' 
                WHERE pcode = '$new_group_code'",$dbconn);
            if(!$result_T) { error("QUERY_ERROR"); exit; }


            // Shop 미지정 재고 입력 필드 존재 여부 ----------------------------------------------------------------- //
          
            $scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$new_prd_code' AND shop_code = ''";
            $scv_result = mysql_query($scv_query,$dbconn);
              if (!$scv_result) { error("QUERY_ERROR"); exit; }
            $scv_count = @mysql_result($scv_result,0,0);
          
            $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''"; // Shop이 미지정된 재고 수량
            $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
            $sB_qty_org = @mysql_result($s_resultB,0,0);
            $sB_qty_now = @mysql_result($s_resultB,0,1);
            $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
            $newA_qty_org = $sB_qty_org + $chg_stock_add; // 새 입력값에서 현재의 재고를 더함
            $newA_qty_now = $sB_qty_now + $chg_stock_add; // 새 입력값에서 현재의 재고를 더함
            
            // 하위 Shop 지정 정보 및 수량 정보 수정
            if($scv_count > "0") { // Shop 미지정 재고가 1 이상일 때

            
              // Shop이 미지정된 재고수량 변경
              $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''",$dbconn);
              if(!$result_Tv) { error("QUERY_ERROR"); exit; }

          
            } else {
          
          
              $query_S19 = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,shop_code,pcode,org_pcode,org_barcode,qty_org,qty_now,store_date,unit) 
                values ('','$new_uid','$login_branch','$new_shop_code','$new_prd_code','$org_pcode','$org_barcode','$newA_qty_org','$newA_qty_now',
                '$post_dates','$new_unit')";
              $result_S19 = mysql_query($query_S19);
              if (!$result_S19) { error("QUERY_ERROR"); exit; }
          
            }

            
            // echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=upd&uid=$new_uid'>");
			echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=dtl&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&dtl_gcode=$old_gcode&dtl_uid=$new_uid&page=$page'>");
            exit;
            
          
          
          
          } else { // 새로운 상품 생성
          
          // 상품 코드 생성
          $rm_query = "SELECT pcode FROM shop_product_list WHERE catg_uid = '$new_catg_uid' ORDER BY pcode DESC";
          $rm_result = mysql_query($rm_query);
            if (!$rm_result) { error("QUERY_ERROR"); exit; }
          $max_room = @mysql_result($rm_result,0,0);

		  $exp_room1 = substr($max_room,11);
	
		  // Product Group Name
		  $rm2_query = "SELECT pname FROM shop_product_catg WHERE pcode = '$new_group_code' ORDER BY pcode DESC";
          $rm2_result = mysql_query($rm2_query);
            if (!$rm2_result) { error("QUERY_ERROR"); exit; }
          $new_gname = @mysql_result($rm2_result,0,0);
		  

          $new_room_num1 = $exp_room1 + 1;
          $new_room_num2 = sprintf("%02d", $new_room_num1); // 2자리수
    
          if($max_room == "") {
            $new_pcode = $new_group_code . "01";
          } else {
            $new_pcode = $new_group_code . "$new_room_num2";
          }
    
          // 상품 합계
          $t_price_orgin = $new_price_orgin * $chg_stock_add;
          $t_price_market = $new_price_market * $chg_stock_add;
          $t_price_sale = $new_price_sale * $chg_stock_add;
          $t_price_margin = $new_price_margin * $chg_stock_add;
    
          // 상품 정보 입력

            $query_M1 = "INSERT INTO shop_product_list (uid,catg_uid,branch_code,gudang_code,supp_code,
            gate,shop_code,catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,
            price_orgin,price_market,price_sale,price_sale2,price_margin,
            tprice_orgin,tprice_market,tprice_sale,tprice_sale2,tprice_margin,stock_org,stock_now,post_date,
            product_color,product_size,product_option1,product_option2,product_option3,product_option4,product_option5,unit) 
            values ('','$new_catg_uid','$new_branch_code','$new_gudang_code','$new_supp_code',
            '$new_client','$new_client','$s_cat_code','$new_group_code','$new_pcode','$org_pcode','$org_barcode','$new_gname','$new_prd_name',
            '$new_price_orgin','$new_price_market','$new_price_sale','$new_price_sale','$new_price_margin',
            '$t_price_orgin','$t_price_market','$t_price_sale','$t_price_sale','$t_price_margin','$chg_stock_add','$chg_stock_add',
            '$post_dates','$new_prd_color','$new_prd_size','$p_option1','$p_option2','$p_option3','$p_option4','$p_option5','$new_unit')";
            $result_M1 = mysql_query($query_M1);
            if (!$result_M1) { error("QUERY_ERROR"); exit; }
    

    
          // 상품 품목 합산
          $my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
                FROM shop_product_catg WHERE uid = '$new_catg_uid' ORDER BY pcode DESC";
          $my_result = mysql_query($my_query);
          if (!$my_result) { error("QUERY_ERROR"); exit; }

          $my_catg_uid = @mysql_result($my_result,0,0);
          $my_price_orgin = @mysql_result($my_result,0,1);
          $my_price_market = @mysql_result($my_result,0,2);
          $my_price_sale = @mysql_result($my_result,0,3);
          $my_price_margin = @mysql_result($my_result,0,4);
          $my_stock_org = @mysql_result($my_result,0,5);
    
          $ts_stock_org = $my_stock_org + $chg_stock_add;
          $ts_price_orgin = $my_price_orgin + ( $new_price_orgin * $chg_stock_add );
          $ts_price_market = $my_price_market + ( $new_price_sale * $chg_stock_add );
          $ts_price_sale = $my_price_sale + ( $new_price_sale * $chg_stock_add );
          $ts_price_margin = $my_price_margin + ( $new_price_margin * $chg_stock_add );
    
          $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_margin = '$ts_price_margin', tstock_org = '$ts_stock_org' 
                WHERE pcode = '$new_group_code'",$dbconn);
          if(!$result_T) { error("QUERY_ERROR"); exit; }

          // 상품 출고매장 정보 입력 [신규 - 미출고]
          $query_SH2 = "INSERT INTO shop_product_list_shop (uid,branch_code,shop_code,pcode,org_pcode,org_barcode,gname,pname,qty_org,qty_now,store_date,unit) 
            values ('','$login_branch','','$new_pcode','$org_pcode','$org_barcode','$new_gname','$new_prd_name','$chg_stock_add','$chg_stock_add','$post_dates','$new_unit')";
          $result_SH2 = mysql_query($query_SH2);
          if (!$result_SH2) { error("QUERY_ERROR"); exit; }
          
          // 하위 수량 테이블 생성 ●
          $query_npc = "SELECT uid FROM shop_product_list WHERE pcode = '$new_pcode'";
          $result_npc = mysql_query($query_npc);
            if (!$result_npc) { error("QUERY_ERROR"); exit; }
          $new_org_uid = @mysql_result($result_npc,0,0);
          
          $query_S1 = "INSERT INTO shop_product_list_qty (uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,gudang_code,supp_code,
                org_uid,stock,date,price_orgin,unit) values ('','$login_branch','$s_cat_code','$new_group_code',
                '$new_pcode','$org_pcode','$org_barcode','$new_gudang_code','$new_supp_code','$new_org_uid','$chg_stock_add','$post_dates',
                '$new_price_orgin','$new_unit')";
          $result_S1 = mysql_query($query_S1);
          if (!$result_S1) { error("QUERY_ERROR"); exit; }



          echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=post&uid=$my_catg_uid&smode=dtl&dtl_gcode=$new_group_code'>");
          exit;
        
        
        }
      
      
      } else if($add_stock_chk == "0") { // 상품 정보 수정 [단순한 재고 수정]
  

          
          
          // 신규 수량이 Shop이 지정된 (이미 출고된) 재고 수량보다 작을 수 없음
          $s_queryX = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code != ''"; // Shop이 지정된 재고 수량
          $s_resultX = mysql_query($s_queryX,$dbconn);
              if (!$s_resultX) { error("QUERY_ERROR"); exit; }
          $sX_qty_org = @mysql_result($s_resultX,0,0);
          $sX_qty_now = @mysql_result($s_resultX,0,1);
          $sX_qty_sell = @mysql_result($s_resultX,0,2);
          
          if($new_stock_org < $sX_qty_org) { $new_stock_org = $sX_qty_org; }
          if($new_stock_now < $sX_qty_now) { $new_stock_now = $sX_qty_now; }
          
          // 현재 재고 (새 입력값에서 이미 팔린 수량을 뺌)
          $new_stock_now = $new_stock_org - $sX_qty_sell;
          

          // 이익
          $new_price_margin = $new_price_sale - $new_price_orgin;
    
          // 시장가
          if($new_price_market < "1" OR $new_price_market == "") {
            $new_price_market = $new_price_sale;
          }
    
          // 상품 합계
          $t_price_orgin = $new_price_orgin * $new_stock_org;
          $t_price_market = $new_price_market * $new_stock_org;
          $t_price_sale = $new_price_sale * $new_stock_org;
          $t_price_margin = $new_price_margin * $new_stock_org;
          
    
          // 상품 정보 수정
          $result_CHG = mysql_query("UPDATE shop_product_list SET gudang_code = '$new_gudang_code', 
                supp_code = '$new_supp_code', org_pcode = '$org_pcode', org_barcode = '$org_barcode',
                gate = '$new_shop_code', shop_code = '$new_shop_code', pname = '$new_prd_name', 
                price_orgin = '$new_price_orgin', price_market = '$new_price_market', 
                price_sale = '$new_price_sale', price_sale2 = '$new_price_sale', price_margin = '$new_price_margin', 
                tprice_orgin = '$t_price_orgin', tprice_market = '$t_price_market', 
                tprice_sale = '$t_price_sale', tprice_sale2 = '$t_price_sale', tprice_margin = '$t_price_margin', 
                stock_org = '$new_stock_org', stock_now = '$new_stock_now',
                product_color = '$new_prd_color', product_size = '$new_prd_size', 
                product_option1 = '$p_option1', product_option2 = '$p_option2', product_option3 = '$p_option3', 
                product_option4 = '$p_option4', product_option5 = '$p_option5' WHERE uid = '$new_uid'",$dbconn);
          if(!$result_CHG) { error("QUERY_ERROR"); exit; }
           
          
          // 상품 품목 합계 추출 (상품 리스트에서)
          $query_sum1 = "SELECT sum(tprice_orgin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum1 = mysql_query($query_sum1);
            if (!$result_sum1) { error("QUERY_ERROR"); exit; }
          $ts_price_orgin = @mysql_result($result_sum1,0,0);

          $query_sum2 = "SELECT sum(tprice_market) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum2 = mysql_query($query_sum2);
            if (!$result_sum2) { error("QUERY_ERROR"); exit; }
          $ts_price_market = @mysql_result($result_sum2,0,0);
    
          $query_sum3 = "SELECT sum(tprice_sale) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum3 = mysql_query($query_sum3);
            if (!$result_sum3) { error("QUERY_ERROR"); exit; }
          $ts_price_sale = @mysql_result($result_sum3,0,0);
    
          $query_sum4 = "SELECT sum(tprice_margin) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum4 = mysql_query($query_sum4);
            if (!$result_sum4) { error("QUERY_ERROR"); exit; }
          $ts_price_margin = @mysql_result($result_sum4,0,0);
    
          $query_sum5 = "SELECT sum(stock_org) FROM shop_product_list WHERE catg_uid = '$new_catg_uid'";
          $result_sum5 = mysql_query($query_sum5);
            if (!$result_sum5) { error("QUERY_ERROR"); exit; }
          $ts_stock_org = @mysql_result($result_sum5,0,0);

          // 품목 정보 변경
          $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_sale2 = '$ts_price_sale', tprice_margin = '$ts_price_margin', 
                tstock_org = '$ts_stock_org' WHERE uid = '$new_catg_uid'",$dbconn);
          if(!$result_T) { error("QUERY_ERROR"); exit; }
          
          
          
          
          // Shop 미지정 재고 입력 필드 존재 여부 ----------------------------------------------------------------- //
          
          $scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$new_prd_code' AND shop_code = ''";
          $scv_result = mysql_query($scv_query,$dbconn);
            if (!$scv_result) { error("QUERY_ERROR"); exit; }
          $scv_count = @mysql_result($scv_result,0,0);
          
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code != ''"; // Shop이 지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
          $newA_qty_org = $new_stock_org - $sB_qty_org; // 새 입력값에서 이미 출고된 재고를 뺌
          $newA_qty_now = $new_stock_org - $sB_qty_now; // 새 입력값에서 이미 출고된 재고를 뺌
            
          // 새 입력값에서 이미 출고된 재고를 뺀 값이 음수가 될 수 없음
          if($newA_qty_org < 0) { $newA_qty_org = $sB_qty_org; }
          if($newA_qty_now < 0) { $newA_qty_now = $sB_qty_now; }
          
          
          // 하위 Shop 지정 정보 및 수량 정보 수정
          if($scv_count > "0") { // Shop 미지정 재고가 1 이상일 때

            
            // Shop이 미지정된 재고수량 변경
            $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''",$dbconn);
            if(!$result_Tv) { error("QUERY_ERROR"); exit; }

          
          } else {
          
          
            $query_S19 = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,shop_code,pcode,org_pcode,org_barcode,qty_org,qty_now,store_date,unit) 
                values ('','$new_uid','$login_branch','$new_shop_code','$new_prd_code','$org_pcode','$org_barcode','$newA_qty_org','$newA_qty_now',
                '$post_dates','$new_unit')";
            $result_S19 = mysql_query($query_S19);
            if (!$result_S19) { error("QUERY_ERROR"); exit; }
          
          }
    
  
          echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=dtl&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&dtl_gcode=$old_gcode&dtl_uid=$new_uid&page=$page'>");
          exit;



      } else {  // Shop에 따른 재고 수정
      
      
          // 변경하고자 하는 shop_code와 수량 재정의
          $check_org_qty = "new_qty_$add_stock_chk";
          $check_new_qty = ${$check_org_qty}; // 변경후 수량
          $check_shop_code = $add_stock_chk; // Shop Code
          
          
          // 선택한 Shop의 현재 재고 추출
          $s_queryK = "SELECT qty_org,qty_now,qty_sell FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code = '$check_shop_code'";
          $s_resultK = mysql_query($s_queryK,$dbconn);
            if (!$s_resultK) { error("QUERY_ERROR"); exit; }
          $sK_qty_org = @mysql_result($s_resultK,0,0);
          $sK_qty_now = @mysql_result($s_resultK,0,1);
          $sK_qty_sell = @mysql_result($s_resultK,0,2);
          
          $newA_qty_now = $check_new_qty - $sK_qty_sell; // 변경후 현 해당 Shop의 현재 재고수량

            
          // 선택한 Shop의 재고수량 변경
          $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$check_new_qty', qty_now = '$newA_qty_now' 
                    WHERE pcode = '$new_prd_code' AND shop_code = '$check_shop_code'",$dbconn);
          if(!$result_Tv) { error("QUERY_ERROR"); exit; }
          
          // 재고 변동의 차이 [!]
          $newA_qty_diff = $sK_qty_org - $check_new_qty;

              
          // 미출고 재고 수량 추출 ------------------------------------------------ //

          $scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$new_prd_code' AND shop_code = ''";
          $scv_result = mysql_query($scv_query,$dbconn);
            if (!$scv_result) { error("QUERY_ERROR"); exit; }
          $scv_count = @mysql_result($scv_result,0,0);
        
          if($scv_count > "0") { // 미출고 테이블이 있을 때
        
          
          $s_queryB = "SELECT qty_org,qty_now FROM shop_product_list_shop 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''"; // Shop이 미지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
            if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          
          // 변경 후 재고수량
          $newB_qty_org = $sB_qty_org + $newA_qty_diff;
          $newB_qty_now = $sB_qty_now + $newA_qty_diff;
          
          
          // 미출고 Shop의 재고수량 변경
          $result_Tv2 = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newB_qty_org', qty_now = '$newB_qty_now' 
                        WHERE pcode = '$new_prd_code' AND shop_code = ''",$dbconn);
          if(!$result_Tv2) { error("QUERY_ERROR"); exit; }          
          
          
          } else { // 미출고 테이블이 없을 때 -- 미출고 테이블 생성
          
            $query_SH2 = "INSERT INTO shop_product_list_shop (uid,branch_code,shop_code,pcode,org_pcode,org_barcode,qty_org,qty_now,store_date,unit) 
                values ('','$login_branch','','$new_prd_code','$org_pcode','$org_barcode','$sK_qty_org','$sK_qty_now','$post_dates','$new_unit')";
            $result_SH2 = mysql_query($query_SH2);
            if (!$result_SH2) { error("QUERY_ERROR"); exit; }
            
            // 하위 수량 테이블 생성
            $rm3_query = "SELECT uid,catg_code,gcode,gudang_code,supp_code FROM shop_product_list WHERE pcode = '$new_prd_code'";
            $rm3_result = mysql_query($rm3_query);
            if (!$rm3_result) { error("QUERY_ERROR"); exit; }
            $rm3_qty_uid = @mysql_result($rm3_result,0,0);
            $rm3_catg_code = @mysql_result($rm3_result,0,1);
            $rm3_gcode = @mysql_result($rm3_result,0,2);
            $rm3_gudang_code = @mysql_result($rm3_result,0,3);
            $rm3_supp_code = @mysql_result($rm3_result,0,4);
            
            $query_SH3 = "INSERT INTO shop_product_list_qty (uid,branch_code,catg_code,gcode,pcode,org_pcode,org_barcode,gudang_code,supp_code,
                org_uid,this_stock,store_date,price_orgin,unit) values ('','$login_branch','$rm3_cat_code','$rm3_gcode',
                '$new_prd_code','$org_pcode','$org_barcode','$rm3_gudang_code','$rm3_supp_code','$rm3_qty_uid','$sK_qty_org','$post_dates','$new_price_orgin','$new_unit')";
            $result_SH3 = mysql_query($query_SH3);
            if (!$result_SH3) { error("QUERY_ERROR"); exit; }
          
          }

          // 재고를 "0"으로 변경할 때 관련 하위 테이블 삭제 [판매된 수량도 없을 때]
          if($check_new_qty == 0) {
            $query_D5 = "DELETE FROM shop_product_list_shop WHERE pcode = '$new_prd_code' AND shop_code = '$check_shop_code'";
            $result_D5 = mysql_query($query_D5);
            if (!$result_D5) { error("QUERY_ERROR"); exit; }
            
            $query_D6 = "DELETE FROM shop_product_list_qty WHERE pcode = '$new_prd_code' AND this_shop_code = '$check_shop_code'";
            $result_D6 = mysql_query($query_D6);
            if (!$result_D6) { error("QUERY_ERROR"); exit; }
          }
          
      
          echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=dtl&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&dtl_gcode=$rm3_gcode&dtl_uid=$new_uid&page=$page'>");
          exit;
      
      
      }



  
  // 상품 입력 -------------------------------------------------------------------------------------------// 
  
  } else if($add_mode == "LIST") {
  
      
      if($new_gudang_code == "") {
          popup_msg("$txt_stf_member_chk01");
          break;
      }
      
      if($new_supp_code == "") {
          popup_msg("$txt_sys_supplier_13");
          break;
      }
  
    // 상품 코드 생성
    $rm_query = "SELECT pcode FROM shop_product_list WHERE gcode = '$new_prd_code' ORDER BY pcode DESC";
    $rm_result = mysql_query($rm_query);
    if (!$rm_result) { error("QUERY_ERROR"); exit; }
    $max_room = @mysql_result($rm_result,0,0);
 
	$exp_room1 = substr($max_room,11);
	
		  // Product Group Name
		  $rm2_query = "SELECT pname FROM shop_product_catg WHERE pcode = '$new_prd_code' ORDER BY pcode DESC";
          $rm2_result = mysql_query($rm2_query);
            if (!$rm2_result) { error("QUERY_ERROR"); exit; }
          $new_gname = @mysql_result($rm2_result,0,0);

    $new_room_num1 = $exp_room1 + 1;
    $new_room_num2 = sprintf("%02d", $new_room_num1); // 2자리수
    
    if($max_room == "") {
      $new_pcode = $new_prd_code . "01";
    } else {
      $new_pcode = $new_prd_code . "$new_room_num2";
    }
    
    // 이익
    $new_price_margin = $new_price_sale - $new_price_orgin;
    
    // 시장가
    if($new_price_market < "1" OR $new_price_market == "") {
      $new_price_market = $new_price_sale;
    }
    
    // 상품 합계
    $t_price_orgin = $new_price_orgin * $new_stock_org;
    $t_price_market = $new_price_market * $new_stock_org;
    $t_price_sale = $new_price_sale * $new_stock_org;
    $t_price_margin = $new_price_margin * $new_stock_org;
    
    // 상품 정보 입력
    $query_M1 = "INSERT INTO shop_product_list (uid,catg_uid,branch_code,gudang_code,supp_code,
          gate,shop_code,catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,
          price_orgin,price_market,price_sale,price_sale2,price_margin,
          tprice_orgin,tprice_market,tprice_sale,tprice_sale2,tprice_margin,stock_org,stock_now,post_date,
          product_color,product_size,product_option1,product_option2,product_option3,product_option4,product_option5,unit) 
          values ('','$new_uid','$login_branch','$new_gudang_code','$new_supp_code',
          '$new_toko','$new_toko','$s_cat_code','$new_prd_code','$new_pcode','$org_pcode','$org_barcode','$new_gname','$new_prd_name',
          '$new_price_orgin','$new_price_market','$new_price_sale','$new_price_sale','$new_price_margin',
          '$t_price_orgin','$t_price_market','$t_price_sale','$t_price_sale','$t_price_margin','$new_stock_org','$new_stock_org',
          '$post_dates','$new_prd_color','$new_prd_size','$p_option1','$p_option2','$p_option3','$p_option4','$p_option5','$new_unit')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }
    
    // 상품 품목 합산
    $my_query = "SELECT uid,tprice_orgin,tprice_market,tprice_sale,tprice_margin,tstock_org 
                FROM shop_product_catg WHERE pcode = '$new_prd_code' ORDER BY pcode DESC";
    $my_result = mysql_query($my_query);
    if (!$my_result) { error("QUERY_ERROR"); exit; }

    $my_catg_uid = @mysql_result($my_result,0,0);
    $my_price_orgin = @mysql_result($my_result,0,1);
    $my_price_market = @mysql_result($my_result,0,2);
    $my_price_sale = @mysql_result($my_result,0,3);
    $my_price_margin = @mysql_result($my_result,0,4);
    $my_stock_org = @mysql_result($my_result,0,5);
    
    $ts_stock_org = $my_stock_org + $new_stock_org;
    $ts_price_orgin = $my_price_orgin + ( $new_price_orgin * $new_stock_org );
    $ts_price_market = $my_price_market + ( $new_price_sale * $new_stock_org );
    $ts_price_sale = $my_price_sale + ( $new_price_sale * $new_stock_org );
    $ts_price_margin = $my_price_margin + ( $new_price_margin * $new_stock_org );
    
    $result_T = mysql_query("UPDATE shop_product_catg SET tprice_orgin = '$ts_price_orgin', tprice_market = '$ts_price_market', 
                tprice_sale = '$ts_price_sale', tprice_margin = '$ts_price_margin', tstock_org = '$ts_stock_org' 
                WHERE pcode = '$new_prd_code'",$dbconn);
    if(!$result_T) { error("QUERY_ERROR"); exit; }
    
    
    // 상품 출고매장 정보 입력
    $query_SH2 = "INSERT INTO shop_product_list_shop (uid,branch_code,shop_code,pcode,org_pcode,org_barcode,gname,pname,qty_org,qty_now,store_date,unit) 
          values ('','$login_branch','','$new_pcode','$org_pcode','$org_barcode','$new_gname','$new_prd_name','$new_stock_org','$new_stock_org','$post_dates','$new_unit')";
    $result_SH2 = mysql_query($query_SH2);
    if (!$result_SH2) { error("QUERY_ERROR"); exit; }
    
    // 상품 수량 정보 입력 [uid 추출]
    $rm2_query = "SELECT uid FROM shop_product_list WHERE pcode = '$new_pcode'";
    $rm2_result = mysql_query($rm2_query);
    if (!$rm2_result) { error("QUERY_ERROR"); exit; }
    $new_qty_uid = @mysql_result($rm2_result,0,0);

    $query_SH3 = "INSERT INTO shop_product_list_qty (uid,branch_code,shop_code,catg_code,
          gcode,pcode,org_pcode,org_barcode,gudang_code,supp_code,org_uid,stock,date,price_orgin,unit) values ('','$login_branch',
          '','$s_cat_code','$new_prd_code','$new_pcode','$org_pcode','$org_barcode','$new_gudang_code','$new_supp_code',
          '$new_qty_uid','$new_stock_org','$post_dates','$new_price_orgin','$new_unit')";
    $result_SH3 = mysql_query($query_SH3);
    if (!$result_SH3) { error("QUERY_ERROR"); exit; }
    
    
    
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mode=post&uid=$my_catg_uid&smode=dtl&dtl_gcode=$new_prd_code'>");
    exit;









  } else if($add_mode == "CATG_UPD") {
  
    // 품목 수정 [카테고리 수정 가능토록 변경]
    if(!$chg_mcode) { $chg_mcode = "0"; }
    
    if($chg_mcode == "1") {

      $query_M1 = "UPDATE shop_product_catg SET catg_code = '$s_cat_code', pname = '$new_prd_name' WHERE uid = '$new_catg_uid'";
      $result_M1 = mysql_query($query_M1);
      if (!$result_M1) { error("QUERY_ERROR"); exit; }
      
      // 하위 테이블 품목 수정 [gcode 중심 -- $new_chg_gcode]
      $query_GM1 = "UPDATE shop_product_list SET catg_code = '$s_cat_code', gname = '$new_prd_name' WHERE gcode = '$new_chg_gcode'";
      $result_GM1 = mysql_query($query_GM1);
      if (!$result_GM1) { error("QUERY_ERROR"); exit; }
      
      $query_GM2 = "UPDATE shop_product_list_shop SET catg_code = '$s_cat_code', gname = '$new_prd_name' WHERE gcode = '$new_chg_gcode'";
      $result_GM2 = mysql_query($query_GM2);
      if (!$result_GM2) { error("QUERY_ERROR"); exit; }
      
      $query_GM3 = "UPDATE shop_product_list_qty SET catg_code = '$s_cat_code' WHERE gcode = '$new_chg_gcode'";
      $result_GM3 = mysql_query($query_GM3);
      if (!$result_GM3) { error("QUERY_ERROR"); exit; }
    
    } else {
      $query_M1 = "UPDATE shop_product_catg SET pname = '$new_prd_name', p_opt_name1 = '$p_opt_name1', 
                p_opt_name2 = '$p_opt_name2', p_opt_name3 = '$p_opt_name3', p_opt_name4 = '$p_opt_name4', 
                p_opt_name5 = '$p_opt_name5',
                p_option1 = '$p_option1', p_option2 = '$p_option2', p_option3 = '$p_option3', 
                p_option4 = '$p_option4', p_option5 = '$p_option5', org_pcode = '$org_pcode', org_barcode = '$org_barcode', unit = '$new_unit' WHERE uid = '$new_catg_uid'";
      $result_M1 = mysql_query($query_M1);
      if (!$result_M1) { error("QUERY_ERROR"); exit; }
    }
	
	
	
		// Product Unit -- IMPORTANT !!
	
		$query_RC = "SELECT count(uid) FROM shop_product_unit";
		$result_RC = mysql_query($query_RC,$dbconn);
		if (!$result_RC) { error("QUERY_ERROR"); exit; }
      
		$total_RC = @mysql_result($result_RC,0,0);
      
		$query_R1 = "SELECT uid,unit_name FROM shop_product_unit ORDER BY uid ASC";
		$result_R1 = mysql_query($query_R1,$dbconn);
		if (!$result_R1) { error("QUERY_ERROR"); exit; }

		for($r = 0; $r < $total_RC; $r++) {
			$r_uid = mysql_result($result_R1,$r,0);
			$r_unit_name = mysql_result($result_R1,$r,1);
			
			$check_org_uid = "check_$r_uid";
			$check_uid = ${$check_org_uid};
			
			$check2_org_uid = "check2_$r_uid";
			$check2_uid = ${$check2_org_uid};
						
			$qty2_org_uid = "qty2_$r_uid";
			$qty2_uid = ${$qty2_org_uid};
			
			$name_org_uid = "name_$r_uid";
			$name_uid = ${$name_org_uid};
        
		
			// check item unit
			$scu_query = "SELECT count(uid) FROM shop_product_catg_unit WHERE uid = '$check2_uid' AND gcode = '$new_chg_gcode'";
			$scu_result = mysql_query($scu_query,$dbconn);
				if (!$scu_result) { error("QUERY_ERROR"); exit; }
			$unit_count = @mysql_result($scu_result,0,0);
			
			if($unit_count > 0) {
				$result_uup = mysql_query("UPDATE shop_product_catg_unit SET gcode = '$new_chg_gcode', unit_name = '$r_unit_name', unit_qty = '$qty2_uid'
                        WHERE uid = '$check2_uid' AND gcode = '$new_chg_gcode'",$dbconn);
				if(!$result_uup) { error("QUERY_ERROR"); exit; }
			} else {
				$query_upo = "INSERT INTO shop_product_catg_unit (uid,catg_uid,branch_code,gcode,unit_name,unit_qty) values 
						('','$check_uid','$login_branch','$new_chg_gcode','$r_unit_name','$qty2_uid')";
				$result_upo = mysql_query($query_upo);
				if (!$result_upo) { error("QUERY_ERROR"); exit; }
			}
		
		
		}
	

    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=upd_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_catg_uid&page=$page'>");
    exit;


  } else if($add_mode == "CATG") {
  
    // 지사 코드 추출
    $br_query = "SELECT branch_code FROM client WHERE client_id = '$new_client' ORDER BY uid DESC";
    $br_result = mysql_query($br_query);
    if (!$br_result) { error("QUERY_ERROR"); exit; }
    $br_branch_code = @mysql_result($br_result,0,0);

    // 상품 품목 입력
    $query_M2 = "INSERT INTO shop_product_catg (uid,branch_code,gate,catg_code,pcode,pname,post_date,
          p_opt_name1,p_opt_name2,p_opt_name3,p_opt_name4,p_opt_name5,p_option1,p_option2,p_option3,p_option4,p_option5,org_pcode,org_barcode,unit) 
          values ('','$login_branch','$new_client','$s_cat_code','$new_prd_code','$new_prd_name','$post_dates',
          '$p_opt_name1','$p_opt_name2','$p_opt_name3','$p_opt_name4','$p_opt_name5','$p_option1','$p_option2',
          '$p_option3','$p_option4','$p_option5','$org_pcode','$org_barcode','$new_unit')";
    $result_M2 = mysql_query($query_M2);
    if (!$result_M2) { error("QUERY_ERROR"); exit; }

	
		// Product Unit -- IMPORTANT !!
	
		$query_RC = "SELECT count(uid) FROM shop_product_unit";
		$result_RC = mysql_query($query_RC,$dbconn);
		if (!$result_RC) { error("QUERY_ERROR"); exit; }
      
		$total_RC = @mysql_result($result_RC,0,0);
      
		$query_R1 = "SELECT uid,unit_name FROM shop_product_unit ORDER BY uid ASC";
		$result_R1 = mysql_query($query_R1,$dbconn);
		if (!$result_R1) { error("QUERY_ERROR"); exit; }

		for($r = 0; $r < $total_RC; $r++) {
			$r_uid = mysql_result($result_R1,$r,0);
			$r_unit_name = mysql_result($result_R1,$r,1);
			
			$check_org_uid = "check_$r_uid";
			$check_uid = ${$check_org_uid};
						
			$qty_org_uid = "qty_$r_uid";
			$qty_uid = ${$qty_org_uid};
			
			$name_org_uid = "name_$r_uid";
			$name_uid = ${$name_org_uid};
        
		
			// check item unit
			$scu_query = "SELECT count(uid) FROM shop_product_catg_unit WHERE catg_uid = '$check_uid' AND gcode = '$new_prd_code'";
			$scu_result = mysql_query($scu_query,$dbconn);
				if (!$scu_result) { error("QUERY_ERROR"); exit; }
			$unit_count = @mysql_result($scu_result,0,0);
			
			if($unit_count > 0) {
				$result_uup = mysql_query("UPDATE shop_product_catg_unit SET gcode = '$new_prd_code', unit_name = '$r_unit_name', unit_qty = '$qty_uid'
                        WHERE catg_uid = '$check_uid'",$dbconn);
				if(!$result_uup) { error("QUERY_ERROR"); exit; }
			} else {
				$query_upo = "INSERT INTO shop_product_catg_unit (uid,catg_uid,branch_code,gcode,unit_name,unit_qty) values 
						('','$check_uid','$login_branch','$new_prd_code','$r_unit_name','$qty_uid')";
				$result_upo = mysql_query($query_upo);
				if (!$result_upo) { error("QUERY_ERROR"); exit; }
			}
		
		
		}
	

    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;
  
  }



} else if($step_next == "permit_qty") { // 수량 하위테이블 개별정보 수정

    $query_GM2 = "UPDATE shop_product_list_qty SET stock = '$qs_stock', price_orgin = '$qs_price_orgin' WHERE uid = '$qs_uid'";
    $result_GM2 = mysql_query($query_GM2);
    if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    
    // 카트 정보 변경
    if($qs_flag == "S") {
      $query_GM3 = "UPDATE shop_cart SET qty = '$qs_stock' WHERE uid = '$qs_cart_uid' AND expire = '1'";
      $result_GM3 = mysql_query($query_GM3);
      if (!$result_GM3) { error("QUERY_ERROR"); exit; }
    }
    
    // shop_purchase 정보 변경
    
    
    
    // 결제정보 변경(shop_payment, finance) - 수량, 원가, 판매총액, 결제일 등
    if($qs_flag == "S") {
      $query_GM4 = "UPDATE shop_payment SET qty = '$qs_stock', pay_amount = '$qs_pay_amount' 
                    WHERE uid = '$qs_pay_uid'";
      $result_GM4 = mysql_query($query_GM4);
      if (!$result_GM4) { error("QUERY_ERROR"); exit; }
      
      $query_GM5 = "UPDATE finance SET qty = '$qs_stock', amount = '$qs_pay_amount' 
                    WHERE pay_num = '$qs_pay_num'";
      $result_GM5 = mysql_query($query_GM5);
      if (!$result_GM5) { error("QUERY_ERROR"); exit; }
    }
    
    
    // 상품정보 수정(shop_product_list) - 입고수량, 판매수량, 현재재고 -------------------------//
    
    // [1] shop_product_list_shop의 shop 미지정 재고 정보 출력
    $sh1_query = "SELECT pcode,qty_org,qty_sell,qty_now,price_orgin,price_sale,price_sale2 FROM shop_product_list_shop 
                  WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
    $sh1_result = mysql_query($sh1_query);
      if (!$sh1_result) { error("QUERY_ERROR"); exit; }
    $sh1_pcode = @mysql_result($sh1_result,0,0);
    $sh1_qty_org = @mysql_result($sh1_result,0,1);
    $sh1_qty_sell = @mysql_result($sh1_result,0,2);
    $sh1_qty_now = @mysql_result($sh1_result,0,3);
    $sh1_price_orgin = @mysql_result($sh1_result,0,4);
    $sh1_price_sale = @mysql_result($sh1_result,0,5);
    $sh1_price_sale2 = @mysql_result($sh1_result,0,6);
    
    
    // [2] shop_product_list_qty에서 in/out별로 수량 정보 합계
    $sh21_query = "SELECT sum(stock) FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'in' ORDER BY uid DESC";
    $sh21_result = mysql_query($sh21_query);
      if (!$sh21_result) { error("QUERY_ERROR"); exit; }
    $sh21_sum_qty_buy = @mysql_result($sh21_result,0,0);

    $sh22_query = "SELECT sum(stock) FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'out' ORDER BY uid DESC";
    $sh22_result = mysql_query($sh22_query);
      if (!$sh22_result) { error("QUERY_ERROR"); exit; }
    $sh22_sum_qty_sell = @mysql_result($sh22_result,0,0);
    
    $sh2_sum_qty = $sh21_sum_qty_buy - $sh22_sum_qty_sell;
    
    
    // [3] shop_product_list의 재고 정보 수정
    $query_sh3 = "UPDATE shop_product_list SET stock_org = '$sh21_sum_qty_buy', stock_now = '$sh2_sum_qty' 
                  WHERE pcode = '$qs_pcode'";
    $result_sh3 = mysql_query($query_sh3);
    if (!$result_sh3) { error("QUERY_ERROR"); exit; }
    
    
    // [4] shop_product_list_shop의 shop 미지정 재고 증감 계산
    $sh4_query = "SELECT sum(qty_org),sum(qty_now) FROM shop_product_list_shop 
                  WHERE branch_code = '$login_branch' AND shop_code != '' ORDER BY uid DESC";
    $sh4_result = mysql_query($sh4_query);
      if (!$sh4_result) { error("QUERY_ERROR"); exit; }

    $sh4_sum_qty_org = @mysql_result($sh4_result,0,0);
    $sh4_sum_qty_now = @mysql_result($sh4_result,0,1);
    
    
    $sh4_sum_qty_org_new = $sh21_sum_qty_buy - $sh4_sum_qty_org;
    $sh4_sum_qty_now_new = $sh2_sum_qty - $sh4_sum_qty_now;
    
    
    // [5] shop_product_list_shop의 shop 미지정 재고 정보 수정
    $query_sh5 = "UPDATE shop_product_list_shop SET stock_org = '$sh4_sum_qty_org_new', stock_now = '$sh4_sum_qty_now_new' 
                  WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
    $result_sh3 = mysql_query($query_sh3);
    if (!$result_sh3) { error("QUERY_ERROR"); exit; }


echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page&catg=$catg&view=qty'>");
exit;



} else if($step_next == "permit_qty_del") { // 수량 하위테이블 개별정보 삭제

    $query_GM2 = "DELETE FROM shop_product_list_qty WHERE uid = '$qs_uid'";
    $result_GM2 = mysql_query($query_GM2);
    if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    
    // 카트 정보 삭제
    if($qs_flag == "S") {
      $query_GM3 = "DELETE FROM shop_cart WHERE uid = '$qs_cart_uid' AND expire = '1'";
      $result_GM3 = mysql_query($query_GM3);
      if (!$result_GM3) { error("QUERY_ERROR"); exit; }
    }
    
    // shop_purchase 정보 변경
    
    
    
    // 결제정보 삭제(shop_payment, finance) - 수량, 원가, 판매총액, 결제일 등
    if($qs_flag == "S") {
      $query_GM4 = "DELETE FROM shop_payment WHERE uid = '$qs_pay_uid'";
      $result_GM4 = mysql_query($query_GM4);
      if (!$result_GM4) { error("QUERY_ERROR"); exit; }
      
      $query_GM5 = "DELETE FROM finance WHERE pay_num = '$qs_pay_num'";
      $result_GM5 = mysql_query($query_GM5);
      if (!$result_GM5) { error("QUERY_ERROR"); exit; }
    }
    
    
    // 상품정보 수정(shop_product_list) - 입고수량, 판매수량, 현재재고 -------------------------//
    
    // [1] shop_product_list_shop의 shop 미지정 재고 정보 출력
    $sh1_query = "SELECT pcode,qty_org,qty_sell,qty_now,price_orgin,price_sale,price_sale2 FROM shop_product_list_shop 
                  WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
    $sh1_result = mysql_query($sh1_query);
      if (!$sh1_result) { error("QUERY_ERROR"); exit; }
    $sh1_pcode = @mysql_result($sh1_result,0,0);
    $sh1_qty_org = @mysql_result($sh1_result,0,1);
    $sh1_qty_sell = @mysql_result($sh1_result,0,2);
    $sh1_qty_now = @mysql_result($sh1_result,0,3);
    $sh1_price_orgin = @mysql_result($sh1_result,0,4);
    $sh1_price_sale = @mysql_result($sh1_result,0,5);
    $sh1_price_sale2 = @mysql_result($sh1_result,0,6);
    
    
    // [2] shop_product_list_qty에서 in/out별로 수량 정보 합계
    $sh21_query = "SELECT sum(stock) FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'in' ORDER BY uid DESC";
    $sh21_result = mysql_query($sh21_query);
      if (!$sh21_result) { error("QUERY_ERROR"); exit; }
    $sh21_sum_qty_buy = @mysql_result($sh21_result,0,0);

    $sh22_query = "SELECT sum(stock) FROM shop_product_list_qty 
                  WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'out' ORDER BY uid DESC";
    $sh22_result = mysql_query($sh22_query);
      if (!$sh22_result) { error("QUERY_ERROR"); exit; }
    $sh22_sum_qty_sell = @mysql_result($sh22_result,0,0);
    
    $sh2_sum_qty = $sh21_sum_qty_buy - $sh22_sum_qty_sell;
    
    
    // [3] shop_product_list의 재고 정보 수정
    $query_sh3 = "UPDATE shop_product_list SET stock_org = '$sh21_sum_qty_buy', stock_now = '$sh2_sum_qty' 
                  WHERE pcode = '$qs_pcode'";
    $result_sh3 = mysql_query($query_sh3);
    if (!$result_sh3) { error("QUERY_ERROR"); exit; }
    
    
    // [4] shop_product_list_shop의 shop 미지정 재고 증감 계산
    $sh4_query = "SELECT sum(qty_org),sum(qty_now) FROM shop_product_list_shop 
                  WHERE branch_code = '$login_branch' AND shop_code != '' ORDER BY uid DESC";
    $sh4_result = mysql_query($sh4_query);
      if (!$sh4_result) { error("QUERY_ERROR"); exit; }

    $sh4_sum_qty_org = @mysql_result($sh4_result,0,0);
    $sh4_sum_qty_now = @mysql_result($sh4_result,0,1);
    
    
    $sh4_sum_qty_org_new = $sh21_sum_qty_buy - $sh4_sum_qty_org;
    $sh4_sum_qty_now_new = $sh2_sum_qty - $sh4_sum_qty_now;
    
    
    // [5] shop_product_list_shop의 shop 미지정 재고 정보 수정
    $query_sh5 = "UPDATE shop_product_list_shop SET stock_org = '$sh4_sum_qty_org_new', stock_now = '$sh4_sum_qty_now_new' 
                  WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
    $result_sh3 = mysql_query($query_sh3);
    if (!$result_sh3) { error("QUERY_ERROR"); exit; }


echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page&catg=$catg&view=qty'>");
exit;
}

}
?>