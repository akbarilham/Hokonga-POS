<style type="text/css">

table { border-collapse:collapse; }
.table1 { border-bottom: 1px solid #797979; }
.table2 { border-bottom: 1px solid #000; }

th,td { padding:0 4px 0 4px;  }

</style>
<?
$query_SO  = "SELECT so_num,sales_order,po_num,del_date,post_dates FROM wms_so where wmscode = '$wmscode' ";
$fetch_SO  = mysql_query($query_SO);
if (!$fetch_SO) {  error("QUERY_ERROR");  exit; }

$so_num         = @mysql_result($fetch_SO, 0, 0);
$sales_order    = @mysql_result($fetch_SO, 0, 1);
$sales_order_ex = explode("|",$sales_order);
$kode           = $sales_order_ex[0];
$shop           = $sales_order_ex[1];
$total_qty      = $sales_order_ex[3];
$total_amount   = $sales_order_ex[4];
$po_num         = @mysql_result($fetch_SO, 0, 2);
$del_date       = @mysql_result($fetch_SO, 0, 3);
$post_dates     = @mysql_result($fetch_SO, 0, 4);
$new_post_dates = date("Y-m-d", strtotime($post_dates));

$query_mm = "SELECT name FROM member_main WHERE code = '$kode'";
$fetch_mm  = mysql_query($query_mm);
if (!$fetch_mm) {  error("QUERY_ERROR");  exit; }
$name_mm = @mysql_result($fetch_mm,0,0);

$query_sh = "SELECT shop_name FROM client_shop WHERE shop_code = '$shop'";
$fetch_sh  = mysql_query($query_sh);
if (!$fetch_sh) {  error("QUERY_ERROR");  exit; }
$shop_name = @mysql_result($fetch_sh,0,0);
?>
	 <center>
    <div><b><u>SALES ORDER</u></b></div>
    <div><b>[ S/O No: <?=$so_num?>]</b></div>
   </center>
   <div class="row" style="border: 0px solid transparent;">
   <!-- LEFT SIDE -->
    <div style="float:left; border: 10px solid transparent; margin-left:0%; width:40%">
      <table>
        <tr>
          <td><b>Consignee</b></td>
          <td>:</td>
          <td>LOCK & LOCK</td>
        </tr>
        <tr>
          <td><b>Customer</b></td>
          <td>:</td>
          <td><?=$name_mm?></td>        
        </tr>
        <tr>
          <td><b>Destination</b></td>
          <td>:</td>
          <td><?=$shop_name?></td>        
        </tr> 
        <tr>
          <td><b>&nbsp;</b></td>
          <td>&nbsp;</td>
          <td>Jl. Sudirman No.52-58</td>        
        </tr>                
      </table>
    </div>
    <!-- RIGHT SIDE -->
    <div style="clear:right; border: 10px solid transparent; margin-left: 77.8%;">
      <table>
        <tr>
          <td><b>PO No.</b></td>
          <td>:</td>
          <td><?=$po_num?></td>
        </tr>
        <tr>
          <td><b>S/O Date</b></td>
          <td>:</td>
          <td><?=date("d F Y", strtotime($new_post_dates))?></td>        
        </tr>
        <tr>
          <td><b>Delivery Date</b></td>
          <td>:</td>
          <td><?=date("d F Y", strtotime($del_date))?></td>        
        </tr>        
      </table>    
    </div>
   </div>
	  <table class="table table" id="delTable">
        <tr>
            <th style='text-align:left; width: 120px;'>NO</th>
            <th style='text-align:left; width: 120px;'>ITEM</th>
            <th style='text-align:left; width: 120px;'>QTY</th>
		        <th style='text-align:left; width: 120px;'>UNIT</th>
            <th style='text-align:left; width: 120px;'>DESCRIPTION</th>
            <th style='text-align:left; width: 120px;'>REMARK</th>
            <th style='text-align:left; width: 120px;'>PRICE</th>
            <th style='text-align:left; width: 120px;'>AMOUNT</th>
        </tr>    

<?
if(!$page) { $page = 1; }
$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom
$query_ps  = "SELECT count(uid) FROM wms_so where wmscode = '$wmscode' ";
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

$query_pos  = "SELECT item FROM wms_so WHERE wmscode = '$wmscode' ORDER BY sales_order desc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {
    error("QUERY_ERROR");
    exit;
}

for($k = $first; $k <= $last; $k++) {

    $item             = @mysql_result($result_pos, $k, 0);
    $item_ex          = explode("|", $item);
    $total_ex         = count($item_ex);
    $jml_ex           = $total_ex/7;

    for($ki=0;$ki<$jml_ex;$ki++) {
      $names_x          = $ki*7;
      $desc_x           = ($ki*7)+1;
      $qty_x            = ($ki*7)+2;
      $unit_x           = ($ki*7)+3;      
      $remark_x         = ($ki*7)+4;
      $prices_x         = ($ki*7)+5;
      $amount_x         = ($ki*7)+6;
      $kl = $ki+1;
?>

        <tr id="item">
            
            <td style='text-align:left; width: 120px; padding:5px;'><?=$kl?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=$item_ex[$names_x]?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=number_format($item_ex[$qty_x])?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=$item_ex[$unit_x]?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=$item_ex[$desc_x]?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=$item_ex[$remark_x]?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=number_format($item_ex[$prices_x])?></td>
            <td style='text-align:left; width: 120px; padding:5px;'><?=number_format($item_ex[$amount_x])?></td>

        </tr>
  <? } ?>
<? } ?>

        <tr id="total">
            
            <th colspan="2" style='text-align:left; width: 120px; padding:5px;'><center>TOTAL</center></th>
            <th style='text-align:left; width: 120px; padding:5px;'><?=number_format($total_qty)?></th>
            <th colspan="4" style='text-align:left; width: 120px; padding:5px;'>&nbsp;</th>
            <th style='text-align:left; width: 120px; padding:5px;'><?=number_format($total_amount)?></th>

        </tr>
         
    </table>

   <div class="row" style="border: 0px solid gold;">
   <!-- LEFT SIDE -->
    <div style="float:left; border: 0px solid red; margin-left:10%; width:20%">
      <table>
        <tr>
          <td><b>Dibuat,</b></td>
        </tr>
        <tr>
          <td><br/><br/><br/></td>
        </tr>
        <tr>
          <td>(Sales)</td>        
        </tr>        
      </table>
    </div>
    <!-- CENTER SIDE -->
    <div style="float:left; border: 0px solid blue; margin-left: 17%; width:20%">
      <table>
        <tr>
          <td><b>Diperiksa,</b></td>
        </tr>
        <tr>
          <td><br/><br/><br/></td>
        </tr>
        <tr>
          <td>(Ordering)</td>        
        </tr>        
      </table>    
    </div>
    <!-- RIGHT SIDE -->
    <div style="float:right; border: 0px solid green; margin-right: -1%;width:20%">
      <table>
        <tr>
          <td><b>Diterima,</b></td>
        </tr>
        <tr>
          <td><br/><br/><br/></td>
        </tr>
        <tr>
          <td>(Gudang)</td>        
        </tr>        
      </table>    
    </div>
    <!-- END -->
   </div>

<a href="table_report_10A.php" class="btn btn-primary">Back</a>