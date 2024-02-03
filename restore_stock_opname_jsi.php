<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_stock_opname_jsi";
$step_next = $_POST['step_next'];
$job_slct = $_POST['job_slct'];
$data_name = $_POST['data_name'];
$no_robot_pw_hidden = $_POST['no_robot_pw_hidden'];
$pin_key = $_POST['pin_key'];

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
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_stock_opname_jsi.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="table_stock_201507_jsi" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Selection</label>
                                        <div class="col-sm-9">
                                            <input type="radio" name="job_slct" value="1" checked> Preview &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="2"> Import Stock Table now &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="3"> Update Stock Table now &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="4"> <font color=red>Delete from Table</font>
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
	// $post_dates = "$post_date1"."$post_date2";
	$post_dates = "20150730100000";
	
	if($job_slct == "4") {
		
		$query_del5 = "DELETE FROM shop_product_list_qty";
		$result_del5 = mysql_query($query_del5);
		if(!$result_del5) { error("QUERY_ERROR"); exit; }
		
		$query_del6 = "DELETE FROM shop_product_list_shop";
		$result_del6 = mysql_query($query_del6);
		if(!$result_del6) { error("QUERY_ERROR"); exit; }
		
		$query_del7 = "DELETE FROM shop_stock_list";
		$result_del7 = mysql_query($query_del7);
		if(!$result_del7) { error("QUERY_ERROR"); exit; }
		
		
		echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_jsi.php'>");
		exit;
	
	
	} else if($job_slct == "3") {
  
		
		$queryC2 = "SELECT count(pnum) FROM table_stock_201507_cvj2";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT pnum,org_pcode,stocks FROM table_stock_201507_cvj2 ORDER BY pnum ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_pnum = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_stores = mysql_result($resultD2,$ra,2);
			
			// Item List
			$query_li = "SELECT uid,supp_code,brand_code,catg_code,gcode,pcode,org_barcode,stock_org,gname,pname 
						FROM shop_product_list WHERE org_pcode = '$R_pcode'";
			$result_li = mysql_query($query_li);
				if (!$result_li) { error("QUERY_ERROR"); exit; }
			$li_uid = @mysql_result($result_li,0,0);
			$li_supp_code = @mysql_result($result_li,0,1);
			$li_brand_code = @mysql_result($result_li,0,2);
			$li_catg_code = @mysql_result($result_li,0,3);
			$li_gcode = @mysql_result($result_li,0,4);
			$li_pcode = @mysql_result($result_li,0,5);
			$li_org_barcode = @mysql_result($result_li,0,6);
			$li_stock_org = @mysql_result($result_li,0,7);
			$li_gname = @mysql_result($result_li,0,8);
			$li_pname = @mysql_result($result_li,0,9);
			
			$sp_opt1 = explode("|", $R_stores);
			
			if($R_total_qty > 0) {
				
				// Branch
				for($br=1;$br<5;$br++) {
					
					if($br == 1) {
						$li_branch_code = "CORP_02";
					} else if($br == 2) {
						$li_branch_code = "CORP_03";
					} else if($br == 3) {
						$li_branch_code = "CORP_04";
					} else if($br == 4) {
						$li_branch_code = "CORP_05";
					}
				
						
						// Warehouse
						$query_gd = "SELECT gudang_code FROM code_gudang WHERE branch_code = '$li_branch_code' ORDER BY gudang_code ASC";
						$result_gd = mysql_query($query_gd);
							if (!$result_gd) { error("QUERY_ERROR"); exit; }
						$li_gudang_code = @mysql_result($result_gd,0,0);
						
						
						// SUM
						$query_sm = "SELECT sum(stock) FROM shop_product_list_qty WHERE branch_code = '$li_branch_code' AND org_pcode = '$R_pcode' AND flag = 'out'";
						$result_sm = mysql_query($query_sm);
							if (!$result_sm) { error("QUERY_ERROR"); exit; }
						$new_stock_sum = @mysql_result($result_sm,0,0);
				
				
						echo ("$R_pnum ... [$R_pcode] $li_branch_code --- $new_stock_sum ($post_dates) ...</br>");
				
						if($new_stock_sum > 0) {
					
							$query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,shop_code,gudang_code,
									catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,stock,stock_check,stock_loss,date,check_date,virtual,ini) 
									values ('','$li_uid','in','$li_branch_code','$li_supp_code','','$li_gudang_code',
									'$li_catg_code','$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$li_gname','$li_pname','$new_stock_sum','0','0',
									'$post_dates','$post_dates','0','1')";
							$result_SH3 = mysql_query($query_SH3);
							if (!$result_SH3) { error("QUERY_ERROR"); exit; }
						
						}

				}

			

			
			}
			
		}
		
		echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_jsi.php'>");
		exit;
	
	
	
	} else if($job_slct == "2") {
  
		
		$queryC2 = "SELECT count(pnum) FROM table_stock_201507_jsi";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT pnum,org_pcode,stocks FROM table_stock_201507_jsi ORDER BY pnum ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
				
		// Fibonacci 
		$angka_sebelumnya=4;
		$angka_sekarang=6;		

		for($ra = 0; $ra < $total_recordC2; $ra++) {
		# for($ra = 0; $ra < 1000; $ra++) {

			$R_pnum = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_stores = mysql_result($resultD2,$ra,2);
			//var_dump($R_stores); die();
			
			// Item List
			$query_li = "SELECT uid,supp_code,brand_code,catg_code,gcode,pcode,org_barcode,stock_org,gname,pname 
						FROM shop_product_list WHERE org_pcode = '$R_pcode'";
			$result_li = mysql_query($query_li);
				if (!$result_li) { error("QUERY_ERROR"); exit; }
			$li_uid = @mysql_result($result_li,0,0);
			$li_supp_code = @mysql_result($result_li,0,1);
			$li_brand_code = @mysql_result($result_li,0,2);
			$li_catg_code = @mysql_result($result_li,0,3);
			$li_gcode = @mysql_result($result_li,0,4);
			$li_pcode = @mysql_result($result_li,0,5);
			$li_org_barcode = @mysql_result($result_li,0,6);
			$li_stock_org = @mysql_result($result_li,0,7);
			$li_gname = @mysql_result($result_li,0,8);
			$li_pname = @mysql_result($result_li,0,9);
			
			$sp_opt1 = explode("|", $R_stores);

			$R_total_qty=$sp_opt1[832];
			//var_dump($sp_opt1[1270]); die();
			if($R_total_qty > 0) {
			//echo 'aku'; die();	
				
				// SUM *
				/*$result_sum = mysql_query("UPDATE shop_product_list SET stock_now = '$R_total_qty' WHERE org_pcode = '$R_pcode'");
				if(!$result_sum) { error("QUERY_ERROR"); exit; }*/
				
				echo ("<br/>$R_pnum ... [$R_pcode] $R_total_qty -- $li_catg_code - [$li_gcode] $li_pcode</br>");
				echo '<br/>------------------------------------------------------------------------------------------<br/>';
				

				# for($o1=0; $o1<count($sp_opt1); $o1++) {
				for($o1=0; $o1<133; $o1++) {
					$num = $o1 + 1;
				
					# if($sp_opt1[$output] > 0) {
					
						if ($output > 794) {
						# Kembali dari awal
								$angka_sebelumnya = 4;
								$angka_sekarang = 6;
								$output = '';
						}
						if ($output == '') {
						# Di mulai dari angka 2
							$angka_sebelumnya = 0;
							$angka_sekarang = 4;
						}	
						if ($output > 0) {
							$angka_sebelumnya = $output;
							$angka_sekarang = 6;
						}

						/*
						if($num > 537) { // WH
				
							if($num == 538) {
								$gd_gudang_code = "WH_02";
							} else if($num == 539) {
								$gd_gudang_code = "WH_06";
							} else if($num == 540) {
								$gd_gudang_code = "WH_07";
							} else if($num == 541) {
								$gd_gudang_code = "WH_08";
							}
						
				
							$query_gd = "SELECT branch_code FROM code_gudang WHERE gudang_code = '$gd_gudang_code'";
							$result_gd = mysql_query($query_gd);
								if (!$result_gd) { error("QUERY_ERROR"); exit; }
							$gd_branch_code = @mysql_result($result_gd,0,0);
							
							// Data Entry
							$query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,shop_code,gudang_code,
									catg_code,gcode,pcode,org_pcode,org_barcode,gname,pname,stock,stock_check,stock_loss,date,check_date,virtual,ini) 
									values ('','$li_uid','in','$gd_branch_code','$li_supp_code','','$gd_gudang_code',
									'$li_catg_code','$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$li_gname','$li_pname',
									'$sp_opt1[$output]','0','0','$post_dates','$post_dates','0','1')";
							$result_SH3 = mysql_query($query_SH3);
							if (!$result_SH3) { error("QUERY_ERROR"); exit; }
							
							$query_dir1 = "INSERT INTO shop_stock_list (uid,branch_code,brand_code,supp_code,shop_code,gudang_code,
									catg_code,gcode,pcode,org_pcode,org_barcode,stock_org,stock_now,gname,pname) 
									values ('','$gd_branch_code','$li_brand_code','$li_supp_code','','$gd_gudang_code',
									'$li_catg_code','$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$sp_opt1[$o1]','$sp_opt1[$o1]','$li_gname','$li_pname')";
							$result_dir1 = mysql_query($query_dir1);
							if (!$result_dir1) { error("QUERY_ERROR"); exit; }
				
							echo (" ---- $num ... [$gd_branch_code][$gd_gudang_code] - $sp_opt1[$o1]</br>");
				
						} else {
						*/

							$query_shop = "SELECT shop_code FROM table_store_name_jsi WHERE num = '$num'";
							$result_shop = mysql_query($query_shop);
							if (!$result_shop) { error("QUERY_ERROR"); exit; }
							$new_shop_code = @mysql_result($result_shop,0,0);

							// Shop List
							$query_sh = "SELECT shop_code,branch_code,associate,group_code FROM client_shop WHERE shop_code= '$new_shop_code' and branch_code='CORP_02'";
							$result_sh = mysql_query($query_sh);
								if (!$result_sh) { error("QUERY_ERROR"); exit; }
							$sh_shop_code = @mysql_result($result_sh,0,0);
							$sh_branch_code = @mysql_result($result_sh,0,1);
							$sh_associate = @mysql_result($result_sh,0,2);
							$sh_group_code = @mysql_result($result_sh,0,3);
							
							// Warehouse
							/*$query_gd = "SELECT gudang_code FROM code_gudang WHERE branch_code = '$sh_branch_code' ORDER BY gudang_code ASC";
							$result_gd = mysql_query($query_gd);
								if (!$result_gd) { error("QUERY_ERROR"); exit; }
							$sh_gudang_code = @mysql_result($result_gd,0,0);*/

							$output = $angka_sekarang + $angka_sebelumnya;
							/*
							# echo '<br/>num nya berapa : '.$num;
							echo "<br/> ---- $num ... [$sh_branch_code][$sh_shop_code] $sh_group_code ( $sh_associate ) - $sp_opt1[$output]</br>";
							echo '<br/>fibonacci = ' .$output; 
							//die();
							*/
							$angka_sebelumnya = $output;
							$angka_sekarang = 6;


							#if($sp_opt1[$output] > 0) {
							
							// Data Entry - Stock-out
							$query_SH1 = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,group_code,shop_code,gudang_code,
								catg_code,brand_code,gcode,pcode,org_pcode,org_barcode,gname,pname,stock,stock_check,stock_loss,date,check_date,virtual,ini) 
								values ('','$li_uid','out','$sh_branch_code','$li_supp_code','$sh_group_code','$sh_shop_code','$sh_gudang_code',
								'$li_catg_code','$li_brand_code','$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$li_gname','$li_pname',
								'$sp_opt1[$output]','0','0','$post_dates','$post_dates','0','1')";
							$result_SH1 = mysql_query($query_SH1);
							if (!$result_SH1) { error("QUERY_ERROR"); exit; }
							
							$query_dir2 = "INSERT INTO shop_stock_list (uid,branch_code,brand_code,supp_code,group_code,shop_code,gudang_code,
									catg_code,gcode,pcode,org_pcode,org_barcode,stock_org,stock_now,gname,pname) 
									values ('','$sh_branch_code','$li_brand_code','$li_supp_code','$sh_group_code','$sh_shop_code','$sh_gudang_code',
									'$li_catg_code','$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$sp_opt1[$output]','$sp_opt1[$output]','$li_gname','$li_pname')";
							$result_dir2 = mysql_query($query_dir2);
							if (!$result_dir2) { error("QUERY_ERROR"); exit; }
				
							// Data Entry - Shop
							$query_SH2 = "INSERT INTO shop_product_list_shop (uid,branch_code,catg_code,brand_code,group_code,shop_code,
								gcode,pcode,org_pcode,org_barcode,gname,pname,qty_org,qty_now,store_date,ini) values 
								('','$sh_branch_code','$li_catg_code','$li_brand_code','$sh_group_code','$sh_shop_code',
								'$li_gcode','$li_pcode','$R_pcode','$li_org_barcode','$li_gname','$li_pname','$sp_opt1[$output]','$sp_opt1[$output]','$post_dates','1')";
							$result_SH2 = mysql_query($query_SH2);
							if (!$result_SH2) { error("QUERY_ERROR"); exit; }
							
							
							
							echo (" ---- $num ... [$sh_branch_code][$sh_shop_code] $sh_group_code ( $sh_associate ) - $sp_opt1[$output]</br>");
							
							# echo (" ---- $num ... [$sh_branch_code][$sh_shop_code] $sh_group_code ( $sh_associate ) - $output</br>");

							#}
				
				#	}
			
				}
			
			}
			
		}
		
		echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_jsi.php'>");
		exit;
	
	} else if($job_slct == "1") {
  
		
		$queryC2 = "SELECT count(pnum) FROM table_ini_stock";
		$resultC2 = mysql_query($queryC2);
			if (!$resultC2) { error("QUERY_ERROR"); exit; }
		$total_recordC2 = @mysql_result($resultC2,0,0);

		$queryD2 = "SELECT pnum,org_pcode,total_qty,stores FROM table_ini_stock ORDER BY pnum ASC";
		$resultD2 = mysql_query($queryD2);
		if (!$resultD2) { error("QUERY_ERROR"); exit; }
		
    
		for($ra = 0; $ra < $total_recordC2; $ra++) {
			$R_pnum = mysql_result($resultD2,$ra,0);
			$R_pcode = mysql_result($resultD2,$ra,1);
			$R_total_qty = mysql_result($resultD2,$ra,2);
			$R_stores = mysql_result($resultD2,$ra,3);
			
			// Item List
			$query_li = "SELECT uid,supp_code,brand_code,catg_code,gcode,pcode,org_barcode,stock_org 
						FROM shop_product_list WHERE org_pcode = '$R_pcode'";
			$result_li = mysql_query($query_li);
				if (!$result_li) { error("QUERY_ERROR"); exit; }
			$li_uid = @mysql_result($result_li,0,0);
			$li_supp_code = @mysql_result($result_li,0,1);
			$li_brand_code = @mysql_result($result_li,0,2);
			$li_catg_code = @mysql_result($result_li,0,3);
			$li_gcode = @mysql_result($result_li,0,4);
			$li_pcode = @mysql_result($result_li,0,5);
			$li_org_barcode = @mysql_result($result_li,0,6);
			$li_stock_org = @mysql_result($result_li,0,7);
							
			
			$sp_opt1 = explode("|", $R_stores);
			
			if($R_total_qty > 0) {
			
				echo ("$R_pnum ... [$R_pcode] $R_total_qty -- $li_catg_code - [$li_gcode] $li_pcode</br>");
			
				for($o1=0; $o1<count($sp_opt1); $o1++) {
					$num = $o1 + 1;
				
					if($sp_opt1[$o1] > 0) {
					
						if($num > 537) { // WH
				
							if($num == 538) {
								$gd_gudang_code = "WH_02";
							} else if($num == 539) {
								$gd_gudang_code = "WH_06";
							} else if($num == 540) {
								$gd_gudang_code = "WH_07";
							} else if($num == 541) {
								$gd_gudang_code = "WH_08";
							}
				
							$query_gd = "SELECT branch_code FROM code_gudang WHERE gudang_code = '$gd_gudang_code'";
							$result_gd = mysql_query($query_gd);
								if (!$result_gd) { error("QUERY_ERROR"); exit; }
							$gd_branch_code = @mysql_result($result_gd,0,0);
							
							
							echo (" ---- $num ... [$gd_branch_code][$gd_gudang_code] - $sp_opt1[$o1]</br>");
				
						} else {
				
							// Shop List
							$query_sh = "SELECT shop_code,branch_code,associate,group_code FROM client_shop WHERE num_tmp = '$num'";
							$result_sh = mysql_query($query_sh);
								if (!$result_sh) { error("QUERY_ERROR"); exit; }
							$sh_shop_code = @mysql_result($result_sh,0,0);
							$sh_branch_code = @mysql_result($result_sh,0,1);
							$sh_associate = @mysql_result($result_sh,0,2);
							$sh_group_code = @mysql_result($result_sh,0,3);
							
							
							
							echo (" ---- $num ... [$sh_branch_code][$sh_shop_code] $sh_group_code ( $sh_associate ) - $sp_opt1[$o1]</br>");
							
					
						}
				
					}
			
				}
			
			}
			
		}									

		echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_stock_opname_jsi.php'>");
		exit;
		
	}

 
}

}
?>
