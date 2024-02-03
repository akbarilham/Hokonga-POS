<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_item";

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
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_item.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="data_item" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Selection</label>
                                        <div class="col-sm-9">
                                            <input type="radio" name="job_slct" value="1" checked> Preview &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="2"> Restore now &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="3"> <font color=red>Delete All Data</font>
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="Submit">
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
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	if($job_slct == "3") {
		
		$query_del1 = "DELETE FROM shop_product_catg";
		$result_del1 = mysql_query($query_del1);
		if(!$result_del1) { error("QUERY_ERROR"); exit; }
		
		$query_del2 = "DELETE FROM shop_product_catg_unit";
		$result_del2 = mysql_query($query_del2);
		if(!$result_del2) { error("QUERY_ERROR"); exit; }
		
		$query_del3 = "DELETE FROM shop_product_list";
		$result_del3 = mysql_query($query_del3);
		if(!$result_del3) { error("QUERY_ERROR"); exit; }
		
		$query_del4 = "DELETE FROM shop_product_list_do";
		$result_del4 = mysql_query($query_del4);
		if(!$result_del4) { error("QUERY_ERROR"); exit; }
		
		$query_del5 = "DELETE FROM shop_product_list_qty";
		$result_del5 = mysql_query($query_del5);
		if(!$result_del5) { error("QUERY_ERROR"); exit; }
		
		$query_del6 = "DELETE FROM shop_product_list_shop";
		$result_del6 = mysql_query($query_del6);
		if(!$result_del6) { error("QUERY_ERROR"); exit; }
		
	echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item.php'>");
	exit;
	
	} else if($job_slct == "2") {
  

		$queryC2 = "SELECT count(num) FROM temp_table_item2";
		$resultC2 = mysql_query($queryC2);
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,pcode,pname,catgbig,catgmid,catgsml,condi,barcode FROM temp_table_item2 ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
      
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
				$R_pcode_exp = explode("'",$R_pcode);
				$R_pcode1 = $R_pcode_exp[0];
			$R_pname = mysql_result($resultD2,$ra,2);
				$R_pname2 = addslashes($R_pname);
			$R_catg1_name = mysql_result($resultD2,$ra,3);
				$R_catg1_name_exp = explode("'",$R_catg1_name);
				$R_catg1_name1 = $R_catg1_name_exp[0];
			$R_catg2_name = mysql_result($resultD2,$ra,4);
				$R_catg2_name_exp = explode("'",$R_catg2_name);
				$R_catg2_name1 = $R_catg2_name_exp[0];
			$R_catg3_name = mysql_result($resultD2,$ra,5);
				$R_catg3_name_exp = explode("'",$R_catg3_name);
				$R_catg3_name1 = $R_catg1_name_exp[0];
			$R_condi = mysql_result($resultD2,$ra,6);
			$R_barcode = mysql_result($resultD2,$ra,7);
			
			// Condition
			if($R_condi == "Going") {
				$R_condi_code = "1";
			} else if($R_condi == "Discontinued") {
				$R_condi_code = "2";
			} else if($R_condi == "Stop") {
				$R_condi_code = "3";
			} else {
				$R_condi_code = "1";
			}
			
			// Category
			$c1_query = "SELECT lcode FROM shop_catgbig WHERE lang = 'en' AND lname = '$R_catg1_name'";
			$c1_result = mysql_query($c1_query);
				if (!$c1_result) { error("QUERY_ERROR"); exit; }
			$R_lcode = @mysql_result($c1_result,0,0);
			
			$c2_query = "SELECT mcode FROM shop_catgmid WHERE lang = 'en' AND lcode = '$R_lcode' AND mname = '$R_catg2_name'";
			$c2_result = mysql_query($c2_query);
				if (!$c2_result) { error("QUERY_ERROR"); exit; }
			$R_mcode = @mysql_result($c2_result,0,0);
			
			$c3_query = "SELECT scode FROM shop_catgsml WHERE lang = 'en' AND mcode = '$R_mcode' AND sname = '$R_catg3_name'";
			$c3_result = mysql_query($c3_query);
				if (!$c3_result) { error("QUERY_ERROR"); exit; }
			$R_scode = @mysql_result($c3_result,0,0);
			
			$R_catg_code = $R_scode;


			
			// New Product Code
			$R_num5 = sprintf("%05d", $R_num); // 5자리수
    
			$new_gcode = "$R_catg_code"."$R_num5";
			$new_pcode = $new_gcode . "01";

			
			// Price
			$new_price_orgin = $R_price * 0.8;
				$new_price_orgin = round($new_price_orgin);
			$new_price_market = $R_price * 1.2;
			$new_price_sale = $R_price;
				$new_price_market = round($new_price_market);
			$new_price_margin = $new_price_sale - $new_price_orgin;
		  
			// PT
			$new_branch_code = "CORP_02"; // JSI
			$new_gudang_code = "WH_02"; // Gudang Pusat - JSI
			$new_supp_code = "F0001"; // Lock&Lock - JSI
			$new_client = "jsisco"; // SCO - JSI
			
			// Brand
			$new_brand_code = "01";
			
			
	  
			
			
			// Remove
			
			
			
			// Duplication Check
			$dp_query = "SELECT count(org_pcode) FROM shop_product_list WHERE org_pcode = '$R_pcode' ORDER BY pcode DESC";
			$dp_result = mysql_query($dp_query);
				if (!$dp_result) { error("QUERY_ERROR"); exit; }
			$count_pcode = @mysql_result($dp_result,0,0);
			
			echo ("Writing now ... ($R_num) [ $R_catg_code / $new_brand_code ] [$new_gcode] $new_pcode ($R_condi_code) - $R_pname2<br>");
			
			
			// Update & Insert
			
			if($R_num > "0") {
			if($count_pcode > "0") {
				
				$result_U1 = mysql_query("UPDATE shop_product_list SET gname = '$R_pname2', pname = '$R_pname2', catg_code = '$R_catg_code', condi = '$R_condi_code' WHERE org_pcode = '$R_pcode'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
				
				/*
				$result_U2 = mysql_query("UPDATE shop_product_list_qty SET gname = '$R_pname2', pname = '$R_pname2' WHERE org_pcode = '$R_pcode'");
				if(!$result_U2) { error("QUERY_ERROR"); exit; }
				$result_U3 = mysql_query("UPDATE shop_product_list_shop SET gname = '$R_pname2', pname = '$R_pname2' WHERE org_pcode = '$R_pcode'");
				if(!$result_U3) { error("QUERY_ERROR"); exit; }
				*/
			}
			}

			
		}
		
	echo("<meta http-equiv='Refresh' content='30; URL=$home/restore_item.php'>");
	exit;
	
	
	
	} else if($job_slct == "1") {
  

		$queryC2 = "SELECT count(num) FROM temp_table_item2";
		$resultC2 = mysql_query($queryC2);
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT num,pcode,pname,catgbig,catgmid,catgsml,condi,barcode FROM temp_table_item2 ORDER BY num ASC";
		$resultD2 = mysql_query($queryD2);
      
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_num = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
				$R_pcode_exp = explode("'",$R_pcode);
				$R_pcode1 = $R_pcode_exp[0];
			$R_pname = mysql_result($resultD2,$ra,2);
				$R_pname2 = addslashes($R_pname);
			$R_catg1_name = mysql_result($resultD2,$ra,3);
				$R_catg1_name_exp = explode("'",$R_catg1_name);
				$R_catg1_name1 = $R_catg1_name_exp[0];
			$R_catg2_name = mysql_result($resultD2,$ra,4);
				$R_catg2_name_exp = explode("'",$R_catg2_name);
				$R_catg2_name1 = $R_catg2_name_exp[0];
			$R_catg3_name = mysql_result($resultD2,$ra,5);
				$R_catg3_name_exp = explode("'",$R_catg3_name);
				$R_catg3_name1 = $R_catg1_name_exp[0];
			$R_condi = mysql_result($resultD2,$ra,6);
			$R_barcode = mysql_result($resultD2,$ra,7);
			
			// Condition
			if($R_condi == "Going") {
				$R_condi_code = "1";
			} else if($R_condi == "Discontinued") {
				$R_condi_code = "2";
			} else if($R_condi == "Stop") {
				$R_condi_code = "3";
			} else {
				$R_condi_code = "1";
			}
			
			// Category
			$c1_query = "SELECT lcode FROM shop_catgbig WHERE lang = 'en' AND lname = '$R_catg1_name'";
			$c1_result = mysql_query($c1_query);
				if (!$c1_result) { error("QUERY_ERROR"); exit; }
			$R_lcode = @mysql_result($c1_result,0,0);
			
			$c2_query = "SELECT mcode FROM shop_catgmid WHERE lang = 'en' AND lcode = '$R_lcode' AND mname = '$R_catg2_name'";
			$c2_result = mysql_query($c2_query);
				if (!$c2_result) { error("QUERY_ERROR"); exit; }
			$R_mcode = @mysql_result($c2_result,0,0);
			
			$c3_query = "SELECT scode FROM shop_catgsml WHERE lang = 'en' AND mcode = '$R_mcode' AND sname = '$R_catg3_name'";
			$c3_result = mysql_query($c3_query);
				if (!$c3_result) { error("QUERY_ERROR"); exit; }
			$R_scode = @mysql_result($c3_result,0,0);
			
			$R_catg_code = $R_scode;
			$R_barcode = "";


			
			// New Product Code
			$R_num5 = sprintf("%05d", $R_num); // 5자리수
    
			$new_gcode = "$R_catg_code"."$R_num5";
			$new_pcode = $new_gcode . "01";

			
			// Price
			$new_price_orgin = $R_price * 0.8;
				$new_price_orgin = round($new_price_orgin);
			$new_price_market = $R_price * 1.2;
			$new_price_sale = $R_price;
				$new_price_market = round($new_price_market);
			$new_price_margin = $new_price_sale - $new_price_orgin;
		  
			// PT
			$new_branch_code = "CORP_02"; // JSI
			$new_gudang_code = "WH_02"; // Gudang Pusat - JSI
			$new_supp_code = "F0001"; // Lock&Lock - JSI
			$new_client = "jsisco"; // SCO - JSI
			
			// Brand
			$new_brand_code = "01";
			

			
			// Remove
			
			
			
			// Duplication Check
			$dp_query = "SELECT count(org_pcode) FROM shop_product_list WHERE org_pcode = '$R_pcode' ORDER BY pcode DESC";
			$dp_result = mysql_query($dp_query);
				if (!$dp_result) { error("QUERY_ERROR"); exit; }
			$count_pcode = @mysql_result($dp_result,0,0);
			
			echo ("Writing now ... ($R_num) [ $R_catg_code / $new_brand_code ] [$new_gcode] $new_pcode ($R_condi_code) - $R_pname2<br>");
			
			
			// Update & Insert
			
			if($R_num > "0") {
				
			if($count_pcode > "0") {
			
				$result_U1 = mysql_query("UPDATE shop_product_list SET gname = '$R_pname2', pname = '$R_pname2', catg_code = '$R_catg_code', condi = '$R_condi_code' 
							WHERE org_pcode = '$R_pcode'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
				
				/*
				$result_U2 = mysql_query("UPDATE shop_product_list_qty SET gname = '$R_pname2', pname = '$R_pname2', gcode = '$new_gcode' WHERE org_pcode = '$R_pcode'");
				if(!$result_U2) { error("QUERY_ERROR"); exit; }
				$result_U3 = mysql_query("UPDATE shop_product_list_shop SET gname = '$R_pname2', pname = '$R_pname2', gcode = '$new_gcode' WHERE org_pcode = '$R_pcode'");
				if(!$result_U3) { error("QUERY_ERROR"); exit; }
				*/
			
			} else {
				
				if($R_catg_code > "0") {
				
				// Generate Group
				$query_G = "INSERT INTO shop_product_catg (uid,branch_code,gate,catg_code,brand_code,pcode,org_pcode,org_barcode,pname,condi) 
							values ('','$new_branch_code','$new_client','$R_catg_code','$new_brand_code','$new_gcode','$R_pcode','$R_barcode','$R_pname2','$R_condi_code')";
				$result_G = mysql_query($query_G);
				if (!$result_G) { error("QUERY_ERROR"); exit; }
				
				// Generate Item
				$query_P = "INSERT INTO shop_product_list (uid,catg_uid,branch_code,gudang_code,supp_code,
							gate,shop_code,catg_code,brand_code,gcode,pcode,org_pcode,org_barcode,gname,pname,condi,
							price_orgin,price_market,price_sale,price_sale2,price_margin) values ('','$new_catg_uid','$new_branch_code','$new_gudang_code','$new_supp_code',
							'$new_client','','$R_catg_code','$new_brand_code','$new_gcode','$new_pcode','$R_pcode','$R_barcode','$R_pname2','$R_pname2','$R_condi_code',
							'$new_price_orgin','$new_price_market','$new_price_sale','$new_price_sale','$new_price_margin')";
				$result_P = mysql_query($query_P);
				if (!$result_P) { error("QUERY_ERROR"); exit; }
			
			
				$uid_query = "SELECT uid FROM shop_product_list WHERE pcode = '$new_pcode' ORDER BY uid DESC";
				$uid_result = mysql_query($uid_query);
				if (!$uid_result) { error("QUERY_ERROR"); exit; }
				$new_org_uid = @mysql_result($uid_result,0,0);
			
				/*
				$query_S1 = "INSERT INTO shop_product_list_qty (uid,branch_code,catg_code,brand_code,gcode,pcode,org_pcode,org_barcode,gudang_code,supp_code,
							org_uid,stock,date,price_orgin,ini) values ('','$new_branch_code','$R_catg_code','$new_brand_code','$new_gcode','$new_pcode',
							'$R_pcode','$R_barcode','$new_gudang_code','$new_supp_code','$new_org_uid','0','$post_dates','$new_price_orgin','1')";
				$result_S1 = mysql_query($query_S1);
				if (!$result_S1) { error("QUERY_ERROR"); exit; }
			
				$query_SH2 = "INSERT INTO shop_product_list_shop (uid,branch_code,catg_code,brand_code,shop_code,gcode,pcode,org_pcode,org_barcode,
							qty_org,qty_now,store_date,ini) values ('','$new_branch_code','$R_catg_code','$new_brand_code','','$new_gcode','$new_pcode',
							'$R_pcode','$R_barcode','0','0','$post_dates','1')";
				$result_SH2 = mysql_query($query_SH2);
				if (!$result_SH2) { error("QUERY_ERROR"); exit; }
				*/
				
				}
			
			}
			
			}

			
		}
		
	echo("<meta http-equiv='Refresh' content='30; URL=$home/restore_item.php'>");
	exit;
	}

 
}

}
?>