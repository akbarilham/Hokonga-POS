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
            <?=$hsm_name_09_41?> - <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">


		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
		<?
		echo ("
		<form name='signform1' method='post' action='system_jobclass_post.php'>
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

		
		$big_cat_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9");

		// 대분류 데이터베이스에서 레코드를 검색
		$big_query = "SELECT * FROM code_jobclass1 WHERE lang = '$lang' ORDER BY lcode";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);  // 대분류에 들어있는 분류수
  
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

		// 추가할 대분류가 있으면 이름을 기입
		$i=0;
		while($big_cat_array[$i]) {

			if($big_cat_array[$i] == $big_code) {   
			$i++;
			echo ("
			<tr>
			<td>($big_cat_array[$i]) <input type=text name=b_name></td>
			<td width=50 align=center>
				<input type=radio name=b_code value=add checked>
				<input type=hidden name=add_code value=$big_cat_array[$i]>
				<input type=hidden name=gate value=$gate>
			</td>
			</tr>
			");
  			break;
			}
		$i++;
		}

		// 대분류에 아무 레코드도 없으면 초기값 입력 폼
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
				<input type="submit" value="<?=$txt_comm_frm18?>" class="btn btn-primary">
			</div>
			</form>
		
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
} else if(!strcmp($room,"addcatg")) {

  	if($b_code == "add") {
	
	    $b_name = addslashes($b_name);
	
	    // 대분류 항목을 추가 (3개 언어 동시에)
	    $query_L1  = "INSERT INTO code_jobclass1 (lcode, lname, lang) VALUES ('$add_code','$b_name','en')";
	    $result_L1 = mysql_query($query_L1,$dbconn);
	    if(!$result_L1) { error("QUERY_ERROR"); exit; }
	
	    $query_L2  = "INSERT INTO code_jobclass1 (lcode, lname, lang) VALUES ('$add_code','$b_name','ko')";
	    $result_L2 = mysql_query($query_L2,$dbconn);
	    if(!$result_L2) { error("QUERY_ERROR"); exit; }
	
	    $query_L3  = "INSERT INTO code_jobclass1 (lcode, lname, lang) VALUES ('$add_code','$b_name','in')";
	    $result_L3 = mysql_query($query_L3,$dbconn);
	    if(!$result_L3) { error("QUERY_ERROR"); exit; }

      echo("<meta http-equiv='Refresh' content='0; URL=$home/system_jobclass.php?gate=$login_gate'>");
      exit;

	} // the end of if($b_code == "add")
  
	// 해당 대분류의 중분류 추가 폼
	$b_name = substr($b_code, 1);
	$b_code = substr($b_code, 0,1);
	
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
            <?=$hsm_name_09_41?> - <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
		<?
		echo ("
		<table class='display table table-bordered table-striped'>
		<form name='signform2' method='post' action='system_jobclass_post.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='room' value='process'>


		<thead>
		<tr>
			<th>$txt_sys_category_05 : ($b_code) $b_name</th>
		</tr>
     	</thead>
		
		<tbody>");

		
		// 중분류 데이터베이스에서 레코드 검색
		$queryC = "SELECT count(uid) FROM code_jobclass2 WHERE lang = '$lang'";
		$resultC = mysql_query($queryC);
		$total_num = mysql_result($resultC,0,0);
		
		$mid_query = "SELECT * FROM code_jobclass2 WHERE lang = '$lang' AND lcode = '$b_code' ORDER BY mcode";
		$mid_result = mysql_query($mid_query);

			if (!$mid_result) {
			error("QUERY_ERROR");
			exit;
			}
    
		$mid_rows = mysql_num_rows($mid_result);  // 중분류에 들어있는 분류수

		while($mid_row = mysql_fetch_object($mid_result)) {

			$mid_code = $mid_row->mcode;
			$mid_name = $mid_row->mname;
			  $mid_name = stripslashes($mid_name);
			  
  	  		echo ("<tr><td>($mid_code) $mid_name</td></tr>");

		}

		// 추가할 중분류 필드
		$new_num = $mid_rows + 1;
		$new_num = sprintf("%02d", $new_num);

		echo ("
		<tr>
		<td>($new_num) 
			<input type=text name=m_name>
			<input type=hidden name=addcode value=$new_num>
			<input type=hidden name=b_code value=$b_code>
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

	$m_name = addslashes($m_name);

	// 중분류 항목을 추가 (3개 언어 동시에)
	$query_M1  = "INSERT INTO code_jobclass2 (lcode, mcode, mname, lang) VALUES ('$b_code','$addcode','$m_name', 'en')";
	$result_M1 = mysql_query($query_M1);
		if(!$result_M1) {	error("QUERY_ERROR");	exit;	}

	$query_M2  = "INSERT INTO code_jobclass2 (lcode, mcode, mname, lang) VALUES ('$b_code','$addcode','$m_name', 'ko')";
	$result_M2 = mysql_query($query_M2);
		if(!$result_M2) {	error("QUERY_ERROR");	exit;	}
	
	$query_M3  = "INSERT INTO code_jobclass2 (lcode, mcode, mname, lang) VALUES ('$b_code','$addcode','$m_name', 'in')";
	$result_M3 = mysql_query($query_M3);
		if(!$result_M3) {	error("QUERY_ERROR");	exit;	}

	// 분류 목록 출력화면으로 이동하고 종료
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_jobclass.php?gate=$login_gate'>");
	exit;


}

}
?>
