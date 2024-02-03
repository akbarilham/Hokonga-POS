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

$mmenu = "website";
$smenu = "website_banner1";

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
$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_08_031?> &gt; <?=$txt_web_banner1_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="website_banner1_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type="hidden" name="key_gate" value="<?=$key_gate?>">
								
								
								
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_05?></label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="b_id" type="text" required />
                                        </div>
										<div class="col-sm-6">(<?=$txt_web_banner1_09?>)</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_10?></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="cname" name="userfile" type="file" required />
                                        </div>
										<div class="col-sm-3">(JPG, GIF, PNG)</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_banner1_11?></label>
                                        <div class="col-sm-9">
                                            <?=$txt_web_banner1_111?> : <input type='text' name='b_width' maxlength=4 style='WIDTH: 80px; text-align: center'> <?=$txt_web_banner1_12?> *   
											<?=$txt_web_banner1_112?> : <input type='text' name='b_height' maxlength=4 style='WIDTH: 80px; text-align: center'> <?=$txt_web_banner1_12?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Note</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="b_memo" type="text" />
                                        </div>
                                    </div>
									
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm21?></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="cname" maxlength="12" name="no_robot_pw" type="text" required />
                                        </div>
										<div class="col-sm-7">
											<?=$txt_comm_frm22?> <?=$no_robot_code?>
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm03?>">
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

	

  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');

  
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}



  if($pin_key) {
  
			$full_filename = explode(".", "$userfile_name");
			$extension = $full_filename[sizeof($full_filename)-1];	   
	
			if(strcmp($extension,"JPG") AND 
			   strcmp($extension,"jpg") AND
			   strcmp($extension,"GIF") AND
			   strcmp($extension,"gif") AND
			   strcmp($extension,"PNG") AND
			   strcmp($extension,"png")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}
			
			// File Types
			if($extension == "JPG" OR $extension == "jpg") {
			  $image_type = "1";
			  $extension2 = "jpg";
			} else if($extension == "GIF" OR $extension == "gif") {
			  $image_type = "2";
			  $extension2 = "gif";
			} else if($extension == "PNG" OR $extension == "png") {
			  $image_type = "3";
			  $extension2 = "png";
			} else {
			  $image_type = "4";
			  $extension2 = $extension;
			}
			

			$new_filename = "banner_"."$b_id".".{$extension2}";

			if($userfile != "") {
			if(!copy("$userfile","$savedir/$userfile_name")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			if(!rename("$savedir/$userfile_name","$savedir/$new_filename")) {
			   error("UPLOAD_COPY_FAILURE");
			   exit;
			}
			}
			
			$b_memo = addslashes($b_memo);
			
			// Duplication Check
			$result_q1 = mysql_query("SELECT count(uid) FROM wpage_banner1 WHERE b_id = '$b_id' AND gate = '$key_gate' AND branch_code = '$login_branch'");
				if (!$result_q1) { error("QUERY_ERROR"); exit; }
			$rows_q1 = @mysql_result($result_q1,0,0);
			if ($rows_q1) {
				popup_msg("The Banner Code you submitted exists already.");
				break;
			} else {

				$query_M1  = "INSERT INTO wpage_banner1 (uid, b_id, b_type, b_width, b_height, filesize, memo, gate, branch_code)
							VALUES ('', '$b_id', '$image_type', '$b_width', '$b_height', '$userfile_size', '$b_memo', '$key_gate', '$login_branch')";
				$result_M1 = mysql_query($query_M1);
				if (!$result_M1) { error("QUERY_ERROR"); exit; }
			
			}


  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_banner1.php?key_gate=$key_gate'>");
  exit;
  
  }
  }
  
}

}
?>