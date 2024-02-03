<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "hr";
$smenu = "hr_member";

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
$query = "SELECT uid,branch_code,gate,name,name2,code,id,birthday,calendar,gender,
          email,homepage,corp_name,corp_dept,corp_title,zipcode,addr1,addr2,phone,phone_cel,phone_fax,
          memo,userlevel,signdate,photo1,photo2 FROM member_staff WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$staff_uid = $row->uid;
$branch_code = $row->branch_code;
$user_gate = $row->gate;
$user_name = $row->name;
$user_name2 = $row->name2;
$user_code = $row->code;
$user_id = $row->id;
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
$corp_name = $row->corp_name;
$corp_dept = $row->corp_dept;
$corp_title = $row->corp_title;
$zipcode = $row->zipcode;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$phone = $row->phone;
$phone_cel = $row->phone_cel;
$phone_fax = $row->phone_fax;
$memo = $row->memo;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$photo1 = $row->photo1;
$photo2 = $row->photo2;

$memo = stripslashes($memo);


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
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_stf_member_04?>
            <span class="tools pull-right">
				<a href="<?echo("$hr_member_del_link")?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="hr_member_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type='hidden' name='step_next_form' value='basic'>
								<input type='hidden' name='tab' value='$tab'>
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='staff_uid' value='<?=$staff_uid?>'>
								<input type='hidden' name='staff_id' value='<?=$user_id?>'>
								<input type='hidden' name='org_name' value='<?=$user_name?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_code' value='<?=$user_code?>'>
								<input type='hidden' name='hr_type' value='<?=$hr_type?>'>
								<input type='hidden' name='hr_retire' value='<?=$hr_retire?>'>
								
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm24?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryE = "SELECT count(uid) FROM client WHERE userlevel > '0'";
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											$queryF = "SELECT client_id,client_name FROM client WHERE userlevel > '0' ORDER BY client_code ASC";
											$resultF = mysql_query($queryF);

											echo("<select name='user_gate' class='form-control'>");
											echo("<option value=\"\">:: $txt_stf_member_chk01</option>");

											for($i = 0; $i < $total_recordE; $i++) {
												$client_id = mysql_result($resultF,$i,0);
												$client_name = mysql_result($resultF,$i,1);
												
												if($client_id == $user_gate) {
													$slc_gateF = "selected";
													$slc_disableF = "";
												} else {
													$slc_gateF = "";
													$slc_disableF = "disabled";
												}
        
												echo("<option value='$client_id' $slc_gateF>&nbsp; $client_name [ $client_id ]</option>");
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


  $query = "DELETE FROM member_staff WHERE uid = '$staff_uid'"; 
  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }
  
	$query2 = "DELETE FROM admin_user WHERE user_id = '$staff_id' AND staff_sync = '1'"; 
	$result2 = mysql_query($query2);
	if(!$result2) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/hr_member.php?keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type&hr_type=$hr_type&hr_retire=$hr_retire&hr_temp=$hr_temp'>");
  exit;
  
}

}
?>