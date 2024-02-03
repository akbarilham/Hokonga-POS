<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "sales";
$smenu = "sales_pos";

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
            POS Cart Data Table Merge
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="pos_admin_restore.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&gt; Data Table Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_table_name" type="text" value="pos_detail_backup_01.sql" />
                                        </div>
                                    </div>
									
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="Restore now !">
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

		$query_ftmx = "SELECT uid,transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,gross,nett,netvat,vat,sales_code,transcode,temp,qty FROM $data_table_name";
		$result_ftmx = mysql_query($query_ftmx,$dbconn);
		$row_ftmx = mysql_num_rows($result_ftmx);

		while($row_ftmx = mysql_fetch_object($result_ftmx)) {
			$R_uid = $row_ftmx->uid;
			$R_transaction_code = $row_ftmx->transaction_code;
			$R_org_pcode = $row_ftmx->org_pcode;
			$R_barcode = $row_ftmx->barcode;
			$R_date = $row_ftmx->date;
			$R_hostname = $row_ftmx->hostname;
			$R_ip = $row_ftmx->ip;
			$R_price = $row_ftmx->price;
			$R_disc_rate = $row_ftmx->disc_rate;
			$R_gross = $row_ftmx->gross;
			$R_nett = $row_ftmx->nett;
			$R_netvat = $row_ftmx->netvat;
			$R_vat = $row_ftmx->vat;
			$R_sales_code = $row_ftmx->sales_code;
			$R_transcode = $row_ftmx->transcode;
			$R_temp = $row_ftmx->temp;
			$R_qty = $row_ftmx->qty;
			
			// Duplication Check
			$dp_query = "SELECT count(uid) FROM pos_detail WHERE uid = '$R_uid' ORDER BY uid ASC";
			$dp_result = mysql_query($dp_query);
				if (!$dp_result) { error("QUERY_ERROR"); exit; }
			$count_uid = @mysql_result($dp_result,0,0);

			
			// Data Insert
			if($count_uid < 1) {
			
				$query_gabung = "INSERT INTO pos_detail (uid,transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,
							gross,nett,netvat,vat,sales_code,transcode,temp,qty) values ('$R_uid',
							'$R_transaction_code','$R_org_pcode','$R_barcode','$R_date','$R_hostname','$R_ip','$R_price','$R_disc_rate',
							'$R_gross','$R_nett','$R_netvat','$R_vat','$R_sales_code','$R_transcode','$R_temp','$R_qty')";
				$result_gabung = mysql_query($query_gabung);
				if (!$result_gabung) { error("QUERY_ERROR"); exit; }
			
			}
			
		}


  echo("<meta http-equiv='Refresh' content='5; URL=$home/pos_admin_restore.php'>");
  exit;
  

} 


}
?>