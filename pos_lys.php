<?php
/*
	Creator : Cihuy Programmer
*/
include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
require "config/user_functions_{$lang}.inc";

$mmenu = "main";
$smenu = "dashboard";

if(!$login_id OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=user_login.php'>");
} else {

$lys = $_GET['lys'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hokonga POS | Transaction List Page </title>
</head>
<!-- Creator by : Cihuy Programmer -->

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">
<!--external css-->
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

<!--dynamic table-->
<link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
<!--right slidebar-->
<link href="css/slidebars.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet" />
<!-- CSS POS -->
<link rel="stylesheet" href="css/pos.css">

<!-- ////////////////////////////////////////////////////////////////////////////////// -->

<div class="col-lg-12 table-responsive" id='main' style='border: 0px solid #FFF;'>
  <!--PRODUCT CART LIST-->
  <section class="panel">
  <form action="pos_list.php" method="post">
      <div class="panel-body progress-panel">
          <div class="task-progress">
          	  <img src="img/feelbuy-logo.jpg" style="height: 50px"><br/><br/>
              <h1>TRANSACTION LIST</h1>
              <p><?=$login_id?></p>
          </div>
      </div>
      <table class="table table1" id="mans">
      	 <thead class='thead'>
        	<tr>
              <td>TRANSACTION CODE</td>
              <td>TOTAL ITEM</td>
              <td>TOTAL PRICE</td>
              <td>VAT</td>
              <td>CASH AMOUNT</td>
              <td>CREDIT AMOUNT</td>
              <td>REMAIN</td>
            </tr>
          </thead>     

          <?php
            $query_ps = "SELECT count(id) FROM pos_total where hostname = '$hostname'";
            $result_ps = mysql_query($query_ps);
            $total =  @mysql_result($result_ps,0,0);

            $query_pos = "SELECT id,transaction_code,total_item,total_nett,total_vat,cash_amount,card_amount,cash_remain FROM pos_total where hostname = '$hostname'";
            $result_pos = mysql_query($query_pos);
            if (!$result_pos) {   error("QUERY_ERROR");   exit; }

            for ($k=0; $k < $total; $k++) { 

              $id = @mysql_result($result_pos,$k,0);
              $transaksie_kode =  @mysql_result($result_pos,$k,1);
              $totale_item =  @mysql_result($result_pos,$k,2);
              $totale_netto =  @mysql_result($result_pos,$k,3);
              $totale_vat =  @mysql_result($result_pos,$k,4);
              $kontant_bedrag =  @mysql_result($result_pos,$k,5);
              $krediet_bedrag =  @mysql_result($result_pos,$k,6);
              $kontant_bly =  @mysql_result($result_pos,$k,7);

          ?>

        	<tr>
              <td><a href="pos_list.php?transaksie='<?=base64_encode($transaksie_kode)?>" ><?=$transaksie_kode?></a></td>
        	    <td><?=$totale_item?></td>
              <td><?=number_format($totale_netto);?></td>
              <td><?=$totale_vat?></td>
              <td><?=number_format($kontant_bedrag);?></td>
              <td><?=$krediet_bedrag?></td>
              <td><?=number_format($kontant_bly);?></td>
            </tr>
        <?php
        	}
        ?>
         
      </table>
      <input type="hidden" class='form-control' name="id" value="<?=$id?>">
      <input type="hidden" class='form-control' name="transaction_code" value="<?=$transaksie_kode?>">
  </form>
  </section>
</div>

<!-- ////////////////////////////////////////////////////////////////////////////////// -->
<?php } ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</html>