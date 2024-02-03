<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_incentive_fbs_cost";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_incentive_fbs_cost.php";
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


						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Incentive Calculation - Feel Buy Shop Costs
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Level 1</th>
            <th>Level 2</th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$query_BC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'out'";
		$result_BC = mysql_query($query_BC);
		if (!$result_BC) { error("QUERY_ERROR"); exit; }
		$total_BC = @mysql_result($result_BC,0,0);
   
   
		$query_B = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'out' ORDER BY catg ASC";
		$result_B = mysql_query($query_B);
		if (!$result_B) {   error("QUERY_ERROR");   exit; }

		for($b = 0; $b < $total_BC; $b++) {
			$fB_uid = mysql_result($result_B,$b,0);
			$fB_class = mysql_result($result_B,$b,1);
			$fB_catg = mysql_result($result_B,$b,2);
   
			$fB_catg_txt = "txt_sys_account_06_"."$fB_catg";
			
			echo("
			<tr>
				<td>($fB_catg) ${$fB_catg_txt}</td>
				<td>
					<table width=100% style='margin: -7px'>");

			
    // 세부 항목 [리스트] - 수정/삭제
    $query_H2C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fB_catg' AND lang = '$lang'";
    $result_H2C = mysql_query($query_H2C);
    if (!$result_H2C) {   error("QUERY_ERROR");   exit; }
    
    $total_H2C = @mysql_result($result_H2C,0,0);
    
    $query_H2 = "SELECT uid,acc_code,acc_name,acc_shop_cost FROM code_acc_list WHERE catg = '$fB_catg' AND lang = '$lang' ORDER BY acc_code ASC";
    $result_H2 = mysql_query($query_H2);
    if (!$result_H2) {   error("QUERY_ERROR");   exit; }
    
    for($h2 = 0; $h2 < $total_H2C; $h2++) {
      $H2_acc_uid = mysql_result($result_H2,$h2,0);   
      $H2_acc_code = mysql_result($result_H2,$h2,1);
      $H2_acc_name = mysql_result($result_H2,$h2,2);
	  $H2_acc_shop_cost = mysql_result($result_H2,$h2,3);
      
  
    echo ("
    <tr>
      <form name='act_updB' method='post' action='system_incentive_fbs_cost.php'>
	  <input type='hidden' name='step_next' value='permit_update'>
      <input type=hidden name='new_acc_uid' value='$H2_acc_uid'>
      <input type=hidden name='new_acc_code' value='$H2_acc_code'>

	  
      <td width=10%>$H2_acc_code</td>
      <td width=80%>&nbsp;&nbsp;&nbsp;");
      
      if($H2_acc_shop_cost == "1") {
        echo ("<input type=checkbox name='new_acc_chk' value='1' checked>");
      } else {
        echo ("<input type=checkbox name='new_acc_chk' value='1'>");
      }
      
      echo ("
      &nbsp;&nbsp;&nbsp; $H2_acc_name
      </td>
      <td width=10%><input type=submit value='$txt_comm_frm12' class='btn btn-default btn-sm'></td>
      </form>
    </tr>");
  
    }
	
				echo ("
				</table>
			</td>
		</tr>");
	
		}
	?>
		
        </tbody>
        </table>
		</section>
		

		
        </div>
		
        </section>
						
						
						
    
    
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
} else if($step_next == "permit_update") {

	
	if(!$new_acc_chk) {
		$new_acc_chk = "0";
	}
	
	
		$result1 = mysql_query("UPDATE code_acc_list SET acc_shop_cost = '$new_acc_chk' WHERE acc_code = '$new_acc_code'");
		if (!$result1) { error("QUERY_ERROR"); exit; }

	
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_incentive_fbs_cost.php'>");
	exit;

}

}
?>