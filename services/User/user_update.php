<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "user";
$smenu = "user_update";


if(!$step_next) {

$query = "SELECT uid,gate,user_id,user_level,user_name,user_email,user_website,default_lang,signdate,
          log_ip,log_in,log_out,visit FROM admin_user WHERE user_id = '$login_id'";
$result = mysql_query($query);

   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
$user_id = $row->user_id;
$userlevel = $row->user_level;
$user_name = $row->user_name;
$user_email = $row->user_email;
$homepage = $row->user_website;
$default_lang = $row->default_lang;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",strtotime($signdate));	
  } else {
    $signdates = date("d-m-Y, H:i:s",strtotime($signdate));	
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



// Staff Information
$query2 = "SELECT uid,branch_code,code,name,birthday,gender,email,zipcode,addr1,addr2,phone,phone_cel,phone_fax,counter,country_code,mb_type,
		photo1,log_in,log_out,visit,lang,bank_name,acct_name,acct_no,nationality_code,visa_type,passport_no,passport_expire,
        marital_status,spouse_name,fam_head,dir1_code,dir2_code,dir3_code,group1_code,group2_code,group3_code,regis_date,upd_date,
		religion,idcard_no,fam_child,memo FROM member_staff WHERE id = '$user_id'";
$result2 = mysql_query($query2);
if(!$result2) {      
   error("QUERY_ERROR");
   exit;
}
   $row2 = mysql_fetch_array($result2);

$staff_uid = $row2["uid"];
$user_branch_code = $row2["branch_code"];
$user_code = $row2["code"];
$user_name2 = $row2["name"];
$birth_date = $row2["birthday"];
  $birthyear = substr($birth_date,0,4);
  $birthmonth = substr($birth_date,4,2);
    $birthmonth1 = substr($birth_date,4,1);
    $birthmonth2 = substr($birth_date,5,1);
  $birthday = substr($birth_date,6,2);
    $birthday1 = substr($birth_date,6,1);
    $birthday2 = substr($birth_date,7,1);
  $birth_dates = "$birthyear"."-"."$birthmonth"."-"."$birthday";
  
  if($lang == "ko") {
	  $birth_dates_txt = "$birthyear"."/"."$birthmonth"."/"."$birthday";
  } else {
	  $birth_dates_txt = "$birthday"."-"."$birthmonth"."-"."$birthyear";
  }
  
$user_gender = $row2["gender"];
  if($user_gender == "M") {
    $user_gender_chkM = "checked";
    $user_gender_chkF = "";
  } else if($user_gender == "F") {
    $user_gender_chkM = "";
    $user_gender_chkF = "checked";
  }
$user_email2 = $row2["email"];
$zipcode = $row2["zipcode"];
$addr1 = $row2["addr1"];
$addr2 = $row2["addr2"];
$phone = $row2["phone"];
$phone_cel = $row2["phone_cel"];
$phone_fax = $row2["phone_fax"];
$counter = $row2["counter"];
$mb_type = $row2["mb_type"];

$photo1 = $row2["photo1"];
$log_in = $row2["log_in"];
$log_out = $row2["log_out"];
$visit = $row2["visit"];
$join_lang = $row2["lang"];
$bank_name = $row2["bank_name"];
$acct_name = $row2["acct_name"];
$acct_no = $row2["acct_no"];
$nationality_code = $row2["nationality_code"];
if($nationality_code == "in") {
    $nationality_code_chk_in = "selected";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "ml") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "selected";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "sg") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "selected";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "au") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "selected";
    $nationality_code_chk_ko = "";
  } else if($nationality_code == "ko") {
    $nationality_code_chk_in = "";
    $nationality_code_chk_ml = "";
    $nationality_code_chk_sg = "";
    $nationality_code_chk_au = "";
    $nationality_code_chk_ko = "selected";
  }
