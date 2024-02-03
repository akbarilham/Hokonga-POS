<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member2";

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
$query = "SELECT uid,org_uid,org_db,sync_date,sync_on,branch_code,gate,name,name2,code,id,passwd2,
          birthday,calendar,gender,email,homepage,job,corp_name,corp_dept,corp_title,corp_desc,corp_margin,
          zipcode,addr1,addr2,phone,phone_cel,phone_fax,mlist,m_ip,memo,userlevel,signdate,paydate,
          shop_point,counter,country_code,mb_type,reseller,photo1,photo2,crmflag,log_in,log_out,
          visit,lang,bank_name,acct_name,acct_no,level1_code FROM member_main WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$staff_uid = $row->uid;
$org_uid = $row->org_uid;
$org_db = $row->org_db;
$sync_date = $row->sync_date;
$sync_on = $row->sync_on;
  if($sync_on == "2") {
    $sync_on_txt = "<font color=green>$txt_stf_member_12</font>";
  } else if($sync_on == "1") {
    $sync_on_txt = "<font color=blue>$txt_stf_member_11</font>";
  } else {
    $sync_on_txt = "$txt_stf_member_10";
  }
$user_branch_code = $row->branch_code;
$user_gate = $row->gate;
$user_name = $row->name;
$user_name2 = $row->name2;
$user_code = $row->code;
$user_id = $row->id;
$user_passwd2 = $row->passwd2;
$birth_date = $row->birthday;
  $birthyear = substr($birth_date,0,4);
  $birthmonth = substr($birth_date,4,2);
    $birthmonth1 = substr($birth_date,4,1);
    $birthmonth2 = substr($birth_date,5,1);
  $birthday = substr($birth_date,6,2);
    $birthday1 = substr($birth_date,6,1);
    $birthday2 = substr($birth_date,7,1);
  $birth_dates = "$birthyear"."-"."$birthmonth"."-"."$birthday";
  
  if($birthmonth1 == "0") {
    $birth_m = $birthmonth2;
  } else {
    $birth_m = $birthmonth;
  }
  if($birthday1 == "0") {
    $birth_d = $birthday2;
  } else {
    $birth_d = $birthday;
  }
$calendar = $row->calendar;
  if($calendar == "S") {
    $calendar_chkS = "checked";
    $calendar_chkL = "";
  } else if($calendar == "L") {
    $calendar_chkS = "";
    $calendar_chkL = "checked";
  }
$gender = $row->gender;
  if($gender == "M") {
    $gender_chkM = "checked";
    $gender_chkF = "";
  } else if($gender == "F") {
    $gender_chkM = "";
    $gender_chkF = "checked";
  }
$email = $row->email;
$homepage = $row->homepage;
$job = $row->job;
$corp_name = $row->corp_name;
$corp_dept = $row->corp_dept;
$corp_title = $row->corp_title;
$corp_desc = $row->corp_desc;
$zipcode = $row->zipcode;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$phone = $row->phone;
$phone_cel = $row->phone_cel;
$phone_fax = $row->phone_fax;
$mlist = $row->mlist;
  if($mlist == "0") {
    $mlist_chk1 = "";
    $mlist_chk0 = "checked";
  } else {
    $mlist_chk1 = "checked";
    $mlist_chk0 = "";
  }
$m_ip = $row->m_ip;
$memo = $row->memo;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$paydate = $row->paydate;
$shop_point = $row->shop_point;
$counter = $row->counter;
$country_code = $row->country_code;
$mb_type = $row->mb_type;
$reseller = $row->reseller;
  if($reseller == "1") {
    $reseller_chk0 = "";
    $reseller_chk1 = "checked";
  } else {
    $reseller_chk0 = "checked";
    $reseller_chk1 = "";
  }
$photo1 = $row->photo1;
$photo2 = $row->photo2;
$crmflag = $row->crmflag;
$log_in = $row->log_in;
$log_out = $row->log_out;
$visit = $row->visit;
$join_lang = $row->lang;
$bank_name = $row->bank_name;
$acct_name = $row->acct_name;
$acct_no = $row->acct_no;
$user_level1_code = $row->level1_code;
$corp_margin = $row->corp_margin;

$memo = stripslashes($memo);
$corp_desc = stripslashes($corp_desc);

// 이미지 확장자
if($photo1 == "1") {
	$ext1 = "jpg";
} else if($photo1 == "2") {
	$ext1 = "gif";
} else if($photo1 == "3") {
	$ext1 = "png";
}
if($photo2 == "1") {
	$ext2 = "jpg";
} else if($photo2 == "2") {
	$ext2 = "gif";
} else if($photo2 == "3") {
	$ext2 = "png";
}

