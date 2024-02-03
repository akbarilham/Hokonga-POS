<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_option";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_option.php";
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
$query = "SELECT count(uid) FROM code_shop_option";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);
?>
    

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_21?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		<? if(!$total_record) { ?>
		
		
			<form name='signform1' class="cmxform form-horizontal adminex-form" method='post' action="inventory_option.php">
			<input type='hidden' name='step_next' value='permit_okay'>
			<input type='hidden' name='key_branch' value='<?=$login_branch?>'>

									<span>&nbsp;</span>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_zonopt_02?>">
                                        </div>
                                    </div>
									
									<span>&nbsp;</span>
			
			</form>
		
		
		
		
		<? } else { ?>
		

			<?
			$query = "SELECT uid,p_opt_name1,p_opt_name2,p_opt_name3,p_opt_name4,p_opt_name5,
						p_option1,p_option2,p_option3,p_option4,p_option5 FROM code_shop_option ORDER BY uid DESC";
			$result = mysql_query($query);
				if (!$result) {   error("QUERY_ERROR");   exit; }

			$p_uid = @mysql_result($result,0,0);
			$p_opt_name1 = @mysql_result($result,0,1);
			$p_opt_name2 = @mysql_result($result,0,2);
			$p_opt_name3 = @mysql_result($result,0,3);
			$p_opt_name4 = @mysql_result($result,0,4);
			$p_opt_name5 = @mysql_result($result,0,5);
			$p_option1 = @mysql_result($result,0,6);
			$p_option2 = @mysql_result($result,0,7);
			$p_option3 = @mysql_result($result,0,8);
			$p_option4 = @mysql_result($result,0,9);
			$p_option5 = @mysql_result($result,0,10);
			?>
			
			<form name='signform2' class="cmxform form-horizontal adminex-form" method='post' action="inventory_option.php">
			<input type='hidden' name='step_next' value='permit_update'>
			<input type='hidden' name='key_branch' value='<?=$login_branch?>'>
			<input type='hidden' name='key_uid' value="<?=$p_uid?>">
			
			
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-2">Option 1</label>
										<div class="col-sm-3">
											<input class="form-control" name="p_opt_name1" value="<?=$p_opt_name1?>" placeholder="<?=$txt_invn_zonopt_03?>" type="text" />
										</div>
										<div class="col-sm-7">
											<input class="form-control" name="p_option1" value="<?=$p_option1?>" placeholder="<?=$txt_invn_zonopt_04?> : <?=$txt_invn_zonopt_05?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-2">Option 2</label>
										<div class="col-sm-3">
											<input class="form-control" name="p_opt_name2" value="<?=$p_opt_name2?>" placeholder="<?=$txt_invn_zonopt_03?>" type="text" />
										</div>
										<div class="col-sm-7">
											<input class="form-control" name="p_option2" value="<?=$p_option2?>" placeholder="<?=$txt_invn_zonopt_04?> : <?=$txt_invn_zonopt_05?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-2">Option 3</label>
										<div class="col-sm-3">
											<input class="form-control" name="p_opt_name3" value="<?=$p_opt_name3?>" placeholder="<?=$txt_invn_zonopt_03?>" type="text" />
										</div>
										<div class="col-sm-7">
											<input class="form-control" name="p_option3" value="<?=$p_option3?>" placeholder="<?=$txt_invn_zonopt_04?> : <?=$txt_invn_zonopt_05?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-2">Option 4</label>
										<div class="col-sm-3">
											<input class="form-control" name="p_opt_name4" value="<?=$p_opt_name4?>" placeholder="<?=$txt_invn_zonopt_03?>" type="text" />
										</div>
										<div class="col-sm-7">
											<input class="form-control" name="p_option4" value="<?=$p_option4?>" placeholder="<?=$txt_invn_zonopt_04?> : <?=$txt_invn_zonopt_05?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-2">Option 5</label>
										<div class="col-sm-3">
											<input class="form-control" name="p_opt_name5" value="<?=$p_opt_name5?>" placeholder="<?=$txt_invn_zonopt_03?>" type="text" />
										</div>
										<div class="col-sm-7">
											<input class="form-control" name="p_option5" value="<?=$p_option5?>" placeholder="<?=$txt_invn_zonopt_04?> : <?=$txt_invn_zonopt_05?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm27?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
			
			</form>
		
		
		<? } ?>
        
		
		
		
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

    // 기초 데이터 입력
    $query_M2 = "INSERT INTO code_shop_option (uid,branch_code) values ('','$login_branch')";
    $result_M2 = mysql_query($query_M2);
    if (!$result_M2) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_option.php?key=$key_zone'>");
  exit;


} else if($step_next == "permit_update") {

    // 데이터 수정
    $query_M1 = "UPDATE code_shop_option SET p_opt_name1 = '$p_opt_name1', p_opt_name2 = '$p_opt_name2',
                p_opt_name3 = '$p_opt_name3', p_opt_name4 = '$p_opt_name4', p_opt_name5 = '$p_opt_name5',
                p_option1 = '$p_option1', p_option2 = '$p_option2', p_option3 = '$p_option3', 
                p_option4 = '$p_option4', p_option5 = '$p_option5' WHERE uid = '$key_uid'";
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_option.php'>");
  exit;


}

}
?>