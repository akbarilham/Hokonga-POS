<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_brand";

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
	
<SCRIPT LANGUAGE="JavaScript"> 
<!-- 
function imgResize(img){ 
  img1= new Image(); 
  img1.src=(img); 
  imgControll(img); 
} 

function imgControll(img){ 
  if((img1.width!=0)&&(img1.height!=0)){ 
    viewImage(img); 
  } 
  else{ 
    controller="imgControll('"+img+"')"; 
    intervalID=setTimeout(controller,20); 
  } 
} 

function viewImage(img){ 
        W=img1.width; 
        H=img1.height; 
        O="width="+W+",height="+H; 
        imgWin=window.open("","",O); 
        imgWin.document.write("<html><head><title>Image Preview</title></head>");
        imgWin.document.write("<body topmargin=0 leftmargin=0>");
        imgWin.document.write("<img src="+img+" onclick='self.close()'>");
        imgWin.document.close();
} 
//  --> 
</script>

  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
<?
$img_dir = "user_file";


$query = "SELECT uid,gate,branch_code,brand_code,brand_name,brand_origin,brand_show,brand_profile,img1,img2,ref FROM shop_brand WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$user_gate = $row->gate;
$brand_branch_code = $row->branch_code;
$brand_code = $row->brand_code;
$brand_name = $row->brand_name;
	$brand_name = stripslashes($brand_name);
$brand_origin = $row->brand_origin;
$brand_show = $row->brand_show;
$brand_profile = $row->brand_profile;
	$brand_profile = stripslashes($brand_profile);
$brand_img1 = $row->img1;
$brand_img2 = $row->img2;
$brand_ref = $row->ref;


if($brand_show == "0") {
  $brand_show_chk0 = "checked";
  $brand_show_chk1 = "";
} else if($brand_show == "1") {
  $brand_show_chk0 = "";
  $brand_show_chk1 = "checked";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_brand_03?>
            <span class="tools pull-right">
				<a href="system_brand_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="system_brand_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value="<?=$user_uid?>">
								<input type='hidden' name='key_field' value="<?=$key_field?>">
								<input type='hidden' name='key' value="<?=$key?>">
								<input type='hidden' name='page' value="<?=$page?>">
								<input type='hidden' name='org_code' value="<?=$brand_code?>">
								<input type='hidden' name='org_img1' value="<?=$brand_img1?>">
								<input type='hidden' name='org_img2' value="<?=$brand_img2?>">
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
											$resultD = mysql_query($queryD);

											echo("<select name='new_branch_code' class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$menu_code = mysql_result($resultD,$i,0);
												$menu_name = mysql_result($resultD,$i,1);
        
												if($menu_code == $brand_branch_code) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option value='$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
																		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_brand_05?></label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="dis_brand_code" value="<?=$brand_code?>" type="text"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_brand_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="brand_name" value="<?=$brand_name?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_brand_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="brand_origin" value="<?=$brand_origin?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="cname" name="brand_profile"><?echo("$brand_profile")?></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cname" name="brand_img1" value="<?=$brand_img1?>" type="file" />
                                        </div>
										<div class="col-sm-3">
											<?
                                            if($brand_img1 != "") {
												echo ("<a href=\"javascript:imgResize('$img_dir/$brand_img1')\"><i class='fa fa-picture-o'></i></a>");
											}
											?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cname" name="brand_img2" value="<?=$brand_img2?>" type="file" />
                                        </div>
										<div class="col-sm-3">
											<?
                                            if($brand_img2 != "") {
												echo ("<a href=\"javascript:imgResize('$img_dir/$brand_img2')\"><i class='fa fa-picture-o'></i></a>");
											}
											?>
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_brand_09?></label>
                                        <div class="col-sm-9">
                                            <input type=radio name='brand_show' value='1' <?=$brand_show_chk1?>> <font color=blue>ON</font> &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type=radio name='brand_show' value='0' <?=$brand_show_chk0?>> <font color=red>OFF</font>
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

	
	$savedir = "user_file";
	
	
	if($brand_img1 != "") {

			$full_filename1 = explode(".", "$brand_img1_name");
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

			$new_filename1 = "brand_{$org_code}"."_1.{$extension1}";

			if(!copy("$brand_img1","$savedir/$brand_img1_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$brand_img1_name","$savedir/$new_filename1")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			
		// Database
		$query_f1 = "UPDATE shop_brand SET img1 = '$new_filename1' WHERE uid = '$user_uid'";
		$result_f1 = mysql_query($query_f1,$dbconn);
		if (!$result_f1) { error("QUERY_ERROR"); exit; }

	}
	
	
	if($brand_img2 != "") {

			$full_filename2 = explode(".", "$brand_img2_name");
			$extension2 = $full_filename2[sizeof($full_filename2)-1];	   
	
			if(strcmp($extension2,"JPG") AND 
			   strcmp($extension2,"jpg") AND
			   strcmp($extension2,"GIF") AND
			   strcmp($extension2,"gif") AND
			   strcmp($extension2,"PNG") AND
			   strcmp($extension2,"png"))
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}

			$new_filename2 = "brand_{$org_code}"."_2.{$extension2}";

			if(!copy("$brand_img2","$savedir/$brand_img2_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$brand_img2_name","$savedir/$new_filename2")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			
		// Database
		$query_f2 = "UPDATE shop_brand SET img2 = '$new_filename2' WHERE uid = '$user_uid'";
		$result_f2 = mysql_query($query_f2,$dbconn);
		if (!$result_f2) { error("QUERY_ERROR"); exit; }

	}
  
  
  
	$brand_name = addslashes($brand_name);
	$brand_profile = addslashes($brand_profile);

	$query  = "UPDATE shop_brand SET brand_name = '$brand_name', brand_origin = '$brand_origin', brand_profile = '$brand_profile', 
              brand_show = '$brand_show' WHERE uid = '$user_uid'";
	$result = mysql_query($query);
	if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_brand.php'>");
  exit;
  

}

}
?>