<?php

require "func/mysqli_result.php";

$dbconn = new mysqli($DB_HOST,$DB_USER,$DB_PASSWORD, $DB_SCHEMA);
if ($dbconn -> connect_errno) {
    echo "Failed to connect the database" . mysqli -> connect_error;
	exit();
}

// Channel Code & Website Account
global $login_branch;
#$query_wbs = "SELECT branch_name,signdate FROM client_branch WHERE branch_code = '$login_branch'";
$query_wbs = "SELECT branch_name,signdate FROM client_branch WHERE branch_code = 'CORP_05'";
$result_wbs = mysqli_query($dbconn, $query_wbs);
if(!$result_wbs) {  echo("Error description: " . mysqli_error($dbconn)); }
$row_wbs = mysqli_fetch_array($result_wbs);

$now_branch_name = $row_wbs["branch_name"];
// $now_branch_name = stripslashes($now_branch_name);
$branch_signdate = $row_wbs["signdate"];

// Reporting Date
date_default_timezone_set("Asia/Bangkok");
$branch_signyear = date("Y",$branch_signdate);
$branch_signyear_prev = $branch_signyear - 1;

$report_last_date = "$branch_signyear_prev"."1231";
$report_start_date = "$branch_signyear"."0101";


// Currency
$query_cur = "SELECT default_currency,currency_01 FROM client_currency";
$result_cur = mysqli_query($dbconn, $query_cur);
if(!$result_cur) { error("QUERY_ERROR"); exit; }
$row_cur = mysqli_fetch_object($result_cur);

$now_currency1 = $row_cur->default_currency;
if(!$now_currency1 OR $now_currency1 == "") {
	$now_currency1 = "USD";
}
$now_currency2 = $row_cur->currency_01;


// Exchange Rate
$query_xcg = "SELECT xchange_rate,upd_date FROM shop_xchange ORDER BY upd_date DESC";
$result_xcg = mysqli_query($dbconn, $query_xcg);
if (!$result_xcg) {   var_dump("QUERY_ERROR");   exit; }
// var_dump(mysqli_num_rows($result_xcg)); die();
$now_xchange_rate = @mysqli_result($result_xcg,0,0);
$now_xchange_date = @mysqli_result($result_xcg,0,1);


// Main Modules
global $login_gate;
$query_asso = "SELECT associate,web_flag,gatepage,module_01,module_01B,module_02,module_03,module_04,module_05,
			module_06,module_07,module_08,module_09,module_10,module_11 FROM client WHERE branch_code = '$login_branch' AND client_id = '$login_gate'";
$result_asso = mysqli_query($dbconn, $query_asso);
	if (!$result_asso) { error("QUERY_ERROR"); exit; }
$now_associate = @mysqli_result($result_asso,0,0);
$now_web_flag = @mysqli_result($result_asso,0,1);
$now_gatepage = @mysqli_result($result_asso,0,2);
$mmodule_01 = @mysqli_result($result_asso,0,3); // 01. Purchasing
$mmodule_01B = @mysqli_result($result_asso,0,4); // 01B. Purchase Request (PR)
$mmodule_02 = @mysqli_result($result_asso,0,5); // 02. Inventory (SCO)
$mmodule_03 = @mysqli_result($result_asso,0,6); // 03. Logistics
$mmodule_04 = @mysqli_result($result_asso,0,7); // 04. Asset Management
$mmodule_05 = @mysqli_result($result_asso,0,8); // 05. Sales (FeelBuy Shop)
$mmodule_06 = @mysqli_result($result_asso,0,9); // 06. Sales (Associate Store)
$mmodule_07 = @mysqli_result($result_asso,0,10); // 07. Sales (Direct Sales)
$mmodule_08 = @mysqli_result($result_asso,0,11); // 08. CRM/HR
$mmodule_09 = @mysqli_result($result_asso,0,12); // 09. Finance
$mmodule_10 = @mysqli_result($result_asso,0,13); // 10. Accounting
$mmodule_11 = @mysqli_result($result_asso,0,14); // 11. CMS (Website)


// Associate Types & POS Types
global $login_level;
if($login_level < 3) {
	if($now_associate == "1") {
		$pos_type = "3"; // Associate Store
	} else if($now_associate == "0") {
		$pos_type = "2"; // FeelBuy Shop
	}
} else {
		$pos_type = "1"; // Direct Sales
}




