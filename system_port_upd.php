<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_port";


if(!$step_next) {
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
 
<?
$query = "SELECT uid,p_type,country_code,port_code,port_name,port_area FROM code_port WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$p_type = $row->p_type;
$now_country_code = $row->country_code;
$port_code = $row->port_code;
$port_name = $row->port_name;
$port_area = $row->port_area;

// Country Name
$queryS = "SELECT country_name FROM code_country WHERE country_code = '$now_country_code'";
$resultS = mysql_query($queryS);

$now_country_name = @mysql_result($resultS,0,0);

if($p_type == "0") {
	$p_type_chk0 = "checked";
	$p_type_chk1 = "";
	$p_type_chk2 = "";
} else if($p_type == "1") {
	$p_type_chk0 = "";
	$p_type_chk1 = "checked";
	$p_type_chk2 = "";
} else if($p_type == "2") {
	$p_type_chk0 = "";
	$p_type_chk1 = "";
	$p_type_chk2 = "checked";	
}
?>

       
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Update Port
            <span class="tools pull-right">
                <a href="system_port_del.php?uid=<?=$user_uid?>" class="fa fa-trash-o"></a>
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="system_port_upd.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								
								
								
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Code</label>
                                        <div class="col-sm-3">
                                            <input disabled class="form-control" id="cname" name="port_code" type="text" value="<?=$port_code?>" />
                                        </div>
										<div class="col-sm-6">
											<input type="radio" name="p_type" value="1" <?=$p_type_chk1?>> Departure &nbsp;&nbsp; 
											<input type="radio" name="p_type" value="2" <?=$p_type_chk2?>> Arrival &nbsp;&nbsp; 
											<input type="radio" name="p_type" value="0" <?=$p_type_chk0?>> Undefined
										</div>
										
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Port Name</label>
										<div class="col-sm-9">
											<input class="form-control" id="cname" name="port_name" value="<?=$port_name?>" type="text" required />
										</div>
										
                                    </div>
									
								
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_area_06?></label>
                                        <div class="col-sm-3">
										
											<?
											$queryA = "SELECT count(uid) FROM code_country";
											$resultA = mysql_query($queryA);
											$total_recordA = mysql_result($resultA,0,0);

											$queryB = "SELECT country_code,country_name FROM code_country ORDER BY country_name ASC";
											$resultB = mysql_query($queryB);

											echo ("<select name='country_code' class='form-control'>");

											for($i = 0; $i < $total_recordA; $i++) {
												$country_code = mysql_result($resultB,$i,0);
												$country_name = mysql_result($resultB,$i,1);
												
												if($country_code == $now_country_code) {
													$country_slct = "selected";
													$country_dis = "";
												} else {
													$country_slct = "";
													$country_dis = "disabled";
												}
        
												echo("<option $country_dis value='$country_code' $country_slct>($country_code) $country_name</option>");
											}
											echo("</select>");
											?>
											
                                        </div>
										<div class="col-sm-3">Area/Region</div>
										<div class="col-sm-3">
											<input class="form-control" id="cname" name="port_area" value="<?=$port_area?>" type="text" />
										</div>
                                    </div>
									
									
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
                                </form>
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

<?
} else if($step_next == "permit_okay") {


    $port_name = addslashes($port_name);

	$query_upd = "UPDATE code_port SET p_type = '$p_type', port_name = '$port_name', port_area = '$port_area' WHERE uid = '$user_uid'";  
	$result_upd = mysql_query($query_upd);
    if(!$result_upd) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_port.php'>");
  exit;
  

}

}
?>