<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_return";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_return.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_return.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_list_inventory = "$home/inventory_inventory.php?sorting_key=$sorting_key";
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
if($login_level > "3") {
  $sorting_filter = "branch_code = '$login_branch' AND f_class = 'out'";
} else {
  $sorting_filter = "branch_code = '$login_branch' AND gudang_code = '$login_gate' AND f_class = 'out'";
}


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "return_date"; }
if($sorting_key == "post_date" OR $sorting_key == "return_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "post_date") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pname") { $chk2 = "selected"; } else { $chk2 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_product_return WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_return WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_return WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_04_03_2?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_purchase.php'>
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
			<option value='$PHP_SELF?sorting_key=return_date&keyfield=$keyfield&key=$key'>$txt_invn_return_02</option>
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
			<th><?=$txt_invn_stockin_07s?></th>
			<th><?=$txt_invn_stockin_17?></th>
			<th><?=$txt_invn_purchase_07?></th>
			<th><?=$txt_invn_return_01?></th>
			<th><?=$txt_invn_return_02s?></th>
			<th><?=$txt_invn_return_03?></th>
			<th><?=$txt_comm_frm11?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,catg_code,pcode,pname,price_orgin,price_sale,price_margin,stock_org,tprice_orgin,
      return_type,return_why,return_date,pay_code,pay_status,pay_date 
      FROM shop_product_return WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,catg_code,pcode,pname,price_orgin,price_sale,price_margin,stock_org,tprice_orgin,
      return_type,return_why,return_date,pay_code,pay_status,pay_date 
      FROM shop_product_return WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
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
   $prd_qty = mysql_result($result,$i,8);
   $t_prd_price_orgin = mysql_result($result,$i,9);
      $t_prd_price_orgin_K = number_format($t_prd_price_orgin);
   $return_type = mysql_result($result,$i,10);
   $return_why = mysql_result($result,$i,11);
   $return_date = mysql_result($result,$i,12);
   $pay_code = mysql_result($result,$i,13);
   $pay_status = mysql_result($result,$i,14);
   $pay_date = mysql_result($result,$i,15);
   
   // 반품일
   $uday1 = substr($return_date,0,4);
	 $uday2 = substr($return_date,4,2);
	 $uday3 = substr($return_date,6,2);

    if($lang == "ko") {
	    $return_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	  } else {
	    $return_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	  }
   

    // 처리 내용
    if($pay_status == "2") {
        $prc_status_txt = "<font color=blue>$txt_invn_return_04</font>"; // 수금 완료
    } else if($pay_status == "1") {
        $prc_status_txt = "<font color=black>$txt_invn_return_09</font>"; // 처리중
    } else {
      if($return_type == "6") {
        $prc_status_txt = "<font color=red>$txt_invn_return_05</font>"; // 반 품
      } else if($return_type == "2") {
        $prc_status_txt = "<font color=black>$txt_invn_return_06</font>"; // 분 실
      } else if($return_type == "1") {
        $prc_status_txt = "<font color=black>$txt_invn_return_07</font>"; // 파 손
      } else if($return_type == "0") {
        $prc_status_txt = "<font color=black>$txt_invn_return_08</font>"; // 기 타
      }
    
    }

    // 줄 색깔
    if($uid == $prd_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }


  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  // echo("<td bgcolor='$highlight_color'>&nbsp;{$prd_gate}</td>");
  echo("<td bgcolor='$highlight_color'>{$prd_code}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$prd_uid'>{$prd_name}</a></td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_price_orgin_K}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$prd_qty}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$t_prd_price_orgin_K}</td>");
  echo("<td bgcolor='$highlight_color'>{$return_date_txt}</td>");
  echo("<td bgcolor='$highlight_color'>{$prc_status_txt}</td>");
  
  // Print
  echo("<td bgcolor='$highlight_color'><a class='btn btn-default btn-xs' target='_blank' href='inventory_return_print.php?p_uid=$prd_uid'><i class='fa fa-print'></i> Print </a></td>");
  echo("</tr>");
  
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
		
	
		


		
		
		
		

		<? if($mode == "check" AND $uid) { ?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Return Information
			
            
        </header>
		
        <div class="panel-body">
			
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action="inventory_return.php">
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		  <?
		  $query_upd = "SELECT uid,org_uid,supp_code,shop_code,gudang_code,branch_code,gate,catg_code,pcode,pname,
                        price_orgin,price_market,price_sale,price_sale2,stock_org,tprice_orgin,post_date,
                        return_type,return_why,return_date,pay_code,pay_date,pay_status
                        FROM shop_product_return WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_org_uid = $row_upd->org_uid;
          $upd_supp_code = $row_upd->supp_code;
          $upd_shop_code = $row_upd->shop_code;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_gate = $row_upd->gate;
          $upd_catg_code = $row_upd->catg_code;
          $upd_pcode = $row_upd->pcode;
          $upd_pname = $row_upd->pname;
          $upd_price_orgin = $row_upd->price_orgin;
          $upd_price_market = $row_upd->price_market;
          $upd_price_sale = $row_upd->price_sale;
          $upd_price_sale2 = $row_upd->price_sale2;
          $upd_stock_org = $row_upd->stock_org;
          $upd_tprice_orgin = $row_upd->tprice_orgin;
			$upd_tprice_orgin_K = number_format($upd_tprice_orgin);
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
          $upd_return_type = $row_upd->return_type;
          $upd_return_why = $row_upd->return_why;
          $upd_return_date = $row_upd->return_date;
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
          $upd_pay_code = $row_upd->pay_code;
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
          $upd_pay_status = $row_upd->pay_status;
          
          // 반품 사유
          if($upd_return_why == "2") {
            $upd_return_why_chk2 = "checked";
            $upd_return_why_chk1 = "";
            $upd_return_why_chk0 = "";
          } else if($upd_return_why == "1") {
            $upd_return_why_chk2 = "";
            $upd_return_why_chk1 = "checked";
            $upd_return_why_chk0 = "";
          } else if($upd_return_why == "0") {
            $upd_return_why_chk2 = "";
            $upd_return_why_chk1 = "";
            $upd_return_why_chk0 = "checked";
          }
          
          // 반품 처리
          if($upd_return_type == "6") {
            $upd_return_type_chk6 = "checked";
            $upd_return_type_chk2 = "";
            $upd_return_type_chk1 = "";
            $upd_return_type_chk0 = "";
          } else if($upd_return_type == "2") {
            $upd_return_type_chk6 = "";
            $upd_return_type_chk2 = "checked";
            $upd_return_type_chk1 = "";
            $upd_return_type_chk0 = "";
          } else if($upd_return_type == "1") {
            $upd_return_type_chk6 = "";
            $upd_return_type_chk2 = "";
            $upd_return_type_chk1 = "checked";
            $upd_return_type_chk0 = "";
          } else if($upd_return_type == "0") {
            $upd_return_type_chk6 = "";
            $upd_return_type_chk2 = "";
            $upd_return_type_chk1 = "";
            $upd_return_type_chk0 = "checked";
          }
          
          // 수금 처리
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
          
          
          // 출고 합계
          $query_sumQ = "SELECT sum(stock) FROM shop_product_list_qty WHERE org_uid = '$upd_org_uid'";
          $result_sumQ = mysql_query($query_sumQ);
            if (!$result_sumQ) { error("QUERY_ERROR"); exit; }
          $t_this_qty = @mysql_result($result_sumQ,0,0);
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_uid' value='$upd_uid'>
      <input type=hidden name='new_catg_uid' value='$upd_catg_uid'>
      <input type=hidden name='new_client' value='$upd_gate'>
      <input type=hidden name='m_cat_code' value='$upd_catg_code'>
      <input type=hidden name='new_prd_code' value='$upd_pcode'>
      <input type=hidden name='new_price_orgin' value='$upd_price_orgin'>
      <input type=hidden name='new_price_sale' value='$upd_price_sale'>
      <input type=hidden name='new_price_sale2' value='$upd_price_sale2'>
      <input type=hidden name='old_status' value='$upd_confirm_status'>
      <input type=hidden name='old_stock_org' value='$upd_stock_org'>
      <input type=hidden name='new_tprice_orgin' value='$upd_tprice_orgin'>");
	  ?>
	    
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
										<div class="col-sm-4">
											<input <?=$catg_disableA?> class="form-control" name="dis_gudang_code" value="<?=$upd_gudang_code?>" type="text" />
										</div>
										<div class="col-sm-2" align=right><?=$txt_invn_stockin_06?></div>
										<div class="col-sm-1">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
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
											<input type='text' class='form-control' name='new_prd_name' value='$upd_pname'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='dis_new_price_orgin' value='$upd_price_orgin' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<input disabled type='text' class='form-control' name='dis_new_stock_org' value='$upd_stock_org' style='text-align: right'>
										</div>
										<div class='col-sm-2' align=right>$txt_invn_payment_02</div>
										<div class='col-sm-5'>
											<input disabled type='text' class='form-control' name='dis_new_tprice_orgin' value='$upd_tprice_orgin_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_18</label>
                                        <div class='col-sm-3'>
											<input disabled type='text' class='form-control' name='dis_post_dates' value='$upd_post_dates'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_return_02</label>
                                        <div class='col-sm-3'>
											<input disabled type='text' class='form-control' name='dis_return_date' value='$upd_return_dates'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_return_14</label>
                                        <div class='col-sm-9'>
											<input type=radio name='new_return_why' value='2' {$upd_return_why_chk2}> $txt_invn_return_07 &nbsp;&nbsp; 
											<input type=radio name='new_return_why' value='1' {$upd_return_why_chk1}> Near Expired &nbsp;&nbsp; 
											<input type=radio name='new_return_why' value='0' {$upd_return_why_chk0}> $txt_invn_return_08
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_return_11</label>
                                        <div class='col-sm-9'>
											<input type=radio name='new_return_type' value='6' {$upd_return_type_chk6}> <font color=red>$txt_invn_return_05</font> 
											<input type=radio name='new_return_type' value='2' {$upd_return_type_chk2}> $txt_invn_return_06 
											<input type=radio name='new_return_type' value='1' {$upd_return_type_chk1}> $txt_invn_return_07 
											<input type=radio name='new_return_type' value='0' {$upd_return_type_chk0}> $txt_invn_return_08
										</div>
                                    </div>");
									
									if($upd_pay_status == "2") {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_return_13</label>
                                        <div class='col-sm-4'>
											<input disabled type='text' class='form-control' name='dis_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>");
									
									}
									
									
									
									if($upd_pay_status < "2") {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'><input type=radio name='new_pay_status' value='2'> $txt_invn_return_04</label>
                                        <div class='col-sm-9'>");
											$query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'in'";
											$result_AC = mysql_query($query_AC);
											if (!$result_AC) { error("QUERY_ERROR"); exit; }
											$total_AC = @mysql_result($result_AC,0,0);
                
											echo ("<select name='new_acc_code' class='form-control'>");
											echo ("<option disabled value=\"\"> :: $txt_comm_frm19</option>");
                
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
															WHERE $login_branch = '1' AND catg = '$fA_catg' AND lang = '$lang'";
												$result_H1C = mysql_query($query_H1C);
												if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
    
												$total_H1C = @mysql_result($result_H1C,0,0);
    
												$query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
															WHERE $login_branch = '1' AND catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
												$result_H1 = mysql_query($query_H1);
												if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
												for($h1 = 0; $h1 < $total_H1C; $h1++) {
													$H1_acc_uid = mysql_result($result_H1,$h1,0);   
													$H1_acc_code = mysql_result($result_H1,$h1,1);
													$H1_acc_name = mysql_result($result_H1,$h1,2);
                        
													if($H1_acc_code == $upd_f_code) {
														$f_code_slct = "selected";
													} else {
														$f_code_slct = "";
													}
                      
													echo ("<option value='$H1_acc_code' $f_code_slct>&nbsp;&nbsp; ($H1_acc_code) $H1_acc_name</option>");
												}
               
											}
            
											echo ("</select>
										</div>
                                    </div>");
									
									}
									
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input class='btn btn-primary' type='submit' value='$txt_comm_frm27'>
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
  
  // 반환 코드
  $exp_br_code = explode("_",$login_branch);
  $exp_branch_code = $exp_br_code[1];
  
  $new_pay_num = "RE-"."$exp_branch_code"."-"."$signdate";
  
  // 상위 계정항목
  $new_fcatg = substr($new_acc_code,0,2);
        

  if($add_mode == "LIST_CHG") {
  

    if($new_pay_status == "2") {  // 반품 수금 완료

        if($new_acc_code == "") {

          popup_msg("$txt_fin_cost_chk01");
          exit;
      
        } else {
            
        $result_CHG = mysql_query("UPDATE shop_product_return SET return_why = '$new_return_why', 
                return_type = '$new_return_type', pay_status = '2', pay_code = '$new_pay_num', 
                pay_date = '$post_dates' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }

        // finance 테이블에 입력
        $new_process = "2";
        $new_fname = "Ref. $new_pay_num";
        $new_currency = "IDR";
        $new_fremark = "Refund";
    
        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,f_class,f_paylink,f_catg,f_code,f_name,f_remark,currency,
        pay_type,amount,post_date,pay_date,process,pay_num,bank_name,remit_code,pay_bank,pay_card) values ('',
        '$login_branch','$new_client','in','1','$new_fcatg','$new_acc_code','$new_fname','$new_fremark','$new_currency',
        '$new_pay_type','$new_tprice_orgin','$post_dates','$post_dates','$new_process','$new_pay_num','$new_bank_code','$new_remit_code',
        '$new_pay_bank','$new_pay_card')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }

        }
    
    
    
    } else if($new_pay_status == "1") {
    
        $result_CHG = mysql_query("UPDATE shop_product_return SET return_why = '$new_return_why', 
                return_type = '$new_return_type', pay_status = '1', pay_code = '$new_pay_num' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
        // 결제 정보 테이블에 정보 입력 [f_intype =2 : 반환]
        $query_F2 = "INSERT INTO shop_payment (uid,branch_code,gate,f_class,f_intype,pay_num,pay_amount,pay_amount_money,
          pay_date,pay_state) values ('','$login_branch','$new_client','in','2','$new_pay_num','$new_tprice_orgin',
          '$new_tprice_orgin','$post_dates','1')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }
        
    } else {
    
        $result_CHG = mysql_query("UPDATE shop_product_return SET return_why = '$new_return_why', 
                return_type = '$new_return_type', pay_status = '0' WHERE uid = '$new_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
        
    }
  
    // 리스트로 되돌아 가기
    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_return.php?mode=check&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_uid&page=$page'>");
    exit;
    
  }

}

}
?>