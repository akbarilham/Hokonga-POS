<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member";

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
          birthday,calendar,gender,email,homepage,job,corp_name,corp_dept,corp_title,corp_desc,
          zipcode,addr1,addr2,phone,phone_cel,phone_fax,mlist,m_ip,memo,userlevel,signdate,paydate,
          shop_point,counter,country_code,mb_type,reseller,photo1,photo2,crmflag,log_in,log_out,
          visit,lang,bank_name,acct_name,acct_no,uncoll FROM member_main WHERE uid = '$uid'";

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
$uncoll = $row->uncoll;
  if($uncoll == "1") {
    $uncoll_chk = "checked";
  } else {
    $uncoll_chk = "";
  }

$memo = stripslashes($memo);
$corp_desc = stripslashes($corp_desc);

// 이미지 확장자
if($photo1 == "1") {
	$ext1 = "jpg";
} else if($photo1 == "2") {
	$ext1 = "gif";
} else if($photo1 == "3") {
	$ext1 = "swf";
}
if($photo2 == "1") {
	$ext2 = "jpg";
} else if($photo2 == "2") {
	$ext2 = "gif";
} else if($photo2 == "3") {
	$ext2 = "swf";
}

// 이미지 경로 및 파일명
$savedir = "user_file";
$img1 = "staff_{$client_id}_photo1.{$ext1}";
$img2 = "staff_{$client_id}_photo2.{$ext2}";
?>

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_stf_member_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="crm_member_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='staff_uid' value='<?=$staff_uid?>'>
								<input type='hidden' name='org_name' value='<?=$user_name?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
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
											if($now_group_admin == "1" OR $login_level > "3") {
												echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");
											}

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($branch_code == $user_branch_code) {
													$slc_brc = "selected";
												} else {
													$slc_brc = "";
												}
        
												echo("<option value='$branch_code' $slc_brc>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_06?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="user_id" value='<?=$user_id?>' maxlength="12" type="id" />
                                        </div>
										
										<div class="col-sm-1">Password</div>
										<div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="user_passwd2" value='<?=$user_passwd2?>' maxlength="12" type="text" />
                                        </div>
										<div class="col-sm-4">&gt; <?=$txt_stf_member_09?> : <?=$sync_on_txt?></div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_05?></label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="user_code" value='<?=$user_code?>' maxlength="12" type="id" />
                                        </div>
                                    </div>
									
									
									<? if($mb_type > "0") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="new_name" value="<?=$user_name?>" type="text" required />
                                        </div>
                                    </div>
									
									<? } else { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_staff_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="new_name" value="<?=$user_name?>" type="text" required />
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
									
									<? } ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_13?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" name="shop_point" value="<?=$shop_point?>" type="text" />
                                        </div>
										<div class="col-sm-7">
                                            <input type=radio name='reseller' value='0' <?=$reseller_chk0?>> <?=$txt_stf_member_15?> &nbsp;&nbsp; 
											<input type=radio name='reseller' value='1' <?=$reseller_chk1?>> <font color=red><?=$txt_stf_member_14?></font>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_16?></label>
										<div class="col-sm-9">
                                            <input type=radio name='mlist' value='1' <?=$mlist_chk1?>> <?=$txt_stf_member_17?> &nbsp;&nbsp; 
											<input type=radio name='mlist' value='0' <?=$mlist_chk0?>> <?=$txt_stf_member_18?>
                                        </div>
                                    </div>
									
									
									<? if($mb_type == "0") { ?>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_stf_member_08?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="corp_name" value="<?=$corp_name?>" type="text" />
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
									
									<? } ?>
									
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm08?>">
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

	
	$query  = "DELETE FROM member_main WHERE uid = '$staff_uid'"; 
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member.php?keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type'>");
  exit;

}

}
?>