$visa_type = $row2["visa_type"];
$passport_no = $row2["passport_no"];
$passport_expire = $row2["passport_expire"];
$spouse_name = $row2["spouse_name"];
$dir1_code = $row2["dir1_code"];
$dir2_code = $row2["dir2_code"];
$dir3_code = $row2["dir3_code"];
$group1_code = $row2["group1_code"];
$group2_code = $row2["group2_code"];
$group3_code = $row2["group3_code"];
$regis_date = $row2["regis_date"];
  $regisyear = substr($regis_date,0,4);
  $regismonth = substr($regis_date,4,2);
    $regismonth1 = substr($regis_date,4,1);
    $regismonth2 = substr($regis_date,5,1);
  $regisday = substr($regis_date,6,2);
    $regisday1 = substr($regis_date,6,1);
    $regisday2 = substr($regis_date,7,1);
  
  if($regismonth1 == "0") {
    $regis_m = $regismonth2;
  } else {
    $regis_m = $regismonth;
  }
  if($regisday1 == "0") {
    $regis_d = $regisday2;
  } else {
    $regis_d = $regisday;
  }
$upd_date = $row2["upd_date"];

    $uday1 = substr($upd_date,0,4);
	  $uday2 = substr($upd_date,4,2);
	  $uday3 = substr($upd_date,6,2);
	  $uday4 = substr($upd_date,8,2);
	  $uday5 = substr($upd_date,10,2);
	  $uday6 = substr($upd_date,12,2);

    if($lang == "ko") {
	    $upd_date_txt = "$uday1"."/"."$uday2"."/"."$uday3".", "."$uday4".":"."$uday5".":"."$uday6";
	  } else {
	    $upd_date_txt = "$uday3"."-"."$uday2"."-"."$uday1".", "."$uday4".":"."$uday5".":"."$uday6";
	  }

$fam_child = $row2["fam_child"];
$memo = $row2["memo"];
	$memo2 = nl2br($memo);


if($photo1 == "none") {
    $staff_photo_img1 = "img/User_Photo_"."$user_gender".".png";
    $staff_photo_img1_txt = "";
} else {
    $staff_photo_img1 = "user_file/$photo1";
    $staff_photo_img1_txt = "<font color=blue>O</font>";
}

// My Age

