<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }
if(!$key_gate) { $key_gate = $client_id; }

if(!$step_next) {
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Work, Bootstrap, Responsive">
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
$query = "SELECT uid,b_id,b_type,b_width,b_height,filesize,memo FROM wpage_banner1 WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

   $uid = $row->uid;   
   $b_id = $row->b_id;   
   $b_type = $row->b_type;
   $b_width = $row->b_width;
   $b_height = $row->b_height;
   $b_filesize = (int)($row->filesize);
	$b_filesize_K = number_format($b_filesize);
   $b_memo = $row->memo;
	// $b_memo = stripslashes($b_memo);
	
	if($b_type == "2") {
		$ext = "gif";
	} else if($b_type == "3") {
		$ext = "png";
	} else {
		$ext = "jpg";
	}


	$filename = "banner_"."$b_id".".{$ext}"; 
  

// Save Directory
if($client_id == "host") {
	$savedir = "user_file";
} else {
	// $savedir = "user/$client_id/user_file";
	$savedir = "user_file";
}
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_031?> &gt; <?=$txt_web_banner1_04?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="website_banner1_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								<input type='hidden' name='old_b_type' value='<?=$b_type?>'>
								<input type='hidden' name='old_b_id' value='<?=$b_id?>'>
								<input type='hidden' name='filename' value='<?=$filename?>'>
								<input type='hidden' name='uid' value='<?=$uid?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								
								
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' 
													ORDER BY userlevel DESC";
											$resultD = mysql_query($queryD);

											echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo ("<option value=\"\">:: $txt_comm_frm24</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$web_client_id = mysql_result($resultD,$i,0);
												$web_client_name = mysql_result($resultD,$i,1);
												$web_client_homepage = mysql_result($resultD,$i,2);
        
												if($web_client_id == $key_gate) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$PHP_SELF?key_gate=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
										
												<?
												if($b_type == "2") {
													$ext = "gif";
													$chk1 = "";
													$chk2 = "checked";
													$chk3 = "";
												} else if($b_type == "3") {
													$ext = "png";
													$chk1 = "";
													$chk2 = "";
													$chk3 = "checked";
												} else {
													$ext = "jpg";
													$chk1 = "checked";
													$chk2 = "";
													$chk3 = "";
												}

												
												if($b_id == "intro1" OR $b_id == "intro2" OR $b_id == "intro3") {
													echo ("<image src='$savedir/banner_{$b_id}.{$ext}' style='WIDTH: 760px' border=0>");
												} else {
													echo ("<image src='$savedir/banner_{$b_id}.{$ext}' border=0>");
												}
												?>
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_07?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" type="text" name="b_filesize" value="<?=$b_filesize_K?>" style="text-align: right">
                                        </div>
										<div class="col-sm-6">Bytes</div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_05?></label>
                                        <div class="col-sm-3">
                                            <input disabled class="form-control" id="cname" name="dis_b_id" value="<?=$b_id?>" type="text" />
                                        </div>
										<div class="col-sm-6">(<?=$txt_web_banner1_09?>)</div>
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

	

  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');
  $b_memo = addslashes($b_memo);
  
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}


  if(!unlink("$savedir/$filename")) {
	echo "Failed to delete images involved";
	exit;
  }

	// Database
	$query  = "DELETE FROM wpage_banner1 WHERE uid = '$uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
	$result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }


echo("<meta http-equiv='Refresh' content='0; URL=$home/website_banner1.php?key_gate=$key_gate'>");
exit;
  
}

}
?>