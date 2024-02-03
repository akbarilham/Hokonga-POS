<? 
/*
  Creator By : Cihuy Programmer
  Inspiration : Ena ena
  Version : 3.0
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

             <a href="<?=$home?>/pos_admin.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;margin-bottom:10px">BACK</a>

            <div class="row"> <!-- start div row -->

              <!--Today start-->
              <div class="col-lg-10" style="margin-left: 1%">
                  <section class="panel">
                      <div class="panel-body progress-panel">
                          <div class="task-progress">
                              <h1>POS Recap by Name</h1>
                              <!--<p><?=$login_name2?></p>-->
                          </div>
                      </div>
                  <table class="table table-hover personal-task">
                  <tbody>
                  <tr>
                      <th> Name </th>
                      <th style="text-align:center;"> Trx </th>
                      <th style="text-align:center;"> Qty </th>
                      <th><center> Tunai </center></th>
                      <th><center> PPN </center></th>
                      <th><center> Debit </center></th>
                      <th><center> Kredit </center></th>
                      <th><center> Kembali </center></th>
                      <th><center> Gross </center></th>
                      <th><center> Nett </center></th>
                  </tr>                            
                  <? 
                  $tanggal_ini = date('Y-m-d');
      
                  $query_totale_uidk = "SELECT count(id) from pos_total where trx_date = '$tanggal_ini' ";
                  $fetch_totale_uidk = mysql_query($query_totale_uidk);
                  if (!$fetch_totale_uidk) { error("QUERY_ERROR"); exit; }
                  $totale_uidk = @mysql_result($fetch_totale_uidk,0,0);
      
                    $reken_uidk = 12;
    
                  for ($k=0; $k < $reken_uidk; $k++) { 

                    //Tyd transaksie vir Admin - Best items for Admin
                    $query_tyd = "SELECT user_id,count(transaction_code),sum(total_item),sum(cash_amount),sum(total_vat),sum(debit_amount),sum(credit_amount),sum(cash_remain),sum(total_gross),sum(total_nett),(sum(cash_amount)+sum(credit_amount)+sum(debit_amount)-sum(cash_remain) ) AS Total FROM `pos_total` GROUP BY user_id";
                    $fetch_tyd = mysql_query($query_tyd);
                    if (!$fetch_tyd) { error("QUERY_ERROR"); exit; }
                      $tyd_kassier = @mysql_result($fetch_tyd,$k,0);
                      $tyd_transaksie_J = @mysql_result($fetch_tyd,$k,1);
                      $tyd_qty = @mysql_result($fetch_tyd,$k,2);
                      $tyd_tunai = @mysql_result($fetch_tyd,$k,3);
                      $tyd_ppn = @mysql_result($fetch_tyd,$k,4);
                      $tyd_debit = @mysql_result($fetch_tyd,$k,5);
                      $tyd_credit = @mysql_result($fetch_tyd,$k,6);
                      $tyd_kembali = @mysql_result($fetch_tyd,$k,7);
                      $tyd_bruto = @mysql_result($fetch_tyd,$k,8);
                      $tyd_netto = @mysql_result($fetch_tyd,$k,9);                      
                  ?>
                  <tr>
                <?
                if ($tyd_kassier == '') {
                  $tyd_kassier_T = 'Cashier is not available';
                } elseif ($tyd_kassier != '') {
                  $tyd_kassier_T = $tyd_kassier;
                }
                ?>                            
                <td><?=$tyd_kassier_T?></td>
                <td style="text-align:right;"><?=number_format($tyd_transaksie_J)?></td>
                <td style="text-align:right;"><?=number_format($tyd_qty)?></td>
                <td style="text-align:right;"><?=number_format($tyd_tunai)?></td>
                <td style="text-align:right;"><?=number_format($tyd_ppn)?></td>
                <td style="text-align:right;"><?=number_format($tyd_debit)?></td>
                <td style="text-align:right;"><?=number_format($tyd_credit)?></td>
                <td style="text-align:right;"><?=number_format($tyd_kembali)?></td>
                <td style="text-align:right;"><?=number_format($tyd_bruto)?></td>
                <td><?=number_format($tyd_netto)?></td>
                </tr>
                <? 
                $tyd_transaksie_K3 += $tyd_transaksie_J;
                $tyd_qty_K3 += $tyd_qty;
                $tyd_tunai_K3 += $tyd_tunai;
                $tyd_ppn_K3 += $tyd_ppn;
                $tyd_debit_K3 += $tyd_debit;
                $tyd_credit_K3 += $tyd_credit;
                $tyd_kembali_K3 += $tyd_kembali;
                $tyd_netto_K3 += $tyd_netto;
                $tyd_bruto_K3 += $tyd_bruto;              
                } 
                ?>                
                  <tr>
                    <td><b>TOTAL</b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_transaksie_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_qty_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_tunai_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_ppn_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_debit_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_credit_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_kembali_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_bruto_K3)?></b></td>
                    <td><b><?=number_format($tyd_netto_K3)?></b></td>
                  </tr>                                                            
                  </tbody>
                  </table>                            
                </div>
                <!--Today end-->        

              <!--Total start-->
              <div class="col-lg-10" style="margin-left: 1%">
                  <section class="panel">
                      <div class="panel-body progress-panel">
                          <div class="task-progress">
                              <h1>POS Recap by Cashier</h1>
                              <!--<p><?=$login_name2?></p>-->
                          </div>
                      </div>
                  <table class="table table-hover personal-task">
                  <tbody>
                  <tr>
                      <th> Cashier </th>
                      <th style="text-align:center;"> Trx </th>
                      <th style="text-align:center;"> Qty </th>
                      <th><center> Tunai </center></th>
                      <th><center> PPN </center></th>
                      <th><center> Debit </center></th>
                      <th><center> Kredit </center></th>
                      <th><center> Kembali </center></th>                      
                      <th><center> Gross </center></th>
                      <th><center> Nett </center></th>
                  </tr>                            
                  <? 
                  $tanggal_ini = date('Y-m-d');
      
                  $query_totale_uidk = "SELECT count(id) from pos_total where trx_date = '$tanggal_ini' ";
                  $fetch_totale_uidk = mysql_query($query_totale_uidk);
                  if (!$fetch_totale_uidk) { error("QUERY_ERROR"); exit; }
                  $totale_uidk = @mysql_result($fetch_totale_uidk,0,0);
      
                    $reken_uidk = 10;
    
                  for ($k=0; $k < $reken_uidk; $k++) { 

                    //Tyd transaksie vir Admin - Best items for Admin
                    $query_totale = "SELECT cashier_id,count(transaction_code),sum(total_item),sum(cash_amount),sum(total_vat),sum(debit_amount),sum(credit_amount),sum(cash_remain),sum(total_gross),sum(total_nett),(sum(cash_amount)+sum(credit_amount)+sum(debit_amount)-sum(cash_remain) ) AS Total FROM `pos_total` GROUP BY cashier_id";
                    $fetch_totale = mysql_query($query_totale);
                    if (!$fetch_totale) { error("QUERY_ERROR"); exit; }
                      $totale_kassier = @mysql_result($fetch_totale,$k,0);
                      $totale_transaksie_J = @mysql_result($fetch_totale,$k,1);
                      $totale_qty = @mysql_result($fetch_totale,$k,2);
                      $totale_tunai = @mysql_result($fetch_totale,$k,3);
                      $totale_ppn = @mysql_result($fetch_totale,$k,4);
                      $totale_debit = @mysql_result($fetch_totale,$k,5);
                      $totale_credit = @mysql_result($fetch_totale,$k,6);
                      $totale_kembali = @mysql_result($fetch_totale,$k,7);
                      $totale_bruto = @mysql_result($fetch_totale,$k,8);
                      $totale_netto = @mysql_result($fetch_totale,$k,9);  
                  ?>
                  <tr>
                <?
                if ($totale_kassier == '') {
                  $totale_kassier_T = 'Cashier is not available';
                } elseif ($tyd_kassier != '') {
                  $totale_kassier_T = $totale_kassier;
                }
                ?>                            
                <td><?=$totale_kassier_T?></td>
                <td style="text-align:right;"><?=number_format($totale_transaksie_J)?></td>
                <td style="text-align:right;"><?=number_format($totale_qty)?></td>
                <td style="text-align:right;"><?=number_format($totale_tunai)?></td>
                <td style="text-align:right;"><?=number_format($totale_ppn)?></td>
                <td style="text-align:right;"><?=number_format($totale_debit)?></td>
                <td style="text-align:right;"><?=number_format($totale_credit)?></td>
                <td style="text-align:right;"><?=number_format($totale_kembali)?></td>
                <td style="text-align:right;"><?=number_format($totale_bruto)?></td>
                <td><?=number_format($totale_netto)?></td>
                </tr>
                <? 
                $totale_transaksie_K3 += $totale_transaksie_J;
                $totale_qty_K3 += $totale_qty;
                $totale_tunai_K3 += $totale_tunai;
                $totale_ppn_K3 += $totale_ppn;
                $totale_debit_K3 += $totale_debit;
                $totale_credit_K3 += $totale_credit;
                $totale_kembali_K3 += $totale_kembali;
                $totale_netto_K3 += $totale_netto;
                $totale_bruto_K3 += $totale_bruto;              
                } 
                ?>                
                  <tr>
                    <td><b>TOTAL</b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_transaksie_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_qty_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_tunai_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_ppn_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_debit_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_credit_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_kembali_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($totale_bruto_K3)?></b></td>
                    <td><b><?=number_format($totale_netto_K3)?></b></td>
                  </tr>                                                            
                </tbody>
                </table>                            
                </div>
                <!--Total end-->        

                </div> <!-- end of div row -->
            </div>

        </section>
    </section>
    <!--main content end-->

      <? include "right_slidebar.inc"; ?>

      <? include "footer.inc"; ?>
    
    
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>                
<? } ?>