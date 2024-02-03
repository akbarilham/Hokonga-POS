

<?php

include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$void = $_GET['void'];
$trans = $_GET['trans'];
$del = $_GET['del'];
$sec= $_GET['security'];
$pid=$_GET['pid'];

// Get data from POS TOTAL
$query_pos_total = "SELECT transaction_code,trx_date,sales_code,total,dump
          FROM pos_total2 WHERE transcode = '$trans'";
$result_pos_total = mysql_query($query_pos_total);
if (!$result_pos_total) {   error("QUERY_ERROR");   exit; }
$transaction_code = @mysql_result($result_pos_total,0,0);
$trx_date_J = @mysql_result($result_pos_total,0,1);
$sales_code = @mysql_result($result_pos_total,0,2);
$payments = @mysql_result($result_pos_total,0,3);
$payments_ex = explode("|", $payments);
$dump = @mysql_result($result_pos_total,0,4);

$total_item = $payments_ex[0];
$total_nett = $payments_ex[1];
$total_gross = $payments_ex[2];
$cash_amount = $payments_ex[5];
$cash_remain = $payments_ex[6];
$credit_amount = $payments_ex[7];
$debit_amount = $payments_ex[8];
$krediet_kaart = $payments_ex[9];
$debiet_kaart = $payments_ex[10];
$card_type = $payments_ex[11];

$new_payments = $total_item.'|'.$total_gross.'|'.$total_nett.'|'.$total_nettax.'|'.$total_vat.'|'.$cash_amount.'|'.$cash_remain.'|'.$credit_card_amount.'|'.$debit_card_amount.'|'.$krediet_kaart.'|'.$debiet_kaart.'|'.$card_type;

// Show all carts
$query_pay = "SELECT uid,detail,datedetail,temp FROM pos_detail_backup
WHERE sales_code ='$sales_code' AND temp = '9' AND transcode = '$trans'";
$result_pay = mysql_query($query_pay);
if (!$result_pay) {   error("QUERY_ERROR"); exit; }

$uid = @mysql_result($result_pay,0,0);
$detail = @mysql_result($result_pay,0,1);
$detail_ex = explode("|", $detail);
$datedetail = @mysql_result($result_pay,0,2);
$temp = @mysql_result($result_pay,0,3);

/*$pcode = $detail_ex[0];
$barcode = $detail_ex[1];
$pname = $detail_ex[2];
$price = $detail_ex[3];
$disc_rate = $detail_ex[4];
$gross = $detail_ex[5];
$nett = $detail_ex[6];
$nettvat = $detail_ex[7];
$vat = $detail_ex[8];
*/
?>
<script language="javascript">
function selectIt() {
window.opener.location.href = '<?=$home?>/pos_cart_void.php?void=void&trans=<?=$trans?>&security=<?=$sec?>';
window.close();
}

