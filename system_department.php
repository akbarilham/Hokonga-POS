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

$link_list = "$home/system_department.php";
$link_post = "$home/system_department_post.php";
$link_upd = "$home/system_department_upd.php";
$link_del = "$home/system_department_del.php";
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
            <?=$txt_sys_department_01?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		<section id="unseen">
		<table class="table table-bordered table-condensed">
<?
echo ("
		<tr height=22>
			<td align=center bgcolor=#EFEFEF>$txt_sys_category_05</td>
			<td colspan=2 align=center bgcolor=#EFEFEF>$txt_sys_category_06 1</td>
			<td colspan=2 align=center bgcolor=#EFEFEF>$txt_sys_category_06 2</td>
		</tr>");

		$big_cat_array = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", 
						"21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", 
						"41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", 
						"61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", 
						"81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99");


		// Main Category
		$big_query = "SELECT * FROM dept_catgbig ORDER BY lcode";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);
		
		$j=0;
  
		while($big_row = mysql_fetch_object($big_result)) {

		  	$big_code = $big_row->lcode;
		  	$big_name = $big_row->lname;
		  	  $big_name = stripslashes($big_name);
		  	
		  	$j2 = $j + 1;
		  	
		  	
		  	// Mid-category
		  	$mid_query = "SELECT * FROM dept_catgmid WHERE lcode = '$big_code' ORDER BY mcode";
		  	$mid_result = mysql_query($mid_query);
		  	if (!$mid_result) {
		     		error("QUERY_ERROR");
		     		exit;
		  	}   
		  	$mid_rows = mysql_num_rows($mid_result);
    
			// Main Category Update
			echo ("
			<form name='formB' method='post' action='$home/process_dept_updB.php'>
			<input type='hidden' name='lang' value='$lang'>
			<input type='hidden' name='gate' value='$login_gate'>
			<input type='hidden' name='mode' value='big'>
			
			<tr>
			<td rowspan=$mid_rows>
				<table width=100% cellspacing=0 cellpadding=0 border=0>
				<tr>
					<td height=16>($big_code) 
						<input type=text size=16 name='bname' value=\"$big_name\" $box_style>
						<input type=hidden name='bcode' value=\"$big_code\">
					</td>

					<td>
						<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>&nbsp;");
						if($j2 == $big_rows) {
							echo("<a href='$home/process_dept_del.php?lang=$lang&mode=big&bcode=$big_code&bname=$big_name&gate=$gate'>$txt_comm_frm13</a>");
						} else {
							echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
						}
			
						echo("
					</td>
				</tr>
				</table>
			</td>
			</form>
			");

		  	$i=0;

		  	while($mid_row = mysql_fetch_object($mid_result)) {

					$m_code = $mid_row->mcode;
					$m_name = $mid_row->mname;
				    $m_name = stripslashes($m_name);
				    $i2 = $i + 1;

		    	if($i == 0) {
		      	echo ("
				<form name='formM' method='post' action='$home/process_dept_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$login_gate'>
				<input type='hidden' name='mode' value='form'>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td height=16>($m_code)
							<input type=text size=16 name='new_mname' value=\"$m_name\" style='height:24px; WIDTH: 140px'>
							<input type=hidden name='new_mcode' value=\"$m_code\"> ");
				
							if($ss_mcode != $m_code) { echo ("
								<a href='system_department.php?lang=$lang&ss_mode=add&ss_mcode=$m_code'><i class='fa fa-pencil'></i> Add</a>");
							} echo ("
						</td>

						<td align=right>
							<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>&nbsp;");
				
							if($i2 == $mid_rows) {
								echo("<a href='$home/process_dept_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a>");
							} else {
								echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
							}
				
							echo("
						</td>
					</tr>
					</form>");

					echo ("
					</table>
        
				</td>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>");
				
					// Small Category
					$sml_query = "SELECT * FROM dept_catgsml WHERE lcode = '$big_code' AND mcode = '$m_code' ORDER BY scode";
					$sml_result = mysql_query($sml_query);
						if (!$sml_result) {	error("QUERY_ERROR");	exit;	}   
					$sml_rows = mysql_num_rows($sml_result);
					
					// SS CATG Update
					while($sml_row = mysql_fetch_object($sml_result)) {

						$s_code = $sml_row->scode;
						$s_name = $sml_row->sname;
							$s_name = stripslashes($s_name);
				
						echo ("
						<form name='formSU1' method='post' action='$home/process_dept_updS.php'>
						<input type='hidden' name='lang' value='$lang'>
						<input type='hidden' name='gate' value='$login_gate'>
						<input type='hidden' name='m_catg' value='$m_code'>
						<input type='hidden' name='new_scode' value='$s_code'>
						<tr>
							<td height=16>($s_code) <input type=text size=16 name='new_sname' value='$s_name' style='height:24px; WIDTH: 160px'></td>
							<td align=right>
								<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>
								<a href='$home/process_dept_delS.php?lang=$lang&scode=$s_code&gate=$login_gate'>$txt_comm_frm13</a>
							</td>
						</tr>
						</form>");
					}
				
					// Add SS CATG
					if($ss_mode == "add" AND $ss_mcode == $m_code) {
					echo ("
					<form name='formS1' method='post' action='$home/process_dept_addS.php'>
					<input type='hidden' name='lang' value='$lang'>
					<input type='hidden' name='gate' value='$login_gate'>
					<input type='hidden' name='m_catg' value='$m_code'>
					<tr>
						<td height=16 align=center>&nbsp; + &nbsp;<input type=text size=16 name='new_sname' style='height:24px; WIDTH: 160px'></td>
						<td align=right><input type='submit' value='$txt_comm_frm01' class='btn btn-default btn-xs'></td>
					</tr>
					</form>
					");
					}
				
				
				
					echo ("
					</table>
				</td>
				</tr>
				");

		    	} else {
		    		
		    	echo ("
				<tr>

				<form name='formM' method='post' action='$home/process_dept_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$gate'>
				<input type='hidden' name='mode' value='form'>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td height=16>($m_code)
							<input type=text size=16 name='new_mname' value=\"$m_name\" style='height:24px; WIDTH: 140px'>
							<input type=hidden name='new_mcode' value=\"$m_code\"> ");
				
							if($ss_mcode != $m_code) { echo ("
								<a href='system_department.php?lang=$lang&ss_mode=add&ss_mcode=$m_code'><i class='fa fa-pencil'></i> Add</a>");
							} echo ("
						</td>
						<td align=right>
							<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>&nbsp;");
				
							if($i2 == $mid_rows) {
								echo("<a href='$home/process_dept_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a>");
							} else {
								echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
							}
				
							echo("
						</td>
					</tr>
					</form>");
				
				

				
					echo ("
					</table>
        
				</td>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>");
					
					// Small Category
					$sml_query = "SELECT * FROM dept_catgsml WHERE lcode = '$big_code' AND mcode = '$m_code' ORDER BY scode";
					$sml_result = mysql_query($sml_query);
						if (!$sml_result) {	error("QUERY_ERROR");	exit;	}   
					$sml_rows = mysql_num_rows($sml_result);
		  	
		  	
					// SS CATG Update
					while($sml_row = mysql_fetch_object($sml_result)) {

						$s_code = $sml_row->scode;
						$s_name = $sml_row->sname;
							$s_name = stripslashes($s_name);
				
						echo ("
						<form name='formSU2' method='post' action='$home/process_dept_updS.php'>
						<input type='hidden' name='lang' value='$lang'>
						<input type='hidden' name='gate' value='$login_gate'>
						<input type='hidden' name='m_catg' value='$m_code'>
						<input type='hidden' name='new_scode' value='$s_code'>
						<tr>
							<td height=16>($s_code) <input type=text size=16 name='new_sname' value='$s_name' style='height:24px; WIDTH: 160px'></td>
							<td align=right>
								<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>
								<a href='$home/process_dept_delS.php?lang=$lang&scode=$s_code&gate=$login_gate'>$txt_comm_frm13</a>
							</td>
						</tr>
						</form>");
					}
				
				
					// Add SS CATG
					if($ss_mode == "add" AND $ss_mcode == $m_code) {
					echo ("
					<form name='formS2' method='post' action='$home/process_dept_addS.php'>
					<input type='hidden' name='lang' value='$lang'>
					<input type='hidden' name='gate' value='$login_gate'>
					<input type='hidden' name='m_catg' value='$m_code'>
					<tr>
						<td height=16 align=center>&nbsp; + &nbsp;<input type=text size=16 name='new_sname' style='height:24px; WIDTH: 160px'></td>
						<td align=right><input type='submit' value='$txt_comm_frm01' class='btn btn-default btn-xs'></td>
					</tr>
					</form>
					");
					}
				
					echo ("
					</table>
				</td>
				</tr>
				");
				
				
    			}
    		

    		
    		
    		
    		
    		
    		

	  		$i++;
			}

  			if($mid_rows == 0) {
    			echo ("<td colspan=4 valign=left>&nbsp;&nbsp;&nbsp; <font color=navy>$txt_sys_category_chk01</font></td></tr>");
  			}
  		$j++;
		}
		echo("
    </table>");
?>			
</section>

		
			<br />
			<div class="form-actions">
				<a href="<?echo("$link_post?gate=$login_gate")?>"><input type="button" value="<?=$txt_sys_category_02?>" class="btn btn-primary"></a>
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

<? } ?>