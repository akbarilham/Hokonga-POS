<? 
/*
  Creator By : Cihuy Programmer
  Inspiration : Ena ena
  Version : 4.0
*/
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
require "config/user_functions_{$lang}.inc";

if(!$login_id OR $login_level < "1") {

  echo ("<meta http-equiv='Refresh' content='0; URL=user_login.php'>");

} else {
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
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">

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

  <body>

  <section id="container" >
  
    <!--main content start-->
    <section id="belangrikste-inhoud">
      
        <section class="wikkel">
          <img src="img/feelbuy-logo.jpg" style="margin-bottom: 2%; width: 13%; height: 7%">
            <!--state overview start-->
            <div class="row state-overview">

            <div class="row"> <!-- start div row -->
            <div class="col-lg-3" style="margin-left:20px">
              <form action="pos_closing.php">
                <input type="text" name="close" class="form-control" placeholder="<?=date('Y-m-d')?>"/>
                <input type="submit" class="form-control" value="Closing"/>
              </form>
              <a href="<?=$home?>/pos_admin.php" class="btn btn-primary" style=" color:#fff; width:30%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;">BACK</a>
            </div>
            </div>

            </div>
        </section>
    </section>
    <!--main content end-->

      <? include "right_slidebar.inc"; ?>
    
    
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>

<?php
$closing = $_GET['close'];

if ($closing != '') {

  // Get total closing
  $query_totale_sluit = "SELECT count(transaction_code) FROM pos_total WHERE closing > '0' AND trx_date LIKE '$closing%'";
  $fetch_totale_sluit = mysql_query($query_totale_sluit);
  if (!$fetch_totale_sluit) { error("QUERY_ERROR"); }
  $reken_sluit = mysql_result($fetch_totale_sluit,0,0); 

  for ($i=0; $i < $reken_sluit; $i++) { 

    // Show transaction_code
    $query_sluit = "SELECT transaction_code FROM pos_total WHERE closing > '0' AND trx_date LIKE '$closing%'";
    $result_sluit = mysql_query($query_sluit);
    if (!$result_sluit) { error("QUERY_ERROR"); }
    $bespreking_kode = mysql_result($result_sluit,$i,0);

    if ($bespreking_kode != '') {
/*
        // Deklarasi id dari pos_detail lalu hapus pake id, bukan transaction kode
        $query_id_C = "SELECT COUNT(uid) FROM pos_detail WHERE transaction_code = '$bespreking_kode'";
        $fetch_id_C = mysql_query($query_id_C);
        if (!$fetch_id_C) { error("QUERY_ERROR"); exit; }
        $detail_id_C = mysql_result($fetch_id_C,0,0);

        for ($ki=0; $ki < $detail_id_C; $ki++) { 

	        // ------------------- Closing Pos Detail -------------------- //  
	        
	        // Closing First step
	        $query_closing = "INSERT INTO pos_detail_closing (transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,gross,nett,netvat,vat,sales_code,transcode,temp,qty) 
	        SELECT transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,gross,nett,netvat,vat,sales_code,transcode,temp,qty 
	        FROM pos_detail WHERE transaction_code = '$bespreking_kode' AND temp = '9'";
	        $result_closing = mysql_query($query_closing);
	        if (!$result_closing) { error("QUERY_ERROR"); exit; }
	        echo ("Closing Detail $ki ... transaction_code [ $bespreking_kode ] .... <br>");

          
	        // Deklarasi id dari pos_detail lalu hapus pake id, bukan transaction kode
	        $query_id = "SELECT uid FROM pos_detail WHERE transaction_code = '$bespreking_kode'";
	        $fetch_id = mysql_query($query_id);
	        if (!$fetch_id) { error("QUERY_ERROR"); exit; }
	        $detail_id = mysql_result($fetch_id,$ki,0);
          
          
	        $query_delete = "DELETE FROM pos_detail WHERE uid = '$detail_id'";
	        $result_delete = mysql_query($query_delete);
	        if (!$result_delete) { error("QUERY_ERROR"); exit; }
	        echo ("Hapus Detail $detail_id ... transaction_code [ $bespreking_kode ] .... <br>"); 
        	
        }       
      */
        // ------------------- Closing Pos Total -------------------- //

        //if ($result_delete == TRUE) {
        
        // Closing Last Step
        $query_closing_2 = "INSERT INTO pos_total_closing (transaction_code,trx_date,user_id,hostname,cashier_id,total_item,total_gross,total_nett,total_nettax,total_vat,cash_amount,cash_remain,credit_amount,debit_amount,credit_no,debit_no,card_type,status,sesskey,closing)
        SELECT transaction_code,trx_date,user_id,hostname,cashier_id,total_item,total_gross,total_nett,total_nettax,total_vat,cash_amount,cash_remain,credit_amount,debit_amount,credit_no,debit_no,card_type,status,sesskey,closing FROM pos_total WHERE transaction_code = '$bespreking_kode'";
        $result_closing_2 = mysql_query($query_closing_2);
        if (!$result_closing_2) { error("QUERY_ERROR"); exit; }
        echo ("Closing Total $i ... transaction_code [ $bespreking_kode ] .... <br>");
/*
        // Deklarasi id dari pos_detail lalu hapus pake id, bukan transaction kode
        $query_id_2 = "SELECT uid FROM pos_detail WHERE transaction_code = '$bespreking_kode'";
        $fetch_id_2 = mysql_query($query_id_2);
        if (!$fetch_id) { error("QUERY_ERROR"); exit; }
        $detail_id_2 = mysql_result($fetch_id_2,$i,0);
*/
        
/*        $query_delete_2 = "DELETE FROM pos_total WHERE transaction_code = '$bespreking_kode'";
        $result_delete_2 = mysql_query($query_delete_2);
        if (!$result_delete_2) { error("QUERY_ERROR"); exit; }
        
        echo ("Hapus Total $detail_id_2 ... transaction_code [ $bespreking_kode ] .... <br>");        
        //*/}

    } 

  }

  echo ("<br>Completeing Closing<br><br>");
  echo ("<meta http-equiv='Refresh' content='3; URL=$home/pos_closing.php?close=$closing'>");

} else if ($closing == '') {
  //echo "<h4>Data belum dapat di close, silakan closing kasir terlebih dahulu</h4>";
 // echo ("<meta http-equiv='Refresh' content='3; URL=$home/pos_closing.php'>");
}
  
?>
<? include "footer.inc"; ?>
<? } ?>