// Language & Sub-Modules
global $login_id;
$query_lang = "SELECT default_lang,group_admin,module_01,module_01B,module_02,module_03,module_04,module_05,
			module_06,module_07,module_08,module_09,module_10,module_11 FROM admin_user WHERE user_id = '$login_id'";
$result_lang = mysqli_query($dbconn, $query_lang);
  if(!$result_lang) { error("QUERY_ERROR"); exit; }
  $row_lang = mysqli_fetch_array($result_lang);
  
$lang = $row_lang["default_lang"];
if(!$lang OR $lang == "") {
	$lang = "en";
}

$now_group_admin = $row_lang["group_admin"];
$smodule_01 = $row_lang["module_01"];
$smodule_01B = $row_lang["module_01B"];
$smodule_02 = $row_lang["module_02"];
$smodule_03 = $row_lang["module_03"];
$smodule_04 = $row_lang["module_04"];
$smodule_05 = $row_lang["module_05"];
$smodule_06 = $row_lang["module_06"];
$smodule_07 = $row_lang["module_07"];
$smodule_08 = $row_lang["module_08"];
$smodule_09 = $row_lang["module_09"];
$smodule_10 = $row_lang["module_10"];
$smodule_11 = $row_lang["module_11"];


// 01. Purchasing
$smodule_0101 = substr($smodule_01,0,1);
$smodule_0102 = substr($smodule_01,1,1);
$smodule_0103 = substr($smodule_01,2,1);
$smodule_0104 = substr($smodule_01,3,1);
$smodule_0105 = substr($smodule_01,4,1);
$smodule_0106 = substr($smodule_01,5,1);
$smodule_0107 = substr($smodule_01,6,1);
$smodule_0108 = substr($smodule_01,7,1);
$smodule_0109 = substr($smodule_01,8,1);
$smodule_0110 = substr($smodule_01,9,1);

// 04. Asset
$smodule_0401 = substr($smodule_04,0,1);
$smodule_0402 = substr($smodule_04,1,1);
$smodule_0403 = substr($smodule_04,2,1);
$smodule_0404 = substr($smodule_04,3,1);
$smodule_0405 = substr($smodule_04,4,1);
$smodule_0406 = substr($smodule_04,5,1);
$smodule_0407 = substr($smodule_04,6,1);
$smodule_0408 = substr($smodule_04,7,1);
$smodule_0409 = substr($smodule_04,8,1);
$smodule_0410 = substr($smodule_04,9,1);

// 08. CRM/HR
$smodule_0801 = substr($smodule_08,0,1);
$smodule_0802 = substr($smodule_08,1,1);
$smodule_0803 = substr($smodule_08,2,1);
$smodule_0804 = substr($smodule_08,3,1);
$smodule_0805 = substr($smodule_08,4,1);
$smodule_0806 = substr($smodule_08,5,1);
$smodule_0807 = substr($smodule_08,6,1);
$smodule_0808 = substr($smodule_08,7,1);
$smodule_0809 = substr($smodule_08,8,1);
$smodule_0810 = substr($smodule_08,9,1);

// 09. Finance
$smodule_0901 = substr($smodule_09,0,1);
$smodule_0902 = substr($smodule_09,1,1);
$smodule_0903 = substr($smodule_09,2,1);
$smodule_0904 = substr($smodule_09,3,1);
$smodule_0905 = substr($smodule_09,4,1);
$smodule_0906 = substr($smodule_09,5,1);
$smodule_0907 = substr($smodule_09,6,1);
$smodule_0908 = substr($smodule_09,7,1);
$smodule_0909 = substr($smodule_09,8,1);
$smodule_0910 = substr($smodule_09,9,1);

// 11. Accounting
$smodule_1101 = substr($smodule_11,0,1);
$smodule_1102 = substr($smodule_11,1,1);
$smodule_1103 = substr($smodule_11,2,1);
$smodule_1104 = substr($smodule_11,3,1);
$smodule_1105 = substr($smodule_11,4,1);
$smodule_1106 = substr($smodule_11,5,1);
$smodule_1107 = substr($smodule_11,6,1);
$smodule_1108 = substr($smodule_11,7,1);
$smodule_1109 = substr($smodule_11,8,1);
$smodule_1110 = substr($smodule_11,9,1);

