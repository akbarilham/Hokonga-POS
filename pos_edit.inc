
<script type="text/javascript">

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
								var data = '?id=' + id +'&val='+value ;
								
								

		           				var totval = parseFloat(value);
		           				var bindval = parseFloat(bind);
								if(totval < bindval){
									window.open($('#link').attr("href")+value,"popupWindow","width=400,height=400");
								}else{

								$.ajax(
								{
									   type: "GET",
									   url: "pos_edit_row.php"+data,
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
								
				            	}
				            	showCell();
							    showTotal();
							    getClear();
				             }
		         	}
		        });
		      });

		$(document).ready(function()
		{
			$('table#delTable td a.delete').click(function()
			{
				if (confirm("Are you sure you want to delete this row?"))
				{

					var id = $(this).parent().parent().attr('id');
					
					var data = 'id=' + id ;
					var parent = $(this).parent().parent();

					$.ajax(
					{
						   type: "GET",
						   url: "pos_edit.php",
						   data: data,
						   cache: false,
						
						   success: function()
						   {

								parent.fadeOut('slow', function() {$(this).remove();});
						   }
					 });
							
				}
			});
			
			// style the table with alternate colors
			// sets specified color for every odd row
			$('table#delTable tr:odd').css('background',' #FFFFFF');
		});
		



	</script>

<table class="table table1"  id="delTable" >

<?php

/*if(!$trans){
	$check = "temp = 0 AND sales_code = '$login_id' AND hostname = '$hostname'";
}else{
	$check = "temp = 9 AND sales_code = '$login_id' AND hostname = '$hostname' AND transaction_code ='$trans'";
}*/

if(!$trans){
	$check = "temp = 0 AND sales_code = '$login_id' AND hostname = '$hostname'";
}else{
	$check = "temp = 9 AND transaction_code ='$trans'";
}


$query_ps = "SELECT count(uid) FROM pos_detail where $check";
$result_ps = mysql_query($query_ps);
$total =  @mysql_result($result_ps,0,0);

$query_pos = "SELECT org_pcode,transcode,price,qty,nett,gross,vat,disc_rate,barcode,uid,temp FROM pos_detail where $check order by date asc";
$result_pos = mysql_query($query_pos);
if (!$result_pos) {   error("QUERY_ERROR");   exit; }

for ($i=0; $i < $total; $i++) { 
$pcode =  @mysql_result($result_pos,$i,0);
$transcode1 =  @mysql_result($result_pos,$i,1);
$price =  @mysql_result($result_pos,$i,2);
$qty =  @mysql_result($result_pos,$i,3);
$nett =  @mysql_result($result_pos,$i,4);
$gross =  @mysql_result($result_pos,$i,5);
$vat =  @mysql_result($result_pos,$i,6);
$disc =  @mysql_result($result_pos,$i,7);
$barcode =  @mysql_result($result_pos,$i,8);
$uid =  @mysql_result($result_pos,$i,9);
$status =  @mysql_result($result_pos,$i,10);

$query = "SELECT pname FROM shop_product_list WHERE org_pcode = '$pcode'";
$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }
$pname =  @mysql_result($result,0,0);

/*if(!$trans){
	$lostmode = substr($hostname, 0,2)."/".substr($login_id,0,3);
}else{
	$lostmode = ";".substr($hostname,0,2)."/".substr($login_id,0,3);
}
$a = explode('%', $security);*/

?>
<tr id='<?=$uid?>'>
<td style="width:120px"><?=$barcode?></td>
<td style="width:90px"><?=$pcode?></td>
<td style="width:250px"><?php
                    if(strlen($pname) > 30){
                      echo substr($pname,0,30).'...';  
                    }else{
                      echo $pname;
                    }
                    ?>
                  </td>
<td style="width:80px"><?=number_format($price);?></td>
<td style="width:40px">

<?if($status == 8){?>
 	<input type='hidden' name='<?=$uid?>b' id='<?=$uid?>b' value='<?=$qty?>'style='width:50px'>
	<input readonly type='text' name='<?=$uid?>i' id='<?=$uid?>i' value='<?=$qty?>'style='width:50px'>
<?}else{?>  
	<input type='hidden' name='<?=$uid?>b' id='<?=$uid?>b' value='<?=$qty?>'style='width:50px'>
	<input type='text' name='<?=$uid?>i' id='<?=$uid?>i' value='<?=$qty?>'style='width:50px' class='submit_on_enter_edit'>
<?}?>
</td>

	
	<?
		$link = $home.'/pos_security.php?uid='.$uid.'&val=';
	?>

	<a id='link' href="<?=$link?>" style="color:#FF0000;"></a>
</td>
<td style="width:90px">
	<span name='<?=$uid?>j' id='<?=$uid?>j' ><?=number_format($gross)?></span>
</td>
<td style="width:30px"><?=$disc?>%</td>
<td style="width:90px">
	<span name='<?=$uid?>k' id='<?=$uid?>k' ><?=number_format($nett)?></span>
</td>
<td style="width:10px">
<?if($status == 8){?>
  <a>VOID<a>
<?}else{?>  
<a href="#" class="delete fa fa-times-circle fa-2x" style="color:#FF0000;"></a>
<?}?>
</td>

	

</tr>
<?}?>
</table>

