<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_payment";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_payment.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_payment.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_list2 = "$home/inventory_payment2.php?sorting_key=$sorting_key";
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
$sorting_filter = "flag = 'in' AND pay_status < '1' AND stock > '0'";
$sorting_filter_G = "userlevel < '6'";



// 정렬 필터링
if(!$sorting_key) { $sorting_key = "pay_date"; }
if($sorting_key == "supp_code") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "date") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "supp_code") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_list_qty WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list_qty WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_list_qty WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_04_041?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_payment.php'>
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
			<option value='$PHP_SELF?sorting_key=pay_date&keyfield=$keyfield&key=$key'>$txt_invn_payment_03</option>
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=supp_code&keyfield=$keyfield&key=$key' $chk2>$txt_sys_supplier_05</option>
			<option value='$PHP_SELF?sorting_key=date&keyfield=$keyfield&key=$key' $chk4>$txt_invn_stockin_18</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			


		<form name='signform' class="form-horizontal" method='post' action='inventory_payment.php'>
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
            <th><?=$txt_invn_stockin_06?></th>
            <th><?=$txt_invn_stockin_05?></th>
			<th><?=$txt_invn_stockin_07?></th>
			<th><?=$txt_invn_stockin_17?></th>
			<th><?=$txt_invn_payment_02?></th>
			<th><div align=center><i class='fa fa-check-square-o'></i></div></th>
			<th><?=$txt_invn_payment_03s?></th>
			<th><?=$txt_invn_return_03?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gudang_code,supp_code,catg_code,gcode,pcode,stock,date,pay_num,pay_status,pay_date 
      FROM shop_product_list_qty WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gudang_code,supp_code,catg_code,gcode,pcode,stock,date,pay_num,pay_status,pay_date  
      FROM shop_product_list_qty WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_gudang_code = mysql_result($result,$i,1);
   $prd_supp_code = mysql_result($result,$i,2);
   $prd_catg_code = mysql_result($result,$i,3);
   $prd_gcode = mysql_result($result,$i,4);
   $prd_pcode = mysql_result($result,$i,5);
   $prd_qty = mysql_result($result,$i,6);
   $prd_post_date = mysql_result($result,$i,7);
   $prd_pay_num = mysql_result($result,$i,8);
   $prd_pay_status = mysql_result($result,$i,9);
   $prd_pay_date = mysql_result($result,$i,10);
   
    // 상품 정보 추출
    $query_dari = "SELECT uid,pname,product_option1,product_option2,product_option3,product_option4,product_option5,
      price_orgin,dc_rate,save_point FROM shop_product_list WHERE pcode = '$prd_pcode'";
    $result_dari = mysql_query($query_dari);
    if(!$result_dari) { error("QUERY_ERROR"); exit; }
    $row_dari = mysql_fetch_object($result_dari);

    $dari_uid = $row_dari->uid;
    $dari_pname = $row_dari->pname;
    $dari_product_option1 = $row_dari->product_option1;
    $dari_product_option2 = $row_dari->product_option2;
    $dari_product_option3 = $row_dari->product_option3;
    $dari_product_option4 = $row_dari->product_option4;
    $dari_product_option5 = $row_dari->product_option5;
    $prd_price_orgin = $row_dari->price_orgin;
      $prd_price_orgin_K = number_format($prd_price_orgin);
    $prd_dc_rate = $row_dari->dc_rate;
    $prd_save_point = $row_dari->save_point;
   
   
    // 구입 가격의 합계
    $t_prd_price_orgin = $prd_price_orgin * $prd_qty;
      $t_prd_price_orgin_K = number_format($t_prd_price_orgin);

   
   // 결제일
   $sday1 = substr($prd_post_date,0,4);
	 $sday2 = substr($prd_post_date,4,2);
	 $sday3 = substr($prd_post_date,6,2);
	 
	 $pday1 = substr($prd_pay_date,0,4);
	 $pday2 = substr($prd_pay_date,4,2);
	 $pday3 = substr($prd_pay_date,6,2);
	 
	 if($prd_pay_status == "0") {
	  if($lang == "ko") {
	    $pay_date_txt = "<font color=#AAAAAA>$sday1"."/"."$sday2"."/"."$sday3</font>";
	  } else {
	    $pay_date_txt = "<font color=#AAAAAA>$sday3"."-"."$sday2"."-"."$sday1</font>";
	  }
   } else {
    if($lang == "ko") {
	    $pay_date_txt = "$pday1"."/"."$pday2"."/"."$pday3";
	  } else {
	    $pay_date_txt = "$pday3"."-"."$pday2"."-"."$pday1";
	  }
	 }
   

    // 처리 내용
    if($prd_pay_status == "2") {
        $prc_status_txt = "<font color=blue>$txt_invn_payment_06</font>"; // 지불완료
    } else if($prd_pay_status == "1") {
        $prc_status_txt = "<font color=black>$txt_invn_return_09s</font>"; // 처리중
    } else {
        $prc_status_txt = "<font color=red>$txt_invn_payment_05s</font>"; // 미지불
    }

    // 줄 색깔
    if($uid == $prd_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    if($dari_product_option1 != "") { $dari_product_option1_txt = "[$dari_product_option1]"; } else { $dari_product_option1_txt = ""; }
    if($dari_product_option2 != "") { $dari_product_option2_txt = "[$dari_product_option2]"; } else { $dari_product_option2_txt = ""; }
    if($dari_product_option3 != "") { $dari_product_option3_txt = "[$dari_product_option3]"; } else { $dari_product_option3_txt = ""; }
    if($dari_product_option4 != "") { $dari_product_option4_txt = "[$dari_product_option4]"; } else { $dari_product_option4_txt = ""; }
    if($dari_product_option5 != "") { $dari_product_option5_txt = "[$dari_product_option5]"; } else { $dari_product_option5_txt = ""; }
    


  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'>{$prd_pcode}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$prd_uid'>{$dari_pname} {$dari_product_option1_txt}{$dari_product_option2_txt}</a></td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_price_orgin_K}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_qty}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$t_prd_price_orgin_K}</td>");
    if($prd_pay_status == "0") {
      echo("<td bgcolor='$highlight_color' align=center><input type=checkbox name='check_$prd_uid' value='1'></td>");
    } else {
      echo("<td bgcolor='$highlight_color'>&nbsp;</td>");
    }
  echo("<td bgcolor='$highlight_color'>{$pay_date_txt}</td>");
  echo("<td bgcolor='$highlight_color'>{$prc_status_txt}</td>");
  echo("</tr>");
  
   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
		
				<a href="<?=$link_list2?>"><input type="button" value="<?=$txt_invn_payment_01?>" class="btn btn-primary"></a>
			
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
		if($mode == "check" AND $uid) { // 상품 정보 변경

          $query_upd = "SELECT uid,gudang_code,supp_code,shop_code,branch_code,catg_code,gcode,pcode,
            stock,date,pay_num,pay_status,pay_date FROM shop_product_list_qty WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);
          
          $upd_uid = $row_upd->uid;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_supp_code = $row_upd->supp_code;
          $upd_shop_code = $row_upd->shop_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_catg_code = $row_upd->catg_code;
          $upd_gcode = $row_upd->gcode;
          $upd_pcode = $row_upd->pcode;
          $upd_stock_org = $row_upd->stock;
          $upd_post_date = $row_upd->date;
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
          $upd_pay_code = $row_upd->pay_num;
          $upd_pay_status = $row_upd->pay_status;
          $upd_pay_date = $row_upd->pay_date;
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
          
          
          $query_upd2 = "SELECT uid,pname,product_option1,product_option2,product_option3,product_option4,product_option5,
            price_orgin,price_market,price_sale,price_sale2 FROM shop_product_list WHERE pcode = '$upd_pcode'";
          $result_upd2 = mysql_query($query_upd2);
          if(!$result_upd2) { error("QUERY_ERROR"); exit; }
          $row_upd2 = mysql_fetch_object($result_upd2);
          
          $upd_prd_uid = $row_upd2->uid;
          $upd_pname = $row_upd2->pname;
          $upd_product_option1 = $row_upd2->product_option1;
          $upd_product_option2 = $row_upd2->product_option2;
          $upd_product_option3 = $row_upd2->product_option3;
          $upd_product_option4 = $row_upd2->product_option4;
          $upd_product_option5 = $row_upd2->product_option5;
          
          $upd_price_orgin = $row_upd2->price_orgin;
          $upd_price_market = $row_upd2->price_market;
          $upd_price_sale = $row_upd2->price_sale;
          $upd_price_sale2 = $row_upd2->price_sale2;
          
          // 지불하여야 할 구입가의 합계
          $upd_tprice_orgin = $upd_price_orgin * $upd_stock_org;
            $upd_tprice_orgin_K = number_format($upd_tprice_orgin);

          
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
          
          
          // 결제 정보 테이블
          $pm_query = "SELECT uid,pay_num,bank_name,pay_type,pay_bank,remit_code,client_code,loan_flag,loan_trans_code 
                        FROM shop_payment WHERE pay_num = '$upd_pay_code'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_pay_num = @mysql_result($pm_result,0,1);
          $pm_bank_name = @mysql_result($pm_result,0,2);
          $pm_pay_type = @mysql_result($pm_result,0,3);
          $pm_pay_bank = @mysql_result($pm_result,0,4);
          $pm_remit_code = @mysql_result($pm_result,0,5);
          $pm_client_code = @mysql_result($pm_result,0,6);
          $pm_loan_flag = @mysql_result($pm_result,0,7);
          $pm_loan_trans_code = @mysql_result($pm_result,0,8);
          
          // 대출 정보
          $pm2_query = "SELECT uid,loan_code,pay_num FROM loan_transaction WHERE trans_code = '$pm_loan_trans_code'";
          $pm2_result = mysql_query($pm2_query);
          if (!$pm2_result) { error("QUERY_ERROR"); exit; }
          
          $pm_loan_uid = @mysql_result($pm2_result,0,0);
          $pm_loan_code = @mysql_result($pm2_result,0,1);
          $pm_loan_pay_num = @mysql_result($pm2_result,0,2);
          
          
          if($pm_pay_type == "cash") { $pay_type_slc_cash = "selected"; } else { $pay_type_slc_cash = ""; }
          if($pm_pay_type == "bank") { $pay_type_slc_bank = "selected"; } else { $pay_type_slc_bank = ""; }
          if($pm_pay_type == "account") { $pay_type_slc_account = "selected"; } else { $pay_type_slc_account = ""; }
          if($pm_pay_type == "card") { $pay_type_slc_card = "selected"; } else { $pay_type_slc_card = ""; }
          if($pm_pay_type == "voucher") { $pay_type_slc_voucher = "selected"; } else { $pay_type_slc_voucher = ""; }
          
          // 처리 버튼
          if($upd_pay_status == "2") {
            $submit_txt = $txt_invn_payment_14;
          } else if($upd_pay_status == "1") {
            $submit_txt = "Payment Request";
          } else {
            $submit_txt = "Payment Request";
          }
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_gudang_code' value='$upd_gudang_code'>
      <input type=hidden name='new_uid' value='$upd_uid'>
      <input type=hidden name='new_prd_uid' value='$upd_prd_uid'>
      <input type=hidden name='new_client' value='$upd_gate'>
      <input type=hidden name='new_prd_code' value='$upd_pcode'>
      <input type=hidden name='new_prd_name' value='$upd_pname'>
      
      <input type=hidden name='new_product_option1' value='$upd_product_option1'>
      <input type=hidden name='new_product_option2' value='$upd_product_option2'>
      <input type=hidden name='new_product_option3' value='$upd_product_option3'>
      <input type=hidden name='new_product_option4' value='$upd_product_option4'>
      <input type=hidden name='new_product_option5' value='$upd_product_option5'>
      
      <input type=hidden name='new_stock_org' value='$upd_stock_org'>
      
      <input type=hidden name='org_pay_uid' value='$pm_uid'>
      <input type=hidden name='org_pay_num' value='$pm_pay_num'>
      <input type=hidden name='new_loan_uid' value='$pm_loan_uid'>
      <input type=hidden name='new_loan_pay_num' value='$pm_loan_pay_num'>");
	  ?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Payment Form
			
            
        </header>
		
        <div class="panel-body">
								<div class="cmxform form-horizontal adminex-form">
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_06?></label>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" required />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableB?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" required />
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
                                        <div class="col-sm-4">
											<input class="form-control" name="new_prv_code" value="<?=$upd_org_pcode?>" type="text" />
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
									// Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-2'>
											<input class='form-control' name='dis_price_orgin' value='$upd_price_orgin' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<input disabled class='form-control' name='dis_new_stock_org' value='$upd_stock_org' style='text-align: right'>
										</div>
										<div class='col-sm-2' align=right>$txt_invn_payment_02</div>
										<div class='col-sm-5'>
											<input class='form-control' name='new_tprice_orgin' value='$upd_tprice_orgin' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_18</label>
                                        <div class='col-sm-3'>
											<input disabled type='text' class='form-control' name='dis_post_dates' value='$upd_post_dates'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_10</label>
                                        <div class='col-sm-9'>
											<select name='new_pay_type' class='form-control'>
											<option value='cash' $pay_type_slc_cash>$txt_invn_payment_10_1</option>
											<option value='bank' $pay_type_slc_bank>$txt_invn_payment_10_2</option>
              
											<option value='card' $pay_type_slc_card>$txt_invn_payment_10_4</option>
											<!--<option value='voucher' $pay_type_slc_voucher>$txt_invn_payment_10_5</option>-->
											</select>
										</div>
                                    </div>
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_16</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_bank_name' value='$pm_bank_name'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_12</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_pay_bank' value='$pm_pay_bank'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_13</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_remit_code' value='$pm_remit_code'>
										</div>
                                    </div>
									
									<!---------- loan request module here // --------------------------------------->
									
									
									<!---------- payment status // -------------------------------------------------->
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_08</label>
                                        <div class='col-sm-9'>");
											if($upd_pay_status == "2") {
													echo("
													<input type=radio name='new_pay_status' value='2' checked> <font color=blue>$txt_invn_payment_06</font> &nbsp;&nbsp; 
													");
											} else if($upd_pay_status == "1") {
													echo("
													<input $pre_loan_submit type=radio name='new_pay_status' value='' checked> <font color=black>$txt_invn_return_09</font> &nbsp;&nbsp; 
													<input type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04 (No need to pay)</font>
													");
											} else {
												
													echo("
													<input type=radio name='new_pay_status' value='1' checked> <font color=blue>Payment Request</font> &nbsp;&nbsp; 
													<input type=radio name='new_pay_status' value='0'> <font color=red>$txt_invn_payment_04 (No need to pay)</font>
													");
                
											}
											echo ("
										</div>
                                    </div>");
									
									if($upd_pay_status > "0") {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_15</label>
                                        <div class='col-sm-4'>
											<input disabled class='form-control' name='dis_pay_code' value='$upd_pay_code'>
										</div>
										<div class='col-sm-2' align=right>$txt_invn_payment_03</div>
										<div class='col-sm-3'>
											<input disabled class='form-control' name='dis_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>");
									
									} else {
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='Submit'>
										</div>
                                    </div>");
									
									}
									?>
								</div>
		</div>
		</section>
		</div>
		</div>

		
	  <? } else { ?>
	  
	  <input type=hidden name='add_mode' value='LIST_PAY'>
      <input type=hidden name='new_prd_uid' value='<?=$prd_uid?>'>
      <input type=hidden name='new_client' value='<?=$prd_gate?>'>
      <input type=hidden name='new_prd_branch_code' value='<?=$prd_branch_code?>'>
	  
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Payment Form
			
            
        </header>
		
        <div class="panel-body">
								
            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_payment_07?>">
                                        
		</div>
		</section>
		</div>
		</div>
	
	  <? } ?>
		
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
  

    if($new_pay_status == "2") { // 결제마감
    
        // 결제 정보 수정
        $result_CHG = mysql_query("UPDATE shop_payment SET client_code = '$new_supp_code', pay_type = '$new_pay_type', 
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', 
			pay_amount = '$new_tprice_orgin', pay_amount_money = '$new_tprice_orgin', pay_state = '2' WHERE uid = '$org_pay_uid'",$dbconn);
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
    
        // 상품 정보 수정 -결제가 된 것으로 처리
        $result_CHG = mysql_query("UPDATE shop_product_list_qty SET pay_num = '', pay_status = '2' WHERE uid = '$new_uid'",$dbconn);
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
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', 
			pay_amount = '$new_tprice_orgin', pay_amount_money = '$new_tprice_orgin' WHERE uid = '$org_pay_uid'",$dbconn);
        if(!$result_CHGs) { error("QUERY_ERROR"); exit; }
    
    }
    
    
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_payment.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
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
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_payment2.php'>");
    exit;
  
  }
  

}

}
?>