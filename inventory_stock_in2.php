<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_stock_in2";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_stock_in2.php?sorting_key=$sorting_key";
$link_list_action = "$home/inventory_stock_in2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_post = "$home/inventory_stock_in2.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_del = "process_stock_del.php?mode=del&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
// Filtering
$sorting_filter = "branch_code = '$login_branch'";
$sorting_filter_G = "branch_code = '$login_branch' AND client_id = '$login_gate'";


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "post_date"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pname") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "org_pcode") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "org_barcode") { $chk4 = "selected"; } else { $chk4 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_list";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_list WHERE $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_04_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_stock_in2.php'>
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
			
			<form name='search' method='post' action='inventory_stock_in2.php'>
			<input type='hidden' name='keyfield' value='pname'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_invn_stockin_05'> 
			</div>
			</form>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=org_pcode&keyfield=$keyfield&key=$key' $chk3>Original Code</option>
			<option value='$PHP_SELF?sorting_key=org_barcode&keyfield=$keyfield&key=$key' $chk4>Original Barcode</option>
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
            <th>Original Code</th>
            <th><?=$txt_invn_stockin_06?></th>
			<th><?=$txt_invn_stockin_05?></th>
			<th><?=$txt_invn_stockin_31?></th>
			<th><?=$txt_invn_stockin_32s?></th>
			<th colspan=2><?=$txt_invn_stockin_33?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// 검색된 입고/출고/재고 합계
$query_tsm1 = "SELECT sum(qty_org),sum(qty_sell) FROM shop_product_list_shop WHERE shop_code = '$login_shop'";
$result_tsm1 = mysql_query($query_tsm1);
if (!$result_tsm1) { error("QUERY_ERROR"); exit; }

$prd_tsm_qty_in = @mysql_result($result_tsm1,0,0);
 $prd_tsm_qty_in_K = number_format($prd_tsm_qty_in);
$prd_tsm_qty_out = @mysql_result($result_tsm1,0,1);
 $prd_tsm_qty_out_K = number_format($prd_tsm_qty_out);

$prd_tsm_qty_now = $prd_tsm_qty_in - $prd_tsm_qty_out;
 $prd_tsm_qty_now_K = number_format($prd_tsm_qty_now);

 // Loss
$query_tsm2 = "SELECT sum(stock_loss) FROM shop_product_list_qty WHERE (flag = 'out' AND shop_code = '$login_shop') 
			OR (flag = 'out' AND shop_code2 = '$login_shop')";
$result_tsm2 = mysql_query($query_tsm2);
if (!$result_tsm2) { error("QUERY_ERROR"); exit; }

$prd_tsm_qty_loss = @mysql_result($result_tsm2,0,0);
 $prd_tsm_qty_loss_K = number_format($prd_tsm_qty_loss);

// Final Stock Now
$prd_tsm_qty_now2 = $prd_tsm_qty_now - $prd_tsm_qty_loss;
 $prd_tsm_qty_now2_K = number_format($prd_tsm_qty_now2);
 

