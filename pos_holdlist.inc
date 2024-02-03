<?
/*
Creator : Cihuy Programmer
*/
?>
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
<h1>TRANSACTION HOLD hold</h1>
<p><?= $login_id ?>-<?= $hostname ?></p>
</div>
</div>
      <?php
echo '<a href="' . $home . '/pos.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>';
?>
      <table class="table table1" id="delTable">
         <thead class='thead'>
          <tr>
			<td style='text-align:right; width: 120px;'>CASHIER NAME</td>
              <td style='text-align:right; width: 120px;'>TRANSACTION CODE</td>
              <td style='text-align:right; width: 120px;'>TOTAL ITEM</td>
              <td style='text-align:right; width: 120px;'>TOTAL PRICE</td>
              <td style='text-align:right; width: 120px;'>PPN</td>
              <!--<td style='text-align:right; width: 120px;'>JENIS ITEM</td>-->
              <!--<td style='text-align:right; width: 120px;'>BAYAR</td>-->
			  <td style='text-align:right; width: 120px;'>TAMBAH</td>
			  <!--<td style='text-align:right; width: 120px;'>HAPUS</td>-->
            </tr>
          </thead>

          <?


if ($login_id == 'superadmin') {
    $getdata = "hostname != ''";
} else {
    $getdata = "sales_code = '$login_id'";
}

	$query_getcly = "SELECT id_number,sales_code from pos_client where $getdata";
	$result_getcly = mysql_query($query_getcly);
  if (!$result_getcly) { error("QUERY_ERROR"); exit; }
	$id_number1y   = @mysql_result($result_getcly, 0, 0);
  $sales_code1y   = @mysql_result($result_getcly, 0, 1);

  $query_getsales = "SELECT user_name from admin_user where user_id='$sales_code1y'";
	$result_getsales = mysql_query($query_getsales);
  if (!$result_getsales) { error("QUERY_ERROR"); exit; }
  $sales   = @mysql_result($result_getsales, 0, 0);


if(!$page) { $page = 1; }
$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$query_ps  = "SELECT COUNT(*) AS NEW_TRANSCODE FROM ( SELECT count(transcode) FROM pos_detail2 where temp='1' AND pos_clientID = '$id_number1y' group by transcode having count(transcode) >= 1 ) AS Y";
$result_ps = mysql_query($query_ps);
$total     = @mysql_result($result_ps, 0, 0);

// Display Range of records ------------------------------- //
if(!$total) {
   $first = 1;
   $last = 0;
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total - 1;
   }
}

$total_page = ceil($total/$num_per_page);

$query_pos  =
"SELECT uid,transcode,
substring_index(substring_index(detail,'|',1),'|',-1) AS ITEMCODE,
SUM(substring_index(substring_index(detail,'|',6),'|',-1)) AS GROSS,
SUM(substring_index(substring_index(detail,'|',7),'|',-1)) AS NETT,
SUM(substring_index(substring_index(detail,'|',9),'|',-1)) AS VAT,
SUM(qty) AS QTY
FROM pos_detail2
where pos_clientID = '$id_number1y'
AND temp='1'
group by transcode";

$result_pos = mysql_query($query_pos);
if (!$result_pos) {
    error("QUERY_ERROR");
    exit;
}

for($k = $first; $k <= $last; $k++) {

    $id               = @mysql_result($result_pos, $k, 0);
    $transcode        = @mysql_result($result_pos, $k, 1);
    $org_pcode        = @mysql_result($result_pos, $k, 2);
    $gross            = @mysql_result($result_pos, $k, 3);
    $nett             = @mysql_result($result_pos, $k, 4);
    $vat              = @mysql_result($result_pos, $k, 5);
    $qty              = @mysql_result($result_pos, $k, 6);


    if ($card_type == 9 OR $card_type == 'TK') {
        $credit = $card;
        $debit  = 0;
    } else {
        $debit  = $card;
        $credit = 0;
    }

?>

          <tr id="<?= $id ?>">
			 <td style='text-align:right; width: 120px;'><p id='sales'><?= $sales ?></p></td>
              <td style='text-align:right; width: 120px;'><p id='transaction_code'><?= $transcode ?></p></td>
              <td style='text-align:right; width: 120px;'><?= $qty ?></td>
              <td style='text-align:right; width: 120px;'><?= number_format($nett); ?></td>
              <td style='text-align:right; width: 120px;'><?= number_format($vat) ?></td>
              <!--<td style='text-align:right; width: 120px;'><?= number_format($tot_item); ?></td>-->


              <!--<td style='text-align:right; width: 120px;'>

                 <input type='hidden' id='<?= $id ?>T' value='<?= $transaction_code ?>'>
                <?php echo '<a href="'.$home. '/pos.php?pay='.md5($hostname).'&hold='.$transcode.'" class="btn btn-primary" style=" color:#fff; width:100%;border-color:#81C784;" >BAYAR</a>'; ?>



              </td>-->
			   <td style='text-align:right; width: 120px;'>
				<?php echo '<a href="'.$home. '/pos_holdadd.php?id='.md5($hostname).'&hold='.$transcode.'&stat=update" class="btn btn-primary" style=" color:#fff; width:100%;border-color:#81C784;" >TAMBAH</a>'; ?>

			  </td>
			   <!--<td style='text-align:right; width: 120px;'>
			   <?php echo '<a href="'.$home. '/pos_holdadd.php?hold='.$transcode.'" class="btn btn-primary" style=" color:#fff; width:100%;border-color:#81C784;" >HAPUS</a>'; ?>
              </td>-->

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
          echo("<li><a href=".$home."/pos_master.php?trans=hold&page=$my_page>Prev $page_per_block</a></li>");
        }


        if ($page > 1) {
          $page_num = $page - 1;
          echo("<li><a href=".$home."/pos_master.php?trans=hold&page=$page_num>&laquo;</a></li>");
        } else {
          echo("<li><a href='#'>&laquo;</a></li>");
        }

        for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
        if($page == $direct_page) {
          echo("<li class='active'><a href='#'>$direct_page</a></li>");
        } else {
          echo("<li><a href=".$home."/pos_master.php?trans=hold&page=$direct_page>$direct_page</a></li>");
        }
        }

        if ($IsNext > 0) {
        $page_num = $page + 1;
          echo("<li><a href=".$home."/pos_master.php?trans=hold&page=$page_num>&raquo;</a></li>");
        } else {
          echo("<li><a href='#'>&raquo;</a></li>");
        }

        if($block < $total_block) {
          $my_page = $last_page+1;
          echo("<li><a href=".$home."/pos_master.php?trans=hold&page=$my_page>Next $page_per_block</a>");
        }
        ?>
        </ul>