// 이미지 경로 및 파일명
$savedir = "user_file";
$img1 = "staff_{$client_id}_photo1.{$ext1}";
$img2 = "staff_{$client_id}_photo2.{$ext2}";

$crm_member2_del_link = "crm_member2_del.php?keyfield=$keyfield&key=$key&page=$page&uid=$staff_uid&mb_level=$mb_level&mb_type=$mb_type";




// Distributor Details
$queryG = "SELECT count(code) FROM member_main_distributor WHERE code = '$user_code'";
$resultG = mysql_query($queryG);
	if (!$resultG) {   error("QUERY_ERROR");   exit; }
$total_distrib = @mysql_result($resultG,0,0);
											
$queryH = "SELECT uid,contract_num,store_name,store_type,store_open_date,pay_npwp,pay_type,pay_term,pay_shipping,cust_type,pic1_spc,pic2_suv,
		sales_area,counter_catg,counter_typo,store_grade,stock_point,total_cashier,store_email,store_zipcode,store_addr1,store_addr2,
		store_phone,store_phone_cel,store_phone_fax,store_pic_name,tax_id,tax_addr,tax_status,no_npwp,rebate_fixed,rebate_condi,fixed_cost,
		market1,market2,market3,market_item,display_floor,display_gondola,display_tg,display_msc,display_type,sa_total,sa1,sa2,
		code_pro,code_appr1,code_appr2,code_appr3,code_cc01,code_cc02,code_cc03,code_cc04,code_cc05,code_cc06,code_cc07,code_cc08,code_cc09,code_cc10,
		userfile,memo,post_date,upd_date FROM member_main_distributor WHERE code = '$user_code' ORDER BY uid DESC";
$resultH = mysql_query($queryH);
	if (!$resultH) {   error("QUERY_ERROR");   exit; }
