<?
include "config/common.inc";
include "config/dbconn.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>
<script type="text/javascript">


			$(document).ready(function() {
		        $('.submit_on_enter_addmincart').keydown(function(event) {
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
								var minus = id+'&val='+value;
		           				var totval = parseFloat(value);
		           				var bindval = parseFloat(bind);

								if(totval < bindval){
									window.open($('#link').attr("href")+minus,"popupWindow","width=300,height=300",'fullscreen=yes,resizable=no');
									window.close();
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
								$("#test").load("<?=$home?>/pos_cart.php");

				             }
		         	}
		        });
		      });

		$(document).ready(function()
		{
			$('table#delTable td a.delete').click(function()
			{

					if (answer=confirm("Are you sure you want to delete this item?"))
					{
						if (answer==true) {
						var id = $(this).parent().parent().attr('id');
						var del = id+'&del=1';
					      	window.open($('#link').attr("href")+del,"popupWindow","width=300,height=300",'fullscreen=yes,resizable=no');
							window.close();
					     }

						/*var id = $(this).parent().parent().attr('id');

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
									 showCell();
								    showTotal();
								    getClear();

							   }

						 });
						$("#test").load("http://localhost/feelbuy/pos_edit1.php");	*/
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
	$check = "temp = '0' AND sales_code = '$login_id' AND hostname = '$hostname'";
}else{
	$check = "temp = 9 AND sales_code = '$login_id' AND hostname = '$hostname' AND transaction_code ='$trans'";
}*/

/* if(!$trans){
	$check = "temp = '0' AND sales_code = '$login_id' AND hostname = '$hostname'";
}else{
	$check = "temp = 9 AND transaction_code ='$trans'";
} */

if($hold!=''){
          $temp = "temp = '1' and transcode = '$hold'";
        }else{
           $temp = "temp = '0'";
        }

$query_getcl = "SELECT id_number from pos_client where sales_code = '$login_id' AND hostname = '$hostname'";
$result_getcl = mysql_query($query_getcl);
$id_number   = @mysql_result($result_getcl, 0, 0);

$query_ps = "SELECT count(uid) FROM pos_detail2 where $temp AND pos_clientID = '$id_number'";
$result_ps = mysql_query($query_ps);
 if (!$result_ps) {   error("QUERY_ERROR");   exit; }
$total =  @mysql_result($result_ps,0,0);

$query_pos = "SELECT uid,pos_clientID,detail,datedetail,transcode,temp,qty,package,org_pcode FROM pos_detail2 where $temp AND pos_clientID = '$id_number' order by uid desc";
$result_pos = mysql_query($query_pos);
 if (!$result_pos) {   error("QUERY_ERROR");   exit; }

for ($i=0; $i < $total; $i++) {
$ki = $i + 1;
$uid 			=  @mysql_result($result_pos,$i,0);
$pos_clientID 	=  @mysql_result($result_pos,$i,1);
$detail 		=  @mysql_result($result_pos,$i,2);
$datedetail 	=  @mysql_result($result_pos,$i,3);
$transcode 		=  @mysql_result($result_pos,$i,4);
$temp 			=  @mysql_result($result_pos,$i,5);
$qty 			=  @mysql_result($result_pos,$i,6);
$package		=  @mysql_result($result_pos,$i,7);
$packcode2		=  @mysql_result($result_pos,$i,8);


if($package != ''){
	$pcount="SELECT sum(qty) FROM pos_detail2 where pos_clientID = '$id_number'  group by transcode" ;
	$fetch_pcount=mysql_query($pcount);
	$cuidp=mysql_result($fetch_pcount,0,0);

		if($package == 5){
			$codecount="SELECT qty FROM pos_detail2 where pos_clientID = '$id_number' AND package = '$package' AND  qty = (SELECT MIN(qty) from pos_detail2)";
			$fetch_codecount=mysql_query($codecount);
			$codecp	=mysql_result($fetch_codecount,0,0);
		}

	}

/*if(!$trans){
	$lostmode = substr($hostname, 0,2)."/".substr($login_id,0,3);
}else{
	$lostmode = ";".substr($hostname,0,2)."/".substr($login_id,0,3);
}
$a = explode('%', $security);*/
?>

<tr id='<?=$uid?>'>
<td style="width:40px;text-align:right;"><?=$ki?></td> <!-- nomor -->
<td style="width:40px;text-align:right;"> <!-- qty -->
	<input type='hidden' name='<?=$uid?>b' id='<?=$uid?>b' value='<?=$qty?>'style='width:50px'>

	 <?$paid=md5($hostname);
        if($pay==$paid){
			$disableds = 'disabled';
		}else{
			$disableds = '';
		}?>
		<input <?=$disableds?> type='text' name='<?=$uid?>i' id='<?=$uid?>i' value='<?=$qty?>'style='width:50px;text-align:right;' onclick="myFunction()" class='submit_on_enter_addmincart '>

	</td>


	<?
		$link = $home.'/pos_security.php?uid=';
	?>

	<a id='link' href="<?=$link?>" style="color:#FF0000;"></a>


<?
$discount = $dic/100;
$new_detail = explode('|',$detail);
$arrCount = count($new_detail);
$query_getcatdis = "SELECT cat from item_masters Where org_pcode = '$new_detail[0]'";
$result_getcatdis = mysql_query($query_getcatdis);
$cat   = @mysql_result($result_getcatdis, 0, 0);
$diskon = $dic/100;
for ($j=0; $j < $arrCount ; $j++){

	if($j == 3){
		echo '<td style="width:40px;text-align:right;">'.number_format($new_detail[$j]).'</td>'; //price
	}else if($j == 2){
		echo '<td style="width:300px;text-align:left;">'.substr($new_detail[$j],0,40).'</td>'; // desc
	}else if($j == 4){
/*		if($dic == true){
			if ($cat == 1){
				if($codecp >= 1 ){
					$di= '15%';
				}else{
					$di= '15%';
				}


			}else{
				$di ='-';
			}
		}else{
			$di ='-';
		}*/
		echo '<td style="width:90px">'.$new_detail[$j].'</td>'; // diskon
	}else if($j == 5){
		$net =$new_detail[$j];
		echo '<td style="width:90px;text-align:center;">'.number_format($net).'</td>'; // subtotal
	}else if($j == 6){
		$cnt = $new_detail[$j];
		echo '<td style="width:90px;text-align:center;">'.number_format($cnt).'</td>'; // total
	}else if($j == 7){
		echo '';
	}else if($j == 8){
		echo '';
	}else if($j == 9){
		echo '';
	}else if($j == 0){
		if($package != ''){
			echo '<td style="width:140px;background:green;color:#FFF;">'.$new_detail[$j].'[ Paket '.$package.']'.'</td>';

		}else{
			echo '<td style="width:140px;">'.$new_detail[$j].'</td>'; // item
		}

	}
	else{
		echo '<td style="width:10px;text-align:right">'.$new_detail[$j].'</td>'; //barcode
	}
}

?>

<td style="width:10px">
<a href="#" class="delete fa fa-times-circle fa-2x" style="color:#FF0000;"></a>
</td>


</tr>
<?}?>
</table>
<?}?>
