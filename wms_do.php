<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "shop_code";

$num_per_page = 10; // uidber of article lines per page
$page_per_block = 10; // uidber of pages displayed in the bottom


$keyfield = $_GET['keyfield'];
$key = $_GET['key'];

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
    <link href="assets/font-awedome/css/font-awedome.css" rel="stylesheet" />
    <link href="css/table-responsive.css" rel="stylesheet" />
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/redources/demos/style.css">
	<script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">

<?
$date 	= date('Ymd');
$year 	= date('Y');
$month 	= date('m');
$day 	= date('d');
$newdate	= $month.'/'.$day.'/'.$year;


//===================== new page code ======================
//Yogi Anditia
if(!$page) { 
  if(isset($_GET['page'])){
    $page = intval($_GET['page']); //get value from url
    if(intval($_GET['page'])==null){
      $page = 1;
    }else{
      $page = intval($_GET['page']); 
    }
  }else{
    $page = 1;
  }
}
//===========================================================



// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
   $query = "SELECT count(uid) FROM wms_do ";
} else {
   $encoded_key = urlencode($key);
   $query = "SELECT count(uid) FROM wms_do WHERE $keyfield LIKE '%$key%' ";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


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
?>
    

						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading">
                Delivery Order
          
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
			<a href="wms_do.php" class='btn btn-primary' VALUE ="NEW">NEW</a>
			<button type="button" class='btn btn-primary'>VALID</button>
			<button type="button" class='btn btn-primary save'>SAVE</button>
			<button type="button" class='btn btn-primary'>CANCEL</button>
			<button type="button" class='btn btn-primary'>PRINT</button>
			<br>
			<br>
			<?
				$query_dodata	="SELECT uid,delivery_order,item,do_num,so_num,del_date,status,post_dates FROM wms_do WHERE wmscode = '$wmcode'";
				$fetch_dodata 	= mysql_query($query_dodata);
				if (!$fetch_dodata) { error("QUERY_ERROR"); exit; }
				$uid				= mysql_result($fetch_dodata,0,0);
				$delivery_order		= mysql_result($fetch_dodata,0,1);
				$item				= mysql_result($fetch_dodata,0,2);
				$do_num				= mysql_result($fetch_dodata,0,3);
				$so_num				= mysql_result($fetch_dodata,0,4);
				$del_date			= mysql_result($fetch_dodata,0,5);
				$stats				= mysql_result($fetch_dodata,0,6);
				$post_date			= mysql_result($fetch_dodata,0,7);
				
				
				
				
				$exdelivery_order		= explode('|',$delivery_order);
				$arrdelivery_order 	= count($exdelivery_order);
				for($y=0;$y<$arrdelivery_order;$y++){
					 $exdelivery_order[$y];
				}
				
				if(!$wmdocode){
					$stat 	= "DRAFT";
					
				}else {
					$stat = $stats;
				
				}
				
			?>
			<form name="form" id="form" action='wms_post_do.php' method='post' onsubmit="return validateForm()" enctype="multipart/form-data">
              <table class="table table-hover perdonal-task">
                <tr>
                    <td>NO DO</td>
                    <td><input readonly type='text' class='form-control' name='do_no' value='<?=$do_num?>'></td>
                    <td>TANGGAL</td>
                    <td><input readonly type='text' class='form-control' name='date' data-date="" data-date-format="DD MMMM YYYY" value="<?=$newdate?>"></td>
                    <td>USER</td>
                    <td><input readonly type='text' class='form-control' name='user' value="<?=$login_id?>"></td>
                </tr>
                <tr>
                    <td>NO SO</td>
                    <td>
						<?
						echo("<select name='so' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
				echo("<option value='$PHP_SELF?trans=admin&user=All'>All</option>");

				
				$query_branchcount 	= "SELECT count(uid) FROM wms_so ";
							$fetch_branchcount 	= mysql_query($query_branchcount);
							if (!$fetch_branchcount) { error("QUERY_ERROR"); exit; }
							$branchcount		= mysql_result($fetch_branchcount,0,0);

							$query_branch 		= "SELECT so_num,substring_index(substring_index(sales_order,'|',1),'|',-1),wmscode FROM wms_so ";
							$fetch_branch		= mysql_query($query_branch);
							if (!$fetch_branch) { error("QUERY_ERROR"); exit; }

							for ($k=0;$k<$branchcount;$k++) { 
							$so   	=mysql_result($fetch_branch,$k,0);
							$code  	=mysql_result($fetch_branch,$k,1);
							$wcode 	=mysql_result($fetch_branch,$k,2);
						
								
								if($mcode == $code) {
									$slct = "selected";
								} else {
									$slct = "";
								}
							
								echo("<option $slct value='$PHP_SELF?mcode=$code&so=$so&wmcode=$wcode'>$so</option>");
							}
				
				echo("</select>");
						
					?>
												
					</td>
                    <td>TANGGAL DO</td>
                    <td><input type='date' class='form-control' id='datepicker' name='do_date' value='<?=$del_date?>'></td>
                    <td>STATUS</td>
                    <td><input readonly type='text' class='form-control' name='stat' value="<?=$stat?>"></td>
                </tr>
                <tr>
                    <td>NAMA PT</td>
                    <td>
						<select name='company' id='company' class='form-control'>
						<option selected>:: <?=$txt_comm_frm19?> ::</option>
						<?
							$query_branchcount 	= "SELECT count(uid) FROM member_main ";
							$fetch_branchcount 	= mysql_query($query_branchcount);
							if (!$fetch_branchcount) { error("QUERY_ERROR"); exit; }
							$branchcount		= mysql_result($fetch_branchcount,0,0);

							$query_branch 		= "SELECT uid,code,name,addr1,addr2 FROM member_main ";
							$fetch_branch		= mysql_query($query_branch);
							if (!$fetch_branch) { error("QUERY_ERROR"); exit; }

							for ($k=0;$k<$branchcount;$k++) { 
							$fuid   =mysql_result($fetch_branch,$k,0);
							$fcode  =mysql_result($fetch_branch,$k,1);
							$fname  =mysql_result($fetch_branch,$k,2);
							$addr1	=mysql_result($fetch_branch,$k,3);
							$addr2	=mysql_result($fetch_branch,$k,4);
						
								
								if($exdelivery_order[0] == $fcode ||$mcode == $fcode) {
									$slct = "selected";
								} else {
									$slct = "";
								}
								echo("<option value='$fcode' $slct>$fname</option>");
							}
						?>

						</select>
					</td>
                    <td>NAMA TOKO </td>
                    <td>
						
						<select name='shop' id='shop' class='form-control'>
                            <option selected>:: <?=$txt_comm_frm19?> ::</option>
                        </select>
					</td>
                   
                </tr>
                <tr>
                    <td>ALAMAT PT</td>
                    <td><textarea type='text' class='form-control' name='addr_pt' value='<?=$addr2?>'>  </textarea></td>
                    <td>ALAMAT TOKO</td>
                    <td><textarea type='text' class='form-control' name='addr_shop'><?=$addr_shop?></textarea></td>
                    
                </tr>
				<tr>
					 <td>KETERANGAN</td>
                    <td><textarea type='text' class='form-control' name='desc'><?=$exdelivery_order[2]?></textarea></td>
				</tr>
              </table>

                <script src="js/jquery-1.10.2-pos.js"></script>
                    <script src="js/jquery-ui-pos.js"></script>
                    <script src='http://demo.smarttutorials.net/auto_table/jquery-1.9.1.min.js'></script>
                 <script>
                 $(document).ready(function() {
                        $(".delete").on('click', function() {
                          $('.case:checkbox:checked').parents("tr").remove();
                            $('.check_all').prop("checked", false); 
                          check();

                        });
						 var j = $('#no').val();
                        var i=j;

                        $(".addmore").on('click',function(){
                          count=$('.table-list tr').length;
                            var data="<tr><td><input  type='checkbox' class='case form-control'/></td>";
                            data +="<td><span id='snum"+i+"'>"+count+".</span></td>";
							data +="<td><input type='text' class='form-control' id='item_name"+i+"' name='item_name["+i+"]'/></td>";
							data +="<td><input type='text' class='form-control' id='description"+i+"' name='description["+i+"]'/></td>";
							data +="<td><input type='text' class='form-control' id='qty"+i+"' name='qty["+i+"]'/></td>";
							data +="<td><input type='text' class='form-control' id='unit"+i+"' name='unit["+i+"]'/> </td>";
							data +="<td><input type='text' class='form-control' id='remark"+i+"' name='remark["+i+"]'/></td></tr>";
							
                          $('.table-list').append(data);
                          i++;
                        });
                  
                   });

                        function select_all() {
                          $('input[class=case]:checkbox').each(function(){ 
                            if($('input[class=check_all]:checkbox:checked').length == 0){ 
                              $(this).prop("checked", false); 
                            } else {
                              $(this).prop("checked", true); 
                            } 
                          });
                        }

                        function check(){
                          obj=$('.table-list tr').find('span');
                          $.each( obj, function( key, value ) {
                          id=value.id;
                          $('#'+id).html(key+1);
                          });
                          }
					
					
					        $(document).ready(function(){
								$('#company').on('change',function(){
									var comID = $(this).val();
									if(comID){
										$.ajax({
											type:'POST',
											url:'wms_getcompany.php',
											data:'com='+comID,
											success:function(html){
												$('#shop').html(html);
											}
										}); 
									}else{
										$('#shop').html('<option value="">Select Company first</option>');
									}
								});
								
							});
							
							 $('.save').click(function(event) {
									validateForm();
							  });
							
							function validateForm() {
								this.form.submit();
								return false;
							}
					
                        </script>
                    
              <table class="table table-bordered table-striped table-condensed table-list">
                <thead>
                <tr>
                    <th>DEL</th>
                    <th>NO</th>
                    <th>ITEM</th>
                    <th>DESCRIPTION</th>
                    <th>QTY</th>
                    <th>UNIT</th>
                    <th>REMARK</th>            
                </tr>
                </thead>
				
                <tbody>
					<?
					
					$query_wmsget  = "SELECT item FROM wms_so WHERE wmscode = '$wmcode' ";
					$result_wmsget = mysql_query($query_wmsget);
					if (!$result_wmsget) {
						error("QUERY_ERROR");
						exit;
					}
						    $items            = @mysql_result($result_wmsget, 0, 0);
							$item_ex          = explode("|", $items);
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

						$kl = $jml_ex+1;
						
				?>
                    <tr>
                        <td><input type='checkbox' class='case form-control'/></td>
                        <td><span id='snum'><?php echo (1+$ki);?></span></td>
						 <input type='hidden' class='form-control' id='no' name='no' value='<?=($kl)?>'/>
                        <td><input type='text' class='form-control' id='item_name' name='item_name[<?php echo (1+$ki)?>]' value='<?=$item_ex[$names_x]?>'/></td>
                        <td><input type='text' class='form-control' id='description' name='description[<?php echo (1+$ki)?>]' value='<?=$item_ex[$desc_x]?>'/></td>
                        <td><input type='text' class='form-control' id='qty' name='qty[<?php echo (1+$ki)?>]' value='<?=$item_ex[$qty_x]?>'/></td>
                        <td><input type='text' class='form-control' id='unit' name='unit[<?php echo (1+$ki)?>]' value='<?=$item_ex[$unit_x]?>'/> </td>
                        <td><input type='text' class='form-control' id='remark' name='remark[<?php echo (1+$ki)?>]' value='<?=$item_ex[$remark_x]?>'/></td>
                       
                      </tr>
					<?}?>
                </tbody>
                <input type='hidden' class='form-control' id='bind' name='bind' value='bind'/>
				<input type='hidden' class='form-control' id='wmcode' name='wmcode' value='<?=$wmcode?>'/>
              </table>
			  </form>
              <button type="button" class='delete'>- Delete</button>
              <button type="button" class='addmore'>+ Add More</button>
            </div>
			
			
        </section>
        </div>
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Delivery Order List
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
       
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>NO do</th>
            <th>TANGGAL</th>
            <th>NAMA PT</th>
            <th>NAMA TOKO</th>      
            <th>KETERANGAN</th>
            <th>QTY</th>
            <th>STATUS</th>
            <th>CETAK</th>
        </tr>
		
        </thead>
		
		 <?

			$query_getdodata 	= "SELECT delivery_order,item,do_num,so_num,del_date,wmscode,status FROM wms_do";
			$fetch_getdodata	= mysql_query($query_getdodata); 
		?>
		
        <tbody>
		<?
		$time_limit = 60*60*24*$notify_new_article; 

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_uid = $total_record - $num_per_page*($page-1);


for($i = $first; $i <= $last; $i++) {

			$do					= mysql_result($fetch_getdodata,$i,0);
			$item				= mysql_result($fetch_getdodata,$i,1);
			$do_num				= mysql_result($fetch_getdodata,$i,2);
			$so_num				= mysql_result($fetch_getdodata,$i,3);
			$date				= mysql_result($fetch_getdodata,$i,4);
			$wms_code			= mysql_result($fetch_getdodata,$i,5);
			$status				= mysql_result($fetch_getdodata,$i,6);

  
  // 검색어 폰트색깔 지정
  if(!strcmp($key,"$gudang_name") && $key) {
    $gudang_name = eregi_replace("($key)", "<font color=navy>\\1</font>", $gudang_name);
  }
  if(!strcmp($key,"$gudang_code") && $key) {
    $gudang_code = eregi_replace("($key)", "<font color=navy>\\1</font>", $gudang_code);
  }
	
	
		
		echo "<tr>";
			echo "<td>".$do_num."</td>";
			echo "<td>".$date."</td>";
			$exdo	= explode('|',$do);
			$arrdo 	= count($exdo);
			for($x=0;$x<$arrdo;$x++){
				echo "<td>".$exdo[$x]."</td>";
			}
			echo "<td><a href='$home/wms_do.php?page=$page&wmcode=$wms_code'> ".$status."</a></td>";
			echo "<td></td>";

		echo "</tr>";


 
}

?>
		
        </tbody>
        </table>
		</section>
		
		
			
				
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
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_uid = $page - 1;
					echo("<li><a href=\"$link_list?page=$page_uid&keyfield=$keyfield&key=$encoded_key\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?page=$direct_page&keyfield=$keyfield&key=$encoded_key\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_uid = $page + 1;   
					echo("<li><a href=\"$link_list?page=$page_uid&keyfield=$keyfield&key=$encoded_key\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?page=$my_page&keyfield=$keyfield&key=$encoded_key\">Next $page_per_block</a>");
				}
				?>
				</ul>
			
				
			</div>
			</div>
			
        </div>
		
        </section>
		</div>
		</div>
		</div>
						

						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	<? include "footer.inc"; ?>

</section>


	<!-- js placed at the end of the document do the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>

</html>

<? } ?>