
<script type="text/javascript">
      /*$(document).ready(function()
    {
      $('table#delTable td a.delete').click(function()
      {
        if (answer=confirm("Are you sure you want to VOID this TRANSACTION?"))
        {

          if (answer==true) {
            var id = $(this).parent().parent().attr('id');
            var value = $('#'+id+'T').val();
            var voi = id+'&void=v&trans='+value;
                  window.open($('#link').attr("href")+voi,"popupWindow","width=400,height=400");
              window.close();
          }
          var id = $(this).parent().parent().attr('id');

          var data = 'id=' + id ;
          var parent = $(this).parent().parent();

          $.ajax(
          {
               type: "GET",
               url: "pos_void.php",
               data: data,
               cache: false,

               success: function(data)
               {
               $('a#'+id+'k').replaceWith('<a>CLOSE<a>');

               }
           });

        }
      });

      // style the table with alternate colors
      // sets specified color for every odd row
      $('table#delTable tr:odd').css('background',' #FFFFFF');
    });*/
</script>

<div class="panel-body progress-panel">
<div class="task-progress">
<h1>TRANSACTION LIST</h1>
<p><?= $login_id ?>-<?= $hostname ?></p>
</div>
</div>

<?
$query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = '$login_id'";
$fetch_0509 = mysql_query($query_0509);
$smode_0509_K3 = @mysql_result($fetch_0509,0,2);
$module_0509 = substr($smode_0509_K3,8,1);

$query_kassier = "SELECT id_number,no from pos_client where hostname = '$hostname'";
$fetch_kassier = mysql_query($query_kassier);
if (!$fetch_kassier) { error("QUERY_ERROR"); exit; }
$pos_client_id = mysql_result($fetch_kassier,0,0);
$kassier_aantal = mysql_result($fetch_kassier,0,1);
?>

<?/* if ($module_0509 == '1') { ?>
<a href="<?=$home?>/pos.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>
<a href="<?=$home?>/pos_cashier_report_print.php" class="btn btn-primary" style=" color:#fff; width:20%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;">CLOSING</a>
<? } else { */?>
<a href="<?=$home?>/pos.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>
<a href="<?=$home?>/pos_cashier_report_print.php?kasir=<?=$login_id?>" class="btn btn-primary" style=" color:#fff; width:20%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;">CLOSING</a>
<?# }  ?>
	  <?
			if ($module_0509 == '1') {
				$getdata = "closing = '0'";
			} else {
				$getdata = "sales_code = '$login_id' AND closing = '0'";
			}
			/*
			$query_total  = "SELECT count(transaction_code),sum(total_item),sum(total_nett),sum(total_vat),sum(cash_amount),sum(credit_amount),sum(cash_remain),sum(debit_amount),sum(total_vat),sum(total_gross) from pos_total WHERE $getdata";
			$result_total = mysql_query($query_total);
			if (!$result_total) {
				error("QUERY_ERROR");
				exit;
			}
			$total_transaksi  = @mysql_result($result_total, 0, 0);
			$count_item		  = @mysql_result($result_total, 0, 1);
			$count_nett       = @mysql_result($result_total, 0, 2);
			$count_vat        = @mysql_result($result_total, 0, 3);
			$count_cash       = @mysql_result($result_total, 0, 4);
			$count_creamo     = @mysql_result($result_total, 0, 5);
			$count_change     = @mysql_result($result_total, 0, 6);
			$count_debamo     = @mysql_result($result_total, 0, 7);
			$count_ppn     	  = @mysql_result($result_total, 0, 8);
			$count_gross   	  = @mysql_result($result_total, 0, 9);
      */

	  ?>
	 <div>&nbsp;</div>
	  <div>&nbsp;</div>
	  <table class="table table1" id="delTable">
         <thead class='thead'>
          <tr>
              <th style='text-align:left; width: 120px;'>Transaksi</th>
              <th style='text-align:right; width: 120px;'>VOID</th>
			  <th style='text-align:right; width: 120px;'>PRINT</th>
            </tr>
          </thead>

          <?


if(!$page) { $page = 1; }
$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom
$query_ps  = "SELECT count(uid) FROM pos_total2 where $getdata ";
$result_ps = mysql_query($query_ps);
$total_record     = @mysql_result($result_ps, 0, 0);

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

$query_pos  = "SELECT transaction_code,trx_date,total,transcode,status
FROM pos_total2 where $getdata ORDER BY transaction_code desc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {
    error("QUERY_ERROR");
    exit;
}

$article_num = $total_record - $num_per_page*($page-1);
for($k = $first; $k <= $last; $k++) {

    $transaction_code = @mysql_result($result_pos, $k, 0);
    $trx_date         = @mysql_result($result_pos, $k, 1);
    $payments         = @mysql_result($result_pos, $k, 2);
    $payments_ex = explode("|", $payments);
    $transcode        = @mysql_result($result_pos, $k, 3);
    $status           = @mysql_result($result_pos, $k, 4);
?>

          <tr id="<?= $id ?>">

              <td style='text-align:left; width: 120px; padding:5px;'><p id='transaction_code'><?echo 'ES'.$kassier_aantal.'-'.substr($transaction_code,4) ?></p></td>

              <td style="width:10px;text-align:right;padding:5px;" >
                <?if ($status == 'V') {?>
                  <a>CLOSE<a>
                <?} else {?>
					<!--  <input type='hidden' id='<?= $id ?>T' value='<?= $transaction_code ?>'> -->
                <a  href="<?php echo $home . '/pos_security.php?uid=' . $id . '&trans=' . $transcode . '&void=void';?>"  class="delete fa fa-times-circle fa-1x" style="color:#FF0000;">VOID</a>

                <?}?>
              </td>
              <td style='text-align:right;padding:5px;'>
				<?if ($status == 'V') {?>
					<a>CLOSE<a>
                <?} else {?>
					<a href="pos_pay_reprint.php?reprint=<?= $transcode ?>">REPRINT<a>
				<?}?>
              </td>

            </tr>
        <?


}
?>

      </table>

      <ul class="pagination pagination-sm pull-right">
        <?
        $total_block = ceil($total_page/$page_per_block);
        $block = ceil($page/$page_per_block);

        $first_page = ($block-1)*$page_per_block;
        $last_page = $block*$page_per_block;

        if($total_block <= $block) {
          $last_page = $total_page;
        }

        if($block > 1) {
          $my_page = $first_page;
          echo("<li><a href=".$home."/pos_master.php?trans=list&page=$my_page>Prev $page_per_block</a></li>");
        }


        if ($page > 1) {
          $page_num = $page - 1;
          echo("<li><a href=".$home."/pos_master.php?trans=list&page=$page_num>&laquo;</a></li>");
        } else {
          echo("<li><a href='#'>&laquo;</a></li>");
        }

        for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
        if($page == $direct_page) {
          echo("<li class='active'><a href='#'>$direct_page</a></li>");
        } else {
          echo("<li><a href=".$home."/pos_master.php?trans=list&page=$direct_page>$direct_page</a></li>");
        }
        }

        if ($IsNext > 0) {
        $page_num = $page + 1;
          echo("<li><a href=".$home."/pos_master.php?trans=list&page=$page_num>&raquo;</a></li>");
        } else {
          echo("<li><a href='#'>&raquo;</a></li>");
        }

        if($block < $total_block) {
          $my_page = $last_page+1;
          echo("<li><a href=".$home."/pos_master.php?trans=list&page=$my_page>Next $page_per_block</a>");
        }

        ?>
        </ul>