echo ("
<tr height=22>
   <td colspan=4 align=right><b>Total</b></td>
   <td align=right>{$prd_tsm_qty_in_K}</td>
   <td align=right>{$prd_tsm_qty_out_K}</td>
   <td colspan=2 align=right>{$prd_tsm_qty_now2_K}</td>
</tr>
");



$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gudang_code,catg_code,pcode,pname,price_orgin,stock_org,supp_code,shop_code,org_pcode,org_barcode
      FROM shop_product_list ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gudang_code,catg_code,pcode,pname,price_orgin,stock_org,supp_code,shop_code,org_pcode,org_barcode
      FROM shop_product_list WHERE $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_gudang_code = mysql_result($result,$i,1);
   $prd_catg = mysql_result($result,$i,2);
   $prd_code = mysql_result($result,$i,3);
   $prd_name = mysql_result($result,$i,4);
   $prd_price_orgin = mysql_result($result,$i,5);
      $prd_price_orgin_K = number_format($prd_price_orgin);
   $prd_qty = mysql_result($result,$i,6);
      $prd_qty_K = number_format($prd_qty);
   $H_supp_code = mysql_result($result,$i,7);
   $H_shop_code = mysql_result($result,$i,8);
   $H_org_pcode = mysql_result($result,$i,9);
   $H_org_barcode = mysql_result($result,$i,10);

        
    // 해당 상품코드의 수량 추출 [입고]
    $query_sub1 = "SELECT sum(qty_org),sum(qty_sell),sum(qty_now) FROM shop_product_list_shop WHERE pcode = '$prd_code' AND shop_code = '$login_shop'";
    $result_sub1 = mysql_query($query_sub1);
   
    $sum_qty_in = @mysql_result($result_sub1,0,0);
        $sum_qty_in_K = number_format($sum_qty_in);
	$sum_qty_sell = @mysql_result($result_sub1,0,1);
        $sum_qty_sell_K = number_format($sum_qty_sell);
	$sum_qty_now = @mysql_result($result_sub1,0,2);
        $sum_qty_now_K = number_format($sum_qty_now);

    // 해당 상품코드의 수량 추출 [판매]
    $query_sub2 = "SELECT sum(stock_loss) FROM shop_product_list_qty WHERE pcode = '$prd_code' AND shop_code2 = '$login_shop' AND virtual = '0'";
    $result_sub2 = mysql_query($query_sub2);
 
	$sum_qty_loss = @mysql_result($result_sub2,0,0);
    $sum_qty_loss_K = number_format($sum_qty_loss);
	$sum_qty_loss2 = abs($sum_qty_loss); // Remove Minus
	$sum_qty_loss2_K = number_format($sum_qty_loss2);
		
		if($sum_qty_loss > 0) {
			$sum_qty_loss_txt = "<font color=red>- "."$sum_qty_loss_K"."</font>";
		} else if($sum_qty_loss < 0) {
			$sum_qty_loss_txt = "<font color=blue>+ "."$sum_qty_loss2_K"."</font>";
		} else {
			$sum_qty_loss_txt = "$sum_qty_loss_K";
		}
    
    // 해당 상품코드의 수량 추출 [재고]
    $sum_qty_now2 = $sum_qty_now - $sum_qty_loss;
        $sum_qty_now2_K = number_format($sum_qty_now2);
		
	



    // 줄 색깔
    if($uid == $prd_uid AND ( $mode == "upd" OR $mode == "del" OR $mode == "post" )) {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    // 하위 수량 테이블 링크
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$prd_code' AND flag = 'out' AND shop_code2 = '$login_shop'";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
    if($view == "qty" AND $prd_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
      $H_prd_qty_link1 = "<i class='fa fa-caret-down'></i> <a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_in_K</a>";
	  $H_prd_qty_link2 = "<a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_sell_K</a>";
    } else {
      $H_prd_qty_link1 = "<a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_in_K</a>";
	  $H_prd_qty_link2 = "<a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_sell_K</a>";
    }

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>$H_org_pcode</td>");
  echo("<td bgcolor='$highlight_color'>$prd_code</td>");
  // if($sum_qty_now > '0') {
    echo("<td bgcolor='$highlight_color'><a href='$link_post&uid=$prd_uid'>{$prd_name}</a></td>");
  // } else {
  //   echo("<td bgcolor='$highlight_color'>{$prd_name}</td>");
  // }
  echo("<td bgcolor='$highlight_color' align=right>{$H_prd_qty_link1}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$H_prd_qty_link2}</td>");
  
  if($sum_qty_now > '0') {
	echo ("<td bgcolor='$highlight_color' align=right><i class='fa fa-chevron-left'></i></td>");
	echo ("<td bgcolor='$highlight_color' align=right><a href='$link_post&uid=$prd_uid'>{$sum_qty_now2_K}</a></td>");
  } else {
	echo ("<td bgcolor='$highlight_color' align=right>&nbsp;</td>");
	echo ("<td bgcolor='$highlight_color' align=right>{$sum_qty_now2_K}</td>");
  }
      
  echo("</tr>");


  
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $uid == "$prd_uid") {
    
        $query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,branch_code,stock_check,stock_loss,check_date  
                      FROM shop_product_list_qty WHERE pcode = '$prd_code' AND flag = 'out' AND shop_code2 = '$login_shop' 
					  ORDER BY check_date DESC, date DESC";
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
		  $qs_branch_code = mysql_result($result_qs2,$qs,9);
		  $qs_stock_check = mysql_result($result_qs2,$qs,10);
			$qs_stock_check_K = number_format($qs_stock_check);
		  $qs_stock_loss = mysql_result($result_qs2,$qs,11);
		    $qs_stock_loss_K = number_format($qs_stock_loss);
			
			$qs_stock_loss2 = abs($qs_stock_loss); // Remove Minus
			$qs_stock_loss2_K = number_format($qs_stock_loss2);
		
			if($qs_stock_loss > 0) {
				$qs_stock_loss_txt = "<font color=red>- "."$qs_stock_loss_K"."</font>";
			} else if($sum_qty_loss < 0) {
				$qs_stock_loss_txt = "<font color=blue>+ "."$qs_stock_loss2_K"."</font>";
			} else {
				$qs_stock_loss_txt = "$qs_stock_loss_K";
			}
			
		  $qs_stock_remain = $qs_stock_check - $qs_stock_loss;
		
		
		  $qs_dateB = mysql_result($result_qs2,$qs,12);
          
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
		
			$qdayB1 = substr($qs_dateB,0,4);
	        $qdayB2 = substr($qs_dateB,4,2);
	        $qdayB3 = substr($qs_dateB,6,2);
	        $qdayB4 = substr($qs_dateB,8,2);
	        $qdayB5 = substr($qs_dateB,10,2);
	        $qdayB6 = substr($qs_dateB,12,2);

			if($lang == "ko") {
	          $qs_dateB_txt = "$qdayB1"."/"."$qdayB2"."/"."$qdayB3".", "."$qdayB4".":"."$qdayB5".":"."$qdayB6";
	        } else {
	          $qs_dateB_txt = "$qdayB3"."-"."$qdayB2"."-"."$qdayB1".", "."$qdayB4".":"."$qdayB5".":"."$qdayB6";
	        }
		
		  if($qs_dateB > 1) {
			$qs_dateF_txt = "<font color=blue>$qs_dateB_txt</font>";
		  } else {
		    $qs_dateF_txt = "$qs_date_txt";
		  }
          
          // 상품 구입가격 [원가] ★
          $query_qsp = "SELECT price_orgin FROM shop_product_list WHERE uid = '$qs_org_uid'";
          $result_qsp = mysql_query($query_qsp,$dbconn);
          if (!$result_qsp) { error("QUERY_ERROR"); exit; }   
          
          $qs_price_orgin = @mysql_result($result_qsp,0,0);
          $qs_price_orgin_K = number_format($qs_price_orgin);
          
          $qs_tprice_orgin = $qs_price_orgin * $qs_stock;
          $qs_tprice_orgin_K = number_format($qs_tprice_orgin);
          
          // BUY/SELL FLAG
          if($qs_flag == "in") {
            $qs_flag_txt = "<font color=green>SOLD (-)</font>";
          } else if($qs_flag == "out") {
            $qs_flag_txt = "<font color=blue>IN (+)</font>";
          } else {
            $qs_flag_txt = "<font color=red>?</font>";
          }
          
          // Branch 이름 추출
          $query_qs6 = "SELECT branch_name FROM client_branch WHERE branch_code = '$qs_branch_code'";
          $result_qs6 = mysql_query($query_qs6,$dbconn);
          if (!$result_qs6) { error("QUERY_ERROR"); exit; }   
          
          $qs_branch_name = @mysql_result($result_qs6,0,0);
		  
		  if($qs_branch_code != $login_branch) {
			$qs_branch_name_txt = "<font color=red>[$qs_branch_code] $qs_branch_name</font>&nbsp;&nbsp;";
		  } else {
		    $qs_branch_name_txt = "";
		  }
          
          if($qs_uid == $qty_uid) {
            $qs_uid_font_color = "red";
          } else {
            $qs_uid_font_color = "blue";
          }
          
          echo ("
          <tr height=22>
            <form name='qs_signform' method='post' action='inventory_stock_in2.php'>
            <input type='hidden' name='step_next' value='permit_qty'>
            <input type='hidden' name='sorting_table' value='$sorting_table'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='page' value='$page'>
            <input type='hidden' name='catg' value='$catg'>
            <input type='hidden' name='new_uid' value='$prd_uid'>
            <input type='hidden' name='qs_uid' value='$qs_uid'>
            <input type='hidden' name='qs_flag' value='$qs_flag'>
            <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
            <input type='hidden' name='qs_pcode' value='$prd_code'>
            <input type='hidden' name='qs_price_orgin' value='$qs_price_orgin'>
            <input type='hidden' name='qs_org_stock' value='$qs_stock'>
            <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>
            
            
            <td>&nbsp;</td>
            <td>$qs_flag_txt</td>

            <td colspan=2>
				{$qs_branch_name_txt}$qs_dateF_txt &nbsp;&nbsp; 
				/ $qs_price_orgin_K x $qs_stock = $qs_tprice_orgin_K
			</td>");
            
            // 각 총출고
            if($qs_flag == "in") { 
			  echo ("<td>&nbsp;</td>");
              echo ("<td align=right><font color=green>-</font>&nbsp; $qs_stock</td>");
            } else {
              echo ("<td align=right><font color=blue>+</font>&nbsp; $qs_stock</td>");
			  echo ("<td>&nbsp;</td>");
            }
            
            // if($qs_stock_loss > 0) {
				echo ("<td align=right>$qs_stock_loss_txt</td>");
			// } else {
			// 	echo ("<td align=right>&nbsp;</td>");
			// }
			echo ("
            </form>
                  
            
            <form name='qs_signform' method='post' action='inventory_stock_in2.php'>
                  <input type='hidden' name='step_next' value='permit_qty_del'>
                  <input type='hidden' name='sorting_table' value='$sorting_table'>
                  <input type='hidden' name='sorting_key' value='$sorting_key'>
                  <input type='hidden' name='keyfield' value='$keyfield'>
                  <input type='hidden' name='key' value='$key'>
                  <input type='hidden' name='page' value='$page'>
                  <input type='hidden' name='catg' value='$catg'>
                  <input type='hidden' name='new_uid' value='$prd_uid'>
                  <input type='hidden' name='qs_uid' value='$qs_uid'>
                  <input type='hidden' name='qs_flag' value='$qs_flag'>
                  <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
                  <input type='hidden' name='qs_pcode' value='$prd_code'>
                  <input type='hidden' name='qs_stock' value='$qs_stock'>
                  <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>
            <td align=center>&nbsp;</td>
            </form>
          </tr>");
            
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
		
	
		


		
		
		
		

		<? if($mode == "post" AND $uid) { ?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_01?>
			
            
        </header>
		
        <div class="panel-body">
			
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action="inventory_stock_in2.php">
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		  <?
		  $query_upd = "SELECT uid,supp_code,shop_code,branch_code,gudang_code,catg_code,gcode,pcode,pname,
                        price_orgin,price_market,price_sale,stock_org,catg_uid,org_pcode,org_barcode FROM shop_product_list WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_supp_code = $row_upd->supp_code;
          $upd_shop_code = $row_upd->shop_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_catg_code = $row_upd->catg_code;
          $upd_gcode = $row_upd->gcode;
          $upd_pcode = $row_upd->pcode;
          $upd_pname = $row_upd->pname;
          $upd_price_orgin = $row_upd->price_orgin;
			$upd_price_orgin_K = number_format($upd_price_orgin);
          $upd_price_market = $row_upd->price_market;
			$upd_price_market_K = number_format($upd_price_market);
          $upd_price_sale = $row_upd->price_sale;
			$upd_price_sale_K = number_format($upd_price_sale);
          $upd_stock_org = $row_upd->stock_org;
			$upd_stock_org_K = number_format($upd_stock_org);
          $upd_catg_uid = $row_upd->catg_uid;
		  $upd_org_pcode = $row_upd->org_pcode;
		  $upd_org_barcode = $row_upd->org_barcode;
          
          // 입고 합계
          $query_sumQ1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE org_uid = '$upd_uid' AND flag = 'in'";
          $result_sumQ1 = mysql_query($query_sumQ1);
            if (!$result_sumQ1) { error("QUERY_ERROR"); exit; }
          $this_qty_in = @mysql_result($result_sumQ1,0,0);
          
          // 출고 합계
          $query_sumQ2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE org_uid = '$upd_uid' AND flag = 'out'";
          $result_sumQ2 = mysql_query($query_sumQ2);
            if (!$result_sumQ2) { error("QUERY_ERROR"); exit; }
          $this_qty_out = @mysql_result($result_sumQ2,0,0);
			$this_qty_out_K = number_format($this_qty_out);
          
          // 남은 재고 합계
          $this_qty_now = $this_qty_in - $this_qty_out;
			$this_qty_now_K = number_format($this_qty_now);
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_QTY'>
      <input type=hidden name='old_branch_code' value='$upd_branch_code'>
	  <input type=hidden name='old_gudang_code' value='$upd_gudang_code'>
	  <input type=hidden name='old_supp_code' value='$upd_supp_code'>
	  <input type=hidden name='old_shop_code' value='$upd_shop_code'>
      <input type=hidden name='new_uid' value='$upd_uid'>
      <input type=hidden name='new_qty_uid' value='$qty_uid'>
      <input type=hidden name='new_catg_uid' value='$upd_catg_uid'>
      <input type=hidden name='new_gcode' value='$upd_gcode'>
      <input type=hidden name='new_pcode' value='$upd_pcode'>
      <input type=hidden name='new_price_orgin' value='$upd_price_orgin'>
      <input type=hidden name='new_price_sale' value='$upd_price_sale'>
      <input type=hidden name='old_stock_org' value='$upd_stock_org'>
      <input type=hidden name='old_stock_org_qty' value='$rm2_this_stock'>");
	  ?>
	    
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_05?></label>
										<div class="col-sm-3">
											<input <?=$catg_disableA?> class="form-control" name="dis_gudang_code" value="<?=$upd_gudang_code?>" type="text" />
										</div>
										<div class="col-sm-2" align=right><?=$txt_invn_stockin_06?></div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Original Code</label>
										<div class="col-sm-3">
											<input <?=$catg_disableA?> class="form-control" name="dis_org_pcode" value="<?=$upd_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-2" align=right>Original Barcode</div>
										<div class="col-sm-4">
											<input <?=$catg_disableA?> class="form-control" name="dis_org_barcode" value="<?=$upd_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
										<div class="col-sm-9">
											<img src="include/_barcode/html/image.php?code=code39&o=1&dpi=72&t=30&r=2&rot=0&text=<?=$upd_pcode?>&f1=Arial.ttf&f2=8&a1=&a2=&a3=" border=0>
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
              
												echo("<option value='$supp_code' $supp_slct>[$supp_code] $supp_name</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									
									<?
									// Product Name, Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_05</label>
                                        <div class='col-sm-9'>
											<input style='text' class='form-control' name='new_prd_name' value='$upd_pname'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_09</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_orgin' value='$upd_price_orgin_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_10</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_market' value='$upd_price_market_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_12</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_sale' value='$upd_price_sale_K' style='text-align: right'>
										</div>
                                    </div>
									
									
									
									
									<!--------- select corporate & warehouse // ----------------------------------------------------->
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_comm_frm23</label>
                                        <div class='col-sm-4'>");
											$query_brc = "SELECT count(uid) FROM client_branch WHERE userlevel > '0' AND userlevel < '5'";
											$result_brc = mysql_query($query_brc);
											$total_record_br = @mysql_result($result_brc,0,0);

											$query_br = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' AND userlevel < '5' ORDER BY branch_code ASC";
											$result_br = mysql_query($query_br);

											echo("<select name='new_branch_code' class='form-control' required>");
											// echo("<option value=\"\">:: $txt_comm_frm32</option>");

											for($br = 0; $br < $total_record_br; $br++) {
												$br_menu_code = mysql_result($result_br,$br,0);
												$br_menu_name = mysql_result($result_br,$br,1);
        
												if($br_menu_code == $upd_branch_code) {
													$sx_tag = "";
												} else {
													$sx_tag = "+ [SX]";
												}
												
												if($br_menu_code == $login_branch) {
													$br_slc_gate = "selected";
													$br_slc_dis = "";
												} else {
													$br_slc_gate = "";
													$br_slc_dis = "disabled";
												}

												echo("<option $br_slc_dis value='$br_menu_code' $br_slc_gate>[ $br_menu_code ] $br_menu_name $sx_tag</option>");
											}
											echo("</select>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_comm_frm24</label>
                                        <div class='col-sm-4'>");
											$query_gtc = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$login_branch' AND userlevel > '0'";
											$result_gtc = mysql_query($query_gtc);
											$total_record_gt = @mysql_result($result_gtc,0,0);

											$query_gt = "SELECT gudang_code,gudang_name FROM code_gudang 
														WHERE branch_code = '$login_branch' AND userlevel > '0' ORDER BY gudang_code ASC";
											$result_gt = mysql_query($query_gt);

											echo("<select name='new_gudang_code' class='form-control' required>");

											for($gt = 0; $gt < $total_record_gt; $gt++) {
												$gt_menu_code = mysql_result($result_gt,$gt,0);
												$gt_menu_name = mysql_result($result_gt,$gt,1);
        
												if($gt_menu_code == $upd_gudang_code) {
													$gt_slc_gate = "selected";
													$gt_slc_dis = "";
												} else {
													$gt_slc_gate = "";
													$gt_slc_dis = "disabled";
												}

												echo("<option $gt_slc_dis value='$gt_menu_code' $gt_slc_gate>[ $gt_menu_code ] $gt_menu_name</option>");
											}
											echo("</select>
											
											
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<select name='new_stock_qty' class='form-control'>");
											for($q = 1; $q <= $this_qty_now; $q++) {
												echo("<option value='$q'>$q</option>");
											}
              
											echo ("
											</select>
										</div>
										<div class='col-sm-7'>
											 / $this_qty_now_K ($upd_stock_org_K)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<input type=checkbox name='return' value='1'> <font color=red>$txt_invn_stockout_03</font>-->
										</div>
                                    </div>");
									
									
									
									// Stock-out Not Available when no sale price
									if($upd_price_sale < '1') {
										$stock_output_disable = "disabled";
									} else {
										$stock_output_disable = "";
									}
            
             
									// Condition for only INVENTORY MANAGER that Stock Out to SHOP
									if($this_qty_now < 1){
										$btnDisabled = "disabled";
									} else {
										$btnDisabled = "";
									}
			
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input $btnDisabled class='btn btn-primary' type='submit' value='$txt_invn_stockout_02'>
										</div>
                                    </div>");
									?>
		
		
		
		
		
		</form>

			
		</div>
		</section>
		</div>
		</div>

		<? } ?>


		
		
		

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
  
	  
	// DO Number
	$exp_br_code = explode("_",$login_branch);
	$exp_branch_code = $exp_br_code[1];
  
	$new_do_num = "SJ-"."$exp_branch_code"."-"."$post_dates";
	
	// SX - Sales-Data eXchange
	$new_sx_num = "SX-"."$exp_branch_code"."-"."$post_dates";
	
	
	// 다른 회사[지사]로 Stock 이동시 목적지 창고나 상점 데이터 (_do, _qty)에는 출발지 정보가 입력되어야 함
	// Warehouse ("$new_gudang_code" from "$key_gt")
	// 즉, branch_code2, gudang_code2, shop_code2에 출발지 정보 입력
	
	
	if($new_branch_code == $old_branch_code) {
		$new_branch_code2 = "";
		$new_gudang_code2 = "";
		$new_sx_num2 = ""; // IMPORTANT !
	} else {
		$new_branch_code2 = $new_branch_code;
		$new_gudang_code2 = $new_gudang_code;
		$new_sx_num2 = $new_sx_num; // IMPORTANT !
	}
	
	$new_shop_code = $login_shop; // IMPORTANT !
	
	if($new_shop_code != "" AND $new_shop_code != "cancel") {
		$new_shop_code2 = $new_shop_code;
	} else {
		$new_shop_code2 = "";
	}
	
	

  
  
  // 상품 수정
  if($add_mode == "LIST_CHG") { // 분할출고시 새로운 상품코드 생성
  
    // 출고 취소의 경우
    // if($new_shop_code == "cancel") {
    //   $new_shop_code2 = "";
    // } else {
    //   $new_shop_code2 = $new_shop_code;
    // }
    
    // 출고 후 남은 재고로 상품정보 변경
    $remain_qty = $old_stock_org - $new_stock_org;
    

    // 분할 출고된 새로운 상품코드 생성
    
    
    
    // 출고 정보 수정 (출고 형식 - 0:전체 출고, 1:분할 출고 / 출고 상태 - 0:미출고, 1:일부 출고, 2:출고 완료)
    $query_sumQ4 = "SELECT sum(this_stock) FROM shop_product_list_qty WHERE org_uid = '$new_uid'";
    $result_sumQ4 = mysql_query($query_sumQ4);
      if (!$result_sumQ4) { error("QUERY_ERROR"); exit; }
    $t_this_qty4 = @mysql_result($result_sumQ4,0,0);
    
    $rm2_query = "SELECT uid,org_stock,this_stock FROM shop_product_list_qty WHERE org_uid = '$new_uid' ORDER BY uid ASC";
    $rm2_result = mysql_query($rm2_query);
    if (!$rm2_result) { error("QUERY_ERROR"); exit; }
    $rm2_this_uid = @mysql_result($rm2_result,0,0);
    $rm2_org_stock = @mysql_result($rm2_result,0,1);
    $rm2_this_stock = @mysql_result($rm2_result,0,2);
    
    if($t_this_qty4) {
      if($t_this_qty4 == $rm2_org_stock) {
        $new_store_type = "1";
        $new_store_status = "2";
      } else {
        $new_store_type = "1";
        $new_store_status = "1";
      }
    } else {
        $new_store_type = "0";
        $new_store_status = "2";
    }
    
    $result_CHG = mysql_query("UPDATE shop_product_list SET store_type = '$new_store_type', store_status = '$new_store_status', 
                  store_date = '$post_dates', shop_code = '$new_shop_code2' WHERE uid = '$new_uid'",$dbconn);
    if(!$result_CHG) { error("QUERY_ERROR"); exit; }



    
  
  } else if($add_mode == "LIST_QTY") { // 출고 ▶▶▶▶▶
  
    // 출고 취소의 경우
    if($new_shop_code == "cancel") {
      $new_shop_code_x = "";
    } else {
      $new_shop_code_x = $new_shop_code;
    }
    
    // 출고 취소
    if($new_shop_code == "cancel") {
    
        /*
        $query_D3 = "DELETE FROM shop_product_list_qty WHERE uid = '$new_qty_uid'";
        $result_D3 = mysql_query($query_D3);
        if (!$result_D3) { error("QUERY_ERROR"); exit; }
        */
    
    } else {
    
        // shop_product_list 상품 상세 정보 추출

          $query_dari = "SELECT uid,catg_uid,branch_code,gate,catg_code,pcode,org_pcode,org_barcode,pname,shop_code,gudang_code,supp_code
            product_color,product_size,product_option1,product_option2,product_option3,product_option4,product_option5,
            currency,price_orgin,price_market,price_sale,price_sale2,price_margin,dc_rate,save_point,stock_org,stock_sell,stock_now,
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
          $dari_gudang_code = $row_dari->gudang_code;
          $dari_supp_code = $row_dari->supp_code;
          $dari_product_color = $row_dari->product_color;
          $dari_product_size = $row_dari->product_size;
          $dari_product_option1 = $row_dari->product_option1;
          $dari_product_option2 = $row_dari->product_option2;
          $dari_product_option3 = $row_dari->product_option3;
          $dari_product_option4 = $row_dari->product_option4;
          $dari_product_option5 = $row_dari->product_option5;
          $dari_currency = $row_dari->currency;
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
        
        // 판매가격
        
        
        // shop_product_list_qty 출고 정보 입력
        $query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,branch_code,gudang_code,shop_code,catg_code,
          gcode,pcode,org_pcode,org_barcode,supp_code,stock,date,price_orgin,flag,branch_code2,gudang_code2,shop_code2,sx_num) 
		  values ('','$new_uid','$old_branch_code','$old_gudang_code','$new_shop_code','$dari_catg_code',
		  '$new_gcode','$new_pcode','$dari_org_pcode','$dari_org_barcode','$new_supp_code','$new_stock_qty','$post_dates','$dari_price_orgin','out',
		  '$new_branch_code2','$new_gudang_code2','$new_shop_code2','$new_sx_num2')";
        $result_SH3 = mysql_query($query_SH3);
        if (!$result_SH3) { error("QUERY_ERROR"); exit; }
        
        
        
          // shop_product_list_shop에 동일 Shop, 동일 상품코드가 있는지 확인
          $scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'";
          $scv_result = mysql_query($scv_query,$dbconn);
            if (!$scv_result) { error("QUERY_ERROR"); exit; }
          $scv_count = @mysql_result($scv_result,0,0);
          
          // 하위 수량테이블 수정된 재고 합계 추출
          $s_queryA = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code' AND flag = 'out'";
          $s_resultA = mysql_query($s_queryA,$dbconn);
              if (!$s_resultA) { error("QUERY_ERROR"); exit; }
          $sA_qty_now = @mysql_result($s_resultA,0,0); // 수정된 수량 합계
          
          // 하위 SHOP 상품 테이블의 판매된 총수 추출
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'"; // Shop이 지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
          $newA_qty_org = $sA_qty_now; // 변경된 재고: 수정된 수량 합계
          $newA_qty_now = $newA_qty_org - $sB_qty_sell; // 재고수정: 변경된 재고에서 원판매수량을 공제

          
          // 하위 Shop 지정 정보 및 수량 정보 수정
          if($scv_count > "0") { //

            
            // Shop이 지정된 재고수량 변경
            $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'",$dbconn);
            if(!$result_Tv) { error("QUERY_ERROR"); exit; }
        
          } else {
        
            // shop_product_list_shop 출고 정보 저장
            $query_R1 = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,gudang_code,shop_code,catg_code,
              gcode,pcode,org_pcode,org_barcode,pname,supp_code,product_color,product_size,
              product_option1,product_option2,product_option3,product_option4,product_option5,
              price_orgin,price_market,price_sale,price_sale2,price_margin,
              dc_rate,save_point,qty_org,qty_sell,qty_now,store_date) 
            values ('','$new_uid','$new_branch_code2','$new_gudang_code2','$new_shop_code2','$dari_catg_code',
              '$dari_gcode','$dari_pcode','$dari_org_pcode','$dari_org_barcode','$dari_pname','$dari_supp_code',
              '$dari_product_color','$dari_product_size',
              '$dari_product_option1','$dari_product_option2','$dari_product_option3','$dari_product_option4','$dari_product_option5',
              '$dari_price_orgin','$dari_price_market','$dari_price_sale','$dari_price_sale2','$dari_price_margin',
              '$dari_dc_rate','$dari_save_point','$new_stock_qty','0','$new_stock_qty','$post_dates')";
            $result_R1 = mysql_query($query_R1);
            if (!$result_R1) { error("QUERY_ERROR"); exit; }
        
          }
        
        
		
		


      }
    }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_in2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid'>");
  exit;

}

}
?>