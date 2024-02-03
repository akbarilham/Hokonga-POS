<?php
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
    
			
			$company		= $_POST['company'];
			$shop			= $_POST['shop'];
			$desc			= $_POST['desc'];
			$item_name		= $_POST['item_name'];
			$description	= $_POST['description'];
			$qty			= $_POST['qty'];
			$unit			= $_POST['unit'];
			$remark			= $_POST['remark'];
			$stat			= $_POST['stat'];
			$tgl			= implode('-',(explode('/',$_POST['date'])));;
			$bind			= $_POST['bind'];
			$del_date		= $_POST['so_date'];
			$wdcode			= $_POST['wmcode'];
			$po_no			= $_POST['so'];
			
			$date 			= date('Ymd');
			$year 			= substr(date('Y'),2,3);
			$month 			= date('m');
			$arrCount		= count($item_name);
			for($v=1;$v<=$arrCount;$v++){
				$item_names 	= $item_name[$v];
				$descriptions 	= $description[$v];
				$qtys 			= $qty[$v];
				$units 			= $unit[$v];
				$remarks 		= $remark[$v];
				$item[] 		= $item_names.'|'.$descriptions.'|'.$qtys.'|'.$units.'|'.$remarks;
				$arrQtys[]		= $qty[$v];			
			}
			$jmlQty		= array_sum($arrQtys);
			$toAmount	= array_sum($arrAmount);
			$new 	= implode('|',$item);
			$token     = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, 5);
			$wmdcode = 'WMDO'.$date.''.$token;
			
			$delivery_order	= $company.'|'.$shop.'|'.$desc.'|'.$jmlQty;
		
			$query_max 	= "select max(uid) from wms_do";
			$fetch_max	= mysql_query($query_max);
			if (!$fetch_max) { error("QUERY_ERROR"); exit; }			
			$max		= mysql_result($fetch_max,0,0);
			$str		= $max+1;
			$countMax	= strlen($str);
			
			
			$do_max		= 'DO'.$year.''.$month.'-'.sprintf('%05d', $str);
			if($bind == 'bind'){
				
				if(!$wdcode){
					$query_insert	= "INSERT INTO wms_do (uid,so_num,delivery_order,item,status,post_dates,wmcode,del_date,so_num) VALUES ('','$do_max','$delivery_order','$new','$stat','$tgl','$wmdcode','$del_date','$po_no')";
					$fetch_insert	= mysql_query($query_insert);
					if (!$fetch_insert) { error("QUERY_ERROR"); exit; }
				}else{
					$query_update 	= "UPDATE wms_do SET delivery_order = '$delivery_order', item = '$new', status = '$stat',post_dates = '$tgl', del_date = '$del_date',so_num = '$po_no' WHERE wmscode = '$wcode' ";
					$fetch_update	= mysql_query($query_update);
					if (!$fetch_update) { error("QUERY_ERROR"); exit; }
				}
				
				
			
			
			}
    
			 echo("<meta http-equiv='Refresh' content='0; URL=$home/wms_do.php?wmcode=$wmscode'>");
}
?>