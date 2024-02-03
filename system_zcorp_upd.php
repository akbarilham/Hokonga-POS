<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_zcorp";

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
$query = "SELECT uid,branch_code,branch_name,branch_name2,branch_type,ceo_name,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,img1,prd_code FROM client_branch WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$branch_code = $row->branch_code;
$branch_name = $row->branch_name;
$branch_name2 = $row->branch_name2;
$branch_type = $row->branch_type;
$ceo_name = $row->ceo_name;
$email = $row->email;
$homepage = $row->homepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$zipcode = $row->zipcode;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row->memo;
$photo1 = $row->img1;
$prd_code = $row->prd_code;

if($prd_code == "1") {
  $prd_code_chk = "checked";
} else {
  $prd_code_chk = "";
}

$savedir = "user_file";
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Corporate Account
            <span class="tools pull-right">
				<a href="system_zcorp_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="system_zcorp_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='org_branch_code' value='<?=$branch_code?>'>
								<input type='hidden' name='org_photo1' value='<?=$photo1?>'>
								
                                    									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Code</label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="dis_branch_code" value="<?=$branch_code?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Name</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cname" name="branch_name" value="<?=$branch_name?>" type="text" required />
                                        </div>
										<div class="col-sm-3">
                                            <input class="form-control" id="cname" name="branch_name2" value="<?=$branch_name2?>" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Logo</label>
                                        <div class="col-sm-9">
                                            <?
											if($photo1 != "") {
												echo ("<img src='$savedir/$photo1' border=0>");
											} else {
												echo ("<input disabled type=text name='dis_photo1' value='No Image' class='form-control'>");
											}
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Executive</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="ceo_name" value="<?=$ceo_name?>" type="text" />
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
                                        <label for="cname" class="control-label col-sm-3">Business Type</label>
                                        <div class="col-sm-9">
                                            <?
											if(!strcmp($branch_type,"1")) {
												echo("<input type=\"radio\" name=\"branch_type\" value=\"1\" CHECKED> General &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"branch_type\" value=\"1\"> General &nbsp;");
											}

											if(!strcmp($branch_type,"2")) {
												echo("<input type=\"radio\" name=\"branch_type\" value=\"2\" CHECKED> <font color=blue>Outsourcing</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"branch_type\" value=\"2\"> <font color=blue>Outsourcing</font> &nbsp;");
											}

											echo("
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
											<input type=checkbox name='new_prd_code' value='1' $prd_code_chk> <font color=red>Orginal Provider Code Entry Needed</font>");
											?>
  
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_shop_09?></label>
                                        <div class="col-sm-9">
											<?
											if(!strcmp($userlevel,"0")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Closed</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Closed</font> &nbsp;");
											}

											if(!strcmp($userlevel,"1")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\" CHECKED> In Process &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"1\"> In Process &nbsp;");
											}
   
											if(!strcmp($userlevel,"3")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\" CHECKED> <font color=blue>Corporate</font> &nbsp;");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"3\"> <font color=blue>Corporate</font> &nbsp;");
											}
   
											if(!strcmp($userlevel,"5")) {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\" CHECKED> Head Quarter");
											} else {
												echo("<input type=\"radio\" name=\"userlevel\" value=\"5\"> Head Quarter");
											}
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Logo File</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cfile" name="photo1" type="file" />
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


	$savedir = "user_file";

  if($photo1 != "") {

			$full_filename1 = explode(".", "$photo1_name");
			$extension1 = $full_filename1[sizeof($full_filename1)-1];
	
			if(strcmp($extension1,"JPG") AND 
			   strcmp($extension1,"jpg") AND
			   strcmp($extension1,"GIF") AND
			   strcmp($extension1,"gif") AND
			   strcmp($extension1,"PNG") AND
			   strcmp($extension1,"png")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}

      $new_filename1 = "logo_"."$org_branch_code"."_1.{$extension1}";

      if($org_photo1 != "") {
        if(!unlink("$savedir/$org_photo1")) {
           error("FILE_DELETE_FAILURE");
           exit;
        }
      }

      if($photo1 != "") {
			  if(!copy("$photo1","$savedir/$photo1_name")) {
			     error("UPLOAD_COPY_FAILURE");
			     exit;
			  }
			  if(!rename("$savedir/$photo1_name","$savedir/$new_filename1")) {
			    error("UPLOAD_COPY_FAILURE");
			    exit;
			  }
   	  }

  }
  
  if($photo1 == "") { $upd_filename1 = $org_photo1; } else { $upd_filename1 = $new_filename1; }
  if($photo2 == "") { $upd_filename2 = $org_photo2; } else { $upd_filename2 = $new_filename2; }
  
  if(!$new_prd_code) {
    $new_prd_code = "0";
  }
  
  $memo = addslashes($memo);
  $branch_name = addslashes($branch_name);
  $branch_name2 = addslashes($branch_name2);

  $query  = "UPDATE client_branch SET userlevel = '$userlevel', branch_name = '$branch_name', branch_name2 = '$branch_name2', branch_type = '$branch_type',
              ceo_name = '$ceo_name', email = '$email', homepage = '$homepage', zipcode = '$zipcode', 
              addr1 = '$addr1', addr2 = '$addr2', phone1 = '$phone1', phone2 = '$phone2', phone_fax = '$phone_fax', 
              phone_cell = '$phone_cell', memo = '$memo', img1 = '$upd_filename1', prd_code = '$new_prd_code' 
              WHERE uid = '$user_uid'"; 

  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zcorp.php'>");
  exit;
  
}

}
?>