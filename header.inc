
<!-- 인쇄창 ------------------>
<script type="text/javascript">
var ns4=document.layers
var ie4=document.all
var ns6=document.getElementById&&!document.all

var dragswitch=0
var nsx
var nsy
var nstemp

function drag_dropns(name){
if (!ns4)
return
temp=eval(name)
temp.captureEvents(Event.MOUSEDOWN | Event.MOUSEUP)
temp.onmousedown=gons
temp.onmousemove=dragns
temp.onmouseup=stopns
}

function gons(e){
temp.captureEvents(Event.MOUSEMOVE)
nsx=e.x
nsy=e.y
}
function dragns(e){
if (dragswitch==1){
temp.moveBy(e.x-nsx,e.y-nsy)
return false
}
}

function stopns(){
temp.releaseEvents(Event.MOUSEMOVE)
}

function drag_drop(e){
if (ie4&&dragapproved){
crossobj.style.left=tempx+event.clientX-offsetx
crossobj.style.top=tempy+event.clientY-offsety
return false
}
else if (ns6&&dragapproved){
crossobj.style.left=tempx+e.clientX-offsetx+"px"
crossobj.style.top=tempy+e.clientY-offsety+"px"
return false
}
}

function initializedrag(e){
crossobj=ns6? document.getElementById("showimage") : document.all.showimage
var firedobj=ns6? e.target : event.srcElement
var topelement=ns6? "html" : document.compatMode && document.compatMode!="BackCompat"? "documentElement" : "body"
while (firedobj.tagName!=topelement.toUpperCase() && firedobj.id!="dragbar"){
firedobj=ns6? firedobj.parentNode : firedobj.parentElement
}

if (firedobj.id=="dragbar"){
offsetx=ie4? event.clientX : e.clientX
offsety=ie4? event.clientY : e.clientY

tempx=parseInt(crossobj.style.left)
tempy=parseInt(crossobj.style.top)

dragapproved=true
document.onmousemove=drag_drop
}
}
document.onmouseup=new Function("dragapproved=false")

function hidebox(){
crossobj=ns6? document.getElementById("showimage") : document.all.showimage
if (ie4||ns6)
crossobj.style.visibility="hidden"
else if (ns4)
document.showimage.visibility="hide"
}

</script>


<?
$m_ip = getenv('REMOTE_ADDR');
$signdate = time();

$today_full_set = date("Ymd",$signdate);
	$today_full_set2 = date("Y-m-d",$signdate);
$today_month_set = date("Ym",$signdate);
	$today_month_set2 = date("Y-m",$signdate);
$today_6d = date("ymd",$signdate);
$today_8d = date("ymdH",$signdate);
$today_time = date("ymdHis",$signdate);

$this_date = date("d");
$this_week = date("D");

if($lang == "ko") {
	$today_month_set_txt = date("Y/m",$signdate);
	$today_date_set_txt = date("Y/m/d",$signdate);
} else {
	$today_month_set_txt = date("M-Y",$signdate);
	$today_date_set_txt = date("d-M-Y",$signdate);
}


// User Website URL
$user_website_url = "index.php?gate=$website_id&lang=$lang";


// Modules
$query_logbr2 = "SELECT web_flag,module_03,module_05,module_07 FROM client WHERE client_id = '$login_gate' AND branch_code = '$login_branch'";
$result_logbr2 = mysql_query($query_logbr2);
   if(!$result_logbr2) { error("QUERY_ERROR"); exit; }
   $row_logbr2 = mysql_fetch_object($result_logbr2);

  $login_web_flag = $row_logbr2->web_flag;
  $login_module_03 = $row_logbr2->module_03; // Church Members
  $login_module_05 = $row_logbr2->module_05; // Offering
  $login_module_07 = $row_logbr2->module_07; // Attendance


// Logo
$query_logo = "SELECT img1 FROM client_branch WHERE branch_code = '$login_branch'";
$result_logo = mysql_query($query_logo);
if(!$result_logo) { error("QUERY_ERROR"); exit; }
   $row_logo = mysql_fetch_array($result_logo);

$logo_file = $row_logo["img1"];

if($logo_file != "") {
	if($website_id == "host") {
		$logo_img_file = "user_file/$logo_file";
	} else {
		$logo_img_file = "user/$website_id/user_file/$logo_file";
	}
} else {
		$logo_img_file = "img/logo/logo_host.png";
}


// Login Data
if($login_ip) {
$query_log = "SELECT visit,log_in,default_lang,user_level FROM admin_user WHERE user_id = '$login_id' AND branch_code = '$login_branch'";
$result_log = mysql_query($query_log);
   if(!$result_log) { error("QUERY_ERROR"); exit; }
   $row_log = mysql_fetch_array($result_log);

  $last_visit = $row_log['visit'];
  $last_login = $row_log['log_in'];
  //$last_lang = $row_log->last_lang;
  $last_level = $row_log['user_level'];

  if($lang == "ko") {
    $last_login1 = date("Y/m/d",$last_login);
  } else {
    $last_login1 = date("d-M-Y",$last_login);
  }
  $last_login2 = date("H:i:s (D)",$last_login);
  if($lang == "ko") {
    $last_login_full = date("Y/m/d,H:i:s",$last_login);
  } else {
    $last_login_full = date("d-m-Y, H:i:s",$last_login);
  }

  $last_login_txt = "$txt_sys_user_09: "."$last_login_full";

} else {
  $last_login_txt = "Local Login";
}


// User Profile
$query_foto = "SELECT name,gender,photo1 FROM member_staff WHERE id = '$login_id'";
$result_foto = mysql_query($query_foto);
    if (!$result_foto) { error("QUERY_ERROR"); exit; }
$login_name2 = @mysql_result($result_foto,0,0);
	if(!$login_name2) {
		$login_name2 = $login_name;
	}
$login_gender = @mysql_result($result_foto,0,1);
	if(!$login_gender) {
		$login_gender = "M";
	}
$login_photo1 = @mysql_result($result_foto,0,2);
	if($login_photo1 == "none" OR $login_photo1 == "") {
		$login_photo_img1 = "img/User_Photo_"."$login_gender".".png";
	} else {
		$login_photo_img1 = "user_file/$login_photo1";
	}

// Privileges POS Monitoring
$query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = '$login_id'";
$fetch_0509 = mysql_query($query_0509);
$smode_0509_K3 = @mysql_result($fetch_0509,0,2);
$module_0509 = substr($smode_0509_K3,8,1);

// Dashboard (Home)

//$hmmenu_01 = "index.php?lang=$last_lang";

// 01. Purchasing
$link_module_0101 = "inventory_stock1D.php"; // Product Search
$link_module_0102 = "inventory_purchase.php"; // Purchase Order
  $link_module_0102A = "inventory_purchase.php?otype=A"; // Purchase Order A (In Process)
  $link_module_0102B = "inventory_purchase.php?otype=B"; // Purchase Order A (Completed)
$link_module_0103 = "inventory_purchase1.php"; // Purchase Approval
$link_module_0104 = "inventory_stock2.php"; // Physical Check ////
$link_module_0105 = "inventory_purchase2.php"; // Warehousing
$link_module_0106 = "inventory_purchase3.php"; // Warehousing Check

// 01B. Purchase Request (PR)
$link_module_01B01 = "sales_pr_search.php"; // Product Search (PR)
$link_module_01B02 = "sales_pr_order.php"; // Product Request
$link_module_01B03 = "sales_pr_confirm.php"; // Request Approval

// 01C. Warehouse (WMS)
$link_module_01C01 = "wms_so.php"; // Sales Order (WMS)
$link_module_01C02 = "wms_po.php"; // Purchasing Order (WMS)
$link_module_01C03 = "wms_do.php"; // Delivery Order (WMS)

// 02. Inventory (SCO)
$link_module_0201 = "inventory_stock_in.php"; // Stock Input
	$link_module_0201A = "inventory_stock_data1.php"; // Stock Data - by item
	$link_module_0201B = "inventory_stock_data2.php"; // Stock Data - by warehouse
	$link_module_0201C = "inventory_stock_data3.php"; // Stock Data - by branch shop
	$link_module_0201D = "inventory_stock_data4.php"; // Stock Data - by store
$link_module_0201on = "inventory_stock_online.php"; // Stock Online

$link_module_0202 = "inventory_payment.php"; // Payment (PP)
$link_module_0203 = "inventory_payment2.php"; // Payment Confirmation
$link_module_0204 = "inventory_stock_out.php"; // Stock Output
$link_module_0205 = "inventory_delivery.php"; // Delivery Check
  $link_module_0206 = "inventory_delivery2.php"; // Surat Jalan
  $link_module_0207 = "inventory_billing.php"; // Billing Management
$link_module_0208 = "inventory_return.php"; // Return
$link_module_0209 = "inventory_pickup.php"; // Product Pick-up
$link_module_0210 = "inventory_opname_dir.php"; // Stock Opname - Directory
$link_module_0210D = "inventory_opnameD.php"; // Stock Opname - Check
$link_module_0210_set = "inventory_opname_set.php"; // Stock Opname - Initial Stock (Setting - Time)
$link_module_0210_ini1 = "inventory_opname_ini1.php"; // Stock Opname - Initial Stock (Warehouse)
$link_module_0210_ini2 = "inventory_opname_ini2.php"; // Stock Opname - Initial Stock (Branch Shop)
$link_module_0210_ini3 = "inventory_opname_ini3.php"; // Stock Opname - Initial Stock (Associate Store)
$link_module_0220 = "inventory_opname_close.php"; // Stock Closing
$link_module_0221 = "inventory_closing_check.php"; // Stock Closing

$link_module_0211 = "inventory_option.php"; // 상품 옵션 항목 관리
$link_module_0212 = "inventory_unit.php"; // 상품 단위 관리
$link_module_0213 = "inventory_update_cbm.php"; // Barcode, CBM
$link_module_0214 = "inventory_update_price.php"; // Price List

// 03. Logistics
$link_module_0301 = "logistic_docheck.php"; // Check Sujat Jalan
$link_module_0302 = "logistic_progress.php"; // Logistics Progress

// 03A. Shipment
$link_module_03A01 = "shipment_booking.php"; // Shipment Booking
$link_module_03A011 = "shipment_close.php"; // Closing
$link_module_03A012 = "shipment_remit.php"; // Remittance (to Escow Account)
$link_module_03A02 = "shipment_reconcile.php"; // Shipment Reconcile
$link_module_03A03 = "shipment_reconcile2.php"; // Shipment Reconcile - Confirmation
$link_module_03A04 = "shipment_pickup.php"; // Pick-up
$link_module_03A05 = "shipment_pickup2.php"; // Pick-up Manifest