// 10. CMS
$smodule_1001 = substr($smodule_10,0,1);
$smodule_1002 = substr($smodule_10,1,1);
$smodule_1003 = substr($smodule_10,2,1);
$smodule_1004 = substr($smodule_10,3,1);
$smodule_1005 = substr($smodule_10,4,1);
$smodule_1006 = substr($smodule_10,5,1);
$smodule_1007 = substr($smodule_10,6,1);
$smodule_1008 = substr($smodule_10,7,1);
$smodule_1009 = substr($smodule_10,8,1);
$smodule_1010 = substr($smodule_10,9,1);



// Menu Sets
if($now_group_admin < "1" AND ($login_level == "5" OR $login_level == "7")) { // 07. Sales - Admin Sales

	$mmodule_01_act = "0";
	$mmodule_01B_act = "1";
	$mmodule_02_act = "1";
	$mmodule_03_act = "1";
	$mmodule_04_act = "0";
	$mmodule_05_act = "0";
	$mmodule_06_act = "0";
	$mmodule_07_act = "1";
	$mmodule_08_act = "0";
	$mmodule_09_act = "0";
	$mmodule_10_act = "0";
	
	// 01B. Purchase Request (PR)
	$smodule_01B01 = "1";
	$smodule_01B02 = "1";
	$smodule_01B03 = "1";
	$smodule_01B04 = "1";
	$smodule_01B05 = "1";
	$smodule_01B06 = "1";
	$smodule_01B07 = "1";
	$smodule_01B08 = "1";
	$smodule_01B09 = "1";
	$smodule_01B10 = "1";

	// 02. Inventory Control (SCO)
	$smodule_0201 = "0";
	$smodule_0202 = "0";
	$smodule_0203 = "0";
	$smodule_0204 = "0";
	$smodule_0205 = "0";
	$smodule_0206 = "0";
	$smodule_0207 = "0";
	$smodule_0208 = "0";
	$smodule_0209 = "1";
	$smodule_0210 = "1";

	// 03. Logistics
	$smodule_0301 = "1";
	$smodule_0302 = "1";
	$smodule_0303 = "1";
	$smodule_0304 = "1";
	$smodule_0305 = "1";
	$smodule_0306 = "1";
	$smodule_0307 = "1";
	$smodule_0308 = "1";
	$smodule_0309 = "1";
	$smodule_0310 = "1";
	
	// 05. Sales - FeelBuy Shop
	$smodule_0501 = substr($smodule_05,0,1);
	$smodule_0502 = substr($smodule_05,1,1);
	$smodule_0503 = substr($smodule_05,2,1);
	$smodule_0504 = substr($smodule_05,3,1);
	$smodule_0505 = substr($smodule_05,4,1);
	$smodule_0506 = substr($smodule_05,5,1);
	$smodule_0507 = substr($smodule_05,6,1);
	$smodule_0508 = substr($smodule_05,7,1);
	$smodule_0509 = substr($smodule_05,8,1);
	$smodule_0510 = substr($smodule_05,9,1);

	// 06. Sales - Associate Store
	$smodule_0601 = substr($smodule_06,0,1);
	$smodule_0602 = substr($smodule_06,1,1);
	$smodule_0603 = substr($smodule_06,2,1);
	$smodule_0604 = substr($smodule_06,3,1);
	$smodule_0605 = substr($smodule_06,4,1);
	$smodule_0606 = substr($smodule_06,5,1);
	$smodule_0607 = substr($smodule_06,6,1);
	$smodule_0608 = substr($smodule_06,7,1);
	$smodule_0609 = substr($smodule_06,8,1);
	$smodule_0610 = substr($smodule_06,9,1);

	// 07. Sales - Admin Sales
	$smodule_0701 = "1";
	$smodule_0702 = "1";
	$smodule_0703 = "1";
	$smodule_0704 = "1";
	$smodule_0705 = "1";
	$smodule_0706 = "1";
	$smodule_0707 = "1";
	$smodule_0708 = "1";
	$smodule_0709 = "1";
	$smodule_0710 = "1";

} else if($now_group_admin < "1" AND (($login_level > 0 AND $login_shop_flag == "2") OR $login_level > "6")) { // 05. Sales - FeelBuy Shop

	$mmodule_01_act = "0";
	$mmodule_01B_act = "1";
	$mmodule_02_act = "1";
	$mmodule_03_act = "1";
	$mmodule_04_act = "0";
	$mmodule_05_act = "1";
	$mmodule_06_act = "0";
	$mmodule_07_act = "0";
	$mmodule_08_act = "0";
	$mmodule_09_act = "0";
	$mmodule_10_act = "0";
	
	// 01B. Purchase Request (PR)
	$smodule_01B01 = "1";
	$smodule_01B02 = "1";
	$smodule_01B03 = "1";
	$smodule_01B04 = "1";
	$smodule_01B05 = "1";
	$smodule_01B06 = "1";
	$smodule_01B07 = "1";
	$smodule_01B08 = "1";
	$smodule_01B09 = "1";
	$smodule_01B10 = "1";

	// 02. Inventory Control (SCO)
	$smodule_0201 = "0";
	$smodule_0202 = "0";
	$smodule_0203 = "0";
	$smodule_0204 = "0";
	$smodule_0205 = "0";
	$smodule_0206 = "0";
	$smodule_0207 = "0";
	$smodule_0208 = "0";
	$smodule_0209 = "1";
	$smodule_0210 = "1";

	// 03. Logistics
	$smodule_0301 = "1";
	$smodule_0302 = "1";
	$smodule_0303 = "1";
	$smodule_0304 = "1";
	$smodule_0305 = "1";
	$smodule_0306 = "1";
	$smodule_0307 = "1";
	$smodule_0308 = "1";
	$smodule_0309 = "1";
	$smodule_0310 = "1";
	
	// 05. Sales - FeelBuy Shop
	$smodule_0501 = "1";
	$smodule_0502 = "1";
	$smodule_0503 = "1";
	$smodule_0504 = "1";
	$smodule_0505 = "1";
	$smodule_0506 = "1";
	$smodule_0507 = "1";
	$smodule_0508 = "1";
	$smodule_0509 = "1";
	$smodule_0510 = "1";

	// 06. Sales - Associate Store
	$smodule_0601 = substr($smodule_06,0,1);
	$smodule_0602 = substr($smodule_06,1,1);
	$smodule_0603 = substr($smodule_06,2,1);
	$smodule_0604 = substr($smodule_06,3,1);
	$smodule_0605 = substr($smodule_06,4,1);
	$smodule_0606 = substr($smodule_06,5,1);
	$smodule_0607 = substr($smodule_06,6,1);
	$smodule_0608 = substr($smodule_06,7,1);
	$smodule_0609 = substr($smodule_06,8,1);
	$smodule_0610 = substr($smodule_06,9,1);

	// 07. Sales - Admin Sales
	$smodule_0701 = substr($smodule_07,0,1);
	$smodule_0702 = substr($smodule_07,1,1);
	$smodule_0703 = substr($smodule_07,2,1);
	$smodule_0704 = substr($smodule_07,3,1);
	$smodule_0705 = substr($smodule_07,4,1);
	$smodule_0706 = substr($smodule_07,5,1);
	$smodule_0707 = substr($smodule_07,6,1);
	$smodule_0708 = substr($smodule_07,7,1);
	$smodule_0709 = substr($smodule_07,8,1);
	$smodule_0710 = substr($smodule_07,9,1);

} else if($now_group_admin < "1" AND (($login_level > 0 AND $login_shop_flag == "1") OR $login_level > "6")) { // 06. Sales - Associate Store

	$mmodule_01_act = "0";
	$mmodule_01B_act = "1";
	$mmodule_02_act = "1";
	$mmodule_03_act = "1";
	$mmodule_04_act = "0";
	$mmodule_05_act = "0";
	$mmodule_06_act = "1";
	$mmodule_07_act = "0";
	$mmodule_08_act = "0";
	$mmodule_09_act = "0";
	$mmodule_10_act = "0";
	
	// 01B. Purchase Request (PR)
	$smodule_01B01 = "1";
	$smodule_01B02 = "1";
	$smodule_01B03 = "1";
	$smodule_01B04 = "1";
	$smodule_01B05 = "1";
	$smodule_01B06 = "1";
	$smodule_01B07 = "1";
	$smodule_01B08 = "1";
	$smodule_01B09 = "1";
	$smodule_01B10 = "1";

	// 02. Inventory Control (SCO)
	$smodule_0201 = "0";
	$smodule_0202 = "0";
	$smodule_0203 = "0";
	$smodule_0204 = "0";
	$smodule_0205 = "0";
	$smodule_0206 = "0";
	$smodule_0207 = "0";
	$smodule_0208 = "0";
	$smodule_0209 = "1";
	$smodule_0210 = "1";

	// 03. Logistics
	$smodule_0301 = "1";
	$smodule_0302 = "1";
	$smodule_0303 = "1";
	$smodule_0304 = "1";
	$smodule_0305 = "1";
	$smodule_0306 = "1";
	$smodule_0307 = "1";
	$smodule_0308 = "1";
	$smodule_0309 = "1";
	$smodule_0310 = "1";
	
	// 05. Sales - FeelBuy Shop
	$smodule_0501 = substr($smodule_05,0,1);
	$smodule_0502 = substr($smodule_05,1,1);
	$smodule_0503 = substr($smodule_05,2,1);
	$smodule_0504 = substr($smodule_05,3,1);
	$smodule_0505 = substr($smodule_05,4,1);
	$smodule_0506 = substr($smodule_05,5,1);
	$smodule_0507 = substr($smodule_05,6,1);
	$smodule_0508 = substr($smodule_05,7,1);
	$smodule_0509 = substr($smodule_05,8,1);
	$smodule_0510 = substr($smodule_05,9,1);

	// 06. Sales - Associate Store
	$smodule_0601 = "1";
	$smodule_0602 = "1";
	$smodule_0603 = "1";
	$smodule_0604 = "1";
	$smodule_0605 = "1";
	$smodule_0606 = "1";
	$smodule_0607 = "1";
	$smodule_0608 = "1";
	$smodule_0609 = "1";
	$smodule_0610 = "1";

	// 07. Sales - Admin Sales
	$smodule_0701 = substr($smodule_07,0,1);
	$smodule_0702 = substr($smodule_07,1,1);
	$smodule_0703 = substr($smodule_07,2,1);
	$smodule_0704 = substr($smodule_07,3,1);
	$smodule_0705 = substr($smodule_07,4,1);
	$smodule_0706 = substr($smodule_07,5,1);
	$smodule_0707 = substr($smodule_07,6,1);
	$smodule_0708 = substr($smodule_07,7,1);
	$smodule_0709 = substr($smodule_07,8,1);
	$smodule_0710 = substr($smodule_07,9,1);

} else {

	if($mmodule_01 == "1" OR $smodule_01 > "0") { $mmodule_01_act = "1"; } else { $mmodule_01_act = "0"; }
	if($mmodule_01B == "1" OR $smodule_01B > "0") { $mmodule_01B_act = "1"; } else { $mmodule_01B_act = "0"; }
	if($mmodule_02 == "1" OR $smodule_02 > "0") { $mmodule_02_act = "1"; } else { $mmodule_02_act = "0"; }
	if($mmodule_03 == "1" OR $smodule_03 > "0") { $mmodule_03_act = "1"; } else { $mmodule_03_act = "0"; }
	if($mmodule_04 == "1" OR $smodule_04 > "0") { $mmodule_04_act = "1"; } else { $mmodule_04_act = "0"; }
	if($mmodule_05 == "1" OR $smodule_05 > "0") { $mmodule_05_act = "1"; } else { $mmodule_05_act = "0"; }
	if($mmodule_06 == "1" OR $smodule_06 > "0") { $mmodule_06_act = "1"; } else { $mmodule_06_act = "0"; }
	if($mmodule_07 == "1" OR $smodule_07 > "0") { $mmodule_07_act = "1"; } else { $mmodule_07_act = "0"; }
	if($mmodule_08 == "1" OR $smodule_08 > "0") { $mmodule_08_act = "1"; } else { $mmodule_08_act = "0"; }
	if($mmodule_09 == "1" OR $smodule_09 > "0") { $mmodule_09_act = "1"; } else { $mmodule_09_act = "0"; }
	if($mmodule_10 == "1" OR $smodule_10 > "0") { $mmodule_10_act = "1"; } else { $mmodule_10_act = "0"; }
	if($mmodule_11 == "1" OR $smodule_11 > "0") { $mmodule_11_act = "1"; } else { $mmodule_11_act = "0"; }

	// 01B. Purchase Request (PR)
	$smodule_01B01 = substr($smodule_01B,0,1);
	$smodule_01B02 = substr($smodule_01B,1,1);
	$smodule_01B03 = substr($smodule_01B,2,1);
	$smodule_01B04 = substr($smodule_01B,3,1);
	$smodule_01B05 = substr($smodule_01B,4,1);
	$smodule_01B06 = substr($smodule_01B,5,1);
	$smodule_01B07 = substr($smodule_01B,6,1);
	$smodule_01B08 = substr($smodule_01B,7,1);
	$smodule_01B09 = substr($smodule_01B,8,1);
	$smodule_01B10 = substr($smodule_01B,9,1);

	// 02. Inventory Control (SCO)
	$smodule_0201 = substr($smodule_02,0,1);
	$smodule_0202 = substr($smodule_02,1,1);
	$smodule_0203 = substr($smodule_02,2,1);
	$smodule_0204 = substr($smodule_02,3,1);
	$smodule_0205 = substr($smodule_02,4,1);
	$smodule_0206 = substr($smodule_02,5,1);
	$smodule_0207 = substr($smodule_02,6,1);
	$smodule_0208 = substr($smodule_02,7,1);
	$smodule_0209 = substr($smodule_02,8,1);
	$smodule_0210 = substr($smodule_02,9,1);

	// 03. Logistics
	$smodule_0301 = substr($smodule_03,0,1);
	$smodule_0302 = substr($smodule_03,1,1);
	$smodule_0303 = substr($smodule_03,2,1);
	$smodule_0304 = substr($smodule_03,3,1);
	$smodule_0305 = substr($smodule_03,4,1);
	$smodule_0306 = substr($smodule_03,5,1);
	$smodule_0307 = substr($smodule_03,6,1);
	$smodule_0308 = substr($smodule_03,7,1);
	$smodule_0309 = substr($smodule_03,8,1);
	$smodule_0310 = substr($smodule_03,9,1);
	
	// 05. Sales - FeelBuy Shop
	$smodule_0501 = substr($smodule_05,0,1);
	$smodule_0502 = substr($smodule_05,1,1);
	$smodule_0503 = substr($smodule_05,2,1);
	$smodule_0504 = substr($smodule_05,3,1);
	$smodule_0505 = substr($smodule_05,4,1);
	$smodule_0506 = substr($smodule_05,5,1);
	$smodule_0507 = substr($smodule_05,6,1);
	$smodule_0508 = substr($smodule_05,7,1);
	$smodule_0509 = substr($smodule_05,8,1);
	$smodule_0510 = substr($smodule_05,9,1);

	// 06. Sales - Associate Store
	$smodule_0601 = substr($smodule_06,0,1);
	$smodule_0602 = substr($smodule_06,1,1);
	$smodule_0603 = substr($smodule_06,2,1);
	$smodule_0604 = substr($smodule_06,3,1);
	$smodule_0605 = substr($smodule_06,4,1);
	$smodule_0606 = substr($smodule_06,5,1);
	$smodule_0607 = substr($smodule_06,6,1);
	$smodule_0608 = substr($smodule_06,7,1);
	$smodule_0609 = substr($smodule_06,8,1);
	$smodule_0610 = substr($smodule_06,9,1);

	// 07. Sales - Admin Sales
	$smodule_0701 = substr($smodule_07,0,1);
	$smodule_0702 = substr($smodule_07,1,1);
	$smodule_0703 = substr($smodule_07,2,1);
	$smodule_0704 = substr($smodule_07,3,1);
	$smodule_0705 = substr($smodule_07,4,1);
	$smodule_0706 = substr($smodule_07,5,1);
	$smodule_0707 = substr($smodule_07,6,1);
	$smodule_0708 = substr($smodule_07,7,1);
	$smodule_0709 = substr($smodule_07,8,1);
	$smodule_0710 = substr($smodule_07,9,1);

}
?>
