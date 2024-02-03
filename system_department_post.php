<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_department";

if(!strcmp($room,"")) {
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
            <?=$txt_sys_department_01?> &gt; <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">

		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
		<?
		echo ("
		<form name='signform1' method='post' action='system_department_post.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='room' value='addcatg'>


		<thead>
		<tr>
			<th>$txt_sys_category_05</th>
			<th width=50>$txt_comm_frm19</th>
		</tr>
     	</thead>
		
		<tbody>");

		
		$big_cat_array = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", 
						"21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", 
						"41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", 
						"61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", 
						"81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99");

		$big_query = "SELECT * FROM dept_catgbig ORDER BY lcode";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);
  
		while($big_row = mysql_fetch_object($big_result)) {

			$big_code = $big_row->lcode;
			$big_name = $big_row->lname;
			  $big_name = stripslashes($big_name);
  
  			echo ("
			<tr>
         		<td>($big_code) $big_name</td>
         		<td width=50 align=center><input type=radio name=b_code value=\"$big_code$big_name\"></td>
			</tr>
			");
		}

		// Add Main Category
		$i=0;
		while($big_cat_array[$i]) {

			if($big_cat_array[$i] == $big_code) {   
			$i++;
			echo ("
			<tr>
			<td><input type='text' name='add_code' value='$big_cat_array[$i]' size=5 maxlength=2> <input type=text name=b_name></td>
			<td width=50 align=center>
				<input type=radio name=b_code value=add checked>
				<input type=hidden name=gate value=$gate>
			</td>
			</tr>
			");
  			break;
			}
		$i++;
		}

		// Default Entry
		if($big_rows == 0) {
		echo ("
		<tr>
		<td>($big_cat_array[0]) <input type=text name=b_name></td>
		<td width=50 align=center>
			<input type=radio name=b_code value=add checked>
			<input type=hidden name=add_code value=$big_cat_array[0]>
			<input type=hidden name=gate value=$gate>
		</td>
		</tr>
		");
		}

		?>

		</tbody>
		</table>
		</section>
		
		<br />
			<div class="form-actions">
				<input type="submit" value="<?=$txt_comm_frm18?>" class="btn btn-primary"></a>
			</div>
			</form>
		
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
} else if(!strcmp($room,"addcatg")) {

  	if($b_code == "add") {
	
	    $b_name = addslashes($b_name);
	
	    $query_L1  = "INSERT INTO dept_catgbig (lcode, lname, lang, branch_code) VALUES ('$add_code','$b_name','$lang','$login_branch')";
	    $result_L1 = mysql_query($query_L1,$dbconn);
	    if(!$result_L1) { error("QUERY_ERROR"); exit; }
	
      echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php?gate=$login_gate'>");
      exit;

	} // the end of if($b_code == "add")
  
	// Mid-category
	$b_name = substr($b_code, 2);
	$b_code = substr($b_code, 0,2);
	
	$b_name = stripslashes($b_name);
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
            <?=$txt_sys_department_01?> &gt; <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
		<?
		echo ("
		<table class='display table table-bordered table-striped'>
		<form name='signform2' method='post' action='system_department_post.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='room' value='process'>


		<thead>
		<tr>
			<th>$txt_sys_category_05 : ($b_code) $b_name</th>
		</tr>
     	</thead>
		
		<tbody>");

		
		$mid_query = "SELECT * FROM dept_catgmid WHERE lcode = '$b_code' ORDER BY mcode";
		$mid_result = mysql_query($mid_query);

			if (!$mid_result) {
			error("QUERY_ERROR");
			exit;
			}
    
		$mid_rows = mysql_num_rows($mid_result);

		while($mid_row = mysql_fetch_object($mid_result)) {

			$mid_code = $mid_row->mcode;
			$mid_name = $mid_row->mname;
			  $mid_name = stripslashes($mid_name);
			  
  	  		echo ("<tr><td>($mid_code) $mid_name</td></tr>");

		}

		$new_num = $mid_rows + 1;
		$new_num = sprintf("%02d", $new_num);

		echo ("
		<tr>
		<td>($b_code$new_num) 
			<input type=text name=m_name>
			<input type=hidden name=addcode value=$b_code$new_num>
			<input type=hidden name=gate value=$gate>
		</td>
		</tr>");
		?>

		</tbody>
		</table>
		
		<br />
			<div class="form-actions">
				<input type="submit" value="<?=$txt_comm_frm18?>" class="btn btn-primary">
			</div>
			</form>
		
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
} else if(!strcmp($room,"process")) {

	$b_code = substr($addcode, 0,2);
	$m_name = addslashes($m_name);

	$query_M1  = "INSERT INTO dept_catgmid (lcode, mcode, mname, lang, branch_code) VALUES ('$b_code','$addcode','$m_name', '$lang', '$login_branch')";
	$result_M1 = mysql_query($query_M1);
		if(!$result_M1) {	error("QUERY_ERROR");	exit;	}


	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_department.php'>");
	exit;


}

}
?>
