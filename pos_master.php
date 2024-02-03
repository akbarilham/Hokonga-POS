<?php

	include "config/common.inc";
	if(!$login_id OR $login_id == "" OR $login_level < "1") {
	  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
	} else {
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	include "config/dbconn.inc";
	include "config/text_main_{$lang}.inc";
	include "config/user_functions_{$lang}.inc";

if(!$page) { $page = 1; }
$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = '$login_id'";
$fetch_0509 = mysql_query($query_0509);
$smode_0509_K3 = @mysql_result($fetch_0509,0,2);
$module_0509 = substr($smode_0509_K3,8,1);
				?>
					<html lang="<?=$lang?>">
				  <head>

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

				  </head>
				  <body>
				  	<section id="container" >


			      <!--main content start-->

			          <section class="wrapper" style='margin-top:-1px;'>
					   <section class="panel">
						<?
							//selection
							if(!$search){
										$find = '';
									}else if(!$select){
											$find = "WHERE org_pcode LIKE '%$search%' OR org_barcode LIKE '%$search%' OR pname LIKE '%$search%' order by uid asc";
									}else{
										if($select == 1){
											$find = "WHERE org_pcode like '%$search%' order by uid asc";
											$selected1 = 'selected';
										}else if($select == 2){
											$find = "WHERE org_barcode like '%$search%' order by uid asc";
											$selected2 = 'selected';
										}else if($select == 3){
											$find = "WHERE pname like '%$search%' order by uid asc ";
											$selected3 = 'selected';
										}else{
											$find = '';
										}

									}

							$query_m = "SELECT count(uid) FROM item_masters $find ";
									$result_m = mysql_query($query_m);
									if (!$result_m) {   error("QUERY_ERROR");   exit; }
									$total =  @mysql_result($result_m,0,0);

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

							$query_su = "SELECT uid,org_pcode,org_barcode,pname,price_sale,dc_rate,
							stok_awal,stok,dc_rate_WH,stok_gudang,keterangan FROM item_masters where org_pcode = '$pcode'";
							$result_su = mysql_query($query_su);
							if (!$result_su) {   error("QUERY_ERROR");exit; }
							$uid_su =  @mysql_result($result_su,0,0);
							$pcode_su =  @mysql_result($result_su,0,1);
							$barcode_su =  @mysql_result($result_su,0,2);
							$pname_su =  @mysql_result($result_su,0,3);
							$price_su =  @mysql_result($result_su,0,4);
							$disc_su =  @mysql_result($result_su,0,5);
							$stoka_su =  @mysql_result($result_su,0,6);
							$stok_su =  @mysql_result($result_su,0,7);
							$discwh_su =  @mysql_result($result_su,0,8);
							$stokwh_su =  @mysql_result($result_su,0,9);
							$keterangan =  @mysql_result($result_su,0,10);
							if($edit == 'edit' || $add == 'add'){?>

						 <div class="panel-body progress-panel">
							  <div class="task-progress">
								<?if($edit == 'edit'){?>
									<h1><a href='<?=$home?>/pos_master.php'>MASTER UPDATE ITEM</a></h1>
								<?}else if($add == 'add'){?>
									<h1><a href='<?=$home?>/pos_master.php'>MASTER ADD ITEM</a></h1>
								<?}?>
								<p>
								  <?=$login_id?>
								</p>

							  </div>

						</div>


								<div class="row">
									<div class="col-lg-12 table-responsive" id='header_main' style='border: 0px solid #FFF;'>
									<form name='upitem' id='upitem' action='pos_master.php' enctype="multipart/form-data">
										<table class="table table1">
											<tr>
												<th>No</th>
												<th><input disabled type='text' class='form-control' value='<?if($edit == 'edit'){echo $uid_su;}?>'></th>
											</tr>
											<tr>
												<th>Item Code</th>
												<th><input type='text' name='pcode_u' class='form-control' value='<?if($edit == 'edit'){echo $pcode_su;}?>'></th>
											</tr>
											<tr>
												<th>Barcode</th>
												<th><input type='text' name='barcode_u' class='form-control' value='<?if($edit == 'edit'){echo $barcode_su;}?>'></th>
											</tr>
											<tr>
												<th>Name</th>
												<th><input type='text' name='pname_u' class='form-control' value='<?if($edit == 'edit'){echo $pname_su;}?>'></th>
											</tr>
											<tr>
												<th>Price</th>
												<th><input type='text' name='price_u' pattern="[0-9,]+" class='form-control' value='<?if($edit == 'edit'){echo $price_su;}?>'></th>
											</tr>
											<tr>
												<th>Discount Boomsale</th>
												<th><input type='text' name='disc_u' pattern="[0-9,]+" class='form-control' value='<?if($edit == 'edit'){echo $disc_su;}?>'></th>
											</tr>
											<tr>
												<th>Discount Regular</th>
												<th><input type='text' name='discwh_u' pattern="[0-9,]+" class='form-control' value='<?if($edit == 'edit'){echo $discwh_su;}?>'></th>
											</tr>
											<tr>
												<th>Stock Boomsale</th>
												<th><input type='text' name='stok_u' class='form-control' value='<?if($edit == 'edit'){echo $stoka_su;}?>'></th>
											</tr>
											<tr>
												<th>Stock Warehouse</th>
												<th><input type='text' name='stokho_u' class='form-control' value='<?if($edit == 'edit'){echo $stokwh_su;}?>'></th>
											</tr>
											<tr>
												<th>Keterangan</th>
												<th><input type='text' name='ket' class='form-control' value='<?if($edit == 'edit'){echo $keterangan;}?>'></th>
											</tr>
											<tr>
												<th>Image</th>
												<th><input type="file" name="beeld" accept="image/*"></th>
											</tr>
											<tr >

												<th colspan='2'><input type='submit' class="btn btn-primary" value='SUBMIT'></th>
											</tr>
											<input type='hidden' name='uid_u'  class='form-control' value='<?=$uid_su?>'>
											<input type='hidden' name='but_u' class='form-control' placeholder='Stok' value='<?if($edit == 'edit'){echo 'update';}else{echo 'add';}?>'>
										</table>
										</form>

							<?}
						?>
						</section>



							</div>
								</div>
						 <section class="panel">
						 <?if($trans== 'list'){
								include "pos_lys.inc";

								?>

						  	 <?}else if($trans == 'hold'){
						  	 	include "pos_holdlist.inc";
						  	 	?>

						  	 <?} else if ($trans == 'admin'){
								include "pos_adminlys.inc";
						  	 	?>

						  	  <?}else{?>

							<?php
								$but_u = $_GET['but_u'];

								if($but_u == 'add'){
									$query_add = "INSERT INTO item_masters (uid,org_pcode,org_barcode,pname,price_sale,dc_rate,stok_awal,stok_gudang,dc_rate_WH,keterangan)
									VALUES ('','$pcode_u','$barcode_u','$pname_u','$price_u','$disc_u','$stok_u','$stokho_u','$discwh_u','$ket')";
									$result_add = mysql_query($query_add);
									if (!$result_add) {   error("QUERY_ERROR");exit; }
									echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_master.php?page=$end'>");
								}else if($but_u == 'update'){
									$query_upd = "UPDATE item_masters SET org_pcode = '$pcode_u', org_barcode = '$barcode_u', pname = '$pname_u', price_sale = '$price_u',dc_rate = '$disc_u',stok_awal = '$stok_u', stok_gudang = '$stokho_u', dc_rate_WH = '$discwh_u', keterangan = '$ket' WHERE uid = $uid_u";
									//var_dump($query_upd);die();
									$result_upd = mysql_query($query_upd);
									if (!$result_upd) {   error("QUERY_ERROR");exit; }
									echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_master.php?page=$page'>");
								}
							?>
						 <div class="panel-body progress-panel">
							  <div class="task-progress">
								<h1><a href='<?=$home?>/pos_master.php'>MASTER ITEM</a></h1>
								<p>
								  <?=$login_id?><?php  echo '<a href="'.$home.'/pos.php"  class="fa fa-home" data-toggle="tooltip" title="FIRST"> HOME</a>'; ?>
								</p>
								<? if ($module_0509 == '1') { ?>
								<p>
									<?php  echo '<a href="'.$home.'/pos_admin.php"  class="fa fa-desktop" data-toggle="tooltip" title="FIRST"> MONITORING</a>'; ?>
								</p>
								<? } ?>

							  </div>

						</div>
						<div class="panel-body progress-panel">
						  <div class='col-sm-5'>
							<form name='formsearch' id='formsearch' action='pos_master.php'>
									<div class='col-sm-5'>
										<select name='select' id='select'class='form-control'>
											<option disabled selected>:: Search by ::</option>
											<option value='1' <?=$selected1?>>Item Code</option>
											<option value='2' <?=$selected2?>>Barcode</option>
											<option value='3' <?=$selected3?>>Item Name</option>
										</select>
									</div>
									<div class='col-sm-5'>
										<input type='text' name='search' id='search' class='form-control' placeholder='search' value='<?=$search?>'>
									</div>
									<input type='hidden' name='page'  class='form-control' value='<?=$page?>'>
									<!--<input type='submit' value='submit' class='btn btn-primary'>-->

								</form>
						  </div>
						  <div class='col-sm-5' align='right'>Add item : <a href="<?=$home?>/pos_master.php?add=add&search=<?=$search?>" class='btn btn-primary'>Add</a></div>
						</div>
						 <div class="row">
						  	 <div class="col-lg-12 table-responsive" id='main' style='border: 0px solid #FFF;'>


								<form name='upitem' id='upitem' action='pos_master.php'>
								<table class="table table1"  id="delTable">
									<thead>
										<th>NO</th>
										<th>IMAGE</th>
										<th>ITEM CODE</th>
										<th>BARCODE</th>
										<th>NAME</th>
										<th>QTY</th>
										<th>DISCOUNT</th>
										<th>PRICE</th>
										<th>AFTER DISC</th>

									</thead>
									<?
									$info = pathinfo($_FILES['bleed']['name']);
									$ext = $info['extension']; // get the extension of the file
									$newname = $pcode.$ext;

									$target = 'img_pos/'.$newname;
									move_uploaded_file( $_FILES['bleed']['tmp_name'], $target);



									$query_ms = "SELECT uid,org_pcode,org_barcode,pname,price_sale,
									dc_rate,dc_rate_WH,stok_awal,stok_gudang,stok,csp_after_price FROM item_masters $find ";

									$result_ms = mysql_query($query_ms);
									 if (!$result_ms) {   error("QUERY_ERROR");   exit; }
										$article_num = $total_record - $num_per_page*($page-1);
										for($i = $first; $i <= $last; $i++) {
											$uid =  @mysql_result($result_ms,$i,0);
											$pcode =  @mysql_result($result_ms,$i,1);
											$barcode =  @mysql_result($result_ms,$i,2);
											$pname =  @mysql_result($result_ms,$i,3);
											$price =  @mysql_result($result_ms,$i,4);
											$disc =  @mysql_result($result_ms,$i,5);
											$disc_wh = @mysql_result($result_ms,$i,6);
											$stok_awal =  @mysql_result($result_ms,$i,7);
											$stok_gudang =  @mysql_result($result_ms,$i,8);
											$stok =  @mysql_result($result_ms,$i,9);
											$after_price =  @mysql_result($result_ms,$i,10);

									if ($stok_awal > '0') {
										$qty = $stok_awal-$stok;
									} else if ($stok_awal == '0' AND $stok_gudang > '0') {
										$qty = $stok_gudang-$stok;
									} else if ($stok_awal == '0' AND $stok_gudang == '0') {
										$qty = 0;
									} else {
										$qty = '-'.$stok;
									}

									?>

									<tbody>
										<tr id='<?=$uid?>'>
											<td style='vertical-align:middle;'><?=$uid?></td>
											<?
												$file = 'img_pos/'.$pcode.'.jpg'; // 'images/'.$file (physical path)

												if (file_exists($file)) {
													$gambar = 'img_pos/'.$pcode.'.jpg';
												} else {
													$gambar = 'img_pos/feelbuy.jpg';
												}
											?>
											<td style='vertical-align:middle;'><img id="image" style="width: 100px;height: 100px;margin: auto;top: 0; bottom: 0;left: 0;right: 0;" src="<?=$gambar?>"/></td>
											<td style='vertical-align:middle;'><a href="<?=$home?>/pos_master.php?pcode=<?=$pcode?>&uid=<?=$uid?>&edit=edit&page=<?=$page?>"><?=$pcode?></a></td>
											<td style='vertical-align:middle;'><a href="<?=$home?>/pos_master.php?pcode=<?=$pcode?>&uid=<?=$uid?>&edit=edit&page=<?=$page?>"><?=$barcode?></a></td>
											<td style='vertical-align:middle;'><a href="<?=$home?>/pos_master.php?pcode=<?=$pcode?>&uid=<?=$uid?>&edit=edit&page=<?=$page?>"><?=$pname?></a></td>

											<? if ($stok_awal > '0') { ?>
												<td style='vertical-align:middle;'><a><?=$qty?></a></td>
											<? } else if ($stok_awal == '0' AND $stok_gudang > '0') { ?>
												<td style='vertical-align:middle;'><a style="color:red"><?=$qty?></a></td>
											<? } else if ($stok_awal == '0' AND $stok_gudang == '0') { ?>
												<td style='vertical-align:middle;'><a><?=$qty?></a></td>
											<? } else { ?>
												<td style='vertical-align:middle;'><a><?=$qty?></a></td>
											<? } ?>

											<? if ($stok_awal > '0') { ?>
												<td style='vertical-align:middle;'><a><?=$disc?>%</a></td>
											<? } else if ($stok_awal == '0' AND $stok_gudang > '0') { ?>
												<td style='vertical-align:middle;'><a style="color:red"><?=$disc_wh?>%</a></td>
											<? } else if ($stok_awal == '0' AND $stok_gudang == '0') { ?>
												<td style='vertical-align:middle;'><a><?=$disc?>%</a></td>
											<? } else { ?>
												<td style='vertical-align:middle;'><a><?=$disc?>%</a></td>
											<? } ?>

											<td style='vertical-align:middle;text-align:right;'><a><?=number_format($price)?></a></td>
											<td style='vertical-align:middle;text-align:right;'><a><?=number_format($after_price)?></a></td>
											<!--<td><input type='submit' class="btn btn-primary" value='update'></td>-->
											<input type='hidden' class="btn btn-primary" name="uid" value='<?=$uid?>'>
										</tr>
									</tbody>
									<?}?>
									</table>
									</form>

									 <ul class="pagination pagination-sm pull-right">
										<?
										$total_block = ceil($total_page/$page_per_block);
										$block = ceil($page/$page_per_block);

										$first_page = ($block-1)*$page_per_block;
										$last_page = $block*$page_per_block;

										if(!$page || $page == 1){

										}else{
											echo("<li><a href=".$home."/pos_master.php?page=1&search=$search&end=1>First</a>");
										}

										if($total_block <= $block) {
										  $last_page = $total_page;
										}

										if($block > 1) {
										  $my_page = $first_page;
										  echo("<li><a href=".$home."/pos_master.php?page=$my_page&search=$search&end=$total_page>Prev $page_per_block</a></li>");
										}


										if ($page > 1) {
										  $page_num = $page - 1;
										  echo("<li><a href=".$home."/pos_master.php?page=$page_num&search=$search&end=$total_page>&laquo;</a></li>");
										} else {
										  echo("<li><a href='#'>&laquo;</a></li>");
										}

										for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
										if($page == $direct_page) {
										  echo("<li class='active'><a href='#'>$direct_page</a></li>");
										} else {
										  echo("<li><a href=".$home."/pos_master.php?page=$direct_page&search=$search&end=$total_page>$direct_page</a></li>");
										}
										}

										if ($IsNext > 0) {
										$page_num = $page + 1;
										  echo("<li><a href=".$home."/pos_master.php?page=$page_num&search=$search&end=$total_page>&raquo;</a></li>");
										} else {
										  echo("<li><a href='#'>&raquo;</a></li>");
										}

										if($block < $total_block) {
										  $my_page = $last_page+1;
										  echo("<li><a href=".$home."/pos_master.php?page=$my_page&search=$search&end=$total_page>Next $page_per_block</a>");
										}

										if($total_page == $page ){

										}else{
											echo("<li><a href=".$home."/pos_master.php?page=$total_page&search=$search&end=$total_page>Last</a>");
										}
										?>
										</ul>
									<?}?>


		  					</div>
		  				</div>
		  				</section>
		  			</section>
		  			</section>
		  			</body>
  				</html>

<?
}
?>
