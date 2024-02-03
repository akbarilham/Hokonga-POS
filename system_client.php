<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_client";

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_client.php";
$link_post = "$home/system_client_post.php";
$link_upd = "$home/system_client_upd.php";
$link_del = "$home/system_client_del.php";
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
            <?=$txt_sys_client_10?>
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
        <table class="display table table-bordered table-striped">
		<?
		$query = "SELECT count(uid) FROM client";
		$result = mysql_query($query);
		if (!$result) { error("QUERY_ERROR"); exit; }
		$total_record = mysql_result($result,0,0);
		?>
		
        <thead>
        <tr>
            <th><?=$hsm_name_09_01?></th>
            <th><?=$txt_sys_client_01?></th>
			<th>Main Modules</th>
			<th><?=$txt_sys_client_04?></th>
			<th><?=$txt_sys_client_06?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
			$query_sub1 = "SELECT count(uid) FROM client";
			$result_sub1 = mysql_query($query_sub1);
			if (!$result_sub1) {   error("QUERY_ERROR");   exit; }
  
			$kr_count = @mysql_result($result_sub1,0,0);
  
			$query_sub = "SELECT client_name,client_id,client_code,userlevel,web_flag,web_style,web_activate,signdate,uid,consign,associate,
						module_01,module_01B,module_02,module_03,module_04,module_05,module_06,module_07,module_08,module_09,module_10,module_11,
						module_01_type,module_98,module_99 FROM client ORDER BY branch_code ASC, userlevel DESC, client_id ASC";
			$result_sub = mysql_query($query_sub);
			if (!$result_sub) {   error("QUERY_ERROR");   exit; }

			for($j = 0; $j < $kr_count; $j++) {
  
				$client_name = @mysql_result($result_sub,$j,0);
				$client_id = @mysql_result($result_sub,$j,1);
				$client_code = @mysql_result($result_sub,$j,2);
				$userlevel = @mysql_result($result_sub,$j,3);
				$web_flag = @mysql_result($result_sub,$j,4);
				$web_style = @mysql_result($result_sub,$j,5);
				$web_activate = @mysql_result($result_sub,$j,6);
				$signdate = @mysql_result($result_sub,$j,7);
				$client_uid = @mysql_result($result_sub,$j,8);
				$consign = @mysql_result($result_sub,$j,9);
				$associate = @mysql_result($result_sub,$j,10);
				$sys_module_01 = @mysql_result($result_sub,$j,11);
				$sys_module_01B = @mysql_result($result_sub,$j,12);
				$sys_module_02 = @mysql_result($result_sub,$j,13);
				$sys_module_03 = @mysql_result($result_sub,$j,14);
				$sys_module_04 = @mysql_result($result_sub,$j,15);
				$sys_module_05 = @mysql_result($result_sub,$j,16);
				$sys_module_06 = @mysql_result($result_sub,$j,17);
				$sys_module_07 = @mysql_result($result_sub,$j,18);
				$sys_module_08 = @mysql_result($result_sub,$j,19);
				$sys_module_09 = @mysql_result($result_sub,$j,20);
				$sys_module_10 = @mysql_result($result_sub,$j,21);
				$sys_module_11 = @mysql_result($result_sub,$j,22);
				$sys_module_01_type = @mysql_result($result_sub,$j,23);
				$sys_module_98 = @mysql_result($result_sub,$j,24);
				$sys_module_99 = @mysql_result($result_sub,$j,25);
				
				// member_staff -- gate
				$t21_query = "SELECT count(code) FROM member_staff WHERE gate = '$client_id'";
				$t21_result = mysql_query($t21_query);
					if (!$t21_result) { error("QUERY_ERROR"); exit; }
				$sum_client_id = @mysql_result($t21_result,0,0);
				if($sum_client_id > 0) {
					$sum_client_id_txt = "&nbsp; ($sum_client_id)";
				} else {
					$sum_client_id_txt = "";
				}
				
				if($sys_module_01 == "1") { $sys_module_01_txt = "[PO]"; } else { $sys_module_01_txt = ""; }
				if($sys_module_01B == "1") { $sys_module_01B_txt = "[PR]"; } else { $sys_module_01B_txt = ""; }
				if($sys_module_02 == "1") { $sys_module_02_txt = "[Inventory]"; } else { $sys_module_02_txt = ""; }
				if($sys_module_03 == "1") { $sys_module_03_txt = "[Logis]"; } else { $sys_module_03_txt = ""; }
				if($sys_module_04 == "1") { $sys_module_04_txt = "[Asset]"; } else { $sys_module_04_txt = ""; }
				if($sys_module_05 == "1") { $sys_module_05_txt = "[SO-Branch]"; } else { $sys_module_05_txt = ""; }
				if($sys_module_06 == "1") { $sys_module_06_txt = "[SO-Associate]"; } else { $sys_module_06_txt = ""; }
				if($sys_module_07 == "1") { $sys_module_07_txt = "[SO-Direct]"; } else { $sys_module_07_txt = ""; }
				if($sys_module_08 == "1") { $sys_module_08_txt = "[CRM/HR]"; } else { $sys_module_08_txt = ""; }
				if($sys_module_09 == "1") { $sys_module_09_txt = "[Finance]"; } else { $sys_module_09_txt = ""; }
				if($sys_module_10 == "1") { $sys_module_10_txt = "[Accounting]"; } else { $sys_module_10_txt = ""; }
				if($sys_module_11 == "1") { $sys_module_11_txt = "<font color=red>[CMS]</font>"; } else { $sys_module_11_txt = ""; }
				if($sys_module_98 == "1") { $sys_module_98_txt = "<font color=green>[Financial Institution]</font>"; } else { $sys_module_98_txt = ""; }
				if($sys_module_99 == "1") { $sys_module_99_txt = "<font color=green>[Insurance]</font>"; } else { $sys_module_99_txt = ""; }
				
				$sys_modules_txt = "$sys_module_01_txt"."$sys_module_01B_txt"."$sys_module_02_txt"."$sys_module_03_txt"."$sys_module_04_txt"."$sys_module_05_txt".
									"$sys_module_06_txt"."$sys_module_07_txt"."$sys_module_08_txt"."$sys_module_09_txt"."$sys_module_10_txt"."$sys_module_11_txt".
									"$sys_module_98_txt"."$sys_module_99_txt";
				
   
				if($lang == "ko") {
					$signdates = date("Y/m/d",$signdate);
				} else {
					$signdates = date("d-m-Y",$signdate);
				}
	
				// User Class
				if($userlevel == "0") {
					$level_name = "<font color=red>Closed</font>";
				} else if($userlevel == "2") {
					$level_name = "<font color=blue>Shop Mgt</font>";
				} else if($userlevel == "3") {
					$level_name = "<font color=blue>Branch</font>";
				} else if($userlevel == "4") {
					$level_name = "<font color=blue>Region / Dep't</font>";
				} else if($userlevel == "5") {
					if($associate == "1") {
						$level_name = "<font color=#006699>Division (Assoc) +</font>";
					} else {
						$level_name = "<font color=#777777>Division</font>";
					}
				} else if($userlevel == "6") {
					$level_name = "<font color=green>Inventory</font>";
				} else if($userlevel == "7") {
					$level_name = "Corporate";
				} else if($userlevel == "8") {
					$level_name = "Group H.Q.";
				} else if($userlevel == "9") {
					$level_name = "*";
				} else {
					$level_name = "-&gt;-";
				}
  
				if($userlevel < "3") {
					$userlevel_span = "&nbsp;&nbsp;<font color=blue>&gt;</font>&nbsp;";
				} else {
					$userlevel_span = "";
				}
				
				if($web_flag == "1") {
					$web_flag_txt = "<i class='fa fa-globe'></i>";
				} else {
					$web_flag_txt = "";
				}
		
		
				
				echo ("
				<tr class=\"gradeX\">
				<td>{$userlevel_span}<a href='$link_upd?uid=$client_uid'>$client_id</a> $web_flag_txt</td>
				<!--<td><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='bottom' 
					data-original-title='$sys_modules_txt'>$client_name</a></td>-->
				<td>$client_name{$sum_client_id_txt}</td>
				<td>$sys_modules_txt</td>
				<td>$level_name</td>
				<td>$signdates</td>
				</tr>");
		
			}
		
		?>
        </tbody>
		
        </table>
		
			<br />
			<div class="form-actions">
				<a href="<?=$link_post?>"><input type="button" value="<?=$txt_comm_frm03?>" class="btn btn-primary"></a>
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