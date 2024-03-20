<?
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
    $index = $_REQUEST["index"];
    $val   = $_REQUEST["val"]; //Hasil dari Barcode Reader
    $qtys  = $_REQUEST["qtys"];
    $uid   = $_REQUEST["uid"];
    
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $ip       = '';
    $time     = date('His');
    $date     = date('Ymd');
    $timedate = $date . '' . $time;
    $trx      = 'DS-' . $date;
    
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
    
    if ($val == 'o') {
        $list = md5($date);
        echo ("
    <div id='viewResult<?=$index?>''>
    </div>
    <meta http-equiv='Refresh' content='2; URL=$home'>");
    } else if ($val == 'm') {
        $list = md5($date);
        echo ("
    <div id='viewResult<?=$index?>''>
    </div>
    <meta http-equiv='Refresh' content='2; URL=$home/pos_admin.php'>");
    } else {
        
        if ($qtys == '') {
            $qty = 1;
        } else {
            $qty = $qtys;
        }
        
        $user = "sales_code = '$login_id' AND hostname = '$hostname'";
        
        //cek daftar produk yang di input
        $query  = "SELECT pname,price_sale,org_pcode,dc_rate,org_barcode FROM item_masters WHERE $check";
        $result = mysql_query($query);
        if (!$result) {
            error("QUERY_ERROR");
            exit;
        }
        $pname      = @mysql_result($result, 0, 0);
        $price_sale = @mysql_result($result, 0, 1);
        $code       = @mysql_result($result, 0, 2);
        $dc_rate    = @mysql_result($result, 0, 3);
        $barcode    = @mysql_result($result, 0, 4);
        
        //hitung jumlah yang ada di tabel boomsale
        $query_pis  = "SELECT count(uid) FROM boomsale WHERE $user";
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
        
        //pilih berdasarkan user/sales yang digunakan
        $query_pos  = "SELECT sales_code,transcode,temp,org_pcode,barcode,uid FROM boomsale where $user $tempq  ";
        $result_pos = mysql_query($query_pos);
        if (!$result_pos) {
            error("QUERY_ERROR");
            exit;
        }
        $salesdmc   = @mysql_result($result_pos, 0, 0);
        $transcode1 = @mysql_result($result_pos, 0, 1);
        $temp       = @mysql_result($result_pos, 0, 2);
		$pcode       = @mysql_result($result_pos, 0, 3);
		$barcode       = @mysql_result($result_pos, 0, 4);
		$id	       = @mysql_result($result_pos, 0, 5);
        
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
        if (!$code OR $con == 5 OR $pcode == $val OR $barcode == $val OR $id == $uid) {
?>
        <!-- Menampilkan result -->
        <div id="viewResult<?= $index ?>">
        </div>
     <?
        } else {
            //jika tidak ada transcode buat transaksi baru
            if (!$transcode1) {
                $query     = "SELECT max(transcode) FROM boomsale";
                $token     = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, 5);
                $transcode = 'C-' . $time . '' . $token;
                $temp      = '0';
                
                mysql_query("INSERT INTO boomsale (uid,transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,gross,nett,netvat,vat,sales_code,transcode,temp,qty) 
                VALUES ('','$trx','$code','$barcode',' $timedate','$hostname','$ip','$price_sale','$dc_rate','$gross','$nett','$nettvat','$vat','$login_id','$transcode','$temp','$qty')");
                
            } else {
                $query_posw  = "SELECT org_pcode,qty FROM boomsale where temp = '0' AND sales_code = '$login_id' AND org_pcode = '$code' AND hostname ='$hostname' ";
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
               
               
                    mysql_query("INSERT INTO boomsale (uid,transaction_code,org_pcode,barcode,date,hostname,ip,price,disc_rate,gross,nett,netvat,vat,sales_code,transcode,temp,qty) 
                VALUES ('','$trx','$code','$barcode',' $timedate','$hostname','$ip','$price_sale','$dc_rate','$gross','$nett','$nettvat','$vat','$login_id','$transcode1','$temp','$qty')");
                
            }
            
            
				?>
				<?
				if ($qtys < 0 OR $con == 5 OR $pcode == $val OR $barcode == $val OR $id == $uid) {
				?>
				<div id="viewResult<?= $index ?>">
				</div>
				<?
				} else {



				?>


				<div id="viewResult<?= $index ?>">
				</div>




				<?
            }
        }
    }
}
?>