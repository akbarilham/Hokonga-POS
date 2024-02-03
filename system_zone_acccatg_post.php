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
            <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">

		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
		<?
		echo ("
		<form name='signform1' method='post' action='system_zone_acccatg_post.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='room' value='addcatg'>
		<input type=hidden name='key' value='$key'>


		<thead>
		<tr>
			<th>Level 2</th>
			<th width=50>$txt_comm_frm19</th>
		</tr>
     	</thead>
		
		<tbody>");

		
		$big_cat_array = array("{$key}1", "{$key}2", "{$key}3", "{$key}4", "{$key}5", "{$key}6", "{$key}7", "{$key}8", "{$key}9");

		// 대분류 데이터베이스에서 레코드를 검색
		$big_query = "SELECT * FROM zone_acc_level2 WHERE code1 = '$key' ORDER BY code2";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);  // 대분류에 들어있는 분류수
  
		while($big_row = mysql_fetch_object($big_result)) {

			$big_code = $big_row->code2;
			$big_name = $big_row->name2;
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
			<td><input type='text' name='add_code' value='$big_cat_array[$i]' size=5 maxlength=2> <input type=text name=b_name></td>
			<td width=50 align=center>
				<input type=radio name=b_code value=add checked>
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
		<td><input type='text' name='add_code' value='$big_cat_array[0]' size=5 maxlength=2> <input type=text name=b_name></td>
		<td width=50 align=center>
			<input type=radio name=b_code value=add checked>
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
	
	    $query_L1  = "INSERT INTO zone_acc_level2 (code1, code2, name2) VALUES ('$key','$add_code','$b_name')";
	    $result_L1 = mysql_query($query_L1,$dbconn);
	    if(!$result_L1) { error("QUERY_ERROR"); exit; }
	
      echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
      exit;

	} // the end of if($b_code == "add")
  
	// 해당 대분류의 중분류 추가 폼
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
            <?=$txt_sys_category_02?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
		<?
		echo ("
		<table class='display table table-bordered table-striped'>
		<form name='signform2' method='post' action='system_zone_acccatg_post.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='gate' value='$login_gate'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='room' value='process'>


		<thead>
		<tr>
			<th>Category Level 2 : ($b_code) $b_name</th>
		</tr>
     	</thead>
		
		<tbody>");

		
		$mid_query = "SELECT * FROM zone_acc_level3 WHERE code2 = '$b_code' ORDER BY code3";
		$mid_result = mysql_query($mid_query);

			if (!$mid_result) {
			error("QUERY_ERROR");
			exit;
			}
    
		$mid_rows = mysql_num_rows($mid_result);  // 중분류에 들어있는 분류수

		while($mid_row = mysql_fetch_object($mid_result)) {

			$mid_code = $mid_row->code3;
			$mid_name = $mid_row->name3;
			  $mid_name = stripslashes($mid_name);
			  
  	  		echo ("<tr><td>($mid_code) $mid_name</td></tr>");

		}

		// 추가할 중분류 필드
		$new_num = $mid_rows + 1;
		// $new_num = sprintf("%02d", $new_num);

		echo ("
		<tr>
		<td><input type=text name=addcode value='$b_code$new_num' size=6 maxlength=3> 
			<input type=text name=m_name>
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

	$b1_code = substr($addcode,0,1);
	$b2_code = substr($addcode,0,2);
	$m_name = addslashes($m_name);

	$query_M1  = "INSERT INTO zone_acc_level3 (code1, code2, code3, name3) VALUES ('$b1_code','$b2_code','$addcode','$m_name')";
	$result_M1 = mysql_query($query_M1);
		if(!$result_M1) {	error("QUERY_ERROR");	exit;	}


	// 분류 목록 출력화면으로 이동하고 종료
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acccatg.php?gate=$login_gate&key=$key'>");
	exit;


}

}
?>
