<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_discount";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_discount.php";
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

<?
if(!$page) { $page = 1; }

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM client WHERE associate = '1' AND userlevel > '2' AND userlevel < '6'";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM client WHERE associate = '1' AND userlevel > '2' AND userlevel < '6' AND $keyfield LIKE '%$key%'";  
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
            <?=$txt_sys_discount_01?> &nbsp; 
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
        
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th><?=$txt_sys_client_02?></th>
            <th><?=$txt_sys_client_01?></th>
            <th><?=$txt_sys_client_04?></th>
			<th><?=$txt_sys_discount_02?></th>
			<th><?=$txt_sys_mileage_03?></th>
			<th><?=$txt_comm_frm12?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,client_name,client_id,client_code,email,userlevel,web_style,web_activate,signdate,dc_amount,dc_upd
			FROM client WHERE associate = '1' AND userlevel > '2' AND userlevel < '6' 
			ORDER BY client_code ASC, client_id ASC, uid DESC";
} else {
   $query = "SELECT uid,client_name,client_id,client_code,email,userlevel,web_style,web_activate,signdate,dc_amount,dc_upd
			FROM client WHERE associate = '1' AND userlevel > '2' AND userlevel < '6' AND $keyfield LIKE '%$key%' 
			ORDER BY client_code ASC, client_id ASC, uid DESC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
   $client_name = mysql_result($result,$i,1);
   $client_id = mysql_result($result,$i,2);
   $client_code = mysql_result($result,$i,3);
   $email = mysql_result($result,$i,4);
   $userlevel = mysql_result($result,$i,5);
   $web_style = mysql_result($result,$i,6);
   $web_activate = mysql_result($result,$i,7);
   $signdate = mysql_result($result,$i,8);
	  if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
	 $dc_amount = mysql_result($result,$i,9);
	 $dc_upd = mysql_result($result,$i,10);
	  $uday1 = substr($dc_upd,0,4);
	  $uday2 = substr($dc_upd,4,2);
	  $uday3 = substr($dc_upd,6,2);
	  
	  if($dc_upd == "") {
	    $upd_date_txt = "$txt_sys_mileage_04";
	  } else {
	    if($lang == "ko") {
	      $upd_date_txt = "$uday1"."/"."$uday2"."/"."$uday3";
	    } else {
	      $upd_date_txt = "$uday3"."-"."$uday2"."-"."$uday1";
	    }
	 }

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$client_name") && $key) {
    $client_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $client_name);
  }
  if(!strcmp($key,"$client_id") && $key) {
    $client_id = eregi_replace("($key)", "<font color=navy>\\1</font>", $client_id);
  }


  echo ("<tr>");
  echo("<td>{$client_id}</td>");
  echo("<td>{$client_name}</td>");

				
				if($userlevel == "3") {
					$level_name = "<font color=blue>Branch</font>";
				} else if($userlevel == "4") {
					$level_name = "<font color=blue>Region / Dep't</font>";
				} else if($userlevel == "5") {
					$level_name = "<font color=#006699>Division</font>";
				}

  echo("<td>$level_name</td>");
  
  // 마일리지 수정
  // if($userlevel != "4") {
  //   $dis_submit = "disabled";
  // } else {
    $dis_submit = "";
  // }
  
  echo ("
    <form name='signform' method='post' action='system_discount.php'>
    <input type='hidden' name='step_next' value='permit_update'>
    <input type='hidden' name='new_uid' value=\"$uid\">
    
    <td>
      <input type=text name='new_point' maxlength=2 value=\"$dc_amount\" style='WIDTH: 50px; HEIGHT: 22px; text-align: center'> %
    </td>
    <td>$upd_date_txt</td>
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
    ");

	echo("</tr>");

   $article_num--;
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

	$signdate = time();
	$signdates1 = date("Ymd",$signdate); 
	$signdates2 = date("His",$signdate); 
  
	$m_ip = getenv('REMOTE_ADDR');

	$result = mysql_query("UPDATE client SET dc_amount = '$new_point', dc_upd = '$signdates1' WHERE uid = '$new_uid'");
	if (!$result) { error("QUERY_ERROR"); exit;	}

	echo("<meta http-equiv='Refresh' content='0; URL=$home/system_discount.php'>");
	exit;

}

}
?>