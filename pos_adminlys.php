
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
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
	
<div class="panel-body progress-panel">
  <div class="task-progress">
    <h1>TRANSACTION LIST</h1>
    <p><?php echo $login_id ?>-<?php echo $hostname ?></p>
  </div>
</div>

<?php
  $query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = '$login_id'";
  $fetch_0509 = mysql_query($query_0509);
  $smode_0509_K3 = @mysql_result($fetch_0509,0,2);
  $module_0509 = substr($smode_0509_K3,8,1);
?>

<?php if ($module_0509 == '1') { ?>
  <a href="<?php echo $home?>/pos_closing.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>
<?php } else { ?>
  <a href="<?php echo $home?>/pos.php" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>
<?php }  ?>
<?php
  $user = $_GET['user'];
  
  if ($module_0509 == '1') {
    $getdata = "user_id = '$user'";
  } else {
    $getdata = "user_id = '$user'";
  }
?>
<div>&nbsp;</div>
<div>&nbsp;</div>
<?php
  $query_count = "SELECT count(distinct user_id) FROM pos_total WHERE user_id !=  ''";
  $fetch_count = mysql_query($query_count);
  $count_name = mysql_result($fetch_count,0,0);
?>
<div class="task-option" style="float:left">
&nbsp;Filter by&nbsp;&nbsp;&nbsp;
    
<?php
  $query_name_K1 = "SELECT count(DISTINCT user_id) FROM pos_total_closing ORDER BY user_id ASC;";
  $fetch_name_K1 = mysql_query($query_name_K1);
  if (!$fetch_name_K1) {   error("QUERY_ERROR");exit; }
  $cashier_name_K1 = mysql_result($fetch_name_K1,0,0);

  $query_name_K3 = "SELECT DISTINCT user_id FROM pos_total_closing ORDER BY user_id ASC;";
  $fetch_name_K3 = mysql_query($query_name_K3);
  if (!$fetch_name_K3) {   error("QUERY_ERROR");exit; }
  
  echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
  echo("<option value='$PHP_SELF?trans=admin&user=All'>All</option>");

  for($i = 0; $i < $cashier_name_K1; $i++) {
    $cashier_name_K3 = mysql_result($fetch_name_K3,$i,0);
  
    $query_name_J = "SELECT user_name FROM admin_user WHERE user_id = '$cashier_name_K3'";
    $fetch_name_J = mysql_query($query_name_J);
    if (!$fetch_name_J) {   error("QUERY_ERROR");exit; }
    $cashier_name_J = mysql_result($fetch_name_J,0,0);
  
    if($cashier_name_K3 == $user) {
      $slc_gate = "selected";
      $slc_disable = "";
    } else {
      $slc_gate = "";
      $slc_disable = "disabled";
    }
    echo("<option $slc_gate value='$PHP_SELF?trans=admin&user=$cashier_name_K3'>$cashier_name_J</option>");
  }
  echo("</select>");

  if ($user == 'All') {
    $getdata = "1";
  }
?>    
</div>    

<table class="table table1" id="delTable">
  <thead class='thead'>
    <tr>
      <th style='text-align:left; width: 120px;'>Transaksi</th>
      <th style='text-align:left; width: 120px;'>Tanggal</th>
      <th style='text-align:left; width: 120px;'>Cashier</th>
      <th style='width: 50px;text-align:right; '>Item</th>
    <th style='text-align:right; width: 120px;'>Total Gross</th>
      <th style='text-align:right; width: 120px;'>Total Nett</th>
      <!--<td style='text-align:right; width: 120px;'>PPN</th>-->
      <th style='text-align:right; width: 120px;'>Tunai</th>
      <th style='text-align:right; width: 120px;'>K.Debit</th>
      <th style='text-align:right; width: 120px;'>K.Kredit</th>
      <th style='text-align:right; width: 120px;'>Kembali</th>
    </tr>
  </thead>     
