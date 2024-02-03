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
            Data Mining
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_store.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="data_store" />
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="Restore now !">
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


	$signdate = time();
  

		$queryC2 = "SELECT count(store) FROM temp_table_store";
		$resultC2 = mysql_query($queryC2);
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT spt,sgroup,store,area,address,tel,fax FROM temp_table_store";
		$resultD2 = mysql_query($queryD2);
      
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_pt = mysql_result($resultD2,$ra,0);
			$R_group = mysql_result($resultD2,$ra,1);
			$R_store = mysql_result($resultD2,$ra,2);
				$R_store_name = addslashes($R_store);
			$R_area = mysql_result($resultD2,$ra,3);
			$R_addr = mysql_result($resultD2,$ra,4);
			$R_tel = mysql_result($resultD2,$ra,5);
			$R_fax = mysql_result($resultD2,$ra,6);
			
			
			// PT Code
			if($R_pt == "JOEUN STAR") {
				$new_pt_code = "CORP_02";
			} else if($R_pt == "CV. JOEUN" OR $R_pt == "CV.JOEUN") {
				$new_pt_code = "CORP_03";
			} else if($R_pt == "LOCK & LOCK" OR $R_pt == "LOCK&LOCK") {
				$new_pt_code = "CORP_04";
			} else if($R_pt == "FEELBUY" OR $R_pt == "FEEL BUY") {
				$new_pt_code = "CORP_05";
			} else if($R_pt == "DORCO") {
				$new_pt_code = "CORP_06";
			} else {
				$new_pt_code = "CORP_01";
			}
			
			
			// Consignment Group Code
			if($R_group == "FARMER MARKET" OR $R_group == "FARMERMARKET") {
				$R_group = "FARMERS MARKET";
			}
			
			$pg_query = "SELECT group_code FROM client_consign WHERE group_name = '$R_group'";
			$pg_result = mysql_query($pg_query);
				if (!$pg_result) { error("QUERY_ERROR"); exit; }
			$new_group_code = @mysql_result($pg_result,0,0);
			
			// New Shop Code
			$rm_query = "SELECT shop_code FROM client_shop WHERE associate = '1' ORDER BY shop_code DESC";
			$rm_result = mysql_query($rm_query);
				if (!$rm_result) { error("QUERY_ERROR"); exit; }
			$max_room = @mysql_result($rm_result,0,0);
  
			$new_room1 = substr($max_room,0,1);
			$new_room2 = substr($max_room,1);
  
			$new_room2p = $new_room2 + 1;
			$new_room2_num4 = sprintf("%04d", $new_room2p); // 4자리수
  
			if(!$max_room OR $max_room == "") {
				$new_shop_code = "A0001";
			} else {
				$new_shop_code = "A"."$new_room2_num4";
			}
			
			// Area Code
			if($R_area == "Sumatra") {
				$R_area = "Sumatera";
			} else if($R_area == "Balik Papan") {
				$R_area = "Balikpapan";
			}
			
			$query_AR2 = "SELECT area_code FROM code_area WHERE area_name = '$R_area' OR area_name2 = '$R_area' ORDER BY area_code ASC";
			$result_AR2 = mysql_query($query_AR2);
				if (!$result_AR2) { error("QUERY_ERROR"); exit; }
			$sh_area_code = @mysql_result($result_AR2,0,0);
												
			
			// Gate
			$gt_query = "SELECT client_id FROM client WHERE branch_code = '$new_pt_code' AND associate = '1' AND userlevel = '5' ORDER BY client_id ASC";
			$gt_result = mysql_query($gt_query);
				if (!$gt_result) { error("QUERY_ERROR"); exit; }
			$new_gate_code = @mysql_result($gt_result,0,0);

			
			// Insert
			$query_P = "INSERT INTO client_shop (uid,branch_code,gate,subgate,associate,group_code,shop_code,shop_name,shop_type,manager,
					area,email,homepage,userlevel,signdate) values ('','$new_pt_code','$new_gate_code','$new_gate_code','1','$new_group_code',
					'$new_shop_code','$R_store_name','off','','$sh_area_code','','','2','$signdate')";
			$result_P = mysql_query($query_P);
			if (!$result_P) { error("QUERY_ERROR"); exit; }
			
		}


  echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_store.php'>");
  exit;
  

 
}

}
?>