<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_zone_acclist";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_zone_acclist.php";
$link_post = "$home/system_zone_acclist.php?mode=add&keyfield=$keyfield&key=$key";
$link_upd = "$home/system_zone_acclist_upd.php";
$link_del = "$home/system_zone_acclist_del.php";
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
	
	<script language="javascript">
	function Popup_Win(ref) {
		var window_left = (screen.width-800)/2;
		var window_top = (screen.height-480)/2;
		window.open(ref,"cat_win",'width=310,height=320,status=no,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">

<?
if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(code) FROM zone_acc_list";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(code) FROM zone_acc_list WHERE $keyfield LIKE '%$key%'";  
}
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
            Accounting Codes
			
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
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Accounting Code</th>
            <th>Accounting Name</th>
			<th><?=$txt_comm_frm12?></th>
			<th><?=$txt_comm_frm13?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT code,name FROM zone_acc_list ORDER BY code ASC";
} else {
   $query = "SELECT code,name FROM zone_acc_list WHERE $keyfield LIKE '%$key%' ORDER BY code ASC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $upd_acc_code = mysql_result($result,$i,0);   
   $upd_acc_name = mysql_result($result,$i,1);
   

	echo ("
	<tr>
		<td>$upd_acc_code</td>
		
		<form name='updform' method='post' action='system_zone_acclist.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='step_next_mode' value='upd'>
		<input type='hidden' name='org_acc_code' value='$upd_acc_code'>
		<input type='hidden' name='sorting_table' value='$sorting_table'>
		<input type='hidden' name='sorting_key' value='$sorting_key'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='page' value='$page'>
		<td><input type='text' class='form-control' name='upd_acc_name' maxlength=12 value=\"$upd_acc_name\"></td>
		<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default'></td>
		</form>
		
		<form name='updform' method='post' action='system_zone_acclist.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='step_next_mode' value='del'>
		<input type='hidden' name='org_acc_code' value='$upd_acc_code'>
		<input type='hidden' name='sorting_table' value='$sorting_table'>
		<input type='hidden' name='sorting_key' value='$sorting_key'>
		<input type='hidden' name='keyfield' value='$keyfield'>
		<input type='hidden' name='key' value='$key'>
		<input type='hidden' name='page' value='$page'>
		<td><input type='submit' value='$txt_comm_frm13' class='btn btn-default'></td>
		</form>
	</tr>");

	
   $article_num--;
}
?>
		
        </tbody>
        </table>
		</section>
		
				<? if($key != "") { ?>
				<a href="<?=$link_post?>"><input type="button" value="Add Code" class="btn btn-primary"></a>
				<? } ?>
			
				<ul class="pagination pagination-sm pull-right">
				<?
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_num&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
				}
				?>
				</ul>
			
        </div>
		
        </section>
		</div>
		</div>
		
		
		
		<? if($mode == "add" AND $key != "") { ?>
		
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action='system_zone_acclist.php'>
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='step_next_mode' value='add'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Add New Accounting Code
			
            
        </header>
		
        <div class="panel-body">
		
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Accounting Code</label>
										<div class="col-sm-2">
											<input type="button" class="btn btn-default" value="<?=$txt_invn_stockin_21?>" onClick="Popup_Win('system_zone_accfind.php?key=<?=$key?>')" />
										</div>
                                        <div class="col-sm-2">
											<input class="form-control" name="new_acc_code" type="text" required />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Accounting Name</label>
                                        <div class="col-sm-9">
											<input class="form-control" name="new_acc_name" type="text" required />
										</div>
                                    </div>
									
									<div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_invn_stockin_19?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
		
		</div>
		</section>
		</div>
		</div>
		
		</form>
		
		<? } ?>
		
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


	if($step_next_mode == "del") {
  
		$query_D = "DELETE FROM zone_acc_list WHERE code = '$org_acc_code'";
		$result_D = mysql_query($query_D);
		if (!$result_D) { error("QUERY_ERROR"); exit; }

		
	} else if($step_next_mode == "upd") {
		
		$upd_acc_name = addslashes($upd_acc_name);
	
		$result = mysql_query("UPDATE zone_acc_list SET name = '$upd_acc_name' WHERE code = '$org_acc_code'");
		if (!$result) { error("QUERY_ERROR"); exit;	}
	
	
	} else if($step_next_mode == "add") {
	
		$new_code1 = substr($new_acc_code,0,1);
		$new_code2 = substr($new_acc_code,0,2);
		$new_code3 = substr($new_acc_code,0,3);
		$new_code4 = substr($new_acc_code,0,5);
	
		$new_acc_name = addslashes($new_acc_name);
  

		$query_P = "INSERT INTO zone_acc_list (code1,code2,code3,code4,code,name) 
					values ('$new_code1','$new_code2','$new_code3','$new_code4','$new_acc_code','$new_acc_name')";
		$result_P = mysql_query($query_P);
		if (!$result_P) { error("QUERY_ERROR"); exit; }

		
	}
		
	
	
	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zone_acclist.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page'>");
    exit;
	
}

}
?>
