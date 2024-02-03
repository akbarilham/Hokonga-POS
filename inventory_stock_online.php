<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_stock_online";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_stock_online.php?sorting_key=$sorting_key";
$link_list_action = "$home/inventory_stock_online.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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


// 공급자용 상품 코드 입력란 필요 여부



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
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$title_module_0201on?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_stock_online.php'>
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
			
			<form name='search' method='post' action='inventory_stock_online.php'>
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
            <th><?=$txt_invn_stockin_06?></th>
            <th><?=$txt_invn_stockin_05?></th>
			<th>Online</th>
			<th><?=$txt_invn_stockin_12?></th>
			<th><?=$txt_invn_stockin_17?></th>
			<th><?=$txt_hr_member_44?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,price_orgin,price_sale,price_margin,tstock_org,org_pcode,currency,photo1,onoff 
      FROM shop_product_catg ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,branch_code,catg_code,pcode,pname,price_orgin,price_sale,price_margin,tstock_org,org_pcode,currency,photo1,onoff 
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
   $prd_currency = mysql_result($result,$i,10);
   $prd_photo1 = mysql_result($result,$i,11);
   $prd_onoff = mysql_result($result,$i,12);
   
   // 하위 테이블에서 수량과 총매입액 추출
   $query_sub = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode LIKE '$prd_gcode%' AND flag = 'in'";
   $result_sub = mysql_query($query_sub);
   
   $sum_qty_org = @mysql_result($result_sub,0,0);
   
	$query_pic = "SELECT count(uid) FROM shop_product_catg_photo WHERE gcode = '$prd_gcode'";
	$result_pic = mysql_query($query_pic,$dbconn);
		if (!$result_pic) { error("QUERY_ERROR"); exit; }
	$total_pic = @mysql_result($result_pic,0,0);
	
	if($total_pic > 0) {
		$total_pic_txt = "$txt_comm_frm17 ($total_pic)";
	} else {
		$total_pic_txt = "$txt_comm_frm051s +";
	}
							
   
	// Display
	if($prd_onoff == "1") {
		$prd_onoff_txt = "<i class='fa fa-chain'></i>";
	} else {
		$prd_onoff_txt = "";
	}
	
	if($prd_photo1 != "") {
		$prd_photo1_txt = "<i class='fa fa-picture-o'></i>";
	} else {
		$prd_photo1_txt = "Add Photo";
	}
	
	

   
	if($uid == $prd_uid AND ( $mode == "upd_catg" OR $mode == "add_photo" OR $mode == "upd_photo" OR $mode == "del_photo")) {
		$highlight_color = "#FAFAB4";
	} else {
		$highlight_color = "#FFFFFF";
	}

  echo ("<tr>");
  // echo("<td bgcolor='$highlight_color'>$article_num</td>");
  
  echo("<td bgcolor='$highlight_color'>{$prd_gcode}</td>");
  echo("
        <td bgcolor='$highlight_color'><a href='$link_list_action&mode=upd_catg&uid=$prd_uid'>[$prd_org_pcode] {$prd_name} &nbsp; {$prd_photo1_txt}</a></td>
        <td bgcolor='$highlight_color'>$prd_onoff_txt</td>
		<td bgcolor='$highlight_color'>$prd_price_sale_K</td>
      ");


  echo("<td bgcolor='$highlight_color'><font color='navy'>$sum_qty_org</font></td>");
  echo("<td bgcolor='$highlight_color'><font color='navy'><a href='$link_list_action&mode=upd_photo&uid=$prd_uid'>{$total_pic_txt}</a></td>");
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
		
	
		<?
		$query_sw = "SELECT uid,dc_rate,save_point,sold_out,photo1,cnt_hit,display_type,onoff,
					pcode,org_pcode,org_barcode,catg_code,pname,price_buy,price_buy_cost,price_orgin,price_market,
					price_sale,price_sale2 FROM shop_product_catg WHERE uid = '$uid' ORDER BY uid DESC";
        $result_sw = mysql_query($query_sw,$dbconn);
			if (!$result_sw) { error("QUERY_ERROR"); exit; }   

        $sw_uid = @mysql_result($result_sw,0,0);
		$sw_dc_rate = @mysql_result($result_sw,0,1);
		$sw_save_point = @mysql_result($result_sw,0,2);
		$sw_sold_out = @mysql_result($result_sw,0,3);
		$sw_photo1 = @mysql_result($result_sw,0,4);
		$sw_cnt_hit = @mysql_result($result_sw,0,5);
		$sw_display_type = @mysql_result($result_sw,0,6);
		$sw_onoff = @mysql_result($result_sw,0,7);
		$sw_gcode = @mysql_result($result_sw,0,8);
		$sw_org_pcode = @mysql_result($result_sw,0,9);
		$sw_org_barcode = @mysql_result($result_sw,0,10);
		$sw_catg_code = @mysql_result($result_sw,0,11);
		$sw_pname = @mysql_result($result_sw,0,12);
		$sw_price_buy = @mysql_result($result_sw,0,13);
		$sw_price_buy_cost = @mysql_result($result_sw,0,14);
		$sw_price_orgin = @mysql_result($result_sw,0,15);
		$sw_price_market = @mysql_result($result_sw,0,16);
		$sw_price_sale = @mysql_result($result_sw,0,17);
		$sw_price_sale2 = @mysql_result($result_sw,0,18);
		
		
		
		$query_sw1 = "SELECT point_amount, dc_amount FROM client WHERE client_id = '$login_gate' ORDER BY uid DESC";
        $result_sw1 = mysql_query($query_sw1,$dbconn);
			if (!$result_sw1) { error("QUERY_ERROR"); exit; }   

        $sw1_save_rate = @mysql_result($result_sw1,0,0);
		$sw1_dc_rate = @mysql_result($result_sw1,0,1);
		
		// New D/C Rate & Mileage Point
		if($sw_dc_rate < 1) {
			$now_dc_rate = $sw1_dc_rate;
		} else {
			$now_dc_rate = $sw_dc_rate;
		}
		
		if($sw_save_point < 1) {
			$now_save_point = $sw_price_sale * ( $sw1_save_rate * 0.01);
		} else {
			$now_save_point = $sw_save_point;
		}
		
		// Description
		$query_sw2 = "SELECT uid,pname,simple_note,detail_note_nlbr,detail_note FROM shop_product_catg_detail 
						WHERE gcode = '$sw_gcode' AND lang = '$lang' AND gate = '$login_gate' ORDER BY uid DESC";
        $result_sw2 = mysql_query($query_sw2,$dbconn);
			if (!$result_sw2) { error("QUERY_ERROR"); exit; }   

        $sw2_uid = @mysql_result($result_sw2,0,0);
		$sw2_pname = @mysql_result($result_sw2,0,1);
			$sw2_pname = stripslashes($sw2_pname);
		$sw2_simple_note = @mysql_result($result_sw2,0,2);
			$sw2_simple_note = stripslashes($sw2_simple_note);
		$sw2_detail_note_nlbr = @mysql_result($result_sw2,0,3);
		$sw2_detail_note = @mysql_result($result_sw2,0,4);
			$sw2_detail_note = stripslashes($sw2_detail_note);
		
		if($sw2_uid < "1") {
			$sw_mode = "write";
			$sw_pnameB = $sw_pname;
		} else {
			$sw_mode = "modify";
			$sw_pnameB = $sw2_pname;
		}
		?>
		
		
		<? if($mode == "upd_catg" AND $uid) { ?>
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' ENCTYPE='multipart/form-data' action='inventory_stock_online.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		<input type='hidden' name='dtl_mode' value='<?=$sw_mode?>'>
		<input type='hidden' name='dtl_gcode' value='<?=$sw_gcode?>'>
		<input type='hidden' name='dtl1_uid' value='<?=$sw_uid?>'>
		<input type='hidden' name='dtl2_uid' value='<?=$sw2_uid?>'>
		<input type='hidden' name='dtl_photo1' value='<?=$sw_photo1?>'>
		<input type='hidden' name='stock_uid' value='<?=$uid?>'>

		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Item Category
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_061?></label>
										<div class="col-sm-3">
											<input disabled class="form-control" name="new_prd_code" value="<?=$sw_gcode?>" type="text" />
										</div>
										<div class="col-sm-3" align=right><?=$txt_invn_stockin_04?></div>
										<div class="col-sm-3">
											<input disabled class="form-control" name="s_cat_code" value="<?=$sw_catg_code?>" type="text" />
										</div>
										
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_30?></label>
                                        <div class="col-sm-3">
											<input disabled class="form-control" name="org_pcode" value="<?=$sw_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-3" align=right>Original Barcode</div>
                                        <div class="col-sm-3">
											<input class="form-control" name="org_barcode" value="<?=$sw_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_05?></label>
                                        <div class="col-sm-9">
											<input type="text" name="nsw_pname" class="form-control" value="<?=$sw_pnameB?>">
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner2_05?></label>
                                        <div class="col-sm-3">
											<select name='nsw_display_type' class="form-control">
											<?
											if($sw_display_type == "normal") {
												echo ("<option value='normal' selected>Normal</option>");
											} else {
												echo ("<option value='normal'>Normal</option>");
											}
											if($sw_display_type == "best") {
												echo ("<option value='best' selected>Best</option>");
											} else {
												echo ("<option value='best'>Best</option>");
											}
											if($sw_display_type == "cool") {
												echo ("<option value='cool' selected>Cool</option>");
											} else {
												echo ("<option value='cool'>Cool</option>");
											}
											if($sw_display_type == "brand") {
												echo ("<option value='brand' selected>Brand</option>");
											} else {
												echo ("<option value='brand'>Brand</option>");
											}
											?>
											</select>
										</div>
										<div class="col-sm-3">
											<?
											if($sw_onoff == "1") {
												echo ("<input type=radio name='nsw_onoff' value='1' checked> <font color=blue>On</font> &nbsp;&nbsp; ");
												echo ("<input type=radio name='nsw_onoff' value='0'> <font color=red>Off</font>");
											} else {
												echo ("<input type=radio name='nsw_onoff' value='1'> <font color=blue>On</font> &nbsp;&nbsp; ");
												echo ("<input type=radio name='nsw_onoff' value='0' checked> <font color=red>Off</font>");
											}
											?>
										</div>
										<div class="col-sm-3">
											<?
											if($sw_sold_out == "1") {
												echo ("<input type=checkbox name='nsw_sold_out' value='1' checked> <font color=red>Sold Out</font>");
											} else {
												echo ("<input type=checkbox name='nsw_sold_out' value='1'> <font color=red>Sold Out</font>");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$hsm_name_09_06?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="nsw_save_point" value="<?=$now_save_point?>" type="text" />
										</div>
										<div class="col-sm-3">
											( <?=$sw1_save_rate?>% )
										</div>
                                        <div class="col-sm-2">
											<input class="form-control" name="nsw_dc_rate" value="<?=$now_dc_rate?>" type="text" />
										</div>
										<div class="col-sm-1">
											%
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_07?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_price_buy" value="<?=$sw_price_buy?>" type="text" />
										</div>
										<label for="cname" class="control-label col-sm-3"><?=$title_module_0902?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_price_buy_cost" value="<?=$sw_price_buy_cost?>" type="text" />
										</div>
									</div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_10?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_price_market" value="<?=$sw_price_market?>" type="text" />
										</div>
										<label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_12?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="new_price_sale" value="<?=$sw_price_sale?>" type="text" />
										</div>
									</div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_stockin_43?></label>
                                        <div class="col-sm-9">
											<textarea name="nsw_simple_note" class="form-control"><?=$sw2_simple_note?></textarea>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
											<textarea name="nsw_detail_note" class="form-control" rows="8"><?=$sw2_detail_note?></textarea>
										</div>
                                    </div>
									
									<?
									// Image Directory
									$prdimgDir = "user_file";
									
									if($sw_photo1 != "") {
									?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"></label>
                                        <div class="col-sm-9">
											<img src='<?=$prdimgDir?>/<?=$sw_photo1?>' style='WIDTH: 320px' border=0>
										</div>
                                    </div>
									<? } ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_hr_member_44?></label>
                                        <div class="col-sm-9">
											<input class="form-control" name="photo1" type="file" />
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
		}
		?>
		</form>
		
		
		
		
		<? if($uid AND $mode == "upd_photo") { ?>
	
	
						<div class="row product-list">
							
							<?
							$query_qs1 = "SELECT count(uid) FROM shop_product_catg_photo WHERE gcode = '$sw_gcode'";
							$result_qs1 = mysql_query($query_qs1,$dbconn);
								if (!$result_qs1) { error("QUERY_ERROR"); exit; }
							$total_qs = @mysql_result($result_qs1,0,0);
	
							$query_qs2 = "SELECT uid,userfile,caption FROM shop_product_catg_photo WHERE gcode = '$sw_gcode' ORDER BY userfile ASC";
							$result_qs2 = mysql_query($query_qs2,$dbconn);
								if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

							for($qs = 0; $qs < $total_qs; $qs++) {
								$qs_uid = mysql_result($result_qs2,$qs,0);
								$qs_userfile = mysql_result($result_qs2,$qs,1);
								$qs_caption = mysql_result($result_qs2,$qs,2);
									// $qs_caption = stripslashes($qs_caption);
								$imageLoco = "user_file/$qs_userfile";
								
								$link_photo_upd = "process_stock_photo.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&stock_uid=$uid&qs_uid=$qs_uid&page=$page";
								$link_photo_del = "process_stock_photo.php?mode=del&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&stock_uid=$uid&qs_uid=$qs_uid&page=$page";
								?>

                          <div class="col-md-3">
                              <section class="panel">
                                  <div class="pro-img-box">
                                      <img src="<?=$imageLoco?>" alt=""/>
                                      <a href="<?=$link_photo_del?>" class="adtocart">
                                          <i class="fa fa-times"></i>
                                      </a>
                                  </div>

                                  <div class="panel-body text-center">
                                      <h4>
                                          <a href="#" class="pro-title">
                                              <?=$qs_caption?>
                                          </a>
                                      </h4>
                                  </div>
                              </section>
                          </div>

							<? } ?>
							
                      </div>
					  

		<form name='signform2' class="cmxform form-horizontal adminex-form" method='post' ENCTYPE='multipart/form-data' action='inventory_stock_online.php'>
		<input type='hidden' name='step_next' value='permit_post'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		<input type='hidden' name='dtl_gcode' value='<?=$sw_gcode?>'>
		<input type='hidden' name='stock_uid' value='<?=$uid?>'>
									
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <div class="panel-body">
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_hr_member_44?></label>
                                        <div class="col-sm-6">
											<input class="form-control" name="userphoto" type="file" required />
										</div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"></label>
                                        <div class="col-sm-6">
											<textarea class="form-control" name="usermemo"></textarea>
										</div>
                                        <div class="col-sm-3">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm03?>">
                                        </div>
                                    </div>
		</div>
		</section>
		</div>
		</div>
		</form>
	
	
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
	
	$savedir = "user_file";

	// Variables
	if(!$nsw_sold_out) { $nsw_sold_out = "0"; }
	
	$nsw_pname = addslashes($nsw_pname);
	$nsw_simple_note = addslashes($nsw_simple_note);
	$nsw_detail_note = addslashes($nsw_detail_note);
	
	// Currency
	$nsw_currency = "IDR";
	
	
	// Prices
    $new_price_orgin = $new_price_buy + $new_price_buy_cost;
    $new_price_margin = $new_price_sale - $new_price_orgin;

    if($new_price_market < "1" OR $new_price_market == "") {
      $new_price_market = $new_price_sale;
    }
	
	
	// Photo Upload
	if($photo1 != "") {
			$full_filename = explode(".", "$photo1_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(strcmp($extension,"JPG") AND 
			   strcmp($extension,"jpg") AND
			   strcmp($extension,"GIF") AND
			   strcmp($extension,"gif") AND
			   strcmp($extension,"PNG") AND
			   strcmp($extension,"png")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}
			
			$new_filename = "img1_"."$signdate".".{$extension}";

			if($photo1 != "") {
			if(!copy("$photo1","$savedir/$photo1_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$photo1_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			}
			
			$query_P1 = "UPDATE shop_product_catg SET photo1 = '$new_filename' WHERE uid = '$dtl1_uid'";
			$result_P1 = mysql_query($query_P1);
			if (!$result_P1) { error("QUERY_ERROR"); exit; }
	}
	
	
	
		// Update
		$query_M1 = "UPDATE shop_product_catg SET dc_rate = '$nsw_dc_rate', save_point = '$nsw_save_point', sold_out = '$nsw_sold_out', 
					display_type = '$nsw_display_type', onoff = '$nsw_onoff', currency = '$nsw_currency', 
					price_buy = '$new_price_buy', price_buy_cost = '$new_price_buy_cost', price_orgin = '$new_price_orgin', price_market = '$new_price_market', 
					price_sale = '$new_price_sale', price_sale2 = '$new_price_sale', price_margin = '$new_price_margin' WHERE uid = '$dtl1_uid'";
		$result_M1 = mysql_query($query_M1);
		if (!$result_M1) { error("QUERY_ERROR"); exit; }
	  
  
  
		if($dtl_mode == "modify") {

			$result_T = mysql_query("UPDATE shop_product_catg_detail SET simple_note = '$nsw_simple_note', 
					detail_note = '$nsw_detail_note' WHERE uid = '$dtl2_uid'",$dbconn);
			if(!$result_T) { error("QUERY_ERROR"); exit; }
		
		} else if($dtl_mode == "write") {
		
			$query_S1 = "INSERT INTO shop_product_catg_detail (uid,branch_code,gate,gcode,simple_note,detail_note,lang) 
					values ('','$login_branch','$login_gate','$dtl_gcode','$nsw_simple_note','$nsw_detail_note','$lang')";
			$result_S1 = mysql_query($query_S1);
			if (!$result_S1) { error("QUERY_ERROR"); exit; }

		}


    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_online.php?mode=upd_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&uid=$new_catg_uid&page=$page'>");
    exit;


} else if($step_next == "permit_post") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	
	$savedir = "user_file";
	$usermemo = addslashes($usermemo);
	
	
	
			$full_filename = explode(".", "$userphoto_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(strcmp($extension,"JPG") AND 
			   strcmp($extension,"jpg") AND
			   strcmp($extension,"GIF") AND
			   strcmp($extension,"gif") AND
			   strcmp($extension,"PNG") AND
			   strcmp($extension,"png")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}
			
			$new_filename = "imgs_"."$signdate".".{$extension}";

			if($userphoto != "") {
			if(!copy("$userphoto","$savedir/$userphoto_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$userphoto_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			}
			
			$query_F1  = "INSERT INTO shop_product_catg_photo (uid, branch_code, gate, gcode, userfile, caption, upd_date)
				VALUES ('', '$login_branch', '$login_gate', '$dtl_gcode', '$new_filename', '$usermemo', '$post_dates')";
			$result_F1 = mysql_query($query_F1);
			if (!$result_F1) { error("QUERY_ERROR"); exit; }
			


    echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_online.php?mode=upd_photo&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&mode=upd_photo&uid=$stock_uid&page=$page'>");
    exit;


}

}
?>