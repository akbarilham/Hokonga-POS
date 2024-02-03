<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_client";

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
  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
<?
$query = "SELECT uid,branch_code,client_id,client_code,client_name,consign,associate,ceo_name,passwd,passwd2,cmt_about,cmt_cond,cmt_ctac,
		email,homepage,gatepage,phone1,phone2,phone_fax,phone_cell,addr1,addr2,zipcode,nationflag,
		photo1,photo2,userlevel,signdate,memo,web_flag,web_style,web_activate,db_name,db_gate,
		module_01,module_01_type,module_01B,module_02,module_03,module_04,module_05,module_06,module_07,module_08,module_09,module_10,
		module_11,module_98,module_99 FROM client WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$client_uid = $row->uid;
$branch_code = $row->branch_code;
$client_id = $row->client_id;
$client_code = $row->client_code;
$client_name = $row->client_name;
$consign = $row->consign;
$associate = $row->associate;
$ceo_name = $row->ceo_name;
$passwd = $row->passwd;
$passwd2 = $row->passwd2;
$cmt_about = $row->cmt_about;
$cmt_cond = $row->cmt_cond;
$cmt_ctac = $row->cmt_ctac;
$email = $row->email;
$homepage = $row->homepage;
$gatepage = $row->gatepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$zipcode = $row->zipcode;
$nationflag = $row->nationflag;
$userlevel = $row->userlevel;
$photo1 = $row->photo1;
$photo2 = $row->photo2;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row->memo;
$web_flag = $row->web_flag;
$web_style = $row->web_style;
$web_activate = $row->web_activate;
$db_name = $row->db_name;
$db_gate = $row->db_gate;

$sys_module_01 = $row->module_01;
$sys_module_01_type = $row->module_01_type;
$sys_module_01B = $row->module_01B;
$sys_module_02 = $row->module_02;
$sys_module_03 = $row->module_03;
$sys_module_04 = $row->module_04;
$sys_module_05 = $row->module_05;
$sys_module_06 = $row->module_06;
$sys_module_07 = $row->module_07;
$sys_module_08 = $row->module_08;
$sys_module_09 = $row->module_09;
$sys_module_10 = $row->module_10;
$sys_module_11 = $row->module_11;
$sys_module_98 = $row->module_98;
$sys_module_99 = $row->module_99;

if($sys_module_01 == "1") { $sys_module_01_chk = "checked"; } else { $sys_module_01_chk = ""; }
if($sys_module_01B == "1") { $sys_module_01B_chk = "checked"; } else { $sys_module_01B_chk = ""; }
if($sys_module_02 == "1") { $sys_module_02_chk = "checked"; } else { $sys_module_02_chk = ""; }
if($sys_module_03 == "1") { $sys_module_03_chk = "checked"; } else { $sys_module_03_chk = ""; }
if($sys_module_04 == "1") { $sys_module_04_chk = "checked"; } else { $sys_module_04_chk = ""; }
if($sys_module_05 == "1") { $sys_module_05_chk = "checked"; } else { $sys_module_05_chk = ""; }
if($sys_module_06 == "1") { $sys_module_06_chk = "checked"; } else { $sys_module_06_chk = ""; }
if($sys_module_07 == "1") { $sys_module_07_chk = "checked"; } else { $sys_module_07_chk = ""; }
if($sys_module_08 == "1") { $sys_module_08_chk = "checked"; } else { $sys_module_08_chk = ""; }
if($sys_module_09 == "1") { $sys_module_09_chk = "checked"; } else { $sys_module_09_chk = ""; }
if($sys_module_10 == "1") { $sys_module_10_chk = "checked"; } else { $sys_module_10_chk = ""; }
if($sys_module_11 == "1") { $sys_module_11_chk = "checked"; } else { $sys_module_11_chk = ""; }
if($sys_module_98 == "1") { $sys_module_98_chk = "checked"; } else { $sys_module_98_chk = ""; }
if($sys_module_99 == "1") { $sys_module_99_chk = "checked"; } else { $sys_module_99_chk = ""; }

if($sys_module_01_type == "1") {
	$sys_module_01_type_chk1 = "checked";
	$sys_module_01_type_chk2 = "";
} else if($sys_module_01_type == "2") {
	$sys_module_01_type_chk1 = "";
	$sys_module_01_type_chk2 = "checked";
} else {
	$sys_module_01_type_chk1 = "";
	$sys_module_01_type_chk2 = "checked";
}


// addslashes() 함수로 escape된 제목과 본문의 문자열을 원상복귀
$cmt_about = stripslashes($cmt_about);
$cmt_cond = stripslashes($cmt_cond);
$cmt_ctac = stripslashes($cmt_ctac);
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
$img1 = "client_{$client_id}_banner1.{$ext1}";
$img2 = "client_{$client_id}_banner2.{$ext2}";


