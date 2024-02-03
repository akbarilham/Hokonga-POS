<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_insurance";

if(!$step_next) {
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Work, Hybrid ERP, Bootstrap, Responsive">
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
$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sys_insur_02?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_insurance_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								
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
        
												echo("<option value='$menu_code'>[ $menu_code ] $menu_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_insur_06?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="agent_name" type="text" required />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_bank_09?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="branch_name" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_insur_07?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="contact_name" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_bank_11?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="agent_manager" type="text" />
                                        </div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cemail" class="control-label col-sm-3">E-Mail</label>
                                        <div class="col-sm-9">
                                            <input class="form-control " id="cemail" type="email" name="email" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_05?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="homepage" type="url" />
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

	

  $rm_query = "SELECT agent_code FROM code_insurance ORDER BY agent_code DESC";
  $rm_result = mysql_query($rm_query);
	if (!$rm_result) { error("QUERY_ERROR"); exit; }
  $max_room = @mysql_result($rm_result,0,0);
  
  $exp_room = explode("_",$max_room);
  $exp_room1 = $exp_room[1];
  $new_room_num1 = $exp_room1 + 1;
  if($new_room_num1 < 10) { $new_room_num = "0".$new_room_num1; } else { $new_room_num = $new_room_num1; }
  
  if($max_room == "") {
    $new_agent_code = "IN_01";
  } else {
    $new_agent_code = "IN_". "$new_room_num";
  }

  if(strcmp($no_robot_pw,$no_robot_pw_hidden)) {
    error("INVALID_PASSWD");
    exit;
  } else {


  $signdate = time();
  $m_ip = getenv('REMOTE_ADDR');

	$agent_name = addslashes($agent_name);
	$branch_name = addslashes($branch_name);
	$contact_name = addslashes($contact_name);
	$agent_manager = addslashes($agent_manager);


  if($pin_key) {

    $query_M1 = "INSERT INTO code_insurance (uid,branch_code,gate,agent_code,agent_name,branch_name,
          contact_name,manager,email,homepage,userlevel,signdate) values ('',
          '$new_branch_code','$user_gate','$new_agent_code','$agent_name','$branch_name',
          '$contact_name','$agent_manager','$email','$homepage','1',$signdate)";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_insurance.php?keyfield=$keyfield&key=$key'>");
  exit;
  
  }
  }
  
}

}
?>