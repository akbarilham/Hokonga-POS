<?
/*
  Creator By : Cihuy Programmer
  Inspiration : Ena ena
  Version : 5.0
*/
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
require "config/user_functions_{$lang}.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {

  echo ("<meta http-equiv='Refresh' content='0; URL=user_login.php'>");

} else {

$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//---------------------------- Vir Admin ----------------------------------------//

// Verkope vir Admin - Sales for Admin
$query_verkope = "SELECT sum(qty) FROM pos_detail WHERE temp = '9'";
$fetch_verkope = mysql_query($query_verkope);
if (!$fetch_verkope) { error("QUERY_ERROR"); exit; }
  $totale_verkope = @mysql_result($fetch_verkope,0,0);

// Transaksie vir Admin - Transaction for Admin
$query_transaksie = "SELECT count(transaction_code) FROM pos_total2";
$fetch_transaksie = mysql_query($query_transaksie);
if (!$fetch_transaksie) { error("QUERY_ERROR"); exit; }
  $totale_transaksie = @mysql_result($fetch_transaksie,0,0);

// Wins vir Admin - Profit for Admin
$query_wins = "SELECT sum(total_nett) FROM pos_total2";
$fetch_wins = mysql_query($query_wins);
if (!$fetch_wins) { error("QUERY_ERROR"); exit; }
  $totale_wins = @mysql_result($fetch_wins,0,0);

  // Skakel na Miljoen - Convert to Million
  if ($totale_wins > 999 && $totale_wins <= 999999) {
      $resultaat = floor($totale_wins / 1000) . ' Rb';
  } elseif ($totale_wins > 999999) {
      $resultaat = floor($totale_wins / 1000000) . ' Jt';
  } else {
      $resultaat = $totale_wins;
  }

//---------------------------- Vir Kassier ----------------------------------------//

// Verkope vir kassier = Sales for Cashier
$navra_verkope = "SELECT sum(qty) FROM pos_detail WHERE temp = '9' AND hostname = '$hostname' AND sales_code = '$login_id'";
$haal_verkope = mysql_query($navra_verkope);
if (!$haal_verkope) { error("QUERY_ERROR"); exit; }
  $kassier_verkope = @mysql_result($haal_verkope,0,0);

// Voorraad vir Admin - Stocks for Admin
$navra_voorraad = "SELECT sum(stok_awal) FROM item_masters ";
$haal_voorraad = mysql_query($navra_voorraad);
if (!$haal_voorraad) { error("QUERY_ERROR"); exit; }
  $kassier_voorraad = @mysql_result($haal_voorraad,0,0);

// Transaksie vir Admin - Transaction for Admin
$navra_transaksie = "SELECT SUM(count) FROM (SELECT COUNT(transaction_code) AS count FROM pos_detail WHERE transaction_code like 'BS%') as A";
$haal_transaksie = mysql_query($navra_transaksie);
if (!$haal_transaksie) { error("QUERY_ERROR"); exit; }
  $kassier_transaksie = @mysql_result($haal_transaksie,0,0);

// Wins vir Admin - Profit for Admin
$navra_wins = "SELECT sum(total_nett) FROM pos_total WHERE status = '9' AND hostname = '$hostname' AND user_id = '$login_id'";
$haal_wins = mysql_query($navra_wins);
if (!$haal_wins) { error("QUERY_ERROR"); exit; }
  $kassier_wins = @mysql_result($haal_wins,0,0);
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
          <br/>
          <a href="<?=$home?>" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;margin-bottom:10px">BACK</a>

            <!--state overview start-->
            <div class="row state-overview">

                <!-- Transaction Block -->
                <a href="pos_master.php?trans=list">
                <div class="col-lg-3 col-sm-6">
                    <section class="panel">
                        <div class="symbol terques">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="value">
                            <h1 class="count">
                               0
                            </h1>
                            <p>Transactions</p>
                        </div>
                    </section>
                </div>
                </a>

                <!-- Stock Block -->
                <a href="pos_master.php">
                <div class="col-lg-3 col-sm-6">
                    <section class="panel">
                        <div class="symbol red">
                            <i class="fa fa-tags"></i>
                        </div>
                        <div class="value">
                            <h1 class="count2">
                            0
                            </h1>
                            <p>Stocks</p>
                        </div>
                    </section>
                </div>
                </a>

                <a href="pos_closing.php">
                <!-- Sales Block -->
                <div class="col-lg-3 col-sm-6">
                    <section class="panel">
                        <div class="symbol yellow">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="value">
                            <h1 class="count3">
                                0
                            </h1>
                            <p>Sales</p>
                        </div>
                    </section>
                </div>
                </a>

                <!-- Profit Block -->
                <a href="pos_recap.php">
                <div class="col-lg-3 col-sm-6">
                    <section class="panel">
                        <div class="symbol blue">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="value">
                            <!--<h1 class=" count4">-->
                            <h1>
                                <?=$resultaat?>
                            </h1>
                            <p>Total Profit</p>
                        </div>
                    </section>
                </div>
                </a>

            </div>
            <!--state overview end-->

            <div class="row"> <!-- start div row -->

              <!--Today start-->
              <div class="col-lg-6">
                  <section class="panel">
                      <div class="panel-body progress-panel">
                          <div class="task-progress">
                              <h1>Total /Name</h1>
                              <!--<p><?=$login_name2?></p>-->
                          </div>
                      </div>
                  <table class="table table-hover personal-task">
                  <tbody>
                  <tr>
                      <th> Cashier Number </th>
                      <th style="text-align:center;"> Trx </th>
                      <th style="text-align:center;"> Qty </th>
                      <th><center> Gross </center></th>
                      <th><center> Nett </center></th>
                  </tr>
                  <?
                  $tanggal_ini = date('Y-m-d');

                  $query_totale_uidk = "SELECT count(id) from pos_total2 where trx_date like '$tanggal_ini%' ";
                  $fetch_totale_uidk = mysql_query($query_totale_uidk);
                  if (!$fetch_totale_uidk) { error("QUERY_ERROR"); exit; }
                  $totale_uidk = @mysql_result($fetch_totale_uidk,0,0);

                    $reken_uidk = 10;

                  for ($k=0; $k < $reken_uidk; $k++) {

                    //Tyd transaksie vir Admin - Best items for Admin
                    $query_tyd = "SELECT cashier_id, count(transaction_code) as trx, sum(total_nett) as nett,sum(total_item) as qty,sum(total_gross) as gross from pos_total2 where trx_date like '$tanggal_ini%' group by cashier_id";
                    $fetch_tyd = mysql_query($query_tyd);
                    if (!$fetch_tyd) { error("QUERY_ERROR"); exit; }
                      $tyd_kassier = @mysql_result($fetch_tyd,$k,0);
                      $tyd_transaksie_J = @mysql_result($fetch_tyd,$k,1);
                      $tyd_netto = @mysql_result($fetch_tyd,$k,2);
                      $tyd_qty = @mysql_result($fetch_tyd,$k,3);
                      $tyd_bruto = @mysql_result($fetch_tyd,$k,4);
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
                <td style="text-align:right;"><?=number_format($tyd_bruto)?></td>
                <td><?=number_format($tyd_netto)?></td>
                </tr>
                <?
                $tyd_transaksie_K3 += $tyd_transaksie_J;
                $tyd_qty_K3 += $tyd_qty;
                $tyd_netto_K3 += $tyd_netto;
                $tyd_bruto_K3 += $tyd_bruto;
    }
                ?>
                  <tr>
                    <td><b>TOTAL </b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_transaksie_K3)?></b></td>
                    <td style="text-align:right;"><b><?=number_format($tyd_qty_K3)?></b></td>
                <td style="text-align:right;"><b><?=number_format($tyd_bruto_K3)?></b></td>
                              <td><b><?=number_format($tyd_netto_K3)?></b></td>
                            </tr>
                          </tbody>
                      </table>
                </div>
                <!--Today end-->

                <!--Total start-->
                <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body progress-panel">
                            <div class="task-progress">
                                <h1>Total /Number</h1>
                                <!--<p><?=$login_name2?></p>-->
                            </div>
                        </div>
                    <table class="table table-hover personal-task">
                    <tbody>
                    <tr>
                        <th> Cashier Number </th>
                        <th style="text-align:center;"> Trx </th>
                        <th style="text-align:center;"> Qty </th>
                        <th><center> Gross </center></th>
                        <th><center> Nett </center></th>
                    </tr>
                    <?
                    $datum = date('Y-m-d'); // Tanggal
                    $query_totale = "SELECT count(id) from pos_total_closing where trx_date = '$datum' "; // Query Today
                    $fetch_totale = mysql_query($query_totale);
                    if (!$fetch_totale) { error("QUERY_ERROR"); exit; }
                    $totale_totale = @mysql_result($fetch_totale,0,0);

                      $reken_totale = 10;

                    for ($k=0; $k < $reken_totale; $k++) {
                      $kk = $k +1;

                      //Totale transaksie vir Admin - Best items for Admin
                      $query_totale_J = "SELECT cashier_id, count(transaction_code) as trx, sum(total_nett) as nett,sum(total_item) as qty,sum(total_gross) as gross from pos_total_closing WHERE status = 'P' group by cashier_id";
                      $fetch_totale_J = mysql_query($query_totale_J);
                      if (!$fetch_totale_J) { error("QUERY_ERROR"); exit; }
                        $totale_kassier = @mysql_result($fetch_totale_J,$k,0);
                        $totale_transaksie_J = @mysql_result($fetch_totale_J,$k,1);
                        $totale_netto = @mysql_result($fetch_totale_J,$k,2);
                        $totale_qty = @mysql_result($fetch_totale_J,$k,3);
                        $totale_bruto = @mysql_result($fetch_totale_J,$k,4);
                    ?>
                <tr>
                <?
                if ($totale_kassier == '') {
                  $totale_kassier_T = 'Cashier is not available';
                } elseif ($totale_kassier != '') {
                  $totale_kassier_T = $totale_kassier;
                }
                ?>
                    <td><?=$totale_kassier_T?></td>
                    <td style="text-align:right;"><?=number_format($totale_transaksie_J)?></td>
                    <td style="text-align:right;"><?=number_format($totale_qty)?></td>
                    <td style="text-align:right;"><?=number_format($totale_bruto)?></td>
                    <td><?=number_format($totale_netto)?></td>
                </tr>
                <?
                $totale_transaksie_K3 += $totale_transaksie_J;
                $totale_qty_K3 += $totale_qty;
                $totale_netto_K3 += $totale_netto;
                $totale_bruto_K3 += $totale_bruto;
                }
                ?>
                <tr>
                  <td><b>TOTAL</b></td>
                  <td style="text-align:right;"><b><?=number_format($totale_transaksie_K3)?></b></td>
                  <td style="text-align:right;"><b><?=number_format($totale_qty_K3)?></b></td>
                  <td style="text-align:right;"><b><?=number_format($totale_bruto_K3)?></b></td>
                  <td><b><?=number_format($totale_netto_K3)?></b></td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <!--Total end-->

          <!--Curren Transaction start-->
          <div class="col-lg-6">
              <section class="panel">
                  <div class="panel-body progress-panel">
                      <div class="task-progress">
                          <h1>Real Time</h1>
                          <!--<p><?=$login_name2?></p>-->
                      </div>
                  </div>
                <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <th> Transaction No </th>
                    <th style="text-align: center;"> Qty </th>
                    <th style="text-align: center;"> Prices </th>
                    <th style="text-align: center;"> Payment Method </th>
                </tr>
                <?
                $query_totale_uidk = "SELECT count(id) from pos_total";
                $fetch_totale_uidk = mysql_query($query_totale_uidk);
                if (!$fetch_totale_uidk) { error("QUERY_ERROR"); exit; }
                $totale_uidk = @mysql_result($fetch_totale_uidk,0,0);

                  $reken_uidk = 10;

                for ($k=0; $k < $reken_uidk; $k++) {

                  //Huidige transaksie vir Admin - Best items for Admin
                  $query_huidige = "SELECT transaction_code,total_nett,total_item,card_type FROM pos_total order by transaction_code desc";
                  $fetch_huidige = mysql_query($query_huidige);
                  if (!$fetch_huidige) { error("QUERY_ERROR"); exit; }
                    $huidige_transaksie = @mysql_result($fetch_huidige,$k,0);
                    $netto = @mysql_result($fetch_huidige,$k,1);
                    $punkt = @mysql_result($fetch_huidige,$k,2);
                    $tipe_kaart = @mysql_result($fetch_huidige,$k,3);
                ?>
                <tr>
                <?
                if ($huidige_transaksie == '') {
                  $huidige_transaksie_T = 'Transaction is not available';
                } elseif ($huidige_transaksie != '') {
                  $huidige_transaksie_T = $huidige_transaksie;
                }
                ?>
                <td><?=$huidige_transaksie_T?></td>
                <td style="text-align: right;"><?=number_format($punkt)?></td>
                <td style="text-align: right;"><?=number_format($netto)?></td>
                <?
                switch ($tipe_kaart) {
                  case '3':
                    $betalings_metode = 'Tunai';
                    break;

                  case '6':
                    $betalings_metode = 'Debit';
                    break;

                  case '9':
                    $betalings_metode = 'Kredit';
                    break;

                  case 'TD':
                    $betalings_metode = 'Tunai & Debit';
                    break;

                  case 'TK':
                    $betalings_metode = 'Tunai & Kredit';
                    break;

                  case 'DK':
                    $betalings_metode = 'Debit & Kredit';
                    break;

                  case 'TKD':
                    $betalings_metode = 'Tunai & Debit & Kredit';
                    break;

                  default:
                    $betalings_metode = 'Payment method';
                    break;
                }

                ?>
                <td style="text-align: center;"><?=$betalings_metode?></td>
                <td style="display: none;">ena</td>
            </tr>
                  <? } ?>
                  </tbody>
              </table>
          </div>
          <!--Current Transaction end-->

                    <?/*
                      <!--user info table start-->
                      <div class="col-lg-4" style="float: left;">
                          <section class="panel">
                              <div class="panel-body">
                                  <a href="#" class="task-thumb">
                                      <img src="<?=$login_photo_img1?>" style="width: 80px" alt="">
                                  </a>
                                  <div class="task-thumb-details">
                                      <h1><a href="#"><?=$login_id?></a></h1>
                                      <p>Cashier no : 1</p>
                                  </div>
                                  <div class="task-option">
                                      <select class="styled">
                                          <option>Cashier 2</option>
                                          <option>Cashier 3</option>
                                          <option>Cashier 4</option>
                                      </select>
                                  </div>
                              </div>
                              <table class="table table-hover personal-task">
                                  <tbody>
                                    <tr>
                                        <td>
                                            <i class=" fa fa-tasks"></i>
                                        </td>
                                        <td>Sales</td>
                                        <td><?=number_format($kassier_verkope);?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </td>
                                        <td>Profits</td>
                                        <td><?=number_format($kassier_wins);?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-envelope"></i>
                                        </td>
                                        <td>Switch</td>
                                        <td> 45</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="fa fa-envelope"></i>
                                        </td>
                                        <td>Void</td>
                                        <td> 1</td>
                                    </tr>
                                  </tbody>
                              </table>
                          </section>
                      </div>
                      <!--user info table end-->
                      */ ?>

                      <!--Best Items start-->
                      <div class="col-lg-6">
                          <section class="panel">
                              <div class="panel-body progress-panel">
                                  <div class="task-progress">
                                      <h1>Best Items</h1>
                                      <!--<p><?=$login_name2?></p>-->
                                  </div>
                              </div>
                              <table class="table table-hover personal-task">
                                  <tbody>
                                  <tr>
                                      <th>No</th>
                                      <th>Product Code</th>
                                      <th>Product Name</th>
                                      <th>Qty Sold</th>
                                  </tr>
                                  <?
                                  for ($k=0; $k < 10; $k++) {

                                    //Beste item vir Admin - Best items for Admin
                                    $query_beste = "SELECT pd.org_pcode,spl.pname, sum(pd.qty) as best FROM pos_detail pd INNER JOIN item_masters spl ON pd.org_pcode = spl.org_pcode WHERE pd.temp = '9' group by pd.org_pcode order by best desc";
                                    $fetch_beste = mysql_query($query_beste);
                                    if (!$fetch_beste) { error("QUERY_ERROR"); exit; }
                                      $product_code = @mysql_result($fetch_beste,$k,0);
                                      $best_items = @mysql_result($fetch_beste,$k,1);
                                      $totale_best_items = @mysql_result($fetch_beste,$k,2);
                                  ?>
                                  <tr>
                                      <td><?=$k+1?></td>
                                  <?
                                  if ($product_code == '') {
                                    $product_code_T = '-';
                                  } elseif ($product_code != '') {
                                    $product_code_T = $product_code;
                                  }
                                  ?>
                                                      <td><?=$product_code_T?></td>
                                  <?
                                  if ($best_items == '') {
                                    $best_items_T = 'Product is not available';
                                  } elseif ($best_items != '') {
                                    $best_items_T = $best_items;
                                  }
                                  ?>
                                      <td>
                                          <?=$best_items_T?>
                                      </td>
                                      <td>
                                          <center><?=number_format($totale_best_items)?></center>
                                      </td>
                                  </tr>
                                  <? } ?>
                                  </tbody>
                              </table>
                          </section>
                      </div>
                      <!--Best Items end-->

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

  <?
  // Counter 2 - Sales
  // $query_count2 = "SELECT count(uid) FROM finance WHERE f_class = 'in' AND branch_code = '$login_branch'";
  $query_count2 = "SELECT count(uid) FROM finance WHERE f_class = 'in'";
  $result_count2 = mysql_query($query_count2,$dbconn);
    if (!$result_count2) { error("QUERY_ERROR"); exit; }
  // $zcount2 = @mysql_result($result_count2,0,0);
  $zcount2 = 927;

  ?>

  <script>
  function countUp(count)
  {
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
  }

  countUp("<?=$totale_transaksie?>");


  function countUp2(count)
  {
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count2'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
  }

  countUp2("<?=$totale_voorraad?>");


  function countUp3(count)
  {
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count3'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
  }

  countUp3("<?=$totale_verkope?>");


  function countUp4(count)
  {
    var div_by = 100,
        speed = Math.round(count / div_by),
        $display = $('.count4'),
        run_count = 1,
        int_speed = 24;

    var int = setInterval(function() {
        if(run_count < div_by){
            $display.text(speed * run_count);
            run_count++;
        } else if(parseInt($display.text()) < count) {
            var curr_count = parseInt($display.text()) + 1;
            $display.text(curr_count);
        } else {
            clearInterval(int);
        }
    }, int_speed);
  }

  countUp4("<?=$totale_wins?>");
  </script>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
        autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

$(document).ready(
    function() {
        setInterval(function() {
            /*var randomnumber = Math.floor(Math.random() * 100);
            $('#show').text(
                    'I am getting refreshed every 3 seconds..! Random Number ==> '
                            + randomnumber);*/
        }, 3000);
    });

  </script>

  </body>
</html>
<?  echo ("<meta http-equiv='Refresh' content='7; URL=$home/pos_admin.php'>");  ?>

<? } ?>
