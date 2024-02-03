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
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_store_sa.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="data_store_SA" />
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
  

		$queryC2 = "SELECT count(store) FROM temp_table_store_sa";
		$resultC2 = mysql_query($queryC2);
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT sa_name,sa_gender,regis_date,sgroup,store,area2,area,spt FROM temp_table_store_sa ORDER BY sa_num ASC";
		$resultD2 = mysql_query($queryD2);
      
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_name = mysql_result($resultD2,$ra,0);
				$R_name = addslashes($R_name);
			$R_gndr = mysql_result($resultD2,$ra,1);
			$R_date = mysql_result($resultD2,$ra,2);
			$R_group = mysql_result($resultD2,$ra,3);
			$R_store = mysql_result($resultD2,$ra,4);
				$R_store_name = addslashes($R_store);
				$R_store_ex = explode(" ",$R_store);
				$R_store2 = "$R_store_ex[0]"." "."$R_store_ex[1]"." "."$R_store_ex[2]";
			$R_area2 = mysql_result($resultD2,$ra,5);
			$R_area = mysql_result($resultD2,$ra,6);
			$R_pt = mysql_result($resultD2,$ra,7);
			
			
			// Gender
			if($R_gndr == "Laki - laki") {
				$R_gender = "M";
			} else {
				$R_gender = "F";
			}
			
			// Regis. Date
			$R_date_ex = explode("-",$R_date);
			$R_date_d = $R_date_ex[0];
				$R_date_dd = sprintf("%02d", $R_date_d); // 2자리수
			$R_date_m = $R_date_ex[1];
				$R_date_mm = sprintf("%02d", $R_date_m); // 2자리수
			$R_date_yyyy = $R_date_ex[2];
			
			$R_regis_date = "$R_date_yyyy"."-"."$R_date_mm"."-"."$R_date_dd";
			
			
			
			// PT Code
			if($R_pt == "JSI") {
				$new_pt_code = "CORP_02";
			} else if($R_pt == "CVJ") {
				$new_pt_code = "CORP_03";
			} else if($R_pt == "LLJ") {
				$new_pt_code = "CORP_04";
			} else if($R_pt == "FBI") {
				$new_pt_code = "CORP_05";
			} else if($R_pt == "Dorco") {
				$new_pt_code = "CORP_06";
			} else if($R_pt == "I And") {
				$new_pt_code = "CORP_07";
			} else {
				$new_pt_code = "CORP_01";
			}
			
			
			// User ID
			$R_name_ex = explode(" ",$R_name);
			$R_name1 = $R_name_ex[0]; // 1st name
			$R_name2 = $R_name_ex[1]; // 2nd name
			$R_name3 = $R_name_ex[2]; // 3rd name
			
			if($R_name1 == "M.") {
				$R_temp_id = $R_name2;
			} else if($R_name1 == "M") {
				$R_temp_id = $R_name2.$R_name3;
			} else if($R_name1 == "Ni" OR $R_name1 == "Al" OR $R_name1 == "Ai" OR $R_name1 == "Tri" OR $R_name1 == "Mad" OR $R_name1 == "Umi" 
				OR $R_name1 == "Ita" OR $R_name1 == "Iis" OR $R_name1 == "Eka" OR $R_name1 == "Via" OR $R_name1 == "Ade" OR $R_name1 == "Nur" 
				OR $R_name1 == "Ida" OR $R_name1 == "Edi" OR $R_name1 == "Iin" OR $R_name1 == "Ira" OR $R_name1 == "Sri" OR $R_name1 == "Dwi" 
				OR $R_name1 == "Irma" OR $R_name1 == "Johan") {
				$R_temp_id = $R_name1.$R_name2;
			} else {
				$R_temp_id = $R_name1;
			}
			
			$R_temp_id = strtolower($R_temp_id) ; // Lower Cast
			$R_temp_id = substr($R_temp_id,0,12);
			
			$dp_query = "SELECT count(id) FROM member_staff WHERE id = '$R_temp_id' ORDER BY id DESC";
			$dp_result = mysql_query($dp_query);
				if (!$dp_result) { error("QUERY_ERROR"); exit; }
			$count_id = @mysql_result($dp_result,0,0);
			
			if($count_id > "0") {
				$R_user_id = "$R_temp_id"."2";
			} else {
				$R_user_id = $R_temp_id;
			}
			
			// Code
			$staff_code = $signdate + $ra;
			
			
			// Consignment Group Code
			if($R_group == "FARMER MARKET" OR $R_group == "FARMERMARKET") {
				$R_group = "FARMERS MARKET";
			}
			
			$pg_query = "SELECT group_code FROM client_consign WHERE group_name = '$R_group'";
			$pg_result = mysql_query($pg_query);
				if (!$pg_result) { error("QUERY_ERROR"); exit; }
			$con_group_code = @mysql_result($pg_result,0,0);
			
			// Shop Code
			$rm_query = "SELECT shop_code FROM client_shop WHERE associate = '1' AND shop_name LIKE '$R_store2%'";
			$rm_result = mysql_query($rm_query);
				if (!$rm_result) { error("QUERY_ERROR"); exit; }
			$con_shop_code = @mysql_result($rm_result,0,0);
			
			
			// Area
			if($R_area == "Sumatra") {
				$R_area = "Sumatera";
			}
			if($R_area2 == "Balik Papan") {
				$R_area2 = "Balikpapan";
			}
			
			$query_AR2 = "SELECT area_code FROM code_area WHERE area_name = '$R_area' AND area_name2 = '$R_area2' ORDER BY area_code ASC";
			$result_AR2 = mysql_query($query_AR2);
				if (!$result_AR2) { error("QUERY_ERROR"); exit; }
			$sh_area_code = @mysql_result($result_AR2,0,0);
  
			
			// Gate
			$gt_query = "SELECT client_id FROM client WHERE branch_code = '$new_pt_code' AND associate = '1' AND userlevel = '5' ORDER BY client_id ASC";
			$gt_result = mysql_query($gt_query);
				if (!$gt_result) { error("QUERY_ERROR"); exit; }
			$new_gate_code = @mysql_result($gt_result,0,0);
			
			// Test
			echo ("$ra. $R_user_id ==== $R_name [$R_gender] ------ $R_regis_date [$new_pt_code] ==== [$con_group_code] $con_shop_code ====&gt; $sh_area_code <br>");

			
			// Insert [member_staff]
		

				$R_name_f = addslashes($R_name);
				
				$query_P = "INSERT INTO member_staff (uid,branch_code,gate,ctr_sa,ctr_branch_code,name,code,id,gender,
						userlevel,signdate,nationality_code,regis_date) values ('','CORP_07','inin','1','$new_pt_code','$R_name_f',
						'$staff_code','$R_user_id','$R_gender','1','$signdate','in','$R_regis_date')";
				$result_P = mysql_query($query_P);
				if (!$result_P) { error("QUERY_ERROR"); exit; }

				$query_M1 = "INSERT INTO admin_user (uid,branch_code,gate,subgate,staff_sync,staff_id,user_id,
						user_name,user_email,user_website,user_level,signdate,shop_flag,shop_code) 
						values ('','$new_pt_code','$new_gate_code','$new_gate_code','1','$R_user_id','$R_user_id',
						'$R_name_f','','','1','$signdate','1','$con_shop_code')";
				$result_M1 = mysql_query($query_M1);
				if (!$result_M1) { error("QUERY_ERROR"); exit; }
		
			
			
			
		}


  echo("<meta http-equiv='Refresh' content='20; URL=$home/restore_store_sa.php'>");
  exit;
  

 
}

}
?>