// 04. Asset Management
$link_module_0401 = "finance_asset.php"; // Assets
$link_module_04012 = "finance_asset_vehicle.php"; // Assets - 2. Vehicle
$link_module_0402 = "finance_deprec.php"; // Depreciation
$link_module_0403 = "finance_cogs.php"; // COGS
$link_module_0404 = "finance_amort.php"; // Amortization

// 05. Sales (FeelBuy Shop)
$link_module_0501 = "sales_order2.php"; // Sales Entry
$link_module_0502 = "sales_collection.php"; // Payment Collection
$link_module_0503 = "inventory_stock_in2.php"; // Stock Input

$link_module_0506 = "inventory_pickup.php"; // Product Pick-up
$link_module_0507 = "inventory_opnameD.php"; // Stock Opname
//$link_module_0508 = "sales_pos.php"; // Point of Sales [POS]
$link_module_0508 = "pos.php"; // Point of Sales [POS]
$link_module_0509 = "pos_admin.php"; // Admin POS

// 06. Sales (Associate Store)
$link_module_0601 = "sales_order3.php"; // Sales Entry
	$link_module_0601A = "sales_order3A.php"; // Sales Entry (Blank)
	$link_module_0601B = "sales_order3B.php"; // Sales Entry (Grid)
$link_module_0602 = "sales_collection.php"; // Payment Collection
$link_module_0603 = "sales_pr_search.php"; // Product Search
$link_module_0604 = "sales_pr_order.php"; // Product Request
$link_module_0605 = "sales_pr_confirm.php"; // Request Approval
$link_module_0606 = "inventory_pickup.php"; // Product Pick-up
$link_module_0607 = "inventory_opnameD.php"; // Stock Opname

// 07. Sales (Admin Sales)
$link_module_0701 = "sales_order1.php"; // Sales Entry
$link_module_0702 = "sales_collection.php"; // Payment Collection
$link_module_0703 = "sales_pr_search.php"; // Product Search
$link_module_0704 = "sales_pr_order.php"; // Product Request
$link_module_0705 = "sales_pr_confirm.php"; // Request Approval

$link_module_0707 = "inventory_opnameD.php"; // Stock Opname

// 08. CRM/HR
$link_module_0801 = "crm_member.php"; // Customer
	$link_module_08010 = "crm_member.php?mb_level=3&mb_type=2"; // 위탁 매장
	$link_module_08011 = "crm_member.php?mb_level=2&mb_type=2"; // 리셀러 (상점)
	$link_module_08012 = "crm_member.php?mb_level=2&mb_type=0"; // 리셀러 (개인)
	$link_module_08013 = "crm_member.php?mb_level=1&mb_type=3"; // 일반 고객 (기업)
	$link_module_08014 = "crm_member.php?mb_level=1&mb_type=0"; // (개인)
	$link_module_08015 = "crm_member.php?mb_level=4&mb_type=3"; // (개인)
$link_module_0802 = "crm_member2.php"; // Distributor
	$link_module_08021 = "crm_member2.php?mb_level=7"; // 대리점 (지역총판)
	$link_module_08022 = "crm_member2.php?mb_level=6"; // 대리점 (지역지점)
$link_module_0803 = "hr_member.php"; // Employee
	$link_module_08031 = "hr_member.php?hr_type=1"; // Regular
		$link_module_08031x = "hr_member.php?hr_type=1&hr_retire=1"; // Regular - Retired
	$link_module_08032 = "hr_member.php?hr_type=2"; // Non-regular (SA)
		$link_module_08032x = "hr_member.php?hr_type=2&hr_retire=1"; // Non-regular (SA) - Retired
	$link_module_08033 = "hr_member.php?hr_type=3&hr_temp=1"; // Temporary

	// Work Attitudes
	$link_module_08031w = "hr_member_work.php";
	$link_module_08031w0 = "hr_member_history.php";
	$link_module_08031w1 = "hr_member_work.php?hr_type=1"; // Regular
	$link_module_08031w2 = "hr_member_work.php?hr_type=2"; // 용역 (SA) 관리

	// Incentive
	$link_module_080321 = "hr_incentive_sa.php"; // SA - Reseller
	$link_module_080322 = "hr_incentive_spc.php";
	$link_module_080323 = "hr_incentive_sms.php";
	$link_module_080324 = "hr_incentive_fbs.php";
	$link_module_080325 = "hr_incentive_driver.php";
	$link_module_080326 = "hr_incentive_office.php";

	// Wages
	$link_module_080331 = "hr_wage_sa.php"; // SA - Reseller
	$link_module_080332 = "hr_wage_spc.php";
	$link_module_080333 = "hr_wage_sms.php";
	$link_module_080334 = "hr_wage_fbs.php";
	$link_module_080335 = "hr_wage_driver.php";
	$link_module_080336 = "hr_wage_office.php";

$link_module_0804 = "crm_mailing2.php"; // Mailing List
	$link_module_08041 = "crm_mailing1.php"; // Mailing List (Employee)
	$link_module_08042 = "crm_mailing2.php"; // Mailing List (Customer)
	$link_module_08043 = "crm_mailing3.php"; // Mailing List (Non-member)
$link_module_0805 = "crm_newsletter.php"; // News Letter



// 09. Finance
$link_module_0901 = "finance_cost.php"; // General Expenses
$link_module_0902 = "finance_cost2.php"; // Purchase Cost
$link_module_0903 = "finance_income.php"; // General Income
$link_module_0904 = "finance_income2.php"; // Sales Income
$link_module_0905 = "finance_invoice.php"; // Invoices
$link_module_0906 = "finance_balance.php"; // Income Statement
$link_module_0907 = "currency_balance.php"; // Kurs

// 10. Accounting
$link_module_1001 = "accounting_general.php"; // General Accounting
$link_module_1002 = "accounting_finance.php"; // Financial Accounting
$link_module_1003 = "accounting_manage.php"; // Managerial Accounting
$link_module_1004 = "accounting_tax.php"; // Tax Accounting


// 11. CMS (Website Contents)
$link_module_1101 = "website_menu.php"; // Menu Editor
$link_module_1102 = "website_content.php"; // Contents Editor
$link_module_1103 = "website_banner1.php"; // Banner Files
$link_module_1104 = "website_banner2.php"; // Banner Display
$link_module_1105 = "website_stuff.php"; // Page Stuff
$link_module_1106 = "website_layout.php"; // Layout


// 21. System Configuration
$link_module_2101 = "system_client.php"; // Client(창고) 계정관리
$link_module_2102 = "system_user.php"; // 사용자(창고) 계정관리
$link_module_2101d = "system_department.php"; // 부서 관리
$link_module_2117 = "system_warehouse.php"; // Warehouse
	$link_module_211701 = "system_wloc_catg.php"; // Warehouse Location Category
	$link_module_211702 = "system_wloc_list.php"; // Warehouse Location List
$link_module_2104A = "system_brand.php"; // 브랜드
$link_module_2105 = "system_category.php"; // 상품 카테고리 관리
$link_module_2118 = "system_consign.php"; // 위탁판매 그룹 관리
$link_check_shop_code = "check_code.php";
$link_shop_code = "shop_code.php";
$link_check_shop_cvj = "check_code_cvj.php";

$link_module_21031 = "system_shop.php"; // 매장 관리
$link_module_21031A = "system_shop.php?asso_type=A"; // Associate Stores
$link_module_21031A2 = "system_shop2.php"; // Associate Stores by Customer *
$link_module_21031B = "system_shop.php?asso_type=B"; // Branch Shops
$link_module_21031E = "system_shop.php?asso_type=E"; // Online Shop (e-Commerce)
$link_module_21032 = "system_user2.php"; // 매장 Manager 관리
$link_module_21032A = "system_user2.php?shop_flag=1"; // Associate Store Managers
$link_module_21032B = "system_user2.php?shop_flag=2"; // Branch Shop Managers
$link_module_2103C = "system_currency.php"; // Currency
$link_module_2104 = "system_supplier.php"; // 공급자 관리
$link_module_2106 = "system_mileage.php"; // 마일리지
$link_module_2107 = "system_discount.php"; // 리셀러 정책
$link_module_2107A = "system_charge_rate.php"; // Shipment Charge Rate
$link_module_2108 = "system_voucher.php"; // 바우처 발행관리
$link_module_21081 = "system_voucher2.php"; // YARNEN 관리
$link_module_2109 = "system_discount2.php"; // 특별 행사가

$link_module_2110 = "system_cash.php"; // 현금시제 초기값
$link_module_2111 = "system_bank.php"; // 결제은행 관리
$link_module_2112 = "system_card.php"; // 신용카드 관리
$link_module_2112a = "system_insurance.php"; // 보험사 관리

$link_module_2113 = "system_account.php"; // 계정항목 관리
$link_module_21132 = "system_account2.php"; // 부서별 지출항목
$link_module_21133 = "system_budget.php"; // 부서별 예산
$link_module_2114 = "system_loan.php"; // 은행대출
$link_module_2120 = "system_xchange.php"; // 환율 관리


$link_module_21341 = "system_tdir.php"; // 훈련/활동 카테고리
$link_module_21342 = "system_tcourse.php"; // 훈련/활동 과정

$link_module_2115 = "system_region.php"; // 배송지역 코드 및 배송비
$link_module_2116 = "system_port.php"; // 선적항
$link_module_2141 = "system_jobclass.php"; // 직급 코드
$link_module_2142 = "system_payclass.php"; // 호봉
$link_module_2143 = "system_paybase.php"; // 연간 임금기준표

// $link_module_2121 = "system_zdblink.php"; // Client DB 계정 [최고 관리자 전용]
$link_module_2121 = "#";
$link_module_2122 = "system_zcorp.php"; // 본/지사 계정 [최고 관리자 전용]
$link_module_2123 = "system_zbank.php"; // 펀드 제공은행 [최고 관리자 전용]
$link_module_21241 = "system_zone_acccatg.php"; // 국가별 계정 코드 - 카테고리
$link_module_21242 = "system_zone_acclist.php"; // 국가별 계정 코드 - 리스트


// Incentive Calculation
$link_module_2151 = "system_incentive_sa.php"; // SA - Reseller
$link_module_2152 = "system_incentive_spc.php";
$link_module_2153 = "system_incentive_sms.php";
$link_module_2154 = "system_incentive_fbs.php";
$link_module_21541 = "system_incentive_fbs_cost.php";
$link_module_2155 = "system_incentive_driver.php";
$link_module_2156 = "system_incentive_office.php";


// Reports
$link_report_08 = "table_report_08.php"; // Customer
  $link_report_08B = "table_report_08B.php"; // HR
$link_report_01 = "table_report_01.php"; // Purchasing
$link_report_02 = "table_report_02.php"; // Inventory
$link_report_31 = "table_report_31.php"; // Marketing
$link_report_05 = "table_report_05.php"; // Sales
  $link_report_05B = "table_report.php"; // Sales Projection by Shop
