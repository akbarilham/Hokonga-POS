<?php
/*
@author : YOGI ANDITIA;
@updated : Akbar;
@version : 2.0;

*/
include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

?>
    <!--dynamic table-->
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <!-- CSS POS -->
    <link rel="stylesheet" href="css/pos.css">
 <script language="javascript">
function selectIt() {
  window.opener.location.href = '<?=$home?>/pos.php';
  window.close();

}

</script>
<?
 $security = $_GET['security'];
 $lostmode = 'BS1718';

#$lostmode = substr($hostname, 0,2)."".substr($login_id,0,3);
#$security = $_GET['security'];
$del = $_GET['del'];
$uid = $_GET['uid'];
$void = $_GET['void'];
$cek = $_GET['cek'];

if($security == $lostmode){
    $id = $_GET['id'];
    $qtym = $_GET['val'];

}else{
    $id = $_GET['id'];
    $qtym = $_GET['val'];
}



$query_pos = "SELECT uid,pos_clientID,detail,datedetail,transcode,temp,qty FROM pos_detail2 where uid = '$id'";

    $result_pos = mysql_query($query_pos);
    if (!$result_pos) {   error("QUERY_ERROR");   exit; }

			$uid 			=  @mysql_result($result_pos,0,0);
			$pos_clientID 	=  @mysql_result($result_pos,0,1);
			$detail 		=  @mysql_result($result_pos,0,2);
			$datedetail 	=  @mysql_result($result_pos,0,3);
			$transcode 		=  @mysql_result($result_pos,0,4);
			$temp 			=  @mysql_result($result_pos,0,5);
			$qty 			=  @mysql_result($result_pos,0,6);

			$new_detail1 = explode('|',$detail);
					$arrCount1 = count($new_detail1);
					for ($j=0; $j < $arrCount1 ; $j++){

						if($j == 0){
							$code = $new_detail1[$j];
						}else if($j == 1){
							$barcode = $new_detail1[$j];
						}else if($j == 2){
							$pname = $new_detail1[$j];
						}else if($j == 3){
							$price = $new_detail1[$j];
						}else if($j == 4){
							$disc = $new_detail1[$j];
						}else if($j == 5){
							$newgross = $new_detail1[$j];
						}else if($j == 6){
							$nett = $new_detail1[$j];
						}else if($j == 7){
							$nettvat = $new_detail1[$j];
						}else if($j == 8){
							$vat = $new_detail1[$j];
						}else{

						}

			}


    $newgross = $qtym*$price;
    $newdis = $newgross*($disc/100);
    $newnett = $newgross-$newdis;
    $newvat = $newnett/11;
    $newnettvat = $newvat*10;


		if($uid == $id){
			if($security == $lostmode AND $cek == 'cek'){
				 if($del == 1){
					 //update data for delete item
					$sql_query_s="Delete from pos_detail2 WHERE uid='$id'";
					$result_pos_s = mysql_query($sql_query_s);
					if (!$result_pos_s) {   error("QUERY_ERROR");exit; }
				 }else{
					// update item pengurangan
					$detail2 = $code.'|'.$barcode.'|'.$pname.'|'.$price.'|'.$disc.'|'.$newgross.'|'.$newnett.'|'.$newnettvat.'|'.$newvat;
					$sql_query="UPDATE pos_detail2 SET qty = '$qtym', detail = '$detail2' WHERE uid='$id'";
					$result_poss = mysql_query($sql_query);
					if (!$result_poss) {   error("QUERY_ERROR");exit; }

				 }
			}else if($id != '' AND $qtym != ''){

				$detail2 = $code.'|'.$barcode.'|'.$pname.'|'.$price.'|'.$disc.'|'.$newgross.'|'.$newnett.'|'.$newnettvat.'|'.$newvat;
					$sql_query="UPDATE pos_detail2 SET qty = '$qtym', detail = '$detail2' WHERE uid='$id'";
				$result_poss2 = mysql_query($sql_query);

				 if (!$result_poss2) {   error("QUERY_ERROR");exit; }

				$data[] = array('qty' => $qtym,'gross' => number_format($newgross), 'nett' => number_format($newnett));

				json_encode($data);
			}else{
				echo("<meta http-equiv='Refresh' content='0; URL=$home/pos_security.php?val=$val&id=$uid&uid=$uid&fail=faild'>");
			}
			echo '<input type="button" autofocus class="btn btn-primary" style="margin:20px; color:#fff;height:40px;width:80%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" value="Done" onclick="selectIt()">';
		}


}
?>
