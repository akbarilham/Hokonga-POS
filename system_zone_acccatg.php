<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_zone_acccatg";

$link_list = "$home/system_zone_acccatg.php";
$link_post = "$home/system_zone_acccatg_post.php";
$link_upd = "$home/system_zone_acccatg_upd.php";
$link_del = "$home/system_zone_acccatg_del.php";
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
            Accounting Category
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-4">
			
			<?
			$queryC = "SELECT count(code1) FROM zone_acc_level1";
			$resultC = mysql_query($queryC);
			$total_recordC = mysql_result($resultC,0,0);

			$queryD = "SELECT code1,name1 FROM zone_acc_level1 ORDER BY code1 ASC";
			$resultD = mysql_query($queryD);

			echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
			echo("<option value='$PHP_SELF'>:: Select Level 1</option>");

			for($i = 0; $i < $total_recordC; $i++) {
				$menu_code = mysql_result($resultD,$i,0);
				$menu_name = mysql_result($resultD,$i,1);
        
				if($menu_code == $key) {
					$slc_gate = "selected";
				} else {
					$slc_gate = "";
				}

				echo("<option value='$PHP_SELF?keyfield=code1&key=$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
			}
			echo("</select>");
			?>

			</div>
			</div>
			
			<div>&nbsp;</div>
			
		
		<section id="unseen">
		<table class="table table-bordered table-condensed">
<?
echo ("
		<tr height=22>
			<td align=center bgcolor=#EFEFEF>Level 2</td>
			<td colspan=2 align=center bgcolor=#EFEFEF>Level 3</td>
			<td colspan=2 align=center bgcolor=#EFEFEF>Level 4</td>
		</tr>");

		$big_cat_array = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", 
						"21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", 
						"41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", 
						"61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", 
						"81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99");


		// 대분류 데이터베이스에서 레코드를 검색
		$big_query = "SELECT * FROM zone_acc_level2 WHERE code1 = '$key' ORDER BY code2";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);  // 대분류에 들어있는 분류수
		
		$j=0;
  
		while($big_row = mysql_fetch_object($big_result)) {

		  	$big_code = $big_row->code2;
		  	$big_name = $big_row->name2;
		  	  $big_name = stripslashes($big_name);
		  	
		  	$j2 = $j + 1;
		  	
		  	
		  	// 중분류
		  	$mid_query = "SELECT * FROM zone_acc_level3 WHERE code2 = '$big_code' ORDER BY code3";
		  	$mid_result = mysql_query($mid_query);  // 쿼리문을 SQL서버에 전송
		  	if (!$mid_result) {
		     		error("QUERY_ERROR");
		     		exit;
		  	}   
		  	$mid_rows = mysql_num_rows($mid_result);  // 중분류에 들어있는 분류수
    
			// 대분류 수정 링크
			echo ("
			<form name='formB' method='post' action='$home/process_zcatg_updB.php'>
			<input type='hidden' name='lang' value='$lang'>
			<input type='hidden' name='gate' value='$login_gate'>
			<input type='hidden' name='key' value='$key'>
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
							echo("<a href='$home/process_zcatg_del.php?lang=$lang&mode=big&bcode=$big_code&bname=$big_name&gate=$gate&key=$key'>$txt_comm_frm13</a>");
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

					$m_code = $mid_row->code3;
					$m_name = $mid_row->name3;
				    $m_name = stripslashes($m_name);
				    $i2 = $i + 1;

		    	if($i == 0) {
		      	echo ("
				<form name='formM' method='post' action='$home/process_zcatg_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$login_gate'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='mode' value='form'>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td height=16>($m_code)
							<input type=text size=16 name='new_mname' value=\"$m_name\" style='height:24px; WIDTH: 140px'>
							<input type=hidden name='new_mcode' value=\"$m_code\"> ");
				
							if($ss_mcode != $m_code) { echo ("
								<a href='system_zone_acccatg.php?lang=$lang&ss_mode=add&ss_mcode=$m_code&key=$key'><i class='fa fa-pencil'></i> Add</a>");
							} echo ("
						</td>

						<td align=right>
							<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>&nbsp;");
				
							if($i2 == $mid_rows) {
								echo("<a href='$home/process_zcatg_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate&key=$key'>$txt_comm_frm13</a>");
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
				
					$rm_query = "SELECT code4 FROM zone_acc_level4 WHERE code2 = '$big_code' AND code3 = '$m_code' ORDER BY code4 DESC";
					$rm_result = mysql_query($rm_query);
						if (!$rm_result) { error("QUERY_ERROR"); exit; }
					$max_scroom = @mysql_result($rm_result,0,0);
						
					if(!$max_scroom) {
						$new_scode4 = "$m_code"."01";
					} else {
						$new_scode4 = $max_scroom + 1;
					}
					
					// 소분류
					$sml_query = "SELECT * FROM zone_acc_level4 WHERE code2 = '$big_code' AND code3 = '$m_code' ORDER BY code4";
					$sml_result = mysql_query($sml_query);  // 쿼리문을 SQL서버에 전송
						if (!$sml_result) {	error("QUERY_ERROR");	exit;	}   
					$sml_rows = mysql_num_rows($sml_result);
					
					// SS CATG 변경/삭제
					while($sml_row = mysql_fetch_object($sml_result)) {

						$s_code = $sml_row->code4;
						$s_name = $sml_row->name4;
							$s_name = stripslashes($s_name);
						
				
						echo ("
						<form name='formSU1' method='post' action='$home/process_zcatg_updS.php'>
						<input type='hidden' name='lang' value='$lang'>
						<input type='hidden' name='gate' value='$login_gate'>
						<input type='hidden' name='key' value='$key'>
						<input type='hidden' name='m_catg' value='$m_code'>
						<input type='hidden' name='new_scode' value='$s_code'>
						<tr>
							<td height=16>($s_code) <input type=text size=16 name='new_sname' value='$s_name' style='height:24px; WIDTH: 160px'></td>
							<td align=right>
								<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>
								<a href='$home/process_zcatg_delS.php?lang=$lang&scode=$s_code&gate=$login_gate&key=$key'>$txt_comm_frm13</a>
							</td>
						</tr>
						</form>");
					}
				
					// SS CATG 추가
					if($ss_mode == "add" AND $ss_mcode == $m_code) {
					echo ("
					<form name='formS1' method='post' action='$home/process_zcatg_addS.php'>
					<input type='hidden' name='lang' value='$lang'>
					<input type='hidden' name='gate' value='$login_gate'>
					<input type='hidden' name='key' value='$key'>
					<input type='hidden' name='m_catg' value='$m_code'>
					<tr>
						<td height=16 align=center>
							+ <input type=tel name='new_scode4' value='$new_scode4' maxlength=5 style='height:24px; WIDTH: 50px'> 
							<input type=text name='new_sname' style='height:24px; WIDTH: 160px'></td>
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

				<form name='formM' method='post' action='$home/process_zcatg_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$gate'>
				<input type='hidden' name='key' value='$key'>
				<input type='hidden' name='mode' value='form'>
				
				<td colspan=2>
					<table width=100% cellspacing=0 cellpadding=0 border=0>
					<tr>
						<td height=16>($m_code)
							<input type=text size=16 name='new_mname' value=\"$m_name\" style='height:24px; WIDTH: 140px'>
							<input type=hidden name='new_mcode' value=\"$m_code\"> ");
				
							if($ss_mcode != $m_code) { echo ("
								<a href='system_zone_acccatg.php?lang=$lang&ss_mode=add&ss_mcode=$m_code&key=$key'><i class='fa fa-pencil'></i> Add</a>");
							} echo ("
						</td>
						<td align=right>
							<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>&nbsp;");
				
							if($i2 == $mid_rows) {
								echo("<a href='$home/process_zcatg_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate&key=$key'>$txt_comm_frm13</a>");
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
					
					$rm_query = "SELECT code4 FROM zone_acc_level4 WHERE code2 = '$big_code' AND code3 = '$m_code' ORDER BY code4 DESC";
					$rm_result = mysql_query($rm_query);
						if (!$rm_result) { error("QUERY_ERROR"); exit; }
					$max_scroom = @mysql_result($rm_result,0,0);
						
					if(!$max_scroom) {
						$new_scode4 = "$m_code"."01";
					} else {
						$new_scode4 = $max_scroom + 1;
					}
					
					// 소분류
					$sml_query = "SELECT * FROM zone_acc_level4 WHERE code2 = '$big_code' AND code3 = '$m_code' ORDER BY code4";
					$sml_result = mysql_query($sml_query);  // 쿼리문을 SQL서버에 전송
						if (!$sml_result) {	error("QUERY_ERROR");	exit;	}   
					$sml_rows = mysql_num_rows($sml_result);
					
					// SS CATG 변경/삭제
					while($sml_row = mysql_fetch_object($sml_result)) {

						$s_code = $sml_row->code4;
						$s_name = $sml_row->name4;
							$s_name = stripslashes($s_name);
						
										
						echo ("
						<form name='formSU2' method='post' action='$home/process_zcatg_updS.php'>
						<input type='hidden' name='lang' value='$lang'>
						<input type='hidden' name='gate' value='$login_gate'>
						<input type='hidden' name='key' value='$key'>
						<input type='hidden' name='m_catg' value='$m_code'>
						<input type='hidden' name='new_scode' value='$s_code'>
						<tr>
							<td height=16>($s_code) <input type=text size=16 name='new_sname' value='$s_name' style='height:24px; WIDTH: 160px'></td>
							<td align=right>
								<input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'>
								<a href='$home/process_zcatg_delS.php?lang=$lang&scode=$s_code&gate=$login_gate&key=$key'>$txt_comm_frm13</a>
							</td>
						</tr>
						</form>");
					}
				
				
					// SS CATG 추가
					if($ss_mode == "add" AND $ss_mcode == $m_code) {
					echo ("
					<form name='formS2' method='post' action='$home/process_zcatg_addS.php'>
					<input type='hidden' name='lang' value='$lang'>
					<input type='hidden' name='gate' value='$login_gate'>
					<input type='hidden' name='key' value='$key'>
					<input type='hidden' name='m_catg' value='$m_code'>
					<tr>
						<td height=16 align=center>
							+ <input type=tel name='new_scode4' value='$new_scode4' maxlength=5 style='height:24px; WIDTH: 50px'> 
							<input type=text name='new_sname' style='height:24px; WIDTH: 160px'></td>
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

  			// 중분류에 하부 항목이 없으면 없다고 보여줌 
  			if($mid_rows == 0) {
    			echo ("<td colspan=4 align=left>&nbsp;&nbsp;&nbsp; <font color=navy>$txt_sys_category_chk01</font></td></tr>");
  			}
  		$j++;
		}
		echo("
    </table>");
?>			
</section>

		
			<? if($key > "0") { ?>
			<br />
			<div class="form-actions">
				<a href="<?echo("$link_post?gate=$login_gate&key=$key")?>"><input type="button" value="<?=$txt_sys_category_02?>" class="btn btn-primary"></a>
			</div>
			<? } ?>
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

<? } ?>