<?php
  if(!$page) { $page = 1; }
  $num_per_page = 10; // number of article lines per page
  $page_per_block = 10; // number of pages displayed in the bottom
  $query_ps  = "SELECT count(id) FROM pos_total_closing where $getdata AND closing = '1' AND status = 'P'";
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
  $query_pos  = "SELECT id,transaction_code,total_item,total_nett,total_vat,cash_amount,credit_amount,cash_remain,status,card_type,debit_amount,total_gross,user_id,trx_date FROM pos_total_closing where $getdata AND closing = '1' AND status = 'P' ORDER BY transaction_code desc";
  $result_pos = mysql_query($query_pos);
  if (!$result_pos) {
      error("QUERY_ERROR");
      exit;
  }

  $article_num = $total_record - $num_per_page*($page-1);
  for($k = $first; $k <= $last; $k++) {
    $id               = @mysql_result($result_pos, $k, 0);
    $transaction_code = @mysql_result($result_pos, $k, 1);
    $total_item       = @mysql_result($result_pos, $k, 2);
    $total_nett       = @mysql_result($result_pos, $k, 3);
    $total_vat        = @mysql_result($result_pos, $k, 4);
    $cash             = @mysql_result($result_pos, $k, 5);
    $credit_amount    = @mysql_result($result_pos, $k, 6);
    $change           = @mysql_result($result_pos, $k, 7);
    $status           = @mysql_result($result_pos, $k, 8);
    $card_type        = @mysql_result($result_pos, $k, 9);
    $debit_amount     = @mysql_result($result_pos, $k, 10);
    $total_gross      = @mysql_result($result_pos, $k, 11);
    $user_id          = @mysql_result($result_pos, $k, 12);
    $trx_date         = @mysql_result($result_pos, $k, 13);
    $query_name_T = "SELECT user_name FROM admin_user WHERE user_id = '$user_id';";
    $fetch_name_T = mysql_query($query_name_T);
    if (!$fetch_name_T) {   error("QUERY_ERROR");exit; }
    $cashier_name_T = mysql_result($fetch_name_T,0,0);    
?>

    <tr id="<?php echo $id ?>">          
      <td style='text-align:left; width: 120px; padding:5px;'><p id='transaction_code'><?= $transaction_code ?></p></td>
      <td style='text-align:left; width: 120px; padding:5px;'><?php echo date("d-m-Y H:i", strtotime($trx_date)) ?></td>
      <td style='text-align:left; width: 120px; padding:5px;'><?php echo $cashier_name_T ?></td>
      <td style='width: 50px;text-align:right; padding:5px;'><?php echo $total_item ?></td>
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($total_gross); ?></td>
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($total_nett); ?></td>
      <!-- <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($total_vat) ?></td>-->
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($cash); ?></td>
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($debit_amount) ?></td>
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($credit_amount) ?></td>
      <td style='text-align:right; width: 120px;padding:5px;'><?php echo number_format($change); ?></td>
    </tr>
    <?php } ?>
         
  </table>  
<ul class="pagination pagination-sm pull-right">
<?php
  $total_block = ceil($total_page/$page_per_block);
  $block = ceil($page/$page_per_block);
  $first_page = ($block-1)*$page_per_block;
  $last_page = $block*$page_per_block;

  if($total_block <= $block) {
    $last_page = $total_page;
  }

  if($block > 1) {
    $my_page = $first_page;
    echo("<li><a href=".$home."/pos_master.php?trans=admin&page=$my_page&user=$user>Prev $page_per_block</a></li>");
  }


  if ($page > 1) {
    $page_num = $page - 1;
    echo("<li><a href=".$home."/pos_master.php?trans=admin&page=$page_num>&laquo;</a></li>");
  } else {
    echo("<li><a href='#'>&laquo;</a></li>");
  }

  for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
  if($page == $direct_page) {
    echo("<li class='active'><a href='#'>$direct_page</a></li>");
  } else {
    echo("<li><a href=".$home."/pos_master.php?trans=admin&&page=$direct_page&user=$user>$direct_page</a></li>");
  }
  }

  if ($IsNext > 0) {
  $page_num = $page + 1;   
    echo("<li><a href=".$home."/pos_master.php?trans=admin&page=$page_num&user=$user>&raquo;</a></li>");
  } else { 
    echo("<li><a href='#'>&raquo;</a></li>");
  }

  if($block < $total_block) {
    $my_page = $last_page+1;
    echo("<li><a href=".$home."/pos_master.php?trans=admin&page=$my_page&user=$user>Next $page_per_block</a>");
  }
?>
</ul>