// Website
if($web_flag == "1") {
	$web_flag_chk1 = "checked";
	$web_flag_chk0 = "";
} else {
	$web_flag_chk1 = "";
	$web_flag_chk0 = "checked";
}


// Web Style 정의
// 1/0 --- 1st: Default, 2nd: Shop, 3rd: Yellow Pages, 4rd: Multimedia
$style1 = substr($web_style,0,1);
$style2 = substr($web_style,1,1);
$style3 = substr($web_style,2,1);
$style4 = substr($web_style,3,1);

if($style1 == "1") {
  $style_chk1 = "checked";
} else {
  $style_chk1 = "";
}
if($style2 == "1") {
  $style_chk2 = "checked";
} else {
  $style_chk2 = "";
}
if($style3 == "1") {
  $style_chk3 = "checked";
} else {
  $style_chk3 = "";
}
if($style4 == "1") {
  $style_chk4 = "checked";
} else {
  $style_chk4 = "";
}

// Website Activation
if($web_activate == "1") {
	$web_activate_chk1 = "checked";
	$web_activate_chk0 = "";
} else {
	$web_activate_chk1 = "checked";
	$web_activate_chk0 = "";
}


if($consign == "1") {
	$consign_chk = "checked";
} else {
	$consign_chk = "";
}

