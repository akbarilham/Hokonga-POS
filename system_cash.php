<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_cash";

if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/system_cash.php";
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
   $query = "SELECT count(uid) FROM client_branch";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM client_branch WHERE $keyfield LIKE '%$key%'";  
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
            <?=$hsm_name_09_10?> &nbsp; 
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
        <section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th colspan=2><?=$txt_comm_frm23?></th>
			<th>Curr.</th>
            <th><?=$txt_sys_bank_14?></th>
			<th><?=$txt_sys_bank_15?></th>
			<th>Max Value / Day</th>
			<th><?=$txt_comm_frm12?></th>
        </tr>
        </thead>
		
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT uid,branch_code,branch_name,initial_cash,initial_uncol,initial_cash2,initial_uncol2,signdate,
            baseline,baseline2 FROM client_branch ORDER BY userlevel DESC, branch_code ASC";
} else {
   $query = "SELECT uid,branch_code,branch_name,initial_cash,initial_uncol,initial_cash2,initial_uncol2,signdate,
            baseline,baseline2 FROM client_branch WHERE $keyfield LIKE '%$key%' ORDER BY userlevel DESC, branch_code ASC";
}

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $uid = mysql_result($result,$i,0);   
   $branch_code = mysql_result($result,$i,1);
   $branch_name = mysql_result($result,$i,2);
   $initial_cash = mysql_result($result,$i,3);
   $initial_uncol = mysql_result($result,$i,4);
   $initial_cash2 = mysql_result($result,$i,5);
   $initial_uncol2 = mysql_result($result,$i,6);
   $signdate = mysql_result($result,$i,7);
    if($lang == "ko") {
	    $signdates = date("Y/m/d",$signdate);
	  } else {
	    $signdates = date("d-m-Y",$signdate);
	  }
	 $baseline = mysql_result($result,$i,8);
	 $baseline2 = mysql_result($result,$i,9);
	 

  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$branch_name") && $key) {
    $branch_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $branch_name);
  }
  if(!strcmp($key,"$branch_code") && $key) {
    $branch_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $branch_code);
  }


  echo ("
  <tr height=22>
    <td rowspan=2>{$branch_code}</td>
    <td rowspan=2>{$branch_name}</td>
    <td bgcolor=#FFFFFF align=center>IDR</td>
    
    <form name='signform1' method='post' action='system_cash.php'>
    <input type='hidden' name='step_next' value='permit_update1'>
    <input type='hidden' name='new_uid' value=\"$uid\">
    
    <td>
      <input type=text name='initial_cash' maxlength=12 value=\"$initial_cash\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td>
      <input type=text name='initial_uncol' maxlength=12 value=\"$initial_uncol\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td>
      <input type=text name='baseline' maxlength=12 value=\"$baseline\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
  </tr>

  <tr height=22>
    <td bgcolor=#FFFFFF align=center>USD</td>
    
    <form name='signform2' method='post' action='system_cash.php'>
    <input type='hidden' name='step_next' value='permit_update2'>
    <input type='hidden' name='new_uid' value=\"$uid\">
    
    <td>
      <input type=text name='initial_cash2' maxlength=12 value=\"$initial_cash2\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td>
      <input type=text name='initial_uncol2' maxlength=12 value=\"$initial_uncol2\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td>
      <input type=text name='baseline2' maxlength=12 value=\"$baseline2\" style='text-align: right; WIDTH: 120px; HEIGHT: 22px; padding-right: 5px;'>
    </td>
    <td><input $dis_submit type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'></td>
    </form>
  </tr>

  ");

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
} else if($step_next == "permit_update1") {

  $result1 = mysql_query("UPDATE client_branch SET initial_cash = '$initial_cash',initial_uncol = '$initial_uncol',
            baseline = '$baseline' WHERE uid = '$new_uid'");
  if (!$result1) { error("QUERY_ERROR"); exit;	}
  

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_cash.php'>");
  exit;


} else if($step_next == "permit_update2") {

  $result2 = mysql_query("UPDATE client_branch SET initial_cash2 = '$initial_cash2',initial_uncol2 = '$initial_uncol2',
            baseline2 = '$baseline2' WHERE uid = '$new_uid'");
  if (!$result2) { error("QUERY_ERROR"); exit;	}
  

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_cash.php'>");
  exit;

}

}
?>