$my_age = $post_year - $birthyear;
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Church, Bootstrap, Responsive">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
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
  </head>

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <aside class="profile-nav col-lg-3">
                      <section class="panel">
                          <div class="user-heading round">
							  <a href="#">
								<img src="<?=$staff_photo_img1?>">
                              </a>
                              <h1><?=$user_name?></h1>
                              <p><?=$user_email?></p>
                          </div>

                          <ul class="nav nav-pills nav-stacked">
								<li class="active"><a href="user_update.php"> <i class="fa fa-edit"></i> Edit profile</a></li>
                          </ul>

                      </section>
                  </aside>
                  <aside class="profile-info col-lg-9">
                      <section class="panel">
                          <div class="bio-graph-heading">
                              <?echo("$memo2")?>
                          </div>
                          <div class="panel-body bio-graph-info">
                              
                              <div class="row">
								  <? echo ("
                                  <div class='bio-row'>
                                      <p><span>$txt_stf_staff_08 </span>: $user_name</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_ch_member_05 </span>: $user_code</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_stf_staff_12</span>: $birth_dates_txt</p>
                                  </div>
                                  <div class='bio-row'>
                                      <p><span>$txt_sys_client_09 </span>: $phone_cel</p>
                                  </div>");
								  ?>
                              </div>
                          </div>
                      </section>
                      

					  
					  <section class="panel">

                          <header class="panel-heading">
							<?=$txt_stf_member_03?>
							<span class="tools pull-right">
								<a href="javascript:;" class="fa fa-chevron-down"></a>
							</span>
						  </header>
						  
                          <div class="panel-body bio-graph-info">
                              
								<form name='updform1' class="form-horizontal" method='post' ENCTYPE='multipart/form-data' action='user_update.php'>
								<input type="hidden" name="step_next" value="permit_update1">
								<input type="hidden" name="admin_uid" value="<?=$user_uid?>">
								<input type="hidden" name="staff_uid" value="<?=$staff_uid?>">
								

								  <? 
                     echo ("
                                  <div class='form-group'>
                                      <label  class='col-sm-3 control-label'>$frn1_mmenu_12</label>
                                      <div class='col-sm-3'>
                                          <input disabled type='text' class='form-control' id='l-name' name='user_id' value='$user_id'>
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-3 control-label'>$txt_stf_staff_08</label>
                                      <div class='col-sm-3'>
                                          <input disabled type='text' class='form-control' id='l-name' name='new_name' value='$user_name2'>
                                      </div>
									  <div class='col-sm-6'>
											<input disabled type=radio name='gender' value='M' $user_gender_chkM> $txt_stf_staff_10 &nbsp;&nbsp;
											<input disabled type=radio name='gender' value='F' $user_gender_chkF> $txt_stf_staff_11
                                      </div>
                                  </div>
								  
								  <div class='form-group'>
                                      <label  class='col-sm-3 control-label'>$txt_stf_staff_12</label>
                                      <div class='col-sm-3'>
                                          <input type='date' class='form-control' id='l-name' name='user_birthdates' value='$birth_dates'>
                                      </div>
									  <div class='col-sm-3'></div>
                                  </div>
								  
								  <div class='form-group'>
									<label class='col-sm-3 control-label'>E-mail</label>
									<div class='col-sm-9'>
										<input type='email' class='form-control' id='l-name' name='user_email' value='$user_email'>
									</div>
								  </div>
								  
								  <div class='form-group'>
									<label class='col-sm-3 control-label'>Memo</label>
									<div class='col-sm-9'>
										<textarea class='form-control' id='l-name' name='memo'>$memo</textarea>
									</div>
								  </div>
								  
								  
								  <div class='form-group'>
                                      <label class='col-sm-3 control-label'>$txt_sys_client_06</label>
                                      <div class='col-sm-3'>
											<input disabled type='date' class='form-control' id='l-name' name='regis_date' value='$regis_date'>
                                      </div>
                                  </div>
								  
								  
								  <div class='form-group'>
                                      <div class='col-sm-offset-3 col-sm-9'>
                                          <input type='submit' class='btn btn-success' value='$txt_comm_frm05'>
                                      </div>
                                  </div>
                                  ");
								  ?>
                              </form>

					  </div>
                      </section>
					  
					  
					  
					  <section>
                          <div class="panel panel-primary">
                              <div class="panel-heading"> Sets New Password & Avatar</div>
                              <div class="panel-body">
							  
									<form name='updform2' class="form-horizontal" method='post' ENCTYPE='multipart/form-data' action='user_update.php'>
									<input type="hidden" name="step_next" value="permit_update2">
									<input type="hidden" name="admin_uid" value="<?=$user_uid?>">
									<input type="hidden" name="staff_uid" value="<?=$staff_uid?>">
								
                                      <div class="form-group">
                                          <label  class="col-sm-3 control-label">New Password</label>
                                          <div class="col-sm-3">
                                              <input type="password" class="form-control" id="n-pwd" name="new_pwd1" placeholder=" ">
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label  class="col-sm-3 control-label">Re-type New Password</label>
                                          <div class="col-sm-3">
                                              <input type="password" class="form-control" id="rt-pwd" name="new_pwd2" placeholder=" ">
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label  class="col-sm-3 control-label">Change Avatar</label>
                                          <div class="col-sm-6">
                                              <input type="file" class="file-pos" id="exampleInputFile" name="photofile1">
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <div class="col-sm-offset-3 col-lg-9">
                                              <input type='submit' class='btn btn-success' value='<?=$txt_comm_frm05?>'>
                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </section>

					  
                  </aside>
              </div>

              <!-- page end-->
          </section>
      </section>
      <!--main content end-->

      <? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

  <script>

      //knob
      $(".knob").knob();

  </script>


  </body>
</html>


<?
} else if($step_next == "permit_update1") {
	
  $signdate = time();
  $post_year = date("Y",$signdate);
  $post_date1 = date("Ymd",$signdate);
    $post_date1s = date("Y-m-d",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  $m_ip = getenv('REMOTE_ADDR');

	$birthday_exp = explode("-",$user_birthdates);
	$birth1 = $birthday_exp[0];
	$birth2 = $birthday_exp[1];
	$birth3 = $birthday_exp[2];
	
	$birth_date = "$birth1"."$birth2"."$birth3";
	
 
	$memo = addslashes($memo);

   	    
   	    $query_P1 = "UPDATE member_staff SET birthday = '$birth_date', email = '$user_email', memo = '$memo' WHERE uid = '$staff_uid'";
        $result_P1 = mysql_query($query_P1);
        if (!$result_P1) { error("QUERY_ERROR"); exit; }
		
		$query_P2 = "UPDATE admin_user SET user_email = '$user_email' WHERE uid = '$admin_uid'";
        $result_P2 = mysql_query($query_P2);
        if (!$result_P2) { error("QUERY_ERROR"); exit; }
    

  echo("<meta http-equiv='Refresh' content='0; URL=$home/user_update.php'>");
  exit;


  
} else if($step_next == "permit_update2") {
	

	$savedir = "user_file";
	
	if($photofile1 != "") {

			  $full_filename1 = explode(".", "$photofile1_name");
			  $extension1 = $full_filename1[sizeof($full_filename1)-1];	   
	
			  if(strcmp($extension1,"jpg") AND 
			    strcmp($extension1,"JPG") AND 
			    strcmp($extension1,"jpeg") AND 
			    strcmp($extension1,"JPEG") AND 
			    strcmp($extension1,"gif") AND 
				strcmp($extension1,"GIF") AND 
			    strcmp($extension1,"png") AND 
			    strcmp($extension1,"PNG")) 
			  { 
			    error("NO_ACCESS_UPLOAD");
			    exit;
			  }

			  $new_filename1 = "photo_"."$mb_code"."_A."."$extension1";


        if($photofile1 != "") {
			    if(!copy("$photofile1","$savedir/$photofile1_name")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
			    if(!rename("$savedir/$photofile1_name","$savedir/$new_filename1")) {
			      error("UPLOAD_COPY_FAILURE");
			      exit;
			    }
   	    }
   	    
   	    $query_P1  = "UPDATE member_staff SET photo1 = '$new_filename1' WHERE uid = '$staff_uid'";
        $result_P1 = mysql_query($query_P1);
        if (!$result_P1) { error("QUERY_ERROR"); exit; }
    
	}
	
	
	$query_opwd = "SELECT user_pw FROM admin_user WHERE uid = '$admin_uid'";
    $result_opwd = mysql_query($query_opwd);
      if (!$result_opwd) { error("QUERY_ERROR"); exit; }   
    $org_pwd = @mysql_result($result_opwd,0,0);
	
	
	if($new_pwd1 != $new_pwd2){
	    popup_msg("$txt_sys_user_chk03");
	    break;
	} else {
	    $new_pwd = "$new_pwd1";
	}
	
	if(!ereg("[[:alnum:]+]{4,12}",$new_pwd1)) {
	    error("INVALID_PASSWD");
	    exit;
	}
	
	

	
/*		$query_pw1 = "UPDATE member_staff SET passwd = old_password('$new_pwd'), passwd2 = '$new_pwd' WHERE uid = '$admin_uid'"; 
		$result_pw1 = mysql_query($query_pw1);
		if(!$result_pw1) { error("QUERY_ERROR"); exit; }*/
		
		$query_pw2 = "UPDATE admin_user SET user_pw = old_password('$new_pwd'), user_pw2 = '$new_pwd' WHERE uid = '$admin_uid'"; 
		$result_pw2 = mysql_query($query_pw2);
		if(!$result_pw2) { error("QUERY_ERROR"); exit; }

	
	

  echo("<meta http-equiv='Refresh' content='0; URL=$home/user_update.php'>");
  exit;

}

}
?>