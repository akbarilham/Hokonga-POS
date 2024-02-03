<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "finance";
$smenu = "currency_balance";

if(!$step_next)  {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom
if(!$page) { $page = 1; }

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

    <!--dynamic table-->
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
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


//$query_HC = "SELECT count(uid) FROM finance_curr WHERE user_id = '$login_id'";
$query_HC = "SELECT count(uid) FROM finance_curr";
$result_HC = mysql_query($query_HC);
if (!$result_HC) {   error("QUERY_ERROR");   exit; }
    
$tot_uid = @mysql_result($result_HC,0,0);


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";

  $qday1 = substr($post_date1,0,4);
  $qday2 = substr($post_date1,4,2);
  $qday3 = substr($post_date1,6,2);

  if($lang == "ko") {
     $qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3";
   } else {
    $qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1";
   }
?>
    
            
    <!--body wrapper start-->
<div class="wrapper">
        <? if($mode != "order_form") { ?>
    <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
          Input
        </header>
        <div class="panel-body">
          <section id="unseen">
          <form name='curr' method='post' autocomplete="off" action='currency_balance.php'>
            <table class="table table-bordered table-condensed">
            <thead>
        <tr>
            <th>Purchase Date</th>
            <th colspan='2'>Foreign</th>
            <th >Kurs</th>
            <th></th>
        </tr>
        </thead>
    
    
        <tbody>
                <?       
                echo ("
                <tr>
                <input type=hidden name='cart_mode' value='BAL_ADD'>
                <input type=hidden name='page' value='$page'>
                <input type=hidden name='user' value='$login_id'>
                <input type=hidden name='post_dates' value='$post_dates'>
                
                <td><input type='text' name='date' class='form-control' value='$qs_date_txt' required></td>
                <td>
                    <select name='FRID' class='form-control'>
                        <option value='USD'>USD</option>
                        <option value='SGD'>SGD</option>
                        <option value='KRW'>KRW</option>
                        <option value='MYR'>MYR</option>
                        <option value='EUR'>EUR</option>
                    </select>
                </td>
                <td>
                    <input type='text' pattern='[0-9.]+' name='amount_usd' class='form-control'  placeholder = 'Amount' required>
                </td>
                <td><input type='text' pattern='[0-9.]+' name='amount_idr' class='form-control' placeholder = 'Amount' required></td>
                <td><input type='submit' value='New' name='New' class='btn btn-default'></td>
                </form>
                
                </tr>
                ");
              
                ?>
        </tbody>
    </table>
    </section>
    </div>
    </section>
    </div>
     </div>
    
   <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
          Currency Inputed
        </header>
        <div class="panel-body">
          <section id="unseen">
            <div class="adv-table">
            <table class="display table table-bordered table-striped table-condensed" id="dynamic-table">
            <thead>
    <tr>
      <th>UID</th>
      <th>Purchase Date</th>
      <th>Amount</th>
      <th>Kurs</th>
      <th>Total</th>
    </tr>
    </thead>
    <tbody>
      <?
        $fc_query = 'SELECT uid,org_currency_amount,currency_amount,xchge_default_rate,date,post_date,gate,branch_code,currency FROM finance_curr order by uid asc';
            $fc_result = mysql_query($fc_query);
            if (!$fc_result) { error("QUERY_ERROR"); exit; }

            for($i = 0 ; $i <= $tot_uid ; $i++){
            $uid = @mysql_result($fc_result,$i,0);
            $org_currency = mysql_result($fc_result,$i,1);
            $currency_amount = mysql_result($fc_result,$i,2);
            $xchge_default_rate = mysql_result($fc_result,$i,3);
            $qs_date = mysql_result($fc_result,$i,4);
            $post_date = mysql_result($fc_result,$i,5);
            $gate = mysql_result($fc_result,$i,6);
            $branch_code = mysql_result($fc_result,$i,7);
            $frid = mysql_result($fc_result,$i,8);

            $balance = $currency_amount * $org_currency;

            $qday4 = substr($qs_date,0,4);
            $qday5 = substr($qs_date,4,2);
            $qday6 = substr($qs_date,6,2);
             if($lang == "ko") {
               $qs_date_txt1 = "$qday4"."/"."$qday5"."/"."$qday6";
             } else {
              $qs_date_txt1 = "$qday6"."-"."$qday5"."-"."$qday4";
             }

             $total_bal += $balance;
      

      ?>
      <?if($currency_amount == 0){?>
      <tr style="display:none;" style='background:#CCC'>
      <td>#</td>
      <td>--</td>
      <td>--</td>
      <td>--</td>
      <td>--</td>
      </tr>
      <?}else{?>
      <tr>
      <td><?=$uid?></td>
      <td><?=$qs_date_txt1;?></td>
      <td><?php echo $frid;?> <?=number_format(floatval($currency_amount),2);?></td>
      <td><?=number_format($org_currency);?></td>
      <td><?=number_format(floatval($balance),2);?></td>
      </tr>

      <?}}?>
    </tbody>
    <tfoot style='background:#e0e0e0;' >
      <?
        $query_jml = "SELECT sum(currency_amount) FROM finance_curr where currency = 'USD'";
        $result_jml = mysql_query($query_jml);
        if (!$result_jml) {   error("QUERY_ERROR");   exit; }
        $jml_USD = @mysql_result($result_jml,0,0);

        $query_jml2 = "SELECT sum(currency_amount) FROM finance_curr where currency = 'SGD'";
        $result_jml2 = mysql_query($query_jml2);
        if (!$result_jml2) {   error("QUERY_ERROR");   exit; }
        $jml_SGD = @mysql_result($result_jml2,0,0);

         $query_jml3 = "SELECT sum(currency_amount) FROM finance_curr where currency = 'KRW'";
        $result_jml3 = mysql_query($query_jml3);
        if (!$result_jml3) {   error("QUERY_ERROR");   exit; }
        $jml_KRW = @mysql_result($result_jml3,0,0);

         $query_jml4 = "SELECT sum(currency_amount) FROM finance_curr where currency = 'MYR'";
        $result_jml4 = mysql_query($query_jml4);
        if (!$result_jml4) {   error("QUERY_ERROR");   exit; }
        $jml_MYR = @mysql_result($result_jml4,0,0);
        
        $query_jml5 = "SELECT sum(currency_amount) FROM finance_curr where currency = 'EUR'";
        $result_jml5 = mysql_query($query_jml5);
        if (!$result_jml5) {   error("QUERY_ERROR");   exit; }
        $jml_EUR = @mysql_result($result_jml5,0,0);

        $query_USD = "SELECT currency_01_rate FROM client_currency";
        $result_USD = mysql_query($query_USD);
        if (!$result_USD) {   error("QUERY_ERROR");   exit; }
        $USD = @mysql_result($result_USD,0,0);
        
      ?>
      <tr>
          <td colspan='1'>Total All</td>
          <td colspan='3'>
            <marquee behavior="scroll" direction="left"> <b>USD <?=number_format(floatval($jml_USD),2)?></b> |  <b>SGD <?=number_format(floatval($jml_SGD),2)?></b> | <b>KRW <?=number_format(floatval($jml_KRW),2)?></b> | <b>MYR <?=number_format(floatval($jml_MYR),2)?></b> | <b>EUR <?=number_format(floatval($jml_EUR),2)?></b></marquee>
            <!-- <b><?=number_format(floatval($jml),2);?> x Default (<?=$USD?>) = <?=number_format(floatval($jml*$USD),2);?></b> -->
          </td>
          <td><b>IDR <?=number_format(floatval($total_bal),2);?></b></td>
      </tr>
    </tfoot>
    </table>
    </div>
    </section>
        </div>
        </section>
        </div>
        </div>
   
    
  <? include "right_slidebar.inc"; ?>
    
    <? include "footer.inc"; ?>
    
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
     <script src="js/jquery.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
  
  <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <script src="js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="js/slidebars.min.js"></script>

    <!--dynamic table initialization -->
    <script src="js/dynamic_table_init3.js"></script>


    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>
</html>
 <? }


    if($cart_mode == 'BAL_ADD' AND $amount_usd != 0){
          
         if($lang == "ko") {
            $datex= explode('/',$date);
           //$qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3";
            $dates = $datex[0].$datex[1].$datex[2];
         } else {
            $datex= explode('-',$date);
            //$qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1";
            $dates = $datex[2].$datex[1].$datex[0];
         }


          $query_C2 = "INSERT INTO finance_curr (uid,org_currency_amount,currency_amount,xchge_default_rate,date,post_date,gate,branch_code,user_id,f_class,currency) 
          values ('','$amount_idr','$amount_usd','','$dates','$post_dates','','','$user','','$FRID')";
         $result_C2 = mysql_query($query_C2);
        if (!$result_C2) { error("QUERY_ERROR"); exit; }
        echo("<meta http-equiv='Refresh'  content='0; URL='currency_balance.php'>");
        clearstatcache();
      exit;
        ?>
    <? } ?>

<?


}

}
?>