<?php

	include "config/common.inc";
	if(!$login_id OR $login_id == "" OR $login_level < "1") {
	  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
	} else {
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	include "config/dbconn.inc";
	include "config/text_main_{$lang}.inc";
	include "config/user_functions_{$lang}.inc";
	$trans = $_GET['trans'];

	$security = $_GET['security'];
	#$lostmode = substr($hostname, 0,2)."".substr($login_id,0,3);
	$lostmode = 'BS1718';

	if($security == $lostmode){
	    $id = $_GET['id'];
	    $qtym = $_GET['val'];
	}else{
	    echo ("<meta http-equiv='Refresh' content='0; URL=$home/pos_security.php?trans=$trans&void=void'>");
	}

	// Kassier Aantal
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$query_kassier = "SELECT no from pos_client where hostname = '$hostname'";
	$fetch_kassier = mysql_query($query_kassier);
	if (!$fetch_kassier) { error("QUERY_ERROR"); exit; }
	$kassier_aantal = mysql_result($fetch_kassier,0,0);

?>
<html lang="<?php echo $lang?>">
	<head>
		<title><?php echo $web_erp_name?></title>
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
	<link rel="stylesheet" href="css/jquery-ui-pos.css">
  <script src="js/jquery-1.10.2-pos.js"></script>
  <script src="js/jquery-ui-pos.js"></script>
  <script type="text/javascript">
	$(document).ready(function()
		{
			$('table#delTable td a.delete').click(function()
			{
					if (answer=confirm("Are you sure you want to delete this item?"))
					{
						if (answer==true) {
						var id = $(this).parent().parent().attr('id');
						var del = id+'&del=1';

						var tdPid = document.getElementById('pid'+id).value;
						var pid = '&pid='+tdPid;
						//var del = 'pos_security.php?uid='+id+'&del=1';
					      	window.open($('#link').attr("href")+del+pid,"popupWindow","width=400,height=400");
							window.close();
					     }
					}
			});

			// style the table with alternate colors
			// sets specified color for every odd row
			$('table#delTable tr:odd').css('background',' #FFFFFF');
		});

		$(document).ready(function() {
			$('.submit_on_enter_edit').keydown(function(event) {
				if (event.keyCode == 13) {
					if (confirm("Yakin?"))
					{

						var id = $(this).parent().parent().attr('id');
						var value = $('#'+id+'i').val();
						if (!value)
						value = '0';
						var bind = $('#'+id+'b').val();
						if (!bind)
						bind = '0';
						var data = '?uid=' + id +'&val='+value+'&del=2&trans=<?php echo $trans?>&secuity=<?php echo $security?>' ;
						var minus = id+'&val='+value;
						/*var totval = parseFloat(value);
						var bindval = parseFloat(bind);
						if(totval < bindval){
							window.open($('#link').attr("href")+minus,"popupWindow","width=400,height=400");
							window.close();
						}else{*/
						$.ajax(
						{
								type: "GET",
								url: "pos_edit_void.php"+data,
								data: {qty:'qty',gross:'gross'},
								cache: false,

								success: function(data)

								{
									var qty = '';
									var gross = '';
									var nett = '';

									var obj = $.parseJSON(data);
									$.each(obj, function() {
										qty += this['qty'];
										gross += this['gross'];
										nett += this['nett'];
									});

									$('#'+id+'i').val(qty);
									$('#'+id+'j').text(gross);
									$('#'+id+'k').text(nett);

								}

							});

						// }
						location.reload();
					}
				}
			});
		});
	</script>
<script>
function confirmVoidAll(delUrl) {
  if (confirm("Are you sure you want to Void this Transaction")) {
   document.location = delUrl;
  }
}
</script>
<script type="text/javascript">
window.history.forward();
window.onload = function()
{
  window.history.forward();
};

window.onunload = function() {
  null;
};
</script>
	</head>
		<body>
			<section id="container" >
			    <!--main content start-->
				<section class="wrapper" style='margin-top:-1px;'>
			        <section class="panel">
			          	<div class="row">
							<div class="col-lg-12 table-responsive" id='header_main' style='border: 0px solid #FFF;'>
							<?php
								$query_s 	= "SELECT total,dump,sales_code FROM pos_total2 where transcode = '$trans'";
								$fetch 		= mysql_query($query_s);
								$detail 	= mysql_result($fetch,0,0);
								$dump 		= mysql_result($fetch,0,1);
								$sales_code = mysql_result($fetch,0,2);

								$detail_ex 	= explode("|", $detail);
								$dump_ex 	= explode("|", $dump);
								$price 		= $detail_ex[2];
								$gross 		= $detail_ex[1];
								$qty 		= $detail_ex[0];
								$dic 		= $gross-$price;

								$query_name = "SELECT name FROM member_staff where id = '$sales_code'";
								$fetch_name = mysql_query($query_name);
								$name 		= mysql_result($fetch_name,0,0);
								$s_name 	= explode(' ',$name);

								$query_tc 			= "SELECT transaction_code FROM pos_total2 where transcode = '$trans'";
								$fetch_tc 			= mysql_query($query_tc);
								$transaction_code 	= mysql_result($fetch_tc,0,0);
								$void 				= $home.'/pos_edit_void.php?uid='.$uid.'&trans='.$trans;
								?>
								<div class="panel-body progress-panel">
									<div class="task-progress" >
											<h1>NOMOR TRANSAKSI : </h1>
											<a id='tra'style='font-size:30px;'><?echo 'ES'.$kassier_aantal.'-'.substr($transaction_code,4)?>&nbsp;</a><a href="javascript:confirmVoidAll('<?php echo $void?>')" id='void' onclick="myFunction()" class="deletev fa fa-times-circle fa-2x" style='font-size:30px; width:20px; color:#FF0000;'>VOID</a>
									</div>
									<div style='float:right;margin-left:-20px;width:250px;'>
									Total<p id='price' style='font-size:50px; width:200px;'><?php echo number_format($price)?></p>
									</div>
									<div style='float:right;padding:0 20px;width:120px;'>
									Quantity<p style='font-size:20px;' id='totqty' ><?php echo $qty?></p>
									</div>
									<div style='float:right;padding:0 20px;width:120px;'>
									Normal <p style='font-size:20px;' id='gross'><?php echo number_format($gross)?></p>
									</div>

									<div style='float:right;padding:0 20px;width:120px;'>
									Discount<p style='font-size:20px;' id='disc'>-<?php echo number_format($dic)?></p>
									</div>

									<div style='float:right;padding:0 20px;width:120px;'>
									Cashier<p style='font-size:20px;' id='cs'><?php echo $s_name[0]?></p>
									</div>

								</div>
								<?php
									$query1 = "SELECT temp FROM pos_detail_backup where transcode = '$trans' AND temp NOT IN (SELECT temp FROM pos_detail_backup where transcode = '$trans' AND temp ='9' OR temp = 'VA')";
									$fetch1 = mysql_query($query1);
									$count_qty1 = mysql_result($fetch1,0,0);

									if($count_qty1 == 'V'){
										echo '<a href="pos_pay_reprint.php?reprint='.$trans.'&voids=leemte" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;">PRINT<a>';
										/*
										echo '<a href="'.$home.'/pos_master.php?trans=list" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>';*/
									}else{
										echo '<a href="'.$home.'/pos_master.php?trans=list" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>';									/*
										echo '<a href="pos_pay_reprint.php?reprint='.$trans.'&voids=leemte" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;">PRINT<a>';*/
									}
								?>
								<?php
								$query_ps = "SELECT count(uid) FROM pos_detail_backup where temp = '9' AND transcode='$trans'";
								$result_ps = mysql_query($query_ps);
								if (!$result_ps) {   error("QUERY_ERROR");   exit; }
								$total =  @mysql_result($result_ps,0,0);

								$query_pos = "SELECT dump,status FROM pos_total2 where  status = 'P' AND transcode='$trans'";
								$result_pos = mysql_query($query_pos);
								if (!$result_pos) {   error("QUERY_ERROR");   exit; }

								$dump = @mysql_result($result_pos,0,0);
								$status = @mysql_result($result_pos,0,1);
								$cdetail = explode('|',$dump);
								$arrDetail = count($cdetail);
								$k = 3;
								$jmlCode = $arrDetail/$k;

								echo "
									<form action='pos_cart_void.php' method='POST' name='instv' >
									<table class='table table1'  id='delTable' >
									<thead class='thead'>
									<tr>
									<th>No</th>
									<th>CODE</th>
									<th>Barcode</th>
									<th>Description</th>
									<th>After Price</th>
									<th>QTY</th>
									<th>VOID</th>
									</tr>
									</thead>
									<tbody>
									";

									for ($i=0; $i<$jmlCode; $i++)
									{
										$id = $i + 1;
										$query_pse = "SELECT uid,qty FROM pos_detail_backup where temp = '9' AND transcode='$trans'";
										$result_pse = mysql_query($query_pse);
										if (!$result_pse) {   error("QUERY_ERROR");   exit; }
										$pid = @mysql_result($result_pse,$i,0);
										$qtyd = @mysql_result($result_pse,$i,1);

										echo '<tr id='.$id.'>';
										for ($j=0; $j<$k; $j++)
										{
											$s = $j+($i*$k);
											$query = "SELECT pname,org_barcode,csp_after_price FROM item_masters WHERE org_pcode = '$cdetail[$s]'";
											$result = mysql_query($query);
											if (!$result) {   error("QUERY_ERROR");   exit; }
											$pname 		=  @mysql_result($result,0,0);
											$barcode	=  @mysql_result($result,0,1);
											$price 		=  @mysql_result($result,0,2);
											if($j == 0){
												echo '<td id='.$pid.'><p></p>'.$id.'</td>';
												echo '<input type="hidden" id="pid'.$id.'" value='.$pid.'>';
												echo '<td>'.$cdetail[$s].'</td>';
												echo '<td>'.$barcode.'</td>';
												echo '<td>'.substr($pname,0,30).'</td>';
												echo "<input type='hidden' style='width:50px' name='code[".$id."]' id='code' class='form-control' value='".$cdetail[$s]."'>";
											}else if ($j== 1){
												$quantiy = $cdetail[$s];
												echo "<td> <input type='text' style='width:50px' name='qty[".$id."]' id='qty' class='form-control' value='".$cdetail[$s]."'></td>";
											}
												$prices = $qtyd*$price;
												echo "<td align='left'>".number_format($prices)."</td>";
										}
										if($jmlCode == 1){
											echo "<td><a class='fa fa-times-circle fa-2x' style='color:#EEE;'></a></td>";
										}else{
											echo "<td><a class='delete fa fa-times-circle fa-2x' style='color:#FF0000;'></a></td>";
										}
											echo '</tr>';

									}
									echo "<input type='hidden' style='width:50px' name='id' id='id' class='form-control' value='".$jmlCode."'>";
								?>
								<?php $link = $home.'/pos_edit_void.php?trans='.$trans.'&uid=';?>
								<a id='link' href="<?php echo $link?>" style="color:#FF0000;"></a>
								<?php
									echo "<input type='hidden' style='width:50px' name='reprint' id='code' class='form-control' value='".$trans."'>";
									echo "<input type='hidden' style='width:50px' name='voids' id='code' class='form-control' value='leemte'>";
									echo "
										<tbody>
										</table>
										<form>
									";
								for ($i=0; $i < $total; $i++) {

								} 
							?>

						</div>
					</div>
				</section>
			</section>
		</section>
	</body>
</html>
<?php
}
?>