if($associate == "1") {
	$associate_chk = "checked";
} else {
	$associate_chk = "";
}
?>

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_client_12?>
            <span class="tools pull-right">
                <a href="system_client_del.php?uid=<?=$client_uid?>" class="fa fa-trash-o"></a>
				<a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_client_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name="client_uid" value="<?=$client_uid?>">
								<input type='hidden' name="client_id" value="<?=$client_id?>">
								<input type='hidden' name="org_web_flag" value="<?=$web_flag?>">
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_03?></label>
                                        <div class="col-sm-9">
                                            <input readonly class="form-control" id="cname" name="id" value="<?=$client_id?>" type="id" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_02?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="client_code" value="<?=$client_code?>" maxlength="40" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
												
												if($menu_code == $branch_code) {
													$slc_gate = "selected";
												} else {
													$slc_gate = "";
												}
        
												echo("<option value='$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_01?></label>
                                        <div class="col-sm-5">
                                            <input class="form-control" id="cname" name="client_name" value="<?=$client_name?>" maxlength="60" type="text" required />
											
                                        </div>
										<div class="col-sm-4">
											<?
											if($userlevel == "5") {
												echo ("<input type=checkbox name='associate' value='1' $associate_chk> $txt_sys_shop_073");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-3">
                                            <input type="checkbox" name="sys_module_01" value="1" <?=$sys_module_01_chk?>> <?echo("$title_module_01")?>
											<br>&nbsp;&nbsp; &nbsp;&nbsp; 
											<input type="radio" name="sys_module_01_type" value="1" <?=$sys_module_01_type_chk1?>> <?=$title_module_01_type1?> &nbsp;&nbsp; 
											<input type="radio" name="sys_module_01_type" value="2" <?=$sys_module_01_type_chk2?>> <?=$title_module_01_type2?>
											
											<br><input type="checkbox" name="sys_module_01B" value="1" <?=$sys_module_01B_chk?>> <?echo("$title_module_01B")?>
											<br><input type="checkbox" name="sys_module_02" value="1" <?=$sys_module_02_chk?>> <?echo("$title_module_02")?>
											<br><input type="checkbox" name="sys_module_03" value="1" <?=$sys_module_03_chk?>> <?echo("$title_module_03")?>
											<br><input type="checkbox" name="sys_module_04" value="1" <?=$sys_module_04_chk?>> <?echo("$title_module_04")?>
                                        </div>
										<div class="col-sm-3">
                                            <input disabled type="checkbox" name="sys_module_05" value="1" <?=$sys_module_05_chk?>> <?echo("$title_module_05")?>
											<br><input disabled type="checkbox" name="sys_module_06" value="1" <?=$sys_module_06_chk?>> <?echo("$title_module_06")?>
											<br><input type="checkbox" name="sys_module_07" value="1" <?=$sys_module_07_chk?>> <?echo("$title_module_07")?>
                                        </div>
										<div class="col-sm-3">
                                            <input type="checkbox" name="sys_module_08" value="1" <?=$sys_module_08_chk?>> <?echo("$title_module_08")?>
											<br><input type="checkbox" name="sys_module_09" value="1" <?=$sys_module_09_chk?>> <?echo("$title_module_09")?>
											<br><input type="checkbox" name="sys_module_10" value="1" <?=$sys_module_10_chk?>> <?echo("$title_module_10")?>
											<br><input type="checkbox" name="sys_module_11" value="1" <?=$sys_module_11_chk?>> <?echo("$title_module_11")?>
											<? if($login_level > "8") { ?>
											<br><input type="checkbox" name="sys_module_98" value="1" <?=$sys_module_98_chk?>> <?echo("$title_module_98")?>
											<br><input type="checkbox" name="sys_module_99" value="1" <?=$sys_module_99_chk?>> <?echo("$title_module_99")?>
											<? } ?>
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="ceo_name" value="<?=$ceo_name?>" maxlength="60" type="text" required />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" value="<?=$email?>" maxlength="120" type="email" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Website Publishing</label>
                                        <div class="col-sm-9">
											<? if($web_flag == "1") { ?>
                                            <input type="radio" name="web_flag" value="1" <?=$web_flag_chk1?>> <font color=#006699>Published</font> &nbsp;&nbsp; 
											<input disabled type="radio" name="web_flag" value="0" <?=$web_flag_chk0?>> Remove
											<? } else { ?>
											<input type="radio" name="web_flag" value="1" <?=$web_flag_chk1?>> <font color=#006699>Publish now</font> &nbsp;&nbsp; 
											<input type="radio" name="web_flag" value="0" <?=$web_flag_chk0?>> Don't need Website
											<? } ?>
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Gate Page</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="gatepage" value="<?=$gatepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Office)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone1" value="<?=$phone1?>" maxlength="60" type="tel" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">TEL (Home)</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ctel" name="phone2" value="<?=$phone2?>" maxlength="60" type="tel" />
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
                                            <input class="form-control" id="ctel" name="phone_cell" value="<?=$phone_cell?>" maxlength="60" type="tel" />
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_04?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Closed</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Closed</font> &nbsp;");
											}

	
											if(!strcmp($userlevel,"2")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\" CHECKED> Shop Management &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"2\"> Shop Management &nbsp;");
											}
   
											if(!strcmp($userlevel,"3")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\" CHECKED> Branch &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\"> Branch &nbsp;");
											}
   
											if(!strcmp($userlevel,"4")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"4\" CHECKED> Region / Dep't &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"4\"> Region / Dep't &nbsp;");
											}
   
											if(!strcmp($userlevel,"5")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\" CHECKED> Division &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\"> Division &nbsp;");
											}
											
											if(!strcmp($userlevel,"6")) {
												echo("<br><input type=\"radio\" name=\"userlevel\" value=\"6\" CHECKED> Inventory &nbsp;");
											} else {
												echo("<br><input type=\"radio\" name=\"userlevel\" value=\"6\"> Inventory &nbsp;");
											}
   
   
											if($login_level > "6") {
											if(!strcmp($userlevel,"7")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\" CHECKED> Corporate &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"7\"> Corporate &nbsp;");
											}
											if(!strcmp($userlevel,"8")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"8\" CHECKED> <font color=#777777>Group H.Q.</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"8\"> <font color=#777777>Group H.Q.</font> &nbsp;");
											}
											}
											
											if($login_level > "8") {
											if(!strcmp($userlevel,"9")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"9\" CHECKED> <font color=#777777>EIS</font>");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"9\"> <font color=#777777>EIS</font>");
											}
											}
											?>
                                            
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3"><?=$txt_sys_client_23?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="cmt_about"><?echo("$cmt_about")?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3"><?=$txt_sys_client_24?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="cmt_cond"><?echo("$cmt_cond")?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cmemo" class="control-label col-sm-3"><?=$txt_sys_client_25?></label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cmemo" name="cmt_ctac"><?echo("$cmt_ctac")?></textarea>
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
										<div class="col-sm-5"></div>
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

	

	if(!$consign) {
		$consign = "0";
	}
	if(!$associate) {
		$associate = "0";
	}

  // 비밀번호가 일치한지 검사(변경시에만)
  if(!$pw_upd) {
	  $pw_upd == "0";
  }

  if($pw_upd == "1") {
	  if($pw1 != $pw2){
	    error("INVALID_TWO_PASSWD");
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
  
  if(!$sys_module_01) { $sys_module_01 = "0"; }
  if(!$sys_module_01B) { $sys_module_01B = "0"; }
  if(!$sys_module_02) { $sys_module_02 = "0"; }
  if(!$sys_module_03) { $sys_module_03 = "0"; }
  if(!$sys_module_04) { $sys_module_04 = "0"; }
  if(!$sys_module_05) { $sys_module_05 = "0"; }
  if(!$sys_module_06) { $sys_module_06 = "0"; }
  if(!$sys_module_07) { $sys_module_07 = "0"; }
  if(!$sys_module_08) { $sys_module_08 = "0"; }
  if(!$sys_module_09) { $sys_module_09 = "0"; }
  if(!$sys_module_10) { $sys_module_10 = "0"; }
  if(!$sys_module_11) { $sys_module_11 = "0"; }
  if(!$sys_module_98) { $sys_module_98 = "0"; }
  if(!$sys_module_99) { $sys_module_99 = "0"; }
  
  
  $cmt_about = addslashes($cmt_about);
  $cmt_cond = addslashes($cmt_cond);
  $cmt_ctac = addslashes($cmt_ctac);
  $memo = addslashes($memo);
  
  
  $chn_file_dir = "home"; // Website Account Root Directory
  
  
	// Website Publishing
	if(!$web_flag) { $web_flag = "0"; }
	
	if($org_web_flag == "0" AND $web_flag == "1") {
	
		// Duplication Check
		$result = mysql_query("SELECT count(client_id) FROM client WHERE client_id = '$id' AND web_flag = '1'");
		if (!$result) {
			error("QUERY_ERROR");
			exit;
		}
		$rows = @mysql_result($result,0,0);
		if ($rows) {
		?>
		
			<script language="javascript">
			alert("Your submission of website account already exists!");
			</script>
		
		<?
		} else {
  
			// Account Directory
			mkdir("$chn_file_dir/$client_id",0660);
			chmod("$chn_file_dir/$client_id",0777);
	
			mkdir("$chn_file_dir/$client_id/user_file",0660);
			chmod("$chn_file_dir/$client_id/user_file",0777);
		
		}
  
  
	}
  

  // 정보 변경
  if($userlevel == "5") {
	$query_con = "UPDATE client SET associate = '$associate' WHERE uid = '$client_uid'"; 
	$result_con = mysql_query($query_con);
	if(!$result_con) { error("QUERY_ERROR"); exit; }
  }
  
  if($pw_upd == "1") {
    $query  = "UPDATE client SET client_code = '$client_code', client_name = '$client_name', ceo_name = '$ceo_name', 
            branch_code = '$branch_code', email = '$email', homepage = '$homepage', gatepage = '$gatepage', zipcode = '$zipcode', 
            addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', 
            phone_cell = '$phone_cell', cmt_about = '$cmt_about', cmt_cond = '$cmt_cond', cmt_ctac = '$cmt_ctac', 
            memo = '$memo', userlevel = '$userlevel', db_name = '$db_name', db_gate = '$db_gate', web_flag = '$web_flag', 
            passwd = password('$pw'), passwd2 = '$pw', module_01_type = '$sys_module_01_type', module_01B = '$sys_module_01B', 
			module_01 = '$sys_module_01', module_02 = '$sys_module_02', module_03 = '$sys_module_03', module_04 = '$sys_module_04', module_05 = '$sys_module_05', 
			module_06 = '$sys_module_06', module_07 = '$sys_module_07', module_08 = '$sys_module_08', module_09 = '$sys_module_09', module_10 = '$sys_module_10', 
			module_11 = '$sys_module_11', module_98 = '$sys_module_98', module_99 = '$sys_module_99' WHERE uid = '$client_uid'"; 
  } else {
    $query  = "UPDATE client SET client_code = '$client_code', client_name = '$client_name', ceo_name = '$ceo_name', 
            branch_code = '$branch_code', email = '$email', homepage = '$homepage', gatepage = '$gatepage', zipcode = '$zipcode', 
            addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', 
            phone_cell = '$phone_cell', cmt_about = '$cmt_about', cmt_cond = '$cmt_cond', cmt_ctac = '$cmt_ctac', 
            memo = '$memo', userlevel = '$userlevel', db_name = '$db_name', db_gate = '$db_gate', web_flag = '$web_flag', 
			module_01_type = '$sys_module_01_type', module_01B = '$sys_module_01B', 
			module_01 = '$sys_module_01', module_02 = '$sys_module_02', module_03 = '$sys_module_03', module_04 = '$sys_module_04', module_05 = '$sys_module_05', 
			module_06 = '$sys_module_06', module_07 = '$sys_module_07', module_08 = '$sys_module_08', module_09 = '$sys_module_09', module_10 = '$sys_module_10', 
			module_11 = '$sys_module_11', module_98 = '$sys_module_98', module_99 = '$sys_module_99' WHERE uid = '$client_uid'"; 
  }
  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_client.php'>");
  exit;
  
 

}

}
?>