$H_uid = @mysql_result($resultH,0,0);
$H_contract_num = @mysql_result($resultH,0,1);
$H_store_name = @mysql_result($resultH,0,2);
$H_store_type = @mysql_result($resultH,0,3);
$H_store_open = @mysql_result($resultH,0,4);
$H_pay_npwp = @mysql_result($resultH,0,5);
$H_pay_type = @mysql_result($resultH,0,6);
$H_pay_term = @mysql_result($resultH,0,7);
$H_pay_shipping = @mysql_result($resultH,0,8);
$H_cust_type = @mysql_result($resultH,0,9);
$H_pic1_spc = @mysql_result($resultH,0,10);
$H_pic1_suv = @mysql_result($resultH,0,11);
$H_sales_area = @mysql_result($resultH,0,12);
$H_counter_catg = @mysql_result($resultH,0,13);
$H_counter_typo = @mysql_result($resultH,0,14);
$H_store_grade = @mysql_result($resultH,0,15);
$H_stock_point = @mysql_result($resultH,0,16);
$H_total_cashier = @mysql_result($resultH,0,17);
$H_store_email = @mysql_result($resultH,0,18);
$H_store_zipcode = @mysql_result($resultH,0,19);
$H_store_addr1 = @mysql_result($resultH,0,20);
$H_store_addr2 = @mysql_result($resultH,0,21);
$H_store_phone = @mysql_result($resultH,0,22);
$H_store_phone_cel = @mysql_result($resultH,0,23);
$H_store_phone_fax = @mysql_result($resultH,0,24);
$H_store_pic_name = @mysql_result($resultH,0,25);
$H_tax_id = @mysql_result($resultH,0,26);
$H_tax_addr = @mysql_result($resultH,0,27);
$H_tax_status = @mysql_result($resultH,0,28);
$H_no_npwp = @mysql_result($resultH,0,29);
$H_rebate_fixed = @mysql_result($resultH,0,30);
$H_rebate_condi = @mysql_result($resultH,0,31);
$H_fixed_cost = @mysql_result($resultH,0,32);
$H_market1 = @mysql_result($resultH,0,33);
$H_market2 = @mysql_result($resultH,0,34);
$H_market3 = @mysql_result($resultH,0,35);
$H_market_item = @mysql_result($resultH,0,36);
$H_display_floor = @mysql_result($resultH,0,37);
$H_display_gondola = @mysql_result($resultH,0,38);
$H_display_tg = @mysql_result($resultH,0,39);
$H_display_msc = @mysql_result($resultH,0,40);
$H_display_type = @mysql_result($resultH,0,41);
$H_sa_total = @mysql_result($resultH,0,42);
$H_sa1 = @mysql_result($resultH,0,43);
$H_sa2 = @mysql_result($resultH,0,44);
$H_code_pro = @mysql_result($resultH,0,45);
$H_code_appr1 = @mysql_result($resultH,0,46);
$H_code_appr2 = @mysql_result($resultH,0,47);
$H_code_appr3 = @mysql_result($resultH,0,48);
$H_code_cc01 = @mysql_result($resultH,0,49);
$H_code_cc02 = @mysql_result($resultH,0,50);
$H_code_cc03 = @mysql_result($resultH,0,51);
$H_code_cc04 = @mysql_result($resultH,0,52);
$H_code_cc05 = @mysql_result($resultH,0,53);
$H_code_cc06 = @mysql_result($resultH,0,54);
$H_code_cc07 = @mysql_result($resultH,0,55);
$H_code_cc08 = @mysql_result($resultH,0,56);
$H_code_cc09 = @mysql_result($resultH,0,57);
$H_code_cc10 = @mysql_result($resultH,0,58);
$H_userfile = @mysql_result($resultH,0,59);
$H_memo = @mysql_result($resultH,0,60);
$H_post_date = @mysql_result($resultH,0,61);
$H_upd_date = @mysql_result($resultH,0,62);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_stf_member_03?>
            <span class="tools pull-right">
				<a href="<?echo("$crm_member2_del_link")?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                
									<form class="cmxform form-horizontal adminex-form" name="createform" method="post" action="crm_member2_upd.php">
									<input type="hidden" name="step_next" value="permit_post">
									<input type="hidden" name="user_id" value="<?=$login_id?>">
									<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
									<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
									<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
									<input type='hidden' name='key' value='<?=$key?>'>
									<input type='hidden' name='staff_uid' value='<?=$staff_uid?>'>
									<input type='hidden' name='staff_code' value='<?=$user_code?>'>
									<input type='hidden' name='org_name' value='<?=$user_name?>'>
									<input type='hidden' name='org_corp_name' value='<?=$corp_name?>'>
									<input type='hidden' name='org_branch_code' value='<?=$user_branch_code?>'>
									<input type='hidden' name='page' value='<?=$page?>'>
								
									<div class="form-group ">
									
									
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_55?></label>
                                        <div class="col-sm-3">
                                            <input readonly class="form-control" id="cname" name="dis_user_code" value='<?=$user_code?>' type="id" />
                                        </div>
										
										<? if($total_distrib > 0) { ?>
										
										<div class="col-sm-1">
											DOC. NO
										</div>
										<div class="col-sm-5">
											<input disabled class="form-control" id="cname" name="contract_num" value="<?=$H_contract_num?>" type="text"/>
										</div>
										
										<? } else { ?>
										
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="contract_num" type="text" placeholder="DOC. NO" required/>
                                        </div>
										<div class="col-sm-3">
											<input class="btn btn-primary" type="submit" value="Create DOC.">
										</div>
										
										<? } ?>
										
                                    </div>
									
									</form>
							
							</div>
							
							
							<div class="form">
									
									
									<form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="crm_member2_upd.php">
									<input type="hidden" name="step_next" value="permit_okay">
									<input type="hidden" name="user_id" value="<?=$login_id?>">
									<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
									<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
									<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
									<input type='hidden' name='key' value='<?=$key?>'>
									<input type='hidden' name='staff_uid' value='<?=$staff_uid?>'>
									<input type='hidden' name='org_name' value='<?=$user_name?>'>
									<input type='hidden' name='page' value='<?=$page?>'>
                                    
									<? if($mb_level AND $mb_level < "7") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
											if($now_group_admin == "1" OR $login_level > "3") {
												$queryE = "SELECT count(uid) FROM client_branch";
											} else {
												$queryE = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
											}
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											if($now_group_admin == "1" OR $login_level > "3") {
												$queryF = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											} else {
												$queryF = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code = '$login_branch' 
															ORDER BY branch_code ASC";
											}
											$resultF = mysql_query($queryF);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											if($now_group_admin == "1" OR $login_level > "3") {
												echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");
											}

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($key) {
													if($branch_code == $key) {
														$slc_brc = "selected";
													} else {
														$slc_brc = "";
													}
												} else {
													if($branch_code == $user_branch_code) {
														$slc_brc = "selected";
													} else {
														$slc_brc = "";
													}
												}
        
												echo("<option value='$PHP_SELF?keyfield=branch_code&key=$branch_code&uid=$staff_uid&mb_level=$mb_level&mb_type=$mb_type' $slc_brc>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<? if($key) { ?>
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$hsm_name_06_021?></label>
                                        <div class="col-sm-9">
										
											<?
											if($key) {
												$key2 = $key;
											} else {
												$key2 = $user_branch_code;
											}
	
											$queryG = "SELECT count(code) FROM member_main WHERE userlevel = '7' AND branch_code = '$key2'";
											$resultG = mysql_query($queryG);
											$total_recordG = @mysql_result($resultG,0,0);

											$queryH = "SELECT code,corp_name FROM member_main WHERE userlevel = '7' AND branch_code = '$key2' ORDER BY name ASC";
											$resultH = mysql_query($queryH);

											echo("<select name='user1_code' class='form-control' required>");

											for($h = 0; $h < $total_recordG; $h++) {
												$level1_code = mysql_result($resultH,$h,0);
												$level1_name = mysql_result($resultH,$h,1);
        
												if($level1_code == $key2) {
													$level1_slct = "selected";
												} else {
													$level1_slct = "";
												}
        
												echo("<option value='$level1_code' $level1_slct>$level1_name</option>");
											}
											echo("</select>");
											?>
										
										
										</div>
                                    </div>
									<? } ?>
									
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            if($now_group_admin == "1" OR $login_level > "3") {
												$queryE = "SELECT count(uid) FROM client_branch";
											} else {
												$queryE = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
											}
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											if($now_group_admin == "1" OR $login_level > "3") {
												$queryF = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											} else {
												$queryF = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code = '$login_branch' 
															ORDER BY branch_code ASC";
											}
											$resultF = mysql_query($queryF);

											echo("<select name='user_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($branch_code == $user_branch_code) {
													$slc_brcF = "selected";
													$slc_disableF = "";
												} else {
													$slc_brcF = "";
													$slc_disableF = "disabled";
												}
        
												echo("<option value='$branch_code' $slc_brcF>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									
									
									
									
									<? if($total_distrib > 0) { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Store Type</label>
                                        <div class="col-sm-9">
                                            <? if($H_store_type == "1") { ?>
											<input type="radio" name="H_store_type" value="1" checked> STORE &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_type" value="1"> STORE &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_type == "2") { ?>
											<input type="radio" name="H_store_type" value="2" checked> NEW ITEM &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_type" value="2"> NEW ITEM &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_type == "3") { ?>
											<input type="radio" name="H_store_type" value="3" checked> REVISI
											<? } else { ?>
											<input type="radio" name="H_store_type" value="3"> REVISI
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Customer Type</label>
                                        <div class="col-sm-9">
                                            <? if($H_cust_type == "1") { ?>
											<input type="radio" name="H_cust_type" value="1" checked> DIRECT &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_cust_type" value="1"> DIRECT &nbsp;&nbsp; 
											<? } ?>
											<? if($H_cust_type == "2") { ?>
											<input type="radio" name="H_cust_type" value="2" checked> B2B &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_cust_type" value="2"> B2B &nbsp;&nbsp; 
											<? } ?>
											<? if($H_cust_type == "3") { ?>
											<input type="radio" name="H_cust_type" value="3" checked> KONSINYASI
											<? } else { ?>
											<input type="radio" name="H_cust_type" value="3"> KONSINYASI
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Person in charge - SPC</label>
                                        <div class="col-sm-9">
                                            <?
                                            $query_1E = "SELECT count(id) FROM member_staff WHERE userlevel > '1' AND userlevel < '5'";
											$result_1E = mysql_query($query_1E);
											$total_record_1E = @mysql_result($result_1E,0,0);

											$query_1F = "SELECT id,code,name,userlevel FROM member_staff WHERE userlevel > '1' AND userlevel < '5' 
														ORDER BY id ASC, name ASC";
											$result_1F = mysql_query($query_1F);

											echo("<select name='H_pic1_spc' class='form-control'>");
											
											echo("<option value=\"\">:: Select Person in charge</option>");

											for($f1 = 0; $f1 < $total_record_1E; $f1++) {
												$mbr1_id = mysql_result($result_1F,$f1,0);
												$mbr1_code = mysql_result($result_1F,$f1,1);
												$mbr1_name = mysql_result($result_1F,$f1,2);
												$mbr1_level = mysql_result($result_1F,$f1,3);
												
												echo("<option value='$mbr1_code'>[ $mbr1_code ] $mbr1_name ( $mbr1_id )</option>");
											}
											
											
											echo("</select>");
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Supervisor</label>
                                        <div class="col-sm-9">
                                            <?
                                            $query_2E = "SELECT count(id) FROM member_staff WHERE userlevel > '1' AND userlevel < '8'";
											$result_2E = mysql_query($query_2E);
											$total_record_2E = @mysql_result($result_2E,0,0);

											$query_2F = "SELECT id,code,name,userlevel FROM member_staff WHERE userlevel > '1' AND userlevel < '8' 
														ORDER BY id ASC, name ASC";
											$result_2F = mysql_query($query_2F);

											echo("<select name='H_pic2_suv' class='form-control'>");
											
											echo("<option value=\"\">:: Select Supervisor</option>");

											for($f2 = 0; $f2 < $total_record_2E; $f2++) {
												$mbr2_id = mysql_result($result_2F,$f2,0);
												$mbr2_code = mysql_result($result_2F,$f2,1);
												$mbr2_name = mysql_result($result_2F,$f2,2);
												$mbr2_level = mysql_result($result_2F,$f2,3);
												
												echo("<option value='$mbr2_code'>[ $mbr2_code ] $mbr2_name ( $mbr2_id )</option>");
											}
											
											
											echo("</select>");
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Sales Area/Region</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_sales_area" value="<?=$H_sales_area?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Counter Category</label>
                                        <div class="col-sm-9">
                                            <? if($H_counter_catg == "1") { ?>
											<input type="radio" name="H_counter_catg" value="1" checked> Gold &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_counter_catg" value="1"> Gold &nbsp;&nbsp; 
											<? } ?>
											<? if($H_counter_catg == "2") { ?>
											<input type="radio" name="H_counter_catg" value="2" checked> Silver &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_counter_catg" value="2"> Silver &nbsp;&nbsp; 
											<? } ?>
											<? if($H_counter_catg == "3") { ?>
											<input type="radio" name="H_counter_catg" value="3" checked> Bronze
											<? } else { ?>
											<input type="radio" name="H_counter_catg" value="3"> Bronze
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Counter Typology</label>
                                        <div class="col-sm-5">
                                            <? if($H_counter_typo == "A") { ?>
											<input type="radio" name="H_counter_typo" value="A" checked> A &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_counter_typo" value="A"> A &nbsp;&nbsp; 
											<? } ?>
											<? if($H_counter_typo == "B") { ?>
											<input type="radio" name="H_counter_typo" value="B" checked> B &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_counter_typo" value="B"> B &nbsp;&nbsp; 
											<? } ?>
											<? if($H_counter_typo == "C") { ?>
											<input type="radio" name="H_counter_typo" value="C" checked> C &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_counter_typo" value="C"> C &nbsp;&nbsp; 
											<? } ?>
											<? if($H_counter_typo == "D") { ?>
											<input type="radio" name="H_counter_typo" value="D" checked> D
											<? } else { ?>
											<input type="radio" name="H_counter_typo" value="D"> D
											<? } ?>
                                        </div>
										<div class="col-sm-2">JUMLAH KASIR :</div>
										<div class="col-sm-2">
                                            <input class="form-control" id="cname" name="H_total_cashier" value="<?=$H_total_cashier?>" maxlength="6" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Grade Store</label>
                                        <div class="col-sm-9">
                                            <? if($H_store_grade == "A+") { ?>
											<input type="radio" name="H_store_grade" value="A+" checked> A+ &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_grade" value="A+"> A+ &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_grade == "A") { ?>
											<input type="radio" name="H_store_grade" value="A" checked> A &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_grade" value="A"> A &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_grade == "B+") { ?>
											<input type="radio" name="H_store_grade" value="B+" checked> B+ &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_grade" value="B+"> B+ &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_grade == "B+") { ?>
											<input type="radio" name="H_store_grade" value="B" checked> B &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_store_grade" value="B"> B &nbsp;&nbsp; 
											<? } ?>
											<? if($H_store_grade == "C+") { ?>
											<input type="radio" name="H_store_grade" value="C+" checked> C+
											<? } else { ?>
											<input type="radio" name="H_store_grade" value="C+"> C+
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Stock Point</label>
                                        <div class="col-sm-9">
											<? if($H_stock_point == "JKT") { ?>
                                            <input type="radio" name="H_stock_point" value="JKT" checked> JKT &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_stock_point" value="JKT"> JKT &nbsp;&nbsp; 
											<? } ?>
											<? if($H_stock_point == "MDN") { ?>
											<input type="radio" name="H_stock_point" value="MDN" checked> MDN &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_stock_point" value="MDN"> MDN &nbsp;&nbsp; 
											<? } ?>
											<? if($H_stock_point == "BNDG") { ?>
											<input type="radio" name="H_stock_point" value="BNDG" checked> BNDG &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_stock_point" value="BNDG"> BNDG &nbsp;&nbsp; 
											<? } ?>
											<? if($H_stock_point == "SBY") { ?>
											<input type="radio" name="H_stock_point" value="SBY" checked> SBY
											<? } else { ?>
											<input type="radio" name="H_stock_point" value="SBY"> SBY
											<? } ?>
                                        </div>
                                    </div>
									
									<br><br>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>STORE DATA</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Store Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_store_name" value="<?=$H_store_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Open Date</label>
                                        <div class="col-sm-3">
											<input class="form-control" name="H_store_open_date" size="16" type="date" value="<?=$H_store_open_date?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_15?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="zipcode" name="H_store_zipcode" value="<?=$H_store_zipcode?>" maxlength="6" type="tel" />
                                        </div>
										<div class="col-sm-7"></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_16?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_store_addr2" value="<?=$H_store_addr2?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_17?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_store_addr1" value="<?=$H_store_addr1?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Person in charge</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_store_pic_name" value="<?=$H_store_pic_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="H_store_email" value="<?=$H_store_email?>" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="H_store_phone" value="<?=$H_store_phone?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">FAX</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="H_store_phone_fax" value="<?=$H_store_phone_fax?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="H_store_phone_cel" value="<?=$H_store_phone_cel?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<br><br>
									
									<? } ?>
									
									
									
									
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>CUSTOMER DATA</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Company Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_name" value="<?=$corp_name?>" type="text" required/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_15?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="zipcode" name="zipcode" value="<?=$zipcode?>" maxlength="6" type="tel" />
                                        </div>
										<div class="col-sm-7"></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_16?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr2" value="<?=$addr2?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_14?> (<?=$txt_sys_client_17?>)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="addr1" value="<?=$addr1?>" maxlength="120" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Person in charge</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="new_name" value="<?=$user_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_09?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='gender' value='M' <?=$gender_chkM?>> <?=$txt_stf_staff_10?> &nbsp;&nbsp;
											<input type=radio name='gender' value='F' <?=$gender_chkF?>> <?=$txt_stf_staff_11?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_12?></label>
                                        <div class="col-sm-3">
											<input class="form-control" name="user_birthdates" size="16" type="date" value="<?=$birth_dates?>" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_15?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_dept" value="<?=$corp_dept?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_16?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_title" value="<?=$corp_title?>" type="text" />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" value="<?=$email?>" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone" value="<?=$phone?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">FAX</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_fax" value="<?=$phone_fax?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone_cel" value="<?=$phone_cel?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_60?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="bank_name" value="<?=$bank_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_61?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="acct_name" value="<?=$acct_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_62?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="acct_no" value="<?=$acct_no?>" type="text" />
                                        </div>
                                    </div>
									
									
									
									
									
									
									<? if($total_distrib > 0) { ?>
									
									<br><br>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>Conditions</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Tax ID</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_tax_id" value="<?=$H_tax_id?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Tax Address</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_tax_addr" value="<?=$H_tax_addr?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">NO NPWP</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_no_npwp" value="<?=$H_no_npwp?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Tax Status</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="H_tax_status" value="<?=$H_tax_status?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Fixed Rebate</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="H_rebate_fixed" value="<?=$H_rebate_fixed?>" type="text" />
                                        </div>
										<div class="col-sm-1">%</div>
										<label for="cname" class="control-label col-sm-3">Conditional Rebate</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="H_rebate_condi" value="<?=$H_rebate_condi?>" type="text" />
                                        </div>
										<div class="col-sm-1">%</div>
                                    </div>
									
									<? } ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Discount Margin</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="corp_margin" value="<?=$corp_margin?>" maxlength="6" type="text" required />
                                        </div>
										<div class="col-sm-1">%</div>
                                    </div>
									
									
									<? if($total_distrib > 0) { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Fixed Cost (Rp.)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_fixed_cost" value="<?=$H_fixed_cost?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">NPWP</label>
                                        <div class="col-sm-9">
											<? if($H_pay_npwp == "0") { ?>
                                            <input type="radio" name="H_pay_npwp" value="0" checked> NON PKP &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_npwp" value="0"> NON PKP &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_npwp == "1") { ?>
											<input type="radio" name="H_pay_npwp" value="1" checked> PKP
											<? } else { ?>
											<input type="radio" name="H_pay_npwp" value="1"> PKP
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Term of Payment</label>
                                        <div class="col-sm-9">
                                            <? if($H_pay_term == "cod") { ?>
											<input type="radio" name="H_pay_term" value="cod" checked> CBD/COD &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_term" value="cod"> CBD/COD &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_term == "14") { ?>
											<input type="radio" name="H_pay_term" value="14" checked> 14 Days &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_term" value="14"> 14 Days &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_term == "30") { ?>
											<input type="radio" name="H_pay_term" value="30" checked> 30 Days &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_term" value="30"> 30 Days &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_term == "45") { ?>
											<input type="radio" name="H_pay_term" value="45" checked> 45/60 Days
											<? } else { ?>
											<input type="radio" name="H_pay_term" value="45"> 45/60 Days
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Type of Payment</label>
                                        <div class="col-sm-9">
                                            <? if($H_pay_type == "cash") { ?>
											<input type="radio" name="H_pay_type" value="cash" checked> Cash &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_type" value="cash"> Cash &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_type == "bank") { ?>
											<input type="radio" name="H_pay_type" value="bank" checked> Transfer &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_type" value="bank"> Transfer &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_type == "giro") { ?>
											<input type="radio" name="H_pay_type" value="giro" checked> Giro
											<? } else { ?>
											<input type="radio" name="H_pay_type" value="giro"> Giro
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Delivery Cost</label>
                                        <div class="col-sm-9">
											<? if($H_pay_shipping == "pt") { ?>
                                            <input type="radio" name="H_pay_shipping" value="pt" checked> PT &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_pay_shipping" value="pt"> PT &nbsp;&nbsp; 
											<? } ?>
											<? if($H_pay_shipping == "customer") { ?>
											<input type="radio" name="H_pay_shipping" value="customer" checked> Customer
											<? } else { ?>
											<input type="radio" name="H_pay_shipping" value="customer"> Customer
											<? } ?>
                                        </div>
                                    </div>
									
									<br><br>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>Market Size Analysis</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Market Size by Group (Rp.)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_market1" value="<?=$H_market1?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Market Size by Housewares (Rp.)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_market2" value="<?=$H_market2?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Market Size by Plasticwares (Rp.)</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_market3" value="<?=$H_market3?>" type="text" />
                                        </div>
                                    </div>
									
									<br><br>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>Display Size & Type</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Area Display</label>
                                        <div class="col-sm-3">Floor Display</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_display_floor" value="<?=$H_display_floor?>" type="text" />
                                        </div>
										<div class="col-sm-3">m<sup>2</sup></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-3">Gondola</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_display_gondola" value="<?=$H_display_gondola?>" type="text" />
                                        </div>
										<div class="col-sm-3">unit</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-3">TG / End Gondola</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_display_tg" value="<?=$H_display_tg?>" type="text" />
                                        </div>
										<div class="col-sm-3">unit</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-3">Others</div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="H_display_msc" value="<?=$H_display_msc?>" type="text" />
                                        </div>
										<div class="col-sm-3"></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Display Type</label>
                                        <div class="col-sm-9">
											<? if($H_display_type == "1") { ?>
                                            <input type="radio" name="H_display_type" value="1" checked> Image Counter &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_display_type" value="1"> Image Counter &nbsp;&nbsp; 
											<? } ?>
											<? if($H_display_type == "2") { ?>
											<input type="radio" name="H_display_type" value="2" checked> Semi Image Counter &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_display_type" value="2"> Semi Image Counter &nbsp;&nbsp; 
											<? } ?>
											<? if($H_display_type == "3") { ?>
											<input type="radio" name="H_display_type" value="3" checked> Regular Display / rack &nbsp;&nbsp; 
											<? } else { ?>
											<input type="radio" name="H_display_type" value="3"> Regular Display / rack &nbsp;&nbsp; 
											<? } ?>
											<? if($H_display_type == "4") { ?>
											<input type="radio" name="H_display_type" value="4" checked> Others
											<? } else { ?>
											<input type="radio" name="H_display_type" value="4"> Others
											<? } ?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">SA Needed</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="H_sa_total" value="<?=$H_sa_total?>" type="text" />
                                        </div>
										<div class="col-sm-1">person(s)</div>
										<div class="col-sm-2">&nbsp;</div>
										<div class="col-sm-1">
                                            <input class="form-control" id="cname" name="H_sa1" value="<?=$H_sa1?>" type="text" />
                                        </div>
										<div class="col-sm-1">&lt; Stay</div>
										<div class="col-sm-1">
                                            <input class="form-control" id="cname" name="H_sa2" value="<?=$H_sa2?>" type="text" />
                                        </div>
										<div class="col-sm-1">&lt; Mobile</div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Date</label>
                                        <div class="col-sm-4">
                                            <input readonly class="form-control" id="signdate" name="H_post_date" value="<?=$H_post_date?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3">Note :</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="H_memo"><?echo("$H_memo")?></textarea>
                                        </div>
                                    </div>
									
									<? } ?>
									
									
									
									
									
									
									<br><br>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><i class="fa fa-chevron-circle-down"></i>&nbsp; <b>User Level</b></label>
                                        <div class="col-sm-9">&nbsp;</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_57?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Hold</font> &nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Hold</font> &nbsp;&nbsp; ");
											}

											if(!strcmp($userlevel,"6")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"6\" CHECKED> $hsm_name_06_022 &nbsp;&nbsp; ");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"6\"> $hsm_name_06_022 &nbsp;&nbsp; ");
											}
   
											if(!strcmp($userlevel,"7")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\" CHECKED> $hsm_name_06_021");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\"> $hsm_name_06_021");
											}
											?>
                                            
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3"><?=$txt_sys_client_26?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="memo"><?echo("$memo")?></textarea>
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
                                            <input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
                                        </div>
										<div class="col-sm-1" align=right>IP</div>
										<div class="col-sm-4">
                                            <input readonly class="form-control" id="cname" name="m_ip" value="<?echo("$m_ip")?>" type="text" />
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
} else if($step_next == "permit_post") {


	$org_name = addslashes($org_name);
	$org_corp_name = addslashes($org_corp_name);

  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  

    $query_P = "INSERT INTO member_main_distributor (uid,branch_code,code,contract_num,store_name) values ('',
          '$org_branch_code','$staff_code','$contract_num','$org_corp_name')";
    $result_P = mysql_query($query_P);
    if (!$result_P) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member2.php?keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type'>");
  exit;
  


  
} else if($step_next == "permit_okay") {

	
	$birthday_exp = explode("-",$user_birthdates);
	$birth1 = $birthday_exp[0];
	$birth2 = $birthday_exp[1];
	$birth3 = $birthday_exp[2];
	
	$birth_date = "$birth1"."$birth2"."$birth3";
	
	$name = addslashes($name);
	$corp_name = addslashes($corp_name);
	$memo = addslashes($memo);
	
	$H_store_pic_name = addslashes($H_store_pic_name);
	$H_store_name = addslashes($H_store_name);
	$H_memo = addslashes($Hmemo);


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  
	if(!$user_branch_code) {
		$user_branch_code = $key;
	}


	if($mb_level == "7") {
		$new_level1_code = "";
	} else {
		$new_level1_code = $user1_code;
	}


    $query_M1  = "UPDATE member_main SET branch_code = '$user_branch_code', level1_code = '$new_level1_code',
              name = '$new_name', email = '$email', homepage = '$homepage', 
			  corp_name = '$corp_name', corp_dept = '$corp_dept', corp_title = '$corp_title', corp_margin = '$corp_margin', 
              phone = '$phone', phone_fax = '$phone_fax', phone_cel = '$phone_cel', zipcode = '$zipcode', 
              addr1 = '$addr1', addr2 = '$addr2', memo = '$memo', 
              bank_name = '$bank_name', acct_name = '$acct_name', acct_no = '$acct_no' WHERE uid = '$staff_uid'";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }
	


	// Details
	$query_M2 = "UPDATE member_main_distributor SET store_name = '$H_store_name', store_type = '$H_store_type', store_open_date = '$H_store_open_date', 
				pay_npwp = '$H_pay_npwp', pay_type = '$H_pay_type', pay_term = '$H_pay_term', pay_shipping = '$H_pay_shipping', cust_type = '$H_cust_type', 
				pic1_spc = '$H_pic1_spc', pic2_suv = '$H_pic2_suv', sales_area = '$H_sales_area', counter_catg = '$H_counter_catg', counter_typo = 'H_counter_typo', 
				store_grade = '$H_store_grade', stock_point = '$H_stock_point', total_cashier = '$H_total_cashier', store_email = '$H_store_email', 
				store_zipcode = '$H_store_zipcode', store_addr1 = '$H_store_addr1', store_addr2 = '$H_store_addr2', 
				store_phone = '$H_store_phone', store_phone_cel = '$H_store_phone_cel', store_phone_fax = '$H_store_phone_fax', 
				store_pic_name = '$H_store_pic_name', tax_id = '$H_tax_id', tax_addr = '$H_tax_addr', tax_status = '$H_tax_status', 
				no_npwp = '$H_no_npwp', rebate_fixed = '$H_rebate_fixed', rebate_condi = '$H_rebate_condi', fixed_cost = '$H_fixed_cost', 
				market1 = '$H_market1', market2 = '$H_market2', market3 = '$H_market3', market_item = '$H_market_item', 
				display_floor = '$H_display_floor', display_gondola = '$H_display_gondola', display_tg = '$H_display_tg', display_msc = '$H_display_msc', 
				display_type = '$H_display_type', sa_total = '$H_sa_total', sa1 = '$H_sa1', sa2 = '$H_sa2', 
				code_pro = '$H_code_pro', code_appr1 = '$H_code_appr1', code_appr2 = '$H_code_appr2', code_appr3 = '$H_code_appr3', 
				code_cc01 = '$H_code_cc01', code_cc02 = '$H_code_cc02', code_cc03 = '$H_code_cc03', code_cc04 = '$H_code_cc04', code_cc05 = '$H_code_cc05', 
				code_cc06 = '$H_code_cc06', code_cc07 = '$H_code_cc07', code_cc08 = '$H_code_cc08', code_cc09 = '$H_code_cc09', code_cc10 = '$H_code_cc10', 
				userfile = '$H_userfile', memo = '$H_memo', post_date = '$H_post_date', upd_date = '$H_upd_date' WHERE code = '$staff_code'";
    $result_M2 = mysql_query($query_M2);
    if (!$result_M2) { error("QUERY_ERROR"); exit; }
	
	
	
	
	
	
	
	
	
	

  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member2.php?keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type'>");
  exit;

 
}

}
?>