</script>
<?


    if (!$del){

      // Void semua transaksi, data $payments tetap tersimpan
      $sql_query_s="UPDATE pos_total2 SET total='$new_payments', status = 'V' WHERE transcode = '$trans'";
      $result_pos_s = mysql_query($sql_query_s);
	    if (!$result_pos_s) {   error("QUERY_ERROR");   exit; }

      $sql_query="UPDATE pos_detail_backup SET temp='V' WHERE transcode = '$trans'";
      $result_poss = mysql_query($sql_query);
	    if (!$result_poss) {   error("QUERY_ERROR");   exit; }
	    echo("<meta http-equiv='Refresh' content='0; URL=$home/pos_pay_reprint.php?reprint=$trans&void=void'>");

    }else{

          if($del == 1){

              // void one by one, data $payments wajib update
              $sql_query="UPDATE pos_detail_backup SET temp='V' WHERE uid='$pid' AND transcode = '$trans'";
              $result_pos = mysql_query($sql_query);
              if (!$result_pos) {   error("QUERY_ERROR");   exit; }

              // total baris detail
              $query_eud = "SELECT count(uid) FROM pos_detail_backup WHERE sales_code ='$sales_code'
                            AND temp = '9' AND transcode = '$trans'";
              $fetch_eud = mysql_query($query_eud);
              if (!$fetch_eud) { error("QUERY_ERROR"); exit; }
              $eud_detail = @mysql_result($fetch_eud,0,0);

              // detail
              $query_detail = "SELECT uid,detail,datedetail,temp,qty FROM pos_detail_backup
                              WHERE sales_code ='$sales_code' AND temp = '9' AND transcode = '$trans'";
              $fetch_detail = mysql_query($query_detail);
              if (!$fetch_detail) {   error("QUERY_ERROR"); exit; }

              for ($le=0; $le<$eud_detail; $le++) {

                #$pid = @mysql_result($fetch_detail,$le,0);
                $detail = @mysql_result($fetch_detail,$le,1);
                $detail_ex = explode("|", $detail);
                $datedetail = @mysql_result($fetch_detail,$le,2);
                $temp = @mysql_result($fetch_detail,$le,3);
                $qtyp = @mysql_result($fetch_detail,$le,4);

                $itemcode = $detail_ex[0];
                $disc_rate = $detail_ex[4];
                $gross = $detail_ex[5];
                $nett = $detail_ex[6];
                $nettax = $detail_ex[7];
                $vat = $detail_ex[8];

                // SUM
                $total_item1 += $qtyp;
                $total_gross1 += $gross;
                $total_nett1 += $nett;
                $total_nettax1 += $nettax;
                $total_vat1 += $vat;

                $dump_ap[$le] = $itemcode.'|'.$qtyp.'|'.$aaa;

              }

              #$cash_remain1 = $cash_amount - $total_nett1;
              $cash_remain1 = $cash_amount + $credit_amount + $debit_amount - $total_nett1;

              $dump_apdet = implode('|',$dump_ap);
              $payments_apdet = $total_item1.'|'.$total_gross1.'|'.$total_nett1.'|'.$total_nettax1.'|'.$total_vat1.'|'.$cash_amount.'|'.$cash_remain1.'|'.$credit_amount.'|'.$debit_amount.'|'.$krediet_kaart.'|'.$debiet_kaart.'|'.$card_type;

              $sql_querys="UPDATE pos_total2 SET total = '$payments_apdet', dump='$dump_apdet' WHERE sales_code='$sales_code' AND transcode='$trans'";
              $result_p = mysql_query($sql_querys);
              if (!$result_p) {   error("QUERY_ERROR");exit; }

          }/*else if($del == 2){

                // unknown function
                $query_detail = "SELECT uid,qty,price,disc_rate,transaction_code FROM pos_total2 where uid = '$uid'";
                $result_detail = mysql_query($query_detail);
                if (!$result_detail) {   error("QUERY_ERROR");   exit; }

                $uid =  @mysql_result($result_detail,0,0);
                $qtyd =  @mysql_result($result_detail,0,1);
                $price =  @mysql_result($result_detail,0,2);
                $disc =  @mysql_result($result_detail,0,3);
                $disc =  @mysql_result($result_detail,0,3);

                $newgross = $qtym*$price;
                $newdis = $newgross*($disc/100);
                $newnett = $newgross-$newdis;
                $newvat = $newnett/11;
                $newnettvat = $newvat*10;

                $new_detail = $pcode.'|'.$barcode.'|'.$pname.'|'.$price.'|'.$newvat.'|'.$newdis.'|'.$newgross.'|'.$newnett.'|'.$newnettvat.'|'.$newvat;

                $sql_querys="UPDATE pos_total2 SET detail = '$new_detail',qty='$qtym' WHERE uid='$uid'";
                $result_p = mysql_query($sql_querys);
                // var_dump($sql_querys);
                if (!$result_p) {   error("QUERY_ERROR");exit; }
         }

          // Update hasil dari void, lalu update ke pos total
          $query ="SELECT sum(nett) as nett ,sum(gross) as gross,sum(qty) as qty,sum(netvat) as netvat,sum(vat) as vat FROM pos_detail where temp = '9' AND transcode = '$trans'";
          $result = mysql_query($query);
          if (!$result) {   error("QUERY_ERROR");   exit; }
          $nett =  @mysql_result($result,0,0);
          $gross =  @mysql_result($result,0,1);
          $qty =  @mysql_result($result,0,2);
          $netvat =  @mysql_result($result,0,3);
          $vat =  @mysql_result($result,0,4);

		  //GET data from pos_total
			$query_st = "SELECT cash_amount,debit_amount,credit_amount FROM pos_total WHERE transaction_code = '$trans'";
			$result_st = mysql_query($query_st);
			if (!$result_st) {   error("QUERY_ERROR");exit; }
			$cash_amount 	=  @mysql_result($result_st,0,0);
			$debit_amount 	=  @mysql_result($result_st,0,1);
			$credit_amount 	=  @mysql_result($result_st,0,2);
			$remain 		= $cash_amount - $nett;

          $sql_query_u="UPDATE pos_total2 SET total_gross= '$gross',total_nett = '$nett',total_nettax = '$netvat',total_vat = '$vat', total_item = '$qty',cash_remain = '$remain'  WHERE transaction_code = '$trans'";

          $result_pos_u = mysql_query($sql_query_u);
          if (!$result_pos_u) {   error("QUERY_ERROR");   exit; }
*/

      if($del == 1){
        echo '<input type="button" class="btn btn-primary" style=" color:#fff; width:40%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" value="Done" onclick="selectIt()">';
      }else{
         echo("<meta http-equiv='Refresh' content='0; URL=$home/pos_cart_void.php?void=void&trans=$trans&security=$sec>");
      }
    }


}
?>
