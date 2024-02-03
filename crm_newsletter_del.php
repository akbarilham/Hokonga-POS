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
$query = "SELECT uid,room,issue_no,fr_email,cnt_head,cnt_subject,cnt_comment,cnt_paper,cnt_inclu, 
          m_html, count_sent, send_flag, post_date, sent_date, att_type, userfile FROM mail_delivery 
		  WHERE uid = '$uid' AND branch_code = '$login_branch'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$my_uid = $row->uid;
$my_room = $row->room;
$my_issue_no = $row->issue_no;
$my_fr_email = $row->fr_email;
$my_head = $row->cnt_head;
$my_subject = $row->cnt_subject;
	$my_subject = stripslashes($my_subject);
$my_comment = $row->cnt_comment;
	$my_comment = stripslashes($my_comment);
	$my_comment2 = nl2br($my_comment);
$my_paper = $row->cnt_paper;
$my_inclu = $row->cnt_inclu;
$my_m_html = $row->m_html;
$my_count_sent = $row->count_sent;
$my_post_date = $row->post_date;
$my_sent_date = $row->sent_date;
$my_att_type = $row->att_type;
$my_userfile = $row->userfile;

		if($my_inclu == "None") {
	        $cnt_checkA = "";
	        $cnt_checkB = "checked";
	    } else {
	        $cnt_checkA = "checked";
	        $cnt_checkB = "";
	    }

$post_date1 = substr($my_post_date,0,4);
$post_date2 = substr($my_post_date,4,2);
$post_date3 = substr($my_post_date,6,2);
	if($lang == "ko") {
		$post_dates = "$post_date1"."/"."$post_date2"."/"."$post_date3";
	} else {
		$post_dates = "$post_date3"."-"."$post_date2"."-"."$post_date1";
	}

$post_time = substr($my_post_date,8,8);

$org_postdates = "$post_dates".":"."$post_time";

$sent_date1 = substr($my_sent_date,0,4);
$sent_date2 = substr($my_sent_date,4,2);
$sent_date3 = substr($my_sent_date,6,2);
	if($lang == "ko") {
		$sent_dates = "$sent_date1"."/"."$sent_date2"."/"."$sent_date3";
	} else {
		$sent_dates = "$sent_date3"."-"."$sent_date2"."-"."$sent_date1";
	}

$sent_time = substr($my_sent_date,8,8);

if($sent_date1 == "") {
  $org_sentdates = "<font color=red>DRAFT</font>";
} else {
  $org_sentdates = "<font color=blue>$sent_dates".":"."$sent_time</font>";
}
?>
    


        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_web_nletter_04?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		

		
		<div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="crm_newsletter_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='ml_room' value='<?=$my_room?>'>
								<input type='hidden' name='nl_sender' value='<?=$my_fr_email?>'>
								<input type='hidden' name='mode' value='<?=$mode?>'>
								<input type='hidden' name='uid' value='<?=$my_uid?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								
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
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_nletter_06?></label>
                                        <div class="col-sm-3">
                                            <input disabled class="form-control" id="cname" name="dis_issue_no" value="<?=$my_issue_no?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">From</label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="dis_nl_sender" value="<?=$my_fr_email?>" type="email"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Head</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="cname" name="nl_head" type="text" value="<?=$my_head?>"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$bdtxt_02?></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="nl_subject" type="text" value="<?=$my_subject?>"/>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$bdtxt_08?></label>
                                        <div class="col-sm-9">
                                            <?
												if($my_m_html == "0") {
													echo ("<input type='radio' name='m_html' value='0' checked> Text &nbsp;&nbsp; ");
												} else {
													echo ("<input type='radio' name='m_html' value='0'> Text &nbsp;&nbsp; ");
												}

												if($my_m_html == "1") {
													echo ("<input type='radio' name='m_html' value='1' checked> HTML");
												} else {
													echo ("<input type='radio' name='m_html' value='1'> HTML");
												}
												?>
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
                                        <div class="col-sm-9">
                                            <?echo("$my_comment2")?>
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_mailing_13?></label>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" name="dis_org_postdates" value="<?=$org_postdates?>">
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_nletter_08?></label>
                                        <div class="col-sm-6">
                                            <input disabled type="text" class="form-control" name="dis_count_sent" value="<?=$my_count_sent?>">
                                        </div>
                                    </div>

											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm08?>">
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

	
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}
	

	$query  = "DELETE FROM mail_delivery WHERE uid = '$uid' AND branch_code = '$login_branch'";
	$result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }


echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_newsletter.php?page=$page'>");
exit;
}

}
?>