<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_payment2";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_payment2.php?sorting_key=$sorting_key";
$link_upd = "$home/inventory_payment2.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_list1 = "$home/inventory_payment.php?sorting_key=$sorting_key";
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
	
<SCRIPT LANGUAGE="JavaScript"> 
<!-- 
function imgResize(img){ 
  img1= new Image(); 
  img1.src=(img); 
  imgControll(img); 
} 

function imgControll(img){ 
  if((img1.width!=0)&&(img1.height!=0)){ 
    viewImage(img); 
  } 
  else{ 
    controller="imgControll('"+img+"')"; 
    intervalID=setTimeout(controller,20); 
  } 
} 

function viewImage(img){ 
        W=img1.width; 
        H=img1.height; 
        O="width="+W+",height="+H; 
        imgWin=window.open("","",O); 
        imgWin.document.write("<html><head><title>Image Preview</title></head>");
        imgWin.document.write("<body topmargin=0 leftmargin=0>");
        imgWin.document.write("<img src="+img+" onclick='self.close()'>");
        imgWin.document.close();
} 
//  --> 
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
$sorting_filter = "f_class = 'out'";
$sorting_filter_G = "userlevel < '6'";


// 정렬 필터링
if(!$sorting_key) { $sorting_key = "pay_date"; }
if($sorting_key == "pay_date") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pay_num") { $chk1 = "selected"; } else { $chk1 = ""; }


if(!$page) { $page = 1; }


