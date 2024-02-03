<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_jobclass";

$link_list = "$home/system_jobclass.php";
$link_post = "$home/system_jobclass_post.php";
$link_upd = "$home/system_jobclass_upd.php";
$link_del = "$home/system_jobclass_del.php";
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
            <?=$hsm_name_09_41?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
			
<?
echo ("
        <thead>
		<tr>
			<th colspan=2 width=45%>$txt_sys_category_05</td>
			<th colspan=2 width=55%>$txt_sys_category_06</td>
		</tr>
		</thead>
		
		<tbody>");

		$big_cat_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

		// 대분류 데이터베이스에서 레코드를 검색
		$big_query = "SELECT * FROM code_jobclass1 WHERE lang = '$lang' ORDER BY lcode";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);  // 대분류에 들어있는 분류수
		
		$j=0;
  
		while($big_row = mysql_fetch_object($big_result)) {

		  	$big_code = $big_row->lcode;
		  	$big_name = $big_row->lname;
		  	  $big_name = stripslashes($big_name);
			$big_area_code = $big_row->area_code;
		  	
		  	$j2 = $j + 1;
		  	
		  	// 중분류
		  	$mid_query = "SELECT * FROM code_jobclass2 WHERE lang = '$lang' AND lcode = '$big_code' ORDER BY mcode";
		  	$mid_result = mysql_query($mid_query);  // 쿼리문을 SQL서버에 전송
		  	if (!$mid_result) {
		     		error("QUERY_ERROR");
		     		exit;
		  	}   
		  	$mid_rows = mysql_num_rows($mid_result);  // 중분류에 들어있는 분류수
    
			// 대분류 수정 링크
	    echo ("
			<form name='formB' method='post' action='$home/process_jobclass_updB.php'>
			<input type='hidden' name='lang' value='$lang'>
			<input type='hidden' name='gate' value='$gate'>
			<input type='hidden' name='mode' value='big'>
			
			<tr height=24>
			<td rowspan=$mid_rows><input type=text name='bname' value=\"$big_name\" style='WIDTH: 180px; HEIGHT: 22px'></td>
			<input type=hidden name='bcode' value=\"$big_code\">

			<td rowspan=$mid_rows><input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'> ");
			if($j2 == $big_rows) {
			  echo("<a href='$home/process_jobclass_del.php?lang=$lang&mode=big&bcode=$big_code&bname=$big_name&gate=$gate'>$txt_comm_frm13</a>");
			} else {
			  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
			}
			
			echo("
			</td>
			</form>
			");

		  	$i=0;

		  	while($mid_row = mysql_fetch_object($mid_result)) {

				  $l_code = $mid_row->lcode;
				  $m_code = $mid_row->mcode;
				  $m_name = $mid_row->mname;
				    $m_name = stripslashes($m_name);
				  $m_name_abr = $mid_row->mname_abr;
				  $m_level = $mid_row->highlevel;
				  
				  if($m_level == "2") {
					$m_level_chk = "checked";
				  } else {
					$m_level_chk = "";
				  }
				  
				  
				    $i2 = $i + 1;

		    		if($i == 0) {
		      	echo ("
				<form name='formM' method='post' action='$home/process_jobclass_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$gate'>
				<input type='hidden' name='mode' value='form'>
				
				<td>($m_code)
					<input type=text name='new_mname_abr' value=\"$m_name_abr\" style='WIDTH: 80px; HEIGHT: 22px'> 
					<input type=text name='new_mname' value=\"$m_name\" style='WIDTH: 200px; HEIGHT: 22px'> 
					<input type=checkbox name='new_highlevel' value='2' $m_level_chk> Exc
				
				</td>
				<input type=hidden name='new_lcode' value=\"$l_code\">
				<input type=hidden name='new_mcode' value=\"$m_code\">

				<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'> ");
				
				if($i2 == $mid_rows) {
				  echo("<a href='$home/process_jobclass_del.php?lang=$lang&mode=mid&lcode=$l_code&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a>");
				} else {
				  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
				}
				
				echo("
				</td>
        </tr>
				</form>
				");

		    		} else {
		    		
		    		echo ("
				<tr>

				<form name='formM' method='post' action='$home/process_jobclass_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
				<input type='hidden' name='gate' value='$gate'>
				<input type='hidden' name='mode' value='form'>
				
				<td>($m_code)
					<input type=text name='new_mname_abr' value=\"$m_name_abr\" style='WIDTH: 80px; HEIGHT: 22px'> 
					<input type=text name='new_mname' value=\"$m_name\" style='WIDTH: 200px; HEIGHT: 22px'> 
					<input type=checkbox name='new_highlevel' value='2' $m_level_chk> Exc
				
				</td>
				<input type=hidden name='new_lcode' value=\"$l_code\">
				<input type=hidden name='new_mcode' value=\"$m_code\">
				
				<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'> ");
				
				if($i2 == $mid_rows) {
				  echo("<a href='$home/process_jobclass_del.php?lang=$lang&mode=mid&lcode=$l_code&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a></td>");
				} else {
				  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
				}
				
				echo("
				</tr>
				</form>
				");
    				}

	  		$i++;
			}

  			// 중분류에 하부 항목이 없으면 없다고 보여줌 
  			if($mid_rows == 0) {
    			echo ("<td colspan=2><font color=navy>$txt_sys_category_chk01</font></td></tr>");
  			}
  		$j++;
		}
		echo("
		</tbody>
    </table>")
?>
</section>	

		
			<br />
			<div class="form-actions">
				<a href="<?echo("$link_post?gate=$login_gate")?>"><input type="button" value="<?=$txt_sys_category_02?>" class="btn btn-primary"></a>
			</div>
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