$link_report_04 = "table_report_04.php"; // Asset
$link_report_09 = "table_report_09.php"; // Finance
$link_report_10A = "table_report_10A.php"; // Warehouse - Sales Order
$link_report_10B = "table_report_10B.php"; // Warehouse - Total Stocks


// 20. Settings
$hsmenu_10_01 = "user_layout.php"; // 언어선택
$hsmenu_10_02 = "user_update.php"; // 개인정보 변경
// $hsmenu_10_03 = "user_passwd.php"; // 비밀번호 변경

$hsmenu_10_04 = "user_join.php";
$hsmenu_10_05 = "user_login.php";
$hsmenu_10_06 = "user_logout.php";



// Branch & Shop Name
if($grpBrc) {
	$query_name1 = "SELECT branch_name FROM client_branch WHERE branch_code = '$grpBrc'";
	$result_name1 = mysql_query($query_name1);
		if (!$result_name1) { error("QUERY_ERROR"); exit; }
	$rp_title1 = @mysql_result($result_name1,0,0);
}


if($grpShp) {
	$query_name2 = "SELECT shop_name,associate FROM client_shop WHERE shop_code = '$grpShp'";
	$result_name2 = mysql_query($query_name2);
		if (!$result_name2) { error("QUERY_ERROR"); exit; }
	$rp_title2 = @mysql_result($result_name2,0,0);
		$rp_title2_txt = "($rp_title2)";
		$rp_title2_full = "$rp_title1"." &gt; "."$rp_title2";
	$rp_asso_type = @mysql_result($result_name2,0,1);
} else {
	$rp_title2_txt = "";
	$rp_title2_full = $rp_title1;
	$rp_title2 = @mysql_result($result_name2,0,0);
	$rp_asso_type = "0";
}



// Total Stock In/Out
if($login_level > "7") {
	$query_tcnt = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'in'";
} else if($login_level > "2") {
	$query_tcnt = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'in' AND branch_code = '$login_branch'";
} else {
	$query_tcnt = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'out' AND shop_code2 = '$login_shop' AND branch_code2 = '$login_branch'";
}
$result_tcnt = mysql_query($query_tcnt);
    if (!$result_tcnt) { error("QUERY_ERROR"); exit; }
$lfprd_tcnt = @mysql_result($result_tcnt,0,0);
$lfprd_tcnt_K = number_format($lfprd_tcnt);

if($login_level > "7") {
	$query_tcnt2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'out'";
} else if($login_level > "2") {
	$query_tcnt2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'out' AND branch_code = '$login_branch'";
} else {
	$query_tcnt2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE flag = 'in' AND shop_code2 = '$login_shop' AND branch_code2 = '$login_branch'";
}
$result_tcnt2 = mysql_query($query_tcnt2);
    if (!$result_tcnt2) { error("QUERY_ERROR"); exit; }
$lfprd_tcnt2 = @mysql_result($result_tcnt2,0,0);
$lfprd_tcnt2_K = number_format($lfprd_tcnt2);


// Photo
$query_foto = "SELECT gender,photo1 FROM member_staff WHERE id = '$login_id'";
$result_foto = mysql_query($query_foto);
    if (!$result_foto) { error("QUERY_ERROR"); exit; }
$gender = @mysql_result($result_foto,0,0);
	if(!$gender) {
		$gender = "M";
	}
$photo1 = @mysql_result($result_foto,0,1);

if($photo1 == "none" OR $photo1 == "") {
    $photo_img1 = "img/User_Photo_"."$gender".".png";
} else {
    $photo_img1 = "user_file/$photo1";
}

//query temporary
$query_tempo_c = "SELECT count(uid) FROM member_staff WHERE DATEDIFF( CURDATE( ) , DATE_ADD( regis_date, INTERVAL 90
				 DAY ) ) <=14 AND ctr_sa = '2' OR temp = '1'";
$result_tempo_c = mysql_query($query_tempo_c);
if (!$result_tempo_c) { error("QUERY_ERROR"); exit; }
$uid_total = @mysql_result($result_tempo_c,0,0);




?>



