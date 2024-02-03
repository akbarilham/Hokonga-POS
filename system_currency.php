<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_currency";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_currency.php";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Church, Bootstrap, Responsive">
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
if(!$page) { $page = 1; }

$query = "SELECT count(uid) FROM client_currency";
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
            <?=$txt_sys_bank_13?> : <?=$now_currency1?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tbody>
		<form name='signform1' method='post' action='system_currency.php'>
		<input type='hidden' name='step_next' value='permit_update'>
			
		<?
		$time_limit = 60*60*24*$notify_new_article; 

		$query = "SELECT uid,default_currency,currency_01,currency_01_rate,upd_date,memo FROM client_currency ORDER BY upd_date DESC";
		$result = mysql_query($query);
		if (!$result) {   error("QUERY_ERROR");   exit; }

		$article_num = $total_record - $num_per_page*($page-1);

		for($i = $first; $i <= $last; $i++) {
			$uid = mysql_result($result,$i,0);   
			$default_currency = mysql_result($result,$i,1);
			$currency_01 = mysql_result($result,$i,2);
			$currency_01_rate = mysql_result($result,$i,3);
			$upd_date = mysql_result($result,$i,4);
			$memo = mysql_result($result,$i,5);
   

			echo ("
			<input type='hidden' name='new_uid' value=\"$uid\">

			<tr>
				<td><input type=text name='default_currency' maxlength=3 value=\"$default_currency\" style='text-align: center' class='form-control'></td>
				<td colspan=2>Default Currency</td>
			</tr>
  
			<tr>
				<td><input type=text name='currency_01' maxlength=3 value=\"$currency_01\" style='text-align: center' class='form-control'></td>
				<td><input type=text name='currency_01_rate' maxlength=10 value=\"$currency_01_rate\" style='text-align: center' class='form-control'></td>
				<td>= $now_currency1 1</td>
			</tr>
			
			
			");

			$article_num--;
			}
	
			echo ("</tbody>
			</table>
			</section>");
	
			if($total_record > 0) {
				echo ("<input type='submit' value='$txt_comm_frm05' class='btn btn-primary'>");
			}
			
			echo ("
			</form>");
			
			


	if($total_record < 1) {

	echo ("
	<form name='signform2' method='post' action='system_currency.php'>
	<input type='hidden' name='step_next' value='permit_post'>
	<input type='submit' value='Create Currency Table' class='btn btn-primary'>

	</form>");
	
	}
	?>

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
} else if($step_next == "permit_post") {

	// if($login_branch != "") {

		$query_W1 = "INSERT INTO client_currency (uid, default_currency, currency_01, currency_01_rate, gate, branch_code) 
					VALUES ('', 'IDR', 'USD', '0.00076', '$login_gate', '$login_branch')";
		$result_W1 = mysql_query($query_W1);
		if (!$result_W1) { error("QUERY_ERROR"); exit; }
	
	// }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_currency.php'>");
  exit;
  

} else if($step_next == "permit_update") {

		$result1 = mysql_query("UPDATE client_currency SET default_currency = '$default_currency', 
				currency_01 = '$currency_01', currency_01_rate = '$currency_01_rate' WHERE uid = '$new_uid'");
		if (!$result1) { error("QUERY_ERROR"); exit;	}
	

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_currency.php'>");
  exit;


}

}
?>