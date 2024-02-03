<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$step_next) {
?>


<!DOCTYPE<!DOCTYPE html>
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
	
	<SCRIPT LANGUAGE="JavaScript">
<!-- 
function setFocus(formNo, elementNo) {
  if (document.forms.length > 0) {
   document.forms[formNo].elements[elementNo].focus();
  }
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
  
  


<body bgcolor="#FFFFFF" leftmarign=0 topmargin=0 onLoad="setFocus(0,1);">

<?
// 오늘 날짜
  $signdate = time();

  // 오늘 날짜를 년월일별로 구하기
  $today = date("Ymd");
  $this_year = date("Y");
  $this_month = date("m");
  $this_yearmonth = date("ym");
  $this_date = date("d");
  $this_week = date("D");
	      
  if(!$p_date_set) { $p_date_set = date("Ymd",$signdate); }

  if(!$p_year) { $p_year = date("Y",$signdate); }
  if(!$p_yearmonth) { $p_yearmonth = date("Ym",$signdate); }
  if(!$p_month) { $p_month = date("m",$signdate); }
  if(!$p_date) { $p_date = date("d",$signdate); }
  if(!$p_hour) { $p_hour = date("H",$signdate); }
  
  
$style_box_blue = "BACKGROUND-COLOR: #FFFFFF; FONT-FAMILY: Verdana, Arial, 돋움, 굴림; FONT-SIZE: 9pt; BORDER-BOTTOM: blue 1px solid; BORDER-LEFT: blue 1px solid; BORDER-RIGHT: blue 1px solid; BORDER-TOP: blue 1px solid; HEIGHT: 20px";
$sorting_filter = "branch_code = '$login_branch' AND shop_code = '$login_shop'";

// 장바구니에 담긴 상품 수
$query_HC = "SELECT count(uid) FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0'";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$total_HC = @mysql_result($result_HC,0,0);
?>


<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
  <td height=30 align=right>
    <i class="fa fa-caret-up"></i>
    <a href="sales_order2.php?lang=<?=$lang?>&loco=page_client"><?=$web_erp_name?></a> &nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td>
    <table width=100% cellspacing=1 cellpadding=1 border=0>
    <tr>
      <td align=center bgcolor=#FFFFFF valign=top>
      
          <table width=100% height=200 cellspacing=0 cellpadding=0 border=0>
          <tr>
			<td width=5%></td>
            <td width=50% align=center valign=top>
			
				<br>

                <table width=90% class='display table table-bordered'>
                
                <?
                // 장바구니
                $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5,shop_code,
							org_pcode,org_barcode FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' ORDER BY date ASC";
                $result_H = mysql_query($query_H);
                if (!$result_H) {   error("QUERY_ERROR");   exit; }
                
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
				  $H_org_pcode = mysql_result($result_H,$h,12);
				  $H_org_barcode = mysql_result($result_H,$h,13);
      
                  if($H_p_color != "") { $H_p_color_txt = "[$H_p_color]"; } else { $H_p_color_txt = ""; }
                  if($H_p_size != "") { $H_p_size_txt = "[$H_p_size]"; } else { $H_p_size_txt = ""; }
                  if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
                  if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
                  if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
                  if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
                  if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
                  $H_option_list = "{$H_p_opt1_txt}{$H_p_opt2_txt}";

				  
                  // 상품명, 상품별 결제액
				  $query_li = "SELECT pname,price_sale FROM shop_product_list_shop WHERE pcode = '$H_pcode' AND shop_code = '$login_shop' ORDER BY uid DESC";
                  $result_li = mysql_query($query_li);
                  if (!$result_li) {   error("QUERY_ERROR");   exit; }
                  $li_pname = @mysql_result($result_li,0,0);
					$li_pname = stripslashes($li_pname);
				  $li_price_sale = @mysql_result($result_li,0,1);
					$li_price_sale_K = number_format($li_price_sale);
				  
				  // Total
				  $li_tprice_sale = $li_price_sale * $H_qty;
					$li_tprice_sale_K = number_format($li_tprice_sale);
				  
				  
				  // Grand Total
                  $p_total_price = $p_total_price + ($li_price_sale * $H_qty);
                  $p_total_price_K = number_format($p_total_price);
                  
                  echo ("
                  <tr>
                    <td height=22 align=center>$cart_no</td>
                    <td align=center>$H_org_pcode</td>
                    <td>{$li_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5_txt}</td>
                    <td align=right>$li_price_sale_K</td>
                    <td align=right>$H_qty</td>
                    <td align=right>$li_tprice_sale_K</td>
                  </tr>
                  <tr>
                  <!--<tr><td colspan=6 height=2 bgcolor=#FFFFFF></td></tr>-->
                  ");

                  $cart_no++;
                }
                ?>
        
        
      
                <tr>
                  <td colspan=4 height=24 align=center><b>TOTAL</b></td>
                  <td colspan=2 height=24 align=right><b><?=$p_total_price_K?></b>&nbsp;</td>
                </tr>
                </table>
            
            
            
            </td>
            
            
            
            <td width=45% align=center>
                <table width=100% cellspacing=0 cellpadding=0 border=0>
                <form name="search" method="post" action="sales_pos.php">
                <input type="hidden" name="step_next" value="permit_okay">
                <tr>
                  <td align=center>
                    <input type="text" name="new_scan_barcode" style="WIDTH: 200px; HEIGHT: 34px" autofocus>
                    <input type="text" name="new_scan_qty" value="1" style="WIDTH: 40px; HEIGHT: 34px; text-align: center">
                    <input type="submit" value="<?=$txt_comm_frm26?>" class="btn btn-default">
                  </td>
                </tr>
                </form>
                
                <tr><td height=10></td></tr>
                
                <form name="search" method="post" action="sales_order2.php">
                <input type="hidden" name="lang" value="<?=$lang?>">
                <input type="hidden" name="loco" value="page_client">
                <tr>
                  <td align=center>
                    <!--<input type="submit" value="<?=$txt_sales_sales_06?>" style="<?=$style_box?>; WIDTH: 294px">-->
                    <input type="submit" id='btn_cash' name="btn_kas" class="btn btn-primary" value="Cash" />
					<input type="submit" id='btn_credit' name="btn_hutang" class="btn btn-primary" value="Credit" />
		    </td>
                </tr>
                </form>
                
                </table>
                
            </td>
          </tr>
          </table>
          
      </td>
    </tr>
    </table>
  </td>
</tr>
<tr><td height=10></td></tr>
<tr>
  <td align=center height=20>
    <?
    // Footer Menu
    
    
    echo ("
      <!--<a href='http://barcode.inkoptan.net/html/code39.php' target='_web'>$frn1_mmenu_01</a> &nbsp;&nbsp; -->
      <a href='sales_order2.php?lang=$lang&loco=page_client'>$frn1_mmenu_02</a> &nbsp;&nbsp; 
      <!--<a href='sales_payment.php?lang=$lang&loco=page_client''>$frn1_mmenu_03</a> &nbsp;&nbsp; -->
      <!--<a href='../../page_client/sales/report_sales_daily.php?p_year=$p_year&p_month=$p_month&p_date=$p_date&p_date_set=$p_date_set'>$frn1_mmenu_04</a> &nbsp;&nbsp; -->
      <!--<a onClick=\"Popup_Win('../../page_client/sales/report_sales_daily_print.php?p_date_set=$p_date_set')\">$frn1_mmenu_05</a>-->
    ");
    ?>
  
  </td>
</tr>

<tr><td height=40>&nbsp;</td></tr>
</table>

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


      // 동일한 SHOP의 제품만을 장바구니에 담을 수 있음
      $query_K = "SELECT shop_code FROM shop_cart WHERE user_id = '$login_id' AND f_class = 'in' AND expire = '0' ORDER BY uid ASC";
      $result_K = mysql_query($query_K);
      if (!$result_K) {   error("QUERY_ERROR");   exit; }
      
        $K_cart_shop = mysql_result($result_K,0,0);  // SHOP Code 추출
        
      if($K_cart_shop AND $login_shop != $K_cart_shop) {
        popup_msg("$txt_sales_sales_chk05");
        exit;
      } else {

     
      // 남은 재고 수량이 0보다 커야하고 판매할 수량을 공제한 수량이 음수가 될 수 없음
      $query_os = "SELECT qty_now FROM shop_product_list_shop WHERE org_barcode = '$new_scan_barcode' AND shop_code = '$login_shop'";
      $result_os = mysql_query($query_os);
        if(!$result_os) { error("QUERY_ERROR"); exit; }
      $row_os = mysql_fetch_object($result_os);

      $os_stock_now = $row_os->qty_now;
      $check_stock_now = $os_stock_now - $new_scan_qty + 1;
      
      if($check_stock_now > 0) {

      
        // 상품 상세 정보 추출
        $query_upd = "SELECT uid,pcode,org_pcode,gudang_code,supp_code,
                        product_option1,product_option2,product_option3,product_option4,product_option5,price_market,price_sale
                        FROM shop_product_list_shop WHERE org_barcode = '$new_scan_barcode' AND shop_code = '$login_shop'";
        $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
        $row_upd = mysql_fetch_object($result_upd);

        if($row_upd) {

          $upd_uid = $row_upd->uid;
		  $upd_pcode = $row_upd->pcode;
		  $upd_org_pcode = $row_upd->org_pcode;
		  $upd_gudang_code = $row_upd->gudang_code;
          $upd_supp_code = $row_upd->supp_code;
          $upd_p_option1 = $row_upd->product_option1;
          $upd_p_option2 = $row_upd->product_option2;
          $upd_p_option3 = $row_upd->product_option3;
          $upd_p_option4 = $row_upd->product_option4;
          $upd_p_option5 = $row_upd->product_option5;
          $upd_price_market = $row_upd->price_market;
          $upd_price_sale = $row_upd->price_sale;
		  
			$query_li = "SELECT pname,price_market,price_sale FROM shop_product_list WHERE pcode = '$H_pcode' ORDER BY uid DESC";
            $result_li = mysql_query($query_li);
                if (!$result_li) {   error("QUERY_ERROR");   exit; }
            $li_pname = @mysql_result($result_li,0,0);
				$li_pname = stripslashes($li_pname);
			$li_price_market = @mysql_result($result_li,0,1);
			$li_price_sale = @mysql_result($result_li,0,2);
			
			if($upd_price_market < 1) {
				$upd_price_market = $li_price_market;
			}
			if($upd_price_sale < 1) {
				$upd_price_sale = $li_price_sale;
			}
      

			// 카트정보 입력
			$query_C2 = "INSERT INTO shop_cart (uid,prd_uid,branch_code,gate,f_class,user_id,user_ip,pcode,org_pcode,org_barcode,
				qty,p_option1,p_option2,p_option3,p_option4,p_option5,expire,date,p_price,p_saleprice,p_name) values 
				('','$upd_uid','$login_branch','$login_shop','in','$login_id','$m_ip','$upd_pcode','$upd_barcode','$new_scan_barcode',
				'$new_scan_qty','$upd_product_option1','$upd_product_option2','$upd_product_option3','$upd_product_option4','$upd_product_option5',
				'0','$post_dates','$upd_price_market','$upd_price_sale','$li_pname')";
			$result_C2 = mysql_query($query_C2);
			if (!$result_C2) { error("QUERY_ERROR"); exit; }
      
			// 상품 판매 후 재고 수량 [카트의 수량 만큼 공제]
			$query_hd1 = "SELECT uid,qty_sell,qty_now FROM shop_product_list_shop 
                    WHERE org_barcode = '$new_scan_barcode' AND shop_code = '$login_shop'";
			$result_hd1 = mysql_query($query_hd1);
				if(!$result_hd1) { error("QUERY_ERROR"); exit; }
			$row_hd1 = mysql_fetch_object($result_hd1);

			$hd1_uid = $row_hd1->uid;
			$hd1_stock_sell = $row_hd1->qty_sell;
			$hd1_stock_now = $row_hd1->qty_now;
      
			$re1_stock_sell = $hd1_stock_sell + $new_scan_qty;
			$re1_stock_now = $hd1_stock_now - $new_scan_qty;
      
			$result_re1 = mysql_query("UPDATE shop_product_list_shop SET qty_sell = '$re1_stock_sell', 
                    qty_now = '$re1_stock_now' WHERE org_barcode = '$new_scan_barcode' AND shop_code = '$login_shop'",$dbconn);
			if(!$result_re1) { error("QUERY_ERROR"); exit; }
      
      
			// 상품 재고정보 수정 ------------------------------------------------------------------------- //
			$query_qs1 = "SELECT uid,stock_sell,stock_now FROM shop_product_list WHERE org_barcode = '$new_scan_barcode'";
			$result_qs1 = mysql_query($query_qs1);
				if(!$result_qs1) { error("QUERY_ERROR"); exit; }
			$row_qs1 = mysql_fetch_object($result_qs1);

			$qs1_uid = $row_qs1->uid;
			$qs1_stock_sell = $row_qs1->stock_sell;
			$qs1_stock_now = $row_qs1->stock_now;
      
			$qs2_stock_sell = $qs1_stock_sell + $new_scan_qty;
			$qs2_stock_now = $qs1_stock_now - $new_scan_qty;
      
      
			$result_qs2 = mysql_query("UPDATE shop_product_list SET stock_sell = '$qs2_stock_sell', 
                    stock_now = '$qs2_stock_now' WHERE org_barcode = '$new_scan_barcode'",$dbconn);
			if(!$result_qs2) { error("QUERY_ERROR"); exit; }

        }
      
      
      }

      }


  // 리스트로 돌아가기
  echo("<meta http-equiv='Refresh' content='0; URL=$home/sales_pos.php'>");
  exit;

}

}
?>