<!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><img src="<?=$logo_img_file?>" style="width: 152px;"></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
					<!--
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-success">6</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 6 pending tasks</p>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Dashboard v1.3</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Database Update</div>
                                        <div class="percent">60%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Iphone Development</div>
                                        <div class="percent">87%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 87%">
                                            <span class="sr-only">87% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Mobile App</div>
                                        <div class="percent">33%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                            <span class="sr-only">33% Complete (danger)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Dashboard v1.3</div>
                                        <div class="percent">45%</div>
                                    </div>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                            <span class="sr-only">45% Complete</span>
                                        </div>
                                    </div>

                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See All Tasks</a>
                            </li>
                        </ul>
                    </li>
					-->
                    <!-- settings end -->

                    <!-- inbox dropdown start-->
					<!--
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-important">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-red"></div>
                            <li>
                                <p class="red">You have 5 new messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jonathan Smith</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is an example msg.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini2.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jhon Doe</span>
                                    <span class="time">10 mins</span>
                                    </span>
                                    <span class="message">
                                     Hi, Jhon Doe Bhai how are you ?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini3.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jason Stathum</span>
                                    <span class="time">3 hrs</span>
                                    </span>
                                    <span class="message">
                                        This is awesome dashboard.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="./img/avatar-mini4.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Jondi Rose</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hello, this is metrolab
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all messages</a>
                            </li>
                        </ul>
                    </li>
					-->
                    <!-- inbox dropdown end -->

                    <!-- notification dropdown start-->
					<? if ($last_level >= 8) {?>
                    <li id="header_notification_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge bg-warning"><?=$uid_total?></span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-yellow"></div>
                            <li>
                                <p class="yellow">You have <?=$uid_total?> new notifications</p>
                            </li>
							<?php
							for ($i = 0 ; $i < $uid_total ; $i++){
									/*$query_tempo = "SELECT name,corp_title,regis_date,uid
										FROM member_staff WHERE ctr_sa = '2' OR temp = '1' ORDER BY regis_date ASC ";*/
									$query_tempo = "SELECT name, corp_title, regis_date, uid FROM member_staff WHERE
													DATEDIFF( CURDATE( ) , DATE_ADD( regis_date, INTERVAL 90 DAY ) )
													<=14 AND ctr_sa = '2' OR temp = '1'";
									$result_tempo = mysql_query($query_tempo);
										if (!$result_tempo) { error("QUERY_ERROR"); exit; }
											$employee_name = @mysql_result($result_tempo,$i,0);
											$employee_title = @mysql_result($result_tempo,$i,1);
											$regis_dates = @mysql_result($result_tempo,$i,2);
											$uid = @mysql_result($result_tempo,$i,3);
											$name = explode(' ',$employee_name);
											$signdate = time();
											  $post_year = date("Y",$signdate);
											  $pmonth = date("m",$signdate);
											  $pdate = date("d",$signdate);
											  $phour = date("H",$signdate);
											  $past_month3 = date('d-m-Y',mktime(0,0,0,$pmonth,$pdate,$post_year));

											  $post_year2 = explode("-",$regis_dates);
											  $pdate3 =$post_year2[2];
											  $pmonth3 = $post_year2[1];
											  $post_year3 = $post_year2[0];
											  $past_month4 = date('d-m-Y',mktime(0,0,0,$pmonth3+3,$pdate3,$post_year3));

											$selisih = ((abs(strtotime($past_month4) - strtotime($past_month3)))/(60*60*24));

									?>
									<li>
										<a href='hr_member_upd.php?keyfield=&key=&page=1&uid=<?=$uid?>&hr_type=3&hr_temp=1'>
											<span class="label label-danger"><i class="fa fa-bolt"></i></span>
											<span class="small"><?=$name[0]?>[<?=$employee_title?>] - <?=$selisih?> hari</span>
										</a>
									</li>
									<?

								}
							?>
							<!--
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="fa fa-bell"></i></span>
                                    Server #10 not respoding.
                                    <span class="small italic">1 Hours</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    Database overloaded 24%.
                                    <span class="small italic">4 hrs</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="fa fa-plus"></i></span>
                                    New user registered.
                                    <span class="small italic">Just now</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-info"><i class="fa fa-bullhorn"></i></span>
                                    Application error.
                                    <span class="small italic">10 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
							-->
                        </ul>
                    </li>
					<?}?>
                    <!-- notification dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder="Search">
                    </li>

					<!--
					<li class="dropdown language">
						<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="index.php?lang=en">
                          <img src="img/flags/us.png" alt=""><span class="username"> English</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
                          <li><a href="index.php?lang=in"><img src="img/flags/id.png" alt=""> English</a></li>
                          <li><a href="index.php?lang=ko"><img src="img/flags/kr.png" alt=""> Korean</a></li>
						</ul>
					</li>
					-->

                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="<?=$photo_img1?>" style="height: 30px">
                            <span class="username"><?=$login_user_name?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?echo("$hsmenu_10_01")?>"><i class="fa fa-cog"></i> <?echo("$hsm_name_10_01")?></a></li>
                            <li><a href="<?echo("$hsmenu_10_02")?>"><i class="fa fa-suitcase"></i> <?echo("$hsm_name_10_02")?></a></li>
							<li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                            <li><a href="user_logout.php"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <li class="sb-toggle-right">
                        <i class="fa  fa-align-right"></i>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
				  <? if(!$mmenu OR $mmenu == "main") { ?>
                  <li><a class="active" href="index.php"> <i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
				  <? } else { ?>
				  <li><a href="index.php"> <i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
				  <? } ?>

				  <!--
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-laptop"></i>
                          <span>Layouts</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="boxed_page.html">Boxed Page</a></li>
                          <li><a  href="horizontal_menu.html">Horizontal Menu</a></li>
                      </ul>
                  </li>
				  -->



				  <? if($mmodule_05_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "sales") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-tags"></i> <span><?echo("$title_module_05")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-tags"></i> <span><?echo("$title_module_05")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0501 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_order2") { ?>
						<li class="active"><a href="<?echo("$link_module_0501")?>"><?echo("$title_module_0501")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0501")?>"><?echo("$title_module_0501")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0501 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_collection") { ?>
						<li class="active"><a href="<?echo("$link_module_0502")?>"><?echo("$title_module_0502")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0502")?>"><?echo("$title_module_0502")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0501 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_pos") { ?>
						<li class="active"><a href="<?echo("$link_module_0508")?>"><?echo("$title_module_0508")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0508")?>"><?echo("$title_module_0508")?></a></li>
						<? } ?>
						<? if($now_group_admin == "1" AND $smodule_0509 == "1") { ?>
						<li><a href="<?echo("$link_module_0509")?>"><?echo("$title_module_0509")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_06_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "sales") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-tags"></i> <span><?echo("$title_module_06")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-tags"></i> <span><?echo("$title_module_06")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0601 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_order3") { ?>
						<li class="active"><a href="<?echo("$link_module_0601")?>"><?echo("$title_module_0601")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0601")?>"><?echo("$title_module_0601")?></a></li>
						<? } ?>
						<? if($smenu == "sales_order3A") { ?>
						<li class="active"><a href="<?echo("$link_module_0601A")?>">+ <?echo("$title_module_0601")?> (Blank)</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0601A")?>">+ <?echo("$title_module_0601")?> (Blank)</a></li>
						<? } ?>
						<? if($smenu == "sales_order3B") { ?>
						<li class="active"><a href="<?echo("$link_module_0601B")?>">+ <?echo("$title_module_0601")?> (Grid)</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0601B")?>">+ <?echo("$title_module_0601")?> (Grid)</a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0602 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_collection") { ?>
						<li class="active"><a href="<?echo("$link_module_0602")?>"><?echo("$title_module_0602")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0602")?>"><?echo("$title_module_0602")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_07_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "sales") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-tags"></i> <span><?echo("$title_module_07")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-tags"></i> <span><?echo("$title_module_07")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0701 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_order1") { ?>
						<li class="active"><a href="<?echo("$link_module_0701")?>"><?echo("$title_module_0701")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0701")?>"><?echo("$title_module_0701")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0702 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_collection") { ?>
						<li class="active"><a href="<?echo("$link_module_0702")?>"><?echo("$title_module_0702")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0702")?>"><?echo("$title_module_0702")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_01_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "purchase") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-anchor"></i> <span><?echo("$title_module_01")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-anchor"></i> <span><?echo("$title_module_01")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0101 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_stock1") { ?>
						<li class="active"><a href="<?echo("$link_module_0101")?>"><?echo("$title_module_0101")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0101")?>"><?echo("$title_module_0101")?></a></li>
						<? } ?>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0102 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_purchase") { ?>
						<li class="active"><a href="<?echo("$link_module_0102")?>"><?echo("$title_module_0102")?></a></li>
							<? if($otype == "A") { ?>
							<li class="active"><a href="<?echo("$link_module_0102A")?>">+ <?=$title_module_0102A?></a></li>
							<? } else { ?>
							<li><a href="<?echo("$link_module_0102A")?>">+ <?=$title_module_0102A?></a></li>
							<? } ?>
							<? if($otype == "B") { ?>
							<li class="active"><a href="<?echo("$link_module_0102B")?>">+ <?=$title_module_0102B?></a></li>
							<? } else { ?>
							<li><a href="<?echo("$link_module_0102B")?>">+ <?=$title_module_0102B?></a></li>
							<? } ?>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0102")?>"><?echo("$title_module_0102")?></a></li>
						<? } ?>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0103 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_purchase1") { ?>
						<li class="active"><a href="<?echo("$link_module_0103")?>"><?echo("$title_module_0103")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0103")?>"><?echo("$title_module_0103")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0104 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_stock2") { ?>
						<li class="active"><a href="<?echo("$link_module_0104")?>"><?echo("$title_module_0104")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0104")?>"><?echo("$title_module_0104")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0105 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_purchase2") { ?>
						<li class="active"><a href="<?echo("$link_module_0105")?>"><?echo("$title_module_0105")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0105")?>"><?echo("$title_module_0105")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0106 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_purchase3") { ?>
						<li class="active"><a href="<?echo("$link_module_0106")?>"><?echo("$title_module_0106")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0106")?>"><?echo("$title_module_0106")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_01B_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "purchaseB") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-anchor"></i> <span><?echo("$title_module_01B")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-anchor"></i> <span><?echo("$title_module_01B")?></span></a>
					  <? } ?>
					  <ul class="sub">
						<? if(($now_group_admin == "1" AND $smodule_01B01 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_pr_search") { ?>
						<li class="active"><a href="<?echo("$link_module_01B01")?>"><?echo("$title_module_01B01")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01B01")?>"><?echo("$title_module_01B01")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_01B02 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_pr_order") { ?>
						<li class="active"><a href="<?echo("$link_module_01B02")?>"><?echo("$title_module_01B02")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01B02")?>"><?echo("$title_module_01B02")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_01B03 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "sales_pr_confirm") { ?>
						<li class="active"><a href="<?echo("$link_module_01B03")?>"><?echo("$title_module_01B03")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01B03")?>"><?echo("$title_module_01B03")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>

                  <li class="sub-menu">
					  <? if($mmenu == "warehouse") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-square"></i> <span><?echo("$title_module_01C")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-square"></i> <span><?echo("$title_module_01C")?></span></a>
					  <? } ?>
					  <ul class="sub">
						<? if(($now_group_admin == "1" AND $smodule_01B02 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "wms_po") { ?>
						<li class="active"><a href="<?echo("$link_module_01C02")?>"><?echo("$title_module_01C02")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01C02")?>"><?echo("$title_module_01C02")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_01B01 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "wms_so") { ?>
						<li class="active"><a href="<?echo("$link_module_01C01")?>"><?echo("$title_module_01C01")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01C01")?>"><?echo("$title_module_01C01")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_01B03 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "wms_do") { ?>
						<li class="active"><a href="<?echo("$link_module_01C03")?>"><?echo("$title_module_01C03")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_01C03")?>"><?echo("$title_module_01C03")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($login_level > "7" OR $mmodule_02_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "inventory") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-archive"></i> <span><?echo("$title_module_02")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-archive"></i> <span><?echo("$title_module_02")?></span></a>
					  <? } ?>
					  <ul class="sub">

					    <? if(($now_group_admin == "1" AND $smodule_0201 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_stock_in") { ?>
						<li class="active"><a href="<?echo("$link_module_0201")?>"><?echo("$title_module_0201")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201")?>"><?echo("$title_module_0201")?></a></li>
						<? } ?>

						<? if($smenu == "inventory_stock_data1") { ?>
						<li class="active"><a href="<?echo("$link_module_0201A")?>"> + by item</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201A")?>"> + by item</a></li>
						<? } ?>
						<? if($smenu == "inventory_stock_data2") { ?>
						<li class="active"><a href="<?echo("$link_module_0201B")?>"> + <?=$txt_sys_shop_079?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201B")?>"> + <?=$txt_sys_shop_079?></a></li>
						<? } ?>
						<? if($smenu == "inventory_stock_data3") { ?>
						<li class="active"><a href="<?echo("$link_module_0201C")?>"> + <?=$txt_sys_shop_071?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201C")?>"> + <?=$txt_sys_shop_071?></a></li>
						<? } ?>
						<? if($smenu == "inventory_stock_data4") { ?>
						<li class="active"><a href="<?echo("$link_module_0201D")?>"> + <?=$txt_sys_shop_072?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201D")?>"> + <?=$txt_sys_shop_072?></a></li>
						<? } ?>

						<? if($smenu == "inventory_stock_online") { ?>
						<li class="active"><a href="<?echo("$link_module_0201on")?>"><?echo("$title_module_0201on")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0201on")?>"><?echo("$title_module_0201on")?></a></li>
						<? } ?>
					    <? } ?>


					    <? if(($now_group_admin == "1" AND $smodule_0202 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_payment") { ?>
						<li class="active"><a href="<?echo("$link_module_0202")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0202")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0202")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0202")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0203 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_payment2") { ?>
						<li class="active"><a href="<?echo("$link_module_0203")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0203")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0203")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0203")?></a></li>
						<? } ?>
					    <? } ?>

						<? if(($now_group_admin == "1" AND $smodule_0204 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_stock_out") { ?>
						<li class="active"><a href="<?echo("$link_module_0204")?>"><?echo("$title_module_0204")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0204")?>"><?echo("$title_module_0204")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0205 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_delivery") { ?>
						<li class="active"><a href="<?echo("$link_module_0205")?>"><?echo("$title_module_0205")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0205")?>"><?echo("$title_module_0205")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0206 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_delivery2") { ?>
						<li class="active"><a href="<?echo("$link_module_0206")?>"><?echo("$title_module_0206")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0206")?>"><?echo("$title_module_0206")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0208 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_return") { ?>
						<li class="active"><a href="<?echo("$link_module_0208")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0208")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0208")?>"><i class="fa fa-thumb-tack"></i> <?echo("$title_module_0208")?></a></li>
						<? } ?>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0207 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_billing") { ?>
						<li class="active"><a href="<?echo("$link_module_0207")?>"><?echo("$title_module_0207")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0207")?>"><?echo("$title_module_0207")?></a></li>
						<? } ?>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0209 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_pickup") { ?>
						<li class="active"><a href="<?echo("$link_module_0209")?>"><?echo("$title_module_0209")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0209")?>"><?echo("$title_module_0209")?></a></li>
						<? } ?>
					    <? } ?>

						<!--
					    <? if(($now_group_admin == "1" AND $smodule_0210 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "inventory_opname") { ?>
						<li class="active"><a href="<?echo("$link_module_0210")?>"><?echo("$title_module_0210")?> (WH)</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0210")?>"><?echo("$title_module_0210")?>  (WH)</a></li>
						<? } ?>
						-->

						<? if($smenu == "inventory_opname_ini1" OR $smenu == "inventory_opname_ini2" OR $smenu == "inventory_opname_set") { ?>
						<li class="active"><a href="<?echo("$link_module_0210_set")?>"><?echo("$title_module_0210")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0210_set")?>"><?echo("$title_module_0210")?></a></li>
						<? } ?>

						<? if($smenu == "inventory_opname_ini1") { ?>
						<li class="active"><a href="<?echo("$link_module_0210_ini1")?>">+ <?=$txt_sys_shop_079?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0210_ini1")?>">+ <?=$txt_sys_shop_079?></a></li>
						<? } ?>
						<? if($smenu == "inventory_opname_ini2") { ?>
						<li class="active"><a href="<?echo("$link_module_0210_ini2")?>">+ <?=$txt_sys_shop_071?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0210_ini2")?>">+ <?=$txt_sys_shop_071?></a></li>
						<? } ?>
						<? if($smenu == "inventory_opname_ini3") { ?>
						<li class="active"><a href="<?echo("$link_module_0210_ini3")?>">+ <?=$txt_sys_shop_072?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0210_ini3")?>">+ <?=$txt_sys_shop_072?></a></li>
						<? } ?>
						<!-- Inventory opname check -->
						<? if($smenu == "inventory_closing_check") { ?>
						<li class="active"><a href="<?echo("$link_module_0221")?>">Stock Closing Check</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0221")?>">Stock Closing Check</a></li>
						<? } ?>
						<!-- Inventory opname check -->
						<? if($smenu == "inventory_opname_close") { ?>
						<li class="active"><a href="<?echo("$link_module_0220")?>"><?echo("$title_module_0220")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0220")?>"><?echo("$title_module_0220")?></a></li>
						<? } ?>

						<? if($smenu == "inventory_update_cbm") { ?>
						<li class="active"><a href="<?echo("$link_module_0213")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0213")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0213")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0213")?></a></li>
						<? } ?>

						<? if($smenu == "inventory_update_price") { ?>
						<li class="active"><a href="<?echo("$link_module_0214")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0214")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0214")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0214")?></a></li>
						<? } ?>

					    <? } ?>

						<? if($login_level > "7") { ?>

						<? if($smenu == "inventory_option") { ?>
						<li class="active"><a href="<?echo("$link_module_0211")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0211")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0211")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0211")?></a></li>
						<? } ?>

						<? if($smenu == "inventory_unit") { ?>
						<li class="active"><a href="<?echo("$link_module_0212")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0212")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0212")?>"><i class="fa fa-wrench"></i> <?echo("$title_module_0212")?></a></li>
						<? } ?>

						<? } ?>
                      </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_03_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "logistic") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-truck"></i> <span><?echo("$title_module_03")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-truck"></i> <span><?echo("$title_module_03")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0301 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "logistic_docheck") { ?>
						<li class="active"><a href="<?echo("$link_module_0301")?>"><?echo("$title_module_0301")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0301")?>"><?echo("$title_module_0301")?></a></li>
						<? } ?>
					    <? } ?>
					    <? if(($now_group_admin == "1" AND $smodule_0302 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "logistic_progress") { ?>
						<li class="active"><a href="<?echo("$link_module_0302")?>"><?echo("$title_module_0302")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0302")?>"><?echo("$title_module_0302")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_04_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "asset") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-trophy"></i> <span><?echo("$title_module_04")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-trophy"></i> <span><?echo("$title_module_04")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0401 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_asset" OR $smenu == "finance_asset_vehicle") { ?>
						<li class="active"><a href="<?echo("$link_module_0401")?>"><?echo("$title_module_0401")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0401")?>"><?echo("$title_module_0401")?></a></li>
						<? } ?>
					    <? } ?>
                        <? if($smenu == "finance_asset_vehicle") { ?>
						<li class="active"><a href="<?echo("$link_module_04012")?>"><?echo("$title_module_04012")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_04012")?>"><?echo("$title_module_04012")?></a></li>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0402 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_deprec") { ?>
						<li class="active"><a href="<?echo("$link_module_0402")?>"><?echo("$title_module_0402")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0402")?>"><?echo("$title_module_0402")?></a></li>
						<? } ?>
                        <? if($smenu == "finance_amort") { ?>
						<li class="active"><a href="<?echo("$link_module_0404")?>"><?echo("$title_module_0404")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0404")?>"><?echo("$title_module_0404")?></a></li>
						<? } ?>
					    <? } ?>

						<? if(($now_group_admin == "1" AND $smodule_0403 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_cogs") { ?>
						<li class="active"><a href="<?echo("$link_module_0403")?>"><?echo("$title_module_0403")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0403")?>"><?echo("$title_module_0403")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>


				  <? if($mmodule_08_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "crm" OR $mmenu == "hr") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-user"></i> <span><?echo("$title_module_08")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-user"></i> <span><?echo("$title_module_08")?></span></a>
					  <? } ?>
					  <ul class="sub">

					    <? if(($now_group_admin == "1" AND $smodule_0801 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "crm_member" OR $smenu == "crm_memberA" OR $smenu == "crm_memberB") { ?>
						<li class="active"><a href="<?echo("$link_module_0801")?>"><?echo("$title_module_0801")?></a></li>

							<? if($mb_level == "3" AND $mb_type == "2") { ?>
								<li class="active"><a href="<?echo("$link_module_08010")?>">+ <?echo("$hsm_name_06_010")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08010")?>">+ <?echo("$hsm_name_06_010")?></a></li>
							<? } ?>

							<? if($mb_level == "2" AND $mb_type == "2") { ?>
								<li class="active"><a href="<?echo("$link_module_08011")?>">+ <?echo("$hsm_name_06_011")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08011")?>">+ <?echo("$hsm_name_06_011")?></a></li>
							<? } ?>

							<? if($mb_level == "2" AND $mb_type == "0") { ?>
								<li class="active"><a href="<?echo("$link_module_08012")?>">+ <?echo("$hsm_name_06_012")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08012")?>">+ <?echo("$hsm_name_06_012")?></a></li>
							<? } ?>

							<? if($mb_level == "1" AND $mb_type == "3") { ?>
								<li class="active"><a href="<?echo("$link_module_08013")?>">+ <?echo("$hsm_name_06_013")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08013")?>">+ <?echo("$hsm_name_06_013")?></a></li>
							<? } ?>

							<? if($mb_level == "4" AND $mb_type == "3") { ?>
								<li class="active"><a href="<?echo("$link_module_08015")?>">+ <?echo("$hsm_name_06_015")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08015")?>">+ <?echo("$hsm_name_06_015")?></a></li>
							<? } ?>

							<? if($mb_level == "1" AND $mb_type == "0") { ?>
								<li class="active"><a href="<?echo("$link_module_08014")?>">+ <?echo("$hsm_name_06_014")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08014")?>">+ <?echo("$hsm_name_06_014")?></a></li>
							<? } ?>

						<? } else { ?>
						<li><a href="<?echo("$link_module_0801")?>"><?echo("$title_module_0801")?></a></li>
						<? } ?>
					    <? } ?>

						<? if(($now_group_admin == "1" AND $smodule_0802 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "crm_member2") { ?>
						<li class="active"><a href="<?echo("$link_module_0802")?>"><?echo("$title_module_0802")?></a></li>

							<? if($mb_level == "7") { ?>
								<li class="active"><a href="<?echo("$link_module_08021")?>">+ <?echo("$hsm_name_06_021")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08021")?>">+ <?echo("$hsm_name_06_021")?></a></li>
							<? } ?>

							<? if($mb_level == "6") { ?>
								<li class="active"><a href="<?echo("$link_module_08022")?>">+ <?echo("$hsm_name_06_022")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08022")?>">+ <?echo("$hsm_name_06_022")?></a></li>
							<? } ?>

						<? } else { ?>
						<li><a href="<?echo("$link_module_0802")?>"><?echo("$title_module_0802")?></a></li>
						<? } ?>
					    <? } ?>

						<? if(($now_group_admin == "1" AND $smodule_0803 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "hr_member" OR $smenu == "hr_member_work" OR $smenu == "hr_member_history") { ?>
						<li class="active"><a href="<?echo("$link_module_0803")?>"><?echo("$title_module_0803")?></a></li>

							<? if($smenu == "hr_member" AND $hr_type == "1" AND $hr_retire != "1") { ?>
								<li class="active"><a href="<?echo("$link_module_08031")?>">- <?echo("$txt_hr_member_382")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08031")?>">- <?echo("$txt_hr_member_382")?></a></li>
							<? } ?>
							<? if($smenu == "hr_member" AND $hr_type == "1" AND $hr_retire == "1") { ?>
								<li class="active"><a href="<?echo("$link_module_08031x")?>">&nbsp;&nbsp;&nbsp; &gt; <?echo("$txt_hr_member_380")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08031x")?>">&nbsp;&nbsp;&nbsp; &gt; <?echo("$txt_hr_member_380")?></a></li>
							<? } ?>

							<? if($smenu == "hr_member" AND $hr_type == "2" AND $hr_retire != "1") { ?>
								<li class="active"><a href="<?echo("$link_module_08032")?>">- <?echo("$txt_hr_member_381")?> (SA)</a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08032")?>">- <?echo("$txt_hr_member_381")?> (SA)</a></li>
							<? } ?>
							<? if($smenu == "hr_member" AND $hr_type == "2" AND $hr_retire == "1") { ?>
								<li class="active"><a href="<?echo("$link_module_08032x")?>">&nbsp;&nbsp;&nbsp; &gt; <?echo("$txt_hr_member_380")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08032x")?>">&nbsp;&nbsp;&nbsp; &gt; <?echo("$txt_hr_member_380")?></a></li>
							<? } ?>
							<? if($smenu == "hr_member" AND $hr_type == "3" AND $hr_retire != "1") { ?>
								<li class="active"><a href="<?echo("$link_module_08033")?>">- <?echo("$txt_hr_member_383")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08033")?>">- <?echo("$txt_hr_member_383")?></a></li>
							<? } ?>

						<? if($smenu == "hr_member_work") { ?>
						<li class="active"><a href="<?echo("$link_module_08031w")?>"><?echo("$txt_hr_work_011")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_08031w")?>"><?echo("$txt_hr_work_011")?></a></li>
						<? } ?>

						<? if($smenu == "hr_member_history") { ?>
						<li class="active"><a href="<?echo("$link_module_08031w0")?>">Attendance Book NEW</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_08031w0")?>">Attendance Book NEW</a></li>
						<? } ?>

						<? if($smenu == "hr_member_work" AND $hr_type == "1") { ?>
						<li class="active"><a href="<?echo("$link_module_08031w1")?>">- <?echo("$txt_hr_member_382")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_08031w1")?>">- <?echo("$txt_hr_member_382")?></a></li>
						<? } ?>
						<? if($smenu == "hr_member_work" AND $hr_type == "2") { ?>
						<li class="active"><a href="<?echo("$link_module_08031w2")?>">- <?echo("$txt_hr_member_381")?> (SA)</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_08031w2")?>">- <?echo("$txt_hr_member_381")?> (SA)</a></li>
						<? } ?>



						<? if($login_level > "8") { ?>

						<? if($smenu == "hr_incentive_sa" OR $smenu == "hr_incentive_spc" OR $smenu == "hr_incentive_sms"
							 OR $smenu == "hr_incentive_fbs" OR $smenu == "hr_incentive_driver" OR $smenu == "hr_incentive_office") { ?>
						<li class="active"><a href="#">Incentives</a></li>
						<? } else { ?>
						<li><a href="#">Incentive</a></li>
						<? } ?>
						<? if($smenu == "hr_incentive_sa") { ?>
						<li class="active"><a href="<?echo("$link_module_080321")?>">- Incentive - SA</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080321")?>">- Incentive - SA</a></li>
						<? } ?>
						<? if($smenu == "hr_incentive_spc") { ?>
						<li class="active"><a href="<?echo("$link_module_080322")?>">- Incentive - SPC</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080322")?>">- Incentive - SPC</a></li>
						<? } ?>
						<? if($smenu == "hr_incentive_sms") { ?>
						<li class="active"><a href="<?echo("$link_module_080323")?>">- Incentive - SMS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080323")?>">- Incentive - SMS</a></li>
						<? } ?>
						<? if($smenu == "hr_incentive_fbs") { ?>
						<li class="active"><a href="<?echo("$link_module_080324")?>">- Incentive - FBS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080324")?>">- Incentive - FBS</a></li>
						<? } ?>
						<!--
						<? if($smenu == "hr_incentive_driver") { ?>
						<li class="active"><a href="<?echo("$link_module_080325")?>">- Incentive - Driver</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080325")?>">- Incentive - Driver</a></li>
						<? } ?>
						<? if($smenu == "hr_incentive_office") { ?>
						<li class="active"><a href="<?echo("$link_module_080326")?>">- Incentive - Office</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080326")?>">- Incentive - Office</a></li>
						<? } ?>
						-->

						<? if($smenu == "hr_wage_sa" OR $smenu == "hr_wage_spc" OR $smenu == "hr_wage_sms"
							 OR $smenu == "hr_wage_fbs" OR $smenu == "hr_wage_driver" OR $smenu == "hr_wage_office") { ?>
						<li class="active"><a href="#">Wages</a></li>
						<? } else { ?>
						<li><a href="#">Wage</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_sa") { ?>
						<li class="active"><a href="<?echo("$link_module_080331")?>">- Wage - SA</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080331")?>">- Wage - SA</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_spc") { ?>
						<li class="active"><a href="<?echo("$link_module_080332")?>">- Wage - SPC</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080332")?>">- Wage - SPC</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_sms") { ?>
						<li class="active"><a href="<?echo("$link_module_080333")?>">- Wage - SMS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080333")?>">- Wage - SMS</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_fbs") { ?>
						<li class="active"><a href="<?echo("$link_module_080334")?>">- Wage - FBS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080334")?>">- Wage - FBS</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_driver") { ?>
						<li class="active"><a href="<?echo("$link_module_080335")?>">- Wage - Driver</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080335")?>">- Wage - Driver</a></li>
						<? } ?>
						<? if($smenu == "hr_wage_office") { ?>
						<li class="active"><a href="<?echo("$link_module_080336")?>">- Wage - Office</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_080336")?>">- Wage - Office</a></li>
						<? } ?>

						<? } ?>


						<? } else { ?>
						<li><a href="<?echo("$link_module_0803")?>"><?echo("$title_module_0803")?></a></li>
						<? } ?>
					    <? } ?>

						<? if(($now_group_admin == "1" AND $smodule_0804 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "crm_mailing" OR $smenu == "crm_mailing1" OR $smenu == "crm_mailing2" OR $smenu == "crm_mailing3") { ?>
						<li class="active"><a href="<?echo("$link_module_08042")?>"><?echo("$title_module_0804")?></a></li>

							<? if($smenu == "crm_mailing1") { ?>
								<li class="active"><a href="<?echo("$link_module_08041")?>">- <?echo("$title_module_08041")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08041")?>">- <?echo("$title_module_08041")?></a></li>
							<? } ?>
							<? if($smenu == "crm_mailing2") { ?>
								<li class="active"><a href="<?echo("$link_module_08042")?>">- <?echo("$title_module_08042")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08042")?>">- <?echo("$title_module_08042")?></a></li>
							<? } ?>
							<? if($smenu == "crm_mailing3") { ?>
								<li class="active"><a href="<?echo("$link_module_08043")?>">- <?echo("$title_module_08043")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_08043")?>">- <?echo("$title_module_08043")?></a></li>
							<? } ?>

						<? } else { ?>
						<li><a href="<?echo("$link_module_08042")?>"><?echo("$title_module_0804")?></a></li>
						<? } ?>
					    <? } ?>

					    <? if(($now_group_admin == "1" AND $smodule_0805 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "crm_newsletter") { ?>
						<li class="active"><a href="<?echo("$link_module_0805")?>"><?echo("$title_module_0805")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0805")?>"><?echo("$title_module_0805")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>

				  <? if($mmodule_09_act == "1") { ?>
                  <li class="sub-menu">
					  <? if($mmenu == "finance") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-money"></i> <span><?echo("$title_module_09")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-money"></i> <span><?echo("$title_module_09")?></span></a>
					  <? } ?>
					  <ul class="sub">
					    <? if(($now_group_admin == "1" AND $smodule_0901 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_cost") { ?>
						<li class="active"><a href="<?echo("$link_module_0901")?>"><?echo("$title_module_0901")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0901")?>"><?echo("$title_module_0901")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0902 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_cost2") { ?>
						<li class="active"><a href="<?echo("$link_module_0902")?>"><?echo("$title_module_0902")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0902")?>"><?echo("$title_module_0902")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0903 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_income") { ?>
						<li class="active"><a href="<?echo("$link_module_0903")?>"><?echo("$title_module_0903")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0903")?>"><?echo("$title_module_0903")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0904 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_income2") { ?>
						<li class="active"><a href="<?echo("$link_module_0904")?>"><?echo("$title_module_0904")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0904")?>"><?echo("$title_module_0904")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0905 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_invoice") { ?>
						<li class="active"><a href="<?echo("$link_module_0905")?>"><?echo("$title_module_0905")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_0905")?>"><?echo("$title_module_0905")?></a></li>
						<? } ?>
					    <? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0906 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "finance_balance") { ?>
						<li class="active"><a href="<?echo("$link_module_0906")?>"><?echo("$title_module_0906")?></a></li>
						<? } else { global $title_module_0906; ?>
						<li><a href="<?echo("$link_module_0906")?>"><?echo("$title_module_0906")?></a></li>
						<? } ?>
						<? } ?>
						<? if(($now_group_admin == "1" AND $smodule_0907 == "1") OR $now_group_admin == "0") { ?>
                        <? if($smenu == "currency_balance") { ?>
						<li class="active"><a href="<?echo("$link_module_0907")?>"><?echo("$title_module_0907")?></a></li>
						<? } else { global $title_module_0907; ?>
						<li><a href="<?echo("$link_module_0907")?>"><?echo("$title_module_0907")?></a></li>
						<? } ?>
					    <? } ?>
					  </ul>
                  </li>
				  <? } ?>




				  <? // if($mmodule_11_act == "1") { ?>
				  <li class="sub-menu">
					  <? if($mmenu == "website") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-globe"></i> <span><?echo("$title_module_11")?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-globe"></i> <span><?echo("$title_module_11")?></span></a>
					  <? } ?>
					  <ul class="sub">
                        <? if($smenu == "website_menu") { ?>
                        <li class="active"><a href="<?echo("$link_module_1101")?>"><?echo("$title_module_1101")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1101")?>"><?echo("$title_module_1101")?></a></li>
						<? } ?>
						<? if($smenu == "website_content") { ?>
                        <li class="active"><a href="<?echo("$link_module_1102")?>"><?echo("$title_module_1102")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1102")?>"><?echo("$title_module_1102")?></a></li>
						<? } ?>
						<? if($smenu == "website_banner1") { ?>
                        <li class="active"><a href="<?echo("$link_module_1103")?>"><?echo("$title_module_1103")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1103")?>"><?echo("$title_module_1103")?></a></li>
						<? } ?>
						<? if($smenu == "website_banner2") { ?>
                        <li class="active"><a href="<?echo("$link_module_1104")?>"><?echo("$title_module_1104")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1104")?>"><?echo("$title_module_1104")?></a></li>
						<? } ?>
						<? if($smenu == "website_stuff") { ?>
                        <li class="active"><a href="<?echo("$link_module_1105")?>"><?echo("$title_module_1105")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1105")?>"><?echo("$title_module_1105")?></a></li>
						<? } ?>
						<? if($smenu == "website_layout") { ?>
                        <li class="active"><a href="<?echo("$link_module_1106")?>"><?echo("$title_module_1106")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_1106")?>"><?echo("$title_module_1106")?></a></li>
						<? } ?>
                      </ul>
                  </li>
				  <? // } ?>



				  <li class="sub-menu">
					  <? if($mmenu == "table") { ?>
                      <a href="javascript:;" class="active"><i class="fa fa-signal"></i> <span><?=$title_report?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"><i class="fa fa-signal"></i> <span><?=$title_report?></span></a>
					  <? } ?>
                      <ul class="sub">
						<? if($smenu == "table_report_08") { ?>
                        <li class="active"><a href="<?=$link_report_08?>"><?=$title_report_08?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_08?>"><?=$title_report_08?></a></li>
						<? } ?>
						<? if($smenu == "table_report_08B") { ?>
                        <li class="active"><a href="<?=$link_report_08B?>">- <?=$title_report_08B?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_08B?>">- <?=$title_report_08B?></a></li>
						<? } ?>
						<? if($smenu == "table_report_01") { ?>
                        <li class="active"><a href="<?=$link_report_01?>"><?=$title_report_01?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_01?>"><?=$title_report_01?></a></li>
						<? } ?>
						<? if($smenu == "table_report_02") { ?>
                        <li class="active"><a href="<?=$link_report_02?>"><?=$title_report_02?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_02?>"><?=$title_report_02?></a></li>
						<? } ?>
						<? if($smenu == "table_report_31") { ?>
                        <li class="active"><a href="<?=$link_report_31?>"><?=$title_report_31?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_31?>"><?=$title_report_31?></a></li>
						<? } ?>
						<? if($smenu == "table_report_05") { ?>
                        <li class="active"><a href="<?=$link_report_05?>"><?=$title_report_05?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_05?>"><?=$title_report_05?></a></li>
						<? } ?>
						<? if($smenu == "table_report") { ?>
                        <li class="active"><a href="<?=$link_report_05B?>">- <?=$title_report_05B?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_05B?>">- <?=$title_report_05B?></a></li>
						<? } ?>
						<? if($smenu == "table_report_04") { ?>
                        <li class="active"><a href="<?=$link_report_04?>"><?=$title_report_04?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_04?>"><?=$title_report_04?></a></li>
						<? } ?>
						<? if($smenu == "table_report_09") { ?>
                        <li class="active"><a href="<?=$link_report_09?>"><?=$title_report_09?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_09?>"><?=$title_report_09?></a></li>
						<? } ?>
						<? if($smenu == "table_report_10A") { ?>
                        <li class="active"><a href="<?=$link_report_10A?>">- <?=$title_report_10A?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_10A?>">- <?=$title_report_10A?></a></li>
						<? } ?>
						<? if($smenu == "table_report_10B") { ?>
                        <li class="active"><a href="<?=$link_report_10B?>">- <?=$title_report_10B?></a></li>
						<? } else { ?>
						<li><a href="<?=$link_report_10B?>">- <?=$title_report_10B?></a></li>
						<? } ?>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Charts</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="graph_morris.php">Morris</a></li>
                          <li><a  href="graph_chartjs.php">Chartjs</a></li>
                          <li><a  href="graph_flot_chart.php">Flot Charts</a></li>
                          <li><a  href="graph_xchart.php">xChart</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-envelope"></i>
                          <span>Mail</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="#">Inbox</a></li>
                          <li><a  href="#">Inbox Details</a></li>
                      </ul>
                  </li>

				  <? if($login_level > "5") { ?>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Shop</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="#">List View</a></li>
                          <li><a  href="#">Details View</a></li>
                      </ul>
                  </li>

				  <!--
                  <li>
                      <a href="google_maps.php" >
                          <i class="fa fa-map-marker"></i>
                          <span>Google Maps </span>
                      </a>
                  </li>
				  -->
				  <? } ?>

                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-comments-o"></i>
                          <span>Chat Room</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="chat_lobby.php">Lobby</a></li>
                          <li><a  href="chat_room.php"> Chat Room</a></li>
                      </ul>
                  </li>


				  <? if($login_level > "7") { ?>
				  <li class="sub-menu">
					  <? if($mmenu == "system") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-wrench"></i> <span><?=$hmm_name_09?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-wrench"></i> <span><?=$hmm_name_09?></span></a>
					  <? } ?>
					  <ul class="sub">
                        <? if($smenu == "system_client") { ?>
                        <li class="active"><a href="<?echo("$link_module_2101")?>"><?echo("$hsm_name_09_01")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2101")?>"><?echo("$hsm_name_09_01")?></a></li>
						<? } ?>
						<? if($smenu == "system_user") { ?>
						<li class="active"><a href="<?echo("$link_module_2102")?>"><?echo("$hsm_name_09_02")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2102")?>"><?echo("$hsm_name_09_02")?></a></li>
						<? } ?>
						<? if($smenu == "system_department") { ?>
                        <li class="active"><a href="<?echo("$link_module_2101d")?>"><?echo("$hsm_name_09_01d")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2101d")?>"><?echo("$hsm_name_09_01d")?></a></li>
						<? } ?>

						<? if($smenu == "system_warehouse") { ?>
						<li class="active"><a href="<?echo("$link_module_2117")?>"><?echo("$hsm_name_09_17")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2117")?>"><?echo("$hsm_name_09_17")?></a></li>
						<? } ?>

							<? if($smenu == "system_wloc_catg") { ?>
							<li class="active"><a href="<?echo("$link_module_211701")?>">- <?echo("$hsm_name_09_1701")?></a></li>
							<? } else { ?>
							<li><a href="<?echo("$link_module_211701")?>">- <?echo("$hsm_name_09_1701")?></a></li>
							<? } ?>
							<? if($smenu == "system_wloc_list") { ?>
							<li class="active"><a href="<?echo("$link_module_211702")?>">- <?echo("$hsm_name_09_1702")?></a></li>
							<? } else { ?>
							<li><a href="<?echo("$link_module_211702")?>">- <?echo("$hsm_name_09_1702")?></a></li>
							<? } ?>


						<? if($smenu == "system_brand") { ?>
						<li class="active"><a href="<?echo("$link_module_2104A")?>"><?echo("$hsm_name_09_04A")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2104A")?>"><?echo("$hsm_name_09_04A")?></a></li>
						<? } ?>
						<? if($smenu == "system_category") { ?>
						<li class="active"><a href="<?echo("$link_module_2105")?>"><?echo("$hsm_name_09_05")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2105")?>"><?echo("$hsm_name_09_05")?></a></li>
						<? } ?>
						<? if($smenu == "system_consign") { ?>
						<li class="active"><a href="<?echo("$link_module_2118")?>"><?echo("$hsm_name_09_18")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2118")?>"><?echo("$hsm_name_09_18")?></a></li>
						<? } ?>
						<? if($smenu == "check_code") { ?>
						<li class="active"><a href="<?echo("$link_check_shop_code")?>">
						Check Client Shop Code</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_check_shop_code")?>">Check Client Shop Code</a>
						</li>
						<? } ?>
						<? if($smenu == "shop_code") { ?>
						<li class="active"><a href="<?echo("$link_shop_code")?>">
						All Shop Codes</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_shop_code")?>">All Shop Codes</a>
						</li>
						<? } ?>
                        <? if($smenu == "check_code_cvj") { ?>
                        <li class="active"><a href="<?echo("$link_check_shop_cvj")?>">
                        Table Store Name CVJ</a></li>
                        <? } else { ?>
                        <li><a href="<?echo("$link_check_shop_cvj")?>">Table Store Name CVJ</a>
                        </li>
                        <? } ?>



						<? if($smenu == "system_shop" OR $smenu == "system_shop2") { ?>
						<li class="active"><a href="<?echo("$link_module_21031")?>"><?echo("$hsm_name_09_031")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21031")?>"><?echo("$hsm_name_09_031")?></a></li>
						<? } ?>

							<? if($smenu == "system_shop" AND $asso_type == "A") { ?>
								<li class="active"><a href="<?echo("$link_module_21031A")?>">- <?echo("$txt_sys_shop_072")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21031A")?>">- <?echo("$txt_sys_shop_072")?></a></li>
							<? } ?>
							<? if($smenu == "system_shop2") { ?>
								<li class="active"><a href="<?echo("$link_module_21031A2")?>"> &nbsp;&nbsp; by Customer</a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21031A2")?>"> &nbsp;&nbsp; by Customer</a></li>
							<? } ?>
							<? if($smenu == "system_shop" AND $asso_type == "B") { ?>
								<li class="active"><a href="<?echo("$link_module_21031B")?>">- <?echo("$txt_sys_shop_071")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21031B")?>">- <?echo("$txt_sys_shop_071")?></a></li>
							<? } ?>
							<? if($smenu == "system_shop" AND $asso_type == "E") { ?>
								<li class="active"><a href="<?echo("$link_module_21031E")?>">- <?echo("$txt_sys_shop_074")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21031E")?>">- <?echo("$txt_sys_shop_074")?></a></li>
							<? } ?>

						<? if($smenu == "system_user2") { ?>
						<li class="active"><a href="<?echo("$link_module_21032")?>"><?echo("$hsm_name_09_032")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21032")?>"><?echo("$hsm_name_09_032")?></a></li>
						<? } ?>

							<? if($smenu == "system_user2" AND $shop_flag == "1") { ?>
								<li class="active"><a href="<?echo("$link_module_21032A")?>">- <?echo("$txt_sys_shop_073")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21032A")?>">- <?echo("$txt_sys_shop_073")?></a></li>
							<? } ?>
							<? if($smenu == "system_user2" AND $shop_flag == "2") { ?>
								<li class="active"><a href="<?echo("$link_module_21032B")?>">- <?echo("$txt_sys_shop_071")?></a></li>
							<? } else { ?>
								<li><a href="<?echo("$link_module_21032B")?>">- <?echo("$txt_sys_shop_071")?></a></li>
							<? } ?>

						<? if($smenu == "system_supplier") { ?>
						<li class="active"><a href="<?echo("$link_module_2104")?>"><?echo("$hsm_name_09_04")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2104")?>"><?echo("$hsm_name_09_04")?></a></li>
						<? } ?>
						<? if($smenu == "system_mileage") { ?>
						<li class="active"><a href="<?echo("$link_module_2106")?>"><?echo("$hsm_name_09_06")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2106")?>"><?echo("$hsm_name_09_06")?></a></li>
						<? } ?>
						<? if($smenu == "system_discount") { ?>
						<li class="active"><a href="<?echo("$link_module_2107")?>"><?echo("$hsm_name_09_07")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2107")?>"><?echo("$hsm_name_09_07")?></a></li>
						<? } ?>
						<? if($smenu == "system_voucher") { ?>
						<li class="active"><a href="<?echo("$link_module_2108")?>"><?echo("$hsm_name_09_08")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2108")?>"><?echo("$hsm_name_09_08")?></a></li>
						<? } ?>
						<? if($smenu == "system_discount2") { ?>
						<li class="active"><a href="<?echo("$link_module_2109")?>"><?echo("$hsm_name_09_09")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2109")?>"><?echo("$hsm_name_09_09")?></a></li>
						<? } ?>

						<? if($smenu == "system_currency") { ?>
						<li class="active"><a href="<?echo("$link_module_2103C")?>"><?echo("$hsm_name_09_03C")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2103C")?>"><?echo("$hsm_name_09_03C")?></a></li>
						<? } ?>
						<? if($smenu == "system_cash") { ?>
						<li class="active"><a href="<?echo("$link_module_2110")?>"><?echo("$hsm_name_09_10")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2110")?>"><?echo("$hsm_name_09_10")?></a></li>
						<? } ?>
						<? if($smenu == "system_bank") { ?>
						<li class="active"><a href="<?echo("$link_module_2111")?>"><?echo("$hsm_name_09_11")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2111")?>"><?echo("$hsm_name_09_11")?></a></li>
						<? } ?>
						<? if($smenu == "system_card") { ?>
						<li class="active"><a href="<?echo("$link_module_2112")?>"><?echo("$hsm_name_09_12")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2112")?>"><?echo("$hsm_name_09_12")?></a></li>
						<? } ?>
						<? if($smenu == "system_insurance") { ?>
						<li class="active"><a href="<?echo("$link_module_2112a")?>"><?echo("$hsm_name_09_12a")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2112a")?>"><?echo("$hsm_name_09_12a")?></a></li>
						<? } ?>

						<? if($smenu == "system_account") { ?>
						<li class="active"><a href="<?echo("$link_module_2113")?>"><?echo("$hsm_name_09_13")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2113")?>"><?echo("$hsm_name_09_13")?></a></li>
						<? } ?>
						<? if($smenu == "system_account2") { ?>
						<li class="active"><a href="<?echo("$link_module_21132")?>"><?echo("$hsm_name_09_132")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21132")?>"><?echo("$hsm_name_09_132")?></a></li>
						<? } ?>
						<? if($smenu == "system_budget") { ?>
						<li class="active"><a href="<?echo("$link_module_21133")?>"><?echo("$hsm_name_09_133")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21133")?>"><?echo("$hsm_name_09_133")?></a></li>
						<? } ?>

						<? if($smenu == "system_xchange") { ?>
						<li class="active"><a href="<?echo("$link_module_2120")?>"><?echo("$hsm_name_09_20")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2120")?>"><?echo("$hsm_name_09_20")?></a></li>
						<? } ?>

						<? if($smenu == "system_tdir") { ?>
						<li class="active"><a href="<?echo("$link_module_21341")?>"><?echo("$hsm_name_09_341")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21341")?>"><?echo("$hsm_name_09_341")?></a></li>
						<? } ?>
						<? if($smenu == "system_tcourse") { ?>
						<li class="active"><a href="<?echo("$link_module_21342")?>"><?echo("$hsm_name_09_342")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21342")?>"><?echo("$hsm_name_09_342")?></a></li>
						<? } ?>

						<? if($login_level > "8") { ?>

						<? if($smenu == "system_region") { ?>
						<li class="active"><a href="<?echo("$link_module_2115")?>"><?echo("$hsm_name_09_15")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2115")?>"><?echo("$hsm_name_09_15")?></a></li>
						<? } ?>
						<? if($smenu == "system_port") { ?>
						<li class="active"><a href="<?echo("$link_module_2116")?>"><?echo("$hsm_name_09_16")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2116")?>"><?echo("$hsm_name_09_16")?></a></li>
						<? } ?>
						<? if($smenu == "system_jobclass") { ?>
						<li class="active"><a href="<?echo("$link_module_2141")?>"><?echo("$hsm_name_09_41")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2141")?>"><?echo("$hsm_name_09_41")?></a></li>
						<? } ?>
						<? if($smenu == "system_payclass") { ?>
						<li class="active"><a href="<?echo("$link_module_2142")?>"><?echo("$hsm_name_09_42")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2142")?>"><?echo("$hsm_name_09_42")?></a></li>
						<? } ?>
						<? if($smenu == "system_paybase") { ?>
						<li class="active"><a href="<?echo("$link_module_2143")?>"><?echo("$hsm_name_09_43")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2143")?>"><?echo("$hsm_name_09_43")?></a></li>
						<? } ?>

						<? if($smenu == "system_incentive_sa" OR $smenu == "system_incentive_spc" OR $smenu == "system_incentive_sms"
							 OR $smenu == "system_incentive_fbs" OR $smenu == "system_incentive_driver" OR $smenu == "system_incentive_office") { ?>
						<li class="active"><a href="#">Incentive</a></li>
						<? } else { ?>
						<li><a href="#">Incentive</a></li>
						<? } ?>
						<? if($smenu == "system_incentive_sa") { ?>
						<li class="active"><a href="<?echo("$link_module_2151")?>">- Incentive - SA</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2151")?>">- Incentive - SA</a></li>
						<? } ?>
						<!--
						<? if($smenu == "system_incentive_spc") { ?>
						<li class="active"><a href="<?echo("$link_module_2152")?>">- Incentive - SPC</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2152")?>">- Incentive - SPC</a></li>
						<? } ?>
						<? if($smenu == "system_incentive_sms") { ?>
						<li class="active"><a href="<?echo("$link_module_2153")?>">- Incentive - SMS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2153")?>">- Incentive - SMS</a></li>
						<? } ?>
						-->
						<? if($smenu == "system_incentive_fbs") { ?>
						<li class="active"><a href="<?echo("$link_module_2154")?>">- Incentive - FBS</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2154")?>">- Incentive - FBS</a></li>
						<? } ?>
						<? if($smenu == "system_incentive_fbs_cost") { ?>
						<li class="active"><a href="<?echo("$link_module_21541")?>">&nbsp;&nbsp; - FBS Costs</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21541")?>">&nbsp;&nbsp; - FBS Costs</a></li>
						<? } ?>
						<!--
						<? if($smenu == "system_incentive_driver") { ?>
						<li class="active"><a href="<?echo("$link_module_2155")?>">- Incentive - Driver</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2155")?>">- Incentive - Driver</a></li>
						<? } ?>
						<? if($smenu == "system_incentive_office") { ?>
						<li class="active"><a href="<?echo("$link_module_2156")?>">- Incentive - Office</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2156")?>">- Incentive - Office</a></li>
						<? } ?>
						-->


						<? if($smenu == "system_zone_acccatg") { ?>
						<li class="active"><a href="<?echo("$link_module_21241")?>">Accounting Category</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21241")?>">Accounting Category</a></li>
						<? } ?>

						<? if($smenu == "system_zone_acclist") { ?>
						<li class="active"><a href="<?echo("$link_module_21242")?>">Accounting Codes</a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_21242")?>">Accounting Codes</a></li>
						<? } ?>

						<? if($smenu == "system_zdblink") { ?>
						<li class="active"><a href="<?echo("$link_module_2121")?>"><?echo("$hsm_name_09_21")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2121")?>"><?echo("$hsm_name_09_21")?></a></li>
						<? } ?>
						<? if($smenu == "system_zcorp") { ?>
						<li class="active"><a href="<?echo("$link_module_2122")?>"><?echo("$hsm_name_09_22")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$link_module_2122")?>"><?echo("$hsm_name_09_22")?></a></li>
						<? } ?>

						<? } ?>
                      </ul>
                  </li>
				  <? } ?>

                  <li class="sub-menu">
					  <? if($mmenu == "user") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-cog"></i> <span><?=$hmm_name_10?></span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-cog"></i> <span><?=$hmm_name_10?></span></a>
					  <? } ?>
					  <ul class="sub">
                        <? if($login_level > "0" AND $login_id != "") { ?>
						<? if($smenu == "user_layout") { ?>
                        <li class="active"><a href="<?echo("$hsmenu_10_01")?>"><?echo("$hsm_name_10_01")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$hsmenu_10_01")?>"><?echo("$hsm_name_10_01")?></a></li>
						<? } ?>
						<? if($smenu == "user_update") { ?>
						<li class="active"><a href="<?echo("$hsmenu_10_02")?>"><?echo("$hsm_name_10_02")?></a></li>
						<? } else { ?>
						<li><a href="<?echo("$hsmenu_10_02")?>"><?echo("$hsm_name_10_02")?></a></li>
						<? } ?>
						<li><a href="<?echo("$hsmenu_10_06")?>"><?echo("$hsm_name_10_06")?></a></li>
						<? } ?>
                      </ul>
                  </li>

				  <? if($login_level > "8") { ?>
				  <li class="sub-menu">
					  <? if($mmenu == "restore") { ?>
                      <a href="javascript:;" class="active"> <i class="fa fa-refresh"></i> <span>Data Mining</span></a>
					  <? } else { ?>
					  <a href="javascript:;"> <i class="fa fa-refresh"></i> <span>Data Mining</span></a>
					  <? } ?>
					  <ul class="sub">
						<? if($smenu == "restore_category") { ?>
                        <li class="active"><a href="restore_category.php">Category</a></li>
						<? } else { ?>
						<li><a href="restore_category.php">Category</a></li>
						<? } ?>
                        <? if($smenu == "restore_item_list") { ?>
                        <li class="active"><a href="restore_item_list.php">Items & Categories</a></li>
						<? } else { ?>
						<li><a href="restore_item_list.php">Items & Categories</a></li>
						<? } ?>

						<? if($smenu == "restore_item") { ?>
                        <li class="active"><a href="restore_item.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } else { ?>
						<li><a href="restore_item.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } ?>
						<? if($smenu == "restore_item_store_list") { ?>
                        <li class="active"><a href="restore_item_store_list.php">Stores & Warehouses</a></li>
						<? } else { ?>
						<li><a href="restore_item_store_list.php">Stores & Warehouses</a></li>
						<? } ?>
						<? if($smenu == "restore_item_store") { ?>
                        <li class="active"><a href="restore_item_store.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } else { ?>
						<li><a href="restore_item_store.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } ?>

						<? if($smenu == "restore_item_unit_list") { ?>
                        <li class="active"><a href="restore_item_unit_list.php">Items & Bulk Qty / CBM</a></li>
						<? } else { ?>
						<li><a href="restore_item_unit_list.php">Items & Bulk Qty / CBM</a></li>
						<? } ?>
						<? if($smenu == "restore_item_unit") { ?>
                        <li class="active"><a href="restore_item_unit.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } else { ?>
						<li><a href="restore_item_unit.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } ?>

						<? if($smenu == "restore_stock_opname_list") { ?>
                        <li class="active"><a href="restore_stock_opname_list.php">Initial Stock Opname</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_list.php">Initial Stock Opname</a></li>
						<? } ?>

						<? if($smenu == "restore_stock_opname") { ?>
                        <li class="active"><a href="restore_stock_opname.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname.php">&nbsp;&nbsp; &gt; Restore now</a></li>
						<? } ?>

						<? if($smenu == "restore_stock_opname_month") { ?>
                        <li class="active"><a href="restore_stock_opname_month2.php">Monthly Stock - CVJ</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_month2.php">Monthly Stock - CVJ</a></li>
						<? } ?>
						<? if($smenu == "yearly_stock_cvj") { ?>
                        <li class="active"><a href="yearly_stock_cvj.php">Summary CVJ</a></li>
						<? } else { ?>
						<li><a href="yearly_stock_cvj.php">Summary CVJ</a></li>
						<? } ?>
						<? if($smenu == "restore_stock_opname_cvj") { ?>
                        <li class="active"><a href="restore_stock_opname_cvj.php">&nbsp;&nbsp; &gt; Restore now CVJ</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_cvj.php">&nbsp;&nbsp; &gt; Restore now CVJ</a></li>
						<? } ?>


                        <? if($smenu == "restore_stock_opname_monthjsi") { ?>
                        <li class="active"><a href="restore_stock_opname_monthjsi.php">Monthly Stock - JSI</a></li>
                        <? } else { ?>
                        <li><a href="restore_stock_opname_monthjsi.php">Monthly Stock - JSI</a></li>
                        <? } ?>
                        <? if($smenu == "restore_stock_opname_jsi") { ?>
                        <li class="active"><a href="restore_stock_opname_jsi.php">&nbsp;&nbsp; &gt; Restore now JSI</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_jsi.php">&nbsp;&nbsp; &gt; Restore now JSI
						</a></li>
						<? } ?>

                        <? if($smenu == "restore_stock_opname_monthlnl") { ?>
						<li class="active"><a href="restore_stock_opname_monthlnl.php">Monthly Stock - L&L</a></li>
                        <? } else { ?>
                        <li><a href="restore_stock_opname_monthlnl.php">Monthly Stock - L&L</a></li>
                        <? } ?>
                        <? if($smenu == "restore_stock_opname_lnl") { ?>
                        <li class="active"><a href="restore_stock_opname_lnl.php">&nbsp;&nbsp; &gt; Restore now Lock & Lock</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_lnl.php">&nbsp;&nbsp; &gt; Restore now Lock & Lock
						</a></li>
						<? } ?>

                        <? if($smenu == "restore_stock_opname_monthfb") { ?>
                        <li class="active"><a href="restore_stock_opname_monthfb.php">Monthly Stock - Feelbuy</a></li>
                        <? } else { ?>
                        <li><a href="restore_stock_opname_monthfb.php">Monthly Stock - Feelbuy</a></li>
                        <? } ?>
						<? if($smenu == "restore_stock_opname_fb") { ?>
                        <li class="active"><a href="restore_stock_opname_fb.php">&nbsp;&nbsp; &gt; Restore now Feelbuy</a></li>
						<? } else { ?>
						<li><a href="restore_stock_opname_fb.php">&nbsp;&nbsp; &gt; Restore now Feelbuy
						</a></li>
						<? } ?>


                      </ul>
                  </li>
				  <? } ?>


              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
