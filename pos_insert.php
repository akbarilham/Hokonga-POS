<?php
/*
author : Yogi Anditia
date : 18 April 2016
*/

include "config/common.inc";
if (!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
    
    include "config/dbconn.inc";
    
    //parameter
    $index = mysqli_real_escape_string($dbconn, $_REQUEST["index"]);
    $val   = mysqli_real_escape_string($dbconn, $_REQUEST["val"]); //Hasil dari Barcode Reader
    $qtys  = mysqli_real_escape_string($dbconn, $_REQUEST["qtys"]);
    $uid   = mysqli_real_escape_string($dbconn, $_REQUEST["uid"]);
    
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $ip       = '';
    $time     = date('His');
    $date     = date('Ymd');
    $timedate = $date . '' . $time;
    $trx      = 'AS-' . $date;
    
    if ($val == '') {
        $check = "uid = '$uid'";
    } else {
		$query_ch  	= "SELECT org_pcode FROM item_masters WHERE org_pcode = '$val'";
        $result_ch 	= mysql_query($query_ch);
		$pco      	= @mysql_result($result_ch, 0, 0);
        if ($pco != '') {
            $check = "org_pcode = '$val'";
        } else {
            $query_c  = "SELECT count(org_barcode) FROM item_masters WHERE org_barcode = '$val'";
            $result_c = mysql_query($query_c);
            if (!$result_c) {
                error("QUERY_ERROR");
                exit;
            }
            $break = @mysql_result($result_c, 0, 0);
            if ($break < 2) {
                $check = "org_barcode = '$val' OR uid = '$uid'";
					if (strlen($val) > 9){
						$bind = substr($val,0,3);
					}
            } else {
                $check = "org_barcode = '$val' OR uid = '$uid'";
					if (strlen($val) > 9){
						$bind = substr($val,0,3);
					}
            }
        }
    }
    
	 $user = "sales_code = '$login_id' AND hostname = '$hostname'";
	
	$query_getclient = "SELECT id_number from pos_client where  $user";
	$result_getclient = mysql_query($query_getclient);
	$id_number   = @mysql_result($result_getclient, 0, 0);
    
    if ($val == 'o') {
        $list = md5($date);
        echo ("
    <div id='viewResult<?php echo $index?>''>
    </div>
    <meta http-equiv='Refresh' content='2; URL=$home'>");
    } else if ($val == 'm') {
        $list = md5($date);
        echo ("
    <div id='viewResult<?php echo $index?>''>
    </div>
    <meta http-equiv='Refresh' content='2; URL=$home/pos_admin.php'>");
    } else {
        
        if ($qtys == '') {
            $qty = 1;
        } else {
            $qty = $qtys;
        }

        
        //cek daftar produk yang di input
        $query  = "SELECT pname,price_sale,org_pcode,dc_rate,org_barcode,stok_awal,stok_gudang,stok,dc_rate_WH,uid FROM item_masters WHERE $check";
        $result = mysql_query($query);
        if (!$result) {
            error("QUERY_ERROR");
            exit;
        }
        $pname      = @mysql_result($result, 0, 0);
        $price_sale = @mysql_result($result, 0, 1);
        $code       = @mysql_result($result, 0, 2);
        $dc_r    	= @mysql_result($result, 0, 3);
        $barcode    = @mysql_result($result, 0, 4);
		$s_awal     = @mysql_result($result, 0, 5);
		$s_gudang   = @mysql_result($result, 0, 6);
		$stok       = @mysql_result($result, 0, 7);
		$dc_rate_WH = @mysql_result($result, 0, 8);
		$uid = @mysql_result($result, 0, 9);
        
        //hitung jumlah yang ada di tabel pos_detail
        $query_pis  = "SELECT count(uid) FROM pos_detail2 WHERE pos_clientID = '$id_number'";
        $result_pis = mysql_query($query_pis);
        if (!$result_pis) {
            error("QUERY_ERROR");
            exit;
        }
        $con = @mysql_result($result_pis, 0, 0);
        
        if (!$con) {
            $tempq = '';
        } else {
            $tempq = "AND temp = '0'";
        }
        
		//Ganti diskon jika alokasi item habis
		if($s_awal == 0){
			$dc_rate = $dc_rate_WH;
		}else{
			$dc_rate = $dc_r;
		}
		
        //pilih berdasarkan user/sales yang digunakan
        $query_pos  = "SELECT transcode,temp FROM pos_detail2 where pos_clientID = '$id_number' AND temp = '0'";
        $result_pos = mysql_query($query_pos);
        if (!$result_pos) {
            error("QUERY_ERROR");
            exit;
        }
       
        $transcode1 = @mysql_result($result_pos, 0, 0);
        $temp1       = @mysql_result($result_pos, 0, 1);
        
		$query_disten  = "SELECT org_pcode,package FROM item_masters_package where org_pcode = '$code'";
        $result_disten = mysql_query($query_disten);
        if (!$result_disten) {
            error("QUERY_ERROR");
            exit;
        }
		$codep	 		= @mysql_result($result_disten, 0, 0);
        $package       	= @mysql_result($result_disten, 0, 1);
        
		
		
        $rate    = $dc_rate / 100;
        $gross   = $qty * $price_sale;
        $dis     = $gross * $rate;
        $nett    = $gross - $dis;
        $vat     = $nett / 11;
        $nettvat = $vat * 10;
        
		
		/*if ($code!=''){
        
        }
        */ //JIKA QUANTITY ADA
        //$minqty = $qtystock - 1;
        //mysql_query("UPDATE item_masters SET qty = '$minqty' ");
        if (!$code ) {
?>
        <!-- Menampilkan result -->
        
		
		<?php if($val != $pco){?>
			<div id="viewResult<?php echo  $index ?>">
				<p style='background:red; width:100%; padding: 7px;color:#FFF;'>Item tidak terdaftar</p>
			</div>
		<?php } else { ?>
			<div id="viewResult<?php echo  $index ?>">
			</div>
		<?php } ?>
     <?php
        }else if($bind == $qty){?>
			 <div id="viewResult<?php echo  $index ?>">
				<p style='background:red; width:100%; padding: 7px;color:#FFF;'>Jumlah Item <?php echo $qtys?> sama dengan 3 [<?php echo substr($val,0,3)?>]<?php echo substr($val,4,15)?> kode awal karakter barcode</p>
			</div>
			
		<?php } else if(!is_numeric($qty)){?>
			<div id="viewResult<?php echo  $index ?>">
				<p style='background:red; width:100%; padding: 7px;color:#FFF;'>Quanitity mengandung Karakter</p>
			</div>
		<?php } else if($s_awal < $qty){?>
			<div id="viewResult<?php echo  $index ?>">
				<p style='background:red; width:100%; padding: 7px;color:#FFF;'>Sisa stok hanya <?php echo $s_awal?></p>
			</div>
		<?php }else {
            //jika tidak ada transcode buat transaksi baru
			$detail = $code.'|'.$barcode.'|'.$pname.'|'.$price_sale.'|'.$dc_rate.'|'.$gross.'|'.$nett.'|'.$nettvat.'|'.$vat.'|'.$uid;
            if (!$transcode1) {
                //$query     = "SELECT max(transcode) FROM pos_detail";
                $token     = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, 5);
                $transcode = 'C' . $time . '' . $token;
                $temp      = '0';
				
                mysql_query("INSERT INTO pos_detail2 (uid,pos_clientID,org_pcode,detail,datedetail,transcode,temp,qty,package) 
                VALUES ('','$id_number','$code','$detail','$timedate','$transcode','$temp','$qty','$package')");
                
            } else {
				$query_posw  = "SELECT org_pcode,qty,transcode FROM pos_detail2 where temp ='0' AND org_pcode='$code' AND transcode ='$transcode1' ";
                $result_posw = mysql_query($query_posw);
                if (!$result_posw) {
                    error("QUERY_ERROR");
                    exit;
                }
                $pcode = @mysql_result($result_posw, 0, 0);
                $qty1  = @mysql_result($result_posw, 0, 1);
				 
                //jika produk sudah pernah di input maka diupdate
                
                $addqty   = $qty1 + $qty;
                $gross1   = $addqty * $price_sale;
                $dis      = $gross1 * $rate;
                $nett1    = $gross1 - $dis;
                $vat1     = $nett1 / 11;
                $nettvat1 = $vat1 * 10;
				
				if ($code == $pcode) {
					$detail = $code.'|'.$barcode.'|'.$pname.'|'.$price_sale.'|'.$dc_rate.'|'.$gross1.'|'.$nett1.'|'.$nettvat1.'|'.$vat1.'|'.$uid;
					 mysql_query("UPDATE pos_detail2 SET qty = '$addqty', detail = '$detail' WHERE temp = '0' AND org_pcode = '$pcode' AND transcode = '$transcode1'");
                    
				}else{
					mysql_query("INSERT INTO pos_detail2 (uid,pos_clientID,org_pcode,detail,datedetail,transcode,temp,qty,package) 
					VALUES ('','$id_number','$code','$detail','$timedate','$transcode1','$temp1','$qty','$package')");
				}
			}
            
            if ($qtys < 0 || $bind == $qtys) {
        ?>
          <div id="viewResult<?php echo  $index ?>">
		  
          </div>
<?php
    } else {                
?>


       <div id="viewResult<?php echo  $index ?>">
	   
	   <?php if($package != ''){
			echo "<p style='background:green; width:100%; padding: 7px;color:#FFF;'>Item ".$codep." Termasuk Paket ".$package." code ".$code."</p>";
			
		}else{
			
		}?>
	  
      </div>

      <!-- Menampilkan result 
       <table class="table table1" id='newTable'>
       <tr id='<?php echo  $con + 1 ?>'>
       
        <td style="width:90px"><?php echo  $code ?></td>
         <td style="width:120px"><?php echo  $barcode ?></td>
        <td style="width:250px"><?php
                if (strlen($pname) > 30) {
                    echo substr($pname, 0, 30) . '...';
                } else {
                    echo $pname;
                }
?>
                          </td>
        <td style="width:80px;text-align:right;"><?php echo  number_format($price_sale); ?></td>
        <td style="width:40px">
          <input type='text' name='<?php echo  $con + 1 ?>i' id='<?php echo  $con + 1 ?>i' value='<?php echo  $qty ?>'style='width:50px;' onkeyup='test()' class='submit_on_enter_edit_s hover'>
        </td>
        <td style="width:90px;text-align:right;">
          <span name='<?php echo  $con + 1 ?>j' id='<?php echo  $con + 1 ?>j' ><?php echo  number_format($gross) ?></span>
        </td>
        <td style="width:30px;text-align:right;"><?php echo  $dc_rate ?>%</td>
        <td style="width:90px;text-align:right;">
          <span name='<?php echo  $con + 1 ?>k' id='<?php echo  $con + 1 ?>k' ><?php echo  number_format($nett) ?></span>
        </td>
        <td style="width:10px"><a href="#" class="delete fa fa-times-circle fa-2x" style="color:#FF0000;"></a></td>
      </tr>
      </table>

     -->
    <?php
            }
        }
    }
}
?>