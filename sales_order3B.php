<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "sales";
$smenu = "sales_order3B";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/sales_order3B.php?sorting_key=$sorting_key&key_shop=$key_shop";
$link_upd = "$home/sales_order3B.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>" ng-app="myApp">
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
	
	<!-- ExcelCopy & Paste -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
	<script src="js/script_excel.js"></script>
	
	
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


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "pcode"; }
if($sorting_key == "post_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "org_pcode" OR $keyfield == "org_pcode") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "pname" OR $keyfield == "pname") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "post_date" OR $keyfield == "post_date") { $chk2 = "selected"; } else { $chk2 = ""; }


// 공급자용 상품 코드 입력란 필요 여부
$query_prv = "SELECT prd_code FROM client_branch WHERE branch_code = '$login_branch'";
$result_prv = mysql_query($query_prv);
if(!$result_prv) { error("QUERY_ERROR"); exit; }
$row_prv = mysql_fetch_object($result_prv);

$prv_entry = $row_prv->prd_code;


if(!$page) { $page = 1; }


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
  $query = "SELECT count(uid) FROM shop_product_list_shop WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
$query_HC = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);
?>
    
						
		<!--body wrapper start-->
        <div class="wrapper">
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
			<div class='col-sm-4'>
			
											<?
											$query_shc = "SELECT count(uid) FROM client_branch";
											$result_shc = mysql_query($query_shc);
											$total_record_sh = @mysql_result($result_shc,0,0);

											$query_sh = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											$result_sh = mysql_query($query_sh);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");

											for($sh = 0; $sh < $total_record_sh; $sh++) {
												$sh_menu_code = mysql_result($result_sh,$sh,0);
												$sh_menu_name = mysql_result($result_sh,$sh,1);
        
												if($sh_menu_code == $key_sh) {
													$sh_slc_gate = "selected";
												} else {
													$sh_slc_gate = "";
												}

												echo("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&uid=$uid&mode=$mode&key_sh=$sh_menu_code' $sh_slc_gate>[ $sh_menu_code ] $sh_menu_name</option>");
											}
											echo("</select>");
											?>
			
			</div>
			
			<div class='col-sm-4'>
			
											<?
											$queryC = "SELECT count(uid) FROM client WHERE $sorting_filter_SHOP AND userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client WHERE $sorting_filter_SHOP AND userlevel > '0' ORDER BY client_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo("<option value='$PHP_SELF'>:: $txt_comm_frm20</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
        
												if($menu_code == $key_shop) {
													$slc_gate = "selected";
												} else {
													$slc_gate = "";
												}
												if($menu_level == "4") {
													$slc_disable = "";
												} else {
													$slc_disable = "disabled";
												}

												echo("<option value='$PHP_SELF?sorting_key=$sorting_key&key_shop=$menu_code&keyfield=$keyfield&key=$key' $slc_gate>&nbsp; $menu_name [ $menu_code ]</option>");
											}
											echo ("</select>");
											?>
			
			</div>
			
			<div class='col-sm-4'></div>
			</div>
			
			<div>&nbsp;</div>
			
			
			
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='sales_order3B.php'>
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
			
			
			<div class='col-sm-2'>$total_record / $all_record &nbsp;[<font color='navy'>$page</font>/$total_page]</div>
			
			<div class='col-sm-2' align=right>$txt_comm_frm14 : </div>
			
			<div class='col-sm-2'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=pcode&key_shop=$key_shop&keyfield=$keyfield&key=$key'>$txt_invn_stockin_06</option>");

				if($prv_entry == "1") { // 공급자 코드 
					echo ("<option value='$PHP_SELF?sorting_key=org_pcode&key_shop=$key_shop&keyfield=$keyfield&key=$key' $chk4>$txt_invn_stockin_30</option>");
				} echo ("

				<option value='$PHP_SELF?sorting_key=pname&key_shop=$key_shop&keyfield=$keyfield&key=$key' $chk1>$txt_invn_stockin_05</option>
				<option value='$PHP_SELF?sorting_key=post_date&key_shop=$key_shop&keyfield=$keyfield&key=$key' $chk2>$txt_invn_stockin_18</option>
				</select>");
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			

			
		
			<iFrame src="sales_excel.php" style="width: 100%; height: 200px; border: 1px solid #eee"></iFrame>

		
			<br />
			<div class="row">
			
			<div class="col-sm-3">
				<? if($total_HC > "0") { ?>
          
				<div class="form-actions">
					<a href="sales_order3B.php"><button class="btn btn-danger"><i class="fa fa-shopping-cart"></i> <?=$txt_sales_sales_05?></button></a>
				</div>
				
				<? } ?>
			</div>
			
			
			<div class="col-sm-9" align=right>
			
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
		
	
		



		

		<? if($mode == "search" AND $uid) { ?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Product Details
			
            
        </header>
		
        <div class="panel-body">
			
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action="sales_order3B.php">
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='key_shop' value='<?=$key_shop?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		  <?
		  $query_upd = "SELECT uid,gudang_code,supp_code,branch_code,shop_code,catg_code,gcode,pcode,pname,
                        price_orgin,price_market,price_sale,qty_org,qty_sell,qty_now,
                        product_option1,product_option2,product_option3,product_option4,product_option5,sold_out,org_pcode
                        FROM shop_product_list_shop WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_supp_code = $row_upd->supp_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_shop_code = $row_upd->shop_code;
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
          $upd_stock_org = $row_upd->qty_org;
          $upd_stock_sell = $row_upd->qty_sell;
          $upd_stock_now = $row_upd->qty_now;
          $upd_p_option1 = $row_upd->product_option1;
          $upd_p_option2 = $row_upd->product_option2;
          $upd_p_option3 = $row_upd->product_option3;
          $upd_p_option4 = $row_upd->product_option4;
          $upd_p_option5 = $row_upd->product_option5;
          $upd_sold_out = $row_upd->sold_out;
          $upd_org_pcode = $row_upd->org_pcode;
		  
          
          // Online Shop 구분
          $query_upd2 = "SELECT userlevel FROM client WHERE client_id = '$upd_shop_code'";
          $result_upd2 = mysql_query($query_upd2);
          if(!$result_upd2) { error("QUERY_ERROR"); exit; }
          $row_upd2 = mysql_fetch_object($result_upd2);

          $upd_userlevel = $row_upd2->userlevel;
          
          // 매진
          // if($upd_stock_now == "0" OR $upd_sold_out == "1" OR $upd_userlevel != "4") { // 온라인 판매불가
          if($upd_stock_now == "0" OR $upd_sold_out == "1" OR $login_level != "1") { // 온라인 판매가
            $sumit_btn_dis = "disabled";
            $sumit_soldout_txt = "( <font color=red>$txt_sales_sales_08</font> )";
          } else {
            $sumit_btn_dis = "";
            $sumit_soldout_txt = "";
          }
          
          // Expired Date
          $query_exp = "SELECT date_expire FROM shop_product_list_qty WHERE pcode = '$upd_pcode' ORDER BY date_expire DESC";
          $result_exp = mysql_query($query_exp);
          if(!$result_exp) { error("QUERY_ERROR"); exit; }
          $upd_date_expire = @mysql_result($result_exp,0,0);
            $date_expire1 = substr($upd_date_expire,0,4);
            $date_expire2 = substr($upd_date_expire,4,2);
            $date_expire3 = substr($upd_date_expire,6,2);
          
          if($upd_date_expire > 0) {
            if($lang == "ko") {
              $upd_date_expire_txt = "$date_expire1"."/"."$date_expire2"."/"."$date_expire3";
            } else {
              $upd_date_expire_txt = "$date_expire3"."-"."$date_expire2"."-"."$date_expire1";
            }
          } else {
            $upd_date_expire_txt = "No defined";
          }


      echo ("
      <input type=hidden name='add_mode' value='SEARCH'>
      <input type=hidden name='new_branch_code' value='$upd_branch_code'>
      <input type=hidden name='new_uid' value='$upd_uid'>
      <input type=hidden name='new_shop_code' value='$upd_shop_code'>
      <input type=hidden name='new_catg_code' value='$upd_catg_code'>
      <input type=hidden name='new_gcode' value='$upd_gcode'>
      <input type=hidden name='new_pcode' value='$upd_pcode'>
      <input type=hidden name='new_price_orgin' value='$upd_price_orgin'>
      <input type=hidden name='new_price_sale' value='$upd_price_sale'>
      
      <input type=hidden name='old_stock_org' value='$upd_stock_org'>
      <input type=hidden name='old_stock_sell' value='$upd_stock_sell'>
      <input type=hidden name='old_stock_now' value='$upd_stock_now'>

      <input type=hidden name='new_product_option1' value='$upd_p_option1'>
      <input type=hidden name='new_product_option2' value='$upd_p_option2'>
      <input type=hidden name='new_product_option3' value='$upd_p_option3'>
      <input type=hidden name='new_product_option4' value='$upd_p_option4'>
      <input type=hidden name='new_product_option5' value='$upd_p_option5'>");
	  ?>
	    
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockout_05?></label>
										<div class="col-sm-4">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_shop_code" value="<?=$upd_shop_code?>" type="text" />
										</div>
										<div class="col-sm-2" align=right><?=$txt_invn_stockin_06?></div>
										<div class="col-sm-1">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
										</div>
                                    </div>
									
									<!--
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
									-->
									
									
									<?
									// Product Name, Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_05</label>
                                        <div class='col-sm-9'>
											<input type='text' class='form-control' name='new_prd_name' value='$upd_pname'>
										</div>
                                    </div>
									
									<!--
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_07</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='dis_new_price_orgin' value='$upd_price_orgin_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_10</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='dis_new_price_market' value='$upd_price_market_K' style='text-align: right'>
										</div>
                                    </div>
									-->
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_11</label>
                                        <div class='col-sm-3'>
											<input type='text' class='form-control' name='dis_new_price_sale' value='$upd_price_sale_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<select name='new_qty_sell' class='form-control'>");
											if($upd_stock_now < 1) {
												$q_s = "0";
											} else {
												$q_s = "1";
											}
              
											for($q = $q_s; $q <= $upd_stock_now; $q++) {
												echo("<option value='$q'>$q</option>");
											}
              
											echo ("
											</select>
										</div>
										<div class='col-sm-7'>
											 / $upd_stock_org  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<input type=checkbox name='return' value='1'> <font color=red>$txt_invn_stockout_03</font>-->
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<!--<input $sumit_btn_dis class='btn btn-primary' type='submit' value='$txt_sales_sales_04'>-->
											<input class='btn btn-primary' type='submit' value='$txt_sales_sales_04'>
										</div>
                                    </div>");
									?>
		
		
		
		
		
		</form>

			
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
      } else {
        $stat = "cash";
      }
      }
      
      
      // 장바구니
      if($total_HC > "0" AND ($mode == "" OR $mode == "order_form")) {
      
      $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,
                  gate,p_price,p_saleprice FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' 
                  ORDER BY pcode ASC";
      $result_H = mysql_query($query_H);
      if (!$result_H) {   error("QUERY_ERROR");   exit; }
      
        $H_cart_gate = mysql_result($result_H,0,11);  // SHOP 이름 추출
		?>
		
		

		
		
	  <?
	  echo ("
	  <div class='row'>
		<div class='col-sm-6'>&raquo; $txt_sales_sales_05 : $H_cart_gate</div>
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
      
        if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
        if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
        if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
        if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
        if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
        if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
        if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
        $H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";
      
      
      
        // 상품명, 상품별 결제액
        $query_dari = "SELECT uid,pname,price_orgin,price_market,price_sale,qty_now,qty_sell FROM shop_product_list_shop 
                      WHERE pcode = '$H_pcode' AND shop_code = '$H_cart_shop_code'";
        $result_dari = mysql_query($query_dari);
        if(!$result_dari) { error("QUERY_ERROR"); exit; }
        $row_dari = mysql_fetch_object($result_dari);

        $dari_uid = $row_dari->uid;
        $dari_pname = $row_dari->pname;
		$harga_orgin = $row_dari->price_orgin;
	    $harga_faktur = $row_dari->price_market;
        $dari_amount = $row_dari->price_sale;
         $dari_amount_K = number_format($dari_amount);

        // $dari_tamount = $dari_amount * $H_qty;
        $dari_tamount = $H_p_saleprice * $H_qty;
         $dari_tamount_K = number_format($dari_tamount);
        $dari_stock_now = $row_dari->qty_now;
          $qty_max = $dari_stock_now + $H_qty; // 재고와 카트의 주문수량의 합 (주문 가능한 수량의 최대값, 본래의 재고량)
          
        $dari_stock_sell = $row_dari->qty_sell;
          $qty_sold = $dari_stock_sell - $H_qty; // 판매량에서 카트의 주문수량을 공제 (본래의 판매량)
        
        // 합계 [cash로 결제할 경우를 위해 쇼핑카트에서 가격정보 추출]
        //  $p_total_price = $p_total_price + ($dari_amount * $H_qty);
        $p_tamount = $H_p_saleprice * $H_qty;
          $p_tamount_K = number_format($p_tamount);
        
        $p_total_price = $p_total_price + ($H_p_saleprice * $H_qty);
          $p_total_price_K = number_format($p_total_price);
          
      
	
      // FANDI AKHMAD Edited
	  // Youngkay Edited 22-08-2013
	  
      echo ("
      <form name='cart_upd' method='post' action='sales_order_cart.php'>
      <input type=hidden name='add_mode' value='CART_UPD'>
	  <input type=hidden name='sub_type' value='3B'>
      <input type=hidden name='H_cart_uid' value='$H_cart_uid'>
	  <input type=hidden name='harga_orgin' value='$harga_orgin'>
      <input type=hidden name='harga_faktur' value='$harga_faktur'>
	  <input type=hidden name='harga_jual' value='$dari_amount'>
      <input type=hidden name='H_shop_uid' value='$dari_uid'>
      <input type=hidden name='H_prd_code' value='$H_pcode'>
      <input type=hidden name='H_prd_stock_sell' value='$qty_sold'>
      <input type=hidden name='H_prd_stock_now' value='$qty_max'>
      <input type='hidden' name='key_shop' value='$key_shop'>
      <input type='hidden' name='page' value='$page'>
      <input type='hidden' name='stat' value='$stat'>

      
      <tr height=22>
        <td>$cart_no</td>
        <td>$H_pcode</td>
        <td>{$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</td>");
        if($stat == "cash") {
          echo ("<td align=right><input type=text class='form-control' name='new_unit_saleprice' value='$H_p_saleprice' style='text-align: right'></td>");
        } else {
          echo ("<td align=right>{$dari_amount_K}</td>");
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
        <td align=right>{$p_tamount_K}</td>
        <td><input type=submit value='$txt_comm_frm12' class='form-control'></td>
        </form>
        
        <form name='cart_del' method='post' action='sales_order_cart.php'>
        <input type=hidden name='add_mode' value='CART_DEL'>
		<input type=hidden name='sub_type' value='3B'>
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
      <form name='order_check' method='post' action='sales_order3B.php'>
      <input type=hidden name='mode' value='order_form'>
      <input type=hidden name='H_total_price' value='$p_total_price'>
      <input type=hidden name='new_client' value='$H_cart_gate'>
      <input type='hidden' name='key_shop' value='$key_shop'>
      <input type='hidden' name='page' value='$page'>
      <input type='hidden' name='stat' value='$stat'>

      <tr>
        <td colspan=3 align=center>
			<!--
			<input type=radio name='new_buyer_type' value='0' $new_buyer_type_chk0> $txt_sales_sales_30 &nbsp&nbsp; &nbsp&nbsp; 
			<input type=radio name='new_buyer_type' value='1' $new_buyer_type_chk1> $txt_sales_sales_31 &nbsp&nbsp; &nbsp&nbsp; 
			<input type=radio name='new_buyer_type' value='2' $new_buyer_type_chk2> $txt_sales_sales_32
			-->
        </td>
        <td align=center><b>$txt_sales_sales_11</b></td>
        <td align=center>{$total_qty}</td>
        <td align=right><font color=#000000><b>{$p_total_price_K}</b></font></td>
        <td colspan=2><input type=submit value='$txt_sales_sales_12' class='btn btn-primary'></td>
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
	  
      echo ("
	  
      <form name='order_check' class='cmxform form-horizontal adminex-form' method='post' action='sales_order_cart.php'>
      <input type=hidden name='mode' value='order_form'>
	  <input type=hidden name='sub_type' value='3B'>
      <input type=hidden name='add_mode' value='ORDER'>
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
			
					if($new_buyer_type == "2") { // Corporate Member

                    $query_z1C = "SELECT count(id) FROM member_main WHERE userlevel > '0' AND mb_level = '1' AND mb_type = '3'";
                    $result_z1C = mysql_query($query_z1C);
                    $total_z1C = @mysql_result($result_z1C,0,0);
                
                    $query_z1 = "SELECT id,code,name,corp_name FROM member_main 
                            WHERE userlevel > '0' AND mb_level = '1' AND mb_type = '3' ORDER BY name ASC";
                    $result_z1 = mysql_query($query_z1);
                
                    echo ("<select name='new_buyer_name' class='form-control'>");
                    echo ("<option value=''>:: $txt_comm_frm19 ($txt_sales_sales_32)</option>");

                    for($z1 = 0; $z1 < $total_z1C; $z1++) {
                      $zbuyer_id = mysql_result($result_z1,$z1,0);
                      $zbuyer_code = mysql_result($result_z1,$z1,1);
                      $zbuyer_name = mysql_result($result_z1,$z1,2);
                      $zbuyer_corp = mysql_result($result_z1,$z1,3);
                
                      echo ("<option value='$zbuyer_code'>[$zbuyer_code] $zbuyer_name</option>");
                    }
                    echo ("</select>");
                
                } else if($new_buyer_type == "1") { // Individual Member
                
                    $query_z2C = "SELECT count(id) FROM member_main WHERE userlevel > '0' AND mb_level = '1' AND mb_type < '3'";
                    $result_z2C = mysql_query($query_z2C);
                    $total_z2C = @mysql_result($result_z2C,0,0);
                
                    $query_z2 = "SELECT id,code,name FROM member_main 
                            WHERE userlevel > '0' AND mb_level = '1' AND mb_type < '3' ORDER BY name ASC";
                    $result_z2 = mysql_query($query_z2);
                
                    echo ("<select name='new_buyer_name' class='form-control'>");
                    echo ("<option value=''>:: $txt_comm_frm19</option>");

                    for($z2 = 0; $z2 < $total_z2C; $z2++) {
                      $z2buyer_id = mysql_result($result_z2,$z2,0);
                      $z2buyer_code = mysql_result($result_z2,$z2,1);
                      $z2buyer_name = mysql_result($result_z2,$z2,2);
                
                      echo ("<option value='$z2buyer_code'>[$z2buyer_code] $z2buyer_name</option>");
                    }
                    echo ("</select>");
                
                } else {
                  echo ("<input type=text name='new_buyer_name' class='form-control'>");
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
				if($_POST[stat]=="cash"){
		
				echo ("
                <select name='new_pay_type' class='form-control'>
                <option value='cash'>$txt_invn_payment_10_1</option>
                <option value='bank'>$txt_invn_payment_10_2</option>
                
                <option value='card'>$txt_invn_payment_10_4</option>
                <option value='voucher'>$txt_invn_payment_10_5</option>
                </select>
				");

				}
			
				if($_POST[stat]=="credit"){
					echo ("<input type=text name='dis_new_pay_type' value='Kredit' class='form-control' readonly>");
					echo ("<input type=hidden name='new_pay_type' value='credit'>");
				}
				
				echo ("
			</div>
        </div>
		
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_sales_sales_23</label>
            <div class='col-sm-3'>
				<select name='new_pay_voucher_set' class='form-control'>
                <option value='0'>:: $txt_comm_frm19</option>");
                
                $query_V1C = "SELECT count(uid) FROM shop_voucher WHERE branch_code = '$login_branch' AND onoff = '1'";
                $result_V1C = mysql_query($query_V1C);
                $total_V1C = @mysql_result($result_V1C,0,0);
                
                $query_V1 = "SELECT uid,voucher_code,voucher_value FROM shop_voucher 
                            WHERE branch_code = '$login_branch' AND onoff = '1' ORDER BY voucher_value ASC";
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
			
			<div class='col-sm-1'>
                <select name='new_pay_voucher_qty' class='form-control'>");
                for($n = 1; $n < 11; $n++) {
                  if($H_qty == $n) {
                    echo("<option value='$n' selected>$n</option>");
                  } else {
                    echo("<option value='$n'>$n</option>");
                  }
                }
                echo ("
                </select>
			</div>");
			
				// 특별 행사가
				$query_V2 = "SELECT dc2_amount FROM client WHERE branch_code = '$login_branch' AND client_id = '$H_cart_gate'";
				$result_V2 = mysql_query($query_V2,$dbconn);
    
				$V2_dc_rate = @mysql_result($result_V2,0,0);
              
				if($V2_dc_rate > 0) {
					$V2_dc_rate_txt = "<font color=blue>$txt_sales_sales_24</font>";
				} else {
					$V2_dc_rate_txt = "$txt_sales_sales_24";
				}
				
				echo ("

				<label class='control-label col-sm-2'>$V2_dc_rate_txt</label>
            <div class='col-sm-1'>
				<input readonly type=text name='new_pay_saleoff' value='$V2_dc_rate' class='form-control'>
			</div>
			<div class='col-sm-3'>% Discount</div>
        </div>
		
		<div class='form-group'>
            <label class='control-label col-sm-2'>$txt_invn_payment_20</label>
            <div class='col-sm-4'>");
			
				$query_K1C = "SELECT count(uid) FROM code_card WHERE userlevel > '0' AND branch_code = '$login_branch'";
                $result_K1C = mysql_query($query_K1C);
                $total_K1C = @mysql_result($result_K1C,0,0);
                
                $query_K1 = "SELECT card_code,card_name FROM code_card 
                            WHERE userlevel > '0' AND branch_code = '$login_branch' ORDER BY card_code ASC";
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
            <div class='col-sm-offset-2 col-sm-10'>
				<input class='btn btn-primary' type='submit' value='$txt_sales_sales_06'>
			</div>
        </div>
		");
		
		}
		?>
		
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
  
  $m_ip = getenv('REMOTE_ADDR');
  
  
  // 장바구니에 담기
  if($add_mode == "SEARCH") {
  
      
      // 동일한 SHOP의 제품만을 장바구니에 담을 수 있음
      $query_K = "SELECT gate FROM shop_cart 
                WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' ORDER BY uid ASC";
      $result_K = mysql_query($query_K);
      if (!$result_K) {   error("QUERY_ERROR");   exit; }
      
        $K_cart_gate = mysql_result($result_K,0,0);  // SHOP 이름 추출
        
      if($K_cart_gate AND $new_shop_code != $K_cart_gate) {
        popup_msg("$txt_sales_sales_chk05");
        exit;
      } else {

      // 동일한 제품 유무여부 체크
      $query_logn = "SELECT count(uid) FROM shop_cart 
                    WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' AND pcode = '$new_pcode'";
      $result_logn = mysql_query($query_logn);
      if (!$result_logn) { error("QUERY_ERROR"); exit; }   

      $cart_cnt = @mysql_result($result_logn,0,0);

      if($cart_cnt > 0) {
        popup_msg("$txt_sales_sales_chk01");
        exit;
      
      } else {

      
      // 카트정보 입력
      $query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,qty,
            p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_price,p_saleprice) 
            values ('','$new_uid','$new_branch_code','$new_shop_code','in','$login_id','$m_ip',
            '$new_pcode','$new_qty_sell','$new_product_option1','$new_product_option2','$new_product_option3',
            '$new_product_option4','$new_product_option5','0','$post_dates','$new_price_sale','$new_price_sale')";
      $result_C2 = mysql_query($query_C2);
      if (!$result_C2) { error("QUERY_ERROR"); exit; }
      
      // 상품 판매 후 재고 수량 [카트의 수량 만큼 공제]
      $query_hd1 = "SELECT uid,qty_sell,qty_now FROM shop_product_list_shop WHERE uid = '$new_uid'";
      $result_hd1 = mysql_query($query_hd1);
        if(!$result_hd1) { error("QUERY_ERROR"); exit; }
      $row_hd1 = mysql_fetch_object($result_hd1);

      $hd1_uid = $row_hd1->uid;
      $hd1_stock_sell = $row_hd1->qty_sell;
      $hd1_stock_now = $row_hd1->qty_now;
      
      $re1_stock_sell = $hd1_stock_sell + $new_qty_sell;
      $re1_stock_now = $hd1_stock_now - $new_qty_sell;
      
      $result_re1 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$re1_stock_sell', 
                    qty_now = '$re1_stock_now' WHERE uid = '$new_uid'",$dbconn);
      if(!$result_re1) { error("QUERY_ERROR"); exit; }
      
      
      // 상품 재고정보 수정 ------------------------------------------------------------------------- //
      $query_qs1 = "SELECT uid,stock_sell,stock_now FROM shop_product_list WHERE pcode = '$new_pcode'";
      $result_qs1 = mysql_query($query_qs1);
        if(!$result_qs1) { error("QUERY_ERROR"); exit; }
      $row_qs1 = mysql_fetch_object($result_qs1);

      $qs1_uid = $row_qs1->uid;
      $qs1_stock_sell = $row_qs1->stock_sell;
      $qs1_stock_now = $row_qs1->stock_now;
      
      $qs2_stock_sell = $qs1_stock_sell + $new_qty_sell;
      $qs2_stock_now = $qs1_stock_now - $new_qty_sell;
      
      
      $result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$qs2_stock_sell', 
                    stock_now = '$qs2_stock_now' WHERE pcode = '$new_pcode'",$dbconn);
      if(!$result_qs2) { error("QUERY_ERROR"); exit; }
      
      
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_order3B.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page'>");
      exit;
      
      
      }
      }





  } else if($add_mode == "update_all") { // 모든 상품 업데이트
  


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

        
        // Shop 하위 테이블 정보 업데이트 [동일한 상품코드에 동일한 상품 상세 정보]
        $result_UR = mysql_query("UPDATE shop_product_list_shop SET catg_code = '$R_catg_code', gcode = '$R_gcode', 
            pname = '$R_pname', gudang_code = '$R_gudang_code', supp_code = '$R_supp_code', 
            product_option1 = '$R_opt1', product_option2 = '$R_opt2', product_option3 = '$R_opt3', 
            product_option4 = '$R_opt4', product_option5 = '$R_opt5', 
            price_orgin = '$R_price_orgin', price_market = '$R_price_market', price_sale = '$R_price_sale', 
            price_sale2 = '$R_price_sale2', price_margin = '$R_price_margin', dc_rate = '$R_dc_rate', 
            save_point = '$R_save_point', sold_out = '$R_sold_out', post_date = '$R_post_date', 
            org_pcode = '$R_org_pcode' WHERE pcode = '$R_pcode'",$dbconn);
        if(!$result_UR) { error("QUERY_ERROR"); exit; }
        
      }
  
      // 리스트로 돌아가기
      echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_order3B.php?sorting_key=$sorting_key&key_shop=$key_shop&keyfield=$keyfield&key=$key&page=$page'>");
      exit;
  
  }

}

}
?>