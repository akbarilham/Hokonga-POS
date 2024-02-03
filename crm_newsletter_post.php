<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }

$mmenu = "crm";
$smenu = "crm_newsletter";

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


// Sender
$query_var = "SELECT user_email,user_name FROM admin_user WHERE user_id = '$login_id' AND branch_code = '$login_branch'";
$result_var = mysql_query($query_var);
	
$from_email = @mysql_result($result_var,0,0);
$from_name = @mysql_result($result_var,0,1);
?>
    


        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_web_nletter_05?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		

		
		<div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="crm_newsletter_post.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name="nl_sender" value="<?=$from_email?>">
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
                                        <div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,homepage FROM client 
														WHERE web_flag = '1' AND branch_code = '$login_branch' ORDER BY userlevel DESC";
											$resultD = mysql_query($queryD);
											if (!$resultD) {   error("QUERY_ERROR");   exit; }

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

											for($i = 0; $i < $total_recordC; $i++) {
												$web_client_id = mysql_result($resultD,$i,0);
												$web_client_name = mysql_result($resultD,$i,1);
												$web_client_homepage = mysql_result($resultD,$i,2);
        
												if($web_client_id == $client_id) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$PHP_SELF?client_id=$client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">From</label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="dis_nl_sender" type="email" value="<?=$from_email?>"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Head</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="nl_head" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$bdtxt_02?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="nl_subject" type="text"  required/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$bdtxt_08?></label>
                                        <div class="col-sm-9">
                                            <input type='radio' name='m_html' value='0'> Text &nbsp;&nbsp; 
											<input type='radio' name='m_html' value='1' checked> HTML
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="10" name="nl_comment"></textarea>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_nletter_07?></label>
                                        <div class="col-sm-9">
                                            <input type='radio' name='nl_footer' value='1' checked> Yes &nbsp;&nbsp; 
											<input type='radio' name='nl_footer' value='0'> No
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


  if(!$nl_footer) {
	$nl_footer = "0";
  }

  
  $signdate = time();
	$today = date('Ymd'); 
	$time = date('YmdHis');

  $m_ip = getenv('REMOTE_ADDR');
  
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}
	

  if($pin_key) {
  
	$nl_subject = addslashes($nl_subject);
	$nl_comment = addslashes($nl_comment);
	
	$issue=rand(1000,9999);
	$issue_no="NL"."$time";

	if($cnt_select == "1") {
		$nl2_paper = "$nl_paper";
		$nl2_inclu = "None";
	} else {
		$nl2_paper = "None";
		$nl2_inclu = "$nl_inclu";
	}

	
if($nl_footer == "1") {
  
	$query_pdt2 = "SELECT subject,comment FROM wpage_stuff WHERE room = 'xmail_footer' AND lang = '$lang' AND branch_code = '$login_branch'";
	$result_pdt2 = mysql_query($query_pdt2,$dbconn);
	
	$mail_footer1 = @mysql_result($result_pdt2,0,0);
	$mail_footer2 = @mysql_result($result_pdt2,0,1);
	
	$nl_comment .= "
	
      
<b>$mail_footer1</b>
      
$mail_footer2
  
";

}
	

    $query_M1 = "INSERT INTO mail_delivery (uid, issue_no, fr_email, cnt_head, cnt_subject, cnt_comment,
          cnt_paper, cnt_inclu, m_html, post_date, lang, gate, branch_code) VALUES ('', '$issue_no', '$nl_sender', '$nl_head', 
		  '$nl_subject', '$nl_comment', '$nl2_paper', '$nl2_inclu', '$m_html', '$time', '$lang', '$client_id', '$login_branch')";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_newsletter.php'>");
  exit;
  
  }
  }

}

}
?>