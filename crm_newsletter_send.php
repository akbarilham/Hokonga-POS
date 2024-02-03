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

		if($key6) {
				$cnt_checkA = "";
				$cnt_checkB = "checked";
	    } else {
	        if($my_inclu == "None") {
				$cnt_checkA = "";
				$cnt_checkB = "checked";
	        } else {
				$cnt_checkA = "checked";
				$cnt_checkB = "";
	        }
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


// Individual Sending
if($key6) {
  $to_email_now = $key6;
  $issue_no_now = "Send E-Mail to Specific Person";
} else {
  $to_email_now = $my_fr_email;
  $issue_no_now = $my_issue_no;
}



// DB Table
	if($room == "member") {
		$filter_mail_db_name = "member_main";
		$filter_mail_flag_name = "crmflag";
		$filter_mail_result_name = "memo";
	} else {
		$filter_mail_db_name = "mail_user_list";
		$filter_mail_flag_name = "mail_now";
		$filter_mail_result_name = "mail_result";
	}
	
	// DB Filter
	if($key != "") {
		$filter_now = "branch_code = '$login_branch' AND lang = '$lang' AND $keyfield LIKE '%$key%'";
	} else {
		$filter_now = "branch_code = '$login_branch' AND lang = '$lang'";
	}
	
	

// Total Count of recipients ---------------------------------------------------- //
$query_r1 = "SELECT count(uid) FROM $filter_mail_db_name WHERE $filter_now";
$result_r1 = mysql_query($query_r1);
if (!$result_r1) { error("QUERY_ERROR"); exit; }
$total_receiver = @mysql_result($result_r1,0,0);
$total_receiver_K = number_format($total_receiver);
?>
    


        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_web_nletter_11?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		

		
		<div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="crm_newsletter_send.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='ml_room' value='<?=$my_room?>'>
								<input type='hidden' name='nl_sender' value='<?=$my_fr_email?>'>
								<input type='hidden' name='ml_uid' value='<?=$my_uid?>'>
								<input type='hidden' name='ml_issue_no' value='<?=$my_issue_no?>'>
								<input type='hidden' name='ml_count' value='<?=$my_count_sent?>'>
								<input type='hidden' name='nl_head' value="<?=$my_head?>">
								<input type='hidden' name='nl_subject' value="<?=$my_subject?>">
								<input type='hidden' name='comment' value="<?=$my_comment?>">
								
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
                                            <input disabled class="form-control" id="cname" name="dis_issue_no" value="<?=$issue_no_now?>" type="text" />
                                        </div>
										<div class="col-sm-6">
											<?
											if($room == "member") { 
												echo ("&nbsp;&nbsp; <font color=red>[ Members Only ]</font>");
											} else if($room == "staff") {
												echo ("&nbsp;&nbsp; <font color=red>[ Staff Only ]</font>");
											}
											?>
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">From</label>
                                        <div class="col-sm-9">
                                            <input disabled class="form-control" id="cname" name="dis_nl_sender" value="<?=$my_fr_email?>" type="email"/>
                                        </div>
                                    </div>
									
										<?
										// Recipients
										if ($keyfield AND $key) {
											$filter_disableA = "disabled";
											$filter_disableB = "";
											$filter_chk1 = "";
											$filter_chk2 = "checked";
											$filter_value = "<font color=red>[ $keyfield = $key ]</font>";
										} else {
											$filter_disableA = "";
											$filter_disableB = "disabled";
											$filter_chk1 = "checked";
											$filter_chk2 = "";
											$filter_value = "";
										}
										
										echo ("
										<input type='hidden' name='keyfield' value='$keyfield'>
										<input type='hidden' name='key' value='$key'>
										
										<div class='form-group'>											
											<label class='control-label col-sm-3'><font color=red>To<br>($txt_web_nletter_12)</font></label>
											<div class='col-sm-9'>
												<input type=radio $filter_disableA name='re_block' value='test' $filter_chk1> <font color=red>To: </font>
												<input type='text' name='test_email' value='$to_email_now' maxlength=120 style='$style_box; WIDTH: 252px'>
												<br><input $filter_disableA type=radio name='re_block' value='all_list'> $txt_web_nletter_121 
												<br><input $filter_disableA type=radio name='re_block' value='re_select'> $txt_web_nletter_122
												<br><input $filter_disableB type=radio name='re_block' value='re_filter' $filter_chk2> <font color=navy>$txt_web_nletter_123</font> 
												$filter_value
											</div>
										</div>");
										?>
										
									
									
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
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_web_mailing_08?></label>
                                        <div class="col-sm-6">
                                            <?=$org_sentdates?>
                                        </div>
                                    </div>

											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_web_nletter_11?>">
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
	
	// Save Directory
	if($client_id == "host") {
		$savedir2 = "$home/user_file";
	} else {
		// $savedir = "$home/user/$client_id/user_file";
		$savedir2 = "$home/user_file";
	}
	

	$today = date('Ymd'); 
	$time = date('YmdHis');


	if($cnt_select == "1") {
		$nl2_paper = "$nl_paper";
		$nl2_inclu = "None";
	} else {
		$nl2_paper = "None";
		$nl2_inclu = "$nl_inclu";
	}
	
	// Sender Name
	$query_var = "SELECT user_email,user_name FROM admin_user WHERE user_id = '$login_id' AND branch_code = '$login_branch'";
	$result_var = mysql_query($query_var);
	
	$from_email = @mysql_result($result_var,0,0);
	$from_name = @mysql_result($result_var,0,1);
	
	// DB Table
	if($room == "member") {
		$filter_mail_db_name = "member_main";
		$filter_mail_flag_name = "crmflag";
		$filter_mail_result_name = "memo";
	} else if($room == "staff") {
		$filter_mail_db_name = "member_staff";
		$filter_mail_flag_name = "crmflag";
		$filter_mail_result_name = "memo";
	} else {
		$filter_mail_db_name = "mail_user_list";
		$filter_mail_flag_name = "mail_now";
		$filter_mail_result_name = "mail_result";
	}
	
	// DB Filter
	if($re_block == "re_filter") {
		$filter_now = "branch_code = '$login_branch' AND lang = '$lang' AND $keyfield LIKE '%$key%'";
	} else if($re_block == "re_select") {
		$filter_now = "branch_code = '$login_branch' AND lang = '$lang' AND $filter_mail_flag_name = '1'";
	} else if($re_block == "all_list") {
		$filter_now = "branch_code = '$login_branch' AND lang = '$lang'";
	} else {
		$filter_now = "branch_code = '$login_branch' AND email = '$test_email'";
	}
	
	

	// Total Count of recipients ---------------------------------------------------- //
	$query_r1 = "SELECT count(uid) FROM $filter_mail_db_name WHERE $filter_now";
	$result_r1 = mysql_query($query_r1);
	if (!$result_r1) { error("QUERY_ERROR"); exit; }
	$total_receiver = @mysql_result($result_r1,0,0);
	$total_receiver_K = number_format($total_receiver);

	$query_r2 = "SELECT uid,name,email,$filter_mail_result_name FROM $filter_mail_db_name WHERE $filter_now ORDER BY uid ASC";
	$result_r2 = mysql_query($query_r2);
	if (!$result_r2) { error("QUERY_ERROR"); exit; }

    for($r = 0; $r < $total_receiver; $r++) {
    
        // Recipient Definition
        $to_uid = mysql_result($result_r2,$r,0);
        $to_name = mysql_result($result_r2,$r,1);
        $to_email = mysql_result($result_r2,$r,2);
        $to_result = mysql_result($result_r2,$r,3);

        
        $mail_content = "$comment";
        
 
        // $from_email = "$nl_sender";

        // Mail Contents
        $additional = "From: $from_name<$from_email> \n"; 
        $additional .= "Reply-To: $from_email \n";
        $additional .= "MIME-Version: 1.0\r\n"; 
        $additional .= "Content-Type:text/html;charset=UTF-8\r\n"; 
        $additional .= "X-Priority: 1\r\n"; 
        $additional .= "X-MSMail-Priority: High\r\n";
        $additional .= "X-Mailer: $from_email";


        $mail_content = stripslashes($mail_content);
        $mail_content = nl2br($mail_content);
        
        $nl_subject1 = stripslashes($nl_subject);
        
		$mail_topic = "[$nl_head] $nl_subject1";
		$mail_topic2 = "=?utf-8?B?".base64_encode($mail_topic)."?=\n";


    	    $body = "<html lang='$lang'>";
    	    
    	    // Style Sheet
    	    
    	    $body .= "
			<style type='text/css'>
			body	{ font-family:'verdana','Arial'; font-size:9pt;color:#000000; text-decoration:none;}
			td    { font-family:'verdana','Arial'; font-size:9pt;color:#000000; text-decoration:none;}

			A:link{color:navy;text-decoration:Underline}
			A:visited{color:#888888;text-decoration:None}
			A:hover{color:orange;text-decoration:None}
			A:active{color:orange;text-decoration:None}

			A.my:link{color:blue;text-decoration:None}
			A.my:visited{color:navy;text-decoration:None}
			A.my:hover{color:green;text-decoration:None}
			A.my:active{color:orange;text-decoration:None}
			</style>
			";

    	     
    	    $body .= "\n<body bgcolor=\"#ffffff\" text=\"#000000\" link=\"#0000ff\" vlink=\"#800080\" alink=\"#ff0000\">";
    	    $body .= "{$mail_content}";
    	    $body .= "\n</body></html>";



        // (2) Mail Sending
        mail($to_email, $mail_topic2, $body, $additional);


        // (3) User List Update
        if($re_block != "test") {
            
            $user_time = date('YmdHis');
            $new_result = "$ml_issue_no"."-"."$user_time"."|";
            
            $mail_results = "$to_result"."$new_result";
            
            
            $query_write = "UPDATE $filter_mail_db_name SET $filter_mail_result_name = '$mail_results' 
						WHERE uid = '$to_uid' AND lang = '$lang' AND branch_code = '$login_branch'";
            $result_write = mysql_query($query_write);
              if (!$result_write) { error("QUERY_ERROR"); exit; }
        
        }
        
        // (4) Print
        echo ("
            <br>$to_email
            ");
    
    
    
    
    }

	// Layout of text
	$nl_subject2 = addslashes($nl_subject);
	$nl_comment2 = addslashes($comment);


	// Counter
	echo ("<p>Total <font color=red>$total_receiver_K</font> Mails</p>");


	// Mailing List Update
	if($re_block == "test") {
		$query = "UPDATE mail_delivery SET fr_email = '$nl_sender', cnt_head = '$nl_head',
          cnt_subject = '$nl_subject2', cnt_comment = '$nl_comment2', cnt_paper = '$nl2_paper',
          cnt_inclu = '$nl2_inclu', m_html = '$m_html' WHERE uid = '$ml_uid' AND branch_code = '$login_branch'";
	} else {


		$query_count = "SELECT count_sent FROM mail_delivery WHERE uid = '$ml_uid' AND branch_code = '$login_branch'";
		$result_count = mysql_query($query_count);
		if(!$result_count) { error("QUERY_ERROR"); exit; }
		$row_count = mysql_fetch_object($result_count);
		$org_count = $row_count->count_sent;
  
		if(!$ml_count) { $old_count = $org_count; } else { $old_count = $ml_count; }
   
		$count_new = $old_count + $total_receiver;
		$query = "UPDATE mail_delivery SET fr_email = '$nl_sender', cnt_head = '$nl_head',
          cnt_subject = '$nl_subject2', cnt_comment = '$nl_comment2', cnt_paper = '$nl2_paper',
          cnt_inclu = '$nl2_inclu', m_html = '$m_html', 
          count_sent = '$count_new', send_flag = '1', sent_date = '$time' 
          WHERE uid = '$ml_uid' AND lang = '$lang' AND branch_code = '$login_branch'";
	}
	$result = mysql_query($query);
	if (!$result) { error("QUERY_ERROR"); exit; }


	echo ("<p><a href='$home/crm_newsletter.php?page=$page&room=$room' target='_top'>Back to List</a></p>
	<br><br>");



	echo("<meta http-equiv='Refresh' content='10; URL=$home/crm_newsletter.php?page=$page'>");
	exit;

}

}
?>