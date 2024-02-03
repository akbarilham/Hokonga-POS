<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>

	<title><?=$web_erp_name?></title>
    
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
	
    <link href="css/invoice/style2.css" rel="stylesheet">
	<link href="css/invoice/style-responsive.css" rel="stylesheet">
	
   
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<style rel="stylesheet">
		.strikeout {
		  font-size: 1.5em;
		  line-height: 1em;
		  position: relative;
		  
		}
		
		.strikeout::after {
		  border-bottom: 0.125em solid red;
		  content: "";
		  left: 0;
		  margin-top: calc(0.125em / 2 * -1);
		  position: absolute;
		  right: 0;
		  top: 50%;
		  transform: rotate(-8deg);
		}
		.harga {
		  font-size: 4em;
		  line-height: 1em;
		  text-align:middle;
		}
		
		.img{
			widtd:90px;
			height:90px;
		}
		.harga{
			color: red;
   
    -webkit-print-color-adjust: exact;
		}
		.harga::after{
			color: red;
		}
		
		 @media print {
      p {
        color: rgba(0, 0, 0, 0);
        text-shadow: 0 0 0 #fff;
      }

      @media print and (-webkit-min-device-pixel-ratio:0) {
        p {
          color: #fff;
          -webkit-print-color-adjust: exact;
        }
      }
   }
	</style>
  </head>



<body class="print-body">

<section>
<?
	$query_pis  = "SELECT count(uid) FROM boomsale WHERE sales_code = '$user' ";
        $result_pis = mysql_query($query_pis);
        if (!$result_pis) {
            error("QUERY_ERROR");
            exit;
        }
        $con = @mysql_result($result_pis, 0, 0);

	$query_a = "SELECT max(disc_rate) FROM boomsale where sales_code = '$user' ";
	$result_s = mysql_query($query_a);
	$max =  @mysql_result($result_s,0,0);
	
	$query = "SELECT uid,org_pcode,nett,gross,disc_rate FROM boomsale where sales_code = '$user' ";
	$result_ms = mysql_query($query);

?>
<!--body wrapper start-->
	</br>
	</br>
	</br>
    <div class="wrapper" style='margin-top:-5px;'>
		<?php $va = $_GET['va']; ?>
		<p style=' position: absolute; z-index: 2;top:55px;color:#000;'> 
			<?php echo $va;?>
		</p>
        <div class="panel">
            <!--<img style='widtd:250px;height:30px;' src='img_pos/header1.png'></img>-->

						<?php 
						if($max == 0){?>
							<p style='font-size: 2.3em; position: absolute;right: 68px;top: 130px;z-index: 2;font-family:impact;color:#FFF;' >
							SPECIAL
							</p>
							<p style='font-size: 2.3em; position: absolute;right: 85px;top: 158px;z-index: 2;font-family:impact;color:#FFF;' >
								PRICE
							</p>
						<?}else{?>
							<p style='font-size: 7em; position: absolute;right: 68px;top: 135px;z-index: 2;font-family:impact;color:#FFF;' >
								<?echo $max;?>
							</p>
						<?}?>
			
            <img style='width:100%; height:150px;' src='img_pos/HeaderDisc2.png'></img>
			
			 <table class="table table-bordered table-invoice" style='margin-top:10px;padding:0px;'>
				 <thead>
				<td style='text-align:center;color:black;' >Foto Produk</td>
				<td style='text-align:center;color:black;' >Harga Normal</td>
				<td style='text-align:center;color:red;' >Harga Diskon</td>
			 </thead>
               <tbody>
				<?
				for($i = 0; $i < 5; $i++) {
				$uid =  @mysql_result($result_ms,$i,0);
				$pcode =  @mysql_result($result_ms,$i,1);
				$nett =  @mysql_result($result_ms,$i,2);
				$gross =  @mysql_result($result_ms,$i,3);
				
				?>
                <tr id='<?=$uid?>'>
				<td>
				<?
					$file = 'img_pos/'.$pcode.'.jpg'; // 'images/'.$file (physical patd)

					if (file_exists($file)) {
						echo ("<img class='img' style='width:115px;height:115px;' src='img_pos/".$pcode.".jpg'/>");
					} else {
						echo ("<img style='width:115px;height:115px;' />");
					}
				?>
				</td>
				<td >
				<?if($gross == 0){}else{?>
				<h4 style='margin-bottom:-14px;'><?=substr($pcode,0,13)?></h4></br>
					<?if($max == 0){?>
						<h4>SPECIAL PRICE</h4>
					<?}else{?>
						<h4>Rp <span class="strikeout"><?=number_format($gross);?></span></h4>
					<?}?>
				<?}?>
				</td>
				<td style='text-align:right'>
				<?if($nett == 0){}else{?>
				<span class='harga' style='float:left'>Rp</span><span class='harga'><?=number_format($nett)?></span>
				<?}?>
				</td> 



</tr>
				<?}?>

                <tbody>
            </table>
				
			 <img style='margin-top:10px;width:100%' src='img_pos/footer2.png'></img>
        </div>
    </div>
    <!--body wrapper end

</section>

<!-- Placed js at tde end of tde document so tde pages load faster -->
<script src="js/invoice/jquery-1.10.2.min.js"></script>
<script src="js/invoice/jquery-migrate-1.2.1.min.js"></script>
<script src="js/invoice/bootstrap.min.js"></script>
<script src="js/invoice/modernizr.min.js"></script>


<!--common scripts for all pages-->
<script src="js/invoice/scripts.js"></script>
<script type="text/javascript">
    window.print();
</script>
<? echo ("<meta http-equiv='Refresh' content='0; URL=$home/boomsale_add.php'>");	
	 $sql_query="DELETE FROM boomsale WHERE  sales_code='$user'" ; 
     mysql_query($sql_query);  
?>
</body>
</html>


<? } ?>