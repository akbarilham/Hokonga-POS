<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_user";

if(!$step_next) {
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

  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
<?
$uid = $_GET['uid'];
$query = "SELECT uid,gate,subgate,staff_sync,user_id,user_pw2,user_level,user_name,user_email,user_website,default_lang,signdate,
          log_ip,log_in,log_out,visit,group_admin,module_01,module_01B,module_02,module_03,module_04,module_05,
		  module_06,module_07,module_08,module_09,module_10,module_11,module_98,module_99 FROM admin_user WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
$user_subgate = $row->subgate;
$staff_sync = $row->staff_sync;
$user_id = $row->user_id;
$user_pw2 = $row->user_pw2;
$userlevel = $row->user_level;
$user_name = $row->user_name;
$email = $row->user_email;
$homepage = $row->user_website;
$user_lang = $row->default_lang;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$log_ip = $row->log_ip;
$log_in = $row->log_in;
  if($log_in == "1") {
    $log_ins = "$txt_sys_user_12";
  } else {
    if($lang == "ko") {
      $log_ins = date("Y/m/d, H:i:s",$log_in);	
    } else {
      $log_ins = date("d-m-Y, H:i:s",$log_in);	
    }
  }
$log_out = $row->log_out;
  if($log_out == "1") {
    $log_outs = "--";
  } else {
    if($lang == "ko") {
      $log_outs = date("Y/m/d, H:i:s",$log_out);	
    } else {
      $log_outs = date("d-m-Y, H:i:s",$log_out);	
    }
  }
$log_visit = $row->visit;
$group_admin = $row->group_admin;
$module_01 = $row->module_01;
$module_01B = $row->module_01B;
$module_02 = $row->module_02;
$module_03 = $row->module_03;
$module_04 = $row->module_04;
$module_05 = $row->module_05;
$module_06 = $row->module_06;
$module_07 = $row->module_07;
$module_08 = $row->module_08;
$module_09 = $row->module_09;
$module_10 = $row->module_10;
$module_11 = $row->module_11;
$module_98 = $row->module_98;
$module_99 = $row->module_99;


// 01. Purchasing
$module_0101 = substr($module_01,0,1);
$module_0102 = substr($module_01,1,1);
$module_0103 = substr($module_01,2,1);
$module_0104 = substr($module_01,3,1);
$module_0105 = substr($module_01,4,1);
$module_0106 = substr($module_01,5,1);
$module_0107 = substr($module_01,6,1);
$module_0108 = substr($module_01,7,1);
$module_0109 = substr($module_01,8,1);
$module_0110 = substr($module_01,9,1);

// 01B. Purchase Request
$module_01B01 = substr($module_01B,0,1);
$module_01B02 = substr($module_01B,1,1);
$module_01B03 = substr($module_01B,2,1);
$module_01B04 = substr($module_01B,3,1);
$module_01B05 = substr($module_01B,4,1);
$module_01B06 = substr($module_01B,5,1);
$module_01B07 = substr($module_01B,6,1);
$module_01B08 = substr($module_01B,7,1);
$module_01B09 = substr($module_01B,8,1);
$module_01B10 = substr($module_01B,9,1);

// 02. Inventory Control (SCO)
$module_0201 = substr($module_02,0,1);
$module_0202 = substr($module_02,1,1);
$module_0203 = substr($module_02,2,1);
$module_0204 = substr($module_02,3,1);
$module_0205 = substr($module_02,4,1);
$module_0206 = substr($module_02,5,1);
$module_0207 = substr($module_02,6,1);
$module_0208 = substr($module_02,7,1);
$module_0209 = substr($module_02,8,1);
$module_0210 = substr($module_02,9,1);

// 03. Logistics
$module_0301 = substr($module_03,0,1);
$module_0302 = substr($module_03,1,1);
$module_0303 = substr($module_03,2,1);
$module_0304 = substr($module_03,3,1);
$module_0305 = substr($module_03,4,1);
$module_0306 = substr($module_03,5,1);
$module_0307 = substr($module_03,6,1);
$module_0308 = substr($module_03,7,1);
$module_0309 = substr($module_03,8,1);
$module_0310 = substr($module_03,9,1);

// 04. Asset
$module_0401 = substr($module_04,0,1);
$module_0402 = substr($module_04,1,1);
$module_0403 = substr($module_04,2,1);
$module_0404 = substr($module_04,3,1);
$module_0405 = substr($module_04,4,1);
$module_0406 = substr($module_04,5,1);
$module_0407 = substr($module_04,6,1);
$module_0408 = substr($module_04,7,1);
$module_0409 = substr($module_04,8,1);
$module_0410 = substr($module_04,9,1);

// 05. Sales - FeelBuy Shop
$module_0501 = substr($module_05,0,1);
$module_0502 = substr($module_05,1,1);
$module_0503 = substr($module_05,2,1);
$module_0504 = substr($module_05,3,1);
$module_0505 = substr($module_05,4,1);
$module_0506 = substr($module_05,5,1);
$module_0507 = substr($module_05,6,1);
$module_0508 = substr($module_05,7,1);
$module_0509 = substr($module_05,8,1);
$module_0510 = substr($module_05,9,1);

// 06. Sales - Associate Store
$module_0601 = substr($module_06,0,1);
$module_0602 = substr($module_06,1,1);
$module_0603 = substr($module_06,2,1);
$module_0604 = substr($module_06,3,1);
$module_0605 = substr($module_06,4,1);
$module_0606 = substr($module_06,5,1);
$module_0607 = substr($module_06,6,1);
$module_0608 = substr($module_06,7,1);
$module_0609 = substr($module_06,8,1);
$module_0610 = substr($module_06,9,1);

// 07. Sales - Admin Sales
$module_0701 = substr($module_07,0,1);
$module_0702 = substr($module_07,1,1);
$module_0703 = substr($module_07,2,1);
$module_0704 = substr($module_07,3,1);
$module_0705 = substr($module_07,4,1);
$module_0706 = substr($module_07,5,1);
$module_0707 = substr($module_07,6,1);
$module_0708 = substr($module_07,7,1);
$module_0709 = substr($module_07,8,1);
$module_0710 = substr($module_07,9,1);

// 08. CRM/HR
$module_0801 = substr($module_08,0,1);
$module_0802 = substr($module_08,1,1);
$module_0803 = substr($module_08,2,1);
$module_0804 = substr($module_08,3,1);
$module_0805 = substr($module_08,4,1);
$module_0806 = substr($module_08,5,1);
$module_0807 = substr($module_08,6,1);
$module_0808 = substr($module_08,7,1);
$module_0809 = substr($module_08,8,1);
$module_0810 = substr($module_08,9,1);

// 09. Finance/Accounting
$module_0901 = substr($module_09,0,1);
$module_0902 = substr($module_09,1,1);
$module_0903 = substr($module_09,2,1);
$module_0904 = substr($module_09,3,1);
$module_0905 = substr($module_09,4,1);
$module_0906 = substr($module_09,5,1);
$module_0907 = substr($module_09,6,1);
$module_0908 = substr($module_09,7,1);
$module_0909 = substr($module_09,8,1);
$module_0910 = substr($module_09,9,1);

// 10. Accounting
$module_1001 = substr($module_10,0,1);
$module_1002 = substr($module_10,1,1);
$module_1003 = substr($module_10,2,1);
$module_1004 = substr($module_10,3,1);
$module_1005 = substr($module_10,4,1);
$module_1006 = substr($module_10,5,1);
$module_1007 = substr($module_10,6,1);
$module_1008 = substr($module_10,7,1);
$module_1009 = substr($module_10,8,1);
$module_1010 = substr($module_10,9,1);

// 11. CMS
$module_1101 = substr($module_11,0,1);
$module_1102 = substr($module_11,1,1);
$module_1103 = substr($module_11,2,1);
$module_1104 = substr($module_11,3,1);
$module_1105 = substr($module_11,4,1);
$module_1106 = substr($module_11,5,1);
$module_1107 = substr($module_11,6,1);
$module_1108 = substr($module_11,7,1);
$module_1109 = substr($module_11,8,1);
$module_1110 = substr($module_11,9,1);


// 98. Financial Institution
$module_9801 = substr($module_98,0,1);
$module_9802 = substr($module_98,1,1);
$module_9803 = substr($module_98,2,1);
$module_9804 = substr($module_98,3,1);
$module_9805 = substr($module_98,4,1);
$module_9806 = substr($module_98,5,1);
$module_9807 = substr($module_98,6,1);
$module_9808 = substr($module_98,7,1);
$module_9809 = substr($module_98,8,1);
$module_9810 = substr($module_98,9,1);

// 99. Insurance
$module_9901 = substr($module_99,0,1);
$module_9902 = substr($module_99,1,1);
$module_9903 = substr($module_99,2,1);
$module_9904 = substr($module_99,3,1);
$module_9905 = substr($module_99,4,1);
$module_9906 = substr($module_99,5,1);
$module_9907 = substr($module_99,6,1);
$module_9908 = substr($module_99,7,1);
$module_9909 = substr($module_99,8,1);
$module_9910 = substr($module_99,9,1);




if($module_0101 == "1") { $module_0101_chk = "checked"; } else { $module_0101_chk = ""; }
if($module_0102 == "1") { $module_0102_chk = "checked"; } else { $module_0102_chk = ""; }
if($module_0103 == "1") { $module_0103_chk = "checked"; } else { $module_0103_chk = ""; }
if($module_0104 == "1") { $module_0104_chk = "checked"; } else { $module_0104_chk = ""; }
if($module_0105 == "1") { $module_0105_chk = "checked"; } else { $module_0105_chk = ""; }
if($module_0106 == "1") { $module_0106_chk = "checked"; } else { $module_0106_chk = ""; }
if($module_0107 == "1") { $module_0107_chk = "checked"; } else { $module_0107_chk = ""; }
if($module_0108 == "1") { $module_0108_chk = "checked"; } else { $module_0108_chk = ""; }
if($module_0109 == "1") { $module_0109_chk = "checked"; } else { $module_0109_chk = ""; }
if($module_0110 == "1") { $module_0110_chk = "checked"; } else { $module_0110_chk = ""; }

if($module_01B01 == "1") { $module_01B01_chk = "checked"; } else { $module_01B01_chk = ""; }
if($module_01B02 == "1") { $module_01B02_chk = "checked"; } else { $module_01B02_chk = ""; }
if($module_01B03 == "1") { $module_01B03_chk = "checked"; } else { $module_01B03_chk = ""; }
if($module_01B04 == "1") { $module_01B04_chk = "checked"; } else { $module_01B04_chk = ""; }
if($module_01B05 == "1") { $module_01B05_chk = "checked"; } else { $module_01B05_chk = ""; }
if($module_01B06 == "1") { $module_01B06_chk = "checked"; } else { $module_01B06_chk = ""; }
if($module_01B07 == "1") { $module_01B07_chk = "checked"; } else { $module_01B07_chk = ""; }
if($module_01B08 == "1") { $module_01B08_chk = "checked"; } else { $module_01B08_chk = ""; }
if($module_01B09 == "1") { $module_01B09_chk = "checked"; } else { $module_01B09_chk = ""; }
if($module_01B10 == "1") { $module_01B10_chk = "checked"; } else { $module_01B10_chk = ""; }

if($module_0201 == "1") { $module_0201_chk = "checked"; } else { $module_0201_chk = ""; }
if($module_0202 == "1") { $module_0202_chk = "checked"; } else { $module_0202_chk = ""; }
if($module_0203 == "1") { $module_0203_chk = "checked"; } else { $module_0203_chk = ""; }
if($module_0204 == "1") { $module_0204_chk = "checked"; } else { $module_0204_chk = ""; }
if($module_0205 == "1") { $module_0205_chk = "checked"; } else { $module_0205_chk = ""; }
if($module_0206 == "1") { $module_0206_chk = "checked"; } else { $module_0206_chk = ""; }
if($module_0207 == "1") { $module_0207_chk = "checked"; } else { $module_0207_chk = ""; }
if($module_0208 == "1") { $module_0208_chk = "checked"; } else { $module_0208_chk = ""; }
if($module_0209 == "1") { $module_0209_chk = "checked"; } else { $module_0209_chk = ""; }
if($module_0210 == "1") { $module_0210_chk = "checked"; } else { $module_0210_chk = ""; }

if($module_0301 == "1") { $module_0301_chk = "checked"; } else { $module_0301_chk = ""; }
if($module_0302 == "1") { $module_0302_chk = "checked"; } else { $module_0302_chk = ""; }
if($module_0303 == "1") { $module_0303_chk = "checked"; } else { $module_0303_chk = ""; }
if($module_0304 == "1") { $module_0304_chk = "checked"; } else { $module_0304_chk = ""; }
if($module_0305 == "1") { $module_0305_chk = "checked"; } else { $module_0305_chk = ""; }
if($module_0306 == "1") { $module_0306_chk = "checked"; } else { $module_0306_chk = ""; }
if($module_0307 == "1") { $module_0307_chk = "checked"; } else { $module_0307_chk = ""; }
if($module_0308 == "1") { $module_0308_chk = "checked"; } else { $module_0308_chk = ""; }
if($module_0309 == "1") { $module_0309_chk = "checked"; } else { $module_0309_chk = ""; }
if($module_0310 == "1") { $module_0310_chk = "checked"; } else { $module_0310_chk = ""; }

if($module_0401 == "1") { $module_0401_chk = "checked"; } else { $module_0401_chk = ""; }
if($module_0402 == "1") { $module_0402_chk = "checked"; } else { $module_0402_chk = ""; }
if($module_0403 == "1") { $module_0403_chk = "checked"; } else { $module_0403_chk = ""; }
if($module_0404 == "1") { $module_0404_chk = "checked"; } else { $module_0404_chk = ""; }
if($module_0405 == "1") { $module_0405_chk = "checked"; } else { $module_0405_chk = ""; }
if($module_0406 == "1") { $module_0406_chk = "checked"; } else { $module_0406_chk = ""; }
if($module_0407 == "1") { $module_0407_chk = "checked"; } else { $module_0407_chk = ""; }
if($module_0408 == "1") { $module_0408_chk = "checked"; } else { $module_0408_chk = ""; }
if($module_0409 == "1") { $module_0409_chk = "checked"; } else { $module_0409_chk = ""; }
if($module_0410 == "1") { $module_0410_chk = "checked"; } else { $module_0410_chk = ""; }

if($module_0501 == "1") { $module_0501_chk = "checked"; } else { $module_0501_chk = ""; }
if($module_0502 == "1") { $module_0502_chk = "checked"; } else { $module_0502_chk = ""; }
if($module_0503 == "1") { $module_0503_chk = "checked"; } else { $module_0503_chk = ""; }
if($module_0504 == "1") { $module_0504_chk = "checked"; } else { $module_0504_chk = ""; }
if($module_0505 == "1") { $module_0505_chk = "checked"; } else { $module_0505_chk = ""; }
if($module_0506 == "1") { $module_0506_chk = "checked"; } else { $module_0506_chk = ""; }
if($module_0507 == "1") { $module_0507_chk = "checked"; } else { $module_0507_chk = ""; }
if($module_0508 == "1") { $module_0508_chk = "checked"; } else { $module_0508_chk = ""; }
if($module_0509 == "1") { $module_0509_chk = "checked"; } else { $module_0509_chk = ""; }
if($module_0510 == "1") { $module_0510_chk = "checked"; } else { $module_0510_chk = ""; }

if($module_0601 == "1") { $module_0601_chk = "checked"; } else { $module_0601_chk = ""; }
if($module_0602 == "1") { $module_0602_chk = "checked"; } else { $module_0602_chk = ""; }
if($module_0603 == "1") { $module_0603_chk = "checked"; } else { $module_0603_chk = ""; }
if($module_0604 == "1") { $module_0604_chk = "checked"; } else { $module_0604_chk = ""; }
if($module_0605 == "1") { $module_0605_chk = "checked"; } else { $module_0605_chk = ""; }
if($module_0606 == "1") { $module_0606_chk = "checked"; } else { $module_0606_chk = ""; }
if($module_0607 == "1") { $module_0607_chk = "checked"; } else { $module_0607_chk = ""; }
if($module_0608 == "1") { $module_0608_chk = "checked"; } else { $module_0608_chk = ""; }
if($module_0609 == "1") { $module_0609_chk = "checked"; } else { $module_0609_chk = ""; }
if($module_0610 == "1") { $module_0610_chk = "checked"; } else { $module_0610_chk = ""; }

if($module_0701 == "1") { $module_0701_chk = "checked"; } else { $module_0701_chk = ""; }
if($module_0702 == "1") { $module_0702_chk = "checked"; } else { $module_0702_chk = ""; }
if($module_0703 == "1") { $module_0703_chk = "checked"; } else { $module_0703_chk = ""; }
if($module_0704 == "1") { $module_0704_chk = "checked"; } else { $module_0704_chk = ""; }
if($module_0705 == "1") { $module_0705_chk = "checked"; } else { $module_0705_chk = ""; }
if($module_0706 == "1") { $module_0706_chk = "checked"; } else { $module_0706_chk = ""; }
if($module_0707 == "1") { $module_0707_chk = "checked"; } else { $module_0707_chk = ""; }
if($module_0708 == "1") { $module_0708_chk = "checked"; } else { $module_0708_chk = ""; }
if($module_0709 == "1") { $module_0709_chk = "checked"; } else { $module_0709_chk = ""; }
if($module_0710 == "1") { $module_0710_chk = "checked"; } else { $module_0710_chk = ""; }

if($module_0801 == "1") { $module_0801_chk = "checked"; } else { $module_0801_chk = ""; }
if($module_0802 == "1") { $module_0802_chk = "checked"; } else { $module_0802_chk = ""; }
if($module_0803 == "1") { $module_0803_chk = "checked"; } else { $module_0803_chk = ""; }
if($module_0804 == "1") { $module_0804_chk = "checked"; } else { $module_0804_chk = ""; }
if($module_0805 == "1") { $module_0805_chk = "checked"; } else { $module_0805_chk = ""; }
if($module_0806 == "1") { $module_0806_chk = "checked"; } else { $module_0806_chk = ""; }
if($module_0807 == "1") { $module_0807_chk = "checked"; } else { $module_0807_chk = ""; }
if($module_0808 == "1") { $module_0808_chk = "checked"; } else { $module_0808_chk = ""; }
if($module_0809 == "1") { $module_0809_chk = "checked"; } else { $module_0809_chk = ""; }
if($module_0810 == "1") { $module_0810_chk = "checked"; } else { $module_0810_chk = ""; }

if($module_0901 == "1") { $module_0901_chk = "checked"; } else { $module_0901_chk = ""; }
if($module_0902 == "1") { $module_0902_chk = "checked"; } else { $module_0902_chk = ""; }
if($module_0903 == "1") { $module_0903_chk = "checked"; } else { $module_0903_chk = ""; }
if($module_0904 == "1") { $module_0904_chk = "checked"; } else { $module_0904_chk = ""; }
if($module_0905 == "1") { $module_0905_chk = "checked"; } else { $module_0905_chk = ""; }
if($module_0906 == "1") { $module_0906_chk = "checked"; } else { $module_0906_chk = ""; }
if($module_0907 == "1") { $module_0907_chk = "checked"; } else { $module_0907_chk = ""; }
if($module_0908 == "1") { $module_0908_chk = "checked"; } else { $module_0908_chk = ""; }
if($module_0909 == "1") { $module_0909_chk = "checked"; } else { $module_0909_chk = ""; }
if($module_0910 == "1") { $module_0910_chk = "checked"; } else { $module_0910_chk = ""; }

if($module_1001 == "1") { $module_1001_chk = "checked"; } else { $module_1001_chk = ""; }
if($module_1002 == "1") { $module_1002_chk = "checked"; } else { $module_1002_chk = ""; }
if($module_1003 == "1") { $module_1003_chk = "checked"; } else { $module_1003_chk = ""; }
if($module_1004 == "1") { $module_1004_chk = "checked"; } else { $module_1004_chk = ""; }
if($module_1005 == "1") { $module_1005_chk = "checked"; } else { $module_1005_chk = ""; }
if($module_1006 == "1") { $module_1006_chk = "checked"; } else { $module_1006_chk = ""; }
if($module_1007 == "1") { $module_1007_chk = "checked"; } else { $module_1007_chk = ""; }
if($module_1008 == "1") { $module_1008_chk = "checked"; } else { $module_1008_chk = ""; }
if($module_1009 == "1") { $module_1009_chk = "checked"; } else { $module_1009_chk = ""; }
if($module_1010 == "1") { $module_1010_chk = "checked"; } else { $module_1010_chk = ""; }

if($module_1101 == "1") { $module_1101_chk = "checked"; } else { $module_1101_chk = ""; }
if($module_1102 == "1") { $module_1102_chk = "checked"; } else { $module_1102_chk = ""; }
if($module_1103 == "1") { $module_1103_chk = "checked"; } else { $module_1103_chk = ""; }
if($module_1104 == "1") { $module_1104_chk = "checked"; } else { $module_1104_chk = ""; }
if($module_1105 == "1") { $module_1105_chk = "checked"; } else { $module_1105_chk = ""; }
if($module_1106 == "1") { $module_1106_chk = "checked"; } else { $module_1106_chk = ""; }
if($module_1107 == "1") { $module_1107_chk = "checked"; } else { $module_1107_chk = ""; }
if($module_1108 == "1") { $module_1108_chk = "checked"; } else { $module_1108_chk = ""; }
if($module_1109 == "1") { $module_1109_chk = "checked"; } else { $module_1109_chk = ""; }
if($module_1110 == "1") { $module_1110_chk = "checked"; } else { $module_1110_chk = ""; }

if($module_9801 == "1") { $module_9801_chk = "checked"; } else { $module_9801_chk = ""; }
if($module_9802 == "1") { $module_9802_chk = "checked"; } else { $module_9802_chk = ""; }
if($module_9803 == "1") { $module_9803_chk = "checked"; } else { $module_9803_chk = ""; }
if($module_9804 == "1") { $module_9804_chk = "checked"; } else { $module_9804_chk = ""; }
if($module_9805 == "1") { $module_9805_chk = "checked"; } else { $module_9805_chk = ""; }
if($module_9806 == "1") { $module_9806_chk = "checked"; } else { $module_9806_chk = ""; }
if($module_9807 == "1") { $module_9807_chk = "checked"; } else { $module_9807_chk = ""; }
if($module_9808 == "1") { $module_9808_chk = "checked"; } else { $module_9808_chk = ""; }
if($module_9809 == "1") { $module_9809_chk = "checked"; } else { $module_9809_chk = ""; }
if($module_9810 == "1") { $module_9810_chk = "checked"; } else { $module_9810_chk = ""; }

if($module_9901 == "1") { $module_9901_chk = "checked"; } else { $module_9901_chk = ""; }
if($module_9902 == "1") { $module_9902_chk = "checked"; } else { $module_9902_chk = ""; }
if($module_9903 == "1") { $module_9903_chk = "checked"; } else { $module_9903_chk = ""; }
if($module_9904 == "1") { $module_9904_chk = "checked"; } else { $module_9904_chk = ""; }
if($module_9905 == "1") { $module_9905_chk = "checked"; } else { $module_9905_chk = ""; }
if($module_9906 == "1") { $module_9906_chk = "checked"; } else { $module_9906_chk = ""; }
if($module_9907 == "1") { $module_9907_chk = "checked"; } else { $module_9907_chk = ""; }
if($module_9908 == "1") { $module_9908_chk = "checked"; } else { $module_9908_chk = ""; }
if($module_9909 == "1") { $module_9909_chk = "checked"; } else { $module_9909_chk = ""; }
if($module_9910 == "1") { $module_9910_chk = "checked"; } else { $module_9910_chk = ""; }




// Member DB Sync
/*
if($staff_sync == "1") {
	$upd_disable = "disabled";
} else {
	$upd_disable = "";
}
*/
if($login_level > "8") {
	$upd_disable = "";
} else {
	$upd_disable = "disabled";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_user_03?>
            <span class="tools pull-right">
				<a href="system_user_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_user_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$user_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='login_level' value='<?=$login_level?>'>
								<input type='hidden' name='staff_sync' value='<?=$staff_sync?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_07?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,userlevel FROM client WHERE userlevel > '0' 
														ORDER BY client_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='user_gate' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												$menu_level = mysql_result($resultD,$i,2);
        
												if($menu_level > "2") {
													$depth_span = "";
													$depth_disable = "disabled";
												} else {
													$depth_span = "&nbsp;&nbsp;&gt;&nbsp;&nbsp;";
													$depth_disable = "";
												}
        
												if($menu_code == $user_gate) {
													$br_slc_hr = "selected";
												} else {
													$br_slc_hr = "";
												}

												echo("<option value='$menu_code' $br_slc_hr>{$depth_span}[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="id" value="<?=$user_id?>" maxlength="12" type="id" />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1">Password</div>
										<div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="passwd" value="<?=$user_pw2?>" maxlength="12" type="password" />
                                        </div>
										<div class="col-sm-3">(Unix Encoding)</div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_06?></label>
                                        <div class="col-sm-9">
                                            <input <?=$upd_disable?> class="form-control" id="cname" name="user_name" value="<?=$user_name?>" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input <?=$upd_disable?> class="form-control " id="cemail" type="email" name="email" value="<?=$email?>" maxlength="120" required />
                                        </div>
                                    </div>

									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input <?=$upd_disable?> class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_20?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="pw1" maxlength="12" type="password" />
                                        </div>
										<div class="col-sm-1"></div>
										<div class="col-sm-1"><?=$txt_sys_client_21?></div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="pw2" maxlength="12" type="password" />
                                        </div>
										<div class="col-sm-3"><input type=checkbox name='pw_upd' value='1'>&nbsp;<font color=red><?=$txt_sys_client_22?></font></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_11?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($user_lang,"en")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"en\" CHECKED> $txt_comm_lang_en &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"en\"> $txt_comm_lang_en &nbsp;");
											}

											if(!strcmp($user_lang,"in")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"in\" CHECKED> $txt_comm_lang_in &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"in\"> $txt_comm_lang_in &nbsp;");
											}

											if(!strcmp($user_lang,"ko")) {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"ko\" CHECKED> $txt_comm_lang_ko &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"user_lang\" value=\"ko\"> $txt_comm_lang_ko &nbsp;");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Group Admin</label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($group_admin,"1")) {
												echo("<input type=\"radio\" name=\"group_admin\" value=\"1\" CHECKED> <font color=green>Inter-corporate Account</font> &nbsp;&nbsp;&nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"group_admin\" value=\"1\"> <font color=green>Inter-corporate Account</font> &nbsp;&nbsp;&nbsp;&nbsp; ");
											}
											
											if(!strcmp($group_admin,"0")) {
												echo("<input type=\"radio\" name=\"group_admin\" value=\"0\" CHECKED> Corporate Account");
											} else {
												echo("<input type=\"radio\" name=\"group_admin\" value=\"0\"> Corporate Account");
											}
											?>
										</div>
                                    </div>
										
										
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_08?></label>
                                        <div class="col-sm-9">
                                            <?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Hold</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Hold</font> &nbsp;");
											}

											if(!strcmp($userlevel,"2")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\" CHECKED> <font color=blue>Sales Manager (SMS)</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\"> <font color=blue>Sales Manager (SMS)</font> &nbsp;");
											}
   
											if(!strcmp($userlevel,"3")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\" CHECKED> <font color=blue>Branch Manager</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\"> <font color=blue>Branch Manager</font> &nbsp;");
											}

											if(!strcmp($userlevel,"4")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"4\" CHECKED> Regional Manager &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"4\"> Regional Manager &nbsp;");
											}

											if(!strcmp($userlevel,"5")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\" CHECKED> Division Manager &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\"> Division Manager &nbsp;");
											} 
   
											if($login_level > "5") {
											if(!strcmp($userlevel,"6")) {
												echo("<br><input type=\"radio\" name=\"userlevel\" value=\"6\" CHECKED> Inventory Manager &nbsp;");
											} else {
												echo("<br><input type=\"radio\" name=\"userlevel\" value=\"6\"> Inventory Manager &nbsp;");
											}
											}

											if($login_level > "6") {
											if(!strcmp($userlevel,"7")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\" CHECKED> Director &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\"> Director &nbsp;");
											}
											if(!strcmp($userlevel,"8")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"8\" CHECKED> Admin &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"8\"> Admin &nbsp;");
											}
											}
   
											if($login_level > "8") {
											if(!strcmp($userlevel,"9")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"9\" CHECKED>*");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"9\">*");
											}
											}
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Permission</label>
                                        <div class="col-sm-3">
											<u>01. <?=$title_module_01?></u>
											<br><input type="checkbox" name="module_0101" value="1" <?=$module_0101_chk?>> <?echo("$title_module_0101")?>
											<br><input type="checkbox" name="module_0102" value="1" <?=$module_0102_chk?>> <?echo("$title_module_0102")?>
											<br><input type="checkbox" name="module_0103" value="1" <?=$module_0103_chk?>> <?echo("$title_module_0103")?>
											<br><input type="checkbox" name="module_0104" value="1" <?=$module_0104_chk?>> <?echo("$title_module_0104")?>
											<br><input type="checkbox" name="module_0105" value="1" <?=$module_0105_chk?>> <?echo("$title_module_0105")?>
											<br><input type="checkbox" name="module_0106" value="1" <?=$module_0106_chk?>> <?echo("$title_module_0106")?>
											
											<br><br><u>01B. <?echo("$title_module_01B")?></u>
											<br><input type="checkbox" name="module_01B01" value="1" <?=$module_01B01_chk?>> <?echo("$title_module_01B01")?>
											<br><input type="checkbox" name="module_01B02" value="1" <?=$module_01B02_chk?>> <?echo("$title_module_01B02")?>
											<br><input type="checkbox" name="module_01B03" value="1" <?=$module_01B03_chk?>> <?echo("$title_module_01B03")?>
											
											<br><br><u>02. <?echo("$title_module_02")?></u>
											<br><input type="checkbox" name="module_0201" value="1" <?=$module_0201_chk?>> <?echo("$title_module_0201")?>
											<br><input type="checkbox" name="module_0202" value="1" <?=$module_0202_chk?>> <?echo("$title_module_0202")?>
											<br><input type="checkbox" name="module_0203" value="1" <?=$module_0203_chk?>> <?echo("$title_module_0203")?>
											<br><input type="checkbox" name="module_0204" value="1" <?=$module_0204_chk?>> <?echo("$title_module_0204")?>
											<br><input type="checkbox" name="module_0205" value="1" <?=$module_0205_chk?>> <?echo("$title_module_0205")?>
											<br><input type="checkbox" name="module_0206" value="1" <?=$module_0206_chk?>> <?echo("$title_module_0206")?>
											<br><input type="checkbox" name="module_0207" value="1" <?=$module_0207_chk?>> <?echo("$title_module_0207")?>
											<br><input type="checkbox" name="module_0208" value="1" <?=$module_0208_chk?>> <?echo("$title_module_0208")?>
											<br><input type="checkbox" name="module_0209" value="1" <?=$module_0209_chk?>> <?echo("$title_module_0209")?>
											<br><input type="checkbox" name="module_0210" value="1" <?=$module_0210_chk?>> <?echo("$title_module_0210")?>
										</div>
										<div class="col-sm-3">
											<u>03. <?echo("$title_module_03")?></u>
											<br><input type="checkbox" name="module_0301" value="1" <?=$module_0301_chk?>> <?echo("$title_module_0301")?>
											<br><input type="checkbox" name="module_0302" value="1" <?=$module_0302_chk?>> <?echo("$title_module_0302")?>
											
											<br><br><u>04. <?echo("$title_module_04")?></u>
											<br><input type="checkbox" name="module_0401" value="1" <?=$module_0401_chk?>> <?echo("$title_module_0401")?>
											<br><input type="checkbox" name="module_0402" value="1" <?=$module_0402_chk?>> <?echo("$title_module_0402")?>
											<br><input type="checkbox" name="module_0403" value="1" <?=$module_0403_chk?>> <?echo("$title_module_0403")?>
											
											<br><br>
											<br><br><u>05. <?echo("$title_module_05")?></u>
											<br><input type="checkbox" name="module_0501" value="1" <?=$module_0501_chk?>> <?echo("$title_module_0501")?>
											<br><input type="checkbox" name="module_0502" value="1" <?=$module_0502_chk?>> <?echo("$title_module_0502")?>
											<br><input type="checkbox" name="module_0508" value="1" <?=$module_0508_chk?>> <?echo("$title_module_0508")?>
                      <br><input type="checkbox" name="module_0509" value="1" <?=$module_0509_chk?>> <?echo("$title_module_0509")?>
											
											<br><br><u>06. <?echo("$title_module_06")?></u>
											<br><input type="checkbox" name="module_0601" value="1" <?=$module_0601_chk?>> <?echo("$title_module_0601")?>
											<br><input type="checkbox" name="module_0602" value="1" <?=$module_0602_chk?>> <?echo("$title_module_0602")?>
											
											<br><br><u>07. <?echo("$title_module_07")?></u>
											<br><input type="checkbox" name="module_0701" value="1" <?=$module_0701_chk?>> <?echo("$title_module_0701")?>
											<br><input type="checkbox" name="module_0702" value="1" <?=$module_0702_chk?>> <?echo("$title_module_0702")?>
										</div>
										<div class="col-sm-3">
											<u>08. <?echo("$title_module_08")?></u>
											<br><input type="checkbox" name="module_0801" value="1" <?=$module_0801_chk?>> <?echo("$title_module_0801")?>
											<br><input type="checkbox" name="module_0802" value="1" <?=$module_0802_chk?>> <?echo("$title_module_0802")?>
											<br><input type="checkbox" name="module_0803" value="1" <?=$module_0803_chk?>> <?echo("$title_module_0803")?>
											<br><input type="checkbox" name="module_0804" value="1" <?=$module_0804_chk?>> <?echo("$title_module_0804")?>
											<br><input type="checkbox" name="module_0805" value="1" <?=$module_0805_chk?>> <?echo("$title_module_0805")?>
											
											<br><br><u>09. <?echo("$title_module_09")?></u>
											<br><input type="checkbox" name="module_0901" value="1" <?=$module_0901_chk?>> <?echo("$title_module_0901")?>
											<br><input type="checkbox" name="module_0902" value="1" <?=$module_0902_chk?>> <?echo("$title_module_0902")?>
											<br><input type="checkbox" name="module_0903" value="1" <?=$module_0903_chk?>> <?echo("$title_module_0903")?>
											<br><input type="checkbox" name="module_0904" value="1" <?=$module_0904_chk?>> <?echo("$title_module_0904")?>
											<br><input type="checkbox" name="module_0905" value="1" <?=$module_0905_chk?>> <?echo("$title_module_0905")?>
											<br><input type="checkbox" name="module_0906" value="1" <?=$module_0906_chk?>> <?echo("$title_module_0906")?>
											
											<br><br><u>10. <?echo("$title_module_10")?></u>
											<br><input type="checkbox" name="module_1001" value="1" <?=$module_1001_chk?>> <?echo("$title_module_1001")?>
											<br><input type="checkbox" name="module_1002" value="1" <?=$module_1002_chk?>> <?echo("$title_module_1002")?>
											<br><input type="checkbox" name="module_1003" value="1" <?=$module_1003_chk?>> <?echo("$title_module_1003")?>
											<br><input type="checkbox" name="module_1004" value="1" <?=$module_1004_chk?>> <?echo("$title_module_1004")?>
											
											<br><br><u>11. <?echo("$title_module_11")?></u>
											
											<? if($login_level > "8") { ?>
											<br><br><u>98. <?echo("$title_module_98")?></u>
											<br><u>99. <?echo("$title_module_99")?></u>
											<? } ?>
											
										</div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_10?></label>
                                        <div class="col-sm-2">
											<input readonly class="form-control" id="log_visit" name="log_visit" value="<?=$log_visit?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_user_09?></label>
                                        <div class="col-sm-4">
											<input readonly class="form-control" id="log_ins" name="log_ins" value="<?=$log_ins?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
											<input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
										</div>
                                    </div>
									
									
																				
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
							
        </div>
        </section>
		</div>
		</div>
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

	

  if(!$pw_upd) {
	  $pw_upd == "0";
  }

  if($pw_upd == "1") {
	  if($pw1 != $pw2){
	    popup_msg("$txt_sys_user_chk03");
	    break;
	  } else {
	    $pw = "$pw1";
	  }
  }

  // 비밀번호는 최소 4자, 최대 12자의 영문자나 숫자가 조합된 문자열
  if($pw_upd == "1") {
	  if(!ereg("[[:alnum:]+]{4,12}",$pw1)) {
	    error("INVALID_PASSWD");
	    exit;
	  }
  }

  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  
  
  if(!$module_0101) { $module_0101 = "0"; }
  if(!$module_0102) { $module_0102 = "0"; }
  if(!$module_0103) { $module_0103 = "0"; }
  if(!$module_0104) { $module_0104 = "0"; }
  if(!$module_0105) { $module_0105 = "0"; }
  if(!$module_0106) { $module_0106 = "0"; }
  if(!$module_0107) { $module_0107 = "0"; }
  if(!$module_0108) { $module_0108 = "0"; }
  if(!$module_0109) { $module_0109 = "0"; }
  if(!$module_0110) { $module_0110 = "0"; }
  
  if(!$module_01B01) { $module_01B01 = "0"; }
  if(!$module_01B02) { $module_01B02 = "0"; }
  if(!$module_01B03) { $module_01B03 = "0"; }
  if(!$module_01B04) { $module_01B04 = "0"; }
  if(!$module_01B05) { $module_01B05 = "0"; }
  if(!$module_01B06) { $module_01B06 = "0"; }
  if(!$module_01B07) { $module_01B07 = "0"; }
  if(!$module_01B08) { $module_01B08 = "0"; }
  if(!$module_01B09) { $module_01B09 = "0"; }
  if(!$module_01B10) { $module_01B10 = "0"; }
  
  if(!$module_0201) { $module_0201 = "0"; }
  if(!$module_0202) { $module_0202 = "0"; }
  if(!$module_0203) { $module_0203 = "0"; }
  if(!$module_0204) { $module_0204 = "0"; }
  if(!$module_0205) { $module_0205 = "0"; }
  if(!$module_0206) { $module_0206 = "0"; }
  if(!$module_0207) { $module_0207 = "0"; }
  if(!$module_0208) { $module_0208 = "0"; }
  if(!$module_0209) { $module_0209 = "0"; }
  if(!$module_0210) { $module_0210 = "0"; }
  
  if(!$module_0301) { $module_0301 = "0"; }
  if(!$module_0302) { $module_0302 = "0"; }
  if(!$module_0303) { $module_0303 = "0"; }
  if(!$module_0304) { $module_0304 = "0"; }
  if(!$module_0305) { $module_0305 = "0"; }
  if(!$module_0306) { $module_0306 = "0"; }
  if(!$module_0307) { $module_0307 = "0"; }
  if(!$module_0308) { $module_0308 = "0"; }
  if(!$module_0309) { $module_0309 = "0"; }
  if(!$module_0310) { $module_0310 = "0"; }
  
  if(!$module_0401) { $module_0401 = "0"; }
  if(!$module_0402) { $module_0402 = "0"; }
  if(!$module_0403) { $module_0403 = "0"; }
  if(!$module_0404) { $module_0404 = "0"; }
  if(!$module_0405) { $module_0405 = "0"; }
  if(!$module_0406) { $module_0406 = "0"; }
  if(!$module_0407) { $module_0407 = "0"; }
  if(!$module_0408) { $module_0408 = "0"; }
  if(!$module_0409) { $module_0409 = "0"; }
  if(!$module_0410) { $module_0410 = "0"; }
  
  if(!$module_0501) { $module_0501 = "0"; }
  if(!$module_0502) { $module_0502 = "0"; }
  if(!$module_0503) { $module_0503 = "0"; }
  if(!$module_0504) { $module_0504 = "0"; }
  if(!$module_0505) { $module_0505 = "0"; }
  if(!$module_0506) { $module_0506 = "0"; }
  if(!$module_0507) { $module_0507 = "0"; }
  if(!$module_0508) { $module_0508 = "0"; }
  if(!$module_0509) { $module_0509 = "0"; }
  if(!$module_0510) { $module_0510 = "0"; }
  
  if(!$module_0601) { $module_0601 = "0"; }
  if(!$module_0602) { $module_0602 = "0"; }
  if(!$module_0603) { $module_0603 = "0"; }
  if(!$module_0604) { $module_0604 = "0"; }
  if(!$module_0605) { $module_0605 = "0"; }
  if(!$module_0606) { $module_0606 = "0"; }
  if(!$module_0607) { $module_0607 = "0"; }
  if(!$module_0608) { $module_0608 = "0"; }
  if(!$module_0609) { $module_0609 = "0"; }
  if(!$module_0610) { $module_0610 = "0"; }
  
  if(!$module_0701) { $module_0701 = "0"; }
  if(!$module_0702) { $module_0702 = "0"; }
  if(!$module_0703) { $module_0703 = "0"; }
  if(!$module_0704) { $module_0704 = "0"; }
  if(!$module_0705) { $module_0705 = "0"; }
  if(!$module_0706) { $module_0706 = "0"; }
  if(!$module_0707) { $module_0707 = "0"; }
  if(!$module_0708) { $module_0708 = "0"; }
  if(!$module_0709) { $module_0709 = "0"; }
  if(!$module_0710) { $module_0710 = "0"; }
  
  if(!$module_0801) { $module_0801 = "0"; }
  if(!$module_0802) { $module_0802 = "0"; }
  if(!$module_0803) { $module_0803 = "0"; }
  if(!$module_0804) { $module_0804 = "0"; }
  if(!$module_0805) { $module_0805 = "0"; }
  if(!$module_0806) { $module_0806 = "0"; }
  if(!$module_0807) { $module_0807 = "0"; }
  if(!$module_0808) { $module_0808 = "0"; }
  if(!$module_0809) { $module_0809 = "0"; }
  if(!$module_0810) { $module_0810 = "0"; }
  
  if(!$module_0901) { $module_0901 = "0"; }
  if(!$module_0902) { $module_0902 = "0"; }
  if(!$module_0903) { $module_0903 = "0"; }
  if(!$module_0904) { $module_0904 = "0"; }
  if(!$module_0905) { $module_0905 = "0"; }
  if(!$module_0906) { $module_0906 = "0"; }
  if(!$module_0907) { $module_0907 = "0"; }
  if(!$module_0908) { $module_0908 = "0"; }
  if(!$module_0909) { $module_0909 = "0"; }
  if(!$module_0910) { $module_0910 = "0"; }
  
  if(!$module_1001) { $module_1001 = "0"; }
  if(!$module_1002) { $module_1002 = "0"; }
  if(!$module_1003) { $module_1003 = "0"; }
  if(!$module_1004) { $module_1004 = "0"; }
  if(!$module_1005) { $module_1005 = "0"; }
  if(!$module_1006) { $module_1006 = "0"; }
  if(!$module_1007) { $module_1007 = "0"; }
  if(!$module_1008) { $module_1008 = "0"; }
  if(!$module_1009) { $module_1009 = "0"; }
  if(!$module_1010) { $module_1010 = "0"; }
  
  if(!$module_1101) { $module_1101 = "0"; }
  if(!$module_1102) { $module_1102 = "0"; }
  if(!$module_1103) { $module_1103 = "0"; }
  if(!$module_1104) { $module_1104 = "0"; }
  if(!$module_1105) { $module_1105 = "0"; }
  if(!$module_1106) { $module_1106 = "0"; }
  if(!$module_1107) { $module_1107 = "0"; }
  if(!$module_1108) { $module_1108 = "0"; }
  if(!$module_1109) { $module_1109 = "0"; }
  if(!$module_1110) { $module_1110 = "0"; }
  
  if(!$module_9801) { $module_9801 = "0"; }
  if(!$module_9802) { $module_9802 = "0"; }
  if(!$module_9803) { $module_9803 = "0"; }
  if(!$module_9804) { $module_9804 = "0"; }
  if(!$module_9805) { $module_9805 = "0"; }
  if(!$module_9806) { $module_9806 = "0"; }
  if(!$module_9807) { $module_9807 = "0"; }
  if(!$module_9808) { $module_9808 = "0"; }
  if(!$module_9809) { $module_9809 = "0"; }
  if(!$module_9810) { $module_9810 = "0"; }
  
  if(!$module_9901) { $module_9901 = "0"; }
  if(!$module_9902) { $module_9902 = "0"; }
  if(!$module_9903) { $module_9903 = "0"; }
  if(!$module_9904) { $module_9904 = "0"; }
  if(!$module_9905) { $module_9905 = "0"; }
  if(!$module_9906) { $module_9906 = "0"; }
  if(!$module_9907) { $module_9907 = "0"; }
  if(!$module_9908) { $module_9908 = "0"; }
  if(!$module_9909) { $module_9909 = "0"; }
  if(!$module_9910) { $module_9910 = "0"; }
  
  $module_01_set = "$module_0101"."$module_0102"."$module_0103"."$module_0104"."$module_0105"."$module_0106"."$module_0107"."$module_0108"."$module_0109"."$module_0110";
  $module_01B_set = "$module_01B01"."$module_01B02"."$module_01B03"."$module_01B04"."$module_01B05"."$module_01B06"."$module_01B07"."$module_01B08"."$module_01B09"."$module_01B10";
  $module_02_set = "$module_0201"."$module_0202"."$module_0203"."$module_0204"."$module_0205"."$module_0206"."$module_0207"."$module_0208"."$module_0209"."$module_0210";
  $module_03_set = "$module_0301"."$module_0302"."$module_0303"."$module_0304"."$module_0305"."$module_0306"."$module_0307"."$module_0308"."$module_0309"."$module_0310";
  $module_04_set = "$module_0401"."$module_0402"."$module_0403"."$module_0404"."$module_0405"."$module_0406"."$module_0407"."$module_0408"."$module_0409"."$module_0410";
  $module_05_set = "$module_0501"."$module_0502"."$module_0503"."$module_0504"."$module_0505"."$module_0506"."$module_0507"."$module_0508"."$module_0509"."$module_0510";
  $module_06_set = "$module_0601"."$module_0602"."$module_0603"."$module_0604"."$module_0605"."$module_0606"."$module_0607"."$module_0608"."$module_0609"."$module_0610";
  $module_07_set = "$module_0701"."$module_0702"."$module_0703"."$module_0704"."$module_0705"."$module_0706"."$module_0707"."$module_0708"."$module_0709"."$module_0710";
  $module_08_set = "$module_0801"."$module_0802"."$module_0803"."$module_0804"."$module_0805"."$module_0806"."$module_0807"."$module_0808"."$module_0809"."$module_0810";
  $module_09_set = "$module_0901"."$module_0902"."$module_0903"."$module_0904"."$module_0905"."$module_0906"."$module_0907"."$module_0908"."$module_0909"."$module_0910";
  $module_10_set = "$module_1001"."$module_1002"."$module_1003"."$module_1004"."$module_1005"."$module_1006"."$module_1007"."$module_1008"."$module_1009"."$module_1010";
  $module_11_set = "$module_1101"."$module_1102"."$module_1103"."$module_1104"."$module_1105"."$module_1106"."$module_1107"."$module_1108"."$module_1109"."$module_1110";
  $module_98_set = "$module_9801"."$module_9802"."$module_9803"."$module_9804"."$module_9805"."$module_9806"."$module_9807"."$module_9808"."$module_9809"."$module_9810";
  $module_99_set = "$module_9901"."$module_9902"."$module_9903"."$module_9904"."$module_9905"."$module_9906"."$module_9907"."$module_9908"."$module_9909"."$module_9910";
  
  
  
  $br_query = "SELECT branch_code,userlevel FROM client WHERE client_id = '$user_gate' ORDER BY uid DESC";
  $br_result = mysql_query($br_query);
  if (!$br_result) { error("QUERY_ERROR"); exit; }
  $br_branch_code = @mysql_result($br_result,0,0);
  $br_userlevel = @mysql_result($br_result,0,1);
  
  $br2_query = "SELECT client_id FROM client WHERE branch_code = '$br_branch_code' AND userlevel = '3' ORDER BY uid DESC";
  $br2_result = mysql_query($br2_query);
  if (!$br2_result) { error("QUERY_ERROR"); exit; }
  $br2_gate_code = @mysql_result($br2_result,0,0);
  
  /*
  if($br_userlevel > "2") {
    $newup_gate_code = "$user_gate";
    $newup_subgate_code = "";
  } else {
    $newup_gate_code = "$br2_gate_code";
    $newup_subgate_code = "$user_subgate";
  }
  */

  // Update
  if($staff_sync == "1") {
	if($pw_upd == "1") {
		$query  = "UPDATE admin_user SET gate = '$user_gate', subgate = '$user_subgate', 
				user_level = '$userlevel', user_name = '$user_name', user_email = '$email', user_website = '$homepage', 
				default_lang = '$user_lang', user_pw = old_password('$pw'), user_pw2 = '$pw', group_admin = '$group_admin', module_01B = '$module_01B_set', 
				module_01 = '$module_01_set', module_02 = '$module_02_set', module_03 = '$module_03_set', module_04 = '$module_04_set', 
				module_05 = '$module_05_set', module_06 = '$module_06_set', module_07 = '$module_07_set', module_08 = '$module_08_set', 
				module_09 = '$module_09_set', module_10 = '$module_10_set', module_11 = '$module_11_set', module_98 = '$module_98_set', 
				module_99 = '$module_99_set' WHERE uid = '$user_uid'";
		$result = mysql_query($query);
		if(!$result) { error("QUERY_ERROR"); exit; }
		
		$query2 = "UPDATE member_staff SET passwd = old_password('$pw') WHERE id = '$user_id'";
		$result2 = mysql_query($query2);
		if(!$result2) { error("QUERY_ERROR"); exit; }
	} else {
		$query  = "UPDATE admin_user SET gate = '$user_gate', subgate = '$user_subgate', 
				user_level = '$userlevel', default_lang = '$user_lang', group_admin = '$group_admin', module_01B = '$module_01B_set', 
				module_01 = '$module_01_set', module_02 = '$module_02_set', module_03 = '$module_03_set', module_04 = '$module_04_set', 
				module_05 = '$module_05_set', module_06 = '$module_06_set', module_07 = '$module_07_set', module_08 = '$module_08_set', 
				module_09 = '$module_09_set', module_10 = '$module_10_set', module_11 = '$module_11_set', module_98 = '$module_98_set', 
				module_99 = '$module_99_set' WHERE uid = '$user_uid'";
		$result = mysql_query($query);
		if(!$result) { error("QUERY_ERROR"); exit; }
	}
  } else {
	if($pw_upd == "1") {
		$query  = "UPDATE admin_user SET gate = '$user_gate', subgate = '$user_subgate', 
				user_level = '$userlevel', user_name = '$user_name', user_email = '$email', user_website = '$homepage', 
				default_lang = '$user_lang', user_pw = old_password('$pw'), user_pw2 = '$pw', group_admin = '$group_admin', module_01B = '$module_01B_set', 
				module_01 = '$module_01_set', module_02 = '$module_02_set', module_03 = '$module_03_set', module_04 = '$module_04_set', 
				module_05 = '$module_05_set', module_06 = '$module_06_set', module_07 = '$module_07_set', module_08 = '$module_08_set', 
				module_09 = '$module_09_set', module_10 = '$module_10_set', module_11 = '$module_11_set', module_98 = '$module_98_set', 
				module_99 = '$module_99_set' WHERE uid = '$user_uid'";
		$result = mysql_query($query);
		if(!$result) { error("QUERY_ERROR"); exit; }
		
		$query2 = "UPDATE member_staff SET passwd = old_password('$pw') WHERE id = '$user_id'";
		$result2 = mysql_query($query2);
		if(!$result2) { error("QUERY_ERROR"); exit; }
	} else {
		$query  = "UPDATE admin_user SET gate = '$user_gate', subgate = '$user_subgate', 
				user_level = '$userlevel', user_name = '$user_name', user_email = '$email', user_website = '$homepage', 
				default_lang = '$user_lang', group_admin = '$group_admin', module_01B = '$module_01B_set', 
				module_01 = '$module_01_set', module_02 = '$module_02_set', module_03 = '$module_03_set', module_04 = '$module_04_set', 
				module_05 = '$module_05_set', module_06 = '$module_06_set', module_07 = '$module_07_set', module_08 = '$module_08_set', 
				module_09 = '$module_09_set', module_10 = '$module_10_set', module_11 = '$module_11_set', module_98 = '$module_98_set', 
				module_99 = '$module_99_set' WHERE uid = '$user_uid'";
		$result = mysql_query($query);
		if(!$result) { error("QUERY_ERROR"); exit; }
	}
  }
  


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_user.php'>");
  exit;
  
 
}

}
?>
