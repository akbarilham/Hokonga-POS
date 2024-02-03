	 <div>&nbsp;</div>
	  <div>&nbsp;</div>
	  <table class="table table1" id="delTable">
        <thead class='thead'>
          <tr>
              <th style='text-align:left; width: 120px;'>Nama PT</th>
              <th style='text-align:left; width: 120px;'>Consignee</th>
			        <th style='text-align:left; width: 120px;'>Customer</th>
              <th style='text-align:left; width: 120px;'>PO. No</th>
              <th style='text-align:left; width: 120px;'>SO. Date</th>
              <th style='text-align:left; width: 120px;'>Delivery Date</th>
          </tr>
        </thead>     

<?

if(!$page) { $page = 1; }
$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom
$query_ps  = "SELECT count(uid) FROM wms_so where status = 'DRAFT' ";
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

$query_pos  = "SELECT sales_order,item,so_num,po_num,del_date,wmscode,status 
FROM wms_so WHERE status = 'DRAFT' ORDER BY uid desc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {
    error("QUERY_ERROR");
    exit;
}

$article_num = $total_record - $num_per_page*($page-1);
for($k = $first; $k <= $last; $k++) {
    
    $sales_order      = @mysql_result($result_pos, $k, 0);
    $sales_order_ex   = explode("|", $sales_order);
    $kode           = $sales_order_ex[0];
    $shop           = $sales_order_ex[1];    
    $item             = @mysql_result($result_pos, $k, 1);
    $item_ex          = explode("|", $item);
    $so_num           = @mysql_result($result_pos, $k, 2);
    $po_num           = @mysql_result($result_pos, $k, 3);
    $del_date         = @mysql_result($result_pos, $k, 4);
    $wmscode          = @mysql_result($result_pos, $k, 5);
    $status           = @mysql_result($result_pos, $k, 6);

    $query_mm = "SELECT name FROM member_main WHERE code = '$kode'";
    $fetch_mm  = mysql_query($query_mm);
    if (!$fetch_mm) {  error("QUERY_ERROR");  exit; }
    $name_mm = @mysql_result($fetch_mm,0,0);

    $query_sh = "SELECT shop_name FROM client_shop WHERE shop_code = '$shop'";
    $fetch_sh  = mysql_query($query_sh);
    if (!$fetch_sh) {  error("QUERY_ERROR");  exit; }
    $shop_name = @mysql_result($fetch_sh,0,0);    
?>

          <tr id="<?= $id ?>">
              
              <td style='text-align:left; width: 120px; padding:5px;'><a href="table_report_10AK.php?wmscode=<?=$wmscode?>"><?=$so_num?></a></td>
              <td style='text-align:left; width: 120px; padding:5px;'><?=$name_mm?></td>
              <td style='text-align:left; width: 120px; padding:5px;'><?=$shop_name?></td>
              <td style='text-align:left; width: 120px; padding:5px;'><?=$po_num?></td>
              <td style='text-align:left; width: 120px; padding:5px;'><?=$del_date?></td>
              <td style='text-align:left; width: 120px; padding:5px;'><?=$del_date?></td>
  
            </tr>
        <?

       
}
?>
         
      </table>
	  
      <ul class="pagination pagination-sm pull-right">
        <?
        $k_branch_code = $_GET['keyA'];
        $mode = $_GET['mode'];
        $sh1_shop_code = $_GET['keyD'];

        $total_block = ceil($total_page/$page_per_block);
        $block = ceil($page/$page_per_block);

        $first_page = ($block-1)*$page_per_block;
        $last_page = $block*$page_per_block;

        if($total_block <= $block) {
          $last_page = $total_page;
        }

        if($block > 1) {
          $my_page = $first_page;
          echo("<li><a href=".$PHP_SELF."?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&page=$my_page>Prev $page_per_block</a></li>");
        }


        if ($page > 1) {
          $page_num = $page - 1;
          echo("<li><a href=".$PHP_SELF."?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&page=$page_num>&laquo;</a></li>");
        } else {
          echo("<li><a href='#'>&laquo;</a></li>");
        }

        for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
        if($page == $direct_page) {
          echo("<li class='active'><a href='#'>$direct_page</a></li>");
        } else {
          echo("<li><a href=".$PHP_SELF."?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&page=$direct_page>$direct_page</a></li>");
        }
        }

        if ($IsNext > 0) {
        $page_num = $page + 1;   
          echo("<li><a href=".$PHP_SELF."?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&page=$page_num>&raquo;</a></li>");
        } else { 
          echo("<li><a href='#'>&raquo;</a></li>");
        }

        if($block < $total_block) {
          $my_page = $last_page+1;
          echo("<li><a href=".$home."?keyA=$k_branch_code&keyB=$keyB&mode=$mode&p_year=$yy&p_month=$p_month&p_yearmonth$p_yearmonth&page=$my_page>Next $page_per_block</a>");
        }

        ?>
        </ul>

