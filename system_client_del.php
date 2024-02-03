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
          photo1,photo2,userlevel,signdate,memo,web_style,web_activate,db_name,db_gate FROM client WHERE uid = '$uid'";

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
$web_style = $row->web_style;
$web_activate = $row->web_activate;
$db_name = $row->db_name;
$db_gate = $row->db_gate;


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

// Web Style 정의
// 1/0 --- 1st: Shop, 2nd: Tour, 3rd: Yellow Page, 4rd: Livecast
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
            <?=$txt_sys_client_13?>
            <span class="tools pull-right">
				<a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_client_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name="client_uid" value="<?=$client_uid?>">
								
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="ceo_name" value="<?=$ceo_name?>" maxlength="60" type="text" />
                                        </div>
                                    </div>
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" value="<?=$email?>" maxlength="120" type="email" name="email"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" value="<?=$homepage?>" maxlength="120" type="url" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Gate Page</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="gatepage" value="<?=$gatepage?>" maxlength="120" type="url" />
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

	

  $query  = "DELETE FROM client WHERE uid = '$client_uid'"; 
  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_client.php'>");
  exit;
  
 

}

}
?>