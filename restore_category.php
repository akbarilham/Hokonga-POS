<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_category";

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
            Data Reset
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_category.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="category" />
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input disabled class="btn btn-primary" type="submit" value="Reset now !">
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


	// Delete
		$query_del1 = "DELETE FROM shop_catgbig WHERE lang = 'in' OR lang = 'ko'";
		$result_del1 = mysql_query($query_del1);
		if(!$result_del1) { error("QUERY_ERROR"); exit; }
		
		$query_del2 = "DELETE FROM shop_catgmid WHERE lang = 'in' OR lang = 'ko'";
		$result_del2 = mysql_query($query_del2);
		if(!$result_del2) { error("QUERY_ERROR"); exit; }
		
		$query_del3 = "DELETE FROM shop_catgsml WHERE lang = 'in' OR lang = 'ko'";
		$result_del3 = mysql_query($query_del3);
		if(!$result_del3) { error("QUERY_ERROR"); exit; }
	
	
  
	// Insert
		$queryC1 = "SELECT count(uid) FROM shop_catgbig WHERE lang = 'en'";
		$resultC1 = mysql_query($queryC1);
		$total_recordC1 = @mysql_result($resultC1,0,0);

		$queryD1 = "SELECT lcode,lname FROM shop_catgbig WHERE lang = 'en'";
		$resultD1 = mysql_query($queryD1);
      
		for($r1 = 0; $r1 < $total_recordC1; $r1++) {
			$R1_lcode = mysql_result($resultD1,$r1,0);
			$R1_lname = mysql_result($resultD1,$r1,1);
				$R1_lname = addslashes($R1_lname);

			$query_P1A = "INSERT INTO shop_catgbig (uid,lcode,lname,lang) values ('','$R1_lcode','$R1_lname','in')";
			$result_P1A = mysql_query($query_P1A);
			if (!$result_P1A) { error("QUERY_ERROR"); exit; }
			
			$query_P1B = "INSERT INTO shop_catgbig (uid,lcode,lname,lang) values ('','$R1_lcode','$R1_lname','ko')";
			$result_P1B = mysql_query($query_P1B);
			if (!$result_P1B) { error("QUERY_ERROR"); exit; }
			
		}
		
		
		$queryC2 = "SELECT count(uid) FROM shop_catgmid WHERE lang = 'en'";
		$resultC2 = mysql_query($queryC2);
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT lcode,mcode,mname FROM shop_catgmid WHERE lang = 'en'";
		$resultD2 = mysql_query($queryD2);
      
		for($r2 = 0; $r2 < $total_recordC2; $r2++) {
			$R2_lcode = mysql_result($resultD2,$r2,0);
			$R2_mcode = mysql_result($resultD2,$r2,1);
			$R2_mname = mysql_result($resultD2,$r2,2);
				$R2_mname = addslashes($R2_mname);

			$query_P2A = "INSERT INTO shop_catgmid (uid,lcode,mcode,mname,lang) values ('','$R2_lcode','$R2_mcode','$R2_mname','in')";
			$result_P2A = mysql_query($query_P2A);
			if (!$result_P2A) { error("QUERY_ERROR"); exit; }
			
			$query_P2B = "INSERT INTO shop_catgmid (uid,lcode,mcode,mname,lang) values ('','$R2_lcode','$R2_mcode','$R2_mname','ko')";
			$result_P2B = mysql_query($query_P2B);
			if (!$result_P2B) { error("QUERY_ERROR"); exit; }
			
		}
		
		
		$queryC3 = "SELECT count(uid) FROM shop_catgsml WHERE lang = 'en'";
		$resultC3 = mysql_query($queryC3);
		$total_recordC3 = @mysql_result($resultC3,0,0);

		$queryD3 = "SELECT lcode,mcode,scode,sname FROM shop_catgsml WHERE lang = 'en'";
		$resultD3 = mysql_query($queryD3);
      
		for($r3 = 0; $r3 < $total_recordC3; $r3++) {
			$R3_lcode = mysql_result($resultD3,$r3,0);
			$R3_mcode = mysql_result($resultD3,$r3,1);
			$R3_scode = mysql_result($resultD3,$r3,2);
			$R3_sname = mysql_result($resultD3,$r3,3);
				$R3_sname = addslashes($R3_sname);

			$query_P3A = "INSERT INTO shop_catgsml (uid,lcode,mcode,scode,sname,lang) values ('','$R3_lcode','$R3_mcode','$R3_scode','$R3_sname','in')";
			$result_P3A = mysql_query($query_P3A);
			if (!$result_P3A) { error("QUERY_ERROR"); exit; }
			
			$query_P3B = "INSERT INTO shop_catgsml (uid,lcode,mcode,scode,sname,lang) values ('','$R3_lcode','$R3_mcode','$R3_scode','$R3_sname','ko')";
			$result_P3B = mysql_query($query_P3B);
			if (!$result_P3B) { error("QUERY_ERROR"); exit; }
			
		}


  echo("<meta http-equiv='Refresh' content='10; URL=$home/restore_category.php'>");
  exit;
 
}

}
?>