// 총 자료수
$queryAll = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter";
$resultAll = mysql_query($queryAll,$dbconn);
if (!$resultAll) {
   error("QUERY_ERROR");
   exit;
}
$all_record = mysql_result($resultAll,0,0);


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_payment WHERE $sorting_filter AND $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_04_05?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<form name='search' method='post' action='inventory_payment2.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='pay_date'>$txt_invn_payment_03s</option>
				<option value='pay_num' $chk1>Pay. Code</option>
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
			<option value='$PHP_SELF?sorting_key=pay_num&keyfield=$keyfield&key=$key' $chk1>Pay. Code</option>
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
            <th><?=$txt_invn_payment_15?></th>
            <th><?=$txt_invn_payment_02?></th>
			<th>Warehouse Receipt</th>
			<th colspan=2><?=$txt_invn_payment_03?></th>
			<th><?=$txt_invn_return_03?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gate,pay_num,pay_type,pay_state,pay_amount,pay_date,client_code,loan_flag,confirm_status,confirm_date 
      FROM shop_payment WHERE $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gate,pay_num,pay_type,pay_state,pay_amount,pay_date,client_code,loan_flag,confirm_status,confirm_date 
      FROM shop_payment WHERE $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $pay_uid = mysql_result($result,$i,0);   
   $pay_gate = mysql_result($result,$i,1);
   $pay_num = mysql_result($result,$i,2);
   $pay_type = mysql_result($result,$i,3);
   $pay_status = mysql_result($result,$i,4);
   $pay_amount = mysql_result($result,$i,5);
      $pay_amount_K = number_format($pay_amount);
   $pay_date = mysql_result($result,$i,6);
   $f_client_code = mysql_result($result,$i,7);
   $f_loan_flag = mysql_result($result,$i,8);
   $f_confirm_status = mysql_result($result,$i,9);
   $f_confirm_date = mysql_result($result,$i,10);
   
   
    // 영수증 유무
    $rf_query = "SELECT uid,rct_no,pay_num,rct_amount,rct_date,userfile FROM shop_payment_receipt 
                WHERE pay_num = '$pay_num'";
    $rf_result = mysql_query($rf_query);
    if (!$rf_result) { error("QUERY_ERROR"); exit; }
    
    $rctf_uid = @mysql_result($rf_result,0,0);
    $rctf_no = @mysql_result($rf_result,0,1);
    $rctf_pay_num = @mysql_result($rf_result,0,2);
    $rctf_amount = @mysql_result($rf_result,0,3);
    $rctf_date = @mysql_result($rf_result,0,4);
    $rctf_userfile = @mysql_result($rf_result,0,5);
    
    $imageLoco1 = "../../bbs/user_file/$rctf_userfile";
   
    if($rctf_uid) {
      if($rctf_userfile != "") {
        $rctf_link1 = "<a href=\"javascript:imgResize('$imageLoco1')\"><font color=blue>$rctf_no</font></a>";
      } else {
        $rctf_link1 = "<font color=red>$rctf_no</font>";
      }
    } else {
        $rctf_link1 = "";
    }
   
   // 결제일
   $cday1 = substr($f_confirm_date,0,4);
	 $cday2 = substr($f_confirm_date,4,2);
	 $cday3 = substr($f_confirm_date,6,2);
	 $cday4 = substr($f_confirm_date,8,2);
	 $cday5 = substr($f_confirm_date,10,2);
	 $cday6 = substr($f_confirm_date,12,2);
   
   $uday1 = substr($pay_date,0,4);
	 $uday2 = substr($pay_date,4,2);
	 $uday3 = substr($pay_date,6,2);
	 $uday4 = substr($pay_date,8,2);
	 $uday5 = substr($pay_date,10,2);
	 $uday6 = substr($pay_date,12,2);

   // if($pay_status == "2" AND $f_loan_flag == "1") {
   //    if($lang == "ko") {
	 //      $pay_date_txt = "$cday1"."/"."$cday2"."/"."$cday3".", "."$cday4".":"."$cday5".":"."$cday6";
	 //    } else {
	 //      $pay_date_txt = "$cday3"."-"."$cday2"."-"."$cday1".", "."$cday4".":"."$cday5".":"."$cday6";
	 //    }
   // } else {
    if($lang == "ko") {
	    $pay_date_txt = "<font color=#222222>"."$uday1"."/"."$uday2"."/"."$uday3".", "."$uday4".":"."$uday5".":"."$uday6"."</font>";
	  } else {
	    $pay_date_txt = "<font color=#222222>"."$uday3"."-"."$uday2"."-"."$uday1".", "."$uday4".":"."$uday5".":"."$uday6"."</font>";
	  }
   // }
   
   
    
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
    if($f_client_code == "") {
      $f_client_alert = "&nbsp;<font color=red>[?]</font>";
    } else {
      $f_client_alert = "";
    }
    
    if($pay_status == "2") {
          $prc_status_txt = "<font color=blue>$txt_invn_payment_06</font>"; // 지불완료[마감]
    } else if($pay_status == "1") {
        if($f_confirm_status == "2") {
          $prc_status_txt = "<font color=black>Confirmed</font>"; // 처리중
        } else {
          $prc_status_txt = "<font color=red>$txt_invn_return_09s</font>"; // 처리중
        }
    } else {
          $prc_status_txt = "<font color=red>$txt_invn_payment_05s</font>"; // 미지불
    }

    // 줄 색깔
    if($uid == $pay_uid AND $mode == "check") {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    if($f_loan_flag == "1") {
      $f_loan_txt = "<font color=blue>[ LOAN ]</font>";
    } else {
      $f_loan_txt = "";
    }


  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  // echo("<td bgcolor='$highlight_color'>&nbsp;{$pay_gate}</td>");
  echo("<td bgcolor='$highlight_color'><a href='$link_upd&mode=check&uid=$pay_uid'>{$pay_num}</a> $f_loan_txt</td>");
  echo("<td bgcolor='$highlight_color' align=right><a href='$link_upd&mode=check&uid=$pay_uid'>{$pay_amount_K}</a></td>");

  echo("<td bgcolor='$highlight_color'>$rctf_link1</td>");

  echo("<td colspan=2 bgcolor='$highlight_color'>{$pay_date_txt}</td>");
  echo("<td bgcolor='$highlight_color'>{$prc_status_txt}{$f_client_alert}</td>");
  echo("</tr>");
  
  if($mode == "check" AND $pay_uid == $uid) {
  
    // 상세 리스트 [카트]
    $query_HC = "SELECT count(uid) FROM shop_cart WHERE pay_num = '$pay_num'";
    $result_HC = mysql_query($query_HC);
    if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
    $total_HC = @mysql_result($result_HC,0,0);
    
    $query_H = "SELECT uid,prd_uid,pcode,qty,product_color,product_size,p_option1,p_option2,p_option3,p_option4,p_option5 
      FROM shop_cart WHERE pay_num = '$pay_num' ORDER BY pcode ASC";
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
      
      if($H_p_color != "") { $H_p_color_txt = "$H_p_color"."|"; } else { $H_p_color_txt = ""; }
      if($H_p_size != "") { $H_p_size_txt = "$H_p_size"."/"; } else { $H_p_size_txt = ""; }
      if($H_p_opt1 != "") { $H_p_opt1_txt = "[$H_p_opt1]"; } else { $H_p_opt1_txt = ""; }
      if($H_p_opt2 != "") { $H_p_opt2_txt = "[$H_p_opt2]"; } else { $H_p_opt2_txt = ""; }
      if($H_p_opt3 != "") { $H_p_opt3_txt = "[$H_p_opt3]"; } else { $H_p_opt3_txt = ""; }
      if($H_p_opt4 != "") { $H_p_opt4_txt = "[$H_p_opt4]"; } else { $H_p_opt4_txt = ""; }
      if($H_p_opt5 != "") { $H_p_opt5_txt = "[$H_p_opt5]"; } else { $H_p_opt5_txt = ""; }
      
      
      
      // 상품명, 상품별 결제액
      $query_dari = "SELECT uid,pname,price_orgin FROM shop_product_list WHERE pcode = '$H_pcode'";
      $result_dari = mysql_query($query_dari);
      if(!$result_dari) { error("QUERY_ERROR"); exit; }
      $row_dari = mysql_fetch_object($result_dari);

      $dari_uid = $row_dari->uid;
      $dari_pname = $row_dari->pname;
      $dari_amount = $row_dari->price_orgin;
      
      $dari_tamount = $dari_amount * $H_qty;
      
      $dari_amount_K = number_format($dari_amount);
      $dari_tamount_K = number_format($dari_tamount);
      
      
      echo ("
        <tr>
			<td align=right><i class='fa fa-caret-right'></i></td>
			<td colspan=3>[$H_pcode] {$dari_pname} {$H_p_opt1_txt}{$H_p_opt2_txt}{$H_p_opt3_txt}{$H_p_opt4_txt}{$H_p_opt5}</td>
            <td align=right>$dari_amount_K</td>
            <td align=right>$H_qty</td>
            <td align=right>$dari_tamount_K</td>
        </tr>");
    $cart_no++;
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
		
	
		

		
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action="inventory_payment2.php">
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		
		<?
		if($mode == "check" AND $uid) { // 결제정보 변경

          // 결제 정보 테이블
          $pm_query = "SELECT uid,pay_num,bank_name,pay_type,pay_bank,remit_code,pay_date,pay_state,
                      branch_code,gate,pay_amount,client_code,loan_flag,loan_trans_code FROM shop_payment WHERE uid = '$uid'";
          $pm_result = mysql_query($pm_query);
          if (!$pm_result) { error("QUERY_ERROR"); exit; }
    
          $pm_uid = @mysql_result($pm_result,0,0);
          $pm_pay_num = @mysql_result($pm_result,0,1);
          $pm_bank_name = @mysql_result($pm_result,0,2);
          $pm_pay_type = @mysql_result($pm_result,0,3);
          $pm_pay_bank = @mysql_result($pm_result,0,4);
          $pm_remit_code = @mysql_result($pm_result,0,5);
          $upd_pay_date = @mysql_result($pm_result,0,6);
          $upd_pay_status = @mysql_result($pm_result,0,7);
          $upd_branch_code = @mysql_result($pm_result,0,8);
          $upd_gate = @mysql_result($pm_result,0,9);
          $upd_pay_amount = @mysql_result($pm_result,0,10);
            $upd_pay_amount_K = number_format($upd_pay_amount);
          $upd_client_code = @mysql_result($pm_result,0,11);
          $pm_loan_flag = @mysql_result($pm_result,0,12);
          $pm_trans_code = @mysql_result($pm_result,0,13);
          
          // 대출 정보
          $pm2_query = "SELECT uid,loan_code,pay_num FROM loan_transaction WHERE trans_code = '$pm_trans_code'";
          $pm2_result = mysql_query($pm2_query);
          if (!$pm2_result) { error("QUERY_ERROR"); exit; }
          
          $pm_loan_uid = @mysql_result($pm2_result,0,0);
          $pm_loan_code = @mysql_result($pm2_result,0,1);
          $pm_loan_pay_num = @mysql_result($pm2_result,0,2);
          
          $pm3_query = "SELECT loan_name FROM loan WHERE loan_code = '$pm_loan_code'";
          $pm3_result = mysql_query($pm3_query);
          if (!$pm3_result) { error("QUERY_ERROR"); exit; }
          
          $pm_loan_name = @mysql_result($pm3_result,0,0);
          
          
          if($pm_pay_type == "cash") { $pay_type_slc_cash = "selected"; } else { $pay_type_slc_cash = ""; }
          if($pm_pay_type == "bank") { $pay_type_slc_bank = "selected"; } else { $pay_type_slc_bank = ""; }
          if($pm_pay_type == "account") { $pay_type_slc_account = "selected"; } else { $pay_type_slc_account = ""; }
          if($pm_pay_type == "card") { $pay_type_slc_card = "selected"; } else { $pay_type_slc_card = ""; }
          if($pm_pay_type == "voucher") { $pay_type_slc_voucher = "selected"; } else { $pay_type_slc_voucher = ""; }
          
          // 처리 버튼
          if($upd_pay_status == "2") {
            $submit_txt = $txt_invn_payment_14;
          } else if($upd_pay_status == "1") {
            $submit_txt = $txt_invn_payment_14;
          } else {
            $submit_txt = $txt_invn_payment_09;
          }

            // 지불일
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
          
          // 총 수량
          $query_qt1 = "SELECT sum(qty) FROM shop_cart WHERE f_class = 'out' AND pay_num = '$pm_pay_num'";
          $result_qt1 = mysql_query($query_qt1);
          $sum_qt1 = @mysql_result($result_qt1,0,0);
          $sum_qt1_K = number_format($sum_qt1);
          
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_CHG'>
      <input type=hidden name='org_branch_code' value='$upd_branch_code'>
      <input type=hidden name='org_supp_code' value='$upd_client_code'>
      <input type=hidden name='org_gate' value='$upd_gate'>
      <input type=hidden name='org_tprice_orgin' value='$upd_pay_amount'>
      
      <input type=hidden name='org_pay_uid' value='$pm_uid'>
      <input type=hidden name='org_pay_num' value='$pm_pay_num'>
      <input type=hidden name='org_pay_qty' value='$sum_qt1'>
      
      <input type=hidden name='org_loan_flag' value='$pm_loan_flag'>
      <input type=hidden name='org_trans_code' value='$pm_trans_code'>
      <input type=hidden name='org_loan_uid' value='$pm_loan_uid'>
      <input type=hidden name='org_loan_pay_num' value='$pm_loan_pay_num'>");
	  ?>
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Payment Confirmation Form
			
            
        </header>
		
        <div class="panel-body">
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_payment_15?></label>
										<div class="col-sm-4">
											<input disabled class="form-control" name="dis_pay_code" value="<?=$pm_pay_num?>" type="text" required />
										</div>
										<div class="col-sm-2" align=right><?=$txt_sys_user_07?></div>
										<div class="col-sm-3">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_client" value="<?=$upd_gate?>" type="text" required />
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
                
												if($supp_code == $upd_client_code) {
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
									// Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_02</label>
                                        <div class='col-sm-3'>
											<input class='form-control' name='dis_new_tprice_orgin' value='$upd_pay_amount_K' style='text-align: right'>
										</div>
										<div class='col-sm-2'>
											($sum_qt1_K)
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
											<input class='form-control' name='new_bank_name' value='$pm_bank_name'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_12</label>
                                        <div class='col-sm-9'>
											<input class='form-control' name='new_pay_bank' value='$pm_pay_bank'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_13</label>
                                        <div class='col-sm-9'>
											<input class='form-control' name='new_remit_code' value='$pm_remit_code'>
										</div>
                                    </div>
									
									<!---------- loan request module here // --------------------------------------->
									
									
									<!---------- payment status // -------------------------------------------------->
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_payment_08</label>
                                        <div class='col-sm-9'>");
											if($upd_pay_status == "2") {
													echo("
													<input type=radio name='new_pay_status' value='' checked> <font color=blue>$txt_invn_payment_06</font> &nbsp;&nbsp; 
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
											<input type='text' disabled class='form-control' name='dis_pay_num' value='$pm_pay_num'>
										</div>
										<div class='col-sm-2' align=right>$txt_invn_payment_03</div>
										<div class='col-sm-3'>
											<input disabled class='form-control' name='dis_pay_date' value='$upd_pay_dates'>
										</div>
                                    </div>");
									
									}
									
									
									
									
									// Data Entry into Finance Table
									if($upd_pay_status < "2" AND $pm_loan_flag == "0" AND !$self_loan_code) {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'><input type=radio name='new_pay_status' value='2'> Request Confirm</label>
                                        <div class='col-sm-9'>");
											$query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'out'";
											$result_AC = mysql_query($query_AC);
											if (!$result_AC) { error("QUERY_ERROR"); exit; }
											$total_AC = @mysql_result($result_AC,0,0);
                
											echo ("<select name='new_acc_code' class='form-control'>");
											echo ("<option disabled value=\"\"> :: $txt_comm_frm19</option>");
                
											$query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'out' ORDER BY catg ASC";
											$result_A = mysql_query($query_A);
											if (!$result_A) {   error("QUERY_ERROR");   exit; }

											for($a = 0; $a < $total_AC; $a++) {
												$fA_uid = mysql_result($result_A,$a,0);
												$fA_class = mysql_result($result_A,$a,1);
												$fA_catg = mysql_result($result_A,$a,2);
   
												$fA_catg_txt = "txt_sys_account_06_"."$fA_catg";
                  
												echo ("<option disabled value='$fA_catg'> ($fA_catg) ${$fA_catg_txt}</option>");
                  
												$query_H1C = "SELECT count(uid) FROM code_acc_list 
															WHERE $upd_branch_code = '1' AND catg = '$fA_catg' AND lang = '$lang'";
												$result_H1C = mysql_query($query_H1C);
												if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
    
												$total_H1C = @mysql_result($result_H1C,0,0);
    
												$query_H1 = "SELECT uid,acc_code,acc_name FROM code_acc_list 
															WHERE $upd_branch_code = '1' AND catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
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
											<input class='btn btn-primary' type='submit' value='Submit'>
										</div>
                                    </div>");
									
									
									?>
			
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
  

    if($new_pay_status == "4") { // 결제처리 - 은행대출 신청[인보이스 발행], 실제 대출 신청액 산정
    
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

        // 결제 정보 테이블에 정보 입력 + // 인보이스 발행
        $query_P2 = "INSERT INTO shop_payment (uid,branch_code,gate,client_code,f_class,pay_num,bank_name,remit_code,
            pay_type,pay_bank,pay_state,pay_amount,pay_amount_money,pay_amount_point,pay_amount_delivery,qty,pay_date,
            loan_flag,loan_trans_code,invoice_dates,invoice_print) 
            values ('','$new_branch_code','$new_gudang_code','$new_supp_code','out','$new_pay_num','$new_bank_name',
            '$new_remit_code','$new_pay_type','$new_pay_bank','1','$loan_amount','$loan_amount','0','0',
            '$new_stock_org','$post_dates','1','$new_trans_num','$post_dates','1')";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }
        
        }
    
    
    
    } else if($new_pay_status == "2") { // 결제마감
    
        // 결제 정보 수정
        $result_CHG = mysql_query("UPDATE shop_payment SET client_code = '$new_supp_code', pay_type = '$new_pay_type', 
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank', pay_state = '2' 
            WHERE uid = '$org_pay_uid'",$dbconn);
        if(!$result_CHG) { error("QUERY_ERROR"); exit; }
		
		
		// finance 테이블에 입력
        $new_process = "1";
        $new_fname = "Ref. $new_pay_num";
        $new_currency = "IDR";
        $new_fremark = "Post-paid Purchase";
    
        $query_F2 = "INSERT INTO finance (uid,branch_code,gate,client_code,f_class,f_paylink,f_catg,f_code,f_name,f_remark,
            currency,pay_type,amount,post_date,pay_date,process,pay_num,bank_name,remit_code,pay_bank,pay_card) values ('',
            '$login_branch','$org_gate','$new_supp_code','out','1','$new_fcatg','$new_acc_code','$new_fname','$new_fremark',
            '$new_currency','$new_pay_type','$org_tprice_orgin','$post_dates','$post_dates','$new_process','$org_pay_num',
            '$new_bank_code','$new_remit_code','$new_pay_bank','$new_pay_card')";
        $result_F2 = mysql_query($query_F2);
        if (!$result_F2) { error("QUERY_ERROR"); exit; }
		
		
		

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
    
        // 상품 정보 수정 - 결제한 것으로 처리
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
            bank_name = '$new_bank_name', remit_code = '$new_remit_code', pay_bank = '$new_pay_bank' 
            WHERE uid = '$org_pay_uid'",$dbconn);
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